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

		<div class="row">
			<div class="col-md-9"><?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?></div>
			<div class="col-md-3"><?php echo $form->field($model, 'time')->textInput() ?></div>
		</div>

		<?php echo $form->field($model, 'instruction')->textarea(['rows' => 4, 'placeholder' => 'Указания по организации перехода к данной точке']) ?>
		


		<?php echo Html::hiddenInput('returnUrl', Url::to($returnUrl)) ?>

		<?php if (YII_ENV_TEST): ?>
			<?php echo Html::submitButton('Сохранить') ?>
		<?php endif ?>

		<!-- Опции для телефонов -->
		<?php $this->beginBlock('footer') ?>
			<div class="visible-xs-block" style='height: 52px;'></div>

			<footer class='footer-mobile' style='height: 52px;'>
				<div class="container-fluid" style='padding-top: 7px; padding-bottom: 7px;'>
					<div class="row visible-xs-block visible-sm-block" id='<?php echo $this->context->id . '__controls-mobile' ?>'>
						<div class="col-xs-6"><?php echo $strCancel = Html::a('Отменить', $returnUrl, ['class' => 'btn btn-default btn-block']) ?></div>
						<div class="col-xs-6"><?php echo $strSubmit = Html::submitButton('Сохранить', ['class' => 'btn btn-success btn-block', 'form' => 'card-transfer-form']) ?></div>
					</div>			
				</div>	
			</footer>
		<?php $this->endBlock() ?>

		<!-- Опции для десктопов -->
		<?php $this->beginBlock('header-options'); ?>

			<div style='float: right;'>
				<?php echo Html::a('Отменить', $returnUrl, ['style' => 'width: 120px;', 'class' => 'btn btn-default']) ?>
				<?php echo Html::submitButton('Сохранить', ['style' => 'width: 120px;', 'class' => 'btn btn-success', 'form' => 'card-transfer-form']) ?>				
			</div>

		<?php $this->endBlock(); ?>


		
	<?php ActiveForm::end(); ?>
</div>
