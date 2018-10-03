<?php

use yii\helpers\Html;

?>

<div class="site-error">
    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?><br>
    </div>
</div>