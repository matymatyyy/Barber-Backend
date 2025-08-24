<?php 

namespace Src\Model\File;

use Src\Model\S3Model;
use Src\Entity\File\File;

final readonly class FileModel extends S3Model {

    public function upload(File $file): File
    {
        return $this->doUpload($file);
    }
}