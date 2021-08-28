<?php


namespace App\BusinessClass;

use Aws\S3\S3Client;
use finfo;

require dirname(__DIR__, 2) . '/vendor/autoload.php';

class AmazonS3
{
    private string $bucket_name;
    private S3Client $s3;

    public function __construct ()
    {
        $this->bucket_name = config('filesystems.disks.s3.bucket');

        $this->s3 = new S3Client([
                                     'region'      => config('filesystems.disks.s3.region'),
                                     'version'     => 'latest',
                                     'credentials' => [
                                         'key'    => config('filesystems.disks.s3.key'),
                                         'secret' => config('filesystems.disks.s3.secret'),
                                     ]
                                 ]);
    }

    public function uploadFile ($file_name, $file_location, $folder)
    {
        $finfo     = new finfo(FILEINFO_MIME_TYPE);
        $file_mime = $finfo->file($file_location);

        $this->s3->putObject([
                                 'Bucket'      => $this->bucket_name,
                                 'Key'         => $folder . $file_name,
                                 'SourceFile'  => $file_location,
                                 'ACL'         => 'public-read',
                                 'ContentType' => $file_mime
                             ]);
    }

    public function getDataFromFile ($file_name, $folder)
    {
        $result = $this->s3->getObject([
                                           'Bucket' => $this->bucket_name,
                                           'Key'    => $folder . $file_name,
                                           'Body'   => 'this is the body!',
                                       ]);

        return $result['Body'];
    }
}
