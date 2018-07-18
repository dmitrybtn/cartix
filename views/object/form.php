<?php 
	use dmitrybtn\cp\Html;
	use dmitrybtn\cp\ActiveForm;

	use vova07\imperavi\Widget as Imperavi;
?>

<div class="form-autofocus">
	<?php $form = ActiveForm::begin([
		'id' => 'card-object-form',
		'enableClientValidation' => false,
		'enableAjaxValidation' => true,
		'validateOnBlur' => false,
		'validateOnChange' => false,
		'returnUrl' => $returnUrl,	
	]); ?>

	<div class="row">
		<div class="col-md-10"><?php echo $form->field($modCardObject, 'name')->textInput(['maxlength' => true]) ?></div>
		<div class="col-md-2"><?php echo $form->field($modCardObject, 'time')->textInput() ?></div>
	</div>

		<?php echo $form->field($modCardObject, 'text')->widget(Imperavi::className(), [
			'settings' => [
				'minHeight' => 300,
				'buttons' =>  ['html',  'formatting',  'bold',  'italic',  'unorderedlist',  'orderedlist',  'link'],
				'formatting' => ['p'],
				'formattingAdd' => [
					[
						'tag' => 'p',
						'title' => 'Заголовок',
						'class' => 'header',
					]

				]
			]
		]) ?>

		<?php echo $form->field($modCardObject, 'instruction')->textarea(['rows' => 6]) ?>
		
		<?php echo $form->controls() ?>
	<?php ActiveForm::end(); ?>
</div>


 