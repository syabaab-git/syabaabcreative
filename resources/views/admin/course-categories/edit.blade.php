<x-app-layout>
    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- HEADER -->
            <div class="mb-8">
                <h2 class="text-[28px] font-bold text-slate-900 tracking-tight leading-none">Edit Kategori Kursus</h2>
            </div>

            <!-- FORM CARD -->
            <div class="bg-white rounded-[24px] shadow-sm border border-slate-200/80 overflow-hidden">
                <div class="p-8">
                    <form method="POST" action="{{ route('admin.course-categories.update', $courseCategory) }}">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name', $courseCategory->name) }}" class="w-full bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[16px] font-medium text-slate-900 transition-colors placeholder:text-slate-400" required autofocus>
                                @error('name')
                                    <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Slug (readonly) -->
                            <div>
                                <label class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Slug <span class="text-slate-400 font-normal normal-case">(otomatis)</span></label>
                                <input type="text" value="{{ $courseCategory->slug }}" class="w-full bg-transparent border-0 border-b-2 border-slate-100 px-0 py-2 text-[15px] text-slate-400 cursor-not-allowed" readonly>
                                <p class="mt-1 text-[12px] text-slate-400">Digunakan untuk URL, dibuat otomatis dari nama.</p>
                            </div>

                            <!-- Description -->
                            <div class="pt-4">
                                <label for="description" class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Deskripsi <span class="text-slate-400 font-normal normal-case">(Opsional)</span></label>
                                <textarea name="description" id="description" rows="4" class="w-full bg-slate-50 border-0 rounded-2xl focus:ring-2 focus:ring-indigo-100 px-4 py-4 text-[15px] text-slate-900 transition-all placeholder:text-slate-400 resize-none" placeholder="Penjelasan singkat mengenai kategori ini...">{{ old('description', $courseCategory->description) }}</textarea>
                                @error('description')
                                    <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-10 pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-end gap-3">
                            <a href="{{ route('admin.course-categories.index') }}" class="inline-flex items-center justify-center px-8 py-3.5 bg-white text-slate-700 font-bold text-[15px] rounded-2xl hover:bg-slate-50 transition-all border border-slate-200 w-full sm:w-auto">Batal</a>
                            <button type="submit" class="inline-flex items-center justify-center px-8 py-3.5 bg-slate-900 text-white font-bold text-[15px] rounded-2xl hover:bg-indigo-600 hover:shadow-lg hover:-translate-y-0.5 transition-all w-full sm:w-auto">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
