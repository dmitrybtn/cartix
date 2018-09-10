<?php

use yii\helpers\Html;

?>



<?php $this->beginContent('@app/views/cards/card/view.php', ['model' => $this->context->card]) ?>

	<div class="card">

		<?php $arrImages = [] ?>
		<?php foreach ($this->context->card->getTransfers()->with('objects', 'objects.objectImages', 'objects.objectImages.image')->all() as $modTransfer): ?>

			<?php echo Html::a('', '', ['name' => 'transfer-' . $modTransfer->id, 'style' => 'position: absolute; display: block; top: -48px;']) ?>
			<div class="card_text--header_transfer" style='position: relative;'>
				<?php echo Html::encode($modTransfer->name) ?>		
			</div>

			<?php if ($modTransfer->instruction): ?>
				<div class="card_text--instruction text-muted">
					<?php echo Yii::$app->formatter->asHtml($modTransfer->instruction) ?>
				</div>
			<?php endif ?>

			<?php foreach ($modTransfer->objects as $modObject): ?>

				<div class="card_text--header_object" style='position: relative;'>
					<?php echo Html::a('', '', ['name' => 'object-' . $modObject->id, 'style' => 'position: absolute; display: block; top: -48px;']) ?>

					<?php echo Html::encode($modObject->name) ?>
					
					<?php if ($this->context->card->isMy): ?>
						<span class='pull-right card_text--instruction text-muted'>
							<?php echo Html::a('<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>', ['/object/update', 'id' => $modObject->id], ['class' => 'update']) ?>
						</span>
					<?php endif ?>

				</div>

				<?php if ($modObject->instruction): ?>
					<div class="card_text--instruction text-muted">
						<?php echo Yii::$app->formatter->asHtml($modObject->instruction) ?>
					</div>
				<?php endif ?>

				
				<?php if ($modObject->text): ?>
					<div class="card_text--text">
						<?php echo Yii::$app->formatter->asHtml($modObject->textParsed) ?>
					</div>
				<?php endif ?>


				<?php foreach ($modObject->objectImages as $modObjectImage) {
					$arrImages[] = [
						'src' => Yii::getAlias('@web/uploads/' . $modObjectImage->image->file),
						'w' => $modObjectImage->image->width,
						'h' => $modObjectImage->image->height,
						'title' => Html::encode($modObjectImage->comment),
					];
				} ?>

			<?php endforeach ?>
		<?php endforeach ?>
	</div>

	
	<?php echo \app\widgets\photoswipe\Photoswipe::widget([
		'images' => $arrImages,
	]) ?>

<?php $this->endContent() ?>

