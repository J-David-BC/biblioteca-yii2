<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%users}}`.
 */
class m221029_211352_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(45)->notNull(),
            'last_name' => $this->string(45),
            'address' => $this->string(45),
            'phone_number' => $this->string(45),
            'email' => $this->string(45),
            'type' => $this->string()->default_value('Normal')->notNull(),
            'school' => $this->string(45),
            'birth_date' => $this->date(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp(),
            'status' => $this->string()->default_value('Activo')->notNull(),
            'age' => $this->integer(11)->append('GENERATED ALWAYS AS (TIMESTAMP(YEAR,CURTDATE(),birth_date)) VIRTUAL'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
    }
}
