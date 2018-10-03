<?php

	use yii\helpers\Html;
	use dmitrybtn\cp\ActiveForm;

	use app\modules\cards\models\CardTransfer;
?>

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Новая остановка</h4>
	</div>

	<?php $form = ActiveForm::begin([
		'id' => 'card-transfer-form-create',
		'action' => $this->context->to(['/cards/owner/transfer/ajax-create']),
		'options' => ['class' => 'cards_plan_ajax_form'],
		'enableClientScript' => false,
		'enableClientValidation' => false,
		'enableAjaxValidation' => false,
		'validateOnBlur' => false,
		'validateOnChange' => false,
	]); ?>


	<div class="modal-body">
		<?php echo $this->render('@app/modules/cards/views/owner/transfer/form-inputs', ['modTransfer' => $modTransfer ?? new CardTransfer, 'form' => $form]) ?>
	</div>
	<div class="modal-footer">
		<?php echo Html::a('Отменить', '#', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
		<?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
	</div>

	<?php ActiveForm::end(); ?>

							


