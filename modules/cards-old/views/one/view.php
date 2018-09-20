<?php

use yii\bootstrap\Nav;
use yii\helpers\Html;


?>


<?php echo Nav::widget([
    'options' => ['class' =>'nav-tabs hidden-xs hidden-sm', 'style' => 'margin-bottom: 15px;'],
    'activateItems' => true,
    'items' => [
        ['label' => 'План', 'url' => $this->context->to(['/cards/one/view/plan'])],
        ['label' => 'Текст', 'url' => $this->context->to(['/cards/one/view/text'])],
        ['label' => 'Картинки', 'url' => $this->context->to(['/cards/one/view/images'])],
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
		        ['label' => 'План', 'url' => $this->context->to(['/cards/one/view/plan'])],
		        ['label' => 'Текст', 'url' => $this->context->to(['/cards/one/view/text'])],
		        ['label' => 'Картинки', 'url' => $this->context->to(['/cards/one/view/images'])],
		    ],
		]); ?>		
	</footer>

<?php $this->endBlock() ?>