<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4">
            <h2 class="text-2xl lg:text-3xl font-extrabold text-slate-800 dark:text-white tracking-tight drop-shadow-sm">
                {{ __('Pendaftar Menunggu Persetujuan') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50/50 dark:bg-transparent min-h-screen transition-colors duration-300">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div x-data="{ selectedEnrollment: null }" class="bg-white dark:bg-slate-900 rounded-[20px] shadow-sm border border-slate-200 dark:border-slate-800 overflow-hidden flex flex-col h-[calc(100vh-220px)] relative">


        @if(session('status'))
            <div class="bg-emerald-50 dark:bg-emerald-950/30 text-emerald-700 dark:text-emerald-400 p-4 border-b border-emerald-100 dark:border-emerald-900/30 text-sm font-medium">
                {{ session('status') }}
            </div>
        @endif

        <!-- Table Container -->
        <div class="flex-1 overflow-auto custom-scrollbar">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50/80 dark:bg-slate-900/80 sticky top-0 z-10 backdrop-blur-sm border-b border-slate-200 dark:border-slate-800">
                    <tr>
                        <th class="py-3 px-6 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Pengguna</th>
                        <th class="py-3 px-6 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Kelas</th>
                        <th class="py-3 px-6 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Waktu Daftar</th>
                        <th class="py-3 px-6 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center">Status</th>
                        <th class="py-3 px-6 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($enrollments as $enrollment)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors cursor-pointer group" 
                        @click="selectedEnrollment = {
                            id: {{ $enrollment->id }},
                            userName: '{{ addslashes($enrollment->user->name ?? 'Unknown') }}',
                            userEmail: '{{ addslashes($enrollment->user->email ?? '-') }}',
                            userInitials: '{{ substr($enrollment->user->name ?? '?', 0, 1) }}',
                            courseTitle: '{{ addslashes($enrollment->course->title ?? 'Kelas Terhapus') }}',
                            date: '{{ $enrollment->created_at->format('d M Y, H:i') }}',
                            status: '{{ $enrollment->status }}'
                        }">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-350 font-bold text-xs uppercase">
                                    {{ substr($enrollment->user->name ?? '?', 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800 dark:text-slate-200">{{ $enrollment->user->name ?? 'Unknown' }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ $enrollment->user->email ?? '-' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/30 px-3 py-1 rounded-lg border border-indigo-100 dark:border-indigo-900/50 line-clamp-1 max-w-[200px]" title="{{ $enrollment->course->title ?? 'Kelas Terhapus' }}">
                                {{ $enrollment->course->title ?? 'Kelas Terhapus' }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-sm text-slate-600 dark:text-slate-400">
                            {{ $enrollment->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            @if($enrollment->status === 'approved')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-900/40">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Disetujui
                                </span>
                            @elseif($enrollment->status === 'rejected')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-100 dark:bg-red-950/40 text-red-700 dark:text-red-400 border border-red-200 dark:border-red-900/40">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Ditolak
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-900/40">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Menunggu
                                </span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-center">
                            @if($enrollment->status === 'pending')
                                <div class="flex items-center justify-center gap-2">
                                    <form action="{{ route('admin.enrollments.verify', $enrollment->id) }}" method="POST" @click.stop>
                                        @csrf
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="p-2 bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400 hover:bg-emerald-500 hover:text-white dark:hover:bg-emerald-500 dark:hover:text-white rounded-xl transition-colors border border-emerald-200 dark:border-emerald-900/50 hover:border-emerald-500 dark:hover:border-emerald-500 shadow-sm" title="Setujui">
                                            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" /></svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.enrollments.verify', $enrollment->id) }}" method="POST" @click.stop>
                                        @csrf
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="p-2 bg-red-50 dark:bg-red-950/30 text-red-600 dark:text-red-400 hover:bg-red-500 hover:text-white dark:hover:bg-red-500 dark:hover:text-white rounded-xl transition-colors border border-red-200 dark:border-red-900/50 hover:border-red-500 dark:hover:border-red-500 shadow-sm" title="Tolak">
                                            <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor"><path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" /></svg>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-xs text-slate-400 dark:text-slate-500 font-medium italic">Selesai</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-slate-500 dark:text-slate-400">
                            <svg class="w-12 h-12 text-slate-200 dark:text-slate-700 mx-auto mb-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.5 2A1.5 1.5 0 003 3.5v13A1.5 1.5 0 004.5 18h11a1.5 1.5 0 001.5-1.5V7.621a1.5 1.5 0 00-.44-1.06l-4.12-4.122A1.5 1.5 0 0011.379 2H4.5zm5 5a.75.75 0 01.75-.75h2.5a.75.75 0 010 1.5h-2.5A.75.75 0 019.5 7zm0 3a.75.75 0 01.75-.75h4.5a.75.75 0 010 1.5h-4.5A.75.75 0 019.5 10zm0 3a.75.75 0 01.75-.75h4.5a.75.75 0 010 1.5h-4.5a.75.75 0 01-.75-.75z" clip-rule="evenodd" /></svg>
                            <p class="text-sm font-medium">Belum ada data pendaftaran kelas.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Glassmorphism Popup Modal -->
        <template x-teleport="body">
            <div x-show="selectedEnrollment" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4">
                
                <!-- Backdrop -->
                <div x-show="selectedEnrollment"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="absolute inset-0 bg-slate-900/40 dark:bg-black/60 backdrop-blur-sm"
                     @click="selectedEnrollment = null"></div>

                <!-- Modal Content -->
                <div x-show="selectedEnrollment"
                     x-transition:enter="transition cubic-bezier(0.16, 1, 0.3, 1) duration-400"
                     x-transition:enter-start="opacity-0 scale-90 translate-y-4"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition cubic-bezier(0.16, 1, 0.3, 1) duration-300"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-90 translate-y-4"
                     class="relative w-full max-w-md bg-white/95 dark:bg-slate-900/95 backdrop-blur-xl rounded-3xl shadow-[0_20px_60px_-15px_rgba(0,0,0,0.1)] border border-white/50 dark:border-slate-800 p-6 md:p-8 overflow-hidden transform-gpu">
                    
                    <!-- Close Button -->
                    <button @click="selectedEnrollment = null" class="absolute top-5 right-5 text-slate-400 dark:text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 bg-slate-100/50 dark:bg-slate-800/50 hover:bg-slate-100 dark:hover:bg-slate-800 p-2 rounded-full transition-all">
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor"><path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" /></svg>
                    </button>

                    <div class="text-center mb-6">
                        <div class="w-16 h-16 mx-auto rounded-2xl bg-gradient-to-tr from-indigo-100 to-blue-50 dark:from-indigo-950/50 dark:to-blue-950/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-2xl font-black mb-4 shadow-sm border border-indigo-50 dark:border-indigo-900/50" x-text="selectedEnrollment.userInitials">
                        </div>
                        <h4 class="text-xl font-bold text-slate-800 dark:text-slate-200" x-text="selectedEnrollment.userName"></h4>
                        <p class="text-sm text-slate-500 dark:text-slate-400 font-medium" x-text="selectedEnrollment.userEmail"></p>
                    </div>

                    <div class="bg-slate-50 dark:bg-slate-950/40 rounded-2xl p-4 mb-6 border border-slate-100 dark:border-slate-800 space-y-3">
                        <div>
                            <span class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-1">Mendaftar Kelas</span>
                            <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200" x-text="selectedEnrollment.courseTitle"></span>
                        </div>
                        <div class="flex justify-between items-center pt-3 border-t border-slate-200/60 dark:border-slate-800">
                            <div>
                                <span class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-1">Waktu</span>
                                <span class="block text-sm font-medium text-slate-600 dark:text-slate-300" x-text="selectedEnrollment.date"></span>
                            </div>
                            <div class="text-right">
                                <span class="block text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider mb-1">Status</span>
                                <template x-if="selectedEnrollment.status === 'pending'">
                                    <span class="inline-flex text-xs font-bold text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/40 px-2.5 py-0.5 rounded-lg border border-amber-100 dark:border-amber-900/40">Menunggu</span>
                                </template>
                                <template x-if="selectedEnrollment.status === 'approved'">
                                    <span class="inline-flex text-xs font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/40 px-2.5 py-0.5 rounded-lg border border-emerald-100 dark:border-emerald-900/40">Disetujui</span>
                                </template>
                                <template x-if="selectedEnrollment.status === 'rejected'">
                                    <span class="inline-flex text-xs font-bold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-950/40 px-2.5 py-0.5 rounded-lg border border-red-100 dark:border-red-900/40">Ditolak</span>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <template x-if="selectedEnrollment.status === 'pending'">
                        <div class="flex gap-3">
                            <form :action="'{{ url('admin/enrollments') }}/' + selectedEnrollment.id + '/verify'" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="w-full py-3 px-4 bg-red-50 dark:bg-red-950/30 hover:bg-red-500 text-red-600 dark:text-red-400 hover:text-white text-sm font-bold rounded-xl transition-all border border-red-100 dark:border-red-900/50 hover:border-red-500">
                                    Tolak Akses
                                </button>
                            </form>
                            <form :action="'{{ url('admin/enrollments') }}/' + selectedEnrollment.id + '/verify'" method="POST" class="flex-1">
                                @csrf
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="w-full py-3 px-4 bg-indigo-600 hover:bg-indigo-700 dark:bg-indigo-600 dark:hover:bg-indigo-500 text-white text-sm font-bold rounded-xl transition-all shadow-sm border border-transparent">
                                    Setujui Akses
                                </button>
                            </form>
                        </div>
                    </template>
                    <template x-if="selectedEnrollment.status !== 'pending'">
                        <div class="text-center p-3 bg-slate-50 dark:bg-slate-950/40 text-slate-500 dark:text-slate-400 text-sm font-semibold rounded-xl border border-slate-100 dark:border-slate-800">
                            Pendaftaran ini sudah divetifikasi.
                        </div>
                    </template>
                </div>
            </div>
        </template>
            </div>
        </div>
    </div>
</x-app-layout>
