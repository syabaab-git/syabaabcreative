<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <h2 class="font-bold text-2xl text-slate-800 leading-tight tracking-tight">
                    Kelola Kategori Layanan
                </h2>
                <div></div>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-slate-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-[24px] border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="overflow-x-auto custom-scrollbar">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th scope="col" class="px-6 py-5 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest">Nama Kategori</th>
                                <th scope="col" class="px-6 py-5 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest hidden sm:table-cell">Slug</th>
                                <th scope="col" class="px-6 py-5 text-left text-[11px] font-black text-slate-400 uppercase tracking-widest hidden md:table-cell">Deskripsi</th>
                                <th scope="col" class="px-6 py-5 text-right text-[11px] font-black text-slate-400 uppercase tracking-widest">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-100">
                            @forelse ($categories as $category)
                                <tr class="hover:bg-slate-50/50 transition-colors duration-150 group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-[14px] font-bold text-slate-800">{{ $category->name }}</div>
                                        <div class="text-[12px] text-slate-500 font-mono mt-1 sm:hidden">{{ $category->slug }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                        <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-mono font-medium">
                                            {{ $category->slug }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 hidden md:table-cell">
                                        <div class="text-[13px] text-slate-500 max-w-xs truncate">{{ $category->description ?? '-' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="flex items-center justify-end gap-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity duration-200">
                                            <a href="{{ route('admin.service-categories.edit', $category) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-xl transition-colors" title="Edit Kategori">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                            <form action="{{ route('admin.service-categories.destroy', $category) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-2 text-rose-600 hover:bg-rose-50 rounded-xl transition-colors" title="Hapus Kategori">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center text-slate-400">
                                            <div class="w-20 h-20 rounded-full bg-slate-50 flex items-center justify-center mb-4">
                                                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                            </div>
                                            <p class="text-slate-500 font-bold text-lg mb-1">Belum Ada Kategori</p>
                                            <p class="text-sm text-slate-400">Silakan tambahkan kategori layanan baru.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($categories->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $categories->links() }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Floating Action Button for New Category -->
        <div x-data="{ scrolled: false, show: false }"
             x-init="
                if (document.referrer.split('?')[0] === window.location.href.split('?')[0] && document.referrer !== '') {
                    show = true;
                } else {
                    setTimeout(() => show = true, 500);
                }
             "
             x-show="show"
             @scroll.window="scrolled = (window.pageYOffset > 50)"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 -translate-x-12 scale-50"
             x-transition:enter-end="opacity-100 translate-x-0 scale-100"
             x-transition:leave="transition ease-in duration-300 transform"
             x-transition:leave-start="opacity-100 translate-x-0 scale-100"
             x-transition:leave-end="opacity-0 -translate-x-12 scale-50"
             class="fixed bottom-5 left-[4.25rem] sm:left-auto sm:bottom-10 sm:right-10 z-[9999]" style="display: none; bottom: calc(1.25rem + env(safe-area-inset-bottom)) !important;">
             <a href="{{ route('admin.service-categories.create') }}" 
                class="flex items-center h-11 w-11 sm:h-14 bg-white/75 dark:bg-[#151515]/75 backdrop-blur-3xl border border-white/70 dark:border-white/20 rounded-full text-blue-600 dark:text-blue-400 hover:scale-110 sm:hover:scale-105 active:scale-95 focus:outline-none transition-all duration-300 ease-out shadow-[0_8px_25px_rgba(0,0,0,0.08)] dark:shadow-[0_8px_32px_rgba(0,0,0,0.6),_inset_0_1px_1px_rgba(255,255,255,0.25)] overflow-hidden"
                :class="scrolled ? 'w-11 sm:w-14' : 'w-11 sm:w-[210px]'">
                 <div class="flex items-center justify-center w-11 h-11 sm:w-14 sm:h-14 shrink-0">
                     <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                 </div>
                 <span class="hidden sm:inline font-bold text-[16px] whitespace-nowrap transition-opacity duration-500 pl-1 pr-6" :class="scrolled ? 'opacity-0' : 'opacity-100 delay-200'">Tambah Kategori</span>
             </a>
        </div>
    </div>
</x-app-layout>
