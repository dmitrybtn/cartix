<?php

use yii\bootstrap\Nav;
use yii\helpers\Html;

?>


<?php echo Nav::widget([
    'options' => ['class' =>'nav-tabs hidden-xs hidden-sm', 'style' => 'margin-bottom: 15px;'], // set this to nav-tab to get tab-styled navigation
    'activateItems' => true,
    'items' => [
        ['label' => 'План', 'url' => ['/card/view', 'id' => $model->id]],
        ['label' => 'Текст', 'url' => ['/card/view-text', 'id' => $model->id]],
        ['label' => 'Картинки', 'url' => ['/card/view-images', 'id' => $model->id]],
    ],
]); ?>

<?php echo $content ?>

<div class="visible-xs-block" style='height: 50px;'></div>

<?php $this->beginBlock('footer') ?>


	<footer class='footer-mobile'>
		<?php echo Nav::widget([
		    'options' => ['class' =>'nav-footer nav-footer-card'],
		    'activateItems' => true,
		    'items' => [
		        ['label' => 'План', 'url' => ['/card/view', 'id' => $model->id]],
		        ['label' => 'Текст', 'url' => ['/card/view-text', 'id' => $model->id]],
		        ['label' => 'Картинки', 'url' => ['/card/view-images', 'id' => $model->id]],
		    ],
		]); ?>		
	</footer>

<?php $this->endBlock() ?>