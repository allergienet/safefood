<h2 style="margin: 0px;padding: 5px 20px;">Welkom</h2>
<?php
use yii\helpers\Html;

if($userrole== app\models\User::ROLE_USER){//gebruiker
    //stel filters in
    echo '<li>'.Html::a(Yii::t('app',"mijn profiel"),['patient/update','id'=> app\models\Patient::getprofile()->id]).'</li>';
    echo '<li>'.Html::a(Yii::t('app',"mijn diëtist"),['dietist/view','id'=> app\models\Patient::getprofile()->dietist_id]).'</li>';
}
elseif($userrole==app\models\User::ROLE_VOEDINGSDESKUNDIGE){//voedingsdeskundige
    //overzicht van patiënten
    echo '<li>'.Html::a(Yii::t('app',"mijn patiënten"),['patient/index']).'</li>';
    //profiel
    echo '<li>'.Html::a(Yii::t('app',"mijn profiel"),['dietist/update','id'=> app\models\Dietist::getprofile()->id]).'</li>';
}
elseif($userrole==app\models\User::ROLE_PRODUCENT){//producent
    //overzicht van producten
    echo '<li>'.Html::a(Yii::t('app',"mijn producten"),['product/index']).'</li>';
    //profiel
    //echo '<li>'.Html::a(Yii::t('app',"mijn profiel"),['site/profiel']).'</li>';
}
?>
<li style="margin-bottom:10px;">
    <?= Html::a(Yii::t('app','Afmelden'),'#',[
        'onclick'=>'$("#logout").click()'
    ])?>
</li>

<div style="display:none;">
<?= Html::beginForm(['/site/logout'], 'post') ?>
<?= Html::submitButton(
        Yii::t('app','Afmelden'),
        ['id'=>'logout']
    )
?>
<?= Html::endForm()?>
</div>
    