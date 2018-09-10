<?php 
	use dmitrybtn\cp\Html;
	use dmitrybtn\cp\ActiveForm;
?>

<div class="form-autofocus">
	<?php $form = ActiveForm::begin([
		'id' => 'card-form',
		'enableClientValidation' => false,
		'enableAjaxValidation' => true,
		'validateOnBlur' => false,
		'validateOnChange' => false,
	]); ?>

		<?php echo $form->field($this->context->card, 'name')->textInput(['maxlength' => true]) ?>
		<?php echo $form->field($this->context->card, 'map')->textInput(['maxlength' => true]) ?>
		
		<?php echo $form->controls($returnUrl) ?>
	<?php ActiveForm::end(); ?>
</div>
