<?php
use yii\helpers\Html;


?>
<div style="width:320px;margin:0px auto;border: 1px solid rgb(91, 167, 238);">
    <h1 style="background: rgb(91, 167, 238);text-align: center">
        Safefood
    </h1>
    <p style="text-align: center;">Heractiveer je account!</p>

    <p style="text-align: center;">Klik op de link hieronder om jouw email te confirmeren en je paswoord te veranderen</p>
    <p style="text-align: center;">
    <?= Html::a('Verander paswoord','https://www.safefood.be/site/resetpassword?key='.$resetpasswordkey,[
        'style'=>'display:block;line-height:34px;border:1px solid rgb(91, 167, 238);border-radius:4px;padding:15px;'
    ]);?>
    </p>
</div>