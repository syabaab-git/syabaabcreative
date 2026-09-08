<x-app-layout>
    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h2 class="text-[28px] font-bold text-slate-900 tracking-tight leading-none">Edit Portofolio</h2>
            </div>
            <div class="bg-white rounded-[24px] shadow-sm border border-slate-200/80 overflow-hidden">
                <div class="p-8">
                    <form method="POST" action="{{ route('admin.portfolios.update', $portfolio) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="space-y-6">
                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Nama Proyek <span class="text-red-500">*</span></label>
                                <input type="text" name="title" id="title" value="{{ old('title', $portfolio->title) }}" class="w-full bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[16px] font-medium text-slate-900 transition-colors" required autofocus>
                                @error('title') <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Client Name -->
                                <div>
                                    <label for="client_name" class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Nama Klien <span class="text-red-500">*</span></label>
                                    <input type="text" name="client_name" id="client_name" value="{{ old('client_name', $portfolio->client_name) }}" class="w-full bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[16px] font-medium text-slate-900 transition-colors" required>
                                    @error('client_name') <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p> @enderror
                                </div>
                                <!-- Service -->
                                <div>
                                    <label class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Layanan <span class="text-red-500">*</span></label>
                                    <div x-data="{ open: false, value: '{{ old('service_id', $portfolio->service_id) }}', label: '{{ $portfolio->service->title ?? 'Pilih Layanan' }}' }" class="relative">
                                        <input type="hidden" name="service_id" x-model="value">
                                        <div @click="open = !open" @click.away="open = false" class="w-full bg-transparent border-0 border-b-2 border-slate-200 px-0 py-2 text-[16px] font-medium text-slate-900 cursor-pointer flex items-center justify-between transition-colors hover:border-indigo-400">
                                            <span x-text="label"></span>
                                            <svg class="w-5 h-5 text-slate-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-end="opacity-0 translate-y-2" class="absolute z-50 left-0 right-0 mt-2 bg-white rounded-[16px] shadow-xl border border-slate-100 overflow-hidden" style="display: none;">
                                            <div class="max-h-60 overflow-y-auto p-2">
                                                @foreach($services as $service)
                                                    <button type="button" @click="value = '{{ $service->id }}'; label = '{{ $service->title }}'; open = false;" class="w-full text-left px-4 py-2.5 rounded-xl hover:bg-indigo-50 hover:text-indigo-700 transition-colors flex items-center justify-between" :class="value == '{{ $service->id }}' ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-700 font-medium'">
                                                        {{ $service->title }}
                                                        <svg x-show="value == '{{ $service->id }}'" class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @error('service_id') <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <!-- URL Proyek -->
                            <div>
                                <label for="project_url" class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">URL Proyek <span class="text-slate-400 font-normal normal-case">(Opsional)</span></label>
                                <input type="url" name="project_url" id="project_url" value="{{ old('project_url', $portfolio->project_url) }}" class="w-full bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[16px] font-medium text-slate-900 transition-colors placeholder:text-slate-400" placeholder="https://example.com">
                                @error('project_url') <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <!-- Description -->
                            <div class="pt-2">
                                <label for="description" class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Deskripsi Proyek <span class="text-red-500">*</span></label>
                                <textarea name="description" id="description" rows="5" class="w-full bg-slate-50 border-0 rounded-2xl focus:ring-2 focus:ring-indigo-100 px-4 py-4 text-[15px] text-slate-900 transition-all placeholder:text-slate-400 resize-none" required>{{ old('description', $portfolio->description) }}</textarea>
                                @error('description') <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <!-- Thumbnail -->
                            <div class="pt-4">
                                <label class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-3">Thumbnail</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-start">
                                    <div class="rounded-3xl overflow-hidden bg-slate-100 aspect-video border border-slate-200/60 relative shadow-sm">
                                        <img id="thumbnail-preview" src="{{ $portfolio->thumbnail ? asset('storage/' . $portfolio->thumbnail) : '' }}" class="w-full h-full object-cover {{ $portfolio->thumbnail ? 'opacity-100' : 'opacity-0' }} transition-opacity duration-300">
                                        <div id="thumbnail-placeholder" class="absolute inset-0 flex items-center justify-center text-slate-300 {{ $portfolio->thumbnail ? 'hidden' : '' }}">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-center justify-center aspect-video border-2 border-slate-200 border-dashed rounded-3xl hover:border-indigo-400 hover:bg-indigo-50/50 transition-colors bg-slate-50 cursor-pointer group" onclick="document.getElementById('thumbnail').click()">
                                        <div class="text-center p-6">
                                            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center mx-auto shadow-sm text-indigo-500 mb-3 group-hover:scale-110 transition-transform duration-300"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg></div>
                                            <span class="text-[14px] font-bold text-slate-700 block">Klik atau Drag & Drop</span>
                                            <span class="text-[12px] text-slate-500 block mt-1">PNG, JPG, WEBP (Max 2MB)</span>
                                        </div>
                                        <input id="thumbnail" name="thumbnail" type="file" class="hidden" accept="image/png, image/jpeg, image/jpg, image/webp">
                                    </div>
                                </div>
                                @error('thumbnail') <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <!-- Featured Toggle -->
                            <div class="flex items-center justify-between border-t border-slate-100 pt-6" x-data="{ on: {{ old('is_featured', $portfolio->is_featured) ? 'true' : 'false' }} }">
                                <div>
                                    <h3 class="font-bold text-slate-900 text-[16px]">Portofolio Unggulan</h3>
                                    <p class="text-[13px] text-slate-500">Jika aktif, portofolio ini akan ditampilkan di halaman utama.</p>
                                </div>
                                <div class="flex items-center">
                                    <button type="button" @click="on = !on" :class="on ? 'bg-indigo-600' : 'bg-slate-200'" class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">
                                        <input type="hidden" name="is_featured" :value="on ? '1' : '0'">
                                        <span aria-hidden="true" :class="on ? 'translate-x-5' : 'translate-x-0'" class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition-transform duration-300 ease-in-out"></span>
                                    </button>
                                    <span class="ml-3 text-[14px] font-bold transition-colors" :class="on ? 'text-indigo-600' : 'text-slate-700'" x-text="on ? 'Featured' : 'Biasa'"></span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-10 pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-end gap-3">
                            <a href="{{ route('admin.portfolios.index') }}" class="inline-flex items-center justify-center px-8 py-3.5 bg-white text-slate-700 font-bold text-[15px] rounded-2xl hover:bg-slate-50 transition-all border border-slate-200 w-full sm:w-auto">Batal</a>
                            <button type="submit" class="inline-flex items-center justify-center px-8 py-3.5 bg-slate-900 text-white font-bold text-[15px] rounded-2xl hover:bg-indigo-600 hover:shadow-lg hover:-translate-y-0.5 transition-all w-full sm:w-auto">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('thumbnail').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('thumbnail-preview');
                    const ph = document.getElementById('thumbnail-placeholder');
                    img.src = e.target.result; img.classList.remove('opacity-0'); img.classList.add('opacity-100');
                    if (ph) ph.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>
