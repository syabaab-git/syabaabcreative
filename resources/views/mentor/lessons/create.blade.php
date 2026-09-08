<x-app-layout>
    <div class="py-8 bg-slate-50 dark:bg-black min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <h2 class="text-[28px] font-bold text-slate-900 tracking-tight leading-none">Tambah Materi Baru</h2>
                <p class="text-[15px] text-slate-500 mt-2">Kelas: <span class="font-bold text-slate-700">{{ $course->title ?? 'Nama Kelas' }}</span></p>
            </div>

            <form method="POST" action="{{ route('mentor.courses.lessons.store', $course ?? 1) }}" enctype="multipart/form-data" id="lesson-form" onsubmit="prepareFormSubmit(event)">
                @csrf
                {{-- Hidden field for Quill content --}}
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
                                <input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[18px] font-bold text-slate-900 transition-colors placeholder:text-slate-300 placeholder:font-normal" placeholder="Masukkan judul materi…" required autofocus>
                                @error('title') <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <div class="w-1/2">
                                <label for="duration_minutes" class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Durasi <span class="text-slate-400 font-normal normal-case">(Menit)</span> <span class="text-red-500">*</span></label>
                                <input type="number" name="duration_minutes" id="duration_minutes" value="{{ old('duration_minutes', 0) }}" min="0" class="w-full bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[16px] font-medium text-slate-900 transition-colors" required>
                                @error('duration_minutes') <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Deskripsi Singkat <span class="text-slate-400 font-normal normal-case">(Opsional)</span></label>
                                <textarea name="description" id="description" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-2xl focus:border-indigo-400 focus:ring-0 px-4 py-3 text-[15px] text-slate-900 transition-all placeholder:text-slate-400 resize-none" placeholder="Ringkasan singkat tentang materi ini…">{{ old('description') }}</textarea>
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
                                    <button class="ql-link"></button>
                                    <button class="ql-image"></button>
                                    <button class="ql-video"></button>
                                </span>
                            </div>
                            {{-- Quill editor --}}
                            <div id="quill-editor" class="bg-white dark:bg-slate-900" style="min-height: 320px; font-family: Inter, sans-serif; font-size: 15px;">{!! old('body') !!}</div>
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

                        <div id="drop-zone" class="flex flex-col items-center justify-center p-8 border-2 border-slate-200 border-dashed rounded-3xl hover:border-indigo-400 hover:bg-indigo-50/30 transition-all bg-slate-50/50 cursor-pointer"
                            onclick="document.getElementById('file-input').click()"
                            ondragover="event.preventDefault(); this.classList.add('border-indigo-400','bg-indigo-50/50')"
                            ondragleave="this.classList.remove('border-indigo-400','bg-indigo-50/50')"
                            ondrop="handleFileDrop(event)">
                            <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center shadow-sm text-indigo-400 mb-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                            </div>
                            <span class="text-[14px] font-bold text-slate-700">Klik atau seret file ke sini</span>
                            <span class="text-[12px] text-slate-400 mt-1">PDF, ZIP, DOC, JPG, PNG, MP4 (Maks. 10MB/file)</span>
                        </div>
                        
                        {{-- PERBAIKAN: Menambahkan name="attachments[]" agar terbaca oleh Laravel --}}
                        <input type="file" name="attachments[]" id="file-input" class="hidden" multiple accept=".pdf,.zip,.doc,.docx,.rar,.txt,.jpg,.png,.mp4,.mov" onchange="handleFileSelect(this.files)">

                        <div id="files-list" class="flex flex-col gap-2 mt-4"></div>
                        @error('attachments.*') <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- CARD 5: Preview Gratis (Alpine JS) --}}
                    <div class="bg-white rounded-[24px] shadow-sm border border-slate-200/80 dark:border-white/10 p-7" x-data="{ on: {{ old('is_preview') ? 'true' : 'false' }} }">
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

                    {{-- Submit Area --}}
                    <div class="flex items-center justify-between gap-3 pb-8">
                        <a href="{{ route('mentor.courses.show', $course ?? 1) }}" class="inline-flex items-center justify-center px-6 py-3.5 bg-white text-slate-600 font-bold text-[15px] rounded-2xl hover:bg-slate-100 transition-all border border-slate-200">
                            Batal
                        </a>

                        <div class="flex items-stretch relative" id="split-btn-wrapper">
                            <input type="hidden" name="scheduled_at" id="scheduled-at-input" value="{{ old('scheduled_at') }}">

                            <button type="submit" id="submit-btn" class="inline-flex items-center justify-center px-7 py-3.5 bg-slate-900 text-white font-bold text-[15px] rounded-l-2xl hover:bg-indigo-600 transition-all duration-200 hover:shadow-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                <span id="submit-label">Simpan Materi</span>
                            </button>

                            <div class="w-px bg-slate-700 self-stretch"></div>

                            <button type="button" id="schedule-toggle-btn" onclick="toggleSchedulePopup()" class="px-4 bg-slate-900 hover:bg-indigo-600 text-white rounded-r-2xl transition-all duration-200 hover:shadow-lg flex items-center" aria-label="Jadwalkan">
                                <svg id="schedule-arrow" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            {{-- Schedule Popup --}}
                            <div id="schedule-popup" class="hidden absolute right-0 bottom-full mb-3 w-72 bg-white rounded-[20px] shadow-xl border border-slate-200/80 dark:border-white/10 p-5 z-50">
                                <p class="text-[13px] font-bold text-slate-700 mb-1">Jadwalkan Rilis Materi</p>
                                <p class="text-[12px] text-slate-400 mb-4">Materi akan tersedia untuk siswa mulai tanggal & waktu ini.</p>
                                <input type="datetime-local" id="schedule-datetime-picker"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-[14px] text-slate-800 focus:border-indigo-400 focus:ring-0 transition-colors mb-3"
                                    value="{{ old('scheduled_at') }}"
                                    onchange="onScheduleChange(this.value)">
                                <div class="flex gap-2">
                                    <button type="button" onclick="clearSchedule()" class="flex-1 px-3 py-2 bg-slate-100 text-slate-600 font-bold text-[13px] rounded-xl hover:bg-slate-200 transition-colors">Hapus</button>
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
    // Pastikan DOM sudah diload sebelum menjalankan script
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
        // PERBAIKAN: Menangani nilai old('links') yang kosong dengan aman
        let rawLinks = {!! json_encode(old('links', [])) !!};
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
        window.selectedFiles = []; 
        window.fileIdCounter = 0;

        window.handleFileSelect = function(fileList) {
            const maxSize = 10 * 1024 * 1024;
            for (const file of fileList) {
                if (file.size > maxSize) {
                    alert(`"${file.name}" melebihi ukuran maksimum 10MB.`);
                    continue;
                }
                selectedFiles.push({ file, id: ++fileIdCounter });
            }
            syncFileInputs();
            renderFileList();
        };

        window.handleFileDrop = function(event) {
            event.preventDefault();
            document.getElementById('drop-zone').classList.remove('border-indigo-400','bg-indigo-50/50');
            handleFileSelect(event.dataTransfer.files);
        };

        window.removeSelectedFile = function(id) {
            selectedFiles = selectedFiles.filter(f => f.id !== id);
            syncFileInputs();
            renderFileList();
        };

        window.syncFileInputs = function() {
            const fileInput = document.getElementById('file-input');
            const dt = new DataTransfer();
            selectedFiles.forEach(item => dt.items.add(item.file));
            fileInput.files = dt.files;
        };

        window.renderFileList = function() {
            const list = document.getElementById('files-list');
            list.innerHTML = '';
            selectedFiles.forEach(item => {
                const file = item.file;
                const size = (file.size / (1024*1024)).toFixed(2) + ' MB';
                const row = document.createElement('div');
                row.className = 'flex items-center gap-3 px-4 py-3 bg-slate-50 border border-slate-200 rounded-2xl';
                row.innerHTML = `
                    <div class="flex-1 min-w-0">
                        <p class="text-[13px] font-bold text-slate-800 truncate">${escapeHtml(file.name)}</p>
                        <p class="text-[12px] text-slate-400">${size}</p>
                    </div>
                    <button type="button" onclick="removeSelectedFile(${item.id})" class="w-7 h-7 flex items-center justify-center text-slate-300 hover:text-red-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                `;
                list.appendChild(row);
            });
        };

        // ─────────────────────────── SCHEDULE POPUP ───────────────────────────
        window.schedulePopupOpen = false;

        window.toggleSchedulePopup = function() {
            schedulePopupOpen = !schedulePopupOpen;
            document.getElementById('schedule-popup').classList.toggle('hidden', !schedulePopupOpen);
            document.getElementById('schedule-arrow').style.transform = schedulePopupOpen ? 'rotate(180deg)' : 'rotate(0deg)';
        };

        window.onScheduleChange = function(val) {
            document.getElementById('scheduled-at-input').value = val;
            updateSubmitLabel();
        };

        window.clearSchedule = function() {
            document.getElementById('schedule-datetime-picker').value = '';
            document.getElementById('scheduled-at-input').value = '';
            updateSubmitLabel();
            if (schedulePopupOpen) toggleSchedulePopup();
        };

        window.applySchedule = function() {
            updateSubmitLabel();
            if (schedulePopupOpen) toggleSchedulePopup();
        };

        window.updateSubmitLabel = function() {
            const val = document.getElementById('scheduled-at-input').value;
            document.getElementById('submit-label').textContent = val ? 'Jadwalkan' : 'Simpan Materi';
        };

        document.addEventListener('click', function(e) {
            const wrapper = document.getElementById('split-btn-wrapper');
            if (wrapper && !wrapper.contains(e.target) && schedulePopupOpen) {
                toggleSchedulePopup();
            }
        });

        updateSubmitLabel();
    });
    </script>
    @endpush
</x-app-layout>
