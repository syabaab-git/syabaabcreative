<x-app-layout>
    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h2 class="text-[28px] font-bold text-slate-900 tracking-tight leading-none">Edit Testimoni</h2>
            </div>
            <div class="bg-white rounded-[24px] shadow-sm border border-slate-200/80 overflow-hidden">
                <div class="p-8">
                    <form method="POST" action="{{ route('admin.testimonials.update', $testimonial) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Name -->
                                <div>
                                    <label for="name" class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Nama Klien <span class="text-red-500">*</span></label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $testimonial->name) }}" class="w-full bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[16px] font-medium text-slate-900 transition-colors" required autofocus>
                                    @error('name') <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p> @enderror
                                </div>
                                <!-- Role -->
                                <div>
                                    <label for="role" class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Jabatan <span class="text-slate-400 font-normal normal-case">(Opsional)</span></label>
                                    <input type="text" name="role" id="role" value="{{ old('role', $testimonial->role) }}" class="w-full bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[16px] font-medium text-slate-900 transition-colors placeholder:text-slate-400" placeholder="Contoh: CEO di PT. XYZ">
                                    @error('role') <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                                <!-- Rating -->
                                <div>
                                    <label class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Rating <span class="text-red-500">*</span></label>
                                    <div x-data="{ open: false, value: '{{ old('rating', $testimonial->rating) }}', get label() { return this.value + ' Bintang'; } }" class="relative">
                                        <input type="hidden" name="rating" x-model="value">
                                        <div @click="open = !open" @click.away="open = false" class="w-full bg-transparent border-0 border-b-2 border-slate-200 px-0 py-2 text-[16px] font-medium text-slate-900 cursor-pointer flex items-center justify-between transition-colors hover:border-indigo-400">
                                            <span x-text="label"></span>
                                            <svg class="w-5 h-5 text-slate-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-end="opacity-0 translate-y-2" class="absolute z-50 left-0 right-0 mt-2 bg-white rounded-[16px] shadow-xl border border-slate-100 overflow-hidden" style="display: none;">
                                            <div class="p-2">
                                                @foreach(['5','4','3','2','1'] as $r)
                                                    <button type="button" @click="value = '{{ $r }}'; open = false;" class="w-full text-left px-4 py-2.5 rounded-xl hover:bg-indigo-50 hover:text-indigo-700 transition-colors flex items-center justify-between" :class="value == '{{ $r }}' ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-700 font-medium'">
                                                        {{ $r }} Bintang
                                                        <svg x-show="value == '{{ $r }}'" class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @error('rating') <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p> @enderror
                                </div>
                                <!-- Course -->
                                <div>
                                    <label class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Kursus <span class="text-slate-400 font-normal normal-case">(Opsional)</span></label>
                                    <div x-data="{ open: false, value: '{{ old('course_id', $testimonial->course_id) }}', label: '{{ $testimonial->course ? Str::limit($testimonial->course->title, 20) : 'Tidak Terkait' }}' }" class="relative">
                                        <input type="hidden" name="course_id" x-model="value">
                                        <div @click="open = !open" @click.away="open = false" class="w-full bg-transparent border-0 border-b-2 border-slate-200 px-0 py-2 text-[16px] font-medium text-slate-900 cursor-pointer flex items-center justify-between transition-colors hover:border-indigo-400">
                                            <span x-text="label" class="truncate"></span>
                                            <svg class="w-5 h-5 text-slate-400 transition-transform duration-200 flex-shrink-0" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-end="opacity-0 translate-y-2" class="absolute z-50 left-0 right-0 mt-2 bg-white rounded-[16px] shadow-xl border border-slate-100 overflow-hidden" style="display: none;">
                                            <div class="max-h-52 overflow-y-auto p-2">
                                                <button type="button" @click="value = ''; label = 'Tidak Terkait'; open = false;" class="w-full text-left px-4 py-2.5 rounded-xl text-slate-500 hover:bg-slate-50 transition-colors">Tidak Terkait</button>
                                                @foreach($courses as $course)
                                                    <button type="button" @click="value = '{{ $course->id }}'; label = '{{ Str::limit($course->title, 20) }}'; open = false;" class="w-full text-left px-4 py-2.5 rounded-xl hover:bg-indigo-50 hover:text-indigo-700 transition-colors flex items-center justify-between" :class="value == '{{ $course->id }}' ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-700 font-medium'">
                                                        {{ Str::limit($course->title, 25) }}
                                                        <svg x-show="value == '{{ $course->id }}'" class="w-4 h-4 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @error('course_id') <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p> @enderror
                                </div>
                                <!-- Service -->
                                <div>
                                    <label class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Layanan <span class="text-slate-400 font-normal normal-case">(Opsional)</span></label>
                                    <div x-data="{ open: false, value: '{{ old('service_id', $testimonial->service_id) }}', label: '{{ $testimonial->service ? Str::limit($testimonial->service->title, 20) : 'Tidak Terkait' }}' }" class="relative">
                                        <input type="hidden" name="service_id" x-model="value">
                                        <div @click="open = !open" @click.away="open = false" class="w-full bg-transparent border-0 border-b-2 border-slate-200 px-0 py-2 text-[16px] font-medium text-slate-900 cursor-pointer flex items-center justify-between transition-colors hover:border-indigo-400">
                                            <span x-text="label" class="truncate"></span>
                                            <svg class="w-5 h-5 text-slate-400 transition-transform duration-200 flex-shrink-0" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                        </div>
                                        <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-end="opacity-0 translate-y-2" class="absolute z-50 left-0 right-0 mt-2 bg-white rounded-[16px] shadow-xl border border-slate-100 overflow-hidden" style="display: none;">
                                            <div class="max-h-52 overflow-y-auto p-2">
                                                <button type="button" @click="value = ''; label = 'Tidak Terkait'; open = false;" class="w-full text-left px-4 py-2.5 rounded-xl text-slate-500 hover:bg-slate-50 transition-colors">Tidak Terkait</button>
                                                @foreach($services as $service)
                                                    <button type="button" @click="value = '{{ $service->id }}'; label = '{{ Str::limit($service->title, 20) }}'; open = false;" class="w-full text-left px-4 py-2.5 rounded-xl hover:bg-indigo-50 hover:text-indigo-700 transition-colors flex items-center justify-between" :class="value == '{{ $service->id }}' ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-700 font-medium'">
                                                        {{ Str::limit($service->title, 25) }}
                                                        <svg x-show="value == '{{ $service->id }}'" class="w-4 h-4 text-indigo-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @error('service_id') <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <!-- Message -->
                            <div class="pt-2">
                                <label for="message" class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Isi Testimoni <span class="text-red-500">*</span></label>
                                <textarea name="message" id="message" rows="4" class="w-full bg-slate-50 border-0 rounded-2xl focus:ring-2 focus:ring-indigo-100 px-4 py-4 text-[15px] text-slate-900 transition-all resize-none" required>{{ old('message', $testimonial->message) }}</textarea>
                                @error('message') <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <!-- Avatar -->
                            <div>
                                <label class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Foto Klien <span class="text-slate-400 font-normal normal-case">(Opsional)</span></label>
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-16 rounded-full bg-slate-100 border border-slate-200 overflow-hidden flex-shrink-0">
                                        <img id="avatar-preview" src="{{ $testimonial->avatar ? asset('storage/' . $testimonial->avatar) : '' }}" class="w-full h-full object-cover {{ $testimonial->avatar ? 'opacity-100' : 'opacity-0' }} transition-opacity duration-300">
                                    </div>
                                    <label for="avatar" class="cursor-pointer inline-flex items-center gap-2 px-4 py-2.5 bg-slate-100 hover:bg-indigo-50 hover:text-indigo-700 text-slate-700 text-[14px] font-semibold rounded-xl transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        Ganti Foto
                                        <input id="avatar" name="avatar" type="file" class="hidden" accept="image/png, image/jpeg, image/jpg, image/webp">
                                    </label>
                                </div>
                                @error('avatar') <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <!-- Featured Toggle -->
                            <div class="flex items-center justify-between border-t border-slate-100 pt-6" x-data="{ on: {{ old('is_featured', $testimonial->is_featured) ? 'true' : 'false' }} }">
                                <div>
                                    <h3 class="font-bold text-slate-900 text-[16px]">Testimoni Unggulan</h3>
                                    <p class="text-[13px] text-slate-500">Jika aktif, testimoni ini akan ditampilkan di halaman utama.</p>
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
                            <a href="{{ route('admin.testimonials.index') }}" class="inline-flex items-center justify-center px-8 py-3.5 bg-white text-slate-700 font-bold text-[15px] rounded-2xl hover:bg-slate-50 transition-all border border-slate-200 w-full sm:w-auto">Batal</a>
                            <button type="submit" class="inline-flex items-center justify-center px-8 py-3.5 bg-slate-900 text-white font-bold text-[15px] rounded-2xl hover:bg-indigo-600 hover:shadow-lg hover:-translate-y-0.5 transition-all w-full sm:w-auto">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('avatar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById('avatar-preview');
                    img.src = e.target.result; img.classList.remove('opacity-0'); img.classList.add('opacity-100');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
</x-app-layout>
