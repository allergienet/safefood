<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(
            ['options' => ['enctype' => 'multipart/form-data']]
    ); ?>

    
    
    <?= $form->field($model, 'naam')->textInput() ?>

    <?php
    if(!empty($model->foto)){
        ?>
        <div class="form-group">
            <?=Html::img("@web/".$model->foto);?><br/>
            <?= Html::a('<i class="fa fa-remove"></i>',
                ['product/delimage','id'=>$model->id],
                ['class'=>'btn btn-danger','style'=>'width:100px;']); 
            ?>
                
        
        </div>
        <?php
    }
    else{
        echo $form->field($model, 'file')->fileInput();
    }
    ?>
    
    

    
    <?php
        $productgroepen=ArrayHelper::map(app\models\Productgroep::find()
            ->orderBy('productgroep.naam asc')
            ->all(),'id','naam');
    ?>
    
    <?= $form->field($model, 'productgroep_id')->dropDownList($productgroepen) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
