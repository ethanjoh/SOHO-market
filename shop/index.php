<?php include_once '../include/header.php';?>

        <!-- main slider -->
		<section class="slider-area">
			<div class="bend niceties preview-2">
				<div id="ensign-nivoslider" class="slides">
					<img src="/images/slider/slider11.jpg" alt="" title="#slider-direction-1"  />
					<img src="/images/slider/slider12.jpg" alt="" title="#slider-direction-2"  />
				</div>
				<!-- direction 1 -->
				<div id="slider-direction-1" class="t-cn slider-direction">

					<div class="slider-content t-lfl s-tb slider-1">
						<div class="title-container s-tb-c title-compress">
							<h1 class="title1">samsunggalaxy</h1>
							<h2 class="title2">s4 zoom</h2>
							<h3 class="title3" >talk & shoot camera</h3>
							<div class="s-title">
                                <a href="#">view collection</a>
                            </div>
						</div>
					</div>
				</div>
				<!-- direction 2 -->
				<div id="slider-direction-2" class="slider-direction">

					<div class="slider-content t-lfr s-tb slider-2">
						<div class="title-container s-tb-c">
							<h1 class="title4">now available no selected</h1>
							<h3 class="title3">smart tvs & tablets</h3>
							<div class="s-title">
                                <a href="#">view collection</a>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!--main slider end-->
        <!-- start slider_area
		============================================ -->
        <section class="slider_area">
            <div class="container">
                <div class="row">
                    <div class="product col-md-4 col-sm-4 col-xs-12">
                        <a href="#"><img src="/images/product/banner23.jpg" alt=""></a>
                    </div>
                    <div class="product col-md-4 col-sm-4 col-xs-12">
                        <a href="#"><img src="/images/product/banner24.jpg" alt=""></a>
                    </div>
                    <div class="product col-md-4 col-sm-4 col-xs-12">
                        <a href="#"><img src="/images/product/banner25.jpg" alt=""></a>
                    </div>
                   <div class="col-md-12">
                        <div class="ma-title">
                            <h2>
                                Best Sellers
                            </h2>
                        </div>
                        <div class="row">
                            <div class="features-carousel indicator-style">

                                <?php
show_main_products('best', 10);

?>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="lenovo">
                            <a href="#">
                                <img alt="" src="/images/banner/banner15.jpg">
                            </a>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="lenovo">
                            <a href="#">
                                <img alt="" src="/images/banner/banner14.jpg">
                            </a>
                        </div>
                    </div>
			    </div>
            </div>
        </section>
        <!-- end slider_area
		============================================ -->
        <!-- start product_area
		============================================ -->
        <section class="product_area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="ma-title">
                            <h2>
                                New Products
                            </h2>
                        </div>
                        <div class="row">
                            <div class="features-carousel indicator-style">
                                 <?php
show_main_products('new', 10);

?>
                            </div>
                        </div>
                        <div class="banner">
                            <a href="#"><img src="/images/banner16.jpg" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end product_area
		============================================ -->

<?php include_once '../include/brands.php';?>

<?php include_once '../include/footer.php';?>