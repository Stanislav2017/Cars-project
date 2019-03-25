<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cars}}`.
 */
class m190321_070317_create_cars_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%cars}}', [
            'id' => $this->primaryKey(),
            'brand_id' => $this->integer(),
            'type_id' => $this->integer(),
            'mileage' => $this->string(),
            'price' => $this->string(),
            'phone' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%cars}}');
    }
}
