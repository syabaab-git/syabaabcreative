<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Certificate;

class CertificateController extends Controller
{
    public function verify($certificate_number)
    {
        $certificate = Certificate::with(['user', 'course'])
            ->where('certificate_number', $certificate_number)
            ->first();

        if (!$certificate) {
            return redirect()->route('landing')->with('error', 'Sertifikat tidak ditemukan.');
        }

        return view('front.certificates.verify', compact('certificate'));
    }
}
