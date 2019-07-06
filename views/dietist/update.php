<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dietist */

$this->title = Yii::t('app', 'Mijn profiel');
    $this->params['breadcrumbs'][] = Yii::t('app', 'Mijn Profiel');
?>
<div class="dietist-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
