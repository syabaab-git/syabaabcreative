<x-app-layout disable-animation="true" content-padding="pt-0">
    @php
        $globalFiles = \App\Models\CourseFile::where('scope', 'global')->get();
        $totalFiles = $course->courseFiles->where('scope', 'course')->count() + $globalFiles->count() + $course->lessons->sum(function($l) {
            $attachments = $l->attachments;
            if (is_string($attachments)) {
                $attachments = json_decode($attachments, true);
            }
            return is_array($attachments) ? count($attachments) : 0;
        });
    @endphp
    <div class="bg-[#f8fafc] dark:bg-black min-h-screen transition-colors duration-500" x-data="{ 
        activeTab: 'materi', 
        showContent: false,
        searchQuery: '',
        showSearch: false
    }" x-init="setTimeout(() => showContent = true, 100)">
        <div class="max-w-[1600px] mx-auto pt-[125px] px-4 sm:px-6 lg:px-8 pb-20">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <div class="lg:col-span-3 lg:sticky lg:top-[125px] flex flex-col gap-6">
                    <nav class="hidden lg:flex flex-col gap-2 bg-white dark:bg-[#1c1c1e] p-2.5 rounded-[24px] shadow-sm border border-slate-200/80 dark:border-white/10">
                        <!-- Materi Tab -->
                        <button @click="activeTab = 'materi'" 
                                :class="activeTab === 'materi' ? 'bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/20 shadow-[0_2px_10px_-3px_rgba(59,130,246,0.15)]' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white border border-transparent'"
                                class="group flex items-center justify-between px-4 py-2.5 rounded-xl font-bold text-[13px] transition-all duration-300 text-left">
                            <div class="flex items-center gap-3">
                                <div class="p-1.5 rounded-lg transition-colors" :class="activeTab === 'materi' ? 'bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400' : 'bg-transparent text-slate-400 dark:text-slate-500 group-hover:bg-slate-100 dark:group-hover:bg-white/5 group-hover:text-slate-700 dark:group-hover:text-slate-300'">
                                    <svg class="w-4 h-4 transition-transform group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" /></svg>
                                </div>
                                <span>Materi</span>
                            </div>
                            <span class="px-2 py-0.5 rounded-md text-[11px] font-bold shadow-sm transition-all" :class="activeTab === 'materi' ? 'bg-blue-100/80 dark:bg-blue-500/25 text-blue-600 dark:text-blue-300 border border-blue-100 dark:border-blue-500/10' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-transparent'">{{ $course->lessons->count() }}</span>
                        </button>
                        
                        <!-- Tugas Tab -->
                        <button @click="activeTab = 'tugas'" 
                                :class="activeTab === 'tugas' ? 'bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/20 shadow-[0_2px_10px_-3px_rgba(59,130,246,0.15)]' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white border border-transparent'"
                                class="group flex items-center justify-between px-4 py-2.5 rounded-xl font-bold text-[13px] transition-all duration-300 text-left">
                            <div class="flex items-center gap-3">
                                <div class="p-1.5 rounded-lg transition-colors" :class="activeTab === 'tugas' ? 'bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400' : 'bg-transparent text-slate-400 dark:text-slate-500 group-hover:bg-slate-100 dark:group-hover:bg-white/5 group-hover:text-slate-705 dark:group-hover:text-white'">
                                    <svg class="w-4 h-4 transition-transform group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" /><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd" /></svg>
                                </div>
                                <span>Tugas</span>
                            </div>
                            <span class="px-2 py-0.5 rounded-md text-[11px] font-bold shadow-sm transition-all" :class="activeTab === 'tugas' ? 'bg-blue-100/80 dark:bg-blue-500/25 text-blue-600 dark:text-blue-300 border border-blue-100 dark:border-blue-500/10' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-transparent'">{{ $course->assignments->count() }}</span>
                        </button>
 
                        <!-- File Tab -->
                        <button @click="activeTab = 'file'" 
                                :class="activeTab === 'file' ? 'bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 border border-blue-100 dark:border-blue-500/20 shadow-[0_2px_10px_-3px_rgba(59,130,246,0.15)]' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-white/5 hover:text-slate-900 dark:hover:text-white border border-transparent'"
                                class="group flex items-center justify-between px-4 py-2.5 rounded-xl font-bold text-[13px] transition-all duration-300 text-left">
                            <div class="flex items-center gap-3">
                                <div class="p-1.5 rounded-lg transition-colors" :class="activeTab === 'file' ? 'bg-blue-100 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400' : 'bg-transparent text-slate-400 dark:text-slate-500 group-hover:bg-slate-100 dark:group-hover:bg-white/5 group-hover:text-slate-750 dark:group-hover:text-white'">
                                    <svg class="w-4 h-4 transition-transform group-hover:scale-110" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A1 1 0 0112 2.586L15.414 6A1 1 0 0116 6.586V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" /></svg>
                                </div>
                                <span>File</span>
                            </div>
                            <span class="px-2 py-0.5 rounded-md text-[11px] font-bold shadow-sm transition-all" :class="activeTab === 'file' ? 'bg-blue-100/80 dark:bg-blue-500/25 text-blue-600 dark:text-blue-300 border border-blue-100 dark:border-blue-500/10' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-transparent'">{{ $totalFiles }}</span>
                        </button>
                    </nav>

                    <div class="relative group rounded-[28px] overflow-hidden shadow-sm border border-slate-200/80 min-h-[160px] flex flex-col justify-end p-5">
                        <div class="absolute inset-0 z-0">
                            <img src="{{ Storage::url($course->thumbnail) }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/95 via-slate-900/40 to-slate-900/10 backdrop-blur-[1px]"></div>
                        </div>
                        
                        <div class="relative z-10">
                            <div class="flex flex-wrap gap-1.5 mb-2">
                                <span class="px-2 py-0.5 bg-indigo-500/30 backdrop-blur-md border border-white/20 text-white text-[7px] font-black uppercase tracking-wider rounded-md">{{ $course->category->name }}</span>
                            </div>
                            <h3 class="text-[13px] font-black text-white leading-tight mb-4 drop-shadow-md">{{ $course->title }}</h3>
                            
                            <div class="backdrop-blur-md bg-white/10 rounded-xl p-2.5 border border-white/20 flex items-center gap-3">
                                <div class="shrink-0">
                                    @if($course->mentor->avatar)
                                        <img src="{{ Storage::url($course->mentor->avatar) }}" class="w-7 h-7 rounded-lg object-cover border border-white/30 shadow-sm">
                                    @else
                                        <div class="w-7 h-7 rounded-lg bg-indigo-500/80 text-white flex items-center justify-center font-black text-[9px]">
                                            {{ substr($course->mentor->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[7px] font-black text-indigo-200 uppercase tracking-widest leading-none mb-1">Mentor</p>
                                    <h4 class="text-[10px] font-black text-white truncate leading-none">{{ $course->mentor->name }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-6 min-w-0">
                    <div class="w-full"
                         x-show="showContent" 
                         x-transition:enter="transition ease-out duration-500"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100">
                         
                        <!-- Mobile Classroom Floating Glass Navigation Tabs (Placed at Bottom Left of Home Button) -->
                        <template x-teleport="body">
                            <div class="lg:hidden fixed bottom-5 inset-x-0 px-4 z-[9999] pointer-events-none flex items-center justify-between select-none"
                                 style="bottom: calc(1.25rem + env(safe-area-inset-bottom)) !important;">
                                
                                <!-- Left Side: Search Toggle Button -->
                                <div class="pointer-events-auto">
                                    <button @click="showSearch = !showSearch" 
                                            class="flex items-center justify-center h-11 w-11 rounded-full bg-white/75 dark:bg-[#151515]/75 backdrop-blur-3xl border border-white/70 dark:border-white/20 shadow-[0_8px_25px_rgba(0,0,0,0.08)] dark:shadow-[0_8px_32px_rgba(0,0,0,0.6),_inset_0_1px_1px_rgba(255,255,255,0.25)] text-slate-700 hover:text-slate-900 dark:text-slate-200 dark:hover:text-white hover:scale-110 active:scale-95 transition-all duration-300 focus:outline-none"
                                            :class="showSearch ? 'ring-2 ring-blue-500/50 text-blue-600 dark:text-white' : ''"
                                            title="Cari">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 100 13.5 6.75 6.75 0 000-13.5zM2.25 10.5a8.25 8.25 0 1114.59 5.28l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A8.25 8.25 0 012.25 10.5z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>

                                <!-- Right Side: Unified Glass Capsule containing Student Navigation Tabs + Home & Top Buttons -->
                                <div class="pointer-events-auto flex items-center h-11 p-1 rounded-full bg-white/75 dark:bg-[#151515]/75 backdrop-blur-3xl border border-white/70 dark:border-white/20 shadow-[0_8px_25px_rgba(0,0,0,0.08)] dark:shadow-[0_8px_32px_rgba(0,0,0,0.6),_inset_0_1px_1px_rgba(255,255,255,0.25)]">
                                    
                                    <!-- Student Classroom Navigation Tabs (Materi, Tugas, File) with Luminous Glass Glow & Fluid Expand/Shrink -->
                                    <div class="flex items-center gap-1.5 relative">
                                        <!-- Materi Tab -->
                                        <button @click="activeTab = 'materi'"
                                                class="relative z-10 flex items-center justify-center gap-1.5 h-9 rounded-full font-bold text-[11px] transition-all duration-500 ease-[cubic-bezier(0.16,1,0.3,1)]"
                                                :class="activeTab === 'materi' ? 'bg-blue-500/25 dark:bg-blue-500/30 text-blue-600 dark:text-blue-300 border border-blue-400/40 dark:border-blue-400/50 shadow-[0_0_15px_rgba(59,130,246,0.35),_inset_0_1px_1px_rgba(255,255,255,0.3)] backdrop-blur-md px-3.5' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white border border-transparent px-2.5'">
                                            <svg class="w-4 h-4 shrink-0 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                            <span x-show="activeTab === 'materi'" 
                                                  x-transition:enter="transition-all duration-400 ease-[cubic-bezier(0.16,1,0.3,1)]"
                                                  x-transition:enter-start="opacity-0 scale-75 max-w-0"
                                                  x-transition:enter-end="opacity-100 scale-100 max-w-[100px]"
                                                  x-transition:leave="transition-all duration-300 ease-in"
                                                  x-transition:leave-start="opacity-100 scale-100 max-w-[100px]"
                                                  x-transition:leave-end="opacity-0 scale-75 max-w-0"
                                                  class="whitespace-nowrap font-black">Materi</span>
                                        </button>

                                        <!-- Tugas Tab -->
                                        <button @click="activeTab = 'tugas'"
                                                class="relative z-10 flex items-center justify-center gap-1.5 h-9 rounded-full font-bold text-[11px] transition-all duration-500 ease-[cubic-bezier(0.16,1,0.3,1)]"
                                                :class="activeTab === 'tugas' ? 'bg-blue-500/25 dark:bg-blue-500/30 text-blue-600 dark:text-blue-300 border border-blue-400/40 dark:border-blue-400/50 shadow-[0_0_15px_rgba(59,130,246,0.35),_inset_0_1px_1px_rgba(255,255,255,0.3)] backdrop-blur-md px-3.5' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white border border-transparent px-2.5'">
                                            <svg class="w-4 h-4 shrink-0 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                            <span x-show="activeTab === 'tugas'" 
                                                  x-transition:enter="transition-all duration-400 ease-[cubic-bezier(0.16,1,0.3,1)]"
                                                  x-transition:enter-start="opacity-0 scale-75 max-w-0"
                                                  x-transition:enter-end="opacity-100 scale-100 max-w-[100px]"
                                                  x-transition:leave="transition-all duration-300 ease-in"
                                                  x-transition:leave-start="opacity-100 scale-100 max-w-[100px]"
                                                  x-transition:leave-end="opacity-0 scale-75 max-w-0"
                                                  class="whitespace-nowrap font-black">Tugas</span>
                                            <span class="w-5 h-5 rounded-full bg-blue-500/20 dark:bg-blue-500/35 text-blue-600 dark:text-blue-300 border border-blue-400/40 dark:border-blue-400/50 flex items-center justify-center text-[10px] font-black shadow-[0_0_8px_rgba(59,130,246,0.3)] shrink-0">{{ $course->assignments->count() }}</span>
                                        </button>

                                        <!-- File Tab -->
                                        <button @click="activeTab = 'file'"
                                                class="relative z-10 flex items-center justify-center gap-1.5 h-9 rounded-full font-bold text-[11px] transition-all duration-500 ease-[cubic-bezier(0.16,1,0.3,1)]"
                                                :class="activeTab === 'file' ? 'bg-blue-500/25 dark:bg-blue-500/30 text-blue-600 dark:text-blue-300 border border-blue-400/40 dark:border-blue-400/50 shadow-[0_0_15px_rgba(59,130,246,0.35),_inset_0_1px_1px_rgba(255,255,255,0.3)] backdrop-blur-md px-3.5' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white border border-transparent px-2.5'">
                                            <svg class="w-4 h-4 shrink-0 transition-transform duration-300" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A1 1 0 0112 2.586L15.414 6A1 1 0 0116 6.586V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path></svg>
                                            <span x-show="activeTab === 'file'" 
                                                  x-transition:enter="transition-all duration-400 ease-[cubic-bezier(0.16,1,0.3,1)]"
                                                  x-transition:enter-start="opacity-0 scale-75 max-w-0"
                                                  x-transition:enter-end="opacity-100 scale-100 max-w-[100px]"
                                                  x-transition:leave="transition-all duration-300 ease-in"
                                                  x-transition:leave-start="opacity-100 scale-100 max-w-[100px]"
                                                  x-transition:leave-end="opacity-0 scale-75 max-w-0"
                                                  class="whitespace-nowrap font-black">File</span>
                                            <span class="w-5 h-5 rounded-full bg-blue-500/20 dark:bg-blue-500/35 text-blue-600 dark:text-blue-300 border border-blue-400/40 dark:border-blue-400/50 flex items-center justify-center text-[10px] font-black shadow-[0_0_8px_rgba(59,130,246,0.3)] shrink-0">{{ $totalFiles }}</span>
                                        </button>
                                    </div>

                                    <!-- Divider -->
                                    <div class="h-4 w-px bg-slate-300/60 dark:bg-white/15 mx-1"></div>

                                    <!-- Home Button -->
                                    <a href="{{ auth()->check() ? route('dashboard') : route('landing') }}" 
                                       class="flex items-center justify-center h-9 w-9 rounded-full text-slate-700 hover:text-slate-900 dark:text-slate-200 dark:hover:text-white hover:bg-white/60 dark:hover:bg-white/10 active:scale-95 transition-all duration-300 focus:outline-none"
                                       title="Beranda">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 11-1.06 1.06l-.92-.92V19.5a1.5 1.5 0 01-1.5 1.5h-4.5a.75.75 0 01-.75-.75V15h-3v4.55a.75.75 0 01-.75.75H4.5A1.5 1.5 0 013 18.75V12.67l-.92.92a.75.75 0 11-1.06-1.06l8.69-8.69z"/>
                                        </svg>
                                    </a>

                                    <!-- Back to Top Button -->
                                    <button @click="window.scrollTo({ top: 0, behavior: 'smooth' })" 
                                            class="flex items-center justify-center h-9 w-9 rounded-full text-slate-700 hover:text-slate-900 dark:text-slate-200 dark:hover:text-white hover:bg-white/60 dark:hover:bg-white/10 active:scale-95 transition-all duration-300 focus:outline-none"
                                            title="Kembali ke Atas">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                        </svg>
                                    </button>
                                </div>

                            </div>
                        </template>
                        
                        <div x-show="activeTab === 'materi'" class="pb-10">
                            @if($activeLesson)
                                <div class="space-y-0">
                                    @php
                                        // LOGIKA PARSING JSON AMAN
                                        $rawLinks = $activeLesson->links ?? [];
                                        $lessonLinks = is_string($rawLinks) ? (json_decode($rawLinks, true) ?? []) : (is_array($rawLinks) ? $rawLinks : []);
                                        
                                        $rawAttachments = $activeLesson->attachments ?? [];
                                        $lessonAttachments = is_string($rawAttachments) ? (json_decode($rawAttachments, true) ?? []) : (is_array($rawAttachments) ? $rawAttachments : []);
                                        
                                        $videoLink = collect($lessonLinks)->filter(fn($l) => is_array($l) && preg_match('/youtube|youtu\.be|vimeo|dailymotion/i', $l['url'] ?? ''))->first();
                                        $otherLinks = collect($lessonLinks)->reject(fn($l) => is_array($l) && preg_match('/youtube|youtu\.be|vimeo|dailymotion/i', $l['url'] ?? ''));
                                        
                                        $isCompleted = in_array($activeLesson->id, $completedLessonIds);
                                    @endphp

                                    <div class="bg-white rounded-t-[32px] border-x border-t border-slate-200/60 overflow-hidden shadow-sm">
                                        <div class="px-8 py-4 bg-slate-50/50 border-b border-slate-100 flex items-center justify-between">
                                            <div class="flex items-center gap-2">
                                                <span class="px-2.5 py-1 bg-indigo-50 text-indigo-600 text-[9px] font-black uppercase tracking-wider rounded-lg border border-indigo-100">Materi {{ $course->lessons->search(fn($l) => $l->id === $activeLesson->id) + 1 }}</span>
                                            </div>
                                            
                                            <div class="flex items-center gap-4">
                                                @if($isCompleted)
                                                    <div class="flex items-center gap-1.5 text-emerald-500">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                        <span class="text-[9px] font-black uppercase tracking-widest">Selesai</span>
                                                    </div>
                                                @else
                                                    <div class="flex items-center gap-1.5 text-slate-400">
                                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                        <span class="text-[9px] font-black uppercase tracking-widest">{{ $activeLesson->duration_minutes }} Min</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        @if($videoLink)
                                            <!-- Video Iframe dengan Full Aspect Ratio 16:9 -->
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

                                    <div class="bg-white rounded-b-[32px] p-8 md:p-12 border-x border-b border-slate-200/60 shadow-sm overflow-x-auto">
                                        <div class="mb-8">
                                            <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight leading-tight">{{ $activeLesson->title }}</h1>
                                        </div>

                                        @if($activeLesson->description)
                                            <div class="relative bg-slate-50 rounded-2xl p-6 mb-8 border border-slate-100">
                                                <p class="text-[15px] font-bold text-slate-600 leading-relaxed italic">"{{ $activeLesson->description }}"</p>
                                            </div>
                                        @endif

                                        <!-- Konten Materi (Mempertahankan style khusus dari TinyMCE Editor) -->
                                        <div class="prose prose-slate dark:prose-invert max-w-none break-words tinymce-wrapper">
                                            {!! $activeLesson->body !!}
                                        </div>

                                        <div class="mt-12 pt-8 border-t border-slate-100">
                                            
                                            <!-- Menampilkan Tautan & Lampiran jika tersedia -->
                                            @if($otherLinks->count() > 0 || count($lessonAttachments) > 0)
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                                    
                                                    {{-- Tautan Terkait (Gaya Bersih/Minimalis) --}}
                                                    @if($otherLinks->count() > 0)
                                                        <div class="space-y-3">
                                                            <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Tautan Terkait</h4>
                                                            <div class="flex flex-col gap-2">
                                                                @foreach($otherLinks as $link)
                                                                    <a href="{{ is_array($link) ? $link['url'] : $link }}" target="_blank" class="group flex items-center gap-3 p-3 rounded-2xl border border-transparent hover:border-slate-200 hover:bg-slate-50 transition-all">
                                                                        <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 group-hover:text-indigo-600 group-hover:border-indigo-200 shadow-sm transition-all shrink-0">
                                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
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

                                                    {{-- Lampiran Materi (Gaya Bersih/Minimalis) --}}
                                                    @if(count($lessonAttachments) > 0)
                                                        <div class="space-y-3">
                                                            <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Lampiran Materi</h4>
                                                            <div class="flex flex-col gap-2">
                                                                @foreach($lessonAttachments as $file)
                                                                    <a href="{{ Storage::url($file['path']) }}" target="_blank" class="group flex items-center gap-3 p-3 rounded-2xl border border-transparent hover:border-slate-200 hover:bg-slate-50 transition-all">
                                                                        <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 group-hover:text-emerald-600 group-hover:border-emerald-200 shadow-sm transition-all shrink-0">
                                                                            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
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

                                            @php
                                                $currentIndex = $course->lessons->search(fn($l) => $l->id === $activeLesson->id);
                                                $prevLesson = $currentIndex > 0 ? $course->lessons->get($currentIndex - 1) : null;
                                                $nextLesson = $currentIndex < $course->lessons->count() - 1 ? $course->lessons->get($currentIndex + 1) : null;

                                                $lastLesson = $course->lessons->last();
                                                $isLastLesson = $activeLesson && $lastLesson && $activeLesson->id === $lastLesson->id;
                                                $allLessonsCompleted = $course->lessons->count() > 0 && $course->lessons->every(fn($l) => in_array($l->id, $completedLessonIds));
                                            @endphp
                                            <div class="flex items-center justify-between gap-4 mt-8 pt-8 border-t border-slate-100 dark:border-slate-850">
                                                @if($prevLesson)
                                                    <a href="{{ route('member.learning.show', ['course' => $course->slug, 'lesson_id' => $prevLesson->id]) }}" class="flex items-center gap-2 px-4 py-2.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-750 dark:text-slate-300 font-bold text-xs rounded-xl transition-all shadow-sm">
                                                        <svg class="w-4 h-4 text-slate-500 dark:text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg>
                                                        <span>Sebelumnya</span>
                                                    </a>
                                                @else
                                                    <div></div>
                                                @endif

                                                <div class="flex items-center gap-3">
                                                    @if(!$isCompleted)
                                                        <form action="{{ route('member.learning.complete', $activeLesson) }}" method="POST" class="m-0">
                                                            @csrf
                                                            <button type="submit" class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl transition-all shadow-md shadow-indigo-600/10">
                                                                @if($isLastLesson)
                                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>
                                                                    <span>Selesaikan Kursus</span>
                                                                @else
                                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                                                    <span>Selesai & Lanjut</span>
                                                                @endif
                                                            </button>
                                                        </form>
                                                    @else
                                                        @if($isLastLesson)
                                                            <a href="{{ route('member.learning.completed', $course->slug) }}" class="flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl transition-all shadow-md shadow-emerald-600/10">
                                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path></svg>
                                                                <span>Selesaikan Kursus</span>
                                                            </a>
                                                        @elseif($nextLesson)
                                                            <a href="{{ route('member.learning.show', ['course' => $course->slug, 'lesson_id' => $nextLesson->id]) }}" class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl transition-all shadow-md shadow-indigo-600/10">
                                                                <span>Selanjutnya</span>
                                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                            </a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div x-show="activeTab === 'tugas'" x-transition class="pb-10">
                            <div class="bg-white rounded-t-[32px] border-x border-t border-slate-200/60 overflow-hidden shadow-sm">
                                <div class="px-8 py-4 bg-slate-50/50 border-b border-slate-100 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2.5 py-1 bg-indigo-50 text-indigo-600 text-[9px] font-black uppercase tracking-wider rounded-lg border border-indigo-100">Tugas & Evaluasi</span>
                                    </div>
                                    <span class="px-2.5 py-1 bg-white border border-slate-200/85 rounded-lg text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $course->assignments->count() }} Tugas</span>
                                </div>
                            </div>

                            <div class="bg-white rounded-b-[32px] p-8 md:p-12 border-x border-b border-slate-200/60 shadow-sm">
                                <div class="grid grid-cols-1 gap-4">
                                    @forelse($course->assignments as $assignment)
                                        @php
                                            $submission = \App\Models\AssignmentSubmission::where('user_id', auth()->id())
                                                ->where('assignment_id', $assignment->id)
                                                ->first();
                                        @endphp
                                        <div class="group bg-white border border-slate-200/60 rounded-[24px] p-6 hover:border-indigo-400 transition-all duration-300 shadow-sm hover:shadow-xl">
                                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                                                <div class="flex items-center gap-4">
                                                    <div class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center text-indigo-600 group-hover:scale-105 transition-transform shrink-0">
                                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"></path></svg>
                                                    </div>
                                                    <div>
                                                        <h4 class="text-[15px] font-black text-slate-800 mb-1 group-hover:text-indigo-700 transition-colors">{{ $assignment->title }}</h4>
                                                        <div class="flex flex-wrap gap-3">
                                                            @if(!$submission)
                                                                <span class="flex items-center gap-1.5 text-[10px] font-bold text-rose-500 bg-rose-50 dark:bg-rose-950/20 border border-rose-100/50 dark:border-rose-900/30 px-2 py-0.5 rounded-md uppercase tracking-wider">
                                                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                                                    Belum Dikerjakan
                                                                </span>
                                                            @elseif($submission->status === 'submitted')
                                                                <span class="flex items-center gap-1.5 text-[10px] font-bold text-amber-600 bg-amber-50 dark:bg-amber-950/20 border border-amber-100/50 dark:border-amber-900/30 px-2 py-0.5 rounded-md uppercase tracking-wider">
                                                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.8 2.8a1 1 0 101.414-1.414L11 9.586V6z" clip-rule="evenodd"></path></svg>
                                                                    Menunggu Penilaian
                                                                </span>
                                                            @elseif($submission->status === 'graded')
                                                                <span class="flex items-center gap-1.5 text-[10px] font-bold text-emerald-600 bg-emerald-50 dark:bg-emerald-950/20 border border-emerald-100/50 dark:border-emerald-900/30 px-2 py-0.5 rounded-md uppercase tracking-wider">
                                                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l5-5z" clip-rule="evenodd"></path></svg>
                                                                    Sudah Dinilai (Nilai: {{ $submission->score }})
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex items-center gap-3">
                                                    @if(!$submission)
                                                        <a href="{{ route('member.learning.assignment.show', [$course, $assignment]) }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] font-black rounded-xl transition-all shadow-md shadow-indigo-600/10 text-center uppercase tracking-widest">Kerjakan</a>
                                                    @else
                                                        <a href="{{ route('member.learning.assignment.show', [$course, $assignment]) }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-[10px] rounded-xl transition-all shadow-sm text-center uppercase tracking-widest">
                                                            {{ $submission->status === 'graded' ? 'Lihat Hasil' : 'Detail Tugas' }}
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center py-12 bg-slate-50 rounded-[24px] border border-dashed border-slate-200">
                                            <p class="text-slate-400 font-bold text-xs">Tidak ada tugas yang tersedia.</p>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <div x-show="activeTab === 'file'" x-transition class="pb-10">
                            <div class="bg-white rounded-t-[32px] border-x border-t border-slate-200/60 overflow-hidden shadow-sm">
                                <div class="px-8 py-4 bg-slate-50/50 border-b border-slate-100 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="px-2.5 py-1 bg-emerald-50 text-emerald-600 text-[9px] font-black uppercase tracking-wider rounded-lg border border-emerald-100">Berkas Pendukung</span>
                                    </div>
                                    @php
                                        $allFiles = $course->lessons->flatMap(function($l) {
                                            $attachments = $l->attachments;
                                            if (is_string($attachments)) {
                                                $attachments = json_decode($attachments, true);
                                            }
                                            return is_array($attachments) ? $attachments : [];
                                        });
                                    @endphp
                                    <span class="px-2.5 py-1 bg-white border border-slate-200/85 rounded-lg text-[9px] font-black text-slate-400 uppercase tracking-widest">{{ $totalFiles }} File</span>
                                </div>
                            </div>

                            <div class="bg-white rounded-b-[32px] p-8 md:p-12 border-x border-b border-slate-200/60 shadow-sm space-y-8">
                                {{-- 1. Berkas Pendukung Kelas --}}
                                @if($course->courseFiles->where('scope', 'course')->count() > 0)
                                    <div class="space-y-3">
                                        <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Berkas Pendukung Kelas</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            @foreach($course->courseFiles->where('scope', 'course') as $file)
                                                <a href="{{ $file->url }}" target="_blank" class="group flex items-center p-5 bg-white dark:bg-zinc-900/40 border border-slate-200/60 dark:border-white/5 rounded-[24px] hover:border-emerald-450 hover:shadow-xl transition-all duration-300 shadow-sm">
                                                    <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-100 dark:border-zinc-800 flex items-center justify-center text-emerald-600 dark:text-emerald-400 group-hover:scale-105 transition-transform shrink-0">
                                                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                    </div>
                                                    <div class="ml-4 flex-1 min-w-0">
                                                        <h4 class="text-[13px] font-black text-slate-800 dark:text-white truncate group-hover:text-emerald-700 dark:group-hover:text-emerald-400 transition-colors">{{ $file->name }}</h4>
                                                        <p class="text-[9px] font-black text-slate-400 mt-1 uppercase tracking-widest">{{ $file->size_formatted }}</p>
                                                    </div>
                                                    <svg class="w-4 h-4 text-slate-200 group-hover:text-emerald-555 transition-colors ml-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                {{-- 2. Berkas Global --}}
                                @if($globalFiles->count() > 0)
                                    <div class="space-y-3">
                                        <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Berkas Referensi Global</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            @foreach($globalFiles as $file)
                                                <a href="{{ $file->url }}" target="_blank" class="group flex items-center p-5 bg-white dark:bg-zinc-900/40 border border-slate-200/60 dark:border-white/5 rounded-[24px] hover:border-emerald-450 hover:shadow-xl transition-all duration-300 shadow-sm">
                                                    <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-100 dark:border-zinc-800 flex items-center justify-center text-emerald-600 dark:text-emerald-400 group-hover:scale-105 transition-transform shrink-0">
                                                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                    </div>
                                                    <div class="ml-4 flex-1 min-w-0">
                                                        <h4 class="text-[13px] font-black text-slate-800 dark:text-white truncate group-hover:text-emerald-700 dark:group-hover:text-emerald-400 transition-colors">{{ $file->name }}</h4>
                                                        <p class="text-[9px] font-black text-slate-400 mt-1 uppercase tracking-widest">{{ $file->size_formatted }}</p>
                                                    </div>
                                                    <svg class="w-4 h-4 text-slate-200 group-hover:text-emerald-555 transition-colors ml-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                {{-- 3. Lampiran Per Materi --}}
                                @if($allFiles->count() > 0)
                                    <div class="space-y-3">
                                        <h4 class="text-[11px] font-black text-slate-400 uppercase tracking-widest">Lampiran Per Materi</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            @foreach($allFiles as $file)
                                                <a href="{{ Storage::url($file['path']) }}" target="_blank" class="group flex items-center p-5 bg-white dark:bg-zinc-900/40 border border-slate-200/60 dark:border-white/5 rounded-[24px] hover:border-emerald-455 hover:shadow-xl transition-all duration-300 shadow-sm">
                                                    <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-zinc-900 border border-slate-100 dark:border-zinc-800 flex items-center justify-center text-emerald-600 dark:text-emerald-400 group-hover:scale-105 transition-transform shrink-0">
                                                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                                    </div>
                                                    <div class="ml-4 flex-1 min-w-0">
                                                        <h4 class="text-[13px] font-black text-slate-800 dark:text-white truncate group-hover:text-emerald-700 dark:group-hover:text-emerald-400 transition-colors">{{ $file['name'] }}</h4>
                                                        <p class="text-[9px] font-black text-slate-400 mt-1 uppercase tracking-widest">{{ number_format($file['size'] / 1024, 1) }} KB</p>
                                                    </div>
                                                    <svg class="w-4 h-4 text-slate-200 group-hover:text-emerald-555 transition-colors ml-2" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if($course->courseFiles->count() === 0 && $globalFiles->count() === 0 && $allFiles->count() === 0)
                                    <div class="text-center py-12 bg-slate-50 dark:bg-[#121214]/50 rounded-[24px] border border-dashed border-slate-200 dark:border-white/5">
                                        <p class="text-slate-400 dark:text-slate-500 font-bold text-xs">Tidak ada file pendukung yang tersedia.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-3 lg:sticky lg:top-[125px] flex flex-col gap-6">
                    
                    <div class="bg-white rounded-[24px] p-5 shadow-sm border border-slate-200/80">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-[14px] font-black text-slate-800 tracking-tight">Progress Belajar</h3>
                            <span class="text-[14px] font-black text-indigo-600">{{ $enrollment->progress }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 mb-4 overflow-hidden">
                            <div class="bg-indigo-600 h-2 rounded-full transition-all duration-1000" style="width: {{ $enrollment->progress }}%"></div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div class="bg-slate-50 rounded-xl p-3 border border-slate-100">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Materi</p>
                                <p class="text-[13px] font-black text-slate-800">{{ count($completedLessonIds) }}/{{ $course->lessons->count() }}</p>
                            </div>
                            <div class="bg-slate-50 rounded-xl p-3 border border-slate-100">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Tugas Lulus</p>
                                <p class="text-[13px] font-black text-slate-800">{{ count($completedassignmentIds) }}/{{ $course->assignments->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-[#1c1c1e] rounded-[32px] shadow-sm border border-slate-200/80 dark:border-white/10/80 overflow-hidden flex flex-col">
                        <div class="px-5 py-4 border-b border-slate-100 dark:border-white/10 bg-slate-50/50 dark:bg-[#1c1c1e]/50 flex items-center justify-between relative min-h-[64px]">
                            <h3 class="text-[14px] font-black text-slate-800 dark:text-slate-200 tracking-tight transition-all duration-500" :class="showSearch ? 'opacity-0 invisible' : 'opacity-100 visible'">Daftar Materi</h3>
                            
                            <div class="absolute inset-y-0 right-5 flex items-center justify-end" :class="showSearch ? 'left-5' : 'w-10'">
                                <div class="relative w-full flex items-center justify-end">
                                    <input type="text" 
                                           x-model="searchQuery" 
                                           x-show="showSearch"
                                           x-transition:enter="transition ease-out duration-300"
                                           x-transition:enter-start="opacity-0 scale-95"
                                           x-transition:enter-end="opacity-100 scale-100"
                                           @click.away="if(searchQuery === '') showSearch = false"
                                           placeholder="Cari materi..." 
                                           class="w-full pl-4 pr-10 py-1.5 bg-slate-100 dark:bg-[#1c1c1e] border-none rounded-xl text-[11px] font-bold focus:ring-2 focus:ring-indigo-500/20 transition-all">
                                    
                                    <button @click="showSearch = !showSearch; if(showSearch) $nextTick(() => $el.previousElementSibling.focus())" 
                                            class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                                            :class="showSearch ? 'absolute right-1' : ''">
                                        <svg class="w-4 h-4 text-slate-400" :class="showSearch ? 'text-indigo-600' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="p-2 space-y-1 max-h-[400px] overflow-y-auto scrollbar-hide">
                            @foreach($course->lessons as $lesson)
                                @php
                                    $isActive = $activeLesson && $activeLesson->id === $lesson->id;
                                    $isCompleted = in_array($lesson->id, $completedLessonIds);
                                @endphp
                                <a href="{{ route('member.learning.show', ['course' => $course->slug, 'lesson_id' => $lesson->id]) }}" 
                                   x-show="'{{ strtolower($lesson->title) }}'.includes(searchQuery.toLowerCase())"
                                   class="group flex items-center p-3 rounded-[24px] transition-all duration-300 {{ $isActive ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-500/20' : 'hover:bg-slate-50 dark:hover:bg-slate-800/50 border border-transparent dark:text-slate-200' }}">
                                    
                                    <div class="shrink-0">
                                        @if($isCompleted)
                                            <div class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center shadow-md transition-transform group-hover:scale-105">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                        @else
                                            <div class="w-8 h-8 rounded-xl {{ $isActive ? 'bg-white text-indigo-600' : 'bg-slate-100 dark:bg-[#1c1c1e] text-slate-700 dark:text-slate-300 group-hover:bg-indigo-50 dark:group-hover:bg-indigo-950/50 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }} flex items-center justify-center text-[10px] font-black transition-all group-hover:scale-105 shadow-sm">
                                                {{ $loop->iteration }}
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="ml-3 flex-1 min-w-0">
                                        <h4 class="text-[12px] font-black {{ $isActive ? 'text-white' : 'text-slate-700 dark:text-slate-300 group-hover:text-indigo-700 dark:group-hover:text-indigo-400' }} truncate leading-tight transition-colors">
                                            {{ $lesson->title }}
                                        </h4>
                                        <span class="text-[9px] font-black {{ $isActive ? 'text-indigo-100' : 'text-slate-400' }} uppercase tracking-widest">{{ $lesson->duration_minutes }} Min</span>
                                    </div>
 
 
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                
            </div>

        </div>
    </div>

    <style>
        @keyframes music-1 { 0%, 100% { height: 4px; } 50% { height: 12px; } }
        @keyframes music-2 { 0%, 100% { height: 10px; } 50% { height: 6px; } }
        @keyframes music-3 { 0%, 100% { height: 6px; } 50% { height: 10px; } }
        .animate-music-1 { animation: music-1 0.8s ease-in-out infinite; }
        .animate-music-2 { animation: music-2 0.8s ease-in-out infinite 0.1s; }
        .animate-music-3 { animation: music-3 0.8s ease-in-out infinite 0.2s; }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

        /* Konfigurasi keamanan format TinyMCE di dalam kelas Prose */
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
        
        /* Modifikasi ukuran Iframe embed video TinyMCE agar Full Width Aspect Ratio 16:9 */
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
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
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
