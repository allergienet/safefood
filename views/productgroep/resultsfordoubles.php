<h4>
    Overeenkomende productgroepen
</h4>
<ul>
<?php

    foreach($dataProvider->getModels() as $r){
        echo '<li>'.$r->naam.'</li>';
    }
?>
</ul>
