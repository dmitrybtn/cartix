<?php

	namespace app\modules\cards\views\one\view;

	use Yii;

	use yii\helpers\{Html, Url};
	use dmitrybtn\cp\ActiveForm;

?>

		<!-- Остановки -->
		<ul class='sortable-1'>
			<?php foreach ($this->context->transfers as $modTransfer): ?>
				

				
				<li data-id-transfer='<?php echo $modTransfer->id ?>'>
					<?php echo Html::a(Html::encode($modTransfer->name), '#', ['data-toggle' => 'modal', 'data-target' => '.cards_plan_transfer--modal-' . $modTransfer->id]) ?>




					<!-- Форма в модальном окне -->
					<div class="modal cards_plan_transfer--modal cards_plan_transfer--modal-<?= $modTransfer->id ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<?php echo $this->render('@app/modules/cards/views/one/transfer/form-modal', ['modTransfer' => $modTransfer]) ?>
							</div>
						</div>
					</div>


					<!-- Объекты -->
					<ul class='sortable-2' data-id-transfer='<?php echo $modTransfer->id ?>' style='min-height: 10px;'>
						<?php foreach ($modTransfer->objects as $modObject): ?>
							<li data-id-object='<?php echo $modObject->id ?>'>
								<?php echo Html::a(Html::encode($modObject->name), '#', ['class' => 'cards_layout_plan--link', 'data-target' => '#object-' . $modObject->id]) ?>
							</li>
						<?php endforeach ?>
					</ul>
				</li>


			<?php endforeach ?>
		</ul>		


        
	<script>
		$(function ($) {


			// Сортировка остановок
	        $( ".sortable-1" ).sortable({
	            axis: 'y',
	            update: function(event, ui) {
			        jQuery.ajax({
			            'type': 'GET',
			            'url': '<?php echo Url::to($this->context->to(['/cards/one/transfer/replace'])) ?>',
			            'data': {id_transfer: ui.item.attr('data-id-transfer'), index: ui.item.index()},
			            'cache': false,
			            'success':function(html){
			                console.log(html);
			                refreshPlan();	                
			            }       
			        });
	            }
	        });

	        // Сортировка объектов
	        $( ".sortable-2" ).sortable({
	            axis: 'y',
	            dropOnEmpty: true,
	            connectWith: ".sortable-2",
	            update: function(event, ui) {
	            	if (ui.sender == null) {
	            		data = {
			            	id_object: ui.item.attr('data-id-object'),
			            	id_transfer: ui.item.closest('ul').attr('data-id-transfer'),
			            	index: ui.item.index()
			            };

				        jQuery.ajax({
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