<?php include_once '../include/header.php';?>

        <!-- main slider -->
<?php show_main_banner();?>
        <!--main slider end-->
        <!-- start slider_area
		============================================ -->
        <section class="slider_area">
            <div class="container">
                <div class="row">
<?php show_top_banner();?>
                </div>
                <div class="row">
                   <div class="col-md-12">
                        <div class="ma-title">
                            <h2>
                                Best Sellers
                            </h2>
                        </div>
                        <div class="row">
                            <div class="features-carousel indicator-style">
<?php show_items_on_main('best', 10);?>
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
show_items_on_main('new', 10);
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
        <?php echo show_notice(); ?>
    </body>
</html>