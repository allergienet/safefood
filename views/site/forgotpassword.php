<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\ContactForm;
?>
<div class="forgotpassword-wrapper">
    <div class="forgotpassword-content">
        <div class="forgotpassword-form">
            <h4>Paswoord vergeten</h4>
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'fieldConfig' => [
                    'template' => "<div class=\"row\">{label}\n<div class=\"col-sm-12\">{input}</div>\n<div class=\"col-sm-12\">{error}</div></div>",
                    'labelOptions' => ['class' => 'col-sm-12 control-label text-left'],
                ],
            ]); ?>

            <?= $form->field($model, 'username')->textInput() ?>


            <div class="form-group row">
                <div class="col-sm-12">
                    <?= Html::submitButton('Nieuw paswoord registreren', ['class' => 'full-width btn btn-primary', 'name' => 'login-button']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>