<?php include_once '../include/header.php';?>

<?php

$lcode = set_var($_GET['lcode']);
$mcode = set_var($_GET['mcode']);
$pnum  = set_var($_GET['pnum']);
// $p_id  = set_var($_SESSION['p_id']);

$contents = get_item_contents($pnum);

?>

        <!-- start main_slider_area
		============================================ -->
        <section class="shop-details-area">
            <div class="breadcrumbs">
                <div class="container">
                    <div class="container-inner">
                        <ul>
                            <li class="home">
                                <a href="/">Home</a>
                                <span>
                                    <i class="fa fa-angle-right"></i>
                                </span>
                            </li>
                            <li class="home-two">
                                <?php show_brand_name($lcode);?>
                                <span>
                                    <i class="fa fa-angle-right"></i>
                                </span>
                            </li>
                            <li class="category3">
                                <strong>
                                    <?php show_sub_category_name($lcode, $mcode);?>
                                </strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="shop-details">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 hidden-xs">
                            <div class="s_big">
                                <div>
                                    <?php echo show_item_images($pnum); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-6 col-xs-12">
                            <?php echo show_item_info($pnum); ?>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="ma-title">
                                <h2> 연관 상품 </h2>
                            </div>
                            <div class="all">
                                <div class=" content_top content_all indicator-style">
                                    <div class="ma-box-content-all">
                                        <?php echo show_relative_items($lcode, $mcode); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end main_slider_area
		============================================ -->
        <section class="tab_area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="text">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active">
                                    <a href="#desc" aria-controls="desc" role="tab" data-toggle="tab">상세 설명</a>
                                </li>
                                <li role="presentation">
                                    <a href="#delivery" aria-controls="delivery" role="tab" data-toggle="tab">배송 안내</a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="desc">
<?php echo $contents; ?>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="delivery">
                                    <div class="row">
                                        <div class="col-md-6 col-xs-12">
                                            <div class="customer-reviews">
                                                <div class="customer-reviews-one">
                                                    <h4>
                                                        <i class="fa fa-truck"></i> 배송 안내:
                                                    </h4>
                                                </div>
                                                <div class="customer-reviews-two">
                                                    <?php show_policy('d');?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="customer-reviews">
                                                <div class="customer-reviews-one">
                                                    <h4>
                                                        <i class="fa fa-retweet"></i> 환불/반품 안내:
                                                    </h4>
                                                </div>
                                                <div class="customer-reviews-two">
                                                    <?php show_policy('r');?>
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
        </section>


<?php include_once '../include/brands.php';?>

<?php include_once '../include/footer.php';?>

    </body>
</html>