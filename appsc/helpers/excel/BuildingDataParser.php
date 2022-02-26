<?php

namespace appsc\helpers\excel;

use appsc\models\{Unit, Damage};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Yii;

/**
 * 从 worksheet 中解析种族单位数据
 */
class BuildingDataParser extends UnitDataParser
{    
    public function extract()
    {
        $sheet = $this->getWorkSheetAtIndex(1);
        return $this->extractBuildings($sheet);
    }

    public function extractBuildings(Worksheet $sheet){
        $iterator = $sheet->getRowIterator();
        $count = 0;
        $line = 0;
        foreach ($iterator as $row) {
            $line ++;
            $items = $this->getRowArray($row, $sheet);
            if(! $this->_parseLine($items)){
                continue;
            }

            $count ++;
        }

        return $count;
    }

    /**
     * 解析一行数据
     *
     * @param array $lineItems
     * @return boolean 成功时返回 true，解析会继续进行下去；失败时返回 false，解析停止
     */
    private function _parseLine(array $lineItems) {
        $race = $lineItems['A'];
        if (! in_array($race, ['P', 'T', 'Z', ''])) {
            // 跳过非定义行
            return false;
        }

        $race =  $race ?? $this->_race;

        if (empty($race)) {
            return false;
        }
        $this->_race = $race;

        $name = $lineItems['B'];
        if (empty($name)) {
            return false;
        }

        $unit = Unit::findOne(['name' => $name]);
        if (empty($unit)) {
            $unit = new Unit();
            $unit->name = $name;
            $unit->category = Unit::CATEGORY_BUILDING;
        }

        $this->_unit = $unit;

        $unit->race = $race;
        $unit->mineCost = $lineItems['C'];
        $unit->gasCost = $lineItems['D'];
        $unit->timeCost = $lineItems['E'];
        
        $unit->hp = $lineItems['F'];
        $unit->shield = $lineItems['G'];
        $unit->armor = $lineItems['H'];
        $unit->energy = $lineItems['I'];        

        $this->parseSight($lineItems['O']);
        $this->parseCastRange($lineItems['P']);
        // TODO: 探测距离，unit 中的 observer、overload 也需要
        $this->parseDetectRange($lineItems['Q']);        

        // FIXME: sunkey colony 是从 Crreep Colony 变来的，记得添加

        if (! $unit->save()) {
            $errors = $unit->getErrors();
            $msg = print_r($errors, true);
            throw new \Exception("保存 building 失败: {$msg}", 0);
        }

        // 解析伤害要放到最后进行，因为需要填充 Damage.unitId
        $this->parseDamageValue($lineItems['J']);
        $this->parseDamageEffects($lineItems['K']);
        $this->parseDamageRange($lineItems['L']);
        $this->parseDamageCooldown($lineItems['M']);
        $this->parseDamageDps($lineItems['N']);

        $this->saveGD();
        $this->saveAD();

        return true;
    }
}


?>