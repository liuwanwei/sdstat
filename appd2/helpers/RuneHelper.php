<?php
namespace appd2\helpers;

use Yii;
use appd2\models\{Rune, RuneOwned, RuneOwnedSearch};
use Exception;

class RuneHelper {

    /**
     * 根据符文之语的名字，返回维基介绍页面的 URL
     *
     * @param string $name
     * @return string
     */
    public static function detailsUrlForRuneWord(string $name){
        $url = "https://wiki.d.163.com/index.php?title={$name}_(Diablo_II)";
        return $url;
    }

    /**
     * 为用户创建所有符文数据
     *
     * @param integer $userId
     * @return void
     */
    public static function createDefaults(int $userId){
        $runes = Rune::find()->orderBy(['index' => SORT_ASC]);
        foreach ($runes->each() as $rune) {
            $model = RuneOwned::findOne(['runeId' => $rune->id]);
            if ($model == null) {
                $model = new RuneOwned();
                $model->runeId = $rune->id;
            }

            $model->userId = $userId;
            if (! $model->save()){
                Yii::error($model->getErrors());
                throw new Exception("为用户 {$userId} 创建符文拥有记录失败，详情参考日志");
            }
        }
    }

    /**
     * 根据拥有的符文，在符文之语中搜索满足合成条件的
     *
     * @param array $runeWords  搜索目标集合符文之语
     * @param bool $onlyMatched 是否只返回满足条件的符文之语
     * 
     * @return array 能满足条件的符文之语
     */
    public static function searchByOwnedRunes(array $runeWords, bool $onlyMatched){        

        // 首先获取手中符文和数量映射表
        $ownedSearch = new RuneOwnedSearch();
        $dataProvider = $ownedSearch->search(['moreThanOne' => true]);
        $ownedRuneIndexes = [];
        foreach ($dataProvider->query->each() as $owned) {
            $index = $owned->rune->index;
            $count = $owned->count;

            $ownedRuneIndexes[$index] = $count;
        }

        $count = 0;
        $words = [];
        $matches = [];
        foreach ($runeWords as $runeWord) {
            // 获取符文之语需求映射表
            $requirments = $runeWord->getRuneRequirement();
            $matched = true;
            $matchedMark = [];
            foreach ($requirments as $index => $needCount) {
                /**
                 * 当符文序号在拥有的符文的映射表中不存在时，设置 $ownedCount 为 0，
                 * 它就一定小于 $needCount，也就意味着没有匹配中。
                 */
                $ownedCount = $ownedRuneIndexes[$index] ?? 0;
                if ($ownedCount < $needCount) {
                    $matched = false;
                    $matchedMark[$index] = false;
                }else{
                    $matchedMark[$index] = true;
                }
            }

            if ($onlyMatched && ! $matched) {
                continue;
            }

            if ($matched) {
                $count ++;
            }
            
            $words[] = $runeWord;
            $matches[] = [
                'result' => $matched,
                'marks' => $matchedMark,
            ];
        }

        return [
            'runeWords' => $words,
            'matches' => $matches,
            'count' => $count,          // 总共匹配中个数
        ];
    }
}

?>