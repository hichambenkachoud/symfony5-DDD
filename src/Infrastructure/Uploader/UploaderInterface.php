<?php


namespace App\Infrastructure\Uploader;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Interface UploaderInterface
 * @package App\Infrastructure\Uploader
 */
interface UploaderInterface
{

    public function upload(UploadedFile $file): string;
}
