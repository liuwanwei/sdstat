<?php

namespace appsc\helpers\excel;

use appsc\models\{Building, Damage};
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Yii;

/**
 * 从 worksheet 中解析种族单位数据
 */
class BuildingDataParser extends DataParser
{    
    // 临时存储当前区间的种族名字
    private $_race = null;

    // 临时存储当前正在解析的 Unit 实例
    private $_building = null;

    public function extract()
    {
        $sheet = $this->getWorkSheetAtIndex(3);
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
        $unit = Building::findOne(['name' => $name]);
        if (empty($unit)) {
            $unit = new Building();
            $unit->name = $name;
        }

        $this->_building = $unit;

        $unit->race = $race;
        $unit->mineCost = $lineItems['C'];
        $unit->gasCost = $lineItems['D'];
        $unit->timeCost = $lineItems['E'];
        
        $unit->hp = $lineItems['F'];
        $unit->shield = $lineItems['G'];
        $unit->armor = $lineItems['H'];
        $unit->energy = $lineItems['I'];

        if (! $unit->save()) {
            \Yii::error($unit->getErrors());
            throw new \Exception("保存 unit 失败", 1);
        }

        // $this->_parseDamageValue($lineItems);
        // $this->_parseDamageEffects($lineItems);
        // $this->_parseDamageRange($lineItems);
        // $this->_parseDamageCooldown($lineItems);
        // $this->_parseDamageDps($lineItems);

        return true;
    }
}


?>