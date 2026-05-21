<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminAnnouncementController;
use App\Http\Controllers\Admin\AdminAppointmentController;
use App\Http\Controllers\Admin\AdminSessionController;
use App\Http\Controllers\Admin\AdminReferralController;
use App\Http\Controllers\Counselor\CounselorDashboardController;
use App\Http\Controllers\Counselor\CounselorScheduleController;
use App\Http\Controllers\Counselor\CounselorAppointmentController;
use App\Http\Controllers\Counselor\CounselorSessionRecordController;
use App\Http\Controllers\Counselor\CounselorReferralController;
use App\Http\Controllers\Counselor\CounselorStudentController;
use App\Http\Controllers\Counselor\CounselorProfileController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Student\StudentAppointmentController;
use App\Http\Controllers\Student\StudentReferralController;
use App\Http\Controllers\Student\StudentSessionController;
use App\Http\Controllers\Student\StudentProfileController;


Route::get('/auth/google/redirect', [AuthController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');

Route::get('/auth/complete-profile', [AuthController::class, 'showCompleteProfile'])->name('google.complete-profile');
Route::post('/auth/complete-profile', [AuthController::class, 'completeProfile'])->name('google.complete-profile.store');

// ──────────────────────────────────────────────────────────────
// Landing Page
// ──────────────────────────────────────────────────────────────
Route::get('/', fn () => view('CounselConnect.index'))->name('home');
Route::get('/services', fn () => view('CounselConnect.services'))->name('services');
Route::get('/resources', fn () => view('CounselConnect.resources'))->name('resources');
Route::get('/faq', fn () => view('CounselConnect.FAQ'))->name('FAQ');

Route::get('/backoffice',  [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/backoffice', [AuthController::class, 'adminLogin']);

Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
});

Route::post('/login',    [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/run-seeder', function () {
    Artisan::call('db:seed', ['--force' => true]);
    return 'Seeded!';
});

// ──────────────────────────────────────────────────────────────
// Admin Routes
// ──────────────────────────────────────────────────────────────
Route::middleware(['auth', 'active', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('users', AdminUserController::class);
        Route::resource('announcements', AdminAnnouncementController::class);

        Route::get('appointments',                          [AdminAppointmentController::class, 'index'])->name('appointments.index');
        Route::get('appointments/create',                   [AdminAppointmentController::class, 'create'])->name('appointments.create');
        Route::get('appointments/slots',                    [AdminAppointmentController::class, 'slots'])->name('appointments.slots');
        Route::post('appointments',                         [AdminAppointmentController::class, 'store'])->name('appointments.store');
        Route::get('appointments/{appointment}',            [AdminAppointmentController::class, 'show'])->name('appointments.show');
        Route::patch('appointments/{appointment}/approve',  [AdminAppointmentController::class, 'approve'])->name('appointments.approve');
        Route::patch('appointments/{appointment}/reject',   [AdminAppointmentController::class, 'reject'])->name('appointments.reject');
        Route::patch('appointments/{appointment}/complete', [AdminAppointmentController::class, 'complete'])->name('appointments.complete');
        Route::patch('appointments/{appointment}/cancel',   [AdminAppointmentController::class, 'cancel'])->name('appointments.cancel');

        Route::resource('referrals', AdminReferralController::class);

        Route::get('sessions',           [AdminSessionController::class, 'index'])->name('sessions.index');
        Route::get('sessions/{session}', [AdminSessionController::class, 'show'])->name('sessions.show');
    });

// ──────────────────────────────────────────────────────────────
// Counselor Routes
// ──────────────────────────────────────────────────────────────
Route::middleware(['auth', 'active', 'role:counselor'])
    ->prefix('counselor')
    ->name('counselor.')
    ->group(function () {

        Route::get('/dashboard', [CounselorDashboardController::class, 'index'])->name('dashboard');

        Route::get('schedule',                              [CounselorScheduleController::class, 'index'])->name('schedule.index');
        Route::get('schedule/create',                       [CounselorScheduleController::class, 'create'])->name('schedule.create');
        Route::post('schedule',                             [CounselorScheduleController::class, 'store'])->name('schedule.store');
        Route::get('schedule/{schedule}',                   [CounselorScheduleController::class, 'show'])->name('schedule.show');
        Route::get('schedule/{schedule}/edit',              [CounselorScheduleController::class, 'edit'])->name('schedule.edit');
        Route::patch('schedule/{schedule}',                 [CounselorScheduleController::class, 'update'])->name('schedule.update');
        Route::delete('schedule/{schedule}',                [CounselorScheduleController::class, 'destroy'])->name('schedule.destroy');

        // Appointments — now includes counselor-initiated invite (create + store)
        Route::get('appointments',                          [CounselorAppointmentController::class, 'index'])->name('appointments.index');
        Route::get('appointments/invite',                   [CounselorAppointmentController::class, 'create'])->name('appointments.create');
        Route::post('appointments',                         [CounselorAppointmentController::class, 'store'])->name('appointments.store');
        Route::get('appointments/{appointment}',            [CounselorAppointmentController::class, 'show'])->name('appointments.show');
        Route::patch('appointments/{appointment}/approve',  [CounselorAppointmentController::class, 'approve'])->name('appointments.approve');
        Route::patch('appointments/{appointment}/reject',   [CounselorAppointmentController::class, 'reject'])->name('appointments.reject');
        Route::patch('appointments/{appointment}/complete', [CounselorAppointmentController::class, 'complete'])->name('appointments.complete');

        Route::get('sessions',                              [CounselorSessionRecordController::class, 'index'])->name('sessions.index');
        Route::get('sessions/create',                       [CounselorSessionRecordController::class, 'create'])->name('sessions.create');
        Route::post('sessions',                             [CounselorSessionRecordController::class, 'store'])->name('sessions.store');
        Route::get('sessions/{sessionRecord}',              [CounselorSessionRecordController::class, 'show'])->name('sessions.show');
        Route::get('sessions/{sessionRecord}/edit',         [CounselorSessionRecordController::class, 'edit'])->name('sessions.edit');
        Route::patch('sessions/{sessionRecord}',            [CounselorSessionRecordController::class, 'update'])->name('sessions.update');

        Route::get('referrals',                             [CounselorReferralController::class, 'index'])->name('referrals.index');
        Route::get('referrals/create',                      [CounselorReferralController::class, 'create'])->name('referrals.create');
        Route::post('referrals',                            [CounselorReferralController::class, 'store'])->name('referrals.store');
        Route::get('referrals/{referral}',                  [CounselorReferralController::class, 'show'])->name('referrals.show');
        Route::patch('referrals/{referral}/acknowledge',    [CounselorReferralController::class, 'acknowledge'])->name('referrals.acknowledge');

        Route::get('students',                              [CounselorStudentController::class, 'index'])->name('students.index');
        Route::get('students/{student}',                    [CounselorStudentController::class, 'show'])->name('students.show');

        Route::get('profile',                               [CounselorProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile',                             [CounselorProfileController::class, 'update'])->name('profile.update');
    });

// ──────────────────────────────────────────────────────────────
// Student Routes
// ──────────────────────────────────────────────────────────────
Route::middleware(['auth', 'active', 'role:student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {

        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

        Route::get('appointments',                              [StudentAppointmentController::class, 'index'])->name('appointments.index');
        Route::get('appointments/create',                       [StudentAppointmentController::class, 'create'])->name('appointments.create');
        Route::get('appointments/available-slots',              [StudentAppointmentController::class, 'availableSlots'])->name('appointments.available-slots');
        Route::post('appointments',                             [StudentAppointmentController::class, 'store'])->name('appointments.store');
        Route::get('appointments/{appointment}',                [StudentAppointmentController::class, 'show'])->name('appointments.show');
        Route::delete('appointments/{appointment}',             [StudentAppointmentController::class, 'destroy'])->name('appointments.destroy');

        // Counselor-invite response routes
        Route::patch('appointments/{appointment}/accept-invite',  [StudentAppointmentController::class, 'acceptInvite'])->name('appointments.accept-invite');
        Route::patch('appointments/{appointment}/decline-invite', [StudentAppointmentController::class, 'declineInvite'])->name('appointments.decline-invite');

        Route::get('referrals',            [StudentReferralController::class, 'index'])->name('referrals.index');
        Route::get('referrals/{referral}', [StudentReferralController::class, 'show'])->name('referrals.show');

        Route::get('sessions',             [StudentSessionController::class, 'index'])->name('sessions.index');
        Route::get('sessions/{session}',   [StudentSessionController::class, 'show'])->name('sessions.show');

        Route::get('profile',              [StudentProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile',            [StudentProfileController::class, 'update'])->name('profile.update');
    });