<!--A Design by W3layouts 
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>

<head>
	<!-- удаляет во 2 части курса -->
	<!-- <title>Luxury Watches A Ecommerce Category Flat Bootstrap Resposive Website Template | Home :: w3layouts</title> -->
	<base href="/ishop2.loc/">

	<?= $this->getMeta(); ?>


	<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
	<!-- <link href="css/bootstrap.css.map" rel="stylesheet" type="text/css" media="all" /> -->
	<link href="megamenu/css/ionicons.min.css" rel="stylesheet" type="text/css" media="all" />
	<link href="megamenu/css/style.css" rel="stylesheet" type="text/css" media="all" />
	<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />

	<!--theme-style-->
	<link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
	<!--//theme-style-->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


	<!-- Во 2 части курса перенесли от сюда вниз в Футер все скрипты  -->

</head>

<body>
	<!--top-header-->
	<div class="top-header">
		<div class="container">
			<div class="top-header-main">
				<div class="col-md-6 top-header-left">
					<div class="drop">
						<div class="box">
							<select id="currency" tabindex="4" class="dropdown drop">
								<!-- <option value="" class="label">Dollar :</option>
								<option value="1">Dollar</option>
								<option value="2">Euro</option> -->

								<?php new \app\widgets\currency\Currency(); ?>

							</select>
						</div>

						<div class="btn-group">
							<a class="dropdown-toggle" data-toggle="dropdown">Accaunt<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<?php if (!empty($_SESSION['user'])) : ?>
									<li><a href="#">Добро подаловать, <?= h($_SESSION['user']['name']); ?></a></li>
									<li><a href="user/logout">Выход</a></li>
								<?php else : ?>
									<li><a href="user/login">Вход</a></li>
									<li><a href="user/signup">Регистрация</a></li>
								<?php endif; ?>
							</ul>
						</div>

						<div class="clearfix"></div>
					</div>
				</div>



				<!-- Удалим из корзины товары -->
				<!-- <?php //session_destroy();
						?> -->

				<div class="col-md-6 top-header-left">
					<div class="cart box_1">


						<!-- Ссылка для того что бы вызвать КОРЗИНУ  //при клиек мы хотим увидеть корзину // и что бы ссылка не отработала  return false что бы отменить ДЕФОЛТНОЕ поведение ссылки-->
						<a href="cart/show" onclick="getCart(); return false;">
							<div class="total">
								<img src="images/cart-1.png" alt="" />

								<!-- должны вывести либо корзина пуста или вывести сумму товаров в корзине -->
								<?php if (!empty($_SESSION['cart'])) : ?>
									<span class="simpleCart_total"><?= $_SESSION['cart.currency']['symbol_left'] . $_SESSION['cart.sum'] . $_SESSION['cart.currency']['symbol_right']; ?></span>
								<?php else : ?>
									<span class="simpleCart_total">Empty Cart</span>
								<?php endif; ?>

							</div>
						</a>


						<div class="clearfix"> </div>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<!--top-header-->
	<!--start-logo-->
	<div class="logo">
		<a href="<?= PATH; ?>">
			<h1>Luxury Watches</h1>
		</a>
	</div>
	<!--start-logo-->
	<!--bottom-header-->
	<div class="header-bottom">
		<div class="container">
			<div class="header">
				<div class="col-md-9 header-left">

					<div class="menu-container">

						<div class="menu">

							<?php new \app\widgets\menu\Menu([
								'tpl' => WWW . '/menu/menu.php', // WWW - указывает на папку public
								// 'attrs' => [
								// 	'style' => 'border:1px solid red;', 
								// 	'id' => 'menu',
								// ]
							]); ?>

						</div>

					</div>


					<div class="clearfix"> </div>
				</div>

				<div class="col-md-3 header-right">
					<div class="search-bar">

						<form action="search" method="get" autocomplete="off">
							<input type="text" class="typeahead" id="typeahead" name="s">
							<input type="submit" value="">
						</form>

						<!-- <input type="text" value="Search" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search';}">
						<input type="submit" value=""> -->
					</div>
				</div>
				<div class="clearfix"> </div>
			</div>
		</div>
	</div>
	<!--bottom-header-->


	<!--banner-starts-->
	<!-- Эту часть перенесли в Main/index.php -->
	<!--banner-ends-->



	<!-- Эту часть перенесли в Main/index.php -->

	<div class="content">

		<!-- <?php //debug($_SESSION);   //session_destroy() - это чистит корзину; debug($_SESSION); 
				?> -->
		<?= $content; ?>

	</div>




	<!--information-starts-->
	<div class="information">
		<div class="container">
			<div class="infor-top">
				<div class="col-md-3 infor-left">
					<h3>Follow Us</h3>
					<ul>
						<li><a href="#"><span class="fb"></span>
								<h6>Facebook</h6>
							</a></li>
						<li><a href="#"><span class="twit"></span>
								<h6>Twitter</h6>
							</a></li>
						<li><a href="#"><span class="google"></span>
								<h6>Google+</h6>
							</a></li>
					</ul>
				</div>
				<div class="col-md-3 infor-left">
					<h3>Information</h3>
					<ul>
						<li><a href="#">
								<p>Specials</p>
							</a></li>
						<li><a href="#">
								<p>New Products</p>
							</a></li>
						<li><a href="#">
								<p>Our Stores</p>
							</a></li>
						<li><a href="contact.html">
								<p>Contact Us</p>
							</a></li>
						<li><a href="#">
								<p>Top Sellers</p>
							</a></li>
					</ul>
				</div>
				<div class="col-md-3 infor-left">
					<h3>My Account</h3>
					<ul>
						<li><a href="account.html">
								<p>My Account</p>
							</a></li>
						<li><a href="#">
								<p>My Credit slips</p>
							</a></li>
						<li><a href="#">
								<p>My Merchandise returns</p>
							</a></li>
						<li><a href="#">
								<p>My Personal info</p>
							</a></li>
						<li><a href="#">
								<p>My Addresses</p>
							</a></li>
					</ul>
				</div>
				<div class="col-md-3 infor-left">
					<h3>Store Information</h3>
					<h4>The company name,
						<span>Lorem ipsum dolor,</span>
						Glasglow Dr 40 Fe 72.
					</h4>
					<h5>+955 123 4567</h5>
					<p><a href="mailto:example@email.com">contact@example.com</a></p>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<!--information-end-->




	<!--footer-starts-->
	<div class="footer">
		<div class="container">
			<div class="footer-top">
				<div class="col-md-6 footer-left">
					<form>
						<input type="text" value="Enter Your Email" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Enter Your Email';}">
						<input type="submit" value="Subscribe">
					</form>
				</div>
				<div class="col-md-6 footer-right">
					<p>© 2015 Luxury Watches. All Rights Reserved | Design by <a href="http://w3layouts.com/" target="_blank">W3layouts</a> </p>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
	<!--footer-end-->




	<!-- Модальное окно -->
	<div class="modal fade" id="cart" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Корзина</h4>
				</div>

				<div class="modal-body">

				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Продолжить покупки</button>
					<a href="cart/view" type="button" class="btn btn-primary">Оформить заказ</a>
					<button type="button" class="btn btn-danger" onclick="clearCart()">Очистить карзину</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->




	<?php $curr = \ishop\App::$app->getProperty('currency'); ?>
	<script>
		var path = '<?= PATH ?>', //   ссылка на главную страницу нашего САЙТА / нужна для AJAX запросов
			course = <?= $curr['value']; ?>,
			symboleLeft = '<?= $curr['symbol_left']; ?>',
			symboleRight = '<?= $curr['symbol_right']; ?>';
	</script>

	<!-- Перенесли все скрипты -->
	<script src="js/jquery-1.11.0.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/typeahead.bundle.js"></script>

	<!--dropdown-->
	<script src="js/jquery.easydropdown.js"></script>

	<!--Slider-Starts-Here-->
	<script src="js/responsiveslides.min.js"></script>

	<script>
		// You can also use "$(window).load(function() {"
		$(function() {
			// Slideshow 4
			$("#slider4").responsiveSlides({
				auto: true,
				pager: true,
				nav: true,
				speed: 500,
				namespace: "callbacks",
				before: function() {
					$('.events').append("<li>before event fired.</li>");
				},
				after: function() {
					$('.events').append("<li>after event fired.</li>");
				}
			});

		});
	</script>

	<script src="megamenu/js/megamenu.js"></script>

	<script src="js/imagezoom.js"></script>
	<script defer src="js/jquery.flexslider.js"></script>

	<script>
		// Can also be used with $(document).ready()
		$(window).load(function() {
			$('.flexslider').flexslider({
				animation: "slide",
				controlNav: "thumbnails"
			});
		});
	</script>


	<script src="js/jquery.easydropdown.js"></script>
	<script type="text/javascript">
		$(function() {

			var menu_ul = $('.menu_drop > li > ul'),
				menu_a = $('.menu_drop > li > a');

			menu_ul.hide();

			menu_a.click(function(e) {
				e.preventDefault();
				if (!$(this).hasClass('active')) {
					menu_a.removeClass('active');
					menu_ul.filter(':visible').slideUp('normal');
					$(this).addClass('active').next().stop(true, true).slideDown('normal');
				} else {
					$(this).removeClass('active');
					$(this).next().stop(true, true).slideUp('normal');
				}
			});

		});
	</script>


	<script src="js/main.js"></script>
	<!--End-slider-script-->

	<!-- <?php
			$logs = \R::getDatabaseAdapter()
				->getDatabase()
				->getLogger();

			debug($logs->grep('SELECT'));
			?> -->

</body>

</html>