<?php 
	use dmitrybtn\cp\Html;
	use dmitrybtn\cp\ActiveForm;
?>

<div class="form-autofocus">
	<?php $form = ActiveForm::begin([
		'id' => 'user-form',
		'enableClientValidation' => false,
		'enableAjaxValidation' => true,
		'validateOnBlur' => false,
		'validateOnChange' => false,
	]); ?>

		<?php if ($model->isAttributeActive('name')): ?>

			<div class="row">
				<div class="col-md-6"><?php echo $form->field($model, 'surname')->textInput(['maxlength' => true]) ?></div>
				<div class="col-md-6"><?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?></div>				
			</div>			

		
			<?php echo $form->field($model, 'email')->textInput(['maxlength' => true]) ?>			
		<?php endif ?>

		<?php if ($model->isAttributeActive('id_role')): ?>
			<?php echo $form->field($model, 'id_role')->dropDownList(Yii::$app->authManager->roleNames) ?>
		<?php endif ?>


		<?php if ($model->isAttributeActive('password')): ?>
			<div class="row">
				<div class="col-md-6"><?php echo $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?></div>
				<div class="col-md-6"><?php echo $form->field($model, 'confirm')->passwordInput(['maxlength' => true]) ?></div>				
			</div>			
		<?php endif ?>


	
		<?php echo $form->controls($returnUrl) ?>
	<?php ActiveForm::end(); ?>
</div>
