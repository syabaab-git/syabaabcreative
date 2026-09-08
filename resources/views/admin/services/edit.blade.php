<x-app-layout>
    <div class="py-8 bg-slate-50 dark:bg-black min-h-screen transition-colors duration-300">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- HEADER -->
            <div class="mb-8">
                <h2 class="text-[28px] font-bold text-slate-900 dark:text-white tracking-tight leading-none">Edit Layanan</h2>
            </div>

            <!-- FORM CARD -->
            <div class="bg-white dark:bg-slate-900 rounded-[24px] shadow-sm border border-slate-200/80 dark:border-slate-800 overflow-hidden">
                <div class="p-8">
                    <form id="edit-service-form" method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-[13px] font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Judul Layanan <span class="text-red-500">*</span></label>
                                <input type="text" name="title" id="title" value="{{ old('title', $service->title) }}" class="w-full bg-transparent border-0 border-b-2 border-slate-200 dark:border-slate-800 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[16px] font-medium text-slate-900 dark:text-white transition-colors" required autofocus>
                                @error('title') <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Category -->
                                <div>
                                    <label class="block text-[13px] font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Kategori <span class="text-red-500">*</span></label>
                                    <div x-data="{ open: false, value: '{{ old('service_category_id', $service->service_category_id) }}', label: '{{ $service->category->name ?? 'Pilih Kategori' }}' }" class="relative">
                                        <input type="hidden" name="service_category_id" x-model="value">
                                        <div @click="open = !open" @click.away="open = false" class="w-full bg-transparent border-0 border-b-2 border-slate-200 dark:border-slate-800 px-0 py-2 text-[16px] font-medium text-slate-900 dark:text-white cursor-pointer flex items-center justify-between transition-colors hover:border-indigo-450 dark:hover:border-indigo-500">
                                            <span x-text="label"></span>
                                            <svg class="w-5 h-5 text-slate-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-end="opacity-0 translate-y-2" class="absolute z-50 left-0 right-0 mt-2 bg-white dark:bg-slate-800 rounded-[16px] shadow-xl border border-slate-100 dark:border-slate-700 overflow-hidden" style="display: none;">
                                            <div class="max-h-60 overflow-y-auto p-2">
                                                @foreach($categories as $category)
                                                    <button type="button" @click="value = '{{ $category->id }}'; label = '{{ $category->name }}'; open = false;" class="w-full text-left px-4 py-2.5 rounded-xl hover:bg-indigo-50 dark:hover:bg-indigo-950/40 hover:text-indigo-700 dark:hover:text-indigo-400 transition-colors flex items-center justify-between" :class="value == '{{ $category->id }}' ? 'bg-indigo-50 dark:bg-indigo-950/40 text-indigo-700 dark:text-indigo-400 font-bold' : 'text-slate-750 dark:text-slate-300 font-medium'">
                                                        {{ $category->name }}
                                                        <svg x-show="value == '{{ $category->id }}'" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @error('service_category_id') <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p> @enderror
                                </div>

                                <!-- Estimated Days -->
                                <div>
                                    <label for="estimated_days" class="block text-[13px] font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Estimasi Waktu</label>
                                    <input type="text" name="estimated_days" id="estimated_days" value="{{ old('estimated_days', $service->estimated_days) }}" class="w-full bg-transparent border-0 border-b-2 border-slate-200 dark:border-slate-800 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[16px] font-medium text-slate-900 dark:text-white transition-colors placeholder:text-slate-400 dark:placeholder:text-slate-600" placeholder="Contoh: 3-5 Hari">
                                    @error('estimated_days') <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p> @enderror
                                </div>
                            </div>

                            <!-- Base Price -->
                            <div>
                                <label for="base_price" class="block text-[13px] font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Harga Dasar (Rp) <span class="text-red-500">*</span></label>
                                <div class="relative flex items-center">
                                    <span class="text-[16px] font-medium text-slate-400 dark:text-slate-550 mr-2 border-b-2 border-slate-200 dark:border-slate-800 py-2">Rp</span>
                                    <input type="number" name="base_price" id="base_price" value="{{ old('base_price', $service->base_price) }}" min="0" class="flex-1 bg-transparent border-0 border-b-2 border-slate-200 dark:border-slate-800 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[16px] font-medium text-slate-900 dark:text-white transition-colors" required>
                                </div>
                                @error('base_price') <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <!-- Description -->
                            <div class="pt-4">
                                <label for="description" class="block text-[13px] font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Deskripsi <span class="text-red-500">*</span></label>
                                
                                <input type="hidden" name="description" id="description-hidden">
                                
                                <div class="border border-slate-200 dark:border-slate-800 rounded-2xl overflow-hidden focus-within:ring-2 focus-within:ring-indigo-100/50 dark:focus-within:ring-indigo-950/40 focus-within:border-indigo-400 transition-all bg-white dark:bg-slate-950">
                                    <div id="quill-toolbar" class="border-0 border-b border-slate-100 dark:border-slate-800 bg-slate-50/80 dark:bg-slate-900/50 px-4 py-1.5">
                                        <span class="ql-formats">
                                            <button class="ql-bold"></button>
                                            <button class="ql-italic"></button>
                                            <button class="ql-underline"></button>
                                            <button class="ql-strike"></button>
                                        </span>
                                        <span class="ql-formats">
                                            <button class="ql-list" value="ordered"></button>
                                            <button class="ql-list" value="bullet"></button>
                                        </span>
                                        <span class="ql-formats">
                                            <button class="ql-link"></button>
                                            <button class="ql-clean"></button>
                                        </span>
                                    </div>
                                    <div id="quill-editor" class="bg-white dark:bg-slate-950" style="min-height: 200px; font-family: Inter, sans-serif; font-size: 15px;">{!! old('description', $service->description) !!}</div>
                                </div>
                                @error('description') <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <!-- Packages -->
                            @php
                                $packagesData = [];
                                if (is_array($service->packages)) {
                                    foreach ($service->packages as $key => $value) {
                                        if (is_array($value)) {
                                            // New Format
                                            $packagesData[] = [
                                                'name' => $value['name'] ?? '',
                                                'price' => $value['price'] ?? '',
                                                'estimated_days' => $value['estimated_days'] ?? '',
                                                'description' => $value['description'] ?? ''
                                            ];
                                        } else {
                                            // Legacy Format
                                            $packagesData[] = [
                                                'name' => $key,
                                                'price' => $value,
                                                'estimated_days' => '',
                                                'description' => ''
                                            ];
                                        }
                                    }
                                }
                                if (empty($packagesData)) {
                                    $packagesData[] = ['name' => '', 'price' => '', 'estimated_days' => '', 'description' => ''];
                                }
                            @endphp
                            <div class="pt-4 border-t border-slate-100 dark:border-slate-800" x-data="{ packages: {{ json_encode($packagesData) }} }">
                                <div class="flex items-center justify-between mb-4">
                                    <label class="block text-[13px] font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Detail Paket Layanan <span class="text-slate-400 dark:text-slate-550 font-normal normal-case">(Opsional)</span></label>
                                    <button type="button" @click="packages.push({ name: '', price: '', estimated_days: '', description: '' })" class="text-xs font-bold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 flex items-center gap-1 bg-indigo-50 dark:bg-indigo-950/40 px-3 py-1.5 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        Tambah Paket
                                    </button>
                                </div>
                                
                                <div class="space-y-4">
                                    <template x-for="(pkg, index) in packages" :key="index">
                                        <div class="bg-slate-50 dark:bg-slate-900/40 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm relative">
                                            <button type="button" @click="if(packages.length > 1) packages.splice(index, 1)" class="absolute top-3 right-3 p-1.5 text-slate-455 hover:text-red-500 hover:bg-red-550 dark:hover:bg-red-955/30 rounded-lg transition-colors" :class="{ 'hidden': packages.length <= 1 }">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                            </button>
                                            
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 pr-8">
                                                <div>
                                                    <label class="block text-[12px] font-semibold text-slate-500 dark:text-slate-450 mb-1">Nama Paket</label>
                                                    <input type="text" :name="'package_name['+index+']'" x-model="pkg.name" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 px-3 py-2 text-sm text-slate-900 dark:text-white transition-colors placeholder:text-slate-400 dark:placeholder:text-slate-650" placeholder="Contoh: Basic">
                                                </div>
                                                <div>
                                                    <label class="block text-[12px] font-semibold text-slate-500 dark:text-slate-455 mb-1">Harga (Rp)</label>
                                                    <input type="number" :name="'package_price['+index+']'" x-model="pkg.price" min="0" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 px-3 py-2 text-sm text-slate-900 dark:text-white transition-colors placeholder:text-slate-400" placeholder="0">
                                                </div>
                                                <div class="md:col-span-2">
                                                    <label class="block text-[12px] font-semibold text-slate-500 dark:text-slate-450 mb-1">Estimasi Pengerjaan</label>
                                                    <input type="text" :name="'package_estimated_days['+index+']'" x-model="pkg.estimated_days" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 px-3 py-2 text-sm text-slate-900 dark:text-white transition-colors placeholder:text-slate-400 dark:placeholder:text-slate-650" placeholder="Contoh: 3-5 Hari">
                                                </div>
                                                <div class="md:col-span-2">
                                                    <label class="block text-[12px] font-semibold text-slate-500 dark:text-slate-450 mb-1">Keterangan / Rincian Paket</label>
                                                    <textarea :name="'package_description['+index+']'" x-model="pkg.description" rows="3" class="w-full bg-white dark:bg-slate-950 border border-slate-200 dark:border-slate-800 rounded-xl focus:border-indigo-600 focus:ring-1 focus:ring-indigo-600 px-3 py-2 text-sm text-slate-900 dark:text-white transition-colors placeholder:text-slate-400 dark:placeholder:text-slate-650" placeholder="Fitur A, Fitur B... (Bisa gunakan baris baru)"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                <p class="mt-3 text-xs text-slate-500 dark:text-slate-455 font-medium">*Kosongkan jika layanan ini tidak memiliki paket terpisah. Jika diisi, harga dasar akan tetap digunakan sebagai harga minimum.</p>
                            </div>

                            <!-- Thumbnail -->
                            <div class="pt-4">
                                <label class="block text-[13px] font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-3">Thumbnail</label>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 items-start">
                                    <div class="rounded-3xl overflow-hidden bg-slate-100 dark:bg-slate-950 aspect-video border border-slate-200/60 dark:border-slate-800 relative shadow-sm">
                                        <img id="thumbnail-preview" src="{{ $service->thumbnail ? asset('storage/' . $service->thumbnail) : '' }}" class="w-full h-full object-cover {{ $service->thumbnail ? 'opacity-100' : 'opacity-0' }} transition-opacity duration-300">
                                        <div id="thumbnail-placeholder" class="absolute inset-0 flex items-center justify-center text-slate-300 dark:text-slate-700 {{ $service->thumbnail ? 'hidden' : '' }}">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-center justify-center aspect-video border-2 border-slate-200 dark:border-slate-800 border-dashed rounded-3xl hover:border-indigo-400 hover:bg-indigo-50/50 dark:hover:bg-indigo-950/20 transition-colors bg-slate-50 dark:bg-slate-900/40 cursor-pointer group" onclick="document.getElementById('thumbnail').click()">
                                        <div class="text-center p-6">
                                            <div class="w-12 h-12 bg-white dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto shadow-sm text-indigo-500 mb-3 group-hover:scale-110 transition-transform duration-300">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                            </div>
                                            <span class="text-[14px] font-bold text-slate-700 dark:text-slate-300 block">Klik atau Drag & Drop</span>
                                            <span class="text-[12px] text-slate-500 dark:text-slate-455 block mt-1">PNG, JPG, WEBP (Max 2MB)</span>
                                        </div>
                                        <input id="thumbnail" name="thumbnail" type="file" class="hidden" accept="image/png, image/jpeg, image/jpg, image/webp">
                                    </div>
                                </div>
                                @error('thumbnail') <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p> @enderror
                            </div>

                        <!-- Actions -->
                        <div class="mt-10 pt-6 border-t border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-end gap-3">
                            <a href="{{ route('admin.services.index') }}" class="inline-flex items-center justify-center px-8 py-3.5 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-300 font-bold text-[15px] rounded-2xl hover:bg-slate-50 dark:hover:bg-slate-850 transition-all border border-slate-200 dark:border-slate-800 w-full sm:w-auto">Batal</a>
                            <button type="submit" name="action" value="draft" class="inline-flex items-center justify-center px-8 py-3.5 bg-white dark:bg-slate-900 text-indigo-600 dark:text-indigo-400 font-bold text-[15px] rounded-2xl hover:bg-indigo-50 dark:hover:bg-indigo-950/20 transition-all border border-indigo-200 dark:border-indigo-900/40 w-full sm:w-auto">Simpan Draf</button>
                            <button type="submit" name="action" value="publish" class="inline-flex items-center justify-center px-8 py-3.5 bg-slate-900 dark:bg-slate-800 text-white hover:bg-white dark:hover:bg-white hover:text-slate-900 dark:hover:text-slate-900 border border-transparent hover:border-slate-900 dark:hover:border-slate-900 font-bold text-[15px] rounded-2xl hover:shadow-lg hover:-translate-y-0.5 transition-all w-full sm:w-auto">Terbitkan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Quill Editor Assets -->
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
    <style>
        #quill-editor { border: none !important; }
        .ql-toolbar.ql-snow { border: none !important; border-bottom: 1px solid #f1f5f9 !important; padding: 12px 16px !important; }
        .dark .ql-toolbar.ql-snow { border-bottom: 1px solid #1e293b !important; }
        .ql-container.ql-snow { font-family: 'Inter', sans-serif; font-size: 15px; }
        .ql-editor { padding: 16px 20px; color: #0f172a; }
        .dark .ql-editor { color: #f8fafc; }
        .ql-editor.ql-blank::before { font-style: normal; color: #94a3b8; }
        .dark .ql-editor.ql-blank::before { color: #64748b; }
        .dark .ql-snow .ql-stroke { stroke: #94a3b8; }
        .dark .ql-snow .ql-fill { fill: #94a3b8; }
        .dark .ql-snow .ql-picker { color: #94a3b8; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Quill Editor Init
            const quill = new Quill('#quill-editor', {
                modules: { toolbar: '#quill-toolbar' },
                theme: 'snow',
                placeholder: 'Tuliskan deskripsi layanan di sini...'
            });

            // Update hidden input on form submit (specific to our form ID)
            document.getElementById('edit-service-form').addEventListener('submit', function() {
                document.getElementById('description-hidden').value = quill.root.innerHTML === '<p><br></p>' ? '' : quill.root.innerHTML;
            });
        });

        document.getElementById('thumbnail').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('thumbnail-preview');
                    const placeholder = document.getElementById('thumbnail-placeholder');
                    img.src = e.target.result;
                    img.classList.remove('opacity-0'); img.classList.add('opacity-100');
                    if (placeholder) placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>
