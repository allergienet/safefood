<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['site/index'],
        'method' => 'post',
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
                <div id="categorie" class="panel-collapse collapse">
                    <div class="panel-body">
                        <a href="#" onclick="alert('resetcategorie');"><i class="far fa-square"></i> <?= Yii::t('app','alle productgroepen')?></a>
                          <?php
                                $productgroeps=app\models\Productgroep::find()
                                    ->leftJoin('product','product.productgroep_id=productgroep.id')
                                    ->select([
                                        'productgroep.*',
                                        'aantalproducten'=>new \yii\db\Expression('count(product.id)')
                                    ])
                                    ->orderBy('productgroep.naam asc')
                                    ->groupBy('productgroep.id')
                                    ->all();
                                foreach($productgroeps as $pg){
                                ?>
                                    <a href="#" style="display:block;" onclick="togglecheckmark(this,'productgroep-<?=$pg->id?>')"><i class="far fa-square"></i> <?=$pg->naam?> <span class="aantalproducten">(<?= $pg->aantalproducten?>)</span></a>
                                    <input type="checkbox" data-toggle="productgroep-<?=$pg->id?>" name="ProductSearch[productgroep_id][<?=$pg->id?>]" value="1" style="display:none" data-pjax="1">
                                <?php
                                }
                          ?>
                    </div>
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
                <div id="allergenen" class="panel-collapse collapse">
                    <div class="panel-body">
                          <?php
                            $allergenen=app\models\Allergeen::find()
                                ->leftJoin('allergeenproduct','allergeenproduct.allergeen_id=allergeen.id')
                                ->select([
                                    'allergeen.*',
                                    'aantalproducten'=>new \yii\db\Expression('count(allergeenproduct.id)')
                                ])
                                ->orderBy('allergeen.naam asc')
                                ->groupBy('allergeen.id')
                                ->all();
                            foreach($allergenen as $a){
                            ?>
                                <p><?=$a->naam?> <span class="aantalproducten">(<?= $a->aantalproducten?>)</span></p>
                            <?php
                            }
                          ?>
                    </div>
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
                <div id="ingredienten" class="panel-collapse collapse">
                    <div class="panel-body">
                          <?php
                            $ingredienten=  app\models\Ingredient::find()
                                ->leftJoin('ingredientproduct','ingredientproduct.ingredient_id=ingredient.id')
                                ->select([
                                    'ingredient.*',
                                    'aantalproducten'=>new \yii\db\Expression('count(ingredientproduct.id)')
                                ])
                                ->orderBy('ingredient.naam asc')
                                ->groupBy('ingredient.id')
                                ->all();
                            foreach($ingredienten as $i){
                            ?>
                                <p><?=$i->naam?> <span class="aantalproducten">(<?= $i->aantalproducten?>)</span></p>
                            <?php
                            }
                          ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



<?php
$this->registerCss('[data-toggle="collapse"].collapsed > i {transform: rotate(180deg) ;}');
        

?>