<?php 
	use dmitrybtn\cp\Html;
	use dmitrybtn\cp\ActiveForm;

	use yii\helpers\Url;

?>

<div class="form-autofocus">
	<?php $form = ActiveForm::begin([
		'id' => 'card-transfer-form',
		'enableClientValidation' => false,
		'enableAjaxValidation' => true,
		'validateOnBlur' => false,
		'validateOnChange' => false,
	]); ?>

		<?php echo $this->render('form-inputs', ['modTransfer' => $model, 'form' => $form]) ?>


		<?php echo $form->controls($returnUrl) ?>



		
	<?php ActiveForm::end(); ?>
</div>
