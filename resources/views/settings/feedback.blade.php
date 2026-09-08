<x-settings-layout>
    <div class="bg-white rounded-[20px] shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-amber-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-800">Masukan & Saran</h3>
            </div>
        </div>
        <div class="p-6">

            <!-- Feedback Email Setting -->
            <form action="{{ route('settings.feedback.store') }}" method="POST" class="mb-8">
                @csrf
                <div class="bg-slate-50/50 rounded-[16px] border border-slate-200 p-6">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="p-2 rounded-lg bg-indigo-100 text-indigo-600 shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <h4 class="text-base font-bold text-slate-800">Email Tujuan Masukan</h4>
                            <p class="text-sm text-slate-500 mt-1">Atur alamat email (Gmail) yang akan menerima laporan masukan dan saran dari pengguna.</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-3">
                        <input type="email" name="feedback_email" value="{{ $settings['feedback_email'] ?? '' }}" placeholder="contoh: admin@gmail.com" 
                            class="flex-1 rounded-xl border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors text-sm">
                        <button type="submit" class="shrink-0 inline-flex items-center px-5 py-2.5 bg-indigo-600 border border-transparent rounded-xl font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring ring-indigo-300 disabled:opacity-25 transition-all">
                            Simpan Email
                        </button>
                    </div>
                </div>
            </form>

            <!-- Testimonial Management Link (Moved from landing settings) -->
            <div class="bg-white overflow-hidden shadow-sm border border-slate-200 rounded-[16px]">
                <div class="p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex items-start gap-4">
                        <div class="p-2 rounded-lg bg-amber-100 text-amber-600 shrink-0">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-800">Ulasan Pengguna</h3>
                            <p class="text-sm text-slate-500 mt-1">Kelola data ulasan dan rating pengguna yang akan ditampilkan pada carousel Landing Page.</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.testimonials.index') }}" class="shrink-0 inline-flex items-center px-5 py-2.5 border border-slate-300 shadow-sm text-sm font-semibold rounded-xl text-slate-700 bg-white hover:bg-slate-50 hover:text-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                        Kelola Data Ulasan
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-settings-layout>
