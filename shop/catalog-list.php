<?php include_once '../include/header.php';?>

        <!-- start main_shop_area
		============================================ -->
        <section class="main_shop_area">
            <div class="breadcrumbs">
                <div class="container">
                    <div class="container-inner">
                        <ul class="tasnimm">
                            <li class="home">
                                <a href="/">Home</a>
                                <span>
                                    <i class="fa fa-angle-right"></i>
                                </span>
                            </li>
                            <li class="home-two">
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
<?php

if ($mcode) {
    echo <<<HEREDOC

                            <li class="category3">
                                <strong>
                                <span>
                                    <i class="fa fa-angle-right"></i>
                                </span>
HEREDOC;
    ?>
                                    <?php echo show_sub_category_name($lcode, $mcode); ?>

<?php

    echo <<<HEREDOC
                                </strong>
                            </li>

HEREDOC;
}

?>
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
$returnVal         = get_list_page_num($mode, $lcode, $mcode, $key, $keyword, $page, 12);
$scaleTimesPageNum = $returnVal[0];
$numPerPage        = $returnVal[1];
$currentPageNum    = $returnVal[2];
$totalPageNum      = $returnVal[3];

// echo "<pre>";
// print_r($returnVal);
// echo "</pre>";
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
$result = get_list_page_result($mode, $lcode, $mcode, $key, $keyword, $scaleTimesPageNum, $numPerPage);
show_items_on_catalog($result, 'home');
?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="profile">
                                                <div class="row">
<?php

//페이징을 위한 페이지수 구하기
$result = get_list_page_result($mode, $lcode, $mcode, $key, $keyword, $scaleTimesPageNum, $numPerPage);
show_items_on_catalog($result, 'profile');
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
page_nav($totalPageNum, $currentPageNum, $url);
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