<x-app-layout disable-animation="true">
    <div class="h-auto flex flex-col relative overflow-visible">
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full flex-1 flex flex-col min-h-0 relative z-10"
             x-data="{ 
                mobileView: '{{ request()->routeIs('settings.index') ? 'menu' : 'content' }}',
                navTo(url) {
                    if (window.innerWidth < 1024) {
                        this.mobileView = 'content';
                        setTimeout(() => window.location.href = url, 300);
                    } else {
                        window.location.href = url;
                    }
                },
                goBack(url) {
                    if (window.innerWidth < 1024) {
                        this.mobileView = 'menu';
                        setTimeout(() => window.location.href = url, 300);
                    } else {
                        window.location.href = url;
                    }
                }
             }">
             
            <div class="grid grid-cols-1 lg:flex lg:flex-row gap-8 flex-1 min-h-0 h-auto overflow-visible">
                
                <!-- Left Sidebar Navigation -->
                <div class="col-start-1 row-start-1 w-full lg:w-64 flex-shrink-0 lg:border-r lg:border-slate-200/60 lg:pr-6 overflow-visible lg:overflow-y-auto custom-scrollbar pt-6 lg:pt-8 pb-8 z-20 bg-slate-50 dark:bg-black lg:bg-transparent lg:border-slate-200/60 dark:lg:border-white/10 transition-transform duration-300 ease-in-out lg:sticky lg:top-[105px] lg:h-[calc(100vh-105px)]"
                     :class="mobileView === 'menu' ? 'translate-x-0' : '-translate-x-[110%] lg:translate-x-0'">
                    
                    <!-- Navigation Links -->
                    <div class="bg-white/40 dark:bg-[#151515]/40 lg:bg-transparent backdrop-blur-md lg:backdrop-blur-none rounded-2xl shadow-sm lg:shadow-none border border-white/60 dark:border-white/10 lg:border-none p-2 lg:p-0 flex flex-col gap-2 transition-all">
                        
                        <!-- Header & Akun -->
                        <div class="px-3 pb-2 pt-2 lg:pt-0">
                            <h1 class="text-2xl lg:text-3xl font-extrabold text-slate-800 dark:text-white tracking-tight drop-shadow-sm mb-6">Pengaturan</h1>
                            <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Akun</p>
                        </div>

                        <a href="{{ route('settings.profile') }}" @click.prevent="navTo('{{ route('settings.profile') }}')" class="group flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-[13px] transition-all duration-300 {{ request()->routeIs('settings.profile') ? 'bg-white dark:bg-[#1c1c1e] text-slate-800 dark:text-white shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] border border-slate-200/50 dark:border-white/10' : 'text-slate-500 dark:text-slate-400 hover:bg-white/60 dark:hover:bg-white/10 hover:text-slate-800 dark:hover:text-white' }}">
                            <div class="p-1.5 rounded-lg transition-colors {{ request()->routeIs('settings.profile') ? 'bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400' : 'bg-transparent text-slate-400 dark:text-slate-500 group-hover:bg-indigo-50/60 dark:group-hover:bg-indigo-950/20 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
                            </div>
                            <span>Profil Saya</span>
                            <svg class="w-4 h-4 ml-auto transition-all duration-300 {{ request()->routeIs('settings.profile') ? 'text-slate-400 translate-x-0 opacity-100' : 'text-slate-300 -translate-x-2 opacity-0 group-hover:translate-x-0 group-hover:opacity-100' }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                        </a>
                        
                        <a href="{{ route('settings.security') }}" @click.prevent="navTo('{{ route('settings.security') }}')" class="group flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-[13px] transition-all duration-300 {{ request()->routeIs('settings.security') ? 'bg-white dark:bg-[#1c1c1e] text-slate-800 dark:text-white shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] border border-slate-200/50 dark:border-white/10' : 'text-slate-500 dark:text-slate-400 hover:bg-white/60 dark:hover:bg-white/10 hover:text-slate-800 dark:hover:text-white' }}">
                            <div class="p-1.5 rounded-lg transition-colors {{ request()->routeIs('settings.security') ? 'bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400' : 'bg-transparent text-slate-400 dark:text-slate-500 group-hover:bg-indigo-50/60 dark:group-hover:bg-indigo-950/20 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" /></svg>
                            </div>
                            <span>Keamanan</span>
                            <svg class="w-4 h-4 ml-auto transition-all duration-300 {{ request()->routeIs('settings.security') ? 'text-slate-400 translate-x-0 opacity-100' : 'text-slate-300 -translate-x-2 opacity-0 group-hover:translate-x-0 group-hover:opacity-100' }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                        </a>
 
                        @if(auth()->check() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('super-admin')))
                            <div class="px-3 pb-2 pt-4">
                                <p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Administrasi</p>
                            </div>
 
                            <a href="{{ route('settings.landing') }}" @click.prevent="navTo('{{ route('settings.landing') }}')" class="group flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-[13px] transition-all duration-300 {{ request()->routeIs('settings.landing') ? 'bg-white dark:bg-[#1c1c1e] text-slate-800 dark:text-white shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] border border-slate-200/50 dark:border-white/10' : 'text-slate-500 dark:text-slate-400 hover:bg-white/60 dark:hover:bg-white/10 hover:text-slate-800 dark:hover:text-white' }}">
                                <div class="p-1.5 rounded-lg transition-colors {{ request()->routeIs('settings.landing') ? 'bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400' : 'bg-transparent text-slate-400 dark:text-slate-500 group-hover:bg-indigo-50/60 dark:group-hover:bg-indigo-950/20 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" /></svg>
                                </div>
                                <span>Personalisasi</span>
                                <svg class="w-4 h-4 ml-auto transition-all duration-300 {{ request()->routeIs('settings.landing') ? 'text-slate-400 translate-x-0 opacity-100' : 'text-slate-300 -translate-x-2 opacity-0 group-hover:translate-x-0 group-hover:opacity-100' }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                            </a>
 
                            <a href="{{ route('settings.services') }}" @click.prevent="navTo('{{ route('settings.services') }}')" class="group flex items-center gap-3 px-4 py-3 rounded-xl font-semibold text-[13px] transition-all duration-300 {{ request()->routeIs('settings.services') ? 'bg-white dark:bg-[#1c1c1e] text-slate-800 dark:text-white shadow-[0_2px_10px_-3px_rgba(0,0,0,0.05)] border border-slate-200/50 dark:border-white/10' : 'text-slate-500 dark:text-slate-400 hover:bg-white/60 dark:hover:bg-white/10 hover:text-slate-800 dark:hover:text-white' }}">
                                <div class="p-1.5 rounded-lg transition-colors {{ request()->routeIs('settings.services') ? 'bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400' : 'bg-transparent text-slate-400 dark:text-slate-500 group-hover:bg-indigo-50/60 dark:group-hover:bg-indigo-950/20 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" /><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" /></svg>
                                </div>
                                <span>Layanan</span>
                                <svg class="w-4 h-4 ml-auto transition-all duration-300 {{ request()->routeIs('settings.services') ? 'text-slate-400 translate-x-0 opacity-100' : 'text-slate-300 -translate-x-2 opacity-0 group-hover:translate-x-0 group-hover:opacity-100' }}" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" /></svg>
                            </a>

                        @endif
                    </div>
                </div>

                <!-- Right Content Area -->
                <div class="col-start-1 row-start-1 w-full flex-1 overflow-visible custom-scrollbar lg:pl-2 pt-6 lg:pt-8 pb-8 h-auto z-10 bg-slate-50 dark:bg-black lg:bg-transparent transition-transform duration-300 ease-in-out"
                     :class="mobileView === 'content' ? 'translate-x-0' : 'translate-x-[110%] lg:translate-x-0'">
                    
                    <!-- Content Area (Back button removed to rely on navbar) -->

                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
