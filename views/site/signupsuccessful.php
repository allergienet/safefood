<?php
use dmstr\widgets\Alert;
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use app\models\ContactForm;
$this->title = 'Klasmixer';
?>
<div class="site-login">
    
    <h1 class="login-header"><?= Html::encode($this->title) ?></h1>

    <div class="login-content">
        <div class="login-form">
            <?= Alert::widget() ?>

            <div class="form-group">
                <div class="col-sm-12">
                    <?= Html::a('aanmelden',['site/login'],['style'=>'color: #288ae6']) ?>
                </div>
            </div>
        </div>
    </div>
    <?= $this->render(
        '@app/views/site/about'
    ) ?>
    <?= $this->render(
        '@app/views/site/contact',[
            'model'=> new ContactForm()
        ]) ?>
</div>