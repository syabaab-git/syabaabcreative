@php
    $authBg = json_decode(\App\Models\Setting::where('key', 'auth_background')->value('value') ?? '{}', true);
    $bgText = $authBg['text'] ?? 'Syabaab Creative';
    $typoFont = $authBg['font'] ?? 'Inter';
    $typoSizeVal = intval($authBg['size'] ?? 80);
    $chatTypoSize = ($typoSizeVal * 0.3) . 'px'; // 30% of original size for compact elements
    $typoWeight = $authBg['weight'] ?? 900;
    $textColor = $authBg['text_color'] ?? '#0f172a';
    
    $caseMap = ['uppercase' => 'uppercase', 'lowercase' => 'lowercase'];
    $typoCase = $caseMap[$authBg['case'] ?? 'normal'] ?? '';
    $typoItalic = ($authBg['italic'] ?? 'false') === 'true' ? 'italic' : '';
    $typoStrike = ($authBg['strikethrough'] ?? 'false') === 'true' ? 'line-through' : '';
    
    $typoClasses = trim("$typoCase $typoItalic $typoStrike");
    $chatTypoStyles = "font-family: '{$typoFont}'; font-size: {$chatTypoSize}; font-weight: {$typoWeight}; color: {$textColor};";
    
    $hex = ltrim($textColor, '#');
    $r = hexdec(substr($hex, 0, 2) ?: '00');
    $g = hexdec(substr($hex, 2, 2) ?: '00');
    $b = hexdec(substr($hex, 4, 2) ?: '00');
    $computedBgColor = "rgba($r, $g, $b, 0.05)";
@endphp

<x-app-layout content-padding="pt-[105px]">
    <div class="py-8 bg-slate-50 dark:bg-black min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
            
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">Tinjau Tugas</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-2">Siswa: <span class="font-bold text-slate-800 dark:text-slate-200">{{ $submission->user->name }}</span></p>
            </div>

            <!-- 3-Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                
                <!-- Left Column: Deskripsi & Info Tugas (lg:col-span-3) -->
                <div class="lg:col-span-3 space-y-6">
                    <div class="bg-white dark:bg-[#151515] rounded-[24px] border border-slate-200/60 dark:border-white/10 shadow-sm overflow-hidden p-6">
                        <h2 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-4">Informasi Tugas</h2>
                        <div class="space-y-4">
                            <div>
                                <p class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Judul Tugas</p>
                                <p class="text-sm font-bold text-slate-800 dark:text-slate-200 leading-tight">{{ $assignment->title }}</p>
                            </div>
                            <div>
                                <p class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Nilai Minimal Kelulusan</p>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 dark:bg-indigo-950/30 border border-indigo-100 dark:border-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-xs font-bold rounded-xl">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg>
                                    {{ $assignment->passing_score }}%
                                </span>
                            </div>
                            <div>
                                <p class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Status Penilaian</p>
                                @if($submission->status === 'submitted')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 dark:bg-amber-950/20 border border-amber-100/50 dark:border-amber-900/30 text-amber-600 dark:text-amber-455 text-xs font-bold rounded-xl">
                                        Belum Dinilai
                                    </span>
                                @elseif($submission->status === 'graded')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-100/50 dark:border-emerald-900/30 text-emerald-600 dark:text-emerald-450 text-xs font-bold rounded-xl">
                                        Sudah Dinilai ({{ $submission->score }})
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-[#151515] rounded-[24px] border border-slate-200/60 dark:border-white/10 shadow-sm overflow-hidden p-6">
                        <h2 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-3">Deskripsi Soal</h2>
                        <div class="prose prose-slate dark:prose-invert max-w-none tinymce-wrapper text-[13px] leading-relaxed">
                            {!! $assignment->description !!}
                        </div>
                    </div>
                </div>

                <!-- Middle Column: Jawaban Siswa & Form Penilaian (lg:col-span-5) -->
                <div class="lg:col-span-5 space-y-6">
                    <!-- Card Jawaban -->
                    <div class="bg-white dark:bg-[#151515] rounded-[24px] border border-slate-200/60 dark:border-white/10 shadow-sm overflow-hidden p-6">
                        <h2 class="text-lg font-bold text-slate-800 dark:text-white mb-4">Jawaban Siswa</h2>
                        
                        @if($submission->content)
                            <div class="prose prose-slate dark:prose-invert max-w-none p-4 bg-slate-50 dark:bg-slate-900/50 rounded-xl border border-slate-200/60 dark:border-white/5 mb-4 text-[13px] leading-relaxed break-words tinymce-wrapper">
                                {!! $submission->content !!}
                            </div>
                        @else
                            <p class="text-xs text-slate-400 dark:text-slate-500 italic mb-4">Siswa tidak mengirimkan jawaban teks.</p>
                        @endif

                        @if($submission->file_path)
                            <div class="mt-2">
                                <label class="block text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2">Lampiran Siswa</label>
                                @php
                                    $filePath = $submission->file_path;
                                    $fileName = basename($filePath);
                                    $fileExt = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
                                    
                                    // Choose solid icon and colors based on extension
                                    $iconColor = 'text-slate-500 dark:text-slate-400';
                                    $bgColor = 'bg-slate-100 dark:bg-slate-800/60';
                                    if (in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'])) {
                                        $iconColor = 'text-emerald-500 dark:text-emerald-400';
                                        $bgColor = 'bg-emerald-50 dark:bg-emerald-950/30';
                                        $iconSvg = '<svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path></svg>';
                                    } elseif ($fileExt === 'pdf') {
                                        $iconColor = 'text-rose-500 dark:text-rose-400';
                                        $bgColor = 'bg-rose-50 dark:bg-rose-950/30';
                                        $iconSvg = '<svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm2 10a1 1 0 10-2 0v2a1 1 0 102 0v-2zm3-3a1 1 0 00-1 1v4a1 1 0 102 0v-4a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>';
                                    } elseif (in_array($fileExt, ['zip', 'rar', '7z', 'tar'])) {
                                        $iconColor = 'text-amber-500 dark:text-amber-455';
                                        $bgColor = 'bg-amber-50 dark:bg-amber-950/30';
                                        $iconSvg = '<svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A1 1 0 0112 2.586L15.414 6A1 1 0 0116 6.586V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm6 2a1 1 0 10-2 0v2H6a1 1 0 100 2h2v2H6a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2v-2h2a1 1 0 100-2h-2V6z" clip-rule="evenodd"></path></svg>';
                                    } else {
                                        $iconSvg = '<svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A1 1 0 0112 2.586L15.414 6A1 1 0 0116 6.586V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>';
                                    }
                                @endphp
                                <div class="p-3 rounded-2xl border border-slate-200/60 dark:border-white/5 bg-slate-50/50 dark:bg-slate-900/30 flex items-center justify-between gap-3">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 {{ $bgColor }} {{ $iconColor }}">
                                            {!! $iconSvg !!}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="text-xs font-bold text-slate-700 dark:text-slate-250 truncate" title="{{ $fileName }}">{{ $fileName }}</p>
                                            <p class="text-[10px] font-medium text-slate-400 uppercase tracking-wider">{{ $fileExt }} file</p>
                                        </div>
                                    </div>
                                    <a href="{{ asset('storage/' . $filePath) }}" target="_blank" class="px-3.5 py-1.5 bg-indigo-50 dark:bg-indigo-950/40 hover:bg-indigo-100 dark:hover:bg-indigo-900/40 text-indigo-600 dark:text-indigo-455 text-xs font-black rounded-lg transition-colors border border-indigo-100/40 dark:border-indigo-900/30 shrink-0">
                                        Lihat
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Form Penilaian -->
                    <div class="bg-white dark:bg-[#151515] rounded-[24px] border border-slate-200/60 dark:border-white/10 shadow-sm overflow-hidden p-6">
                        <h2 class="text-lg font-bold text-slate-800 dark:text-white mb-6">Berikan Penilaian & Tanggapan</h2>
                        <form action="{{ route('mentor.assignments.submissions.update', [$assignment, $submission]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="space-y-6">
                                <div>
                                    <label for="score" class="block text-[11px] font-black text-slate-400 dark:text-slate-555 uppercase tracking-widest mb-2">Nilai (0 - 100) <span class="text-red-500">*</span></label>
                                    <input type="number" name="score" id="score" class="w-full sm:w-1/3 rounded-xl border-slate-200 dark:border-white/10 dark:bg-slate-900 dark:text-white focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition-shadow text-sm font-bold" required value="{{ old('score', $submission->score) }}" min="0" max="100">
                                </div>

                                <div>
                                    <label for="feedback" class="block text-[11px] font-black text-slate-400 dark:text-slate-555 uppercase tracking-widest mb-2">Tanggapan (Feedback)</label>
                                    <textarea name="feedback" id="feedback" class="w-full rounded-xl border-slate-200 dark:border-white/10 dark:bg-slate-900 dark:text-white focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition-shadow text-sm placeholder-slate-400" rows="4" placeholder="Tuliskan tanggapan untuk siswa ini...">{{ old('feedback', $submission->feedback) }}</textarea>
                                </div>
                            </div>

                            <div class="mt-8 flex items-center justify-between gap-3">
                                <a href="{{ route('mentor.courses.show', $course) }}" class="inline-flex items-center justify-center px-5 py-3 bg-white dark:bg-[#1e1e1e] text-slate-600 dark:text-slate-400 font-bold text-[13px] rounded-2xl hover:bg-slate-100 dark:hover:bg-zinc-800 transition-all border border-slate-200/60 dark:border-white/5 shadow-sm">
                                    Batal
                                </a>
                                <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-slate-900 dark:bg-white text-white dark:text-slate-955 font-bold text-[13px] rounded-2xl hover:bg-indigo-600 dark:hover:bg-indigo-500 hover:text-white dark:hover:text-white transition-all duration-200 hover:shadow-lg">
                                    Simpan Penilaian
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Right Column: Diskusi & Komentar (lg:col-span-4) -->
                <div class="lg:col-span-4">
                    <div class="bg-white dark:bg-[#151515] rounded-[24px] border border-slate-200/60 dark:border-white/10 shadow-sm overflow-hidden flex flex-col h-[480px] relative">
                        <!-- Chat Header -->
                        <div class="p-4 border-b border-slate-100 dark:border-white/5 bg-slate-50/50 dark:bg-slate-900/50 flex items-center justify-between z-10 shadow-sm">
                            <h3 class="text-sm font-black text-slate-800 dark:text-white">
                                Diskusi & Komentar
                            </h3>
                            <span class="text-[10px] font-bold text-slate-400 bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded-md">
                                {{ $submission->comments->count() }} pesan
                            </span>
                        </div>

                        <!-- Chat Body / Message List (Scrollable with Fixed Background) -->
                        <div class="flex-1 relative overflow-hidden" style="background-color: {{ $computedBgColor }};">
                            <!-- Ambient Glow Circles (Fixed) -->
                            <div class="absolute top-[10%] left-[10%] w-[100px] h-[100px] bg-blue-500/5 dark:bg-blue-500/10 rounded-full blur-[30px] pointer-events-none z-0"></div>
                            <div class="absolute bottom-[20%] right-[10%] w-[120px] h-[120px] bg-indigo-500/5 dark:bg-indigo-500/10 rounded-full blur-[40px] pointer-events-none z-0"></div>

                            <!-- Typography Watermark Overlay (Fixed) -->
                            <div class="absolute inset-[-100%] overflow-hidden flex flex-wrap pointer-events-none select-none z-0 transform -rotate-12 justify-center content-center opacity-[0.08]">
                                @for($i = 0; $i < 120; $i++)
                                    <span class="{{ $typoClasses }} px-4 py-2.5 whitespace-nowrap leading-none" style="{{ $chatTypoStyles }}">{{ $bgText }}</span>
                                @endfor
                            </div>

                            <!-- Scrollable Messages Layer -->
                            <div class="absolute inset-0 overflow-y-auto overflow-x-hidden p-4 custom-scrollbar z-10" id="chat-messages-container">
                                <div class="space-y-4">
                                    @forelse($submission->comments as $comment)
                                        @php
                                            $isMe = $comment->user_id === auth()->id();
                                            $commenterIsMentor = $comment->user->hasRole('mentor');
                                        @endphp
                                        <div class="flex gap-2.5 {{ $isMe ? 'flex-row-reverse' : '' }}">
                                            <!-- Avatar -->
                                            <div class="shrink-0">
                                                @if($comment->user->avatar)
                                                    <img src="{{ Storage::url($comment->user->avatar) }}" class="w-8 h-8 rounded-xl object-cover border border-slate-100 dark:border-white/5 shadow-sm">
                                                @else
                                                    <div class="w-8 h-8 rounded-xl {{ $commenterIsMentor ? 'bg-indigo-600' : 'bg-slate-500' }} text-white flex items-center justify-center font-black text-[11px] shadow-sm">
                                                        {{ substr($comment->user->name, 0, 1) }}
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Message Bubble -->
                                            <div class="flex flex-col max-w-[80%] {{ $isMe ? 'items-end' : 'items-start' }}">
                                                <div class="flex items-center gap-1.5 mb-1">
                                                    <span class="text-[10px] font-bold text-slate-700 dark:text-slate-300">{{ $comment->user->name }}</span>
                                                    <span class="px-1.5 py-0.2 text-[7px] font-black uppercase tracking-wider rounded-md {{ $commenterIsMentor ? 'bg-indigo-50 text-indigo-600 border border-indigo-100 dark:bg-indigo-950/20 dark:text-indigo-400 dark:border-indigo-900/30' : 'bg-slate-100 text-slate-600 border border-slate-200 dark:bg-slate-800/30 dark:text-slate-400 dark:border-slate-700/30' }}">
                                                        {{ $commenterIsMentor ? 'Mentor' : 'Siswa' }}
                                                    </span>
                                                </div>
                                                <div class="p-3.5 rounded-2xl text-[12px] leading-relaxed border break-words {{ $isMe ? 'bg-indigo-600 text-white border-transparent rounded-tr-none shadow-sm' : 'bg-white/80 dark:bg-slate-900/80 backdrop-blur-md text-slate-800 dark:text-slate-100 border-slate-100/50 dark:border-zinc-800/50 rounded-tl-none shadow-sm' }}">
                                                    <p class="whitespace-pre-line">{{ $comment->body }}</p>
                                                </div>
                                                <span class="text-[8px] text-slate-400 mt-1">{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="flex flex-col items-center justify-center min-h-[300px] text-center p-6 text-slate-400 dark:text-slate-550">
                                            <svg class="w-8 h-8 mb-2 opacity-50" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7z" clip-rule="evenodd"></path></svg>
                                            <p class="text-xs font-bold">Belum ada obrolan</p>
                                            <p class="text-[10px] mt-1">Mulai obrolan dengan siswa mengenai tugas ini.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- Chat Footer / Input Form (Sticky) -->
                        <div class="p-3 bg-white/80 dark:bg-[#151515]/80 backdrop-blur-md border-t border-slate-100 dark:border-white/5 z-10">
                            <form action="{{ route('assignments.submissions.comments.store', $submission) }}" method="POST" class="m-0">
                                @csrf
                                <div class="flex gap-2 items-center">
                                    <div class="flex-1">
                                        <textarea name="body" rows="1" class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition-shadow text-[12px] placeholder-slate-400 dark:bg-slate-900 dark:border-white/10 dark:text-white py-2 px-3 resize-none max-h-24 custom-scrollbar" placeholder="Tulis komentar..." required></textarea>
                                    </div>
                                    <button type="submit" class="relative flex items-center justify-center h-9 w-9 rounded-full bg-indigo-600 hover:bg-indigo-700 text-white border border-indigo-500/20 shadow-md shadow-indigo-600/10 hover:scale-110 active:scale-95 transition-all duration-300 focus:outline-none shrink-0">
                                        <svg class="w-4 h-4 transform rotate-90" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('styles')
    <style>
        /* Custom scrollbar for chat */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #334155;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Auto scroll chat to bottom
            const chatContainer = document.getElementById('chat-messages-container');
            if (chatContainer) {
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }
        });
    </script>
    @endpush
</x-app-layout>
