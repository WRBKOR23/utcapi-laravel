<?php

namespace App\Providers;

use App\Http\Controllers\CrawlExamScheduleController;
use App\Http\Controllers\CrawlModuleScoreController;
use App\Services\AccountService;
use App\Services\AuthService;
use App\Services\Contracts\AuthServiceContract;
use App\Services\Contracts\CrawlServiceContract;
use App\Services\Contracts\DataVersionTeacherServiceContract;
use App\Services\Contracts\FacultyServiceContract;
use App\Services\Contracts\RegisterServiceContract;
use App\Services\Contracts\ScheduleServiceContract;
use App\Services\CrawlExamScheduleService;
use App\Services\CrawlModuleScoreService;
use App\Services\DataVersionStudentService;
use App\Services\DataVersionTeacherService;
use App\Services\DeviceService;
use App\Services\ExamScheduleService;
use App\Services\FacultyClassService;
use App\Services\Contracts\AccountServiceContract;
use App\Services\Contracts\DataVersionStudentServiceContract;
use App\Services\Contracts\DeviceServiceContract;
use App\Services\Contracts\ExamScheduleServiceContract;
use App\Services\Contracts\FacultyClassServiceContract;
use App\Services\Contracts\ModuleClassServiceContract;
use App\Services\Contracts\ModuleScoreServiceContract;
use App\Services\Contracts\NotificationServiceContract;
use App\Services\FacultyService;
use App\Services\ModuleClassService;
use App\Services\ModuleScoreService;
use App\Services\NotificationService;
use App\Services\RegisterService;
use App\Services\ScheduleService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public array $bindings = [
        DataVersionStudentServiceContract::class => DataVersionStudentService::class,
        DataVersionTeacherServiceContract::class => DataVersionTeacherService::class,
        FacultyClassServiceContract::class       => FacultyClassService::class,
        NotificationServiceContract::class       => NotificationService::class,
        ExamScheduleServiceContract::class       => ExamScheduleService::class,
        ModuleScoreServiceContract::class        => ModuleScoreService::class,
        ModuleClassServiceContract::class        => ModuleClassService::class,
        RegisterServiceContract::class           => RegisterService::class,
        ScheduleServiceContract::class           => ScheduleService::class,
        AccountServiceContract::class            => AccountService::class,
        FacultyServiceContract::class            => FacultyService::class,
        DeviceServiceContract::class             => DeviceService::class,
        AuthServiceContract::class               => AuthService::class,
    ];

    /**
     * Register any application services.
     * @return void
     */
    public function register ()
    {
        $this->app->when(CrawlExamScheduleController::class)
                  ->needs(CrawlServiceContract::class)
                  ->give(CrawlExamScheduleService::class);

        $this->app->when(CrawlModuleScoreController::class)
                  ->needs(CrawlServiceContract::class)
                  ->give(CrawlModuleScoreService::class);
    }

    /**
     * Bootstrap any application services.
     * @return void
     */
    public function boot ()
    {
        //        URL::forceScheme('http');
    }
}
