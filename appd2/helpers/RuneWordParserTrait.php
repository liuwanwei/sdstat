<?php

namespace appd2\helpers;

use Yii;
use appd2\models\RuneWord;
use Exception;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

trait RuneWordParserTrait{
    public function extractRWs(Worksheet $sheet){
        // 从第二行开始
        $iterator = $sheet->getRowIterator(2);
        $count = 0;
        $line = 0;
        foreach ($iterator as $row) {
            $line ++;
            $items = $this->getRowArray($row, $sheet);
            if(! $this->_parseRuneWordLine($items)){
                continue;
            }

            $count ++;
        }

        return $count;
    }

    private function _parseRuneWordLine(array $lineItems){
        $name = $lineItems['B'];
        if (empty($name)) {
            return false;
        }

        $model = RuneWord::findOne(['name' => $name]);
        if (! $model) {
            $model = new RuneWord();
            $model->name = $name;
        }

        $model->cnName = $lineItems['C'];
        $model->runes = $lineItems['D'];
        $model->slots = count(explode('/', $model->runes));
        $model->maxRune = $this->_getMaxRuneIndex($model->runes);    
        $model->equipments = $lineItems['F'];
        $model->category = $lineItems['G']??$model->equipments;
        $model->level = intval($lineItems['H']);
        $model->version = $lineItems['I'];
        $model->desc = $lineItems['J'];

        if (! $model->save()) {
            Yii::error($model->getErrors());
            throw new Exception('导入符文之语数据失败：import rune word，详情查看日志');
        }

        return true;
    }

    private function _getMaxRuneIndex(string $runes){
        $parts = explode('/', $runes);
        sort($parts, SORT_NUMERIC);
        $max = $parts[count($parts) - 1];
        return intval($max);
    }
}

?>