<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

use yii\widgets\ActiveForm;
use app\modules\cards\models\CardImage;

use app\modules\cards\controllers\owner\ImageController;

$arrImages = [];

?>

	<!-- Форма загрузки картинок -->
	<?php if (Yii::$app->user->can('cards/owner')): ?>
		<?php echo Html::beginForm($this->context->to(['/cards/owner/image/upload']), 'post', ['id' => 'form-image-upload', 'data-pjax' => 1, 'enctype' => 'multipart/form-data']) ?>
			
			
			<div class="well well-sm">
				<div class="row">
					
					<div class="col-md-7 col-sm-vmargin">
						<?php echo Html::textInput('url', '', ['class' => 'form-control', 'placeholder' => 'Введите URL картинки или загрузите файл']) ?>					
					</div>

					<div class="col-md-3 col-sm-vmargin">
						<?php echo Html::fileInput('file[]', null, ['multiple' => true, 'accept' => 'image/*']) ?>
							
					</div>
					
					<div class="col-md-2">
						<?php echo Html::submitButton('Загрузить', ['class' => 'form-image-upload--submit btn btn-primary btn-block', 'data-loading-text' => 'Загружаю...']) ?>		
					</div>				
				</div>		
			</div>
		<?php echo Html::endForm() ?>

		<?php if ($arrErrors = Yii::$app->session->getFlash('image-upload')): ?>
			<div class="alert alert-danger">
				<p>При загрузке возникли проблемы:</p>
				<?php echo Html::ul($arrErrors) ?>
			</div>
		<?php endif ?>

	<?php endif ?>


	<!-- Неиспользованные картинки -->
	<div class="row">
		<?php foreach ($this->context->card->getImages(true)->all() as $modImage): ?>
			<div class="col-sm-3 col-md-3">
				<div class="thumbnail">
					<a href="#" class='photoswipe'>
						<?php echo Html::img($modImage->thumbnail(300, 300), ['width' => '300px', 'height' => '300px']) ?>
					</a>

					<div class="caption">
						<?php echo $modImage->marker ?>
						<div class="pull-right">
			            	<?php if (Yii::$app->user->can('cards/owner')) echo Html::a('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>', $this->context->to(['/cards/owner/image/delete', 'id' => $modImage->id]), ['data-confirm' => 'Точно?', 'data-method' => 'post']) ?>					
						</div>						
					</div>

				</div>
			</div>

			<?php $arrImages[] = [
				'src' => Yii::getAlias('@web/uploads/' . $modImage->file),
				'w' => $modImage->width,
				'h' => $modImage->height,
			] ?>
		<?php endforeach ?>		
	</div>


	<?php $id_image_previous = null ?>
	<?php foreach ($this->context->card->getTransfers()->with('objects.objectImages')->all() as $modTransfer): ?>	
		<?php $showTransfer = false ?>

		

		<?php foreach ($modTransfer->objects as $modObject): ?>

			<?php if ($modObject->objectImages): ?>
				<?php if (!$showTransfer): ?>
					<div id='transfer-<?php echo $modTransfer->id ?>' class="cards_text--header_transfer"><?php echo Html::encode($modTransfer->name) ?></div>
					<?php $showTransfer = true ?>
				<?php endif ?>

				<div id='object-<?php echo $modObject->id ?>' class="cards_text--header_object"><?php echo Html::encode($modObject->name) ?></div>			
			<?php endif ?>
			
			<div class="row">
				<?php foreach ($modObject->objectImages as $modObjectImage): ?>
					


					<?php $modImage = $modObjectImage->image ?>
					<?php if ($modImage->id != $id_image_previous): ?>

						<div class="col-sm-3 col-md-3">
							<div class="thumbnail">
								<a href="#" class='photoswipe'>
									<?php echo Html::img($modImage->thumbnail(300, 300)) ?>
								</a>

								<div class="caption">
									<?php echo $modImage->marker ?>
								</div>

							</div>
						</div>

						<?php $arrImages[] = [
							'src' => Yii::getAlias('@web/uploads/' . $modImage->file),
							'w' => $modImage->width,
							'h' => $modImage->height,
							'title' => Html::encode($modObjectImage->comment),
						] ?>

					<?php endif ?>

					<?php $id_image_previous = $modImage->id ?>
				<?php endforeach ?>
			</div>
			
		<?php endforeach ?>
	<?php endforeach ?>


	<?php echo \app\widgets\photoswipe\Photoswipe::widget([
		'images' => $arrImages,
	]) ?>

	<script>
		$(function ($) {
			$(document).on('submit', '#form-image-upload', function() {
				$('.form-image-upload--submit').html('Загружаю...');

				return true;
			})
		});
	</script>