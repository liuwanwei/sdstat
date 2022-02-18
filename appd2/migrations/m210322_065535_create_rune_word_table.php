<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rune_word}}`.
 */
class m210322_065535_create_rune_word_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%rune_word}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64),
            'cnName' => $this->string(64)->comment('中文名'),
            'equipments' => $this->string(64)->comment('所需'),
            'category' => $this->string(16)->comment('大类'),
            'runes' => $this->string(32)->comment('符文序号列表'),
            'slots' => $this->integer()->comment('凹槽个数'),
            'maxRune' => $this->integer()->comment('最大符文序号'),
            'level' => $this->integer()->comment('角色需求等级'),
            'version' => $this->string(16)->comment('游戏版本'),
            'desc' => $this->text()->comment('描述信息，自己维护'),
            'html' => $this->text()->comment('抓取来的面板信息'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%rune_word}}');
    }
}
