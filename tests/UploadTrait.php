<?php


namespace App\Tests;

use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Trait UploadTrait
 * @package App\Tests
 */
trait UploadTrait
{
    /**
     * @return UploadedFile
     */
    static public function createImage(): UploadedFile
    {
        $fileName = md5(random_bytes(10)) . ".png";

        copy(__DIR__.'/../public/uploads/image.png', __DIR__.'/../public/uploads/' . $fileName);

        return new UploadedFile(
            __DIR__ . '/../public/uploads/' . $fileName,
            $fileName,
            null,
            null,
            true
        );
    }
    /**
     * @return UploadedFile
     */
    static public function createFileText(): UploadedFile
    {
        $fileName = md5(random_bytes(10)) . ".txt";

        copy(__DIR__.'/../public/uploads/file.txt', __DIR__.'/../public/uploads/' . $fileName);

        return new UploadedFile(
            __DIR__ . '/../public/uploads/' . $fileName,
            $fileName,
            null,
            null,
            true
        );
    }
}
