<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cars_devices".
 *
 * @property int $id
 * @property int $car_id
 * @property int $device_id
 */
class CarDevice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cars_devices';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['car_id', 'device_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'car_id' => 'Car ID',
            'device_id' => 'Device ID',
        ];
    }
}
