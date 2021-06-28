<?php
namespace appsc\helpers\excel;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Row;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExcelParser{
    private $_errors = [];

    protected function addError($errMsg, $line = '.'){
        $this->_errors[] = "[$line] " . $errMsg;
    }

    protected function getErrors(){
        return $this->_errors;
    }

    /**
     * 获取某一列的下一列名字
     *
     * @param string $column 列名字
     * @return string 
     * 
     * 目前算法只支持最大列名到 DY（返回 DZ）最多支持 130 个字段，再大时情况不可预测
     */
    public static function getNextColumn($column)
    {
        if ($column == 'Z') {
            return 'AA';
        } else if ($column == 'AZ') {
            return 'BA';
        } else if ($column == 'BZ') {
            return 'CA';
        } else if ($column == 'CZ') {
            return 'DA';
        } else {
            if (!isset($column[1])) {
                // 一位
                $value = ord($column) + 1;
                return chr($value);
            } else {
                // 两位
                $value = ord($column[1]) + 1;
                $nextColumn = $column[0] . chr($value);
                return $nextColumn;
            }
        }
    }

    protected function getRowArray(Row $row){
        $cellIterator = $row->getCellIterator();
        // 设为 true 时，会跳过中间的空列
        $cellIterator->setIterateOnlyExistingCells(false);
    
        $items = [];
        foreach ($cellIterator as $cell) {
            $column = $cell->getColumn();
            $value = $cell->getCalculatedValue();
      
            $items[$column] = $value;
        }
    
        return $items;
    }

    public function getSpreadSheet(string $inputFileName){
        // ini_set('memory_limit', '1024M');

        $inputFileType = IOFactory::identify($inputFileName);
        $reader = IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($inputFileName);

        return $spreadsheet;
    }

    /**
     * 打开 Excel 文件，返回默认可操作的表单
     *
     * @param string $inputFileName
     * @return Worksheet
     */
    public function getWorkSheet(string $inputFileName){
        $spreadsheet = $this->getSpreadSheet($inputFileName);        
        return $spreadsheet->getActiveSheet();
    }
}

?>