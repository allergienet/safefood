<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Patient */

$this->title = Yii::t('app', 'Patiënt toevoegen');
$this->params['breadcrumbs'][] = ['label' => Yii::t('patient', 'Patiënten'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="patient-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
