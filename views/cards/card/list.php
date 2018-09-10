<?php
use yii\helpers\Html;
use yii\widgets\Pjax;use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\widgets\ListView;

$dataProvider = new ActiveDataProvider(['query' => $modCard->search()->with('user')->sorted(), 'pagination' => ['pageSize' => 20], 'sort' => false]);

?>

<div class="card_index">

	<?php echo Html::beginForm(['index'], 'get') ?>
		<div class="well well-sm">
			<div class="row">
				<div class="col-md-10 col-sm-vmargin"><?php echo Html::input('text', 'ss', $modCard->search_string, ['class' => 'form-control', 'placeholder' => 'Что будем искать?']) ?></div>
				<div class="col-md-2"><?php echo Html::submitButton('Искать', ['class' => 'btn btn-primary btn-block']) ?></div>				
			</div>		
		</div>
	<?php echo Html::endForm() ?>

<?php Pjax::begin(); ?>
	<?php echo GridView::widget([
		'options' => ['id' => 'card_index--grid', 'class' => 'hidden-xs'],
		'dataProvider' => $dataProvider,
		'layout' => "{items}",
		'columns' => [
			['attribute' => 'name', 'contentOptions' => $h = [], 'headerOptions' => $h],
			['attribute' => 'user.name', 'label' => 'Автор', 'contentOptions' => $h = ['style' => 'width: 250px;'], 'headerOptions' => $h],

			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{view}',
				'contentOptions' => $h = ['class' => 'action-column action-column-1'],
				'headerOptions' => $h,
				'urlCreator' => function($action, $modCard) {					
					return ['/cards/card/view', 'id_card' => $modCard->id, 'id_mode' => Yii::$app->controller->id_mode];
				},
				'buttons' => [
				]
			],
		],
	]); ?>

	<?php echo ListView::widget([
		'options' => ['id' => 'card_index--list', 'class' => 'visible-xs-block'],		
		'dataProvider' => $dataProvider,
		'layout' => "{items}",		
		'itemOptions' => ['class' => 'item'],
		'itemView' => function ($modCard, $key, $index, $widget) {
			return '<div class="well_list-plan well_list well_list-1 card_plan-mobile--transfer">' . 
						Html::a(Html::encode($modCard->name), ['view', 'id' => $modCard->id], ['data-pjax' => 0]) . 
						'<div class="well_list--options">' .
							$modCard->user->name .
						'</div>' .
				   '</div>';
		},
	]) ?>	

	<?php echo LinkPager::widget([
		'pagination' => $dataProvider->pagination,
	]) ?>

<?php Pjax::end(); ?></div>
