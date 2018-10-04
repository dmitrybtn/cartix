<?php

	namespace app\modules\cards\views\one\view;

	use Yii;

	use yii\helpers\{Html, Url};
	use yii\widgets\Pjax;

	use dmitrybtn\cp\ActiveForm;

?>

		<!-- Остановки -->
		<ul class='cards_plan hidden-xs'>
			<?php foreach ($this->context->transfers as $modTransfer): ?>
				<li class='cards_plan_transfer' data-id-transfer='<?php echo $modTransfer->id ?>'>

					<?php echo Html::a(Html::encode($modTransfer->name), $this->context->to(['/cards/view/text', '#' => 'scroll-transfer-' . $modTransfer->id]), ['class' => 'cards_plan_transfer--header']) ?>


					<?php if (Yii::$app->user->can('cards/owner')): ?>
						<div>
							<?php echo Html::a('[Редактировать]', '#', ['class' => 'cards_plan--option', 'data-toggle' => 'modal', 'data-target' => '.cards_plan_transfer--modal-' . $modTransfer->id]) ?>
							<?php echo Html::a('[Добавить объект]', '#', ['class' => 'cards_plan--option', 'data-toggle' => 'modal', 'data-target' => '.cards_plan_object--modal-create-' . $modTransfer->id]) ?>
							<?php echo Html::a('[Удалить]', $this->context->to(['/cards/owner/transfer/ajax-delete', 'id' => $modTransfer->id]), ['class' => 'cards_plan--option cards_plan_ajax_delete']) ?>							
							<?php echo Html::a('[Переместить]', '#', ['class' => 'cards_plan--option cards_plan--sort']) ?>						
						</div>

						<!-- Остановка в модальном окне -->
						<div class="modal cards_plan_transfer--modal cards_plan_transfer--modal-<?= $modTransfer->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<?php echo $this->render('@app/modules/cards/views/owner/transfer/form-modal-update', ['modTransfer' => $modTransfer]) ?>
								</div>
							</div>
						</div>
					<?php endif ?>


					<!-- Объекты -->
					<ul class='cards_plan_objects' data-id-transfer='<?php echo $modTransfer->id ?>'>
						<?php foreach ($modTransfer->objects as $modObject): ?>
							<li class='cards_plan_object' data-id-object='<?php echo $modObject->id ?>'>

								<?php echo Html::a(Html::encode($modObject->name), $this->context->to(['/cards/view/text', '#' => 'scroll-object-' . $modObject->id]), ['class' => 'cards_plan_object--header']) ?>
								
								<div><?php echo Html::encode($modObject->annotation) ?></div>	

								<?php if (Yii::$app->user->can('cards/owner')): ?>
									<div>
										<?php echo Html::a('[Редактировать]', '#', ['class' => 'cards_plan--option', 'data-toggle' => 'modal', 'data-target' => '.cards_plan_object--modal-' . $modObject->id]) ?>
										<?php echo Html::a('[Удалить]', $this->context->to(['/cards/owner/object/ajax-delete', 'id' => $modObject->id]), ['class' => 'cards_plan--option cards_plan_ajax_delete']) ?>							
										<?php echo Html::a('[Переместить]', '#', ['class' => 'cards_plan--option cards_plan--sort']) ?>						
									</div>

									<!-- Объект в модальном окне -->
									<div class="modal cards_plan_object--modal cards_plan_object--modal-<?php echo $modObject->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
										<div class="modal-dialog modal-lg" role="document">
											<div class="modal-content">
												<?php echo $this->render('@app/modules/cards/views/owner/object/form-modal-update', ['modObject' => $modObject]) ?>
											</div>
										</div>
									</div>
								<?php endif ?>

							</li>
						<?php endforeach ?>
					</ul>

					<!-- Создание объекта -->					
					<?php if (Yii::$app->user->can('cards/owner')): ?>

						<div class="modal cards_plan_object--modal cards_plan_object--modal-create-<?php echo $modTransfer->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
							<div class="modal-dialog modal-lg" role="document">
								<div class="modal-content">
									<?php echo $this->render('@app/modules/cards/views/owner/object/form-modal-create', ['modTransfer' => $modTransfer]) ?>
								</div>
							</div>
						</div>						
					<?php endif ?>


				</li>

			<?php endforeach ?>
		</ul>		

		<!-- Создание остановки -->
		<?php if (Yii::$app->user->can('cards/owner')): ?>
			<div class="modal cards_plan_transfer--modal cards_plan_transfer--modal-create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<?php echo $this->render('@app/modules/cards/views/owner/transfer/form-modal-create') ?>
					</div>
				</div>
			</div>
		<?php endif ?>

		<!-- Мобильная версия -->

		<div class="visible-xs-block cards_plan-mobile">
			<?php foreach ($this->context->card->transfers as $modTransfer): ?>
				<div class="well_list-plan well_list well_list-1 <?php if (Yii::$app->user->can('cards/owner')) echo 'cards_plan-mobile--item-options' ?>">

					<?php echo Html::a(Html::encode($modTransfer->name), $this->context->to(['/cards/view/text', '#' => 'scroll-transfer-' . $modTransfer->id])) ?>


					<?php if (Yii::$app->user->can('cards/owner')): ?>
						<div class='cards_plan-mobile--item_options_block'>
							<div class="dropdown">
								<a href="#" data-toggle="dropdown" class="dropdown-toggle">
									<span class="glyphicon glyphicon-menu-down"></span>
								</a>

								<ul class="dropdown-menu">
									<li><?php echo Html::a('Добавить объект', $this->context->to(['/cards/owner/object/create', 'id' => $modTransfer->id])) ?></li>
									<li><?php echo Html::a('Редактировать', $this->context->to(['/cards/owner/transfer/update', 'id' => $modTransfer->id])) ?></li>
									<li><?php echo Html::a('Передвинуть выше', $this->context->to(['/cards/owner/transfer/sort', 'id' => $modTransfer->id]), ['class' => 'cards_plan_ajax_link']) ?></li>
									<li><?php echo Html::a('Передвинуть ниже', $this->context->to(['/cards/owner/transfer/sort', 'id' => $modTransfer->id, 'inv' => 1]), ['class' => 'cards_plan_ajax_link']) ?></li>
									<li><?php echo Html::a('Удалить', $this->context->to(['/cards/owner/transfer/ajax-delete', 'id' => $modTransfer->id]), ['class' => 'cards_plan_ajax_delete']) ?></li>
								</ul>						
							</div>
						</div>					
					
					<?php endif ?>


				</div>

				<?php foreach ($modTransfer->objects as $modObject): ?>
					<div class="well_list-plan well_list well_list-2 <?php if (Yii::$app->user->can('cards/owner')) echo 'cards_plan-mobile--item-options' ?>">

						<?php if (Yii::$app->user->can('cards/owner')): ?>
							<div class='cards_plan-mobile--item_options_block'>
								<div class="dropdown">
									<a href="#" data-toggle="dropdown" class="dropdown-toggle">
										<span class="glyphicon glyphicon-menu-down"></span>
									</a>

									<ul class="dropdown-menu pull-right">
										<li><?php echo Html::a('Редактировать', $this->context->to(['/cards/owner/object/update', 'id' => $modObject->id])) ?></li>
										<li><?php echo Html::a('Передвинуть выше', $this->context->to(['/cards/owner/object/sort', 'id' => $modObject->id]), ['class' => 'cards_plan_ajax_link']) ?></li>
										<li><?php echo Html::a('Передвинуть ниже', $this->context->to(['/cards/owner/object/sort', 'id' => $modObject->id, 'inv' => 1]), ['class' => 'cards_plan_ajax_link']) ?></li>
										<li><?php echo Html::a('Удалить', $this->context->to(['/cards/owner/object/ajax-delete', 'id' => $modObject->id]), ['class' => 'cards_plan_ajax_delete']) ?></li>
									</ul>						
								</div>
							</div>
						<?php endif ?>

						<?php echo Html::a(Html::encode($modObject->name), $this->context->to(['/cards/view/text', '#' => 'scroll-object-' . $modObject->id])) ?>							
					
							<div class="cards_plan-mobile--item_info">
								<?php echo Html::encode($modObject->annotation) ?>
							</div>						

					</div>				
				<?php endforeach ?>
			<?php endforeach ?>			
		</div>

   
	<?php if (Yii::$app->user->can('cards/owner')): ?>
		<script>
			$(document).ready(function(){

				// Сортировка остановок
		        $(".cards_plan").sortable({
		            handle: '.cards_plan--sort',
		            cursor: 'move',
		            update: function(event, ui) {
				        
		            	var self = $(this);

				        $.ajax({
				            'type': 'GET',
				            'url': '<?php echo Url::to($this->context->to(['/cards/owner/transfer/replace'])) ?>',
				            'data': {id_transfer: ui.item.attr('data-id-transfer'), index: ui.item.index()},
				            'cache': false,
				            'success':function(html){
				                // refreshPlan();	                
				            }       
				        });
		            },
		        });

		        // Сортировка объектов
		        $(".cards_plan_objects").sortable({
		            dropOnEmpty: true,
		            connectWith: ".cards_plan_objects",
		            handle: '.cards_plan--sort',
		            update: function(event, ui) {
		            	if (ui.sender == null) {
		            		
		            		var self = $(this);

		            		var data = {
				            	id_object: ui.item.attr('data-id-object'),
				            	id_transfer: ui.item.closest('ul').attr('data-id-transfer'),
				            	index: ui.item.index()
				            };

					        $.ajax({
					            'type': 'GET',
					            'url': '<?php echo Url::to($this->context->to(['/cards/owner/object/replace'])) ?>',
					            'data': data,
					            'cache': false,
					            'success':function(){
					                // refreshPlan();	                
					            }       
					        });	            		
		            	}
		            }	            
		        });
			});
		</script>
	<?php endif ?>
