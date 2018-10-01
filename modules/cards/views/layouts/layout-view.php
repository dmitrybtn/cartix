<?php

use yii\bootstrap\Nav;
use yii\helpers\Html;

?>

<?php $this->beginContent('@app/modules/cards/views/layouts/layout.php') ?>

	<?php $this->beginBlock('cards_content_header--options') ?>
		<?php echo Nav::widget([
		    'options' => ['class' =>'nav-pills'],
		    'activateItems' => true,
		    'items' => [
		        ['label' => 'План', 'url' => $this->context->to(['/cards/one/view/plan'])],
		        ['label' => 'Текст', 'url' => $this->context->to(['/cards/one/view/text'])],
		        ['label' => 'Картинки', 'url' => $this->context->to(['/cards/one/view/images'])],
		    ],
		]); ?>
	<?php $this->endBlock() ?>


	<?php echo $content ?>

	<div class="visible-xs-block" style='height: 50px;'></div>

	<?php $this->beginBlock('footer') ?>
		<footer class='footer-mobile'>
			<?php echo Nav::widget([
			    'options' => ['class' =>'nav-footer cards_footer'],
			    'activateItems' => true,
			    'items' => [
			        ['label' => 'План', 'url' => $this->context->to(['/cards/one/view/plan'])],
			        ['label' => 'Текст', 'url' => $this->context->to(['/cards/one/view/text'])],
			        ['label' => 'Картинки', 'url' => $this->context->to(['/cards/one/view/images'])],
			    ],
			]); ?>		
		</footer>
	<?php $this->endBlock() ?>

	<script>
		$(function ($) {



		    // В десктопном режиме отслеживать прокрутку
	        if ($('#cards_content').hasClass('cards_content-desktop')) {

				// Открутить на последнее сохраненное значение
		        if (sessionStorage.getItem('scroll-cont') != null)
		            $('#cards_content').scrollTop(sessionStorage.getItem('scroll-cont'));

		        // Сохранять значение прокрутки
			    $(window).on('beforeunload', function() {
			        sessionStorage.setItem('scroll-cont', $('#cards_content').scrollTop());
			    });


	        	$('#cards_content').scrollspy({target: '.cards_layout_plan--nav-spy'});
	        } else {

				// Открутить на последнее сохраненное значение
		        if (sessionStorage.getItem('scroll-body') != null)
		            $('body').scrollTop(sessionStorage.getItem('scroll-body'));

		        // Сохранять значение прокрутки
			    $(window).on('beforeunload', function() {
			        sessionStorage.setItem('scroll-body', $('body').scrollTop());
			    });

	        }



		});
	</script>

<?php $this->endContent() ?>

