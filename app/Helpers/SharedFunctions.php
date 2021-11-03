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

    public static function convertToOfficialTerm ($term) : string
    {
        $arr = explode('_', $term);
        return '20' . $arr[0] . '_20' . $arr[1] . '_' . $arr[2];
    }

    public static function formatToOfficialTerm ($term) : string
    {
        $arr  = explode('_', $term);
        $term = $arr[1] . '_' . $arr[2] . '_' . $arr[0];

        return $term;
    }

    public static function formatToUnOfficialTerm ($term) : string
    {
        $arr  = explode('_', $term);
        $term = $arr[2] . '_' . $arr[0] . '_' . $arr[1];

        return $term;
    }
}
