<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @stack('styles')
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script>
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
    </head>
    <body class="font-sans antialiased text-apple-ink bg-apple-parchment dark:bg-black dark:text-slate-100 transition-colors duration-300">
        <!-- Ambient Glow Circles for Glassmorphic Refraction in Dark Mode (Authenticated App) -->
        <div class="hidden dark:block fixed top-[20%] left-[-10%] w-[40vw] h-[40vw] bg-indigo-500/10 rounded-full blur-[150px] pointer-events-none z-0"></div>
        <div class="hidden dark:block fixed bottom-[20%] right-[-10%] w-[40vw] h-[40vw] bg-blue-500/10 rounded-full blur-[150px] pointer-events-none z-0"></div>

        <div class="min-h-screen bg-apple-parchment dark:bg-black pb-[calc(6rem+env(safe-area-inset-bottom))] sm:pb-0 transition-colors duration-300 relative">
            @include('layouts.navigation')

            <div class="{{ $attributes->get('content-padding', 'pt-[105px]') }}">
                <!-- Page Heading -->
            @isset($header)
                <header>
                    <div class="max-w-7xl mx-auto pt-6 pb-2 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            @if(isset($attributes) && $attributes->has('disable-animation'))
                <main {{ $attributes->except(['content-padding']) }}>
                    {{ $slot }}
                </main>
            @else
                <main {{ $attributes->except(['content-padding']) }} x-data="{ show: false }" x-init="setTimeout(() => show = true, 50)" x-show="show" x-transition:enter="transition ease-out duration-500 transform" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    {{ $slot }}
                </main>
            @endif
            </div>
        </div>
        
        <!-- Real-time Toast Notification Component -->
        @php
            $toastsData = [];
            $isDashboard = request()->routeIs('dashboard', 'member.dashboard', 'admin.dashboard', 'staff.dashboard', 'mentor.dashboard');
            if (auth()->check() && $isDashboard) {
                $previewSeenAt = session('notification_preview_seen_at');
                
                // Only get chat-type unread notifications
                $chatNotifications = auth()->user()->unreadNotifications
                    ->filter(function ($n) use ($previewSeenAt) {
                        // Only chat type
                        if (($n->data['type'] ?? null) !== 'chat') {
                            return false;
                        }
                        // Skip if already previewed in navbar
                        if ($previewSeenAt && $n->created_at->lte(\Carbon\Carbon::parse($previewSeenAt))) {
                            return false;
                        }
                        return true;
                    });

                if ($chatNotifications->count() > 2) {
                    $first = $chatNotifications->first();
                    $toastsData[] = [
                        'id' => $first->id,
                        'title' => $first->data['title'] ?? 'Pesan Baru',
                        'message' => $first->data['message'] ?? 'Ada pesan baru',
                        'avatar' => $first->data['avatar'] ?? null,
                    ];
                    $toastsData[] = [
                        'id' => 'grouped_msg',
                        'title' => 'Pesan Masuk',
                        'message' => 'Ada ' . ($chatNotifications->count() - 1) . ' pesan baru lainnya.',
                        'avatar' => null,
                    ];
                } else {
                    foreach($chatNotifications->take(2) as $n) {
                        $toastsData[] = [
                            'id' => $n->id,
                            'title' => $n->data['title'] ?? 'Pesan Baru',
                            'message' => $n->data['message'] ?? 'Ada pesan baru',
                            'avatar' => $n->data['avatar'] ?? null,
                        ];
                    }
                }
            }
        @endphp
        <div x-data="{ 
                toasts: @js($toastsData),
                isNavbarDropdownOpen: false,
                init() {
                    if (window.Echo) {
                        window.Echo.private(`App.Models.User.{{ auth()->id() ?? 0 }}`)
                            .notification((notification) => {
                                // Prevent duplicate toast if it matches the session flash message
                                const sessionMessage = @js(session('success') ?? session('status'));
                                if (sessionMessage && (notification.message === sessionMessage || notification.title === sessionMessage)) {
                                    return;
                                }
                                
                                this.toasts.push({ 
                                    id: Date.now(), 
                                    title: notification.title, 
                                    message: notification.message,
                                    avatar: notification.avatar || null
                                });
                            });
                    }
                }
             }" 
             @notify.window="toasts.push({ id: Date.now(), title: $event.detail.title, message: $event.detail.message, avatar: $event.detail.avatar || null });"
             @nav-dropdown-changed.window="isNavbarDropdownOpen = $event.detail.open"
             class="fixed top-[85px] left-4 right-4 sm:left-auto sm:right-6 lg:right-8 flex flex-col gap-3 pointer-events-none transition-all duration-300"
             :class="isNavbarDropdownOpen ? 'z-[40] opacity-25 scale-95' : 'z-[200] opacity-100 scale-100'">
            <template x-for="(toast, index) in toasts" :key="toast.id">
                <div x-data="{ show: false }"
                     x-init="
                        setTimeout(() => show = true, 50 + (index * 200));
                        let leaveDelay = 5000 + ((toasts.length - 1 - index) * 200);
                        setTimeout(() => { 
                            show = false; 
                            setTimeout(() => toasts = toasts.filter(t => t.id !== toast.id), 500); 
                        }, leaveDelay);
                     "
                     x-show="show" 
                     x-transition:enter="transition ease-out duration-500 transform"
                     x-transition:enter-start="opacity-0 -translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-500 transform"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-4"
                     class="flex flex-col bg-white/95 backdrop-blur-xl border border-slate-200/60 text-slate-700 px-4 py-3.5 rounded-2xl shadow-[0_8px_30px_rgba(0,0,0,0.12)] w-full max-w-sm sm:max-w-none sm:w-80 mx-auto pointer-events-auto">
                    
                    <div class="flex items-start">
                        <div class="shrink-0 mr-3 mt-0.5 relative">
                            <template x-if="toast.avatar">
                                <img :src="toast.avatar" class="w-8 h-8 rounded-full object-cover shadow-sm border border-slate-200">
                            </template>
                            <template x-if="!toast.avatar">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 shadow-sm border border-blue-200">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" /></svg>
                                </div>
                            </template>
                            <div class="absolute -bottom-1 -right-1 w-[18px] h-[18px] rounded-full bg-indigo-500 border-[2px] border-white flex items-center justify-center text-white">
                                <svg class="w-2.5 h-2.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L1 17l1.338-3.123C1.493 12.76 1 11.434 1 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" /></svg>
                            </div>
                        </div>
                        
                        <div class="flex-1 min-w-0 pr-2">
                            <span class="block font-black text-[13px] leading-snug text-slate-800" x-text="toast.title"></span>
                            <span class="block text-[12px] text-slate-500 mt-0.5 leading-snug truncate" x-text="toast.message"></span>
                        </div>

                        <button @click="show = false; setTimeout(() => toasts = toasts.filter(t => t.id !== toast.id), 500)" class="p-1 -mr-1 rounded-full text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors focus:outline-none shrink-0">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                </div>
            </template>
        </div>

        <!-- Custom Centered Confirmation Modal -->
        <div x-data="{
                show: false,
                message: '',
                title: 'Konfirmasi',
                showCancel: true,
                isDanger: false,
                confirmCallback: null,
                open(detail) {
                    this.message = detail.message;
                    this.showCancel = detail.showCancel !== false;
                    this.title = detail.title || (this.showCancel ? 'Konfirmasi' : 'Informasi');
                    // Detect if it is a destructive action (delete, cancel, archive, etc)
                    const lowerMsg = this.message.toLowerCase();
                    this.isDanger = lowerMsg.includes('hapus') || lowerMsg.includes('batal') || lowerMsg.includes('delete') || lowerMsg.includes('cancel') || lowerMsg.includes('arsip');
                    this.confirmCallback = detail.confirmCallback;
                    this.show = true;
                },
                confirm() {
                    if (this.confirmCallback) {
                        this.confirmCallback();
                    }
                    this.close();
                },
                close() {
                    this.show = false;
                    this.confirmCallback = null;
                }
             }"
             @open-custom-confirm.window="open($event.detail)"
             x-show="show"
             class="fixed inset-0 z-[9999] flex items-center justify-center p-4"
             style="display: none;">
            
            <!-- Backdrop -->
            <div x-show="show"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="close()"
                 class="fixed inset-0 bg-black/60 backdrop-blur-sm"></div>

            <!-- Modal Card -->
            <div x-show="show"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 class="relative bg-white dark:bg-slate-900 rounded-[28px] border border-slate-200/80 dark:border-slate-800 p-6 shadow-2xl max-w-sm w-full z-10 text-center flex flex-col items-center">
                
                <!-- Icon -->
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-4 transition-colors duration-300"
                     :class="isDanger ? 'bg-red-50 dark:bg-red-955/20 text-red-600 dark:text-red-400' : 'bg-blue-50 dark:bg-blue-955/20 text-blue-600 dark:text-blue-400'">
                    <template x-if="isDanger">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                        </svg>
                    </template>
                    <template x-if="!isDanger">
                        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 16h-2v-2h2v2zm1.07-7.75l-.9.92C12.45 11.9 12 12.5 12 14h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H7c0-2.76 2.24-5 5-5s5 2.24 5 5c0 1.04-.42 1.99-1.07 2.75z"/>
                        </svg>
                    </template>
                </div>

                <!-- Title / Message -->
                <h3 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2" x-text="title"></h3>
                <p class="text-[15px] font-semibold text-slate-800 dark:text-slate-200 leading-relaxed mb-6 px-2" x-text="message"></p>

                <!-- Action Buttons -->
                <div class="flex gap-3 w-full">
                    <button x-show="showCancel" @click="close()" 
                            class="flex-1 py-3 bg-white dark:bg-slate-900 hover:bg-slate-900 dark:hover:bg-white text-slate-700 dark:text-slate-300 hover:text-white dark:hover:text-slate-900 border border-slate-200 dark:border-slate-800 font-bold text-sm rounded-xl transition-all duration-300">
                        Batal
                    </button>
                    <button @click="confirm()" 
                            class="flex-1 py-3 text-white font-bold text-sm rounded-xl shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 border border-transparent"
                            :class="isDanger ? 'bg-red-600 hover:bg-white dark:hover:bg-white text-white hover:text-red-600 dark:hover:text-red-600 hover:border-red-600 shadow-red-600/20' : 'bg-blue-600 hover:bg-white dark:hover:bg-white text-white hover:text-blue-600 dark:hover:text-blue-600 hover:border-blue-600 shadow-blue-600/20'"
                            x-text="showCancel ? 'Ya, Lanjutkan' : 'OK'">
                    </button>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Intercept Form Submit Confirmations (Capture phase)
                document.addEventListener('submit', function(e) {
                    const onsubmitAttr = e.target.getAttribute('onsubmit');
                    if (onsubmitAttr && onsubmitAttr.includes('confirm(')) {
                        e.preventDefault();
                        e.stopImmediatePropagation();
                        
                        let message = 'Apakah Anda yakin?';
                        const match = onsubmitAttr.match(/confirm\(['"`](.*?)['"`]\)/);
                        if (match && match[1]) {
                            message = match[1];
                        }
                        
                        window.dispatchEvent(new CustomEvent('open-custom-confirm', {
                            detail: {
                                message: message,
                                confirmCallback: () => {
                                    const tempOnsubmit = e.target.getAttribute('onsubmit');
                                    e.target.removeAttribute('onsubmit');
                                    e.target.submit();
                                    setTimeout(() => e.target.setAttribute('onsubmit', tempOnsubmit), 100);
                                }
                            }
                        }));
                    }
                }, true);

                // Intercept Button/Link Click Confirmations (Capture phase)
                document.addEventListener('click', function(e) {
                    const target = e.target.closest('[onclick]');
                    if (target) {
                        const onclickAttr = target.getAttribute('onclick');
                        if (onclickAttr && onclickAttr.includes('confirm(')) {
                            e.preventDefault();
                            e.stopImmediatePropagation();
                            
                            let message = 'Apakah Anda yakin?';
                            const match = onclickAttr.match(/confirm\(['"`](.*?)['"`]\)/);
                            if (match && match[1]) {
                                message = match[1];
                            }
                            
                            window.dispatchEvent(new CustomEvent('open-custom-confirm', {
                                detail: {
                                    message: message,
                                    confirmCallback: () => {
                                        const tempOnclick = target.getAttribute('onclick');
                                        target.removeAttribute('onclick');
                                        target.click();
                                        setTimeout(() => target.setAttribute('onclick', tempOnclick), 100);
                                    }
                                }
                            }));
                        }
                    }
                }, true);
            });
        </script>

        @stack('scripts')
    </body>
</html>
