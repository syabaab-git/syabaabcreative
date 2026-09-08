@props([
    'hideToggle' => false,
    'hideClose' => false,
])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Syabaab Creative') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script>
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        @php
            $authBg = json_decode(\App\Models\Setting::where('key', 'auth_background')->value('value') ?? '{}', true);
            $bgType = $authBg['type'] ?? 'color';
            $bgText = $authBg['text'] ?? 'Syabaab Creative';
            $bgImage = $authBg['image'] ?? '';

            // Typography Classes & Colors
            $typoFont = $authBg['font'] ?? 'Inter';
            $typoSize = ($authBg['size'] ?? 80) . 'px';
            $typoWeight = $authBg['weight'] ?? 900;
            $textColor = $authBg['text_color'] ?? '#0f172a';
            $bgColor = $authBg['bg_color'] ?? '#f8fafc';
            $autoColor = ($authBg['auto_color'] ?? 'true') === 'true';
            
            $caseMap = ['uppercase' => 'uppercase', 'lowercase' => 'lowercase'];
            $typoCase = $caseMap[$authBg['case'] ?? 'normal'] ?? '';
            
            $typoItalic = ($authBg['italic'] ?? 'false') === 'true' ? 'italic' : '';
            $typoStrike = ($authBg['strikethrough'] ?? 'false') === 'true' ? 'line-through' : '';
            
            $typoClasses = trim("$typoCase $typoItalic $typoStrike");
            $typoStyles = "font-family: '{$typoFont}'; font-size: {$typoSize}; font-weight: {$typoWeight}; color: {$textColor};";
            
            // Computed BG Color
            if ($autoColor) {
                $hex = ltrim($textColor, '#');
                $r = hexdec(substr($hex, 0, 2));
                $g = hexdec(substr($hex, 2, 2));
                $b = hexdec(substr($hex, 4, 2));
                $computedBgColor = "rgba($r, $g, $b, 0.05)";
            } else {
                $computedBgColor = $bgColor;
            }
        @endphp
    </head>
    <body class="font-sans text-slate-900 dark:text-slate-100 antialiased min-h-screen relative transition-colors duration-300 dark:bg-black" 
          style="{{ $bgType === 'color' ? 'background-color: ' . $computedBgColor . ';' : ($bgType === 'image' && $bgImage ? 'background-image: url(\'' . asset('storage/' . $bgImage) . '\'); background-attachment: fixed; background-size: cover; background-position: center;' : '') }}">
        
        <!-- Ambient Glow Circles for Glassmorphic Refraction in Dark Mode -->
        <div class="hidden dark:block fixed top-[-10%] left-[-10%] w-[50%] h-[50%] bg-blue-500/10 rounded-full blur-[120px] pointer-events-none z-0"></div>
        <div class="hidden dark:block fixed bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-purple-500/10 rounded-full blur-[120px] pointer-events-none z-0"></div>
        
        @if($bgType === 'color' && $bgText)
            <!-- Typography Background -->
            <div class="fixed inset-[-50%] overflow-hidden flex flex-wrap pointer-events-none select-none z-0 transform -rotate-12 justify-center content-center opacity-30 dark:opacity-10">
                @for($i = 0; $i < 300; $i++)
                    <span class="{{ $typoClasses }} px-6 py-4 whitespace-nowrap leading-none" style="{{ $typoStyles }}">{{ $bgText }}</span>
                @endfor
            </div>
        @endif
        
        @if(!$hideToggle)
        <!-- Glassmorphic Theme Toggle Button (Page Top Right) -->
        <div x-data="{
                darkMode: document.documentElement.classList.contains('dark'),
                toggleDarkMode() {
                    this.darkMode = !this.darkMode;
                    if (this.darkMode) {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('theme', 'dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('theme', 'light');
                    }
                }
             }"
             class="fixed top-6 right-6 z-50">
            <button @click="toggleDarkMode()" 
                    class="h-10 w-10 rounded-full flex items-center justify-center bg-white/30 dark:bg-black/30 backdrop-blur-md border border-white/45 dark:border-white/10 text-slate-700 dark:text-slate-300 hover:text-slate-950 dark:hover:text-white hover:scale-110 active:scale-95 transition-all duration-300 shadow-[0_4px_12px_0_rgba(31,38,135,0.04)] hover:shadow-[0_4px_16px_0_rgba(31,38,135,0.1)] focus:outline-none"
                    title="Ubah Tema">
                <!-- Solid Sun (Matahari) -->
                <svg x-show="darkMode" class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 24 24" style="display: none;">
                    <path d="M12 7.5a4.5 4.5 0 1 1 0 9 4.5 4.5 0 0 1 0-9z M12 2l2 4.5h-4z M12 22l2-4.5h-4z M2 12l4.5-2v4z M22 12l-4.5-2v4z M4.93 4.93l3.18 1.41l-1.41 3.18z M19.07 19.07l-3.18-1.41l1.41-3.18z M19.07 4.93l-1.41 3.18l-3.18-1.41z M4.93 19.07l1.41-3.18l3.18 1.41z" />
                </svg>
                <!-- Solid Moon (Bulan) -->
                <svg x-show="!darkMode" class="w-5 h-5 text-slate-700" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9.528 1.718a.75.75 0 0 1 .162.819A8.97 8.97 0 009 6a9 9 0 009 9 8.97 8.97 0 003.463-.69.75.75 0 0 1 .981.98 10.503 10.503 0 0 1-9.694 6.46c-5.799 0-10.5-4.701-10.5-10.5 0-4.368 2.667-8.112 6.46-9.694a.75.75 0 0 1 .818.162z" />
                </svg>
            </button>
        </div>
        @endif

        <!-- Scrollable Wrapper -->
        <div class="min-h-screen w-full flex items-center justify-center p-4 sm:p-8 relative z-10">
            <!-- Main Container -->
            <div class="w-full max-w-md bg-white/60 dark:bg-[#151515]/60 backdrop-blur-2xl rounded-[32px] shadow-2xl border border-white/50 dark:border-white/10 p-8 sm:p-10 relative">
            
            <!-- Logo -->
            <div class="flex justify-center mb-8">
                <a href="{{ route('dashboard') }}" class="flex flex-col items-center">
                    <span class="text-3xl font-black text-slate-800 dark:text-white leading-none tracking-tight">Syabaab</span>
                    <span class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest leading-none mt-2">Creative Platform</span>
                </a>
            </div>

            <!-- Auth Content -->
            {{ $slot }}
            </div>
        </div>
    </body>
</html>
