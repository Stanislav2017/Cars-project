<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%types}}`.
 */
class m190321_075559_create_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%types}}', [
            'id' => $this->primaryKey(),
            'brand_id' => $this->integer(),
            'name' => $this->string()->unique(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%types}}');
    }
}
