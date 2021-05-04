<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use appsc\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            // [
            //     'label' => TApp('Rune Words'),
            //     'items' => [                    
            //         ['label' => TApp('Runes'), 'url' => ['/rune/index']],
            //         ['label' => TApp('Rune Owneds'), 'url' => ['rune-owned/index']],
            //         ['label' => TApp('Rune Words'), 'url' => ['/rune-word/index']],
            //     ]
            // ],
            [
                'label' => TApp('Rank'),
                'items' => [
                    ['label' => TApp('Speed'), 'url' => ['/rank/speed']],
                ]
            ],
            ['label' => TApp('Import'), 'url' => ['/unitt/import']],
            ['label' => TApp('Units'), 'url' => ['/unitt/index']],
            // ['label' => TApp('Damage'), 'url' => ['/damage/index']],            
            // ['label' => TApp('Rivals'), 'url' => ['/rival/index']],
            ['label' => TApp('Buildings'), 'url' => ['/building/index']],
            ['label' => TApp('Backups'), 'url' => ['/db-manager']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
