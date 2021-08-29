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
        $message .= '=========================================================================================' . PHP_EOL;

        file_put_contents(config('filesystems.disks.errors.file_path'), $message, FILE_APPEND);
    }

    public static function printFileImportException ($file_name, $module_class_list, $title)
    {
        $message = $title . PHP_EOL;
        foreach ($module_class_list as $module_class)
        {
            $message .= $module_class . PHP_EOL;
        }

        file_put_contents(storage_path('app/public/excels/errors/') . $file_name, $message);
    }

    public static function getDateTimeNow (): string
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $temp_date = date('d/m/Y H:i:s');
        $arr       = explode(' ', $temp_date);
        $arr2      = explode('/', $arr[0]);
        $date_time = $arr2[2] . '/' . $arr2[1] . '/' . $arr2[0] . ' ' . $arr[1];

        return $date_time;
    }

    public static function formatString ($str): string
    {
        $str = preg_replace('/[ ]+/', ' ', $str);
        $str = trim($str, ' ');

        return $str;
    }


    public static function formatDate ($date): string
    {
        $date_split = explode('/', $date);
        $date       = $date_split[2] . '-' . $date_split[1] . '-' . $date_split[0];

        return $date;
    }

    /*
     *  For Notification table_as only
     */
    public static function setUpNotificationData ($notification): array
    {
        return [
            'Title' => SharedFunctions::formatString($notification['title']),
            'Content' => SharedFunctions::formatString($notification['content']),
            'Typez' => $notification['typez'],
            'ID_Sender' => $notification['id_sender'],
            'Time_Create' => SharedFunctions::getDateTimeNow(),
            'Time_Start' => $notification['time_start'],
            'Time_End' => $notification['time_end']
        ];
    }

    /*
     *  For Notification_Account table_as only
     */
    public static function setUpNotificationAccountData ($id_account_list, $id_notification): array
    {
        $arr = [];
        foreach ($id_account_list as $id_account)
        {
            $arr[] = [
                'ID_Notification' => $id_notification,
                'ID_Account' => $id_account
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

    public static function formatStringDataCrawled ($str): string
    {
        $str = preg_replace('/\s+/', ' ', $str);
        $str = str_replace('- ', '-', $str);
        $str = str_replace(' -', '-', $str);
        $str = trim($str, ' ');

        return $str;
    }

    public static function convertToOfficialSchoolYear ($shor_school_year): string
    {
        $arr = explode('_', $shor_school_year);

        return '20' . $arr[0] . '_20' . $arr[1] . '_' . $arr[2];
    }

    public static function formatToOfficialSchoolYear ($school_year): string
    {
        $semester_split = explode('_', $school_year);
        $school_year    = $semester_split[1] . '_' . $semester_split[2] . '_' . $semester_split[0];

        return $school_year;
    }

    public static function formatToUnOfficialSchoolYear ($school_year_list): array
    {
        $formatted_data = [];
        foreach ($school_year_list as $item)
        {
            $semester_split   = explode('_', $item);
            $formatted_data[] = $semester_split[2] . '_' . $semester_split[0] . '_' . $semester_split[1];
        }

        return $formatted_data;
    }

    /*
     *
     */

    public static function formatGetNotificationResponse ($data): array
    {
        $response = [];

        for ($i = 0; $i < count($data); $i++)
        {
            $response['notification'][$i] = $data[$i];

            $response['sender'][$i]['ID_Sender']   = $data[$i]->ID_Sender;
            $response['sender'][$i]['Sender_Name'] = $data[$i]->Sender_Name;
            $response['sender'][$i]['permission']  = $data[$i]->permission;

            unset($response['notification'][$i]->Sender_Name);
            unset($response['notification'][$i]->permission);
        }

        $response['sender'] = array_values(array_unique($response['sender'], SORT_REGULAR));

        return $response;
    }

    /*
     *
     */

    public static function setUpNotificationGuestData ($id_notification, $id_guest_list): array
    {
        $data = [];
        foreach ($id_guest_list as $id_guest)
        {
            $arr['ID_Notification'] = $id_notification;
            $arr['ID_Guest']        = $id_guest;

            $data[] = $arr;
        }

        return $data;
    }
}
