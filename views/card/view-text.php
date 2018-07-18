<?php

use yii\helpers\Html;

?>

<?php $this->beginContent('@app/views/card/view.php', ['modCard' => $modCard]) ?>

	<div class="card">

		<?php foreach ($modCard->getTransfers()->with('objects')->all() as $modTransfer): ?>
			<div class="transfer--header"><?php echo Html::encode($modTransfer->name) ?></div>

			<?php foreach ($modTransfer->objects as $modObject): ?>
				<div class="object--header"><?php echo Html::encode($modObject->name) ?></div>
				
				<?php if ($modObject->text): ?>
					<div class="object--text">
						<?php echo Yii::$app->formatter->asHtml($modObject->textParsed) ?>
					</div>
				<?php endif ?>

			<?php endforeach ?>

			
		<?php endforeach ?>
		

	</div>


<?php $this->endContent() ?>

