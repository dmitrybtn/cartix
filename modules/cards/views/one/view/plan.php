<?php

	namespace app\modules\cards\views\one\view;

	use Yii;

	use yii\helpers\{Html, Url};
	use yii\widgets\Pjax;

	use dmitrybtn\cp\ActiveForm;

?>

		<!-- Остановки -->
		<ul class='cards_plan_transfers hidden-xs'>
			<?php foreach ($this->context->transfers as $modTransfer): ?>
				<li class='cards_plan_transfer' data-id-transfer='<?php echo $modTransfer->id ?>'>

					<?php echo Html::a(Html::encode($modTransfer->name), '#', ['class' => 'cards_plan_transfer--header', 'data-toggle' => 'modal', 'data-target' => '.cards_plan_transfer--modal-' . $modTransfer->id]) ?>

					<!-- Остановка в модальном окне -->
					<div class="modal cards_plan_transfer--modal cards_plan_transfer--modal-<?= $modTransfer->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<?php echo $this->render('@app/modules/cards/views/one/transfer/form-modal-update', ['modTransfer' => $modTransfer]) ?>
							</div>
						</div>
					</div>

					<!-- Объекты -->
					<ul class='cards_plan_objects' data-id-transfer='<?php echo $modTransfer->id ?>'>
						<?php foreach ($modTransfer->objects as $modObject): ?>
							<li class='cards_plan_object' data-id-object='<?php echo $modObject->id ?>'>
								<?php echo Html::a(Html::encode($modObject->name), '#', ['class' => 'cards_plan_object--header', 'data-toggle' => 'modal', 'data-target' => '.cards_plan_object--modal-' . $modObject->id]) ?>
							
								<div>Текст брифа и прочее</div>	

								<!-- Объект в модальном окне -->
								<div class="modal cards_plan_object--modal cards_plan_object--modal-<?php echo $modObject->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
									<div class="modal-dialog modal-lg" role="document">
										<div class="modal-content">
											<?php echo $this->render('@app/modules/cards/views/one/object/form-modal-update', ['modObject' => $modObject]) ?>
										</div>
									</div>
								</div>
							</li>
						<?php endforeach ?>
					</ul>

					<!-- Создание объекта -->

					<?php echo Html::a('[Добавить объект]', '#', ['class' => 'text-muted cards_plan_object--create', 'data-toggle' => 'modal', 'data-target' => '.cards_plan_object--modal-create-' . $modTransfer->id]) ?>

					<div class="modal cards_plan_object--modal cards_plan_object--modal-create-<?php echo $modTransfer->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<?php echo $this->render('@app/modules/cards/views/one/object/form-modal-create', ['modTransfer' => $modTransfer]) ?>
							</div>
						</div>
					</div>
				</li>

			<?php endforeach ?>
		</ul>		

		<!-- Создание остановки -->
		<div class="modal cards_plan_transfer--modal cards_plan_transfer--modal-create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<?php echo $this->render('@app/modules/cards/views/one/transfer/form-modal-create') ?>
				</div>
			</div>
		</div>

	<!-- Мобильная версия -->
	<?php Pjax::begin() ?>

		<div class="visible-xs-block cards_plan_transfers-modal">
			<?php foreach ($this->context->card->transfers as $modTransfer): ?>
				<div class="well_list-plan well_list well_list-1 card_plan-mobile--transfer">

					<?php if ($this->context->card->isMy): ?>

						<div class="dropdown">
							<a href="#" data-toggle="dropdown" class="dropdown-toggle"><?php echo Html::encode($modTransfer->name) ?></a>

							<ul class="dropdown-menu">
								<li><?php echo Html::a('К тексту', $this->context->to(['/cards/one/view/text', 'id' => $this->context->card->id, '#' => 'transfer-' . $modTransfer->id])) ?></li>
								<li><?php echo Html::a('Добавить объект', $this->context->to(['/cards/one/object/create', 'id' => $modTransfer->id])) ?></li>
								<li><?php echo Html::a('Редактировать', $this->context->to(['/cards/one/transfer/update', 'id' => $modTransfer->id])) ?></li>
								<li><?php echo Html::a('Передвинуть выше', $this->context->to(['/cards/one/transfer/sort', 'id' => $modTransfer->id])) ?></li>
								<li><?php echo Html::a('Передвинуть ниже', $this->context->to(['/cards/one/transfer/sort', 'id' => $modTransfer->id, 'inv' => 1])) ?></li>
								<li><?php echo Html::a('Удалить', $this->context->to(['/cards/one/transfer/delete', 'id' => $modTransfer->id]), ['data-confirm' => 'Точно?', 'data-method' => 'post']) ?></li>
							</ul>						
						</div>
					
					<?php else: ?>
						<?php echo Html::a(Html::encode($modTransfer->name), $this->context->to(['/cards/one/view/text', '#' => 'transfer-' . $modTransfer->id])) ?>
					<?php endif ?>



						<div class="well_list--options">
							<?php if ($modTransfer->time): ?>
								Переход: <?php echo $modTransfer->time ?> мин.
							<?php endif ?>

							<?php if ($t = $modTransfer->objectsTime): ?>
								Рассказ: <?php echo $t ?> мин.
							<?php endif ?>
						</div>					
				</div>

				<?php foreach ($modTransfer->objects as $modObject): ?>
					<div class="well_list-plan well_list well_list-2 card_plan-mobile--object">

						<?php if ($this->context->card->isMy): ?>

							<div class="dropdown">
								<a href="#" data-toggle="dropdown" class="dropdown-toggle"><?php echo Html::encode($modObject->name) ?></a>

								<ul class="dropdown-menu">
									<li><?php echo Html::a('К тексту', $this->context->to(['/cards/one/view/text', '#' => 'object-' . $modObject->id])) ?></li>
									<li><?php echo Html::a('Редактировать', $this->context->to(['/cards/one/object/update', 'id' => $modObject->id])) ?></li>
									<li><?php echo Html::a('Передвинуть выше', $this->context->to(['/cards/one/object/sort', 'id' => $modObject->id])) ?></li>
									<li><?php echo Html::a('Передвинуть ниже', $this->context->to(['/cards/one/object/sort', 'id' => $modObject->id, 'inv' => 1])) ?></li>
									<li><?php echo Html::a('Удалить', $this->context->to(['/cards/one/object/delete', 'id' => $modObject->id], ['data-confirm' => 'Точно?', 'data-method' => 'post'])) ?></li>
								</ul>						
							</div>
						<?php else: ?>
							<?php echo Html::a(Html::encode($modObject->name), $this->context->to(['/cards/one/view/text', '#' => 'object-' . $modObject->id])) ?>							
						<?php endif ?>



						<div class="well_list--options">
							<?php if ($modObject->time): ?>
								Рассказ: <?php echo $modObject->time ?> мин.
							<?php endif ?>

							<?php if ($modObject->size): ?>
								Объем: <?php echo Yii::$app->formatter->asInteger($modObject->size) ?> зн.
							<?php endif ?>
						</div>						

					</div>				
				<?php endforeach ?>
			<?php endforeach ?>			
		</div>

	<?php Pjax::end() ?>

        
	<script>

		$(document).ready(function(){

			// Сортировка остановок
	        $(".cards_plan_transfers").sortable({
	            update: function(event, ui) {
			        
	            	var self = $(this);

			        $.ajax({
			            'type': 'GET',
			            'url': '<?php echo Url::to($this->context->to(['/cards/one/transfer/replace'])) ?>',
			            'data': {id_transfer: ui.item.attr('data-id-transfer'), index: ui.item.index()},
			            'cache': false,
			            'success':function(html){
			                refreshPlan();	                
			            }       
			        });
	            }
	        });

	        // Сортировка объектов
	        $(".cards_plan_objects").sortable({
	            dropOnEmpty: true,
	            connectWith: ".cards_plan_objects",
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
				            'url': '<?php echo Url::to($this->context->to(['/cards/one/object/replace'])) ?>',
				            'data': data,
				            'cache': false,
				            'success':function(){
				                refreshPlan();	                
				            }       
				        });	            		
	            	}
	            }	            
	        });
		});

	</script>