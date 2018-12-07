
<div class="row">
	<div class="col-md-9"><?php echo $form->field($modTransfer, 'name')->textInput(['maxlength' => true]) ?></div>
	<div class="col-md-3"><?php echo $form->field($modTransfer, 'time')->textInput() ?></div>
</div>

<?php echo $form->field($modTransfer, 'annotation')->textarea(['rows' => 4, 'placeholder' => 'Суть рассказа на точке. Логический переход. Методические указания.']) ?>

