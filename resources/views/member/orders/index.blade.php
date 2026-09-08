<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4">
            <h2 class="text-2xl lg:text-3xl font-extrabold text-slate-800 tracking-tight drop-shadow-sm">
                {{ __('Riwayat Pesanan') }}
            </h2>
            <p class="text-sm font-medium text-slate-500">Pantau status pesanan layanan agensi Anda.</p>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 bg-emerald-50 text-emerald-700 p-4 rounded-xl border border-emerald-100 text-sm font-bold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-[20px] shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50/50 text-[11px] uppercase tracking-wider text-slate-400 font-bold border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4">Nomor Pesanan</th>
                                <th class="px-6 py-4">Layanan</th>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4">Total</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($orders as $order)
                                <tr class="hover:bg-slate-50/80 transition-colors group">
                                    <td class="px-6 py-4 font-bold text-slate-800">{{ $order->order_number }}</td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-800">{{ $order->service->title ?? 'Layanan Khusus' }}</div>
                                        @if($order->package_name)
                                            <div class="text-[12px] text-slate-500 mt-0.5">Paket: {{ $order->package_name }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">{{ $order->created_at->format('d M Y, H:i') }}</td>
                                    <td class="px-6 py-4 font-bold text-slate-800">Rp {{ number_format($order->amount, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-amber-100 text-amber-700',
                                                'processing' => 'bg-blue-100 text-blue-700',
                                                'completed' => 'bg-emerald-100 text-emerald-700',
                                                'cancelled' => 'bg-red-100 text-red-700',
                                            ];
                                            $color = $statusColors[$order->status] ?? 'bg-slate-100 text-slate-700';
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold uppercase tracking-wider {{ $color }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('member.orders.show', $order->order_number) }}" class="inline-flex items-center justify-center px-4 py-2 rounded-xl bg-white border border-slate-200 text-[13px] font-bold text-slate-600 hover:bg-slate-50 hover:text-slate-900 transition-all shadow-sm">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-slate-100">
                                            <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                        </div>
                                        <h3 class="text-[16px] font-bold text-slate-800 mb-1">Belum Ada Pesanan</h3>
                                        <p class="text-[14px] text-slate-500 mb-4">Anda belum memiliki riwayat pemesanan layanan.</p>
                                        <a href="{{ route('front.services') }}" class="inline-flex items-center justify-center px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-[13px] font-bold transition-all shadow-sm">
                                            Jelajahi Layanan
                                        </a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                @if($orders->hasPages())
                    <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
