<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%book_copies}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%books}}`
 */
class m221029_204245_create_book_copies_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book_copies}}', [
            'id' => $this->primaryKey(),
            'status' => $this->string()->defaultValue('Disponible')->notNull(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp(),
            'books_id' => $this->integer(11)->notNull(),
        ]);

        // creates index for column `books_id`
        $this->createIndex(
            '{{%idx-book_copies-books_id}}',
            '{{%book_copies}}',
            'books_id'
        );

        // add foreign key for table `{{%books}}`
        $this->addForeignKey(
            '{{%fk-book_copies-books_id}}',
            '{{%book_copies}}',
            'books_id',
            '{{%books}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%books}}`
        $this->dropForeignKey(
            '{{%fk-book_copies-books_id}}',
            '{{%book_copies}}'
        );

        // drops index for column `books_id`
        $this->dropIndex(
            '{{%idx-book_copies-books_id}}',
            '{{%book_copies}}'
        );

        $this->dropTable('{{%book_copies}}');
    }
}
