<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\RepliesController;
use App\Http\Controllers\TopicsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UsersController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', [PagesController::class, 'root'])->name('root');
Route::get('/', [TopicsController::class, 'index'])->name('root');

Auth::routes(['verify' => true]);

//// 用户身份验证相关的路由
//Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
//Route::post('login', [LoginController::class, 'login']);
//Route::post('logout', [LoginController::class, 'logout'])->name('logout');
//
//// 用户注册相关路由
//Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
//Route::post('register', [RegisterController::class, 'register']);
//
//// 密码重置相关路由
//Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
//Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
//Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
//Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
//
//// 再次确认密码（重要操作前提示）
//Route::get('password/confirm', [ConfirmPasswordController::class, 'showConfirmForm'])->name('password.confirm');
//Route::post('password/confirm', [ConfirmPasswordController::class, 'confirm']);
//
//// Email 认证相关路由
//Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
//Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
//Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

Route::resource('users', UsersController::class)->only(['show', 'update', 'edit']);

Route::resource('topics', TopicsController::class)->only(['index', 'create', 'store', 'update', 'edit', 'destroy']);
Route::get('topics/{topic}/{slug?}', [TopicsController::class, 'show'])->name('topics.show');

Route::resource('categories', CategoriesController::class)->only(['show']);

Route::post('upload_image', [TopicsController::class, 'uploadImage'])->name('topics.upload_image');

Route::resource('replies', RepliesController::class)->only(['store', 'destroy']);

Route::resource('notifications', NotificationsController::class)->only(['index']);

Route::get('/suser', function () {
    dd(Auth::user()->hasRole('Founder'));
});

// 无权限提醒页面
Route::get('permission-denied', [PagesController::class, 'permissionDenied'])->name('permission-denied');
