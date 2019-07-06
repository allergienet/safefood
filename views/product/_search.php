<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */

$productgroeps=app\models\Productgroep::find()
    ->orderBy('productgroep.naam asc')
    ->all();
$allergenen=app\models\Allergeen::find()
    ->orderBy('allergeen.naam asc')
    ->all();
$ingredienten=  app\models\Ingredient::find()
    ->orderBy('ingredient.naam asc')
    ->all();

if(empty($model->productgroepen)){
    $model->productgroepen= \yii\helpers\ArrayHelper::map($productgroeps,'id','id');
}
if(empty($model->allergenen)){
    $model->allergenen=  [];
}
if(empty($model->ingredienten)){
    $model->ingredienten=  [];
}
?>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['site/index','manualsearch'=>true],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    
    <div class="row">
        <div class="panel-group">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#categorie" class="searchpanelgroup"><?= Yii::t('app','Categorie')?>
                            <i class="fa fa-chevron-down pull-right"></i>
                        </a>
                    </h4>
                </div>
                <div id="categorie" class="panel-body collapse in">
                    <?php
                        foreach($productgroeps as $pg){
                            if(in_array($pg->id, $model->productgroepen)){
                                ?>
                                    <a href="#" style="display:block;" onclick="togglecheckmark(this,'productgroep-<?=$pg->id?>','check')"><i class="far fa-check-square"></i> <?=$pg->naam?></a>
                                    <input type="checkbox" checked data-toggle="productgroep-<?=$pg->id?>" name="ProductSearch[productgroepen][]" value="<?=$pg->id?>" style="display:none" data-pjax="1">
                                <?php
                            }
                            else{
                                ?>
                                    <a href="#" style="display:block;" onclick="togglecheckmark(this,'productgroep-<?=$pg->id?>','check')" ><i class="far fa-square"></i> <?=$pg->naam?></a>
                                    <input type="checkbox" data-toggle="productgroep-<?=$pg->id?>" name="ProductSearch[productgroepen][]" value="<?=$pg->id?>" style="display:none" data-pjax="1">
                                <?php
                            }
                        }
                    ?>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#allergenen" class="searchpanelgroup"><?= Yii::t('app','Allergenen')?>
                            <i class="fa fa-chevron-down pull-right"></i>
                        </a>
                    </h4>
                </div>
                <div id="allergenen" class="panel-body collapse in">
     
                    <?php
                    
                    foreach($allergenen as $a){
                        if(in_array($a->id, $model->allergenen)){
                    ?>
                        <a href="#" style="display:block;" onclick="togglecheckmark(this,'allergeen-<?=$a->id?>','minus')"><i class="far fa-minus-square"></i> <?=$a->naam?></a>
                        <input type="checkbox" checked data-toggle="allergeen-<?=$a->id?>" name="ProductSearch[allergenen][<?=$a->id?>]" value="<?=$a->id?>" style="display:none" data-pjax="1">
                    <?php
                        }
                        else{
                    ?>
                        <a href="#" style="display:block;" onclick="togglecheckmark(this,'allergeen-<?=$a->id?>','minus')"><i class="far fa-square"></i> <?=$a->naam?></a>
                        <input type="checkbox" data-toggle="allergeen-<?=$a->id?>" name="ProductSearch[allergenen][<?=$a->id?>]" value="<?=$a->id?>" style="display:none" data-pjax="1">
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#ingredienten" class="searchpanelgroup"><?= Yii::t('app','Ingrediënten')?>
                            <i class="fa fa-chevron-down pull-right"></i>
                        </a>
                    </h4>
                </div>
                <div id="ingredienten" class="panel-body collapse in">
                    <?php
                   
                    foreach($ingredienten as $i){
                        if(in_array($i->id, $model->ingredienten)){
                      ?>
                        <a href="#" style="display:block;" onclick="togglecheckmark(this,'ingredient-<?=$i->id?>','minus')"><i class="far fa-minus-square"></i> <?=$i->naam?></a>
                        <input type="checkbox" checked data-toggle="ingredient-<?=$i->id?>" name="ProductSearch[ingredienten][]" value="<?=$i->id?>" style="display:none" data-pjax="1">
                      <?php
                        }
                        else{
                      ?>
                        <a href="#" style="display:block;" onclick="togglecheckmark(this,'ingredient-<?=$i->id?>','ingredient','minus')"><i class="far fa-square"></i> <?=$i->naam?></a>
                        <input type="checkbox" data-toggle="ingredient-<?=$i->id?>" name="ProductSearch[ingredienten][]" value="<?=$i->id?>" style="display:none" data-pjax="1">
                      <?php      
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    
    

    <div class="form-group" style="display:none;">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary','id'=>'btnsearchproduct']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



<?php
$this->registerCss('[data-toggle="collapse"]:not(.collapsed) > i {transform: rotate(180deg) ;}');
?>