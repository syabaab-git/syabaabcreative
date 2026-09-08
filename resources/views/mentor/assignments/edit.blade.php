<x-app-layout>
    <div class="py-8 bg-slate-50 dark:bg-black min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h2 class="text-[28px] font-bold text-slate-900 tracking-tight leading-none">Edit Penugasan</h2>
                    <p class="text-[15px] text-slate-500 mt-2">Kelas: <span class="font-bold text-slate-700">{{ $course->title ?? 'Nama Kelas' }}</span></p>
                </div>
                <!-- Delete Button -->
                <form action="{{ route('mentor.courses.assignments.destroy', [$course, $assignment]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus tugas ini secara permanen?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 hover:bg-red-100 font-bold text-[13px] rounded-xl transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Hapus Tugas
                    </button>
                </form>
            </div>

            <form method="POST" action="{{ route('mentor.courses.assignments.update', [$course, $assignment]) }}" id="assignment-form" onsubmit="prepareFormSubmit(event)">
                @csrf
                @method('PUT')
                {{-- Hidden field for Quill content --}}
                <input type="hidden" name="description" id="description-hidden">

                <div class="flex flex-col gap-5">

                    {{-- CARD 1: Informasi Utama --}}
                    <div class="bg-white rounded-[24px] shadow-sm border border-slate-200/80 dark:border-white/10 p-7">
                        <h3 class="text-[12px] font-bold text-slate-400 uppercase tracking-widest mb-5">Informasi Tugas</h3>
                        <div class="space-y-6">
                            <div>
                                <label for="title" class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Judul Tugas <span class="text-red-500">*</span></label>
                                <input type="text" name="title" id="title" value="{{ old('title', $assignment->title) }}" class="w-full bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[18px] font-bold text-slate-900 transition-colors placeholder:text-slate-300 placeholder:font-normal" placeholder="Masukkan judul tugas…" required autofocus>
                                @error('title') <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <div class="w-1/2">
                                <label for="passing_score" class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Nilai Kelulusan (KKM) <span class="text-red-500">*</span></label>
                                <input type="number" name="passing_score" id="passing_score" value="{{ old('passing_score', $assignment->passing_score) }}" min="0" max="100" class="w-full bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[16px] font-medium text-slate-900 transition-colors" required>
                                @error('passing_score') <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- CARD 2: Isi Deskripsi & Soal (Quill Editor) --}}
                    <div class="bg-white rounded-[24px] shadow-sm border border-slate-200/80 dark:border-white/10 p-7">
                        <h3 class="text-[12px] font-bold text-slate-400 uppercase tracking-widest mb-5">Deskripsi & Instruksi Tugas</h3>
                        
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
                                </span>
                            </div>
                            {{-- Quill editor --}}
                            <div id="quill-editor" class="bg-white dark:bg-slate-900" style="min-height: 320px; font-family: Inter, sans-serif; font-size: 15px;">{!! old('description', $assignment->description) !!}</div>
                        </div>
                        @error('description') <p class="mt-3 text-[13px] text-red-500">{{ $message }}</p> @enderror
                    </div>

                    {{-- Submit Area --}}
                    <div class="flex items-center justify-between gap-3 pb-8">
                        <a href="{{ route('mentor.courses.show', $course) }}" class="inline-flex items-center justify-center px-6 py-3.5 bg-white text-slate-600 font-bold text-[15px] rounded-2xl hover:bg-slate-100 transition-all border border-slate-200">
                            Batal
                        </a>

                        <div class="flex items-stretch relative" id="split-btn-wrapper">
                            @php
                                // Konversi ke format datetime-local (YYYY-MM-DDThh:mm)
                                $scheduledAtVal = old('scheduled_at', $assignment->scheduled_at ? $assignment->scheduled_at->format('Y-m-d\TH:i') : '');
                            @endphp
                            <input type="hidden" name="scheduled_at" id="scheduled-at-input" value="{{ $scheduledAtVal }}">

                            <button type="submit" id="submit-btn" class="inline-flex items-center justify-center px-7 py-3.5 bg-slate-900 text-white font-bold text-[15px] rounded-l-2xl hover:bg-indigo-600 transition-all duration-200 hover:shadow-lg">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                <span id="submit-label">Simpan Perubahan</span>
                            </button>

                            <div class="w-px bg-slate-700 self-stretch"></div>

                            <button type="button" id="schedule-toggle-btn" onclick="toggleSchedulePopup()" class="px-4 bg-slate-900 hover:bg-indigo-600 text-white rounded-r-2xl transition-all duration-200 hover:shadow-lg flex items-center" aria-label="Jadwalkan">
                                <svg id="schedule-arrow" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                            </button>

                            {{-- Schedule Popup --}}
                            <div id="schedule-popup" class="hidden absolute right-0 bottom-full mb-3 w-72 bg-white rounded-[20px] shadow-xl border border-slate-200/80 dark:border-white/10 p-5 z-50">
                                <p class="text-[13px] font-bold text-slate-700 mb-1">Jadwalkan Rilis Tugas</p>
                                <p class="text-[12px] text-slate-400 mb-4">Tugas akan tersedia untuk siswa mulai tanggal & waktu ini.</p>
                                <input type="datetime-local" id="schedule-datetime-picker"
                                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-[14px] text-slate-800 focus:border-indigo-400 focus:ring-0 transition-colors mb-3"
                                    value="{{ $scheduledAtVal }}"
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
    document.addEventListener("DOMContentLoaded", function() {
        const quill = new Quill('#quill-editor', {
            theme: 'snow',
            modules: { toolbar: '#quill-toolbar' },
            placeholder: 'Tulis instruksi atau soal penugasan di sini…',
        });

        window.prepareFormSubmit = function(event) {
            document.getElementById('description-hidden').value = quill.root.innerHTML === '<p><br></p>' ? '' : quill.root.innerHTML;
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
            // Di halaman edit, bisa menggunakan label 'Perbarui'
            document.getElementById('submit-label').textContent = val ? 'Jadwalkan Pembaruan' : 'Simpan Perubahan';
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
