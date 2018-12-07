<?php
use yii\helpers\Html;
use yii\widgets\Pjax;use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\widgets\ListView;

$dataProvider = new ActiveDataProvider(['query' => $modLog->search(), 'pagination' => ['pageSize' => 20], 'sort' => false]);

?>

<div class="card-log_index">

	<?php echo Html::beginForm(['logs'], 'get') ?>
		<div class="well well-sm">
			<div class="row">
				<div class="col-md-10 col-sm-vmargin"><?php echo Html::input('text', 'ss', $modLog->search_string, ['class' => 'form-control', 'placeholder' => 'Что будем искать?']) ?></div>
				<div class="col-md-2"><?php echo Html::submitButton('Искать', ['class' => 'btn btn-primary btn-block']) ?></div>				
			</div>		
		</div>
	<?php echo Html::endForm() ?>

<?php Pjax::begin(); ?>
	<?php echo GridView::widget([
		'options' => ['id' => 'card-log_index--grid', 'class' => 'hidden-xs'],
		'dataProvider' => $dataProvider,
		'layout' => "{items}",
		'columns' => [
			['attribute' => 'timestamp', 'header' => 'Дата и время', 'format' => ['datetime', 'short'], 'contentOptions' => $h = ['style' => 'width: 150px;'], 'headerOptions' => $h],
			['value' => function($m) {return $m->user->surname ?? $m->ip;}, 'header' => 'Пользователь', 'contentOptions' => $h = ['style' => 'width: 150px;'], 'headerOptions' => $h],
			['attribute' => 'card.title', 'header' => 'Техкарта', 'contentOptions' => $h = ['style' => 'width: 200px;'], 'headerOptions' => $h],
			['attribute' => 'route', 'header' => 'Действие', 'contentOptions' => $h = [], 'headerOptions' => $h],
			['attribute' => 'device', 'header' => 'Браузер', 'contentOptions' => $h = ['style' => 'width: 100px;'], 'headerOptions' => $h],

		],
	]); ?>

	<?php echo ListView::widget([
		'options' => ['id' => 'card-log_index--list', 'class' => 'visible-xs-block'],		
		'dataProvider' => $dataProvider,
		'layout' => "{items}",		
		'itemOptions' => ['class' => 'item'],
		'itemView' => function ($modLog, $key, $index, $widget) {
			return '<div class="well well-small">' . Html::a(Html::encode($modLog->id), ['view', 'id' => $modLog->id]) . '</div>';
		},
	]) ?>	

	<?php echo LinkPager::widget([
		'pagination' => $dataProvider->pagination,
	]) ?>

<?php Pjax::end(); ?></div>
