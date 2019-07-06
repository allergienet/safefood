<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use vova07\imperavi\Widget;

/* @var $this yii\web\View */
/* @var $model app\models\Patient */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="patient-form">

    
    <?php
    if(!$model->isNewRecord && Yii::$app->user->identity->role== app\models\User::ROLE_VOEDINGSDESKUNDIGE){
        if(!$model->hasaccess()){
    ?>
    <div class="registerpatient alert alert-warning">
        <?php $form = ActiveForm::begin([
            'action'=>['patient/sendsignupinviation','id'=>$model->id]
        ]); ?>
         <div class="row">
            <div class="col-sm-12">
                <h4>
                <?= Yii::t('patient', '{name} heeft nog geen login', [
                    'name' => $model->voornaam.' '.$model->naam,
                ]);?>
                </h4>
                <?php
                if(!empty($model->verzoekregistratie)){
                ?>
                <p>
                <?= Yii::t('patient', 'U heeft op {date} een uitnodiging verstuurd naar {email}.', [
                    'date' => DateTime::createFromFormat('Y-m-d H:i:s',$model->verzoekregistratie)->format('d/m/Y'),
                    'email'=>$model->verzoekemail
                ]);?>
                </p>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="form-group">
            <?php
            if(empty($model->email)){
                echo '<p>'.Yii::t('patient','Het email adres ontbreekt. U kan geen registratieverzoek verzenden.').'</p>';
            }
            else{
                echo Html::submitButton(Yii::t('app', 'Verstuur uitnodiging om te registreren'), ['class' => 'btn btn-success']);
            }
            ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
    <?php
        }
    }
    ?>
    
    
    
    
    <?php $form = ActiveForm::begin(['layout'=>'default']); ?>

    <?php
    if(Yii::$app->user->identity->role== app\models\User::ROLE_VOEDINGSDESKUNDIGE){
        $model->dietist_id= app\models\Dietist::getprofile()->id;
        echo$form->field($model,'dietist_id')->hiddenInput()->label(false);
    }
    ?>
   
   
    <div class="row">
        <div class="col-lg-4 col-sm-12">

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

            <?php
            if(Yii::$app->user->identity->role== app\models\User::ROLE_VOEDINGSDESKUNDIGE){
                echo $form->field($model, 'extrainfo')->widget(Widget::className(), [
                    'settings' => [
                        'lang' => 'nl',
                        'minHeight' => 200,
                        'plugins' => [
                            'fullscreen','fontfamily','fontsize','fontcolor','table',
                        ]
                    ]
                ]);
            }
            ?>
        </div>
        <div class="col-sm-12 col-lg-8">
            <?php
            $allergenen= \yii\helpers\ArrayHelper::map(
                \app\models\Allergeen::find()->orderBy("naam asc")->all(),
                'id',
                'naam'
            );
            if(!$model->isNewRecord){
                $model->allergenen= \yii\helpers\ArrayHelper::map(
                    app\models\Patientallergeen::find()
                        ->where(['patient_id'=>$model->id])
                        ->all(),
                    'allergeen_id',
                    'allergeen_id'
                );
            }
            ?>
            <?= $form->field($model,'allergenen')->checkboxList($allergenen)?>
            <?php
            $ingredienten= \yii\helpers\ArrayHelper::map(
                \app\models\Ingredient::find()->orderBy("naam asc")->all(),
                'id',
                'naam'
            );
            if(!$model->isNewRecord){
                $model->ingredienten= \yii\helpers\ArrayHelper::map(
                    app\models\Patientingredient::find()
                        ->where(['patient_id'=>$model->id])
                        ->all(),
                    'ingredient_id',
                    'ingredient_id'
                );
            }
            ?>
            <?= $form->field($model,'ingredienten')->checkboxList($ingredienten)?>
        </div>
    </div>
   

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
