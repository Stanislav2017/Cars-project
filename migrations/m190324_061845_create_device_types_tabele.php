<?php

use yii\db\Migration;

/**
 * Class m190324_061845_create_device_types_tabele
 */
class m190324_061845_create_device_types_tabele extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%device_types}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(191)->unique()->notNull()

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%device_types}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190324_061845_create_device_types_tabele cannot be reverted.\n";

        return false;
    }
    */
}
