<x-guest-layout>
    <!-- Alpine.js sudah dimuat oleh Vite di layout utama jika diperlukan, 
         tetapi jika butuh fallback, letakkan di head. Namun guest layout sudah meload app.js -->
    <div class="text-center" x-data="{
        init() {
            // Redirect setelah 8 detik agar pengguna punya waktu membaca
            setTimeout(() => {
                window.location.href = '{{ route('member.dashboard', ['tab' => 'layanan']) }}';
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

            <h2 class="text-2xl font-black text-slate-800 tracking-tight mb-3 leading-tight">Pesanan Terkirim!</h2>
            
            <p class="text-slate-500 text-[13px] leading-relaxed mb-6 px-2">
                Terima kasih, pesanan Anda telah kami terima. Anda dapat memeriksa status layanan secara berkala pada halaman <a href="{{ route('member.dashboard', ['tab' => 'layanan']) }}" class="font-bold text-indigo-600 hover:underline">Layanan Saya</a>.<br><br>
                Mohon lakukan <strong class="text-slate-700">konfirmasi pemesanan</strong> dengan menghubungi admin kami melalui WhatsApp di bawah ini.
            </p>

            <div class="flex justify-center gap-3 mb-8">
                @php $waNumber = preg_replace('/[^0-9]/', '', \App\Models\Setting::where('key', 'whatsapp_number')->value('value') ?? '6281234567890'); @endphp
                <a href="https://wa.me/{{ $waNumber }}" target="_blank" class="w-12 h-12 inline-flex justify-center items-center bg-[#25D366] hover:bg-[#128C7E] text-white rounded-2xl transition-all shadow-sm hover:shadow-lg hover:shadow-[#25D366]/30 hover:-translate-y-0.5" title="Konfirmasi via WhatsApp">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                </a>
                @php $igUrl = \App\Models\Setting::where('key', 'social_instagram')->value('value') ?? '#'; @endphp
                <a href="{{ $igUrl }}" target="_blank" class="w-12 h-12 inline-flex justify-center items-center bg-gradient-to-tr from-[#FD1D1D] via-[#E1306C] to-[#C13584] hover:opacity-90 text-white rounded-2xl transition-all shadow-sm hover:shadow-lg hover:shadow-pink-500/30 hover:-translate-y-0.5" title="DM Instagram">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"></path></svg>
                </a>
            </div>

            <div class="flex flex-col items-center">
                <div class="w-full max-w-[150px] bg-slate-100 rounded-full h-1 mb-3 overflow-hidden relative">
                    <div class="absolute left-0 top-0 bg-indigo-500 h-full rounded-full" 
                         x-data="{ width: 0 }" x-init="setTimeout(() => width = 100, 100)" 
                         :style="`width: ${width}%; transition: width 8s linear;`">
                    </div>
                </div>
                <a href="{{ route('member.dashboard', ['tab' => 'layanan']) }}" class="text-[11px] font-bold text-slate-400 hover:text-indigo-600 transition-colors">
                    Kembali ke Dashboard...
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
