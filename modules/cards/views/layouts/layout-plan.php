<?php

	namespace app\modules\cards\views\layouts;

	use Yii;

	use yii\helpers\{Html, Url};
?>

<div class="cards_layout_plan" id='cards_layout_plan' data-refresh='<?= Url::to($this->context->to(['/cards/view/refresh-plan'])) ?>'>
	<nav id='cards_layout_plan--nav' class='cards_layout_plan--nav cards_layout_plan--nav-spy'>
		<ul class='nav nav-stacked nav-pills'>
			<?php foreach ($this->context->transfers as $modTransfer): ?>
				<li>
					<?php echo Html::a(Html::encode($modTransfer->name), '#', ['class' => 'cards_layout_plan--link', 'data-target' => '#transfer-' . $modTransfer->id]) ?>
				

				</li>

				<?php foreach ($modTransfer->objects as $modObject): ?>
					<li class='cards_layout_plan_object'>
						<?php echo Html::a(Html::encode($modObject->name), '#', ['class' => 'cards_layout_plan--link', 'data-target' => '#object-' . $modObject->id]) ?>
					</li>
				<?php endforeach ?>


			<?php endforeach ?>
		</ul>		
	</nav>
</div>

<script>

	var id_card = <?php echo $this->context->card->id ?>;

	$(function ($) {

		// Включить прокрутку основной области для десктопов
		env = findBootstrapEnvironment();

        if ($('#cards_content').hasClass('cards_content-desktop')) {

            // Сохранение прокрутки плана
            $(window).on('unload', function() {
                sessionStorage.setItem('scroll-plan-' + id_card, $('#cards_layout_plan').scrollTop());
            });

            // Восстановление прокрутки плана
            if (sessionStorage.getItem('scroll-plan-' + id_card) != null)
                $('#cards_layout_plan').scrollTop(sessionStorage.getItem('scroll-plan-' + id_card));

            // Отслеживание прокрутки
            $('#cards_content').scrollspy({target: '.cards_layout_plan--nav-spy'});

        }


	    // Плавная прокрутка текста
	    $('.cards_layout_plan--link').click(function() {
	        
	        var link = $(this)
	        var target = link.attr('data-target');
	        var coords = $(target).position().top;

	        $('#cards_layout_plan--nav').removeClass('cards_layout_plan--nav-spy');

	        $('#cards_content').animate({
	            scrollTop: $('#cards_content').scrollTop() + coords
	        }, {
	            duration: 400,
	            easing: "swing",
	            complete: function() {
	                
	                $('.cards_layout_plan--nav li').removeClass('active');

	                link.parent().addClass("active");

	                $('#cards_layout_plan--nav').addClass('cards_layout_plan--nav-spy');                
	            }
	        });
	       

	        return false;
	    })


	});
</script>