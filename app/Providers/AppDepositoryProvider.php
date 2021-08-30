<?php

namespace App\Providers;

use App\Depositories\AccountDepository;
use App\Depositories\ClassDepository;
use App\Depositories\Contracts\AccountDepositoryContract;
use App\Depositories\Contracts\ClassDepositoryContract;
use App\Depositories\Contracts\DataVersionStudentDepositoryContract;
use App\Depositories\Contracts\DataVersionTeacherDepositoryContract;
use App\Depositories\Contracts\DepartmentDepositoryContract;
use App\Depositories\Contracts\DeviceDepositoryContract;
use App\Depositories\Contracts\ExamScheduleDepositoryContract;
use App\Depositories\Contracts\ExamScheduleGuestDepositoryContract;
use App\Depositories\Contracts\FacultyDepositoryContract;
use App\Depositories\Contracts\FixDepositoryContract;
use App\Depositories\Contracts\GuestInfoDepositoryContract;
use App\Depositories\Contracts\ModuleClassDepositoryContract;
use App\Depositories\Contracts\ModuleScoreDepositoryContract;
use App\Depositories\Contracts\ModuleScoreGuestDepositoryContract;
use App\Depositories\Contracts\NotificationAccountDepositoryContract;
use App\Depositories\Contracts\NotificationDepositoryContract;
use App\Depositories\Contracts\NotificationGuestDepositoryContract;
use App\Depositories\Contracts\OtherDepartmentDepositoryContract;
use App\Depositories\Contracts\ParticipateDepositoryContract;
use App\Depositories\Contracts\ScheduleDepositoryContract;
use App\Depositories\Contracts\StudentDepositoryContract;
use App\Depositories\Contracts\TeacherDepositoryContract;
use App\Depositories\DataVersionStudentDepository;
use App\Depositories\DataVersionTeacherDepository;
use App\Depositories\DepartmentDepository;
use App\Depositories\DeviceDepository;
use App\Depositories\ExamScheduleDepository;
use App\Depositories\ExamScheduleGuestDepository;
use App\Depositories\FacultyDepository;
use App\Depositories\FixDepository;
use App\Depositories\GuestInfoDepository;
use App\Depositories\ModuleClassDepository;
use App\Depositories\ModuleScoreDepository;
use App\Depositories\ModuleScoreGuestDepository;
use App\Depositories\NotificationAccountDepository;
use App\Depositories\NotificationDepository;
use App\Depositories\NotificationGuestDepository;
use App\Depositories\OtherDepartmentDepository;
use App\Depositories\ParticipateDepository;
use App\Depositories\ScheduleDepository;
use App\Depositories\StudentDepository;
use App\Depositories\TeacherDepository;
use Illuminate\Support\ServiceProvider;

class AppDepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NotificationAccountDepositoryContract::class, NotificationAccountDepository::class);
        $this->app->bind(DataVersionStudentDepositoryContract::class, DataVersionStudentDepository::class);
        $this->app->bind(DataVersionTeacherDepositoryContract::class, DataVersionTeacherDepository::class);
        $this->app->bind(OtherDepartmentDepositoryContract::class, OtherDepartmentDepository::class);
        $this->app->bind(NotificationDepositoryContract::class, NotificationDepository::class);
        $this->app->bind(ExamScheduleDepositoryContract::class, ExamScheduleDepository::class);
        $this->app->bind(ModuleScoreDepositoryContract::class, ModuleScoreDepository::class);
        $this->app->bind(ModuleClassDepositoryContract::class, ModuleClassDepository::class);
        $this->app->bind(ParticipateDepositoryContract::class, ParticipateDepository::class);
        $this->app->bind(ScheduleDepositoryContract::class, ScheduleDepository::class);
        $this->app->bind(TeacherDepositoryContract::class, TeacherDepository::class);
        $this->app->bind(StudentDepositoryContract::class, StudentDepository::class);
        $this->app->bind(AccountDepositoryContract::class, AccountDepository::class);
        $this->app->bind(DeviceDepositoryContract::class, DeviceDepository::class);
        $this->app->bind(ClassDepositoryContract::class, ClassDepository::class);
        $this->app->bind(FixDepositoryContract::class, FixDepository::class);
        $this->app->bind(DepartmentDepositoryContract::class, DepartmentDepository::class);
        $this->app->bind(FacultyDepositoryContract::class, FacultyDepository::class);

        $this->app->bind(NotificationGuestDepositoryContract::class, NotificationGuestDepository::class);
        $this->app->bind(ExamScheduleGuestDepositoryContract::class, ExamScheduleGuestDepository::class);
        $this->app->bind(ModuleScoreGuestDepositoryContract::class, ModuleScoreGuestDepository::class);
        $this->app->bind(GuestInfoDepositoryContract::class, GuestInfoDepository::class);

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
