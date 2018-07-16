<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CardObject */
?>
<div class="card-object-view">

    <?= DetailView::widget([
        'model' => $modCardObject,
        'attributes' => [
            'id',
            'id_transfer',
            'id_sort',
            'time:datetime',
            'name',
            'instruction:ntext',
            'information:ntext',
        ],
    ]) ?>

</div>
