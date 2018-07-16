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
		'returnUrl' => $returnUrl,	
	]); ?>

		<?php echo $form->field($modCard, 'name')->textInput(['maxlength' => true]) ?>
		<?php echo $form->field($modCard, 'map')->textInput(['maxlength' => true]) ?>
		
		<?php echo $form->controls() ?>
	<?php ActiveForm::end(); ?>
</div>
