<?php

namespace App\Providers;

use App\Repositories\AccountRepository;
use App\Repositories\ClassRepository;
use App\Repositories\Contracts\AccountRepositoryContract;
use App\Repositories\Contracts\ClassRepositoryContract;
use App\Repositories\Contracts\DataVersionStudentRepositoryContract;
use App\Repositories\Contracts\DataVersionTeacherRepositoryContract;
use App\Repositories\Contracts\DepartmentRepositoryContract;
use App\Repositories\Contracts\DeviceRepositoryContract;
use App\Repositories\Contracts\ExamScheduleRepositoryContract;
use App\Repositories\Contracts\FacultyRepositoryContract;
use App\Repositories\Contracts\ModuleClassRepositoryContract;
use App\Repositories\Contracts\ModuleRepositoryContract;
use App\Repositories\Contracts\ModuleScoreDepositoryContract;
use App\Repositories\Contracts\NotificationAccountRepositoryContract;
use App\Repositories\Contracts\NotificationRepositoryContract;
use App\Repositories\Contracts\OtherDepartmentRepositoryContract;
use App\Repositories\Contracts\ParticipateRepositoryContract;
use App\Repositories\Contracts\ScheduleRepositoryContract;
use App\Repositories\Contracts\SchoolYearRepositoryContract;
use App\Repositories\Contracts\StudentRepositoryContract;
use App\Repositories\Contracts\TeacherRepositoryContract;
use App\Repositories\DataVersionStudentRepository;
use App\Repositories\DataVersionTeacherRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\DeviceRepository;
use App\Repositories\ExamScheduleRepository;
use App\Repositories\FacultyRepository;
use App\Repositories\ModuleClassRepository;
use App\Repositories\ModuleRepository;
use App\Repositories\ModuleScoreRepository;
use App\Repositories\NotificationAccountRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\OtherDepartmentRepository;
use App\Repositories\ParticipateRepository;
use App\Repositories\ScheduleRepository;
use App\Repositories\SchoolYearRepository;
use App\Repositories\StudentRepository;
use App\Repositories\TeacherRepository;
use Illuminate\Support\ServiceProvider;

class AppRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NotificationAccountRepositoryContract::class, NotificationAccountRepository::class);
        $this->app->bind(DataVersionStudentRepositoryContract::class, DataVersionStudentRepository::class);
        $this->app->bind(DataVersionTeacherRepositoryContract::class, DataVersionTeacherRepository::class);
        $this->app->bind(OtherDepartmentRepositoryContract::class, OtherDepartmentRepository::class);
        $this->app->bind(NotificationRepositoryContract::class, NotificationRepository::class);
        $this->app->bind(ExamScheduleRepositoryContract::class, ExamScheduleRepository::class);
        $this->app->bind(ModuleScoreDepositoryContract::class, ModuleScoreRepository::class);
        $this->app->bind(ModuleClassRepositoryContract::class, ModuleClassRepository::class);
        $this->app->bind(ParticipateRepositoryContract::class, ParticipateRepository::class);
        $this->app->bind(DepartmentRepositoryContract::class, DepartmentRepository::class);
        $this->app->bind(SchoolYearRepositoryContract::class, SchoolYearRepository::class);
        $this->app->bind(ScheduleRepositoryContract::class, ScheduleRepository::class);
        $this->app->bind(TeacherRepositoryContract::class, TeacherRepository::class);
        $this->app->bind(StudentRepositoryContract::class, StudentRepository::class);
        $this->app->bind(AccountRepositoryContract::class, AccountRepository::class);
        $this->app->bind(FacultyRepositoryContract::class, FacultyRepository::class);
        $this->app->bind(DeviceRepositoryContract::class, DeviceRepository::class);
        $this->app->bind(ModuleRepositoryContract::class, ModuleRepository::class);
        $this->app->bind(ClassRepositoryContract::class, ClassRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
