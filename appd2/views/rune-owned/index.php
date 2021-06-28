<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RuneOwnedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Rune Owneds');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="rune-owned-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <p>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </p>
    
    <div class='row'>        
        <?= $this->render('_index', ['model' => $searchModel, 'dataProvider' => $dataProvider, 'editable' => true]) ?>            
    </div>
    

</div>
