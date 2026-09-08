<x-app-layout>
    <x-slot name="header">
        @php
            if (!function_exists('getCategoryIcon')) {
                function getCategoryIcon($name) {
                    $name = strtolower($name);
                    if (str_contains($name, 'branding')) {
                        // Sparkles icon
                        return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />';
                    } elseif (str_contains($name, 'company profile') || str_contains($name, 'profil')) {
                        // Identification card / Office building
                        return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />';
                    } elseif (str_contains($name, 'katalog') || str_contains($name, 'catalog') || str_contains($name, 'produk')) {
                        // Shopping bag
                        return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />';
                    } elseif (str_contains($name, 'sosial media') || str_contains($name, 'social media')) {
                        // Share network
                        return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />';
                    } elseif (str_contains($name, 'digital') || str_contains($name, 'marketing')) {
                        // Megaphone
                        return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />';
                    } elseif (str_contains($name, 'web') || str_contains($name, 'aplikasi') || str_contains($name, 'software')) {
                        // Code window
                        return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />';
                    } elseif (str_contains($name, 'video') || str_contains($name, 'animasi')) {
                        // Video camera
                        return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />';
                    } elseif (str_contains($name, 'foto') || str_contains($name, 'photo')) {
                        // Camera
                        return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />';
                    } else {
                        // Default Cube/Collection
                        return '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />';
                    }
                }
            }
        @endphp
        <div class="flex flex-col gap-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <h2 class="font-bold text-2xl text-slate-800 dark:text-white leading-tight tracking-tight">
                    Manajemen Layanan
                </h2>
                <div></div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50/50 dark:bg-black min-h-screen transition-colors duration-300" x-data="{ viewMode: localStorage.getItem('serviceViewMode') || 'grid', activeTab: '{{ $activeTab }}' }" x-init="$watch('viewMode', val => localStorage.setItem('serviceViewMode', val))">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Top Header: Tabs & Actions -->
            <div class="flex flex-col xl:flex-row xl:items-center justify-between gap-4 mb-6">
                <!-- Tabs Navigation -->
                <div class="overflow-x-auto pb-2 -mb-2 custom-scrollbar">
                    <div class="sm:hidden mb-4 lg:mb-0">
                        <label for="tabs" class="sr-only">Pilih Tab</label>
                        <select id="tabs" name="tabs" class="block w-full rounded-2xl border-slate-300 dark:border-slate-805 bg-white dark:bg-slate-900 py-3 pl-4 pr-10 text-base text-slate-800 dark:text-white focus:border-blue-500 focus:ring-blue-500" x-model="activeTab" @change="window.history.replaceState(null, null, '?tab=' + activeTab + '&search={{ request('search') }}&sort={{ request('sort') }}')">
                            <option value="semua">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->slug }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="hidden sm:block">
                        <div class="flex items-center gap-2">
                            <nav class="flex space-x-2 bg-white dark:bg-slate-900 p-2 rounded-[20px] border border-slate-200/80 dark:border-slate-800 shadow-sm w-max" aria-label="Tabs">
                                <!-- Semua -->
                                <button @click="activeTab = 'semua'; window.history.replaceState(null, null, '?tab=semua&search={{ request('search') }}&sort={{ request('sort') }}')"
                                        :class="{'bg-blue-50 dark:bg-blue-950/40 text-blue-700 dark:text-blue-400 shadow-sm ring-1 ring-blue-700/10 dark:ring-blue-400/20 px-5': activeTab === 'semua', 'text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50/50 dark:hover:bg-blue-955/20 px-4': activeTab !== 'semua'}"
                                        class="group py-2.5 rounded-[14px] font-bold text-[14px] transition-all duration-300 flex items-center whitespace-nowrap">
                                    <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                    <div class="overflow-hidden transition-all duration-300 ease-in-out flex items-center"
                                         :class="activeTab === 'semua' ? 'max-w-[200px] opacity-100 ml-2.5' : 'max-w-0 opacity-0 group-hover:max-w-[200px] group-hover:opacity-100 group-hover:ml-2.5'">
                                        <span>Semua</span>
                                        <span class="ml-1.5 px-2 py-0.5 rounded-md bg-white dark:bg-slate-800 text-blue-600 dark:text-blue-400 text-[11px] border border-blue-100 dark:border-blue-900 shadow-sm">{{ $totals['semua'] ?? 0 }}</span>
                                    </div>
                                </button>
                                
                                <!-- Kategori -->
                                @foreach($categories as $category)
                                <button @click="activeTab = '{{ $category->slug }}'; window.history.replaceState(null, null, '?tab={{ $category->slug }}&search={{ request('search') }}&sort={{ request('sort') }}')"
                                        :class="{'bg-blue-50 dark:bg-blue-950/40 text-blue-700 dark:text-blue-400 shadow-sm ring-1 ring-blue-700/10 dark:ring-blue-400/20 px-5': activeTab === '{{ $category->slug }}', 'text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50/50 dark:hover:bg-blue-955/20 px-4': activeTab !== '{{ $category->slug }}'}"
                                        class="group py-2.5 rounded-[14px] font-bold text-[14px] transition-all duration-300 flex items-center whitespace-nowrap">
                                    <svg class="w-5 h-5 shrink-0 transition-transform duration-300 group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">{!! getCategoryIcon($category->name) !!}</svg>
                                    <div class="overflow-hidden transition-all duration-300 ease-in-out flex items-center"
                                         :class="activeTab === '{{ $category->slug }}' ? 'max-w-[250px] opacity-100 ml-2.5' : 'max-w-0 opacity-0 group-hover:max-w-[250px] group-hover:opacity-100 group-hover:ml-2.5'">
                                        <span>{{ $category->name }}</span>
                                        <span class="ml-1.5 px-2 py-0.5 rounded-md bg-white dark:bg-slate-800 text-blue-600 dark:text-blue-400 text-[11px] border border-blue-100 dark:border-blue-900 shadow-sm">{{ $totals[$category->slug] ?? 0 }}</span>
                                    </div>
                                </button>
                                @endforeach
                            </nav>
                            
                            <div class="bg-white dark:bg-slate-900 p-2 rounded-[20px] border border-slate-200/80 dark:border-slate-800 shadow-sm flex items-center shrink-0 h-full">
                                <a href="{{ route('admin.service-categories.index') }}" class="group flex items-center justify-center px-4 py-2.5 rounded-[14px] text-slate-500 dark:text-slate-400 hover:bg-blue-50 dark:hover:bg-blue-955/20 hover:text-blue-600 dark:hover:text-blue-400 transition-all duration-300" title="Kelola Kategori Layanan">
                                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions: Search, Sort & Toggles -->
                <div class="flex items-center gap-3 self-end xl:self-auto shrink-0 flex-wrap justify-end">
                    
                    <!-- Expandable Search -->
                    <form action="{{ route('admin.services.index') }}" method="GET" x-data="{ searchOpen: '{{ request('search') }}' !== '' }" class="flex items-center">
                        <div @click.away="if($refs.searchInput.value === '') searchOpen = false"
                             class="flex items-center bg-white dark:bg-slate-900 border shadow-sm rounded-xl overflow-hidden transition-all duration-300 ease-out"
                             :class="searchOpen ? 'w-64 sm:w-80 border-blue-400 dark:border-blue-800 ring-4 ring-blue-500/10 dark:ring-blue-400/10' : 'w-10 border-slate-200/60 dark:border-slate-800 hover:border-blue-300 dark:hover:border-blue-750'">
                            <button type="button" @click="if(!searchOpen) { searchOpen = true; $nextTick(() => $refs.searchInput.focus()) } else if ($refs.searchInput.value) { $el.closest('form').submit() }" 
                                    class="flex-shrink-0 w-10 h-10 flex items-center justify-center transition-colors bg-transparent z-10 cursor-pointer"
                                    :class="searchOpen ? 'text-blue-600' : 'text-slate-500 hover:text-blue-600 dark:text-slate-400'">
                                <svg class="w-5 h-5 transition-transform duration-300 ease-out" :class="searchOpen ? 'scale-95' : 'scale-100 hover:scale-110'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </button>
                            <input x-ref="searchInput" @keydown.enter="$el.closest('form').submit()" type="text" name="search" value="{{ request('search') }}" placeholder="Cari layanan..." 
                                   class="bg-transparent border-none text-[13px] text-slate-800 dark:text-white focus:ring-0 font-medium transition-all duration-300 ease-out flex-1 min-w-0 placeholder:text-slate-400 dark:placeholder:text-slate-600"
                                   :class="searchOpen ? 'opacity-100 pr-3 pl-1 w-full translate-x-0' : 'opacity-0 w-0 p-0 -translate-x-2 pointer-events-none'">
                        </div>
                        @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                        @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                    </form>

                    <!-- Sort & Filter Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="w-10 h-10 flex items-center justify-center bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800 shadow-sm text-slate-500 dark:text-slate-400 rounded-xl hover:text-blue-600 dark:hover:text-blue-400 hover:border-blue-300 dark:hover:border-blue-700 transition-colors" title="Filter & Sortir">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        </button>
                        
                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" style="display: none;" class="absolute right-0 mt-2 w-56 bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-100 dark:border-slate-700 z-50 overflow-hidden">
                            <div class="px-4 py-3 text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.1em] bg-slate-50/50 dark:bg-slate-900/30 border-b border-slate-100 dark:border-slate-700">Sortir Berdasarkan</div>
                            <div class="p-2">
                                <a :href="`?tab=${activeTab}&sort=latest&search={{ request('search') }}`" class="flex items-center px-3 py-2.5 text-[13px] font-bold text-slate-700 dark:text-slate-300 hover:bg-blue-50 dark:hover:bg-blue-955/20 hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition-colors {{ request('sort') == 'latest' || !request('sort') ? 'text-blue-600 dark:text-blue-400 bg-blue-50/50 dark:bg-blue-955/10' : '' }}">
                                    <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-2.5 opacity-0 {{ request('sort') == 'latest' || !request('sort') ? 'opacity-100' : '' }}"></div>
                                    Terbaru
                                </a>
                                <a :href="`?tab=${activeTab}&sort=oldest&search={{ request('search') }}`" class="flex items-center px-3 py-2.5 text-[13px] font-bold text-slate-700 dark:text-slate-300 hover:bg-blue-50 dark:hover:bg-blue-955/20 hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition-colors {{ request('sort') == 'oldest' ? 'text-blue-600 dark:text-blue-400 bg-blue-50/50 dark:bg-blue-955/10' : '' }}">
                                    <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-2.5 opacity-0 {{ request('sort') == 'oldest' ? 'opacity-100' : '' }}"></div>
                                    Terlama
                                </a>
                                <div class="mt-1 pt-1 border-t border-slate-50 dark:border-slate-700">
                                    <a :href="`?tab=${activeTab}&sort=name_asc&search={{ request('search') }}`" class="flex items-center px-3 py-2.5 text-[13px] font-bold text-slate-700 dark:text-slate-300 hover:bg-blue-50 dark:hover:bg-blue-955/20 hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition-colors {{ request('sort') == 'name_asc' ? 'text-blue-600 dark:text-blue-400 bg-blue-50/50 dark:bg-blue-955/10' : '' }}">
                                        <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-2.5 opacity-0 {{ request('sort') == 'name_asc' ? 'opacity-100' : '' }}"></div>
                                        Nama (A-Z)
                                    </a>
                                    <a :href="`?tab=${activeTab}&sort=price_desc&search={{ request('search') }}`" class="flex items-center px-3 py-2.5 text-[13px] font-bold text-slate-700 dark:text-slate-300 hover:bg-blue-50 dark:hover:bg-blue-955/20 hover:text-blue-600 dark:hover:text-blue-400 rounded-xl transition-colors {{ request('sort') == 'price_desc' ? 'text-blue-600 dark:text-blue-400 bg-blue-50/50 dark:bg-blue-955/10' : '' }}">
                                        <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-2.5 opacity-0 {{ request('sort') == 'price_desc' ? 'opacity-100' : '' }}"></div>
                                        Harga Tertinggi
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-px h-6 bg-slate-200 dark:bg-slate-800"></div>

                    <div class="flex items-center bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800 shadow-sm rounded-xl p-1">
                        <button @click="viewMode = 'grid'" :class="viewMode === 'grid' ? 'bg-slate-100 dark:bg-slate-800 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-slate-400 dark:text-slate-550 hover:text-slate-600 dark:hover:text-slate-300'" class="w-8 h-8 flex items-center justify-center rounded-lg transition-all" title="Tampilan Kartu">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        </button>
                        <button @click="viewMode = 'list'" :class="viewMode === 'list' ? 'bg-slate-100 dark:bg-slate-800 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-slate-400 dark:text-slate-550 hover:text-slate-600 dark:hover:text-slate-300'" class="w-8 h-8 flex items-center justify-center rounded-lg transition-all" title="Tampilan Memanjang">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

            @foreach($servicesByTab as $tabKey => $services)
            <div x-show="activeTab === '{{ $tabKey }}'" style="display: none;" x-transition:enter="transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                @if($services->count() > 0)
                    <div x-show="viewMode === 'grid'" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        @foreach($services as $service)
                            <div class="group bg-white dark:bg-slate-900 rounded-3xl overflow-hidden border border-slate-200/60 dark:border-slate-800 shadow-sm hover:shadow-xl hover:border-blue-200 dark:hover:border-blue-900 transition-all duration-500 ease-out flex flex-col relative">
                                <div class="absolute top-4 left-4 z-10 flex gap-2">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-white/90 dark:bg-slate-900/90 text-slate-700 dark:text-slate-300 backdrop-blur-md shadow-sm border border-white/20 dark:border-slate-850">
                                        {{ $service->category->name }}
                                    </span>
                                    @if(!$service->is_active)
                                        <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-800/90 dark:bg-slate-950/90 text-white backdrop-blur-md shadow-sm border border-slate-700/50 dark:border-slate-850">
                                            Draf / Arsip
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="absolute top-4 right-4 z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex gap-2">
                                    <form action="{{ route('admin.services.toggle-status', $service) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin {{ $service->is_active ? 'mengarsipkan' : 'menerbitkan' }} layanan ini?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="w-8 h-8 rounded-full bg-white/90 dark:bg-slate-800/90 text-indigo-600 dark:text-indigo-450 hover:bg-indigo-50 dark:hover:bg-indigo-950/40 flex items-center justify-center backdrop-blur-md shadow-sm transition-colors" title="{{ $service->is_active ? 'Arsipkan' : 'Terbitkan' }}">
                                            @if($service->is_active)
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                            @else
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            @endif
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.services.edit', $service) }}" class="w-8 h-8 rounded-full bg-white/90 dark:bg-slate-800/90 text-amber-600 dark:text-amber-500 hover:bg-amber-50 dark:hover:bg-amber-955/20 flex items-center justify-center backdrop-blur-md shadow-sm transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-full bg-white/90 dark:bg-slate-800/90 text-red-600 dark:text-red-450 hover:bg-red-50 dark:hover:bg-red-955/20 flex items-center justify-center backdrop-blur-md shadow-sm transition-colors" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>

                                <div class="aspect-[4/3] w-full bg-slate-100 dark:bg-slate-950 relative overflow-hidden group-hover:shadow-inner">
                                    @if($service->thumbnail)
                                        <img src="{{ Storage::url($service->thumbnail) }}" alt="{{ $service->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-in-out">
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 dark:text-slate-600 gap-3 group-hover:scale-105 transition-transform duration-500">
                                            <svg class="w-12 h-12 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <span class="text-xs font-medium uppercase tracking-wider">Tanpa Thumbnail</span>
                                        </div>
                                    @endif
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                </div>

                                <div class="p-6 flex flex-col flex-1 bg-white dark:bg-slate-900 relative">
                                    <h3 class="font-bold text-lg text-slate-800 dark:text-white mb-2 leading-tight group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2">
                                        {{ $service->title }}
                                    </h3>
                                    
                                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-6 line-clamp-3 leading-relaxed flex-1">
                                        {{ strip_tags($service->description) }}
                                    </p>

                                    <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between mt-auto">
                                        <div class="flex flex-col">
                                            <span class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-1">Harga Mulai</span>
                                            <span class="text-lg font-black text-blue-600 dark:text-blue-400">Rp {{ number_format($service->base_price, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="w-10 h-10 rounded-full bg-blue-50 dark:bg-blue-950/30 text-blue-600 dark:text-blue-400 flex items-center justify-center group-hover:bg-blue-600 dark:group-hover:bg-blue-500 group-hover:text-white transition-colors duration-300 shadow-sm">
                                            <svg class="w-5 h-5 translate-x-0 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- List View -->
                    <div x-show="viewMode === 'list'" style="display: none;" class="bg-white dark:bg-slate-900 rounded-[24px] overflow-hidden border border-slate-200/60 dark:border-slate-800 shadow-sm mb-8">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-slate-50/80 dark:bg-slate-950/40 border-b border-slate-200/80 dark:border-slate-800">
                                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-450 uppercase tracking-widest w-[100px]">Thumbnail</th>
                                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-450 uppercase tracking-widest">Detail Layanan</th>
                                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-450 uppercase tracking-widest">Kategori</th>
                                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-450 uppercase tracking-widest text-right">Harga Dasar</th>
                                        <th class="px-6 py-4 text-xs font-bold text-slate-500 dark:text-slate-450 uppercase tracking-widest text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                    @foreach($services as $service)
                                        <tr class="hover:bg-blue-50/30 dark:hover:bg-slate-850/30 transition-colors group">
                                            <td class="px-6 py-4">
                                                <div class="w-20 h-16 rounded-xl bg-slate-100 dark:bg-slate-950 overflow-hidden shadow-sm">
                                                    @if($service->thumbnail)
                                                        <img src="{{ Storage::url($service->thumbnail) }}" alt="{{ $service->title }}" class="w-full h-full object-cover">
                                                    @else
                                                        <div class="w-full h-full flex items-center justify-center text-slate-300 dark:text-slate-700">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                <p class="font-bold text-slate-800 dark:text-white text-[15px] mb-1 line-clamp-1 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ $service->title }}</p>
                                                <p class="text-[13px] text-slate-500 dark:text-slate-400 line-clamp-1">{{ strip_tags($service->description) }}</p>
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700">
                                                    {{ $service->category->name }}
                                                </span>
                                                @if(!$service->is_active)
                                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-800/90 dark:bg-slate-700/90 text-white border border-slate-700/50 dark:border-slate-600 mt-1 sm:mt-0 sm:ml-1">
                                                        Draf / Arsip
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <span class="font-black text-slate-800 dark:text-white">Rp {{ number_format($service->base_price, 0, ',', '.') }}</span>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <form action="{{ route('admin.services.toggle-status', $service) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin {{ $service->is_active ? 'mengarsipkan' : 'menerbitkan' }} layanan ini?');">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="p-2 text-indigo-600 dark:text-indigo-455 hover:bg-indigo-50 dark:hover:bg-indigo-950/40 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500/20" title="{{ $service->is_active ? 'Arsipkan' : 'Terbitkan' }}">
                                                            @if($service->is_active)
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                                            @else
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                            @endif
                                                        </button>
                                                    </form>
                                                    <a href="{{ route('admin.services.edit', $service) }}" class="p-2 text-amber-600 dark:text-amber-500 hover:bg-amber-50 dark:hover:bg-amber-955/20 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-amber-500/20" title="Edit">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                    </a>
                                                    <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus layanan ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="p-2 text-rose-600 dark:text-rose-455 hover:bg-rose-50 dark:hover:bg-rose-955/20 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-rose-500/20" title="Hapus">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/60 dark:border-slate-800 shadow-sm p-12 flex flex-col items-center justify-center text-center mb-8">
                        <div class="w-24 h-24 rounded-full bg-slate-50 dark:bg-slate-950 flex items-center justify-center mb-6">
                            <svg class="w-12 h-12 text-slate-300 dark:text-slate-750" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white mb-2">Belum Ada Layanan</h3>
                        <p class="text-slate-500 dark:text-slate-400 mb-8 max-w-md">Anda belum memiliki layanan di sistem. Tambahkan layanan baru untuk mulai menawarkannya kepada klien Anda.</p>
                        <a href="{{ route('admin.services.create') }}" class="px-8 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition-colors shadow-sm flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Layanan Pertama
                        </a>
                    </div>
                @endif
                
                <!-- Pagination -->
                @if($services->hasPages())
                    <div class="mt-8">
                        {{ $services->links() }}
                    </div>
                @endif
            </div>
            @endforeach
        </div>

        <!-- Floating Action Button for New Service -->
        <div x-data="{ scrolled: false, show: false }"
             x-init="
                if (document.referrer.split('?')[0] === window.location.href.split('?')[0] && document.referrer !== '') {
                    show = true;
                } else {
                    setTimeout(() => show = true, 500);
                }
             "
             x-show="show"
             @scroll.window="scrolled = (window.pageYOffset > 50)"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 -translate-x-12 scale-50"
             x-transition:enter-end="opacity-100 translate-x-0 scale-100"
             x-transition:leave="transition ease-in duration-300 transform"
             x-transition:leave-start="opacity-100 translate-x-0 scale-100"
             x-transition:leave-end="opacity-0 -translate-x-12 scale-50"
             class="fixed bottom-5 left-[4.25rem] sm:left-auto sm:bottom-10 sm:right-10 z-[9999]" style="display: none; bottom: calc(1.25rem + env(safe-area-inset-bottom)) !important;">
             <a href="{{ route('admin.services.create') }}" 
                class="flex items-center h-11 w-11 sm:h-14 bg-white/75 dark:bg-[#151515]/75 backdrop-blur-3xl border border-white/70 dark:border-white/20 rounded-full text-blue-600 dark:text-blue-400 hover:scale-110 sm:hover:scale-105 active:scale-95 focus:outline-none transition-all duration-300 ease-out shadow-[0_8px_25px_rgba(0,0,0,0.08)] dark:shadow-[0_8px_32px_rgba(0,0,0,0.6),_inset_0_1px_1px_rgba(255,255,255,0.25)] overflow-hidden"
                :class="scrolled ? 'w-11 sm:w-14' : 'w-11 sm:w-[205px]'">
                 <div class="flex items-center justify-center w-11 h-11 sm:w-14 sm:h-14 shrink-0">
                     <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                 </div>
                 <span class="hidden sm:inline font-bold text-[16px] whitespace-nowrap transition-opacity duration-500 pl-1 pr-6" :class="scrolled ? 'opacity-0' : 'opacity-100 delay-200'">Tambah Layanan</span>
             </a>
        </div>
    </div>
</x-app-layout>
