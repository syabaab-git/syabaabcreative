<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enrollment;

class EnrollmentController extends Controller
{
    /**
     * Show pending class enrollments/approvals.
     */
    public function index(Request $request)
    {
        $enrollments = Enrollment::with(['user', 'course'])->orderBy('created_at', 'desc')->get();
        return view('admin.enrollments.index', [
            'user' => $request->user(),
            'enrollments' => $enrollments,
        ]);
    }

    /**
     * Verify class enrollment.
     */
    public function verify(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $enrollment = Enrollment::findOrFail($id);
        $enrollment->status = $request->status;
        $enrollment->save();

        return back()->with('status', 'Status persetujuan pengguna berhasil diperbarui!');
    }
}
