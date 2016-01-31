<?php include_once '../include/header.php';?>

<?php

$lcode = (isset($_GET['lcode']) ? $_GET['lcode'] : '');
$mcode = (isset($_GET['mcode']) ? $_GET['mcode'] : '');
$pnum  = (isset($_GET['pnum']) ? $_GET['pnum'] : '');

// if ($_GET) {
//     $lcode = $_GET['lcode'];
//     $mcode = $_GET['mcode'];
//     $pnum  = $_GET['pnum'];
// }

$query  = "SELECT * FROM products WHERE num='$pnum'";
$result = mysqli_query($connect, $query);
$rows   = mysqli_fetch_array($result);
mysqli_free_result($result);

$lcode = $rows['category_l'];

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
                                                <a class="simpleLens-lens-image" data-lens-image="<?php echo $rows['b_image1_name']; ?>">
                                                    <img alt="" src="<?php echo $rows['b_image1_name']; ?>" class="simpleLens-big-image">
                                                </a>
                                            </div>
                                        </div>
                                        <div id="image2" class="tab-pane fade">
                                            <div class="simpleLens-big-image-container">
                                                <a class="simpleLens-lens-image" data-lens-image="<?php echo $rows['b_image2_name']; ?>">
                                                    <img alt="" src="<?php echo $rows['b_image2_name']; ?>" class="simpleLens-big-image">
                                                </a>
                                            </div>
                                        </div>
                                        <div id="image3" class="tab-pane fade">
                                            <div class="simpleLens-big-image-container">
                                                <a class="simpleLens-lens-image" data-lens-image="<?php echo $rows['b_image3_name']; ?>">
                                                    <img alt="" src="<?php echo $rows['b_image3_name']; ?>" class="simpleLens-big-image">
                                                </a>
                                            </div>
                                        </div>
                                        <div id="image4" class="tab-pane fade">
                                            <div class="simpleLens-big-image-container">
                                                <a class="simpleLens-lens-image" data-lens-image="<?php echo $rows['b_image4_name']; ?>" >
                                                    <img alt="" src="<?php echo $rows['b_image4_name']; ?>" class="simpleLens-big-image">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="thumnail-image fix">
                                        <ul class="tab-menu">
                                            <li class="active"><a data-toggle="tab" href="#image1"><img alt="" src="<?php echo $rows['s_image_name']; ?>"></a></li>
                                            <li><a data-toggle="tab" href="#image2"><img alt="" src="../images/product/5_1_1.jpg" ></a></li>
                                            <li><a data-toggle="tab" href="#image3"><img alt="" src="../images/product/3_2.jpg"></a></li>
                                            <li><a data-toggle="tab" href="#image4"><img alt="" src="../images/product/17.jpg"></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-6 col-xs-12">
                            <div class="cras">
                                <div class="product-name">
                                    <h1><?php echo $rows['name']; ?></h1>
                                </div>
                                <div class="pro-rating">
                                    모델명: <?php echo $rows['short_desc']; ?>
                                </div>
                                <p class="availability in-stock">
                                    재고:
                                    <span>In stock</span>
                                </p>
                                <div class="short-description">
                                    <p> <?php echo $rows['opt']; ?> </p>
                                </div>
                                <div class="pre-box">
                                    <span class="special-price"><i class="fa fa-krw"></i> 4,400</span>
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
                                <li role="presentation">
                                    <a href="#return" aria-controls="return" role="tab" data-toggle="tab">환불/반품 안내</a>
                                </li>
                            </ul>
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="desc">Nunc facilisis sagittis ullamcorper. Proin lectus ipsum, gravida et mattis vulputate, tristique ut lectus. Sed et lorem nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean eleifend laoreet congue. Vivamus adipiscing nisl ut dolor dignissim semper. Nulla luctus malesuada tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer enim purus, posuere at ultricies eu, placerat a felis. Suspendisse aliquet urna pretium eros convallis interdum. Quisque in arcu id dui vulputate mollis eget non arcu. Aenean et nulla purus. Mauris vel tellus non nunc mattis lobortis. Nunc facilisis sagittis ullamcorper. Proin lectus ipsum, gravida et mattis vulputate, tristique ut lectus. Sed et lorem nunc. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean eleifend laoreet congue. Vivamus adipiscing nisl ut dolor dignissim semper. Nulla luctus malesuada tincidunt. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer enim purus, posuere at ultricies eu, placerat a felis. Suspendisse aliquet urna pretium eros convallis interdum. Quisque in arcu id dui vulputate mollis eget non arcu. Aenean et nulla purus. Mauris vel tellus non nunc mattis lobortis. </div>
                                <div role="tabpanel" class="tab-pane" id="delivery">
                                    <div class="row">
                                        <div class="col-md-6 col-xs-12">
                                            <div class="customer-reviews">
                                                <div class="customer-reviews-one">
                                                    <p><a href="#">Plazathemes</a> <span>Review by</span> Plazathemes</p>
                                                </div>
                                                <div class="customer-reviews-two">
                                                    <p>Quality</p>
                                                    <div class="pro-rating">
                                                        <div class="pro_one">
                                                            <a href="#">
                                                                <i class="fa fa-star"></i>
                                                            </a>
                                                            <a href="#">
                                                                <i class="fa fa-star"></i>
                                                            </a>
                                                            <a href="#">
                                                                <i class="fa fa-star"></i>
                                                            </a>
                                                            <a href="#">
                                                                <i class="fa fa-star"></i>
                                                            </a>
                                                            <a href="#">
                                                                <i class="fa fa-star"></i>
                                                            </a>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="customer-reviews-two">
                                                    <p>Price</p>
                                                    <div class="pro-rating pro-ra-two">
                                                        <div class="pro_one">
                                                            <a href="#">
                                                                <i class="fa fa-star"></i>
                                                            </a>
                                                            <a href="#">
                                                                <i class="fa fa-star"></i>
                                                            </a>
                                                            <a href="#">
                                                                <i class="fa fa-star"></i>
                                                            </a>
                                                            <a href="#">
                                                                <i class="fa fa-star"></i>
                                                            </a>
                                                        </div>
                                                        <div class="pro_two">
                                                            <a href="#">
                                                                <i class="fa fa-star-o"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="customer-reviews-two">
                                                    <p>Value</p>
                                                    <div class="pro-rating pro-ra-two">
                                                        <div class="pro_one">
                                                            <a href="#">
                                                                <i class="fa fa-star"></i>
                                                            </a>
                                                            <a href="#">
                                                                <i class="fa fa-star"></i>
                                                            </a>
                                                            <a href="#">
                                                                <i class="fa fa-star"></i>
                                                            </a>
                                                            <a href="#">

                                                            </a>
                                                        </div>
                                                        <div class="pro_two">
                                                            <a href="#">
                                                                <i class="fa fa-star-o"></i>
                                                                <i class="fa fa-star-o"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="date">
                                                    <p>Plazathemes <small>(Posted on 9/11/2014)</small></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12">
                                            <div class="form-add table-responsive">
                                                <form action="#">
                                                    <div class="form-border">
                                                        <div class="add-text">
                                                            <h3>
                                                                You're reviewing:
                                                                <span>Cras neque metus</span>
                                                            </h3>
                                                            <h4>
                                                                How do you rate this product?*
                                                            </h4>
                                                        </div>
                                                        <table class="data-table">
                                                            <tr>
                                                                <th></th>
                                                                <th>1 star</th>
                                                                <th>2 stars</th>
                                                                <th>3 stars</th>
                                                                <th>4 stars</th>
                                                                <th>5 stars</th>
                                                            </tr>
                                                            <tr>
                                                                <td class="one two">Quality</td>
                                                                <td><input type="radio" name="ratings" required></td>
                                                                <td><input type="radio" name="ratings" required></td>
                                                                <td><input type="radio" name="ratings" required></td>
                                                                <td><input type="radio" name="ratings" required></td>
                                                                <td><input type="radio" name="ratings" required></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="one">Price</td>
                                                                <td><input type="radio" name="ratings" required></td>
                                                                <td><input type="radio" name="ratings" required></td>
                                                                <td><input type="radio" name="ratings" required></td>
                                                                <td><input type="radio" name="ratings" required></td>
                                                                <td><input type="radio" name="ratings" required></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="one">Value</td>
                                                                <td><input type="radio" name="ratings" required></td>
                                                                <td><input type="radio" name="ratings" required></td>
                                                                <td><input type="radio" name="ratings" required></td>
                                                                <td><input type="radio" name="ratings" required></td>
                                                                <td><input type="radio" name="ratings" required></td>
                                                            </tr>
                                                        </table>
                                                        <div class="input-one form-list">
                                                            <label class="required">Nickname<em>*</em></label>
                                                            <input type="text" class="email" required>
                                                        </div>
                                                        <div class="input-one">
                                                            <label class="required">Summary of Your Review<em>*</em></label>
                                                            <input type="text" class="email" required>
                                                        </div>
                                                        <div class="input-one">
                                                            <label class="required">Review<em>*</em></label>
                                                            <textarea class="email"></textarea>
                                                        </div>
                                                        <button class="button2 btn-cart btn-in" type="button" title="">
                                                            <span>Submit Review</span>
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="return">
                                    <div class="box-collateral">
                                        <h3>Other people marked this product with these tags:</h3>
                                        <p><a href="#">Clothing</a>(3)</p>
                                    </div>
                                    <div class="input-two">
                                        <label class="required">Add Your Tags:</label>
                                        <input type="text" class="email tags" required>
                                        <button class="button2 btn-cart btn-a" type="button" title="">
                                            <span>Add Tags</span>
                                        </button>
                                    </div>
                                    <p class="note">Use spaces to separate tags. Use single quotes (') for phrases.</p>
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