<?php 

namespace Src\Model;

use Aws\S3\S3Client;
use Src\Infrastructure\S3\Client;
use Aws\Exception\AwsException;
use Src\Entity\File\File;

readonly class S3Model {
    
    private S3Client $client;

    public function __construct() {
        $s3Client = new Client();
        $this->client = $s3Client->connect();
    }

    public function doUpload(File $file): File 
    {
        try {
            $result = $this->client->putObject([
                'Bucket' => $_ENV["AWS_S3_BUCKET_NAME"],
                'Key'    => $file->fileName(),
                'SourceFile' => $file->tmpPath(),
                'ACL'    => 'public-read',
                'ContentType' => mime_content_type($file->tmpPath()),
            ]);

            return File::fromFile($file, $result['ObjectURL']);
        } catch (AwsException $e) {
            return $file;
        }
    }
}