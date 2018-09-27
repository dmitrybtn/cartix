<?php
	namespace app\modules\cards\views\layouts;


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

			<!-- Основная область для десктопов -->
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-3 hidden-xs hidden-sm">
						<?php echo $this->render('@app/modules/cards/views/layouts/layout-plan') ?>
					</div>

					<div class="col-md-9">

						<!-- Главный заголовок с опциями -->
						<div class='hidden-xs hidden-sm cards_content_header'>
							<?php echo $this->blocks['cards_content_header--options'] ?? '' ?>																				

							<?php if ($this->context->showHeader): ?>
								<h1><?= Html::encode($this->context->header) ?></h1>                        
							<?php endif ?>
						</div>

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

		<?php $this->endBody() ?>
	</body>

</html>
<?php $this->endPage() ?>
