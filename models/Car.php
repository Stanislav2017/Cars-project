<?php

namespace app\models;

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
    public $music;
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

    public function getSmallImages()
    {
        $this->hasMany(Image::class, ['object_id' => 'id', ])->where(['size' => Image::SMALL, 'object_type' => 'car'])->limit(1);
    }

    public function getSmallImage()
    {
        $this->hasOne(Image::class, ['object_id' => 'id', 'object_type' => 'car'])->where(['size' => Image::SMALL]);
    }

    public function getLargeImages()
    {
        $this->hasMany(Image::class, ['object_id' => 'id'])->where(['size' => Image::LARGE]);
    }

    public function getLargeImage()
    {
        $this->hasOne(Image::class, ['object_id' => 'id'])->where(['size' => Image::LARGE]);
    }

    public function getAllImages()
    {
        return $this->hasMany('app\models\Image', ['object_id' => 'id'])->where(['object_type' => 'car']);
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
