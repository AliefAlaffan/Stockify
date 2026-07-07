<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit()
    {
        $settings = [
            'app_name' => Setting::get('app_name', config('app.name', 'Stockify')),
            'app_logo' => Setting::get('app_logo'),
        ];

        return view('settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'app_name' => ['required', 'string', 'max:100'],
            'app_logo' => ['nullable', 'image', 'max:1024'], // max 1MB
        ]);

        Setting::set('app_name', $validated['app_name']);

        if ($request->hasFile('app_logo')) {
            // Hapus logo lama kalau ada
            $oldLogo = Setting::get('app_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            $path = $request->file('app_logo')->store('settings', 'public');
            Setting::set('app_logo', $path);
        }

        return redirect()->route('settings.edit')->with('success', 'Pengaturan aplikasi berhasil diperbarui.');
    }
}