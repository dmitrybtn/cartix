<?php 

use yii\data\ActiveDataProvider;
use yii\helpers\Html;

?>


<?php echo Html::beginForm(['index'], 'get') ?>
	<div class="well well-sm">
		<div class="row">
			<div class="col-md-10 col-sm-vmargin"><?php echo Html::input('text', 'ss', $modCard->search_string, ['class' => 'form-control', 'placeholder' => 'Что будем искать?']) ?></div>
			<div class="col-md-2"><?php echo Html::submitButton('Искать', ['class' => 'btn btn-primary btn-block']) ?></div>				
		</div>		
	</div>
<?php echo Html::endForm() ?>


<?php echo $this->render('/list', [
	'modCard' => $modCard,
	'dataProvider' => new ActiveDataProvider([
		'query' => $modCard->search()->mode($this->context->id_mode)->with('user')->sorted(), 
		'pagination' => ['pageSize' => 20], 
		'sort' => false])
]) ?>