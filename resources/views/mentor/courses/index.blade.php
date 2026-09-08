<x-app-layout>
    <div class="py-8 bg-slate-50 dark:bg-black min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- HEADER -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-[28px] font-bold text-slate-900 tracking-tight leading-none mb-2">Kelola Kelas Anda</h2>
                    <p class="text-slate-500 text-[15px]">Pantau dan kelola seluruh kelas yang Anda ajar di platform ini.</p>
                </div>
                <div class="flex-shrink-0">
                    <a href="{{ route('mentor.courses.create') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 hover:bg-indigo-700 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                        Buat Kelas Baru
                    </a>
                </div>
            </div>

            <!-- SUCCESS MESSAGE -->

            <!-- COURSES GRID -->
            @if($courses->isEmpty())
                <div class="bg-white rounded-[24px] border border-slate-200/80 dark:border-white/10 dark:border-white/10 p-16 text-center shadow-sm">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h4 class="text-[20px] font-bold text-slate-900 mb-2">Belum ada kelas</h4>
                    <p class="text-slate-500 text-[15px] mb-8 max-w-md mx-auto">Anda belum membuat kelas apapun. Mulailah berbagi pengetahuan Anda dengan membuat kelas pertama.</p>
                    <a href="{{ route('mentor.courses.create') }}" class="inline-flex items-center px-6 py-3 bg-white border-2 border-indigo-100 text-indigo-600 font-bold rounded-xl hover:border-indigo-600 hover:bg-indigo-50 transition-all duration-300">
                        Buat Kelas Sekarang
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($courses as $course)
                        <div class="group bg-white rounded-[32px] overflow-hidden border border-slate-200/70 dark:border-white/10 dark:border-white/10 shadow-sm hover:shadow-2xl hover:border-blue-300/50 transition-all duration-500 flex flex-col relative cursor-pointer" @click="window.location.href = '{{ route('mentor.courses.show', $course) }}'">
                            <!-- Thumbnail Area -->
                            <div class="aspect-[16/10] w-full bg-slate-100 relative overflow-hidden">
                                <div class="absolute top-4 left-4 z-10 flex gap-2">
                                    <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider bg-white/90 text-blue-600 backdrop-blur-md shadow-sm border border-white/20">{{ $course->category->name ?? 'Kategori' }}</span>
                                    @if($course->is_published)
                                        <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider bg-emerald-500 text-white backdrop-blur-md shadow-sm">Publik</span>
                                    @else
                                        <span class="px-3 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider bg-amber-400 text-amber-900 backdrop-blur-md shadow-sm">Draft</span>
                                    @endif
                                </div>

                                @if($course->thumbnail)
                                    <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center text-blue-300 bg-blue-50/50">
                                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    </div>
                                @endif
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-slate-900/10 to-transparent opacity-60"></div>
                                
                                <!-- Student Info Overlay -->
                                <div class="absolute bottom-4 left-4 right-4 z-10">
                                    <div class="bg-slate-900/40 backdrop-blur-xl border border-white/20 rounded-2xl p-3 flex items-center justify-between">
                                        <div class="flex-1 mr-4">
                                            <div class="flex items-center justify-between">
                                                <span class="text-[10px] font-bold text-white uppercase tracking-wider">Jumlah Siswa</span>
                                                <span class="text-[10px] font-black text-white">{{ $course->students_count ?? 0 }} Orang</span>
                                            </div>
                                        </div>
                                        <div class="shrink-0 w-10 h-10 rounded-xl bg-blue-500 flex items-center justify-center text-white shadow-lg">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Content Area -->
                            <div class="p-6 flex flex-col flex-1">
                                <h3 class="font-black text-[17px] text-slate-800 leading-tight mb-5 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                    {{ $course->title }}
                                </h3>
                                
                                <div class="flex flex-wrap items-center gap-2 text-slate-500 text-[11px] mb-4 mt-auto">
                                    <span class="flex items-center gap-1 font-semibold text-slate-600"><svg class="w-3.5 h-3.5 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg> {{ number_format($course->rating ?? 0, 1) }}</span>
                                    <span class="text-slate-300">•</span>
                                    <span class="flex items-center gap-1 font-semibold text-slate-600"><svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> {{ $course->price == 0 ? 'Gratis' : 'Rp' . number_format($course->price, 0, ',', '.') }}</span>
                                </div>

                                <div class="mt-4 pt-4 border-t border-slate-100 dark:border-white/10 flex items-center justify-between">
                                    <div class="text-[10px] font-semibold text-slate-400">Dibuat: {{ $course->created_at->format('d M Y') }}</div>
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('mentor.courses.edit', $course) }}" class="w-8 h-8 flex items-center justify-center rounded-xl bg-slate-50 dark:bg-[#151517] text-slate-400 dark:text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-950/40 transition-colors" title="Edit Info">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </a>
                                        <a href="{{ route('mentor.courses.show', $course) }}" class="text-[11px] font-black text-blue-600 flex items-center gap-1 group-hover:gap-2 transition-all" title="Kelola Materi">
                                            Kelola
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-8">
                    {{ $courses->links() }}
                </div>
            @endif
            
        </div>
    </div>
</x-app-layout>
