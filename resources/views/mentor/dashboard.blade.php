<x-app-layout>
    <div class="min-h-screen bg-[#f8fafc] dark:bg-black pb-12 pt-4 sm:pt-8 transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">


            <!-- TABS & CONTENT -->
            <div x-data="{ viewMode: localStorage.getItem('mentorViewMode') || 'grid', activeTab: '{{ $activeTab }}' }" x-init="$watch('viewMode', val => localStorage.setItem('mentorViewMode', val))" class="flex flex-col lg:flex-row gap-4 lg:gap-8 relative">
                
                <!-- Sidebar Nav -->
                <div class="w-full lg:w-64 flex-shrink-0">
                    <div class="sticky top-[105px]">
                        <h2 class="text-[22px] font-black text-slate-800 mb-4 lg:mb-6 tracking-tight">Dashboard Mentor</h2>
                        
                        <!-- Mobile Responsive Nav Tab & Search/Sort Row -->
                        <div class="sm:hidden flex items-center justify-between gap-2 mb-4 bg-white/45 dark:bg-[#151515]/45 backdrop-blur-md p-1.5 rounded-[20px] shadow-sm border border-slate-200/60 dark:border-white/10 dark:border-white/10 dark:border-white/10 relative h-[62px] z-20" x-data="{ mobileSearchOpen: '{{ request('search') }}' !== '' }">
                            <!-- Tab & Icons Wrapper (visible when search is closed) -->
                            <div class="flex items-center justify-between w-full gap-2" x-show="!mobileSearchOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                                <!-- Sideways Tabs with Fluid Liquid Indicator -->
                                <nav class="relative flex items-center p-1 rounded-full bg-slate-100/90 dark:bg-[#121212]/90 backdrop-blur-md border border-slate-200/80 dark:border-white/10 flex-1 select-none overflow-hidden">
                                    <!-- Fluid Liquid Sliding Capsule Indicator -->
                                    <div class="absolute top-1 bottom-1 rounded-full bg-white dark:bg-white/15 border border-slate-200/80 dark:border-white/10 shadow-sm pointer-events-none transition-all duration-500 ease-[cubic-bezier(0.34,1.56,0.64,1)] z-0"
                                         :style="`width: calc((100% - 8px) / 2); left: calc(4px + (100% - 8px) / 2 * ${activeTab === 'tugas' ? 1 : 0})`">
                                    </div>

                                    <div class="grid grid-cols-2 relative z-10 w-full items-center">
                                        <!-- Kelas Saya Tab -->
                                        <button @click="activeTab = 'kelas'; window.history.replaceState(null, null, '?tab=kelas&search={{ request('search') }}&sort={{ request('sort') }}')"
                                                class="flex items-center justify-center gap-1.5 h-8 px-2 rounded-full font-bold text-[11px] transition-colors duration-300 relative z-10 group"
                                                :class="activeTab === 'kelas' ? 'text-blue-600 dark:text-blue-400 font-black' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 font-medium'">
                                            <svg class="w-3.5 h-3.5 shrink-0 transition-transform duration-300 group-active:scale-90" :class="activeTab === 'kelas' ? 'text-blue-600 dark:text-blue-400' : 'text-slate-400 dark:text-slate-500'" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-2.283 1 1 0 011-.755zm13.38 0a1 1 0 011 .755 11.115 11.115 0 01.25 2.283 1 1 0 01-.89.89 8.963 8.963 0 00-1.05.174V10.12l1.69-.723zM7.18 10.74l1.246.534A3 3 0 0010 11a3 3 0 001.573-.466l1.247-.534L15 10.74v4.102c-1.398.545-3.082.858-5 .858c-1.918 0-3.602-.313-5-.858V10.74l2.18-.937z" /></svg>
                                            <span class="whitespace-nowrap">Kelas Saya</span>
                                        </button>
                                        
                                        <!-- Tugas Siswa Tab -->
                                        <button @click="activeTab = 'tugas'; window.history.replaceState(null, null, '?tab=tugas&search={{ request('search') }}&sort={{ request('sort') }}')"
                                                class="flex items-center justify-center gap-1.5 h-8 px-2 rounded-full font-bold text-[11px] transition-colors duration-300 relative z-10 group"
                                                :class="activeTab === 'tugas' ? 'text-blue-600 dark:text-blue-400 font-black' : 'text-slate-500 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 font-medium'">
                                            <svg class="w-3.5 h-3.5 shrink-0 transition-transform duration-300 group-active:scale-90" :class="activeTab === 'tugas' ? 'text-blue-600 dark:text-blue-400' : 'text-slate-400 dark:text-slate-500'" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" /><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" /></svg>
                                            <span class="whitespace-nowrap">Tugas Siswa</span>
                                        </button>
                                    </div>
                                </nav>

                                <!-- Mobile Search & Sort Icon Group -->
                                <div class="flex items-center gap-1 shrink-0">
                                    <!-- Search Toggle Button -->
                                    <button @click="mobileSearchOpen = true" class="w-9 h-9 flex items-center justify-center bg-slate-50 border border-slate-200/60 dark:border-white/10 dark:border-white/10 text-slate-500 rounded-xl hover:text-blue-600 transition-colors" title="Cari">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </button>

                                    <!-- Sort Dropdown -->
                                    <div class="relative" x-data="{ open: false }">
                                        <button @click="open = !open" @click.away="open = false" class="w-9 h-9 flex items-center justify-center bg-slate-50 border border-slate-200/60 dark:border-white/10 dark:border-white/10 text-slate-500 rounded-xl hover:text-blue-600 transition-colors" title="Sortir">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                                        </button>
                                        
                                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" style="display: none;" class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 z-50 overflow-hidden">
                                            <div class="px-3 py-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.1em] bg-slate-50/50 dark:bg-[#121214]/50 border-b border-slate-100">Sortir Berdasarkan</div>
                                            <div class="p-1.5">
                                                <a href="?tab={{ $activeTab }}&sort=latest&search={{ request('search') }}" class="flex items-center px-2.5 py-2 text-[12px] font-bold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('sort') == 'latest' || !request('sort') ? 'text-blue-600 bg-blue-50/50' : '' }}">
                                                    Terbaru
                                                </a>
                                                <a href="?tab={{ $activeTab }}&sort=oldest&search={{ request('search') }}" class="flex items-center px-2.5 py-2 text-[12px] font-bold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('sort') == 'oldest' ? 'text-blue-600 bg-blue-50/50' : '' }}">
                                                    Terlama
                                                </a>
                                                <a href="?tab={{ $activeTab }}&sort=name_asc&search={{ request('search') }}" class="flex items-center px-2.5 py-2 text-[12px] font-bold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('sort') == 'name_asc' ? 'text-blue-600 bg-blue-50/50' : '' }}">
                                                    Nama (A-Z)
                                                </a>
                                                <a href="?tab={{ $activeTab }}&sort=name_desc&search={{ request('search') }}" class="flex items-center px-2.5 py-2 text-[12px] font-bold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('sort') == 'name_desc' ? 'text-blue-600 bg-blue-50/50' : '' }}">
                                                    Nama (Z-A)
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Search Overlay (visible when search is open) -->
                            <div class="absolute inset-0 bg-white px-3 flex items-center gap-2 z-20 rounded-[20px]" x-show="mobileSearchOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                                <form action="{{ route('mentor.dashboard') }}" method="GET" class="flex-1 flex items-center bg-slate-50 border border-slate-200/60 dark:border-white/10 dark:border-white/10 rounded-xl overflow-hidden h-10">
                                    <div class="flex-1 flex items-center px-3 h-full">
                                        <svg class="w-4 h-4 text-slate-400 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..." 
                                               class="bg-transparent border-none text-[13px] focus:ring-0 font-medium w-full p-0 h-full">
                                    </div>
                                    <input type="hidden" name="tab" :value="activeTab">
                                    @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                                </form>
                                <!-- Close button -->
                                <button @click="mobileSearchOpen = false; window.location.href = '?tab=' + activeTab" class="w-10 h-10 flex items-center justify-center bg-slate-100 hover:bg-slate-200 text-slate-500 rounded-xl shrink-0" title="Batal Cari">
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
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-2.283 1 1 0 011-.755zm13.38 0a1 1 0 011 .755 11.115 11.115 0 01.25 2.283 1 1 0 01-.89.89 8.963 8.963 0 00-1.05.174V10.12l1.69-.723zM7.18 10.74l1.246.534A3 3 0 0010 11a3 3 0 001.573-.466l1.247-.534L15 10.74v4.102c-1.398.545-3.082.858-5 .858c-1.918 0-3.602-.313-5-.858V10.74l2.18-.937z" /></svg>
                                    </div>
                                    <span>Kelas Saya</span>
                                </div>
                                <span class="px-2 py-0.5 rounded-md text-[11px] font-bold shadow-sm transition-all" :class="activeTab === 'kelas' ? 'bg-blue-100/80 dark:bg-blue-500/25 text-blue-600 dark:text-blue-300 border border-blue-100 dark:border-blue-500/10' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-transparent'">{{ $totalKelasTab ?? 0 }}</span>
                            </button>
                            
                            <!-- Tugas Siswa Tab -->
                            <button @click="activeTab = 'tugas'; window.history.replaceState(null, null, '?tab=tugas&search={{ request('search') }}&sort={{ request('sort') }}')"
                                    :class="activeTab === 'tugas' ? 'bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/20 shadow-[0_2px_10px_-3px_rgba(59,130,246,0.15)]' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white border border-transparent'"
                                    class="group flex items-center justify-between px-4 py-2.5 rounded-xl font-bold text-[13px] transition-all duration-300 text-left">
                                <div class="flex items-center gap-3">
                                    <div class="p-1.5 rounded-lg transition-colors" :class="activeTab === 'tugas' ? 'bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400' : 'bg-transparent text-slate-400 dark:text-slate-500 group-hover:bg-slate-100 dark:group-hover:bg-white/5 group-hover:text-slate-705 dark:group-hover:text-white'">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" /><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" /></svg>
                                    </div>
                                    <span>Tugas Siswa</span>
                                </div>
                                <span class="px-2 py-0.5 rounded-md text-[11px] font-bold shadow-sm transition-all" :class="activeTab === 'tugas' ? 'bg-blue-100/80 dark:bg-blue-500/25 text-blue-600 dark:text-blue-300 border border-blue-100 dark:border-blue-500/10' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-transparent'">{{ $totalTugasTab ?? 0 }}</span>
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
                                        <span>{{ number_format($totalCourses) }} Kelas</span>
                                    </div>
                                    <div class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-700"></div>
                                    <div class="flex items-center gap-1.5 text-[11px] font-bold">
                                        <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                        </svg>
                                        <span>{{ number_format($totalStudents) }} Siswa</span>
                                    </div>
                                    <div class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-700"></div>
                                    <div class="flex items-center gap-1.5 text-[11px] font-bold">
                                        <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <span>{{ number_format($averageRating, 1) }} Rating</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Content Area -->
                <div class="flex-1 min-w-0 relative">
                    <!-- Actions: Search & Sort -->
                    <div class="flex justify-between items-center gap-4 mb-4 sm:mb-6" :class="activeTab === 'kelas' ? 'flex' : 'hidden sm:flex'">
                        <!-- Expandable Search -->
                        <form action="{{ route('mentor.dashboard') }}" method="GET" x-data="{ searchOpen: '{{ request('search') }}' !== '' }" class="hidden sm:flex items-center w-full sm:w-auto">
                            <div @click.away="if($refs.searchInput.value === '') searchOpen = false"
                                 class="flex items-center bg-white border shadow-sm rounded-xl overflow-hidden transition-all duration-300 ease-out"
                                 :class="searchOpen ? 'w-full sm:w-80 border-blue-400 ring-4 ring-blue-500/10' : 'w-10 border-slate-200/60 dark:border-white/10 dark:border-white/10 hover:border-blue-300'">
                                <button type="button" @click="if(!searchOpen) { searchOpen = true; $nextTick(() => $refs.searchInput.focus()) } else if ($refs.searchInput.value) { $el.closest('form').submit() }" 
                                        class="flex-shrink-0 w-10 h-10 flex items-center justify-center transition-colors bg-transparent z-10 cursor-pointer"
                                        :class="searchOpen ? 'text-blue-600' : 'text-slate-500 hover:text-blue-600'">
                                    <svg class="w-5 h-5 transition-transform duration-300 ease-out" :class="searchOpen ? 'scale-95' : 'scale-100 hover:scale-110'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </button>
                                <input x-ref="searchInput" @keydown.enter="$el.closest('form').submit()" type="text" name="search" value="{{ request('search') }}" placeholder="Pencarian..." 
                                       class="bg-transparent border-none text-[13px] focus:ring-0 font-medium transition-all duration-300 ease-out flex-1 min-w-0"
                                       :class="searchOpen ? 'opacity-100 pr-3 pl-1 w-full translate-x-0' : 'opacity-0 w-0 p-0 -translate-x-2 pointer-events-none'">
                            </div>
                            <input type="hidden" name="tab" value="{{ $activeTab }}">
                            @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                        </form>

                        <div class="flex items-center gap-3 self-end sm:self-auto">
                            <!-- Sort Dropdown -->
                            <div class="relative hidden sm:block" x-data="{ open: false }">
                                <button @click="open = !open" @click.away="open = false" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200/60 dark:border-white/10 dark:border-white/10 shadow-sm text-slate-500 rounded-xl hover:text-blue-600 hover:border-blue-300 transition-colors" title="Sortir">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                                </button>
                                
                                <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" style="display: none;" class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 z-50 overflow-hidden">
                                    <div class="px-4 py-3 text-[11px] font-black text-slate-400 uppercase tracking-[0.1em] bg-slate-50/50 dark:bg-[#121214]/50 border-b border-slate-100">Sortir Berdasarkan</div>
                                    <div class="p-2">
                                        <a href="?tab={{ $activeTab }}&sort=latest&search={{ request('search') }}" class="flex items-center px-3 py-2.5 text-[13px] font-bold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('sort') == 'latest' || !request('sort') ? 'text-blue-600 bg-blue-50/50' : '' }}">
                                            <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-2.5 opacity-0 {{ request('sort') == 'latest' || !request('sort') ? 'opacity-100' : '' }}"></div>
                                            Terbaru
                                        </a>
                                        <a href="?tab={{ $activeTab }}&sort=oldest&search={{ request('search') }}" class="flex items-center px-3 py-2.5 text-[13px] font-bold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('sort') == 'oldest' ? 'text-blue-600 bg-blue-50/50' : '' }}">
                                            <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-2.5 opacity-0 {{ request('sort') == 'oldest' ? 'opacity-100' : '' }}"></div>
                                            Terlama
                                        </a>
                                        <template x-if="activeTab === 'kelas'">
                                            <div class="mt-1 pt-1 border-t border-slate-50">
                                                <a href="?tab={{ $activeTab }}&sort=name_asc&search={{ request('search') }}" class="flex items-center px-3 py-2.5 text-[13px] font-bold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('sort') == 'name_asc' ? 'text-blue-600 bg-blue-50/50' : '' }}">
                                                    <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-2.5 opacity-0 {{ request('sort') == 'name_asc' ? 'opacity-100' : '' }}"></div>
                                                    Nama (A-Z)
                                                </a>
                                                <a href="?tab={{ $activeTab }}&sort=name_desc&search={{ request('search') }}" class="flex items-center px-3 py-2.5 text-[13px] font-bold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('sort') == 'name_desc' ? 'text-blue-600 bg-blue-50/50' : '' }}">
                                                    <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-2.5 opacity-0 {{ request('sort') == 'name_desc' ? 'opacity-100' : '' }}"></div>
                                                    Nama (Z-A)
                                                </a>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <!-- View Toggles (Only for Kelas Saya) -->
                            <div x-show="activeTab === 'kelas'" class="flex items-center gap-3">
                                <div class="hidden sm:block w-px h-6 bg-slate-200"></div>
                                <div class="hidden sm:flex items-center bg-white border border-slate-200/60 dark:border-white/10 dark:border-white/10 shadow-sm rounded-xl p-1">
                                    <button @click="viewMode = 'grid'" :class="viewMode === 'grid' ? 'bg-slate-100 text-blue-600 shadow-sm' : 'text-slate-400 hover:text-slate-600'" class="w-8 h-8 flex items-center justify-center rounded-lg transition-all" title="Tampilan Kartu">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                    </button>
                                    <button @click="viewMode = 'list'" :class="viewMode === 'list' ? 'bg-slate-100 text-blue-600 shadow-sm' : 'text-slate-400 hover:text-slate-600'" class="w-8 h-8 flex items-center justify-center rounded-lg transition-all" title="Tampilan Tabel">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Data Table Content -->
                    <div class="bg-transparent sm:bg-white dark:sm:bg-[#1c1c1e] sm:rounded-[24px] border-0 sm:border border-slate-200/60 dark:border-white/10 sm:shadow-sm overflow-hidden mb-12">
                    <div class="overflow-x-auto">
                        
                        <!-- TAB: KELAS SAYA -->
                        <div x-show="activeTab === 'kelas'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">

                            <!-- Grid View -->
                            <div x-show="viewMode === 'grid'" style="display: none;" class="hidden sm:grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 p-5 bg-slate-50/30 dark:bg-[#121214]/50">
                                @forelse($coursesList as $course)
                                    <div class="group bg-white dark:bg-[#1c1c1e] rounded-[24px] overflow-hidden border border-slate-200/70 dark:border-white/10 shadow-sm hover:shadow-xl hover:border-blue-500/30 transition-all duration-500 flex flex-col relative cursor-pointer" @click="window.location.href = '{{ route('mentor.courses.show', $course) }}'">
                                        <!-- Thumbnail Area -->
                                        <div class="aspect-[16/9] w-full bg-slate-100 dark:bg-[#151517] relative overflow-hidden">
                                            <div class="absolute top-3.5 left-3.5 z-10 flex gap-1.5">
                                                <span class="px-2.5 py-1 rounded-lg text-[9px] font-bold uppercase tracking-wider bg-slate-100 dark:bg-slate-800 text-blue-600 dark:text-blue-400 border border-slate-200 dark:border-transparent shadow-sm">{{ $course->category->name ?? 'Kategori' }}</span>
                                                @if($course->is_published)
                                                    <span class="px-2.5 py-1 rounded-lg text-[9px] font-bold uppercase tracking-wider bg-slate-100 dark:bg-slate-800 text-emerald-700 dark:text-emerald-400 border border-slate-200 dark:border-transparent shadow-sm">Publik</span>
                                                @else
                                                    <span class="px-2.5 py-1 rounded-lg text-[9px] font-bold uppercase tracking-wider bg-slate-100 dark:bg-slate-800 text-amber-800 dark:text-amber-400 border border-slate-200 dark:border-transparent shadow-sm">Draft</span>
                                                @endif
                                            </div>

                                            @if($course->thumbnail)
                                                <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                                            @else
                                                <div class="w-full h-full flex flex-col items-center justify-center text-blue-300 dark:text-blue-900 bg-blue-50/40 dark:bg-blue-950/10">
                                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                </div>
                                            @endif
                                            
                                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/40 to-transparent opacity-60"></div>
                                        </div>

                                        <!-- Content Area -->
                                        <div class="p-5 flex flex-col flex-1">
                                            <h3 class="font-bold text-[15px] text-slate-800 dark:text-slate-100 leading-snug mb-3 line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                                {{ $course->title }}
                                            </h3>
                                            
                                            <!-- Stats Row -->
                                            <div class="flex items-center gap-3 text-[11px] font-bold text-slate-500 dark:text-slate-300 mb-4 border-b border-slate-100 dark:border-white/5 pb-3">
                                                <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>{{ number_format($course->rating, 1) }}</span>
                                                <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-700"></span>
                                                <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>{{ $course->enrollments_count }} Siswa</span>
                                                <span class="w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-700"></span>
                                                <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>{{ $course->lessons->count() }} Materi</span>
                                            </div>

                                            <!-- Last updates -->
                                            @php
                                                $latestLesson = $course->lessons->first();
                                                $latestQuiz = $course->assignments->first();
                                            @endphp
                                            <div class="space-y-2 text-[11px] text-slate-600 dark:text-slate-400 mb-4 mt-auto">
                                                <div class="flex items-center gap-2 min-w-0">
                                                    <span class="px-1.5 py-0.5 rounded bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 font-bold text-[9px] uppercase tracking-wider shrink-0">Materi</span>
                                                    <span class="font-medium truncate text-slate-700 dark:text-slate-200">{{ $latestLesson ? $latestLesson->title : 'Belum ada materi' }}</span>
                                                </div>
                                                <div class="flex items-center gap-2 min-w-0">
                                                    <span class="px-1.5 py-0.5 rounded bg-orange-50 dark:bg-orange-950/40 text-orange-600 dark:text-orange-400 font-bold text-[9px] uppercase tracking-wider shrink-0">Tugas</span>
                                                    <span class="font-medium truncate text-slate-700 dark:text-slate-200">{{ $latestQuiz ? $latestQuiz->title : 'Belum ada tugas' }}</span>
                                                </div>
                                            </div>

                                            <!-- Footer -->
                                            <div class="mt-3 pt-3 border-t border-slate-100 dark:border-white/5 flex items-center justify-between text-[11px]">
                                                <span class="text-slate-400 dark:text-slate-500">Dibuat: {{ $course->created_at->format('d M Y') }}</span>
                                                <span class="font-black text-blue-600 dark:text-blue-400 flex items-center gap-1 group-hover:gap-1.5 transition-all">
                                                    Kelola
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-12">
                                        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-200">
                                            <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        </div>
                                        <h3 class="text-[15px] font-bold text-slate-800 mb-1">Data Kelas Kosong</h3>
                                        <p class="text-[13px] text-slate-500">Belum ada kelas yang sesuai kriteria pencarian.</p>
                                    </div>
                                @endforelse
                            </div>

                            <!-- List View (Horizontal Cards) -->
                            <div x-show="viewMode === 'list'" style="display: none;" class="hidden sm:flex flex-col gap-3 p-4 bg-slate-50/30 dark:bg-[#121214]/50">
                                @forelse($coursesList as $course)
                                    @php
                                        $latestLesson = $course->lessons->first();
                                        $latestQuiz = $course->assignments->first();
                                    @endphp
                                    <div class="group bg-white rounded-2xl border border-slate-200/60 dark:border-white/10 shadow-sm hover:shadow-md transition-all duration-300 p-3 flex flex-col sm:flex-row items-start sm:items-center gap-4 cursor-pointer" @click="window.location.href = '{{ route('mentor.courses.show', $course) }}'">
                                        <!-- Thumbnail (Small) -->
                                        <div class="w-full sm:w-40 aspect-video sm:aspect-[4/3] rounded-xl bg-slate-100 overflow-hidden shrink-0 relative">
                                            @if($course->is_published)
                                                <span class="absolute top-1.5 left-1.5 px-1.5 py-0.5 rounded text-[8px] font-bold uppercase tracking-wider bg-emerald-500 text-white z-10">Publik</span>
                                            @else
                                                <span class="absolute top-1.5 left-1.5 px-1.5 py-0.5 rounded text-[8px] font-bold uppercase tracking-wider bg-amber-400 text-amber-900 z-10">Draft</span>
                                            @endif
                                            
                                            @if($course->thumbnail)
                                                <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                            @else
                                                <div class="w-full h-full bg-blue-50 text-blue-300 flex items-center justify-center">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Main Info -->
                                        <div class="flex-1 min-w-0 flex flex-col justify-center">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="px-2 py-0.5 rounded-md bg-slate-100 dark:bg-white/5 text-slate-500 dark:text-slate-400 text-[10px] font-bold uppercase">{{ $course->category->name ?? 'Kategori' }}</span>
                                                <span class="text-[10px] text-slate-400">Dibuat {{ $course->created_at->format('d M Y') }}</span>
                                            </div>
                                            <h3 class="font-bold text-[15px] text-slate-800 leading-tight mb-2 truncate group-hover:text-blue-600 transition-colors">
                                                {{ $course->title }}
                                            </h3>
                                            <div class="flex items-center gap-3 text-[11px] font-semibold text-slate-600">
                                                <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg> {{ $course->enrollments_count }} Siswa</span>
                                                <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8 2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg> {{ number_format($course->rating, 1) }}</span>
                                            </div>
                                        </div>

                                        <!-- Latest Info (Materials & Tasks) -->
                                        <div class="w-full sm:w-64 border-t sm:border-t-0 sm:border-l border-slate-100 pt-3 sm:pt-0 sm:pl-4 flex flex-col justify-center gap-2 shrink-0">
                                            <div class="flex items-center gap-2">
                                                 <div class="w-6 h-6 rounded-md bg-blue-50 dark:bg-blue-950/40 text-blue-500 dark:text-blue-400 flex items-center justify-center shrink-0">
                                                     <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                                 </div>
                                                 <div class="min-w-0">
                                                     <p class="text-[9px] font-bold text-slate-400 uppercase leading-none mb-0.5 flex items-center gap-1">
                                                         Materi Terakhir
                                                         @if($latestLesson) <span class="font-medium normal-case text-blue-500">(Diunggah: {{ $latestLesson->created_at->format('d M') }})</span> @endif
                                                     </p>
                                                     <p class="text-[11px] font-semibold text-slate-700 truncate leading-tight">{{ $latestLesson ? $latestLesson->title : '-' }}</p>
                                                 </div>
                                             </div>
                                             <div class="flex items-center gap-2">
                                                 <div class="w-6 h-6 rounded-md bg-orange-50 dark:bg-orange-950/40 text-orange-500 dark:text-orange-400 flex items-center justify-center shrink-0">
                                                     <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                                 </div>
                                                 <div class="min-w-0">
                                                     <p class="text-[9px] font-bold text-slate-400 uppercase leading-none mb-0.5 flex items-center gap-1">
                                                         Tugas / Kuis
                                                         @if($latestQuiz) <span class="font-medium normal-case text-orange-500">(Hingga: Fleksibel)</span> @endif
                                                     </p>
                                                     <p class="text-[11px] font-semibold text-slate-700 truncate leading-tight">{{ $latestQuiz ? $latestQuiz->title : '-' }}</p>
                                                 </div>
                                             </div>
                                        </div>

                                        <!-- Action -->
                                        <div class="hidden sm:flex items-center justify-center pl-4 shrink-0 border-l border-slate-100 h-full">
                                            <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-blue-50 dark:group-hover:bg-blue-950/40 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-12">
                                        <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        </div>
                                        <h3 class="text-sm font-bold text-slate-800 mb-1">Data Kelas Kosong</h3>
                                        <p class="text-[13px] text-slate-500">Belum ada kelas yang sesuai kriteria pencarian.</p>
                                    </div>
                                @endforelse
                            </div>

                            <!-- Mobile View (Compact Cards) -->
                            <div class="sm:hidden flex flex-col gap-3">
                                @forelse($coursesList as $course)
                                    @php
                                        $latestLesson = $course->lessons->first();
                                        $latestQuiz = $course->assignments->first();
                                    @endphp
                                    <div class="bg-white rounded-2xl p-3 border border-slate-200/80 dark:border-white/10 shadow-sm flex items-center gap-3 cursor-pointer hover:border-blue-300/50 transition-colors" @click="window.location.href = '{{ route('mentor.courses.show', $course) }}'">
                                        <div class="w-16 h-16 rounded-xl bg-slate-100 overflow-hidden shrink-0 relative">
                                            @if($course->thumbnail)
                                                <img src="{{ Storage::url($course->thumbnail) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full bg-blue-50 text-blue-300 flex items-center justify-center">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center justify-between mb-0.5">
                                                <span class="px-1.5 py-0.5 rounded-md bg-slate-100 dark:bg-white/5 text-slate-500 dark:text-slate-400 text-[9px] font-bold uppercase">{{ $course->category->name ?? 'Kategori' }}</span>
                                                @if($course->is_published)
                                                    <span class="px-1.5 py-0.5 rounded-md bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 text-[8px] font-black uppercase">Publik</span>
                                                @else
                                                    <span class="px-1.5 py-0.5 rounded-md bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 text-[8px] font-black uppercase">Draft</span>
                                                @endif
                                            </div>
                                            <h4 class="font-extrabold text-[13px] text-slate-800 leading-tight mb-1 truncate">{{ $course->title }}</h4>
                                            <div class="flex items-center gap-3 text-[10px] font-bold text-slate-400">
                                                <span class="flex items-center gap-1"><svg class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg> {{ $course->enrollments_count }} Siswa</span>
                                                <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg> {{ number_format($course->rating, 1) }}</span>
                                            </div>
                                        </div>
                                        <div class="shrink-0 w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                        </div>
                                    </div>
                                @empty
                                    <div class="py-12 bg-white dark:bg-[#1c1c1e] rounded-2xl border-2 border-dashed border-slate-200 dark:border-white/10 flex flex-col items-center justify-center text-center p-4">
                                        <h3 class="text-sm font-bold text-slate-800 dark:text-white mb-1">Data Kelas Kosong</h3>
                                    </div>
                                @endforelse
                            </div>

                            @if($coursesList->hasPages())
                                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 dark:bg-[#121214]/50">
                                    {{ $coursesList->links() }}
                                </div>
                            @endif
                        </div>

                        <!-- TAB: TUGAS / KUIS -->
                        <div x-show="activeTab === 'tugas'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                            <table class="hidden sm:table min-w-full divide-y divide-slate-100 dark:divide-white/5">
                                <thead>
                                    <tr class="bg-slate-50/50 dark:bg-[#121214]/50">
                                        <th scope="col" class="px-6 py-4 text-left text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Siswa</th>
                                        <th scope="col" class="px-6 py-4 text-left text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Judul Kuis/Tugas</th>
                                        <th scope="col" class="px-6 py-4 text-center text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Skor</th>
                                        <th scope="col" class="px-6 py-4 text-center text-[11px] font-extrabold text-slate-400 uppercase tracking-wider">Waktu Selesai</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-white/5 bg-white dark:bg-[#1c1c1e]">
                                    @forelse($tasksList as $task)
                                        <tr class="hover:bg-blue-50/30 dark:hover:bg-indigo-950/30 transition-colors group">
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                <div class="flex items-center gap-3">
                                                    @if($task->user->avatar)
                                                        <img src="{{ asset('storage/' . $task->user->avatar) }}" class="w-8 h-8 rounded-full border border-slate-200">
                                                    @else
                                                        <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">
                                                            {{ substr($task->user->name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <p class="text-sm font-bold text-slate-800">{{ $task->user->name }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                <p class="text-sm font-bold text-slate-800">{{ $task->assignment->title }}</p>
                                                <p class="text-xs text-slate-500 mt-0.5">Kelas: {{ $task->assignment->course->title }}</p>
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-center">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-black {{ $task->score >= 70 ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                                    {{ $task->score }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-center">
                                                <p class="text-sm text-slate-600 font-medium">{{ $task->created_at->format('d M Y, H:i') }}</p>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-12 text-center">
                                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                </div>
                                                <h3 class="text-sm font-bold text-slate-800 mb-1">Belum Ada Tugas Masuk</h3>
                                                <p class="text-xs text-slate-500">Siswa yang mengerjakan kuis akan tampil di sini.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <!-- Mobile View (Compact Cards) -->
                             <div class="sm:hidden flex flex-col gap-3 p-1">
                                 @forelse($tasksList as $task)
                                     <div class="bg-white rounded-2xl p-3 border border-slate-200/80 dark:border-white/10 shadow-sm flex items-center gap-3">
                                         <div class="shrink-0">
                                             @if($task->user->avatar)
                                                 <img src="{{ asset('storage/' . $task->user->avatar) }}" class="w-10 h-10 rounded-full border border-slate-200 object-cover">
                                             @else
                                                 <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm">
                                                     {{ substr($task->user->name, 0, 1) }}
                                                 </div>
                                             @endif
                                         </div>
                                         <div class="flex-1 min-w-0">
                                             <div class="flex items-center justify-between mb-0.5">
                                                 <h4 class="font-extrabold text-[13px] text-slate-800 truncate leading-tight">{{ $task->user->name }}</h4>
                                                 <span class="text-[9px] font-bold text-slate-400">{{ $task->created_at->format('d M, H:i') }}</span>
                                             </div>
                                             <p class="text-[11px] font-bold text-slate-700 truncate">Tugas: {{ $task->assignment->title }}</p>
                                             <p class="text-[9.5px] text-slate-400 truncate">Kelas: {{ $task->assignment->course->title }}</p>
                                         </div>
                                         <div class="shrink-0">
                                             <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl text-[12px] font-black {{ $task->score >= 70 ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">
                                                 {{ $task->score }}
                                             </span>
                                         </div>
                                     </div>
                                 @empty
                                     <div class="py-12 bg-white rounded-2xl border-2 border-dashed border-slate-200 flex flex-col items-center justify-center text-center p-4">
                                         <h3 class="text-sm font-bold text-slate-800 mb-1">Belum Ada Tugas Masuk</h3>
                                         <p class="text-xs text-slate-500">Siswa yang mengerjakan kuis akan tampil di sini.</p>
                                     </div>
                                 @endforelse
                             </div>
                             
                            <!-- Pagination -->
                            @if($tasksList->hasPages())
                                <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50 dark:bg-[#121214]/50">
                                    {{ $tasksList->links() }}
                                </div>
                            @endif
                        </div>

                        </div>

                    </div>

                    <!-- Floating Action Button -->
                    <div x-data="{ scrolled: false }"
                         x-show="activeTab === 'kelas'"
                         @scroll.window="scrolled = (window.pageYOffset > 50)"
                         x-transition:enter="transition ease-out duration-300 transform"
                         x-transition:enter-start="opacity-0 -translate-x-12 scale-50"
                         x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                         x-transition:leave="transition ease-in duration-300 transform"
                         x-transition:leave-start="opacity-100 translate-x-0 scale-100"
                         x-transition:leave-end="opacity-0 -translate-x-12 scale-50"
                         class="fixed bottom-5 left-[4.25rem] sm:left-auto sm:bottom-10 sm:right-10 z-[9999]"
                         style="bottom: calc(1.25rem + env(safe-area-inset-bottom)) !important;">
                        <a href="{{ route('mentor.courses.create') }}" 
                           class="flex items-center h-11 w-11 sm:h-14 bg-white/75 dark:bg-[#151515]/75 backdrop-blur-3xl border border-white/70 dark:border-white/20 rounded-full text-blue-600 dark:text-blue-400 hover:scale-110 sm:hover:scale-105 active:scale-95 focus:outline-none transition-all duration-300 ease-out shadow-[0_8px_25px_rgba(0,0,0,0.08)] dark:shadow-[0_8px_32px_rgba(0,0,0,0.6),_inset_0_1px_1px_rgba(255,255,255,0.25)] overflow-hidden"
                           :class="scrolled ? 'w-11 sm:w-14' : 'w-11 sm:w-48'">
                            <div class="flex items-center justify-center w-11 h-11 sm:w-14 sm:h-14 shrink-0">
                                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                            </div>
                            <span class="hidden sm:inline font-bold text-[16px] whitespace-nowrap transition-opacity duration-500 pl-1 pr-6" 
                                  :class="scrolled ? 'opacity-0' : 'opacity-100 delay-200'">Tambah Kelas</span>
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
