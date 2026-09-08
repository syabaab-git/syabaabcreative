<x-front-layout>
    <div class="min-h-screen bg-[#f8fafc] pb-16 pt-4 sm:pt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 50)"
                 class="transform transition-all duration-700 ease-out opacity-0 translate-y-8"
                 :class="show ? '!opacity-100 !translate-y-0' : ''">

                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">

                    {{-- KIRI: COURSE DETAILS --}}
                    <div class="col-span-1 lg:col-span-4 lg:sticky lg:top-[120px] flex flex-col gap-4">

                        {{-- Thumbnail Card --}}
                        <div class="bg-white rounded-[24px] border border-slate-200 overflow-hidden shadow-sm">
                            <div class="w-full h-52 bg-slate-100 relative">
                                @if($course->thumbnail)
                                    <img src="{{ Storage::url($course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-blue-50 to-cyan-50">
                                        <svg class="w-14 h-14 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    </div>
                                @endif
                                <div class="absolute top-3 left-3 flex gap-2">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold bg-white/90 text-blue-700 backdrop-blur-md shadow-sm uppercase tracking-wider">
                                        {{ $course->category->name ?? '-' }}
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold capitalize bg-white/90 text-slate-700 backdrop-blur-md shadow-sm">
                                        {{ $course->level }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-5">
                                <h1 class="text-xl font-black text-slate-800 mb-3 leading-snug">{{ $course->title }}</h1>

                                {{-- Rating & Students --}}
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        <span class="text-sm font-bold text-slate-700">{{ number_format($course->rating, 1) }}</span>
                                    </div>
                                    <span class="text-[11px] text-slate-400 font-medium">·</span>
                                    <span class="text-xs text-slate-500 font-semibold">{{ $course->students_count }} siswa</span>
                                    <span class="text-[11px] text-slate-400 font-medium">·</span>
                                    <span class="text-xs text-slate-500 font-semibold">{{ $course->lessons->count() }} pelajaran</span>
                                </div>

                                {{-- Price --}}
                                <div class="bg-blue-50 px-4 py-3 rounded-xl border border-blue-100 flex items-center justify-between mb-5">
                                    <span class="text-xs font-bold text-blue-500 uppercase tracking-wider">Harga</span>
                                    <span class="text-xl font-black text-blue-700">
                                        @if($course->price == 0)
                                            Gratis
                                        @else
                                            Rp{{ number_format($course->price, 0, ',', '.') }}
                                        @endif
                                    </span>
                                </div>

                                {{-- CTA Button --}}
                                @if(auth()->check() && auth()->user()->hasRole('member'))
                                    @if($enrollment)
                                        @if($enrollment->status === 'approved')
                                            <a href="{{ route('member.learning.show', $course) }}" class="w-full flex items-center justify-center gap-2 px-5 py-3 bg-emerald-600 hover:bg-emerald-700 text-white rounded-2xl font-black text-sm shadow-sm shadow-emerald-600/20 hover:-translate-y-0.5 transition-all">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/></svg>
                                                Lanjut Belajar
                                            </a>
                                        @elseif($enrollment->status === 'pending')
                                            <div class="w-full flex items-center justify-center gap-2 px-5 py-3 bg-amber-50 text-amber-700 border border-amber-200 rounded-2xl font-bold text-sm cursor-not-allowed">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                                                Menunggu Persetujuan
                                            </div>
                                        @else
                                            <div class="w-full flex items-center justify-center gap-2 px-5 py-3 bg-slate-100 text-slate-500 rounded-2xl font-bold text-sm cursor-not-allowed">
                                                Pendaftaran Ditolak
                                            </div>
                                        @endif
                                    @else
                                        <a href="{{ route('member.learning.show', $course) }}" class="w-full flex items-center justify-center gap-2 px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-black text-sm shadow-sm shadow-blue-600/20 hover:-translate-y-0.5 transition-all">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/></svg>
                                            Daftar Sekarang
                                        </a>
                                    @endif
                                @elseif(!auth()->check())
                                    <a href="{{ route('login') }}" class="w-full flex items-center justify-center gap-2 px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-black text-sm shadow-sm shadow-blue-600/20 hover:-translate-y-0.5 transition-all">
                                        Login untuk Mendaftar
                                    </a>
                                @endif

                                {{-- Mentor Info --}}
                                <div class="flex items-center gap-3 mt-5 pt-4 border-t border-slate-100">
                                    @if($course->mentor->avatar)
                                        <img src="{{ Storage::url($course->mentor->avatar) }}" class="w-9 h-9 rounded-full object-cover border border-slate-200" alt="{{ $course->mentor->name }}">
                                    @else
                                        <div class="w-9 h-9 rounded-full bg-blue-100 flex items-center justify-center text-blue-700 font-black text-sm">
                                            {{ substr($course->mentor->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Mentor</p>
                                        <p class="text-sm font-bold text-slate-700">{{ $course->mentor->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- KANAN: DESKRIPSI & SILABUS --}}
                    <div class="col-span-1 lg:col-span-8 flex flex-col gap-5">

                        {{-- Deskripsi --}}
                        <div class="bg-white rounded-[24px] border border-slate-200 shadow-sm p-6 sm:p-8">
                            <h2 class="text-lg font-black text-slate-800 mb-4 flex items-center gap-2">
                                <span class="w-7 h-7 rounded-lg bg-blue-50 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                                </span>
                                Tentang Kursus Ini
                            </h2>
                            <p class="text-slate-600 text-sm leading-relaxed">{{ $course->description }}</p>
                        </div>

                        {{-- Silabus --}}
                        @if($course->lessons->count() > 0)
                        <div class="bg-white rounded-[24px] border border-slate-200 shadow-sm overflow-hidden">
                            <div class="px-6 sm:px-8 py-5 border-b border-slate-100 flex items-center justify-between">
                                <h2 class="text-lg font-black text-slate-800 flex items-center gap-2">
                                    <span class="w-7 h-7 rounded-lg bg-indigo-50 flex items-center justify-center">
                                        <svg class="w-4 h-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"/></svg>
                                    </span>
                                    Silabus Kursus
                                </h2>
                                <span class="text-xs font-bold text-slate-400 bg-slate-50 px-3 py-1.5 rounded-xl border border-slate-100">
                                    {{ $course->lessons->count() }} Pelajaran
                                </span>
                            </div>

                            <div class="divide-y divide-slate-100">
                                @foreach($course->lessons as $index => $lesson)
                                    <div class="flex items-center gap-4 px-6 sm:px-8 py-4 hover:bg-slate-50/50 transition-colors">
                                        <div class="shrink-0 w-8 h-8 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 text-xs font-black">
                                            {{ $index + 1 }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-bold text-slate-700 truncate">{{ $lesson->title }}</p>
                                            @if($lesson->duration_minutes)
                                                <p class="text-[11px] text-slate-400 font-medium mt-0.5">{{ $lesson->duration_minutes }} menit</p>
                                            @endif
                                        </div>
                                        <div class="shrink-0">
                                            @if($enrollment && $enrollment->status === 'approved')
                                                <svg class="w-5 h-5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/></svg>
                                            @else
                                                <svg class="w-4 h-4 text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- Back Link --}}
                        <div>
                            <a href="{{ route('courses.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-slate-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                                Kembali ke Daftar Kursus
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-front-layout>
