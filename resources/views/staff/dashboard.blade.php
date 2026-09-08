<x-app-layout>
    <div class="py-8 bg-apple-parchment dark:bg-black min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <style>
                @keyframes shimmer {
                    100% { transform: translateX(200%); }
                }
            </style>

            <!-- HERO: Welcome Banner with Ambient Glow -->
            <div class="relative mb-10 rounded-[24px] overflow-hidden bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-800 p-8 md:p-10 border border-white/10"
                 x-data="{ show: false }" x-init="setTimeout(() => show = true, 50)"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-500 transform"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0">
                
                <!-- Ambient Glow -->
                <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-cyan-400/20 rounded-full blur-[120px] pointer-events-none"></div>
                <div class="absolute -bottom-20 -left-20 w-[300px] h-[300px] bg-fuchsia-500/15 rounded-full blur-[100px] pointer-events-none"></div>
                
                <!-- Decorative floating circles -->
                <div class="absolute top-6 right-8 w-20 h-20 border border-white/10 rounded-full pointer-events-none"></div>
                <div class="absolute top-10 right-16 w-10 h-10 border border-white/5 rounded-full pointer-events-none"></div>

                <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                    <div>
                        <p class="text-indigo-200 text-[13px] font-semibold uppercase tracking-widest mb-3">Dashboard Agensi</p>
                        <h1 class="text-[32px] md:text-[40px] font-bold text-white leading-[1.1] tracking-tight mb-2">
                            Selamat bekerja, {{ explode(' ', auth()->user()->name)[0] }}<span class="text-cyan-300">!</span> 🚀
                        </h1>
                        <p class="text-indigo-100 text-[17px] max-w-xl">Pantau pesanan klien dan perbarui kemajuan proyek agensi. Setiap karya yang selesai adalah portofolio terbaik kita.</p>
                    </div>
                </div>
            </div>

            <!-- STAT CARDS (3 columns, staggered) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 mb-10">

                <!-- Pesanan Aktif -->
                <div class="group relative bg-white rounded-[20px] p-6 border border-slate-200/80 hover:border-indigo-200 hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(79,70,229,0.12)] transition-all duration-500 overflow-hidden"
                     x-data="{ show: false }" x-init="setTimeout(() => show = true, 50)"
                     x-show="show"
                     x-transition:enter="transition ease-out duration-500 transform"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="absolute -right-6 -top-6 w-28 h-28 bg-indigo-500/8 rounded-full blur-2xl pointer-events-none group-hover:bg-indigo-500/15 transition-colors duration-500"></div>
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 rounded-[16px] bg-gradient-to-br from-indigo-400 to-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-500/25 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 flex-shrink-0">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <div x-data="{ 
                            newOrders: {{ $newOrders ?? 0 }},
                            init() {
                                if (window.Echo) {
                                    window.Echo.private('staff.dashboard')
                                        .listen('NewServiceOrder', (e) => {
                                            this.newOrders++;
                                        });
                                }
                            }
                        }">
                            <p class="text-[12px] font-bold text-slate-400 uppercase tracking-widest mb-1">Pesanan Aktif</p>
                            <h3 class="text-[32px] font-bold text-slate-900 tracking-tight leading-none" x-text="newOrders"></h3>
                        </div>
                    </div>
                </div>

                <!-- Proyek Aktif -->
                <div class="group relative bg-white rounded-[20px] p-6 border border-slate-200/80 hover:border-amber-200 hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(245,158,11,0.12)] transition-all duration-500 overflow-hidden"
                     x-data="{ show: false }" x-init="setTimeout(() => show = true, 50)"
                     x-show="show"
                     x-transition:enter="transition ease-out duration-500 transform"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="absolute -right-6 -top-6 w-28 h-28 bg-amber-500/8 rounded-full blur-2xl pointer-events-none group-hover:bg-amber-500/15 transition-colors duration-500"></div>
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 rounded-[16px] bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center shadow-lg shadow-amber-500/25 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 flex-shrink-0">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[12px] font-bold text-slate-400 uppercase tracking-widest mb-1">Proyek Berjalan</p>
                            <h3 class="text-[32px] font-bold text-slate-900 tracking-tight leading-none">{{ $activeProjects }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Proyek Selesai -->
                <div class="group relative bg-white rounded-[20px] p-6 border border-slate-200/80 hover:border-emerald-200 hover:-translate-y-1 hover:shadow-[0_20px_40px_rgba(16,185,129,0.12)] transition-all duration-500 overflow-hidden"
                     x-data="{ show: false }" x-init="setTimeout(() => show = true, 150)"
                     x-show="show"
                     x-transition:enter="transition ease-out duration-500 transform"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="absolute -right-6 -top-6 w-28 h-28 bg-emerald-500/8 rounded-full blur-2xl pointer-events-none group-hover:bg-emerald-500/15 transition-colors duration-500"></div>
                    <div class="flex items-center gap-5">
                        <div class="w-14 h-14 rounded-[16px] bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/25 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 flex-shrink-0">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-[12px] font-bold text-slate-400 uppercase tracking-widest mb-1">Proyek Selesai</p>
                            <h3 class="text-[32px] font-bold text-slate-900 tracking-tight leading-none">{{ $completedProjects }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MAIN CONTENT AREA -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6"
                 x-data="{ show: false }" x-init="setTimeout(() => show = true, 50)"
                 x-show="show"
                 x-transition:enter="transition ease-out duration-500 transform"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0">
                
                <!-- My Projects -->
                <div class="bg-white rounded-[20px] shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-indigo-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800">Proyek Saya</h3>
                        </div>
                        <a href="{{ route('staff.orders.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 flex items-center gap-1 transition-colors">
                            Lihat Semua
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                    <div class="p-0">
                        @forelse($myProjects as $project)
                            <div class="p-6 border-b border-slate-50 last:border-0 hover:bg-slate-50 transition-colors">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <h4 class="font-bold text-slate-800">{{ $project->title }}</h4>
                                        <p class="text-[13px] text-slate-500 mt-0.5">Pesanan: {{ $project->order->order_number ?? '-' }}</p>
                                    </div>
                                    <span class="px-2.5 py-1 text-[11px] font-bold uppercase tracking-wider rounded-lg {{ $project->status === 'completed' ? 'bg-emerald-100 text-emerald-700' : ($project->status === 'review' ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700') }}">
                                        {{ str_replace('_', ' ', $project->status) }}
                                    </span>
                                </div>
                                
                                <div class="mt-4 p-4 rounded-xl border border-slate-100 bg-slate-50">
                                    <div class="flex justify-between text-xs mb-2">
                                        <span class="font-bold text-slate-400 uppercase tracking-wider">Progress</span>
                                        <span class="font-black text-indigo-600">{{ $project->progress ?? 0 }}%</span>
                                    </div>
                                    <div class="w-full bg-slate-200/80 rounded-full h-2 overflow-hidden shadow-inner">
                                        <div class="h-full bg-gradient-to-r relative transition-all duration-1000 {{ $project->progress >= 100 ? 'from-emerald-400 to-emerald-500' : 'from-blue-500 to-cyan-400' }}" style="width: {{ $project->progress ?? 0 }}%">
                                            <div class="absolute inset-0 bg-white/20 w-1/2 -skew-x-12 translate-x-full animate-[shimmer_2s_infinite]"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 flex items-center justify-between text-xs text-slate-500">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Tenggat: <strong class="ml-1 {{ $project->deadline && $project->deadline->diffInDays(now()) <= 3 ? 'text-red-500' : 'text-slate-700' }}">{{ $project->deadline ? $project->deadline->format('d M Y') : 'Belum diatur' }}</strong>
                                    </div>
                                    <a href="{{ route('staff.orders.show', $project->order) }}" class="text-indigo-600 font-semibold hover:underline">Kelola &rarr;</a>
                                </div>
                            </div>
                        @empty
                            <div class="p-12 text-center">
                                <div class="w-16 h-16 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                </div>
                                <h4 class="text-[16px] font-bold text-slate-800 mb-1">Belum ada proyek</h4>
                                <p class="text-slate-500 text-[14px]">Anda belum diberikan tugas proyek.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="bg-white rounded-[20px] shadow-sm border border-slate-200 overflow-hidden">
                    <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-amber-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800">Pesanan Klien</h3>
                        </div>
                        <a href="{{ route('staff.orders.index') }}" class="text-sm font-semibold text-amber-600 hover:text-amber-800 flex items-center gap-1 transition-colors">
                            Lihat Semua
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                        </a>
                    </div>
                    <div class="p-0">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm text-slate-600">
                                <thead class="bg-slate-50/50 text-[11px] uppercase tracking-wider text-slate-400 font-bold border-b border-slate-100">
                                    <tr>
                                        <th class="px-6 py-4">Detail Pesanan</th>
                                        <th class="px-6 py-4">Estimasi</th>
                                        <th class="px-6 py-4">Status</th>
                                        <th class="px-6 py-4 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @forelse($recentOrders as $order)
                                        <tr class="hover:bg-slate-50/80 transition-colors group cursor-pointer" onclick="window.location.href='{{ route('staff.orders.show', $order) }}'">
                                            <td class="px-6 py-4">
                                                <div class="font-bold text-slate-800 text-[14px] mb-0.5">{{ $order->order_number }}</div>
                                                <div class="text-[13px] text-slate-500 font-medium">{{ $order->service->title ?? 'Layanan' }}</div>
                                                <div class="text-[12px] text-slate-400 mt-1 flex items-center">
                                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                    {{ $order->customer_name }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-[14px] text-slate-600">
                                                @if($order->estimation_date)
                                                    <span class="font-medium text-slate-800">{{ \Carbon\Carbon::parse($order->estimation_date)->translatedFormat('d M Y') }}</span>
                                                    <span class="text-[12px] text-slate-400 block">{{ \Carbon\Carbon::parse($order->estimation_date)->translatedFormat('H:i') }} WIB</span>
                                                @else
                                                    <span class="text-slate-400 italic">Belum diatur</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold uppercase tracking-wider {{ $order->status === 'completed' ? 'bg-emerald-100 text-emerald-700' : ($order->status === 'processing' ? 'bg-blue-100 text-blue-700' : ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-slate-100 text-slate-700')) }}">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <a href="{{ route('staff.orders.show', $order) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-full bg-white border border-slate-200 text-slate-400 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 transition-all shadow-sm group-hover:shadow">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path></svg>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-6 py-12 text-center">
                                                <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                                    <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                                </div>
                                                <p class="text-slate-500 text-[14px]">Belum ada pesanan masuk.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
