<!-- <h1>Hello, world!</h1>


<p><?= $name; ?></p>
<p><?= $age; ?></p>
<?php debug($names); ?>
<?php foreach ($posts as $post) : ?>
    <h3><?= $post->title ?></h3>
<?php endforeach; ?> -->



<div class="bnr" id="home">
	<div id="top" class="callbacks_container">
		<ul class="rslides" id="slider4">
			<li>
				<img src="images/bnr-1.jpg" alt="" />
			</li>
			<li>
				<img src="images/bnr-2.jpg" alt="" />
			</li>
			<li>
				<img src="images/bnr-3.jpg" alt="" />
			</li>
		</ul>
	</div>
	<div class="clearfix"> </div>
</div>
<!--banner-ends-->


<!-- Во 2 части курса перенёс в layouts/watches в скрипты  -->


<!--about-starts-->


<?php if ($brands) : ?>


	<div class="about">
		<div class="container">
			<div class="about-top grid-1">

				<?php foreach ($brands as $brand) : ?>

					<div class="col-md-4 about-left">
						<figure class="effect-bubba">
							<img class="img-responsive" src="images/<?= $brand->img; ?>" alt="" />
							<figcaption>
								<h2><?= $brand->title; ?></h2>
								<p><?= $brand->description; ?></p>
							</figcaption>
						</figure>
					</div>

					<!-- Во 2 части эта матня удаляется -->
					<!-- <div class="col-md-4 about-left">
					<figure class="effect-bubba">
						<img class="img-responsive" src="images/abt-2.jpg" alt=""/>
						<figcaption>
							<h4>Mauris erat augue</h4>
							<p>In sit amet sapien eros Integer dolore magna aliqua</p>	
						</figcaption>			
					</figure>
				</div>
				<div class="col-md-4 about-left">
					<figure class="effect-bubba">
						<img class="img-responsive" src="images/abt-3.jpg" alt=""/>
						<figcaption>
							<h4>Cras elit mauris</h4>
							<p>In sit amet sapien eros Integer dolore magna aliqua</p>	
						</figcaption>			
					</figure>
				</div> -->
				<?php endforeach; ?>

				<div class="clearfix"></div>
			</div>
		</div>
	</div>


<?php endif; ?>


<!--about-end-->
<!--product-starts-->

<?php if ($hits) : ?>

	<!-- Получаем активную валюту -->
	<!-- И возьму её из контейнера -->
	<?php $curr = \ishop\App::$app->getProperty('currency'); ?>

	<div class="product">
		<div class="container">
			<div class="product-top">
				<div class="product-one">

					<?php foreach ($hits as $hit) : ?>

						<div class="col-md-3 product-left">
							<div class="product-main simpleCart_shelfItem">
								<a href="product/<?= $hit->alias; ?>" class="mask"><img class="img-responsive zoom-img" src="images/<?= $hit->img; ?>" alt="" /></a>
								<div class="product-bottom">
									<h3>
										<a href="product/<?= $hit->alias; ?>"><?= $hit->title; ?></a>
									</h3>
									<p>Explore Now</p>
									<h4>
										<a class="add-to-cart-link" href="cart/add?id=<?= $hit->id; ?>">
											<i></i>
										</a>
										<span class=" item_price"><?= $curr['symbol_left']; ?><?= $hit->price * $curr['value']; ?><?= $curr['symbol_right']; ?></span>


										<?php if ($hit->old_price) : ?>

											<small>
												<del><?= $hit->old_price * $curr['value']; ?></del>
											</small>

										<?php endif; ?>


									</h4>
								</div>
								<div class="srch">
									<span>-50%</span>
								</div>
							</div>
						</div>

					<?php endforeach; ?>

					<!-- Во 2 части курса удаляет этот кусок -->

					<!-- <div class="col-md-3 product-left">
						<div class="product-main simpleCart_shelfItem">
							<a href="single.html" class="mask"><img class="img-responsive zoom-img" src="images/p-2.png" alt="" /></a>
							<div class="product-bottom">
								<h3>Smart Watches</h3>
								<p>Explore Now</p>
								<h4><a class="item_add" href="#"><i></i></a> <span class=" item_price">$ 329</span></h4>
							</div>
							<div class="srch">
								<span>-50%</span>
							</div>
						</div>
					</div>
					<div class="col-md-3 product-left">
						<div class="product-main simpleCart_shelfItem">
							<a href="single.html" class="mask"><img class="img-responsive zoom-img" src="images/p-3.png"  alt="" /></a>
							<div class="product-bottom">
								<h3>Smart Watches</h3>
								<p>Explore Now</p>
								<h4><a class="item_add" href="#"><i></i></a> <span class=" item_price">$ 329</span></h4>
							</div>
							<div class="srch">
								<span>-50%</span>
							</div>
						</div>
					</div>
					<div class="col-md-3 product-left">
						<div class="product-main simpleCart_shelfItem">
							<a href="single.html" class="mask"><img class="img-responsive zoom-img" src="images/p-4.png" alt="" /></a>
							<div class="product-bottom">
								<h3>Smart Watches</h3>
								<p>Explore Now</p>
								<h4><a class="item_add" href="#"><i></i></a> <span class=" item_price">$ 329</span></h4>
							</div>
							<div class="srch">
								<span>-50%</span>
							</div>
						</div>
					</div> -->

					<div class="clearfix"></div>
				</div>



				<!-- Во 2 части курса удаляет этот кусок -->

				<!-- <div class="product-one">
					<div class="col-md-3 product-left">
						<div class="product-main simpleCart_shelfItem">
							<a href="single.html" class="mask"><img class="img-responsive zoom-img" src="images/p-5.png" alt="" /></a>
							<div class="product-bottom">
								<h3>Smart Watches</h3>
								<p>Explore Now</p>
								<h4><a class="item_add" href="#"><i></i></a> <span class=" item_price">$ 329</span></h4>
							</div>
							<div class="srch">
								<span>-50%</span>
							</div>
						</div>
					</div>
					<div class="col-md-3 product-left">
						<div class="product-main simpleCart_shelfItem">
							<a href="single.html" class="mask"><img class="img-responsive zoom-img" src="images/p-6.png" alt="" /></a>
							<div class="product-bottom">
								<h3>Smart Watches</h3>
								<p>Explore Now</p>
								<h4><a class="item_add" href="#"><i></i></a> <span class=" item_price">$ 329</span></h4>
							</div>
							<div class="srch">
								<span>-50%</span>
							</div>
						</div>
					</div>
					<div class="col-md-3 product-left">
						<div class="product-main simpleCart_shelfItem">
							<a href="single.html" class="mask"><img class="img-responsive zoom-img" src="images/p-7.png" alt="" /></a>
							<div class="product-bottom">
								<h3>Smart Watches</h3>
								<p>Explore Now</p>
								<h4><a class="item_add" href="#"><i></i></a> <span class=" item_price">$ 329</span></h4>
							</div>
							<div class="srch">
								<span>-50%</span>
							</div>
						</div>
					</div>
					<div class="col-md-3 product-left">
						<div class="product-main simpleCart_shelfItem">
							<a href="single.html" class="mask"><img class="img-responsive zoom-img" src="images/p-8.png" alt="" /></a>
							<div class="product-bottom">
								<h3>Smart Watches</h3>
								<p>Explore Now</p>
								<h4><a class="item_add" href="#"><i></i></a> <span class=" item_price">$ 329</span></h4>
							</div>
							<div class="srch">
								<span>-50%</span>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>					 -->



			</div>
		</div>
	</div>

<?php endif; ?>

<!--product-end-->