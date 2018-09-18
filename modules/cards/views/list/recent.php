<?php 

use yii\data\ActiveDataProvider;

?>

<h1 style='text-align: center;'><?php echo $this->context->title ?></h1>

<?php echo $this->render('/list', [
	'modCard' => $modCard,
	'dataProvider' => new ActiveDataProvider([
		'query' => $modCard::find()->recent()->with('user'), 
		'pagination' => false, 
		'sort' => false
	])
]) ?>