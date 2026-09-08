<nav x-data="{ 
    activeDropdown: null,
    isSwitching: false,
    scrolled: window.scrollY > 10,
    previewSeenUrl: @js(route('notifications.previewSeen')),
    darkMode: document.documentElement.classList.contains('dark'),
    activeMobileTab: 'home',
    get activeMobileIndexAuth() {
        if (this.activeDropdown === 'search') return 1;
        if (this.activeDropdown === 'notif') return 2;
        if (this.activeMobileTab === 'search') return 1;
        if (this.activeMobileTab === 'notif') return 2;
        return 0;
    },
    get activeMobileIndexGuest() {
        if (this.activeDropdown === 'search') return 1;
        if (window.location.pathname.includes('/login') || this.activeMobileTab === 'login') return 2;
        if (this.activeMobileTab === 'search') return 1;
        return 0;
    },
    toggleDarkMode() {
        this.darkMode = !this.darkMode;
        if (this.darkMode) {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        } else {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        }
    },
    toggleDropdown(panel) {
        if (this.activeDropdown === panel) {
            this.isSwitching = false;
            this.activeDropdown = null;
        } else {
            if (this.activeDropdown !== null) {
                this.isSwitching = true;
            } else {
                this.isSwitching = false;
            }
            this.activeDropdown = panel;
            this.$nextTick(() => {
                document.querySelectorAll('.dropdown-scroll-area').forEach(el => el.scrollTop = 0);
            });
            // Mark notification previews as seen when opening notif dropdown
            if (panel === 'notif') {
                fetch(this.previewSeenUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json',
                    }
                }).catch(() => {});
            }
        }
    },
    closeAll() {
        this.isSwitching = false;
        this.activeDropdown = null;
    }
}" 
x-init="
    $watch('activeDropdown', value => window.dispatchEvent(new CustomEvent('nav-dropdown-changed', { detail: { open: value !== null } })));
"
@scroll.window="scrolled = (window.scrollY > 10)"
class="fixed top-0 inset-x-0 w-full z-[50] transition-all duration-500"
:class="scrolled ? 'border-b-0 sm:border-b border-transparent sm:border-gray-200/30 sm:dark:border-white/10 bg-transparent sm:bg-white/80 sm:dark:bg-black/80 backdrop-blur-none sm:backdrop-blur-2xl shadow-none sm:shadow-sm' : 'border-b-0 sm:border-b border-transparent bg-transparent sm:bg-white/40 sm:dark:bg-[#151515]/40 backdrop-blur-none sm:backdrop-blur-md'">
    <div class="px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto relative z-[70]">
        <div class="flex justify-between items-center h-16 relative">
            <div class="flex items-center gap-1.5 sm:gap-2 z-[90]">

                @php
                    $isDark = false;
                    $textColor = 'text-slate-500 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white';
                    $logoText1 = 'text-slate-800 dark:text-white';
                    $logoText2 = 'text-blue-600 dark:text-blue-400';
                    $searchBg = 'bg-white/50 dark:bg-white/10 border-gray-200/50 dark:border-white/10 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:bg-white dark:focus:bg-white/20 focus:ring-indigo-500 focus:border-indigo-500';
                    $btnText = 'text-slate-500 dark:text-gray-300 hover:text-slate-800 dark:hover:text-white hover:bg-slate-50 dark:hover:bg-white/10';
                    
                    // Dropdown adaptive colors
                    $ddLinkHover = 'hover:bg-slate-100 dark:hover:bg-white/15 hover:text-indigo-600 dark:hover:text-white';
                    $ddIconBg = 'bg-white/60 dark:bg-white/10 text-slate-600 dark:text-gray-300 border border-slate-200 dark:border-white/5';
                    $ddIconHoverBg = 'group-hover:bg-blue-50 dark:group-hover:bg-white/25 group-hover:text-blue-600 dark:group-hover:text-white group-hover:border-blue-200 dark:group-hover:border-white/10';
                    $ddText = 'text-slate-800 dark:text-gray-100 group-hover:text-blue-700 dark:group-hover:text-white font-medium';
                    $ddHeader = 'text-slate-600 dark:text-gray-300 drop-shadow-sm dark:drop-shadow-md';
                    $ddDivider = 'border-slate-200 dark:border-white/10';
                    $tileBg = 'bg-white/80 dark:bg-[#151515]/60 border-white/70 dark:border-white/20 shadow-[0_4px_16px_rgba(0,0,0,0.06)] dark:shadow-[0_4px_20px_rgba(0,0,0,0.6)] text-slate-800 dark:text-gray-100 hover:bg-white dark:hover:bg-[#151515]/90 hover:border-blue-200 dark:hover:border-white/20 hover:text-blue-700 dark:hover:text-white backdrop-blur-3xl';
                    $sectionBg = 'bg-white/80 dark:bg-[#151515]/60 border-white/70 dark:border-white/20 shadow-[0_8px_32px_rgba(0,0,0,0.12)] dark:shadow-[0_8px_32px_rgba(0,0,0,0.6),_inset_0_1px_1px_rgba(255,255,255,0.2)] backdrop-blur-3xl';
                    
                    $showBackButton = !request()->routeIs('dashboard') && !request()->routeIs('*.dashboard') && !request()->routeIs('landing');
                    $isLearningPage = request()->routeIs('member.learning.*');
                    $startX = $showBackButton ? '-translate-x-4' : 'translate-x-4';
                    $isSettingsPage = request()->is('settings*');
                    $isCatalogPage = request()->routeIs('services.index') || request()->routeIs('services.show');
                    $animateCondition = ($showBackButton && !$isLearningPage && !$isSettingsPage && !$isCatalogPage) ? 'true' : "false";
                    
                    $fallbackUrl = '/';
                    if (auth()->check()) {
                        $user = auth()->user();
                        if ($user->hasRole('admin')) {
                            $fallbackUrl = route('admin.dashboard');
                        } elseif ($user->hasRole('member')) {
                            $fallbackUrl = route('member.dashboard');
                        } elseif ($user->hasRole('agency-staff') || $user->hasRole('staff')) {
                            $fallbackUrl = route('staff.dashboard');
                        } elseif ($user->hasRole('mentor')) {
                            $fallbackUrl = route('mentor.dashboard');
                        } else {
                            // Fallback jika ada role lain
                            $fallbackUrl = url('/dashboard');
                        }
                    }

                    $backUrl = "window.history.length > 1 ? window.history.back() : window.location.href='{$fallbackUrl}'";
                    if (request()->routeIs('member.learning.assignment.show')) {
                        $courseId = request()->route('course');
                        $backUrl = "window.location.href='" . route('member.learning.show', $courseId) . "?tab=tugas'";
                    } elseif ($isLearningPage) {
                        $backUrl = "window.location.href='" . route('member.dashboard') . "'";
                    } elseif ($isSettingsPage) {
                        if (request()->routeIs('settings.index')) {
                            $backUrl = "window.location.href='{$fallbackUrl}'";
                        } else {
                            $backUrl = "if (window.innerWidth < 1024) { window.location.href='" . route('settings.index') . "' } else { window.location.href='{$fallbackUrl}' }";
                        }
                    } elseif (request()->routeIs('admin.services.index') || request()->routeIs('admin.courses.index') || request()->routeIs('mentor.courses.index') || request()->routeIs('admin.users.index') || request()->routeIs('mentor.courses.show') || request()->routeIs('admin.orders.history') || request()->routeIs('staff.orders.history')) {
                        $backUrl = "window.location.href='{$fallbackUrl}'";
                    } elseif (request()->routeIs('services.index')) {
                        $backUrl = "window.location.href='{$fallbackUrl}?tab=layanan'";
                    } elseif (request()->routeIs('services.show')) {
                        $backUrl = "window.location.href='" . route('services.index') . "'";
                    } elseif (request()->routeIs('member.orders.show') || request()->routeIs('admin.orders.show') || request()->routeIs('staff.orders.show')) {
                        $backUrl = "window.location.href='{$fallbackUrl}?tab=layanan'";
                    } elseif (request()->routeIs('member.testimonials.index')) {
                        $backUrl = "window.location.href='{$fallbackUrl}'";
                    }
                @endphp

                @if($showBackButton)
                    <div x-data="{ 
                            showBack: false,
                            shouldAnimate: {{ $animateCondition }}
                         }" 
                         x-init="if(shouldAnimate) setTimeout(() => showBack = true, 50); else showBack = true;">
                        <button onclick="{!! $backUrl !!}" 
                           class="group mr-1 sm:mr-3 h-10 w-10 rounded-full flex items-center justify-center bg-white/70 dark:bg-[#151515]/40 backdrop-blur-2xl border border-white/60 dark:border-white/20 shadow-[0_4px_16px_rgba(0,0,0,0.08)] dark:shadow-[0_4px_16px_rgba(0,0,0,0.6),_inset_0_1px_1px_rgba(255,255,255,0.2)] text-slate-700 hover:text-blue-600 dark:text-slate-200 dark:hover:text-blue-400 hover:scale-110 active:scale-95 transition-all duration-300 focus:outline-none" 
                           :class="shouldAnimate && !showBack ? 'opacity-0 -translate-x-4' : 'opacity-100 translate-x-0'"
                           title="Kembali">
                            <svg class="w-5 h-5 transform group-hover:-translate-x-1 transition-transform duration-300 ease-out" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        </button>
                    </div>
                @endif

                @auth
                @if(!$showBackButton)
                    <!-- Expanded Glassmorphic Capsule with Avatar + First Name when Back button is NOT present -->
                    <button @click="toggleDropdown('profile')" class="inline-flex sm:hidden items-center p-0.5 pr-3 gap-2 rounded-full bg-white/70 dark:bg-[#151515]/40 backdrop-blur-2xl border border-white/60 dark:border-white/20 shadow-[0_4px_16px_rgba(0,0,0,0.08)] dark:shadow-[0_4px_16px_rgba(0,0,0,0.6),_inset_0_1px_1px_rgba(255,255,255,0.2)] focus:outline-none transition-all duration-300 ease-out z-[70] hover:scale-105 active:scale-95" title="Profil">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="h-9 w-9 rounded-full object-cover border border-slate-200/50 dark:border-white/10 shadow-sm">
                        @else
                            <div class="h-9 w-9 rounded-full bg-gradient-to-tr from-slate-200 to-slate-300 text-slate-600 dark:from-slate-800 dark:to-slate-900 dark:text-slate-300 flex items-center justify-center font-bold text-sm shadow-sm border border-transparent dark:border-white/10">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        @endif
                        <span class="text-xs font-bold text-slate-800 dark:text-slate-100 max-w-[85px] truncate leading-none ml-0.5">
                            {{ explode(' ', Auth::user()->name)[0] }}
                        </span>
                    </button>
                @else
                    <!-- Compact Circular Profile Bubble when Back button IS present -->
                    <button @click="toggleDropdown('profile')" class="inline-flex sm:hidden items-center p-0.5 rounded-full bg-white/70 dark:bg-[#151515]/40 backdrop-blur-2xl border border-white/60 dark:border-white/20 shadow-[0_4px_16px_rgba(0,0,0,0.08)] dark:shadow-[0_4px_16px_rgba(0,0,0,0.6),_inset_0_1px_1px_rgba(255,255,255,0.2)] focus:outline-none transition-all duration-300 ease-out z-[70] hover:scale-110 active:scale-95" title="Profil">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="h-9 w-9 rounded-full object-cover border border-slate-200/50 dark:border-white/10 shadow-sm">
                        @else
                            <div class="h-9 w-9 rounded-full bg-gradient-to-tr from-slate-200 to-slate-300 text-slate-600 dark:from-slate-800 dark:to-slate-900 dark:text-slate-300 flex items-center justify-center font-bold text-sm shadow-sm border border-transparent dark:border-white/10">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        @endif
                    </button>
                @endif
                @endauth
                <!-- Desktop Plain Title (Left-aligned next to back button, static) -->
                <div class="hidden sm:flex items-center ml-2">
                    <a href="{{ route('dashboard') }}" title="Kembali ke Halaman Utama" 
                       class="flex flex-col justify-center">
                        <span class="text-xl font-bold {{ $logoText1 }} leading-none tracking-tight">Syabaab</span>
                        <span class="text-[10px] font-semibold {{ $logoText2 }} uppercase tracking-widest leading-none mt-1">Creative Platform</span>
                    </a>
                </div>
            </div>

            <!-- Mobile Centered Title Glassmorphic Capsule (Mobile Only - Static without entry animation) -->
            <div class="sm:hidden absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 flex items-center justify-center pointer-events-auto z-10">
                <a href="{{ route('dashboard') }}" title="Kembali ke Halaman Utama" 
                   class="flex flex-col justify-center items-center px-4 py-1.5 rounded-full bg-white/70 dark:bg-[#151515]/40 backdrop-blur-2xl border border-white/60 dark:border-white/20 shadow-[0_4px_16px_rgba(0,0,0,0.08)] dark:shadow-[0_4px_16px_rgba(0,0,0,0.6),_inset_0_1px_1px_rgba(255,255,255,0.2)]">
                    <span class="text-lg font-bold {{ $logoText1 }} leading-none tracking-tight">Syabaab</span>
                    <span class="text-[9px] font-semibold {{ $logoText2 }} uppercase tracking-widest leading-none mt-1">Creative Platform</span>
                </a>
            </div>

            <div class="hidden md:flex flex-1 max-w-md mx-8 items-center" 
                 x-data="{ 
                    showSearch: false, 
                    shouldAnimate: {{ $animateCondition }} 
                 }" 
                 x-init="if(shouldAnimate) setTimeout(() => showSearch = true, 50); else showSearch = true;">
                <form action="{{ route('search') }}" method="GET" 
                      class="w-full relative transition-all duration-500 ease-out transform"
                      :class="shouldAnimate && !showSearch ? 'opacity-0 {{ $startX }}' : 'opacity-100 translate-x-0'">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 {{ $isDark ? 'text-gray-400' : 'text-gray-400' }}" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 100 13.5 6.75 6.75 0 000-13.5zM2.25 10.5a8.25 8.25 0 1114.59 5.28l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A8.25 8.25 0 012.25 10.5z" clip-rule="evenodd" /></svg>
                    </div>
                    <input type="text" name="q" class="block w-full pl-10 pr-4 py-2 border rounded-full leading-5 sm:text-sm transition-all {{ $searchBg }}" placeholder="Pencarian...">
                </form>
            </div>

            <div class="flex items-center space-x-6">

                <style>
                    /* Safe area handling for mobile */
                    .mobile-nav-container {
                        position: fixed !important;
                        bottom: calc(1.5rem + env(safe-area-inset-bottom)) !important;
                    }
                    .mobile-nav-container a,
                    .mobile-nav-container button,
                    .mobile-nav-container a:hover,
                    .mobile-nav-container button:hover,
                    .mobile-nav-container a:focus,
                    .mobile-nav-container button:focus,
                    .mobile-nav-container a:active,
                    .mobile-nav-container button:active {
                        background: transparent !important;
                        background-color: transparent !important;
                        box-shadow: none !important;
                        border-color: transparent !important;
                        outline: none !important;
                        -webkit-tap-highlight-color: transparent !important;
                    }
                    @media (max-width: 639px) {
                        .mobile-popup-container {
                            bottom: calc(6rem + env(safe-area-inset-bottom)) !important;
                        }
                    }
 
                    /* Elegant micro-thin scrollbar for dropdown menus */
                    .dropdown-scroll-area::-webkit-scrollbar {
                        width: 4px !important;
                    }
                    .dropdown-scroll-area::-webkit-scrollbar-track {
                        background: transparent !important;
                    }
                    .dropdown-scroll-area::-webkit-scrollbar-thumb {
                        background: rgba(156, 163, 175, 0.3) !important;
                        border-radius: 20px !important;
                    }
                    .dropdown-scroll-area::-webkit-scrollbar-thumb:hover {
                        background: rgba(156, 163, 175, 0.5) !important;
                    }
                    .dark .dropdown-scroll-area::-webkit-scrollbar-thumb {
                        background: rgba(255, 255, 255, 0.15) !important;
                    }
                    .dark .dropdown-scroll-area::-webkit-scrollbar-thumb:hover {
                        background: rgba(255, 255, 255, 0.3) !important;
                    }

                    .popup-transition-active {
                        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
                    }

                    @media (min-width: 640px) {
                        .anim-vertical .popup-start, .anim-vertical .popup-leave-to {
                            transform: translateY(-20px) scale(0.96);
                            filter: blur(8px);
                        }
                    }
                    @media (max-width: 639px) {
                        .anim-vertical .popup-start, .anim-vertical .popup-leave-to {
                            transform: translateY(20px) scale(0.96);
                        }
                    }
                    .anim-vertical .popup-start, .anim-vertical .popup-leave-to {
                        opacity: 0;
                    }

                    /* Depth transition when switching */
                    .anim-switch .popup-transition-active {
                        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.3s cubic-bezier(0.16, 1, 0.3, 1);
                    }
                    
                    /* Entering popup (slides in and fades) */
                    .anim-switch .cart-start,
                    .anim-switch .notif-start,
                    .anim-switch .profile-start {
                        opacity: 0;
                        transform: translateX(30px);
                    }
                    
                    /* Leaving popup (slides out and fades) */
                    .anim-switch .cart-leave-to,
                    .anim-switch .notif-leave-to,
                    .anim-switch .profile-leave-to {
                        opacity: 0;
                        transform: translateX(-30px);
                    }
                    
                    /* End state for all */
                    .popup-end {
                        opacity: 1;
                        transform: translate(0, 0) scale(1);
                        filter: blur(0);
                    }
                </style>

                <template x-teleport="body">
                    <!-- Subtle Mobile Top Edge Fade Mask -->
                    <div class="sm:hidden fixed top-0 inset-x-0 h-16 pointer-events-none z-[35] bg-gradient-to-b from-[#fbfbfd] via-[#fbfbfd]/50 to-transparent dark:from-black dark:via-black/80 dark:to-transparent"></div>
                </template>

                <template x-teleport="body">
                    <!-- Subtle Mobile Bottom Edge Fade Mask (Identical size and opacity curve as top edge fade) -->
                    <div class="sm:hidden fixed bottom-0 inset-x-0 pointer-events-none z-[35] bg-gradient-to-t from-[#fbfbfd] via-[#fbfbfd]/50 to-transparent dark:from-black dark:via-black/50 dark:to-transparent"
                         style="height: calc(3rem + env(safe-area-inset-bottom, 0px));"></div>
                </template>

                @if(!request()->routeIs('member.courses.show'))
                <template x-teleport="body">
                    <!-- Mobile Floating Bottom Bar with Individual Glassmorphic Refraction Buttons -->
                    <div class="sm:hidden fixed inset-x-0 bottom-5 px-4 z-[9999] pointer-events-none flex justify-between items-center select-none"
                         style="bottom: calc(1.25rem + env(safe-area-inset-bottom)) !important;">
                        
                        <!-- Left Side: Search Button -->
                        <div class="pointer-events-auto">
                            <button @click="toggleDropdown('search')" 
                                    class="flex items-center justify-center h-11 w-11 rounded-full bg-white/70 dark:bg-[#151515]/40 backdrop-blur-2xl border border-white/60 dark:border-white/20 shadow-[0_8px_25px_rgba(0,0,0,0.1)] dark:shadow-[0_8px_32px_rgba(0,0,0,0.6),_inset_0_1px_1px_rgba(255,255,255,0.2)] text-slate-700 hover:text-slate-900 dark:text-slate-200 dark:hover:text-white hover:scale-110 active:scale-95 transition-all duration-300 focus:outline-none"
                                    :class="activeDropdown === 'search' ? 'ring-2 ring-blue-500/50 text-blue-600 dark:text-white' : ''"
                                    title="Cari">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 100 13.5 6.75 6.75 0 000-13.5zM2.25 10.5a8.25 8.25 0 1114.59 5.28l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A8.25 8.25 0 012.25 10.5z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>

                        <!-- Right Side: Home & Back to Top Unified Glass Capsule -->
                        <div class="pointer-events-auto flex items-center h-11 p-1 rounded-full bg-white/70 dark:bg-[#151515]/40 backdrop-blur-2xl border border-white/60 dark:border-white/20 shadow-[0_8px_25px_rgba(0,0,0,0.1)] dark:shadow-[0_8px_32px_rgba(0,0,0,0.6),_inset_0_1px_1px_rgba(255,255,255,0.2)]">
                            <!-- Home Button -->
                            <a href="{{ auth()->check() ? route('dashboard') : route('landing') }}" 
                               @click="closeAll()"
                               class="flex items-center justify-center h-9 w-9 rounded-full text-slate-700 hover:text-slate-900 dark:text-slate-200 dark:hover:text-white hover:bg-white/60 dark:hover:bg-white/10 active:scale-95 transition-all duration-300 focus:outline-none"
                               title="Beranda">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 11-1.06 1.06l-.92-.92V19.5a1.5 1.5 0 01-1.5 1.5h-4.5a.75.75 0 01-.75-.75V15h-3v4.55a.75.75 0 01-.75.75H4.5A1.5 1.5 0 013 18.75V12.67l-.92.92a.75.75 0 11-1.06-1.06l8.69-8.69z"/>
                                </svg>
                            </a>

                            <div class="h-4 w-px bg-slate-300/60 dark:bg-white/15 mx-0.5"></div>

                            <!-- Back to Top Button -->
                            <button @click="window.scrollTo({ top: 0, behavior: 'smooth' })" 
                                    class="flex items-center justify-center h-9 w-9 rounded-full text-slate-700 hover:text-slate-900 dark:text-slate-200 dark:hover:text-white hover:bg-white/60 dark:hover:bg-white/10 active:scale-95 transition-all duration-300 focus:outline-none"
                                    title="Kembali ke Atas">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                </svg>
                            </button>
                        </div>

                    </div>
                </template>
                @endif

                @auth
                @php
                    $unreadCount = auth()->user()->unreadNotifications->count();
                    $notifications = auth()->user()->notifications()->take(5)->get();
                @endphp
                
                <div class="flex items-center space-x-2 sm:space-x-4 z-[90]">
                    
                    <template x-teleport="body">
                        <div x-show="activeDropdown !== null" 
                             @click="closeAll()"
                              x-transition:enter="transition-all duration-200 ease-[cubic-bezier(0.16,1,0.3,1)]"
                              x-transition:enter-start="opacity-0"
                              x-transition:enter-end="opacity-100"
                              x-transition:leave="transition-all duration-150 ease-[cubic-bezier(0.16,1,0.3,1)]"
                              x-transition:leave-start="opacity-100"
                              x-transition:leave-end="opacity-0"
                              class="fixed inset-0 z-[40] bg-slate-900/15 dark:bg-black/40 backdrop-blur-[3px] sm:backdrop-blur-sm cursor-default will-change-transform" 
                              style="display: none;"></div>
                    </template>
 
                    <!-- Theme Toggle (desktop only) -->
                    <button @click="toggleDarkMode()" class="hidden sm:flex relative items-center justify-center h-10 w-10 rounded-full bg-white/70 dark:bg-[#151515]/40 backdrop-blur-2xl border border-white/60 dark:border-white/20 shadow-[0_4px_16px_rgba(0,0,0,0.08)] dark:shadow-[0_4px_16px_rgba(0,0,0,0.6),_inset_0_1px_1px_rgba(255,255,255,0.2)] text-slate-700 hover:text-slate-900 dark:text-slate-200 dark:hover:text-white hover:scale-110 active:scale-95 transition-all duration-300 z-[70] focus:outline-none" title="Ubah Tema">
                        <svg x-show="darkMode" class="absolute w-6 h-6 text-amber-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 7.5a4.5 4.5 0 1 1 0 9 4.5 4.5 0 0 1 0-9z M12 2l2 4.5h-4z M12 22l2-4.5h-4z M2 12l4.5-2v4z M22 12l-4.5-2v4z M4.93 4.93l3.18 1.41l-1.41 3.18z M19.07 19.07l-3.18-1.41l1.41-3.18z M19.07 4.93l-1.41 3.18l-3.18-1.41z M4.93 19.07l1.41-3.18l3.18 1.41z" /></svg>
                        <svg x-show="!darkMode" class="absolute w-6 h-6 text-slate-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M9.528 1.718a.75.75 0 0 1 .162.819A8.97 8.97 0 009 6a9 9 0 009 9 8.97 8.97 0 003.463-.69.75.75 0 0 1 .981.98 10.503 10.503 0 0 1-9.694 6.46c-5.799 0-10.5-4.701-10.5-10.5 0-4.368 2.667-8.112 6.46-9.694a.75.75 0 0 1 .818.162z" /></svg>
                    </button>
 
                    <!-- Notif Toggle (visible on mobile and desktop) -->
                    <button @click="toggleDropdown('notif')" class="flex relative items-center justify-center h-10 w-10 rounded-full bg-white/70 dark:bg-[#151515]/40 backdrop-blur-2xl border border-white/60 dark:border-white/20 shadow-[0_4px_16px_rgba(0,0,0,0.08)] dark:shadow-[0_4px_16px_rgba(0,0,0,0.6),_inset_0_1px_1px_rgba(255,255,255,0.2)] text-slate-700 hover:text-slate-900 dark:text-slate-200 dark:hover:text-white hover:scale-110 active:scale-95 transition-all duration-300 z-[70] focus:outline-none" title="Notifikasi">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M5.25 9a6.75 6.75 0 0113.5 0v.75c0 2.123.8 4.057 2.118 5.52a.75.75 0 01-.297 1.206c-1.544.57-3.16.99-4.831 1.243a3.75 3.75 0 11-7.48 0 24.585 24.585 0 01-4.831-1.244.75.75 0 01-.298-1.205A8.217 8.217 0 005.25 9.75V9zm4.502 8.9a2.25 2.25 0 104.496 0 25.057 25.057 0 01-4.496 0z" clip-rule="evenodd" /></svg>
                        @if($unreadCount > 0)
                        <span class="absolute top-1 right-2 block h-2.5 w-2.5 rounded-full ring-2 ring-white dark:ring-black bg-red-500 transform translate-x-1 -translate-y-1"></span>
                        @endif
                    </button>

                    <!-- Profile Button (visible on desktop) -->
                    <button @click="toggleDropdown('profile')" class="hidden sm:inline-flex items-center p-0.5 rounded-full bg-white/70 dark:bg-[#151515]/40 backdrop-blur-2xl border border-white/60 dark:border-white/20 shadow-[0_4px_16px_rgba(0,0,0,0.08)] dark:shadow-[0_4px_16px_rgba(0,0,0,0.6),_inset_0_1px_1px_rgba(255,255,255,0.2)] focus:outline-none transition ease-in-out duration-150 z-[70] hover:scale-110 active:scale-95 duration-300" title="Profil">
                        @if(Auth::user()->avatar)
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}" class="h-9 w-9 rounded-full object-cover border border-slate-200/50 dark:border-white/10 shadow-sm">
                        @else
                            <div class="h-9 w-9 rounded-full bg-gradient-to-tr from-slate-200 to-slate-300 text-slate-600 dark:from-slate-800 dark:to-slate-900 dark:text-slate-300 flex items-center justify-center font-bold text-sm shadow-sm border border-transparent dark:border-white/10">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        @endif
                    </button>

                    <!-- Mobile Three-dot Menu Button (On top right on mobile) -->
                    <button @click="toggleDropdown('more')" class="flex sm:hidden items-center justify-center h-10 w-10 rounded-full bg-white/70 dark:bg-[#151515]/40 backdrop-blur-2xl border border-white/60 dark:border-white/20 shadow-[0_4px_16px_rgba(0,0,0,0.08)] dark:shadow-[0_4px_16px_rgba(0,0,0,0.6),_inset_0_1px_1px_rgba(255,255,255,0.2)] text-slate-700 hover:text-slate-900 dark:text-slate-200 dark:hover:text-white hover:scale-110 active:scale-95 transition-all duration-300 focus:outline-none z-[90]" :class="activeDropdown === 'more' ? 'ring-2 ring-blue-500/50 text-blue-600 dark:text-white' : ''" title="Menu">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M10.5 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm0 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm0 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z" clip-rule="evenodd" /></svg>
                    </button>
                </div>
                @else
                <div class="flex items-center space-x-2 sm:space-x-4 z-[90]">
                    <button @click="toggleDarkMode()" class="hidden sm:flex relative items-center justify-center h-10 w-10 rounded-full bg-white/70 dark:bg-[#151515]/40 backdrop-blur-2xl border border-white/60 dark:border-white/20 shadow-[0_4px_16px_rgba(0,0,0,0.08)] dark:shadow-[0_4px_16px_rgba(0,0,0,0.6),_inset_0_1px_1px_rgba(255,255,255,0.2)] text-slate-700 hover:text-slate-900 dark:text-slate-200 dark:hover:text-white hover:scale-110 active:scale-95 transition-all duration-300 z-[70] focus:outline-none" title="Ubah Tema">
                        <svg x-show="darkMode" class="absolute w-6 h-6 text-amber-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 7.5a4.5 4.5 0 1 1 0 9 4.5 4.5 0 0 1 0-9z M12 2l2 4.5h-4z M12 22l2-4.5h-4z M2 12l4.5-2v4z M22 12l-4.5-2v4z M4.93 4.93l3.18 1.41l-1.41 3.18z M19.07 19.07l-3.18-1.41l1.41-3.18z M19.07 4.93l-1.41 3.18l-3.18-1.41z M4.93 19.07l1.41-3.18l3.18 1.41z" /></svg>
                        <svg x-show="!darkMode" class="absolute w-6 h-6 text-slate-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M9.528 1.718a.75.75 0 0 1 .162.819A8.97 8.97 0 009 6a9 9 0 009 9 8.97 8.97 0 003.463-.69.75.75 0 0 1 .981.98 10.503 10.503 0 0 1-9.694 6.46c-5.799 0-10.5-4.701-10.5-10.5 0-4.368 2.667-8.112 6.46-9.694a.75.75 0 0 1 .818.162z" /></svg>
                    </button>
                    <div class="hidden sm:flex sm:items-center space-x-4">
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium transition {{ $textColor }}">Log In</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-500 text-white text-sm font-medium rounded-full transition-colors shadow-sm">Sign Up</a>
                    </div>
                    <!-- Mobile Three-dot Menu Button for Guest -->
                    <button @click="toggleDropdown('more')" class="flex sm:hidden items-center justify-center h-10 w-10 rounded-full bg-white/70 dark:bg-[#151515]/40 backdrop-blur-2xl border border-white/60 dark:border-white/20 shadow-[0_4px_16px_rgba(0,0,0,0.08)] dark:shadow-[0_4px_16px_rgba(0,0,0,0.6),_inset_0_1px_1px_rgba(255,255,255,0.2)] text-slate-700 hover:text-slate-900 dark:text-slate-200 dark:hover:text-white hover:scale-110 active:scale-95 transition-all duration-300 focus:outline-none z-[90]" :class="activeDropdown === 'more' ? 'ring-2 ring-blue-500/50 text-blue-600 dark:text-white' : ''" title="Menu">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path fill-rule="evenodd" d="M10.5 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm0 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zm0 6a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z" clip-rule="evenodd" /></svg>
                    </button>
                </div>
                @endauth

                <template x-teleport="body">
                    <!-- Mobile Three-dot Dropdown Popup -->
                    <div x-show="activeDropdown === 'more'"
                         x-transition:enter="transition ease-out duration-300 transform origin-top-right"
                         x-transition:enter-start="opacity-0 scale-75 translate-y-[20px] sm:translate-y-[-20px] translate-x-[20px]"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0 translate-x-0"
                         x-transition:leave="transition ease-in duration-200 transform origin-top-right"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0 translate-x-0"
                         x-transition:leave-end="opacity-0 scale-75 translate-y-[20px] sm:translate-y-[-20px] translate-x-[20px]"
                         class="fixed top-16 right-4 sm:right-6 z-[120] w-52 max-h-[80vh] overflow-y-auto rounded-[20px] border {{ $sectionBg }} flex flex-col p-1.5 gap-0.5 pointer-events-auto sm:hidden shadow-[0_8px_32px_rgba(0,0,0,0.12)] scrollbar-hide"
                         style="display: none;"
                         @click.away="closeAll()">
                        
                        <!-- Ubah Tema (Mobile Only inside Dropdown) -->
                        <button @click="toggleDarkMode()" class="w-full flex items-center justify-between px-4 py-2 text-sm font-semibold rounded-lg {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                            <span class="flex items-center gap-2">
                                <svg x-show="darkMode" class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 7.5a4.5 4.5 0 1 1 0 9 4.5 4.5 0 0 1 0-9z M12 2l2 4.5h-4z M12 22l2-4.5h-4z M2 12l4.5-2v4z M22 12l-4.5-2v4z M4.93 4.93l3.18 1.41l-1.41 3.18z M19.07 19.07l-3.18-1.41l1.41-3.18z M19.07 4.93l-1.41 3.18l-3.18-1.41z M4.93 19.07l1.41-3.18l3.18 1.41z" /></svg>
                                <svg x-show="!darkMode" class="w-4 h-4 text-slate-600 dark:text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M9.528 1.718a.75.75 0 0 1 .162.819A8.97 8.97 0 009 6a9 9 0 009 9 8.97 8.97 0 003.463-.69.75.75 0 0 1 .981.98 10.503 10.503 0 0 1-9.694 6.46c-5.799 0-10.5-4.701-10.5-10.5 0-4.368 2.667-8.112 6.46-9.694a.75.75 0 0 1 .818.162z" /></svg>
                                <span x-text="darkMode ? 'Mode Terang' : 'Mode Gelap'"></span>
                            </span>
                        </button>
                        <div class="h-px border-t {{ $ddDivider }} my-1 opacity-50"></div>

                        @auth
                        <!-- Dashboard -->
                        <a href="{{ request()->routeIs('landing') ? route('login') : route('dashboard') }}" class="block px-4 py-2 text-sm font-semibold rounded-lg {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                            Dashboard
                        </a>
                        
                        @if(auth()->user()->hasRole('super-admin'))
                            <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 text-sm font-semibold rounded-lg {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                Pengguna
                            </a>
                        @elseif(auth()->user()->hasRole('member') || auth()->user()->roles->isEmpty())
                            <a href="{{ route('member.orders.index') }}" class="block px-4 py-2 text-sm font-semibold rounded-lg {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                Transaksi
                            </a>
                        @endif
                        
                        <a href="#about" class="block px-4 py-2 text-sm font-semibold rounded-lg {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                            About
                        </a>
                        
                        @if(auth()->user()->hasRole('member') || auth()->user()->roles->isEmpty())
                            <div class="h-px border-t {{ $ddDivider }} my-1 opacity-50"></div>
                            <a href="{{ route('member.certificates.index') }}" class="block px-4 py-2 text-sm font-semibold rounded-lg {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                Sertifikat
                            </a>
                            <a href="{{ route('member.testimonials.index') }}" class="block px-4 py-2 text-sm font-semibold rounded-lg {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                Ulasan Saya
                            </a>
                        @endif
                        
                        @if(auth()->user()->hasRole('mentor'))
                            <div class="h-px border-t {{ $ddDivider }} my-1 opacity-50"></div>
                            <a href="{{ route('mentor.courses.index') }}" class="block px-4 py-2 text-sm font-semibold rounded-lg {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                Kelas Saya
                            </a>
                            <a href="{{ route('mentor.courses.create') }}" class="block px-4 py-2 text-sm font-semibold rounded-lg {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                Buat Kelas
                            </a>
                        @endif
                        
                        @if(auth()->user()->hasRole('super-admin'))
                            <div class="h-px border-t {{ $ddDivider }} my-1 opacity-50"></div>
                            <a href="{{ route('admin.courses.index') }}" class="block px-4 py-2 text-sm font-semibold rounded-lg {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                Kursus
                            </a>
                            <a href="{{ route('admin.course-categories.index') }}" class="block px-4 py-2 text-sm font-semibold rounded-lg {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                Kategori Kursus
                            </a>
                            
                            <div class="h-px border-t {{ $ddDivider }} my-1 opacity-50"></div>
                            <a href="{{ route('admin.services.index') }}" class="block px-4 py-2 text-sm font-semibold rounded-lg {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                Layanan
                            </a>
                            <a href="{{ route('admin.service-categories.index') }}" class="block px-4 py-2 text-sm font-semibold rounded-lg {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                Kategori Layanan
                            </a>
                            <a href="{{ route('admin.portfolios.index') }}" class="block px-4 py-2 text-sm font-semibold rounded-lg {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                Portfolio
                            </a>
                            <a href="{{ route('admin.testimonials.index') }}" class="block px-4 py-2 text-sm font-semibold rounded-lg {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                Testimoni
                            </a>
                            
                            <div class="h-px border-t {{ $ddDivider }} my-1 opacity-50"></div>
                            <a href="{{ route('admin.orders.index') }}" class="block px-4 py-2 text-sm font-semibold rounded-lg {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                Pesanan Aktif
                            </a>
                            <a href="{{ route('admin.orders.history') }}" class="block px-4 py-2 text-sm font-semibold rounded-lg {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                Riwayat Layanan
                            </a>
                            <a href="{{ route('admin.finances.index') }}" class="block px-4 py-2 text-sm font-semibold rounded-lg {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                Transaksi & Keuangan
                            </a>
                        @endif
                        
                        <div class="h-px border-t {{ $ddDivider }} my-1 opacity-50"></div>
                        <a href="{{ route('feedback.create') }}" class="block px-4 py-2 text-sm font-semibold rounded-lg {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                            Kirim Masukan
                        </a>
                        
                        <div class="h-px border-t {{ $ddDivider }} my-1 opacity-50"></div>
                        <a href="{{ route('settings.index') }}" class="block px-4 py-2 text-sm font-semibold rounded-lg {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                            Pengaturan
                        </a>
                        
                        <form method="POST" action="{{ route('logout') }}" class="m-0 w-full">
                            @csrf
                            <button type="submit" class="w-full text-left block px-4 py-2 text-sm font-semibold rounded-lg {{ $ddLinkHover }} transition-colors text-red-600 focus:outline-none">
                                Log Out
                            </button>
                        </form>
                        @endauth
                    </div>
                </template>

                <template x-teleport="body">
                    <div class="mobile-popup-container fixed z-[120] pointer-events-auto"
                         :class="[
                             activeDropdown === 'profile' ? 'top-10 left-4 right-auto sm:left-auto sm:right-4 sm:top-[70px] w-[calc(100%-2rem)] max-w-sm sm:w-80' : 
                             (activeDropdown === 'notif' ? 'top-16 right-4 left-auto sm:right-4 sm:top-[70px] w-[calc(100%-2rem)] max-w-sm sm:w-80' : 
                             'left-1/2 -translate-x-1/2 w-[calc(100%-3rem)] max-w-sm sm:max-w-none sm:translate-x-0 sm:left-auto sm:right-4 sm:top-[70px] sm:w-80'),
                             isSwitching ? 'anim-switch' : 'anim-vertical'
                         ]">
                    <div class="relative w-full max-h-[70vh] sm:max-h-[calc(100vh-100px)] overflow-y-auto sm:overflow-visible scrollbar-hide">
                            @auth
                            {{--
                            <div x-show="activeDropdown === 'cart'"
                                 x-transition:enter="popup-transition-active"
                                 x-transition:enter-start="popup-start cart-start"
                                 x-transition:enter-end="popup-end"
                                 x-transition:leave="popup-transition-active absolute top-0 right-0 w-full"
                                 x-transition:leave-start="popup-end"
                                 x-transition:leave-end="popup-leave-to cart-leave-to"
                                 class="rounded-2xl w-full"
                                 style="display: none;">
                                <div style="-webkit-mask-image: linear-gradient(to bottom, transparent 0%, black 24px, black calc(100% - 24px), transparent 100%); mask-image: linear-gradient(to bottom, transparent 0%, black 24px, black calc(100% - 24px), transparent 100%);">
                                    <div class="max-h-[70vh] overflow-y-auto scrollbar-hide py-6 px-2 dropdown-scroll-area">

                                        <div class="p-2 rounded-[24px] border {{ $sectionBg }} flex flex-col gap-1">
                                            <div class="flex flex-col items-center justify-center p-6 rounded-xl border border-dashed border-slate-200 bg-slate-50 dark:border-white/20 dark:bg-white/5">
                                                <div class="p-3 rounded-full bg-white dark:bg-white/10 mb-3 shadow-sm border border-slate-100 dark:border-white/10">
                                                    <svg class="w-6 h-6 text-slate-300 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                                </div>
                                                <p class="text-xs font-semibold text-center text-slate-500 dark:text-gray-400">Belum ada item di keranjang</p>
                                            </div>

                                            <div class="w-full h-px border-t {{ $ddDivider }} my-1"></div>
                                            <a href="{{ auth()->user()->hasRole('super-admin') ? route('admin.orders.index') : route('member.orders.index') }}" class="flex flex-row items-center justify-center gap-2 p-3 rounded-xl border border-transparent {{ $ddLinkHover }} transition-all duration-300 group">
                                                <span class="text-[11px] font-bold text-center leading-tight tracking-wide uppercase text-blue-600 group-hover:text-blue-700">Lihat keranjang belanja</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            --}}

                            <div x-show="activeDropdown === 'notif'"
                                 x-transition:enter="transition-all duration-200 ease-[cubic-bezier(0.16,1,0.3,1)] transform origin-top-right will-change-transform"
                                 x-transition:enter-start="opacity-0 scale-[0.92] -translate-y-2 translate-x-2"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0 translate-x-0"
                                 x-transition:leave="transition-all duration-150 ease-in transform origin-top-right absolute top-0 right-0 w-full will-change-transform"
                                 x-transition:leave-start="opacity-100 scale-100 translate-y-0 translate-x-0"
                                 x-transition:leave-end="opacity-0 scale-[0.92] -translate-y-2 translate-x-2"
                                 class="w-full will-change-transform"
                                 style="display: none;">
                                <div class="max-h-[60vh] overflow-y-auto scrollbar-hide p-3 rounded-[24px] bg-white/75 dark:bg-[#151515]/75 backdrop-blur-3xl border border-white/70 dark:border-white/20 shadow-[0_8px_32px_rgba(0,0,0,0.15)] dark:shadow-[0_8px_32px_rgba(0,0,0,0.6),_inset_0_1px_1px_rgba(255,255,255,0.2)] flex flex-col gap-1">
                                        @if($notifications->count() > 0)
                                                @foreach($notifications as $notification)
                                                    @php
                                                        $isChat = str_contains(strtolower($notification->data['title'] ?? ''), 'pesan') || str_contains($notification->data['url'] ?? '', 'orders');
                                                    @endphp
                                                    <div class="flex flex-row items-start gap-3 p-3 rounded-xl border border-transparent transition-all duration-300 {{ is_null($notification->read_at) ? 'bg-blue-50/40 dark:bg-blue-950/20' : '' }}">
                                                        <div class="shrink-0 mr-1 mt-0.5 relative">
                                                            @if(isset($notification->data['avatar']) && $notification->data['avatar'])
                                                                <img src="{{ $notification->data['avatar'] }}" class="w-9 h-9 rounded-full object-cover shadow-sm border border-slate-200">
                                                            @else
                                                                <div class="w-9 h-9 rounded-full bg-blue-50 dark:bg-blue-900/40 text-blue-600 dark:text-blue-400 border-blue-100 dark:border-blue-800 flex items-center justify-center shadow-sm border">
                                                                    @if($isChat)
                                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L1 17l1.338-3.123C1.493 12.76 1 11.434 1 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" /></svg>
                                                                    @else
                                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" /></svg>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                            
                                                            @if(is_null($notification->read_at))
                                                                <div class="absolute top-0 right-0 w-2.5 h-2.5 rounded-full bg-blue-500 transform translate-x-1/3 -translate-y-1/3 shadow-[0_0_5px_rgba(59,130,246,0.5)] border-2 border-white"></div>
                                                            @endif

                                                            @if(isset($notification->data['avatar']) && $notification->data['avatar'])
                                                                <!-- Badge Icon for Chat if Avatar is shown -->
                                                                <div class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full {{ $isChat ? 'bg-indigo-500' : 'bg-blue-500' }} border-[2px] border-white flex items-center justify-center text-white">
                                                                    @if($isChat)
                                                                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L1 17l1.338-3.123C1.493 12.76 1 11.434 1 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" /></svg>
                                                                    @else
                                                                        <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" /></svg>
                                                                    @endif
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="flex-1 min-w-0 pt-0.5 text-left">
                                                            <p class="text-[13px] font-bold leading-tight truncate {{ $ddText }}">{{ $notification->data['title'] ?? 'Notifikasi Baru' }}</p>
                                                            <p class="text-[11px] text-slate-500 dark:text-gray-400 mt-1 line-clamp-2 leading-snug font-medium">{{ $notification->data['message'] ?? '' }}</p>
                                                            
                                                            <div class="mt-2.5 flex items-center justify-between gap-2">
                                                                <span class="text-[9px] font-semibold text-slate-400 dark:text-gray-500">{{ $notification->created_at->diffForHumans() }}</span>
                                                                
                                                                <div class="flex items-center gap-1.5 shrink-0">
                                                                    @if(isset($notification->data['url']))
                                                                        <form action="{{ route('notifications.markRead', $notification->id) }}" method="POST" class="m-0">
                                                                            @csrf
                                                                            <button type="submit" class="inline-flex items-center justify-center px-2 py-1 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-[9px] font-black uppercase tracking-wider transition-all shadow-sm">
                                                                                Lihat
                                                                            </button>
                                                                        </form>
                                                                    @endif
                                                                    
                                                                    @if(is_null($notification->read_at))
                                                                        <form action="{{ route('notifications.markRead', $notification->id) }}" method="POST" class="m-0">
                                                                            @csrf
                                                                            <button type="submit" class="inline-flex items-center justify-center px-2.5 py-1 bg-slate-100 hover:bg-slate-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-slate-650 dark:text-slate-300 rounded-lg text-[9px] font-black uppercase tracking-wider transition-all border border-slate-200/50 dark:border-white/5">
                                                                                Tandai Dibaca
                                                                            </button>
                                                                        </form>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                        @else
                                            <div class="flex flex-col items-center justify-center p-6 rounded-xl border border-dashed border-slate-200 bg-slate-50 dark:border-white/20 dark:bg-white/5">
                                                    <div class="p-3 rounded-full bg-white dark:bg-white/10 mb-3 shadow-sm border border-slate-100 dark:border-white/10">
                                                        <svg class="w-6 h-6 text-slate-300 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                                    </div>
                                                    <p class="text-xs font-semibold text-center text-slate-500 dark:text-gray-400">Tidak ada notifikasi terbaru</p>
                                                </div>
                                        @endif

                                            <div class="w-full h-px border-t {{ $ddDivider }} my-1"></div>
                                            <a href="{{ route('notifications.index') }}" class="flex flex-row items-center justify-center gap-2 p-3 rounded-xl border border-transparent {{ $ddLinkHover }} transition-all duration-300 group">
                                                <span class="text-[11px] font-bold text-center leading-tight tracking-wide uppercase text-blue-600 group-hover:text-blue-700">Lihat selengkapnya</span>
                                            </a>
                                        </div>
                            </div>

                            <div x-show="activeDropdown === 'profile'"
                                 x-transition:enter="transition ease-out duration-300 transform origin-top-left sm:origin-top-right"
                                 x-transition:enter-start="opacity-0 scale-75 -translate-y-4 -translate-x-4 sm:translate-x-4 sm:-translate-y-4"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0 translate-x-0"
                                 x-transition:leave="transition ease-in duration-200 transform origin-top-left sm:origin-top-right absolute top-0 left-0 sm:left-auto sm:right-0 w-full"
                                 x-transition:leave-start="opacity-100 scale-100 translate-y-0 translate-x-0"
                                 x-transition:leave-end="opacity-0 scale-75 -translate-y-4 -translate-x-4 sm:translate-x-4 sm:-translate-y-4"
                                 class="rounded-2xl w-full flex flex-col py-6 px-2"
                                 style="display: none;">
                                    
                                    <div class="bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 rounded-2xl p-4 relative overflow-hidden flex flex-col gap-4 shadow-xl border border-white/10 shrink-0 z-20">
                                    
                                    <div class="absolute -top-28 -right-28 w-80 h-80 rounded-full overflow-hidden z-0 pointer-events-none" style="-webkit-mask-image: radial-gradient(circle at center, black 20%, transparent 65%); mask-image: radial-gradient(circle at center, black 20%, transparent 65%);">
                                        @if(Auth::user()->avatar)
                                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="" class="w-full h-full object-cover opacity-60 mix-blend-luminosity">
                                        @else
                                            <div class="w-full h-full bg-white/5 flex items-center justify-center font-bold text-[120px] text-white/20 pl-4 pb-4">
                                                {{ substr(Auth::user()->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <div class="absolute inset-0 bg-gradient-to-bl from-indigo-900/80 via-blue-800/40 to-transparent mix-blend-multiply"></div>
                                        <div class="absolute inset-0 bg-gradient-to-b from-blue-900/50 to-transparent"></div>
                                    </div>

                                    <div class="absolute -left-6 -bottom-6 w-20 h-20 bg-cyan-400/20 rounded-full blur-xl pointer-events-none z-0"></div>
                                    
                                    <div class="relative z-10 flex items-start justify-between w-full">
                                        <div class="text-white drop-shadow-md" x-data="{ time: '', date: '' }" x-init="
                                            setInterval(() => { 
                                                let d = new Date(); 
                                                time = d.getHours().toString().padStart(2, '0') + ':' + d.getMinutes().toString().padStart(2, '0');
                                                date = d.toLocaleDateString('id-ID', { weekday: 'short', day: 'numeric', month: 'short' });
                                            }, 1000);
                                            // initial call
                                            let d = new Date(); 
                                            time = d.getHours().toString().padStart(2, '0') + ':' + d.getMinutes().toString().padStart(2, '0');
                                            date = d.toLocaleDateString('id-ID', { weekday: 'short', day: 'numeric', month: 'short' });
                                        ">
                                            <div class="text-[28px] font-bold leading-none tracking-tight tabular-nums" x-text="time"></div>
                                            <div class="text-[11px] font-semibold opacity-90 uppercase tracking-widest mt-1" x-text="date"></div>
                                        </div>
                                        
                                         <div class="flex items-start gap-2 drop-shadow-lg">
                                             <a href="{{ route('settings.index') }}" class="w-9 h-9 rounded-xl bg-white/15 backdrop-blur-md shadow-sm border border-white/20 flex items-center justify-center transition-all duration-300 group hover:bg-white hover:text-blue-600 hover:border-white hover:scale-110 active:scale-95 text-white" title="Pengaturan">
                                                 <svg class="w-[18px] h-[18px] group-hover:rotate-90 transition-all duration-500" fill="currentColor" viewBox="0 0 16 16">
                                                     <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                                                 </svg>
                                             </a>
                                             <form method="POST" action="{{ route('logout') }}" class="m-0">
                                                 @csrf
                                                 <button type="submit" class="w-9 h-9 rounded-xl bg-white/15 backdrop-blur-md shadow-sm border border-white/20 flex items-center justify-center transition-all duration-300 group hover:bg-white hover:text-red-600 hover:border-white hover:scale-110 active:scale-95 text-white" title="Log Out">
                                                     <svg class="w-[18px] h-[18px] group-hover:translate-x-0.5 transition-all duration-300" fill="currentColor" viewBox="0 0 20 20">
                                                         <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                                                     </svg>
                                                 </button>
                                             </form>
                                         </div>
                                    </div>
                                    
                                    <div class="relative z-10 pt-3 border-t border-white/20 w-full drop-shadow-md">
                                        <div class="font-extrabold text-white text-sm tracking-wide">{{ Auth::user()->name }}</div>
                                        <div class="text-[11px] text-white/90 font-medium">{{ Auth::user()->email }}</div>
                                        <div class="text-[10px] text-white/80 uppercase tracking-wider mt-1">Bergabung sejak {{ Auth::user()->created_at->format('M Y') }}</div>
                                    </div>
                                </div>
                                
                                <div class="hidden sm:block relative w-full overflow-hidden mt-2" style="-webkit-mask-image: linear-gradient(to bottom, transparent 0%, black 16px, black calc(100% - 25px), transparent 100%); mask-image: linear-gradient(to bottom, transparent 0%, black 16px, black calc(100% - 25px), transparent 100%);">
                                    <div class="max-h-[45vh] overflow-y-auto scrollbar-hide pt-4 pb-16 px-1 dropdown-scroll-area">
                                        <div class="p-2 rounded-[24px] border {{ $sectionBg }} flex flex-col gap-1">
                                            <a href="{{ request()->routeIs('landing') ? route('login') : route('dashboard') }}" class="block px-4 py-2.5 text-[13px] font-semibold rounded-xl {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                                Dashboard
                                            </a>
                                            
                                            @if(auth()->user()->hasRole('super-admin'))
                                                <a href="{{ route('admin.users.index') }}" class="block px-4 py-2.5 text-[13px] font-semibold rounded-xl {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                                    Pengguna
                                                </a>
                                            @elseif(auth()->user()->hasRole('member') || auth()->user()->roles->isEmpty())
                                                <a href="{{ route('member.orders.index') }}" class="block px-4 py-2.5 text-[13px] font-semibold rounded-xl {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                                    Transaksi
                                                </a>
                                            @endif
                                            

                                            @if(auth()->user()->hasRole('member') || auth()->user()->roles->isEmpty())
                                                <div class="h-px border-t {{ $ddDivider }} my-1 opacity-50"></div>
                                                <a href="{{ route('member.certificates.index') }}" class="block px-4 py-2.5 text-[13px] font-semibold rounded-xl {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                                    Sertifikat
                                                </a>
                                                <a href="{{ route('member.testimonials.index') }}" class="block px-4 py-2.5 text-[13px] font-semibold rounded-xl {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                                    Ulasan Saya
                                                </a>
                                            @endif
                                            
                                            @if(auth()->user()->hasRole('mentor'))
                                                <div class="h-px border-t {{ $ddDivider }} my-1 opacity-50"></div>
                                                <a href="{{ route('mentor.courses.index') }}" class="block px-4 py-2.5 text-[13px] font-semibold rounded-xl {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                                    Kelas Saya
                                                </a>
                                                <a href="{{ route('mentor.courses.create') }}" class="block px-4 py-2.5 text-[13px] font-semibold rounded-xl {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                                    Buat Kelas
                                                </a>
                                            @endif
                                            
                                            @if(auth()->user()->hasRole('super-admin'))
                                                <div class="h-px border-t {{ $ddDivider }} my-1 opacity-50"></div>
                                                <a href="{{ route('admin.courses.index') }}" class="block px-4 py-2.5 text-[13px] font-semibold rounded-xl {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                                    Kursus
                                                </a>
                                                <a href="{{ route('admin.course-categories.index') }}" class="block px-4 py-2.5 text-[13px] font-semibold rounded-xl {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                                    Kategori Kursus
                                                </a>
                                                
                                                <div class="h-px border-t {{ $ddDivider }} my-1 opacity-50"></div>
                                                <a href="{{ route('admin.services.index') }}" class="block px-4 py-2.5 text-[13px] font-semibold rounded-xl {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                                    Layanan
                                                </a>
                                                <a href="{{ route('admin.service-categories.index') }}" class="block px-4 py-2.5 text-[13px] font-semibold rounded-xl {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                                    Kategori Layanan
                                                </a>
                                                <a href="{{ route('admin.portfolios.index') }}" class="block px-4 py-2.5 text-[13px] font-semibold rounded-xl {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                                    Portfolio
                                                </a>
                                                <a href="{{ route('admin.testimonials.index') }}" class="block px-4 py-2.5 text-[13px] font-semibold rounded-xl {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                                    Testimoni
                                                </a>
                                                
                                                <div class="h-px border-t {{ $ddDivider }} my-1 opacity-50"></div>
                                                <a href="{{ route('admin.orders.index') }}" class="block px-4 py-2.5 text-[13px] font-semibold rounded-xl {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                                    Pesanan Aktif
                                                </a>
                                                <a href="{{ route('admin.orders.history') }}" class="block px-4 py-2.5 text-[13px] font-semibold rounded-xl {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                                    Riwayat Layanan
                                                </a>
                                                <a href="{{ route('admin.payments.index') }}" class="block px-4 py-2.5 text-[13px] font-semibold rounded-xl {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                                    Pembayaran Bawaan
                                                </a>
                                                <a href="{{ route('admin.finances.index') }}" class="block px-4 py-2.5 text-[13px] font-semibold rounded-xl {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                                    Transaksi & Keuangan
                                                </a>
                                            @endif
                                            
                                            <div class="h-px border-t {{ $ddDivider }} my-1 opacity-50"></div>
                                            <a href="{{ route('feedback.create') }}" class="block px-4 py-2.5 text-[13px] font-semibold rounded-xl {{ $ddLinkHover }} transition-colors text-slate-700 dark:text-gray-200">
                                                Kirim Masukan
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endauth

                            <div x-show="activeDropdown === 'search'"
                                 x-transition:enter="popup-transition-active"
                                 x-transition:enter-start="popup-start cart-start"
                                 x-transition:enter-end="popup-end"
                                 x-transition:leave="popup-transition-active absolute top-0 right-0 w-full"
                                 x-transition:leave-start="popup-end"
                                 x-transition:leave-end="popup-leave-to cart-leave-to"
                                 class="w-full pb-2 flex flex-col items-center gap-3"
                                 style="display: none;">
                                <form action="{{ route('search') }}" method="GET" class="w-full relative">
                                    <input type="text" name="q" class="block w-full pl-6 pr-16 py-4 {{ $sectionBg }} rounded-[28px] leading-5 {{ $textColor }} placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition-all shadow-[0_8px_32px_rgba(0,0,0,0.1)]" placeholder="Cari kursus atau layanan...">
                                    <button type="submit" class="absolute right-2.5 top-1/2 -translate-y-1/2 p-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-[20px] transition-colors shadow-md flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </button>
                                </form>
                                <a href="#" class="px-5 py-2 {{ $sectionBg }} {{ $textColor }} text-xs font-medium rounded-full shadow-md hover:text-blue-600 transition-colors flex items-center gap-2 border border-white/20 backdrop-blur-2xl bg-white/70">
                                    <svg class="w-4 h-4 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Riwayat Pencarian
                                </a>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
    <x-breadcrumbs />

    <template x-teleport="body">
        <div x-data="{
                show: {{ (session('success') || session('status')) ? 'true' : 'false' }},
                isConfirm: false,
                message: '{{ session('success') ?? session('status') }}',
                url: '',
                method: 'POST',
                type: 'success',
                init() {
                    if (this.show) {
                        setTimeout(() => { if(!this.isConfirm) this.show = false; }, 4000);
                    }
                }
             }"
             @open-confirm.window="
                message = $event.detail.message;
                url = $event.detail.url;
                method = $event.detail.method || 'POST';
                type = $event.detail.type || 'success';
                isConfirm = true;
                show = true;
             "
             x-show="show"
             x-transition:enter="transition ease-out duration-500"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-500"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 translate-y-4"
             class="fixed top-[95px] left-4 right-4 sm:left-auto sm:right-6 lg:right-8 z-[200] flex flex-col bg-white/95 dark:bg-zinc-900/95 backdrop-blur-xl border border-slate-200/60 dark:border-zinc-800/80 text-slate-800 dark:text-white p-5 rounded-[24px] shadow-[0_10px_30px_rgba(0,0,0,0.08)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.3)] sm:max-w-sm w-auto sm:w-[360px] pointer-events-auto"
             style="display: none;">
            
            <div class="flex items-start gap-3.5">
                <div class="shrink-0">
                    <template x-if="!isConfirm || type === 'success'">
                        <div class="w-9 h-9 rounded-full bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-center text-emerald-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </template>
                    <template x-if="isConfirm && type === 'danger'">
                        <div class="w-9 h-9 rounded-full bg-red-500/10 border border-red-500/20 flex items-center justify-center text-red-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                    </template>
                    <template x-if="isConfirm && type === 'warning'">
                        <div class="w-9 h-9 rounded-full bg-amber-500/10 border border-amber-500/20 flex items-center justify-center text-amber-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                    </template>
                </div>
                
                <div class="flex-1 min-w-0 pr-2 pt-1.5">
                    <span class="block font-bold text-[14px] leading-snug text-slate-800 dark:text-slate-100" x-text="message"></span>
                </div>

                <button x-show="!isConfirm" @click="show = false" class="p-1 -mr-1 rounded-full text-slate-400 hover:text-slate-600 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-white/10 transition-colors focus:outline-none shrink-0">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div x-show="isConfirm" class="flex gap-3 mt-5 w-full" style="display: none;">
                <button @click="show = false; isConfirm = false" class="flex-1 py-3 bg-slate-100 dark:bg-zinc-800 hover:bg-slate-200 dark:hover:bg-zinc-750 text-slate-600 dark:text-white rounded-[16px] text-xs font-black uppercase tracking-wider transition-all border border-slate-200/60 dark:border-zinc-700/55">Batal</button>
                <form :action="url" method="POST" class="flex-1 m-0">
                    @csrf
                    <input type="hidden" name="_method" :value="method">
                    <button type="submit" 
                            class="w-full py-3 text-white rounded-[16px] text-xs font-black uppercase tracking-wider transition-all"
                            :class="{
                                'bg-red-600 hover:bg-red-700 shadow-lg shadow-red-600/25': type === 'danger',
                                'bg-amber-500 hover:bg-amber-600 shadow-lg shadow-amber-500/25': type === 'warning',
                                'bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-600/25': type === 'success' || !type
                            }">
                        Konfirmasi
                    </button>
                </form>
            </div>
        </div>
    </template>
</nav>
