<?php

use yii\bootstrap\Nav;

?>


<?php echo Nav::widget([

    'options' => ['class' =>'nav-tabs'], // set this to nav-tab to get tab-styled navigation
    'activateItems' => true,
    'items' => [
        ['label' => 'План', 'url' => ['/card/view', 'id' => $modCard->id]],
        ['label' => 'Текст', 'url' => ['/card/view-text', 'id' => $modCard->id]],
        ['label' => 'Картинки', 'url' => ['/card/view-images', 'id' => $modCard->id]],
    ],
]); ?>

<br>

<?php echo $content ?>