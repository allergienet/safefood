<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>

<div class="signup-wrapper">
    <div class="signup-content">
        <h4>Registreren</h4>
        <?php $form = ActiveForm::begin([
            'action'=>['site/signup'],
            'method'=>'POST',
            'id' => 'signup-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-sm-12\">{input}</div>\n<div class=\"col-sm-12\">{error}</div>",
                'labelOptions' => ['class' => 'col-sm-12 control-label text-left'],
            ],
        ]); ?>

        <?= $form->field($model, 'username')->textInput() ?>

        <?= $form->field($model, 'password')->passwordInput() ?>

        <?= $form->field($model, 'password_repeat')->passwordInput() ?>
        
        <?= $form->field($model, 'type')->dropDownList($model->getusertypes()) ?>

        

        <div class="form-group">
            <div class="col-sm-12">
                <?= Html::submitButton('Registereren', ['class' => 'full-width btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>
       

        <?php ActiveForm::end(); ?>
    </div>
</div>