<?php

namespace app\traits;

use function copy;
use function file_exists;
use function floor;
use function getimagesize;
use Imagine\Image\Box;
use Yii;
use yii\helpers\FileHelper;
use yii\imagine\Image;
use yii\web\UploadedFile;

/**
 * Trait ImageTrait crud with image.
 * @package app\traits
 */
trait ImageTrait
{
    /**
     * Save upload image.
     * 
     * @param UploadedFile $oFile
     * @param string $path
     * @param string $filename
     * @return bool
     */
    public function save_image(UploadedFile $oFile, string $path, string $filename) : bool
    {
        if (!file_exists($path)) {
            FileHelper::createDirectory($path, 0775);
        }
        return $oFile->saveAs($path . $filename);
    }

    /**
     * Change image.
     * 
     * @param string $image_path
     * @param string $path
     * @param string $filename
     * @param $width
     * @param $height
     */
    public function thumbs_image(string $image_path, string $path, string $filename, $new_width, $new_height)
    {
        $imagine = Image::getImagine();
        $image = $imagine->open($image_path);
        if (!file_exists($path)) {
            FileHelper::createDirectory($path, 0775);
        }
        list($width, $height) = getimagesize($image_path);
        if ($width > $height) {
            $image_height = floor(($height / $width) * $new_width);
            $image_width  = $new_width;
        } else {
            $image_width  = floor(($width / $height) * $new_height);
            $image_height = $new_height;
        }

        $image->resize(new Box($image_width, $image_height))->save($path . $filename, ['quality' => 100]);
    }
}