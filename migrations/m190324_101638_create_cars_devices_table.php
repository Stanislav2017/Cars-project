<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cars_devices}}`.
 */
class m190324_101638_create_cars_devices_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cars_devices}}', [
            'id' => $this->primaryKey(),
            'car_id' => $this->integer(),
            'device_id' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cars_devices}}');
    }
}
