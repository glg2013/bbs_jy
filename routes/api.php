<?php

use App\Http\Controllers\Api\AuthorizationsController;
use App\Http\Controllers\Api\CaptchasController;
use App\Http\Controllers\Api\CategoriesController;
use App\Http\Controllers\Api\ImagesController;
use App\Http\Controllers\Api\TopicsController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\VerificationCodesController;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::prefix('v1')->name('api.v1.')->group(function() {

    Route::middleware('throttle:' . config('api.rate_limits.sign'))->group(function () {
        // 短信验证码
        Route::post('verificationCodes', [VerificationCodesController::class, 'store'])->name('verificationCodes.store');

        // 用户注册
        Route::post('users', [UsersController::class, 'store'])->name('users.store');
        // 第三方登录
        Route::post('socials/{social_type}/authorizations', [AuthorizationsController::class, 'socialStore'])
            ->where('social_type', 'wechat')
            ->name('socials.authorizations.store');

        // 登录
        Route::post('authorizations', [AuthorizationsController::class, 'store'])
            ->name('authorizations.store');

        // 刷新 token
        Route::put('authorizations/current', [AuthorizationsController::class, 'update'])->name('authorizations.update');

        // 删除 token
        Route::delete('authorizations/current', [AuthorizationsController::class, 'destroy'])->name('authorizations.destroy');

        // 图片验证码
        Route::post('captchas', [CaptchasController::class, 'store'])->name('captchas.store');
    });

    Route::middleware('throttle:' . config('api.rate_limits.access'))->group(function () {
        // 游客可以访问的接口

        // 话题列表，详情
        Route::apiResource('topics', TopicsController::class)->only(['index', 'show']);

        // 分类列表
        Route::apiResource('categories', CategoriesController::class)->only('index');

        // 某个用户发布的话题
        Route::get('users/{user}/topics', [TopicsController::class, 'userIndex'])->name('users.topics.index');

        // 某个用户的详情
        Route::get('users/{user}', [UsersController::class, 'show'])->name('users.show');

        // 登录后可以访问的接口
        Route::middleware('auth:api')->group(function () {
            // 当前登录用户信息
            Route::get('user', [UsersController::class, 'me'])->name('user.show');

            // 编辑登录用户信息
            Route::patch('user', [UsersController::class, 'update'])->name('user.update');

            // 上传图片
            Route::post('images', [ImagesController::class, 'store'])->name('images.store');

            // 发布，修改，删除话题
            Route::apiResource('topics', TopicsController::class)->only(['store', 'update', 'destroy']);
        });
    });
});
