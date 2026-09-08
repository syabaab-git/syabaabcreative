@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1', 'transparent' => false])

@php
$alignmentClasses = match ($align) {
    'left' => 'ltr:origin-top-left rtl:origin-top-right start-0',
    'top' => 'origin-top',
    default => 'ltr:origin-top-right rtl:origin-top-left end-0',
};

$width = match ($width) {
    '48' => 'w-48',
    '72' => 'w-72',
    '80' => 'w-80',
    '96' => 'w-96',
    default => $width,
};

$isDark = request()->routeIs('landing');
$dropdownBg = $transparent ? '' : 'bg-white dark:bg-[#151515] border-gray-200 dark:border-white/10';
$shadowClass = $transparent ? '' : 'shadow-xl border';
$overlayBg = 'bg-slate-900/20 dark:bg-black/40';
@endphp

<div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <!-- Blur Overlay (Teleported to body with z-[40] so it sits behind the z-50 navbar but above the page) -->
    <template x-teleport="body">
        <div x-show="open" 
             @click="open = false"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[40] {{ $overlayBg }} backdrop-blur-md cursor-default" 
             style="display: none;"></div>
    </template>

    <div @click="open = ! open" class="relative z-[70]">
        {{ $trigger }}
    </div>

    <!-- Dropdown Menu -->
    <div x-show="open"
            x-transition:enter="transition ease-out duration-400 transform"
            x-transition:enter-start="opacity-0 -translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150 transform"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4"
            class="absolute z-[70] mt-2 {{ $width }} rounded-2xl overflow-hidden {{ $alignmentClasses }} {{ $dropdownBg }} {{ $shadowClass }}"
            style="display: none;"
            @click="open = false">
        <div class="{{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>
