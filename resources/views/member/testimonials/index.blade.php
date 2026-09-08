<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-black text-xl text-slate-800 dark:text-white leading-tight">
                Ulasan & Testimoni Saya
            </h2>
        </div>
    </x-slot>

    @php
        $type = request('type');
        $id = request('id');
        $initialTab = $type === 'service' ? 'service' : 'course';
        $initialShowModal = !empty($id) ? 'true' : 'false';
        $initialCourse = ($type === 'course' && !empty($id)) ? $id : 'null';
        $initialService = ($type === 'service' && !empty($id)) ? $id : 'null';
    @endphp

    <div class="py-8 bg-slate-50 dark:bg-black min-h-screen" x-data="{ 
        activeTab: '{{ $initialTab }}', 
        showReviewModal: {{ $initialShowModal }}, 
        selectedCourse: {{ $initialCourse }}, 
        selectedService: {{ $initialService }}, 
        selectedTestimonial: null, 
        rating: 5, 
        message: '', 
        isEdit: false 
    }">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- 2-Column Sidebar Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                
                <!-- Left Column: Vertical Navigation Sidebar (lg:col-span-3) -->
                <div class="lg:col-span-3">
                    <div class="bg-white dark:bg-[#151515] rounded-[24px] border border-slate-200/60 dark:border-white/10 p-4 space-y-1.5 shadow-sm">
                        <p class="text-[9px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest px-3 mb-2">Kategori Ulasan</p>
                        
                        <button @click="activeTab = 'course'" 
                            :class="activeTab === 'course' ? 'bg-indigo-50 dark:bg-indigo-950/40 text-indigo-700 dark:text-indigo-400 border-indigo-100/50 dark:border-indigo-900/30 font-black' : 'text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-255 hover:bg-slate-50 dark:hover:bg-zinc-900/50 border-transparent'" 
                            class="w-full px-4 py-3 text-xs rounded-xl transition-all flex items-center gap-3 border text-left">
                            <svg class="w-4 h-4 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5 7.82v4.2a1 1 0 00.293.707l2 2a1 1 0 001.414 0l2-2A1 1 0 0011 12.02v-4.2l2.394-.82a1 1 0 000-1.84l-3-3.136zm-3.394 6.82v2.793l1 1 1-1V8.9l-2-.793z"/>
                            </svg>
                            <span>Ulasan Kursus</span>
                        </button>
                        
                        <button @click="activeTab = 'service'" 
                            :class="activeTab === 'service' ? 'bg-indigo-50 dark:bg-indigo-950/40 text-indigo-700 dark:text-indigo-400 border-indigo-100/50 dark:border-indigo-900/30 font-black' : 'text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-255 hover:bg-slate-50 dark:hover:bg-zinc-900/50 border-transparent'" 
                            class="w-full px-4 py-3 text-xs rounded-xl transition-all flex items-center gap-3 border text-left">
                            <svg class="w-4 h-4 shrink-0" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Ulasan Jasa & Layanan</span>
                        </button>
                    </div>
                </div>

                <!-- Right Column: Content (lg:col-span-9) -->
                <div class="lg:col-span-9">
                    
                    <!-- TAB 1: ULASAN KURSUS -->
                    <div x-show="activeTab === 'course'" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @forelse($certificates as $cert)
                                <div class="bg-white dark:bg-[#151515] rounded-[24px] border border-slate-200/60 dark:border-white/10 overflow-hidden flex flex-col justify-between shadow-sm hover:shadow-xl hover:border-indigo-400 dark:hover:border-indigo-500/50 transition-all duration-300">
                                    <!-- Card Header -->
                                    <div class="p-6 pb-4">
                                        <span class="px-2.5 py-0.5 bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 rounded-md text-[9px] font-black uppercase tracking-widest border border-indigo-100/50 dark:border-indigo-900/30">Kursus</span>
                                        <h3 class="font-black text-slate-850 dark:text-white text-base leading-snug mt-3 line-clamp-2">{{ $cert->course->title }}</h3>
                                        <p class="text-slate-400 dark:text-slate-500 text-[10px] font-bold mt-1.5">Lulus pada {{ $cert->created_at->format('d M Y') }}</p>
                                    </div>
                                    
                                    <!-- Card Footer -->
                                    <div class="p-6 pt-0 bg-slate-50/40 dark:bg-slate-900/10 border-t border-slate-100 dark:border-white/5 flex flex-col gap-3">
                                        @php
                                            $testimonial = $testimonials->get('course_' . $cert->course_id);
                                        @endphp

                                        @if($testimonial)
                                            <!-- Menampilkan Ulasan yang Ada -->
                                            <div class="bg-white dark:bg-zinc-900/50 p-4 rounded-2xl border border-slate-200/60 dark:border-white/5 mt-4">
                                                <div class="flex items-center gap-0.5 mb-2 text-amber-400">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <svg class="w-3.5 h-3.5 {{ $i <= $testimonial->rating ? 'fill-current' : 'text-slate-200 dark:text-slate-700' }}" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                        </svg>
                                                    @endfor
                                                </div>
                                                <p class="text-xs text-slate-650 dark:text-slate-300 leading-relaxed italic">"{{ $testimonial->message }}"</p>
                                            </div>

                                            <div class="grid grid-cols-2 gap-2">
                                                <button @click="showReviewModal = true; selectedCourse = {{ $cert->course_id }}; selectedService = null; selectedTestimonial = {{ $testimonial->id }}; isEdit = true; rating = {{ $testimonial->rating }}; message = {{ json_encode($testimonial->message) }};" class="flex items-center justify-center gap-1.5 px-3 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-bold transition-colors">
                                                    <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                                    </svg>
                                                    Edit
                                                </button>
                                                <form action="{{ route('member.testimonials.destroy', $testimonial) }}" method="POST" class="inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="w-full flex items-center justify-center gap-1.5 px-3 py-2 bg-red-50 hover:bg-red-100 dark:bg-red-950/20 dark:hover:bg-red-950/40 text-red-600 dark:text-red-400 rounded-xl text-xs font-bold transition-colors" onclick="return confirm('Yakin ingin menghapus ulasan ini?')">
                                                        <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                        </svg>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <button @click="showReviewModal = true; selectedCourse = {{ $cert->course_id }}; selectedService = null; isEdit = false; rating = 5; message = '';" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-colors shadow-md shadow-indigo-600/10 mt-4">
                                                <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                                                </svg>
                                                Beri Ulasan Kursus
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full">
                                    <div class="bg-white dark:bg-[#151515] p-12 text-center rounded-[24px] border border-slate-200/60 dark:border-white/10 shadow-sm">
                                        <div class="w-16 h-16 bg-slate-50 dark:bg-zinc-900 border border-slate-100 dark:border-zinc-800 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400 dark:text-slate-550">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-base font-black text-slate-800 dark:text-white">Belum Ada Sertifikat Kursus</h3>
                                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-2 max-w-sm mx-auto leading-relaxed">Anda belum menyelesaikan kursus apa pun. Selesaikan pembelajaran kursus Anda untuk memberikan ulasan di sini.</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- TAB 2: ULASAN JASA & LAYANAN -->
                    <div x-show="activeTab === 'service'" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @forelse($completedOrders as $order)
                                @if($order->service)
                                    <div class="bg-white dark:bg-[#151515] rounded-[24px] border border-slate-200/60 dark:border-white/10 overflow-hidden flex flex-col justify-between shadow-sm hover:shadow-xl hover:border-indigo-400 dark:hover:border-indigo-500/50 transition-all duration-300">
                                        <!-- Card Header -->
                                        <div class="p-6 pb-4">
                                            <div class="flex items-center justify-between gap-4">
                                                <span class="px-2.5 py-0.5 bg-emerald-50 dark:bg-emerald-950/40 text-emerald-600 dark:text-emerald-400 rounded-md text-[9px] font-black uppercase tracking-widest border border-emerald-100/50 dark:border-emerald-900/30">Layanan</span>
                                                <span class="text-[10px] font-mono font-bold text-slate-400 dark:text-slate-550">#{{ $order->order_number }}</span>
                                            </div>
                                            <h3 class="font-black text-slate-850 dark:text-white text-base leading-snug mt-3 line-clamp-2">{{ $order->service->title }}</h3>
                                            <p class="text-slate-400 dark:text-slate-555 text-[10px] font-bold mt-1.5">Selesai pada {{ $order->updated_at->format('d M Y') }}</p>
                                        </div>
                                        
                                        <!-- Card Footer -->
                                        <div class="p-6 pt-0 bg-slate-50/40 dark:bg-slate-900/10 border-t border-slate-100 dark:border-white/5 flex flex-col gap-3">
                                            @php
                                                $testimonial = $testimonials->get('service_' . $order->service_id);
                                            @endphp

                                            @if($testimonial)
                                                <!-- Menampilkan Ulasan Jasa -->
                                                <div class="bg-white dark:bg-zinc-900/50 p-4 rounded-2xl border border-slate-200/60 dark:border-white/5 mt-4">
                                                    <div class="flex items-center gap-0.5 mb-2 text-amber-400">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <svg class="w-3.5 h-3.5 {{ $i <= $testimonial->rating ? 'fill-current' : 'text-slate-200 dark:text-slate-700' }}" viewBox="0 0 20 20" fill="currentColor">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                            </svg>
                                                        @endfor
                                                    </div>
                                                    <p class="text-xs text-slate-650 dark:text-slate-300 leading-relaxed italic">"{{ $testimonial->message }}"</p>
                                                </div>

                                                <div class="grid grid-cols-2 gap-2">
                                                    <button @click="showReviewModal = true; selectedCourse = null; selectedService = {{ $order->service_id }}; selectedTestimonial = {{ $testimonial->id }}; isEdit = true; rating = {{ $testimonial->rating }}; message = {{ json_encode($testimonial->message) }};" class="flex items-center justify-center gap-1.5 px-3 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-bold transition-colors">
                                                        <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                                        </svg>
                                                        Edit
                                                    </button>
                                                    <form action="{{ route('member.testimonials.destroy', $testimonial) }}" method="POST" class="inline">
                                                        @csrf @method('DELETE')
                                                        <button type="submit" class="w-full flex items-center justify-center gap-1.5 px-3 py-2 bg-red-50 hover:bg-red-100 dark:bg-red-950/20 dark:hover:bg-red-950/40 text-red-600 dark:text-red-400 rounded-xl text-xs font-bold transition-colors" onclick="return confirm('Yakin ingin menghapus ulasan ini?')">
                                                            <svg class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                                            </svg>
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <button @click="showReviewModal = true; selectedCourse = null; selectedService = {{ $order->service_id }}; isEdit = false; rating = 5; message = '';" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-colors shadow-md shadow-indigo-600/10 mt-4">
                                                    <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Beri Ulasan Layanan
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <div class="col-span-full">
                                    <div class="bg-white dark:bg-[#151515] p-12 text-center rounded-[24px] border border-slate-200/60 dark:border-white/10 shadow-sm">
                                        <div class="w-16 h-16 bg-slate-50 dark:bg-zinc-900 border border-slate-100 dark:border-zinc-800 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400 dark:text-slate-500">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-base font-black text-slate-800 dark:text-white">Belum Ada Layanan Selesai</h3>
                                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-2 max-w-sm mx-auto leading-relaxed">Anda belum memiliki riwayat pemesanan jasa yang selesai. Ulasan dapat diberikan setelah pesanan Anda ditandai selesai.</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Dynamic Review Modal (Universal) -->
        <div x-show="showReviewModal" class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
                
                <!-- Backdrop -->
                <div x-show="showReviewModal" 
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
                     class="fixed inset-0 transition-opacity bg-slate-900/40 backdrop-blur-md" 
                     @click="showReviewModal = false; selectedCourse = null; selectedService = null; isEdit = false;"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal Content Card -->
                <div x-show="showReviewModal" 
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     class="inline-block w-full max-w-lg p-6 my-8 overflow-hidden text-left align-middle transition-all transform bg-white dark:bg-[#151515] shadow-2xl rounded-[28px] relative border border-slate-200/60 dark:border-white/10">
                    
                    <button @click="showReviewModal = false; selectedCourse = null; selectedService = null; isEdit = false;" class="absolute top-5 right-5 text-slate-400 hover:text-slate-650 dark:text-slate-500 dark:hover:text-slate-350 transition-colors">
                        <svg class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>

                    <div>
                        <h3 class="text-lg font-black text-slate-800 dark:text-white leading-tight" x-text="isEdit ? 'Edit Ulasan Anda' : (selectedCourse ? 'Beri Ulasan Kursus' : 'Beri Ulasan Layanan')"></h3>
                        <p class="mt-2 text-xs text-slate-400 dark:text-slate-500 leading-relaxed" x-text="selectedCourse ? 'Bagikan pengalaman belajar Anda. Ulasan ini akan membantu siswa lain.' : 'Bagikan pengalaman Anda menggunakan jasa kami. Masukan Anda sangat berharga.'"></p>
                    </div>

                    <form :action="isEdit ? `/member/testimonials/${selectedTestimonial}` : `{{ route('member.testimonials.store') }}`" method="POST" class="mt-6 space-y-6">
                        @csrf
                        <template x-if="isEdit">
                            <input type="hidden" name="_method" value="PUT">
                        </template>
                        
                        <template x-if="selectedCourse">
                            <input type="hidden" name="course_id" :value="selectedCourse">
                        </template>

                        <template x-if="selectedService">
                            <input type="hidden" name="service_id" :value="selectedService">
                        </template>
                        
                        <!-- Rating Stars -->
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2">Rating Kepuasan</label>
                            <div class="flex items-center space-x-1">
                                <template x-for="i in 5">
                                    <button type="button" @click="rating = i" class="focus:outline-none transition-colors text-slate-200 dark:text-slate-800">
                                        <svg class="w-8 h-8" :class="rating >= i ? 'text-amber-400 fill-current' : 'text-slate-200 dark:text-slate-800'" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </button>
                                </template>
                            </div>
                            <input type="hidden" name="rating" :value="rating">
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-2">Ulasan Anda</label>
                            <textarea id="message" name="message" x-model="message" rows="4" class="block w-full rounded-2xl border-slate-200 dark:border-white/10 focus:border-indigo-500 focus:ring focus:ring-indigo-200/50 text-sm p-4 text-slate-800 dark:bg-slate-900 dark:text-white resize-none" placeholder="Tuliskan ulasan jujur Anda..." required></textarea>
                        </div>

                        <!-- Modal Actions -->
                        <div class="mt-6 flex justify-end gap-2.5 pt-4 border-t border-slate-100 dark:border-white/5">
                            <button type="button" @click="showReviewModal = false; selectedCourse = null; selectedService = null; isEdit = false;" class="px-5 py-2.5 text-xs font-bold text-slate-500 dark:text-slate-400 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 rounded-xl transition-colors">
                                Batal
                            </button>
                            <button type="submit" class="px-6 py-2.5 text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl transition-colors shadow-md shadow-indigo-600/10" x-text="isEdit ? 'Simpan Perubahan' : 'Kirim Ulasan'"></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
