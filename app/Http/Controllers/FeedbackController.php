<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\FeedbackMail;
use App\Models\Setting;

class FeedbackController extends Controller
{
    /**
     * Show the form for creating a new feedback.
     */
    public function create()
    {
        return view('feedback.create');
    }

    /**
     * Store a newly created feedback and send email.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        $user = auth()->user();
        
        // Get the destination email from settings, default to config mail if not set
        $destinationEmailSetting = Setting::where('key', 'feedback_email')->first();
        $destinationEmail = $destinationEmailSetting && !empty($destinationEmailSetting->value) 
            ? $destinationEmailSetting->value 
            : config('mail.from.address');

        try {
            if ($destinationEmail) {
                Mail::to($destinationEmail)->send(new FeedbackMail($user, $request->subject, $request->message));
                return redirect()->route('dashboard')->with('success', 'Terima kasih! Masukan & saran Anda telah berhasil dikirim.');
            } else {
                return back()->with('error', 'Gagal mengirim masukan: Email tujuan belum diatur oleh Admin.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim masukan. Pastikan konfigurasi SMTP sudah benar. (' . $e->getMessage() . ')')->withInput();
        }
    }
}
