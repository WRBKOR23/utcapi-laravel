<?php

use App\Http\Controllers\WebController\AccountController;
use App\Http\Controllers\WebController\Auth\LoginWebController;
use App\Http\Controllers\WebController\Auth\LogoutController;
use App\Http\Controllers\WebController\FacultyClassController;
use App\Http\Controllers\WebController\DataController;
use App\Http\Controllers\WebController\ModuleClassController;
use App\Http\Controllers\WebController\NotificationController;
use App\Http\Controllers\WebController\HomeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/login', [LoginWebController::class, 'showLoginScreen']);

Route::post('/auth/authenticate', [LoginWebController::class, 'login']);

Route::middleware('cus.session')->group(function ()
{
    Route::get('/home', [HomeController::class, 'showHome']);

    Route::get('/logout', function ()
    {
        return view('logout');
    });

    Route::prefix('/forms')->group(function ()
    {
        Route::get('/module-class', function ()
        {
            return view('forms.module_class');
        });

        Route::get('/faculty', function ()
        {
            return view('forms.faculty_class');
        });
    });

    Route::get('/delete-notification', function ()
    {
        return view('delete-notification.index');
    });

    Route::get('/import-data', function ()
    {
        return view('import-data.index');
    });
});

Route::middleware('cus.auth')->group(function ()
{
    Route::group(['prefix' => 'web'], function ()
    {
        Route::group(['prefix' => 'notification'], function ()
        {
            Route::get('{id_sender}/{num}', [NotificationController::class, 'getNotifications']);

            Route::group(['prefix' => 'push-notification'], function ()
            {
                Route::post('faculty-class', [NotificationController::class, 'pushNotificationBFC']);

                Route::post('module-class', [NotificationController::class, 'pushNotificationBMC']);
            });

            Route::post('set-delete', [NotificationController::class, 'deleteNotifications']);

        });

        Route::group(['prefix' => 'import-data'], function ()
        {
            Route::post('process-1', [DataController::class, 'process1']);

            Route::post('process-2', [DataController::class, 'process2']);
        });

        Route::group(['prefix' => 'forms'], function ()
        {
            Route::get('faculty-class', [FacultyClassController::class, 'getFacultyClassesAndAcademicYears']);

            Route::get('module-class', [ModuleClassController::class, 'getModuleClasses']);
        });

        Route::post('/account/change-password', [AccountController::class, 'changePassword']);

        Route::post('/auth/logout', [LogoutController::class, 'logout']);

    });
});

Route::get('test', [\App\Http\Controllers\WebController\TestController::class, 'test'])->name('a');
