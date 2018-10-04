<?php

use yii\helpers\Html;

?>

<div class="cards_layout_text">
	<?php foreach ($this->context->transfers as $modTransfer): ?>
		<?php $showTransfer = true ?>


			<?php foreach ($modTransfer->objects as $modObject): ?>
				<?php $showObject = true ?>

				<?php foreach ($modObject->quotes as $strQuote): ?>
					

					<?php if ($showTransfer): ?>
						<div id='transfer-<?php echo $modTransfer->id ?>' class="cards_text--header_transfer">
							<?php echo $this->context->a(Html::encode($modTransfer->name), $this->context->to(['/cards/owner/transfer/update', 'id' => $modTransfer->id])) ?>		
						</div>					
						<?php $showTransfer = false ?>
					<?php endif ?>

					<?php if ($showObject): ?>
						<div id='object-<?php echo $modObject->id ?>' class="cards_text--header_object">
							<?php echo $this->context->a(Html::encode($modObject->name), $this->context->to(['/cards/owner/object/update', 'id' => $modObject->id])) ?>
						</div>						
						<?php $showObject = false ?>
					<?php endif ?>


					<?php echo $strQuote ?>
				<?php endforeach ?>

			<?php endforeach ?>

	<?php endforeach ?>	
</div>