<?php
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use yii\widgets\LinkPager;
use yii\widgets\ListView;


?>

<div class="card_index">


<?php Pjax::begin(); ?>
	<?php echo GridView::widget([
		'options' => ['id' => 'card_index--grid', 'class' => 'hidden-xs'],
		'dataProvider' => $dataProvider,
		'layout' => "{items}",
		'columns' => [
			['attribute' => 'name', 'contentOptions' => $h = [], 'headerOptions' => $h],
			['attribute' => 'user.nameInit', 'label' => 'Автор', 'contentOptions' => $h = ['style' => 'width: 250px;'], 'headerOptions' => $h],

			[
				'class' => 'yii\grid\ActionColumn',
				'template' => '{view}',
				'contentOptions' => $h = ['class' => 'action-column action-column-1'],
				'headerOptions' => $h,
				'urlCreator' => function($action, $modCard) {					
					return ['/cards/one/view/plan', 'id_card' => $modCard->sid, 'id_mode' => Yii::$app->controller->id_mode];
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
						Html::a(Html::encode($modCard->name), ['/cards/one/view/plan', 'id_card' => $modCard->sid, 'id_mode' => Yii::$app->controller->id_mode], ['data-pjax' => 0]) . 
						'<div class="well_list--options">' .
							$modCard->user->nameInit .
						'</div>' .
				   '</div>';
		},
	]) ?>	

	<?php if ($dataProvider->pagination) echo LinkPager::widget([
		'pagination' => $dataProvider->pagination,
	]) ?>

<?php Pjax::end(); ?></div>
