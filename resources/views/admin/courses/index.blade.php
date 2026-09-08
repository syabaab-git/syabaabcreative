<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <h2 class="font-bold text-2xl text-slate-800 leading-tight tracking-tight">
                    Manajemen Kursus
                </h2>
            <div></div>
        </div>
    </x-slot>

    <!-- Init Alpine Data checking URL parameters so pagination keeps the tab active -->
    <div class="py-8 bg-slate-50/50 min-h-screen" 
         x-data="{ 
            activeTab: new URLSearchParams(window.location.search).has('mentor_page') ? 'mentor' : (new URLSearchParams(window.location.search).has('student_page') ? 'siswa' : (new URLSearchParams(window.location.search).get('tab') || 'kelas')),
            viewMode: localStorage.getItem('courseViewMode') || 'list'
         }"
         x-init="$watch('viewMode', val => localStorage.setItem('courseViewMode', val))">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Top Header: Tabs & Actions -->
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
                <!-- Tabs Navigation -->
                <div>
                    <div class="sm:hidden mb-4 lg:mb-0">
                        <label for="tabs" class="sr-only">Pilih Tab</label>
                        <select id="tabs" name="tabs" class="block w-full rounded-2xl border-slate-300 py-3 pl-4 pr-10 text-base focus:border-blue-500 focus:ring-blue-500" x-model="activeTab" @change="window.history.replaceState(null, null, '?tab=' + activeTab)">
                            <option value="kelas">Manajemen Kelas</option>
                            <option value="mentor">Data Mentor</option>
                            <option value="siswa">Data Siswa</option>
                        </select>
                    </div>
                    <div class="hidden sm:block">
                        <div class="flex items-center gap-2">
                            <nav class="flex space-x-2 bg-white p-2 rounded-[20px] border border-slate-200/80 shadow-sm w-fit" aria-label="Tabs">
                                <button @click="activeTab = 'kelas'; window.history.replaceState(null, null, '?tab=kelas')"
                                        :class="{'bg-blue-50 text-blue-700 shadow-sm ring-1 ring-blue-700/10': activeTab === 'kelas', 'text-slate-500 hover:text-slate-700 hover:bg-slate-50': activeTab !== 'kelas'}"
                                        class="px-6 py-2.5 rounded-[14px] font-bold text-[14px] transition-all duration-300 flex items-center gap-2.5">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    Kelas <span class="ml-1 px-2 py-0.5 rounded-md bg-white text-blue-600 text-[11px] border border-blue-100 shadow-sm">{{ $courses->total() }}</span>
                                </button>
                                
                                <button @click="activeTab = 'mentor'; window.history.replaceState(null, null, '?tab=mentor')"
                                        :class="{'bg-blue-50 text-blue-700 shadow-sm ring-1 ring-blue-700/10': activeTab === 'mentor', 'text-slate-500 hover:text-slate-700 hover:bg-slate-50': activeTab !== 'mentor'}"
                                        class="px-6 py-2.5 rounded-[14px] font-bold text-[14px] transition-all duration-300 flex items-center gap-2.5">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    Mentor <span class="ml-1 px-2 py-0.5 rounded-md bg-white text-blue-600 text-[11px] border border-blue-100 shadow-sm">{{ $mentors->total() }}</span>
                                </button>
                                
                                <button @click="activeTab = 'siswa'; window.history.replaceState(null, null, '?tab=siswa')"
                                        :class="{'bg-blue-50 text-blue-700 shadow-sm ring-1 ring-blue-700/10': activeTab === 'siswa', 'text-slate-500 hover:text-slate-700 hover:bg-slate-50': activeTab !== 'siswa'}"
                                        class="px-6 py-2.5 rounded-[14px] font-bold text-[14px] transition-all duration-300 flex items-center gap-2.5">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    Siswa <span class="ml-1 px-2 py-0.5 rounded-md bg-white text-blue-600 text-[11px] border border-blue-100 shadow-sm">{{ $students->total() }}</span>
                                </button>
                            </nav>
                            
                            <div class="bg-white p-2 rounded-[20px] border border-slate-200/80 shadow-sm flex items-center shrink-0 h-full">
                                <a href="{{ route('admin.course-categories.index') }}" class="group flex items-center justify-center px-4 py-2.5 rounded-[14px] text-slate-500 hover:bg-blue-50 hover:text-blue-600 transition-all duration-300" title="Kelola Kategori Kursus">
                                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions: Search, Sort & Toggles -->
                <div class="flex items-center gap-3 self-end lg:self-auto">
                    
                    <!-- Expandable Search -->
                    <form action="{{ route('admin.courses.index') }}" method="GET" x-data="{ searchOpen: '{{ request('search') }}' !== '' }" class="flex items-center">
                        <div @click.away="if($refs.searchInput.value === '') searchOpen = false" 
                             class="flex items-center bg-white border shadow-sm rounded-xl overflow-hidden transition-all duration-300 ease-out"
                             :class="searchOpen ? 'w-64 sm:w-80 border-blue-400 ring-4 ring-blue-500/10' : 'w-10 border-slate-200/60 hover:border-blue-300'">
                            <button type="button" @click="if(!searchOpen) { searchOpen = true; $nextTick(() => $refs.searchInput.focus()) } else if ($refs.searchInput.value) { $el.closest('form').submit() }" 
                                    class="flex-shrink-0 w-10 h-10 flex items-center justify-center transition-colors bg-transparent z-10 cursor-pointer"
                                    :class="searchOpen ? 'text-blue-600' : 'text-slate-500 hover:text-blue-600'">
                                <svg class="w-5 h-5 transition-transform duration-300 ease-out" :class="searchOpen ? 'scale-95' : 'scale-100 hover:scale-110'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </button>
                            <input x-ref="searchInput" @keydown.enter="$el.closest('form').submit()" type="text" name="search" value="{{ request('search') }}" 
                                   :placeholder="'Cari ' + (activeTab === 'kelas' ? 'kursus' : activeTab) + '...'"
                                   class="bg-transparent border-none text-[13px] focus:ring-0 font-medium transition-all duration-300 ease-out flex-1 min-w-0"
                                   :class="searchOpen ? 'opacity-100 pr-3 pl-1 w-full translate-x-0' : 'opacity-0 w-0 p-0 -translate-x-2 pointer-events-none'">
                        </div>
                        <input type="hidden" name="tab" :value="activeTab">
                        @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                        @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                    </form>

                    <!-- Sort & Filter Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="w-10 h-10 flex items-center justify-center bg-white border border-slate-200/60 shadow-sm text-slate-500 rounded-xl hover:text-blue-600 hover:border-blue-300 transition-colors" title="Filter & Sortir">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        </button>
                        
                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" style="display: none;" class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 z-50 overflow-hidden">
                            <div class="px-4 py-3 text-[11px] font-black text-slate-400 uppercase tracking-[0.1em] bg-slate-50/50 border-b border-slate-100">Sortir Berdasarkan</div>
                            <div class="p-2">
                                <a :href="`?tab=${activeTab}&sort=latest&search={{ request('search') }}`" class="flex items-center px-3 py-2.5 text-[13px] font-bold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('sort') == 'latest' || !request('sort') ? 'text-blue-600 bg-blue-50/50' : '' }}">
                                    <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-2.5 opacity-0 {{ request('sort') == 'latest' || !request('sort') ? 'opacity-100' : '' }}"></div>
                                    Terbaru
                                </a>
                                <a :href="`?tab=${activeTab}&sort=oldest&search={{ request('search') }}`" class="flex items-center px-3 py-2.5 text-[13px] font-bold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('sort') == 'oldest' ? 'text-blue-600 bg-blue-50/50' : '' }}">
                                    <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-2.5 opacity-0 {{ request('sort') == 'oldest' ? 'opacity-100' : '' }}"></div>
                                    Terlama
                                </a>
                                <div class="mt-1 pt-1 border-t border-slate-50">
                                    <a :href="`?tab=${activeTab}&sort=name_asc&search={{ request('search') }}`" class="flex items-center px-3 py-2.5 text-[13px] font-bold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('sort') == 'name_asc' ? 'text-blue-600 bg-blue-50/50' : '' }}">
                                        <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-2.5 opacity-0 {{ request('sort') == 'name_asc' ? 'opacity-100' : '' }}"></div>
                                        Nama (A-Z)
                                    </a>
                                    <a :href="`?tab=${activeTab}&sort=name_desc&search={{ request('search') }}`" class="flex items-center px-3 py-2.5 text-[13px] font-bold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('sort') == 'name_desc' ? 'text-blue-600 bg-blue-50/50' : '' }}">
                                        <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-2.5 opacity-0 {{ request('sort') == 'name_desc' ? 'opacity-100' : '' }}"></div>
                                        Nama (Z-A)
                                    </a>
                                </div>
                            </div>
                            <template x-if="activeTab === 'kelas'">
                                <div>
                                    <div class="px-4 py-3 text-[11px] font-black text-slate-400 uppercase tracking-[0.1em] bg-slate-50/50 border-y border-slate-100">Kategori</div>
                                    <div class="p-2 max-h-48 overflow-y-auto">
                                        <a :href="`?tab=${activeTab}&category=&search={{ request('search') }}`" class="flex items-center px-3 py-2.5 text-[13px] font-bold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ !request('category') ? 'text-blue-600 bg-blue-50/50' : '' }}">
                                            <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-2.5 opacity-0 {{ !request('category') ? 'opacity-100' : '' }}"></div>
                                            Semua Kategori
                                        </a>
                                        @foreach($categories as $category)
                                            <a :href="`?tab=${activeTab}&category={{ $category->id }}&search={{ request('search') }}`" class="flex items-center px-3 py-2.5 text-[13px] font-bold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('category') == $category->id ? 'text-blue-600 bg-blue-50/50' : '' }}">
                                                <div class="w-1.5 h-1.5 rounded-full bg-blue-500 mr-2.5 opacity-0 {{ request('category') == $category->id ? 'opacity-100' : '' }}"></div>
                                                {{ $category->name }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="w-px h-6 bg-slate-200" x-show="activeTab !== 'siswa'"></div>

                    <!-- View Toggles (Only show for Kelas and Mentor) -->
                    <div x-show="activeTab !== 'siswa'" class="flex items-center bg-white border border-slate-200/60 shadow-sm rounded-xl p-1" style="display: none;">
                        <button @click="viewMode = 'grid'" :class="viewMode === 'grid' ? 'bg-slate-100 text-blue-600 shadow-sm' : 'text-slate-400 hover:text-slate-600'" class="w-8 h-8 flex items-center justify-center rounded-lg transition-all" title="Tampilan Kartu">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        </button>
                        <button @click="viewMode = 'list'" :class="viewMode === 'list' ? 'bg-slate-100 text-blue-600 shadow-sm' : 'text-slate-400 hover:text-slate-600'" class="w-8 h-8 flex items-center justify-center rounded-lg transition-all" title="Tampilan Memanjang">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tab Content: Kelas -->
            <div x-show="activeTab === 'kelas'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                @if($courses->isEmpty())
                    <div class="bg-white rounded-[24px] border border-slate-200/80 p-16 text-center shadow-sm">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h4 class="text-[20px] font-bold text-slate-900 mb-2">Belum Ada Kursus</h4>
                        <p class="text-slate-500 text-[15px] mb-8 max-w-md mx-auto">Mulai buat kelas pertamamu sekarang.</p>
                    </div>
                @else
                    <!-- Grid View -->
                    <div x-show="viewMode === 'grid'" style="display: none;" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($courses as $course)
                            <div class="group bg-white rounded-[24px] border border-slate-200/60 p-4 hover:border-blue-300 hover:shadow-[0_8px_30px_rgba(37,99,235,0.06)] transition-all duration-300 flex flex-col relative overflow-hidden">
                                <!-- Thumbnail -->
                                <div class="w-full h-40 relative rounded-[16px] overflow-hidden bg-slate-100 mb-4">
                                    @if($course->thumbnail)
                                        <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-300 bg-gradient-to-br from-slate-50 to-slate-100">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        </div>
                                    @endif
                                    
                                    <!-- Badges Top -->
                                    <div class="absolute top-3 left-3 flex flex-wrap gap-2">
                                        <span class="bg-white/95 backdrop-blur-md px-2.5 py-1 rounded-lg text-[10px] font-extrabold text-slate-800 shadow-sm border border-white">
                                            {{ $course->category->name ?? 'Uncategorized' }}
                                        </span>
                                        <span class="bg-white/95 backdrop-blur-md px-2.5 py-1 rounded-lg text-[10px] font-extrabold text-slate-800 shadow-sm border border-white">
                                            {{ $course->level }}
                                        </span>
                                    </div>
                                    <div class="absolute top-3 right-3">
                                        @if($course->is_published)
                                            <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-emerald-600 bg-emerald-50/95 backdrop-blur-md px-2 py-1 rounded-lg shadow-sm border border-emerald-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Published
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-amber-600 bg-amber-50/95 backdrop-blur-md px-2 py-1 rounded-lg shadow-sm border border-amber-100">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                Draft
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="flex-1 flex flex-col">
                                    <h3 class="text-[17px] font-bold text-slate-800 mb-2 leading-tight group-hover:text-blue-600 transition-colors line-clamp-2">
                                        {{ $course->title }}
                                    </h3>

                                    <div class="mt-auto pt-4 border-t border-slate-100 flex items-end justify-between">
                                        <div>
                                            <div class="text-[10px] font-extrabold text-slate-400 uppercase tracking-wider mb-0.5">Biaya</div>
                                            <div class="text-[16px] font-bold {{ $course->price == 0 ? 'text-emerald-600' : 'text-blue-600' }}">
                                                @if($course->price == 0)
                                                    Gratis
                                                @else
                                                    Rp{{ number_format($course->price, 0, ',', '.') }}
                                                @endif
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="flex items-center gap-1 text-[11px] font-bold text-slate-500 bg-slate-50 px-2 py-1 rounded-md border border-slate-100 max-w-[120px] truncate">
                                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                {{ optional($course->mentor)->name ?? 'Tanpa Mentor' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Hover Actions Overlay -->
                                <div class="absolute inset-0 bg-white/60 backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center gap-3">
                                    <a href="{{ route('admin.courses.show', $course) }}" class="w-12 h-12 flex items-center justify-center bg-white text-slate-700 rounded-full hover:bg-slate-800 hover:text-white transition-all duration-300 shadow-[0_8px_20px_rgba(0,0,0,0.15)] hover:shadow-[0_8px_20px_rgba(0,0,0,0.3)] hover:-translate-y-1" title="Lihat Peserta">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <a href="{{ route('admin.courses.edit', $course) }}" class="w-12 h-12 flex items-center justify-center bg-white text-blue-600 rounded-full hover:bg-blue-600 hover:text-white transition-all duration-300 shadow-[0_8px_20px_rgba(37,99,235,0.15)] hover:shadow-[0_8px_20px_rgba(37,99,235,0.3)] hover:-translate-y-1" title="Edit Kursus">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kursus ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-12 h-12 flex items-center justify-center bg-white text-red-600 rounded-full hover:bg-red-600 hover:text-white transition-all duration-300 shadow-[0_8px_20px_rgba(239,68,68,0.15)] hover:shadow-[0_8px_20px_rgba(239,68,68,0.3)] hover:-translate-y-1" title="Hapus Kursus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- List View (Memanjang) -->
                    <div x-show="viewMode === 'list'" class="flex flex-col gap-5">
                        @foreach ($courses as $course)
                            <div class="group bg-white rounded-[16px] border border-slate-200/60 p-3 hover:border-slate-300 hover:shadow-[0_4px_20px_rgba(0,0,0,0.03)] transition-all duration-300 flex flex-col sm:flex-row items-center gap-5">
                                
                                <!-- Thumbnail -->
                                <div class="w-full sm:w-40 h-24 flex-shrink-0 relative rounded-[10px] overflow-hidden bg-slate-100">
                                    @if($course->thumbnail)
                                        <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-slate-300">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        </div>
                                    @endif
                                </div>

                                <!-- Main Content -->
                                <div class="flex-1 flex flex-col justify-center min-w-0 py-1 w-full">
                                    <!-- Badges -->
                                    <div class="flex items-center gap-2 mb-1.5">
                                        @if($course->is_published)
                                            <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-emerald-600 bg-emerald-50/80 px-2 py-0.5 rounded-md">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                                Published
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-amber-600 bg-amber-50/80 px-2 py-0.5 rounded-md">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                                Draft
                                            </span>
                                        @endif
                                        <span class="text-[10px] font-semibold text-slate-500 border border-slate-200 px-2 py-0.5 rounded-md bg-white">
                                            {{ $course->category->name ?? 'Uncategorized' }}
                                        </span>
                                        <span class="text-[10px] font-semibold text-slate-500 border border-slate-200 px-2 py-0.5 rounded-md bg-white">
                                            {{ $course->level }}
                                        </span>
                                    </div>
                                    
                                    <!-- Title -->
                                    <h3 class="text-[16px] font-bold text-slate-800 mb-1.5 truncate group-hover:text-blue-600 transition-colors">
                                        {{ $course->title }}
                                    </h3>
                                    
                                    <!-- Meta Data -->
                                    <div class="flex items-center gap-3 text-[12px] text-slate-500 font-medium mt-auto">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            <span class="truncate max-w-[120px]">{{ optional($course->mentor)->name ?? 'Tanpa Mentor' }}</span>
                                        </div>
                                        <div class="w-1 h-1 rounded-full bg-slate-300"></div>
                                        <div class="flex items-center font-bold {{ $course->price == 0 ? 'text-emerald-600' : 'text-slate-800' }}">
                                            @if($course->price == 0)
                                                Gratis
                                            @else
                                                Rp{{ number_format($course->price, 0, ',', '.') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="flex items-center gap-2 mt-3 sm:mt-0 shrink-0">
                                    <a href="{{ route('admin.courses.show', $course) }}" class="w-9 h-9 flex items-center justify-center bg-white border border-slate-200 text-slate-500 rounded-xl hover:bg-slate-50 hover:text-slate-800 hover:border-slate-300 transition-all duration-200" title="Lihat Peserta">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <a href="{{ route('admin.courses.edit', $course) }}" class="w-9 h-9 flex items-center justify-center bg-white border border-slate-200 text-slate-500 rounded-xl hover:bg-slate-50 hover:text-slate-800 hover:border-slate-300 transition-all duration-200" title="Edit Kursus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kursus ini? Semua data terkait juga akan terhapus.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-9 h-9 flex items-center justify-center bg-white border border-slate-200 text-slate-500 rounded-xl hover:bg-red-50 hover:text-red-600 hover:border-red-200 transition-all duration-200" title="Hapus Kursus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($courses->hasPages())
                        <div class="mt-8">
                            {{ $courses->appends(['tab' => 'kelas'])->links() }}
                        </div>
                    @endif
                @endif
            </div>

            <!-- Tab Content: Mentor -->
            <div x-show="activeTab === 'mentor'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <!-- Grid View -->
                <div x-show="viewMode === 'grid'" style="display: none;" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($mentors as $mentor)
                        <div class="bg-white border border-slate-200/80 rounded-[24px] p-6 hover:shadow-lg hover:-translate-y-1 hover:border-blue-200 transition-all duration-300 group">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex items-center gap-4">
                                    @if($mentor->avatar)
                                        <img src="{{ asset('storage/' . $mentor->avatar) }}" alt="{{ $mentor->name }}" class="w-14 h-14 rounded-[14px] object-cover border border-slate-200 shadow-sm">
                                    @else
                                        <div class="w-14 h-14 rounded-[14px] bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center text-blue-600 font-bold text-xl border border-blue-200/50 shadow-sm">
                                            {{ substr($mentor->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <h3 class="text-[16px] font-bold text-slate-800 leading-tight group-hover:text-blue-600 transition-colors">{{ $mentor->name }}</h3>
                                        <p class="text-[13px] font-medium text-slate-500 mt-1">{{ $mentor->email }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('admin.users.edit', $mentor) }}" class="p-2 bg-slate-50 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-colors border border-transparent hover:border-blue-100" title="Edit Profil">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                            </div>
                            
                            <div class="pt-4 mt-2 border-t border-slate-100 flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="text-[11px] font-extrabold text-slate-400 uppercase tracking-widest">Total Kelas</span>
                                    <span class="text-[16px] font-bold text-slate-800 mt-0.5">{{ $mentor->courses_count ?? 0 }} Kelas</span>
                                </div>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold bg-indigo-50 text-indigo-600 border border-indigo-100">
                                    Mentor
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-16 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-400">
                                <svg class="w-16 h-16 mb-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <h3 class="text-xl font-bold text-slate-700 mb-2">Belum Ada Mentor</h3>
                                <p class="text-slate-500">Daftar mentor yang mengajar akan tampil di sini.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- List View -->
                <div x-show="viewMode === 'list'" style="display: none;" class="flex flex-col gap-4">
                    @forelse ($mentors as $mentor)
                        <div class="group bg-white rounded-[16px] border border-slate-200/60 p-4 hover:border-slate-300 hover:shadow-[0_4px_20px_rgba(0,0,0,0.03)] transition-all duration-300 flex flex-col sm:flex-row items-center gap-5">
                            
                            <!-- Avatar -->
                            <div class="w-14 h-14 flex-shrink-0 relative rounded-[14px] overflow-hidden bg-slate-100">
                                @if($mentor->avatar)
                                    <img src="{{ asset('storage/' . $mentor->avatar) }}" alt="{{ $mentor->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out border border-slate-200">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-100 to-indigo-100 flex items-center justify-center text-blue-600 font-bold text-xl border border-blue-200/50">
                                        {{ substr($mentor->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>

                            <!-- Main Content -->
                            <div class="flex-1 flex flex-col justify-center min-w-0 py-1 w-full">
                                <h3 class="text-[16px] font-bold text-slate-800 mb-1 truncate group-hover:text-blue-600 transition-colors">
                                    {{ $mentor->name }}
                                </h3>
                                
                                <div class="flex items-center gap-3 text-[12px] text-slate-500 font-medium mt-auto">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        <span class="truncate">{{ $mentor->email }}</span>
                                    </div>
                                    <div class="w-1 h-1 rounded-full bg-slate-300"></div>
                                    <div class="flex items-center font-bold text-slate-700">
                                        {{ $mentor->courses_count ?? 0 }} Kelas
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center gap-2 mt-3 sm:mt-0 shrink-0">
                                <span class="hidden sm:inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-bold bg-indigo-50 text-indigo-600 border border-indigo-100 mr-2">
                                    Mentor
                                </span>
                                <a href="{{ route('admin.users.edit', $mentor) }}" class="w-9 h-9 flex items-center justify-center bg-white border border-slate-200 text-slate-500 rounded-xl hover:bg-slate-50 hover:text-slate-800 hover:border-slate-300 transition-all duration-200" title="Edit Profil">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-16 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-400">
                                <svg class="w-16 h-16 mb-4 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                <h3 class="text-xl font-bold text-slate-700 mb-2">Belum Ada Mentor</h3>
                                <p class="text-slate-500">Daftar mentor yang mengajar akan tampil di sini.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
                @if($mentors->hasPages())
                    <div class="mt-8">
                        {{ $mentors->appends(['tab' => 'mentor'])->links() }}
                    </div>
                @endif
            </div>

            <!-- Tab Content: Siswa -->
            <div x-show="activeTab === 'siswa'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" style="display: none;">
                <div class="bg-white overflow-hidden shadow-sm border border-slate-200/60 rounded-[24px]">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200/80">
                            <thead class="bg-slate-50/80">
                                <tr>
                                    <th scope="col" class="px-6 py-5 text-left text-[11px] font-extrabold text-slate-500 uppercase tracking-widest">Profil Siswa</th>
                                    <th scope="col" class="px-6 py-5 text-left text-[11px] font-extrabold text-slate-500 uppercase tracking-widest">Kontak</th>
                                    <th scope="col" class="px-6 py-5 text-left text-[11px] font-extrabold text-slate-500 uppercase tracking-widest">Kelas yang Diikuti</th>
                                    <th scope="col" class="px-6 py-5 text-right text-[11px] font-extrabold text-slate-500 uppercase tracking-widest">Bergabung</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-100">
                                @forelse ($students as $student)
                                    <tr class="hover:bg-slate-50/50 transition-colors duration-200 group">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-4">
                                                @if($student->avatar)
                                                    <img src="{{ asset('storage/' . $student->avatar) }}" alt="{{ $student->name }}" class="w-10 h-10 rounded-full object-cover border border-slate-200 shadow-sm">
                                                @else
                                                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold border border-slate-200 shadow-sm">
                                                        {{ substr($student->name, 0, 1) }}
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="text-[14px] font-bold text-slate-800">{{ $student->name }}</div>
                                                    <div class="text-[11px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md mt-1 w-fit border border-blue-100">Member</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-[13px] font-medium text-slate-600">{{ $student->email }}</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($student->enrollments->count() > 0)
                                                <div class="flex flex-wrap gap-2 max-w-[280px]">
                                                    @foreach($student->enrollments->take(2) as $enrollment)
                                                        @if(optional($enrollment->course)->title)
                                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-100 truncate max-w-[130px]" title="{{ $enrollment->course->title }}">
                                                                {{ $enrollment->course->title }}
                                                            </span>
                                                        @endif
                                                    @endforeach
                                                    @if($student->enrollments->count() > 2)
                                                        <span class="inline-flex items-center px-2 py-1 rounded-lg text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200" title="Dan {{ $student->enrollments->count() - 2 }} kelas lainnya">
                                                            +{{ $student->enrollments->count() - 2 }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-[12px] font-medium text-slate-400 italic">Belum ada kelas</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            <div class="text-[13px] font-semibold text-slate-800">{{ $student->created_at->format('d M Y') }}</div>
                                            <div class="text-[11px] font-medium text-slate-400 mt-1">{{ $student->created_at->diffForHumans() }}</div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-16 text-center">
                                            <div class="flex flex-col items-center justify-center text-slate-400">
                                                <div class="w-16 h-16 rounded-2xl bg-slate-50 border border-slate-100 flex items-center justify-center mb-4">
                                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                                </div>
                                                <p class="text-[14px] font-bold text-slate-600">Belum Ada Siswa</p>
                                                <p class="text-[13px] font-medium mt-1">Data siswa akan muncul saat ada pendaftaran kursus.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($students->hasPages())
                        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                            {{ $students->appends(['tab' => 'siswa'])->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- Floating Action Button -->
        <div x-data="{ scrolled: false, show: false }"
             x-init="setTimeout(() => show = true, 500)"
             x-show="show && activeTab !== 'siswa'"
             @scroll.window="scrolled = (window.pageYOffset > 50)"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 -translate-x-12 scale-50"
             x-transition:enter-end="opacity-100 translate-x-0 scale-100"
             x-transition:leave="transition ease-in duration-300 transform"
             x-transition:leave-start="opacity-100 translate-x-0 scale-100"
             x-transition:leave-end="opacity-0 -translate-x-12 scale-50"
             class="fixed bottom-5 left-[4.25rem] sm:left-auto sm:bottom-10 sm:right-10 z-[9999]" style="display: none; bottom: calc(1.25rem + env(safe-area-inset-bottom)) !important;">
            <a :href="activeTab === 'mentor' ? '{{ route('admin.users.create') }}' : '{{ route('admin.courses.create') }}'" 
               class="flex items-center h-11 w-11 sm:h-14 bg-white/75 dark:bg-[#151515]/75 backdrop-blur-3xl border border-white/70 dark:border-white/20 rounded-full text-blue-600 dark:text-blue-400 hover:scale-110 sm:hover:scale-105 active:scale-95 focus:outline-none transition-all duration-300 ease-out shadow-[0_8px_25px_rgba(0,0,0,0.08)] dark:shadow-[0_8px_32px_rgba(0,0,0,0.6),_inset_0_1px_1px_rgba(255,255,255,0.25)] overflow-hidden"
               :class="scrolled ? 'w-11 sm:w-14' : (activeTab === 'mentor' ? 'w-11 sm:w-[200px]' : 'w-11 sm:w-[170px]')">
                <div class="flex items-center justify-center w-11 h-11 sm:w-14 sm:h-14 shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                </div>
                <span class="hidden sm:inline font-bold text-[16px] whitespace-nowrap transition-opacity duration-500 pl-1 pr-6" 
                      :class="scrolled ? 'opacity-0' : 'opacity-100 delay-200'" 
                      x-text="activeTab === 'mentor' ? 'Tambah Mentor' : 'Kelas Baru'"></span>
            </a>
        </div>
    </div>
</x-app-layout>
