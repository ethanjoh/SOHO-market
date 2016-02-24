<?php include_once '../include/header.php';?>

        <!-- start main_shop_area
		============================================ -->
        <section class="main_shop_area">
            <div class="breadcrumbs">
                <div class="container">
                    <div class="container-inner">
                        <ul class="tasnimm">
                            <li class="home">
                                <a href="#">Home</a>
                                <span>
                                    <i class="fa fa-angle-right"></i>
                                </span>
                            </li>
                            <li class="category3">
                                <strong>
<?php

	$mode    = set_var($_GET['mode']);
	$lcode   = set_var($_GET['lcode']);
	$mcode   = set_var($_GET['mcode']);
	$key     = set_var($_GET['key']);
	$keyword = set_var($_GET['keyword']);
	$page    = set_var($_GET['page']);

	show_brand_name($lcode);
?>
                                </strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="main_shop_all">
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 col-sm-3">
                            <div class="narrow-by-list">
                                <div class="block layered-attribute">
                                    <div class="block-title">
                                        <h2>서브 카테고리</h2>
                                    </div>
                                    <div class="odd">
                                        <?php show_sub_category($lcode);?>
                                    </div>
                                </div>
                            </div>
                        </div>
<?php

	//상품 리스트 페이징을 위한 페이지수 구하기
	// $scale         = get_list_page_num($mode, $key, $keyword, 1, 12);
	// $cline         = $scale[0];
	// $last_page_num = $scale[1];
	// $cpage         = $scale[2];
	// $totalpage     = $scale[3];

	$code_qry = '';

	//중분류 선택시
	if ($mcode) {
	    $code_qry = " AND category_m = '$mcode'";
	}

	if ("search" == $mode) {
	    $search_qry .= " AND (name LIKE '%$keyword%' OR prod_code LIKE '$keyword' OR company LIKE '%$keyword%') ";
	    $qry = "SELECT * FROM products WHERE approved='Y' AND del_chk != 'Y' $search_qry ";

	} else {
	    $qry = "SELECT * FROM products WHERE category_l='$lcode' AND del_chk != 'Y' AND approved='Y' $code_qry";
	}

	// 자료 총수 구하기
	$res   = mysqli_query($connect, $qry);
	$total = mysqli_num_rows($res);

	$scale = 12;
	// $page  = '';

	if ($page == '') {
	    $page = 1;
	}

	$cpage     = intval($page);
	$totalpage = intval($total / $scale);

	if ($totalpage * $scale != $total) {
	    $totalpage = $totalpage + 1;
	}

	if ($cpage == 1) {
	    $cline = 0;
	} else {
	    $cline = ($cpage * $scale) - $scale;
	}

	$limit = $cline + $scale;

	if ($limit >= $total) {
	    $limit = $total;
	}

	$last_page_num = $limit - $cline;

	if ($mode == "search") {
	    $search_qry .= " AND (name LIKE '%$keyword%' OR prod_code LIKE '$keyword' OR company LIKE '%$keyword%') ";
	    $query = "SELECT * FROM products WHERE approved='Y' AND del_chk != 'Y' $search_qry ORDER BY num DESC LIMIT $cline, $last_page_num";
	} else {
	    // $query = "SELECT * FROM products WHERE category_l='$lcode' $code_qry AND del_chk != 'Y' AND approved='Y' ORDER BY del_chk='N' DESC, created DESC LIMIT $cline, $last_page_num";
	    $query = "SELECT * FROM products WHERE del_chk='N'" . $code_qry . " AND approved = 'Y' ORDER BY num DESC LIMIT $cline, $last_page_num ";

	}

?>

                        <div class="col-md-9 col-sm-9 col-xs-12">
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="features-tab">
                                      <!-- Nav tabs -->
                                        <div class="shop-all-tab">
                                            <div class="two-part">
                                                <ul class="nav tabs" role="tablist">
                                                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-th-large"></i></a></li>
                                                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-align-justify"></i></a></li>
                                                </ul>
                                            </div>

                                        </div>
                                      <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="home">
                                                <div class="row">
                                                    <div class="shop-tab">
<?php
	//페이징을 위한 페이지수 구하기
	// $ret    = get_list_page_result($mode, $lcode, $mcode, $key, $keyword, $cline, $last_page_num);
	// $t_no   = $ret[0];
	// $result = $ret[1];

	// show_catalog_products($lcode, $mcode, 'home');
	// show_catalog_products($result, 'home');

	$tabid = 'home';

	// if ($mcode) {
	//     $code_qry = " AND category_l = '$lcode' AND category_m = '$mcode'";
	// } else {
	//     $code_qry = " AND category_l = '$lcode'";
	// }

	// $query  = "SELECT * FROM products WHERE del_chk='N'" . $code_qry . " AND approved = 'Y' ORDER BY num DESC LIMIT 0, 12 ";
	$result = mysqli_query($connect, $query);

	if ($result) {

	    for ($i = 0; $rows = mysqli_fetch_array($result); $i++) {

	        // $dealer_price = number_format($rows['retail_price']);
	        $item_name  = stripslashes($rows['name']);
	        $pnum       = $rows['num'];
	        $category_l = $rows['category_l'];
	        $category_m = $rows['category_m'];
	        $moq        = $rows['moq'];
	        $short_desc = $rows['short_desc'];
	        // $option       = $rows['opt'];
	        $p_id         = set_var($_SESSION['p_id']);
	        $offer_price  = calc_offer_price($rows['retail_price'], $p_id);
	        $dealer_price = number_format($offer_price);
	        $price        = show_me_price($pnum);

	        $option = show_option($pnum);

	        if ('home' == $tabid) {
	            echo <<<HEREDOC

                                <!-- single-product start -->
                                <form name="form_{$pnum}" method="post" action="">
                                <input type="hidden" name="pnum" id="pnum_{$pnum}" value="{$pnum}">
                                <div class="col-md-3">
                                    <div class="single-product">
                                        <div class="product-img">
                                            <a href="detail.php?pnum={$pnum}&lcode={$category_l}&mcode={$category_m}">
                                                <img class="primary-image" src="{$rows['b_image1_name']}" alt="" />
                                            </a>
                                        </div>
                                        <div class="product-content">
                                            <div class="price-box">
                                                {$price}
                                            </div>
                                            <h2 class="product-name"><a href="detail.php?pnum={$pnum}&lcode={$category_l}&mcode={$category_m}">{$item_name}</a></h2>
                                            <span class="desc">{$option}</span>
                                            <div class="product-icon">
HEREDOC;

	            if ($p_id) {
	                echo <<<HEREDOC
																																				                                                <input type="text" name="products_count" id="products_count_{$pnum}" value="{$moq}" size="2">
                                                <a href="#" id="{$pnum}" class="addCart_submit"><i class="fa fa-shopping-cart"></i></a>
                                                <div id="loadplace{$pnum}"></div>
                                                <input type="hidden" name="amount" id="amount_{$pnum}" value="{$offer_price}">
                                                <input type="hidden" name="from" id="from" value="list">
HEREDOC;

	            } else {
	                echo '                      <a href="/member/login.php"><i class="fa fa-shopping-cart"></i></a>';
	            }

	            echo <<<HEREDOC

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </form>
                                <!-- single-product end -->

HEREDOC;
	        } elseif ('profile' == $tabid) {
	            $option = show_option($pnum);

	            echo <<<HEREDOC
																																				                                <!-- single-product start -->
                                <form name="form_{$pnum}" method="post" action="">
                                <input type="hidden" name="pnum" id="pnum_{$pnum}" value="{$pnum}">
                                <div class="li-item">
                                    <div class="col-md-4 col-sm-4">
                                        <div class="single-product">
                                            <div class="product-img">
                                                <a href="detail.php?pnum={$pnum}&lcode={$category_l}&mcode={$category_m}&scode={$category_s}">
                                                    <img class="primary-image" src="{$rows['b_image1_name']}" alt="">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-8">
                                        <div class="f-fix">
                                            <h2 class="product-name">
                                                <a href="detail.php?pnum={$pnum}&lcode={$category_l}&mcode={$category_m}&scode={$category_s}">{$item_name}</a>
                                            </h2>
                                            <p class="desc">[모델:] {$short_desc}<br>
                                            <span class="spec">{$option}</span></p>
                                            <div class="p-box">
                                                {$price}
                                            </div>
                                            <div class="product-icon">
HEREDOC;
	            if ($p_id) {
	                echo '                      <input type="text" name="products_count" id="products_count_' . $pnum . '" value="' . $moq . '" size="2">
                                                <a href="#" id="' . $pnum . '" class="addCart_submit"><i class="fa fa-shopping-cart"></i></a>
                                                <div id="loadplace' . $pnum . '"></div>
                                                <input type="hidden" name="amount" id="amount_' . $pnum . '" value="' . $offer_price . '">
                                                <input type="hidden" name="from" id="from" value="list">';

	            } else {
	                echo '                      <a href="/member/login.php"><i class="fa fa-shopping-cart"></i></a>';
	            }

	            echo <<<HEREDOC
																																				                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </form>
                                <hr>
                                <!-- single-product end -->

HEREDOC;
	        }

	    }
	    //end for

	} else {
	    echo "<p>등록된 상품이 없습니다.</p><p>관리자 페이지 > 상품관리에서 상품을 등록해 주세요.</p>\n";
	}

?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="profile">
                                                <div class="row">
<?php
	//페이징을 위한 페이지수 구하기
	// $ret    = get_list_page_result($mode, $key, $keyword, $cline, $last_page_num);
	// $t_no   = $ret[0];
	// $result = $ret[1];

	// show_catalog_products($lcode, $mcode, 'profile');
?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="shop-all-tab">
                                            <div class="two-part">
                                                <ul class="nav tabs" role="tablist">
                                                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><i class="fa fa-th-large"></i></a></li>
                                                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-align-justify"></i></a></li>
                                                </ul>
                                                <div class="shop5 page">
<?php

	$url = $_SERVER['PHP_SELF'] . "?mode=" . $mode . "&amp;lcode=" . $lcode . "&amp;mcode=" . $mcode . "&amp;key=" . $key . "&amp;keyword=" . $keyword;
	page_nav($totalpage, $cpage, $url);

?>
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