<?php

namespace App\Helpers;

class SharedFunctions
{
    public static function printError ($error)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date    = date('d/m/Y H:i:s');
        $message = $date . PHP_EOL;
        $message .= 'Code: ' . $error->getCode() . PHP_EOL;
        $message .= $error->getMessage() . PHP_EOL;
        $message .= $error->getFile() . '  ' . $error->getLine() . PHP_EOL;
        $message .= '=========================================================================================' .
                    PHP_EOL;

        file_put_contents(config('filesystems.disks.errors.file_path'), $message, FILE_APPEND);
    }

    public static function getDateTimeNow () : string
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $temp_date = date('d/m/Y H:i:s');
        $arr       = explode(' ', $temp_date);
        $arr2      = explode('/', $arr[0]);
        $date_time = $arr2[2] . '/' . $arr2[1] . '/' . $arr2[0] . ' ' . $arr[1];

        return $date_time;
    }

    public static function formatString ($str) : string
    {
        $str = preg_replace('/[ ]+/', ' ', $str);
        $str = trim($str, ' ');

        return $str;
    }


    public static function formatDate ($date) : string
    {
        $date_split = explode('/', $date);
        $date       = $date_split[2] . '-' . $date_split[1] . '-' . $date_split[0];

        return $date;
    }

    public static function formatArray ($arr, $key) : array
    {
        $formatted_array = [];
        foreach ($arr as $a)
        {
            $formatted_array[] = [$key => $a];
        }

        return $formatted_array;
    }

    /*
     *  For Notification table_as only
     */
    public static function setUpNotificationData ($notification) : array
    {
        return [
            'title'       => SharedFunctions::formatString($notification['title']),
            'content'     => SharedFunctions::formatString($notification['content']),
            'type'        => $notification['type'],
            'id_sender'   => $notification['id_sender'],
            'time_create' => SharedFunctions::getDateTimeNow(),
            'time_start'  => $notification['time_start'],
            'time_end'    => $notification['time_end']
        ];
    }

    /*
     *  For Notification_Account table_as only
     */
    public static function setUpNotificationAccountData ($id_account_list, $id_notification) : array
    {
        $arr = [];
        foreach ($id_account_list as $id_account)
        {
            $arr[] = [
                'id_notification' => $id_notification,
                'id_account'      => $id_account
            ];
        }

        return $arr;
    }

    /*
     * For crawl qldt only
     */

    public static function formatWrongWord ($str)
    {
        $str = preg_replace('/Kê/', 'Kế', $str);
        $str = preg_replace('/hoach/', 'hoạch', $str);
        $str = preg_replace('/Phong/', 'Phòng', $str);

        return $str;
    }

    public static function formatStringDataCrawled ($str) : string
    {
        $str = preg_replace('/\s+/', ' ', $str);
        $str = str_replace('- ', '-', $str);
        $str = str_replace(' -', '-', $str);
        $str = trim($str, ' ');

        return $str;
    }

    public static function convertToOfficialSchoolYear ($shor_school_year) : string
    {
        $arr = explode('_', $shor_school_year);
        return '20' . $arr[0] . '_20' . $arr[1] . '_' . $arr[2];
    }

    public static function formatToOfficialSchoolYear ($school_year) : string
    {
        $semester_split = explode('_', $school_year);
        $school_year    = $semester_split[1] . '_' . $semester_split[2] . '_' . $semester_split[0];

        return $school_year;
    }

    public static function formatToUnOfficialSchoolYear ($school_year) : string
    {
        $semester_split = explode('_', $school_year);
        $school_year    = $semester_split[2] . '_' . $semester_split[0] . '_' . $semester_split[1];

        return $school_year;
    }
}
