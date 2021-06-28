<?php

namespace appd2\helpers;

use Yii;
use appd2\models\Rune;
use Exception;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


trait RuneParserTrait{
    public function extractRs(Worksheet $sheet){
        // 从第二行开始
        $iterator = $sheet->getRowIterator(2);
        $count = 0;
        $line = 0;
        foreach ($iterator as $row) {
            $line ++;
            $items = $this->getRowArray($row, $sheet);
            if(! $this->_parseRuneLine($items)){
                continue;
            }

            $count ++;
        }

        return $count;
    }

    private function _parseRuneLine(array $lineItems){
        $name = $lineItems['B'];
        if (empty($name)) {
            return false;
        }

        $model = Rune::findOne(['name' => $name]);
        if (! $model) {
            $model = new Rune();
            $model->name = $name;
        }

        $model->index = intval($lineItems['A']);
        $model->cnName = $lineItems['C'];
        $model->level = intval($lineItems['D']);
        $model->dropRate = $lineItems['E'];
        $model->boss = $lineItems['F'];
        $model->difficulty = $lineItems['G'];
        $model->img = $lineItems['H'];

        if (! $model->save()) {
            Yii::error($model->getErrors());
            throw new Exception('导入符文数据失败：import rune word，详情查看日志');
        }

        return true;
    }
}

?>