<?php

namespace app\models;

use app\traits\Morphed;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "cars".
 *
 * @property int $id
 * @property int $brand_id
 * @property int $type_id
 * @property string $mileage
 * @property string $price
 * @property string $phone
 */
class Car extends \yii\db\ActiveRecord
{
    public $images;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cars';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['brand_id', 'type_id', 'mileage', 'price', 'phone'], 'required'],
            [['brand_id', 'type_id'], 'integer'],
            ['brand_id', 'exist', 'targetClass' => Brand::class, 'targetAttribute' => ['brand_id' => 'id']],
            ['type_id', 'exist', 'targetClass' => Type::class, 'targetAttribute' => ['type_id' => 'id']],
            [['mileage', 'price', 'phone'], 'string', 'max' => 255],
            [['images'], 'file', 'extensions' => 'jpg, png', 'maxFiles' => 3],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Идентифекатор',
            'brand_id' => 'Марка',
            'type_id' => 'Модель',
            'mileage' => 'Пробег',
            'price' => 'Цена',
            'phone' => 'Телефон',
            'images' => 'Изображения'
        ];
    }

    public function getAllImages()
    {
        return $this->hasMany(Image::class, ['object_id' => 'id'])->onCondition(['object_type' => 'car']);
    }

    public function getSmallImages()
    {
        return $this->hasMany(Image::class, ['object_id' => 'id'])->onCondition([
            'object_type' => 'car',
            'size' => Image::SMALL
        ]);
    }

    public function getSmallImage()
    {
        return $this->hasOne(Image::class, ['object_id' => 'id'])->onCondition([
            'object_type' => 'car',
            'size' => Image::SMALL
        ]);
    }

    public function getLargeImages()
    {
        return $this->hasMany(Image::class, ['object_id' => 'id'])->onCondition([
            'object_type' => 'car',
            'size' => Image::LARGE
        ]);
    }

    public function getLargeImage()
    {
        return $this->hasOne(Image::class, ['object_id' => 'id'])->onCondition([
            'object_type' => 'car',
            'size' => Image::LARGE
        ]);
    }

    public function getBrand()
    {
        return $this->hasOne(Brand::class, ['id' => 'brand_id']);
    }

    public function getType()
    {
        return $this->hasOne(Type::class, ['id' => 'type_id']);
    }

    public function getDevices()
    {
        return $this->hasMany(Device::class, ['id' => 'device_id'])
            ->viaTable('cars_devices', ['car_id' => 'id']);
    }
}
