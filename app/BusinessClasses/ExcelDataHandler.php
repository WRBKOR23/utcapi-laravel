<?php


namespace App\BusinessClasses;


use App\Helpers\SharedData;

class ExcelDataHandler
{
    public function handleData ($formatted_data) : array
    {
        $complete_data             = [];
        $class_list                = [];
        $account_list              = [];
        $data_version_student_list = [];

        foreach ($formatted_data['student'] as &$student)
        {
            $class_info   = $this->_getInfoOfFacultyClass($student['id_class']);
            $class_list[] = $class_info;

            $account_list[] = [
                'username'   => $student['id'],
                'password'   => $student['birth'],
                'permission' => '0'
            ];

            $data_version_student_list[] = ['id_student' => $student['id']];

        }
        $account_list = array_chunk($account_list, 200);
        $class_list   = array_unique($class_list, SORT_REGULAR);;


        $complete_data['class']                = $class_list;
        $complete_data['account']              = $account_list;
        $complete_data['data_version_student'] = $data_version_student_list;
        $complete_data['student']              = $formatted_data['student'];
        $complete_data['participate']          = $formatted_data['participate'];
        $complete_data['exception1']           = $formatted_data['exception1'];
        $complete_data['module_class']         = $formatted_data['module_class'];

        return $complete_data;
    }

    private function _getInfoOfFacultyClass (&$id_class)
    {
        $id_class      = preg_replace('/\s+/', '', $id_class);
        $arr           = explode('.', $id_class);
        $academic_year = $arr[0];

        unset($arr[0]);
        $class = '';
        foreach ($arr as $a)
        {
            $class .= $a . '.';
        }
        $class = rtrim($class, '.');

        $num = substr($class, strlen($class) - 1, 1);
        if (is_numeric($num))
        {
            if (!isset(SharedData::$faculty_class_and_major_info[substr($class, 0, strlen($class) - 1)]))
            {
                $class_info['id_faculty'] = 'KHOAKHAC';
                $class_info['class_name'] = 'Lớp thuộc khoa khác';
            }
            else
            {
                $class_info               = SharedData::$faculty_class_and_major_info[substr($class, 0,
                                                                                             strlen($class) - 1)];
                $name_academic_year       = substr_replace($academic_year, 'hóa ', 1, 0);
                $class_info['class_name'] = $class_info['class_name'] . ' ' . $num . ' - ' . $name_academic_year;
            }
        }
        else
        {
            if (!isset(SharedData::$faculty_class_and_major_info[$class]))
            {
                $class_info['id_faculty'] = 'KHOAKHAC';
                $class_info['class_name'] = 'Lớp thuộc khoa khác';
            }
            else
            {
                $class_info               = SharedData::$faculty_class_and_major_info[$class];
                $name_academic_year       = substr_replace($academic_year, 'hóa ', 1, 0);
                $class_info['class_name'] = $class_info['class_name'] . ' - ' . $name_academic_year;
            }
        }
        $class_info['id']            = $id_class;
        $class_info['academic_year'] = $academic_year;

        return $class_info;
    }
}
