<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-slate-800 leading-tight">
            Sertifikat Saya
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($certificates as $cert)
                    <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-200 hover:shadow-md transition-shadow">
                        <div class="aspect-[4/3] bg-gradient-to-br from-indigo-500 to-purple-600 p-6 flex flex-col justify-between text-white relative overflow-hidden">
                            <!-- Background decoration -->
                            <div class="absolute -right-10 -top-10 w-32 h-32 bg-white opacity-10 rounded-full"></div>
                            <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-white opacity-10 rounded-full"></div>
                            
                            <div class="relative z-10 flex justify-between items-start">
                                <div>
                                    <h3 class="font-bold text-lg leading-tight">{{ $cert->course->title }}</h3>
                                    <p class="text-indigo-100 text-xs mt-1">Sertifikat Kelulusan</p>
                                </div>
                                <svg class="w-8 h-8 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                            </div>
                            
                            <div class="relative z-10">
                                <p class="text-sm font-medium mb-1">Diberikan kepada:</p>
                                <p class="text-xl font-bold font-serif">{{ $cert->user->name }}</p>
                            </div>
                        </div>
                        
                        <div class="p-5 border-t border-slate-100 bg-slate-50 flex flex-col gap-3">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-500">ID Sertifikat</span>
                                <span class="font-mono font-bold text-slate-700">{{ $cert->certificate_number }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-500">Tanggal Terbit</span>
                                <span class="font-medium text-slate-700">{{ \Carbon\Carbon::parse($cert->issued_at)->format('d M Y') }}</span>
                            </div>
                            
                            @php
                                $testimonial = $testimonials->get($cert->course_id);
                            @endphp

                            <div class="pt-3 mt-1 border-t border-slate-200 grid grid-cols-2 gap-3">
                                @if($testimonial)
                                    <a href="{{ route('member.certificates.download', $cert) }}" class="flex items-center justify-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        Unduh PDF
                                    </a>
                                    <a href="{{ route('certificates.verify', $cert->certificate_number) }}" target="_blank" class="flex items-center justify-center gap-2 px-4 py-2 bg-white border border-slate-300 text-slate-700 rounded-lg text-sm font-semibold hover:bg-slate-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        Verifikasi
                                    </a>
                                    <a href="{{ route('member.testimonials.index', ['type' => 'course', 'id' => $cert->course_id]) }}" class="flex items-center justify-center gap-2 px-4 py-2 bg-slate-200 text-slate-700 rounded-lg text-sm font-semibold hover:bg-slate-300 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Edit Ulasan
                                    </a>
                                    <form action="{{ route('member.testimonials.destroy', $testimonial) }}" method="POST" class="w-full">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-red-50 text-red-600 rounded-lg text-sm font-semibold hover:bg-red-100 transition-colors" onclick="return confirm('Yakin ingin menghapus ulasan ini? Anda tidak bisa mengunduh sertifikat hingga memberikan ulasan baru.')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Hapus Ulasan
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('member.testimonials.index', ['type' => 'course', 'id' => $cert->course_id]) }}" class="flex items-center justify-center gap-2 px-4 py-2 bg-amber-500 text-white rounded-lg text-sm font-semibold hover:bg-amber-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                                        Beri Ulasan
                                    </a>
                                    <a href="{{ route('certificates.verify', $cert->certificate_number) }}" target="_blank" class="flex items-center justify-center gap-2 px-4 py-2 bg-white border border-slate-300 text-slate-700 rounded-lg text-sm font-semibold hover:bg-slate-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        Verifikasi
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white p-12 text-center rounded-2xl shadow-sm border border-slate-200">
                            <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-900">Belum Ada Sertifikat</h3>
                            <p class="text-slate-500 mt-2 max-w-md mx-auto">Anda belum mendapatkan sertifikat. Selesaikan seluruh materi kursus dan lulus ujian akhir untuk mendapatkan sertifikat.</p>
                            <a href="{{ route('member.dashboard') }}" class="inline-block mt-6 px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition-colors">
                                Lanjutkan Belajar
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</x-app-layout>

