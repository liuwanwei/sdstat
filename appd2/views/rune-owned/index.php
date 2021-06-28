<?php

use common\assets\EuiAsset;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RuneOwnedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Rune Owneds');
$this->params['breadcrumbs'][] = $this->title;

EuiAsset::register($this);
?>
<div class="rune-owned-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <p>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </p>
    
    <div class='row'>        
        <?= $this->render('_kartik_editable_index', ['model' => $searchModel, 'dataProvider' => $dataProvider, 'editable' => true]) ?>            
    </div>
    

</div>
