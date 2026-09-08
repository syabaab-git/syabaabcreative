<x-app-layout>
    @push('styles')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        .ql-toolbar.ql-snow { border-radius: 1rem 1rem 0 0; border-color: #f1f5f9; background: #f8fafc; }
        .ql-container.ql-snow { border-radius: 0 0 1rem 1rem; border-color: #f1f5f9; font-family: 'inter', sans-serif; font-size: 0.875rem; min-height: 120px; }
        .ql-editor { min-height: 120px; }
        .prose img { border-radius: 0.75rem; max-height: 300px; object-fit: contain; }
    </style>
    @endpush

    <x-slot name="header">
        <div class="flex flex-col gap-4">
            <div class="flex justify-between items-start md:items-center flex-col md:flex-row gap-4">
                <div>
                    <h2 class="text-2xl lg:text-3xl font-extrabold text-slate-800 tracking-tight drop-shadow-sm mb-1">
                        Detail Pesanan
                    </h2>
                </div>
            </div>
        </div>
    </x-slot>

    <!-- Alpine X-Data for the Page (includes Payment Modal state) -->
    <div x-data="{ showPaymentModal: false, paymentMethod: 'qris', showUpdateModal: false, showEditUpdateModal: false, editUpdateId: null, editUpdateContent: '', showAttachmentModal: false, activeAttachment: null, showReceiptModal: false, receiptHtml: '' }" @edit-update.window="showEditUpdateModal = true; editUpdateId = $event.detail.id; editUpdateContent = atob($event.detail.content)" class="py-8 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            


            <!-- Layout 3 Kolom -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">
                
                <!-- Kolom Kiri: Informasi & Lampiran -->
                <div class="lg:col-span-1 space-y-6 lg:sticky lg:top-28">
                    <!-- Informasi Pesanan -->
                    <div class="bg-white rounded-[24px] shadow-sm border border-slate-200/60 overflow-hidden">
                        <div class="p-5 border-b border-slate-100 bg-slate-50/50">
                            <h3 class="text-[15px] font-black text-slate-800">Informasi Pesanan</h3>
                        </div>
                        <div class="p-5 space-y-5">
                            <div>
                                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1">Nomor Pesanan</p>
                                <div class="flex items-center gap-2">
                                    <p class="text-slate-800 font-bold text-sm bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100" id="order-number">{{ $order->order_number }}</p>
                                    <button onclick="navigator.clipboard.writeText('{{ $order->order_number }}'); alert('Nomor Pesanan berhasil disalin!');" class="p-1.5 rounded-lg text-blue-600 hover:bg-blue-50 transition-colors border border-transparent hover:border-blue-100" title="Salin Nomor Pesanan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                    </button>
                                </div>
                            </div>
                            
                            <div>
                                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1">Layanan</p>
                                <p class="text-slate-800 font-bold text-sm">{{ $order->service->title ?? 'Layanan Kustom' }}</p>
                            </div>

                            <div>
                                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1">Paket</p>
                                <p class="text-slate-800 font-bold text-sm">{{ $order->package_name ?? 'Kustom' }}</p>
                            </div>

                            <div>
                                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Catatan Tambahan</p>
                                <div class="bg-slate-50 p-4 rounded-xl text-xs text-slate-600 whitespace-pre-line border border-slate-100/80 leading-relaxed shadow-inner max-h-40 overflow-y-auto custom-scrollbar">
                                    {!! $order->requirement !!}
                                </div>
                            </div>
                            
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Lampiran Pemesan</p>
                                    <span class="text-[10px] font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-md">{{ $order->files->count() }} file</span>
                                </div>
                                @if($order->files->count() > 0)
                                    <ul class="space-y-2">
                                        @foreach($order->files as $file)
                                            <li class="group">
                                                <button @click="activeAttachment = { name: '{{ addslashes($file->filename) }}', url: '{{ Storage::url($file->file_path) }}', type: '{{ strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION)) }}' }; showAttachmentModal = true" class="w-full text-left flex items-center gap-3 p-2.5 rounded-xl border border-slate-100 hover:border-slate-200 bg-slate-50 hover:bg-slate-100 transition-all">
                                                    <div class="w-8 h-8 shrink-0 rounded-lg bg-white text-indigo-600 flex items-center justify-center group-hover:scale-110 transition-transform shadow-sm">
                                                        @php $ext = strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION)); @endphp
                                                        @if(in_array($ext, ['jpg','jpeg','png','gif','svg','webp']))
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                        @elseif($ext === 'pdf')
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                        @else
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                        @endif
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <p class="text-[13px] font-bold text-slate-700 truncate group-hover:text-indigo-600 transition-colors">{{ $file->filename }}</p>
                                                        <p class="text-[9px] text-slate-400 uppercase tracking-widest font-bold mt-0.5">{{ strtoupper($ext) }}</p>
                                                    </div>
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="text-center py-4 bg-slate-50 rounded-xl border border-slate-100 border-dashed">
                                        <p class="text-slate-400 text-xs font-bold">Tidak ada lampiran.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom Tengah: Ruang Pembaruan Pesanan (Chat/Forum) -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-[24px] shadow-sm border border-slate-200/60 overflow-hidden flex flex-col">
                        <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between z-10 relative shadow-sm">
                            <h3 class="text-lg font-black text-slate-800 tracking-tight">Chat Langsung Admin</h3>
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-bold text-slate-500 hidden sm:inline-block">Atau Chat di :</span>
                                <div class="flex items-center gap-2">
                                    <a href="{{ $whatsappUrl }}" target="_blank" class="w-10 h-10 rounded-[18px] flex items-center justify-center bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-100 dark:hover:bg-emerald-900/60 hover:text-emerald-700 dark:hover:text-emerald-300 border border-emerald-100/80 dark:border-emerald-900/50 transition-all shadow-sm hover:scale-105 active:scale-95" title="WhatsApp">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    </a>
                                    @php
                                        $instagramUrl = \App\Models\Setting::where('key', 'social_instagram')->value('value') ?? '#';
                                    @endphp
                                    <a href="{{ $instagramUrl }}" target="_blank" class="w-10 h-10 rounded-[18px] flex items-center justify-center bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 hover:bg-rose-100 dark:hover:bg-rose-900/60 hover:text-rose-700 dark:hover:text-rose-300 border border-rose-100/80 dark:border-rose-900/50 transition-all shadow-sm hover:scale-105 active:scale-95" title="Instagram">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0 3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        @php
                            $authBg = json_decode(\App\Models\Setting::where('key', 'auth_background')->value('value') ?? '{}', true);
                            $bgText = $authBg['text'] ?? 'Syabaab Creative';
                            $typoFont = $authBg['font'] ?? 'Inter';
                            $typoSize = ($authBg['size'] ?? 80) . 'px';
                            $typoWeight = $authBg['weight'] ?? 900;
                            $textColor = $authBg['text_color'] ?? '#0f172a';
                            
                            $caseMap = ['uppercase' => 'uppercase', 'lowercase' => 'lowercase'];
                            $typoCase = $caseMap[$authBg['case'] ?? 'normal'] ?? '';
                            $typoItalic = ($authBg['italic'] ?? 'false') === 'true' ? 'italic' : '';
                            $typoStrike = ($authBg['strikethrough'] ?? 'false') === 'true' ? 'line-through' : '';
                            
                            $typoClasses = trim("$typoCase $typoItalic $typoStrike");
                            $typoStyles = "font-family: '{$typoFont}'; font-size: {$typoSize}; font-weight: {$typoWeight}; color: {$textColor};";
                            
                            $hex = ltrim($textColor, '#');
                            $r = hexdec(substr($hex, 0, 2) ? substr($hex, 0, 2) : '00');
                            $g = hexdec(substr($hex, 2, 2) ? substr($hex, 2, 2) : '00');
                            $b = hexdec(substr($hex, 4, 2) ? substr($hex, 4, 2) : '00');
                            $computedBgColor = "rgba($r, $g, $b, 0.05)";
                        @endphp
                        <!-- Area Pesan -->
                        <div x-data="chatComponent({{ $order->id }}, {{ auth()->id() }}, {{ \Illuminate\Support\Js::from($order->updates->map(function($u) {
                                         return [
                                             'id' => $u->id,
                                             'user_id' => $u->user_id,
                                             'content' => $u->content,
                                             'file_path' => $u->file_path ? Storage::url($u->file_path) : null,
                                             'file_name' => $u->file_name,
                                             'created_at' => $u->created_at->toIso8601String(),
                                             'read_at' => $u->read_at,
                                             'status' => $u->read_at ? 'read' : 'delivered',
                                             'user' => [
                                                 'id' => $u->user->id,
                                                 'name' => $u->user->name,
                                                 'avatar' => $u->user->avatar ? Storage::url($u->user->avatar) : null
                                             ]
                                         ];
                                     })->sortBy('created_at')->values()) }})">
                            <div class="h-[600px] relative overflow-hidden" style="background-color: {{ $computedBgColor }};">
                                <!-- Ambient glow for glass refraction in dark mode -->
                                <div class="hidden dark:block absolute top-[10%] left-[10%] w-[120px] h-[120px] bg-blue-500/20 rounded-full blur-[40px] pointer-events-none z-0"></div>
                                <div class="hidden dark:block absolute bottom-[10%] right-[10%] w-[150px] h-[150px] bg-indigo-500/20 rounded-full blur-[50px] pointer-events-none z-0"></div>

                                <div class="absolute inset-[-100%] overflow-hidden flex flex-wrap pointer-events-none select-none z-0 transform -rotate-12 justify-center content-center opacity-10">
                                    @for($i = 0; $i < 150; $i++)
                                        <span class="{{ $typoClasses }} px-6 py-4 whitespace-nowrap leading-none" style="{{ $typoStyles }}">{{ $bgText }}</span>
                                    @endfor
                                </div>
                                
                                    <!-- Daftar Pesan/Revisi -->
                                    <div class="absolute inset-0 overflow-y-auto p-5 md:p-6 pb-4 z-10 space-y-6 custom-scrollbar" x-ref="chatContainer" @scroll="onChatScroll">
                                        <template x-if="messages.length > 0">
                                            <template x-for="update in messages" :key="update.id">
                                                <div class="flex gap-4" :class="update.user_id === currentUserId ? 'flex-row-reverse' : ''">
                                                    
                                                    <div class="shrink-0 relative animate-chat-avatar">
                                                        <template x-if="update.user.avatar">
                                                            <img :src="update.user.avatar" :alt="update.user.name" class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm">
                                                        </template>
                                                        <template x-if="!update.user.avatar">
                                                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold shadow-sm border-2 border-white"
                                                                :class="update.user_id === currentUserId ? 'bg-indigo-600 text-white' : 'bg-slate-200 text-slate-600'"
                                                                x-text="update.user.name.substring(0, 1)">
                                                            </div>
                                                        </template>
                                                    </div>

                                                    <div class="flex flex-col max-w-[85%]" :class="update.user_id === currentUserId ? 'items-end animate-chat-bubble-right' : 'items-start animate-chat-bubble-left'">
                                                        <div class="flex items-center gap-2 mb-1">
                                                            <span class="text-xs font-bold text-slate-700" x-text="update.user.name"></span>
                                                        </div>
                                                        <div class="p-4 rounded-[24px] px-6 py-4 shadow-xl border relative z-10 text-[13px] prose prose-sm max-w-none"
                                                            :class="update.user_id === currentUserId ? 'bg-indigo-600/90 backdrop-blur-2xl border-indigo-500/50 text-white rounded-tr-none prose-invert prose-p:text-white/90 prose-a:text-white' : 'bg-white/80 backdrop-blur-2xl border-white/50 text-slate-800 rounded-tl-none prose-p:text-slate-600'">
                                                            <div x-html="update.content"></div>
                                                            
                                                            <div class="flex items-center justify-end gap-1.5 mt-2">
                                                                <span class="text-[10px] font-medium opacity-80" x-text="formatTime(update.created_at)"></span>
                                                                <template x-if="update.user_id === currentUserId">
                                                                    <div class="flex items-center">
                                                                        <template x-if="update.status === 'sent'">
                                                                            <svg class="w-3 h-3 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                                        </template>
                                                                        <template x-if="update.status === 'delivered'">
                                                                            <svg class="w-3.5 h-3.5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7M11 13l4 4L24 7"></path></svg>
                                                                        </template>
                                                                        <template x-if="update.status === 'read'">
                                                                            <svg class="w-3.5 h-3.5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7M11 13l4 4L24 7"></path></svg>
                                                                        </template>
                                                                    </div>
                                                                </template>
                                                            </div>
                                                        </div>

                                                        <template x-if="update.file_path">
                                                            <div class="mt-2">
                                                                <template x-if="['jpg','jpeg','png','gif','webp','svg'].includes(update.file_name.split('.').pop().toLowerCase())">
                                                                    <a :href="update.file_path" target="_blank" class="block max-w-[200px] overflow-hidden rounded-lg border shadow-sm transition-opacity hover:opacity-90 mt-2" :class="update.user_id === currentUserId ? 'border-indigo-300' : 'border-slate-200'">
                                                                        <img :src="update.file_path" :alt="update.file_name" class="w-full h-auto object-cover">
                                                                    </a>
                                                                </template>
                                                                <template x-if="!['jpg','jpeg','png','gif','webp','svg'].includes(update.file_name.split('.').pop().toLowerCase())">
                                                                    <a :href="update.file_path" target="_blank" class="flex items-center gap-2 px-3 py-1.5 rounded-lg border transition-colors text-xs font-bold"
                                                                    :class="update.user_id === currentUserId ? 'border-indigo-200 bg-indigo-50 text-indigo-700 hover:bg-indigo-100' : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50'">
                                                                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                                        <span class="truncate">Lampiran: <span x-text="update.file_name"></span></span>
                                                                    </a>
                                                                </template>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </template>
                                        </template>
                                        <template x-if="messages.length === 0 && '{{ $order->status }}' !== 'completed'">
                                            <div class="relative z-10 flex flex-col items-center justify-center h-full min-h-[300px] w-full bg-white/40 backdrop-blur-md rounded-2xl border border-white/50 text-center p-8">
                                                <div class="mb-4 text-slate-400">
                                                    <svg class="w-10 h-10 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                                </div>
                                                <p class="text-slate-600 text-sm font-bold">Belum ada obrolan</p>
                                                <p class="text-slate-500 text-xs mt-1 max-w-xs mx-auto">Pesan, revisi, dan file yang dikirim akan muncul di sini.</p>
                                            </div>
                                        </template>
                                        
                                        @if($order->status === 'completed')
                                            <!-- Simulated Chat Bubble from Admin/System -->
                                            <div class="flex gap-4 animate-chat-bubble-left">
                                                <div class="shrink-0 relative">
                                                    <div class="w-10 h-10 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center font-bold shadow-sm border-2 border-white">
                                                        A
                                                    </div>
                                                </div>

                                                <div class="flex flex-col max-w-[85%] items-start">
                                                    <div class="flex items-center gap-2 mb-1">
                                                        <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Admin Syabaab</span>
                                                        <span class="bg-emerald-100 dark:bg-emerald-500/10 text-emerald-800 dark:text-emerald-400 text-[9px] px-1.5 py-0.5 rounded font-black uppercase tracking-wider">Sistem</span>
                                                    </div>
                                                    <div class="p-4 rounded-[24px] rounded-tl-none px-6 py-4 shadow-xl border bg-white/90 dark:bg-slate-900/90 border-slate-100 dark:border-slate-800 text-slate-800 dark:text-slate-100 text-[13px] leading-relaxed space-y-2.5">
                                                        <p class="font-extrabold text-emerald-600 dark:text-emerald-450 flex items-center gap-1.5">
                                                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                                            Pesanan telah selesai. Diskusi telah ditutup.
                                                        </p>
                                                        <p class="text-slate-600 dark:text-slate-300">Terima kasih atas kerja samanya! Pesanan Anda telah ditandai sebagai selesai.</p>
                                                        
                                                        <div class="pt-2.5 border-t border-slate-100 dark:border-slate-800/65 space-y-2 text-[12.5px]">
                                                            <p class="text-slate-600 dark:text-slate-300">
                                                                ✍️ Silakan berikan ulasan Anda dengan <a href="{{ route('member.testimonials.index', ['type' => 'service', 'id' => $order->service_id]) }}" class="font-black text-indigo-600 dark:text-indigo-400 hover:underline">Beri Ulasan di Sini</a> untuk membantu kami meningkatkan kualitas pelayanan.
                                                            </p>
                                                            @if($order->receipt_sent_at)
                                                                <p class="text-slate-600 dark:text-slate-300">
                                                                    🧾 Unduh atau cetak struk pembayaran resmi Anda dengan <a href="{{ route('member.orders.receipt.preview', $order->order_number) }}" target="_blank" class="font-black text-indigo-600 dark:text-indigo-400 hover:underline">Klik di Sini</a> atau melalui tombol struk di bagian <strong>Ringkasan Biaya</strong>.
                                                                </p>
                                                            @endif
                                                        </div>

                                                        <div class="flex items-center justify-end pt-1 text-[10px] text-slate-400 dark:text-slate-500">
                                                            <span>Selesai pada {{ $order->updated_at->format('d M Y H:i') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <!-- Spacer agar pesan terakhir tidak tertutup form absolut -->
                                        <div class="h-20 w-full shrink-0"></div>
                                    </div>

                                    <!-- Form Input / Status Penutup di Bagian Bawah (Glassmorphism) -->
                                    <div class="absolute bottom-0 left-0 right-0 p-4 bg-white/40 dark:bg-slate-900/40 backdrop-blur-md border-t border-white/50 dark:border-slate-800/30 z-20 shadow-[0_-8px_30px_rgb(0,0,0,0.04)]">
                                        @if($order->status !== 'completed')
                                            <form @submit.prevent="sendMessage" class="flex items-end gap-2">
                                                <div class="shrink-0 relative">
                                                    @if(Auth::user()->avatar)
                                                        <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="Avatar" class="w-[46px] h-[46px] rounded-full object-cover shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-white/60">
                                                    @else
                                                        <div class="w-[46px] h-[46px] rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-lg shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-white/20">
                                                            {{ substr(Auth::user()->name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                    <div x-show="isOnline" x-transition class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-emerald-500 border-2 border-white rounded-full"></div>
                                                </div>
                                                <div class="flex-1 relative flex items-end">
                                                    <textarea x-model="quickMessage" rows="1" class="w-full bg-white/70 backdrop-blur-xl border border-white/60 shadow-inner focus:bg-white/90 focus:border-indigo-300 focus:ring focus:ring-indigo-200/50 rounded-[20px] px-4 py-3.5 text-[14px] font-medium text-slate-800 transition-all resize-none overflow-hidden placeholder-slate-400" placeholder="Tambahkan pesan..." x-ref="textarea" @input="$refs.textarea.style.height = 'auto'; $refs.textarea.style.height = $refs.textarea.scrollHeight + 'px'" style="min-height: 46px; max-height: 120px;" @keydown.enter.prevent="sendMessage"></textarea>
                                                </div>
                                                
                                                <div class="shrink-0 flex items-center gap-2">
                                                    <button type="button" @click="showUpdateModal = true" class="w-[46px] h-[46px] bg-white/80 backdrop-blur-xl border border-white/60 shadow-md hover:shadow-lg hover:-translate-y-0.5 rounded-[18px] flex items-center justify-center transition-all duration-300 text-slate-600 hover:bg-white hover:text-indigo-600" title="Opsi Lanjutan & Lampiran">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                    </button>
                                                    
                                                    <button type="submit" x-show="quickMessage.trim().length > 0" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4 scale-90" x-transition:enter-end="opacity-100 translate-x-0 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-x-0 scale-100" x-transition:leave-end="opacity-0 translate-x-4 scale-90" class="w-[46px] h-[46px] bg-indigo-600/90 backdrop-blur-xl border border-indigo-500/50 text-white rounded-[18px] flex items-center justify-center hover:bg-indigo-600 shadow-md transition-all">
                                                        <svg class="w-5 h-5 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                                    </button>
                                                </div>
                                            </form>
                                        @else
                                            <div class="flex justify-center items-center py-1">
                                                <span class="text-xs sm:text-sm font-bold text-slate-500 dark:text-slate-400 flex items-center gap-2 bg-slate-200/40 dark:bg-slate-800/50 px-5 py-2.5 rounded-full border border-slate-300/30 dark:border-slate-700/30 backdrop-blur-sm shadow-inner">
                                                    <svg class="w-4 h-4 text-emerald-500 dark:text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Diskusi Ditutup karena Pesanan Telah Selesai
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <!-- Kolom Kanan: Status Timeline, Ringkasan Biaya, Timer -->
                <div class="lg:col-span-1 space-y-6 lg:sticky lg:top-28">
                    
                    <!-- Timeline Riwayat Status -->
                    <div class="bg-white rounded-[24px] shadow-sm border border-slate-200/60 overflow-hidden">
                        <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                            <h3 class="text-[15px] font-black text-slate-800">Status Pesanan</h3>
                            @if($order->status === 'pending')
                            <form action="{{ route('member.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-bold text-red-500 hover:text-red-600 transition-colors flex items-center gap-1" title="Batalkan Pesanan">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Batalkan
                                </button>
                            </form>
                            @endif
                        </div>
                        <div class="p-5">
                            @php
                                $statusHistory = [
                                    [
                                        'status' => 'Pending',
                                        'desc' => 'Menunggu pembayaran',
                                        'time' => $order->created_at,
                                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
                                        'color' => 'amber',
                                        'active' => true,
                                        'done' => in_array($order->status, ['processing', 'completed', 'cancelled'])
                                    ],
                                    [
                                        'status' => 'Diproses',
                                        'desc' => 'Sedang dikerjakan',
                                        'time' => in_array($order->status, ['processing', 'completed']) ? $order->updated_at : null,
                                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>',
                                        'color' => 'blue',
                                        'active' => in_array($order->status, ['processing', 'completed']),
                                        'done' => $order->status === 'completed'
                                    ],
                                    [
                                        'status' => 'Selesai',
                                        'desc' => 'Telah selesai',
                                        'time' => $order->status === 'completed' ? $order->updated_at : null,
                                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>',
                                        'color' => 'emerald',
                                        'active' => $order->status === 'completed',
                                        'done' => $order->status === 'completed'
                                    ]
                                ];

                                if ($order->status === 'cancelled') {
                                    $statusHistory[1] = [
                                        'status' => 'Dibatalkan',
                                        'desc' => 'Telah dibatalkan',
                                        'time' => $order->updated_at,
                                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>',
                                        'color' => 'red',
                                        'active' => true,
                                        'done' => true
                                    ];
                                    unset($statusHistory[2]);
                                }
                            @endphp

                            <div class="flex gap-4">
                                <div class="flex-1 relative pl-4 space-y-5 border-l border-slate-200 ml-2 mb-4">
                                @foreach($statusHistory as $step)
                                    <div class="relative">
                                        <div class="absolute -left-[21px] top-1 w-2.5 h-2.5 rounded-full ring-4 ring-white {{ $step['active'] ? 'bg-'.$step['color'].'-500' : 'bg-slate-200' }}"></div>
                                        <div>
                                            <h4 class="text-sm font-bold {{ $step['active'] ? 'text-slate-800' : 'text-slate-400' }}">{{ $step['status'] }}</h4>
                                            @if($step['time'])
                                                <p class="text-[10px] text-slate-400 mt-0.5">{{ \Carbon\Carbon::parse($step['time'])->isoFormat('D MMM Y • HH:mm') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                                </div>

                                @if($order->estimation_date && in_array($order->status, ['pending', 'processing']))
                                <div class="shrink-0 flex flex-col items-end justify-start border-l border-slate-100 pl-5" 
                                     x-data="{
                                        start_date: new Date('{{ \Carbon\Carbon::parse($order->created_at)->toIso8601String() }}').getTime(),
                                        deadline: new Date('{{ \Carbon\Carbon::parse($order->estimation_date)->toIso8601String() }}').getTime(),
                                        days: '00', hours: '00', minutes: '00', seconds: '00',
                                        progress: 0,
                                        expired: false,
                                        interval: null,
                                        start() {
                                            this.update();
                                            this.interval = setInterval(() => this.update(), 1000);
                                        },
                                        update() {
                                            const now = new Date().getTime();
                                            const distance = this.deadline - now;
                                            
                                            const totalDuration = this.deadline - this.start_date;
                                            const elapsed = now - this.start_date;
                                            let p = (elapsed / totalDuration) * 100;
                                            if(p > 100) p = 100;
                                            if(p < 0) p = 0;
                                            this.progress = p;

                                            if (distance < 0) {
                                                this.expired = true;
                                                this.progress = 100;
                                                clearInterval(this.interval);
                                                return;
                                            }
                                            this.days = String(Math.floor(distance / (1000 * 60 * 60 * 24))).padStart(2, '0');
                                            this.hours = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
                                            this.minutes = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                                            this.seconds = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');
                                        }
                                     }" x-init="start()">
                                    <div class="flex flex-col gap-2.5 w-full mt-1" x-show="!expired">
                                        <div class="flex items-center justify-end w-full">
                                            <span class="text-[22px] font-black tracking-tighter text-slate-800 leading-none w-9 text-right" x-text="days"></span>
                                            <span class="text-[10px] font-bold text-slate-400 tracking-normal uppercase ml-2 w-10 text-left">Hari</span>
                                        </div>
                                        <div class="flex items-center justify-end w-full">
                                            <span class="text-[22px] font-black tracking-tighter text-slate-800 leading-none w-9 text-right" x-text="hours"></span>
                                            <span class="text-[10px] font-bold text-slate-400 tracking-normal uppercase ml-2 w-10 text-left">Jam</span>
                                        </div>
                                        <div class="flex items-center justify-end w-full">
                                            <span class="text-[22px] font-black tracking-tighter text-slate-800 leading-none w-9 text-right" x-text="minutes"></span>
                                            <span class="text-[10px] font-bold text-slate-400 tracking-normal uppercase ml-2 w-10 text-left">Menit</span>
                                        </div>
                                        <div class="flex items-center justify-end w-full">
                                            <span class="text-[22px] font-black tracking-tighter text-blue-600 leading-none w-9 text-right" x-text="seconds"></span>
                                            <span class="text-[10px] font-bold text-blue-400 tracking-normal uppercase ml-2 w-10 text-left">Detik</span>
                                        </div>
                                    </div>
                                    
                                    <div x-show="expired" class="w-full text-right mt-1">
                                        <span class="inline-block text-[9px] font-black text-rose-500 bg-rose-50 px-2 py-1 rounded-md border border-rose-100">
                                            WAKTU HABIS
                                        </span>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @php
                        $statusColors = [
                            'pending' => 'bg-amber-100 text-amber-700 border-amber-200',
                            'processing' => 'bg-blue-100 text-blue-700 border-blue-200',
                            'completed' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                            'cancelled' => 'bg-red-100 text-red-700 border-red-200',
                        ];
                        $statusText = [
                            'pending' => 'Menunggu Pembayaran',
                            'processing' => 'Diproses',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                        ];
                        $color = $statusColors[$order->status] ?? 'bg-slate-100 text-slate-700 border-slate-200';
                        $text = $statusText[$order->status] ?? ucfirst($order->status);
                    @endphp
                    <!-- Ringkasan Biaya -->
                    <div class="bg-white rounded-[24px] shadow-sm border border-slate-200/60 overflow-hidden">
                        <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                            <h3 class="text-[12px] font-black text-slate-800 uppercase tracking-widest">Ringkasan Biaya</h3>
                            <span class="px-2.5 py-1 rounded-lg border text-[10px] font-black uppercase tracking-wider {{ $color }} shadow-sm">
                                {{ $text }}
                            </span>
                        </div>
                        <div class="p-5">
                            <div class="space-y-3 mb-4">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="font-bold text-slate-500">Harga Layanan</span>
                                    <span class="font-bold text-slate-800">Rp {{ number_format($order->amount, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="font-bold text-slate-500">Biaya Admin</span>
                                    <span class="font-bold text-slate-800">Rp 0</span>
                                </div>
                            </div>
                            <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Total Tagihan</p>
                                    <p class="text-2xl font-black text-blue-600 tracking-tight">Rp {{ number_format($order->amount, 0, ',', '.') }}</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    @if($order->status === 'pending')
                                    <button @click="showPaymentModal = true" 
                                        class="w-10 h-10 rounded-[18px] flex items-center justify-center bg-blue-50 dark:bg-blue-950/40 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-blue-900/60 hover:text-blue-700 dark:hover:text-blue-300 border border-blue-100/80 dark:border-blue-900/50 transition-all shadow-sm hover:scale-105 active:scale-95" title="Pilih Metode Pembayaran">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                                            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    @endif
                                    @if($order->receipt_sent_at)
                                    <button type="button" onclick="openMemberReceipt('{{ route('member.orders.receipt.preview', $order->order_number) }}', '{{ route('member.orders.receipt.download', $order->order_number) }}')" 
                                        class="w-10 h-10 rounded-[18px] flex items-center justify-center bg-blue-50 dark:bg-blue-955/40 text-blue-600 dark:text-blue-400 hover:bg-blue-100 dark:hover:bg-indigo-900/60 hover:text-blue-700 dark:hover:text-blue-300 border border-blue-100/80 dark:border-blue-900/50 transition-all shadow-sm hover:scale-105 active:scale-95" title="Lihat Struk">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4v3h10V4H5zM3 8h14a2 2 0 012 2v5a2 2 0 01-2 2h-2v2a1 1 0 01-1 1H6a1 1 0 01-1-1v-2H3a2 2 0 01-2-2v-5a2 2 0 012-2zm2.5 10h9v-2h-9v2zM17 11a1 1 0 110-2 1 1 0 010 2z" /></svg>
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    

                </div>
            </div>

        </div>

        <!-- MODAL TAMBAH PEMBARUAN (QUILL) -->
        <div x-show="showUpdateModal" style="display: none;" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showUpdateModal" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="showUpdateModal = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
                <div x-show="showUpdateModal" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     class="inline-block align-bottom bg-white rounded-3xl text-left overflow-visible shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full">
                    
                    <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50 rounded-t-3xl">
                        <h3 class="text-lg font-black text-slate-800">Tulis Pembaruan / Lampirkan File</h3>
                        <button @click="showUpdateModal = false" class="text-slate-400 hover:text-slate-600 bg-white hover:bg-slate-100 p-2 rounded-full transition-colors border border-slate-200 shadow-sm">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <form action="{{ route('order-updates.store', $order) }}" method="POST" enctype="multipart/form-data" id="updateForm" class="p-6">
                        @csrf
                        <div class="mb-5">
                            <div id="editor-container" class="bg-white"></div>
                            <input type="hidden" name="content" id="content-input">
                            @error('content')
                                <p class="text-rose-500 text-xs mt-2 font-bold">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-6 p-4 border border-dashed border-slate-300 rounded-xl bg-slate-50/50 hover:bg-slate-50 hover:border-indigo-300 transition-colors group relative">
                            <label class="flex flex-col items-center justify-center cursor-pointer">
                                <div class="p-3 bg-white rounded-full shadow-sm mb-3 group-hover:scale-110 transition-transform">
                                    <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                </div>
                                <span class="text-sm font-bold text-slate-700">Klik untuk melampirkan file</span>
                                <span class="text-xs text-slate-400 mt-1">Opsional. Maksimal ukuran file 10MB</span>
                                <input type="file" name="attachment" class="hidden" onchange="document.getElementById('file-name-display').textContent = this.files[0] ? this.files[0].name : ''">
                            </label>
                            <div id="file-name-display" class="mt-3 text-center text-xs font-bold text-indigo-600 truncate px-4"></div>
                        </div>

                        <div class="flex justify-end pt-2 border-t border-slate-100 mt-2">
                            <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-slate-900 hover:bg-indigo-600 text-white rounded-xl font-black text-sm transition-all shadow-md hover:shadow-xl hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                Kirim Pembaruan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- PAYMENT MODAL -->
        <div x-show="showPaymentModal" 
             style="display: none;"
             class="fixed inset-0 z-[100] overflow-y-auto" 
             aria-labelledby="modal-title" role="dialog" aria-modal="true">
            
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div x-show="showPaymentModal" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 backdrop-blur-none" 
                     x-transition:enter-end="opacity-100 backdrop-blur-sm" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 backdrop-blur-sm" 
                     x-transition:leave-end="opacity-0 backdrop-blur-none" 
                     class="fixed inset-0 bg-slate-900/60 transition-all" 
                     @click="showPaymentModal = false"
                     aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal Panel -->
                <div x-show="showPaymentModal" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     class="inline-block align-bottom bg-white rounded-[32px] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full border border-slate-100 relative">
                    
                    <!-- Close button -->
                    <button @click="showPaymentModal = false" class="absolute top-5 right-5 w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>

                    <div class="px-6 pt-8 pb-6 sm:px-8">
                        <div class="text-center mb-6">
                            <div class="mx-auto flex items-center justify-center h-14 w-14 rounded-full bg-blue-50 text-blue-600 mb-4 shadow-sm border border-blue-100">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <h3 class="text-xl font-black text-slate-800 tracking-tight" id="modal-title">Metode Pembayaran</h3>
                            <p class="text-sm text-slate-500 mt-2 font-medium">Pilih metode pembayaran yang paling nyaman untuk Anda.</p>
                        </div>

                        <!-- Total Tagihan di Modal -->
                        <div class="bg-slate-50 rounded-2xl p-4 flex items-center justify-between mb-6 border border-slate-100">
                            <span class="text-sm font-bold text-slate-500">Total Tagihan</span>
                            <span class="text-xl font-black text-blue-600">Rp {{ number_format($order->amount, 0, ',', '.') }}</span>
                        </div>

                        <!-- Toggle QRIS / Transfer -->
                        <div class="flex p-1 bg-slate-100 rounded-xl mb-6">
                            <button @click="paymentMethod = 'qris'" 
                                    :class="paymentMethod === 'qris' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                                    class="flex-1 py-2 text-sm font-bold rounded-lg transition-all text-center">
                                QRIS
                            </button>
                            <button @click="paymentMethod = 'transfer'" 
                                    :class="paymentMethod === 'transfer' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                                    class="flex-1 py-2 text-sm font-bold rounded-lg transition-all text-center">
                                Transfer Bank
                            </button>
                        </div>

                        <!-- Tab Content: QRIS -->
                        <div x-show="paymentMethod === 'qris'" x-transition.opacity>
                            <div class="bg-white rounded-2xl border border-slate-200 p-6 text-center">
                                @if(!empty($settings['payment_qris_image']))
                                    <img src="{{ Storage::url($settings['payment_qris_image']) }}" alt="QRIS Barcode" class="mx-auto w-48 h-48 object-contain mb-4 rounded-xl border border-slate-100 shadow-sm p-2">
                                    <p class="text-sm font-bold text-slate-700 mb-1">Scan QRIS ini</p>
                                    <p class="text-xs text-slate-500">Buka aplikasi m-Banking atau e-Wallet Anda dan scan barcode di atas.</p>
                                @else
                                    <div class="py-8 flex flex-col items-center justify-center border-2 border-dashed border-slate-200 rounded-xl">
                                        <svg class="w-10 h-10 text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                        <p class="text-sm font-bold text-slate-400">Barcode QRIS belum tersedia.</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Tab Content: Transfer Bank -->
                        <div x-show="paymentMethod === 'transfer'" x-transition.opacity style="display: none;">
                            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                                <div class="p-4 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                                    <h4 class="font-black text-slate-800 text-sm flex items-center gap-2">
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                        {{ $settings['payment_bank_name'] ?? 'Bank Transfer' }}
                                    </h4>
                                </div>
                                <div class="p-5 space-y-4">
                                    @if(empty($settings['payment_bank_account']))
                                        <p class="text-sm font-bold text-slate-400 text-center py-4">Data rekening belum tersedia.</p>
                                    @else
                                        <div>
                                            <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1">Nomor Rekening</p>
                                            <div class="flex items-center justify-between">
                                                <p class="text-xl font-black text-slate-800 tracking-tight" id="bank-account">{{ $settings['payment_bank_account'] }}</p>
                                                <!-- Copy Button -->
                                                <button onclick="navigator.clipboard.writeText('{{ $settings['payment_bank_account'] }}'); alert('Nomor Rekening berhasil disalin!');" class="p-1.5 rounded-lg text-blue-600 hover:bg-blue-50 transition-colors" title="Salin Rekening">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1">Atas Nama</p>
                                            <p class="text-sm font-bold text-slate-600">{{ $settings['payment_bank_owner'] ?? '-' }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100 sm:px-8 text-center">
                        <p class="text-[13px] text-slate-600 mb-4 font-medium">Setelah transfer, mohon kirimkan bukti pembayaran melalui WhatsApp.</p>
                        <a href="{{ $whatsappUrl }}" target="_blank" class="w-full inline-flex justify-center items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-xl font-black text-sm shadow-lg shadow-blue-600/20 hover:bg-blue-700 hover:shadow-xl hover:-translate-y-0.5 transition-all">
                            Konfirmasi Pembayaran
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ATTACHMENT VIEWER MODAL -->
        <div x-show="showAttachmentModal" style="display: none;" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
                <div x-show="showAttachmentModal" x-transition.opacity class="fixed inset-0 bg-slate-900/90 backdrop-blur-md transition-opacity" @click="showAttachmentModal = false"></div>
                <div x-show="showAttachmentModal" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 scale-95" 
                     x-transition:enter-end="opacity-100 scale-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 scale-100" 
                     x-transition:leave-end="opacity-0 scale-95" 
                     class="inline-block bg-transparent text-left overflow-hidden transform transition-all sm:max-w-4xl w-full relative z-10">
                    
                    <button @click="showAttachmentModal = false" class="absolute -top-12 right-0 text-white hover:text-slate-300 transition-colors flex items-center gap-2 font-bold text-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        Tutup
                    </button>

                    <template x-if="activeAttachment">
                        <div class="w-full h-full flex items-center justify-center">
                            <template x-if="['jpg','jpeg','png','gif','svg','webp'].includes(activeAttachment.type)">
                                <img :src="activeAttachment.url" class="max-w-full max-h-[70vh] rounded-xl shadow-sm object-contain" alt="Lampiran">
                            </template>
                            <template x-if="activeAttachment.type === 'pdf'">
                                <iframe :src="activeAttachment.url" class="w-full h-[70vh] rounded-xl shadow-sm bg-white" frameborder="0"></iframe>
                            </template>
                            <template x-if="!['jpg','jpeg','png','gif','svg','webp','pdf'].includes(activeAttachment.type)">
                                <div class="text-center">
                                    <div class="w-20 h-20 mx-auto bg-white rounded-2xl flex items-center justify-center shadow-sm text-slate-400 mb-4">
                                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <p class="text-slate-600 font-medium mb-4">File ini tidak dapat dipratinjau secara langsung.</p>
                                    <a :href="activeAttachment.url" target="_blank" class="inline-flex items-center gap-2 px-6 py-2.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition-colors shadow-sm shadow-indigo-600/20">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        Unduh File
                                    </a>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Edit Update Modal -->
        <div x-show="showEditUpdateModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6" style="display: none;">
            <div x-show="showEditUpdateModal" x-transition.opacity class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showEditUpdateModal = false"></div>
            
            <div x-show="showEditUpdateModal" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                 x-transition:leave-end="opacity-0 translate-y-8 scale-95"
                 class="relative w-full max-w-2xl bg-white rounded-3xl shadow-2xl overflow-hidden flex flex-col">
                
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <h3 class="text-lg font-black text-slate-800">Edit Pembaruan</h3>
                    <button @click="showEditUpdateModal = false" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <form :action="`/order-updates/${editUpdateId}`" method="POST" enctype="multipart/form-data" class="p-6 flex-1 overflow-y-auto">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <div>                            <label class="block text-sm font-bold text-slate-700 mb-2">Pesan Pembaruan</label>
                            <input type="hidden" name="content" id="editUpdateContentInput" :value="editUpdateContent">
                            <div id="edit-editor" class="bg-white rounded-xl" style="min-height: 150px;"></div>
                            <p class="text-xs text-slate-500 mt-2">Pesan hanya dapat diubah maksimal 30 menit setelah dikirim.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Ganti Lampiran (Opsional)</label>
                            <div class="relative group">
                                <input type="file" name="attachment" id="edit-attachment" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                    onchange="document.getElementById('edit-file-name').textContent = this.files[0] ? this.files[0].name : 'Pilih file atau tarik ke sini'">
                                <div class="border-2 border-dashed border-slate-200 rounded-2xl p-6 text-center group-hover:border-indigo-400 group-hover:bg-indigo-50/50 transition-colors bg-slate-50">
                                    <div class="w-10 h-10 bg-white rounded-full shadow-sm flex items-center justify-center mx-auto mb-3 text-slate-400 group-hover:text-indigo-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    </div>
                                    <p class="text-sm font-bold text-slate-700 mb-1">Unggah File Baru</p>
                                    <p id="edit-file-name" class="text-xs font-medium text-slate-500">Akan menggantikan lampiran lama (Maks: 10MB)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-8 flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                        <button type="button" @click="showEditUpdateModal = false" class="px-6 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2.5 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm shadow-indigo-600/20 transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

        <!-- Receipt Modal for Member - matching admin premium style -->
        <style>
            #member-receipt-panel .custom-scrollbar::-webkit-scrollbar {
                width: 6px;
            }
            #member-receipt-panel .custom-scrollbar::-webkit-scrollbar-track {
                background: transparent;
            }
            #member-receipt-panel .custom-scrollbar::-webkit-scrollbar-thumb {
                background: rgba(148, 163, 184, 0.2);
                border-radius: 9999px;
                border: 2px solid transparent;
                background-clip: padding-box;
            }
            #member-receipt-panel .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: rgba(148, 163, 184, 0.4);
                border: 2px solid transparent;
                background-clip: padding-box;
            }
        </style>
        <div id="member-receipt-modal" x-data="{ previewZoom: 1.0 }" x-on:open-receipt-modal.window="previewZoom = 1.0" class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;" aria-modal="true" role="dialog">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Backdrop -->
                <div id="member-receipt-backdrop" class="fixed inset-0 bg-slate-900/60 dark:bg-slate-950/80 backdrop-blur-sm transition-opacity" onclick="closeMemberReceipt()"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <!-- Modal Panel -->
                <div id="member-receipt-panel" class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-[32px] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full border border-slate-100 dark:border-slate-800 relative h-[80vh]">
                    
                    <!-- Header - Absolute & Glassmorphism -->
                    <div class="absolute top-0 left-0 right-0 z-30 px-8 pt-8 pb-5 bg-white/70 dark:bg-slate-900/75 backdrop-blur-md border-b border-slate-100 dark:border-slate-800/60 rounded-t-[32px]">
                        <div class="flex items-center gap-3 mb-1">
                            <div class="w-9 h-9 rounded-xl bg-indigo-50 dark:bg-indigo-955/40 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4v3h10V4H5zM3 8h14a2 2 0 012 2v5a2 2 0 01-2 2h-2v2a1 1 0 01-1 1H6a1 1 0 01-1-1v-2H3a2 2 0 01-2-2v-5a2 2 0 012-2zm2.5 10h9v-2h-9v2zM17 11a1 1 0 110-2 1 1 0 010 2z" /></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-black text-slate-800 dark:text-slate-100 tracking-tight">Pratinjau Struk</h3>
                                <p class="text-xs text-slate-400 dark:text-slate-500 font-medium">Struk pembayaran resmi untuk pesanan Anda</p>
                            </div>
                        </div>
                    </div>

                    <!-- Scrollable Wrapper (Absolute Fill) -->
                    <div class="absolute inset-0 overflow-y-auto custom-scrollbar bg-slate-50/50 dark:bg-slate-900/20 pt-[110px] pb-[110px] px-8">
                        <div class="min-h-full w-full flex items-center justify-center py-6">
                            <div class="transition-transform duration-200 my-auto flex items-center justify-center" :style="{ transform: 'scale(' + previewZoom + ')', transformOrigin: 'center center' }">
                                <div id="member-receipt-content" class="bg-white dark:bg-slate-900 shadow-sm rounded-xl w-full max-w-md overflow-hidden border border-slate-100 dark:border-slate-800">
                                    <div class="p-6 text-center text-slate-400 dark:text-slate-500 text-sm">Memuat preview...</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Floating Zoom Controller -->
                    <div class="absolute bottom-[96px] left-1/2 transform -translate-x-1/2 z-35 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md px-3 py-1.5 rounded-xl shadow-lg border border-slate-200/80 dark:border-slate-800/85 flex items-center gap-2 text-[11px] font-bold text-slate-700 dark:text-slate-200 w-max mx-auto">
                        <button type="button" @click="previewZoom = Math.max(0.5, previewZoom - 0.1)" class="w-6 h-6 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 flex items-center justify-center transition-all shadow-sm" title="Zoom Out">
                            <svg class="w-3.5 h-3.5 text-slate-600 dark:text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" /></svg>
                        </button>
                        <span class="min-w-[35px] text-center" x-text="Math.round(previewZoom * 100) + '%'"></span>
                        <button type="button" @click="previewZoom = Math.min(1.5, previewZoom + 0.1)" class="w-6 h-6 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 flex items-center justify-center transition-all shadow-sm" title="Zoom In">
                            <svg class="w-3.5 h-3.5 text-slate-600 dark:text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" /></svg>
                        </button>
                        <div class="h-3 w-[1px] bg-slate-200 dark:bg-slate-800"></div>
                        <button type="button" @click="previewZoom = 1.0" class="px-2 py-1 rounded-lg bg-indigo-50 dark:bg-indigo-955/40 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-600 dark:hover:bg-indigo-500 hover:text-white dark:hover:text-white transition-all shadow-sm">Reset</button>
                    </div>

                    <!-- Footer - Absolute & Glassmorphism -->
                    <div class="absolute bottom-0 left-0 right-0 z-30 px-8 py-5 bg-slate-50/70 dark:bg-slate-900/75 backdrop-blur-md border-t border-slate-100 dark:border-slate-800/60 flex items-center justify-between rounded-b-[32px]">
                        <button type="button" onclick="printMemberReceipt()" class="flex items-center gap-2 px-5 py-3 bg-white dark:bg-slate-800 hover:bg-slate-900 dark:hover:bg-white text-slate-700 dark:text-slate-200 hover:text-white dark:hover:text-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl font-bold text-sm shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4v3h10V4H5zM3 8h14a2 2 0 012 2v5a2 2 0 01-2 2h-2v2a1 1 0 01-1 1H6a1 1 0 01-1-1v-2H3a2 2 0 01-2-2v-5a2 2 0 012-2zm2.5 10h9v-2h-9v2zM17 11a1 1 0 110-2 1 1 0 010 2z" /></svg>
                            Cetak
                        </button>
                        <div class="flex gap-2.5">
                            <a id="member-receipt-download" href="#" target="_blank" class="flex items-center gap-2 px-5 py-3 bg-indigo-600 dark:bg-indigo-500 hover:bg-indigo-700 dark:hover:bg-indigo-600 text-white rounded-2xl font-bold text-sm shadow-lg shadow-indigo-600/20 dark:shadow-indigo-500/10 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 110-2h12zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" /></svg>
                                Unduh PDF
                            </a>
                        </div>
                    </div>

                    <!-- Close button -->
                    <button onclick="closeMemberReceipt()" class="group absolute top-6 right-6 h-10 w-10 rounded-full flex items-center justify-center bg-slate-100/80 dark:bg-slate-800/80 backdrop-blur-md border border-slate-200/50 dark:border-slate-700/50 text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 hover:scale-110 active:scale-95 transition-all duration-300 shadow-[0_4px_12px_0_rgba(0,0,0,0.02)] hover:shadow-[0_4px_16px_0_rgba(0,0,0,0.08)] focus:outline-none z-50" title="Tutup">
                        <svg class="w-5 h-5 transition-transform duration-300 ease-out group-hover:rotate-90" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- RECEIPT MODAL -->
        <div x-show="showReceiptModal" 
             style="display: none;"
             class="fixed inset-0 z-[100] overflow-y-auto" 
             aria-labelledby="modal-title" role="dialog" aria-modal="true">
            
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showReceiptModal" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 backdrop-blur-none" 
                     x-transition:enter-end="opacity-100 backdrop-blur-sm" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 backdrop-blur-sm" 
                     x-transition:leave-end="opacity-0 backdrop-blur-none" 
                     class="fixed inset-0 bg-slate-900/60 transition-all" 
                     @click="showReceiptModal = false"
                     aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal Panel -->
                <div x-show="showReceiptModal" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     class="inline-block align-bottom bg-white rounded-[32px] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full border border-slate-100 relative">
                    
                    <!-- Close button -->
                    <button @click="showReceiptModal = false" class="absolute top-5 right-5 w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 hover:bg-slate-200 transition-colors z-10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>

                    <!-- Header -->
                    <div class="px-8 pt-8 pb-5 border-b border-slate-100">
                        <div class="flex items-center gap-3 mb-1">
                            <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-black text-slate-800 tracking-tight">Struk Pesanan</h3>
                                <p class="text-xs text-slate-400 font-medium">Struk resmi dari layanan Anda</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50/80 px-8 py-6 flex justify-center max-h-[52vh] overflow-y-auto">
                        <div x-html="receiptHtml" class="bg-white shadow-sm rounded-xl w-full max-w-md overflow-hidden border border-slate-100"></div>
                    </div>

                    <div class="px-8 py-5 bg-slate-50 border-t border-slate-100 flex justify-end">
                        <a href="{{ route('member.orders.receipt.download', $order->order_number) }}" target="_blank" class="flex items-center gap-2 px-5 py-2.5 bg-emerald-600 text-white hover:bg-emerald-700 rounded-2xl font-bold text-sm shadow-sm transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Unduh Struk
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('chatComponent', (orderId, currentUserId, initialMessages) => ({
                    orderId: orderId,
                    currentUserId: currentUserId,
                    messages: initialMessages,
                    quickMessage: '',
                    isOnline: false,
                    lastScrollTop: 0,

                    onChatScroll(e) {
                        const currentScrollTop = e.target.scrollTop;
                        if (currentScrollTop > this.lastScrollTop) {
                            // Scrolling down
                            const scrollableDistance = document.body.scrollHeight - window.innerHeight;
                            if (window.scrollY < scrollableDistance - 50) {
                                window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
                            }
                        }
                        this.lastScrollTop = currentScrollTop;
                    },

                    init() {
                        this.$nextTick(() => {
                            this.scrollToBottom();
                            setTimeout(() => {
                                this.scrollToBottom();
                                window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
                            }, 100);
                        });

                        // Listen to Presence Channel
                        if (window.Echo) {
                            window.Echo.join(`order.${this.orderId}`)
                                .here((users) => {
                                    this.checkOnlineStatus(users);
                                })
                                .joining((user) => {
                                    this.isOnline = true;
                                    this.markUnreadAsRead();
                                })
                                .leaving((user) => {
                                    this.isOnline = false;
                                })
                                .listen('MessageSent', (e) => {
                                    if (e.update.user_id !== this.currentUserId) {
                                        this.messages.push({
                                            ...e.update,
                                            status: this.isOnline ? 'read' : 'delivered'
                                        });
                                        this.$nextTick(() => this.scrollToBottom());
                                    }
                                    
                                    if (e.update.user_id !== this.currentUserId) {
                                        this.markUnreadAsRead();
                                    }
                                })
                                .listen('MessageRead', (e) => {
                                    this.messages = this.messages.map(msg => {
                                        if (e.messageIds.includes(msg.db_id || msg.id)) {
                                            return { ...msg, read_at: e.readAt, status: 'read' };
                                        }
                                        return msg;
                                    });
                                });
                        }
                    },

                    checkOnlineStatus(users) {
                        // Check if there's someone else in the room
                        this.isOnline = users.some(u => u.id !== this.currentUserId);
                        if (this.isOnline) {
                            this.markUnreadAsRead();
                        }
                    },

                    markUnreadAsRead() {
                        const unreadIds = this.messages
                            .filter(m => m.user_id !== this.currentUserId && !m.read_at)
                            .map(m => m.id);

                        if (unreadIds.length > 0) {
                            fetch(`/order-updates/${this.orderId}/read`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({ message_ids: unreadIds })
                            });
                        }
                    },

                    scrollToBottom() {
                        const container = this.$refs.chatContainer;
                        if (container) {
                            container.scrollTop = container.scrollHeight;
                        }
                    },

                    formatTime(dateString) {
                        const date = new Date(dateString);
                        return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                    },

                    sendMessage() {
                        if (!this.quickMessage.trim()) return;
                        
                        let tempId = 'temp_' + Date.now();
                        let msgContent = this.quickMessage;
                        this.quickMessage = '';

                        // Optimistic UI update
                        this.messages.push({
                            id: tempId,
                            user_id: this.currentUserId,
                            content: msgContent,
                            file_path: null,
                            file_name: null,
                            created_at: new Date().toISOString(),
                            read_at: null,
                            status: 'sent',
                            user: {
                                id: this.currentUserId,
                                name: 'You',
                                avatar: null
                            }
                        });
                        this.$nextTick(() => this.scrollToBottom());

                        fetch(`/order-updates/${this.orderId}`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ content: msgContent })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                // Replace temp message with real one
                                this.messages = this.messages.map(m => {
                                    if (m.id === tempId) {
                                        return {
                                            ...data.update,
                                            id: tempId, // keep tempId so Alpine doesn't tear down the DOM
                                            db_id: data.update.id,
                                            status: this.isOnline ? 'read' : 'delivered'
                                        };
                                    }
                                    return m;
                                });
                            }
                        })
                        .catch(err => console.error(err));
                    }
                }));
            });

            document.addEventListener('DOMContentLoaded', function() {
                // Initialize edit Quill Editor when edit modal opens
                let editQuill;
                window.addEventListener('edit-update', (event) => {
                    if (!editQuill) {
                        editQuill = new Quill('#edit-editor', {
                            theme: 'snow',
                            placeholder: 'Tulis pembaruan Anda di sini...',
                            modules: {
                                toolbar: [
                                    ['bold', 'italic', 'underline', 'strike'],
                                    ['blockquote', 'code-block'],
                                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                    ['link'],
                                    ['clean']
                                ]
                            }
                        });
                        editQuill.on('text-change', function() {
                            document.getElementById('editUpdateContentInput').value = editQuill.root.innerHTML;
                        });
                    }
                    editQuill.root.innerHTML = atob(event.detail.content);
                });

                if (document.getElementById('editor-container')) {
                    var quill = new Quill('#editor-container', {
                        theme: 'snow',
                        placeholder: 'Tuliskan pembaruan pesanan atau keterangan file yang diunggah...',
                        modules: {
                            toolbar: [
                                ['bold', 'italic', 'underline', 'strike'],
                                ['blockquote', 'code-block'],
                                [{ 'header': 1 }, { 'header': 2 }],
                                [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                                [{ 'script': 'sub'}, { 'script': 'super' }],
                                [{ 'indent': '-1'}, { 'indent': '+1' }],
                                [{ 'direction': 'rtl' }],
                                [{ 'size': ['small', false, 'large', 'huge'] }],
                                [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                                [{ 'color': [] }, { 'background': [] }],
                                [{ 'font': [] }],
                                [{ 'align': [] }],
                                ['clean']
                            ]
                        }
                    });

                    var form = document.getElementById('updateForm');
                    if(form) {
                        form.onsubmit = function() {
                            var contentInput = document.getElementById('content-input');
                            contentInput.value = quill.root.innerHTML;
                        };
                    }
                }

                window.openMemberReceipt = function(previewUrl, downloadUrl) {
                    document.getElementById('member-receipt-content').innerHTML = '<div class="p-6 text-center text-slate-400 dark:text-slate-500 text-sm">Memuat preview...</div>';
                    document.getElementById('member-receipt-download').href = downloadUrl;
                    document.getElementById('member-receipt-modal').style.display = 'block';
                    window.dispatchEvent(new CustomEvent('open-receipt-modal'));
                    fetch(previewUrl)
                        .then(r => r.text())
                        .then(html => { document.getElementById('member-receipt-content').innerHTML = html; })
                        .catch(() => { document.getElementById('member-receipt-content').innerHTML = '<div class="p-6 text-center text-red-600 dark:text-red-400">Preview gagal dimuat.</div>'; });
                }

                window.closeMemberReceipt = function() {
                    document.getElementById('member-receipt-modal').style.display = 'none';
                }

                window.printMemberReceipt = function() {
                    var w = window.open();
                    w.document.write(document.getElementById('member-receipt-content').innerHTML);
                    w.document.close();
                    w.print();
                }
            });
        </script>
    @endpush
</x-app-layout>

