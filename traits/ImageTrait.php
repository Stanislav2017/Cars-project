<?php

namespace app\traits;

use function copy;
use function dirname;
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
     * @param string $destImagePath
     * @param string $targetImagePath
     * @param string $filename
     * @param $width
     * @param $height
     */
    public function thumbs_image(string $destImagePath, string $targetImagePath, $widthNew, $heightNew)
    {
        $imagine = Image::getImagine();
        $image = $imagine->open($destImagePath);
        if (!file_exists(dirname($targetImagePath))) {
            FileHelper::createDirectory(dirname($targetImagePath), 0775);
        }
        list($width, $height) = getimagesize($destImagePath);
        if ($width > $height) {
            $image_height = floor(($height / $width) * $widthNew);
            $image_width  = $widthNew;
        } else {
            $image_width  = floor(($width / $height) * $heightNew);
            $image_height = $heightNew;
        }

        $image->resize(new Box($image_width, $image_height))->save($targetImagePath, ['quality' => 100]);
    }
}