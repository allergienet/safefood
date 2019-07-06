<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dietist */

$this->title = Yii::t('app', 'Create Dietist');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Dietists'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dietist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
