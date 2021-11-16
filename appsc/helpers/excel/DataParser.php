<?php
namespace appsc\helpers\excel;

use yii\base\Exception;

class DataParser extends ExcelParser{

    use UnitParseTrait;

    // 数据文件名字，确保放置在当前文件相同目录
    const SC_EXCEL = "ScStats.xlsx";

    /**
     * 检查星际争霸数据 Excel 文件是否存在
     *
     * @return string 存在时返回文件路径，否则抛出异常 
     */
    private function _checkFile($filename){
        $file = dirname(__FILE__) . '/' . $filename;
        if (! file_exists($file)) {
            throw new Exception("文件不存在：{$file}");
        }

        return $file;
    }

    public function extract(){
        $inputFileName = $this->_checkFile(self::SC_EXCEL);        

        // $worksheet = $this->getWorkSheet($inputFileName);
        $spreadsheet = $this->getSpreadSheet($inputFileName);

        $spreadsheet->setActiveSheetIndex(0);
        $worksheet = $spreadsheet->getActiveSheet();
        return $this->extractUnit($worksheet);
    }
}

?>