<x-app-layout>
    <div class="min-h-screen bg-[#f8fafc] dark:bg-black pb-12 pt-4 sm:pt-8 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- TABS & CONTENT -->
            <div x-data="{ viewMode: localStorage.getItem('memberViewMode') || 'grid', activeTab: '{{ $activeTab }}' }" x-init="$watch('viewMode', val => localStorage.setItem('memberViewMode', val))" class="flex flex-col lg:flex-row gap-4 lg:gap-8 relative">
                
                <div class="w-full lg:w-64 flex-shrink-0">
                    <div class="sticky top-[70px]">
                        <h2 class="text-[22px] font-black text-slate-800 dark:text-white mb-4 lg:mb-6 tracking-tight">Dashboard Member</h2>
                        
                        <!-- Mobile Responsive Nav Tab & Search/Sort Row -->
                        <div class="sm:hidden flex items-center justify-between gap-2 mb-4 bg-white/45 dark:bg-[#151515]/45 backdrop-blur-md p-1.5 rounded-[20px] shadow-sm border border-slate-200/60 dark:border-white/10 relative h-[62px] z-20" x-data="{ mobileSearchOpen: '{{ request('search') }}' !== '' }">
                            <!-- Tab & Icons Wrapper (visible when search is closed) -->
                            <div class="flex items-center justify-between w-full gap-2" x-show="!mobileSearchOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                                <!-- Sideways Tabs with Fluid Liquid Indicator -->
                                <nav class="relative flex items-center p-1 rounded-full bg-slate-100/90 dark:bg-[#121212]/90 backdrop-blur-md border border-slate-200/80 dark:border-white/10 flex-1 select-none overflow-hidden">
                                    <!-- Fluid Liquid Sliding Capsule Indicator -->
                                    <div class="absolute top-1 bottom-1 rounded-full bg-white dark:bg-white/15 border border-slate-200/80 dark:border-white/10 shadow-sm pointer-events-none transition-all duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)] z-0"
                                         :style="`width: calc((100% - 8px) / 2); left: calc(4px + (100% - 8px) / 2 * ${activeTab === 'layanan' ? 1 : 0})`">
                                    </div>

                                    <div class="grid grid-cols-2 relative z-10 w-full items-center">
                                        <!-- Kelas Saya Tab -->
                                        <button @click="activeTab = 'kelas'; window.history.replaceState(null, null, '?tab=kelas&search={{ request('search') }}&sort={{ request('sort') }}')"
                                                class="flex items-center justify-center gap-1.5 h-8 px-2 rounded-full font-bold text-[11px] transition-colors duration-300 relative z-10 group"
                                                :class="activeTab === 'kelas' ? 'text-blue-600 dark:text-blue-400 font-black' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 font-medium'">
                                            <svg class="w-3.5 h-3.5 shrink-0 transition-transform duration-300 group-active:scale-90" :class="activeTab === 'kelas' ? 'text-blue-600 dark:text-blue-400' : 'text-slate-400 dark:text-slate-500'" fill="currentColor" viewBox="0 0 20 20"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" /></svg>
                                            <span class="whitespace-nowrap">Kelas Saya</span>
                                        </button>
                                        
                                        <!-- Layanan Saya Tab -->
                                        <button @click="activeTab = 'layanan'; window.history.replaceState(null, null, '?tab=layanan&search={{ request('search') }}&sort={{ request('sort') }}')"
                                                class="relative flex items-center justify-center gap-1.5 h-8 px-2 rounded-full font-bold text-[11px] transition-colors duration-300 relative z-10 group"
                                                :class="activeTab === 'layanan' ? 'text-blue-600 dark:text-blue-400 font-black' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 font-medium'">
                                            <svg class="w-3.5 h-3.5 shrink-0 transition-transform duration-300 group-active:scale-90" :class="activeTab === 'layanan' ? 'text-blue-600 dark:text-blue-400' : 'text-slate-400 dark:text-slate-500'" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" /><path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" /></svg>
                                            <span class="whitespace-nowrap">Layanan Saya</span>
                                        </button>
                                    </div>
                                </nav>

                                <!-- Mobile Search & Sort Icon Group -->
                                <div class="flex items-center gap-1 shrink-0">
                                    <!-- Search Toggle Button -->
                                    <button @click="mobileSearchOpen = true" class="w-9 h-9 flex items-center justify-center bg-slate-50 dark:bg-[#1c1c1e] border border-slate-200/60 dark:border-white/10 text-slate-500 dark:text-slate-400 rounded-xl hover:text-blue-600 transition-colors" title="Cari">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </button>

                                    <!-- Sort Dropdown -->
                                    <div class="relative" x-data="{ open: false }">
                                        <button @click="open = !open" @click.away="open = false" class="w-9 h-9 flex items-center justify-center bg-slate-50 dark:bg-[#1c1c1e] border border-slate-200/60 dark:border-white/10 text-slate-500 dark:text-slate-400 rounded-xl hover:text-blue-600 transition-colors" title="Sortir">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                                        </button>
                                        
                                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" style="display: none;" class="absolute right-0 mt-2 w-48 bg-white dark:bg-[#1c1c1e] rounded-2xl shadow-xl border border-slate-100 dark:border-white/10/50 z-50 overflow-hidden">
                                            <div class="px-3 py-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.1em] bg-slate-50 dark:bg-[#1c1c1e]/50 border-b border-slate-100 dark:border-white/10/50">Sortir Berdasarkan</div>
                                            <div class="p-1.5">
                                                <a href="?tab={{ $activeTab }}&sort=latest&search={{ request('search') }}" class="flex items-center px-2.5 py-2 text-[12px] font-bold text-slate-700 dark:text-slate-200 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('sort') == 'latest' || !request('sort') ? 'text-blue-600 bg-blue-50/50' : '' }}">
                                                    Terbaru
                                                </a>
                                                <a href="?tab={{ $activeTab }}&sort=oldest&search={{ request('search') }}" class="flex items-center px-2.5 py-2 text-[12px] font-bold text-slate-700 dark:text-slate-200 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('sort') == 'oldest' ? 'text-blue-600 bg-blue-50/50' : '' }}">
                                                    Terlama
                                                </a>
                                                <a href="?tab={{ $activeTab }}&sort=name_asc&search={{ request('search') }}" class="flex items-center px-2.5 py-2 text-[12px] font-bold text-slate-700 dark:text-slate-200 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('sort') == 'name_asc' ? 'text-blue-600 bg-blue-50/50' : '' }}">
                                                    Nama (A-Z)
                                                </a>
                                                <a href="?tab={{ $activeTab }}&sort=name_desc&search={{ request('search') }}" class="flex items-center px-2.5 py-2 text-[12px] font-bold text-slate-700 dark:text-slate-200 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('sort') == 'name_desc' ? 'text-blue-600 bg-blue-50/50' : '' }}">
                                                    Nama (Z-A)
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Search Overlay (visible when search is open) -->
                            <div class="absolute inset-0 bg-white dark:bg-[#1c1c1e] px-3 flex items-center gap-2 z-20 rounded-[20px]" x-show="mobileSearchOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                                <form action="{{ route('member.dashboard') }}" method="GET" class="flex-1 flex items-center bg-slate-50 dark:bg-[#1c1c1e] border border-slate-200/60 dark:border-white/10 rounded-xl overflow-hidden h-10">
                                    <div class="flex-1 flex items-center px-3 h-full">
                                        <svg class="w-4 h-4 text-slate-400 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..." 
                                               class="bg-transparent border-none text-[13px] focus:ring-0 font-medium w-full p-0 h-full">
                                    </div>
                                    <input type="hidden" name="tab" :value="activeTab">
                                    @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                                </form>
                                <!-- Close button -->
                                <button @click="mobileSearchOpen = false; window.location.href = '?tab=' + activeTab" class="w-10 h-10 flex items-center justify-center bg-slate-100 dark:bg-[#1c1c1e]/50 hover:bg-slate-200 text-slate-500 dark:text-slate-400 rounded-xl shrink-0" title="Batal Cari">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        </div>
                        
                        <nav class="hidden sm:flex flex-col gap-2 bg-white dark:bg-[#1c1c1e] p-2.5 rounded-[24px] shadow-sm border border-slate-200/80 dark:border-white/10">
                            <!-- Kelas Saya Tab -->
                            <button @click="activeTab = 'kelas'; window.history.replaceState(null, null, '?tab=kelas&search={{ request('search') }}&sort={{ request('sort') }}')"
                                    :class="activeTab === 'kelas' ? 'bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/20 shadow-[0_2px_10px_-3px_rgba(59,130,246,0.15)]' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white border border-transparent'"
                                    class="group flex items-center justify-between px-4 py-2.5 rounded-xl font-bold text-[13px] transition-all duration-300 text-left">
                                <div class="flex items-center gap-3">
                                    <div class="p-1.5 rounded-lg transition-colors" :class="activeTab === 'kelas' ? 'bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400' : 'bg-transparent text-slate-400 dark:text-slate-500 group-hover:bg-slate-100 dark:group-hover:bg-white/5 group-hover:text-slate-700 dark:group-hover:text-slate-300'">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" /></svg>
                                    </div>
                                    <span>Kelas Saya</span>
                                </div>
                                <span class="px-2 py-0.5 rounded-md text-[11px] font-bold shadow-sm transition-all" :class="activeTab === 'kelas' ? 'bg-blue-100/80 dark:bg-blue-500/25 text-blue-600 dark:text-blue-300 border border-blue-100 dark:border-blue-500/10' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-transparent'">{{ $totalKelasTab ?? 0 }}</span>
                            </button>
                            
                            <!-- Layanan Saya Tab -->
                            <button @click="activeTab = 'layanan'; window.history.replaceState(null, null, '?tab=layanan&search={{ request('search') }}&sort={{ request('sort') }}')"
                                    :class="activeTab === 'layanan' ? 'bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/20 shadow-[0_2px_10px_-3px_rgba(59,130,246,0.15)]' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white border border-transparent'"
                                    class="group flex items-center justify-between px-4 py-2.5 rounded-xl font-bold text-[13px] transition-all duration-300 text-left">
                                <div class="flex items-center gap-3">
                                    <div class="p-1.5 rounded-lg transition-colors" :class="activeTab === 'layanan' ? 'bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400' : 'bg-transparent text-slate-400 dark:text-slate-500 group-hover:bg-slate-100 dark:group-hover:bg-white/5 group-hover:text-slate-750 dark:group-hover:text-white'">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" /><path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" /></svg>
                                    </div>
                                    <span>Layanan Saya</span>
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <span class="px-2 py-0.5 rounded-md text-[11px] font-bold shadow-sm transition-all" :class="activeTab === 'layanan' ? 'bg-blue-100/80 dark:bg-blue-500/25 text-blue-600 dark:text-blue-300 border border-blue-100 dark:border-blue-500/10' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-transparent'">{{ $totalLayananTab ?? 0 }}</span>
                                </div>
                            </button>
                        </nav>

                        <!-- Sidebar Widgets -->
                        <div class="hidden lg:flex flex-col gap-4 mt-6">
                            <!-- COMBINED WIDGET (Clock & Stats) -->
                            <div x-data="clockWidget()" x-init="initClock()" 
                                 class="relative rounded-[24px] bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 p-5 shadow-sm transition-all duration-300 hover:shadow-md overflow-hidden">
                                 
                                <!-- TOP: Greeting & Clock -->
                                <div class="relative z-10 flex flex-col gap-1.5">
                                    <div class="flex justify-between items-center">
                                        <div>
                                            <p class="text-slate-400 dark:text-slate-500 text-[9px] font-black uppercase tracking-wider mb-0.5">
                                                <span x-text="greeting"></span>
                                            </p>
                                            <h2 class="text-[15px] font-black text-slate-800 dark:text-slate-100 leading-tight tracking-tight">
                                                {{ explode(' ', Auth::user()->name)[0] }}!
                                            </h2>
                                        </div>
                                        <div class="text-right">
                                            <div class="text-[18px] font-black text-indigo-600 dark:text-indigo-450 leading-none tracking-tight tabular-nums" x-text="timeString"></div>
                                            <p class="text-slate-400 dark:text-slate-500 text-[8.5px] font-bold uppercase tracking-wider mt-1" x-text="dateString"></p>
                                        </div>
                                    </div>
                                </div>

                                <!-- BOTTOM: Stats Row -->
                                <div class="relative z-10 flex items-center justify-between mt-4 pt-3.5 border-t border-slate-100 dark:border-slate-800/60 text-slate-600 dark:text-slate-400">
                                    <div class="flex items-center gap-1.5 text-[11px] font-bold">
                                        <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.5a1 1 0 01.788 0l4 1.5a.999.999 0 01.356.257l2.856-1.071a1 1 0 000-1.84l-7-3zM5 9.79l5 1.875 5-1.875V13.5a5 5 0 01-10 0V9.79z" />
                                        </svg>
                                        <span>{{ number_format($enrolledCoursesCount) }} Kelas</span>
                                    </div>
                                    <div class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-700"></div>
                                    <div class="flex items-center gap-1.5 text-[11px] font-bold">
                                        <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                                            <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
                                        </svg>
                                        <span>{{ number_format($totalLayananTab ?? 0) }} Layanan</span>
                                    </div>
                                    <div class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-700"></div>
                                    <div class="flex items-center gap-1.5 text-[11px] font-bold">
                                        <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                        </svg>
                                        <span>{{ number_format($certificatesCount) }} Sertifikat</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="flex-1 min-w-0 relative">
                    <!-- Actions: Search, Tabs & Sort -->
                    <div class="flex justify-between items-center gap-4 mb-4 sm:mb-8">
                        <div class="flex items-center gap-3 w-full md:w-auto">
                            <!-- Expandable Search -->
                            <form action="{{ route('member.dashboard') }}" method="GET" x-data="{ searchOpen: '{{ request('search') }}' !== '' }" class="hidden sm:flex items-center">
                                <div @click.away="if($refs.searchInput.value === '') searchOpen = false"
                                    class="flex items-center bg-white dark:bg-[#1c1c1e] border border-slate-200 dark:border-white/10 shadow-sm rounded-xl overflow-hidden transition-all duration-300 ease-out"
                                    :class="searchOpen ? 'w-full sm:w-64 border-blue-400 ring-4 ring-blue-500/10' : 'w-10 border-slate-200/60 dark:border-white/10 hover:border-blue-300'">
                                    <button type="button" @click="if(!searchOpen) { searchOpen = true; $nextTick(() => $refs.searchInput.focus()) } else if ($refs.searchInput.value) { $el.closest('form').submit() }" 
                                            class="flex-shrink-0 w-10 h-10 flex items-center justify-center transition-colors bg-transparent z-10 cursor-pointer"
                                            :class="searchOpen ? 'text-blue-600' : 'text-slate-500 dark:text-slate-400 hover:text-blue-600'">
                                        <svg class="w-5 h-5 transition-transform duration-300 ease-out" :class="searchOpen ? 'scale-95' : 'scale-100 hover:scale-110'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </button>
                                    <input x-ref="searchInput" @keydown.enter="$el.closest('form').submit()" type="text" name="search" value="{{ request('search') }}" placeholder="Cari..." 
                                        class="bg-transparent border-none text-[13px] focus:ring-0 font-medium transition-all duration-300 ease-out flex-1 min-w-0"
                                        :class="searchOpen ? 'opacity-100 pr-3 pl-1 w-full translate-x-0' : 'opacity-0 w-0 p-0 -translate-x-2 pointer-events-none'">
                                </div>
                                <input type="hidden" name="tab" :value="activeTab">
                                @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                            </form>


                        </div>

                        <div class="flex items-center gap-3 w-full md:w-auto justify-end">
                            <!-- Sort Dropdown -->
                            <div class="relative hidden sm:block" x-data="{ open: false }">
                                <button @click="open = !open" @click.away="open = false" class="w-10 h-10 flex items-center justify-center bg-white dark:bg-[#1c1c1e] border border-slate-200/60 dark:border-white/10 shadow-sm text-slate-500 dark:text-slate-400 rounded-xl hover:text-blue-600 hover:border-blue-300 transition-colors group" title="Sortir">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                                </button>
                                
                                <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" style="display: none;" class="absolute right-0 mt-2 w-56 bg-white dark:bg-[#1c1c1e] rounded-2xl shadow-xl border border-slate-100 dark:border-white/10/50 z-50 overflow-hidden">
                                    <div class="px-4 py-3 text-[11px] font-black text-slate-400 uppercase tracking-[0.1em] bg-slate-50 dark:bg-[#1c1c1e]/50 border-b border-slate-100 dark:border-white/10/50">Sortir Berdasarkan</div>
                                    <div class="p-2">
                                        <a href="?tab={{ $activeTab }}&sort=latest&search={{ request('search') }}" class="flex items-center px-3 py-2.5 text-[13px] font-bold text-slate-700 dark:text-slate-200 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('sort') == 'latest' || !request('sort') ? 'text-blue-600 bg-blue-50/50' : '' }}">
                                            <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-2.5 opacity-0 {{ request('sort') == 'latest' || !request('sort') ? 'opacity-100' : '' }}"></div>
                                            Terbaru
                                        </a>
                                        <a href="?tab={{ $activeTab }}&sort=oldest&search={{ request('search') }}" class="flex items-center px-3 py-2.5 text-[13px] font-bold text-slate-700 dark:text-slate-200 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('sort') == 'oldest' ? 'text-blue-600 bg-blue-50/50' : '' }}">
                                            <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-2.5 opacity-0 {{ request('sort') == 'oldest' ? 'opacity-100' : '' }}"></div>
                                            Terlama
                                        </a>
                                        <template x-if="activeTab === 'kelas'">
                                            <div class="mt-1 pt-1 border-t border-slate-50">
                                                <a href="?tab={{ $activeTab }}&sort=name_asc&search={{ request('search') }}" class="flex items-center px-3 py-2.5 text-[13px] font-bold text-slate-700 dark:text-slate-200 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('sort') == 'name_asc' ? 'text-blue-600 bg-blue-50/50' : '' }}">
                                                    <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-2.5 opacity-0 {{ request('sort') == 'name_asc' ? 'opacity-100' : '' }}"></div>
                                                    Nama (A-Z)
                                                </a>
                                                <a href="?tab={{ $activeTab }}&sort=name_desc&search={{ request('search') }}" class="flex items-center px-3 py-2.5 text-[13px] font-bold text-slate-700 dark:text-slate-200 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('sort') == 'name_desc' ? 'text-blue-600 bg-blue-50/50' : '' }}">
                                                    <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-2.5 opacity-0 {{ request('sort') == 'name_desc' ? 'opacity-100' : '' }}"></div>
                                                    Nama (Z-A)
                                                </a>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <div class="hidden sm:block h-8 w-px bg-slate-200 mx-1"></div>

                            <!-- View Toggles -->
                            <div class="hidden sm:flex items-center bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-white/10 shadow-sm rounded-xl p-1">
                                <button @click="viewMode = 'grid'" :class="viewMode === 'grid' ? 'bg-slate-100 dark:bg-slate-800 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300'" class="w-8 h-8 flex items-center justify-center rounded-lg transition-all" title="Tampilan Kartu">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                </button>
                                <button @click="viewMode = 'list'" :class="viewMode === 'list' ? 'bg-slate-100 dark:bg-slate-800 text-blue-600 dark:text-blue-400 shadow-sm' : 'text-slate-400 dark:text-slate-500 hover:text-slate-600 dark:hover:text-slate-300'" class="w-8 h-8 flex items-center justify-center rounded-lg transition-all" title="Tampilan Daftar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Data Table Content -->
                    <div class="bg-transparent sm:bg-white dark:sm:bg-[#1c1c1e] dark:bg-[#1c1c1e] sm:rounded-[24px] border-0 sm:border border-slate-200/60 dark:border-white/10 sm:shadow-sm overflow-hidden mb-12">
                        <div class="overflow-x-auto">

                    <!-- TAB: KELAS -->
                    <div x-show="activeTab === 'kelas'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                        
                        <!-- KELAS BERLANGSUNG -->
                        <div class="hidden sm:block">
                            <div class="flex items-center justify-between mb-4 mt-2 px-5 pt-5">
                                <h3 class="text-[12px] font-black text-slate-400 uppercase tracking-widest">Kelas Berlangsung</h3>
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-[#1c1c1e]/50 text-slate-600 dark:text-slate-300 text-[11px] font-black">{{ $activeCourses->count() }}</span>
                            </div>
                            <!-- Grid View -->
                            <div x-show="viewMode === 'grid'" style="display: none;" class="hidden sm:grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 p-5 bg-slate-50/30 dark:bg-[#121214]/50">
                                @forelse($activeCourses as $enrollment)
                                    @php
                                        $course = $enrollment->course;
                                        $completedLessonCount = \App\Models\LessonProgress::where('enrollment_id', $enrollment->id)->where('is_completed', true)->count();
                                        $totalLessonsCount = $course->lessons->count();
                                        $latestLesson = $course->lessons->sortByDesc('created_at')->first();
                                        $latestassignment = $course->assignments->sortByDesc('created_at')->first();
                                        $nextLesson = $course->lessons->skip($completedLessonCount)->first() ?? $course->lessons->last();
                                    @endphp
                                    <div class="group bg-white dark:bg-[#1c1c1e] rounded-[32px] overflow-hidden border border-slate-200/70 dark:border-white/10 shadow-sm hover:shadow-2xl hover:border-blue-300/50 transition-all duration-500 flex flex-col relative cursor-pointer" @click="window.location.href = '{{ route('member.learning.show', $course->slug) }}'">
                                        <!-- Thumbnail Area -->
                                        <div class="aspect-[16/10] w-full bg-slate-100 dark:bg-[#1c1c1e]/50 relative overflow-hidden">
                                            <div class="absolute top-4 left-4 z-10">
                                                <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider bg-white dark:bg-[#1c1c1e]/90 text-blue-600 backdrop-blur-md shadow-sm border border-white/20">{{ $course->category->name ?? 'Kategori' }}</span>
                                            </div>
                                            
                                            @if($course->thumbnail)
                                                <img src="{{ Storage::url($course->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 ease-out">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-50">
                                                    <svg class="w-12 h-12 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                </div>
                                            @endif

                                            <!-- Progress Overlay -->
                                            <div class="absolute bottom-4 left-4 right-4 z-10">
                                                <div class="bg-slate-800/40 backdrop-blur-xl border border-white/20 rounded-2xl p-3 flex items-center justify-between">
                                                    <div class="flex-1 mr-4">
                                                        <div class="flex justify-between items-center mb-1.5">
                                                            <span class="text-[10px] font-bold text-white/80 tracking-wide">Progress Belajar</span>
                                                            <span class="text-[11px] font-black text-white">{{ $enrollment->progress }}%</span>
                                                        </div>
                                                        <div class="h-1.5 w-full bg-white dark:bg-[#121214]/20 rounded-full overflow-hidden">
                                                            <div class="h-full bg-gradient-to-r from-blue-400 to-cyan-300 shadow-[0_0_10px_rgba(56,189,248,0.5)] transition-all duration-1000" style="width: {{ $enrollment->progress }}%"></div>
                                                        </div>
                                                    </div>
                                                    <div class="shrink-0 w-10 h-10 rounded-xl bg-blue-500 flex items-center justify-center text-white shadow-lg">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path></svg>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="p-6 flex flex-col flex-1">
                                            <div class="flex items-center gap-2 mb-3">
                                                @if($course->mentor->avatar)
                                                    <img src="{{ Storage::url($course->mentor->avatar) }}" class="w-6 h-6 rounded-md object-cover">
                                                @else
                                                    <div class="w-6 h-6 rounded-md bg-indigo-100 text-indigo-600 flex items-center justify-center font-black text-[9px]">
                                                        {{ substr($course->mentor->name, 0, 1) }}
                                                    </div>
                                                @endif
                                                <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400">{{ $course->mentor->name }}</span>
                                            </div>
                                            <h3 class="font-black text-[17px] text-slate-800 dark:text-white leading-tight mb-5 line-clamp-2 group-hover:text-blue-600 transition-colors">{{ $course->title }}</h3>
                                            
                                            <!-- Detailed Info -->
                                            <div class="space-y-4">
                                                <!-- Materi Terbaru -->
                                                @if($latestLesson)
                                                <div class="flex items-start gap-3 p-3 rounded-2xl bg-blue-50/50 dark:bg-blue-900/20 border border-blue-100/50 dark:border-blue-800/30">
                                                    <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-500/20 flex items-center justify-center text-blue-600 dark:text-blue-400 shrink-0">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                    </div>
                                                    <div class="min-w-0">
                                                        <p class="text-[9px] font-black text-blue-400 uppercase tracking-widest leading-none mb-1">Materi Terbaru</p>
                                                        <p class="text-[12px] font-bold text-slate-700 dark:text-slate-200 truncate">{{ $latestLesson->title }}</p>
                                                        <p class="text-[10px] text-slate-400 mt-0.5">Diunggah: {{ $latestLesson->created_at->format('d M Y') }}</p>
                                                    </div>
                                                </div>
                                                @endif

                                                <!-- Tugas Terbaru -->
                                                @if($latestassignment)
                                                <div class="flex items-start gap-3 p-3 rounded-2xl bg-amber-50/50 dark:bg-amber-900/20 border border-amber-100/50 dark:border-amber-800/30">
                                                    <div class="w-8 h-8 rounded-lg bg-amber-100 dark:bg-amber-500/20 flex items-center justify-center text-amber-600 dark:text-amber-400 shrink-0">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                                    </div>
                                                    <div class="min-w-0">
                                                        <p class="text-[9px] font-black text-amber-500 uppercase tracking-widest leading-none mb-1">Tugas Terbaru</p>
                                                        <p class="text-[12px] font-bold text-slate-700 dark:text-slate-200 truncate">{{ $latestassignment->title }}</p>
                                                        <p class="text-[10px] text-amber-600/70 font-semibold mt-0.5 flex items-center gap-1">
                                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path></svg>
                                                            Deadline: Segera
                                                        </p>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>

                                            <div class="mt-8 pt-5 border-t border-slate-50 flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <div class="flex -space-x-2 mr-3">
                                                        @for($i=0; $i<min(3, $totalLessonsCount); $i++)
                                                            <div class="w-6 h-6 rounded-full border-2 border-white bg-slate-200 flex items-center justify-center text-[8px] font-bold text-slate-500 dark:text-slate-400 uppercase">{{ $i+1 }}</div>
                                                        @endfor
                                                    </div>
                                                    <span class="text-[11px] font-bold text-slate-400">{{ $completedLessonCount }} / {{ $totalLessonsCount }} Selesai</span>
                                                </div>
                                                <div class="text-[11px] font-black text-blue-600 flex items-center gap-1 group-hover:gap-2 transition-all">
                                                    Lanjut
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-span-full py-20 bg-white dark:bg-[#1c1c1e] rounded-[40px] border-2 border-dashed border-slate-200 dark:border-white/10 flex flex-col items-center justify-center text-center">
                                        <div class="w-20 h-20 bg-slate-50 dark:bg-[#1c1c1e] rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        </div>
                                        <h3 class="text-lg font-black text-slate-800 dark:text-white">Belum ada kelas aktif</h3>
                                        <p class="text-slate-500 dark:text-slate-400 max-w-xs mt-2 text-sm">Ayo mulai belajar hari ini dan tingkatkan skill kamu!</p>
                                        <a href="{{ route('courses.index') }}" class="mt-6 px-6 py-3 bg-blue-600 text-white rounded-2xl font-bold text-sm hover:bg-blue-700 transition-colors shadow-lg shadow-blue-500/20">Cari Kelas Baru</a>
                                    </div>
                                @endforelse
                            </div>

                            <!-- List View -->
                            <div x-show="viewMode === 'list'" style="display: none;" class="hidden sm:flex flex-col gap-3 p-5 bg-slate-50/30 dark:bg-[#121214]/50">
                                @forelse($activeCourses as $enrollment)
                                    @php
                                        $course = $enrollment->course;
                                        $completedLessonCount = \App\Models\LessonProgress::where('enrollment_id', $enrollment->id)->where('is_completed', true)->count();
                                        $totalLessonsCount = $course->lessons->count();
                                    @endphp
                                    <div class="group bg-white dark:bg-[#1c1c1e] rounded-3xl border border-slate-200/60 dark:border-white/10 shadow-sm hover:shadow-xl transition-all duration-500 p-4 flex flex-col sm:flex-row items-center gap-6 cursor-pointer" @click="window.location.href = '{{ route('member.learning.show', $course->slug) }}'">
                                        <div class="w-full sm:w-48 aspect-[16/10] rounded-2xl bg-slate-100 dark:bg-[#1c1c1e]/50 overflow-hidden shrink-0 relative">
                                            @if($course->thumbnail)
                                                <img src="{{ Storage::url($course->thumbnail) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                            @endif
                                            <div class="absolute inset-0 bg-slate-800/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                                <div class="w-10 h-10 rounded-full bg-white dark:bg-[#1c1c1e]/90 text-blue-600 flex items-center justify-center shadow-lg">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path></svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 mb-2">
                                                <span class="px-2 py-0.5 rounded-lg bg-blue-50 text-blue-600 text-[10px] font-black uppercase tracking-wider">{{ $course->category->name ?? 'Kategori' }}</span>
                                                <div class="w-1 h-1 rounded-full bg-slate-300"></div>
                                                <div class="flex items-center gap-1.5">
                                                    @if($course->mentor->avatar)
                                                        <img src="{{ Storage::url($course->mentor->avatar) }}" class="w-4 h-4 rounded-sm object-cover">
                                                    @else
                                                        <div class="w-4 h-4 rounded-sm bg-indigo-100 text-indigo-600 flex items-center justify-center font-black text-[7px]">
                                                            {{ substr($course->mentor->name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                    <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400">{{ $course->mentor->name }}</span>
                                                </div>
                                            </div>
                                            <h3 class="font-black text-[18px] text-slate-800 dark:text-white leading-tight mb-4 truncate group-hover:text-blue-600 transition-colors">{{ $course->title }}</h3>
                                            <div class="flex items-center gap-4">
                                                <div class="flex-1 max-w-[200px]">
                                                    <div class="flex justify-between items-center mb-1.5">
                                                        <span class="text-[10px] font-bold text-slate-400">Progress</span>
                                                        <span class="text-[11px] font-black text-blue-600">{{ $enrollment->progress }}%</span>
                                                    </div>
                                                    <div class="h-1.5 w-full bg-slate-100 dark:bg-[#1c1c1e]/50 rounded-full overflow-hidden">
                                                        <div class="h-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.4)]" style="width: {{ $enrollment->progress }}%"></div>
                                                    </div>
                                                </div>
                                                <div class="h-8 w-px bg-slate-100 dark:bg-[#1c1c1e]/50"></div>
                                                <div class="flex flex-col">
                                                    <span class="text-[11px] font-black text-slate-700 dark:text-slate-200">{{ $completedLessonCount }} / {{ $totalLessonsCount }}</span>
                                                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Materi Selesai</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="hidden lg:flex items-center justify-center pr-2 shrink-0">
                                            <div class="w-12 h-12 rounded-full bg-slate-50 dark:bg-[#1c1c1e] flex items-center justify-center text-slate-300 group-hover:bg-blue-600 group-hover:text-white group-hover:shadow-lg group-hover:shadow-blue-500/30 transition-all duration-300">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-12 bg-white dark:bg-[#1c1c1e] rounded-3xl border border-slate-100 dark:border-white/10/50">
                                        <h3 class="text-sm font-bold text-slate-800 dark:text-white">Belum ada kelas aktif</h3>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Mobile View (Compact Cards) -->
                            <div class="sm:hidden flex flex-col gap-3">
                                @forelse($activeCourses as $enrollment)
                                    @php
                                        $course = $enrollment->course;
                                        $completedLessonCount = \App\Models\LessonProgress::where('enrollment_id', $enrollment->id)->where('is_completed', true)->count();
                                        $totalLessonsCount = $course->lessons->count();
                                    @endphp
                                    <div class="bg-white dark:bg-[#1c1c1e] rounded-2xl p-3 border border-slate-200/80 shadow-sm flex items-center gap-3 cursor-pointer hover:border-blue-300/50 transition-colors" @click="window.location.href = '{{ route('member.learning.show', $course->slug) }}'">
                                        <div class="w-16 h-16 rounded-xl bg-slate-100 dark:bg-[#1c1c1e]/50 overflow-hidden shrink-0 relative">
                                            @if($course->thumbnail)
                                                <img src="{{ Storage::url($course->thumbnail) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-50">
                                                    <svg class="w-6 h-6 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-1.5 mb-0.5">
                                                <span class="px-1.5 py-0.5 rounded-md bg-blue-50 text-blue-600 text-[9px] font-black uppercase tracking-wider">{{ $course->category->name ?? 'Kategori' }}</span>
                                                <span class="text-[9px] font-bold text-slate-400 truncate max-w-[80px]">• {{ $course->mentor->name }}</span>
                                            </div>
                                            <h4 class="font-extrabold text-[13px] text-slate-800 dark:text-white leading-tight mb-1 truncate">{{ $course->title }}</h4>
                                            <div class="flex items-center justify-between text-[10px] font-bold text-slate-500 dark:text-slate-400">
                                                <span class="text-slate-400 font-semibold">{{ $completedLessonCount }}/{{ $totalLessonsCount }} Selesai</span>
                                                <span class="text-blue-600 font-black">{{ $enrollment->progress }}%</span>
                                            </div>
                                            <div class="h-1 w-full bg-slate-100 dark:bg-[#1c1c1e]/50 rounded-full mt-1 overflow-hidden">
                                                <div class="h-full bg-blue-500 shadow-[0_0_6px_rgba(59,130,246,0.4)]" style="width: {{ $enrollment->progress }}%"></div>
                                            </div>
                                        </div>
                                        <div class="shrink-0 w-8 h-8 rounded-full bg-slate-50 dark:bg-[#1c1c1e] flex items-center justify-center text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                        </div>
                                    </div>
                                @empty
                                    <div class="py-12 bg-white dark:bg-[#1c1c1e] rounded-2xl border-2 border-dashed border-slate-200 dark:border-white/10 flex flex-col items-center justify-center text-center p-4">
                                        <h3 class="text-sm font-bold text-slate-800 dark:text-white">Belum ada kelas aktif</h3>
                                        <a href="{{ route('courses.index') }}" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-xl font-bold text-xs shadow-md shadow-blue-500/10">Cari Kelas Baru</a>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- KELAS SELESAI -->
                        <div class="hidden sm:block">
                            <div class="flex items-center justify-between mb-4 mt-6 px-5 pt-5 border-t border-slate-100 dark:border-white/10/50">
                                <h3 class="text-[12px] font-black text-slate-400 uppercase tracking-widest">Riwayat Belajar</h3>
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-[#1c1c1e]/50 text-slate-600 dark:text-slate-300 text-[11px] font-black">{{ $completedCourses->count() }}</span>
                            </div>
                            <!-- Grid View -->
                            <div x-show="viewMode === 'grid'" style="display: none;" class="hidden sm:grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 p-5 bg-slate-50/30 dark:bg-[#121214]/50">
                                @forelse($completedCourses as $enrollment)
                                    @php $course = $enrollment->course; @endphp
                                    <div class="group bg-white dark:bg-[#1c1c1e] rounded-[32px] overflow-hidden border border-slate-200/60 dark:border-white/10 shadow-sm hover:shadow-2xl hover:border-emerald-300 transition-all duration-500 flex flex-col relative cursor-pointer" @click="window.location.href = '{{ route('member.learning.show', $course->slug) }}'">
                                        <!-- Thumbnail Area -->
                                        <div class="aspect-[16/10] w-full bg-slate-100 dark:bg-[#1c1c1e]/50 relative overflow-hidden grayscale group-hover:grayscale-0 transition-all duration-700">
                                            <div class="absolute inset-0 bg-emerald-600/10 mix-blend-multiply opacity-60"></div>
                                            <div class="absolute top-4 left-4 z-10">
                                                <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider bg-emerald-500 text-white shadow-lg border border-emerald-400/30 flex items-center gap-1.5">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                    LULUS
                                                </span>
                                            </div>
                                            
                                            @if($course->thumbnail)
                                                <img src="{{ Storage::url($course->thumbnail) }}" class="w-full h-full object-cover">
                                            @endif

                                            <div class="absolute inset-0 bg-emerald-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex flex-col items-center justify-center p-6 text-center">
                                                <div class="w-16 h-16 bg-white dark:bg-[#121214]/20 backdrop-blur-md rounded-full flex items-center justify-center text-white mb-4 border border-white/30 scale-50 group-hover:scale-100 transition-transform duration-500">
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </div>
                                                <p class="text-white font-black text-sm tracking-tight">LIHAT SERTIFIKAT</p>
                                            </div>
                                        </div>

                                        <div class="p-6 flex flex-col flex-1">
                                            <div class="flex items-center gap-2 mb-3">
                                                @if($course->mentor->avatar)
                                                    <img src="{{ Storage::url($course->mentor->avatar) }}" class="w-6 h-6 rounded-md object-cover grayscale opacity-80">
                                                @else
                                                    <div class="w-6 h-6 rounded-md bg-slate-100 dark:bg-[#1c1c1e]/50 text-slate-500 dark:text-slate-400 flex items-center justify-center font-black text-[9px]">
                                                        {{ substr($course->mentor->name, 0, 1) }}
                                                    </div>
                                                @endif
                                                <span class="text-[11px] font-bold text-slate-500 dark:text-slate-400">{{ $course->mentor->name }}</span>
                                            </div>
                                            <h3 class="font-black text-[17px] text-slate-800 dark:text-white leading-tight mb-4 line-clamp-2 group-hover:text-emerald-600 transition-colors">{{ $course->title }}</h3>
                                            <div class="mt-auto flex items-center justify-between text-[11px] font-bold">
                                                <span class="text-slate-400">Selesai pada:</span>
                                                <span class="text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg">{{ $enrollment->completed_at ? $enrollment->completed_at->format('d M Y') : $enrollment->updated_at->format('d M Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-span-full py-20 bg-slate-50 dark:bg-[#1c1c1e] rounded-[40px] border-2 border-dashed border-slate-200 dark:border-white/10 flex flex-col items-center justify-center text-center">
                                        <h3 class="text-lg font-black text-slate-800 dark:text-white">Belum ada kelas yang selesai</h3>
                                    </div>
                                @endforelse
                            </div>

                            <!-- List View -->
                            <div x-show="viewMode === 'list'" style="display: none;" class="hidden sm:flex flex-col gap-3 p-5 bg-slate-50/30 dark:bg-[#121214]/50">
                                @forelse($completedCourses as $enrollment)
                                    @php $course = $enrollment->course; @endphp
                                    <div class="group bg-white dark:bg-[#1c1c1e] rounded-3xl border border-slate-200/60 dark:border-white/10 shadow-sm hover:shadow-xl transition-all duration-500 p-4 flex flex-col sm:flex-row items-center gap-6 cursor-pointer" @click="window.location.href = '{{ route('member.learning.show', $course->slug) }}'">
                                        <div class="w-full sm:w-48 aspect-[16/10] rounded-2xl bg-slate-100 dark:bg-[#1c1c1e]/50 overflow-hidden shrink-0 relative grayscale hover:grayscale-0">
                                            @if($course->thumbnail)
                                                <img src="{{ Storage::url($course->thumbnail) }}" class="w-full h-full object-cover">
                                            @endif
                                            <div class="absolute inset-0 bg-emerald-600/20 mix-blend-multiply opacity-60"></div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 mb-2">
                                                <span class="px-2 py-0.5 rounded-lg bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-wider">Lulus</span>
                                                <div class="w-1 h-1 rounded-full bg-slate-300"></div>
                                                <div class="flex items-center gap-1.5">
                                                    @if($course->mentor->avatar)
                                                        <img src="{{ Storage::url($course->mentor->avatar) }}" class="w-4 h-4 rounded-sm object-cover grayscale opacity-80">
                                                    @else
                                                        <div class="w-4 h-4 rounded-sm bg-slate-100 dark:bg-[#1c1c1e]/50 text-slate-500 dark:text-slate-400 flex items-center justify-center font-black text-[7px]">
                                                            {{ substr($course->mentor->name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                    <span class="text-[10px] font-bold text-slate-500 dark:text-slate-400">{{ $course->mentor->name }}</span>
                                                </div>
                                            </div>
                                            <h3 class="font-black text-[18px] text-slate-800 dark:text-white leading-tight mb-2 truncate group-hover:text-emerald-600 transition-colors">{{ $course->title }}</h3>
                                            <p class="text-[12px] font-bold text-slate-400">Selesai pada: <span class="text-slate-600 dark:text-slate-300">{{ $enrollment->completed_at ? $enrollment->completed_at->format('d M Y') : $enrollment->updated_at->format('d M Y') }}</span></p>
                                        </div>
                                        <div class="hidden lg:flex items-center justify-center pr-2 shrink-0">
                                            <div class="w-12 h-12 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-500 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-12">
                                        <h3 class="text-sm font-bold text-slate-800 dark:text-white">Belum ada kelas yang selesai</h3>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Mobile View (Compact Cards) -->
                            <div class="sm:hidden flex flex-col gap-3">
                                @forelse($completedCourses as $enrollment)
                                    @php $course = $enrollment->course; @endphp
                                    <div class="bg-white dark:bg-[#1c1c1e] rounded-2xl p-3 border border-slate-200/80 shadow-sm flex items-center gap-3 cursor-pointer hover:border-emerald-300 transition-colors" @click="window.location.href = '{{ route('member.learning.show', $course->slug) }}'">
                                        <div class="w-16 h-16 rounded-xl bg-slate-100 dark:bg-[#1c1c1e]/50 overflow-hidden shrink-0 relative grayscale">
                                            <div class="absolute inset-0 bg-emerald-600/10 mix-blend-multiply opacity-60"></div>
                                            @if($course->thumbnail)
                                                <img src="{{ Storage::url($course->thumbnail) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-50">
                                                    <svg class="w-6 h-6 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between mb-0.5">
                                                <span class="px-1.5 py-0.5 rounded-md bg-emerald-50 text-emerald-600 text-[9px] font-black uppercase tracking-wider">Lulus</span>
                                                <span class="text-[9px] font-bold text-slate-400">{{ $enrollment->completed_at ? $enrollment->completed_at->format('d M Y') : $enrollment->updated_at->format('d M Y') }}</span>
                                            </div>
                                            <h4 class="font-extrabold text-[13px] text-slate-800 dark:text-white leading-tight mb-1 truncate">{{ $course->title }}</h4>
                                            <p class="text-[10px] font-bold text-slate-400 truncate">Mentor: {{ $course->mentor->name }}</p>
                                        </div>
                                        <div class="shrink-0 w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center text-emerald-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        </div>
                                    </div>
                                @empty
                                    <div class="py-12 bg-slate-50 dark:bg-[#1c1c1e] rounded-2xl border-2 border-dashed border-slate-200 dark:border-white/10 flex flex-col items-center justify-center text-center p-4">
                                        <h3 class="text-sm font-bold text-slate-800 dark:text-white">Belum ada kelas yang selesai</h3>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Mobile View (Grouped Lists) -->
                        <div class="sm:hidden flex flex-col gap-6 mb-6">
                            
                            <!-- Kelas Berlangsung Section -->
                            <div>
                                <div class="flex items-center justify-between mb-3 mt-1">
                                    <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Kelas Berlangsung</h3>
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 dark:bg-[#1c1c1e]/50 text-slate-600 dark:text-slate-300 text-[10px] font-black">{{ $activeCourses->count() }}</span>
                                </div>
                                
                                <div class="flex flex-col gap-3">
                                    @forelse($activeCourses as $enrollment)
                                        @php
                                            $course = $enrollment->course;
                                            $completedLessonCount = \App\Models\LessonProgress::where('enrollment_id', $enrollment->id)->where('is_completed', true)->count();
                                            $totalLessonsCount = $course->lessons->count();
                                        @endphp
                                        <div class="bg-white dark:bg-[#1c1c1e] rounded-2xl p-3 border border-slate-200/80 shadow-sm flex items-center gap-3 cursor-pointer hover:border-blue-300/50 transition-colors" @click="window.location.href = '{{ route('member.learning.show', $course->slug) }}'">
                                            <div class="w-16 h-16 rounded-xl bg-slate-100 dark:bg-[#1c1c1e]/50 overflow-hidden shrink-0 relative">
                                                @if($course->thumbnail)
                                                    <img src="{{ Storage::url($course->thumbnail) }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-50">
                                                        <svg class="w-6 h-6 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center gap-1.5 mb-0.5">
                                                    <span class="px-1.5 py-0.5 rounded-md bg-blue-50 text-blue-600 text-[9px] font-black uppercase tracking-wider">{{ $course->category->name ?? 'Kategori' }}</span>
                                                    <span class="text-[9px] font-bold text-slate-400 truncate max-w-[80px]">• {{ $course->mentor->name }}</span>
                                                </div>
                                                <h4 class="font-extrabold text-[13px] text-slate-800 dark:text-white leading-tight mb-1 truncate">{{ $course->title }}</h4>
                                                <div class="flex items-center justify-between text-[10px] font-bold text-slate-500 dark:text-slate-400">
                                                    <span class="text-slate-400 font-semibold">{{ $completedLessonCount }}/{{ $totalLessonsCount }} Selesai</span>
                                                    <span class="text-blue-600 font-black">{{ $enrollment->progress }}%</span>
                                                </div>
                                                <div class="h-1 w-full bg-slate-100 dark:bg-[#1c1c1e]/50 rounded-full mt-1 overflow-hidden">
                                                    <div class="h-full bg-blue-500 shadow-[0_0_6px_rgba(59,130,246,0.4)]" style="width: {{ $enrollment->progress }}%"></div>
                                                </div>
                                            </div>
                                            <div class="shrink-0 w-8 h-8 rounded-full bg-slate-50 dark:bg-[#1c1c1e] flex items-center justify-center text-slate-400">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="py-6 bg-white dark:bg-[#1c1c1e] rounded-2xl border-2 border-dashed border-slate-200 dark:border-white/10 flex flex-col items-center justify-center text-center p-4">
                                            <p class="text-xs font-bold text-slate-400">Belum ada kelas berlangsung</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Riwayat Belajar Section -->
                            <div>
                                <div class="flex items-center justify-between mb-3 mt-2">
                                    <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Riwayat Belajar</h3>
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 dark:bg-[#1c1c1e]/50 text-slate-600 dark:text-slate-300 text-[10px] font-black">{{ $completedCourses->count() }}</span>
                                </div>
                                
                                <div class="flex flex-col gap-3">
                                    @forelse($completedCourses as $enrollment)
                                        @php 
                                            $course = $enrollment->course; 
                                            $certificate = $userCertificates->get($course->id);
                                            $hasTestimonial = $userTestimonials->has($course->id);
                                        @endphp
                                        <div class="bg-white dark:bg-[#1c1c1e] rounded-2xl p-3 border border-slate-200/80 shadow-sm flex items-center gap-3 cursor-pointer hover:border-emerald-300 transition-colors" @click="window.location.href = '{{ route('member.learning.show', $course->slug) }}'">
                                            <div class="w-16 h-16 rounded-xl bg-slate-100 dark:bg-[#1c1c1e]/50 overflow-hidden shrink-0 relative grayscale">
                                                <div class="absolute inset-0 bg-emerald-600/10 mix-blend-multiply opacity-60"></div>
                                                @if($course->thumbnail)
                                                    <img src="{{ Storage::url($course->thumbnail) }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-50">
                                                        <svg class="w-6 h-6 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center justify-between mb-0.5">
                                                    <span class="px-1.5 py-0.5 rounded-md bg-emerald-50 text-emerald-600 text-[9px] font-black uppercase tracking-wider">Lulus</span>
                                                    <span class="text-[9px] font-bold text-slate-400">{{ $enrollment->completed_at ? $enrollment->completed_at->format('d M Y') : $enrollment->updated_at->format('d M Y') }}</span>
                                                </div>
                                                <h4 class="font-extrabold text-[13px] text-slate-800 dark:text-white leading-tight mb-1 truncate">{{ $course->title }}</h4>
                                                <p class="text-[10px] font-bold text-slate-400 truncate">Mentor: {{ $course->mentor->name }}</p>
                                            </div>
                                            <div class="shrink-0">
                                                @if($certificate)
                                                    @if($hasTestimonial)
                                                        <a href="{{ route('member.certificates.download', $certificate) }}" 
                                                           @click.stop
                                                           class="inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-[10px] font-black uppercase tracking-wider transition-all shadow-sm">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"></path></svg>
                                                            Unduh Sertifikat
                                                        </a>
                                                    @else
                                                        <a href="{{ route('member.testimonials.index', ['type' => 'course', 'id' => $course->id]) }}" 
                                                           @click.stop
                                                           class="inline-flex items-center justify-center gap-1.5 px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-[10px] font-black uppercase tracking-wider transition-all shadow-sm"
                                                           title="Silakan berikan ulasan kursus terlebih dahulu untuk mengunduh sertifikat">
                                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3h9m-9 3h9m-9 3h9M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"></path></svg>
                                                            Beri Ulasan
                                                        </a>
                                                    @endif
                                                @else
                                                    <span class="inline-flex items-center justify-center gap-1 px-2.5 py-1.5 bg-slate-100 dark:bg-zinc-800 text-slate-500 dark:text-slate-400 rounded-xl text-[10px] font-black uppercase tracking-wider">
                                                        Proses
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <div class="py-6 bg-slate-50 dark:bg-[#1c1c1e] rounded-2xl border-2 border-dashed border-slate-200 dark:border-white/10 flex flex-col items-center justify-center text-center p-4">
                                            <p class="text-xs font-bold text-slate-400">Belum ada riwayat kelas</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    <!-- TAB: LAYANAN -->
                    <div x-show="activeTab === 'layanan'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                        
                        <!-- LAYANAN BERLANGSUNG -->
                        <div class="hidden sm:block">
                            <div class="flex items-center justify-between mb-4 mt-2 px-5 pt-5">
                                <h3 class="text-[12px] font-black text-slate-400 uppercase tracking-widest">Layanan Berlangsung</h3>
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-[#1c1c1e]/50 text-slate-600 dark:text-slate-300 text-[11px] font-black">{{ $activeOrders->count() }}</span>
                            </div>
                            <!-- Grid View -->
                            <div x-show="viewMode === 'grid'" style="display: none;" class="hidden sm:grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 p-5 bg-slate-50/30 dark:bg-[#121214]/50">
                                @forelse($activeOrders as $order)
                                    @php
                                        $project = $order->project;
                                        $statusColor = match($order->status) {
                                            'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                                            'processing' => 'bg-blue-100 text-blue-700 border-blue-200',
                                            default => 'bg-slate-100 dark:bg-[#1c1c1e]/50 text-slate-700 dark:text-slate-200 border-slate-200 dark:border-white/10'
                                        };
                                        $statusText = match($order->status) {
                                            'pending' => 'Menunggu Pembayaran',
                                            'processing' => 'Proyek Berjalan',
                                            default => ucfirst($order->status)
                                        };
                                    @endphp
                                    <div class="group bg-white dark:bg-[#1c1c1e] rounded-[32px] overflow-hidden border border-slate-200/60 dark:border-white/10 shadow-sm hover:shadow-2xl hover:border-blue-300/50 transition-all duration-500 flex flex-col relative cursor-pointer" @click="window.location.href = '{{ route('member.orders.show', $order->order_number) }}'">
                                        <div class="p-7 flex flex-col flex-1">
                                            <div class="flex justify-between items-start mb-6">
                                                <div class="flex flex-col">
                                                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">{{ $order->order_number }}</span>
                                                    <span class="text-[11px] font-bold text-slate-400">{{ $order->created_at->format('d M Y') }}</span>
                                                </div>
                                                <span class="px-3 py-1.5 rounded-xl text-[10px] font-black border {{ $statusColor }}">{{ $statusText }}</span>
                                            </div>
                                            
                                            <h3 class="font-black text-[18px] text-slate-800 dark:text-white leading-tight mb-2 group-hover:text-blue-600 transition-colors">{{ $order->service->title ?? 'Layanan Kustom' }}</h3>
                                            <p class="text-[13px] font-bold text-blue-500/80 mb-8">{{ $order->package_name ?? 'Paket Kustom' }}</p>
                                            
                                            @if($project)
                                                <div class="mt-auto pt-6 border-t border-slate-50">
                                                    <div class="bg-slate-50 dark:bg-[#1c1c1e] rounded-2xl p-4">
                                                        <div class="flex justify-between items-center mb-3">
                                                            <div class="flex items-center gap-2">
                                                                <div class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></div>
                                                                <span class="text-[11px] font-black text-slate-700 dark:text-slate-200 uppercase tracking-wide">Progres Proyek</span>
                                                            </div>
                                                            <span class="text-[13px] font-black text-blue-600">{{ $project->progress }}%</span>
                                                        </div>
                                                        <div class="h-2 w-full bg-white dark:bg-[#1c1c1e] rounded-full overflow-hidden mb-3 border border-slate-100 dark:border-white/10/50">
                                                            <div class="h-full bg-gradient-to-r from-blue-500 to-indigo-500 shadow-[0_0_8px_rgba(59,130,246,0.5)] transition-all duration-1000" style="width: {{ $project->progress }}%"></div>
                                                        </div>
                                                        <div class="flex items-center justify-between text-[11px] font-bold">
                                                            <span class="text-slate-400">Deadline:</span>
                                                            <span class="text-slate-700 dark:text-slate-200">{{ $project->deadline ? $project->deadline->format('d M Y') : 'Menunggu' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="mt-auto pt-6 border-t border-slate-50 flex flex-col items-center justify-center py-4 bg-slate-50 dark:bg-[#1c1c1e]/50 rounded-2xl border-2 border-dashed border-slate-100 dark:border-white/10/50">
                                                    <p class="text-[11px] text-slate-400 font-bold italic">Menunggu inisiasi proyek...</p>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-[100px] -mr-16 -mt-16 group-hover:w-40 group-hover:h-40 transition-all duration-500 -z-0"></div>
                                    </div>
                                @empty
                                    <div class="col-span-full py-16 bg-white dark:bg-[#1c1c1e] rounded-[32px] border-2 border-dashed border-slate-200 dark:border-white/10 flex flex-col items-center justify-center text-center p-6 shadow-sm">
                                        <h3 class="text-sm font-bold text-slate-800 dark:text-white">Belum ada layanan aktif</h3>
                                        <p class="text-xs font-semibold text-slate-400 mt-2">Tekan + untuk menambahkan layanan</p>
                                    </div>
                                @endforelse
                            </div>

                            <!-- List View -->
                            <div x-show="viewMode === 'list'" style="display: none;" class="hidden sm:flex flex-col gap-3 p-5 bg-slate-50/30 dark:bg-[#121214]/50">
                                @forelse($activeOrders as $order)
                                    @php $project = $order->project; @endphp
                                    <div class="group bg-white dark:bg-[#1c1c1e] rounded-3xl border border-slate-200/60 dark:border-white/10 shadow-sm hover:shadow-xl transition-all duration-500 p-5 flex flex-col sm:flex-row items-center gap-6 cursor-pointer" @click="window.location.href = '{{ route('member.orders.show', $order->order_number) }}'">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-3 mb-2">
                                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-[#1c1c1e]/50 text-slate-500 dark:text-slate-400 text-[10px] font-black uppercase tracking-wider">{{ $order->order_number }}</span>
                                                <span class="text-[11px] font-bold text-slate-400">{{ $order->created_at->format('d M Y') }}</span>
                                            </div>
                                            <h3 class="font-black text-[18px] text-slate-800 dark:text-white leading-tight mb-1 truncate group-hover:text-blue-600 transition-colors">{{ $order->service->title ?? 'Layanan Kustom' }}</h3>
                                            <p class="text-[12px] font-bold text-slate-400">{{ $order->package_name ?? 'Paket Kustom' }}</p>
                                        </div>
                                        <div class="w-full sm:w-72 shrink-0 flex flex-col sm:items-end justify-center">
                                            @php
                                                $statusColor = match($order->status) {
                                                    'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                                    'processing' => 'bg-blue-50 text-blue-600 border-blue-100',
                                                    default => 'bg-slate-50 dark:bg-[#1c1c1e] text-slate-600 dark:text-slate-300 border-slate-100 dark:border-white/10/50'
                                                };
                                            @endphp
                                            <span class="px-4 py-1.5 rounded-xl text-[10px] font-black border {{ $statusColor }} mb-4">{{ strtoupper($order->status) }}</span>
                                            
                                            @if($order->project)
                                                <div class="w-full sm:w-48">
                                                    <div class="flex justify-between items-center mb-1.5">
                                                        <span class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase">Progress</span>
                                                        <span class="text-[11px] font-black text-blue-600">{{ $order->project->progress }}%</span>
                                                    </div>
                                                    <div class="h-2 w-full bg-slate-100 dark:bg-[#1c1c1e]/50 rounded-full overflow-hidden">
                                                        <div class="h-full bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.3)]" style="width: {{ $order->project->progress }}%"></div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="hidden lg:flex items-center justify-center pr-2 shrink-0">
                                            <div class="w-12 h-12 rounded-full bg-slate-50 dark:bg-[#1c1c1e] flex items-center justify-center text-slate-300 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-12 bg-white dark:bg-[#1c1c1e] rounded-3xl border border-slate-100 dark:border-white/10/50 p-4 shadow-sm">
                                        <h3 class="text-sm font-bold text-slate-800 dark:text-white">Belum ada layanan aktif</h3>
                                        <p class="text-xs font-semibold text-slate-400 mt-2">Tekan + untuk menambahkan layanan</p>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Mobile View (Compact Cards) -->
                            <div class="sm:hidden flex flex-col gap-3">
                                @forelse($activeOrders as $order)
                                    @php
                                        $project = $order->project;
                                        $statusColor = match($order->status) {
                                            'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                            'processing' => 'bg-blue-50 text-blue-600 border-blue-100',
                                            default => 'bg-slate-50 dark:bg-[#1c1c1e] text-slate-600 dark:text-slate-300 border-slate-100 dark:border-white/10/50'
                                        };
                                        $statusText = match($order->status) {
                                            'pending' => 'Pending',
                                            'processing' => 'Berjalan',
                                            default => ucfirst($order->status)
                                        };
                                    @endphp
                                    <div class="bg-white dark:bg-[#1c1c1e] rounded-2xl p-3 border border-slate-200/80 shadow-sm flex items-center gap-3 cursor-pointer hover:border-blue-300/50 transition-colors" @click="window.location.href = '{{ route('member.orders.show', $order->order_number) }}'">
                                        <div class="w-12 h-12 rounded-xl bg-slate-50 dark:bg-[#1c1c1e] text-slate-500 dark:text-slate-400 border border-slate-200/40 flex flex-col items-center justify-center shrink-0">
                                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between mb-0.5">
                                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $order->order_number }}</span>
                                                <span class="px-1.5 py-0.5 rounded-md text-[8px] font-black border {{ $statusColor }}">{{ $statusText }}</span>
                                            </div>
                                            <h4 class="font-extrabold text-[13px] text-slate-800 dark:text-white leading-tight truncate">{{ $order->service->title ?? 'Layanan Kustom' }}</h4>
                                            @if($project)
                                                <div class="flex items-center justify-between text-[10px] font-bold text-slate-500 dark:text-slate-400 mt-1">
                                                    <span class="text-slate-400">Progress Proyek</span>
                                                    <span class="text-blue-600 font-black">{{ $project->progress }}%</span>
                                                </div>
                                                <div class="h-1 w-full bg-slate-100 dark:bg-[#1c1c1e]/50 rounded-full mt-1 overflow-hidden">
                                                    <div class="h-full bg-blue-500" style="width: {{ $project->progress }}%"></div>
                                                </div>
                                            @else
                                                <p class="text-[10px] text-slate-400 font-bold italic mt-1">Menunggu inisiasi proyek...</p>
                                            @endif
                                        </div>
                                        <div class="shrink-0 w-8 h-8 rounded-full bg-slate-50 dark:bg-[#1c1c1e] flex items-center justify-center text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                        </div>
                                    </div>
                                @empty
                                    <div class="py-12 bg-white dark:bg-[#1c1c1e] rounded-2xl border-2 border-dashed border-slate-200 dark:border-white/10 flex flex-col items-center justify-center text-center p-4">
                                        <h3 class="text-sm font-bold text-slate-800 dark:text-white">Belum ada layanan aktif</h3>
                                        <a href="{{ route('services.index') }}" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-xl font-bold text-xs shadow-md shadow-blue-500/10">Pesan Layanan Sekarang</a>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- LAYANAN SELESAI -->
                        <div class="hidden sm:block">
                            <div class="flex items-center justify-between mb-4 mt-6 px-5 pt-5 border-t border-slate-100 dark:border-white/10/50">
                                <h3 class="text-[12px] font-black text-slate-400 uppercase tracking-widest">Riwayat Layanan</h3>
                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-[#1c1c1e]/50 text-slate-600 dark:text-slate-300 text-[11px] font-black">{{ $completedOrders->count() }}</span>
                            </div>
                            <!-- Grid View -->
                            <div x-show="viewMode === 'grid'" style="display: none;" class="hidden sm:grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 p-5 bg-slate-50/30 dark:bg-[#121214]/50">
                                @forelse($completedOrders as $order)
                                    <div class="group bg-white dark:bg-[#1c1c1e] rounded-[32px] overflow-hidden border border-slate-200/60 dark:border-white/10 shadow-sm hover:shadow-2xl transition-all duration-500 flex flex-col relative cursor-pointer opacity-80 hover:opacity-100" @click="window.location.href = '{{ route('member.orders.show', $order->order_number) }}'">
                                        <div class="p-7 flex flex-col flex-1">
                                            <div class="flex justify-between items-start mb-6">
                                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $order->order_number }}</span>
                                                <span class="px-3 py-1.5 rounded-xl text-[10px] font-black {{ $order->status == 'completed' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-red-50 text-red-600 border border-red-100' }}">{{ $order->status == 'completed' ? 'SELESAI' : 'BATAL' }}</span>
                                            </div>
                                            <h3 class="font-black text-[18px] text-slate-800 dark:text-white leading-tight mb-2">{{ $order->service->title ?? 'Layanan Kustom' }}</h3>
                                            <p class="text-[12px] font-bold text-slate-400 mb-6 line-clamp-2">{{ $order->package_name ?? 'Paket Kustom' }}</p>
                                            <div class="mt-auto pt-5 border-t border-slate-50 flex items-center justify-between text-[11px] font-bold">
                                                <span class="text-slate-400">Tanggal:</span>
                                                <span class="text-slate-700 dark:text-slate-200">{{ $order->updated_at->format('d M Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-span-full py-20 bg-slate-50 dark:bg-[#1c1c1e] rounded-[40px] border-2 border-dashed border-slate-200 dark:border-white/10 flex flex-col items-center justify-center text-center">
                                        <h3 class="text-lg font-black text-slate-800 dark:text-white">Belum ada riwayat layanan</h3>
                                    </div>
                                @endforelse
                            </div>

                            <!-- List View -->
                            <div x-show="viewMode === 'list'" style="display: none;" class="hidden sm:flex flex-col gap-3 p-5 bg-slate-50/30 dark:bg-[#121214]/50">
                                @forelse($completedOrders as $order)
                                    <div class="group bg-white dark:bg-[#1c1c1e] rounded-3xl border border-slate-200/60 dark:border-white/10 shadow-sm hover:shadow-xl transition-all duration-500 p-5 flex flex-col sm:flex-row items-center gap-6 cursor-pointer opacity-80 hover:opacity-100" @click="window.location.href = '{{ route('member.orders.show', $order->order_number) }}'">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-3 mb-2">
                                                <span class="px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-[#1c1c1e]/50 text-slate-500 dark:text-slate-400 text-[10px] font-black uppercase tracking-wider">{{ $order->order_number }}</span>
                                                <span class="text-[11px] font-bold text-slate-400">{{ $order->updated_at->format('d M Y') }}</span>
                                            </div>
                                            <h3 class="font-black text-[18px] text-slate-800 dark:text-white leading-tight mb-1 truncate">{{ $order->service->title ?? 'Layanan Kustom' }}</h3>
                                            <p class="text-[12px] font-bold text-slate-400">{{ $order->package_name ?? 'Paket Kustom' }}</p>
                                        </div>
                                        <div class="shrink-0">
                                            <span class="px-4 py-1.5 rounded-xl text-[10px] font-black border {{ $order->status == 'completed' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-red-50 text-red-600 border-red-100' }}">{{ strtoupper($order->status) }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-12">
                                        <h3 class="text-sm font-bold text-slate-800 dark:text-white mb-1">Belum ada riwayat layanan</h3>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Mobile View (Compact Cards) -->
                            <div class="sm:hidden flex flex-col gap-3">
                                @forelse($completedOrders as $order)
                                    @php
                                        $statusColor = $order->status == 'completed' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-red-50 text-red-600 border border-red-100';
                                        $statusText = $order->status == 'completed' ? 'SELESAI' : 'BATAL';
                                    @endphp
                                    <div class="bg-white dark:bg-[#1c1c1e] rounded-2xl p-3 border border-slate-200/80 shadow-sm flex items-center gap-3 cursor-pointer hover:border-slate-300 transition-colors" @click="window.location.href = '{{ route('member.orders.show', $order->order_number) }}'">
                                        <div class="w-12 h-12 rounded-xl bg-slate-50 dark:bg-[#1c1c1e] text-slate-500 dark:text-slate-400 border border-slate-200/40 flex flex-col items-center justify-center shrink-0">
                                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between mb-0.5">
                                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $order->order_number }}</span>
                                                <span class="px-1.5 py-0.5 rounded-md text-[8px] font-black {{ $statusColor }}">{{ $statusText }}</span>
                                            </div>
                                            <h4 class="font-extrabold text-[13px] text-slate-800 dark:text-white leading-tight truncate">{{ $order->service->title ?? 'Layanan Kustom' }}</h4>
                                            <p class="text-[10px] font-bold text-slate-400 truncate">Tanggal: {{ $order->updated_at->format('d M Y') }}</p>
                                        </div>
                                        <div class="shrink-0 w-8 h-8 rounded-full bg-slate-50 dark:bg-[#1c1c1e] flex items-center justify-center text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                        </div>
                                    </div>
                                @empty
                                    <div class="py-12 bg-slate-50 dark:bg-[#1c1c1e] rounded-2xl border-2 border-dashed border-slate-200 dark:border-white/10 flex flex-col items-center justify-center text-center p-4">
                                        <h3 class="text-sm font-bold text-slate-800 dark:text-white">Belum ada riwayat layanan</h3>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Mobile View (Grouped Lists) -->
                        <div class="sm:hidden flex flex-col gap-6 mb-6">
                            
                            <!-- Layanan Berlangsung Section -->
                            <div>
                                <div class="flex items-center justify-between mb-3 mt-1">
                                    <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Layanan Berlangsung</h3>
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 dark:bg-[#1c1c1e]/50 text-slate-600 dark:text-slate-300 text-[10px] font-black">{{ $activeOrders->count() }}</span>
                                </div>
                                
                                <div class="flex flex-col gap-3">
                                    @forelse($activeOrders as $order)
                                        @php
                                            $project = $order->project;
                                            $statusColor = match($order->status) {
                                                'pending' => 'bg-amber-50 text-amber-600 border-amber-100',
                                                'processing' => 'bg-blue-50 text-blue-600 border-blue-100',
                                                default => 'bg-slate-50 dark:bg-[#1c1c1e] text-slate-600 dark:text-slate-300 border-slate-100 dark:border-white/10/50'
                                            };
                                            $statusText = match($order->status) {
                                                'pending' => 'Pending',
                                                'processing' => 'Berjalan',
                                                default => ucfirst($order->status)
                                            };
                                        @endphp
                                        <div class="bg-white dark:bg-[#1c1c1e] rounded-2xl p-3 border border-slate-200/80 shadow-sm flex items-center gap-3 cursor-pointer hover:border-blue-300/50 transition-colors" @click="window.location.href = '{{ route('member.orders.show', $order->order_number) }}'">
                                            <div class="w-12 h-12 rounded-xl bg-slate-50 dark:bg-[#1c1c1e] text-slate-500 dark:text-slate-400 border border-slate-200/40 flex flex-col items-center justify-center shrink-0">
                                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center justify-between mb-0.5">
                                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $order->order_number }}</span>
                                                    <span class="px-1.5 py-0.5 rounded-md text-[8px] font-black border {{ $statusColor }}">{{ $statusText }}</span>
                                                </div>
                                                <h4 class="font-extrabold text-[13px] text-slate-800 dark:text-white leading-tight truncate">{{ $order->service->title ?? 'Layanan Kustom' }}</h4>
                                                @if($project)
                                                    <div class="flex items-center justify-between text-[10px] font-bold text-slate-500 dark:text-slate-400 mt-1">
                                                        <span class="text-slate-400">Progress Proyek</span>
                                                        <span class="text-blue-600 font-black">{{ $project->progress }}%</span>
                                                    </div>
                                                    <div class="h-1 w-full bg-slate-100 dark:bg-[#1c1c1e]/50 rounded-full mt-1 overflow-hidden">
                                                        <div class="h-full bg-blue-500" style="width: {{ $project->progress }}%"></div>
                                                    </div>
                                                @else
                                                    <p class="text-[10px] text-slate-400 font-bold italic mt-1">Menunggu inisiasi proyek...</p>
                                                @endif
                                            </div>
                                            <div class="shrink-0 w-8 h-8 rounded-full bg-slate-50 dark:bg-[#1c1c1e] flex items-center justify-center text-slate-400">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="py-8 bg-white dark:bg-[#1c1c1e] rounded-2xl border-2 border-dashed border-slate-200 dark:border-white/10 flex flex-col items-center justify-center text-center p-6 shadow-sm">
                                            <p class="text-xs font-extrabold text-slate-800 dark:text-white">Belum ada layanan berlangsung</p>
                                            <p class="text-[11px] font-semibold text-slate-400 mt-2">Tekan + untuk menambahkan layanan</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Riwayat Layanan Section -->
                            <div>
                                <div class="flex items-center justify-between mb-3 mt-2">
                                    <h3 class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Riwayat Layanan</h3>
                                    <span class="px-2 py-0.5 rounded-md bg-slate-100 dark:bg-[#1c1c1e]/50 text-slate-600 dark:text-slate-300 text-[10px] font-black">{{ $completedOrders->count() }}</span>
                                </div>
                                
                                <div class="flex flex-col gap-3">
                                    @forelse($completedOrders as $order)
                                        @php
                                            $statusColor = $order->status == 'completed' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-red-50 text-red-600 border border-red-100';
                                            $statusText = $order->status == 'completed' ? 'SELESAI' : 'BATAL';
                                        @endphp
                                        <div class="bg-white dark:bg-[#1c1c1e] rounded-2xl p-3 border border-slate-200/80 shadow-sm flex items-center gap-3 cursor-pointer hover:border-slate-300 transition-colors" @click="window.location.href = '{{ route('member.orders.show', $order->id) }}'">
                                            <div class="w-12 h-12 rounded-xl bg-slate-50 dark:bg-[#1c1c1e] text-slate-500 dark:text-slate-400 border border-slate-200/40 flex flex-col items-center justify-center shrink-0">
                                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center justify-between mb-0.5">
                                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $order->order_number }}</span>
                                                    <span class="px-1.5 py-0.5 rounded-md text-[8px] font-black {{ $statusColor }}">{{ $statusText }}</span>
                                                </div>
                                                <h4 class="font-extrabold text-[13px] text-slate-800 dark:text-white leading-tight truncate">{{ $order->service->title ?? 'Layanan Kustom' }}</h4>
                                                <p class="text-[10px] font-bold text-slate-400 truncate">Tanggal: {{ $order->updated_at->format('d M Y') }}</p>
                                            </div>
                                            <div class="shrink-0 w-8 h-8 rounded-full bg-slate-50 dark:bg-[#1c1c1e] flex items-center justify-center text-slate-400">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="py-6 bg-slate-50 dark:bg-[#1c1c1e] rounded-2xl border-2 border-dashed border-slate-200 dark:border-white/10 flex flex-col items-center justify-center text-center p-4">
                                            <p class="text-xs font-bold text-slate-400">Belum ada riwayat layanan</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                            
                        </div>

                    </div>
                    </div>
                    </div>

                    <!-- Floating Action Button -->
                    <div x-data="{ scrolled: false }"
                         @scroll.window="scrolled = (window.pageYOffset > 50)"
                         x-transition:enter="transition ease-out duration-300 transform"
                         x-transition:enter-start="opacity-0 -translate-x-12 scale-50"
                         x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                         x-transition:leave="transition ease-in duration-300 transform"
                         x-transition:leave-start="opacity-100 translate-x-0 scale-100"
                         x-transition:leave-end="opacity-0 -translate-x-12 scale-50"
                         class="fixed bottom-5 left-[4.25rem] sm:left-auto sm:bottom-10 sm:right-10 z-[9999]"
                         style="bottom: calc(1.25rem + env(safe-area-inset-bottom)) !important;">
                        <a :href="activeTab === 'kelas' ? '{{ route('courses.index') }}' : '{{ route('services.index') }}'" 
                           class="flex items-center h-11 w-11 sm:h-14 bg-white/75 dark:bg-[#151515]/75 backdrop-blur-3xl border border-white/70 dark:border-white/20 rounded-full text-blue-600 dark:text-blue-400 hover:scale-110 sm:hover:scale-105 active:scale-95 focus:outline-none transition-all duration-300 ease-out shadow-[0_8px_25px_rgba(0,0,0,0.08)] dark:shadow-[0_8px_32px_rgba(0,0,0,0.6),_inset_0_1px_1px_rgba(255,255,255,0.25)] overflow-hidden"
                           :class="scrolled ? 'w-11 sm:w-14' : 'w-11 sm:w-48'">
                            <div class="flex items-center justify-center w-11 h-11 sm:w-14 sm:h-14 shrink-0">
                                <!-- Plus SVG for mobile -->
                                <svg class="sm:hidden w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                
                                <!-- Original SVGs for desktop -->
                                <svg x-show="activeTab === 'kelas'" class="hidden sm:block w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                <svg x-show="activeTab === 'layanan'" style="display: none;" class="hidden sm:block w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <span class="hidden sm:inline font-bold text-[14px] whitespace-nowrap transition-opacity duration-500 pl-1 pr-6" 
                                  :class="scrolled ? 'opacity-0' : 'opacity-100 delay-200'"
                                  x-text="activeTab === 'kelas' ? 'Cari Kelas Baru' : 'Pesan Layanan'"></span>
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
    
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('clockWidget', () => ({
                timeString: '',
                dateString: '',
                greeting: '',
                
                initClock() {
                    this.updateClock();
                    setInterval(() => this.updateClock(), 1000);
                },
                
                updateClock() {
                    const now = new Date();
                    const hours = String(now.getHours()).padStart(2, '0');
                    const minutes = String(now.getMinutes()).padStart(2, '0');
                    this.timeString = `${hours}:${minutes}`;
                    const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
                    this.dateString = now.toLocaleDateString('id-ID', options);
                    const hour = now.getHours();
                    if (hour >= 5 && hour < 11) this.greeting = 'Selamat Pagi';
                    else if (hour >= 11 && hour < 15) this.greeting = 'Selamat Siang';
                    else if (hour >= 15 && hour < 18) this.greeting = 'Selamat Sore';
                    else this.greeting = 'Selamat Malam';
                }
            }));
        });
    </script>
</x-app-layout>
