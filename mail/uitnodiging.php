<?php
use yii\helpers\Html;


?>
<div style="width:320px;margin:0px auto;border: 1px solid rgb(91, 167, 238);">
    <h1 style="background: rgb(91, 167, 238);text-align: center">
        Safefood
    </h1>
    <?php
    $dietist=$model->dietist;
    ?>
    <p style="text-align: center;">Voedingsdeskundige <?= $dietist->voornaam . ' '. $dietist->naam ?> heeft u een uitnodiging gestuurd om je te registeren op <a href="https://safefood.be">safefood.be</a></p>

    <p style="text-align: center;">Klik op de link hieronder om je te registeren.</p>
    <p style="text-align: center;">
    <?= Html::a('Activeer account','https://www.safefood.be/site/signup?key='.$signupkey,[
        'style'=>'display:block;line-height:34px;border:1px solid rgb(91, 167, 238);border-radius:4px;padding:15px;'
    ]);?>
    </p>
</div>