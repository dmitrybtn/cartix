<?php
use yii\helpers\Html;
use yii\widgets\Pjax;use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\widgets\ListView;

$dataProvider = new ActiveDataProvider(['query' => $model->search()->sorted(), 'pagination' => ['pageSize' => 20], 'sort' => false]);

?>

<div class="user_index">

	<?php echo Html::beginForm(['index'], 'get') ?>
		<div class="well well-sm">
			<div class="row">
				<div class="col-md-10 col-sm-vmargin"><?php echo Html::input('text', 'ss', $model->search_string, ['class' => 'form-control', 'placeholder' => 'Что будем искать?']) ?></div>
				<div class="col-md-2"><?php echo Html::submitButton('Искать', ['class' => 'btn btn-primary btn-block']) ?></div>				
			</div>		
		</div>
	<?php echo Html::endForm() ?>

<?php Pjax::begin(); ?>
	<?php echo GridView::widget([
		'options' => ['id' => 'user_index--grid', 'class' => 'hidden-xs'],
		'dataProvider' => $dataProvider,
		'layout' => "{items}",
		'columns' => [
			['attribute' => 'nameFullInv', 'header' => 'ФИО', 'contentOptions' => $h = [], 'headerOptions' => $h],
			['attribute' => 'email', 'format' => 'email', 'contentOptions' => $h = ['style' => ''], 'headerOptions' => $h],
			['attribute' => 'role', 'contentOptions' => $h = ['style' => 'width: 200px;'], 'headerOptions' => $h],

			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{view} {update}',
				'contentOptions' => $h = ['class' => 'action-column action-column-2'],
				'headerOptions' => $h,
			],
		],
	]); ?>

	<?php echo ListView::widget([
		'options' => ['id' => 'user_index--list', 'class' => 'visible-xs-block'],		
		'dataProvider' => $dataProvider,
		'layout' => "{items}",		
		'itemOptions' => ['class' => 'item'],
		'itemView' => function ($model, $key, $index, $widget) {
			return '<div class="well well-small">' . Html::a(Html::encode($model->nameFullInv), ['view', 'id' => $model->id]) . '</div>';
		},
	]) ?>	

	<?php echo LinkPager::widget([
		'pagination' => $dataProvider->pagination,
	]) ?>

<?php Pjax::end(); ?></div>
