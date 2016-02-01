<?php include_once '../include/header.php';?>

<?php

$lcode = set_var($_GET['lcode']);
$mcode = set_var($_GET['mcode']);
$pnum  = set_var($_GET['pnum']);
$p_id  = set_var($_SESSION['p_id']);

// if ($_GET) {
//     $lcode = $_GET['lcode'];
//     $mcode = $_GET['mcode'];
//     $pnum  = $_GET['pnum'];
// }

$query  = "SELECT * FROM products WHERE num='$pnum'";
$result = mysqli_query($connect, $query);
$rows   = mysqli_fetch_array($result);
mysqli_free_result($result);

$pnum          = $rows['num'];
$lcode         = $rows['category_l'];
$product_name  = $rows['name'];
$short_desc    = $rows['short_desc'];
$option        = $rows['opt'];
$b_image1_name = $rows['b_image1_name'];
$b_image2_name = $rows['b_image2_name'];
$b_image3_name = $rows['b_image3_name'];
$b_image4_name = $rows['b_image4_name'];
$s_image1_name = $rows['s_image1_name'];
$s_image2_name = $rows['s_image2_name'];
$s_image3_name = $rows['s_image3_name'];
$s_image4_name = $rows['s_image4_name'];
$contents      = $rows['contents'];

$l_qry = "SELECT * FROM products_category1 WHERE code='$lcode'";
$l_res = mysqli_query($connect, $l_qry);
$l_row = mysqli_fetch_array($l_res);

?>

        <!-- start main_slider_area
		============================================ -->
        <section class="shop-details-area">
            <div class="breadcrumbs">
                <div class="container">
                    <div class="container-inner">
                        <ul>
                            <li class="home">
                                <a href="#">Home</a>
                                <span>
                                    <i class="fa fa-angle-right"></i>
                                </span>
                            </li>
                            <li class="home-two">
<?php
show_brand_name($lcode);
?>

                                <span>
                                    <i class="fa fa-angle-right"></i>
                                </span>
                            </li>
                            <li class="category3">
                                <strong>
<?php
show_sub_category_name($lcode, $mcode);
?>
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
                                  <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div id="image1" class="tab-pane fade in active">
                                            <div class="simpleLens-big-image-container">
                                                <a class="simpleLens-lens-image" data-lens-image="<?php show_image('b', 1, $pnum);?>">
                                                    <img alt="" src="<?php show_image('b', 1, $pnum);?>" class="simpleLens-big-image">
                                                </a>
                                            </div>
                                        </div>
                                        <div id="image2" class="tab-pane fade">
                                            <div class="simpleLens-big-image-container">
                                                <a class="simpleLens-lens-image" data-lens-image="<?php show_image('b', 2, $pnum);?>">
                                                    <img alt="" src="<?php show_image('b', 2, $pnum);?>" class="simpleLens-big-image">
                                                </a>
                                            </div>
                                        </div>
                                        <div id="image3" class="tab-pane fade">
                                            <div class="simpleLens-big-image-container">
                                                <a class="simpleLens-lens-image" data-lens-image="<?php show_image('b', 3, $pnum);?>">
                                                    <img alt="" src="<?php show_image('b', 3, $pnum);?>" class="simpleLens-big-image">
                                                </a>
                                            </div>
                                        </div>
                                        <div id="image4" class="tab-pane fade">
                                            <div class="simpleLens-big-image-container">
                                                <a class="simpleLens-lens-image" data-lens-image="<?php show_image('b', 4, $pnum);?>" >
                                                    <img alt="" src="<?php show_image('b', 4, $pnum);?>" class="simpleLens-big-image">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="thumnail-image fix">
                                        <ul class="tab-menu">
                                            <li class="active"><a data-toggle="tab" href="#image1"><img alt="" src="<?php show_image('s', 1, $pnum);?>"></a></li>
                                            <li><a data-toggle="tab" href="#image2"><img alt="" src="<?php show_image('s', 2, $pnum);?>" ></a></li>
                                            <li><a data-toggle="tab" href="#image3"><img alt="" src="<?php show_image('s', 3, $pnum);?>"></a></li>
                                            <li><a data-toggle="tab" href="#image4"><img alt="" src="<?php show_image('s', 4, $pnum);?>"></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-6 col-xs-12">
                            <div class="cras">
                                <div class="product-name">
                                    <h1><?php echo $product_name; ?></h1>
                                </div>
                                <div class="pro-rating">
                                    모델명: <?php echo $short_desc; ?>
                                </div>
                                <p class="availability in-stock">
                                    재고:
                                    <span>In stock</span>
                                </p>
                                <div class="short-description">
                                    <p> <?php echo $option; ?> </p>
                                </div>
                                <div class="pre-box">
                                    <?php show_me_price($p_id, $pnum);?>
                                </div>
                                <div class="add-to-box1">
                                    <div class="add-to-box add-to-box2">
                                        <div class="add-to-cart">
                                            <div class="input-content">
                                                <label for="qty">수량:</label>
                                                <input id="qty" class="input-text qty" type="text" title="Qty" value="1" maxlength="12" name="qty">
                                            </div>
                                            <button class="button2 btn-cart" onclick="productAddToCartForm.submit(this)" title="" type="button">
                                                <span>카트담기</span>
                                            </button>
                                            <button class="button2 btn-cart" onclick="productAddToCartForm.submit(this)" title="" type="button">
                                                <span>주문하기</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <div class="ma-title">
                                <h2> 연관 상품 </h2>
                            </div>
                            <div class="all">
                                <div class=" content_top content_all indicator-style">
                                    <div class="ma-box-content-all">
                                        <div class="ma-box-content">
                                            <div class="product-img-right">
                                                <a href="#">
                                                    <img class="primary-image" alt="" src="../images/product/8.jpg">
                                                </a>
                                            </div>
                                            <div class="product-content">
                                                <h2 class="product-name">
                                                    <a href="#">Accumsan elit </a>
                                                </h2>
                                                <div class="pro-rating">
                                                    모델명:
                                                </div>
                                                <div class="price-box">
                                                    <span class="special">$333.00</span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="ma-box-content">
                                            <div class="product-img-right">
                                                <a href="#">
                                                    <img class="primary-image" alt="" src="../images/product/4.jpg">
                                                </a>
                                            </div>
                                            <div class="product-content">
                                                <h2 class="product-name">
                                                    <a href="#">Nunc facilisis</a>
                                                </h2>
                                                <div class="pro-rating">
                                                    모델명:
                                                </div>
                                                <div class="price-box">
                                                    <span class="special">$222.00</span>
                                                    <span class="old">$333.00</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ma-box-content">
                                            <div class="product-img-right">
                                                <a href="#">
                                                    <img class="primary-image" alt="" src="../images/product/5_1_1.jpg">
                                                </a>
                                            </div>
                                            <div class="product-content">
                                                <h2 class="product-name">
                                                    <a href="#">consequences</a>
                                                </h2>
                                                <div class="pro-rating">
                                                    모델명:
                                                </div>
                                                <div class="price-box">
                                                    <span class="special">$211.00</span>
                                                    <span class="old">$333.00</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ma-box-content">
                                            <div class="product-img-right">
                                                <a href="#">
                                                    <img class="primary-image" alt="" src="../images/product/4.jpg">
                                                </a>
                                            </div>
                                            <div class="product-content">
                                                <h2 class="product-name">
                                                    <a href="#">Nunc facilisis</a>
                                                </h2>
                                                <div class="pro-rating">
                                                    모델명:
                                                </div>
                                                <div class="price-box">
                                                    <span class="special">$222.00</span>
                                                    <span class="old">$333.00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ma-box-content-all">
                                        <div class="ma-box-content">
                                            <div class="product-img-right">
                                                <a href="#">
                                                    <img class="primary-image" alt="" src="../images/product/15_1.jpg">
                                                </a>
                                            </div>
                                            <div class="product-content">
                                                <h2 class="product-name">
                                                    <a href="#">Primis in faucibus</a>
                                                </h2>
                                                <div class="pro-rating">
                                                    모델명:
                                                </div>
                                                <div class="price-box">
                                                    <span class="special">$99.00</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ma-box-content">
                                            <div class="product-img-right">
                                                <a href="#">
                                                    <img class="primary-image" alt="" src="../images/product/4.jpg">
                                                </a>
                                            </div>
                                            <div class="product-content">
                                                <h2 class="product-name">
                                                    <a href="#">Nunc facilisis</a>
                                                </h2>
                                                <div class="pro-rating">
                                                    모델명:
                                                </div>
                                                <div class="price-box">
                                                    <span class="special">$222.00</span>
                                                    <span class="old">$333.00</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ma-box-content">
                                            <div class="product-img-right">
                                                <a href="#">
                                                    <img class="primary-image" alt="" src="../images/product/8.jpg">
                                                </a>
                                            </div>
                                            <div class="product-content">
                                                <h2 class="product-name">
                                                    <a href="#">Nunc facilisis</a>
                                                </h2>
                                                <div class="pro-rating">
                                                    모델명:
                                                </div>
                                                <div class="price-box">
                                                    <span class="special">$222.00</span>
                                                    <span class="old">$333.00</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ma-box-content">
                                            <div class="product-img-right">
                                                <a href="#">
                                                    <img class="primary-image" alt="" src="../images/product/17.jpg">
                                                </a>
                                            </div>
                                            <div class="product-content">
                                                <h2 class="product-name">
                                                    <a href="#">Nunc facilisis</a>
                                                </h2>
                                                <div class="pro-rating">
                                                    모델명:
                                                </div>
                                                <div class="price-box">
                                                    <span class="special">$222.00</span>
                                                    <span class="old">$333.00</span>
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
                                <div role="tabpanel" class="tab-pane active" id="desc"> <?php echo $contents; ?></div>
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