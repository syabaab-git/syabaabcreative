<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\LandingController;
use App\Http\Controllers\Front\CourseController as FrontCourseController;
use App\Http\Controllers\Front\ServiceController as FrontServiceController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Mentor\DashboardController as MentorDashboardController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\OrderUpdateController;

Route::get('/', function () {
    return redirect()->route('login');
})->name('landing');
Route::get('/search', [\App\Http\Controllers\Front\SearchController::class, 'index'])->name('search');

Route::get('/courses', [FrontCourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course:slug}', [FrontCourseController::class, 'show'])->name('courses.show');

Route::get('/services', [FrontServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service:slug}', [FrontServiceController::class, 'show'])->name('services.show');
Route::post('/services/{service:slug}/order', [FrontServiceController::class, 'order'])
    ->middleware('auth')
    ->name('services.order');
Route::get('/services/orders/{order}/success', [FrontServiceController::class, 'success'])
    ->middleware('auth')
    ->name('services.success');

// Public Certificate Verification
Route::get('/certificates/verify/{number}', [\App\Http\Controllers\Front\CertificateController::class, 'verify'])->name('certificates.verify');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();

        return match (true) {
            $user->hasRole('super-admin') => redirect()->route('admin.dashboard'),
            $user->hasRole('mentor') => redirect()->route('mentor.dashboard'),
            $user->hasRole('agency-staff') => redirect()->route('staff.dashboard'),

            default => redirect()->route('member.dashboard'),
        };
    })->name('dashboard');

    Route::post('/order-updates/{order}', [OrderUpdateController::class, 'store'])->name('order-updates.store');
    Route::post('/order-updates/{order}/read', [OrderUpdateController::class, 'markAsRead'])->name('order-updates.read');
    Route::put('/order-updates/{orderUpdate}', [OrderUpdateController::class, 'update'])->name('order-updates.update');
    Route::delete('/order-updates/{orderUpdate}', [OrderUpdateController::class, 'destroy'])->name('order-updates.destroy');

    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-read', [\App\Http\Controllers\NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
    Route::post('/notifications/preview-seen', [\App\Http\Controllers\NotificationController::class, 'previewSeen'])->name('notifications.previewSeen');
    Route::post('/notifications/{id}/mark-read', [\App\Http\Controllers\NotificationController::class, 'markRead'])->name('notifications.markRead');

    // Feedback
    Route::get('/feedback', [\App\Http\Controllers\FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback', [\App\Http\Controllers\FeedbackController::class, 'store'])->name('feedback.store');

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('/', [SettingsController::class, 'index'])->name('index');
        
        // Umum
        Route::get('/profile', [SettingsController::class, 'profile'])->name('profile');
        Route::get('/security', [SettingsController::class, 'security'])->name('security');
        
        // Khusus Admin
        Route::middleware(['role:admin|super-admin'])->group(function () {
            Route::get('/system', [SettingsController::class, 'system'])->name('system');
            Route::get('/services', [SettingsController::class, 'services'])->name('services');
            Route::post('/services', [SettingsController::class, 'servicesStore'])->name('services.store');
            Route::get('/landing', [SettingsController::class, 'landing'])->name('landing');
            Route::post('/landing', [SettingsController::class, 'landingStore'])->name('landing.store');
            Route::get('/receipt', [SettingsController::class, 'receipt'])->name('receipt');
            Route::post('/receipt', [SettingsController::class, 'receiptStore'])->name('receipt.store');
            Route::get('/feedback', [\App\Http\Controllers\SettingsController::class, 'feedback'])->name('feedback');
            Route::post('/feedback', [\App\Http\Controllers\SettingsController::class, 'feedbackStore'])->name('feedback.store');

        });
    });

    // Pertahankan rute update & destroy bawaan Breeze agar form lama tetap berfungsi (API-wise)
    Route::get('/profile', function () {
        return redirect()->route('settings.profile');
    })->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:super-admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/online-users', [AdminDashboardController::class, 'onlineUsers'])->name('online-users');
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
        Route::resource('courses', \App\Http\Controllers\Admin\CourseController::class);
        Route::resource('course-categories', \App\Http\Controllers\Admin\CourseCategoryController::class);
        Route::patch('services/{service}/toggle-status', [\App\Http\Controllers\Admin\ServiceController::class, 'toggleStatus'])->name('services.toggle-status');
        Route::resource('services', \App\Http\Controllers\Admin\ServiceController::class);
        Route::resource('service-categories', \App\Http\Controllers\Admin\ServiceCategoryController::class);
        Route::resource('portfolios', \App\Http\Controllers\Admin\PortfolioController::class);
        Route::resource('testimonials', \App\Http\Controllers\Admin\TestimonialController::class);
        Route::get('orders/history', [\App\Http\Controllers\Admin\OrderController::class, 'history'])->name('orders.history');
        Route::get('orders/success', function() { return view('admin.orders.success'); })->name('orders.success');
        Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class);
        // Receipt actions
        Route::get('orders/{order}/receipt-preview', [\App\Http\Controllers\Admin\ReceiptController::class, 'preview'])->name('orders.receipt.preview');
        Route::post('orders/{order}/generate-receipt', [\App\Http\Controllers\Admin\ReceiptController::class, 'generate'])->name('orders.receipt.generate');
        Route::post('orders/{order}/send-receipt', [\App\Http\Controllers\Admin\ReceiptController::class, 'send'])->name('orders.receipt.send');

        Route::resource('payments', \App\Http\Controllers\Admin\PaymentController::class);
        Route::get('finances', [\App\Http\Controllers\Admin\FinanceController::class, 'index'])->name('finances.index');
        Route::post('finances', [\App\Http\Controllers\Admin\FinanceController::class, 'store'])->name('finances.store');
        
        // Enrollments & Approvals
        Route::get('/enrollments', [\App\Http\Controllers\Admin\EnrollmentController::class, 'index'])->name('enrollments.index');
        Route::post('/enrollments/{id}/verify', [\App\Http\Controllers\Admin\EnrollmentController::class, 'verify'])->name('enrollments.verify');
    });

Route::middleware(['auth', 'role:mentor'])
    ->prefix('mentor')
    ->name('mentor.')
    ->group(function () {
        Route::get('/dashboard', [MentorDashboardController::class, 'index'])->name('dashboard');
        Route::resource('courses', \App\Http\Controllers\Mentor\CourseController::class);
        Route::resource('courses.lessons', \App\Http\Controllers\Mentor\LessonController::class)->except(['index', 'show']);
        Route::patch('courses/{course}/lessons/{lesson}/archive', [\App\Http\Controllers\Mentor\LessonController::class, 'archive'])->name('courses.lessons.archive');
        Route::resource('courses.assignments', \App\Http\Controllers\Mentor\AssignmentController::class)->except(['index']);
        Route::patch('courses/{course}/assignments/{assignment}/archive', [\App\Http\Controllers\Mentor\AssignmentController::class, 'archive'])->name('courses.assignments.archive');
        Route::resource('assignments.submissions', \App\Http\Controllers\Mentor\AssignmentSubmissionController::class)->only(['show', 'update']);
        Route::post('courses/{course}/files', [\App\Http\Controllers\Mentor\CourseFileController::class, 'store'])->name('courses.files.store');
        Route::delete('courses/{course}/files/{file}', [\App\Http\Controllers\Mentor\CourseFileController::class, 'destroy'])->name('courses.files.destroy');
    });

Route::middleware(['auth', 'role:agency-staff'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {
        Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');
        Route::get('orders/history', [\App\Http\Controllers\Staff\OrderController::class, 'history'])->name('orders.history');
        Route::get('orders/success', function() { return view('staff.orders.success'); })->name('orders.success');
        Route::resource('orders', \App\Http\Controllers\Staff\OrderController::class);

    });

Route::middleware(['auth', 'role:member'])
    ->prefix('member')
    ->name('member.')
    ->group(function () {
        Route::get('/dashboard', [MemberDashboardController::class, 'index'])->name('dashboard');
        Route::get('/learning/{course:slug}', [\App\Http\Controllers\Member\LearningController::class, 'show'])->name('learning.show');
        Route::get('/learning/{course:slug}/completed', [\App\Http\Controllers\Member\LearningController::class, 'completed'])->name('learning.completed');
        Route::post('/learning/{lesson}/complete', [\App\Http\Controllers\Member\LearningController::class, 'complete'])->name('learning.complete');
        
        // Assignments
        Route::get('/learning/{course:slug}/assignment/{assignment}', [\App\Http\Controllers\Member\AssignmentController::class, 'show'])->name('learning.assignment.show');
        Route::post('/learning/{course:slug}/assignment/{assignment}', [\App\Http\Controllers\Member\AssignmentController::class, 'store'])->name('learning.assignment.store');
        
        // Leaderboard
        Route::get('/leaderboard', [\App\Http\Controllers\Member\LeaderboardController::class, 'index'])->name('leaderboard.index');
        
        // Certificates
        Route::get('/certificates', [\App\Http\Controllers\Member\CertificateController::class, 'index'])->name('certificates.index');
        Route::get('/certificates/{certificate}/download', [\App\Http\Controllers\Member\CertificateController::class, 'download'])->name('certificates.download');
        
        Route::resource('orders', \App\Http\Controllers\Member\OrderController::class);
        Route::get('orders/{order}/receipt-download', [\App\Http\Controllers\Member\OrderController::class, 'downloadReceipt'])->name('orders.receipt.download');
        Route::get('orders/{order}/receipt-preview', [\App\Http\Controllers\Member\OrderController::class, 'previewReceipt'])->name('orders.receipt.preview');
        
        // Testimonials
        Route::resource('testimonials', \App\Http\Controllers\Member\TestimonialController::class)->only(['index', 'store', 'update', 'destroy']);
    });

Route::middleware(['auth'])->group(function () {
    Route::post('/assignment-submissions/{submission}/comments', [\App\Http\Controllers\AssignmentCommentController::class, 'store'])->name('assignments.submissions.comments.store');
});

require __DIR__.'/auth.php';
