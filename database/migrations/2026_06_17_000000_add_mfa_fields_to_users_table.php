<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('mfa_enabled')->default(false)->after('status');
            $table->string('mfa_code_hash')->nullable()->after('mfa_enabled');
            $table->timestamp('mfa_expires_at')->nullable()->after('mfa_code_hash');
            $table->timestamp('mfa_confirmed_at')->nullable()->after('mfa_expires_at');
            $table->json('mfa_recovery_codes')->nullable()->after('mfa_confirmed_at');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'mfa_enabled',
                'mfa_code_hash',
                'mfa_expires_at',
                'mfa_confirmed_at',
                'mfa_recovery_codes',
            ]);
        });
    }
};
