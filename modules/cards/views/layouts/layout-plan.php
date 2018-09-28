<?php

	namespace app\modules\cards\views\layouts;

	use Yii;

	use yii\helpers\{Html, Url};
?>

<div class="cards_layout_plan" id='cards_layout_plan' data-refresh='<?= Url::to($this->context->to(['/cards/one/view/refresh-plan'])) ?>'>
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
