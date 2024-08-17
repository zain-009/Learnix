<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\EnrolledController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TeachingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\SignupController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\VerificationController;

Route::get('/', [SessionController::class, 'index']);

Route::get('/login', [LoginController::class, 'showLogin']);

Route::get('/register', [SignupController::class, 'showRegister']);

Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::post('/register', [SignupController::class, 'register']);

Route::post('/logout', [LogoutController::class, 'logout']);

Route::get('/home', [HomeController::class, 'showHome'])->middleware(['auth']);

Route::get('/teaching', [TeachingController::class, 'showTeaching'])->middleware(['auth']);

Route::get('/enrolled', [EnrolledController::class, 'showEnrolled'])->middleware(['auth']);

Route::get('/settings', [SettingsController::class, 'showSettings'])->middleware(['auth']);

Route::get('/verification', [VerificationController::class, 'showCodeVerification']);

Route::post('/verify', [VerificationController::class, 'verify']);

Route::post('/resendCode', [VerificationController::class, 'resendCode']);

Route::get('/reset', [PasswordResetController::class, 'showForgotPassword']);

Route::post('/reset', [PasswordResetController::class, 'sendResetPasswordLink']);

Route::post('/verifyPasswordCode', [PasswordResetController::class, 'verifyPasswordCode']);

Route::get('/resetPassword', [PasswordResetController::class, 'showResetPassword']);

Route::post('/resetPassword', [PasswordResetController::class, 'resetPassword']);

Route::post('/deleteAccount',[SettingsController::class, 'deleteAccount']);

Route::post('/createClass',[ClassController::class, 'createClass']);

Route::post('/joinClass',[ClassController::class, 'joinClass']);

Route::post('/leaveClass',[ClassController::class, 'leaveClass']);

Route::get('/class/{code}',[ClassController::class, 'showClass']);

Route::post('/uploadProfileImage', [ImageController::class, 'uploadProfileImage']);

Route::post('/postAnnouncement', [ClassController::class, 'postAnnouncement']);

Route::post('/deleteAnnouncement', [ClassController::class, 'deleteAnnouncement']);

Route::post('/uploadMaterial', [MaterialController::class, 'uploadMaterial']);

Route::post('/deleteMaterial', [MaterialController::class, 'deleteMaterial']);

Route::post('/uploadAssignment', [AssignmentController::class, 'uploadAssignment']);

Route::post('/deleteAssignment', [AssignmentController::class, 'deleteAssignment']);

Route::post('/uploadQuiz', [QuizController::class, 'uploadQuiz']);

Route::post('/deleteQuiz', [QuizController::class, 'deleteQuiz']);

Route::post('/updateCredentials', [UserController::class, 'updateCredentials']);