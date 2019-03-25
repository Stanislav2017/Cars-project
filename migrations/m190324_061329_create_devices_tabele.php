<?php

use yii\db\Migration;

/**
 * Class m190324_061329_create_devices_tabele
 */
class m190324_061329_create_devices_tabele extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%devices}}', [
            'id' => $this->primaryKey(),
            'device_type_id' => $this->integer()->notNull(),
            'title' => $this->string(191)->unique()->notNull()

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%devices}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190324_061329_create_devices_tabele cannot be reverted.\n";

        return false;
    }
    */
}
