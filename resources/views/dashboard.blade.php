<x-app-layout>
    <div class="py-8 bg-apple-parchment dark:bg-black min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Hero Section -->
            <div class="relative rounded-[24px] overflow-hidden bg-gradient-to-br from-slate-800 via-slate-700 to-slate-900 p-10 border border-white/5"
                 x-data="{ show: false }" x-init="setTimeout(() => show = true, 50)"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-500 transform"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0">
                
                <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-blue-600/10 rounded-full blur-[120px] pointer-events-none"></div>
                
                <div class="relative z-10 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-white/10 flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                    </div>
                    <h1 class="text-[36px] font-bold text-white leading-[1.1] tracking-tight mb-3">
                        Selamat Datang, {{ Auth::user()->name }}<span class="text-blue-400">.</span>
                    </h1>
                    <p class="text-slate-400 text-[17px] max-w-lg mx-auto mb-8">Anda berhasil masuk ke platform Syabaab Creative. Silakan menuju dashboard khusus Anda.</p>
                    
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-8 py-3.5 bg-blue-600 text-white font-bold rounded-2xl hover:bg-blue-500 hover:scale-105 transition-all duration-300 shadow-lg shadow-blue-500/30 text-[15px]">
                        Menuju Dashboard
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
