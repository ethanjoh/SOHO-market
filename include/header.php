<?php
include_once "../util/config.php";
include_once "../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

session_start();

$p_sid = set_var($_COOKIE['p_sid']);

if (!$p_sid) {
    $SID = md5(uniqid(rand()));
    SetCookie("p_sid", $SID, 0, "/");
}

$p_id   = set_var($_SESSION['p_id']);
$p_name = set_var($_SESSION['p_name']);

if (isset($p_id)) {
    $mqry = "SELECT * FROM member WHERE id = '$_SESSION[p_id]' ";
    $mres = mysqli_query($connect, $mqry);
    $mrow = mysqli_fetch_array($mres);
}

$info_query = "SELECT * FROM admin_setup";
$info_res   = mysqli_query($connect, $info_query);
$info       = mysqli_fetch_array($info_res);

//로그인 이전의 URL로 돌아가기
$uri = $_SERVER["REQUEST_URI"];
$uri = urlencode($uri);

//메인설정 정보
$main_query = "SELECT * FROM main_setup";
$main_res   = mysqli_query($connect, $main_query);
$main       = mysqli_fetch_array($main_res);
?>

<!doctype html>
<html class="no-js" lang="ko">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title><?php echo $info['company_name']; ?></title>
        <meta name="keyword" content="<?php echo $info['keywords']; ?>">
        <meta name="description" content="<?php echo $info['description']; ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- favicon
		============================================ -->
        <link rel="shortcut icon" type="image/x-icon" href="/images/favicon.ico">
		<!-- Google Fonts
		============================================ -->
        <link href='http://fonts.googleapis.com/earlyaccess/notosanskr.css' rel='stylesheet' type='text/css'>
		<!-- Bootstrap CSS
		============================================ -->
        <link rel="stylesheet" href="/css/bootstrap.min.css">
		<!-- Font awesome CSS
		============================================ -->
        <link rel="stylesheet" href="/css/font-awesome.min.css">
		<!-- owl.carousel CSS
		============================================ -->
        <link rel="stylesheet" href="/css/owl.carousel.css">
        <link rel="stylesheet" href="/css/owl.theme.css">
        <link rel="stylesheet" href="/css/owl.transitions.css">
        <!-- nivo slider CSS
		============================================ -->
        <link rel="stylesheet" href="/lib/css/nivo-slider.css" type="text/css" />
        <link rel="stylesheet" href="/lib/css/preview.css" type="text/css" media="screen" />
		<!-- animate CSS
		============================================ -->
        <link rel="stylesheet" href="/css/animate.css">
		<!-- meanmenu CSS
		============================================ -->
        <link rel="stylesheet" href="/css/meanmenu.min.css">
        <!-- Image Zoom CSS
		============================================ -->
        <link rel="stylesheet" href="/css/img-zoom/jquery.simpleLens.css">
		<!-- normalize CSS
		============================================ -->
        <link rel="stylesheet" href="/css/normalize.css">
		<!-- main CSS
		============================================ -->
        <link rel="stylesheet" href="/css/main.css">
		<!-- style CSS
		============================================ -->
        <link rel="stylesheet" href="/css/style.css">
		<!-- responsive CSS
		============================================ -->
        <link rel="stylesheet" href="/css/responsive.css">
		<!-- modernizr JS
		============================================ -->
        <script src="/js/vendor/modernizr-2.8.3.min.js"></script>
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
                        <div class="col-md-6 col-sm-6">
                            <div class="outlink">
                                <ul>
                                    <li><a href="http://www.no1grip.co.kr/" target="_blank"><img src="/images/logo/no1grip-home.jpg" alt="no1grip"></a></li>
                                    <li><a href="http://www.superstroke.co.kr/" target="_blank"><img src="/images/logo/ss-home.jpg" alt="superstroke"></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <form action="#" id="search_mini_form">
                                <div class="form-search s-same" >
                                    <div class="select-wrapper">
                                        <select class="select">
                                            <option value="">상품명</option>
                                            <option value="">모델명</option>
                                        </select>
                                    </div>
                                    <input class="input-text" type="text" placeholder="검색하기">
                                    <button class="button" title="Search" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="header-wrapper">

<?php show_login_menu();?>

                            </div> <!-- /.header-wrapper -->
                        </div> <!-- /.col-md-4 col-sm-4 col-xs-12 -->

                    </div> <!-- /.row -->
                </div> <!-- /.container -->
            </div> <!-- /.header -->

            <div class="top-menu">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-sm-5">
                            <div class="left-category-menu  hidden-xs">
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
                        <div class="col-lg-9 col-md-8 col-sm-7">
                            <div class="home_menu">
                                <nav>
                                    <ul>
                                        <li><a href="about-us.html">회사 소개</a></li>
                                        <li><a href="blog.html">뉴스&amp;이벤트</a></li>
                                        <li><a href="#">대리점 안내</a></li>
                                        <li><a href="contact-us.html">제휴문의</a></li>
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
                                        <li class="active1"><a href="index.html">Home</a>
                                            <ul>
                                                <li><a href="index-2.html">Home 2</a></li>
                                                <li><a href="index-3.html">Home 3</a></li>
                                                <li><a href="index-4.html">Home 4</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="about-us.html">about us</a></li>
                                        <li><a href="blog.html">Blog</a></li>
                                        <li class="active1"><a href="#">Pages</a>
                                            <ul>
                                                <li><a href="about-us.html">about us</a></li>
                                                <li><a href="blog.html">blog</a></li>
                                                <li><a href="blog-details.html">blog details</a></li>
                                                <li><a href="checkout.html">checkout</a></li>
                                                <li><a href="contact-us.html">Contacts</a></li>
                                                <li><a href="shop.html">shop</a></li>
                                                <li><a href="single-product.html">single-product</a></li>
                                                <li><a href="shopping-cart.html">shopping-cart</a></li>
                                                <li><a href="wishlist.html">wishlist</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="contact-us.html">Contacts</a></li>
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