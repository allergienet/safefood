<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Patient */



if(Yii::$app->user->identity->role== app\models\User::ROLE_VOEDINGSDESKUNDIGE){
    $this->title = Yii::t('app', 'Patient: {name}', [
        'name' => $model->voornaam.' '.$model->naam,
    ]);
    $this->params['breadcrumbs'][] = ['label' => Yii::t('patient', 'Patiënten'), 'url' => ['index']];
    $this->params['breadcrumbs'][] = ['label' => $model->voornaam.' '.$model->naam];
    $this->params['breadcrumbs'][] = Yii::t('app', 'Update');
}
else{
    $this->title = Yii::t('app', 'Mijn profiel');
    $this->params['breadcrumbs'][] = Yii::t('app', 'Mijn Profiel');
}


?>
<div class="patient-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
