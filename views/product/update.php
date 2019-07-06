<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = Yii::t('app', 'Product: {name}', [
    'name' => $model->naam,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Producten'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->naam];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="product-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
