<x-front-layout>
    <div class="pb-12 pt-4 sm:pt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div x-data="{ viewMode: localStorage.getItem('serviceViewMode') || 'grid' }" 
                 x-init="$watch('viewMode', val => localStorage.setItem('serviceViewMode', val))" 
                 class="flex flex-col lg:flex-row gap-6 lg:gap-8 relative">
                
                <!-- LEFT NAVIGATION: KATEGORI -->
                <div class="w-full lg:w-64 flex-shrink-0">
                    <div class="sticky top-[120px]">
                        <h2 class="text-xl font-black text-slate-800 mb-4 tracking-tight">Kategori Layanan</h2>
                        
                        <nav id="left-nav-categories" class="flex flex-col space-y-2 bg-white p-2 rounded-[20px] shadow-sm border border-slate-200/80">
                            <a href="{{ route('services.index', ['search' => request('search'), 'sort' => request('sort')]) }}"
                               class="category-link flex items-center justify-between px-4 py-3 text-sm font-bold rounded-xl transition-colors text-left {{ !request('category') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-3 {{ !request('category') ? 'text-indigo-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                    Semua Layanan
                                </div>
                            </a>
                            
                            @foreach($categories as $cat)
                                <a href="{{ route('services.index', ['category' => $cat->id, 'search' => request('search'), 'sort' => request('sort')]) }}"
                                   class="category-link flex items-center justify-between px-4 py-3 text-sm font-bold rounded-xl transition-colors text-left {{ request('category') == $cat->id ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-50' }}">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-3 {{ request('category') == $cat->id ? 'text-indigo-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                        {{ $cat->name }}
                                    </div>
                                    <span class="px-2 py-0.5 rounded-md bg-white text-indigo-600 text-[11px] border border-indigo-100 shadow-sm">{{ $cat->services()->where('is_active', true)->count() }}</span>
                                </a>
                            @endforeach
                        </nav>
                    </div>
                </div>

                <!-- CENTER CONTENT: DAFTAR LAYANAN -->
                <div class="flex-1 w-full min-w-0 transition-opacity duration-300" id="services-content-area">
                    
                    <!-- Search, Sort & Toggle Bar -->
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 mb-6">
                        <!-- Search Bar (Interactive) -->
                        <div x-data="{ open: {{ request('search') ? 'true' : 'false' }} }" class="relative flex items-center w-full sm:w-auto z-20" :class="open ? 'flex-1 sm:flex-none' : 'w-auto'">
                            <form id="search-form" action="{{ route('services.index') }}" method="GET" 
                                  class="flex items-center bg-white border border-slate-200/80 rounded-xl overflow-hidden shadow-sm transition-all duration-300"
                                  :class="open ? 'w-full sm:w-[280px] px-3 h-11 focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-500/20' : 'w-11 h-11 px-0 cursor-pointer hover:border-blue-200'">
                                
                                <button type="button" @click="open = true; setTimeout(() => $refs.searchInput.focus(), 100)" class="w-11 h-11 flex items-center justify-center shrink-0" :class="open ? 'pointer-events-none' : ''">
                                    <svg class="w-5 h-5" :class="open ? 'text-blue-500' : 'text-slate-500'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </button>

                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik pencarian..." 
                                       class="bg-transparent border-none text-[13px] focus:ring-0 font-medium w-full p-0 h-full transition-opacity duration-300"
                                       :class="open ? 'opacity-100 block' : 'opacity-0 hidden'"
                                       x-ref="searchInput">
                                
                                <button type="button" @click="open = false" x-show="open" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-red-500 transition-colors shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                                
                                @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                                @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                                <button type="submit" class="hidden">Cari</button>
                            </form>
                        </div>

                        <div class="flex items-center gap-3 w-full sm:w-auto shrink-0 justify-end">
                            <!-- Sort Dropdown (Icon) -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" @click.away="open = false" class="w-11 h-11 flex items-center justify-center bg-white shadow-sm border border-slate-200/80 text-slate-500 rounded-xl hover:text-blue-600 hover:border-blue-200 transition-colors" title="Urutkan">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                                </button>
                                
                                <div x-show="open" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 z-50 overflow-hidden" style="display: none;">
                                    <div class="px-3 py-2 text-[10px] font-black text-slate-400 uppercase tracking-[0.1em] bg-slate-50/50 border-b border-slate-100">Sortir Berdasarkan</div>
                                    <div class="p-1.5">
                                        <a href="?sort=latest&category={{ request('category') }}&search={{ request('search') }}" class="sort-link flex items-center px-2.5 py-2 text-[12px] font-bold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('sort') == 'latest' || !request('sort') ? 'text-blue-600 bg-blue-50/50' : '' }}">Terbaru</a>
                                        <a href="?sort=oldest&category={{ request('category') }}&search={{ request('search') }}" class="sort-link flex items-center px-2.5 py-2 text-[12px] font-bold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('sort') == 'oldest' ? 'text-blue-600 bg-blue-50/50' : '' }}">Terlama</a>
                                        <a href="?sort=name_asc&category={{ request('category') }}&search={{ request('search') }}" class="sort-link flex items-center px-2.5 py-2 text-[12px] font-bold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('sort') == 'name_asc' ? 'text-blue-600 bg-blue-50/50' : '' }}">Nama (A-Z)</a>
                                        <a href="?sort=name_desc&category={{ request('category') }}&search={{ request('search') }}" class="sort-link flex items-center px-2.5 py-2 text-[12px] font-bold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('sort') == 'name_desc' ? 'text-blue-600 bg-blue-50/50' : '' }}">Nama (Z-A)</a>
                                        <a href="?sort=price_asc&category={{ request('category') }}&search={{ request('search') }}" class="sort-link flex items-center px-2.5 py-2 text-[12px] font-bold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('sort') == 'price_asc' ? 'text-blue-600 bg-blue-50/50' : '' }}">Harga Termurah</a>
                                        <a href="?sort=price_desc&category={{ request('category') }}&search={{ request('search') }}" class="sort-link flex items-center px-2.5 py-2 text-[12px] font-bold text-slate-700 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors {{ request('sort') == 'price_desc' ? 'text-blue-600 bg-blue-50/50' : '' }}">Harga Termahal</a>
                                    </div>
                                </div>
                            </div>

                            <!-- View Toggles -->
                            <div class="flex items-center bg-white shadow-sm border border-slate-200/80 rounded-xl p-1 shrink-0 h-11">
                                <button @click="viewMode = 'grid'" class="w-9 h-full flex items-center justify-center rounded-lg transition-all" :class="viewMode === 'grid' ? 'bg-slate-100 text-blue-600 font-bold' : 'text-slate-400 hover:text-slate-600'">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                </button>
                                <button @click="viewMode = 'list'" class="w-9 h-full flex items-center justify-center rounded-lg transition-all" :class="viewMode === 'list' ? 'bg-slate-100 text-blue-600 font-bold' : 'text-slate-400 hover:text-slate-600'">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Services Container -->
                    <div>
                        <!-- GRID VIEW -->
                        <div x-show="viewMode === 'grid'" class="grid sm:grid-cols-2 gap-6">
                            @forelse ($services as $service)
                                <a href="{{ route('services.show', $service) }}" class="group flex flex-col bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                                    <div class="relative h-48 bg-slate-100 overflow-hidden shrink-0">
                                        @if($service->thumbnail)
                                            <img src="{{ Storage::url($service->thumbnail) }}" alt="{{ $service->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                        @else
                                            <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-50">
                                                <svg class="w-12 h-12 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                        <div class="absolute top-4 left-4 flex gap-2">
                                            <span class="inline-flex items-center px-3 py-1 rounded-xl text-[11px] font-bold bg-white/90 text-indigo-700 backdrop-blur-md shadow-sm border border-white/20">
                                                {{ $service->category->name }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="p-5 flex flex-col flex-1">
                                        <h3 class="text-lg font-black text-slate-800 mb-2 group-hover:text-blue-600 transition-colors leading-tight line-clamp-2">
                                            {{ $service->title }}
                                        </h3>
                                        <p class="text-slate-500 text-[13px] line-clamp-2 mb-4 flex-1">
                                            {{ $service->description }}
                                        </p>
                                        <div class="flex items-center text-[12px] font-semibold text-slate-500 mb-4 bg-slate-50 rounded-lg px-3 py-2 w-fit border border-slate-100">
                                            <svg class="w-4 h-4 text-slate-400 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Estimasi {{ $service->estimated_days }} Hari
                                        </div>
                                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between mt-auto">
                                            <span class="text-[11px] font-black uppercase tracking-wider text-slate-400">Mulai Dari</span>
                                            <span class="font-black text-lg text-blue-600">
                                                Rp{{ number_format($service->base_price, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="col-span-2 text-center py-16 bg-white rounded-[24px] border border-slate-200 border-dashed">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-700">Layanan Tidak Ditemukan</h3>
                                    <p class="text-slate-500 text-sm mt-1">Coba sesuaikan filter atau kata kunci pencarian Anda.</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- LIST VIEW -->
                        <div x-show="viewMode === 'list'" class="flex flex-col gap-4" style="display: none;">
                            @forelse ($services as $service)
                                <a href="{{ route('services.show', $service) }}" class="group flex flex-col sm:flex-row bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm hover:shadow-md transition-all duration-300">
                                    <div class="relative w-full sm:w-48 h-48 sm:h-auto bg-slate-100 overflow-hidden shrink-0">
                                        @if($service->thumbnail)
                                            <img src="{{ Storage::url($service->thumbnail) }}" alt="{{ $service->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                        @else
                                            <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-blue-50 to-indigo-50">
                                                <svg class="w-10 h-10 text-indigo-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            </div>
                                        @endif
                                        <div class="absolute top-3 left-3 flex sm:hidden gap-2">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-xl text-[10px] font-bold bg-white/90 text-indigo-700 backdrop-blur-md shadow-sm border border-white/20">
                                                {{ $service->category->name }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="p-5 flex flex-col flex-1 justify-center">
                                        <div class="flex items-start justify-between gap-4 mb-2">
                                            <div>
                                                <span class="hidden sm:inline-flex items-center px-2.5 py-1 rounded-xl text-[10px] font-bold bg-indigo-50 text-indigo-700 mb-2 border border-indigo-100">
                                                    {{ $service->category->name }}
                                                </span>
                                                <h3 class="text-xl font-black text-slate-800 group-hover:text-blue-600 transition-colors leading-tight">
                                                    {{ $service->title }}
                                                </h3>
                                            </div>
                                            <div class="text-right shrink-0">
                                                <span class="block text-[10px] font-black uppercase tracking-wider text-slate-400 mb-0.5">Mulai Dari</span>
                                                <span class="font-black text-xl text-blue-600">
                                                    Rp{{ number_format($service->base_price, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        </div>
                                        <p class="text-slate-500 text-[13px] line-clamp-2 mb-4 max-w-2xl">
                                            {{ $service->description }}
                                        </p>
                                        <div class="flex items-center gap-4 mt-auto">
                                            <div class="flex items-center text-[12px] font-semibold text-slate-600 bg-slate-50 rounded-lg px-3 py-1.5 border border-slate-200/60">
                                                <svg class="w-4 h-4 text-slate-400 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Estimasi {{ $service->estimated_days }} Hari
                                            </div>
                                            
                                            <div class="ml-auto flex items-center text-[12px] font-bold text-blue-600 group-hover:text-blue-700 transition-colors">
                                                Pesan Sekarang
                                                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="text-center py-16 bg-white rounded-[24px] border border-slate-200 border-dashed">
                                    <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-700">Layanan Tidak Ditemukan</h3>
                                    <p class="text-slate-500 text-sm mt-1">Coba sesuaikan filter atau kata kunci pencarian Anda.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Pagination -->
                    @if($services->hasPages())
                        <div class="mt-8 pagination-container">
                            {{ $services->links('vendor.pagination.tailwind') }}
                        </div>
                    @endif
                </div>

                <!-- RIGHT WIDGET: REKOMENDASI -->
                <div class="w-full lg:w-72 flex-shrink-0">
                    <div class="sticky top-[120px] flex flex-col gap-6">
                        
                        <div class="bg-gradient-to-br from-indigo-900 via-blue-900 to-slate-900 rounded-[24px] overflow-hidden shadow-lg border border-white/10 group"
                             x-data="{ 
                                activeSlide: 0, 
                                totalSlides: {{ count($recommendedServices) }}, 
                                timer: null,
                                startTimer() {
                                    this.timer = setInterval(() => {
                                        this.activeSlide = (this.activeSlide + 1) % this.totalSlides;
                                    }, 4000);
                                },
                                stopTimer() {
                                    clearInterval(this.timer);
                                }
                             }"
                             x-init="startTimer()"
                             @mouseenter="stopTimer()"
                             @mouseleave="startTimer()">
                            
                            <div class="relative z-10 p-5 pb-3">
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center backdrop-blur-md">
                                        <svg class="w-4 h-4 text-amber-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    </div>
                                    <h3 class="text-white font-black text-lg tracking-tight">Rekomendasi</h3>
                                </div>

                                <div class="relative overflow-hidden w-full h-[150px] rounded-xl border border-white/10 bg-white/5">
                                    @foreach($recommendedServices as $index => $recService)
                                        <div class="absolute inset-0 transition-all duration-500 ease-in-out"
                                             x-show="activeSlide === {{ $index }}"
                                             x-transition:enter="transition ease-out duration-500"
                                             x-transition:enter-start="opacity-0 translate-x-full"
                                             x-transition:enter-end="opacity-100 translate-x-0"
                                             x-transition:leave="transition ease-in duration-500"
                                             x-transition:leave-start="opacity-100 translate-x-0"
                                             x-transition:leave-end="opacity-0 -translate-x-full">
                                             
                                            <a href="{{ route('services.show', $recService) }}" class="block w-full h-full relative group/item">
                                                @if($recService->thumbnail)
                                                    <img src="{{ Storage::url($recService->thumbnail) }}" alt="" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center bg-indigo-900/50 text-white/50">
                                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    </div>
                                                @endif
                                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
                                                <div class="absolute bottom-0 left-0 right-0 p-3">
                                                    <div class="inline-flex items-center px-1.5 py-0.5 rounded text-[8px] font-bold bg-white/20 text-white backdrop-blur-md mb-1.5 border border-white/20">
                                                        {{ $recService->category->name }}
                                                    </div>
                                                    <h4 class="text-white text-[13px] font-bold line-clamp-2 leading-tight group-hover/item:text-blue-300 transition-colors">{{ $recService->title }}</h4>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Slider Indicators -->
                                <div class="flex justify-center gap-1.5 mt-3">
                                    @foreach($recommendedServices as $index => $recService)
                                        <button @click="activeSlide = {{ $index }}" 
                                                class="h-1.5 rounded-full transition-all duration-300"
                                                :class="activeSlide === {{ $index }} ? 'w-4 bg-white' : 'w-1.5 bg-white/30 hover:bg-white/50'">
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Info Widget -->
                        <div class="bg-gradient-to-b from-white to-slate-50 rounded-[24px] p-6 border border-slate-200/80 shadow-sm flex flex-col items-center text-center relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-100/50 rounded-full mix-blend-multiply filter blur-3xl translate-x-1/2 -translate-y-1/2"></div>
                            <div class="absolute bottom-0 left-0 w-32 h-32 bg-blue-100/50 rounded-full mix-blend-multiply filter blur-3xl -translate-x-1/2 translate-y-1/2"></div>
                            
                            <div class="relative w-12 h-12 bg-white/80 backdrop-blur shadow-sm text-indigo-600 rounded-[16px] flex items-center justify-center mb-4 border border-indigo-50">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                            </div>
                            <h3 class="relative text-slate-800 font-black text-[15px] tracking-tight mb-2">Masih Bingung?</h3>
                            <p class="relative text-slate-500 text-[12px] leading-relaxed mb-5">Konsultasikan kebutuhan proyek Anda bersama tim ahli kami.</p>
                            
                            <div class="relative w-full flex gap-2 mt-auto">
                                @php $waNumber = preg_replace('/[^0-9]/', '', \App\Models\Setting::where('key', 'whatsapp_number')->value('value') ?? '6281234567890'); @endphp
                                <a href="https://wa.me/{{ $waNumber }}" target="_blank" class="flex-1 flex justify-center items-center py-2.5 bg-[#25D366] hover:bg-[#128C7E] text-white rounded-[14px] transition-all shadow-sm hover:shadow-[#25D366]/30 hover:-translate-y-0.5" title="WhatsApp">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                                </a>
                                @php $igUrl = \App\Models\Setting::where('key', 'social_instagram')->value('value') ?? '#'; @endphp
                                <a href="{{ $igUrl }}" target="_blank" class="flex-1 flex justify-center items-center py-2.5 bg-gradient-to-tr from-[#FD1D1D] via-[#E1306C] to-[#C13584] hover:opacity-90 text-white rounded-[14px] transition-all shadow-sm hover:shadow-pink-500/30 hover:-translate-y-0.5" title="Instagram">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"></path></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- AJAX Filter Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let isFetching = false;
            
            const attachAjax = () => {
                const centerArea = document.getElementById('services-content-area');
                
                // Categories
                document.querySelectorAll('.category-link').forEach(link => {
                    link.addEventListener('click', async (e) => {
                        e.preventDefault();
                        await loadServices(link.href);
                    });
                });

                // Search form
                const searchForm = document.getElementById('search-form');
                if(searchForm) {
                    searchForm.addEventListener('submit', async (e) => {
                        e.preventDefault();
                        const url = new URL(searchForm.action);
                        const formData = new FormData(searchForm);
                        for (let [key, value] of formData.entries()) {
                            if(value) url.searchParams.set(key, value);
                        }
                        await loadServices(url.toString());
                    });
                }

                // Sort links
                document.querySelectorAll('.sort-link').forEach(link => {
                    link.addEventListener('click', async (e) => {
                        e.preventDefault();
                        await loadServices(link.href);
                    });
                });

                // Pagination
                document.querySelectorAll('.pagination-container a').forEach(link => {
                    link.addEventListener('click', async (e) => {
                        e.preventDefault();
                        await loadServices(link.href);
                    });
                });
            };

            const loadServices = async (url) => {
                if(isFetching) return;
                isFetching = true;
                
                const contentArea = document.getElementById('services-content-area');
                if(contentArea) contentArea.style.opacity = '0.4';
                
                try {
                    const response = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                    const html = await response.text();
                    
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    
                    // Update main content area
                    const newContentArea = doc.getElementById('services-content-area');
                    if(newContentArea && contentArea) {
                        contentArea.innerHTML = newContentArea.innerHTML;
                    }
                    
                    // Update left navigation to reflect active category
                    const oldNav = document.getElementById('left-nav-categories');
                    const newNav = doc.getElementById('left-nav-categories');
                    if(oldNav && newNav) {
                        oldNav.innerHTML = newNav.innerHTML;
                    }
                    
                    // Push state to browser history
                    window.history.pushState({}, '', url);
                    
                    // Re-attach listeners to new elements
                    attachAjax();
                    
                    if(contentArea) contentArea.style.opacity = '1';
                } catch(error) {
                    console.error('Error fetching data:', error);
                    window.location.href = url; // Fallback to normal navigation
                } finally {
                    isFetching = false;
                }
            };

            attachAjax();
            
            window.addEventListener('popstate', () => {
                loadServices(window.location.href);
            });
        });
    </script>
</x-front-layout>
