<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

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
    <script src="https://kit.fontawesome.com/2dedcd2999.js"></script>
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
        'encodeLabels' => false,
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => Yii::t('app','Over ons'), 'url' => ['/site/about']],
            Yii::$app->user->isGuest ? (
                [
                    'label' => '<i class="fa fa-user"></i> Inloggen',
                    'items' => [
                        $this->render('@app/views/site/login',[
                            'model'=>new app\models\LoginForm()
                        ])
                    ],
                ]
                    
            ) : (
                [
                    
                    'label' => '<i class="fa fa-user"></i> '.Yii::$app->user->identity->username,
                    'items' => [
                        $this->render('@app/views/site/accountmenu',[
                            'userrole'=>Yii::$app->user->identity->role
                        ])
                    ],
                ]
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?php
        if(in_array(Yii::$app->controller->id,["product","patient","dietist"])){
        ?>
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?php 
        
        } 
        ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
