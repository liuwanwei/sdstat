<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rune}}`.
 */
class m210322_075524_create_rune_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%rune}}', [
            'id' => $this->primaryKey(),
            'index' => $this->integer(),
            'name' => $this->string(16),
            'cnName' => $this->string(16),            
            'level' => $this->integer(),
            'dropRate' => $this->string(16),
            'boss' => $this->string(16),
            'difficulty' => $this->string(16),
            'img' => $this->text(),
            'formula' => $this->text()->comment('合成公式'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%rune}}');
    }
}
