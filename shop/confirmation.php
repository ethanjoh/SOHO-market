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
</head>
<body>

<!-- Preloader -->
<div id="preloader">
    <div id="status">&nbsp;</div>
</div>

<!-- WRAPPER -->
<div class="wrapper">

    <!-- HEADER -->
    <header class="header sides">
        <div class="container htop">
            <div class="col-md-8 col-sm-7">
                <div class="col-md-6 contact-info">
                    <span class="phone">+82 2 3437 8891</span>
                    <a class="a-email" href="mailto:info@smedics.co.kr">info@smedics.co.kr</a>
                </div>
                <div class="logo pull-left">
                    <a href="/index.php"><span class="color">S-Medics</span> solution</a>
                </div>
                <div class="slogan hidden-xs">TOTAL SOLUTION FOR SURGERY</div>
            </div>
            <div class="col-md-4 col-sm-5 text-right">

                <?php
                // 로그인 상태가 아닌 경우
                if(!$_SESSION['p_id'] || !$_SESSION['p_name']){
                ?>

                <a href="/member/register.php" class="btn btn-default">Join</a>
                <a href="" data-popup="login" class="a-login btn btn-primary pull-right">Login</a>

              <?php
                }else{
              ?>
                <div class="hcart pull-left">
                    <a href="/shop/cart.php"><i class="fa fa-shopping-cart"></i>cart</a> |
                    <a href="#"><i class="fa fa-file-text-o"></i>order</a> |
                    <a href="/member/register_form.php?mode=edit"><i class="fa fa-cog"></i></a>
                    <a href="/member/logout.php" class="a-login btn btn-warning pull-right">Logout</a>
                </div>

            <?php
                }  //end if
             ?>


            </div>
        </div>
        <div class="hbottom right-pos">
            <div class="container">
                <div class="col-md-4 col-sm-3 logo not-sticky">
                    <a href="/index.php"><span class="color">S-Medics</span> solution</a>
                </div>
                <div class="col-md-1 col-sm-2 iconmenu pull-right">
                    <a href="" class="a-search"><i class="custom-icon custom-icon-ico-search"></i></a>
                </div>
                <div class="col-md-4 contact-info">
                    <span class="phone">+82 2 3437 8891</span>
                    <a class="a-email" href="mailto:info@smedics.co.kr">info@smedics.co.kr</a>
                </div>
                <div class="col-md-7 col-sm-10 mainmenu">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbar-collapse">
                        <nav>
                            <ul class="nav navbar-nav text-center">
                                <li class="dropdown">
                                    <a data-toggle="dropdown"  class="dropdown-toggle" href="#">Our Company</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/about/about-us.php">About Us</a></li>
                                        <li><a href="/about/location.php">Location</a></li>
                                    </ul>
                                </li>

                               <li class="dropdown">
                                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Products</a>
                                    <ul class="dropdown-menu">

                                        <?php show_category($connect); ?>

                                    </ul>
                                </li>

                                <li class="dropdown">
                                    <a class="dropdown-toggle" href="/about/contact-us.php">Contact us</a>
                                </li>
                                <li class="dropdown">
                                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Help</a>
                                    <ul class="dropdown-menu">

                                        <?php show_bbs_list($connect); ?>

                                    </ul>
                                </li>

                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="search">
                <div class="container">
                    <form action="/">
                        <div class="col-sm-6 col-sm-offset-3 col-xs-10">
                            <input type="text" autofocus placeholder="Start typing...">
                        </div>
                        <div class="col-md-1 col-xs-2">
                            <a href="" class="sclose"><i class="custom-icon custom-icon-lightclose"></i></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </header>
    <!-- /.header -->

    <!-- HOME -->
    <div class="overlay home medium-size">
        <div class="bg bg-shop" data-stellar-background-ratio="0.5"></div>
        <div class="container vmiddle">
            <div class="row text-center">
                <div class="icon-big color icon-caddie-shopping-streamline"></div>
                <h1>Confirmation</h1>
            </div>
        </div>
    </div>
    <!-- /.home -->

    <!-- CONTENT -->
    <div class="content">

        <!-- container -->
        <div class="container border-bottom text-center">
            <div class="row">
                <h3 class="inherit">Thank you, your order have been recived</h3>
            </div>
        </div>
        <!-- /.container -->

        <!-- CONTAINER: cart -->
        <div class="container cart">

            <!-- row -->
            <div class="row padding-bottom">
                <div class="col-sm-4">
                    <h3>Order details</h3>
                    <p>Order # 009 234 45<br>
                        July 13, 2014<br>
                        Direct Bank Transfer<br>
                        Total $ 2 349,00</p>
                </div>
                <div class="col-sm-4">
                    <h3>Billing information</h3>
                    <p>Richard Flowers<br>
                        Camaro, LLC</p>
                    <p>Le Meridien Piccadilly<br>
                        21 Piccadilly<br>
                        London W1J 0BH<br>
                        United Kingdom</p>
                    <p>info@camaro.com<br>
                        +44 20 7734 8000</p>
                </div>
                <div class="col-sm-4">
                    <h3>Shipping information</h3>
                    <p>Richard Flowers<br>
                        Camaro, LLC</p>
                    <p>Le Meridien Piccadilly<br>
                        21 Piccadilly<br>
                        London W1J 0BH<br>
                        United Kingdom</p>
                </div>
            </div>
            <!-- /.row -->

            <!-- TABLE -->
            <div class="table-responsive">
                <table class="cart-table border-bottom">
                    <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">
                                <a href="detail.php"><img src="http://placehold.it/80x60" alt=""></a>
                            </td>
                            <td class="td-descr">
                                <a href="detail.php">Garment Bag in Tan Atlantic Leather </a>
                            </td>
                            <td>
                                <div class="cost">$ 59,00</div>
                            </td>
                            <td>
                                <div class="counting">1</div>
                            </td>
                            <td>
                                <div class="cost">$ 59,00</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <a href="detail.php"><img src="http://placehold.it/80x60" alt=""></a>
                            </td>
                            <td class="td-descr">
                                <a href="detail.php">Buckingham Leather 3-Bellows<br> Briefcase in Tan Miret Bridle</a>
                            </td>
                            <td>
                                <div class="cost">$ 1 060,00</div>
                            </td>
                            <td>
                                <div class="counting">2</div>
                            </td>
                            <td>
                                <div class="cost"> 1 060,00</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <a href="detail.php"><img src="http://placehold.it/80x60" alt="detail.php"></a>
                            </td>
                            <td class="td-descr">
                                <a href="detail.php">Grafton Laptop Briefcase in Sundance</a>
                            </td>
                            <td>
                                <div class="cost">$ 170,00</div>
                            </td>
                            <td>
                                <div class="counting">1</div>
                            <td>
                                <div class="cost">$ 170,00</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /table -->

            <!-- row -->
            <div class="row">
                <div class="col-sm-4 col-sm-offset-8">
                    <h3 class="normal">Cart Totals</h3>
                    <table class="cart-total">
                        <tr>
                            <th>Cart Subtotal</th>
                            <td>$ 2 349,00</td>
                        </tr>
                        <tr>
                            <th>Shipping</th>
                            <td>Free Shipping</td>
                        </tr>
                        <tr>
                            <th>Order Total</th>
                            <td>$ 2 349,00</td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container -->
    </div>
    <!-- /.content -->
</div>
<!-- /.wrapper -->

<!-- FOOTER -->
<footer class="footer">

    <!-- CONTAINER -->
    <div class="container">
        <div class="row foorow-2 foorow">
            <div class="col-sm-4">
                <h3><a href="contact-us.php">Contact</a></h3>
                <address>
                    <i class="fa fa-phone fa-fw"></i>+82 2 3437 8891<br>
                    <i class="fa fa-fax fa-fw"></i>+82 2 3437 8890<br>
                    <a href="mailto:info@smedics.co.kr">info@smedics.co.kr</a><br>
                    <p>#208, 6-9, Sukseonongju-ro,<br>
                        Jungnang-gu, Seoul, Korea<br>
                        131-848
                    </p>
                </address>
            </div>
            <div class="col-md-5 col-sm-4">
                <h3><a href="#">Notice</a></h3>
                <ul class="twitter-list">

                    <?php show_bbs('notice', $connect); ?>

                </ul>
            </div>
            <div class="col-md-3 col-sm-4">
                <h3>Help</h3>
                <div id="feedback-form">
                    <form action="http://aisconverse.us8.list-manage.com/subscribe/post?u=86ec31fd6b7533ccaa2435111&amp;id=a1293dd461" method="post">
                        <input name="EMAIL" placeholder="Your Email" required type="email" class="pull-left">
                        <button type="submit" class="btn btn-default pull-right">Ok</button>
                    </form>
                    <div class="success-block"></div>
                    <p>Mellentesque habitant morbi tristique senectus et netus et malesuada famesac turpis egestas.</p>
                </div>
            </div>
        </div>

        <div class="row foorow-3 foorow">
            <div class="col-md-6 col-sm-7">
                <a href="index.php" class="logo">S-Medics Solution</a>
                <p>&copy; 2015 S-Medics Solution. All Rights Reserved</p>
            </div>
        </div>
    </div>
    <!-- /.container -->
</footer>
<!-- /.footer -->

<!-- Popup: Login -->
<?php
//로그인 이전의 URL로 돌아가기
$uri = $_SERVER["REQUEST_URI"];
$uri = urlencode($uri);
?>

<div class="block-popup popup plogin" id="login">
    <a href="" class="pclose small"><i class="custom-icon custom-icon-close-s"></i></a>
    <h3 class="text-center">Login to account</h3>
    <!-- <form method='post' name='login' class="loginform" action='https://www.<?=$_SERVER['SERVER_NAME']?>:<?=$port?>/member/login_ok.php' onsubmit="JavaScript:return(login_check());"> -->
    <form method="post" name="loginform" class="loginform" action="http://<?=$_SERVER['SERVER_NAME']?>/member/login_ok.php">
      <input type="hidden" name="uri" value="<?=$uri?>">

        <div class="formwrap">
            <div class="form-group">
                <input type="text" class="form-control" name="id" placeholder="ID">
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control login-password" name="pwd" placeholder="Password" id="login-password">
            </div>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" value="">
                Remember me
            </label>
        </div>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-default block">Login</button>
            <a href="">Forgot password?</a>
        </div>

    </form>
    <div class="footlogin highlight text-center">
        <p><a href="privacy_policy.html" class="a-privacy text-center">Privacy Policy</a></p>
    </div>
</div>
<!-- /.popup -->

<!-- ScrollTop Button -->
<a href="#" class="scrolltop">
    <i class="custom-icon custom-icon-scrolltop"></i>
</a>

<script src="../js/jquery-2.1.1.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDv0RLj_LBhRntn4AOCr4zHSYv0-F8gVeA&sensor=false"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery.plugins.js"></script>
<script src="../js/custom.js"></script>
<script src="../js/global.js"></script>
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
</head>
<body>

<!-- Preloader -->
<div id="preloader">
    <div id="status">&nbsp;</div>
</div>

<!-- WRAPPER -->
<div class="wrapper">

    <!-- HEADER -->
    <header class="header sides">
        <div class="container htop">
            <div class="col-md-8 col-sm-7">
                <div class="col-md-6 contact-info">
                    <span class="phone">+82 2 3437 8891</span>
                    <a class="a-email" href="mailto:info@smedics.co.kr">info@smedics.co.kr</a>
                </div>
                <div class="logo pull-left">
                    <a href="/index.php"><span class="color">S-Medics</span> solution</a>
                </div>
                <div class="slogan hidden-xs">TOTAL SOLUTION FOR SURGERY</div>
            </div>
            <div class="col-md-4 col-sm-5 text-right">

                <?php
                // 로그인 상태가 아닌 경우
                if(!$_SESSION['p_id'] || !$_SESSION['p_name']){
                ?>

                <a href="/member/register.php" class="btn btn-default">Join</a>
                <a href="" data-popup="login" class="a-login btn btn-primary pull-right">Login</a>

              <?php
                }else{
              ?>
                <div class="hcart pull-left">
                    <a href="/shop/cart.php"><i class="fa fa-shopping-cart"></i>cart</a> |
                    <a href="#"><i class="fa fa-file-text-o"></i>order</a> |
                    <a href="/member/register_form.php?mode=edit"><i class="fa fa-cog"></i></a>
                    <a href="/member/logout.php" class="a-login btn btn-warning pull-right">Logout</a>
                </div>

            <?php
                }  //end if
             ?>


            </div>
        </div>
        <div class="hbottom right-pos">
            <div class="container">
                <div class="col-md-4 col-sm-3 logo not-sticky">
                    <a href="/index.php"><span class="color">S-Medics</span> solution</a>
                </div>
                <div class="col-md-1 col-sm-2 iconmenu pull-right">
                    <a href="" class="a-search"><i class="custom-icon custom-icon-ico-search"></i></a>
                </div>
                <div class="col-md-4 contact-info">
                    <span class="phone">+82 2 3437 8891</span>
                    <a class="a-email" href="mailto:info@smedics.co.kr">info@smedics.co.kr</a>
                </div>
                <div class="col-md-7 col-sm-10 mainmenu">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbar-collapse">
                        <nav>
                            <ul class="nav navbar-nav text-center">
                                <li class="dropdown">
                                    <a data-toggle="dropdown"  class="dropdown-toggle" href="#">Our Company</a>
                                    <ul class="dropdown-menu">
                                        <li><a href="/about/about-us.php">About Us</a></li>
                                        <li><a href="/about/location.php">Location</a></li>
                                    </ul>
                                </li>

                               <li class="dropdown">
                                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Products</a>
                                    <ul class="dropdown-menu">

                                        <?php show_category($connect); ?>

                                    </ul>
                                </li>

                                <li class="dropdown">
                                    <a class="dropdown-toggle" href="/about/contact-us.php">Contact us</a>
                                </li>
                                <li class="dropdown">
                                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Help</a>
                                    <ul class="dropdown-menu">

                                        <?php show_bbs_list($connect); ?>

                                    </ul>
                                </li>

                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <div class="search">
                <div class="container">
                    <form action="/">
                        <div class="col-sm-6 col-sm-offset-3 col-xs-10">
                            <input type="text" autofocus placeholder="Start typing...">
                        </div>
                        <div class="col-md-1 col-xs-2">
                            <a href="" class="sclose"><i class="custom-icon custom-icon-lightclose"></i></a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </header>
    <!-- /.header -->

    <!-- HOME -->
    <div class="overlay home medium-size">
        <div class="bg bg-shop" data-stellar-background-ratio="0.5"></div>
        <div class="container vmiddle">
            <div class="row text-center">
                <div class="icon-big color icon-caddie-shopping-streamline"></div>
                <h1>Confirmation</h1>
            </div>
        </div>
    </div>
    <!-- /.home -->

    <!-- CONTENT -->
    <div class="content">

        <!-- container -->
        <div class="container border-bottom text-center">
            <div class="row">
                <h3 class="inherit">Thank you, your order have been recived</h3>
            </div>
        </div>
        <!-- /.container -->

        <!-- CONTAINER: cart -->
        <div class="container cart">

            <!-- row -->
            <div class="row padding-bottom">
                <div class="col-sm-4">
                    <h3>Order details</h3>
                    <p>Order # 009 234 45<br>
                        July 13, 2014<br>
                        Direct Bank Transfer<br>
                        Total $ 2 349,00</p>
                </div>
                <div class="col-sm-4">
                    <h3>Billing information</h3>
                    <p>Richard Flowers<br>
                        Camaro, LLC</p>
                    <p>Le Meridien Piccadilly<br>
                        21 Piccadilly<br>
                        London W1J 0BH<br>
                        United Kingdom</p>
                    <p>info@camaro.com<br>
                        +44 20 7734 8000</p>
                </div>
                <div class="col-sm-4">
                    <h3>Shipping information</h3>
                    <p>Richard Flowers<br>
                        Camaro, LLC</p>
                    <p>Le Meridien Piccadilly<br>
                        21 Piccadilly<br>
                        London W1J 0BH<br>
                        United Kingdom</p>
                </div>
            </div>
            <!-- /.row -->

            <!-- TABLE -->
            <div class="table-responsive">
                <table class="cart-table border-bottom">
                    <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">
                                <a href="detail.php"><img src="http://placehold.it/80x60" alt=""></a>
                            </td>
                            <td class="td-descr">
                                <a href="detail.php">Garment Bag in Tan Atlantic Leather </a>
                            </td>
                            <td>
                                <div class="cost">$ 59,00</div>
                            </td>
                            <td>
                                <div class="counting">1</div>
                            </td>
                            <td>
                                <div class="cost">$ 59,00</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <a href="detail.php"><img src="http://placehold.it/80x60" alt=""></a>
                            </td>
                            <td class="td-descr">
                                <a href="detail.php">Buckingham Leather 3-Bellows<br> Briefcase in Tan Miret Bridle</a>
                            </td>
                            <td>
                                <div class="cost">$ 1 060,00</div>
                            </td>
                            <td>
                                <div class="counting">2</div>
                            </td>
                            <td>
                                <div class="cost"> 1 060,00</div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <a href="detail.php"><img src="http://placehold.it/80x60" alt="detail.php"></a>
                            </td>
                            <td class="td-descr">
                                <a href="detail.php">Grafton Laptop Briefcase in Sundance</a>
                            </td>
                            <td>
                                <div class="cost">$ 170,00</div>
                            </td>
                            <td>
                                <div class="counting">1</div>
                            <td>
                                <div class="cost">$ 170,00</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /table -->

            <!-- row -->
            <div class="row">
                <div class="col-sm-4 col-sm-offset-8">
                    <h3 class="normal">Cart Totals</h3>
                    <table class="cart-total">
                        <tr>
                            <th>Cart Subtotal</th>
                            <td>$ 2 349,00</td>
                        </tr>
                        <tr>
                            <th>Shipping</th>
                            <td>Free Shipping</td>
                        </tr>
                        <tr>
                            <th>Order Total</th>
                            <td>$ 2 349,00</td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container -->
    </div>
    <!-- /.content -->
</div>
<!-- /.wrapper -->

<!-- FOOTER -->
<footer class="footer">

    <!-- CONTAINER -->
    <div class="container">
        <div class="row foorow-2 foorow">
            <div class="col-sm-4">
                <h3><a href="contact-us.php">Contact</a></h3>
                <address>
                    <i class="fa fa-phone fa-fw"></i>+82 2 3437 8891<br>
                    <i class="fa fa-fax fa-fw"></i>+82 2 3437 8890<br>
                    <a href="mailto:info@smedics.co.kr">info@smedics.co.kr</a><br>
                    <p>#208, 6-9, Sukseonongju-ro,<br>
                        Jungnang-gu, Seoul, Korea<br>
                        131-848
                    </p>
                </address>
            </div>
            <div class="col-md-5 col-sm-4">
                <h3><a href="#">Notice</a></h3>
                <ul class="twitter-list">

                    <?php show_bbs('notice', $connect); ?>

                </ul>
            </div>
            <div class="col-md-3 col-sm-4">
                <h3>Help</h3>
                <div id="feedback-form">
                    <form action="http://aisconverse.us8.list-manage.com/subscribe/post?u=86ec31fd6b7533ccaa2435111&amp;id=a1293dd461" method="post">
                        <input name="EMAIL" placeholder="Your Email" required type="email" class="pull-left">
                        <button type="submit" class="btn btn-default pull-right">Ok</button>
                    </form>
                    <div class="success-block"></div>
                    <p>Mellentesque habitant morbi tristique senectus et netus et malesuada famesac turpis egestas.</p>
                </div>
            </div>
        </div>

        <div class="row foorow-3 foorow">
            <div class="col-md-6 col-sm-7">
                <a href="index.php" class="logo">S-Medics Solution</a>
                <p>&copy; 2015 S-Medics Solution. All Rights Reserved</p>
            </div>
        </div>
    </div>
    <!-- /.container -->
</footer>
<!-- /.footer -->

<!-- Popup: Login -->
<?php
//로그인 이전의 URL로 돌아가기
$uri = $_SERVER["REQUEST_URI"];
$uri = urlencode($uri);
?>

<div class="block-popup popup plogin" id="login">
    <a href="" class="pclose small"><i class="custom-icon custom-icon-close-s"></i></a>
    <h3 class="text-center">Login to account</h3>
    <!-- <form method='post' name='login' class="loginform" action='https://www.<?=$_SERVER['SERVER_NAME']?>:<?=$port?>/member/login_ok.php' onsubmit="JavaScript:return(login_check());"> -->
    <form method="post" name="loginform" class="loginform" action="http://<?=$_SERVER['SERVER_NAME']?>/member/login_ok.php">
      <input type="hidden" name="uri" value="<?=$uri?>">

        <div class="formwrap">
            <div class="form-group">
                <input type="text" class="form-control" name="id" placeholder="ID">
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control login-password" name="pwd" placeholder="Password" id="login-password">
            </div>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" value="">
                Remember me
            </label>
        </div>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-default block">Login</button>
            <a href="">Forgot password?</a>
        </div>

    </form>
    <div class="footlogin highlight text-center">
        <p><a href="privacy_policy.html" class="a-privacy text-center">Privacy Policy</a></p>
    </div>
</div>
<!-- /.popup -->

<!-- ScrollTop Button -->
<a href="#" class="scrolltop">
    <i class="custom-icon custom-icon-scrolltop"></i>
</a>

<script src="../js/jquery-2.1.1.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDv0RLj_LBhRntn4AOCr4zHSYv0-F8gVeA&sensor=false"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery.plugins.js"></script>
<script src="../js/custom.js"></script>
<script src="../js/global.js"></script>
<script src="../js/member.js"></script>

</body>
</html>
>>>>>>> 6ec2d8fb9810111cc3e9867ff370e9b6e5f67549
