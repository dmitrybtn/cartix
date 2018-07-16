<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\CardTransfer */
?>
<div class="card-transfer-view">

    <?= DetailView::widget([
        'model' => $modCardTransfer,
        'attributes' => [
            'id',
            'id_card',
            'id_sort',
            'time:datetime',
            'name',
            'instruction:ntext',
        ],
    ]) ?>

</div>
