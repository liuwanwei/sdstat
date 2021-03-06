<?php
namespace appd2\helpers;

use yii\base\Exception;
use appsc\helpers\excel\ExcelParser;

class RuneParser extends ExcelParser{

    use RuneWordParserTrait;
    use RuneParserTrait;

    // 数据文件名字，确保放置在当前文件相同目录
    const RUNEWORDS_EXCEL = 'd2-runewords.xlsx';

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

    public function extractRuneWords(){
        $inputFileName = $this->_checkFile(self::RUNEWORDS_EXCEL);
        $spreadsheet = $this->getSpreadSheet($inputFileName);
        $spreadsheet->setActiveSheetIndex(0);
        $worksheet = $spreadsheet->getActiveSheet();
        return $this->extractRWs($worksheet);
    }

    public function extractRunes(){
        $inputFileName = $this->_checkFile(self::RUNEWORDS_EXCEL);
        $spreadsheet = $this->getSpreadSheet($inputFileName);
        $spreadsheet->setActiveSheetIndex(1);
        $worksheet = $spreadsheet->getActiveSheet();
        return $this->extractRs($worksheet);
    }
}

?>