<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%images}}`.
 */
class m190321_101724_create_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%images}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'size' => $this->string(),
            'object_id' => $this->integer(),
            'object_type' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%images}}');
    }
}
