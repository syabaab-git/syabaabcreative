<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-bold text-xl text-slate-800 dark:text-slate-100 leading-tight">
                {{ __('Transaksi Keuangan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8 bg-apple-parchment dark:bg-black min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('status'))
                <div class="mb-6 bg-emerald-50 dark:bg-emerald-950/30 text-emerald-700 dark:text-emerald-400 p-4 rounded-2xl border border-emerald-100 dark:border-emerald-900/30 text-sm font-medium shadow-sm">
                    {{ session('status') }}
                </div>
            @endif
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="{ selectedTx: null, showAddTransactionModal: false, transactionType: 'income' }">
                
                <!-- LEFT COLUMN: Widgets & Details -->
                <div class="space-y-6">
                    <!-- Summary Widget (Dashboard style, compact and premium) -->
                    <div class="relative rounded-[24px] overflow-hidden bg-gradient-to-br from-emerald-900 via-teal-955 to-slate-900 p-5 border border-white/10 shadow-lg group transition-all duration-300">
                        <!-- Ambient Glow -->
                        <div class="absolute -top-10 -right-10 w-[150px] h-[150px] bg-emerald-500/20 rounded-full blur-[45px] pointer-events-none"></div>
                        <div class="absolute -bottom-10 -left-10 w-[120px] h-[120px] bg-teal-500/15 rounded-full blur-[40px] pointer-events-none"></div>

                        <div class="relative z-10">
                            <!-- Top: Balance (Saldo Bersih) -->
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-emerald-300 text-[10px] font-bold uppercase tracking-widest mb-1 flex items-center gap-1">
                                        Saldo Bersih
                                    </p>
                                    <h2 class="text-2xl font-black text-white leading-none tracking-tight">
                                        Rp{{ number_format($totalIncome - $totalExpense, 0, ',', '.') }}
                                    </h2>
                                </div>
                                <div class="w-9 h-9 rounded-xl bg-white/10 backdrop-blur-md flex items-center justify-center border border-white/10 text-emerald-300">
                                    <!-- Solid Wallet Icon -->
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Bottom: Side-by-Side Pemasukan & Pengeluaran -->
                            <div class="grid grid-cols-2 gap-4 border-t border-white/10 pt-4 mt-4">
                                <!-- Pemasukan -->
                                <div class="min-w-0">
                                    <div class="flex justify-between items-center mb-1">
                                        <p class="text-emerald-300/80 text-[10px] uppercase tracking-wider font-extrabold flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                            Pemasukan
                                        </p>
                                        <button @click="showAddTransactionModal = true; transactionType = 'income'" class="w-6 h-6 rounded-full bg-white/10 hover:bg-white/20 border border-white/10 text-white flex items-center justify-center transition-all hover:scale-110 active:scale-95 shadow-sm focus:outline-none" title="Tambah Pemasukan Manual">
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor"><path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" /></svg>
                                        </button>
                                    </div>
                                    <div class="text-[15px] font-black text-white leading-none truncate">
                                        Rp{{ number_format($totalIncome, 0, ',', '.') }}
                                    </div>
                                </div>

                                <!-- Pengeluaran -->
                                <div class="min-w-0 border-l border-white/10 pl-4">
                                    <div class="flex justify-between items-center mb-1">
                                        <p class="text-rose-300/80 text-[10px] uppercase tracking-wider font-extrabold flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                            Pengeluaran
                                        </p>
                                        <button @click="showAddTransactionModal = true; transactionType = 'expense'" class="w-6 h-6 rounded-full bg-white/10 hover:bg-white/20 border border-white/10 text-white flex items-center justify-center transition-all hover:scale-110 active:scale-95 shadow-sm focus:outline-none" title="Tambah Pengeluaran Manual">
                                            <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor"><path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" /></svg>
                                        </button>
                                    </div>
                                    <div class="text-[15px] font-black text-white leading-none truncate">
                                        Rp{{ number_format($totalExpense, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sticky Container for Details -->
                    <div class="lg:sticky lg:top-[125px] space-y-6">
                        <!-- Detail Widget (Bottom Left) -->
                        <div x-show="selectedTx" 
                             x-transition:enter="transition ease-out duration-300 transform"
                             x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             class="bg-white dark:bg-slate-900 rounded-[20px] p-6 border border-slate-200 dark:border-slate-800 shadow-sm space-y-5 relative overflow-hidden"
                             style="display: none;">
                             
                            <!-- Ambient Glow -->
                            <div class="absolute -right-10 -top-10 w-24 h-24 bg-indigo-500/5 rounded-full blur-2xl pointer-events-none"></div>

                            <div class="flex justify-between items-center pb-3 border-b border-slate-100 dark:border-slate-800">
                                <h4 class="text-xs font-black text-slate-800 dark:text-slate-100 uppercase tracking-widest">Detail Transaksi</h4>
                                <button @click="selectedTx = null" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 p-1 hover:bg-slate-50 dark:hover:bg-slate-800 rounded-lg transition-colors">
                                    <!-- Solid Close Icon -->
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </div>

                            <div class="space-y-4">
                                <!-- Description -->
                                <div>
                                    <span class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest block mb-1">Deskripsi</span>
                                    <p class="text-sm font-bold text-slate-700 dark:text-slate-200 leading-snug" x-text="selectedTx?.description"></p>
                                </div>

                                <!-- Amount & Type -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <span class="text-[10px] font-black text-slate-400 dark:text-slate-550 uppercase tracking-widest block mb-1">Nominal</span>
                                        <p class="text-base font-extrabold" 
                                           :class="selectedTx?.type === 'income' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400'"
                                           x-text="(selectedTx?.type === 'income' ? '+ ' : '- ') + 'Rp ' + selectedTx?.amount"></p>
                                    </div>
                                    <div>
                                        <span class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest block mb-1">Tipe</span>
                                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider mt-1"
                                              :class="selectedTx?.type === 'income' ? 'bg-emerald-100 dark:bg-emerald-500/10 text-emerald-800 dark:text-emerald-400' : 'bg-rose-100 dark:bg-rose-500/10 text-rose-800 dark:text-rose-400'"
                                              x-text="selectedTx?.type === 'income' ? 'Pemasukan' : 'Pengeluaran'"></span>
                                    </div>
                                </div>

                                <!-- Date & Associated Order -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <span class="text-[10px] font-black text-slate-400 dark:text-slate-550 uppercase tracking-widest block mb-1">Tanggal</span>
                                        <p class="text-xs font-bold text-slate-600 dark:text-slate-400" x-text="selectedTx?.date"></p>
                                    </div>
                                    <div>
                                        <span class="text-[10px] font-black text-slate-400 dark:text-slate-505 uppercase tracking-widest block mb-1">Pesanan</span>
                                        <template x-if="selectedTx?.order_number">
                                            <a :href="selectedTx?.order_url" class="inline-flex items-center gap-1 text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 hover:underline mt-0.5">
                                                #<span x-text="selectedTx?.order_number"></span>
                                                <!-- Solid External Link -->
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" />
                                                    <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z" />
                                                </svg>
                                            </a>
                                        </template>
                                        <template x-if="!selectedTx?.order_number">
                                            <span class="text-xs font-semibold text-slate-400 dark:text-slate-550 mt-0.5 block">-</span>
                                        </template>
                                    </div>
                                </div>

                                <!-- Action Button (Show Receipt) -->
                                <template x-if="selectedTx?.has_receipt">
                                    <div class="pt-2 border-t border-slate-100 dark:border-slate-800">
                                        <a :href="selectedTx?.receipt_url" target="_blank" 
                                           class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 dark:bg-indigo-500 hover:bg-indigo-700 dark:hover:bg-indigo-600 text-white font-bold text-xs transition-all duration-200 shadow-md shadow-indigo-600/10 hover:shadow-lg hover:shadow-indigo-600/20 hover:-translate-y-0.5">
                                            <!-- Solid Printer/Receipt -->
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5 4v3h10V4H5zM3 8h14a2 2 0 012 2v5a2 2 0 01-2 2h-2v2a1 1 0 01-1 1H6a1 1 0 01-1-1v-2H3a2 2 0 01-2-2v-5a2 2 0 012-2zm2.5 10h9v-2h-9v2zM17 11a1 1 0 110-2 1 1 0 010 2z" clip-rule="evenodd" />
                                            </svg>
                                            <span x-text="selectedTx?.invoice_file ? 'Tampilkan Invoice' : 'Tampilkan Struk'"></span>
                                        </a>
                                    </div>
                                </template>
                            </div>
                        </div>

                        <!-- Placeholder -->
                        <div x-show="!selectedTx" 
                             x-transition:enter="transition ease-out duration-300"
                             class="bg-slate-50/50 dark:bg-slate-900/40 rounded-[20px] p-8 border border-dashed border-slate-200 dark:border-slate-800 text-center flex flex-col items-center justify-center h-48"
                             style="display: block;">
                            <div class="w-12 h-12 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-400 dark:text-slate-500 mb-3">
                                <!-- Solid Info Circle -->
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <p class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest">Pilih Transaksi</p>
                            <p class="text-xs text-slate-450 dark:text-slate-500 mt-1 max-w-[200px] leading-relaxed">Klik salah satu baris log transaksi di kanan untuk melihat rincian detail & struk.</p>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN: Transaction Log List -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-slate-900 overflow-hidden shadow-sm rounded-[20px] border border-slate-200 dark:border-slate-800">
                        <div class="p-5 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-850/30">
                            <h3 class="text-[15px] font-bold text-slate-800 dark:text-slate-100">Daftar Log Transaksi</h3>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-slate-500 dark:text-slate-400">
                                <thead class="text-xs text-slate-450 dark:text-slate-500 uppercase bg-slate-50/50 dark:bg-slate-850/20 border-b border-slate-100 dark:border-slate-800 font-bold">
                                    <tr>
                                        <th scope="col" class="px-6 py-4">Tanggal</th>
                                        <th scope="col" class="px-6 py-4">Deskripsi</th>
                                        <th scope="col" class="px-6 py-4">Tipe</th>
                                        <th scope="col" class="px-6 py-4 text-right">Nominal</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/40">
                                    @forelse($transactions as $transaction)
                                        <tr @click="selectedTx = {
                                                id: '{{ $transaction->id }}',
                                                date: '{{ $transaction->created_at->format('d M Y H:i') }}',
                                                description: '{{ addslashes($transaction->description) }}',
                                                amount: '{{ number_format($transaction->amount, 0, ',', '.') }}',
                                                type: '{{ $transaction->type }}',
                                                order_number: '{{ $transaction->order ? $transaction->order->order_number : '' }}',
                                                order_url: '{{ $transaction->order ? route('admin.orders.show', $transaction->order) : '' }}',
                                                has_receipt: {{ ($transaction->invoice_file || ($transaction->order && ($transaction->order->receipt_sent_at || $transaction->order->receipt_file))) ? 'true' : 'false' }},
                                                receipt_url: '{{ $transaction->invoice_file ? Storage::url($transaction->invoice_file) : ($transaction->order ? route('admin.orders.receipt.preview', $transaction->order) : '') }}',
                                                invoice_file: '{{ $transaction->invoice_file }}'
                                            }"
                                            class="bg-white dark:bg-slate-900 hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition-colors cursor-pointer group"
                                            :class="selectedTx?.id == '{{ $transaction->id }}' ? 'bg-indigo-50/40 dark:bg-indigo-950/20 hover:bg-indigo-50/40 dark:hover:bg-indigo-950/20' : ''">
                                            
                                            <td class="px-6 py-4 whitespace-nowrap text-slate-500 dark:text-slate-400 font-medium">
                                                {{ $transaction->created_at->format('d M Y H:i') }}
                                            </td>
                                            <td class="px-6 py-4 font-semibold text-slate-750 dark:text-slate-200">
                                                {{ $transaction->description }}
                                            </td>
                                            <td class="px-6 py-4">
                                                @if($transaction->type === 'income')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-emerald-100 dark:bg-emerald-500/10 text-emerald-800 dark:text-emerald-400">
                                                        Pemasukan
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-[10px] font-bold uppercase tracking-wider bg-rose-100 dark:bg-rose-500/10 text-rose-800 dark:text-rose-400">
                                                        Pengeluaran
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-right font-bold {{ $transaction->type === 'income' ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                                                {{ $transaction->type === 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-12 text-center text-slate-400">
                                                <div class="w-12 h-12 bg-slate-50 dark:bg-slate-800/50 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                                    <!-- Solid Wallet Empty State -->
                                                    <svg class="w-6 h-6 text-slate-300 dark:text-slate-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                                                        <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <p class="text-slate-400 dark:text-slate-500 text-xs font-bold uppercase tracking-wider">Belum ada transaksi</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($transactions->hasPages())
                            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800">
                                {{ $transactions->links() }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Add Transaction Modal -->
                <template x-teleport="body">
                    <div x-show="showAddTransactionModal" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4">
                        
                        <!-- Backdrop -->
                        <div x-show="showAddTransactionModal"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0"
                             x-transition:enter-end="opacity-100"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             class="absolute inset-0 bg-slate-900/40 dark:bg-black/60 backdrop-blur-sm"
                             @click="showAddTransactionModal = false"></div>

                        <!-- Modal Content -->
                        <div x-show="showAddTransactionModal"
                             x-transition:enter="transition cubic-bezier(0.16, 1, 0.3, 1) duration-400"
                             x-transition:enter-start="opacity-0 scale-90 translate-y-4"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition cubic-bezier(0.16, 1, 0.3, 1) duration-300"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-90 translate-y-4"
                             class="relative w-full max-w-md bg-white/95 dark:bg-slate-900/95 backdrop-blur-xl rounded-3xl shadow-[0_20px_60px_-15px_rgba(0,0,0,0.1)] border border-slate-200 dark:border-slate-800 p-6 md:p-8 overflow-hidden transform-gpu">
                            
                            <!-- Close Button (Navbar style: circle, blur, border, hover animations) -->
                            <button @click="showAddTransactionModal = false" class="absolute top-5 right-5 h-10 w-10 rounded-full flex items-center justify-center bg-slate-100/50 hover:bg-slate-100 dark:bg-slate-800/50 dark:hover:bg-slate-800 border border-slate-200/50 dark:border-slate-700/50 text-slate-500 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 hover:scale-110 active:scale-95 transition-all duration-300 shadow-sm focus:outline-none">
                                <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor"><path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" /></svg>
                            </button>

                            <div class="mb-6">
                                <h4 class="text-xl font-bold text-slate-800 dark:text-slate-200" x-text="transactionType === 'income' ? 'Tambah Pemasukan Manual' : 'Tambah Pengeluaran Manual'"></h4>
                                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium mt-1">Catat transaksi keuangan Anda secara manual ke dalam sistem.</p>
                            </div>

                            <form action="{{ route('admin.finances.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <input type="hidden" name="type" :value="transactionType">

                                <!-- Nominal (Amount) -->
                                <div>
                                    <label for="amount" class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2">Nominal (Rupiah)</label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-sm font-semibold text-slate-500 dark:text-slate-400">
                                            Rp
                                        </div>
                                        <input type="number" name="amount" id="amount" required min="1" step="any" placeholder="0"
                                               class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/40 text-slate-800 dark:text-slate-250 font-bold focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm transition-all focus:outline-none">
                                    </div>
                                </div>

                                <!-- Tanggal Transaksi (Date Input) -->
                                <div>
                                    <label for="transaction_date" class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2">Tanggal Transaksi (Opsional)</label>
                                    <input type="text" name="transaction_date" id="transaction_date"
                                           class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/40 text-slate-750 dark:text-slate-250 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm transition-all focus:outline-none"
                                           placeholder="Pilih tanggal & waktu...">
                                </div>

                                <!-- Upload Invoice (File Input) -->
                                <div>
                                    <label for="invoice_file" class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2">Unggah Invoice / Nota (Opsional)</label>
                                    <input type="file" name="invoice_file" id="invoice_file" accept="image/*,application/pdf"
                                           class="w-full text-[13px] text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-extrabold file:bg-indigo-50 dark:file:bg-indigo-950/40 file:text-indigo-700 dark:file:text-indigo-400 hover:file:bg-indigo-100 transition-all cursor-pointer">
                                </div>

                                <!-- Deskripsi (Description) -->
                                <div>
                                    <label for="description" class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-2">Keterangan / Deskripsi</label>
                                    <textarea name="description" id="description" required rows="3" placeholder="Masukkan detail transaksi..."
                                              class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/40 text-slate-700 dark:text-slate-250 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm transition-all resize-none focus:outline-none"></textarea>
                                </div>

                                <!-- Actions -->
                                <div class="flex gap-3 pt-2">
                                    <button type="button" @click="showAddTransactionModal = false"
                                            class="flex-1 py-3 px-4 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-750 text-slate-700 dark:text-slate-300 text-sm font-bold rounded-xl transition-all border border-transparent">
                                        Batal
                                    </button>
                                    <button type="submit" 
                                            class="flex-1 py-3 px-4 text-white text-sm font-bold rounded-xl transition-all shadow-sm border border-transparent"
                                            :class="transactionType === 'income' ? 'bg-emerald-600 hover:bg-emerald-700 dark:bg-emerald-600 dark:hover:bg-emerald-500 shadow-emerald-500/10' : 'bg-rose-600 hover:bg-rose-700 dark:bg-rose-600 dark:hover:bg-rose-500 shadow-rose-500/10'">
                                        Simpan Transaksi
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </template>

            </div>

        </div>
    </div>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <style>
            /* Premium custom styling and dark mode styles for Flatpickr */
            .flatpickr-calendar {
                background: rgba(255, 255, 255, 0.75) !important;
                backdrop-filter: blur(16px) !important;
                -webkit-backdrop-filter: blur(16px) !important;
                border: 1px solid rgba(226, 232, 240, 0.8) !important;
                border-radius: 16px !important;
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
                font-family: inherit;
                padding: 12px !important; /* compact padding */
                width: 280px !important; /* ultra-compact width to prevent modal overflows */
                height: auto !important; /* allows time picker at the bottom to render fully without cutoff */
                box-sizing: border-box !important;
            }
            .dark .flatpickr-calendar {
                background: rgba(18, 18, 18, 0.85) !important; /* neutral charcoal dark mode background */
                border-color: rgba(38, 38, 38, 0.8) !important;  /* neutral border zinc-800 */
                box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.5) !important;
            }
            .flatpickr-days {
                width: 256px !important;
            }
            .flatpickr-weekdays {
                width: 256px !important;
            }
            .flatpickr-day {
                border-radius: 6px !important;
                font-size: 12px;
                font-weight: 600;
                color: #334155;
                transition: all 0.15s ease;
                height: 32px !important;
                line-height: 32px !important;
            }
            .dark .flatpickr-day {
                color: #cbd5e1 !important;
            }
            span.flatpickr-weekday {
                font-weight: 700;
                color: #64748b;
                font-size: 10px;
            }
            .dark span.flatpickr-weekday {
                color: #94a3b8 !important;
            }
            /* Header Month & Year Selectors Container */
            .flatpickr-current-month {
                padding: 0 !important;
                display: flex !important;
                flex-direction: row !important;
                flex-wrap: nowrap !important;
                align-items: center !important;
                justify-content: center !important;
                gap: 6px !important;
                height: 28px !important;
                width: 100% !important;
                left: 0 !important;
            }
            /* Month Dropdown and custom Year select styling */
            .flatpickr-current-month .flatpickr-monthDropdown-months,
            .flatpickr-current-month .flatpickr-yearDropdown {
                background-color: rgba(248, 250, 252, 0.95) !important;
                border: 1px solid #cbd5e1 !important;
                border-radius: 8px !important;
                padding: 2px 18px 2px 6px !important;
                color: #1e293b !important;
                font-weight: 700;
                font-size: 12px;
                cursor: pointer;
                outline: none;
                transition: all 0.2s;
                height: 28px;
                line-height: 18px;
                appearance: none !important;
                -webkit-appearance: none !important;
                -moz-appearance: none !important;
                background-repeat: no-repeat !important;
                background-position: right 5px center !important;
                background-size: 8px !important;
                box-sizing: border-box;
                display: inline-block;
            }
            .flatpickr-current-month .flatpickr-monthDropdown-months {
                order: 1 !important; /* Month strictly on the left */
                width: 90px !important;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%2364748b'%3E%3Cpath fill-rule='evenodd' d='M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06z' clip-rule='evenodd'/%3E%3C/svg%3E") !important;
            }
            .flatpickr-current-month .flatpickr-yearDropdown {
                width: 100% !important;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%2364748b'%3E%3Cpath fill-rule='evenodd' d='M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06z' clip-rule='evenodd'/%3E%3C/svg%3E") !important;
            }
            /* Dark Mode Dropdown styles */
            .dark .flatpickr-current-month .flatpickr-monthDropdown-months,
            .dark .flatpickr-current-month .flatpickr-yearDropdown {
                background-color: rgba(24, 24, 27, 0.9) !important; /* Zinc-900 neutral dark background */
                border-color: rgba(63, 63, 70, 0.6) !important;      /* Zinc-700 border */
                color: #e4e4e7 !important;
            }
            .dark .flatpickr-current-month .flatpickr-monthDropdown-months {
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%2394a3b8'%3E%3Cpath fill-rule='evenodd' d='M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06z' clip-rule='evenodd'/%3E%3C/svg%3E") !important;
            }
            .dark .flatpickr-current-month .flatpickr-yearDropdown {
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='%2394a3b8'%3E%3Cpath fill-rule='evenodd' d='M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06z' clip-rule='evenodd'/%3E%3C/svg%3E") !important;
            }
            /* Styling select options for modern elegant look */
            .flatpickr-current-month select option {
                background-color: #ffffff !important;
                color: #1f2937 !important;
            }
            .dark .flatpickr-current-month select option {
                background-color: #18181b !important; /* Zinc-900 neutral black */
                color: #e4e4e7 !important;
            }
            /* Hover styling */
            .flatpickr-current-month .flatpickr-monthDropdown-months:hover,
            .flatpickr-current-month .flatpickr-yearDropdown:hover {
                border-color: #4f46e5 !important;
            }
            .dark .flatpickr-current-month .flatpickr-monthDropdown-months:hover,
            .dark .flatpickr-current-month .flatpickr-yearDropdown:hover {
                border-color: #818cf8 !important;
            }
            /* Styling the custom year selector container */
            .flatpickr-current-month .numInputWrapper {
                order: 2 !important; /* Year strictly on the right */
                width: 65px !important;
                display: inline-block !important;
            }
            .flatpickr-current-month .numInputWrapper span {
                display: none !important; /* hides the default up/down arrows */
            }
            /* Days Styling */
            .flatpickr-day.today {
                border-color: #cbd5e1;
                color: #1e293b;
            }
            .dark .flatpickr-day.today {
                border-color: #475569 !important;
                color: #ffffff !important;
            }
            .flatpickr-day:hover, .flatpickr-day.prevMonthDay:hover, .flatpickr-day.nextMonthDay:hover {
                background: #f1f5f9;
                border-color: #f1f5f9;
                color: #1e293b;
            }
            .dark .flatpickr-day:hover, .dark .flatpickr-day.prevMonthDay:hover, .dark .flatpickr-day.nextMonthDay:hover {
                background: #1e293b !important;
                border-color: #1e293b !important;
                color: #ffffff !important;
            }
            .flatpickr-day.prevMonthDay, .flatpickr-day.nextMonthDay {
                color: #94a3b8;
                opacity: 0.4;
            }
            .dark .flatpickr-day.prevMonthDay, .dark .flatpickr-day.nextMonthDay {
                color: #64748b !important;
                opacity: 0.6;
            }
            .flatpickr-day.selected {
                background: #4f46e5 !important;
                border-color: #4f46e5 !important;
                color: #ffffff !important;
            }
            .dark .flatpickr-day.selected {
                background: #6366f1 !important;
                border-color: #6366f1 !important;
                color: #ffffff !important;
            }
            /* Navigation Arrows styled like Navbar close buttons */
            .flatpickr-months {
                margin-bottom: 8px;
            }
            .flatpickr-months .flatpickr-prev-month,
            .flatpickr-months .flatpickr-next-month {
                width: 28px !important;
                height: 28px !important;
                border-radius: 50% !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                background-color: rgba(241, 245, 249, 0.6) !important;
                border: 1px solid rgba(226, 232, 240, 0.8) !important;
                color: #64748b !important;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
                box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
                top: 12px !important; /* aligns with 12px padding box */
                padding: 0 !important;
            }
            .dark .flatpickr-months .flatpickr-prev-month,
            .dark .flatpickr-months .flatpickr-next-month {
                background-color: rgba(30, 41, 59, 0.6) !important;
                border-color: rgba(71, 85, 105, 0.6) !important;
                color: #cbd5e1 !important;
            }
            .flatpickr-months .flatpickr-prev-month {
                left: 12px !important;
            }
            .flatpickr-months .flatpickr-next-month {
                right: 12px !important;
            }
            .flatpickr-months .flatpickr-prev-month:hover,
            .flatpickr-months .flatpickr-next-month:hover {
                background-color: #ffffff !important;
                border-color: #cbd5e1 !important;
                color: #4f46e5 !important;
                transform: scale(1.1);
            }
            .dark .flatpickr-months .flatpickr-prev-month:hover,
            .dark .flatpickr-months .flatpickr-next-month:hover {
                background-color: rgba(30, 41, 59, 0.95) !important;
                border-color: #475569 !important;
                color: #818cf8 !important;
                transform: scale(1.1);
            }
            .flatpickr-months .flatpickr-prev-month:active,
            .flatpickr-months .flatpickr-next-month:active {
                transform: scale(0.95);
            }
            .flatpickr-months .flatpickr-prev-month svg,
            .flatpickr-months .flatpickr-next-month svg {
                width: 12px !important;
                height: 12px !important;
                vertical-align: middle !important;
                fill: currentColor !important;
            }
            /* Time Picker styling */
            .flatpickr-time {
                border-top: 1px solid rgba(226, 232, 240, 0.8) !important;
                margin-top: 10px !important;
                padding-top: 10px !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                gap: 4px !important;
            }
            .dark .flatpickr-time {
                border-top-color: rgba(38, 38, 38, 0.8) !important;
            }
            .flatpickr-time input {
                font-weight: 700;
                color: #1e293b;
                border-radius: 8px;
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                padding: 4px;
                height: 26px;
                font-size: 12px;
            }
            .dark .flatpickr-time input {
                color: #f1f5f9 !important;
                background: #1e293b !important;
                border-color: #334155 !important;
            }
            .flatpickr-time .flatpickr-time-separator {
                color: #64748b;
                font-weight: 700;
            }
            .dark .flatpickr-time .flatpickr-time-separator {
                color: #94a3b8 !important;
            }
            .flatpickr-time .flatpickr-am-pm {
                font-weight: 700;
                color: #1e293b;
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 8px;
                padding: 2px 6px;
                height: 26px;
                font-size: 12px;
            }
            .dark .flatpickr-time .flatpickr-am-pm {
                color: #f1f5f9 !important;
                background: #1e293b !important;
                border-color: #334155 !important;
            }
            .flatpickr-day.flatpickr-disabled, .flatpickr-day.flatpickr-disabled:hover {
                color: #cbd5e1;
            }
            .dark .flatpickr-day.flatpickr-disabled, .dark .flatpickr-day.flatpickr-disabled:hover {
                color: #475569 !important;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                function initYearDropdown(instance) {
                    const yearInput = instance.currentYearElement;
                    if (yearInput) {
                        const parent = yearInput.parentNode;
                        
                        // Check if select already exists
                        let yearSelect = parent.querySelector('.flatpickr-yearDropdown');
                        if (yearSelect) {
                            yearSelect.value = instance.currentYear;
                            return;
                        }
                        
                        yearSelect = document.createElement('select');
                        yearSelect.className = 'flatpickr-yearDropdown';
                        
                        const currentYear = new Date().getFullYear();
                        const startYear = currentYear - 50; // choices up to 50 years ago
                        const endYear = currentYear + 10;
                        
                        for (let y = startYear; y <= endYear; y++) {
                            const option = document.createElement('option');
                            option.value = y;
                            option.text = y;
                            if (y === instance.currentYear) {
                                option.selected = true;
                            }
                            yearSelect.appendChild(option);
                        }
                        
                        yearInput.style.display = 'none';
                        parent.appendChild(yearSelect);
                        
                        yearSelect.addEventListener('change', function(e) {
                            instance.changeYear(parseInt(e.target.value));
                        });
                    }
                }

                flatpickr("#transaction_date", {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                    altInput: true,
                    altFormat: "d M Y, H:i",
                    time_24hr: true,
                    disableMobile: "true",
                    onReady: function(selectedDates, dateStr, instance) {
                        initYearDropdown(instance);
                    },
                    onMonthChange: function(selectedDates, dateStr, instance) {
                        initYearDropdown(instance);
                        // Brief timeout to ensure DOM update is finalized before binding values
                        setTimeout(() => initYearDropdown(instance), 10);
                    },
                    onYearChange: function(selectedDates, dateStr, instance) {
                        initYearDropdown(instance);
                    },
                    onOpen: function(selectedDates, dateStr, instance) {
                        initYearDropdown(instance);
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
