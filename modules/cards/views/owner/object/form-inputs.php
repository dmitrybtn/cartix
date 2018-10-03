	<div class="row">
		<div class="col-md-10"><?php echo $form->field($modObject, 'name')->textInput(['maxlength' => true]) ?></div>
		<div class="col-md-2"><?php echo $form->field($modObject, 'time')->textInput() ?></div>
	</div>

	<?php echo $form->field($modObject, 'annotation')->textarea(['rows' => 4, 'placeholder' => 'Краткое описание объекта, логический переход']) ?>
	<?php echo $form->field($modObject, 'instruction')->textarea(['rows' => 4, 'placeholder' => 'Как расположить группу? Куда смотреть?']) ?>
