<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Productgroep */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="productgroep-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <?= $form->field($model, 'naam')->textInput([
        'maxlength' => true,
        'onkeyup'=>'checkfordoubleproduktgroepen(this)'
    ]) ?>
    
    <div id="resultaten">
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
