<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%clients}}`.
 */
class m190320_020650_create_clients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%clients}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64)->notNull(),
            'surname' => $this->string(64)->notNull(),
            'phone' => $this->string(14)->notNull(),
            'address' => $this->string(64)->notNull(),
            'comment' => $this->text()->notNull(),
            'feedbackDataId' => $this->string()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%clients}}');
    }
}
