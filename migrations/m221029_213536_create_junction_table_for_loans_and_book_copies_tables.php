<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%loans_book_copies}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%loans}}`
 * - `{{%book_copies}}`
 */
class m221029_213536_create_junction_table_for_loans_and_book_copies_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%loans_book_copies}}', [
            'loans_id' => $this->integer(),
            'book_copies_id' => $this->integer(),
            'loan_status' => $this->string()->notNull()->defaultValue('Prestado'),
            'PRIMARY KEY(loans_id, book_copies_id)',
        ]);

        // creates index for column `loans_id`
        $this->createIndex(
            '{{%idx-loans_book_copies-loans_id}}',
            '{{%loans_book_copies}}',
            'loans_id'
        );

        // add foreign key for table `{{%loans}}`
        $this->addForeignKey(
            '{{%fk-loans_book_copies-loans_id}}',
            '{{%loans_book_copies}}',
            'loans_id',
            '{{%loans}}',
            'id',
            'CASCADE'
        );

        // creates index for column `book_copies_id`
        $this->createIndex(
            '{{%idx-loans_book_copies-book_copies_id}}',
            '{{%loans_book_copies}}',
            'book_copies_id'
        );

        // add foreign key for table `{{%book_copies}}`
        $this->addForeignKey(
            '{{%fk-loans_book_copies-book_copies_id}}',
            '{{%loans_book_copies}}',
            'book_copies_id',
            '{{%book_copies}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%loans}}`
        $this->dropForeignKey(
            '{{%fk-loans_book_copies-loans_id}}',
            '{{%loans_book_copies}}'
        );

        // drops index for column `loans_id`
        $this->dropIndex(
            '{{%idx-loans_book_copies-loans_id}}',
            '{{%loans_book_copies}}'
        );

        // drops foreign key for table `{{%book_copies}}`
        $this->dropForeignKey(
            '{{%fk-loans_book_copies-book_copies_id}}',
            '{{%loans_book_copies}}'
        );

        // drops index for column `book_copies_id`
        $this->dropIndex(
            '{{%idx-loans_book_copies-book_copies_id}}',
            '{{%loans_book_copies}}'
        );

        $this->dropTable('{{%loans_book_copies}}');
    }
}
