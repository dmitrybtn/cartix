
		<div class="row">
			<div class="col-md-9"><?php echo $form->field($modTransfer, 'name')->textInput(['maxlength' => true]) ?></div>
			<div class="col-md-3"><?php echo $form->field($modTransfer, 'time')->textInput() ?></div>
		</div>

		<?php echo $form->field($modTransfer, 'instruction')->textarea(['rows' => 4, 'placeholder' => 'Указания по организации перехода к данной точке']) ?>
		
