<?php


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>   
<div class="login-wrapper">
    <div class="login-content">
        <h2 style="margin-top:0px;">Welkom terug</h2>
        <?php $form = ActiveForm::begin([
            'action'=>['site/login'],
            'method'=>'POST',
            'id' => 'login-form',
            'layout' => 'inline',
            'fieldConfig' => [
                'template' => "\n{input}\n{error}",
                'labelOptions' => ['class' => 'control-label text-left'],
            ],
        ]); ?>

        <?= $form->field($model, 'username')->textInput(['placeholder'=>'E-mail']) ?>

        <?= $form->field($model, 'password')->passwordInput([
            'placeholder'=>'paswoord'
        ]) ?>
        


        <?= Html::submitButton('Aanmelden', ['class' => 'btn btn-success fullwidth', 'name' => 'login-button']) ?>
        <?= Html::a('Registreren',['site/signup'], ['class' => 'btn btn-primary fullwidth', 'name' => 'register-button']) ?>

        <div id="forgotpassword-wrapper">
            <?= Html::a('paswoord vergeten?',['site/forgotpassword'],['style'=>'font-size: 80%;']) ?>           
        </div>
        

        <?php ActiveForm::end(); ?>
    </div>
</div>