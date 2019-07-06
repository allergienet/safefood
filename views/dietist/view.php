<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dietist */

$this->title = $model->voornaam. ' '.$model->naam;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Mijn diëtist')];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="dietist-view">
    <table>
        <tr>
            <?php
                if(!empty($model->logo)){
            ?>
            <td id="container-logo">
                <?= Html::img("@web/".$model->logo)?>
            </td>
            <?php
                }
                ?>
            <td id="container-data">
                <h4>
                    <?= $model->voornaam. ' '.$model->naam ?>
                </h4>
                <?php
                if(!empty($model->email)){
                ?>
                <p><i class="fa fa-envelope"></i> <?= $model->email?></p>
                <?php
                }
                ?>
                <?php
                if(!empty($model->gsm)){
                ?>
                <p><i class="fa fa-mobile"></i> <?= $model->gsm?></p>
                <?php
                }
                ?>
                <?php
                if(!empty($model->tel)){
                ?>
                <p><i class="fa fa-phone"></i> <?= $model->tel?></p>
                <?php    
                }
                ?>
                <?php
                if(!empty($model->adres)){
                ?>
                <p><i class="fa fa-map-marker"></i> <?= $model->adres?></p>
                <?php    
                }
                ?>
            </td>
        </tr>
        
    

</div>
