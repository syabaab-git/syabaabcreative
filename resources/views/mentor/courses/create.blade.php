<x-app-layout>
    <div class="py-8 bg-slate-50 dark:bg-black min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- BACK BUTTON -->
            <div class="mb-6">
                <a href="{{ route('mentor.courses.index') }}" class="inline-flex items-center text-sm font-semibold text-slate-500 hover:text-indigo-600 transition-colors">
                    <svg class="w-5 h-5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Batal & Kembali
                </a>
            </div>

            <!-- HEADER -->
            <div class="mb-8">
                <h2 class="text-[28px] font-bold text-slate-900 tracking-tight leading-none mb-2">Buat Kelas Baru</h2>
                <p class="text-slate-500 text-[15px]">Isi informasi dasar kelas Anda. Anda bisa menambahkan materi & kuis setelah kelas berhasil dibuat.</p>
            </div>

            <!-- FORM CARD -->
            <div class="bg-white rounded-[24px] shadow-sm border border-slate-200/80 dark:border-white/10 overflow-hidden">
                <div class="p-8">
                    <form method="POST" action="{{ route('mentor.courses.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="space-y-6">
                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-[14px] font-bold text-slate-700 mb-2">Judul Kelas <span class="text-red-500">*</span></label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all bg-slate-50 focus:bg-white text-[15px] py-3 px-4" placeholder="Contoh: Belajar UI/UX Design untuk Pemula" required autofocus>
                                @error('title')
                                    <p class="mt-2 text-[13px] font-semibold text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Category -->
                                <div>
                                    <label for="course_category_id" class="block text-[14px] font-bold text-slate-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <select name="course_category_id" id="course_category_id" class="w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all bg-slate-50 focus:bg-white text-[15px] py-3 px-4 appearance-none" required>
                                            <option value="">Pilih Kategori Keterampilan</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('course_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('course_category_id')
                                        <p class="mt-2 text-[13px] font-semibold text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Level -->
                                <div>
                                    <label for="level" class="block text-[14px] font-bold text-slate-700 mb-2">Tingkat Kesulitan <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <select name="level" id="level" class="w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all bg-slate-50 focus:bg-white text-[15px] py-3 px-4 appearance-none" required>
                                            <option value="beginner" {{ old('level') == 'beginner' ? 'selected' : '' }}>Pemula (Beginner)</option>
                                            <option value="intermediate" {{ old('level') == 'intermediate' ? 'selected' : '' }}>Menengah (Intermediate)</option>
                                            <option value="advanced" {{ old('level') == 'advanced' ? 'selected' : '' }}>Mahir (Advanced)</option>
                                        </select>
                                    </div>
                                    @error('level')
                                        <p class="mt-2 text-[13px] font-semibold text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>


                            <!-- Description -->
                            <div>
                                <label for="description" class="block text-[14px] font-bold text-slate-700 mb-2">Deskripsi Kelas <span class="text-red-500">*</span></label>
                                <textarea name="description" id="description" rows="6" class="w-full rounded-xl border-slate-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all bg-slate-50 focus:bg-white text-[15px] py-3 px-4" placeholder="Jelaskan secara detail apa yang akan dipelajari dalam kelas ini, prasyarat jika ada, dan tujuan akhirnya..." required>{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-2 text-[13px] font-semibold text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Thumbnail Upload -->
                            <div>
                                <label class="block text-[14px] font-bold text-slate-700 mb-2">Gambar Sampul (Thumbnail)</label>
                                <div class="mt-1 flex justify-center px-6 pt-8 pb-10 border-2 border-slate-200 border-dashed rounded-xl hover:border-indigo-400 hover:bg-indigo-50/50 transition-colors bg-slate-50">
                                    <div class="space-y-2 text-center">
                                        <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <div class="flex text-sm text-slate-600 justify-center">
                                            <label for="thumbnail" class="relative cursor-pointer rounded-md font-bold text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                                <span>Upload gambar</span>
                                                <input id="thumbnail" name="thumbnail" type="file" class="sr-only" accept="image/png, image/jpeg, image/jpg, image/webp">
                                            </label>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-[12px] font-medium text-slate-500">PNG, JPG, WEBP maksimal 2MB</p>
                                    </div>
                                </div>
                                @error('thumbnail')
                                    <p class="mt-2 text-[13px] font-semibold text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <!-- Info Banner -->
                        <div class="mt-8 bg-amber-50 rounded-xl p-4 flex gap-3 border border-amber-100">
                            <div class="flex-shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-[13px] font-bold text-amber-800">Perhatian</h4>
                                <p class="text-[13px] text-amber-700 mt-0.5 leading-relaxed">Setelah disimpan, kelas Anda akan berstatus <strong>Draft</strong> dan belum bisa dilihat oleh siswa. Anda bisa menyusun materi, menambahkan kuis, lalu menerbitkannya (Publish) nanti.</p>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-end">
                            <button type="submit" class="inline-flex items-center justify-center px-8 py-3.5 bg-indigo-600 text-white font-bold text-[15px] rounded-xl shadow-lg shadow-indigo-500/30 hover:bg-indigo-700 hover:-translate-y-0.5 hover:shadow-xl transition-all w-full md:w-auto">
                                Simpan Kelas Baru
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>

    <!-- Script for Thumbnail Preview (Optional but nice) -->
    <script>
        document.getElementById('thumbnail').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                const label = e.target.parentElement.querySelector('span');
                label.textContent = fileName;
            }
        });
    </script>
</x-app-layout>
