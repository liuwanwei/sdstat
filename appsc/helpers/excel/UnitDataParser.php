<?php

namespace appsc\helpers\excel;

use appsc\helpers\DamageHelper;
use appsc\models\Damage;
use appsc\models\Unit;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Yii;

/**
 * 从 worksheet 中解析种族单位数据
 */
class UnitDataParser extends DataParser
{    
    /** @var string 临时存储当前区间的种族名字 */
    protected $_race = null;

    /** @var \appsc\models\Unit 临时存储当前正在解析的 Unit 实例 */
    protected $_unit = null;

    /** @var int 需要针对某一行数据进行读写时才需要设置 */
    public $debugLineNumber = null;
    /** @var string 针对一行进行读取时，由于 $this->_race 依赖上下文，无法在单行测试时读取到，所以需要设置当前种族 */
    public $debugLineRace = null;

    public function extract()
    {
        $sheet = $this->getWorkSheetAtIndex(0);
        return $this->extractUnit($sheet);
    }

    public function extractUnit(Worksheet $sheet){
        $iterator = $sheet->getRowIterator();
        $count = 0;
        $line = 0;
        foreach ($iterator as $row) {
            $line ++;

            $this->clearDamageCache();

            // 如果 DEBUG 时设置只解析一行，解析完成后跳出循环
            if ($this->debugLineNumber != null) {
                $this->_race = $this->debugLineRace;
                if ($line < $this->debugLineNumber) {
                    continue;
                }else if ($line > $this->debugLineNumber) {
                    break;
                }
            }

            $items = $this->getRowArray($row, $sheet);
            if(! $this->_parseLine($items)){
                continue;
            }

            $count ++;
        }

        return $count;
    }

    private function _parseLine(array $lineItems) {
        $race = $lineItems['A'];
        if (! in_array($race, ['P', 'T', 'Z', ''])) {
            // 跳过非定义行
            return false;
        }

        $race =  $race ?? $this->_race;

        if (empty($race)) {
            throw new \Exception("无法找到种族，停止解析", 1);
        }
        $this->_race = $race;

        $name = $lineItems['B'];
        $unit = Unit::findOne(['name' => $name]);
        if (empty($unit)) {
            $unit = new Unit();
            $unit->name = $name;
            $unit->category = Unit::CATEGORY_UNIT;
        }

        $this->_unit = $unit;

        $unit->race = $race;
        $unit->type = $this->attributeValueForLabel($lineItems['C'], Unit::TYPES);
        $unit->force = $this->attributeValueForLabel($lineItems['D'], Unit::FORCES);
        $unit->mineCost = $lineItems['E'];
        $unit->gasCost = $lineItems['F'];
        $unit->timeCost = $lineItems['G'];
        $unit->unitCost = $lineItems['H'];
        $unit->hp = $lineItems['I'];
        $unit->shield = $lineItems['J'];
        $unit->armor = $lineItems['K'];
        $unit->energy = $lineItems['Q'];        

        if (! $unit->save()) {
            \Yii::error($unit->getErrors());
            throw new \Exception("保存 unit 失败", 1);
        }

        $this->parseSight($lineItems['R']);
        $this->parseSpeed($lineItems['S']);

        $this->parseDamageValue($lineItems['L']);
        $this->parseDamageEffects($lineItems['M']);
        $this->parseDamageRange($lineItems['N']);
        $this->parseDamageCooldown($lineItems['O']);
        $this->parseDamageDps($lineItems['P']);

        $this->saveGD();
        $this->saveAD();

        return true;
    }

    /**
     * 解析 Damage 字段
     * 
     * 伤害信息存储在 damage 表中，包括对空和对地两种，每个单位最多有两条相关记录，最少零条（魔法单位）。
     * 
     * Damage 字段的格式为 (base + stride) * times | (base + stride) * times。
     * · “对地伤害 ｜ 对空伤害”
     * · base 代表基础伤害
     * · stride 代表每次升级伤害值增加量
     * · stride 不存在时可以忽略不写
     * · 如果无法对空或对地，相应部分填写字符 0，如暗黑无法对空，伤害就是 “40+3 | 0”     
     * · times == 1 时可以忽略不写
     * Damage 字段必须严格按照以上方式书写。
     *
     * @param string $content
     * @return void
     */
    protected function parseDamageValue(?string $content){
        if($content == null) return;

        $gd = $ad = null;

        // 对地对空数值是否一样
        $identical = strchr($content, '|') ? false : true;
        if ($identical) {
            $gd = $this->_createDamageRecord($content, Damage::SCOPE_GROUND);            
            $ad = $this->_createDamageRecord($content, Damage::SCOPE_AIR);
            
        }else{
            $parts = explode('|', $content);
            $gd = $this->_createDamageRecord($parts[0], Damage::SCOPE_GROUND);
            $ad = $this->_createDamageRecord($parts[1], Damage::SCOPE_AIR);
        }

        $this->setDamage($gd, Damage::SCOPE_GROUND);
        $this->setDamage($ad, Damage::SCOPE_AIR);
    }

    /**
     * 解析独立的对地或对空攻击力定义
     *
     * @param string|null $content
     * @param integer $scope
     * @return Damage|null
     */
    private function _createDamageRecord(?string $content, int $scope){
        if ($content == '0') {
            // 如果值为 0，代表没有此种类型的攻击
            return null;
        }

        // 是否多次打击
        $times = strchr($content, '*') ? 2 : 1;
        if ($times > 1) {
            // 去括号
            $content = str_replace(['(', ')'], '', $content);
        }

        // 攻击和升级步进值
        $stride = strchr($content, '+') ? true : false;
        if ($stride) {
            list($base, $stride) = explode('+', $content);
        }else{
            $base = $content;
            $stride = 0;
        }

        $unit = $this->_unit;
        $damage = Damage::findOne(['scope' => $scope, 'unitId' => $unit->id]);
        if ($damage == null) {
            $damage = new Damage();
            $damage->unitId = $unit->id;
            $damage->scope = $scope;
        }

        $damage->base = intval($base);
        $damage->stride = intval($stride);
        $damage->times = intval($times);

        if(! $damage->save()){
            Yii::error($damage->getErrors());
            throw new \Exception("解析伤害值失败，详情参考日志", 1);            
        }

        return $damage;
    }    

    // 解析 Exp/Con/Spl 字段
    protected function parseDamageEffects(?string $content){
        if ($content == null) return;

        $identical = strchr($content, '|') ? false : true;
        if ($identical) {
            $this->_updateDamageEffects($content, Damage::SCOPE_GROUND);
            $this->_updateDamageEffects($content, Damage::SCOPE_AIR);
        }else{
            $parts = explode('|', $content);
            $this->_updateDamageEffects($parts[0], Damage::SCOPE_GROUND);
            $this->_updateDamageEffects($parts[1], Damage::SCOPE_AIR);
        }
    }

    private function _updateDamageEffects(?string $content, int $scope){
        if ($content == '0' || $content == null) {
            return;
        }
        
        $damage = $this->getDamage($scope);
        if ($damage == null) {
            throw new \Exception("填充伤害效果失败，未找到所属单位：unit.id {$this->_unit->id}, scope: {$scope}", 1);
        }

        list($exp, $con, $spl) = explode('/', $content);
        $damage->explosive = $this->parseYesNo($exp);
        $damage->concussive = $this->parseYesNo($con);
        $damage->splash = $this->parseYesNo($spl);
        if(! $damage->save()){
            \Yii::error($damage->getErrors());
            throw new \Exception("保存伤害效果失败，请参考日志", 1);            
        }

        $this->_updateUnitDamageEffect($damage);
    }

    // 更新当前 unit 的伤害效果标记
    private function _updateUnitDamageEffect(Damage $damage){        
        $name = $this->_unit->name;
        $effect = Unit::DAMAGE_EFFECT_NORMAL;
        if ($damage->explosive == 1) {
            $effect = Unit::DAMAGE_EFFECT_EXPLOSIVE;
        }else if ($damage->concussive == 1){
            $effect = Unit::DAMAGE_EFFECT_CONCUSSIVE;
        }else if ($damage->splash == 1) {
            $effect = Unit::DAMAGE_EFFECT_SPLASH;
        }
        
        if ($damage->scope == Damage::SCOPE_GROUND) {
            $this->_unit->groundDamageEffect = $effect;
            $this->_unit->save();
        }else{
            $this->_unit->airDamageEffect = $effect;
            $this->_unit->save();
        }
    }

    protected function parseDamageRange(?string $content){
        if ($content == null) return;

        // 对地对空数值是否一样
        $identical = strchr($content, '|') ? false : true;
        if ($identical) {
            $this->_createDamageRange($content, Damage::SCOPE_GROUND);
            $this->_createDamageRange($content, Damage::SCOPE_AIR);
        }else{
            $parts = explode('|', $content);
            $this->_createDamageRange($parts[0], Damage::SCOPE_GROUND);
            $this->_createDamageRange($parts[1], Damage::SCOPE_AIR);
        }
    }

    private function _createDamageRange(?string $content, int $scope){
        if ($content == null) {
            return;
        }

        list($base, $bonus) = $this->_parseBonusContent($content);
        $damage = $this->getDamage($scope);
        if ($damage == null) {
            return;
        }

        $damage->range = $this->realValue($base);
        $damage->rangeBonus = $this->realValue($bonus);
        if(! $damage->save()){
            \Yii::error($damage->getErrors());
            throw new \Exception("保存攻击距离失败", 1);
        }
    }

    protected function parseDamageCooldown(?string $content){
        if ($content == null) return;

        $identical = strchr($content, '|') ? false : true;
        if ($identical) {
            // 没有空地分隔符，可能只有其一，或者都有，取决于之前是否创建过对应的空地伤害记录
            list($base, $bonus) = $this->_parseBonusContent($content);
            DamageHelper::updateCooldown($this->getGD(), $base, $bonus);
            DamageHelper::updateCooldown($this->getAD(), $base, $bonus);
            
        }else{
            // “空-地” 分开，所以之前必须创建过两条空地伤害记录
            $parts = explode('|', $content);
            list($base, $bonus) = $this->_parseBonusContent($parts[0]);
            DamageHelper::updateCooldown($this->getGD(), $base, $bonus);
            list($base, $bonus) = $this->_parseBonusContent($parts[1]);
            DamageHelper::updateCooldown($this->getAD(), $base, $bonus);
        }
    }

    

    protected function parseDamageDps(?string $content) {
        if ($content == null) return;

        $identical = strchr($content, '|') ? false : true;
        if ($identical) {
            // 没有空地分隔符，可能只有其一，或者都有，取决于之前是否创建过对应的空地伤害记录
            list($base, $bonus) = $this->_parseBonusContent($content);
            DamageHelper::updateDps($this->getGD(), $base, $bonus);
            DamageHelper::updateDps($this->getAD(), $base, $bonus);
        }else{
            // 空地分开，所以之前必须创建过两条空地伤害记录
            $parts = explode('|', $content);
            list($base, $bonus) = $this->_parseBonusContent($parts[0]);
            DamageHelper::updateDps($this->getGD(), $base, $bonus);
            list($base, $bonus) = $this->_parseBonusContent($parts[1]);
            DamageHelper::updateDps($this->getAD(), $base, $bonus);
        }
    }    

    protected function parseSight(?string $content){
        if ($content == null) return;

        list($base, $bonus) = $this->_parseBonusContent($content);
        $unit = $this->_unit;
        $unit->sight = $this->realValue($base);
        $unit->sightBonus = $this->realValue($bonus);
        if (! $unit->save()) {
            \Yii::error($unit->getErrors());
            throw new \Exception("保存视野失败", 1);
        }
    }    

    protected function parseSpeed(?string $content){
        if ($content == null) return;

        list($base, $bonus) = $this->_parseBonusContent($content);
        $unit = $this->_unit;
        $unit->speed = $this->realValue($base);
        $unit->speedBonus = $this->realValue($bonus);
        if (! $unit->save()) {
            \Yii::error($unit->getErrors());
            throw new \Exception("保存速度失败", 1);
        }
    }

    protected function parseCastRange(?string $content){
        // TODO: 
    }

    protected function parseDetectRange(?string $content){
        // TODO: 
    }

    /**
     * 解析增益效果值
     * 
     * 增益效果值有两种：
     * 1. m+n，m 代表初始值，n 代表增加值
     * 2. m-n，m 代表初始值，n 代表增加到的值 
     *
     * @param string $content
     * @return [m, n]，m 代表基础值，n 总是升级后的值
     */
    private function _parseBonusContent($content){
        $isPlus = strchr($content, '+') ? true : false;
        if ($isPlus) {
            $parts = explode('+', $content);
            $m = $this->realValue($parts[0]);
            $n = $this->realValue($parts[1]);
            return [$m, $m + $n];
        }else{
            $isMinor = strchr($content, '-') ? true : false;
            if ($isMinor) {
                $parts = explode('-', $content);
                $m = $this->realValue($parts[0]);
                $n = $this->realValue($parts[1]);
                return [$m, $n];
            }else{
                $m = $this->realValue($content);
                return [$m, $m];
            }
        }
    }        

    /**
     * 根据选项的内容（label），找到对应的值(key)
     *
     * @param string $label
     * @param array $options  [key => label, key => label, ...]
     * @return mixed
     */
    public function attributeValueForLabel($label, $options){
        foreach ($options as $key => $value) {
            if ($label == $value) {
                return $key;
            }
        }

        return null;
    }
}


?>