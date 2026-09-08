<x-settings-layout>
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-extrabold text-slate-800 dark:text-white tracking-tight drop-shadow-sm">Pengaturan Layanan</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 font-medium mt-1">Kelola konfigurasi kontak, media sosial, opsi pembayaran, masukan, dan ulasan pelanggan.</p>
        </div>

        <form action="{{ route('settings.services.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Card 1: WhatsApp Configuration -->
            <div class="bg-white dark:bg-slate-900 rounded-[24px] shadow-sm border border-slate-200/80 dark:border-slate-800 overflow-hidden">
                <div class="p-6 border-b border-slate-100 dark:border-slate-800/80 bg-slate-50/50 dark:bg-slate-900/30 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.3 11.3 0 005.517 5.517l.774-1.548a1 1 0 011.06-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" /></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-800 dark:text-slate-200">Kontak & Media Sosial</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-medium mt-0.5">Atur nomor WhatsApp, akun Instagram, dan template pesan otomatis untuk pelanggan</p>
                    </div>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Nomor WhatsApp Tujuan -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Nomor WhatsApp Tujuan</label>
                        <p class="text-[13px] text-slate-500 dark:text-slate-400 mb-3">Nomor yang akan dihubungi oleh member saat membuat pesanan layanan baru. Gunakan format internasional (contoh: 6281234567890).</p>
                        
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.3 11.3 0 005.517 5.517l.774-1.548a1 1 0 011.06-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" /></svg>
                            </div>
                            <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $settings['whatsapp_number'] ?? '6281234567890') }}" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-850 text-slate-700 dark:text-slate-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm transition-all" placeholder="628..." required>
                        </div>
                        @error('whatsapp_number')
                            <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Instagram URL -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">URL Instagram</label>
                        <p class="text-[13px] text-slate-500 dark:text-slate-400 mb-3">Masukkan URL lengkap profil Instagram usaha Anda (contoh: https://instagram.com/namakun). Akan ditampilkan di seluruh tombol Instagram pada halaman layanan.</p>
                        
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-pink-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            </div>
                            <input type="url" name="social_instagram" value="{{ old('social_instagram', $settings['social_instagram'] ?? '') }}" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-850 text-slate-700 dark:text-slate-300 focus:border-pink-500 focus:ring-1 focus:ring-pink-500 text-sm transition-all" placeholder="https://instagram.com/username">
                        </div>
                        @error('social_instagram')
                            <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Template Pesan -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-1.5">Template Pesan Otomatis</label>
                        <p class="text-[13px] text-slate-500 dark:text-slate-400 mb-3">Pesan yang akan otomatis terisi saat member dialihkan ke WhatsApp. Anda dapat menggunakan variabel otomatis berikut:</p>
                        
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="px-2 py-1 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-[11px] font-mono rounded border border-slate-200 dark:border-slate-700">[Nama]</span>
                            <span class="px-2 py-1 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-[11px] font-mono rounded border border-slate-200 dark:border-slate-700">[Nomor_Pesanan]</span>
                            <span class="px-2 py-1 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-[11px] font-mono rounded border border-slate-200 dark:border-slate-700">[Layanan]</span>
                            <span class="px-2 py-1 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-[11px] font-mono rounded border border-slate-200 dark:border-slate-700">[Harga]</span>
                            <span class="px-2 py-1 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 text-[11px] font-mono rounded border border-slate-200 dark:border-slate-700">[Paket]</span>
                        </div>

                        <textarea name="whatsapp_template" rows="5" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-850 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm transition-all custom-scrollbar text-slate-700 dark:text-slate-300" placeholder="Ketik template pesan di sini..." required>{{ old('whatsapp_template', $settings['whatsapp_template'] ?? "Halo Admin,\n\nSaya [Nama], ingin mengkonfirmasi pesanan layanan saya.\nNomor Pesanan: [Nomor_Pesanan]\nLayanan: [Layanan]\nPaket: [Paket]\nTotal Biaya: [Harga]\n\nMohon informasi lebih lanjut mengenai proses selanjutnya. Terima kasih.") }}</textarea>
                        @error('whatsapp_template')
                            <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Card 2: Payment Configuration -->
            <div class="bg-white dark:bg-slate-900 rounded-[24px] shadow-sm border border-slate-200/80 dark:border-slate-800 overflow-hidden">
                <div class="p-6 border-b border-slate-100 dark:border-slate-800/80 bg-slate-50/50 dark:bg-slate-900/30 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 2v10h8V6H6z" clip-rule="evenodd" /></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-800 dark:text-slate-200">Metode Pembayaran</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-medium mt-0.5">Konfigurasi QRIS dan nomor rekening bank untuk transaksi</p>
                    </div>
                </div>
                <div class="p-6 space-y-6">
                    <!-- QRIS -->
                    <div class="bg-slate-50 dark:bg-slate-900/40 p-5 rounded-2xl border border-slate-200 dark:border-slate-800">
                        <h5 class="text-[13px] font-bold text-slate-700 dark:text-slate-300 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 4a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm2 2V5h1v1H5zm8-2a1 1 0 00-1-1h-3a1 1 0 00-1 1v3a1 1 0 001 1h3a1 1 0 001-1V4zm-2 2V5h1v1h-1zm-6 8a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1v-3zm2 2v-1h1v1H5zm8-2a1 1 0 00-1-1h-3a1 1 0 00-1 1v3a1 1 0 001 1h3a1 1 0 001-1v-3zm-2 2v-1h1v1h-1z" clip-rule="evenodd" /></svg>
                            Pembayaran QRIS
                        </h5>
                        
                        @if(!empty($settings['payment_qris_image']))
                            <div class="mb-4">
                                <p class="text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase mb-2">QRIS Saat Ini:</p>
                                <img src="{{ Storage::url($settings['payment_qris_image']) }}" alt="QRIS" class="w-32 h-32 object-contain bg-white rounded-lg border border-slate-200 dark:border-slate-750 p-2 shadow-sm">
                            </div>
                        @endif
                        
                        <div>
                            <label class="block text-[13px] font-bold text-slate-700 dark:text-slate-300 mb-1.5">Unggah Barcode QRIS</label>
                            <input type="file" name="payment_qris_image" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-amber-50 dark:file:bg-amber-950/40 file:text-amber-700 dark:file:text-amber-400 hover:file:bg-amber-100">
                            @error('payment_qris_image')
                                <p class="mt-1.5 text-sm text-red-600 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Bank Transfer -->
                    <div class="bg-slate-50 dark:bg-slate-900/40 p-5 rounded-2xl border border-slate-200 dark:border-slate-800">
                        <h5 class="text-[13px] font-bold text-slate-700 dark:text-slate-300 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" /><path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" /></svg>
                            Transfer Rekening Bank
                        </h5>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[13px] font-bold text-slate-700 dark:text-slate-300 mb-1.5">Nama Bank</label>
                                <input type="text" name="payment_bank_name" value="{{ old('payment_bank_name', $settings['payment_bank_name'] ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-850 text-slate-700 dark:text-slate-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm transition-all" placeholder="Contoh: BCA / Mandiri">
                                @error('payment_bank_name')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-[13px] font-bold text-slate-700 dark:text-slate-300 mb-1.5">Nomor Rekening</label>
                                <input type="text" name="payment_bank_account" value="{{ old('payment_bank_account', $settings['payment_bank_account'] ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-850 text-slate-700 dark:text-slate-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm transition-all" placeholder="Contoh: 1234567890">
                                @error('payment_bank_account')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label class="block text-[13px] font-bold text-slate-700 dark:text-slate-300 mb-1.5">Atas Nama Pemilik Rekening</label>
                                <input type="text" name="payment_bank_owner" value="{{ old('payment_bank_owner', $settings['payment_bank_owner'] ?? '') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-850 text-slate-700 dark:text-slate-300 focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 text-sm transition-all" placeholder="Contoh: PT. Syabaab Digital">
                                @error('payment_bank_owner')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button (placed outside the card at the bottom of the form) -->
            <div class="flex justify-end pt-2">
                <button type="submit" class="inline-flex items-center justify-center px-8 py-3.5 bg-slate-900 dark:bg-slate-800 text-white hover:bg-white dark:hover:bg-white hover:text-slate-900 dark:hover:text-slate-900 border border-transparent hover:border-slate-900 dark:hover:border-slate-900 font-bold text-sm rounded-2xl hover:shadow-lg hover:-translate-y-0.5 transition-all cursor-pointer">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                    Simpan
                </button>
            </div>
        </form>

        <!-- Card 3: Feedback Email Setting -->
        <form action="{{ route('settings.feedback.store') }}" method="POST">
            @csrf
            <div class="bg-white dark:bg-slate-900 rounded-[24px] shadow-sm border border-slate-200/80 dark:border-slate-800 overflow-hidden">
                <div class="p-6 border-b border-slate-100 dark:border-slate-800/80 bg-slate-50/50 dark:bg-slate-900/30 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-indigo-50 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" /><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" /></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-800 dark:text-slate-200">Masukan & Saran</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 font-medium mt-0.5">Konfigurasi email penerima laporan kritik dan saran dari pengguna</p>
                    </div>
                </div>
                <div class="p-6">
                    <div class="bg-slate-50/50 dark:bg-slate-900/30 rounded-[16px] border border-slate-200 dark:border-slate-800 p-6">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="p-2 rounded-lg bg-indigo-100 dark:bg-indigo-950/40 text-indigo-600 dark:text-indigo-400 shrink-0">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" /><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" /></svg>
                            </div>
                            <div>
                                <h4 class="text-base font-bold text-slate-800 dark:text-slate-200">Email Tujuan Masukan</h4>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Atur alamat email yang akan menerima laporan masukan dan saran dari pengguna.</p>
                            </div>
                        </div>
                        
                        <div class="flex gap-3">
                            <input type="email" name="feedback_email" value="{{ $settings['feedback_email'] ?? '' }}" placeholder="contoh: admin@gmail.com" 
                                class="flex-1 rounded-xl border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-850 text-slate-750 dark:text-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-colors text-sm" required>
                            <button type="submit" class="shrink-0 inline-flex items-center justify-center px-6 py-3 bg-indigo-600 text-white hover:bg-white dark:hover:bg-white hover:text-indigo-600 dark:hover:text-indigo-600 border border-transparent hover:border-indigo-600 dark:hover:border-indigo-600 font-bold text-xs rounded-xl hover:shadow-md hover:-translate-y-0.5 transition-all cursor-pointer">
                                Simpan Email
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Card 4: Ulasan & Testimoni -->
        <div class="bg-white dark:bg-slate-900 rounded-[24px] shadow-sm border border-slate-200/80 dark:border-slate-800 overflow-hidden">
            <div class="p-6 border-b border-slate-100 dark:border-slate-800/80 bg-slate-50/50 dark:bg-slate-900/30 flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-slate-800 dark:text-slate-200">Ulasan & Testimoni</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium mt-0.5">Kelola ulasan pengguna yang akan ditampilkan pada halaman depan</p>
                </div>
            </div>
            <div class="p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div class="flex items-start gap-4">
                    <div class="p-2 rounded-lg bg-amber-100 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 shrink-0">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-800 dark:text-slate-200">Ulasan Pengguna</h3>
                        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola data ulasan dan rating pengguna yang akan ditampilkan pada carousel Landing Page.</p>
                    </div>
                </div>
                <a href="{{ route('admin.testimonials.index') }}" class="shrink-0 inline-flex items-center px-5 py-2.5 border border-slate-300 dark:border-slate-700 shadow-sm text-sm font-semibold rounded-xl text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-900 dark:hover:bg-white hover:text-white dark:hover:text-slate-900 border-slate-300 dark:border-slate-700 hover:border-transparent dark:hover:border-transparent focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                    Kelola Data Ulasan
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        </div>
    </div>
</x-settings-layout>
