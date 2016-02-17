<?php
include "../util/config.php";
include "../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

if (!$_COOKIE[p_sid]) {
    $SID = md5(uniqid(rand()));
    SetCookie("p_sid", $SID, 0, "/");
}

$info_query = "SELECT * FROM admin_setup";
$info_res   = mysqli_query($connect, $info_query);
$info       = mysqli_fetch_array($info_res);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <meta name="keywords" content="<?php echo $info['keywords']; ?>" />
    <meta name="description" content="<?php echo $info['description']; ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $info['site_name']; ?></title>
    <link href="favicon.ico" rel="shortcut icon" type="image/x-icon">
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>

<!-- Preloader -->
<div id="preloader">
    <div id="status">&nbsp;</div>
</div>

<!-- WRAPPER -->
<div class="wrapper">

    <!-- HEADER -->
    <?php include "../include/header.php";?>
    <!-- /.header -->

<?php

if (!$_SESSION['p_id'] || !$_SESSION['p_name']) {; // not logged in status
    ?>

    <!-- HOME -->
    <div class="overlay home medium-size">
        <div class="bg bg-shop" data-stellar-background-ratio="0.5"></div>
        <div class="container vmiddle">
            <div class="row text-center">
                <div class="icon-big color icon-bag-shopping-streamline"></div>
                <h1>Products</h1>
            </div>
        </div>
    </div>
    <!-- /.home -->


<?php
} // end of if

$l_qry = "SELECT * FROM products_category1 WHERE code='$lcode'";
$l_res = mysqli_query($connect, $l_qry);
$l_row = mysqli_fetch_array($l_res);

if ($lcode) {
    // 카테고리로 들어왔을 때
    $query = "SELECT * FROM products WHERE category_l='$lcode' AND del_chk != 'Y' AND approved='Y' ";
} else {
    // 회원 로그인 후 바로 접속한 화면
    $query = "SELECT * FROM products WHERE del_chk != 'Y' AND approved='Y' ";
}

$result     = mysqli_query($connect, $query);
$total_bnum = mysqli_num_rows($result);

if (!$page) {
    $page = 1;
}

$p_scale   = 10;
$cpage     = intval($page);
$totalpage = intval($total_bnum / $p_scale);

if ($totalpage * $p_scale != $total_bnum) {
    $totalpage = $totalpage + 1;
}

if ($cpage == 1) {
    $cline = 0;
} else {
    $cline = ($cpage * $p_scale) - $p_scale;
}

$limit = $cline + $p_scale;

if ($limit >= $total_bnum) {
    $limit = $total_bnum;
}

$p_scale1 = $limit - $cline;
?>

    <!-- CONTENT -->
    <div class="content">

        <!-- CONTAINER: catalog-list -->
        <div class="container catalog catalog-list">

            <!-- catalog-bar -->
            <div class="col-sm-3 col-xs-4 catalog-bar">
                <!-- widget -->
                <div class="widget">
                    <h4 class="black"><a href="catalog-list.php">Products</a></h4>
                    <nav>
                        <ul>
<?php show_category($connect, 1);?>
                        </ul>
                    </nav>
                </div>
                <!-- /.widget -->
            </div>
            <!-- /.catalog-bar -->

            <!-- catalog-content -->
            <div class="col-sm-9 col-xs-8">

<?php

if (!$_SESSION['p_id'] || !$_SESSION['p_name']) {
    ; // not logged in status
    ?>

                <!-- before login -->
                <div class="tabs">
                    <span class="brand-title"><h3><?php echo $l_row['name']; ?></h3></span>
                        <ul class="container nav nav-tabs" role="tablist">

<?php
for ($i = 0; $rows = mysqli_fetch_array($result); $i++) {
        if ($i == 0) {
            $active = 'class="active"';
        } else {
            $active = '';
        }

        ?>

                            <li role="presentation" <?php echo $active; ?>><a href="#tab_<?php echo $i; ?>" data-toggle="tab" role="tab"><span><?php echo $rows['name']; ?></span></a></li>

<?php
}
    ; //end for $i loop
    ?>
                        </ul>

                        <div class="highlight">
                            <div class="tab-content">

<?php
if ($lcode) {
        // 카테고리로 들어왔을 때
        $query = "SELECT * FROM products WHERE category_l='$lcode' AND del_chk != 'Y' AND approved='Y' ";
    } else {
        // 전체카테고리 선택했을 때
        $query = "SELECT * FROM products WHERE del_chk != 'Y' AND approved='Y' ";
    }

    $result = mysqli_query($connect, $query);

    for ($j = 0; $rows = mysqli_fetch_array($result); $j++) {
        if ($j == 0) {
            $active = 'in active';
        } else {
            $active = '';
        }

        ?>
                                        <div role="tabpanel" class="tab-pane fade <?php echo $active; ?>" id="tab_<?php echo $j; ?>">
                                            <div class="row citem border-bottom">
                                                <!-- 이미지 섹션 -->
                                                <div class="col-sm-4">
                                                    <a href="detail.php?pnum=<?php echo $rows['num']; ?>&amp;lcode=<?php echo $lcode; ?>"><img src="<?php echo $rows['b_image1_name']; ?>" alt="<?php echo $rows['name']; ?>"></a>
                                                </div>
                                                <!-- 우측 정보섹션 -->
                                                <div class="col-sm-8 cdescription">
                                                    <div class="row">
                                                        <div class="col-sm-8">
                                                            <h3><a href="detail.php?pnum=<?php echo $rows['num']; ?>&amp;lcode=<?php echo $lcode; ?>" class="black"><?php echo $rows['name']; ?></a></h3>
                                                        </div>
                                                    </div>

                                                    <p>
<?php
if ($rows['opt']) {
            show_option($rows);
        }

        ?>
                                                    </p>

                                                    <div class="row ">
                                                        <div class="col-sm-12 margin-top-10">
<?php
if (!empty($rows['short_desc'])) {
            echo $rows['short_desc'];
        }

        ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- description -->
                                            </div>
                                        </div>
                                        <!-- tabpanel -->
                                    <!-- </div>  -->
<?php
}
    ; // end of for j loop
    ?>
                            </div>
                            <!-- tab-content -->
                        </div>
                        <!-- highlight -->
                </div>
                <!-- div tabs , before login end -->
<?php
} else {
    // after loggin

    if ($result) {
        for ($i = 0; $rows = mysqli_fetch_array($result); $i++) {
            ?>

                    <!-- row -->
                    <form name="form_<?php echo $rows['num']; ?>" method="post" action="">
                    <input type="hidden" name="pnum" id="pnum_<?php echo $rows['num']; ?>" value="<?php echo $rows['num']; ?>">
                    <input type="hidden" name="mode" id="mode_<?php echo $rows['num']; ?>" value="<?php echo $mode; ?>">
                    <input type="hidden" name="lcode" id="lcode_<?php echo $rows['num']; ?>" value="<?php echo $lcode; ?>">
                    <input type="hidden" name="mcode" id="mcode_<?php echo $rows['num']; ?>" value="<?php echo $mcode; ?>">
                    <input type="hidden" name="scode" id="scode_<?php echo $rows['num']; ?>" value="<?php echo $scode; ?>">
                    <input type="hidden" name="page" id="page_<?php echo $rows['num']; ?>" value="<?php echo $page; ?>">

<?php
if (isset($_SESSION['p_id'])) {
                echo "<input type=\"hidden\" name=\"from\" id=\"from\" value=\"list\">\n";
                // $offer_price = $rows['retail_price'];
            }
            ?>

                    <div class="row citem border-bottom">
                        <!-- 이미지 섹션 -->
                        <div class="col-sm-4">
                            <a href="detail.php?pnum=<?php echo $rows['num']; ?>&amp;lcode=<?php echo $lcode; ?>"><img src="<?php echo $rows['b_image1_name']; ?>" alt="<?php echo $rows['name']; ?>"></a>
                        </div>
                        <!-- 우측 정보섹션 -->
                        <div class="col-sm-8 cdescription">
                            <div class="row">
                                <div class="col-sm-8">
                                    <h3><a href="detail.php?pnum=<?php echo $rows['num']; ?>&amp;lcode=<?php echo $lcode; ?>" class="black"><?php echo $rows['name']; ?></a></h3>
                                </div>

<?php
// 로그인 상태인 경우
            if ($_SESSION['p_id'] || $_SESSION['p_name']) {
                ?>

                                <div class="col-sm-4 text-right">
<?php

                $offer_price = show_sup_price($connect, $_SESSION['p_id'], $rows['prod_code']);
                ?>
                                    <div class="cost new"><i class="fa fa-krw"></i> <?php echo number_format($offer_price); ?> (VAT 별도)</div>
                                </div>

<?php
}
            ?>

                            </div>

                            <p>
<?php
if ($rows['opt']) {
                show_option($rows);
            }

            ?>
                            </p>

<?php
if ($_SESSION['p_id'] || $_SESSION['p_name']) {
                ?>

                            <div class="row product-count">
<?php
$r = check_avail($connect, $_SESSION['p_id'], $rows['prod_code']);
                if ($r == "Y") {
                    ?>

                                <div class="counting inline-block">
                                    <a href="" class="a-less disabled">-</a>
                                    <input type="text" name="products_count" id="products_count_<?php echo $rows['num']; ?>" value="<?php echo $rows['moq']; ?>">
                                    <a href="" class="a-more">+</a>
                                </div>
                                <a type="button" href="#" id="<?php echo $rows['num']; ?>" class="btn btn-primary addCart_submit" >카트에 담기</a>
                                <div id="loadplace<?php echo $rows['num']; ?>"></div>
                                <input type="hidden" name="amount" id="amount_<?php echo $rows['num']; ?>" value="<?php echo $offer_price; ?>">

<?php
} else {
                    ?>

                                <a type="button" href="#" class="btn btn-warning" >구매 불가</a>

<?php
}
                ?>

                            </div>

<?php
}
            ; // end of login check
            ?>

<?php
if (!$_SESSION['p_id'] || !$_SESSION['p_name']) {
                ?>
                            <div class="row ">
                                <div class="col-sm-12 margin-top-10">
                                <?php
if (!empty($rows['short_desc'])) {
                    echo $rows['short_desc'];
                }

                ?>
                                </div>
                            </div>
<?php
}
            ?>

                        </div>
                    </div>
                    <!-- /.row -->
                    </form>

                <?php
} //end for loop
    }
    ; // end of if result
    ?>

            <?php
}
; //end loggin
?>

            </div>
            <!-- /catalog-content -->
        </div>
        <!-- /.container -->

        <!-- CONTAINER -->
        <div class="container">
            <div class="row text-center">
                <div class="col-md-12 col-sm-12">
                <?php
$url = "catalog-list.php?mode=" . $mode . "&amp;keyword=" . $keyword . "&amp;lcode=" . $lcode . "&mcode=" . $mcode . "&scode=" . $scode;
page_nav($totalpage, $cpage, $url);
?>
                </div>
            </div>
        </div>
        <!-- /.container -->
    </div>
    <!-- /.content -->
</div>
<!-- /.wrapper -->

<!-- FOOTER -->
<?php include "../include/footer.php";?>

<script src="../js/vendor/jquery-2.2.0.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery.plugins.js"></script>
<script src="../js/custom.js"></script>
<script src="../js/addcart.js"></script>
<script src="../js/global.js"></script>
<script src="../js/member.js"></script>

</body>
</html>

