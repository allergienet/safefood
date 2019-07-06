<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
if(!empty($key)){
    $action=['site/signup','key'=>$key];
}
else{
    $action=['site/signup'];
}
?>

<div class="signup-wrapper">
    <div class="signup-content">
        <h4>Registreren</h4>
        <?php $form = ActiveForm::begin([
            'action'=>$action,
            'method'=>'POST',
            'id' => 'signup-form',
            'fieldConfig' => [
                'template' => "<div class=\"row\">{label}\n<div class=\"col-sm-12\">{input}</div>\n<div class=\"col-sm-12\">{error}</div></div>",
                'labelOptions' => ['class' => 'col-sm-12 control-label text-left'],
            ],
        ]); ?>

        <?= $form->field($model, 'username')->textInput() ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'password_repeat')->passwordInput() ?>
        <?php
        if(!empty($key)){
            $model->type=1;
            echo $form->field($model, 'type')->hiddenInput()->label(false);
        }
        else{
            echo $form->field($model, 'type')->dropDownList($model->getusertypes());
        }
        ?>

        

        <div class="form-group row">
            <div class="col-sm-12">
                <?= Html::submitButton('Registereren', ['class' => 'full-width btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>
       

        <?php ActiveForm::end(); ?>
    </div>
</div>