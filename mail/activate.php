<?php
use yii\helpers\Html;


?>
<div style="width:320px;margin:0px auto;border: 1px solid rgb(91, 167, 238);">
    <h1 style="background: rgb(91, 167, 238);text-align: center">
        Safefood
    </h1>
    <p style="text-align: center;">Bijna gedaan met registreren!</p>

    <p style="text-align: center;">Klik op de link hieronder om jouw email te confirmeren en je account te activeren</p>
    <p style="text-align: center;">
    <?= Html::a('Activeer account','https://www.safefood.be/site/activate?key='.$activationkey,[
        'style'=>'display:block;line-height:34px;border:1px solid rgb(91, 167, 238);border-radius:4px;padding:15px;'
    ]);?>
    </p>
</div>