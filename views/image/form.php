<?php 
	use dmitrybtn\cp\Html;
	use dmitrybtn\cp\ActiveForm;
?>

<div class="form-autofocus">
	<?php $form = ActiveForm::begin([
		'id' => 'card-image-form',
		'enableClientValidation' => false,
		'enableAjaxValidation' => true,
		'validateOnBlur' => false,
		'validateOnChange' => false,
		'returnUrl' => $returnUrl,	
	]); ?>

		<?php echo $form->field($modCardImage, 'id_card')->textInput() ?>
		<?php echo $form->field($modCardImage, 'id_sort')->textInput() ?>
		<?php echo $form->field($modCardImage, 'name')->textInput(['maxlength' => true]) ?>
		<?php echo $form->field($modCardImage, 'url')->textInput(['maxlength' => true]) ?>
		<?php echo $form->field($modCardImage, 'file')->textInput(['maxlength' => true]) ?>
		<?php echo $form->field($modCardImage, 'description')->textarea(['rows' => 6]) ?>
		
		<?php echo $form->controls() ?>
	<?php ActiveForm::end(); ?>
</div>
