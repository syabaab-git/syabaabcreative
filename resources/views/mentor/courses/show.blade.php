<x-app-layout disable-animation="true" content-padding="pt-0">
    @php
        $totalMinutes = $course->lessons->sum('duration_minutes');
        $hours = floor($totalMinutes / 60);
        $minutes = $totalMinutes % 60;
        $timeString = $hours > 0 ? "{$hours} Jam" . ($minutes > 0 ? " {$minutes} Mnt" : "") : "{$minutes} Menit";
        
        // Memastikan selalu ada materi yang tertampil secara default
        $activeLesson = $activeLesson ?? $course->lessons->first();

        // Menggunakan variabel file dari controller

    @endphp

    <div class="bg-[#f8fafc] min-h-screen" x-data="{ 
        activeTab: '{{ $activeAssignment ? 'assessments' : 'curriculum' }}', 
        showContent: false,
        searchQuery: '',
        showSearch: false,
        showFileModal: false
    }" x-init="setTimeout(() => showContent = true, 50)">
        
        <div class="max-w-[1600px] mx-auto pt-[125px] px-4 sm:px-6 lg:px-8 pb-20">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <div class="lg:col-span-3 lg:sticky lg:top-[125px] flex flex-col gap-6">
                        <nav class="flex flex-col gap-2 bg-white dark:bg-[#1c1c1e] p-2.5 rounded-[24px] shadow-sm border border-slate-200/80 dark:border-white/10">
                            <!-- Kurikulum Tab -->
                            <button @click="activeTab = 'curriculum'" 
                                    :class="activeTab === 'curriculum' ? 'bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/20 shadow-[0_2px_10px_-3px_rgba(59,130,246,0.15)]' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white border border-transparent'"
                                    class="group flex items-center justify-between px-4 py-2.5 rounded-xl font-bold text-[13px] transition-all duration-300 text-left">
                                <div class="flex items-center gap-3">
                                    <div class="p-1.5 rounded-lg transition-colors" :class="activeTab === 'curriculum' ? 'bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400' : 'bg-transparent text-slate-400 dark:text-slate-500 group-hover:bg-slate-100 dark:group-hover:bg-white/5 group-hover:text-slate-700 dark:group-hover:text-slate-300'">
                                        <svg class="w-4 h-4 transition-transform group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" /></svg>
                                    </div>
                                    <span>Kurikulum</span>
                                </div>
                                <span class="px-2 py-0.5 rounded-md text-[11px] font-bold shadow-sm transition-all" :class="activeTab === 'curriculum' ? 'bg-blue-100/80 dark:bg-blue-500/25 text-blue-600 dark:text-blue-300 border border-blue-100 dark:border-blue-500/10' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-transparent'">{{ $course->lessons->count() + $course->assignments->count() }}</span>
                            </button>
                            
                            <!-- Siswa Tab -->
                            <button @click="activeTab = 'students'" 
                                    :class="activeTab === 'students' ? 'bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/20 shadow-[0_2px_10px_-3px_rgba(59,130,246,0.15)]' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white border border-transparent'"
                                    class="group flex items-center justify-between px-4 py-2.5 rounded-xl font-bold text-[13px] transition-all duration-300 text-left">
                                <div class="flex items-center gap-3">
                                    <div class="p-1.5 rounded-lg transition-colors" :class="activeTab === 'students' ? 'bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400' : 'bg-transparent text-slate-400 dark:text-slate-500 group-hover:bg-slate-100 dark:group-hover:bg-white/5 group-hover:text-slate-700 dark:group-hover:text-slate-300'">
                                        <svg class="w-4 h-4 transition-transform group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20"><path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" /></svg>
                                    </div>
                                    <span>Siswa</span>
                                </div>
                                <span class="px-2 py-0.5 rounded-md text-[11px] font-bold shadow-sm transition-all" :class="activeTab === 'students' ? 'bg-blue-100/80 dark:bg-blue-500/25 text-blue-600 dark:text-blue-300 border border-blue-100 dark:border-blue-500/10' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-transparent'">{{ $course->enrollments->count() }}</span>
                            </button>
 
                            <!-- Penilaian Tab -->
                            <button @click="activeTab = 'assessments'" 
                                    :class="activeTab === 'assessments' ? 'bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/20 shadow-[0_2px_10px_-3px_rgba(59,130,246,0.15)]' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white border border-transparent'"
                                    class="group flex items-center justify-between px-4 py-2.5 rounded-xl font-bold text-[13px] transition-all duration-300 text-left">
                                <div class="flex items-center gap-3">
                                    <div class="p-1.5 rounded-lg transition-colors" :class="activeTab === 'assessments' ? 'bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400' : 'bg-transparent text-slate-400 dark:text-slate-500 group-hover:bg-slate-100 dark:group-hover:bg-white/5 group-hover:text-slate-700 dark:group-hover:text-slate-300'">
                                        <svg class="w-4 h-4 transition-transform group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.9L10 1.154l7.834 3.746A1 1 0 0118.5 5.8v4.962a9.004 9.004 0 01-5.191 8.16l-3 1.44a1 1 0 01-.618 0l-3-1.44A9.004 9.004 0 011.5 10.762V5.8a1 1 0 01.666-.9zM10 12.586l3.293-3.293a1 1 0 011.414 1.414l-4 4a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L10 12.586z" clip-rule="evenodd" /></svg>
                                    </div>
                                    <span>Penilaian</span>
                                </div>
                            </button>
 
                            <!-- File Pendukung Tab -->
                            <button @click="activeTab = 'files'" 
                                    :class="activeTab === 'files' ? 'bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/20 shadow-[0_2px_10px_-3px_rgba(59,130,246,0.15)]' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white border border-transparent'"
                                    class="group flex items-center justify-between px-4 py-2.5 rounded-xl font-bold text-[13px] transition-all duration-300 text-left">
                                <div class="flex items-center gap-3">
                                    <div class="p-1.5 rounded-lg transition-colors" :class="activeTab === 'files' ? 'bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400' : 'bg-transparent text-slate-400 dark:text-slate-500 group-hover:bg-slate-100 dark:group-hover:bg-white/5 group-hover:text-slate-700 dark:group-hover:text-slate-300'">
                                        <svg class="w-4 h-4 transition-transform group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20"><path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" /></svg>
                                    </div>
                                    <span>File Pendukung</span>
                                </div>
                            </button>
                        </nav>

                        <div class="relative group rounded-[24px] bg-white dark:bg-slate-900 border border-slate-200/60 dark:border-slate-800/80 p-5 shadow-sm transition-all duration-300 hover:shadow-md overflow-hidden">
                            <!-- Blended background image on the right -->
                            <div class="absolute right-0 top-0 bottom-0 w-1/2 z-0 overflow-hidden pointer-events-none select-none">
                                <img src="{{ Storage::url($course->thumbnail) }}" class="w-full h-full object-cover opacity-25 dark:opacity-35 transition-transform duration-700 group-hover:scale-105">
                                <div class="absolute inset-0 bg-gradient-to-r from-white via-white/60 to-transparent dark:from-slate-900 dark:via-slate-900/65"></div>
                            </div>

                            <div class="relative z-10">
                                <div class="flex flex-wrap items-center gap-1.5 mb-2">
                                    <span class="px-2 py-0.5 bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 text-[9px] font-black uppercase tracking-wider rounded-md border border-indigo-100/50 dark:border-indigo-900/30">{{ $course->category->name }}</span>
                                    @if($course->is_published)
                                        <span class="px-2 py-0.5 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 text-[9px] font-black uppercase tracking-wider rounded-md border border-emerald-100/50 dark:border-emerald-900/30">Published</span>
                                    @else
                                        <span class="px-2 py-0.5 bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 text-[9px] font-black uppercase tracking-wider rounded-md border border-amber-100/50 dark:border-amber-900/30">Draft</span>
                                    @endif
                                </div>
                                
                                <h3 class="text-[13px] font-black text-slate-800 dark:text-slate-100 leading-tight mb-4" title="{{ $course->title }}">{{ $course->title }}</h3>
                                
                                <div class="flex flex-col gap-2.5 pt-3 border-t border-slate-100 dark:border-slate-800/80">
                                    <!-- Stats Row -->
                                    <div class="flex flex-wrap items-center gap-y-2 gap-x-4 text-slate-600 dark:text-slate-400">
                                        <div class="flex items-center gap-1.5 text-[11px] font-bold">
                                            <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                            </svg>
                                            <span>{{ $course->enrollments->count() }} Siswa</span>
                                        </div>
                                        <div class="hidden sm:block w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-750"></div>
                                        <div class="flex items-center gap-1.5 text-[11px] font-bold">
                                            <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                                            </svg>
                                            <span>{{ $course->lessons->count() }} Materi</span>
                                        </div>
                                        <div class="hidden sm:block w-1 h-1 rounded-full bg-slate-300 dark:bg-slate-750"></div>
                                        <div class="flex items-center gap-1.5 text-[11px] font-bold">
                                            <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                            </svg>
                                            <span>{{ $timeString }}</span>
                                        </div>
                                    </div>

                                    <!-- Mentor Info -->
                                    <div class="flex items-center gap-2 mt-0.5">
                                        @if($course->mentor->avatar)
                                            <img src="{{ Storage::url($course->mentor->avatar) }}" class="w-5 h-5 rounded-full object-cover border border-slate-100 dark:border-slate-800 shadow-sm">
                                        @else
                                            <div class="w-5 h-5 rounded-full bg-indigo-100 dark:bg-indigo-955/60 text-indigo-700 dark:text-indigo-400 flex items-center justify-center font-black text-[9px] border border-indigo-200/20 dark:border-indigo-800/30">
                                                {{ substr($course->mentor->name, 0, 1) }}
                                            </div>
                                        @endif
                                        <span class="text-[10.5px] font-bold text-slate-500 dark:text-slate-400">Oleh <span class="text-slate-700 dark:text-slate-200 font-black">{{ $course->mentor->name }}</span></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit button (pencil icon) in top right -->
                            <a href="{{ route('mentor.courses.edit', $course) }}" class="absolute top-4 right-4 z-20 w-8 h-8 flex items-center justify-center bg-slate-50 dark:bg-slate-850 hover:bg-indigo-600 dark:hover:bg-indigo-500 hover:text-white border border-slate-200/50 dark:border-slate-800/60 rounded-xl text-slate-400 dark:text-slate-500 transition-all shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </a>
                        </div>
                </div>

                <div class="lg:col-span-6 min-w-0">
                    
                    <div class="w-full"
                         x-show="showContent" 
                         x-transition:enter="transition ease-out duration-700 transform"
                         x-transition:enter-start="opacity-0 translate-y-8"
                         x-transition:enter-end="opacity-100 translate-y-0">

                        <div x-show="activeTab === 'curriculum'" style="display: none;">
                            @if($activeLesson)
                                @php
                                    $rawLinks = $activeLesson->links ?? [];
                                    $lessonLinks = is_string($rawLinks) ? (json_decode($rawLinks, true) ?? []) : (is_array($rawLinks) ? $rawLinks : []);
                                    
                                    $rawAttachments = $activeLesson->attachments ?? [];
                                    $lessonAttachments = is_string($rawAttachments) ? (json_decode($rawAttachments, true) ?? []) : (is_array($rawAttachments) ? $rawAttachments : []);
                                    
                                    $videoLink = collect($lessonLinks)->filter(fn($l) => is_array($l) && preg_match('/youtube|youtu\.be|vimeo|dailymotion/i', $l['url'] ?? ''))->first();
                                    $otherLinks = collect($lessonLinks)->reject(fn($l) => is_array($l) && preg_match('/youtube|youtu\.be|vimeo|dailymotion/i', $l['url'] ?? ''));
                                @endphp
                                
                                <div class="bg-white rounded-t-[32px] border-x border-t border-slate-200/60 dark:border-white/10 overflow-hidden shadow-sm">
                                    <div class="px-8 py-4 bg-slate-50/50 border-b border-slate-100 flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <span class="px-2.5 py-1 bg-indigo-50 text-indigo-600 text-[9px] font-black uppercase tracking-wider rounded-lg border border-indigo-100">Modul {{ $course->lessons->search(fn($l) => $l->id === $activeLesson->id) + 1 }} dari {{ $course->lessons->count() }}</span>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <div class="flex items-center gap-1.5 text-slate-400">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                <span class="text-[9px] font-black uppercase tracking-widest">{{ $activeLesson->duration_minutes }} Min</span>
                                            </div>
                                            <div class="h-4 w-px bg-slate-200"></div>
                                            <div class="flex items-center gap-1.5">
                                                <a href="{{ route('mentor.courses.lessons.edit', [$course, $activeLesson]) }}" title="Edit Materi" class="w-7 h-7 flex items-center justify-center rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-400 dark:text-slate-500 hover:text-indigo-600 dark:hover:text-indigo-400 hover:border-indigo-300 dark:hover:border-indigo-500/30 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 transition-all shadow-sm">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2.5 2.5 0 113.536 3.536L12 20.414H8v-4.414L18.586 2.586z"></path></svg>
                                                </a>
                                                <button @click="$dispatch('open-confirm', { message: '{{ $activeLesson->is_archived ? 'Pulihkan materi ini?' : 'Arsipkan materi ini?' }}', url: '{{ route('mentor.courses.lessons.archive', [$course, $activeLesson]) }}', method: 'PATCH', type: 'warning' })" title="{{ $activeLesson->is_archived ? 'Pulihkan' : 'Arsipkan' }}" class="w-7 h-7 flex items-center justify-center rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-400 dark:text-slate-500 hover:text-amber-600 dark:hover:text-amber-400 hover:border-amber-300 dark:hover:border-amber-500/30 hover:bg-amber-50 dark:hover:bg-amber-500/10 transition-all shadow-sm">
                                                    @if($activeLesson->is_archived)
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                                    @else
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 8h14M5 8a2 2 0 110 4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                                    @endif
                                                </button>
                                                <button @click="$dispatch('open-confirm', { message: 'Apakah Anda yakin ingin menghapus materi ini secara permanen?', url: '{{ route('mentor.courses.lessons.destroy', [$course, $activeLesson]) }}', method: 'DELETE', type: 'danger' })" title="Hapus Materi" class="w-7 h-7 flex items-center justify-center rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-400 dark:text-slate-500 hover:text-red-600 dark:hover:text-red-400 hover:border-red-300 dark:hover:border-red-500/30 hover:bg-red-50 dark:hover:bg-red-500/10 transition-all shadow-sm">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    @if($videoLink)
                                        <div class="aspect-video bg-black w-full relative">
                                            @php
                                                $url = $videoLink['url'];
                                                $embedUrl = '';
                                                if (str_contains($url, 'youtube.com/watch?v=')) {
                                                    $id = explode('v=', $url)[1];
                                                    $id = explode('&', $id)[0];
                                                    $embedUrl = "https://www.youtube.com/embed/{$id}";
                                                } elseif (str_contains($url, 'youtu.be/')) {
                                                    $id = explode('youtu.be/', $url)[1];
                                                    $embedUrl = "https://www.youtube.com/embed/{$id}";
                                                }
                                            @endphp
                                            @if($embedUrl)
                                                <iframe class="absolute inset-0 w-full h-full" src="{{ $embedUrl }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-white p-10 text-center">
                                                    <a href="{{ $url }}" target="_blank" class="text-indigo-400 font-bold hover:underline italic">Tonton Video di Tab Baru &rarr;</a>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <div class="bg-white rounded-b-[32px] p-8 md:p-12 border-x border-b border-slate-200/60 dark:border-white/10 shadow-sm overflow-x-auto">
                                    <div class="mb-8">
                                        <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight leading-tight">{{ $activeLesson->title }}</h1>
                                    </div>

                                    @if($activeLesson->description)
                                        <div class="relative bg-slate-50 rounded-2xl p-6 mb-8 border border-slate-100">
                                            <p class="text-[15px] font-bold text-slate-600 leading-relaxed italic">"{{ $activeLesson->description }}"</p>
                                        </div>
                                    @endif

                                    <div class="prose prose-slate max-w-none break-words tinymce-wrapper">
                                        {!! $activeLesson->body !!}
                                    </div>

                                    <div class="mt-12 pt-8 border-t border-slate-100">
                                        @if($otherLinks->count() > 0 || count($lessonAttachments) > 0)
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                                @if($otherLinks->count() > 0)
                                                    <div class="space-y-3">
                                                        <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Tautan Terkait</h4>
                                                        <div class="flex flex-col gap-2">
                                                            @foreach($otherLinks as $link)
                                                                <a href="{{ is_array($link) ? $link['url'] : $link }}" target="_blank" class="group flex items-center gap-3 p-3 rounded-2xl border border-transparent hover:border-slate-200 hover:bg-slate-50 transition-all">
                                                                    <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 group-hover:text-indigo-600 group-hover:border-indigo-200 shadow-sm transition-all shrink-0">
                                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                                                    </div>
                                                                    <div class="flex-1 min-w-0">
                                                                        <h4 class="text-[13px] font-bold text-slate-700 group-hover:text-indigo-700 truncate leading-tight">{{ is_array($link) ? ($link['label'] ?? 'Tautan Referensi') : 'Tautan Referensi' }}</h4>
                                                                        <p class="text-[10px] font-medium text-slate-400 truncate mt-0.5">{{ is_array($link) ? $link['url'] : $link }}</p>
                                                                    </div>
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif

                                                @if(count($lessonAttachments) > 0)
                                                    <div class="space-y-3">
                                                        <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Lampiran Materi</h4>
                                                        <div class="flex flex-col gap-2">
                                                            @foreach($lessonAttachments as $file)
                                                                <a href="{{ Storage::url($file['path']) }}" target="_blank" class="group flex items-center gap-3 p-3 rounded-2xl border border-transparent hover:border-slate-200 hover:bg-slate-50 transition-all">
                                                                    <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 group-hover:text-emerald-600 group-hover:border-emerald-200 shadow-sm transition-all shrink-0">
                                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                                    </div>
                                                                    <div class="flex-1 min-w-0">
                                                                        <h4 class="text-[13px] font-bold text-slate-700 group-hover:text-emerald-700 truncate leading-tight">{{ $file['name'] ?? 'Dokumen' }}</h4>
                                                                        <p class="text-[10px] font-medium text-slate-400 uppercase tracking-widest mt-0.5">{{ isset($file['size']) ? number_format($file['size'] / 1024, 1) . ' KB' : 'FILE' }}</p>
                                                                    </div>
                                                                </a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <div x-show="!activeLesson && activeTab === 'curriculum'" style="display: none;" class="bg-white rounded-[32px] border border-slate-200/60 dark:border-white/10 overflow-hidden shadow-sm p-20 text-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 mx-auto mb-6">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <h3 class="text-xl font-black text-slate-800 tracking-tight">Belum Ada Materi</h3>
                            <p class="text-slate-500 mt-2 max-w-sm mx-auto font-medium italic">Silakan tekan tombol <span class="font-bold text-indigo-600">+</span> pada widget Daftar Modul di sebelah kanan untuk menambahkan materi pembelajaran Anda.</p>
                        </div>

                        <div x-show="activeTab === 'students'" style="display: none;" class="bg-white dark:bg-slate-900 rounded-[24px] border border-slate-200/60 dark:border-slate-800/80 overflow-hidden shadow-sm">
                            <div class="px-8 py-5 bg-slate-50/50 dark:bg-slate-900/50 border-b border-slate-100 dark:border-slate-800/80 flex items-center justify-between">
                                <h2 class="text-lg font-black text-slate-900 dark:text-slate-100 tracking-tight">Siswa Terdaftar</h2>
                                <span class="px-3 py-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ $course->enrollments->count() }} Orang</span>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-left">
                                    <thead>
                                        <tr class="bg-slate-50/30 dark:bg-slate-850/10">
                                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Siswa</th>
                                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Bergabung</th>
                                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Progres</th>
                                            <th class="px-8 py-4 text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest text-right">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80">
                                        @forelse($course->enrollments as $enrollment)
                                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors group">
                                                <td class="px-8 py-5">
                                                    <div class="flex items-center gap-4">
                                                        <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-955/40 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-black text-xs border border-indigo-100/50 dark:border-indigo-900/30 group-hover:scale-105 transition-transform">
                                                            {{ substr($enrollment->user->name, 0, 2) }}
                                                        </div>
                                                        <div>
                                                            <p class="text-[14px] font-black text-slate-800 dark:text-slate-100">{{ $enrollment->user->name }}</p>
                                                            <p class="text-[11px] font-bold text-slate-400 dark:text-slate-500">{{ $enrollment->user->email }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-8 py-5 text-[13px] font-bold text-slate-600 dark:text-slate-400">
                                                    {{ $enrollment->created_at->format('d M Y') }}
                                                </td>
                                                <td class="px-8 py-5">
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-24 h-1.5 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                                                            <div class="h-full rounded-full transition-all duration-1000 {{ $enrollment->progress >= 100 ? 'bg-emerald-500' : 'bg-indigo-600' }}" style="width: {{ $enrollment->progress }}%"></div>
                                                        </div>
                                                        <span class="text-[11px] font-black {{ $enrollment->progress >= 100 ? 'text-emerald-600 dark:text-emerald-450' : 'text-slate-800 dark:text-slate-200' }}">{{ $enrollment->progress }}%</span>
                                                    </div>
                                                </td>
                                                <td class="px-8 py-5 text-right">
                                                    @if($enrollment->progress >= 100)
                                                        <span class="px-2.5 py-1 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 text-[9px] font-black uppercase tracking-widest rounded-lg border border-emerald-100/50 dark:border-emerald-900/30">Lulus</span>
                                                    @elseif($enrollment->progress > 0)
                                                        <span class="px-2.5 py-1 bg-indigo-50 dark:bg-indigo-955/40 text-indigo-600 dark:text-indigo-400 text-[9px] font-black uppercase tracking-widest rounded-lg border border-indigo-100/50 dark:border-indigo-900/30">Aktif</span>
                                                    @else
                                                        <span class="px-2.5 py-1 bg-slate-100 dark:bg-slate-800/60 text-slate-400 dark:text-slate-500 text-[9px] font-black uppercase tracking-widest rounded-lg border border-slate-200 dark:border-slate-700/50">Baru</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-8 py-16 text-center text-slate-400 dark:text-slate-500 font-bold text-sm italic">Belum ada siswa yang bergabung.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div x-show="activeTab === 'assessments'" style="display: none;" class="space-y-6">
                            @if($activeAssignment)
                                <div class="bg-white dark:bg-slate-900 rounded-[24px] border border-slate-200/60 dark:border-slate-800/80 overflow-hidden shadow-sm">
                                    {{-- ── Header Tugas ── --}}
                                    <div class="px-8 py-5 bg-slate-50/50 dark:bg-slate-900/50 border-b border-slate-100 dark:border-slate-800/80 flex items-center justify-between">
                                         <div class="flex items-center gap-2">
                                             <span class="px-2.5 py-1 bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 text-[9px] font-black uppercase tracking-wider rounded-lg border border-indigo-100/50 dark:border-indigo-900/30">Tugas {{ $course->assignments->search(fn($a) => $a->id === $activeAssignment->id) + 1 }} dari {{ $course->assignments->count() }}</span>
                                             @if($activeAssignment->scheduled_at)
                                                 <span class="px-2.5 py-1 bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 text-[9px] font-black uppercase tracking-wider rounded-lg border border-amber-100/50 dark:border-amber-900/30">Dijadwalkan: {{ \Carbon\Carbon::parse($activeAssignment->scheduled_at)->isoFormat('D MMM Y') }}</span>
                                             @endif
                                             @if($activeAssignment->is_archived)
                                                 <span class="px-2.5 py-1 bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 text-[9px] font-black uppercase tracking-wider rounded-lg border border-amber-100/50 dark:border-amber-900/30">Diarsipkan</span>
                                             @endif
                                         </div>
                                         <div class="flex items-center gap-1.5">
                                             <a href="{{ route('mentor.courses.assignments.edit', [$course, $activeAssignment]) }}" title="Edit Tugas" class="w-7 h-7 flex items-center justify-center rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-400 dark:text-slate-500 hover:text-indigo-600 dark:hover:text-indigo-400 hover:border-indigo-300 dark:hover:border-indigo-500/30 hover:bg-indigo-50 dark:hover:bg-indigo-500/10 transition-all shadow-sm">
                                                 <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2.5 2.5 0 113.536 3.536L12 20.414H8v-4.414L18.586 2.586z"></path></svg>
                                             </a>
                                             <button @click="$dispatch('open-confirm', { message: '{{ $activeAssignment->is_archived ? 'Pulihkan tugas ini?' : 'Arsipkan tugas ini?' }}', url: '{{ route('mentor.courses.assignments.archive', [$course, $activeAssignment]) }}', method: 'PATCH', type: 'warning' })" title="{{ $activeAssignment->is_archived ? 'Pulihkan' : 'Arsipkan' }}" class="w-7 h-7 flex items-center justify-center rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-400 dark:text-slate-500 hover:text-amber-600 dark:hover:text-amber-400 hover:border-amber-300 dark:hover:border-amber-500/30 hover:bg-amber-50 dark:hover:bg-amber-500/10 transition-all shadow-sm">
                                                 @if($activeAssignment->is_archived)
                                                     <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                                 @else
                                                     <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 8h14M5 8a2 2 0 110 4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                                                 @endif
                                             </button>
                                             <button @click="$dispatch('open-confirm', { message: 'Hapus tugas ini secara permanen?', url: '{{ route('mentor.courses.assignments.destroy', [$course, $activeAssignment]) }}', method: 'DELETE', type: 'danger' })" title="Hapus Tugas" class="w-7 h-7 flex items-center justify-center rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-400 dark:text-slate-500 hover:text-red-600 dark:hover:text-red-400 hover:border-red-300 dark:hover:border-red-500/30 hover:bg-red-50 dark:hover:bg-red-500/10 transition-all shadow-sm">
                                                 <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                             </button>
                                         </div>
                                     </div>

                                    {{-- ── Body Tugas ── --}}
                                    <div class="p-8 md:p-12 overflow-x-auto">
                                        {{-- Judul & Keterangan --}}
                                        <div class="mb-8">
                                            <h1 class="text-3xl md:text-4xl font-black text-slate-900 dark:text-slate-100 tracking-tight leading-tight">{{ $activeAssignment->title }}</h1>
                                        </div>

                                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-8">
                                            <div class="bg-slate-50 dark:bg-slate-900/50 rounded-2xl p-4 border border-slate-100 dark:border-slate-800/80">
                                                <p class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Nilai Lulus</p>
                                                <p class="text-[22px] font-black text-indigo-600 dark:text-indigo-400 leading-none">{{ $activeAssignment->passing_score }}<span class="text-[13px] text-slate-400 dark:text-slate-500">/100</span></p>
                                            </div>
                                            <div class="bg-slate-50 dark:bg-slate-900/50 rounded-2xl p-4 border border-slate-100 dark:border-slate-800/80">
                                                <p class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Mengumpulkan</p>
                                                <p class="text-[22px] font-black text-slate-800 dark:text-slate-100 leading-none">{{ $activeAssignment->submissions->count() }}</p>
                                            </div>
                                            <div class="bg-slate-50 dark:bg-slate-900/50 rounded-2xl p-4 border border-slate-100 dark:border-slate-800/80">
                                                <p class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Sudah Dinilai</p>
                                                <p class="text-[22px] font-black text-emerald-600 dark:text-emerald-450 leading-none">{{ $activeAssignment->submissions->where('status', 'graded')->count() }}</p>
                                            </div>
                                        </div>

                                        @if($activeAssignment->description)
                                            <div class="bg-slate-50 dark:bg-slate-900/50 rounded-2xl p-6 mb-8 border border-slate-100 dark:border-slate-800/80">
                                                <p class="text-[11px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-3">Deskripsi Tugas</p>
                                                <div class="prose prose-slate dark:prose-invert max-w-none text-[14px] leading-relaxed">
                                                    {!! $activeAssignment->description !!}
                                                </div>
                                            </div>
                                        @endif

                                        {{-- ── Daftar Submission Siswa ── --}}
                                        <div class="mt-8 pt-8 border-t border-slate-100 dark:border-slate-800/80">
                                            <div class="flex items-center justify-between mb-5">
                                                <h3 class="text-[15px] font-black text-slate-800 dark:text-slate-100">Kiriman Siswa</h3>
                                                <span class="px-3 py-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">{{ $activeAssignment->submissions->count() }} Kiriman</span>
                                            </div>

                                            @forelse($activeAssignment->submissions as $submission)
                                                @php
                                                    $isGraded = $submission->status === 'graded';
                                                    $isPassed = $isGraded && $submission->score >= $activeAssignment->passing_score;
                                                @endphp
                                                <div class="group flex flex-col sm:flex-row sm:items-center justify-between gap-4 p-5 rounded-2xl border {{ $isGraded ? 'border-slate-200 dark:border-slate-800 hover:border-indigo-200 dark:hover:border-indigo-900' : 'border-amber-100 dark:border-amber-900/30 bg-amber-50/30 dark:bg-amber-950/10 hover:border-amber-300' }} transition-all mb-3">
                                                    <div class="flex items-center gap-4">
                                                        {{-- Avatar --}}
                                                        <div class="shrink-0 w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 flex items-center justify-center font-black text-xs border border-indigo-100/50 dark:border-indigo-900/30 group-hover:scale-105 transition-transform">
                                                            @if($submission->user->avatar)
                                                                <img src="{{ Storage::url($submission->user->avatar) }}" class="w-full h-full rounded-xl object-cover" alt="">
                                                            @else
                                                                {{ substr($submission->user->name, 0, 2) }}
                                                            @endif
                                                        </div>
                                                        {{-- Info siswa --}}
                                                        <div class="min-w-0">
                                                            <p class="text-[14px] font-black text-slate-800 dark:text-slate-100">{{ $submission->user->name }}</p>
                                                            <p class="text-[11px] font-bold text-slate-400 dark:text-slate-500">Dikumpulkan {{ $submission->created_at->isoFormat('D MMM Y, HH:mm') }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="flex items-center gap-3 flex-shrink-0">
                                                        {{-- File unggahan --}}
                                                        @if($submission->file_path)
                                                            <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank"
                                                               class="flex items-center gap-1.5 px-3 py-1.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-400 text-[11px] font-bold rounded-lg hover:border-indigo-300 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all shadow-sm">
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                                File
                                                            </a>
                                                        @endif

                                                        {{-- Nilai --}}
                                                        @if($isGraded)
                                                            <span class="px-3 py-1.5 text-[12px] font-black rounded-lg border {{ $isPassed ? 'bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 border-emerald-100/50 dark:border-emerald-900/30' : 'bg-red-50 dark:bg-red-955/20 text-red-600 dark:text-red-400 border-red-100/50 dark:border-red-900/30' }}">
                                                                {{ $submission->score }}
                                                            </span>
                                                        @else
                                                            <span class="px-3 py-1.5 text-[10px] font-black bg-amber-50 dark:bg-amber-955/40 text-amber-600 dark:text-amber-400 border border-amber-100/50 dark:border-amber-900/30 rounded-lg uppercase tracking-widest">
                                                                Belum Dinilai
                                                            </span>
                                                        @endif

                                                        {{-- Tombol tinjau --}}
                                                        <a href="{{ route('mentor.assignments.submissions.show', [$activeAssignment, $submission]) }}"
                                                           class="flex items-center gap-1.5 px-4 py-2 bg-indigo-600 text-white text-[11px] font-black rounded-xl hover:bg-indigo-700 transition-all shadow-sm">
                                                            Tinjau
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            @empty
                                                <div class="text-center py-12 bg-slate-50 dark:bg-slate-900/50 rounded-2xl border border-dashed border-slate-200 dark:border-slate-800">
                                                    <p class="text-slate-400 dark:text-slate-500 font-bold text-sm">Belum ada siswa yang mengumpulkan tugas ini.</p>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            @elseif($course->assignments->count() > 0)
                                {{-- Ada tugas tapi belum dipilih --}}
                                <div class="bg-white rounded-[32px] border border-slate-200/60 dark:border-white/10 overflow-hidden shadow-sm">
                                    <div class="px-8 py-5 bg-slate-50/50 border-b border-slate-100">
                                        <h2 class="text-lg font-black text-slate-900 tracking-tight">Penilaian & Tugas</h2>
                                    </div>
                                    <div class="p-16 text-center">
                                        <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-400 mx-auto mb-5">
                                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                        </div>
                                        <h4 class="text-lg font-black text-slate-800 tracking-tight">Pilih Tugas</h4>
                                        <p class="text-[13px] font-medium text-slate-500 mt-2">Klik salah satu tugas di panel kanan untuk melihat detail dan daftar kiriman siswa.</p>
                                    </div>
                                </div>
                            @else
                                {{-- Belum ada tugas sama sekali --}}
                                <div class="bg-white rounded-[32px] border border-slate-200/60 dark:border-white/10 overflow-hidden shadow-sm">
                                    <div class="px-8 py-5 bg-slate-50/50 border-b border-slate-100">
                                        <h2 class="text-lg font-black text-slate-900 tracking-tight">Penilaian & Tugas</h2>
                                    </div>
                                    <div class="p-20 text-center bg-white">
                                        <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 mx-auto mb-6">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                                        </div>
                                        <h4 class="text-xl font-black text-slate-800 tracking-tight">Belum Ada Tugas</h4>
                                        <p class="text-[14px] font-bold text-slate-500 mt-2 max-w-sm mx-auto leading-relaxed italic">Tekan tombol <span class="font-bold text-indigo-600">+</span> pada panel kanan untuk menambahkan tugas baru.</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div x-show="activeTab === 'files'" style="display: none;" class="bg-white rounded-[32px] border border-slate-200/60 dark:border-white/10 overflow-hidden shadow-sm">
                            <div class="px-8 py-5 bg-slate-50/50 border-b border-slate-100 flex items-center justify-between">
                                <h2 class="text-lg font-black text-slate-900 tracking-tight">File Pendukung Kursus</h2>
                                <span class="px-3 py-1 bg-white border border-slate-200 rounded-lg text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ $courseFiles->count() + $globalFiles->count() }} File</span>
                            </div>

                            {{-- Upload Form --}}
                            <div class="px-8 py-6 border-b border-slate-100 bg-slate-50/30">
                                <form action="{{ route('mentor.courses.files.store', $course) }}" method="POST" enctype="multipart/form-data"
                                      x-data="{ fileName: '' }">
                                    @csrf
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                        <div class="sm:col-span-1">
                                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Nama File</label>
                                            <input type="text" name="name" required placeholder="Misal: Modul PDF Ch.1" class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-[13px] font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Tipe</label>
                                            <select name="scope" required class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-[13px] font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-400 transition-all appearance-none cursor-pointer">
                                                <option value="course">Khusus Kelas Ini</option>
                                                <option value="global">Global (Semua Kelas)</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">File</label>
                                            <div class="relative">
                                                <input type="file" name="file" required @change="fileName = $event.target.files[0]?.name || ''" class="absolute inset-0 opacity-0 cursor-pointer z-10 w-full h-full">
                                                <div class="flex items-center gap-2 px-3 py-2.5 bg-white border border-slate-200 rounded-xl cursor-pointer hover:border-indigo-300 transition-all">
                                                    <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                                    <span class="text-[11px] font-bold truncate" :class="fileName ? 'text-indigo-600' : 'text-slate-400'" x-text="fileName || 'Pilih file...'"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-end mt-4">
                                        <button type="submit" class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white text-[11px] font-black rounded-xl hover:bg-indigo-700 transition-all shadow-sm uppercase tracking-widest">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                            Unggah
                                        </button>
                                    </div>
                                </form>
                            </div>

                            {{-- Daftar file --}}
                            @php
                                $allFiles = $courseFiles->merge($globalFiles)->sortByDesc('created_at');
                            @endphp

                            @if($allFiles->isEmpty())
                                <div class="p-16 text-center">
                                    <div class="w-14 h-14 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-300 mx-auto mb-5">
                                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                                    </div>
                                    <h4 class="text-[15px] font-black text-slate-700">Belum Ada File</h4>
                                    <p class="text-[12px] text-slate-400 mt-1">Gunakan form di atas untuk mengunggah file pendukung.</p>
                                </div>
                            @else
                                {{-- Grouped: Kelas Ini + Global --}}
                                @foreach([['label' => 'Khusus Kelas Ini', 'color' => 'indigo', 'items' => $courseFiles], ['label' => 'Global', 'color' => 'emerald', 'items' => $globalFiles]] as $group)
                                    @if($group['items']->isNotEmpty())
                                        <div class="px-8 pt-7 pb-3">
                                            <div class="flex items-center gap-2 mb-4">
                                                <div class="w-8 h-8 rounded-xl bg-{{ $group['color'] }}-50 text-{{ $group['color'] }}-600 flex items-center justify-center border border-{{ $group['color'] }}-100">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                                                </div>
                                                <div>
                                                    <h4 class="text-[13px] font-black text-slate-800">{{ $group['label'] }}</h4>
                                                    <p class="text-[10px] font-bold text-slate-400">{{ $group['items']->count() }} file</p>
                                                </div>
                                            </div>
                                            <div class="space-y-2">
                                                @foreach($group['items'] as $courseFile)
                                                    <div class="group flex items-center justify-between p-4 rounded-2xl border border-slate-100 hover:border-{{ $group['color'] }}-200 hover:bg-{{ $group['color'] }}-50/30 transition-all">
                                                        <div class="flex items-center gap-3 min-w-0">
                                                            @php
                                                                $ext = strtolower(pathinfo($courseFile->file_path, PATHINFO_EXTENSION));
                                                                $iconColor = match($ext) {
                                                                    'pdf' => 'text-red-500',
                                                                    'doc','docx' => 'text-blue-500',
                                                                    'xls','xlsx' => 'text-emerald-500',
                                                                    'zip','rar' => 'text-amber-500',
                                                                    default => 'text-slate-400',
                                                                };
                                                            @endphp
                                                            <div class="shrink-0 w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center shadow-sm {{ $iconColor }} group-hover:border-{{ $group['color'] }}-200 transition-colors">
                                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                                            </div>
                                                            <div class="min-w-0">
                                                                <h4 class="text-[13px] font-black text-slate-700 truncate leading-tight">{{ $courseFile->name }}</h4>
                                                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">{{ strtoupper($ext) }} · {{ $courseFile->size_formatted }}</p>
                                                            </div>
                                                            <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity shrink-0">
                                                                <a href="{{ $courseFile->url }}" target="_blank" download class="w-7 h-7 flex items-center justify-center rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-400 dark:text-slate-500 hover:text-indigo-600 dark:hover:text-indigo-400 hover:border-indigo-200 dark:hover:border-indigo-500/40 hover:bg-indigo-50 dark:hover:bg-indigo-950/40 transition-all shadow-sm" title="Unduh">
                                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                                                </a>
                                                                @if($courseFile->scope === 'course')
                                                                    <button @click="$dispatch('open-confirm', { message: 'Hapus file ini?', url: '{{ route('mentor.courses.files.destroy', [$course, $courseFile]) }}', method: 'DELETE', type: 'danger' })" class="w-7 h-7 flex items-center justify-center rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-400 dark:text-slate-500 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-955/40 hover:border-red-200 dark:hover:border-red-500/40 transition-all shadow-sm" title="Hapus">
                                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <div class="h-6"></div>
                            @endif
                        </div>

                    </div>
                </div>

                <div class="lg:col-span-3 lg:sticky lg:top-[125px] flex flex-col gap-6 relative">
                    
                    <div x-show="activeTab === 'curriculum'" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-x-4"
                         x-transition:enter-end="opacity-100 translate-x-0"
                         class="bg-white rounded-[32px] shadow-sm border border-slate-200/80 dark:border-white/10 overflow-hidden flex flex-col w-full">
                            <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between relative min-h-[64px]">
                                <h3 class="text-[14px] font-black text-slate-800 tracking-tight transition-all duration-500" :class="showSearch ? 'opacity-0 invisible' : 'opacity-100 visible'">Daftar Modul</h3>
                                
                                <div class="absolute inset-y-0 right-5 flex items-center justify-end" :class="showSearch ? 'left-5' : 'w-24'">
                                    <div class="relative w-full flex items-center justify-end gap-2">
                                        <input type="text" 
                                               x-model="searchQuery" 
                                               x-show="showSearch"
                                               x-transition:enter="transition ease-out duration-300"
                                               x-transition:enter-start="opacity-0 scale-95"
                                               x-transition:enter-end="opacity-100 scale-100"
                                               @click.away="if(searchQuery === '') showSearch = false"
                                               placeholder="Cari materi..." 
                                               class="w-full pl-4 pr-10 py-1.5 bg-slate-100 border-none rounded-xl text-[11px] font-bold focus:ring-2 focus:ring-indigo-500/20 transition-all">
                                        
                                        <div class="flex items-center gap-1">
                                            <button @click="showSearch = !showSearch; if(showSearch) $nextTick(() => $el.closest('.relative').querySelector('input').focus())" 
                                                    class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-slate-100 transition-colors"
                                                    :class="showSearch ? 'absolute right-1' : ''">
                                                <svg class="w-4 h-4 text-slate-400" :class="showSearch ? 'text-indigo-600' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                            </button>

                                            <a href="{{ route('mentor.courses.lessons.create', $course) }}" 
                                               x-show="!showSearch"
                                               class="w-8 h-8 flex items-center justify-center rounded-lg bg-indigo-600 text-white shadow-lg shadow-indigo-600/30 hover:bg-indigo-700 hover:shadow-indigo-600/50 hover:scale-110 transition-all duration-300">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="p-2 space-y-1 max-h-[400px] overflow-y-auto scrollbar-hide">
                                @forelse($course->lessons as $lesson)
                                    @php $isActive = $activeLesson && $activeLesson->id === $lesson->id; @endphp
                                    <a href="{{ route('mentor.courses.show', ['course' => $course->id, 'lesson_id' => $lesson->id]) }}" 
                                       x-show="'{{ strtolower($lesson->title) }}'.includes(searchQuery.toLowerCase())"
                                       class="group flex items-center p-3 rounded-[24px] transition-all duration-300 {{ $isActive ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'hover:bg-slate-50 border border-transparent' }}">
                                        <div class="shrink-0">
                                            <div class="w-8 h-8 rounded-xl {{ $isActive ? 'bg-white text-indigo-600' : 'bg-slate-100 text-slate-400 group-hover:bg-indigo-50 group-hover:text-indigo-600' }} flex items-center justify-center text-[10px] font-black transition-all group-hover:scale-105 shadow-sm">
                                                {{ $loop->iteration }}
                                            </div>
                                        </div>
                                        <div class="ml-3 flex-1 min-w-0">
                                            <h4 class="text-[12px] font-black {{ $isActive ? 'text-white' : 'text-slate-700 group-hover:text-indigo-700' }} truncate leading-tight transition-colors {{ $lesson->is_archived ? 'opacity-50' : '' }}">
                                                {{ $lesson->title }}
                                            </h4>
                                            <div class="flex items-center gap-2 mt-0.5">
                                                <span class="text-[9px] font-black {{ $isActive ? 'text-indigo-100' : 'text-slate-400' }} uppercase tracking-widest">{{ $lesson->duration_minutes }} Min</span>
                                                @if($lesson->is_archived)
                                                    <span class="px-1.5 py-0.5 text-[8px] font-bold bg-amber-100 text-amber-600 rounded">Diarsipkan</span>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                @empty
                                    <div class="p-4 text-center">
                                        <p class="text-[11px] font-bold text-slate-400 italic">Tekan tombol <span class="text-indigo-500 font-black">+</span> untuk menambah modul</p>
                                    </div>
                                @endforelse
                            </div>
                    </div>

                    <div x-show="activeTab === 'assessments'" style="display: none;"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-x-4"
                         x-transition:enter-end="opacity-100 translate-x-0" 
                         class="bg-white rounded-[32px] shadow-sm border border-slate-200/80 dark:border-white/10 overflow-hidden flex flex-col w-full">
                        <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between relative min-h-[64px]">
                            <h3 class="text-[14px] font-black text-slate-800 tracking-tight">Daftar Tugas</h3>
                            <div class="absolute inset-y-0 right-5 flex items-center justify-end w-24">
                                <a href="{{ route('mentor.courses.assignments.create', $course) }}" class="w-8 h-8 flex items-center justify-center rounded-lg bg-indigo-600 text-white shadow-lg shadow-indigo-600/30 hover:bg-indigo-700 hover:shadow-indigo-600/50 hover:scale-110 transition-all duration-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                                </a>
                            </div>
                        </div>
                        <div class="p-2 space-y-1 max-h-[400px] overflow-y-auto scrollbar-hide">
                            @forelse($course->assignments as $assignment)
                                @php $isActiveA = $activeAssignment && $activeAssignment->id === $assignment->id; @endphp
                                <a href="{{ route('mentor.courses.show', ['course' => $course->id, 'assignment_id' => $assignment->id]) }}" 
                                   @click.prevent="activeTab = 'assessments'; window.location.href = $el.href"
                                   class="group flex items-center p-3 rounded-[24px] transition-all duration-300 border {{ $isActiveA ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20 border-transparent' : 'hover:bg-slate-50 border-transparent' }}">
                                    <div class="shrink-0">
                                        <div class="w-8 h-8 rounded-xl {{ $isActiveA ? 'bg-white text-indigo-600' : 'bg-slate-100 text-slate-400 group-hover:bg-indigo-50 group-hover:text-indigo-600' }} flex items-center justify-center text-[10px] font-black transition-all group-hover:scale-105 shadow-sm">
                                            {{ $loop->iteration }}
                                        </div>
                                    </div>
                                    <div class="ml-3 flex-1 min-w-0">
                                        <h4 class="text-[12px] font-black {{ $isActiveA ? 'text-white' : 'text-slate-700 group-hover:text-indigo-700' }} truncate leading-tight transition-colors {{ $assignment->is_archived ? 'opacity-50' : '' }}">
                                            {{ $assignment->title }}
                                        </h4>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <span class="text-[9px] font-black {{ $isActiveA ? 'text-indigo-200' : 'text-slate-400' }} uppercase tracking-widest">{{ $assignment->submissions->count() }} Mengumpulkan</span>
                                            @if($assignment->is_archived)
                                                <span class="px-1.5 py-0.5 text-[8px] font-bold bg-amber-100 text-amber-600 rounded">Diarsipkan</span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <div class="p-4 text-center">
                                    <p class="text-[11px] font-bold text-slate-400 italic">Tekan tombol <span class="text-indigo-500 font-black">+</span> untuk menambah tugas</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div x-show="activeTab === 'students'" style="display: none;"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-x-4"
                         x-transition:enter-end="opacity-100 translate-x-0" 
                         class="bg-white rounded-[32px] shadow-sm border border-slate-200/80 dark:border-white/10 overflow-hidden flex flex-col p-6 w-full">
                        <h3 class="text-[14px] font-black text-slate-800 tracking-tight mb-4">Statistik Siswa</h3>
                        <div class="space-y-4">
                            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 flex items-center justify-between">
                                <div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Siswa</p>
                                    <p class="text-[18px] font-black text-indigo-600 leading-none">{{ $course->enrollments->count() }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                </div>
                            </div>
                            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 flex items-center justify-between">
                                <div>
                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Lulus</p>
                                    @php $lulus = $course->enrollments->where('progress', '>=', 100)->count(); @endphp
                                    <p class="text-[18px] font-black text-emerald-600 leading-none">{{ $lulus }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-emerald-400 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div x-show="activeTab === 'files'" style="display: none;"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0 translate-x-4"
                         x-transition:enter-end="opacity-100 translate-x-0" 
                         class="bg-white rounded-[32px] shadow-sm border border-slate-200/80 dark:border-white/10 overflow-hidden flex flex-col w-full">
                        <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between relative min-h-[64px]">
                            <h3 class="text-[14px] font-black text-slate-800 tracking-tight">Daftar File</h3>
                            <span class="px-2 py-0.5 rounded-md text-[11px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-transparent">{{ $courseFiles->count() + $globalFiles->count() }}</span>
                        </div>
                        <div class="p-2 space-y-1 max-h-[400px] overflow-y-auto scrollbar-hide">
                            @forelse($courseFiles->merge($globalFiles)->sortByDesc('created_at') as $cf)
                                <div class="group flex items-center justify-between p-3 rounded-[24px] hover:bg-slate-50 transition-all">
                                    <div class="flex items-center gap-2 min-w-0">
                                        <div class="shrink-0 w-8 h-8 rounded-xl bg-slate-100 text-slate-400 group-hover:bg-indigo-50 group-hover:text-indigo-600 flex items-center justify-center transition-all shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div class="min-w-0">
                                            <h4 class="text-[12px] font-black text-slate-700 group-hover:text-indigo-700 truncate leading-tight">{{ $cf->name }}</h4>
                                            <div class="flex items-center gap-1.5 mt-0.5">
                                                <span class="text-[9px] font-black uppercase tracking-widest {{ $cf->scope === 'global' ? 'text-emerald-500' : 'text-indigo-400' }}">{{ $cf->scope === 'global' ? 'Global' : 'Kelas Ini' }}</span>
                                                <span class="text-[9px] text-slate-300">·</span>
                                                <span class="text-[9px] font-bold text-slate-400">{{ $cf->size_formatted }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity shrink-0">
                                        <a href="{{ $cf->url }}" target="_blank" download class="w-7 h-7 flex items-center justify-center rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-400 dark:text-slate-500 hover:text-indigo-600 dark:hover:text-indigo-400 hover:border-indigo-200 dark:hover:border-indigo-500/40 hover:bg-indigo-50 dark:hover:bg-indigo-950/40 transition-all shadow-sm" title="Unduh">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        </a>
                                        <button @click="$dispatch('open-confirm', { message: 'Hapus file ini?', url: '{{ route('mentor.courses.files.destroy', [$course, $cf]) }}', method: 'DELETE', type: 'danger' })" class="w-7 h-7 flex items-center justify-center rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-red-450 dark:text-red-550 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/40 hover:border-red-200 dark:hover:border-red-500/40 transition-all shadow-sm" title="Hapus">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 text-center">
                                    <p class="text-[11px] font-bold text-slate-400 italic">Belum ada file. Gunakan form di panel kiri.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>

            <div x-show="showFileModal" 
                 style="display: none;"
                 class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0">
                
                <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" @click="showFileModal = false"></div>

                <div class="relative w-full max-w-lg bg-white rounded-[32px] shadow-2xl overflow-hidden"
                     x-transition:enter="transition ease-out duration-300 transform"
                     x-transition:enter-start="opacity-0 translate-y-8 scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                     x-transition:leave="transition ease-in duration-200 transform"
                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                     x-transition:leave-end="opacity-0 translate-y-8 scale-95">
                    
                    <form action="#" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="px-8 py-6 bg-slate-50/50 border-b border-slate-100 flex items-center justify-between">
                            <h3 class="text-lg font-black text-slate-800 tracking-tight">Upload File Baru</h3>
                            <button type="button" @click="showFileModal = false" class="w-8 h-8 flex items-center justify-center rounded-xl text-slate-400 hover:bg-slate-200 hover:text-slate-600 transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        <div class="p-8 space-y-6">
                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Nama File</label>
                                <input type="text" name="name" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all" placeholder="Misal: Modul PDF Chapter 1">
                            </div>

                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Tipe Penggunaan</label>
                                <select name="type" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all appearance-none cursor-pointer">
                                    <option value="course">Hanya untuk kelas ini</option>
                                    <option value="global">File Global (Bisa dipakai di kelas lain)</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2">Pilih Dokumen</label>
                                <div class="relative group cursor-pointer">
                                    <input type="file" name="file" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                    <div class="w-full px-4 py-8 border-2 border-dashed border-slate-200 rounded-2xl text-center group-hover:border-indigo-400 group-hover:bg-indigo-50/50 transition-all flex flex-col items-center justify-center">
                                        <div class="w-12 h-12 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 shadow-sm mb-3 group-hover:text-indigo-600 group-hover:border-indigo-200 transition-all">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                        </div>
                                        <p class="text-sm font-bold text-slate-600 group-hover:text-indigo-700 transition-colors">Pilih file atau drag & drop</p>
                                        <p class="text-[10px] font-medium text-slate-400 mt-1 uppercase tracking-widest">PDF, DOCX, ZIP (Maks. 10MB)</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="px-8 py-5 bg-slate-50/50 border-t border-slate-100 flex items-center justify-end gap-3">
                            <button type="button" @click="showFileModal = false" class="px-6 py-2.5 rounded-xl text-[11px] font-black text-slate-500 hover:bg-slate-200 transition-all uppercase tracking-widest">Batal</button>
                            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl text-[11px] font-black hover:bg-indigo-700 shadow-lg shadow-indigo-600/30 transition-all uppercase tracking-widest">Simpan File</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <style>
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

        .tinymce-wrapper h1, .tinymce-wrapper h2, .tinymce-wrapper h3, .tinymce-wrapper h4, .tinymce-wrapper h5, .tinymce-wrapper h6 {
            font-weight: 800; letter-spacing: -0.025em; margin-bottom: 1rem; color: #0f172a; margin-top: 1.5rem;
        }
        .tinymce-wrapper p { margin-bottom: 1rem; line-height: 1.75; color: #475569; font-size: 16px; }
        .tinymce-wrapper strong, .tinymce-wrapper b { font-weight: 700; color: #1e293b; }
        .tinymce-wrapper ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1rem; }
        .tinymce-wrapper ol { list-style-type: decimal; padding-left: 1.5rem; margin-bottom: 1rem; }
        .tinymce-wrapper li { margin-bottom: 0.25rem; color: #475569; display: list-item; }
        .tinymce-wrapper a { color: #4f46e5; text-decoration: underline; font-weight: 600; transition: color 0.2s; }
        .tinymce-wrapper a:hover { color: #4338ca; }
        .tinymce-wrapper blockquote { border-left-width: 4px; border-left-color: #cbd5e1; padding-left: 1rem; font-style: italic; color: #64748b; margin-top: 1.5rem; margin-bottom: 1.5rem; }
        
        .tinymce-wrapper iframe { 
            width: 100% !important; 
            aspect-ratio: 16 / 9; 
            height: auto !important; 
            border-radius: 16px; 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
        }
        
        .tinymce-wrapper img {
            max-width: 100%;
            height: auto;
            border-radius: 16px;
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
        }
    
        /* Dark Mode overrides for TinyMCE wrapper (to override inline white backgrounds and dark colors) */
        .dark .tinymce-wrapper h1, .dark .tinymce-wrapper h2, .dark .tinymce-wrapper h3, 
        .dark .tinymce-wrapper h4, .dark .tinymce-wrapper h5, .dark .tinymce-wrapper h6 {
            color: #f1f5f9 !important;
        }
        .dark .tinymce-wrapper p, .dark .tinymce-wrapper li, .dark .tinymce-wrapper span, 
        .dark .tinymce-wrapper strong, .dark .tinymce-wrapper b {
            color: #cbd5e1 !important;
        }
        .dark .tinymce-wrapper *:not(pre):not(code) {
            background-color: transparent !important;
        }

        /* --- Premium Code Block & Inline Code Styling --- */
        .tinymce-wrapper pre, .tinymce-wrapper code {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace !important;
        }
        .tinymce-wrapper pre, .tinymce-wrapper .ql-syntax {
            background-color: #0f172a !important;
            color: #e2e8f0 !important;
            padding: 1.25rem 1.5rem !important;
            border-radius: 16px !important;
            border: 1px solid #1e293b !important;
            overflow-x: auto !important;
            margin-top: 1.75rem !important;
            margin-bottom: 1.75rem !important;
            font-size: 14px !important;
            line-height: 1.65 !important;
            box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06) !important;
        }
        .tinymce-wrapper code {
            background-color: #f1f5f9;
            color: #e11d48;
            padding: 0.2rem 0.4rem;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
        }
        .dark .tinymce-wrapper code {
            background-color: #1e293b;
            color: #fda4af;
        }

        /* --- Quill Alignment & Format Support --- */
        .tinymce-wrapper .ql-align-center { text-align: center !important; }
        .tinymce-wrapper .ql-align-right { text-align: right !important; }
        .tinymce-wrapper .ql-align-justify { text-align: justify !important; }
        .tinymce-wrapper .ql-indent-1 { padding-left: 2rem !important; }
        .tinymce-wrapper .ql-indent-2 { padding-left: 4rem !important; }
        .tinymce-wrapper .ql-indent-3 { padding-left: 6rem !important; }
        .tinymce-wrapper .ql-indent-4 { padding-left: 8rem !important; }
        
        /* Force list styles since Tailwind base resets them */
        .tinymce-wrapper ul { list-style-type: disc !important; }
        .tinymce-wrapper ol { list-style-type: decimal !important; }
</style>
</x-app-layout>
