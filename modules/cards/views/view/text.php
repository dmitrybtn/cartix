<?php

use yii\helpers\Html;

?>

<?php $arrImages = [] ?>

<div class="cards_layout_text">
	<?php foreach ($this->context->transfers as $modTransfer): ?>
		

			<div id='transfer-<?php echo $modTransfer->id ?>' class="cards_text--header_transfer">
				<?php echo $this->context->a(Html::encode($modTransfer->name), $this->context->to(['/cards/owner/transfer/update', 'id' => $modTransfer->id])) ?>		
			</div>

			<?php if ($modTransfer->instruction): ?>
				<div class="cards_text--instruction text-muted">
					<?php echo Yii::$app->formatter->asHtml($modTransfer->instruction) ?>
				</div>
			<?php endif ?>

			<?php foreach ($modTransfer->objects as $modObject): ?>

				<div id='object-<?php echo $modObject->id ?>' class="cards_text--header_object">
					<?php echo $this->context->a(Html::encode($modObject->name), $this->context->to(['/cards/owner/object/update', 'id' => $modObject->id])) ?>
				</div>

				<?php if ($modObject->instruction): ?>
					<div class="cards_text--instruction text-muted">
						<?php echo Yii::$app->formatter->asHtml($modObject->instruction) ?>
					</div>
				<?php endif ?>

				
				<?php if ($modObject->text): ?>
					<div class="cards_text--text">
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
