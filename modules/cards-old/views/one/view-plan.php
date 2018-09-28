<?php

use yii\helpers\Html;
use yii\widgets\{Pjax, DetailView};

use app\modules\cards\models\CardTransfer;

use yii\bootstrap\BootstrapPluginAsset;
use yii\bootstrap\Html as BHtml;

BootstrapPluginAsset::register($this);
?>


<?php $this->beginContent('@app/modules/cards/views/one/view.php') ?>

	<div class="row hidden-xs">
		<div class="col-md-6">
		    <?= DetailView::widget([
		        'model' => $this->context->card,
		        'attributes' => [
		            'user.nameFull:text:Автор',
		            ['label' => 'Статус', 'value' => $this->context->card->is_common ? 'Общая' : 'Личная'],
		        ],
		    ]) ?>			
		</div>
		<div class="col-md-6">
		    <?= DetailView::widget([
		        'model' => $this->context->card,
		        'attributes' => [
		            'tst_create:date',
		            'tst_update:date',
		        ],
		    ]) ?>			
		</div>
	</div>

	<div class="visible-xs-block">
	    <?= DetailView::widget([
	        'model' => $this->context->card,
	        'attributes' => [
	            'user.nameInit:text:Автор',
	            'tst_update:date',
	        ],
	    ]) ?>			
	</div>

	<?php Pjax::begin() ?>



	<?php if (0): ?>
		

		<table class='table table-striped table-bordered hidden-xs card_plan'>
			<tr>
				<th>Остановка или объект</th>
				<th class='number'>Время</th>

				<?php if ($this->context->card->isMy): ?>
					<th class='action-column action-column-5'></th>				
				<?php endif ?>
			</tr>
			

			<?php foreach ($arrTransfers as $modTransfer): ?>

				<tr data-transfer-key='<?php echo $modTransfer->id ?>'>
					<td class='card_plan--transfer'>
						<?php echo $modTransfer->name ?>

						<?php if ($t = $modTransfer->objectsTime): ?>
							<span class='pull-right text-muted'>
								Рассказ: <?php echo $t ?> мин.
							</span>							
						<?php endif ?>
					</td>
					<td class="number"><?php echo $modTransfer->time ?></td>

					<?php if ($this->context->card->isMy): ?>
						<td class='action-column action-column-5'>
							<?php echo Html::a(BHtml::icon('plus'), $this->context->to(['/cards/one/object/create', 'id' => $modTransfer->id]), ['class' => 'create']) ?>
							<?php echo Html::a(BHtml::icon('pencil'), $this->context->to(['/cards/one/transfer/update', 'id' => $modTransfer->id]), ['class' => 'update']) ?>
							<?php echo Html::a(BHtml::icon('arrow-up'), $this->context->to(['/cards/one/transfer/sort', 'id' => $modTransfer->id]), ['class' => 'lift']) ?>
							<?php echo Html::a(BHtml::icon('arrow-down'), $this->context->to(['/cards/one/transfer/sort', 'id' => $modTransfer->id, 'inv' => 1]), ['class' => 'drop']) ?>
							<?php echo Html::a(BHtml::icon('trash'), $this->context->to(['/cards/one/transfer/delete', 'id' => $modTransfer->id]), ['class' => 'delete', 'data-confirm' => 'Точно?', 'data-method' => 'POST']) ?>
						</td>
					<?php endif ?>


				</tr>

				<?php foreach ($modTransfer->objects as $modObject): ?>

					<tr data-object-key='<?php echo $modObject->id ?>'>
						<td class='level-1 card_plan--object'>
							<?php echo $modObject->name ?>
						
							<?php if ($modObject->size): ?>
								<span class='pull-right text-muted'>Объем: <?php echo Yii::$app->formatter->asInteger($modObject->size) ?> зн.</span>
							<?php endif ?>
						</td>
						<td class="number"><?php echo $modObject->time ?></td>

						<?php if ($this->context->card->isMy): ?>
							<td class='action-column action-column-5' style='text-align: right;'>
								<?php echo Html::a(BHtml::icon('pencil'), $this->context->to(['/cards/one/object/update', 'id' => $modObject->id]), ['class' => 'update']) ?>
								<?php echo Html::a(BHtml::icon('arrow-up'), $this->context->to(['/cards/one/object/sort', 'id' => $modObject->id])) ?>
								<?php echo Html::a(BHtml::icon('arrow-down'), $this->context->to(['/cards/one/object/sort', 'id' => $modObject->id, 'inv' => 1])) ?>
								<?php echo Html::a(BHtml::icon('trash'), $this->context->to(['/cards/one/object/delete', 'id' => $modObject->id]), ['class' => 'delete', 'data-confirm' => 'Точно?', 'data-method' => 'post']) ?>
							</td>
						<?php endif ?>

					</tr>
					
				<?php endforeach ?>

				
			<?php endforeach ?>

		</table>

	<?php endif ?>

		
		<div class="visible-xs-block">
			<?php foreach ($this->context->card->transfers as $modTransfer): ?>
				<div class="well_list-plan well_list well_list-1 card_plan-mobile--transfer">

					<?php if ($this->context->card->isMy): ?>

						<div class="dropdown">
							<a href="#" data-toggle="dropdown" class="dropdown-toggle"><?php echo Html::encode($modTransfer->name) ?></a>

							<ul class="dropdown-menu">
								<li><?php echo Html::a('К тексту', $this->context->to(['/cards/one/view/text', 'id' => $this->context->card->id, '#' => 'transfer-' . $modTransfer->id])) ?></li>
								<li><?php echo Html::a('Добавить объект', $this->context->to(['/cards/one/object/create', 'id' => $modTransfer->id])) ?></li>
								<li><?php echo Html::a('Редактировать', $this->context->to(['/cards/one/transfer/update', 'id' => $modTransfer->id])) ?></li>
								<li><?php echo Html::a('Передвинуть выше', $this->context->to(['/cards/one/transfer/sort', 'id' => $modTransfer->id])) ?></li>
								<li><?php echo Html::a('Передвинуть ниже', $this->context->to(['/cards/one/transfer/sort', 'id' => $modTransfer->id, 'inv' => 1])) ?></li>
								<li><?php echo Html::a('Удалить', $this->context->to(['/cards/one/transfer/delete', 'id' => $modTransfer->id]), ['data-confirm' => 'Точно?', 'data-method' => 'post']) ?></li>
							</ul>						
						</div>
					
					<?php else: ?>
						<?php echo Html::a(Html::encode($modTransfer->name), $this->context->to(['/cards/one/view/text', '#' => 'transfer-' . $modTransfer->id])) ?>
					<?php endif ?>



						<div class="well_list--options">
							<?php if ($modTransfer->time): ?>
								Переход: <?php echo $modTransfer->time ?> мин.
							<?php endif ?>

							<?php if ($t = $modTransfer->objectsTime): ?>
								Рассказ: <?php echo $t ?> мин.
							<?php endif ?>
						</div>					
				</div>

				<?php foreach ($modTransfer->objects as $modObject): ?>
					<div class="well_list-plan well_list well_list-2 card_plan-mobile--object">

						<?php if ($this->context->card->isMy): ?>

							<div class="dropdown">
								<a href="#" data-toggle="dropdown" class="dropdown-toggle"><?php echo Html::encode($modObject->name) ?></a>

								<ul class="dropdown-menu">
									<li><?php echo Html::a('К тексту', $this->context->to(['/cards/one/view/text', '#' => 'object-' . $modObject->id])) ?></li>
									<li><?php echo Html::a('Редактировать', $this->context->to(['/cards/one/object/update', 'id' => $modObject->id])) ?></li>
									<li><?php echo Html::a('Передвинуть выше', $this->context->to(['/cards/one/object/sort', 'id' => $modObject->id])) ?></li>
									<li><?php echo Html::a('Передвинуть ниже', $this->context->to(['/cards/one/object/sort', 'id' => $modObject->id, 'inv' => 1])) ?></li>
									<li><?php echo Html::a('Удалить', $this->context->to(['/cards/one/object/delete', 'id' => $modObject->id], ['data-confirm' => 'Точно?', 'data-method' => 'post'])) ?></li>
								</ul>						
							</div>
						<?php else: ?>
							<?php echo Html::a(Html::encode($modObject->name), $this->context->to(['/cards/one/view/text', '#' => 'object-' . $modObject->id])) ?>							
						<?php endif ?>



						<div class="well_list--options">
							<?php if ($modObject->time): ?>
								Рассказ: <?php echo $modObject->time ?> мин.
							<?php endif ?>

							<?php if ($modObject->size): ?>
								Объем: <?php echo Yii::$app->formatter->asInteger($modObject->size) ?> зн.
							<?php endif ?>
						</div>						

					</div>				
				<?php endforeach ?>
			<?php endforeach ?>			
		</div>

	<?php Pjax::end() ?>


<?php $this->endContent() ?>
