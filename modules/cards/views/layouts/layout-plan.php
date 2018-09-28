<?php

	namespace app\modules\cards\views\layouts;

	use Yii;

	use yii\helpers\{Html, Url};
?>

<div class="cards_layout_plan" id='cards_layout_plan' data-refresh='<?= Url::to($this->context->to(['/cards/one/view/refresh-plan'])) ?>'>
	<nav id='cards_layout_plan--nav' class='cards_layout_plan--nav cards_layout_plan--nav-spy'>
		<ul class='nav nav-stacked nav-pills sortable-1'>
			<?php foreach ($this->context->transfers as $modTransfer): ?>
				<li>
					<?php echo Html::a(Html::encode($modTransfer->name), '#', ['class' => 'cards_layout_plan--link', 'data-target' => '#transfer-' . $modTransfer->id]) ?>
				
					<ul class='nav nav-stacked sortable-2'>

						<?php foreach ($modTransfer->objects as $modObject): ?>
							<li>
								<?php echo Html::a(Html::encode($modObject->name), '#', ['class' => 'cards_layout_plan--link', 'data-target' => '#object-' . $modObject->id]) ?>
							</li>
						<?php endforeach ?>
					</ul>
				</li>


			<?php endforeach ?>
		</ul>		
	</nav>
</div>