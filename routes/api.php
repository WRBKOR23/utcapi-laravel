<?php

use App\Http\Controllers\ApiController\AccountController;
use App\Http\Controllers\ApiController\Auth\LoginAppController;
use App\Http\Controllers\ApiController\Auth\RegisterController;
use App\Http\Controllers\ApiController\CrawlExamScheduleController;
use App\Http\Controllers\ApiController\CrawlModuleScoreController;
use App\Http\Controllers\ApiController\CronJob\FixScheduleController;
use App\Http\Controllers\ApiController\DataVersionStudentController;
use App\Http\Controllers\ApiController\DataVersionTeacherController;
use App\Http\Controllers\ApiController\DeviceController;
use App\Http\Controllers\ApiController\ExamScheduleController;
use App\Http\Controllers\ApiController\FacultyController;
use App\Http\Controllers\ApiController\Guest\AccountGuestController;
use App\Http\Controllers\ApiController\Guest\CrawlExamScheduleGuestController;
use App\Http\Controllers\ApiController\Guest\CrawlModuleScoreGuestController;
use App\Http\Controllers\ApiController\Guest\DataVersionGuestController;
use App\Http\Controllers\ApiController\Guest\ExamScheduleGuestController;
use App\Http\Controllers\ApiController\Guest\LoginGuestController;
use App\Http\Controllers\ApiController\Guest\ModuleScoreGuestController;
use App\Http\Controllers\ApiController\Guest\NotificationGuestController;
use App\Http\Controllers\ApiController\ModuleScoreController;
use App\Http\Controllers\ApiController\NotificationController;
use App\Http\Controllers\ApiController\ScheduleController;
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

Route::get('faculty', [FacultyController::class, 'getInfoFaculties']);

Route::group(['prefix' => 'auth'], function ()
{
    Route::post('authenticate', [LoginAppController::class, 'login']);

    Route::group(['prefix' => 'register'], function ()
    {
        Route::post('process1', [RegisterController::class, 'process1']);

        Route::post('process2', [RegisterController::class, 'process2']);
    });
});

Route::get('/check-fixschedule', [FixScheduleController::class, 'checkFixSchedule']);

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

        Route::get('notification/{id_account}/{id_notification?}', [NotificationController::class, 'getNotifications']);

        Route::get('module-score/{id_student}', [ModuleScoreController::class, 'get']);

        Route::get('exam-schedule/{id_student}', [ExamScheduleController::class, 'get']);

        Route::group(['prefix' => 'crawl'], function ()
        {
            Route::post('module-score/all', [CrawlModuleScoreController::class, 'crawlAll']);

            Route::post('module-score', [CrawlModuleScoreController::class, 'crawl']);

            Route::post('exam-schedule/all', [CrawlExamScheduleController::class, 'crawlAll']);

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

    });

    /**
     * @Guest----------------------------------------------------------------------------
     */

    Route::group(['prefix' => 'guest'], function ()
    {
        Route::post('login', [LoginGuestController::class, 'login']);

        Route::group(['prefix' => 'account'], function ()
        {
            Route::post('update-password', [AccountGuestController::class, 'updatePassword']);

            Route::post('update-device-token', [AccountGuestController::class, 'updateDeviceToken']);

        });

        Route::group(['prefix' => 'data-version'], function ()
        {
            Route::get('{id_student}', [DataVersionGuestController::class, 'getDataVersion']);

            Route::get('notification/{id_student}', [DataVersionGuestController::class, 'getNotificationVersion']);
        });

        Route::group(['prefix' => 'notification'], function ()
        {
            Route::get('{id_guest}/{id_notification?}', [NotificationGuestController::class, 'getNotifications']);
        });

        Route::group(['prefix' => 'crawl'], function ()
        {
            Route::post('module-score/all', [CrawlModuleScoreGuestController::class, 'crawlAll']);

            Route::post('module-score', [CrawlModuleScoreGuestController::class, 'crawl']);

            Route::post('exam-schedule/all', [CrawlExamScheduleGuestController::class, 'crawlAll']);

            Route::post('exam-schedule', [CrawlExamScheduleGuestController::class, 'crawl']);
        });

        Route::get('module-score/{id_student}', [ModuleScoreGuestController::class, 'get']);

        Route::get('exam-schedule/{id_student}', [ExamScheduleGuestController::class, 'get']);
    });

    Route::get('schedule/{id}', [ScheduleController::class, 'getTeacherSchedules']);

    Route::get('schedule/{id}', [ScheduleController::class, 'getTeacherSchedules']);

});

Route::get('secret/errors', function ()
{
    return nl2br(File::get(config('filesystems.disks.errors.file_path')));
});
