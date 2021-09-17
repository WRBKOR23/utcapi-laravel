<?php


namespace App\BusinessClass;


use App\Helpers\SharedData;

class ExcelDataHandler
{
    public function handleData ($formatted_data) : array
    {
        $complete_data   = [];
        $class_list      = [];
        $student_list    = [];
        $account_list    = [];
        $id_student_list = [];

        $part_of_sql_1 = '';
        $part_of_sql_2 = '';

        foreach ($formatted_data['student'] as &$student)
        {
            $id_student_list[] = $student['id_student'];

            $class_info   = $this->_getInfoOfFacultyClass($student['id_class']);
            $class_list[] = $class_info;

            $student_list[] = $student['id_student'];
            $student_list[] = $student['student_name'];
            $student_list[] = $student['birth'];
            $student_list[] = $student['id_class'];
            $part_of_sql_1  .= '(?,?,?,?,null,null,null),';

            $account_list[] = $student['id_student'];
            $account_list[] = $student['birth'];

            $part_of_sql_2 .= '(?,0,0,0,0),';
        }
        $account_list = array_chunk($account_list, 200);

        $part_of_sql_1 = rtrim($part_of_sql_1, ',');
        $part_of_sql_2 = rtrim($part_of_sql_2, ',');

        $complete_data['student']['arr'] = $student_list;
        $complete_data['student']['sql'] = $part_of_sql_1;

        $complete_data['data_version']['arr'] = $id_student_list;
        $complete_data['data_version']['sql'] = $part_of_sql_2;

        $complete_data['id_student']['arr'] = $id_student_list;
        $complete_data['account']['arr']    = $account_list;
        $complete_data['class']['arr']      = array_unique($class_list, SORT_REGULAR);;

        $participate_list = [];
        $part_of_sql_3    = '';
        foreach ($formatted_data['participate'] as &$participate)
        {
            $participate_list[] = $participate['id_module_class'];
            $participate_list[] = $participate['id_student'];
            $part_of_sql_3      .= '(?,?),';
        }
        $part_of_sql_3                       = rtrim($part_of_sql_3, ',');
        $complete_data['participate']['arr'] = $participate_list;
        $complete_data['participate']['sql'] = $part_of_sql_3;

        $class_list    = [];
        $part_of_sql_4 = '';
        foreach ($complete_data['class']['arr'] as &$class)
        {
            $class_list[]  = $class['id_class'];
            $class_list[]  = $class['academic_year'];
            $class_list[]  = $class['class_name'];
            $class_list[]  = $class['id_faculty'];
            $part_of_sql_4 .= '(?,?,?,?),';
        }
        $part_of_sql_4                 = rtrim($part_of_sql_4, ',');
        $complete_data['class']['arr'] = $class_list;
        $complete_data['class']['sql'] = $part_of_sql_4;

        $complete_data['exception1']   = $formatted_data['exception1'];
        $complete_data['module_class'] = $formatted_data['module_class'];

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
        $class_info['id_class']      = $id_class;
        $class_info['academic_year'] = $academic_year;

        return $class_info;
    }
}
