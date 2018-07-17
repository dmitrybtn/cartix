<?php

use yii\helpers\Html;
use yii\widgets\Pjax;


use yii\widgets\ActiveForm;

use app\models\CardTransfer;
use app\models\CardImage;
?>

<?php $modImage = new CardImage ?>

<?php echo Html::beginForm(['/image/create', 'id' => $modCard->id], 'post', ['enctype' => 'multipart/form-data']) ?>
	<div class="well well-sm">
		<div class="row">
			
			<div class="col-md-7 col-sm-vmargin">
				<?php echo Html::activeTextInput($modImage, 'url', ['class' => 'form-control', 'placeholder' => 'Введите URL картинки или загрузите файл']) ?>					
			</div>

			<div class="col-md-3 col-sm-vmargin">
				<?php echo Html::activeFileInput($modImage, 'file', ['class' => '']) ?>
					
			</div>
			
			<div class="col-md-2">
				<?php echo Html::submitButton('Загрузить', ['class' => 'btn btn-primary btn-block']) ?>		
			</div>				
		</div>		
	</div>
<?php echo Html::endForm() ?>

<div class="row">
<?php foreach ($modCard->images as $modImage): ?>

	<div class="col-xs-4 col-md-2 col-sm-3">
		<a href="#" class="thumbnail">
			<?php echo Html::img($modImage->thumbnail(300, 300), ['alt' => 'Экскурсия']) ?>
		</a>
	</div>

	
<?php endforeach ?>	
</div>



<?php if (0): ?>
	

	<?php Pjax::begin(); ?>

	<table class='table table-striped table-bordered'>
		<tr>
			<th>Остановка или объект</th>
			<th class='action-column action-column-5'>Опции</th>
		</tr>

		<?php foreach (CardTransfer::find()->where(['id_card' => $modCard->id])->sorted()->all() as $modTransfer): ?>

			<tr>
				<td><?php echo $modTransfer->name ?></td>
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

	<?php Pjax::end(); ?>

<?php endif ?>
