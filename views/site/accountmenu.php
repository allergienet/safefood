<?php
use yii\helpers\Html;

if($userrole==1){//gebruiker
    //stel filters in
    echo '<li>'.Html::a(Yii::t('app',"mijn profiel"),['site/profiel']).'</li>';
}
elseif($userrole==2){//voedingsdeskundige
    //overzicht van patiënten
    echo '<li>'.Html::a(Yii::t('app',"patiënten"),['patiënt/index']).'</li>';
    //profiel
    echo '<li>'.Html::a(Yii::t('app',"mijn profiel"),['site/profiel']).'</li>';
}
elseif($userrole==3){//producent
    //overzicht van producten
    echo '<li>'.Html::a(Yii::t('app',"producten"),['product/index']).'</li>';
    //profiel
    echo '<li>'.Html::a(Yii::t('app',"mijn profiel"),['site/profiel']).'</li>';
}
?>


<li>
<?= Html::beginForm(['/site/logout'], 'post') ?>
<?= Html::submitButton(
        Yii::t('app','Logout'),
        ['class' => 'btn btn-primary fullwidth']
    )
?>
<?= Html::endForm()?>
</li>