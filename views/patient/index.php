<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PatientSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('patient', 'Patiënten');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="patient-index">

    <p>
        <?= Html::a(Yii::t('patient', 'Patient toevoegen'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'naam',
            'voornaam',
            'tel',
            'gsm',
            'adres',
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
