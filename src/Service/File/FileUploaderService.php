<?php 

declare(strict_types = 1);

namespace Src\Service\File;

use Src\Model\File\FileModel;
use Src\Entity\File\File;
use Src\Entity\File\Exception\FileNotUploadedException;

final readonly class FileUploaderService {

    private FileModel $model;

    public function __construct() 
    {
        $this->model = new FileModel();
    }

    public function upload(string $name, string $fullPath, string $type, string $tmpName, int $size): File 
    {
        $file = File::create($name, $fullPath, $type, $tmpName, $size);
        
        $file = $this->model->upload($file);
        
        if ($file->uploadUrl() === null) {
            throw new FileNotUploadedException();
        }

        return $file;
    }

}

