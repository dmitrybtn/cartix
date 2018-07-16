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
		'returnUrl' => $returnUrl,	
	]); ?>

		<div class="row">
			<div class="col-md-10"><?php echo $form->field($modCardTransfer, 'name')->textInput(['maxlength' => true]) ?></div>
			<div class="col-md-2"><?php echo $form->field($modCardTransfer, 'time')->textInput() ?></div>
		</div>

		<?php echo $form->field($modCardTransfer, 'instruction')->textarea(['rows' => 4]) ?>
		
		<?php echo $form->controls() ?>
	<?php ActiveForm::end(); ?>
</div>
