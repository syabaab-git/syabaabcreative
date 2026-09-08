<x-app-layout>
    <div class="py-8 bg-slate-50 dark:bg-black min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <h2 class="text-[28px] font-bold text-slate-900 tracking-tight leading-none">Edit Materi</h2>
                <p class="text-[15px] text-slate-500 mt-2">Kelas: <span class="font-bold text-slate-700">{{ $course->title }}</span></p>
            </div>

            <form method="POST" action="{{ route('mentor.courses.lessons.update', [$course, $lesson]) }}" enctype="multipart/form-data" id="lesson-form" onsubmit="prepareFormSubmit(event)">
                @csrf
                @method('PUT')
                <input type="hidden" name="body" id="body-hidden">

                <div class="flex flex-col gap-5">
                    @if ($errors->any())
                        <div class="p-5 bg-rose-50 dark:bg-rose-950/20 border border-rose-200 dark:border-rose-900/30 text-rose-800 dark:text-rose-300 rounded-2xl text-sm">
                            <div class="flex items-center gap-2.5 mb-2.5 font-bold">
                                <svg class="w-5 h-5 text-rose-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                <span>Terjadi kesalahan pengisian data:</span>
                            </div>
                            <ul class="list-disc pl-5 space-y-1 font-medium">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- CARD 1: Informasi Utama --}}
                    <div class="bg-white rounded-[24px] shadow-sm border border-slate-200/80 dark:border-white/10 p-7">
                        <h3 class="text-[12px] font-bold text-slate-400 uppercase tracking-widest mb-5">Informasi Materi</h3>
                        <div class="space-y-6">
                            <div>
                                <label for="title" class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Judul Materi <span class="text-red-500">*</span></label>
                                <input type="text" name="title" id="title" value="{{ old('title', $lesson->title) }}" class="w-full bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[18px] font-bold text-slate-900 transition-colors placeholder:text-slate-300 placeholder:font-normal" required autofocus>
                                @error('title') <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <div class="w-1/2">
                                <label for="duration_minutes" class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Durasi <span class="text-slate-400 font-normal normal-case">(Menit)</span> <span class="text-red-500">*</span></label>
                                <input type="number" name="duration_minutes" id="duration_minutes" value="{{ old('duration_minutes', $lesson->duration_minutes) }}" min="0" class="w-full bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[16px] font-medium text-slate-900 transition-colors" required>
                                @error('duration_minutes') <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Deskripsi Singkat <span class="text-slate-400 font-normal normal-case">(Opsional)</span></label>
                                <textarea name="description" id="description" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-2xl focus:border-indigo-400 focus:ring-0 px-4 py-3 text-[15px] text-slate-900 transition-all placeholder:text-slate-400 resize-none" placeholder="Ringkasan singkat tentang materi ini…">{{ old('description', $lesson->description) }}</textarea>
                                @error('description') <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- CARD 2: Isi Materi (Quill Editor) --}}
                    <div class="bg-white rounded-[24px] shadow-sm border border-slate-200/80 dark:border-white/10 p-7">
                        <h3 class="text-[12px] font-bold text-slate-400 uppercase tracking-widest mb-5">Isi Materi</h3>
                        
                        <div class="rounded-[20px] border border-slate-200 dark:border-white/10 overflow-hidden focus-within:border-indigo-400 focus-within:ring-1 focus-within:ring-indigo-400/20 transition-all bg-slate-50 dark:bg-slate-900">
                            {{-- Quill toolbar --}}
                            <div id="quill-toolbar" class="border-0 border-b border-slate-100 bg-slate-50/80 px-4 py-1.5">
                                <span class="ql-formats">
                                    <select class="ql-header">
                                        <option value="1">Heading 1</option>
                                        <option value="2">Heading 2</option>
                                        <option value="3">Heading 3</option>
                                        <option selected>Normal</option>
                                    </select>
                                    <select class="ql-size"></select>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-bold"></button>
                                    <button class="ql-italic"></button>
                                    <button class="ql-underline"></button>
                                    <button class="ql-strike"></button>
                                </span>
                                <span class="ql-formats">
                                    <select class="ql-color"></select>
                                    <select class="ql-background"></select>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-list" value="ordered"></button>
                                    <button class="ql-list" value="bullet"></button>
                                    <button class="ql-indent" value="-1"></button>
                                    <button class="ql-indent" value="+1"></button>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-align" value=""></button>
                                    <button class="ql-align" value="center"></button>
                                    <button class="ql-align" value="right"></button>
                                    <button class="ql-align" value="justify"></button>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-link"></button>
                                    <button class="ql-image"></button>
                                    <button class="ql-video"></button>
                                    <button class="ql-blockquote"></button>
                                    <button class="ql-code-block"></button>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-clean"></button>
                                </span>
                            </div>
                            {{-- Quill editor --}}
                            <div id="quill-editor" class="bg-white dark:bg-slate-900" style="min-height: 320px; font-family: Inter, sans-serif; font-size: 15px;">{!! old('body', $lesson->body) !!}</div>
                        </div>
                        @error('body') <p class="mt-3 text-[13px] text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- CARD 3: Tautan & Video --}}
                    <div class="bg-white rounded-[24px] shadow-sm border border-slate-200/80 dark:border-white/10 p-7" id="links-card">
                        <div class="flex items-center justify-between mb-5">
                            <h3 class="text-[12px] font-bold text-slate-400 uppercase tracking-widest">Tautan & Video</h3>
                            <button type="button" onclick="addLink()" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 font-bold text-[13px] rounded-xl transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                Tambah Tautan
                            </button>
                        </div>
                        <div id="links-list" class="flex flex-col gap-3"></div>
                        <p id="links-empty" class="text-[13px] text-slate-400 text-center py-6">Belum ada tautan. Klik "Tambah Tautan" untuk menambahkan video atau referensi eksternal.</p>
                    </div>

                    {{-- CARD 4: Lampiran --}}
                    <div class="bg-white rounded-[24px] shadow-sm border border-slate-200/80 dark:border-white/10 p-7" id="attachments-card">
                        <h3 class="text-[12px] font-bold text-slate-400 uppercase tracking-widest mb-5">Lampiran File</h3>

                        {{-- Existing files --}}
                        <div id="existing-files-section">
                            @if($lesson->attachments && count($lesson->attachments) > 0)
                                <p class="text-[12px] font-bold text-slate-400 uppercase tracking-wider mb-2">File Tersimpan</p>
                                <div id="existing-files-list" class="flex flex-col gap-2 mb-4">
                                    @foreach($lesson->attachments as $att)
                                        <div class="flex items-center gap-3 px-4 py-3 bg-emerald-50 border border-emerald-200 rounded-2xl" data-existing-path="{{ $att['path'] }}">
                                            <div class="w-8 h-8 bg-emerald-100 rounded-xl flex items-center justify-center text-emerald-600 flex-shrink-0">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-[13px] font-bold text-slate-800 truncate">{{ $att['name'] }}</p>
                                                <p class="text-[12px] text-slate-400">{{ isset($att['size']) ? round($att['size']/1024, 1).' KB' : '' }}</p>
                                            </div>
                                            <input type="hidden" name="keep_attachments[]" value="{{ $att['path'] }}" class="keep-attachment-input">
                                            <button type="button" onclick="removeExistingFile(this)" class="w-7 h-7 flex items-center justify-center rounded-lg text-slate-300 hover:text-red-500 hover:bg-red-50 transition-all">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        {{-- Upload area --}}
                        <div id="drop-zone" class="flex flex-col items-center justify-center p-8 border-2 border-slate-200 border-dashed rounded-3xl hover:border-indigo-400 hover:bg-indigo-50/30 transition-all bg-slate-50/50 cursor-pointer"
                            onclick="document.getElementById('file-input').click()"
                            ondragover="event.preventDefault(); this.classList.add('border-indigo-400','bg-indigo-50/50')"
                            ondragleave="this.classList.remove('border-indigo-400','bg-indigo-50/50')"
                            ondrop="handleFileDrop(event)">
                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-sm text-indigo-400 mb-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            </div>
                            <span class="text-[14px] font-bold text-slate-700">Tambah file baru</span>
                            <span class="text-[12px] text-slate-400 mt-1">PDF, ZIP, DOC, JPG, PNG, MP4 (Maks. 10MB/file)</span>
                        </div>
                        <div id="file-inputs-container"></div>
                        <input type="file" id="file-input" class="hidden" multiple accept=".pdf,.zip,.doc,.docx,.rar,.txt,.jpg,.png,.mp4,.mov" onchange="handleFileSelect(this.files)">
                        <div id="files-list" class="flex flex-col gap-2 mt-4"></div>

                        @error('attachments.*') <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- CARD 5: Preview Gratis --}}
                    <div class="bg-white rounded-[24px] shadow-sm border border-slate-200/80 dark:border-white/10 p-7" x-data="{ on: {{ old('is_preview', $lesson->is_preview) ? 'true' : 'false' }} }">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-bold text-slate-900 text-[16px]">Preview Gratis</h3>
                                <p class="text-[13px] text-slate-500 mt-0.5">Jika aktif, materi ini dapat dilihat pengguna sebelum membeli kelas.</p>
                            </div>
                            <div class="flex items-center ml-6 flex-shrink-0">
                                <button type="button" @click="on = !on" :class="on ? 'bg-indigo-600' : 'bg-slate-200'" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-300 ease-in-out focus:outline-none">
                                    <input type="hidden" name="is_preview" :value="on ? '1' : '0'">
                                    <span aria-hidden="true" :class="on ? 'translate-x-5' : 'translate-x-0'" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition-transform duration-300 ease-in-out"></span>
                                </button>
                                <span class="ml-3 text-[14px] font-bold transition-colors" :class="on ? 'text-indigo-600' : 'text-slate-500'" x-text="on ? 'Aktif' : 'Nonaktif'"></span>
                            </div>
                        </div>
                    </div>

                    {{-- Submit Area: Split Button --}}
                    <div class="flex items-center justify-between gap-3 pb-8">
                        <a href="{{ route('mentor.courses.show', $course) }}" class="inline-flex items-center justify-center px-6 py-3.5 bg-white text-slate-600 font-bold text-[15px] rounded-2xl hover:bg-slate-100 transition-all border border-slate-200">
                            Batal
                        </a>

                        <div class="flex items-stretch relative" id="split-btn-wrapper">
                            <input type="hidden" name="scheduled_at" id="scheduled-at-input" value="{{ old('scheduled_at', $lesson->scheduled_at ? $lesson->scheduled_at->format('Y-m-d\TH:i') : '') }}">

                            <button type="submit" class="inline-flex items-center justify-center px-7 py-3.5 bg-slate-900 text-white font-bold text-[15px] rounded-l-2xl hover:bg-indigo-600 transition-all duration-200 hover:shadow-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                <span id="submit-label">{{ old('scheduled_at', $lesson->scheduled_at) ? 'Jadwalkan' : 'Simpan Perubahan' }}</span>
                            </button>

                            <div class="w-px bg-slate-700 self-stretch"></div>

                            <button type="button" id="schedule-toggle-btn" onclick="toggleSchedulePopup()" class="px-4 bg-slate-900 hover:bg-indigo-600 text-white rounded-r-2xl transition-all duration-200 hover:shadow-lg flex items-center" aria-label="Jadwalkan">
                                <svg id="schedule-arrow" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            <div id="schedule-popup" class="hidden absolute right-0 bottom-full mb-3 w-72 bg-white rounded-[20px] shadow-xl border border-slate-200/80 dark:border-white/10 p-5 z-50">
                                <p class="text-[13px] font-bold text-slate-700 mb-1">Jadwalkan Rilis Materi</p>
                                <p class="text-[12px] text-slate-400 mb-4">Materi akan tersedia untuk siswa mulai tanggal & waktu ini.</p>
                                <input type="datetime-local" id="schedule-datetime-picker"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-[14px] text-slate-800 focus:border-indigo-400 focus:ring-0 transition-colors mb-3"
                                    value="{{ old('scheduled_at', $lesson->scheduled_at ? $lesson->scheduled_at->format('Y-m-d\TH:i') : '') }}"
                                    onchange="onScheduleChange(this.value)">
                                <div class="flex gap-2">
                                    <button type="button" onclick="clearSchedule()" class="flex-1 px-3 py-2 bg-slate-100 text-slate-600 font-bold text-[13px] rounded-xl hover:bg-slate-200 transition-colors">Hapus Jadwal</button>
                                    <button type="button" onclick="applySchedule()" class="flex-1 px-3 py-2 bg-indigo-600 text-white font-bold text-[13px] rounded-xl hover:bg-indigo-700 transition-colors">Terapkan</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
    <style>
        /* --- Quill Editor Custom Premium Styling --- */
        #quill-editor {
            border: none !important;
            font-family: Inter, sans-serif;
            font-size: 15px;
        }
        .ql-container.ql-snow {
            border: none !important;
        }
        .ql-toolbar.ql-snow {
            border: none !important;
            border-bottom: 1px solid #e2e8f0 !important;
            background-color: #f8fafc !important;
            padding: 8px 12px !important;
        }
        .ql-editor {
            padding: 24px 28px;
            min-height: 280px;
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
</style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // ─────────────────────────── QUILL EDITOR ───────────────────────────
        const quill = new Quill('#quill-editor', {
            theme: 'snow',
            modules: { toolbar: '#quill-toolbar' },
            placeholder: 'Tulis isi materi di sini…',
        });

        window.prepareFormSubmit = function(event) {
            document.getElementById('body-hidden').value = quill.root.innerHTML === '<p><br></p>' ? '' : quill.root.innerHTML;
        };

        // ─────────────────────────── LINKS MANAGER ───────────────────────────
        let rawLinks = @json(old('links', $lesson->links ?? []));
        window.lessonLinks = Array.isArray(rawLinks) ? rawLinks : [];
        window.linkCounter = lessonLinks.length;

        window.renderLinks = function() {
            const list = document.getElementById('links-list');
            const empty = document.getElementById('links-empty');
            list.innerHTML = '';
            
            if (lessonLinks.length === 0) {
                empty.classList.remove('hidden');
                return;
            }
            empty.classList.add('hidden');
            
            lessonLinks.forEach((link, index) => {
                const isVideo = /youtube|youtu\.be|vimeo|dailymotion/i.test(link.url || '');
                const iconBg = link.url ? (isVideo ? 'bg-red-100 text-red-500' : 'bg-emerald-100 text-emerald-600') : 'bg-slate-100 text-slate-400';
                const videoIcon = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;
                const linkIcon = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>`;
                
                const row = document.createElement('div');
                row.className = 'flex gap-3 items-start p-4 bg-slate-50 rounded-2xl border border-slate-200/80 dark:border-white/10 group transition-all duration-300';
                row.innerHTML = `
                    <div class="mt-2 flex-shrink-0">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-colors duration-300 ${iconBg}">
                            ${isVideo ? videoIcon : linkIcon}
                        </div>
                    </div>
                    <div class="flex-1 flex flex-col gap-2 min-w-0">
                        <input type="text" name="links[${index}][label]" value="${escapeHtml(link.label||'')}"
                            class="w-full bg-white border border-slate-200 rounded-xl focus:border-indigo-400 focus:ring-0 px-3 py-2 text-[14px] text-slate-800 font-medium placeholder:text-slate-400 transition-colors"
                            placeholder="Label (misal: Video Intro)" oninput="window.lessonLinks[${index}].label = this.value">
                        <input type="url" name="links[${index}][url]" value="${escapeHtml(link.url||'')}"
                            class="w-full bg-white border border-slate-200 rounded-xl focus:border-indigo-400 focus:ring-0 px-3 py-2 text-[13px] text-slate-600 font-mono placeholder:text-slate-400 transition-colors"
                            placeholder="https://…" oninput="window.lessonLinks[${index}].url = this.value; window.updateLinkIcon(this, ${index})">
                    </div>
                    <button type="button" onclick="removeLink(${index})" class="mt-2 flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-xl text-slate-300 hover:text-red-500 hover:bg-red-50 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                `;
                list.appendChild(row);
            });
        };

        window.updateLinkIcon = function(input, index) {
            const url = input.value;
            const isVideo = /youtube|youtu\.be|vimeo|dailymotion/i.test(url);
            const iconContainer = input.closest('.group').querySelector('.w-8.h-8');
            const videoIcon = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;
            const linkIcon = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>`;
            
            if (isVideo) {
                iconContainer.className = 'w-8 h-8 rounded-xl flex items-center justify-center bg-red-100 text-red-500 transition-colors duration-300';
                iconContainer.innerHTML = videoIcon;
            } else if (url) {
                iconContainer.className = 'w-8 h-8 rounded-xl flex items-center justify-center bg-emerald-100 text-emerald-600 transition-colors duration-300';
                iconContainer.innerHTML = linkIcon;
            } else {
                iconContainer.className = 'w-8 h-8 rounded-xl flex items-center justify-center bg-slate-100 text-slate-400 transition-colors duration-300';
                iconContainer.innerHTML = linkIcon;
            }
        };

        window.addLink = function() {
            lessonLinks.push({ id: ++linkCounter, url: '', label: '' });
            renderLinks();
            setTimeout(() => {
                const rows = document.querySelectorAll('#links-list > div');
                if (rows.length > 0) {
                    rows[rows.length - 1].querySelector('input[type="text"]').focus();
                }
            }, 50);
        };

        window.removeLink = function(index) {
            lessonLinks.splice(index, 1);
            renderLinks();
        };

        window.escapeHtml = function(str) {
            return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
        };

        renderLinks();

        // ─────────────────────────── ATTACHMENTS MANAGER ───────────────────────────
        let selectedFiles = [];
        let fileIdCounter = 0;

        window.removeExistingFile = function(btn) {
            const row = btn.closest('[data-existing-path]');
            if (row) row.remove();
        }

        window.handleFileSelect = function(fileList) {
            const allowedTypes = ['application/pdf','application/zip','application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/x-rar-compressed','text/plain','image/jpeg','image/png','video/mp4','video/quicktime'];
            const maxSize = 10 * 1024 * 1024;
            const errors = [];

            for (const file of fileList) {
                if (!allowedTypes.includes(file.type) && !file.name.match(/\.(pdf|zip|doc|docx|rar|txt|jpg|jpeg|png|mp4|mov)$/i)) {
                    errors.push(`"${file.name}" tidak didukung.`);
                    continue;
                }
                if (file.size > maxSize) {
                    errors.push(`"${file.name}" melebihi ukuran maksimum 10MB.`);
                    continue;
                }
                selectedFiles.push({ file, id: ++fileIdCounter });
            }

            if (errors.length) {
                alert(errors.join('\n'));
            }

            document.getElementById('file-input').value = '';
            syncFileInputs();
            renderFileList();
        }

        window.handleFileDrop = function(event) {
            event.preventDefault();
            document.getElementById('drop-zone').classList.remove('border-indigo-400','bg-indigo-50/50');
            handleFileSelect(event.dataTransfer.files);
        }

        window.removeSelectedFile = function(id) {
            selectedFiles = selectedFiles.filter(f => f.id !== id);
            syncFileInputs();
            renderFileList();
        }

        window.syncFileInputs = function() {
            const fileInput = document.getElementById('file-input');
            if (selectedFiles.length === 0) {
                fileInput.value = '';
                return;
            }

            const dt = new DataTransfer();
            selectedFiles.forEach(item => dt.items.add(item.file));
            fileInput.files = dt.files;
        }

        window.renderFileList = function() {
            const list = document.getElementById('files-list');
            list.innerHTML = '';
            selectedFiles.forEach(item => {
                const f = item.file;
                const size = f.size < 1024 ? f.size+' B' : f.size < 1024*1024 ? (f.size/1024).toFixed(1)+' KB' : (f.size/(1024*1024)).toFixed(1)+' MB';
                const row = document.createElement('div');
                row.className = 'flex items-center gap-3 px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl';
                row.innerHTML = `
                    <div class="w-8 h-8 bg-indigo-100 rounded-xl flex items-center justify-center text-indigo-500 flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[13px] font-bold text-slate-800 truncate">${escapeHtml(f.name)}</p>
                        <p class="text-[12px] text-slate-400">${size}</p>
                    </div>
                    <button type="button" onclick="removeSelectedFile(${item.id})" class="w-7 h-7 flex items-center justify-center rounded-lg text-slate-300 hover:text-red-500 hover:bg-red-50 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                `;
                list.appendChild(row);
            });
        }

        // ─────────────────────────── SCHEDULE POPUP ───────────────────────────
        window.schedulePopupOpen = false;

        window.toggleSchedulePopup = function() {
            schedulePopupOpen = !schedulePopupOpen;
            const popup = document.getElementById('schedule-popup');
            const arrow = document.getElementById('schedule-arrow');
            popup.classList.toggle('hidden', !schedulePopupOpen);
            arrow.style.transform = schedulePopupOpen ? 'rotate(180deg)' : 'rotate(0deg)';
        }

        window.onScheduleChange = function(val) {
            document.getElementById('scheduled-at-input').value = val;
            updateSubmitLabel();
        }

        window.clearSchedule = function() {
            document.getElementById('schedule-datetime-picker').value = '';
            document.getElementById('scheduled-at-input').value = '';
            updateSubmitLabel();
            if (schedulePopupOpen) toggleSchedulePopup();
        }

        window.applySchedule = function() {
            const val = document.getElementById('schedule-datetime-picker').value;
            document.getElementById('scheduled-at-input').value = val;
            updateSubmitLabel();
            if (schedulePopupOpen) toggleSchedulePopup();
        }

        window.updateSubmitLabel = function() {
            const val = document.getElementById('scheduled-at-input').value;
            document.getElementById('submit-label').textContent = val ? 'Jadwalkan' : 'Simpan Perubahan';
        }

        document.addEventListener('click', function(e) {
            const wrapper = document.getElementById('split-btn-wrapper');
            if (wrapper && !wrapper.contains(e.target) && schedulePopupOpen) toggleSchedulePopup();
        });

        updateSubmitLabel();
    });
    </script>
    @endpush
</x-app-layout>
