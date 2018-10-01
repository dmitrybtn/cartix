<?php

	use yii\helpers\Html;
	use dmitrybtn\cp\ActiveForm;

?>

	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		<h4 class="modal-title" id="myModalLabel">Редактирование объекта</h4>
	</div>

	<?php $form = ActiveForm::begin([
		'id' => 'card-object-form-' . $modObject->id,
		'action' => $this->context->to(['/cards/one/object/ajax-update', 'id' => $modObject->id]),
		'options' => ['class' => 'cards_plan_ajax_form'],
		'enableClientScript' => false,
		'enableClientValidation' => false,
		'enableAjaxValidation' => false,
		'validateOnBlur' => false,
		'validateOnChange' => false,
	]); ?>


	<div class="modal-body">
		<?php echo $this->render('@app/modules/cards/views/one/object/form-inputs', ['modObject' => $modObject, 'form' => $form]) ?>
	</div>
	<div class="modal-footer">

		<?php echo Html::a('Удалить объект', $this->context->to(['/cards/one/object/ajax-delete', 'id' => $modObject->id]), ['class' => 'cards_plan_ajax_delete btn btn-danger pull-left']) ?>


		<?php echo Html::a('Отменить', '#', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) ?>
		<?php echo Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
	</div>

	<?php ActiveForm::end(); ?>

							


