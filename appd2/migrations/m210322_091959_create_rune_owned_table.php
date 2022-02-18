<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rune_owned}}`.
 */
class m210322_091959_create_rune_owned_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%rune_owned}}', [
            'id' => $this->primaryKey(),
            'userId' => $this->integer()->comment('user.id'),
            'runeId' => $this->integer()->comment('rune.id'),
            'count' => $this->integer()->defaultValue(0)->comment('拥有个数'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%rune_owned}}');
    }
}
