<?php

namespace App\Providers;

use App\Services\AccountService;
use App\Services\Contracts\DataVersionTeacherServiceContract;
use App\Services\Contracts\FixScheduleServiceContract;
use App\Services\Contracts\Guest\AccountGuestServiceContract;
use App\Services\Contracts\Guest\CrawlExamScheduleGuestServiceContract;
use App\Services\Contracts\Guest\CrawlModuleScoreGuestServiceContract;
use App\Services\Contracts\Guest\DataVersionGuestServiceContract;
use App\Services\Contracts\Guest\ExamScheduleGuestServiceContract;
use App\Services\Contracts\Guest\LoginGuestServiceContract;
use App\Services\Contracts\Guest\ModuleScoreGuestServiceContract;
use App\Services\Contracts\Guest\NotificationGuestServiceContract;
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
use App\Services\Contracts\CrawlExamScheduleServiceContract;
use App\Services\Contracts\CrawlModuleScoreServiceContract;
use App\Services\Contracts\DataVersionStudentServiceContract;
use App\Services\Contracts\DeviceServiceContract;
use App\Services\Contracts\ExamScheduleServiceContract;
use App\Services\Contracts\FacultyClassServiceContract;
use App\Services\Contracts\DataServiceContract;
use App\Services\Contracts\LoginAppServiceContract;
use App\Services\Contracts\LoginWebServiceContract;
use App\Services\Contracts\ModuleClassServiceContract;
use App\Services\Contracts\ModuleScoreServiceContract;
use App\Services\Contracts\NotificationServiceContract;
use App\Services\Contracts\NotifyServiceContract;
use App\Services\FixScheduleService;
use App\Services\Guest\AccountGuestService;
use App\Services\Guest\CrawlExamScheduleGuestService;
use App\Services\Guest\CrawlModuleScoreGuestService;
use App\Services\Guest\DataVersionGuestService;
use App\Services\Guest\ExamScheduleGuestService;
use App\Services\Guest\LoginGuestService;
use App\Services\Guest\ModuleScoreGuestService;
use App\Services\Guest\NotificationGuestService;
use App\Services\DataService;
use App\Services\LoginAppService;
use App\Services\LoginWebService;
use App\Services\ModuleClassService;
use App\Services\ModuleScoreService;
use App\Services\NotificationService;
use App\Services\NotifyService;
use App\Services\RegisterService;
use App\Services\ScheduleService;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register ()
    {
        $this->app->bind(DataVersionStudentServiceContract::class, DataVersionStudentService::class);
        $this->app->bind(DataVersionTeacherServiceContract::class, DataVersionTeacherService::class);
        $this->app->bind(CrawlExamScheduleServiceContract::class, CrawlExamScheduleService::class);
        $this->app->bind(CrawlModuleScoreServiceContract::class, CrawlModuleScoreService::class);
        $this->app->bind(FacultyClassServiceContract::class, FacultyClassService::class);
        $this->app->bind(NotificationServiceContract::class, NotificationService::class);
        $this->app->bind(ExamScheduleServiceContract::class, ExamScheduleService::class);
        $this->app->bind(ModuleScoreServiceContract::class, ModuleScoreService::class);
        $this->app->bind(ModuleClassServiceContract::class, ModuleClassService::class);
        $this->app->bind(FixScheduleServiceContract::class, FixScheduleService::class);
        $this->app->bind(RegisterServiceContract::class, RegisterService::class);
        $this->app->bind(LoginWebServiceContract::class, LoginWebService::class);
        $this->app->bind(LoginAppServiceContract::class, LoginAppService::class);
        $this->app->bind(ScheduleServiceContract::class, ScheduleService::class);
        $this->app->bind(AccountServiceContract::class, AccountService::class);
        $this->app->bind(DeviceServiceContract::class, DeviceService::class);
        $this->app->bind(NotifyServiceContract::class, NotifyService::class);
        $this->app->bind(DataServiceContract::class, DataService::class);

        $this->app->bind(CrawlExamScheduleGuestServiceContract::class, CrawlExamScheduleGuestService::class);
        $this->app->bind(CrawlModuleScoreGuestServiceContract::class, CrawlModuleScoreGuestService::class);
        $this->app->bind(NotificationGuestServiceContract::class, NotificationGuestService::class);
        $this->app->bind(ExamScheduleGuestServiceContract::class, ExamScheduleGuestService::class);
        $this->app->bind(ModuleScoreGuestServiceContract::class, ModuleScoreGuestService::class);
        $this->app->bind(DataVersionGuestServiceContract::class, DataVersionGuestService::class);
        $this->app->bind(AccountGuestServiceContract::class, AccountGuestService::class);
        $this->app->bind(LoginGuestServiceContract::class, LoginGuestService::class);

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot ()
    {
//        URL::forceScheme('https');
    }
}
