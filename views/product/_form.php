<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */

$allergeenproducts= ArrayHelper::map($model->allergeenproducts,'allergeen_id',
    function($m){
        return [
            'sporen'=>$m->bevatsporen,
            'productielijn'=>$m->bevatinproductielijn];
    });
$model->arringredienten= ArrayHelper::map(
        app\models\Ingredientproduct::find()
            ->joinWith('ingredient')
            ->select([
                'ingredient_id',
                'ingredientnaam'=>'ingredient.naam'
            ])
            ->where(['product_id'=>$model->id])
            ->all()
            ,'ingredient_id',
            'ingredient_id'
);

?>

<div class="product-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
    ]); ?>
    <div class="row">
        
    
        <div class="col-sm-4">
            <?= $form->field($model, 'naam')->textInput() ?>

            <?= $form->field($model, 'file')->fileInput(['onchange'=>'$("#productlogo").hide();']); ?>

            <?php
            if(!empty($model->foto)){
                ?>
                <div class="form-group">
                    <?=Html::img("@web/".$model->foto,['id'=>'productlogo']);?>
                </div>
            <?php
            }
            ?>
            <?php
                $productgroepen=ArrayHelper::map(app\models\Productgroep::find()
                    ->orderBy('productgroep.naam asc')
                    ->all(),'id','naam');
            ?>

            <?= $form->field($model, 'productgroep_id')->widget(Select2::classname(), [
                'data' => $productgroepen,
                'language' => Yii::$app->language,
                'options' => [
                    'placeholder' => Yii::t('app','Selecteer productgroep'),
                    'multiple' => false, 
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);?>
            <?= Html::a(Yii::t('app','Productgroep staat nog niet in de lijst?'),['productgroep/create'],['target'=>'_blank','style'=>'font-size:90%'])?>
        </div>
        <div class="col-sm-8">
            <h2>
                Allergenen
            </h2>
            <?php
            $allergenen= \app\models\Allergeen::find()
                    ->orderBy('naam asc')->all();
            foreach($allergenen as $a){
            ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-3">
                            <?= $a->naam ?>
                        </div>
                         <div class="col-sm-3">
                             <div class="form-group">
                                <label class="control-label">aanwezig
                                    <input type="checkbox"
                                           name="Product[arrallergenen][<?=$a->id?>][algemeen]"
                                           value="1"
                                    <?= isset($allergeenproducts[$a->id])?'checked':''?>
                                    >
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                             <div class="form-group">
                                <label class="control-label">bevat sporen
                                    <input type="checkbox"
                                           name="Product[arrallergenen][<?=$a->id?>][sporen]"
                                           value="1"
                                    <?= isset($allergeenproducts[$a->id])?($allergeenproducts[$a->id]['sporen']==1?'checked':''):''?>
                                    >
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3">
                             <div class="form-group">
                                <label class="control-label">bevat in productielijn
                                    <input type="checkbox"
                                           name="Product[arrallergenen][<?=$a->id?>][productielijn]"
                                           value="1"
                                    <?= isset($allergeenproducts[$a->id])?($allergeenproducts[$a->id]['productielijn']==1?'checked':''):''?>
                                    >
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
            ?>
            <h2>
                Ingrediënten
            </h2>
            <?php
            echo $form->field($model, 'arringredienten')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(
                        app\models\Ingredient::find()->orderBy('naam asc')->all(),'id','naam'),
                'language' => Yii::$app->language,
                'options' => [
                    'placeholder' => Yii::t('app','Selecteer ingrediënten'),
                    'multiple' => true, 
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ])->label(false);
            ?>
            <?= Html::a(Yii::t('app','Ingrediënt staat nog niet in de lijst?'),['ingredient/create'],['target'=>'_blank','style'=>'font-size:90%'])?>
        </div>
    </div>

    
    <div class="form-group" style="margin-top:20px;">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
