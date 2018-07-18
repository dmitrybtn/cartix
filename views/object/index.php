<?php
use yii\helpers\Html;
use yii\widgets\Pjax;use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\widgets\ListView;

$dataProvider = new ActiveDataProvider(['query' => $modCardObject->search()->sorted(), 'pagination' => ['pageSize' => 20], 'sort' => false]);

?>

<div class="card-object_index">

	<?php echo Html::beginForm(['index'], 'get') ?>
		<div class="well well-sm">
			<div class="row">
				<div class="col-md-10 col-sm-vmargin"><?php echo Html::input('text', 'ss', $modCardObject->search_string, ['class' => 'form-control', 'placeholder' => 'Что будем искать?']) ?></div>
				<div class="col-md-2"><?php echo Html::submitButton('Искать', ['class' => 'btn btn-primary btn-block']) ?></div>				
			</div>		
		</div>
	<?php echo Html::endForm() ?>

<?php Pjax::begin(); ?>
	<?php echo GridView::widget([
		'options' => ['id' => 'card-object_index--grid', 'class' => 'hidden-xs'],
		'dataProvider' => $dataProvider,
		'layout' => "{items}",
		'columns' => [
			['attribute' => 'id', 'contentOptions' => $h = [], 'headerOptions' => $h],
			['attribute' => 'id_transfer', 'contentOptions' => $h = [], 'headerOptions' => $h],
			['attribute' => 'id_sort', 'contentOptions' => $h = [], 'headerOptions' => $h],
			['attribute' => 'time', 'format' => 'datetime', 'contentOptions' => $h = [], 'headerOptions' => $h],
			['attribute' => 'name', 'contentOptions' => $h = [], 'headerOptions' => $h],
			// ['attribute' => 'instruction', 'format' => 'ntext', 'contentOptions' => $h = [], 'headerOptions' => $h],
			// ['attribute' => 'text', 'format' => 'ntext', 'contentOptions' => $h = [], 'headerOptions' => $h],

			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{lift} {drop} {view} {update} {delete}',
				'contentOptions' => $h = ['class' => 'action-column action-column-5'],
				'headerOptions' => $h,
				'buttons' => [
					'lift' => function ($url, $model, $key) {
						return Html::a('<span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>', ['sort', 'id' => $model->id]);
					},

					'drop' => function ($url, $model, $key) {
						return Html::a('<span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>', ['sort', 'id' => $model->id, 'inv' => 1]);
					},	
				]
			],
		],
	]); ?>

	<?php echo ListView::widget([
		'options' => ['id' => 'card-object_index--list', 'class' => 'visible-xs-block'],		
		'dataProvider' => $dataProvider,
		'layout' => "{items}",		
		'itemOptions' => ['class' => 'item'],
		'itemView' => function ($modCardObject, $key, $index, $widget) {
			return '<div class="well well-small">' . Html::a(Html::encode($modCardObject->name), ['view', 'id' => $modCardObject->id]) . '</div>';
		},
	]) ?>	

	<?php echo LinkPager::widget([
		'pagination' => $dataProvider->pagination,
	]) ?>

<?php Pjax::end(); ?></div>
