<?php

include_once "../util/util.php";
include_once "../util/shop-functions.php";

session_start();

$p_sid  = set_var($_COOKIE['p_sid']);
$p_id   = set_var($_SESSION['p_id']);
$p_name = set_var($_SESSION['p_name']);

$com_info = get_company_info();

//로그인 이전의 URL로 돌아가기
$uri = set_var($_SERVER['HTTP_REFERER']);
// $uri = urlencode($uri);

?>

<!doctype html>
<html class="no-js" lang="ko">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?php echo $com_info['company_name']; ?></title>
        <meta name="keyword" content="<?php echo $com_info['keywords']; ?>">
        <meta name="description" content="<?php echo $com_info['description']; ?>">
        <meta property="og:title" content="<?php echo $com_info['site_name']; ?>"/>
        <meta property="og:site_name" content="<?php echo $com_info['company_name']; ?>"/>
        <meta property="og:url" content="<?php echo $com_info['homepage']; ?>" />
        <meta property="og:description" content="<?php echo $com_info['description']; ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico">

        <!-- FONTS -->
        <link href='//spoqa.github.io/spoqa-han-sans/css/SpoqaHanSans-kr.css' rel='stylesheet' type='text/css'>
        <link href='//spoqa.github.io/spoqa-han-sans/css/SpoqaHanSans-jp.css' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <link rel="stylesheet" href="/css/jquery-ui.min.css" >
        <link rel="stylesheet" href="/css/font-awesome.min.css">
        <link rel="stylesheet" href="/css/owl.carousel.css">
        <link rel="stylesheet" href="/css/owl.theme.css">
        <link rel="stylesheet" href="/css/owl.transitions.css">
        <link rel="stylesheet" href="/lib/css/nivo-slider.css" type="text/css" />
        <link rel="stylesheet" href="/lib/css/preview.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="/css/animate.css">
        <link rel="stylesheet" href="/css/meanmenu.min.css">
        <link rel="stylesheet" href="/css/img-zoom/jquery.simpleLens.css">
        <link rel="stylesheet" href="/css/normalize.css">

        <link rel="stylesheet" href="/css/main.css">
        <link rel="stylesheet" href="/css/style.css">
        <link rel="stylesheet" href="/css/myshop.css">
        <link rel="stylesheet" href="/css/responsive.css">
        <script src="/js/vendor/modernizr-2.8.3.min.js"></script>

        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
        <script src="/admin/js/html5shiv.js"></script>
        <script src="/admin/js/respond.min.js"></script>
        <![endif]-->
        <script src="/bbs/ckeditor/ckeditor.js" charset="utf-8"></script>

    </head>
    <body class="home-1">
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <!-- Add your site or application content here -->
        <!-- start header_area
		============================================ -->
        <header class="header_area">
            <div class="top-link">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <div class="top-logo">
                                <a href="/index.php"><img src="/images/shinsoo-logo.svg" alt="신수상사 로고"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <form action="/shop/catalog-list.php" method="get" id="search_mini_form">
                            <input type="hidden" name="mode" value="search" />
                                <div class="form-search s-same" >
                                    <input class="input-text" type="text" name="keyword" placeholder="검색하기">
                                    <button class="button" title="Search" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="header-wrapper">
                                <?php echo show_login_menu(); ?>
                            </div> <!-- /.header-wrapper -->
                        </div> <!-- /.col-md-4 col-sm-4 col-xs-12 -->

                    </div> <!-- /.row -->
                </div> <!-- /.container -->
            </div> <!-- /.header -->

            <div class="top-menu">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-xs-12">
                            <div class="left-category-menu">
                                <div class="left-product-cat">
                                    <div class="category-heading">
                                        <h2>브랜드</h2>
                                    </div>
                                    <div class="category-menu-list">
                                        <?php show_brands();?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9 col-md-8 hidden-xs ">
                            <div class="home_menu">
                                <nav>
                                    <ul>
                                        <li><a href="/member/about-us.php">회사 소개</a></li>
                                        <li><a href="/bbs/list.php?code=fitting">새소식</a></li>
                                        <li><a href="/member/contact-us.php">문의</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- mobile-menu-area start -->
            <div class="mobile-menu-area">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mobile-menu">
                                <nav id="dropdown">
                                    <ul>
                                        <li class="active1"><a href="/">Home</a></li>
                                        <li><a href="/member/about-us.php">회사 소개</a></li>
                                        <li><a href="/bbs/list.php?code=fitting">새소식</a></li>
                                        <li><a href="/member/contact-us.php">문의</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- mobile-menu-area end -->
        </header>
        <!-- end header_area
		============================================ -->