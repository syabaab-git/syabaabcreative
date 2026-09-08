<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Redirect to the first available settings tab based on role.
     */
    public function index(Request $request)
    {
        return view('settings.index', ['user' => $request->user()]);
    }

    /**
     * Show profile settings tab.
     */
    public function profile(Request $request)
    {
        return view('settings.profile', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Show security settings tab.
     */
    public function security(Request $request)
    {
        return view('settings.security', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Show system settings tab (Admin only).
     */
    public function system(Request $request)
    {
        return view('settings.system', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Show services settings tab (Admin only).
     */
    public function services(Request $request)
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        return view('settings.services', [
            'user' => $request->user(),
            'settings' => $settings,
        ]);
    }

    /**
     * Store services settings (Admin only).
     */
    public function servicesStore(Request $request)
    {
        $validated = $request->validate([
            'whatsapp_number' => ['required', 'string', 'max:20'],
            'whatsapp_template' => ['required', 'string'],
            'social_instagram' => ['nullable', 'url', 'max:255'],
            'payment_bank_name' => ['nullable', 'string', 'max:100'],
            'payment_bank_account' => ['nullable', 'string', 'max:50'],
            'payment_bank_owner' => ['nullable', 'string', 'max:100'],
            'payment_qris_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,svg', 'max:2048'],
        ]);

        if ($request->hasFile('payment_qris_image')) {
            $oldQris = \App\Models\Setting::where('key', 'payment_qris_image')->value('value');
            if ($oldQris) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldQris);
            }
            $validated['payment_qris_image'] = $request->file('payment_qris_image')->store('payment-methods', 'public');
        }

        foreach ($validated as $key => $value) {
            if ($value !== null) {
                \App\Models\Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }
        }

        return back()->with('status', 'Pengaturan layanan berhasil disimpan!');
    }
    /**
     * Show landing page settings tab (Admin only).
     */
    public function landing(Request $request)
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        return view('settings.landing', [
            'user' => $request->user(),
            'settings' => $settings,
        ]);
    }

    /**
     * Store landing page settings.
     */
    public function landingStore(Request $request)
    {
        $request->validate([
            'colors' => 'array',
            'texts' => 'array',
            'slides' => 'array',
            'slides.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'auth_bg_type' => 'nullable|in:color,image',
            'auth_bg_text' => 'nullable|string|max:100',
            'auth_bg_font' => 'nullable|string',
            'auth_bg_size' => 'nullable|numeric|min:10|max:250',
            'auth_bg_weight' => 'nullable|numeric|min:100|max:900',
            'auth_bg_case' => 'nullable|string|in:normal,uppercase,lowercase',
            'auth_bg_italic' => 'nullable|string|in:true,false',
            'auth_bg_strikethrough' => 'nullable|string|in:true,false',
            'auth_bg_text_color' => 'nullable|string',
            'auth_bg_color' => 'nullable|string',
            'auth_bg_auto_color' => 'nullable|string|in:true,false',
            'auth_bg_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Process Auth Background
        if ($request->has('auth_bg_type')) {
            $authBg = json_decode(\App\Models\Setting::where('key', 'auth_background')->value('value') ?? '{}', true);
            $authBg['type'] = $request->auth_bg_type;
            
            if ($request->auth_bg_type === 'color') {
                $authBg['text'] = $request->auth_bg_text;
                $authBg['font'] = $request->auth_bg_font ?? 'Inter';
                $authBg['size'] = $request->auth_bg_size ?? '80';
                $authBg['weight'] = $request->auth_bg_weight ?? '900';
                $authBg['case'] = $request->auth_bg_case ?? 'normal';
                $authBg['italic'] = $request->auth_bg_italic ?? 'false';
                $authBg['strikethrough'] = $request->auth_bg_strikethrough ?? 'false';
                $authBg['text_color'] = $request->auth_bg_text_color ?? '#0f172a';
                $authBg['bg_color'] = $request->auth_bg_color ?? '#f8fafc';
                $authBg['auto_color'] = $request->auth_bg_auto_color ?? 'true';
            } elseif ($request->auth_bg_type === 'image') {
                if ($request->hasFile('auth_bg_image')) {
                    // Delete old image
                    if (!empty($authBg['image'])) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($authBg['image']);
                    }
                    $authBg['image'] = $request->file('auth_bg_image')->store('auth-backgrounds', 'public');
                }
            }
            
            \App\Models\Setting::updateOrCreate(['key' => 'auth_background'], ['value' => json_encode($authBg)]);
        }

        // Process Receipt Canvas from the unified personalization form.
        if ($request->filled('canvas_data')) {
            $receipt = json_decode(\App\Models\Setting::where('key', 'receipt_personalization')->value('value') ?? '{}', true);
            $canvasData = json_decode($request->input('canvas_data'), true);

            if (is_array($canvasData)) {
                $receipt['canvas_width'] = $canvasData['canvas_width'] ?? 380;
                $receipt['canvas_height'] = $canvasData['canvas_height'] ?? 560;
                $receipt['canvas_unit'] = $canvasData['canvas_unit'] ?? 'px';
                $receipt['canvas_bg'] = $canvasData['canvas_bg'] ?? '#ffffff';
                $receipt['canvas_use_default_bg'] = !empty($canvasData['canvas_use_default_bg']);
                $receipt['canvas_default_bg_opacity'] = $canvasData['canvas_default_bg_opacity'] ?? 0.3;
                $receipt['elements'] = $canvasData['elements'] ?? [];

                if (!empty($canvasData['logo_data'])) {
                    $receipt['logo_data'] = $canvasData['logo_data'];
                }

                \App\Models\Setting::updateOrCreate(['key' => 'receipt_personalization'], ['value' => json_encode($receipt)]);
            }
        }

        // Process Colors
        if ($request->has('colors')) {
            \App\Models\Setting::updateOrCreate(['key' => 'landing_colors'], ['value' => $request->colors]);
        }

        // Process Texts
        if ($request->has('texts')) {
            \App\Models\Setting::updateOrCreate(['key' => 'landing_texts'], ['value' => $request->texts]);
        }

        // Process Slides
        if ($request->has('slides')) {
            $slides = [];
            foreach ($request->slides as $index => $slideData) {
                $slide = [
                    'title' => $slideData['title'] ?? '',
                    'subtitle' => $slideData['subtitle'] ?? '',
                    'button_text' => $slideData['button_text'] ?? '',
                    'button_url' => $slideData['button_url'] ?? '',
                    'image' => $slideData['old_image'] ?? '',
                ];

                if ($request->hasFile("slides.{$index}.image")) {
                    // Delete old image if it exists
                    if (!empty($slideData['old_image'])) {
                        \Illuminate\Support\Facades\Storage::disk('public')->delete($slideData['old_image']);
                    }
                    $slide['image'] = $request->file("slides.{$index}.image")->store('hero-slides', 'public');
                }

                $slides[] = $slide;
            }

            \App\Models\Setting::updateOrCreate(['key' => 'landing_hero_slides'], ['value' => $slides]);
        } else {
            // If no slides submitted, clear the slides
            \App\Models\Setting::updateOrCreate(['key' => 'landing_hero_slides'], ['value' => []]);
        }

        return redirect()->route('settings.landing')->with('success', 'Pengaturan Personalisasi berhasil disimpan.');
    }

    /**
     * Show feedback and suggestion settings.
     */
    public function feedback(Request $request)
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        return view('settings.feedback', [
            'user' => $request->user(),
            'settings' => $settings,
        ]);
    }

    /**
     * Show receipt personalization (Admin only).
     */
    public function receipt(Request $request)
    {
        return redirect()->route('settings.landing');
    }

    /**
     * Store receipt personalization.
     */
    public function receiptStore(Request $request)
    {
        $receipt = json_decode(\App\Models\Setting::where('key', 'receipt_personalization')->value('value') ?? '{}', true);

        // Handle canvas_data from visual editor (JSON payload)
        if ($request->filled('canvas_data')) {
            $canvasData = json_decode($request->input('canvas_data'), true);
            if (is_array($canvasData)) {
                $receipt['canvas_width']  = $canvasData['canvas_width']  ?? 380;
                $receipt['canvas_height'] = $canvasData['canvas_height'] ?? 560;
                $receipt['canvas_unit']   = $canvasData['canvas_unit']   ?? 'px';
                $receipt['canvas_bg']     = $canvasData['canvas_bg']     ?? '#ffffff';
                $receipt['canvas_use_default_bg'] = !empty($canvasData['canvas_use_default_bg']);
                $receipt['canvas_default_bg_opacity'] = $canvasData['canvas_default_bg_opacity'] ?? 0.3;
                $receipt['elements']      = $canvasData['elements']       ?? [];
                // Store base64 logo data if provided
                if (!empty($canvasData['logo_data'])) {
                    $receipt['logo_data'] = $canvasData['logo_data'];
                }
            }
        } else {
            // Legacy form fields support
            $request->validate([
                'company_name'    => 'nullable|string|max:200',
                'company_address' => 'nullable|string|max:500',
                'footer_text'     => 'nullable|string|max:500',
                'logo'            => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
                'theme_color'     => 'nullable|string|max:50',
                'text_color'      => 'nullable|string|max:50',
                'font_family'     => 'nullable|string|max:100',
            ]);
            $receipt['company_name']    = $request->input('company_name', $receipt['company_name'] ?? null);
            $receipt['company_address'] = $request->input('company_address', $receipt['company_address'] ?? null);
            $receipt['footer_text']     = $request->input('footer_text', $receipt['footer_text'] ?? null);
            $receipt['theme_color']     = $request->input('theme_color', $receipt['theme_color'] ?? '#4f46e5');
            $receipt['text_color']      = $request->input('text_color', $receipt['text_color'] ?? '#111827');
            $receipt['font_family']     = $request->input('font_family', $receipt['font_family'] ?? 'Inter, sans-serif');

            if ($request->hasFile('logo')) {
                if (!empty($receipt['logo'])) {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($receipt['logo']);
                }
                $receipt['logo'] = $request->file('logo')->store('receipt-logos', 'public');
            }
        }

        \App\Models\Setting::updateOrCreate(['key' => 'receipt_personalization'], ['value' => json_encode($receipt)]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('settings.landing')->with('success', 'Personalisasi Struk berhasil disimpan.');
    }

    /**
     * Store feedback settings.
     */
    public function feedbackStore(Request $request)
    {
        $request->validate([
            'feedback_email' => 'nullable|email|max:255',
        ]);

        if ($request->has('feedback_email')) {
            \App\Models\Setting::updateOrCreate(['key' => 'feedback_email'], ['value' => $request->feedback_email]);
        }

        return redirect()->route('settings.services')->with('status', 'Email tujuan masukan berhasil disimpan.');
    }
}
