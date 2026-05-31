<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use App\Services\FileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function __construct(private readonly FileService $fileService)
    {
    }

    public function index(): View
    {
        $settings = AppSetting::cached();

        return view('settings.index', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'app_name' => ['nullable', 'string', 'max:150'],
            'app_description' => ['nullable', 'string', 'max:500'],
            'institution_address' => ['nullable', 'string', 'max:1000'],
            'phone_number' => ['nullable', 'string', 'max:50'],
            'official_email' => ['nullable', 'email', 'max:150'],
            'official_website' => ['nullable', 'url', 'max:200'],
            'footer_copyright' => ['nullable', 'string', 'max:255'],
            'app_logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'favicon' => ['nullable', 'file', 'mimes:ico,png,jpg,jpeg,svg,webp', 'max:1024'],
        ]);

        $textFields = [
            'app_name',
            'app_description',
            'institution_address',
            'phone_number',
            'official_email',
            'official_website',
            'footer_copyright',
        ];

        foreach ($textFields as $field) {
            AppSetting::setValue($field, $validated[$field] ?? null);
        }

        if ($request->hasFile('app_logo')) {
            $oldLogo = AppSetting::getValue('app_logo');

            if ($oldLogo) {
                $this->fileService->delete($oldLogo, 'public');
            }

            AppSetting::setValue('app_logo', $this->fileService->upload($request->file('app_logo'), 'settings', 'public'));
        }

        if ($request->hasFile('favicon')) {
            $oldFavicon = AppSetting::getValue('favicon');

            if ($oldFavicon) {
                $this->fileService->delete($oldFavicon, 'public');
            }

            AppSetting::setValue('favicon', $this->fileService->upload($request->file('favicon'), 'settings', 'public'));
        }

        return back()->with('success', 'Pengaturan umum berhasil diperbarui!');
    }
}
