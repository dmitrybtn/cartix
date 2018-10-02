<?php
	namespace dmitrybtn\cp\views;


	use Yii;
	use yii\helpers\Html;
	use yii\helpers\Url;

	use yii\bootstrap\{Nav, BootstrapPluginAsset};

	use app\widgets\Alert;
	use yii\widgets\Breadcrumbs;

	use dmitrybtn\cp\Menu;
	use dmitrybtn\cp\MenuWidget;

	\app\assets\AppAsset::register($this);
	\dmitrybtn\cp\Asset::register($this);

	BootstrapPluginAsset::register($this);

	\yii\jui\JuiAsset::register($this);


	$objMenuMain = new Menu([
		'items' => '@app/config/menu.php',
	]);

	$objMenuUser = new Menu([
		'items' => Yii::$app->user->menu,
	]);
	
	$objMenuContext = new Menu([
		'items' => Yii::$app->controller->menu
	]);
	
	$showRightSidebar = $objMenuContext->visible || (isset($this->blocks['sidebar-right']) && $this->blocks['sidebar-right']);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>

<html lang="<?= Yii::$app->language ?>">
	<head>
		<meta charset="<?= \Yii::$app->charset ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<?= Html::csrfMetaTags() ?>

		<title><?= Html::encode($this->context->title) ?><?php if ($this->context->route != Yii::$app->defaultRoute) echo Html::encode(' | ' . Yii::$app->name) ?></title>

		<?php $this->head() ?>
	</head>

	<body>
		<?php $this->beginBody() ?>

			<!-- Навигационная панель для десктопов -->
			<nav class="navbar navbar-desktop">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-9">

							<?php if ($objMenuMain->visible): ?>
								<a href="#" class="navbar-icon navbar-icon-main" id=""><span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span></a>                
							<?php endif ?>


							<?php echo Html::a(\Yii::$app->name, Url::home(), ['class' => 'navbar-brand']) ?>                    

							<?php if ($this->context->showBreads) echo Breadcrumbs::widget([
								'links' => $this->context->breads + ['label' => $this->context->headerBread],
								'options' => ['class' => 'navbar-left navbar-nav navbar-breadcrumb']
							]) ?>                        
						</div>

						<div class="col-md-3">
							<?php echo $objMenuUser->render([
								'activateItems' => false,
								'options' => ['class' => 'navbar-nav navbar-right']
							]) ?>                                                               
						</div>
					</div>
				</div>
			</nav>

			<!-- Навигационная панель для телефонов -->
			<nav class="navbar navbar-mobile">
				<div class="container-fluid">
					<?php if ($objMenuMain->visible || $objMenuUser->visible): ?>
						<a href="#" class="navbar-icon navbar-icon-main" id=""><span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span></a>                
					<?php endif ?>

					<?php if ($objMenuContext->visible): ?>
						<a href="#" class="navbar-icon navbar-icon-context" id="">
							<span class="glyphicon glyphicon-option-horizontal" aria-hidden="true"></span>
						</a>                
					<?php endif ?>

					<?php if ($this->context->showBreads): ?>
						<?php $url = isset($this->context->breads[count($this->context->breads) - 1]['url']) ? $this->context->breads[count($this->context->breads) - 1]['url'] : Url::home() ?>
						<?php echo Html::a('<div class="back"><</div>' . Html::encode($this->context->headerMobile), $url, ['class' => 'navbar-mobile-brand']) ?>
					<?php else: ?>
						<div class="navbar-mobile-brand"><?php echo Html::encode($this->context->headerMobile) ?></div>
					<?php endif ?>
				</div>
			</nav>  

			<!-- Главное меню для телефонов -->
			<div class="mobmenu mobmenu-main">
				<?php echo $objMenuMain->render() ?>

				<?php if ($objMenuUser->visible): ?>
					<hr>
					<?php echo $objMenuUser->render() ?> 			
				<?php endif ?>			
			</div>


			<!-- Контекстное меню для телефонов -->
			<div class="mobmenu mobmenu-context">
				<?php echo $objMenuContext->render() ?>
			</div>

			
			<!-- Главное и контекстное меню для десктопов -->
			<div class="container-fluid container-sidebars-desktop">
				<div class="row">
					<div class="col-md-3 col-lg-2 hidden-md">

						<!-- Навигация по техкарте -->
						<div class="well well-sidebar">
							<?php echo \dmitrybtn\cp\MenuWidget::widget([
							    'items' => [
							    	['label' => 'Навигация'],
									['label' => 'План', 'url' => $this->context->to(['/cards/one/view/plan'])],
									['label' => 'Текст', 'url' => $this->context->to(['/cards/one/view/text'])],
									['label' => 'Картинки', 'url' => $this->context->to(['/cards/one/view/images'])],
							    ],
							    'options' => ['class' => 'nav-pills nav-stacked deskmenu'], // set this to nav-tab to get tab-styled navigation
							]); ?>
						</div>                        


						<!-- Опции техкарты -->
						<div class="well well-sidebar">
							<?php echo \dmitrybtn\cp\MenuWidget::widget([
							    'items' => $this->context->menuCard,
							    'options' => ['class' => 'nav-pills nav-stacked deskmenu'], // set this to nav-tab to get tab-styled navigation
							]); ?>
						</div>                        


					</div>

					<div class="col-md-3 col-md-offset-9 col-lg-2 col-lg-offset-8 <?= $showRightSidebar ? '' : 'hidden-md' ?>">
						<?php if ($objMenuContext->visible): ?>
							<div class="well well-sidebar">
								<?php echo $objMenuContext->render([
									'options' => ['class' => 'nav-pills nav-stacked deskmenu deskmenu-context']
								]) ?>                    
							</div>                        
						<?php endif ?>

						<?php if (isset($this->blocks['sidebar-right'])): ?>
							<?php echo $this->blocks['sidebar-right'] ?>
						<?php endif ?>

						<?php if ($this->context->showPlan): ?>
							<div class="cards_layout_plan--header">Содержание</div>
							<?php echo $this->render('@app/modules/cards/views/layouts/layout-plan') ?>
						<?php endif ?>
					</div>

				</div>        
			</div>


			<!-- Основная область -->
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-8 col-lg-offset-2 <?= $showRightSidebar ? 'col-md-9' : 'col-md-8 col-md-offset-2' ?>">

						<!-- MAIN AREA -->

						<?php if ($this->context->showHeader): ?>
							<h1 class='hidden-xs hidden-sm page-header' style='text-align: center;'><?= Html::encode($this->context->header) ?></h1>                        
						<?php endif ?>

						<div id='cards_content'>
							<?= Alert::widget() ?>

							<?= $content ?>							
						</div>
					
					</div>
				</div>
			</div>

			<!-- Футер -->
			<?php if (isset($this->blocks['footer'])): ?>
				<?php echo $this->blocks['footer'] ?>
			<?php endif ?>

			<?php if ($this->context->showNavMobile): ?>
				<footer class='footer-mobile'>
					<?php echo Nav::widget([
					    'options' => ['class' =>'nav-footer cards_footer'],
					    'activateItems' => true,
					    'items' => [
					        ['label' => 'План', 'url' => $this->context->to(['/cards/one/view/plan'])],
					        ['label' => 'Текст', 'url' => $this->context->to(['/cards/one/view/text'])],
					        ['label' => 'Картинки', 'url' => $this->context->to(['/cards/one/view/images'])],
					    ],
					]); ?>		
				</footer>					
			<?php endif ?>

		<!-- Сохранение и восстановление прокрутки в режиме просмотра -->
		<?php if ($this->context->uniqueid == 'cards/one/view'): ?>
			<script>
				var id_action = '<?php echo $this->context->action->id ?>';
				var id_card = <?php echo $this->context->card->id ?>;
				
				var str_scroll = 'scroll-cont-' + id_card;
				
				var strScrollAction = sessionStorage.getItem(str_scroll + '-action');
				var strScrollValue = sessionStorage.getItem(str_scroll + '-value');


				$(function ($) {

				    // Определить прокручиваемый объект
			        if ($('#cards_content').hasClass('cards_content-desktop')) objScrollable = $('#cards_content');
			        else objScrollable = $('body');

			        // Сохранить прокрутку
				    $(window).on('beforeunload', function() {
				        sessionStorage.setItem(str_scroll + '-action', id_action);
				        sessionStorage.setItem(str_scroll + '-value', objScrollable.scrollTop());
				    });

				    // Восстановить прокрутку
				    if (strScrollAction != null && strScrollAction == id_action) 
				    	objScrollable.scrollTop(strScrollValue);

				});




			</script>			
		<?php endif ?>


		<?php $this->endBody() ?>
	</body>

</html>
<?php $this->endPage() ?>
