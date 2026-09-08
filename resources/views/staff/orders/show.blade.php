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
                            <h3 class="text-[15px] font-black text-slate-800">Informasi Pesanan & Klien</h3>
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
                                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Briefing / Pesan</p>
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

                                <!-- Attachment Modal -->
                                <div x-show="showAttachmentModal" style="display: none;" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
                                        <div x-show="showAttachmentModal" x-transition.opacity class="fixed inset-0 bg-slate-900/80 backdrop-blur-sm transition-opacity" @click="showAttachmentModal = false"></div>
                                        <div x-show="showAttachmentModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle w-full max-w-4xl">
                                            <div class="absolute top-0 right-0 pt-4 pr-4 z-10">
                                                <button type="button" @click="showAttachmentModal = false" class="bg-white/80 backdrop-blur rounded-full p-2 text-slate-400 hover:text-slate-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                                    <span class="sr-only">Close</span>
                                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                                </button>
                                            </div>
                                            <div class="bg-slate-100 w-full h-[80vh] flex flex-col">
                                                <div class="p-4 bg-white border-b border-slate-200 flex justify-between items-center shrink-0">
                                                    <h3 class="text-sm font-bold text-slate-800 truncate pr-8" x-text="activeAttachment.name"></h3>
                                                    <a :href="activeAttachment.url" download class="shrink-0 flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-bold hover:bg-indigo-100 transition-colors">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
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
                                                            <div class="w-20 h-20 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-sm">
                                                                <svg class="w-10 h-10 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
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
                    <div class="bg-white rounded-[24px] shadow-sm border border-slate-200/60 overflow-hidden flex flex-col" x-data="{ 
                        showUpdateModal: false, 
                        editUpdateId: null,
                        lastScrollTop: 0,
                        onChatScroll(e) {
                            const currentScrollTop = e.target.scrollTop;
                            if (currentScrollTop > this.lastScrollTop) {
                                const scrollableDistance = document.body.scrollHeight - window.innerHeight;
                                if (window.scrollY < scrollableDistance - 50) {
                                    window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
                                }
                            }
                            this.lastScrollTop = currentScrollTop;
                        },
                        init() {
                            this.$nextTick(() => {
                                const container = this.$refs.chatContainer;
                                if (container) {
                                    container.scrollTop = container.scrollHeight;
                                    window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
                                }
                            });
                        }
                    }">
                        <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between z-10 relative shadow-sm">
                            <h3 class="text-lg font-black text-slate-800 tracking-tight">Diskusi & Pembaruan</h3>
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-bold text-slate-500 hidden sm:inline-block">Hubungi via:</span>
                                <div class="flex items-center gap-2">
                                    @php
                                        $whatsappPhone = \App\Models\Setting::where('key', 'whatsapp_number')->value('value') ?? '';
                                        $waUrl = 'https://wa.me/' . preg_replace('/[^0-9]/', '', $whatsappPhone);
                                    @endphp
                                    <a href="{{ $waUrl }}" target="_blank" class="w-10 h-10 rounded-[14px] bg-gradient-to-br from-emerald-400 to-emerald-600 border border-emerald-500/50 text-white shadow-[0_8px_20px_rgba(16,185,129,0.3)] hover:shadow-[0_12px_25px_rgba(16,185,129,0.4)] hover:-translate-y-1 transition-all duration-300 flex items-center justify-center relative overflow-hidden group" title="WhatsApp">
                                        <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-out"></div>
                                        <svg class="w-5 h-5 drop-shadow-md relative z-10" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    </a>
                                    @php
                                        $instagramUrl = \App\Models\Setting::where('key', 'social_instagram')->value('value') ?? '#';
                                    @endphp
                                    <a href="{{ $instagramUrl }}" target="_blank" class="w-10 h-10 rounded-[14px] bg-gradient-to-br from-pink-400 to-pink-600 border border-pink-500/50 text-white shadow-[0_8px_20px_rgba(236,72,153,0.3)] hover:shadow-[0_12px_25px_rgba(236,72,153,0.4)] hover:-translate-y-1 transition-all duration-300 flex items-center justify-center relative overflow-hidden group" title="Instagram">
                                        <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-out"></div>
                                        <svg class="w-5 h-5 drop-shadow-md relative z-10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
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
                        <div class="h-[600px] relative overflow-hidden" style="background-color: {{ $computedBgColor }};">
                            <!-- Ambient glow for glass refraction in dark mode -->
                            <div class="hidden dark:block absolute top-[10%] left-[10%] w-[120px] h-[120px] bg-blue-500/20 rounded-full blur-[40px] pointer-events-none z-0"></div>
                            <div class="hidden dark:block absolute bottom-[10%] right-[10%] w-[150px] h-[150px] bg-indigo-500/20 rounded-full blur-[50px] pointer-events-none z-0"></div>

                            <div class="absolute inset-[-100%] overflow-hidden flex flex-wrap pointer-events-none select-none z-0 transform -rotate-12 justify-center content-center opacity-10">
                                @for($i = 0; $i < 150; $i++)
                                    <span class="{{ $typoClasses }} px-6 py-4 whitespace-nowrap leading-none" style="{{ $typoStyles }}">{{ $bgText }}</span>
                                @endfor
                            </div>
                            
                            @if($order->updates->count() > 0)
                                <div class="absolute inset-0 overflow-y-auto p-5 md:p-6 pb-4 z-10 space-y-6 custom-scrollbar" x-ref="chatContainer" @scroll="onChatScroll">
                                    @foreach($order->updates as $update)
                                        <div class="flex gap-4 {{ $update->user_id === Auth::id() ? 'flex-row-reverse' : '' }}">
                                            <div class="shrink-0 relative animate-chat-avatar">
                                                @if($update->user->avatar)
                                                    <img src="{{ Storage::url($update->user->avatar) }}" alt="{{ $update->user->name }}" class="w-10 h-10 rounded-full object-cover border-2 border-white shadow-sm">
                                                @else
                                                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold shadow-sm border-2 border-white {{ $update->user_id === Auth::id() ? 'bg-indigo-600 text-white' : 'bg-slate-200 text-slate-600' }}">
                                                        {{ substr($update->user->name, 0, 1) }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="flex flex-col max-w-[85%] {{ $update->user_id === Auth::id() ? 'items-end animate-chat-bubble-right' : 'items-start animate-chat-bubble-left' }}">
                                                <div class="flex items-center gap-2 mb-1">
                                                    <span class="text-xs font-bold text-slate-700">{{ $update->user->name }}</span>
                                                </div>
                                                <div class="p-4 rounded-[24px] px-6 py-4 shadow-xl border relative z-10 text-[13px] prose prose-sm max-w-none {{ $update->user_id === Auth::id() ? 'bg-indigo-600/90 backdrop-blur-2xl border-indigo-500/50 text-white rounded-tr-none prose-invert prose-p:text-white/90 prose-a:text-white' : 'bg-white/80 backdrop-blur-2xl border-white/50 text-slate-800 rounded-tl-none prose-p:text-slate-600' }}">
                                                    {!! $update->content !!}
                                                    
                                                    <div class="flex items-center justify-end gap-1.5 mt-2">
                                                        <span class="text-[10px] font-medium opacity-80">{{ $update->created_at->format('H:i') }}</span>
                                                        @if($update->user_id === Auth::id())
                                                            <div class="flex items-center">
                                                                @if($update->read_at)
                                                                    <svg class="w-3.5 h-3.5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7M11 13l4 4L24 7"></path></svg>
                                                                @else
                                                                    <svg class="w-3.5 h-3.5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7M11 13l4 4L24 7"></path></svg>
                                                                @endif
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                @if($update->file_path)
                                                    <a href="{{ Storage::url($update->file_path) }}" target="_blank" class="mt-2 flex items-center gap-2 px-3 py-1.5 rounded-lg border transition-colors text-xs font-bold {{ $update->user_id === Auth::id() ? 'border-indigo-200 bg-indigo-50 text-indigo-700 hover:bg-indigo-100' : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50' }}">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                        Lampiran: {{ $update->file_name }}
                                                    </a>
                                                @endif

                                                @if($update->user_id === Auth::id() && $update->created_at->diffInMinutes(now()) <= 30)
                                                    <div class="mt-2 text-right w-full">
                                                        <form action="{{ route('order-updates.destroy', $update) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pesan ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-[11px] text-red-500 hover:text-red-600 font-medium">Hapus</button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                    
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
                                                 <div class="p-4 rounded-[24px] rounded-tl-none px-6 py-4 shadow-xl border bg-white/90 dark:bg-slate-900/90 border-slate-100 dark:border-slate-800 text-slate-855 dark:text-slate-100 text-[13px] leading-relaxed space-y-2.5">
                                                     <p class="font-extrabold text-emerald-600 dark:text-emerald-450 flex items-center gap-1.5">
                                                         <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                                         Pesanan telah selesai. Diskusi telah ditutup.
                                                     </p>
                                                     <p class="text-slate-600 dark:text-slate-300">Pesanan ini telah selesai dikerjakan dan ditandai sebagai selesai.</p>
                                                     
                                                     @if($order->receipt_sent_at)
                                                         <p class="text-slate-600 dark:text-slate-300 pt-2.5 border-t border-slate-100 dark:border-slate-800/65">
                                                             🧾 Struk pembayaran resmi telah dikirimkan ke pelanggan.
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
                             @endif

                             <!-- Form Input / Status Penutup di Bagian Bawah (Glassmorphism) -->
                             <div class="absolute bottom-0 left-0 right-0 p-4 bg-white/40 dark:bg-slate-900/40 backdrop-blur-md border-t border-white/50 dark:border-slate-800/30 z-20 shadow-[0_-8px_30px_rgb(0,0,0,0.04)]">
                                 @if($order->status !== 'completed')
                                     <div x-data="{ quickMessage: '' }">
                                         <form action="{{ route('order-updates.store', $order) }}" method="POST" class="flex items-end gap-2">
                                             @csrf
                                             <div class="shrink-0 relative">
                                                 @if(Auth::user()->avatar)
                                                     <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="Avatar" class="w-[46px] h-[46px] rounded-full object-cover shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-white/60">
                                                 @else
                                                     <div class="w-[46px] h-[46px] rounded-full bg-indigo-600 text-white flex items-center justify-center font-bold text-lg shadow-[0_8px_30px_rgb(0,0,0,0.12)] border border-white/20">
                                                         {{ substr(Auth::user()->name, 0, 1) }}
                                                     </div>
                                                 @endif
                                             </div>
                                             <div class="flex-1 relative flex items-end">
                                                 <textarea name="content" x-model="quickMessage" rows="1" class="w-full bg-white/70 backdrop-blur-xl border border-white/60 shadow-inner focus:bg-white/90 focus:border-indigo-300 focus:ring focus:ring-indigo-200/50 rounded-[20px] px-4 py-3.5 text-[14px] font-medium text-slate-800 transition-all resize-none overflow-hidden placeholder-slate-400" placeholder="Tambahkan pesan..." x-ref="textarea" @input="$refs.textarea.style.height = 'auto'; $refs.textarea.style.height = $refs.textarea.scrollHeight + 'px'" style="min-height: 46px; max-height: 120px;"></textarea>
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
                                     </div>
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
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const container = document.getElementById('chatContainer');
                                if (container) {
                                    container.scrollTop = container.scrollHeight;
                                }
                                setTimeout(() => {
                                    if (container) {
                                        container.scrollTop = container.scrollHeight;
                                    }
                                    window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
                                }, 100);
                            });
                        </script>

                        @if($order->status !== 'completed')
                                <!-- UPDATE MODAL -->
                                <div x-show="showUpdateModal" style="display: none;" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                        <div x-show="showUpdateModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 backdrop-blur-none" x-transition:enter-end="opacity-100 backdrop-blur-sm" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 backdrop-blur-sm" x-transition:leave-end="opacity-0 backdrop-blur-none" class="fixed inset-0 bg-slate-900/60 transition-all" @click="showUpdateModal = false" aria-hidden="true"></div>
                                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                        <div x-show="showUpdateModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full border border-slate-100 relative">
                                            
                                            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center justify-between">
                                                <h3 class="text-lg font-black text-slate-800">Tulis Pembaruan</h3>
                                                <a href="{{ route('staff.orders.index') }}" class="text-slate-400 hover:text-slate-600 transition-colors">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </a>
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
                    <div class="bg-white rounded-[24px] shadow-sm border border-slate-200/60 overflow-hidden">
                        <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                            <h3 class="text-[15px] font-black text-slate-800">Status Pesanan</h3>
                            @if($order->status !== 'completed' && $order->status !== 'cancelled')
                                <button @click="showManageStatusModal = true" class="text-[11px] font-bold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition-colors flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Kelola
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
                                    <button @click="showManageStatusModal = false" class="text-slate-400 hover:text-slate-600 transition-colors bg-white p-1.5 rounded-full shadow-sm border border-slate-100">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                                <div class="p-6">
                                    @if($order->status === 'pending')
                                        <form action="{{ route('staff.orders.update', $order) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="processing">
                                            
                                            <div class="mb-5">
                                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Estimasi Penyelesaian</label>
                                                <input type="datetime-local" name="estimation_date" required class="w-full bg-slate-50 border border-slate-200 rounded-xl focus:border-indigo-500 focus:ring-indigo-500 text-sm py-2.5 px-4 font-bold text-slate-700">
                                                <p class="text-[11px] text-slate-500 mt-2">Pilih tenggat waktu penyelesaian. Pemesan akan mendapatkan notifikasi persetujuan beserta estimasi ini.</p>
                                            </div>
                                            <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition-colors shadow-sm text-sm flex justify-center items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                Setujui & Proses
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('staff.orders.update', $order) }}" method="POST" x-data="{ status: '{{ $order->status }}' }">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-5">
                                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Ubah Status</label>
                                                <div x-data="{ open: false, value: status, get label() { const m = {'pending':'Pending','processing':'Processing','completed':'Completed','cancelled':'Cancelled'}; return m[this.value]; } }" class="relative">
                                                    <input type="hidden" name="status" x-model="value" x-init="$watch('value', val => status = val)">
                                                    <div @click="open = !open" @click.away="open = false" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm font-bold text-slate-700 cursor-pointer flex items-center justify-between transition-colors hover:border-indigo-400">
                                                        <span x-text="label"></span>
                                                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                                    </div>
                                                    <div x-show="open" x-transition class="absolute z-50 left-0 right-0 mt-1 bg-white rounded-xl shadow-lg border border-slate-100 overflow-hidden" style="display: none;">
                                                        <div class="p-1.5">
                                                            @foreach(['pending' => 'Pending', 'processing' => 'Processing', 'completed' => 'Completed', 'cancelled' => 'Cancelled'] as $key => $name)
                                                                <button type="button" @click="value = '{{ $key }}'; open = false;" class="w-full text-left px-3 py-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors flex items-center justify-between text-sm" :class="value == '{{ $key }}' ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-600 font-semibold'">
                                                                    {{ $name }}
                                                                    <svg x-show="value == '{{ $key }}'" class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
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
                                </div>
                            </div>
                        </div>
                    </div>

                    </div>
                    @endif
                </div>
            </div>

        </div>
    @push('scripts')
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
        <script>
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
            });
        </script>
    @endpush
</x-app-layout>

