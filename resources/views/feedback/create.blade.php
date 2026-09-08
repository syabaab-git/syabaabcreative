<x-app-layout>
    <div class="py-8 bg-slate-50 min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h2 class="text-[28px] font-bold text-slate-900 tracking-tight leading-none">Kirim Masukan</h2>
                <p class="text-[15px] text-slate-500 mt-2">Kami menghargai pendapat, saran, dan laporan masalah Anda.</p>
            </div>
            
            @if(session('error'))
                <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-2xl flex items-start gap-3">
                    <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <span class="text-[14px] font-medium">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-[24px] shadow-sm border border-slate-200/80 overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('feedback.store') }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            <!-- Subject -->
                            <div>
                                <label for="subject" class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Subjek Masukan <span class="text-red-500">*</span></label>
                                <input type="text" name="subject" id="subject" value="{{ old('subject') }}" class="w-full bg-transparent border-0 border-b-2 border-slate-200 focus:border-indigo-600 focus:ring-0 px-0 py-2 text-[16px] font-medium text-slate-900 transition-colors placeholder:text-slate-400" placeholder="Contoh: Laporan Bug pada halaman Video" required autofocus>
                                @error('subject') <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p> @enderror
                            </div>

                            <!-- Message -->
                            <div class="pt-2">
                                <label for="message" class="block text-[13px] font-semibold text-slate-500 uppercase tracking-wider mb-2">Pesan & Detail <span class="text-red-500">*</span></label>
                                <textarea name="message" id="message" rows="6" class="w-full bg-slate-50 border-0 rounded-2xl focus:ring-2 focus:ring-indigo-100 px-4 py-4 text-[15px] text-slate-900 transition-all placeholder:text-slate-400 resize-none" placeholder="Tuliskan masukan, saran, atau detail kendala yang Anda alami..." required>{{ old('message') }}</textarea>
                                @error('message') <p class="mt-2 text-[13px] text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="mt-10 pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-end gap-3">
                            <a href="{{ url()->previous() }}" class="inline-flex items-center justify-center px-8 py-3.5 bg-white text-slate-700 font-bold text-[15px] rounded-2xl hover:bg-slate-50 transition-all border border-slate-200 w-full sm:w-auto">Batal</a>
                            <button type="submit" class="inline-flex items-center justify-center px-8 py-3.5 bg-slate-900 text-white font-bold text-[15px] rounded-2xl hover:bg-indigo-600 hover:shadow-lg hover:-translate-y-0.5 transition-all w-full sm:w-auto">Kirim Masukan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
