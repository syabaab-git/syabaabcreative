<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-black text-2xl text-slate-800 dark:text-white leading-tight">
                    {{ __('Notifikasi') }}
                </h2>
                <p class="text-[11px] font-bold text-slate-450 dark:text-slate-500 uppercase tracking-widest mt-1">Pemberitahuan & Pesan Masuk</p>
            </div>
            
            @if($notifications->count() > 0 && auth()->user()->unreadNotifications->count() > 0)
                <form action="{{ route('notifications.markAllRead') }}" method="POST" class="m-0 w-full sm:w-auto">
                    @csrf
                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white dark:bg-zinc-800 hover:bg-slate-50 dark:hover:bg-zinc-700/80 text-slate-650 dark:text-slate-200 border border-slate-200/80 dark:border-white/5 hover:border-slate-300 dark:hover:border-white/10 rounded-2xl text-xs font-black uppercase tracking-wider transition-all shadow-sm">
                        <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Tandai Semua Dibaca
                    </button>
                </form>
            @endif
        </div>
    </x-slot>

    <div class="py-8 min-h-screen bg-slate-55/30 dark:bg-black/10" 
         x-data="{ 
             activeFilter: 'all',
             notifications: [
                 @foreach($notifications as $n)
                 {
                     id: '{{ $n->id }}',
                     read: {{ is_null($n->read_at) ? 'false' : 'true' }}
                 },
                 @endforeach
             ],
             get unreadCount() {
                 return this.notifications.filter(n => !n.read).length;
             },
             get hasVisible() {
                 if (this.activeFilter === 'all') return this.notifications.length > 0;
                 return this.notifications.some(n => !n.read);
             }
         }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/80 dark:bg-[#1c1c1e]/80 backdrop-blur-xl overflow-hidden shadow-[0_8px_30px_rgba(0,0,0,0.04)] sm:rounded-[32px] border border-slate-200/60 dark:border-white/5">
                <div class="p-6 sm:p-8">
                    
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-white/5 pb-4 mb-6">
                        <div class="flex gap-2">
                            <button @click="activeFilter = 'all'" 
                                    class="px-4 py-2 text-xs font-black uppercase tracking-wider rounded-xl transition-all"
                                    :class="activeFilter === 'all' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/15' : 'bg-slate-100 dark:bg-zinc-800/60 text-slate-600 dark:text-slate-300 hover:bg-slate-200/80 dark:hover:bg-zinc-700/80'">
                                Semua
                            </button>
                            <button @click="activeFilter = 'unread'" 
                                    class="px-4 py-2 text-xs font-black uppercase tracking-wider rounded-xl transition-all relative"
                                    :class="activeFilter === 'unread' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/15' : 'bg-slate-100 dark:bg-zinc-800/60 text-slate-600 dark:text-slate-300 hover:bg-slate-200/80 dark:hover:bg-zinc-700/80'">
                                Belum Dibaca
                                <span class="ml-1 px-1.5 py-0.5 rounded-md bg-red-100 dark:bg-red-950/40 text-red-600 text-[10px] font-black" x-show="unreadCount > 0" x-text="unreadCount">
                                </span>
                            </button>
                        </div>
                    </div>

                    @if($notifications->count() > 0)
                        <!-- Notification List Container -->
                        <div x-show="hasVisible" class="space-y-4">
                            @foreach($notifications as $notification)
                                @php
                                    $isChat = str_contains(strtolower($notification->data['title'] ?? ''), 'pesan') || str_contains($notification->data['url'] ?? '', 'orders');
                                @endphp
                                <div x-data="{ item: notifications.find(n => n.id === '{{ $notification->id }}') }" 
                                     x-show="activeFilter === 'all' || (activeFilter === 'unread' && !item.read)"
                                     class="group p-5 rounded-3xl border transition-all duration-300 flex items-start gap-4"
                                     :class="!item.read ? 'bg-white dark:bg-zinc-900/60 border-indigo-100 dark:border-indigo-950/40 shadow-sm shadow-indigo-100/5' : 'bg-white/40 dark:bg-zinc-900/20 border-slate-150 dark:border-white/5 hover:border-slate-200 dark:hover:border-white/10'">
                                    
                                    <div class="shrink-0 relative mt-0.5">
                                        @if(isset($notification->data['avatar']) && $notification->data['avatar'])
                                            <img src="{{ $notification->data['avatar'] }}" class="w-11 h-11 rounded-2xl object-cover shadow-sm border border-slate-250 dark:border-white/10">
                                        @else
                                            <div class="w-11 h-11 rounded-2xl flex items-center justify-center shadow-sm border {{ $isChat ? 'bg-blue-50 dark:bg-blue-950/20 text-blue-600 dark:text-blue-400 border-blue-100 dark:border-blue-900/30' : 'bg-indigo-50 dark:bg-indigo-950/20 text-indigo-600 dark:text-indigo-400 border-indigo-100 dark:border-indigo-900/30' }}">
                                                @if($isChat)
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L1 17l1.338-3.123C1.493 12.76 1 11.434 1 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd" /></svg>
                                                @else
                                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" /></svg>
                                                @endif
                                            </div>
                                        @endif
                                        
                                        <span class="absolute -top-1 -right-1 block h-3 w-3 rounded-full ring-2 ring-white dark:ring-zinc-900 bg-blue-500 shadow-[0_0_8px_rgba(59,130,246,0.6)]" x-show="!item.read"></span>
                                    </div>

                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                                            <h3 class="font-extrabold text-sm text-slate-800 dark:text-white leading-tight">
                                                {{ $notification->data['title'] ?? 'Notifikasi Baru' }}
                                            </h3>
                                            <span class="text-[10px] font-bold text-slate-400 dark:text-slate-500">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </span>
                                        </div>
                                        <p class="mt-1.5 text-xs text-slate-500 dark:text-slate-400 leading-relaxed font-semibold">
                                            {{ $notification->data['message'] ?? '' }}
                                        </p>
                                        
                                        <div class="mt-3.5 flex items-center gap-3">
                                            @if(isset($notification->data['url']))
                                                <form action="{{ route('notifications.markRead', $notification->id) }}" method="POST" class="m-0" @submit="item.read = true">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-[10px] font-black uppercase tracking-wider transition-all shadow-sm shadow-indigo-600/10">
                                                        Lihat Detail
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path></svg>
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            @if(is_null($notification->read_at) && !isset($notification->data['url']))
                                                <form action="{{ route('notifications.markRead', $notification->id) }}" method="POST" class="m-0" @submit.prevent="item.read = true; fetch($el.action, { method: 'POST', body: new FormData($el) })">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-650 dark:bg-zinc-800 dark:hover:bg-zinc-700 dark:text-slate-350 rounded-xl text-[10px] font-black uppercase tracking-wider transition-all">
                                                        Tandai Dibaca
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Client-Side Empty State -->
                    <div x-show="!hasVisible" class="text-center py-20 flex flex-col items-center justify-center" style="display: none;">
                        <div class="w-24 h-24 rounded-full bg-slate-50 dark:bg-zinc-900/50 flex items-center justify-center mb-6 border border-slate-100 dark:border-white/5 relative overflow-hidden shadow-inner">
                            <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 to-purple-500/5"></div>
                            <svg class="w-10 h-10 text-slate-300 dark:text-zinc-700 relative z-10" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" /></svg>
                        </div>
                        <h3 class="text-lg font-black text-slate-800 dark:text-white mb-2">Belum ada notifikasi</h3>
                        <p class="text-slate-550 dark:text-slate-400 text-xs font-semibold max-w-xs mx-auto">
                            <span x-show="activeFilter === 'all'">Anda belum memiliki notifikasi apapun saat ini.</span>
                            <span x-show="activeFilter === 'unread'">Semua notifikasi Anda sudah dibaca.</span>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
