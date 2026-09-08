<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Sertifikat - Syabaab</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 font-sans antialiased text-slate-900">
    <div class="min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-indigo-600 mb-2">Syabaab Academy</h1>
            <p class="text-slate-500">Portal Verifikasi Sertifikat Resmi</p>
        </div>

        <div class="max-w-md w-full bg-white rounded-2xl shadow-xl overflow-hidden border border-slate-100">
            <div class="bg-green-500 p-6 text-center text-white">
                <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 backdrop-blur-sm">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h2 class="text-2xl font-bold mb-1">Sertifikat Valid</h2>
                <p class="text-green-100 text-sm">Dokumen ini resmi diterbitkan oleh Syabaab Academy</p>
            </div>
            
            <div class="p-6 md:p-8 space-y-6">
                <div>
                    <p class="text-sm text-slate-500 font-medium mb-1">Diberikan kepada</p>
                    <p class="text-xl font-bold text-slate-900">{{ $certificate->user->name }}</p>
                </div>
                
                <div>
                    <p class="text-sm text-slate-500 font-medium mb-1">Telah menyelesaikan kursus</p>
                    <p class="text-lg font-semibold text-indigo-700">{{ $certificate->course->title }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-100">
                    <div>
                        <p class="text-xs text-slate-500 mb-1">ID Sertifikat</p>
                        <p class="font-mono text-sm font-semibold">{{ $certificate->certificate_number }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 mb-1">Tanggal Terbit</p>
                        <p class="text-sm font-semibold">{{ \Carbon\Carbon::parse($certificate->issued_at)->format('d F Y') }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-slate-50 p-4 border-t border-slate-100 text-center">
                <a href="{{ route('landing') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-800 transition-colors">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
        
    </div>
</body>
</html>
