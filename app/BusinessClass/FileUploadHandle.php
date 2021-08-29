<?php

namespace App\BusinessClass;

use App\Helpers\SharedData;
use Exception;

class FileUploadHandle
{
    private string $new_file_name;
    private string $old_file_name;
    private array $json;


    /**
     * @return mixed
     */
    public function getOldFileName ()
    {
        return $this->old_file_name;
    }

    /**
     * @throws Exception
     */
    public function getData ($file): array
    {
        $this->_setUpFileUpload($file);
        $this->_readData();
        return $this->_extractData();
    }

    /**
     * @throws Exception
     */
    public function _setUpFileUpload ($file)
    {
        $original_file_name = $file->getClientOriginalName();

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $timeSplit = explode('.', microtime(true));

        $this->old_file_name = $file_name = substr($original_file_name, 0, strripos($original_file_name, '.'));
        $expand              = substr($original_file_name, strripos($original_file_name, '.'));;

        $new_file_name = preg_replace('/\s+/', '', $file_name);
        $new_file_name = $new_file_name . '_' . $timeSplit[0] . $timeSplit[1] . $expand;

        $location = storage_path('app/public/excels/' . $new_file_name);

        if (move_uploaded_file($file->getRealPath(), $location))
        {
            $this->new_file_name = $new_file_name;
        }
        else
        {
            throw new Exception();
        }
    }

    /**
     * @throws Exception
     */
    public function _readData ()
    {
        try
        {
            $command1 = escapeshellcmd('python main.py ' . $this->new_file_name);
            $command2 = 'cd ' . dirname(storage_path()) . '/app/Helpers/Python';
            $output   = shell_exec($command2 . ' && ' . $command1);
            if ($output == null)
            {
                throw new Exception();
            }

            $this->json = json_decode($output, true);
        }
        catch (Exception $error)
        {
            throw  $error;
        }
    }

    public function _extractData (): array
    {
        $data            = [];
        $class_list      = [];
        $student_list    = [];
        $account_list    = [];
        $id_student_list = [];

        $part_of_sql_1 = '';
        $part_of_sql_2 = '';

        foreach ($this->json['student_json'] as &$student)
        {
            $id_student_list[] = $student['ID_Student'];

            $class_info   = $this->_getInfoOfFacultyClass($student['ID_Class']);
            $class_list[] = $class_info;

            $student_list[] = $student['ID_Student'];
            $student_list[] = $student['Student_Name'];
            $student_list[] = $student['DoB'];
            $student_list[] = $student['ID_Class'];
            $part_of_sql_1  .= '(?,?,?,?,null,null,null),';

            $account_list[] = $student['ID_Student'];
            $account_list[] = $student['DoB'];

            $part_of_sql_2 .= '(?,0,0,0,0),';
        }
        $account_list = array_chunk($account_list, 200);

        $part_of_sql_1 = rtrim($part_of_sql_1, ',');
        $part_of_sql_2 = rtrim($part_of_sql_2, ',');

        $data['student']['arr'] = $student_list;
        $data['student']['sql'] = $part_of_sql_1;

        $data['data_version']['arr'] = $id_student_list;
        $data['data_version']['sql'] = $part_of_sql_2;

        $data['id_student']['arr'] = $id_student_list;
        $data['account']['arr']    = $account_list;
        $data['class']['arr']      = array_unique($class_list, SORT_REGULAR);;

        $participate_list = [];
        $part_of_sql_3    = '';
        foreach ($this->json['participate_json'] as &$participate)
        {
            $participate_list[] = $participate['ID_Module_Class'];
            $participate_list[] = $participate['ID_Student'];
            $part_of_sql_3      .= '(?,?,null,null,null,null),';
        }
        $part_of_sql_3              = rtrim($part_of_sql_3, ',');
        $data['participate']['arr'] = $participate_list;
        $data['participate']['sql'] = $part_of_sql_3;

        $class_list    = [];
        $part_of_sql_4 = '';
        foreach ($data['class']['arr'] as &$class)
        {
            $class_list[]  = $class['ID_Class'];
            $class_list[]  = $class['Academic_Year'];
            $class_list[]  = $class['Class_Name'];
            $class_list[]  = $class['ID_Faculty'];
            $part_of_sql_4 .= '(?,?,?,?),';
        }
        $part_of_sql_4        = rtrim($part_of_sql_4, ',');
        $data['class']['arr'] = $class_list;
        $data['class']['sql'] = $part_of_sql_4;

        $data['exception_json'] = $this->json['exception_json'];

        return $data;
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
            if (!isset(SharedData::$faculty_class_info[substr($class, 0, strlen($class) - 1)]))
            {
                $class_info['ID_Faculty'] = 'KHOAKHAC';
                $class_info['Class_Name'] = 'Lớp thuộc khoa khác';
            }
            else
            {
                $class_info               = SharedData::$faculty_class_info[substr($class, 0, strlen($class) - 1)];
                $name_academic_year       = substr_replace($academic_year, 'hóa ', 1, 0);
                $class_info['Class_Name'] = $class_info['Class_Name'] . ' ' . $num . ' - ' . $name_academic_year;
            }
        }
        else
        {
            if (!isset(SharedData::$faculty_class_info[$class]))
            {
                $class_info['ID_Faculty'] = 'KHOAKHAC';
                $class_info['Class_Name'] = 'Lớp thuộc khoa khác';
            }
            else
            {
                $class_info               = SharedData::$faculty_class_info[$class];
                $name_academic_year       = substr_replace($academic_year, 'hóa ', 1, 0);
                $class_info['Class_Name'] = $class_info['Class_Name'] . ' - ' . $name_academic_year;
            }
        }
        $class_info['ID_Class']      = $id_class;
        $class_info['Academic_Year'] = $academic_year;

        return $class_info;
    }
}
