<?php
namespace appsc\helpers\excel;

use yii\base\Exception;
use appsc\models\Damage;

class DataParser extends ExcelParser{

    /** @var string 数据文件名字，确保放置在当前文件相同目录 */
    public $excelName = "ScStats.xlsx";    

    /**
     * 临时存储为创建的对地对空伤害实例
     */

    /** @var \appsc\models\Damage */
    private $_gd = null;
    /** @var \appsc\models\Damage */
    private $_ad = null;

    /**
     * 解析入口，派生类需要实现
     * 
     * @return int 解析出来的数据数量
     */
    public function extract(){
        return 0;
    }

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

    /**
     * 从 excel 中加载一页
     *
     * @param integer $index
     * @return \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet
     */
    protected function getWorkSheetAtIndex(int $index = 0)
    {
        $inputFileName = $this->_checkFile($this->excelName);

        // $worksheet = $this->getWorkSheet($inputFileName);
        $spreadsheet = $this->getSpreadSheet($inputFileName);

        $spreadsheet->setActiveSheetIndex($index);
        $worksheet = $spreadsheet->getActiveSheet();
        return $worksheet;
    }

    /**
     * 判断一个字符串是整形还是浮点型，并返回对应类型的值
     *
     * @param string $value
     * @return mixed
     */
    protected function realValue(string $value){
        if (strchr($value, '.')) {
            return floatval($value);
        }else{
            return intval($value);
        }
    }

    protected function getGD(){
        return $this->_gd;
    }

    protected function saveGD(){
        if ($this->_gd) {
            $this->_gd->save();
        }
    }

    protected function getAD(){
        return $this->_ad;
    }

    protected function saveAD(){
        if ($this->_ad){
            $this->_ad->save();
        }
    }

    protected function getDamage(int $scope){
        if ($scope == Damage::SCOPE_GROUND) {
            return $this->_gd;
        }
        else if ($scope == Damage::SCOPE_AIR) {
            return $this->_ad;
        }

        return null;
    }

    protected function setDamage(?Damage $damage, int $scope) {
        if ($damage == null) return;

        if ($scope == Damage::SCOPE_GROUND) {
            $this->_gd = $damage;
        }
        else if ($scope == Damage::SCOPE_AIR) {
            $this->_ad = $damage;
        }
    }

    protected function parseYesNo(string $value){
        return $value == 'Yes' ? 1 : 0;
    }    
}

?>