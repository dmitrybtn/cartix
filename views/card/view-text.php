<?php

use yii\helpers\Html;
use app\widgets\GallereyModal;

?>

<?php $this->beginContent('@app/views/card/view.php', ['modCard' => $modCard]) ?>

	<div class="card">

		<?php $arrImages = [] ?>
		<?php foreach ($modCard->getTransfers()->with('objects')->all() as $modTransfer): ?>

			<?php echo Html::a('asdfasdf', '', ['name' => 'transfer-' . $modTransfer->id, 'style' => 'position: absolute; display: block; top: -48px;']) ?>
			<div class="transfer--header" style='position: relative;'>
				<?php echo Html::encode($modTransfer->name) ?>		
			</div>

			<?php foreach ($modTransfer->objects as $modObject): ?>

				<div class="object--header" style='position: relative;'>
					<?php echo Html::a('', '', ['name' => 'object-' . $modObject->id, 'style' => 'position: absolute; display: block; top: -48px;']) ?>

					<?php echo Html::encode($modObject->name) ?>						
				</div>
				
				<?php if ($modObject->text): ?>
					<div class="object--text">
						<?php echo Yii::$app->formatter->asHtml($modObject->textParsed) ?>
					</div>
				<?php endif ?>


				<?php foreach ($modObject->objectImages as $modObjectImage) {
					$arrImages[] = [
						'src' => Yii::getAlias('@web/uploads/' . $modObjectImage->image->file),
						'width' => $modObjectImage->image->width,
						'height' => $modObjectImage->image->height,
					];
				} ?>
			<?php endforeach ?>

			
		<?php endforeach ?>
		

	</div>

	<?php echo GallereyModal::widget([
		'selector' => '.lightbox',
	    'images' => $arrImages,
	    'clientOptions' => [
	    	'bgOpacity' => 0.9,
	    	'spacing' => 0.9,

			'closeEl' => true,
			'captionEl' => false,
			'fullscreenEl' => false,
			'zoomEl' => true,
			'shareEl' => false,
			'counterEl' => true,
			'arrowEl' => true,
			'preloaderEl' => true,

	    ]
	]) ?>


<?php $this->endContent() ?>

