<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CrawlExamScheduleController;
use App\Http\Controllers\CrawlModuleScoreController;
use App\Http\Controllers\DataVersionStudentController;
use App\Http\Controllers\DataVersionTeacherController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ExamScheduleController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\ModuleScoreController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ScheduleController;
use Illuminate\Support\Facades\File;
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

Route::get('faculty', [FacultyController::class, 'getFaculties']);

Route::group(['prefix' => 'auth'], function ()
{
    Route::post('login', [AuthController::class, 'login']);

    Route::group(['prefix' => 'register'], function ()
    {
        Route::post('process1', [RegisterController::class, 'process1']);

        Route::post('process2', [RegisterController::class, 'process2']);
    });
});

Route::middleware('cus.auth')->group(function ()
{
    /**
     * @Auth----------------------------------------------------------------------------
     */
    Route::group(['prefix' => 'account'], function ()
    {
        Route::post('update-qldt-password', [AccountController::class, 'updateQLDTPassword']);

        Route::post('change-password', [AccountController::class, 'changePassword']);
    });

    Route::group(['prefix' => 'device'], function ()
    {
        Route::post('upsert-device-token', [DeviceController::class, 'updateDeviceToken']);
    });

    /**
     * @Student----------------------------------------------------------------------------
     */

    Route::group(['prefix' => 'student'], function ()
    {
        Route::get('schedule/{id_student}', [ScheduleController::class, 'getStudentSchedules']);

        Route::get('data-version/{id_student}', [DataVersionStudentController::class, 'getDataVersion']);

        Route::get('notification/{id_account}/{id_notification?}', [NotificationController::class, 'getStudentNotification']);

        Route::get('module-score/{id_student}', [ModuleScoreController::class, 'get']);

        Route::get('exam-schedule/{id_student}', [ExamScheduleController::class, 'get']);

        Route::group(['prefix' => 'crawl'], function ()
        {
            Route::post('module-score-all', [CrawlModuleScoreController::class, 'crawlAll']);

            Route::post('module-score', [CrawlModuleScoreController::class, 'crawl']);

            Route::post('exam-schedule-all', [CrawlExamScheduleController::class, 'crawlAll']);

            Route::post('exam-schedule', [CrawlExamScheduleController::class, 'crawl']);
        });
    });

    /**
     * @Teacher----------------------------------------------------------------------------
     */

    Route::group(['prefix' => 'teacher'], function ()
    {
        Route::get('schedule/{id_teacher}', [ScheduleController::class, 'getTeacherSchedules']);

        Route::get('data-version/{id_teacher}', [DataVersionTeacherController::class, 'getDataVersion']);

        Route::get('notification/{id_account}/{id_notification?}', [NotificationController::class, 'getTeacherNotification']);

    });

    Route::get('schedule/{id}', [ScheduleController::class, 'getTeacherSchedules']);

    Route::get('schedule/{id}', [ScheduleController::class, 'getTeacherSchedules']);

});

Route::get('secret/errors', function ()
{
    return nl2br(File::get(config('filesystems.disks.errors.file_path')));
});
