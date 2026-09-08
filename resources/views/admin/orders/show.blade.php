<x-app-layout>
    <x-slot name="header">
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <div class="flex flex-col gap-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <h2 class="font-bold text-2xl text-slate-800 leading-tight">
                    Detail Pesanan
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-apple-parchment min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">
                
                <!-- Kolom Kiri: Informasi Pesanan & Lampiran -->
                <div class="lg:col-span-1 space-y-6 lg:sticky lg:top-28">
                    <div class="bg-white rounded-[24px] shadow-sm border border-slate-200/60 overflow-hidden">
                        <div class="p-5 border-b border-slate-100 bg-slate-50/50">
                            <h3 class="text-[15px] font-black text-slate-800">Informasi Pesanan</h3>
                        </div>
                        <div class="p-5 space-y-5">
                            <div>
                                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1">Nomor Pesanan</p>
                                <div class="flex items-center gap-2">
                                    <p class="text-slate-800 font-bold text-sm bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100" id="order-number">{{ $order->order_number }}</p>
                                    <button onclick="navigator.clipboard.writeText('{{ $order->order_number }}'); alert('Nomor Pesanan berhasil disalin!');" class="p-1.5 rounded-lg text-blue-600 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-950/30 transition-colors border border-transparent hover:border-blue-100 dark:hover:border-blue-900/50" title="Salin Nomor Pesanan">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M7 9a2 2 0 012-2h6a2 2 0 012 2v6a2 2 0 01-2 2H9a2 2 0 01-2-2V9z" /><path d="M5 3a2 2 0 00-2 2v6a2 2 0 002 2V5h8a2 2 0 00-2-2H5z" /></svg>
                                    </button>
                                </div>
                            </div>
                            
                            <div>
                                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1">Klien</p>
                                <p class="text-slate-800 font-bold text-sm">{{ $order->customer_name }}</p>
                                <p class="text-xs text-slate-500 font-medium">{{ $order->customer_email }}</p>
                                @if($order->customer_phone)
                                    <p class="text-xs text-slate-500 font-medium mt-0.5">WA: {{ $order->customer_phone }}</p>
                                @endif
                            </div>

                            <div>
                                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1">Layanan</p>
                                <p class="text-slate-800 font-bold text-sm">{{ $order->service->title ?? '-' }}</p>
                            </div>

                            <div>
                                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Brief / Catatan Tambahan</p>
                                <div class="bg-slate-50 p-4 rounded-xl text-xs text-slate-600 whitespace-pre-line border border-slate-100/80 leading-relaxed shadow-inner max-h-40 overflow-y-auto custom-scrollbar">
                                    {{ $order->notes ?? 'Tidak ada catatan.' }}
                                </div>
                            </div>
                            
                            <div x-data="{ showAttachmentModal: false, activeAttachment: {} }">
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
                                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6zm-1-7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" /></svg>
                                                        @elseif($ext === 'pdf')
                                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 2v10h8V8h-3a1 1 0 01-1-1V4H6z" clip-rule="evenodd" /></svg>
                                                        @else
                                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v8.5a5 5 0 1010 0V6a1 1 0 112 0v9.5a7 7 0 11-14 0V7a5 5 0 0110 0v8.5a3 3 0 11-6 0V7a1 1 0 112 0v7.5a1 1 0 002 0V7a3 3 0 00-3-3z" clip-rule="evenodd" /></svg>
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

                                <!-- Attachment Modal -->
                                <div x-show="showAttachmentModal" style="display: none;" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
                                        <div x-show="showAttachmentModal" x-transition.opacity class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm transition-opacity" @click="showAttachmentModal = false"></div>
                                        <div x-show="showAttachmentModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle w-full max-w-4xl">
                                            <div class="absolute top-0 right-0 pt-4 pr-4 z-10">
                                                <button type="button" @click="showAttachmentModal = false" class="bg-white/80 dark:bg-slate-850/80 backdrop-blur rounded-full p-2 text-slate-400 hover:text-slate-500 dark:text-slate-500 dark:hover:text-slate-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    <span class="sr-only">Close</span>
                                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                                </button>
                                            </div>
                                            <div class="bg-slate-100 w-full h-[80vh] flex flex-col">
                                                <div class="p-4 bg-white border-b border-slate-200 flex justify-between items-center shrink-0">
                                                    <h3 class="text-sm font-bold text-slate-800 truncate pr-8" x-text="activeAttachment.name"></h3>
                                                    <a :href="activeAttachment.url" download class="shrink-0 flex items-center gap-2 px-4 py-2 bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 rounded-lg text-xs font-bold hover:bg-indigo-650 dark:hover:bg-indigo-500 hover:text-white dark:hover:text-white transition-colors">
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                                        Unduh
                                                    </a>
                                                </div>
                                                <div class="flex-1 overflow-auto p-4 flex items-center justify-center">
                                                    <template x-if="['jpg','jpeg','png','gif','webp'].includes(activeAttachment.type)">
                                                        <img :src="activeAttachment.url" class="max-w-full max-h-full object-contain rounded-lg shadow-sm">
                                                    </template>
                                                    <template x-if="activeAttachment.type === 'pdf'">
                                                        <iframe :src="activeAttachment.url" class="w-full h-full rounded-lg shadow-sm border-0"></iframe>
                                                    </template>
                                                    <template x-if="!['jpg','jpeg','png','gif','webp','pdf'].includes(activeAttachment.type)">
                                                        <div class="text-center">
                                                            <div class="w-20 h-20 bg-white dark:bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm">
                                                                <svg class="w-10 h-10 text-indigo-450 dark:text-indigo-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 2v10h8V8h-3a1 1 0 01-1-1V4H6z" clip-rule="evenodd" /></svg>
                                                            </div>
                                                            <p class="text-slate-600 font-medium mb-2">Pratinjau tidak tersedia untuk format ini.</p>
                                                            <p class="text-sm text-slate-400">Silakan unduh file untuk melihat isinya.</p>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Info Utama (Tengah) -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Diskusi / Revisi Pesanan -->
                    <div class="bg-white dark:bg-slate-900 rounded-[24px] shadow-sm border border-slate-200/60 dark:border-slate-800 overflow-hidden flex flex-col" x-data="{ showUpdateModal: false, editUpdateId: null }">
                        <div class="p-5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 flex items-center justify-between z-10 relative shadow-sm">
                            <h3 class="text-lg font-black text-slate-800 tracking-tight">Chat & Pembaruan</h3>
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
                                                                        <svg class="w-3 h-3 text-white/70" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                                                                    </template>
                                                                    <template x-if="update.status === 'delivered'">
                                                                        <svg class="w-3.5 h-3.5 text-white/70" fill="currentColor" viewBox="0 0 20 20">
                                                                            <path d="M10.025 7.586l-4.293 4.293-1.707-1.707a1 1 0 10-1.414 1.414l2.414 2.414a1 1 0 001.414 0l5-5a1 1 0 10-1.414-1.414z"/>
                                                                            <path d="M15.025 7.586l-4.293 4.293-0.707-0.707a1 1 0 10-1.414 1.414l1.414 1.414a1 1 0 001.414 0l5-5a1 1 0 10-1.414-1.414z"/>
                                                                        </svg>
                                                                    </template>
                                                                    <template x-if="update.status === 'read'">
                                                                        <svg class="w-3.5 h-3.5 text-blue-300" fill="currentColor" viewBox="0 0 20 20">
                                                                            <path d="M10.025 7.586l-4.293 4.293-1.707-1.707a1 1 0 10-1.414 1.414l2.414 2.414a1 1 0 001.414 0l5-5a1 1 0 10-1.414-1.414z"/>
                                                                            <path d="M15.025 7.586l-4.293 4.293-0.707-0.707a1 1 0 10-1.414 1.414l1.414 1.414a1 1 0 001.414 0l5-5a1 1 0 10-1.414-1.414z"/>
                                                                        </svg>
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
                                                                        <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v8.5a5 5 0 1010 0V6a1 1 0 112 0v9.5a7 7 0 11-14 0V7a5 5 0 0110 0v8.5a3 3 0 11-6 0V7a1 1 0 112 0v7.5a1 1 0 002 0V7a3 3 0 00-3-3z" clip-rule="evenodd" /></svg>
                                                                        <span class="truncate">Lampiran: <span x-text="update.file_name"></span></span>
                                                                    </a>
                                                                </template>
                                                            </div>
                                                        </template>
                                                </div>
                                            </div>
                                        </template>
                                    </template>
                                    
                                     @if($order->status === 'completed')
                                         <!-- Simulated Chat Bubble from System/Admin -->
                                         <div class="flex gap-4 animate-chat-bubble-left">
                                             <div class="shrink-0 relative">
                                                 <div class="w-10 h-10 rounded-full bg-slate-200 text-slate-600 flex items-center justify-center font-bold shadow-sm border-2 border-white">
                                                     S
                                                 </div>
                                             </div>

                                             <div class="flex flex-col max-w-[85%] items-start">
                                                 <div class="flex items-center gap-2 mb-1">
                                                     <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Sistem</span>
                                                     <span class="bg-emerald-100 dark:bg-emerald-500/10 text-emerald-800 dark:text-emerald-400 text-[9px] px-1.5 py-0.5 rounded font-black uppercase tracking-wider">Info</span>
                                                 </div>
                                                 <div class="p-4 rounded-[24px] rounded-tl-none px-6 py-4 shadow-xl border bg-white/90 dark:bg-slate-900/90 border-slate-100 dark:border-slate-800 text-slate-800 dark:text-slate-100 text-[13px] leading-relaxed space-y-2.5">
                                                     <p class="font-extrabold text-emerald-600 dark:text-emerald-450 flex items-center gap-1.5">
                                                         <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                                         Pesanan telah selesai. Diskusi telah ditutup.
                                                     </p>
                                                     <p class="text-slate-600 dark:text-slate-300">Pesanan ini telah selesai dikerjakan dan ditandai sebagai selesai.</p>
                                                     
                                                     @if($order->receipt_sent_at)
                                                         <p class="text-slate-600 dark:text-slate-300 pt-2.5 border-t border-slate-100 dark:border-slate-800/65">
                                                             🧾 Struk pembayaran resmi telah dikirimkan ke pelanggan. Anda dapat melihat pratinjau struk dengan <a href="{{ route('admin.orders.receipt.preview', $order) }}" target="_blank" class="font-black text-indigo-600 dark:text-indigo-400 hover:underline">Klik di Sini</a>.
                                                         </p>
                                                     @endif

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
                                                 
                                                 <button type="submit" x-show="quickMessage.trim().length > 0" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-x-4 scale-90" x-transition:enter-end="opacity-100 translate-x-0 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-x-0 scale-100" x-transition:leave-end="opacity-0 translate-x-4 scale-90" class="w-[46px] h-[46px] bg-indigo-600/90 backdrop-blur-xl border border-indigo-500/50 text-white rounded-[18px] flex items-center justify-center hover:bg-indigo-600 shadow-md transition-all" title="Kirim Pesan">
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

                        @if($order->status !== 'completed')
                            <!-- UPDATE MODAL -->
                            <div x-show="showUpdateModal" style="display: none;" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                        <div x-show="showUpdateModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 backdrop-blur-none" x-transition:enter-end="opacity-100 backdrop-blur-sm" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 backdrop-blur-sm" x-transition:leave-end="opacity-0 backdrop-blur-none" class="fixed inset-0 bg-slate-900/60 transition-all" @click="showUpdateModal = false" aria-hidden="true"></div>
                                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                        <div x-show="showUpdateModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full border border-slate-100 relative">
                                            
                                            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                                                <h3 class="text-lg font-black text-slate-800">Tulis Pembaruan</h3>
                                                <button @click="showUpdateModal = false" class="text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300 transition-colors">
                                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" /></svg>
                                                </button>
                                            </div>

                                            <div class="p-6">
                                                <form action="{{ route('order-updates.store', $order) }}" method="POST" enctype="multipart/form-data" id="updateForm">
                                                    @csrf
                                                    <div class="mb-5">
                                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pesan / Keterangan</label>
                                                        <div id="editor-container" class="bg-white rounded-b-xl border-slate-200" style="height: 200px;"></div>
                                                        <input type="hidden" name="content" id="content-input">
                                                    </div>
                                                    <div class="mb-6">
                                                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Lampirkan File (Opsional)</label>
                                                        <input type="file" name="attachment" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-colors cursor-pointer">
                                                    </div>
                                                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                                                        <button type="button" @click="showUpdateModal = false" class="px-5 py-2.5 bg-slate-100 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-200 transition-colors">
                                                            Batal
                                                        </button>
                                                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm transition-all shadow-sm shadow-indigo-600/20">
                                                            Kirim Pesan
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar Status (Kanan) -->
                <div class="lg:col-span-1 space-y-6 lg:sticky lg:top-28 z-40" x-data="{ showManageStatusModal: false }">
                    <div class="bg-white dark:bg-slate-900 rounded-[24px] shadow-sm border border-slate-200/60 dark:border-slate-800 overflow-hidden">
                        <div class="p-5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 flex items-center justify-between">
                            <h3 class="text-[15px] font-black text-slate-800 dark:text-slate-100">Status Pesanan</h3>
                            @if($order->status !== 'completed' && $order->status !== 'cancelled')
                                <button @click="showManageStatusModal = true" class="w-9 h-9 rounded-[14px] flex items-center justify-center text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-955/40 hover:bg-indigo-100 dark:hover:bg-indigo-900/60 hover:text-indigo-700 dark:hover:text-indigo-300 border border-indigo-100/80 dark:border-indigo-900/50 transition-all shadow-sm hover:scale-105 active:scale-95" title="Kelola Status Pesanan">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" /></svg>
                                </button>
                            @endif
                        </div>
                        <div class="p-5">
                            @php
                                $statusHistory = [
                                    [
                                        'status' => 'Pending',
                                        'desc' => 'Menunggu pembayaran',
                                        'time' => $order->created_at,
                                        'icon' => '<path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
                                        'color' => 'amber',
                                        'active' => true,
                                        'done' => in_array($order->status, ['processing', 'completed', 'cancelled'])
                                    ],
                                    [
                                        'status' => 'Diproses',
                                        'desc' => 'Sedang dikerjakan',
                                        'time' => in_array($order->status, ['processing', 'completed']) ? $order->updated_at : null,
                                        'icon' => '<path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>',
                                        'color' => 'blue',
                                        'active' => in_array($order->status, ['processing', 'completed']),
                                        'done' => $order->status === 'completed'
                                    ],
                                    [
                                        'status' => 'Selesai',
                                        'desc' => 'Telah selesai',
                                        'time' => $order->status === 'completed' ? $order->updated_at : null,
                                        'icon' => '<path d="M5 13l4 4L19 7"></path>',
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
                                        'icon' => '<path d="M6 18L18 6M6 6l12 12"></path>',
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

                    <!-- Modal Kelola Status -->
                    <div x-show="showManageStatusModal" style="display: none;" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div x-show="showManageStatusModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 backdrop-blur-none" x-transition:enter-end="opacity-100 backdrop-blur-sm" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 backdrop-blur-sm" x-transition:leave-end="opacity-0 backdrop-blur-none" class="fixed inset-0 bg-slate-900/60 transition-all" @click="showManageStatusModal = false" aria-hidden="true"></div>
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                            <div x-show="showManageStatusModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-visible shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full border border-slate-100">
                                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between rounded-t-3xl">
                                    <h3 class="text-lg font-black text-slate-800">Kelola Status Pesanan</h3>
                                    <button @click="showManageStatusModal = false" class="text-slate-400 hover:text-slate-600 dark:text-slate-500 dark:hover:text-slate-300 transition-colors bg-white dark:bg-slate-855 p-1.5 rounded-full shadow-sm border border-slate-100 dark:border-slate-800">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" /></svg>
                                    </button>
                                </div>
                                <div class="p-6">
                                    @if($order->status === 'pending')
                                        <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="processing">
                                            
                                            <div class="mb-5">
                                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Estimasi Penyelesaian</label>
                                                <input type="datetime-local" name="estimation_date" required class="w-full bg-slate-50 border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5 px-4 font-bold text-slate-700">
                                                <p class="text-[11px] text-slate-500 mt-2">Pilih tenggat waktu penyelesaian. Pemesan akan mendapatkan notifikasi persetujuan beserta estimasi ini.</p>
                                            </div>
                                            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-colors shadow-sm text-sm flex justify-center items-center gap-2">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" /></svg>
                                                Setujui & Proses
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.orders.update', $order) }}" method="POST" x-data="{ status: '{{ $order->status }}' }">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-5">
                                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Ubah Status</label>
                                                <div x-data="{ open: false, value: status, get label() { const m = {'pending':'Pending','processing':'Processing','completed':'Completed','cancelled':'Cancelled'}; return m[this.value]; } }" class="relative">
                                                    <input type="hidden" name="status" x-model="value" x-init="$watch('value', val => status = val)">
                                                    <div @click="open = !open" @click.away="open = false" class="w-full bg-slate-50 dark:bg-slate-855 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-2.5 text-sm font-bold text-slate-700 dark:text-slate-300 cursor-pointer flex items-center justify-between transition-colors hover:border-indigo-400 dark:hover:border-indigo-500">
                                                        <span x-text="label"></span>
                                                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="currentColor" viewBox="0 0 20 20"><path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" /></svg>
                                                    </div>
                                                    <div x-show="open" x-transition class="absolute z-50 left-0 right-0 mt-1 bg-white rounded-xl shadow-lg border border-slate-100 overflow-hidden" style="display: none;">
                                                        <div class="p-1.5">
                                                            @foreach(['pending' => 'Pending', 'processing' => 'Processing', 'completed' => 'Completed', 'cancelled' => 'Cancelled'] as $key => $name)
                                                                <button type="button" @click="value = '{{ $key }}'; open = false;" class="w-full text-left px-3 py-2 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-950/40 hover:text-indigo-700 dark:hover:text-indigo-400 transition-colors flex items-center justify-between text-sm" :class="value == '{{ $key }}' ? 'bg-indigo-50 dark:bg-indigo-950/40 text-indigo-700 dark:text-indigo-400 font-bold' : 'text-slate-600 dark:text-slate-400 font-semibold'">
                                                                    {{ $name }}
                                                                    <svg x-show="value == '{{ $key }}'" class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="currentColor" viewBox="0 0 20 20"><path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" /></svg>
                                                                </button>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($order->estimation_date)
                                                <div class="mb-5">
                                                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Ubah Estimasi</label>
                                                    <input type="datetime-local" name="estimation_date" value="{{ \Carbon\Carbon::parse($order->estimation_date)->format('Y-m-d\TH:i') }}" class="w-full bg-slate-50 border border-slate-200 focus:border-indigo-600 focus:ring-0 rounded-xl px-4 py-2.5 text-sm font-bold text-slate-700 transition-colors">
                                                </div>
                                            @endif
                                            <button type="submit" class="w-full py-3 border transition-colors shadow-sm text-sm font-bold rounded-xl"
                                                :class="status === 'completed' ? 'border-emerald-500 text-emerald-700 bg-emerald-50 hover:bg-emerald-600 hover:text-white hover:border-emerald-600' : 'border-slate-200 bg-white hover:bg-slate-50 text-slate-700'"
                                                x-text="status === 'completed' ? 'Selesaikan Pesanan' : 'Simpan Perubahan'">
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ringkasan Biaya -->
                    <div class="bg-white rounded-[24px] shadow-sm border border-slate-200/60 overflow-hidden">
                        <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                            <h3 class="text-[12px] font-black text-slate-800 uppercase tracking-widest">Ringkasan Biaya</h3>
                            <span class="px-2.5 py-1 rounded-lg border text-[10px] font-black uppercase tracking-wider shadow-sm {{ $order->status === 'completed' ? 'bg-emerald-100 text-emerald-700 border-emerald-200' : ($order->status === 'processing' ? 'bg-blue-100 text-blue-700 border-blue-200' : ($order->status === 'cancelled' ? 'bg-red-100 text-red-700 border-red-200' : 'bg-slate-100 text-slate-700 border-slate-200')) }}">
                                {{ ucfirst($order->status) }}
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
                                </div>                                <!-- Receipt Icon Button -->
                                <button type="button" onclick="openReceiptPreview({{ $order->id }})" 
                                    title="{{ $order->receipt_sent_at ? 'Lihat Struk' : 'Generate Struk' }}"
                                    class="w-10 h-10 rounded-[18px] flex items-center justify-center bg-indigo-50 dark:bg-indigo-955/40 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 dark:hover:bg-indigo-900/60 hover:text-indigo-700 dark:hover:text-indigo-300 border border-indigo-100/80 dark:border-indigo-900/50 transition-all shadow-sm hover:scale-105 active:scale-95">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4v3h10V4H5zM3 8h14a2 2 0 012 2v5a2 2 0 01-2 2h-2v2a1 1 0 01-1 1H6a1 1 0 01-1-1v-2H3a2 2 0 01-2-2v-5a2 2 0 012-2zm2.5 10h9v-2h-9v2zM17 11a1 1 0 110-2 1 1 0 010 2z" /></svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    <style>
        #receipt-modal-content .page-wrap {
            min-height: auto !important;
            padding: 0 !important;
            background: transparent !important;
        }
        #receipt-modal-content .receipt {
            box-shadow: none !important;
            margin: 0 auto !important;
        }
        #receipt-panel .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        #receipt-panel .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        #receipt-panel .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(148, 163, 184, 0.2);
            border-radius: 9999px;
            border: 2px solid transparent;
            background-clip: padding-box;
        }
        #receipt-panel .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(148, 163, 184, 0.4);
            border: 2px solid transparent;
            background-clip: padding-box;
        }
    </style>
    <!-- Receipt Modal - matching system modal style -->
    <div id="receipt-modal" x-data="{ previewZoom: 1.0 }" x-on:open-receipt-modal.window="previewZoom = 1.0" class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;" aria-modal="true" role="dialog">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Backdrop -->
            <div id="receipt-backdrop" class="fixed inset-0 bg-slate-900/60 dark:bg-slate-950/80 backdrop-blur-sm transition-opacity" onclick="closeReceiptModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <!-- Modal Panel -->
            <div id="receipt-panel" class="inline-block align-bottom bg-white dark:bg-slate-900 rounded-[32px] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full border border-slate-100 dark:border-slate-800 relative h-[80vh]">
                
                <!-- Header - Absolute & Glassmorphism -->
                <div class="absolute top-0 left-0 right-0 z-30 px-8 pt-8 pb-5 bg-white/70 dark:bg-slate-900/75 backdrop-blur-md border-b border-slate-100 dark:border-slate-800/60 rounded-t-[32px]">
                    <div class="flex items-center gap-3 mb-1">
                        <div class="w-9 h-9 rounded-xl bg-indigo-50 dark:bg-indigo-950/50 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 2v10h8V8h-3a1 1 0 01-1-1V4H6z" /></svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-black text-slate-800 dark:text-slate-100 tracking-tight">Preview Struk</h3>
                            <p class="text-xs text-slate-400 dark:text-slate-500 font-medium">Preview sebelum dicetak atau dikirim</p>
                        </div>
                    </div>
                </div>

                <!-- Scrollable Wrapper (Absolute Fill) -->
                <div class="absolute inset-0 overflow-y-auto custom-scrollbar bg-slate-50/50 dark:bg-slate-900/20 pt-[110px] pb-[110px] px-8">
                    <div class="min-h-full w-full flex items-center justify-center py-6">
                        <div class="transition-transform duration-200 my-auto flex items-center justify-center" :style="{ transform: 'scale(' + previewZoom + ')', transformOrigin: 'center center' }">
                            <div id="receipt-modal-content" class="bg-white dark:bg-slate-900 shadow-sm rounded-xl w-full max-w-md overflow-hidden border border-slate-100 dark:border-slate-800">
                                <div class="p-6 text-center text-slate-400 dark:text-slate-500 text-sm">Memuat preview...</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Floating Zoom Controller (Absolute above the footer) -->
                <div class="absolute bottom-[96px] left-1/2 transform -translate-x-1/2 z-35 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md px-3 py-1.5 rounded-xl shadow-lg border border-slate-200/80 dark:border-slate-800/85 flex items-center gap-2 text-[11px] font-bold text-slate-700 dark:text-slate-200 w-max mx-auto">
                    <button type="button" @click="previewZoom = Math.max(0.5, previewZoom - 0.1)" class="w-6 h-6 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 flex items-center justify-center transition-all shadow-sm" title="Zoom Out">
                        <svg class="w-3.5 h-3.5 text-slate-600 dark:text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path d="M5 10a1 1 0 011-1h8a1 1 0 110 2H6a1 1 0 01-1-1z" /></svg>
                    </button>
                    <span class="min-w-[35px] text-center" x-text="Math.round(previewZoom * 100) + '%'"></span>
                    <button type="button" @click="previewZoom = Math.min(1.5, previewZoom + 0.1)" class="w-6 h-6 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 flex items-center justify-center transition-all shadow-sm" title="Zoom In">
                        <svg class="w-3.5 h-3.5 text-slate-600 dark:text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" /></svg>
                    </button>
                    <div class="h-3 w-[1px] bg-slate-200 dark:bg-slate-800"></div>
                    <button type="button" @click="previewZoom = 1.0" class="px-2 py-1 rounded-lg bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-600 dark:hover:bg-indigo-500 hover:text-white dark:hover:text-white transition-all shadow-sm">Reset</button>
                </div>

                <!-- Footer - Absolute & Glassmorphism -->
                <div class="absolute bottom-0 left-0 right-0 z-30 px-8 py-5 bg-slate-50/70 dark:bg-slate-900/75 backdrop-blur-md border-t border-slate-100 dark:border-slate-800/60 flex items-center justify-between rounded-b-[32px]">
                    <button type="button" onclick="printReceipt()" class="flex items-center gap-2 px-5 py-3 bg-white dark:bg-slate-800 hover:bg-slate-900 dark:hover:bg-white text-slate-700 dark:text-slate-200 hover:text-white dark:hover:text-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl font-bold text-sm shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4v3h10V4H5zM3 8h14a2 2 0 012 2v5a2 2 0 01-2 2h-2v2a1 1 0 01-1 1H6a1 1 0 01-1-1v-2H3a2 2 0 01-2-2v-5a2 2 0 012-2zm2.5 10h9v-2h-9v2zM17 11a1 1 0 110-2 1 1 0 010 2z" /></svg>
                        Cetak
                    </button>
                    <div class="flex gap-2.5">
                        <button type="button" onclick="sendReceipt()" class="flex items-center gap-2 px-5 py-3 bg-indigo-50 dark:bg-indigo-950/40 border border-indigo-100 dark:border-indigo-900/50 text-indigo-700 dark:text-indigo-400 hover:bg-indigo-600 dark:hover:bg-indigo-500 hover:text-white dark:hover:text-white rounded-2xl font-bold text-sm shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-300">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" /></svg>
                            Kirim ke Pemesan
                        </button>
                        <a id="receipt-download" href="#" target="_blank" onclick="generateReceipt(); return false;" class="flex items-center gap-2 px-5 py-3 bg-indigo-600 dark:bg-indigo-500 hover:bg-indigo-700 dark:hover:bg-indigo-600 text-white rounded-2xl font-bold text-sm shadow-lg shadow-indigo-600/20 dark:shadow-indigo-500/10 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" /></svg>
                            Unduh PDF
                        </a>
                    </div>
                </div>

                <!-- Close button - Navbar style (placed last in DOM for guaranteed top-most stacking) -->
                <button onclick="closeReceiptModal()" class="group absolute top-6 right-6 h-10 w-10 rounded-full flex items-center justify-center bg-slate-100/80 dark:bg-slate-800/80 backdrop-blur-md border border-slate-200/50 dark:border-slate-700/50 text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 hover:scale-110 active:scale-95 transition-all duration-300 shadow-[0_4px_12px_0_rgba(0,0,0,0.02)] hover:shadow-[0_4px_16px_0_rgba(0,0,0,0.08)] focus:outline-none z-50" title="Tutup">
                    <svg class="w-5 h-5 transition-transform duration-300 ease-out group-hover:rotate-90" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                </button>
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

                window.openReceiptPreview = function(orderId) {
                    document.getElementById('receipt-modal-content').innerHTML = '<div class="p-6 text-center text-slate-400 dark:text-slate-500 text-sm">Memuat preview...</div>';
                    document.getElementById('receipt-modal').style.display = 'block';
                    window.dispatchEvent(new CustomEvent('open-receipt-modal'));
                    fetch('/admin/orders/' + orderId + '/receipt-preview')
                        .then(r => r.text())
                        .then(html => {
                            document.getElementById('receipt-modal-content').innerHTML = html;
                            // hide download link initially
                            document.getElementById('receipt-download').href = '#';
                        }).catch(err => {
                            document.getElementById('receipt-modal-content').innerHTML = '<div class="p-6 text-center text-red-600 dark:text-red-400">Preview gagal dimuat.</div>';
                        });
                }

                window.closeReceiptModal = function() {
                    document.getElementById('receipt-modal').style.display = 'none';
                }

                window.printReceipt = function() {
                    var w = window.open();
                    w.document.write(document.getElementById('receipt-modal-content').innerHTML);
                    w.document.close();
                    w.print();
                }

                window.generateReceipt = function() {
                    var path = window.location.pathname;
                    // extract order id from page data using embedded PHP var
                    var orderId = {{ $order->id }};
                    fetch('/admin/orders/' + orderId + '/generate-receipt', { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') } })
                        .then(r => r.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('receipt-download').href = data.url;
                                window.dispatchEvent(new CustomEvent('open-custom-confirm', {
                                    detail: {
                                        title: 'Sukses',
                                        message: 'PDF berhasil digenerate. Klik Unduh untuk menyimpan.',
                                        showCancel: false
                                    }
                                }));
                            }
                        });
                }

                window.sendReceipt = function() {
                    var orderId = {{ $order->id }};
                    window.dispatchEvent(new CustomEvent('open-custom-confirm', {
                        detail: {
                            title: 'Kirim Struk',
                            message: 'Kirim struk ke pemesan sekarang?',
                            confirmCallback: () => {
                                fetch('/admin/orders/' + orderId + '/send-receipt', { method: 'POST', headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') } })
                                    .then(r => r.json())
                                    .then(data => {
                                        if (data.success) {
                                            window.dispatchEvent(new CustomEvent('open-custom-confirm', {
                                                detail: {
                                                    title: 'Sukses',
                                                    message: 'Struk telah dikirim.',
                                                    showCancel: false,
                                                    confirmCallback: () => location.reload()
                                                }
                                            }));
                                        }
                                    });
                            }
                        }
                    }));
                }
            });
        </script>
    @endpush
</x-app-layout>

