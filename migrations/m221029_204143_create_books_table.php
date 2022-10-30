<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books}}`.
 */
class m221029_204143_create_books_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%books}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(45)->notNull(),
            'author' => $this->string(45),
            'editorial' => $this->string(45),
            'year' => $this->integer(4),
            'isbn' => $this->string(13),
            'section' => $this->string()->defaultValue('General')->notNull(),
            'copies' => $this->integer(11),
            'image' => $this->string(255),
            'description' => $this->string(99),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%books}}');
    }
}
