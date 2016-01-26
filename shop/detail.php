<<<<<<< HEAD
<?php
include "../util/config.php";
include "../util/util.php";

$connect = my_connect($host,$dbid,$dbpass,$dbname);

if(!$_COOKIE[p_sid]){
    $SID = md5(uniqid(rand()));
    SetCookie("p_sid",$SID,0,"/");
}

$info_query = "SELECT * FROM admin_setup";
$info_res = mysqli_query($connect, $info_query);
$info = mysqli_fetch_array($info_res);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <meta name="keywords" content="<?=$info['keywords']?>" />
    <meta name="description" content="<?=$info['description']?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?=$info['site_name']?></title>
    <link href="favicon.ico" rel="shortcut icon" type="image/x-icon">
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <script src="../js/global.js"></script>
    <script src="../js/member.js"></script>

</head>
<body>

<!-- Preloader -->
<div id="preloader">
    <div id="status">&nbsp;</div>
</div>

<!-- WRAPPER -->
<div class="wrapper">

    <!-- HEADER -->
    <?php include "../include/header.php"; ?>
    <!-- /.header -->

    <?php
        $query = "SELECT * FROM products WHERE num='$pnum'";
        $result = mysqli_query($connect, $query);
        $rows = mysqli_fetch_array($result);
        mysqli_free_result($result);

        $lcode = $rows['category_l'];

        $l_qry = "SELECT * FROM products_category1 WHERE code='$lcode'";
        $l_res = mysqli_query($connect, $l_qry);
        $l_row = mysqli_fetch_array($l_res);

    ?>

    <!-- HOME -->
    <div class="overlay home small-size">
        <div class="bg bg-shop" data-stellar-background-ratio="0.5"></div>
        <div class="container vmiddle">
            <div class="row text-center">
                <div class="icon-big color icon-bag-shopping-streamline"></div>
                <h1><?=$l_row['name']?></h1>
            </div>
        </div>
    </div>
    <!-- /.home -->

    <!-- CONTENT -->
    <div class="content">

        <!-- CONTAINER: product -->
        <div class="container product padding-top">

            <!-- Product Gallery -->
            <div class="col-sm-6 product-gallery magnific-wrap">
                <div class="img-medium text-center">
                    <!-- <div class="sticker sticker-sale">sale</div> -->
                    <!-- Preview Slider -->
                    <div class="medium-slider">
                        <img src="<?=$rows['b_image1_name']?>" />
                    </div>
                </div>

                <!-- Thumbs Slider -->
                <!-- hidden -->
                <!--
                 <div class="thumbs-wrap">
                    <a href="" class="th-prev th-arrow pull-left">
                        <i class="custom-icon custom-icon-arrow-prev"></i>
                    </a>
                    <a href="" class="th-next th-arrow pull-right">
                        <i class="custom-icon custom-icon-arrow-next"></i>
                    </a>
                    <div class="thwrap">
                        <div class="thumbs-slider">
                            <a href="<?=$rows['b_image1_name']?>"><img src="<?=$rows['s_image_name']?>" /></a>
                        </div>
                    </div>
                </div>
                -->
            </div>
            <!-- /product gallery -->

            <form name="form_<?=$rows['num']?>" method="post" action="">
            <?php
                if(isset($_SESSION['p_id'])) {
                    echo "<input type=\"hidden\" name=\"from\" id=\"from\" value=\"detail\">\n";
                    $offer_price = $rows['retail_price'];
                }
            ?>
            <input type="hidden" name="pnum" id="pnum_<?=$rows['num']?>" value="<?=$pnum?>">

            <div class="col-sm-6">
                <div class="row">
                    <h2><?=$rows['name']?></h2>

                    <?php
                    if($_SESSION['p_id'] || $_SESSION['p_name']){
                    ?>                    

                    <div class="cost">
                        <span class="new"><i class="fa fa-krw"></i> <?=number_format($rows['retail_price'])?> (VAT 별도)</span>
                    </div>
                    
                    <?php
                    }
                    ?>

                </div>
                <div class="row">
                    <p>
                    <?php
                      if($rows['opt'])
                          show_option($rows);
                    ?>
                    </p>
                </div>

                <?php
                if($_SESSION['p_id'] || $_SESSION['p_name']){
                ?>                  

                <div class="row product-count">
                    <div class="counting inline-block">
                        <a href="" class="a-less disabled">-</a>
                        <input type="text" name="products_count" id="products_count_<?=$rows['num']?>" value="<?=$rows['moq']?>">
                        <a href="" class="a-more">+</a>
                    </div>
                    <a type="button" href="#" id="<?=$rows['num']?>" class="btn btn-primary addCart_submit" >장바구니 담기</a>
                    <div id="loadplace<?=$rows['num']?>"></div>
                    <input type="hidden" name="amount" id="amount_<?=$rows['num']?>" value="<?=$offer_price?>">
                </div>

                <?php
                }
                ?>                

                </form>

                <table class="product-table">
                    <tr>
                        <th>보험코드</th>
                        <td><span class="grey">000 568</span></td>
                    </tr>
                    <tr>
                      <th>제조/수입사</th>
                      <td><?=$rows['company']?> / <?=$rows['importer']?></h2></td>
                    </tr>
                    <tr>
                      <th>상품등록일 </th>
                      <td><?php
                        //      $r_date = explode("-", $rows['created']);
                                // echo $r_date[0]."년 ".$r_date[1]."월 <br/>";
                                echo $rows['created'];

                                ?></td>
                    </tr>
                    <tr>
                      <th>원산지</th>
                      <td><?=$rows['origin']?></td>
                    </tr>
                    <tr>
                      <th>크기 / 무게</th>
                      <td><?=$rows['size']?></td>
                    </tr>
                    <tr>
                      <th>재질</th>
                      <td><?=$rows['material']?></td>
                    </tr>
                    <tr>
                      <th>인증여부</th>
                      <td><?=$rows['auth']== NULL? "해당사항 없음" : $rows['auth']?></td>
                    </tr>
                    <tr>
                      <th>A/S</th>
                      <td><?=$rows['service']?></td>
                    </tr>
                    <tr>
                      <th>품질보증</th>
                      <td><?=$rows['warranty']?></td>
                    </tr>
                    <tr>
                      <th>취급시 유의사항</th>
                      <td><?=nl2br($rows['caution'])?></td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- /.container -->

        <!-- TABS -->
        <div class="tabs">
            <ul class="container nav nav-tabs text-center">
                <li class="active"><a href="#description" data-toggle="tab"><span>상세설명</span></a></li>
                <li><a href="#customtab" data-toggle="tab"><span>배송 및 반품</span></a></li>
            </ul>
            <div class="highlight">
                <div class="container tab-content">
                    <div class="tab-pane fade in active" id="description">
                        <div class="row">
                            <div class="col-sm-4">
                                <h2><?=$rows['name']?></h2>
                                <p class="grey">Product Information</p>
                            </div>
                            <div class="col-sm-4">
                                <h3>Information</h3>
                                <p>Mellentesque habitant morbi tristique senectus et netus et malesuada famesac turpis egestas. Ut non enim eleifend felis pretium feugiat. Dummy text of the printing and typesetting industry.</p>
                            </div>
                            <div class="col-sm-4">
                                <h3>Features</h3>
                                <ul>
                                    <li>Approx weight 3.0kg</li>
                                    <li>Two external zipped compartments</li>
                                    <li>Antiqued brass fittings</li>
                                    <li>Detachable shoulder strap</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="customtab">
                        <div class="row">
                            <div class="col-sm-4">
                                <h2>Delivery & Returns</h2>
                                <!-- <p class="grey">Product Information</p> -->
                            </div>
                            <div class="col-sm-4">
                                <h3>Delivery</h3>
                                <p>Habitant morbi tristique senectus et netus malesuada famesac turpis egestas. Ut non enim eleifend pretium feugiat. Dummy text of the printing and typesetting industry.</p>
                            </div>
                            <div class="col-sm-4">
                                <h3>Returns</h3>
                                <p>Dummy text of the printing and typesetting industry. Mellentesque habitant morbi tristique senectus et netus et malesuada famesac turpis egestas.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.tabs -->

    </div>
    <!-- /.content -->
</div>
<!-- /.wrapper -->

<!-- FOOTER -->
<?php include"../include/footer.php"; ?>

<script src="../js/jquery-2.1.1.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDv0RLj_LBhRntn4AOCr4zHSYv0-F8gVeA&sensor=false"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery.plugins.js"></script>
<script src="../js/custom.js"></script>
<script src="../js/addcart.js"></script>
<script src="../js/member.js"></script>

</body>
</html>

=======
<?php
include "../util/config.php";
include "../util/util.php";

$connect = my_connect($host,$dbid,$dbpass,$dbname);

if(!$_COOKIE[p_sid]){
    $SID = md5(uniqid(rand()));
    SetCookie("p_sid",$SID,0,"/");
}

$info_query = "SELECT * FROM admin_setup";
$info_res = mysqli_query($connect, $info_query);
$info = mysqli_fetch_array($info_res);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <meta name="keywords" content="<?=$info['keywords']?>" />
    <meta name="description" content="<?=$info['description']?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?=$info['site_name']?></title>
    <link href="favicon.ico" rel="shortcut icon" type="image/x-icon">
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <script src="../js/global.js"></script>
    <script src="../js/member.js"></script>

</head>
<body>

<!-- Preloader -->
<div id="preloader">
    <div id="status">&nbsp;</div>
</div>

<!-- WRAPPER -->
<div class="wrapper">

    <!-- HEADER -->
    <?php include "../include/header.php"; ?>
    <!-- /.header -->

    <?php
        $query = "SELECT * FROM products WHERE num='$pnum'";
        $result = mysqli_query($connect, $query);
        $rows = mysqli_fetch_array($result);
        mysqli_free_result($result);

        $lcode = $rows['category_l'];

        $l_qry = "SELECT * FROM products_category1 WHERE code='$lcode'";
        $l_res = mysqli_query($connect, $l_qry);
        $l_row = mysqli_fetch_array($l_res);

    ?>

    <!-- HOME -->
    <div class="overlay home small-size">
        <div class="bg bg-shop" data-stellar-background-ratio="0.5"></div>
        <div class="container vmiddle">
            <div class="row text-center">
                <div class="icon-big color icon-bag-shopping-streamline"></div>
                <h1><?=$l_row['name']?></h1>
            </div>
        </div>
    </div>
    <!-- /.home -->

    <!-- CONTENT -->
    <div class="content">

        <!-- CONTAINER: product -->
        <div class="container product padding-top">

            <!-- Product Gallery -->
            <div class="col-sm-6 product-gallery magnific-wrap">
                <div class="img-medium text-center">
                    <!-- <div class="sticker sticker-sale">sale</div> -->
                    <!-- Preview Slider -->
                    <div class="medium-slider">
                        <img src="<?=$rows['b_image1_name']?>" />
                    </div>
                </div>

                <!-- Thumbs Slider -->
                <!-- hidden -->
                <!--
                 <div class="thumbs-wrap">
                    <a href="" class="th-prev th-arrow pull-left">
                        <i class="custom-icon custom-icon-arrow-prev"></i>
                    </a>
                    <a href="" class="th-next th-arrow pull-right">
                        <i class="custom-icon custom-icon-arrow-next"></i>
                    </a>
                    <div class="thwrap">
                        <div class="thumbs-slider">
                            <a href="<?=$rows['b_image1_name']?>"><img src="<?=$rows['s_image_name']?>" /></a>
                        </div>
                    </div>
                </div>
                -->
            </div>
            <!-- /product gallery -->

            <form name="form_<?=$rows['num']?>" method="post" action="">
            <?php
                if(isset($_SESSION['p_id'])) {
                    echo "<input type=\"hidden\" name=\"from\" id=\"from\" value=\"detail\">\n";
                    $offer_price = $rows['retail_price'];
                }
            ?>
            <input type="hidden" name="pnum" id="pnum_<?=$rows['num']?>" value="<?=$pnum?>">

            <div class="col-sm-6">
                <div class="row">
                    <h2><?=$rows['name']?></h2>

                    <?php
                    if($_SESSION['p_id'] || $_SESSION['p_name']){
                    ?>                    

                    <div class="cost">
                        <span class="new"><i class="fa fa-krw"></i> <?=number_format($rows['retail_price'])?> (VAT 별도)</span>
                    </div>
                    
                    <?php
                    }
                    ?>

                </div>
                <div class="row">
                    <p>
                    <?php
                      if($rows['opt'])
                          show_option($rows);
                    ?>
                    </p>
                </div>

                <?php
                if($_SESSION['p_id'] || $_SESSION['p_name']){
                ?>                  

                <div class="row product-count">
                    <div class="counting inline-block">
                        <a href="" class="a-less disabled">-</a>
                        <input type="text" name="products_count" id="products_count_<?=$rows['num']?>" value="<?=$rows['moq']?>">
                        <a href="" class="a-more">+</a>
                    </div>
                    <a type="button" href="#" id="<?=$rows['num']?>" class="btn btn-primary addCart_submit" >장바구니 담기</a>
                    <div id="loadplace<?=$rows['num']?>"></div>
                    <input type="hidden" name="amount" id="amount_<?=$rows['num']?>" value="<?=$offer_price?>">
                </div>

                <?php
                }
                ?>                

                </form>

                <table class="product-table">
                    <tr>
                        <th>보험코드</th>
                        <td><span class="grey">000 568</span></td>
                    </tr>
                    <tr>
                      <th>제조/수입사</th>
                      <td><?=$rows['company']?> / <?=$rows['importer']?></h2></td>
                    </tr>
                    <tr>
                      <th>상품등록일 </th>
                      <td><?php
                        //      $r_date = explode("-", $rows['created']);
                                // echo $r_date[0]."년 ".$r_date[1]."월 <br/>";
                                echo $rows['created'];

                                ?></td>
                    </tr>
                    <tr>
                      <th>원산지</th>
                      <td><?=$rows['origin']?></td>
                    </tr>
                    <tr>
                      <th>크기 / 무게</th>
                      <td><?=$rows['size']?></td>
                    </tr>
                    <tr>
                      <th>재질</th>
                      <td><?=$rows['material']?></td>
                    </tr>
                    <tr>
                      <th>인증여부</th>
                      <td><?=$rows['auth']== NULL? "해당사항 없음" : $rows['auth']?></td>
                    </tr>
                    <tr>
                      <th>A/S</th>
                      <td><?=$rows['service']?></td>
                    </tr>
                    <tr>
                      <th>품질보증</th>
                      <td><?=$rows['warranty']?></td>
                    </tr>
                    <tr>
                      <th>취급시 유의사항</th>
                      <td><?=nl2br($rows['caution'])?></td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- /.container -->

        <!-- TABS -->
        <div class="tabs">
            <ul class="container nav nav-tabs text-center">
                <li class="active"><a href="#description" data-toggle="tab"><span>상세설명</span></a></li>
                <li><a href="#customtab" data-toggle="tab"><span>배송 및 반품</span></a></li>
            </ul>
            <div class="highlight">
                <div class="container tab-content">
                    <div class="tab-pane fade in active" id="description">
                        <div class="row">
                            <div class="col-sm-4">
                                <h2><?=$rows['name']?></h2>
                                <p class="grey">Product Information</p>
                            </div>
                            <div class="col-sm-4">
                                <h3>Information</h3>
                                <p>Mellentesque habitant morbi tristique senectus et netus et malesuada famesac turpis egestas. Ut non enim eleifend felis pretium feugiat. Dummy text of the printing and typesetting industry.</p>
                            </div>
                            <div class="col-sm-4">
                                <h3>Features</h3>
                                <ul>
                                    <li>Approx weight 3.0kg</li>
                                    <li>Two external zipped compartments</li>
                                    <li>Antiqued brass fittings</li>
                                    <li>Detachable shoulder strap</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="customtab">
                        <div class="row">
                            <div class="col-sm-4">
                                <h2>Delivery & Returns</h2>
                                <!-- <p class="grey">Product Information</p> -->
                            </div>
                            <div class="col-sm-4">
                                <h3>Delivery</h3>
                                <p>Habitant morbi tristique senectus et netus malesuada famesac turpis egestas. Ut non enim eleifend pretium feugiat. Dummy text of the printing and typesetting industry.</p>
                            </div>
                            <div class="col-sm-4">
                                <h3>Returns</h3>
                                <p>Dummy text of the printing and typesetting industry. Mellentesque habitant morbi tristique senectus et netus et malesuada famesac turpis egestas.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.tabs -->

    </div>
    <!-- /.content -->
</div>
<!-- /.wrapper -->

<!-- FOOTER -->
<?php include"../include/footer.php"; ?>

<script src="../js/jquery-2.1.1.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDv0RLj_LBhRntn4AOCr4zHSYv0-F8gVeA&sensor=false"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery.plugins.js"></script>
<script src="../js/custom.js"></script>
<script src="../js/addcart.js"></script>
<script src="../js/member.js"></script>

</body>
</html>

>>>>>>> 6ec2d8fb9810111cc3e9867ff370e9b6e5f67549
