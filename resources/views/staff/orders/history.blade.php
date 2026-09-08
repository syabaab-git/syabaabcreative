<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            {{ __('Riwayat Layanan') }}
        </h2>
    </x-slot>

    <div class="py-8 bg-apple-parchment min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-[20px] shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-amber-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800">Riwayat Layanan Selesai</h3>
                    </div>
                </div>

                <div class="p-0">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-slate-400">
                            <thead class="bg-slate-50/50 text-[11px] uppercase tracking-wider text-slate-400 font-bold border-b border-slate-100">
                                <tr>
                                    <th class="px-6 py-4">Nomor Pesanan</th>
                                    <th class="px-6 py-4">Layanan</th>
                                    <th class="px-6 py-4">Klien</th>
                                    <th class="px-6 py-4">Tanggal</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($orders as $order)
                                    <tr class="bg-slate-50/30 hover:bg-slate-50 transition-colors group">
                                        <td class="px-6 py-4 font-bold text-slate-500">{{ $order->order_number }}</td>
                                        <td class="px-6 py-4 font-medium text-slate-400">{{ $order->service->title ?? '-' }}</td>
                                        <td class="px-6 py-4 text-slate-400">{{ $order->customer_name }}</td>
                                        <td class="px-6 py-4 text-slate-400">{{ $order->created_at->format('d M Y') }}</td>
                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[11px] font-bold uppercase tracking-wider {{ $order->status === 'completed' ? 'bg-slate-200 text-slate-600' : 'bg-slate-200 text-slate-600' }}">
                                                Selesai / Nonaktif
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-white border border-slate-200 text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 transition-all font-semibold text-xs shadow-sm">
                                                Detail &rarr;
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                                <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                            </div>
                                            <p class="text-slate-500 text-[14px]">Belum ada data pesanan.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                @if($orders->hasPages())
                    <div class="p-6 border-t border-slate-100">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
