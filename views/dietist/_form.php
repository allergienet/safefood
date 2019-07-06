<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Dietist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dietist-form">
    
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>
    

    <?php
    if(!empty($model->logo)){
        ?>
        <div class="form-group">
            <?=Html::img("@web/".$model->logo,['id'=>'dietistlogo']);?><br/>
            <?= Html::a('<i class="fa fa-remove"></i>',['dietist/delimage','id'=>$model->id],[
                'class'=>'btn btn-danger',
                'style'=>'width:200px'
            ])?>
        </div>
    <?php
    }
    else{
        echo $form->field($model, 'file')->fileInput();
    }
    ?>

    <?= $form->field($model, 'naam')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'voornaam')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    
    <?php
    if(empty($model->tel)){
        $model->tel="32";
    }
    ?>
    <?= $form->field($model, 'tel')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '+99 99 99 99 99',
    ])  ?>

    <?php
    if(empty($model->gsm)){
        $model->gsm="32";
    }
    ?>
    <?= $form->field($model, 'gsm')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '+99 999 99 99 99',
    ])  ?>

    <?= $form->field($model, 'adres')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
