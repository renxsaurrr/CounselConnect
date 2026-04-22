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
 
// Complete profile after Google sign-up (new students only)
Route::get('/auth/complete-profile', [AuthController::class, 'showCompleteProfile'])->name('google.complete-profile');
Route::post('/auth/complete-profile', [AuthController::class, 'completeProfile'])->name('google.complete-profile.store');

// ──────────────────────────────────────────────────────────────
// Landing Page
// ──────────────────────────────────────────────────────────────
Route::get('/', fn () => view('CounselConnect.index'))->name('home');
Route::get('/services', fn () => view('CounselConnect.services'))->name('services');
Route::get('/resources', fn () => view('CounselConnect.resources'))->name('resources');
Route::get('/faq', fn () => view('CounselConnect.FAQ'))->name('FAQ');

// Admin login (outside guest group — has its own auth check inside the controller)
Route::get('/backoffice',  [AuthController::class, 'showAdminLogin'])->name('admin.login');
Route::post('/backoffice', [AuthController::class, 'adminLogin']);

// ──────────────────────────────────────────────────────────────
// Auth Routes — GET only behind guest middleware
// Only show forms to unauthenticated users.
// POST routes are intentionally OUTSIDE guest so the controller
// can handle stale/lingering sessions (e.g. browser back button
// while admin was logged in) instead of being silently blocked.
// ──────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
});

Route::post('/login',    [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Logout (authenticated users only)
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ──────────────────────────────────────────────────────────────
// Admin Routes
// ─── Middleware: auth + active check + role:admin ─────────────
// ──────────────────────────────────────────────────────────────
Route::middleware(['auth', 'active', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // User Management (full CRUD)
        Route::resource('users', AdminUserController::class);

        // Announcement Management (full CRUD)
        Route::resource('announcements', AdminAnnouncementController::class);

        // Appointment Management
        Route::get('appointments',                          [AdminAppointmentController::class, 'index'])->name('appointments.index');
        Route::get('appointments/create',                   [AdminAppointmentController::class, 'create'])->name('appointments.create');
        Route::get('appointments/slots',                    [AdminAppointmentController::class, 'slots'])->name('appointments.slots');
        Route::post('appointments',                         [AdminAppointmentController::class, 'store'])->name('appointments.store');
        Route::get('appointments/{appointment}',            [AdminAppointmentController::class, 'show'])->name('appointments.show');
        Route::patch('appointments/{appointment}/approve',  [AdminAppointmentController::class, 'approve'])->name('appointments.approve');
        Route::patch('appointments/{appointment}/reject',   [AdminAppointmentController::class, 'reject'])->name('appointments.reject');
        Route::patch('appointments/{appointment}/complete', [AdminAppointmentController::class, 'complete'])->name('appointments.complete');
        Route::patch('appointments/{appointment}/cancel',   [AdminAppointmentController::class, 'cancel'])->name('appointments.cancel');

        // Referral Management (full CRUD)
        Route::resource('referrals', AdminReferralController::class);

        // Session Records — view only (records are created by counselors)
        Route::get('sessions',           [AdminSessionController::class, 'index'])->name('sessions.index');
        Route::get('sessions/{session}', [AdminSessionController::class, 'show'])->name('sessions.show');
    });

// ──────────────────────────────────────────────────────────────
// Counselor Routes
// ─── Middleware: auth + active check + role:counselor ─────────
// ──────────────────────────────────────────────────────────────
Route::middleware(['auth', 'active', 'role:counselor'])
    ->prefix('counselor')
    ->name('counselor.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [CounselorDashboardController::class, 'index'])
            ->name('dashboard');

        // Schedule (full CRUD) — URL: /counselor/schedule/...
        Route::get('schedule',                              [CounselorScheduleController::class, 'index'])->name('schedule.index');
        Route::get('schedule/create',                       [CounselorScheduleController::class, 'create'])->name('schedule.create');
        Route::post('schedule',                             [CounselorScheduleController::class, 'store'])->name('schedule.store');
        Route::get('schedule/{schedule}',                   [CounselorScheduleController::class, 'show'])->name('schedule.show');
        Route::get('schedule/{schedule}/edit',              [CounselorScheduleController::class, 'edit'])->name('schedule.edit');
        Route::patch('schedule/{schedule}',                 [CounselorScheduleController::class, 'update'])->name('schedule.update');
        Route::delete('schedule/{schedule}',                [CounselorScheduleController::class, 'destroy'])->name('schedule.destroy');

        // Appointments — view + status actions only (no create/edit/delete)
        Route::get('appointments',                          [CounselorAppointmentController::class, 'index'])->name('appointments.index');
        Route::get('appointments/{appointment}',            [CounselorAppointmentController::class, 'show'])->name('appointments.show');
        Route::patch('appointments/{appointment}/approve',  [CounselorAppointmentController::class, 'approve'])->name('appointments.approve');
        Route::patch('appointments/{appointment}/reject',   [CounselorAppointmentController::class, 'reject'])->name('appointments.reject');
        Route::patch('appointments/{appointment}/complete', [CounselorAppointmentController::class, 'complete'])->name('appointments.complete');

        // Sessions (records) — URL: /counselor/sessions/... — no delete (permanent records)
        Route::get('sessions',                              [CounselorSessionRecordController::class, 'index'])->name('sessions.index');
        Route::get('sessions/create',                       [CounselorSessionRecordController::class, 'create'])->name('sessions.create');
        Route::post('sessions',                             [CounselorSessionRecordController::class, 'store'])->name('sessions.store');
        Route::get('sessions/{sessionRecord}',              [CounselorSessionRecordController::class, 'show'])->name('sessions.show');
        Route::get('sessions/{sessionRecord}/edit',         [CounselorSessionRecordController::class, 'edit'])->name('sessions.edit');
        Route::patch('sessions/{sessionRecord}',            [CounselorSessionRecordController::class, 'update'])->name('sessions.update');

        // Referrals — no edit/delete once submitted
        Route::get('referrals',                             [CounselorReferralController::class, 'index'])->name('referrals.index');
        Route::get('referrals/create',                      [CounselorReferralController::class, 'create'])->name('referrals.create');
        Route::post('referrals',                            [CounselorReferralController::class, 'store'])->name('referrals.store');
        Route::get('referrals/{referral}',                  [CounselorReferralController::class, 'show'])->name('referrals.show');
        Route::patch('referrals/{referral}/acknowledge',    [CounselorReferralController::class, 'acknowledge'])->name('referrals.acknowledge');

        // Students — view only (counselor sees students who have appointments with them)
        Route::get('students',                              [CounselorStudentController::class, 'index'])->name('students.index');
        Route::get('students/{student}',                    [CounselorStudentController::class, 'show'])->name('students.show');

        // Profile — counselor's own profile
        Route::get('profile',                               [CounselorProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile',                             [CounselorProfileController::class, 'update'])->name('profile.update');
    });

// ──────────────────────────────────────────────────────────────
// Student Routes
// ─── Middleware: auth + active check + role:student ───────────
// ──────────────────────────────────────────────────────────────
Route::middleware(['auth', 'active', 'role:student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])
            ->name('dashboard');

        // Appointments — book + view + cancel only (no edit)
        Route::get('appointments',                  [StudentAppointmentController::class, 'index'])->name('appointments.index');
        Route::get('appointments/create',           [StudentAppointmentController::class, 'create'])->name('appointments.create');
        Route::get('appointments/available-slots',  [StudentAppointmentController::class, 'availableSlots'])->name('appointments.available-slots');
        Route::post('appointments',                 [StudentAppointmentController::class, 'store'])->name('appointments.store');
        Route::get('appointments/{appointment}',    [StudentAppointmentController::class, 'show'])->name('appointments.show');
        Route::delete('appointments/{appointment}', [StudentAppointmentController::class, 'destroy'])->name('appointments.destroy');

        // Referrals — view only
        Route::get('referrals',            [StudentReferralController::class, 'index'])->name('referrals.index');
        Route::get('referrals/{referral}', [StudentReferralController::class, 'show'])->name('referrals.show');

        // Sessions — view only (records are created by counselors)
        Route::get('sessions',             [StudentSessionController::class, 'index'])->name('sessions.index');
        Route::get('sessions/{session}',   [StudentSessionController::class, 'show'])->name('sessions.show');

        // Profile
        Route::get('profile',              [StudentProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile',            [StudentProfileController::class, 'update'])->name('profile.update');
    });