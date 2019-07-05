<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Producten');
$this->params['breadcrumbs'][] = $this->title;

$productgroepen=ArrayHelper::map(app\models\Productgroep::find()
    ->orderBy('productgroep.naam asc')
    ->all(),'id','naam');
?>
<div class="product-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Product toevoegen'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'value'=>function($m){
                    return Html::img("@web/".$m->foto);
                },
                'format'=>'raw'
            ],
            'naam',
            [
                'attribute' => 'gridproductgroep',
                'filter' => Html::dropDownList("ProductSearch[productgroep_id]", 
                        $searchModel->productgroep_id,
                        $productgroepen,
                        ['class' => 'form-control','prompt'=>'selecteer productgroep'])
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>