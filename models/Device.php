<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "devices".
 *
 * @property int $id
 * @property int $device_type_id
 * @property string $title
 */
class Device extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'devices';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['device_type_id', 'title'], 'required'],
            [['device_type_id'], 'integer'],
            [['title'], 'string', 'max' => 191],
            [['title'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Идентификатор',
            'device_type_id' => 'Тип оборудования',
            'title' => 'Название',
        ];
    }

    public function getDeviceType()
    {
        return $this->hasOne(DeviceType::class, ['id' => 'device_type_id']);
    }
}
