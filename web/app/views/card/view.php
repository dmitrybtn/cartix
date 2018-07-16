<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Card */
?>
<div class="card-view">

    <?= DetailView::widget([
        'model' => $modCard,
        'attributes' => [
            'id',
            'name',
            'map',
        ],
    ]) ?>

</div>
