<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

use app\models\CardTransfer;
use yii\bootstrap\Dropdown;
?>


<?php $this->beginContent('@app/views/card/view.php', ['modCard' => $modCard]) ?>

	<?php Pjax::begin(['scrollTo' => true]) ?>

		<table class='table table-striped table-bordered hidden-xs'>
			<tr>
				<th>Остановка или объект</th>
				<th class='number'>Время</th>
				<th class='number'>Объем</th>
				<th class='action-column action-column-5'></th>
			</tr>
			
			<?php $arrTransfers = CardTransfer::find()->where(['id_card' => $modCard->id])->sorted()->with('objects')->all() ?>

			<?php foreach ($arrTransfers as $modTransfer): ?>

				<tr>
					<td><?php echo $modTransfer->name ?></td>
					<td class="number"><?php echo $modTransfer->time ?></td>
					<td></td>
					<td class='action-column action-column-5'>
						<?php echo Html::a('<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>', ['/object/create', 'id' => $modTransfer->id]) ?>

						<?php echo Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>', ['/transfer/update', 'id' => $modTransfer->id]) ?>

						<?php echo Html::a('<span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>', ['/transfer/sort', 'id' => $modTransfer->id]) ?>
						<?php echo Html::a('<span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>', ['/transfer/sort', 'id' => $modTransfer->id, 'inv' => 1]) ?>
						<?php echo Html::a('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>', ['/transfer/delete', 'id' => $modTransfer->id], ['data-confirm' => 'Точно?', 'data-method' => 'post']) ?>

					</td>
				</tr>

				<?php foreach ($modTransfer->objects as $modObject): ?>

					<tr>
						<td class='level-1'><?php echo $modObject->name ?></td>
						<td class="number"><?php echo $modObject->time ?></td>
						<td class='number'><?php if ($modObject->size) echo Yii::$app->formatter->asInteger($modObject->size) ?></td>
						<td class='action-column action-column-5' style='text-align: right;'>

							<?php echo Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>', ['/object/update', 'id' => $modObject->id]) ?>

							<?php echo Html::a('<span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>', ['/object/sort', 'id' => $modObject->id]) ?>
							<?php echo Html::a('<span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>', ['/object/sort', 'id' => $modObject->id, 'inv' => 1]) ?>
							<?php echo Html::a('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>', ['/object/delete', 'id' => $modObject->id], ['data-confirm' => 'Точно?', 'data-method' => 'post']) ?>

						</td>
					</tr>
					
				<?php endforeach ?>

				
			<?php endforeach ?>

		</table>

		
		<div class="visible-xs-block">
			<?php foreach ($arrTransfers as $modTransfer): ?>
				<div class="well_list-plan well_list well_list-1">

					<div class="dropdown">
						<a href="#" data-toggle="dropdown" class="dropdown-toggle"><?php echo Html::encode($modTransfer->name) ?></a>
						<?php
							echo Dropdown::widget([
								'items' => [
									['label' => 'К тексту', 'url' => ['/card/view-text', 'id' => $modCard->id, '#' => 'transfer-' . $modTransfer->id]],
									// ['label' => 'Добавить объект', 'url' => ['/object/create', 'id' => $modTransfer->id]],
									['label' => 'Редактировать', 'url' => ['/transfer/update', 'id' => $modTransfer->id]],
									['label' => 'Передвинуть вверх', 'url' => ['/transfer/sort', 'id' => $modTransfer->id]],
									['label' => 'Передвинуть вниз', 'url' => ['/transfer/sort', 'id' => $modTransfer->id, 'inv' => 1]],
									['label' => 'Удалить', 'url' => ['/transfer/delete', 'id' => $modTransfer->id, 'inv' => 1], 'linkOptions' => ['data-confirm' => 'Точно?', 'data-method' => 'post']],
								],
							]);
						?>
					</div>

					<?php if ($modTransfer->time): ?>
						<div class="well_list--options">
							Переход: <?php echo $modTransfer->time ?> мин.
						</div>					
					<?php endif ?>
				</div>

				<?php foreach ($modTransfer->objects as $modObject): ?>
					<div class="well_list-plan well_list well_list-2">

						<div class="dropdown">
							<a href="#" data-toggle="dropdown" class="dropdown-toggle"><?php echo Html::encode($modObject->name) ?></a>
							<?php
								echo Dropdown::widget([
									'items' => [
										['label' => 'К тексту', 'url' => ['/card/view-text', 'id' => $modCard->id, '#' => 'object-' . $modObject->id]],
										['label' => 'Редактировать', 'url' => ['/object/update', 'id' => $modObject->id]],
										['label' => 'Передвинуть вверх', 'url' => ['/object/sort', 'id' => $modObject->id]],
										['label' => 'Передвинуть вниз', 'url' => ['/object/sort', 'id' => $modObject->id, 'inv' => 1]],
										['label' => 'Удалить', 'url' => ['/object/delete', 'id' => $modObject->id, 'inv' => 1], 'linkOptions' => ['data-confirm' => 'Точно?', 'data-method' => 'post']],
									],
								]);
							?>
						</div>

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

		<script>
			jQuery(function ($) {
				$('.dropdown-toggle').dropdown();
			});			
		</script>

	<?php Pjax::end() ?>


<?php $this->endContent() ?>

