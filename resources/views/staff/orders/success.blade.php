<x-guest-layout>
    <div class="text-center" x-data="{
        init() {
            setTimeout(() => {
                window.location.href = '{{ route('staff.orders.history') }}';
            }, 8000);
        }
    }">
        <style>
            @keyframes dash {
                to { stroke-dashoffset: 0; }
            }
        </style>

        <div class="transform transition-all duration-700 ease-out scale-95 opacity-0" 
             x-data="{ show: false }" x-init="setTimeout(() => show = true, 50)"
             :class="show ? '!scale-100 !opacity-100 translate-y-0' : 'translate-y-8'">
             
            <!-- Animasi Centang -->
            <div class="mb-6 relative flex justify-center">
                <div class="absolute inset-0 bg-emerald-100/50 rounded-full blur-xl opacity-50 scale-150 animate-pulse"></div>
                <div class="w-20 h-20 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center relative z-10 shadow-sm border border-emerald-100/50">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         x-data="{ draw: false }" x-init="setTimeout(() => draw = true, 400)">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"
                              stroke-dasharray="100" stroke-dashoffset="100"
                              :class="draw ? 'animate-[dash_0.6s_ease-out_forwards]' : ''" />
                    </svg>
                </div>
            </div>

            <h2 class="text-2xl font-black text-slate-800 tracking-tight mb-3 leading-tight">Pesanan Berhasil Diselesaikan!</h2>
            
            <p class="text-slate-500 text-[14px] leading-relaxed mb-6 px-2">
                Luar biasa! Layanan ini telah ditandai sebagai selesai. Data otomatis masuk ke dalam <a href="{{ route('staff.orders.history') }}" class="font-bold text-indigo-600 hover:underline">Riwayat Layanan</a> dan pemasukan telah ditambahkan ke pembukuan keuangan aplikasi.
            </p>

            <div class="flex flex-col items-center mt-8">
                <div class="w-full max-w-[150px] bg-slate-100 rounded-full h-1 mb-3 overflow-hidden relative">
                    <div class="absolute left-0 top-0 bg-indigo-500 h-full rounded-full" 
                         x-data="{ width: 0 }" x-init="setTimeout(() => width = 100, 100)" 
                         :style="`width: ${width}%; transition: width 8s linear;`">
                    </div>
                </div>
                <a href="{{ route('staff.orders.history') }}" class="text-[12px] font-bold text-slate-400 hover:text-indigo-600 transition-colors">
                    Kembali ke Riwayat Layanan...
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
