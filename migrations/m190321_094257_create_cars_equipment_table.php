<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cars_equipment}}`.
 */
class m190321_094257_create_cars_equipment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%cars_equipment}}', [
            'car_id' => $this->integer(),
            'equipment_id' => $this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%cars_equipment}}');
    }
}
