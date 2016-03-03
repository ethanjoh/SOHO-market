<?php include_once '../include/header.php';?>

        <!-- main slider -->
		<section class="slider-area">
			<div class="bend niceties preview-2">
				<div id="ensign-nivoslider" class="slides">
					<img src="/images/slider/main-01.jpg" alt="" title="#slider-direction-1"  />
					<img src="/images/slider/main-02.jpg" alt="" title="#slider-direction-2"  />
                    <img src="/images/slider/main-03.jpg" alt="" title="#slider-direction-3"  />
                    <img src="/images/slider/main-04.jpg" alt="" title="#slider-direction-4"  />
				</div>


                <div id="slider-direction-1" class="slider-direction">
                    <div class="slider-content t-lfr s-tb slider-2">
                        <div class="title-container s-tb-c">
                            <div class="s-title">
                                <a href="#">자세히 보기</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="slider-direction-2" class="slider-direction">
                    <div class="slider-content t-lfr s-tb slider-2">
                        <div class="title-container s-tb-c">
                            <div class="s-title">
                                <a href="#">자세히 보기</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="slider-direction-3" class="slider-direction">
                    <div class="slider-content t-lfr s-tb slider-2">
                        <div class="title-container s-tb-c">
                            <div class="s-title">
                                <a href="#">자세히 보기</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="slider-direction-4" class="slider-direction">
                    <div class="slider-content t-lfr s-tb slider-2">
                        <div class="title-container s-tb-c">
                            <div class="s-title">
                                <a href="#">자세히 보기</a>
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
<?php show_top_banner();?>
                   <div class="col-md-12">
                        <div class="ma-title">
                            <h2>
                                Best Sellers
                            </h2>
                        </div>
                        <div class="row">
                            <div class="features-carousel indicator-style">
<?php show_main_products('best', 10);?>
                            </div>
                        </div>
                    </div>
<?php show_middle_banner();?>
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
<?php show_bottom_banner();?>
                    </div>
                </div>
            </div>
        </section>
        <!-- end product_area
		============================================ -->

<?php include_once '../include/brands.php';?>

<?php include_once '../include/footer.php';?>

    </body>
</html>