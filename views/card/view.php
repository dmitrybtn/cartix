<?php

use yii\bootstrap\Nav;

?>


<?php echo Nav::widget([

    'options' => ['class' =>'nav-tabs', 'style' => 'margin-bottom: 15px;'], // set this to nav-tab to get tab-styled navigation
    'activateItems' => true,
    'items' => [
        ['label' => 'План', 'url' => ['/card/view', 'id' => $modCard->id]],
        ['label' => 'Текст', 'url' => ['/card/view-text', 'id' => $modCard->id]],
        ['label' => 'Картинки', 'url' => ['/card/view-images', 'id' => $modCard->id]],
    ],
]); ?>

<?php echo $content ?>