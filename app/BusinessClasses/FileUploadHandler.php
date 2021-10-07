<?php

namespace App\BusinessClasses;

use App\Helpers\SharedData;
use App\Models\Module;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class FileUploadHandler
{
    private ExcelFileReader $excelReader;
    private ExcelDataHandler $excelDataHandler;
    private string $new_file_name;
    private string $old_file_name;

    /**
     * FileUploadHandler constructor.
     * @param ExcelFileReader $excelReader
     * @param ExcelDataHandler $excelDataHandler
     */
    public function __construct (ExcelFileReader $excelReader, ExcelDataHandler $excelDataHandler)
    {
        $this->excelReader      = $excelReader;
        $this->excelDataHandler = $excelDataHandler;
    }

    /**
     * @return string
     */
    public function getOldFileName (): string
    {
        return $this->old_file_name;
    }

    /**
     * @throws Exception
     */
    public function getData ($file, $module_list): array
    {
        $this->_handleFileUpload($file);
        $formatted_data = $this->_readData($module_list);
        return $this->_handleData($formatted_data);
    }

    /**
     * @throws Exception
     */
    private function _handleFileUpload ($file)
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
    private function _readData ($module_list): array
    {
        return $this->excelReader->readData($this->new_file_name, $module_list);
    }

    private function _handleData ($formatted_data): array
    {
        return $this->excelDataHandler->handleData($formatted_data);
    }
}
