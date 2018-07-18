<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

use yii\widgets\ActiveForm;

use app\models\CardImage;
use app\widgets\Gallery;

?>

<?php 
	
	$o = null;

	d(preg_match_all('/ФОТО-(\d+)/u', 'Превед ФОТО-106ФОТО-106 медвед ФОТО-2 йа креведко', $o));

	d($o);

 ?>

<?php $this->beginContent('@app/views/card/view.php', ['modCard' => $modCard]) ?>

	<?php $modImage = new CardImage ?>

	<?php echo Html::beginForm(['/image/create', 'id' => $modCard->id], 'post', ['enctype' => 'multipart/form-data']) ?>
		<div class="well well-sm">
			<div class="row">
				
				<div class="col-md-7 col-sm-vmargin">
					<?php echo Html::activeTextInput($modImage, 'url', ['class' => 'form-control', 'placeholder' => 'Введите URL картинки или загрузите файл']) ?>					
				</div>

				<div class="col-md-3 col-sm-vmargin">
					<?php echo Html::activeFileInput($modImage, 'file', ['class' => '']) ?>
						
				</div>
				
				<div class="col-md-2">
					<?php echo Html::submitButton('Загрузить', ['class' => 'btn btn-primary btn-block']) ?>		
				</div>				
			</div>		
		</div>
	<?php echo Html::endForm() ?>


	<?php 

		$arrImages = [];
		foreach ($modCard->images as $modImage) {
			$arrImages[] = [
				'image' => Yii::getAlias('@web/uploads/' . $modImage->file),
	            'title' => 'Image Title 2',
	            'size' => $modImage->size,
	            'thumb' => $modImage->thumbnail(300, 300),
	            'caption' => 
	            	$modImage->marker . 
	            	'<div class="pull-right">' . 
						Html::a('<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>', ['/image/sort', 'id' => $modImage->id]) . ' ' .
						Html::a('<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>', ['/image/sort', 'id' => $modImage->id, 'inv' => 1]) . ' ' .
		            	Html::a('<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>', ['/image/delete', 'id' => $modImage->id], ['data-confirm' => 'Точно?', 'data-method' => 'post']) .
	            	'</div>'
			];	
		}

	?>



	<?= Gallery::widget([
	    'items' => $arrImages,
	    'clientOptions' => [
	    	'bgOpacity' => 0.9,
	    	'spacing' => 0.9,

			'closeEl' => true,
			'captionEl' => false,
			'fullscreenEl' => false,
			'zoomEl' => true,
			'shareEl' => false,
			'counterEl' => true,
			'arrowEl' => true,
			'preloaderEl' => true,

	    ]
	])
	?>

<?php $this->endContent() ?>