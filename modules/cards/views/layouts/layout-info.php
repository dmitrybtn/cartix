<?php
	namespace dmitrybtn\cp\views;


	use Yii;
?>

<!-- Информация о техкарте -->
<div class="well well-sidebar">
	<div class="header">Информация</div>
	<dl style='margin-bottom: 0;'>
		<dt>Автор</dt>
		<dd><?php echo $this->context->card->user->nameInit ?></dd>

		<dt style='margin-top: 10px;'>Дата создания</dt>
		<dd><?php echo Yii::$app->formatter->asDate($this->context->card->tst_create, 'short') ?></dd>

		<dt style='margin-top: 10px;'>Статус</dt>
		<dd><?php echo $this->context->card->is_common ? 'Общая' : 'Личная' ?></dd>
	</dl>						
</div>  