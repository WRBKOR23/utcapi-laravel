<?php


namespace App\Services;


use App\BusinessClass\AmazonS3;
use App\Depositories\Contracts\FixDepositoryContract;

class FixScheduleService implements Contracts\FixScheduleServiceContract
{
    private FixDepositoryContract $fixDepository;
    private AmazonS3 $amazonS3s3;

    /**
     * FixScheduleService constructor.
     * @param FixDepositoryContract $fixDepository
     * @param AmazonS3 $amazonS3s3
     */
    public function __construct (FixDepositoryContract $fixDepository, AmazonS3 $amazonS3s3)
    {
        $this->fixDepository = $fixDepository;
        $this->amazonS3s3    = $amazonS3s3;
    }

    public function sendNotificationOfFixSchedules ()
    {
        $this->amazonS3s3->uploadFile(config('filesystems.disks.s3.file_name_1'),
                                      config('filesystems.disks.s3.file_path_1'),
                                      config('filesystems.disks.s3.cron_job_folder_1'));
    }
}
