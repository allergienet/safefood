<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ProductSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
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
              <div id="categorie" class="panel-collapse collapse">
                  <div class="panel-body">
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
                                <p><?=$pg->naam?> <span class="aantalproducten">(<?= $pg->aantalproducten?>)</span></p>
                            <?php
                            }
                      ?>
                  </div>
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