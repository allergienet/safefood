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
            <div id="loading-div">
                <i class="fas fa-circle-notch fa-spin"></i>
            </div>
            <div id="product-results">
                
                
                <?php
                $counter=0;
                foreach($dataProvider->getModels() as $product){
                if($counter==0){
                    echo '<div class="row">';
                }
                ?>
                
                <div class="panel panel-product col-lg-4">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <?= Html::img("@web/".$product->foto);?> 
                            
                        </div>
                    </div>
                    <div class="panel-body">
                        <h4>
                            <?= $product->naam?>
                        </h4>
                        <div class="product-allergenen">
                            <p>
                                Allergenen
                            </p>
                            <ul>
                            <?php
                            foreach($product->allergeenproducts as $ap){
                            ?>
                                <li>
                                    <?= $ap->allergeen->naam?>
                                    <?php
                                    if($ap->bevatsporen==1){
                                        echo ' (sporen van)';
                                    }
                                    ?>
                                    <?php
                                    if($ap->bevatsporen==1){
                                        echo ' (in productielijn)';
                                    }
                                    ?>
                                </li>
                            <?php
                            }
                            ?>
                            </ul>
                        </div>
                        <div class="product-ingredienten">
                            <p>
                                Ingrediënten 
                            </p>
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
                    </div>
                </div>
                <?php
                    if($counter==2){
                        echo '</div>';
                        $counter=0;
                    }
                    else{
                        $counter++;
                    }
                }
                ?>
            </div>
        </div>
    </div>
    
    <?php
    $this->registerJs('setminheightofproducts();');
    ?>
    <?php Pjax::end(); ?>

</div>
