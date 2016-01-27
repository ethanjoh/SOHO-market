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
main_show_products('best', 10);

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
main_show_products('new', 10);

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
        <!-- start shop_area
        ============================================ -->
        <section class="shop_area">
            <div class="container">

                <div class="row">
                    <div class="col-md-12">
                        <div class="title ma-title lab">
                            <h2>
                                Our brands
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="item_all indicator-style">
                        <div class="col-md-12">
                            <img class="primary-img" src="/images/brand/tigerchoi.jpg" alt="" />
                        </div>
                        <div class="col-md-12">
                            <img class="primary-img" src="/images/brand/no1grip.jpg" alt="" />
                        </div>
                        <div class="col-md-12">
                            <img class="primary-img" src="/images/brand/superstroke.jpg" alt="" />
                        </div>
                        <div class="col-md-12">
                            <img class="primary-img" src="/images/brand/winn.jpg" alt="" />
                        </div>
                        <div class="col-md-12">
                            <img class="primary-img" src="/images/brand/tigershark.jpg" alt="" />
                        </div>
                        <div class="col-md-12">
                            <img class="primary-img" src="/images/brand/griptech.jpg" alt="" />
                        </div>
                        <div class="col-md-12">
                            <img class="primary-img" src="/images/brand/golfpride.jpg" alt="" />
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end shop_area
        ============================================ -->

        <!-- start ma-footer-stati
		============================================ -->
        <div class="ma-footer-static">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="container-inner">
                            <div class="footer-static-top">
                                <div class="row">
                                    <div class="f-col f-col1 col-md-3 col-sm-4 col-xs-12">
                                        <div class="static_all">
                                            <div class="footer-static-title">
                                                <h3>My Account</h3>
                                            </div>
                                            <div class="footer-static-content">
                                                <ul>
                                                    <li>
                                                        <a href="#">My Account</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Login</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">My Cart</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Wishlist</a>
                                                    </li>
                                                    <li class="last">
                                                        <a href="#">Checkout</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="f-col f-col2 col-md-3 hidden-sm col-xs-12">
                                        <div class="static_all">
                                            <div class="footer-static-title">
                                                <h3>공지사항</h3>
                                            </div>
                                            <div class="footer-static-content">
                                                <ul>
                                                    <li>
                                                        <a href="#">Sitemap</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Privacy Policy</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Advanced Search</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Privacy Policy</a>
                                                    </li>
                                                    <li class="last">
                                                        <a href="#">Contact Us</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="f-col f-col3 col-md-3 col-sm-4  col-xs-12">
                                        <div class="static_all">
                                            <div class="footer-static-title">
                                                <h3>고객센터</h3>
                                            </div>
                                            <div class="footer-static-content">
                                                <ul>
                                                    <li>
                                                        <a href="#">Product Recall</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Gift Vouchers</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Returns and Exchanges</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Shipping Options</a>
                                                    </li>
                                                    <li class="last">
                                                        <a href="#">Gift Vouchers</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="f-col f-col4 col-md-3 col-sm-4  col-xs-12">
                                        <div class="footer-static-title">
                                            <h3>회사 정보</h3>
                                        </div>
                                        <div class="footer-static-content">
                                            <div class="footer-contact">
                                                <p class="company">신수상사</p>
                                                <p class="address">서울특별시 강동구 성내로 17길 66</p>
                                                <p class="phone">TEL: 02-479-2142</p>
                                                <p class="fax">FAX: 02-479-2141</p>
                                                <p class="email">Email: griptech@hanmail.net</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end ma-footer-stati
		============================================ -->
        <!-- end footer-address
		============================================ -->
        <footer class="footer-address">
            <div class="container">
                <div class="container-inner">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <address>
                                Copyright ©
                                <a href="#">신수상사</a>
                                All Rights Reserved
                            </address>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="footer-payment">
                                <a href="#">
                                    <img alt="" src="/images/footer/payment.png">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end footer-address
		============================================ -->
        <!-- start scrollUp
		============================================ -->
        <div id="toTop">
            <i class="fa fa-chevron-up"></i>
        </div>
        <!-- end scrollUp
		============================================ -->
		<!-- jquery
		============================================ -->
        <script src="/js/vendor/jquery-2.2.0.min.js"></script>
		<!-- bootstrap JS
		============================================ -->
        <script src="/js/bootstrap.min.js"></script>
		<!-- wow JS
		============================================ -->
        <script src="/js/wow.min.js"></script>
		<!-- price-slider JS
		============================================ -->
        <script src="/js/jquery-price-slider.js"></script>
        <!-- Img Zoom js -->
		<script src="/js/img-zoom/jquery.simpleLens.min.js"></script>
		<!-- meanmenu JS
		============================================ -->
        <script src="/js/jquery.meanmenu.js"></script>
		<!-- owl.carousel JS
		============================================ -->
        <script src="/js/owl.carousel.min.js"></script>
		<!-- scrollUp JS
		============================================ -->
        <script src="/js/jquery.scrollUp.min.js"></script>
		<!-- Nivo slider js
		============================================ -->
		<script src="/lib/js/jquery.nivo.slider.js" type="text/javascript"></script>
		<script src="/lib/home.js" type="text/javascript"></script>
		<!-- plugins JS
		============================================ -->
        <script src="/js/plugins.js"></script>
		<!-- main JS
		============================================ -->
        <script src="/js/main.js"></script>
    </body>
</html>
