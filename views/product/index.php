<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $product app\models\Product */

$this->title = Yii::t('app', 'Safefood');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-index">
    <?php Pjax::begin(); ?>
    <div class="row">
        <div class="col-lg-2">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
        <div class="col-lg-10">
            <div id="product-results">
                <?php
                foreach($dataProvider->getModels() as $product){
                ?>
                <div class="product-item">
                    <h2>
                        <?= $product->productgroep->naam?> - <?= $product->naam?>
                    </h2>
                    
                </div>
                <div class="product-allergenen">
                    <h4>
                        Allergenen
                    </h4>
                    <ul>
                    <?php
                    foreach($product->allergeenproducts as $ap){
                    ?>
                        <li>
                            <?= $ap->allergeen->naam?>
                        </li>
                    <?php
                    }
                    ?>
                    </ul>
                </div>
                <div class="product-ingredienten">
                    <h4>
                        Ingrediënten 
                    </h4>
                    <ul>
                    <?php
                    foreach($product->ingredientproducts as $ip){
                    ?>
                        <li>
                            <?= $ip->ingredient->naam?>
                        </li>
                    <?php
                    }
                    ?>
                    </ul>
                </div>
                
                
                <?php
                }
                ?>
                <div id="loading-div">
                    <i class="fas fa-circle-notch fa-spin"></i>
                </div>
            </div>
        </div>
    </div>
    
    
    <?php Pjax::end(); ?>

</div>
