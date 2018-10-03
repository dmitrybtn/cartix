<?php 

use yii\data\ActiveDataProvider;

?>

<h1 style='text-align: center;' class='hidden-xs'><?php echo $this->context->title ?></h1>

<?php echo $this->render('/list', [
	'dataProvider' => new ActiveDataProvider([
		'query' => $model::find()->recent()->with('user'), 
		'pagination' => false, 
		'sort' => false
	])
]) ?>