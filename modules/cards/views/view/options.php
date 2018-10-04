<?php 
	use dmitrybtn\cp\Menu;
	use dmitrybtn\cp\MenuWidget;
?>

<!-- Информация о техкарте -->
<?php echo $this->render('@app/modules/cards/views/layouts/layout-info') ?>


<!-- Опции техкарты -->
<?php $objMenuCard = new Menu([
	'items' => $this->context->menuCard,
]); ?>

<?php if ($objMenuCard->visible): ?>
	<div class="well well-sidebar">
		<?php echo $objMenuCard->render([
			'options' => ['class' => 'nav-pills nav-stacked deskmenu']
		]); ?>								
	</div>                        
<?php endif ?>
