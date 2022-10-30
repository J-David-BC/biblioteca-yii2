<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%loans}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%users}}`
 */
class m221029_212906_create_loans_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%loans}}', [
            'id' => $this->primaryKey(),
            'days' => $this->integer(11)->notNull()->defaultValue(0),
            'loan_date' => $this->date()->notNull(),
            'return_date' => $this->date(),
            'status' => $this->string()->notNull()->defaultValue('En curso'),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp(),
            'users_id' => $this->integer(11)->notNull(),
        ]);

        // creates index for column `users_id`
        $this->createIndex(
            '{{%idx-loans-users_id}}',
            '{{%loans}}',
            'users_id'
        );

        // add foreign key for table `{{%users}}`
        $this->addForeignKey(
            '{{%fk-loans-users_id}}',
            '{{%loans}}',
            'users_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%users}}`
        $this->dropForeignKey(
            '{{%fk-loans-users_id}}',
            '{{%loans}}'
        );

        // drops index for column `users_id`
        $this->dropIndex(
            '{{%idx-loans-users_id}}',
            '{{%loans}}'
        );

        $this->dropTable('{{%loans}}');
    }
}
