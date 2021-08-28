<?php

    namespace App\Depositories;

    use App\Depositories\Contracts\ScheduleDepositoryContract;
    use App\Models\Schedule;
    use Illuminate\Support\Collection;

    class ScheduleDepository implements ScheduleDepositoryContract
    {
        // Schedule Model
        private Schedule $model;

        public function __construct (Schedule $model)
        {
            $this->model = $model;
        }

        public function getStudentSchedules ($id_student) : Collection
        {
            return $this->model->getStudentSchedules($id_student);
        }

        public function getTeacherSchedules ($id_teacher) : Collection
        {
            return $this->model->getTeacherSchedules($id_teacher);
        }
    }