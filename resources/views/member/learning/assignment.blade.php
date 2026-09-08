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
                <h1 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">{{ $assignment->title }}</h1>
                <p class="text-slate-500 dark:text-slate-400 mt-2">Kelas: <span class="font-bold text-slate-700 dark:text-slate-300">{{ $course->title }}</span></p>
            </div>

            <!-- 3-Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                
                <!-- Left Column: Deskripsi Tugas (lg:col-span-3) -->
                <div class="lg:col-span-3 space-y-6">
                    <div class="bg-white dark:bg-[#151515] rounded-[24px] border border-slate-200/60 dark:border-white/10 shadow-sm overflow-hidden p-6">
                        <h2 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-4">Informasi Tugas</h2>
                        <div class="space-y-4">
                            <div>
                                <p class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Nilai Minimal Kelulusan</p>
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 dark:bg-indigo-950/30 border border-indigo-100 dark:border-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-xs font-bold rounded-xl">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg>
                                    {{ $assignment->passing_score }}%
                                </span>
                            </div>
                            <div>
                                <p class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Status Pengerjaan</p>
                                @if(!$submission)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-50 dark:bg-rose-950/20 border border-rose-100 dark:border-rose-900/30 text-rose-500 dark:text-rose-455 text-xs font-bold rounded-xl">
                                        Belum Dikerjakan
                                    </span>
                                @elseif($submission->status === 'submitted')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-50 dark:bg-amber-950/20 border border-amber-100/50 dark:border-amber-900/30 text-amber-600 dark:text-amber-455 text-xs font-bold rounded-xl">
                                        Menunggu Penilaian
                                    </span>
                                @elseif($submission->status === 'graded')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-100/50 dark:border-emerald-900/30 text-emerald-600 dark:text-emerald-450 text-xs font-bold rounded-xl">
                                        Sudah Dinilai
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-[#151515] rounded-[24px] border border-slate-200/60 dark:border-white/10 shadow-sm overflow-hidden p-6">
                        <h2 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-3">Deskripsi</h2>
                        <div class="prose prose-slate dark:prose-invert max-w-none tinymce-wrapper text-[13px] leading-relaxed">
                            {!! $assignment->description !!}
                        </div>
                    </div>
                </div>

                <!-- Middle Column: Form & Editor (lg:col-span-5) -->
                <div class="lg:col-span-5 space-y-6">
                    @if ($errors->any())
                        <div class="p-5 bg-red-50 dark:bg-red-950/20 border border-red-250/50 dark:border-red-900/30 rounded-[24px]">
                            <div class="flex items-center gap-2 text-red-800 dark:text-red-400 mb-2">
                                <svg class="w-5 h-5 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <span class="font-bold text-sm">Gagal Mengumpulkan Tugas:</span>
                            </div>
                            <ul class="list-disc list-inside text-xs text-red-700 dark:text-red-400 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($submission && $submission->status === 'graded')
                @php
                    $isPassed = $submission->score >= $assignment->passing_score;
                @endphp
                <div class="bg-white dark:bg-[#151515] rounded-2xl border border-slate-200/60 dark:border-white/10 p-4 mb-8 shadow-sm flex items-center justify-between gap-5 flex-wrap">
                    <div class="flex items-center gap-3">
                        <!-- Minimalist Score Badge -->
                        <div class="w-11 h-11 rounded-xl {{ $isPassed ? 'bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400' : 'bg-red-50 dark:bg-red-950/30 text-red-600 dark:text-red-400' }} flex flex-col items-center justify-center shrink-0 border {{ $isPassed ? 'border-emerald-100/80 dark:border-emerald-900/20' : 'border-red-100/80 dark:border-red-900/20' }}">
                            <span class="text-[8px] font-black uppercase tracking-wider leading-none opacity-80">Nilai</span>
                            <span class="text-sm font-black leading-none mt-0.5">{{ $submission->score }}</span>
                        </div>
                        <div>
                            <h3 class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest leading-none mb-1">Hasil Evaluasi</h3>
                            <div class="flex items-center gap-1.5">
                                <span class="text-xs font-black {{ $isPassed ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }} leading-none">
                                    {{ $isPassed ? 'LULUS' : 'BELUM LULUS' }}
                                </span>
                                <span class="text-[9px] font-medium text-slate-400 dark:text-slate-500 leading-none">({{ $assignment->passing_score }}% min)</span>
                            </div>
                        </div>
                    </div>
                    @if($submission->feedback)
                        <div class="flex-1 min-w-[240px] text-xs border-l border-slate-100 dark:border-white/5 pl-4 py-0.5">
                            <span class="font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider text-[9px]">Tanggapan Mentor</span>
                            <p class="mt-1 text-slate-650 dark:text-slate-300 leading-relaxed">{{ $submission->feedback }}</p>
                        </div>
                    @endif
                </div>
            @endif

                    <div class="bg-white dark:bg-[#151515] rounded-[24px] border border-slate-200/60 dark:border-white/10 shadow-sm overflow-hidden p-6">
                        <h2 class="text-lg font-bold text-slate-800 dark:text-white mb-6">{{ $submission ? 'Perbarui Jawaban Anda' : 'Kumpulkan Jawaban Anda' }}</h2>
                        
                        <form action="{{ route('member.learning.assignment.store', [$course, $assignment]) }}" method="POST" enctype="multipart/form-data" id="assignment-form" onsubmit="prepareFormSubmit(event)">
                            @csrf
                            <input type="hidden" name="content" id="content-hidden">
                            
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2">Teks Jawaban <span class="text-red-500">*</span></label>
                                    
                                    <div class="rounded-[20px] border border-slate-200 dark:border-white/10 overflow-hidden focus-within:border-indigo-400 focus-within:ring-1 focus-within:ring-indigo-400/20 transition-all bg-slate-50 dark:bg-slate-900">
                                        {{-- Quill toolbar --}}
                                        <div id="quill-toolbar" class="border-0 border-b border-slate-100 dark:border-white/5 bg-slate-50/80 dark:bg-slate-800/50 px-4 py-1.5">
                                            <span class="ql-formats">
                                                <select class="ql-header">
                                                    <option value="1">Heading 1</option>
                                                    <option value="2">Heading 2</option>
                                                    <option value="3">Heading 3</option>
                                                    <option selected>Normal</option>
                                                </select>
                                            </span>
                                            <span class="ql-formats">
                                                <button class="ql-bold"></button>
                                                <button class="ql-italic"></button>
                                                <button class="ql-underline"></button>
                                            </span>
                                            <span class="ql-formats">
                                                <button class="ql-list" value="ordered"></button>
                                                <button class="ql-list" value="bullet"></button>
                                            </span>
                                            <span class="ql-formats">
                                                <button class="ql-code-block"></button>
                                            </span>
                                        </div>
                                        
                                        {{-- Quill editor --}}
                                        <div id="quill-editor" class="bg-white dark:bg-slate-900" style="min-height: 280px; font-family: Inter, sans-serif; font-size: 14px;">{!! old('content', $submission?->content) !!}</div>
                                    </div>
                                </div>

                                <div>
                                    <label for="file" class="block text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2">Lampiran File <span class="text-slate-400 font-normal normal-case">(Opsional)</span></label>
                                    @if($submission && $submission->file_path)
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
                                        <div class="mb-3 p-3 rounded-2xl border border-slate-200/60 dark:border-white/5 bg-slate-50/50 dark:bg-slate-900/30 flex items-center justify-between gap-3">
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
                                    @endif
                                    <input type="file" name="file" id="file" class="w-full text-xs text-slate-500 dark:text-slate-400 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-xs file:font-black file:uppercase file:tracking-wider file:bg-indigo-50 dark:file:bg-indigo-950/40 file:text-indigo-700 dark:file:text-indigo-400 hover:file:bg-indigo-100 dark:hover:file:bg-indigo-950/60 transition-colors cursor-pointer">
                                </div>
                            </div>

                            <div class="mt-8 flex items-center justify-between gap-3">
                                <a href="{{ route('member.learning.show', $course) }}?tab=tugas" class="inline-flex items-center justify-center px-5 py-3 bg-white dark:bg-[#1e1e1e] text-slate-600 dark:text-slate-400 font-bold text-[13px] rounded-2xl hover:bg-slate-100 dark:hover:bg-zinc-800 transition-all border border-slate-200/60 dark:border-white/5 shadow-sm">
                                    Batal
                                </a>
                                <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-slate-900 dark:bg-white text-white dark:text-slate-955 font-bold text-[13px] rounded-2xl hover:bg-indigo-600 dark:hover:bg-indigo-500 hover:text-white dark:hover:text-white transition-all duration-200 hover:shadow-lg">
                                    {{ $submission ? 'Simpan Pembaruan' : 'Kumpulkan Tugas' }}
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
                                {{ $submission ? $submission->comments->count() : 0 }} pesan
                            </span>
                        </div>

                        <!-- Chat Body / Message List (Fixed Background Wrapper) -->
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
                                    @if($submission)
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
                                                <p class="text-[10px] mt-1">Diskusikan tugas Anda dengan mentor di sini.</p>
                                            </div>
                                        @endforelse
                                    @else
                                        <div class="flex flex-col items-center justify-center min-h-[300px] text-center p-6 text-slate-400 dark:text-slate-550">
                                            <svg class="w-8 h-8 mb-2 opacity-50" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                                            <p class="text-xs font-bold">Obrolan Terkunci</p>
                                            <p class="text-[10px] mt-1">Kirimkan jawaban Anda terlebih dahulu untuk membuka fitur diskusi.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Chat Footer / Input Form (Sticky) -->
                        @if($submission)
                            <div class="p-3 bg-white/80 dark:bg-[#151515]/80 backdrop-blur-md border-t border-slate-100 dark:border-white/5 z-10">
                                <form action="{{ route('assignments.submissions.comments.store', $submission) }}" method="POST" class="m-0">
                                    @csrf
                                    <div class="flex gap-2 items-center">
                                        <div class="flex-1">
                                            <textarea name="body" rows="1" class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 transition-shadow text-[12px] placeholder-slate-400 dark:bg-slate-900 dark:border-white/10 dark:text-white py-2 px-3 resize-none max-h-24 custom-scrollbar" placeholder="Tulis pesan..." required></textarea>
                                        </div>
                                        <button type="submit" class="relative flex items-center justify-center h-9 w-9 rounded-full bg-indigo-600 hover:bg-indigo-700 text-white border border-indigo-500/20 shadow-md shadow-indigo-600/10 hover:scale-110 active:scale-95 transition-all duration-300 focus:outline-none shrink-0">
                                            <svg class="w-4 h-4 transform rotate-90" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
    <style>
        /* --- Quill Editor Custom Premium Styling --- */
        #quill-editor {
            border: none !important;
            font-family: Inter, sans-serif;
            font-size: 14px;
        }
        .ql-container.ql-snow {
            border: none !important;
        }
        .ql-toolbar.ql-snow {
            border: none !important;
            border-bottom: 1px solid #e2e8f0 !important;
            background-color: #f8fafc !important;
            padding: 6px 10px !important;
        }
        .ql-editor {
            padding: 16px 20px;
            min-height: 220px;
            color: #1e293b;
        }
        .ql-editor p, .ql-editor h1, .ql-editor h2, .ql-editor h3, .ql-editor h4, .ql-editor h5, .ql-editor h6 {
            color: #1e293b !important;
        }
        
        /* Light Mode Picker Styling */
        .ql-snow .ql-picker {
            color: #475569 !important;
        }
        .ql-snow .ql-picker-label {
            color: #475569 !important;
        }
        .ql-snow .ql-picker-options {
            background-color: #ffffff !important;
            border-color: #e2e8f0 !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
            border-radius: 8px !important;
        }
        .ql-snow .ql-picker-item {
            color: #475569 !important;
        }
        .ql-snow .ql-picker-item:hover, .ql-snow .ql-picker-item.ql-selected {
            color: #4f46e5 !important;
            background-color: #f1f5f9 !important;
        }

        /* --- Dark Mode Overrides --- */
        .dark #quill-editor {
            background-color: #0f172a !important;
        }
        .dark .ql-editor {
            color: #f1f5f9 !important;
        }
        .dark .ql-editor p, .dark .ql-editor h1, .dark .ql-editor h2, .dark .ql-editor h3, .dark .ql-editor h4, .dark .ql-editor h5, .dark .ql-editor h6 {
            color: #f1f5f9 !important;
        }
        .dark .ql-toolbar.ql-snow {
            background-color: #1e293b !important;
            border-bottom: 1px solid #334155 !important;
        }
        .dark .ql-toolbar.ql-snow .ql-stroke {
            stroke: #94a3b8 !important;
        }
        .dark .ql-toolbar.ql-snow .ql-fill {
            fill: #94a3b8 !important;
        }
        .dark .ql-toolbar.ql-snow button:hover .ql-stroke,
        .dark .ql-toolbar.ql-snow button.ql-active .ql-stroke {
            stroke: #38bdf8 !important;
        }
        .dark .ql-toolbar.ql-snow button:hover .ql-fill,
        .dark .ql-toolbar.ql-snow button.ql-active .ql-fill {
            fill: #38bdf8 !important;
        }
        .dark .ql-snow .ql-picker {
            color: #cbd5e1 !important;
        }
        .dark .ql-snow .ql-picker-label {
            color: #cbd5e1 !important;
        }
        .dark .ql-snow .ql-picker-label:hover {
            color: #38bdf8 !important;
        }
        .dark .ql-snow .ql-picker-label:hover .ql-stroke {
            stroke: #38bdf8 !important;
        }
        .dark .ql-snow .ql-picker-options {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3) !important;
        }
        .dark .ql-snow .ql-picker-item {
            color: #cbd5e1 !important;
        }
        .dark .ql-snow .ql-picker-item:hover, .dark .ql-snow .ql-picker-item.ql-selected {
            color: #38bdf8 !important;
            background-color: #334155 !important;
        }
        
        #quill-editor .ql-syntax {
            background-color: #0f172a !important;
            color: #e2e8f0 !important;
            border-radius: 12px !important;
            padding: 14px 18px !important;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace !important;
            font-size: 14px !important;
            line-height: 1.6 !important;
            margin-top: 12px !important;
            margin-bottom: 12px !important;
        }

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
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const quill = new Quill('#quill-editor', {
                theme: 'snow',
                modules: { toolbar: '#quill-toolbar' },
                placeholder: 'Tulis jawaban tugas Anda di sini…',
            });

            window.prepareFormSubmit = function(event) {
                document.getElementById('content-hidden').value = quill.root.innerHTML === '<p><br></p>' ? '' : quill.root.innerHTML;
            };

            // Auto scroll chat to bottom
            const chatContainer = document.getElementById('chat-messages-container');
            if (chatContainer) {
                chatContainer.scrollTop = chatContainer.scrollHeight;
            }
        });
    </script>
    @endpush
</x-app-layout>
