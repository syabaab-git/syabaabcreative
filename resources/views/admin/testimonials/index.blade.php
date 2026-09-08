<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                {{ __('Testimoni') }}
            </h2>
            <a href="{{ route('admin.testimonials.create') }}" class="hidden sm:inline-flex items-center px-4 py-2.5 bg-white/75 dark:bg-[#151515]/75 backdrop-blur-3xl border border-white/70 dark:border-white/20 rounded-full font-bold text-xs text-blue-600 dark:text-blue-400 uppercase tracking-widest hover:scale-105 active:scale-95 transition-all duration-300 shadow-[0_8px_25px_rgba(0,0,0,0.08)] dark:shadow-[0_8px_32px_rgba(0,0,0,0.6),_inset_0_1px_1px_rgba(255,255,255,0.25)]">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tambah Testimoni
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm border border-gray-100 sm:rounded-2xl">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Klien</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Isi Testimoni</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Rating</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Featured</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($testimonials as $testimonial)
                                <tr class="hover:bg-gray-50/50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($testimonial->avatar)
                                                <div class="h-10 w-10 flex-shrink-0 mr-4">
                                                    <img class="h-10 w-10 rounded-full object-cover border border-gray-200" src="{{ asset('storage/' . $testimonial->avatar) }}" alt="{{ $testimonial->name }}">
                                                </div>
                                            @else
                                                <div class="h-10 w-10 flex-shrink-0 mr-4 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-500 font-bold">
                                                    {{ substr($testimonial->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900">{{ $testimonial->name }}</div>
                                                <div class="text-xs text-gray-500 mt-0.5">
                                                    {{ $testimonial->role ?? 'Klien' }}
                                                    @if($testimonial->course)
                                                        - {{ $testimonial->course->title }}
                                                    @elseif($testimonial->service)
                                                        - {{ $testimonial->service->title }}
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-600 italic max-w-sm truncate">"{{ $testimonial->message }}"</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $testimonial->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            @endfor
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($testimonial->is_featured)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                Featured
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                                Biasa
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-900 mr-3 transition-colors bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus testimoni ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center text-red-600 hover:text-red-900 transition-colors bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg">
                                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                                            <p class="text-sm font-medium">Tidak ada testimoni yang ditemukan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($testimonials->hasPages())
                    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                        {{ $testimonials->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Floating Action Button (Mobile) -->
    <div x-data="{ show: true }"
         x-show="show"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="opacity-0 -translate-x-12 scale-50"
         x-transition:enter-end="opacity-100 translate-x-0 scale-100"
         x-transition:leave="transition ease-in duration-300 transform"
         x-transition:leave-start="opacity-100 translate-x-0 scale-100"
         x-transition:leave-end="opacity-0 -translate-x-12 scale-50"
         class="block sm:hidden fixed bottom-5 left-[4.25rem] z-[9999]" style="bottom: calc(1.25rem + env(safe-area-inset-bottom)) !important;">
        <a href="{{ route('admin.testimonials.create') }}" 
           class="flex items-center justify-center h-11 w-11 bg-white/75 dark:bg-[#151515]/75 backdrop-blur-3xl border border-white/70 dark:border-white/20 rounded-full text-blue-600 dark:text-blue-400 hover:scale-110 active:scale-95 transition-all duration-300 ease-out shadow-[0_8px_25px_rgba(0,0,0,0.08)] dark:shadow-[0_8px_32px_rgba(0,0,0,0.6),_inset_0_1px_1px_rgba(255,255,255,0.25)]">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
        </a>
    </div>
</x-app-layout>
