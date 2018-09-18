<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model dmitrybtn\cp\users\models\User */
?>
<div class="user-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'email:email',
        ],
    ]) ?>

</div>
