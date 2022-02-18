<?php
namespace appsc\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%damage}}`.
 */
class m210303_081801_create_damage_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%damage}}', [
            'id' => $this->primaryKey(),
            'unitId' => $this->integer()->notNull(),
            'scope' => $this->integer()->notNull()->comment('作用范围，0对地 1对空'),
            'base' => $this->integer()->comment('基础值'),
            'stride' => $this->integer()->comment('升级增加值'),
            'times' => $this->integer()->defaultValue(1)->comment('打击次数'),

            'explosive' => $this->boolean()->defaultValue(false)->comment('爆炸伤害'),
            'concussive' => $this->boolean()->defaultValue(false)->comment('震荡伤害'),
            'splash' => $this->boolean()->defaultValue(false)->comment('溅射伤害'),

            'range' => $this->integer()->comment('攻击距离'),
            'rangeBonus' => $this->integer()->comment('范围升级后值'),
            'cooldown' => $this->float()->comment('冷却时间'),
            'cooldownBonus' => $this->float()->comment('冷却时间升级后值'),
            'dps' => $this->float()->comment('每秒造成伤害'),
            'dpsBonus' => $this->float()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%damage}}');
    }
}
