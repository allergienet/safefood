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
                'format'=>'raw',
                'contentOptions' => function ($model, $key, $index, $column) {
                    return [
                        'style' => 'padding:0;width:200px;'
                    ];
                },
            ],
            'naam',
            [
                'attribute' => 'gridproductgroep',
                'filter' => Html::dropDownList("ProductSearch[productgroep_id]", 
                        $searchModel->productgroep_id,
                        $productgroepen,
                        ['class' => 'form-control','prompt'=>'selecteer productgroep'])
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'contentOptions' => function ($model, $key, $index, $column) {
                    return [
                        'style' => 'padding:0'
                    ];
                },
                'template'=>'{update}{delete}',
                'buttons' => [
                'view' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                'title' => Yii::t('app', 'lead-view'),
                    ]);
                },

                'update' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                'title' => Yii::t('app', 'lead-update'),
                                'class'=>'btn btn-primary'
                    ]);
                },
                'delete' => function ($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                'title' => Yii::t('app', 'lead-delete'),
                                'class'=>'btn btn-danger',
                                'data' => [
                                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                    'method' => 'post',
                                ],
                    ]);
                }

                ],
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>