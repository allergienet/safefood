<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Productgroep */

$this->title = Yii::t('app', 'Productgroep toevoegen');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Productgroeps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="productgroep-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
