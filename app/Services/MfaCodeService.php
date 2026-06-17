<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\MfaCodeNotification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MfaCodeService
{
    public function send(User $user): string
    {
        $code = (string) random_int(100000, 999999);

        $user->forceFill([
            'mfa_code_hash' => Hash::make($code),
            'mfa_expires_at' => now()->addMinutes(10),
        ])->save();

        $user->notify(new MfaCodeNotification($code));

        return $code;
    }

    public function verify(User $user, string $code): bool
    {
        if (! $user->mfa_code_hash || ! $user->mfa_expires_at || now()->greaterThan($user->mfa_expires_at)) {
            return false;
        }

        return Hash::check(Str::of($code)->trim()->toString(), $user->mfa_code_hash);
    }

    public function clear(User $user): void
    {
        $user->forceFill([
            'mfa_code_hash' => null,
            'mfa_expires_at' => null,
            'mfa_confirmed_at' => now(),
        ])->save();
    }

    public function generateRecoveryCodes(User $user, int $count = 8): array
    {
        $codes = collect(range(1, $count))
            ->map(fn () => Str::upper(Str::random(5).'-'.Str::random(5)))
            ->values()
            ->all();

        $user->forceFill([
            'mfa_recovery_codes' => collect($codes)
                ->map(fn (string $code) => Hash::make($this->normalizeRecoveryCode($code)))
                ->all(),
        ])->save();

        return $codes;
    }

    public function verifyRecoveryCode(User $user, string $code): bool
    {
        $normalizedCode = $this->normalizeRecoveryCode($code);
        $hashes = collect($user->mfa_recovery_codes ?? []);
        $matchedHash = $hashes->first(fn (string $hash) => Hash::check($normalizedCode, $hash));

        if (! $matchedHash) {
            return false;
        }

        $user->forceFill([
            'mfa_recovery_codes' => $hashes
                ->reject(fn (string $hash) => hash_equals($hash, $matchedHash))
                ->values()
                ->all(),
        ])->save();

        return true;
    }

    public function remainingRecoveryCodes(User $user): int
    {
        return Collection::make($user->mfa_recovery_codes ?? [])->count();
    }

    private function normalizeRecoveryCode(string $code): string
    {
        return Str::of($code)
            ->upper()
            ->replace(' ', '')
            ->trim()
            ->toString();
    }
}
