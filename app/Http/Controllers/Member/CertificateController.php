<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Certificate;
use App\Models\Testimonial;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::with('course')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        // Ambil semua testimoni pengguna untuk kelas yang ada sertifikatnya
        $testimonials = Testimonial::where('user_id', auth()->id())
            ->whereIn('course_id', $certificates->pluck('course_id'))
            ->get()
            ->keyBy('course_id');

        return view('member.certificates.index', compact('certificates', 'testimonials'));
    }

    public function download(Certificate $certificate)
    {
        if ($certificate->user_id !== auth()->id()) {
            abort(403);
        }

        // Cek apakah pengguna sudah memberikan ulasan
        $hasTestimonial = Testimonial::where('user_id', auth()->id())
            ->where('course_id', $certificate->course_id)
            ->exists();

        if (!$hasTestimonial) {
            return back()->with('error', 'Silakan berikan ulasan kursus terlebih dahulu sebelum mengunduh sertifikat.');
        }

        $pdf = Pdf::loadView('certificates.template', compact('certificate'))
            ->setPaper('a4', 'landscape');

        return $pdf->download("Sertifikat-{$certificate->certificate_number}.pdf");
    }
}
