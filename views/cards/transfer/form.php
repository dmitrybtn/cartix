<?php 
	use dmitrybtn\cp\Html;
	use dmitrybtn\cp\ActiveForm;
?>

<div class="form-autofocus">
	<?php $form = ActiveForm::begin([
		'id' => 'card-transfer-form',
		'enableClientValidation' => false,
		'enableAjaxValidation' => true,
		'validateOnBlur' => false,
		'validateOnChange' => false,
	]); ?>

		<div class="row">
			<div class="col-md-9"><?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?></div>
			<div class="col-md-3"><?php echo $form->field($model, 'time')->textInput() ?></div>
		</div>

		<?php echo $form->field($model, 'instruction')->textarea(['rows' => 4, 'placeholder' => 'Указания по организации перехода к данной точке']) ?>
		
		<?php echo $form->controls($returnUrl) ?>
	<?php ActiveForm::end(); ?>
</div>