<?php include_once '../include/header.php';?>

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
if (!$_SESSION['p_id'] || !$_SESSION['p_name']) {
    ?>

                <a href="/member/register.php" class="btn btn-default">Join</a>
                <a href="" data-popup="login" class="a-login btn btn-primary pull-right">Login</a>

              <?php
} else {
    ?>
                <div class="hcart pull-left">
                    <a href="/shop/cart.php"><i class="fa fa-shopping-cart"></i>cart</a> |
                    <a href="#"><i class="fa fa-file-text-o"></i>order</a> |
                    <a href="/member/register_form.php?mode=edit"><i class="fa fa-cog"></i></a>
                    <a href="/member/logout.php" class="a-login btn btn-warning pull-right">Logout</a>
                </div>

            <?php
}
; //end if
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

                                        <?php show_category($connect);?>

                                    </ul>
                                </li>

                                <li class="dropdown">
                                    <a class="dropdown-toggle" href="/about/contact-us.php">Contact us</a>
                                </li>
                                <li class="dropdown">
                                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">Help</a>
                                    <ul class="dropdown-menu">

                                        <?php show_bbs_list($connect);?>

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

<?php include_once '../include/brands.php';?>

<?php include_once '../include/footer.php';?>

    </body>
</html>

