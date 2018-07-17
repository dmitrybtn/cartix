<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CardImage */
?>
<div class="card-image-view">

    <?= DetailView::widget([
        'model' => $modCardImage,
        'attributes' => [
            'id',
            'id_card',
            'id_sort',
            'name',
            'url:url',
            'file',
            'description:ntext',
        ],
    ]) ?>

</div>

<?php echo Html::img($modCardImage->thumbnail(150, 150), ['alt' => 'Экскурсия']) ?>
