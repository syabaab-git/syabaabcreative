<x-guest-layout :hide-toggle="true" :hide-close="true">
    <div class="text-center" x-data="{
        init() {
            // Redirect setelah 8 detik ke halaman testimonial agar siswa bisa mengisi ulasan
            setTimeout(() => {
                window.location.href = '{{ route('member.testimonials.index') }}';
            }, 8000);
        }
    }">
        <style>
            @keyframes progress-timer {
                from { width: 0%; }
                to { width: 100%; }
            }
        </style>

        <div class="transform transition-all duration-700 ease-out scale-95 opacity-0" 
             x-data="{ show: false }" x-init="setTimeout(() => show = true, 50)"
             :class="show ? '!scale-100 !opacity-100 translate-y-0' : 'translate-y-8'">
             
            <!-- Centang Solid -->
            <div class="mb-6 relative flex justify-center">
                <div class="w-16 h-16 bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 rounded-full flex items-center justify-center relative z-10 border border-emerald-100 dark:border-emerald-900/30 shadow-sm">
                    <svg class="w-8 h-8" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>

            <h2 class="text-2xl font-black text-slate-800 dark:text-white tracking-tight mb-3 leading-tight">Kursus Selesai!</h2>
            
            <p class="text-slate-550 dark:text-slate-400 text-[13px] leading-relaxed mb-6 px-2">
                Selamat! Anda telah menyelesaikan seluruh materi kelas <strong class="text-slate-850 dark:text-white font-black">{{ $course->title }}</strong>.<br><br>
                Sertifikat kelulusan Anda dapat diunduh setelah memberikan ulasan untuk kelas ini pada halaman Testimonial.
            </p>

            <div class="flex justify-center gap-3 mb-8">
                <a href="{{ route('member.testimonials.index') }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl transition-all shadow-md shadow-indigo-600/10">
                    Beri Ulasan
                </a>
                <a href="{{ route('member.dashboard') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 dark:bg-slate-850 dark:hover:bg-slate-800 dark:text-slate-300 font-bold text-xs rounded-xl transition-all shadow-sm">
                    Ke Dashboard
                </a>
            </div>

            <!-- Minimalist Timer Bar -->
            <div class="flex flex-col items-center">
                <div class="w-full max-w-[150px] bg-slate-100 dark:bg-slate-800 rounded-full h-[3px] overflow-hidden relative">
                    <div class="absolute left-0 top-0 bg-indigo-600 h-full rounded-full animate-[progress-timer_8s_linear_forwards]">
                    </div>
                </div>
                <a href="{{ route('member.testimonials.index') }}" class="text-[10px] font-bold text-slate-400 dark:text-slate-500 hover:text-indigo-600 transition-colors mt-2">
                    Mengarahkan ke halaman Ulasan...
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
