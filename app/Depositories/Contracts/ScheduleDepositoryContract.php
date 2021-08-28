<?php

    namespace App\Depositories\Contracts;

    interface ScheduleDepositoryContract
    {
        public function getStudentSchedules($id_student);

        public function getTeacherSchedules($id_teacher);
    }