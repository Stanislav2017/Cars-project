<?php

namespace app\models;

use const false;
use yii\base\Model;

class ImageUpload extends Model
{
    public $car_images;

    /*public function rules()
    {
        return [
            [['car_images'], 'file', 'extensions' => 'jpg, png', 'maxFiles' => 3, 'skipOnEmpty' => false],
        ];
    }*/

    public function attributeLabels()
    {
        return [
            'car_images' => 'Изображения'
        ];
    }
}