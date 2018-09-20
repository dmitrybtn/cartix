<?php

	namespace app\modules\cards\views\layouts;

	use Yii;

	use yii\helpers\{Html, Url};
	use yii\bootstrap\BootstrapPluginAsset;

	use app\modules\cards\models\CardTransfer;
?>


<style>

	
	.card_layout_plan li > a {padding: 5px 15px;}

	.card_layout_plan--layout {height: calc(100vh - 210px); overflow-x: visible !important; overflow-y: scroll;}
	.card_layout_plan--object {padding-left: 20px !important;}
	.card_layout_plan--create_object {float: left; margin-bottom: -30px; display: block;}



</style>





<div class='card_layout_plan--layout' >

	<nav id='card_layout_nav'>
		
		<ul class='nav nav-stacked nav-pills card_layout_plan'>
	  		<?php foreach ($this->context->card->transfers as $modTransfer): ?>
	  			
	  			<li class='card_layout_plan--transfer'>
	  				<?php echo Html::a(Html::encode($modTransfer->name), '#transfer-' . $modTransfer->id) ?>
	  			</li>

				<?php if ($modTransfer->objects): ?>
		  				<?php foreach ($modTransfer->objects as $modObject): ?>
		  					<li class='card_layout_plan--object'>
		  						<?php echo Html::a(Html::encode($modObject->name), '#object-' . $modObject->id) ?>
		  					</li>
		  				<?php endforeach ?>							
					
				<?php endif ?>

	  		<?php endforeach ?>
		</ul>
	</nav>

	<?php if (0): ?>
				

		<table class='table table-striped table-bordered table-condensed'>
			<?php foreach ($this->context->card->transfers as $modTransfer): ?>
				<tr>
		


					<td class='action-column action-column-1'>
						<div class="dropdown">
							<a href="#" data-toggle="dropdown" class="dropdown-toggle"><span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span></a>

							<ul class="dropdown-menu">
								<li><?php echo Html::a('Добавить объект', $this->context->to(['/cards/one/object/create', 'id' => $modTransfer->id])) ?></li>
								<li><?php echo Html::a('Редактировать', $this->context->to(['/cards/one/transfer/update', 'id' => $modTransfer->id])) ?></li>
								<li><?php echo Html::a('Передвинуть выше', $this->context->to(['/cards/one/transfer/sort', 'id' => $modTransfer->id])) ?></li>
								<li><?php echo Html::a('Передвинуть ниже', $this->context->to(['/cards/one/transfer/sort', 'id' => $modTransfer->id, 'inv' => 1])) ?></li>
								<li><?php echo Html::a('Удалить', $this->context->to(['/cards/one/transfer/delete', 'id' => $modTransfer->id]), ['data-confirm' => 'Точно?', 'data-method' => 'post']) ?></li>
							</ul>						
						</div>			
					</td>

					<td class="card_layout_plan--transfer">
						<?php echo Html::a(Html::encode($modTransfer->name), '#transfer-' . $modTransfer->id) ?>
					</td>

				</tr>


					<?php foreach ($modTransfer->objects as $modObject): ?>

						<tr>

							<td class='action-column action-column-1'>

								<div class="dropdown">
									<a href="#" data-toggle="dropdown" class="dropdown-toggle"><span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span></a>

									<ul class="dropdown-menu">
										<li><?php echo Html::a('Редактировать', $this->context->to(['/cards/one/object/update', 'id' => $modObject->id])) ?></li>
										<li><?php echo Html::a('Передвинуть выше', $this->context->to(['/cards/one/object/sort', 'id' => $modObject->id])) ?></li>
										<li><?php echo Html::a('Передвинуть ниже', $this->context->to(['/cards/one/object/sort', 'id' => $modObject->id, 'inv' => 1])) ?></li>
										<li><?php echo Html::a('Удалить', $this->context->to(['/cards/one/object/delete', 'id' => $modObject->id], ['data-confirm' => 'Точно?', 'data-method' => 'post'])) ?></li>
									</ul>						
								</div>

							</td>


							<td class="card_layout_plan--object">
								<?php echo Html::encode($modObject->name) ?>
							</td>


						</tr>			
					<?php endforeach ?>

				<?php endforeach ?>		
		</table>

	<?php endif ?>		

</div>

<?php echo Html::a('Добавить остановку', $this->context->to(['/cards/one/transfer/create']), ['class' => 'card_layout_plan--create_object']) ?>

