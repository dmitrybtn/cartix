<?php

	namespace app\modules\cards\views\one\view;

	use Yii;

	use yii\helpers\{Html, Url};
	use dmitrybtn\cp\ActiveForm;

?>

		<!-- Остановки -->
		<ul class='cards_plan_transfers'>
			<?php foreach ($this->context->transfers as $modTransfer): ?>
				

				
				<li class='cards_plan_transfer' data-id-transfer='<?php echo $modTransfer->id ?>'>

					<?php echo Html::a(Html::encode($modTransfer->name), '#', ['class' => 'cards_plan_transfer--header', 'data-toggle' => 'modal', 'data-target' => '.cards_plan_transfer--modal-' . $modTransfer->id]) ?>

					<a href="#" class='handle'><span class='glyphicon glyphicon-move'></span></a>

					<!-- Остановка в модальном окне -->
					<div class="modal cards_plan_transfer--modal cards_plan_transfer--modal-<?= $modTransfer->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<?php echo $this->render('@app/modules/cards/views/one/transfer/form-modal', ['modTransfer' => $modTransfer]) ?>
							</div>
						</div>
					</div>


					<!-- Объекты -->
					<ul class='cards_plan_objects' data-id-transfer='<?php echo $modTransfer->id ?>'>
						<?php foreach ($modTransfer->objects as $modObject): ?>
							<li class='cards_plan_object' data-id-object='<?php echo $modObject->id ?>'>
								<?php echo Html::a(Html::encode($modObject->name), '#', ['class' => 'cards_plan_object--header', 'data-target' => '#object-' . $modObject->id]) ?>
							
								<div>Текст брифа и прочее</div>								
							</li>
						<?php endforeach ?>
					</ul>
					<?php echo Html::a('[Добавить объект]', '#', ['class' => 'text-muted cards_plan_object--create']) ?>
				</li>


			<?php endforeach ?>
		</ul>		

		<?php echo Html::a('[Добавить остановку]', '#', ['class' => 'text-muted', 'data-toggle' => 'modal', 'data-target' => '.cards_plan_transfer--modal-create']) ?>

		<!-- Остановка в модальном окне -->
		<div class="modal cards_plan_transfer--modal cards_plan_transfer--modal-create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<?php echo $this->render('@app/modules/cards/views/one/transfer/form-modal-create') ?>
				</div>
			</div>
		</div>

        
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