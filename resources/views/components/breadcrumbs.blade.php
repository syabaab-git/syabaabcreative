@php
    $segments = request()->segments();
    $roles = ['admin', 'mentor', 'member', 'staff'];
    $breadcrumbs = [];
    $currentUrl = '';

    // Map route parameters to their display names to prevent raw IDs in breadcrumbs
    $parameters = request()->route() ? request()->route()->parameters() : [];
    $segmentToTitle = [];
    
    foreach ($parameters as $key => $value) {
        if (is_object($value)) {
            // Prioritize 'title' or 'name' properties from the bound model
            $name = $value->title ?? $value->name ?? ucwords(str_replace('-', ' ', $key));
            
            if (isset($value->id)) {
                $segmentToTitle[(string)$value->id] = $name;
            }
            if (isset($value->slug)) {
                $segmentToTitle[(string)$value->slug] = $name;
            }
        }
    }

    foreach ($segments as $index => $segment) {
        $currentUrl .= '/' . $segment;
        
        // Hide role segment and rename to Dashboard pointing to the role's dashboard
        if ($index === 0 && in_array($segment, $roles)) {
            $breadcrumbs[] = [
                'title' => 'Dashboard',
                'url' => url('/' . $segment . '/dashboard'),
            ];
            continue;
        }

        // Prevent "Dashboard > Dashboard" duplication
        if ($index === 1 && $segment === 'dashboard' && in_array($segments[0], $roles)) {
            continue;
        }

        // Use the resolved model name if available, otherwise format the segment string
        if (array_key_exists((string)$segment, $segmentToTitle)) {
            $title = $segmentToTitle[(string)$segment];
        } else {
            // Translate common CRUD action words for better localization
            $translations = [
                'create' => 'Tambah Baru',
                'edit' => 'Edit',
                'show' => 'Detail',
                'courses' => 'Kelas',
                'lessons' => 'Materi',
                'assignments' => 'Tugas',
                'users' => 'Pengguna',
            ];
            $title = $translations[strtolower($segment)] ?? ucwords(str_replace('-', ' ', $segment));
        }

        $breadcrumbs[] = [
            'title' => $title,
            'url' => url($currentUrl),
        ];
    }
    
    $isDark = false;
    $borderColor = $isDark ? 'border-white/10' : 'border-gray-200/30';
    $textColor = $isDark ? 'text-gray-400' : 'text-slate-500';
    $iconColor = $isDark ? 'text-gray-500' : 'text-slate-300';
    $activeColor = $isDark ? 'text-white' : 'text-slate-800';
    $hoverColor = $isDark ? 'hover:text-blue-600' : 'hover:text-blue-600';
@endphp

<!-- Desktop Breadcrumbs (Inside/Attached to navbar bottom) -->
<div class="hidden sm:block w-full border-t {{ $borderColor }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2.5 flex items-center text-[12px] font-medium {{ $textColor }} overflow-x-auto whitespace-nowrap scrollbar-hide">
        <a href="/" class="{{ $hoverColor }} transition-colors flex items-center shrink-0">
            <svg class="w-4 h-4 mr-1.5 text-slate-400 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Home
        </a>
        @foreach($breadcrumbs as $breadcrumb)
            <svg class="w-4 h-4 mx-2 {{ $iconColor }} shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            @if($loop->last)
                <span class="{{ $activeColor }} font-bold shrink-0">{{ $breadcrumb['title'] }}</span>
            @else
                <a href="{{ $breadcrumb['url'] }}" class="{{ $hoverColor }} transition-colors shrink-0">{{ $breadcrumb['title'] }}</a>
            @endif
        @endforeach
    </div>
</div>

<!-- Mobile Separated Glassmorphic Capsule Breadcrumbs -->
<template x-teleport="body">
    <div class="block sm:hidden fixed top-[62px] left-4 z-[35] pointer-events-auto">
        <div x-data="{
                // ============================================================
                // PENGATURAN EFEK PENYUSUTAN & FADE KARAKTER DI UJUNG KAPSUL
                // Silakan ubah variabel di bawah ini sesuai keinginan:
                // ============================================================
                edgeOffset: 0.3,   // Jarak offset dari pinggir kapsul (px). Makin kecil = makin di paling ujung.
                shrinkZone: 14,    // Lebar area penyusutan & fade (px).
                minScale: 0.90,    // Skala ukuran terkompresi di ujung (0.90 = 90%).
                minOpacity: 0.10,  // Opasitas terendah di ujung (0.20 = 20% / fade tipis).

                updateScales() {
                    const parent = $el;
                    const items = parent.querySelectorAll('.edge-item');
                    if (!items.length) return;

                    // Aktif HANYA jika isi kapsul melimpah / di-scroll
                    if (parent.scrollWidth <= parent.clientWidth + 2) {
                        items.forEach(c => {
                            c.style.transform = 'scale(1)';
                            c.style.opacity = '1';
                        });
                        return;
                    }

                    const pRect = parent.getBoundingClientRect();
                    const leftEdge = pRect.left + this.edgeOffset;
                    const rightEdge = pRect.right - this.edgeOffset;

                    items.forEach(c => {
                        const cRect = c.getBoundingClientRect();
                        const distLeft = cRect.left - leftEdge;
                        const distRight = rightEdge - cRect.right;
                        const minDist = Math.min(distLeft, distRight);

                        if (minDist < this.shrinkZone) {
                            if (minDist <= 0) {
                                c.style.transform = `scale(${this.minScale})`;
                                c.style.opacity = this.minOpacity;
                            } else {
                                const ratio = minDist / this.shrinkZone;
                                const scale = this.minScale + ((1 - this.minScale) * ratio);
                                const opacity = this.minOpacity + ((1 - this.minOpacity) * ratio);

                                c.style.transform = `scale(${scale.toFixed(2)})`;
                                c.style.opacity = opacity.toFixed(2);
                            }
                        } else {
                            c.style.transform = 'scale(1)';
                            c.style.opacity = '1';
                        }
                    });
                }
             }"
             x-init="setTimeout(() => updateScales(), 60); window.addEventListener('resize', () => updateScales())"
             @scroll="updateScales()"
             class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-white/75 dark:bg-[#151515]/45 backdrop-blur-3xl border border-white/70 dark:border-white/20 shadow-[0_8px_25px_rgba(0,0,0,0.08)] dark:shadow-[0_8px_32px_rgba(0,0,0,0.6),_inset_0_1px_1px_rgba(255,255,255,0.25)] transition-all duration-300 max-w-[calc(100vw-2rem)] overflow-x-auto whitespace-nowrap scrollbar-hide text-[11px] font-medium text-slate-600 dark:text-slate-200">
            
            <a href="/" class="hover:text-blue-600 dark:hover:text-white transition-colors duration-300 flex items-center shrink-0"><span class="edge-item inline-block origin-center transition-all duration-150 ease-out"><svg class="w-3.5 h-3.5 mr-1 text-slate-400 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg></span>@foreach(mb_str_split('Home') as $char)<span class="edge-item inline-block origin-center transition-all duration-150 ease-out">{{ $char === ' ' ? "\u{00A0}" : $char }}</span>@endforeach</a>

            @foreach($breadcrumbs as $breadcrumb)
                <span class="edge-item inline-block origin-center transition-all duration-150 ease-out"><svg class="w-3.5 h-3.5 mx-0.5 text-slate-300 dark:text-gray-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg></span>
                @if($loop->last)
                    <span class="text-slate-900 dark:text-white font-bold shrink-0">@foreach(mb_str_split($breadcrumb['title']) as $char)<span class="edge-item inline-block origin-center transition-all duration-150 ease-out">{{ $char === ' ' ? "\u{00A0}" : $char }}</span>@endforeach</span>
                @else
                    <a href="{{ $breadcrumb['url'] }}" class="hover:text-blue-600 dark:hover:text-white transition-colors duration-300 shrink-0">@foreach(mb_str_split($breadcrumb['title']) as $char)<span class="edge-item inline-block origin-center transition-all duration-150 ease-out">{{ $char === ' ' ? "\u{00A0}" : $char }}</span>@endforeach</a>
                @endif
            @endforeach
        </div>
    </div>
</template>
