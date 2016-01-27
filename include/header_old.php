<header class="header sides">
    <div class="container htop">
        <div class="col-md-6 col-sm-5">
            <!-- <div class="col-md-6 contact-info"></div> -->
            <div class="logo pull-left">
                <a href="/main/index.php"><img class="align-bottom main-logo-top" src="../images/s-medics-logo.png"></a>
            </div>
            <div class="slogan hidden-xs">TOTAL SOLUTION FOR SURGERY</div>
        </div>
        <div class="col-md-6 col-sm-7 text-right login-top">
            <?php
if (!$_SESSION['p_id'] || !$_SESSION['p_name']) {; // not logged in status
    ?>
            <a href="" data-popup="login" class="a-login btn btn-primary btn-extra pull-right">Login</a>
            <?php
} else {; // logged in status
    ?>
            <div class="hcart text-right">
                <a href="/member/logout.php" class="a-login btn btn-warning btn-extra pull-right">Logout</a>
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
                <a href="/main/index.php"><img class="align-bottom main-logo-top-small" src="../images/s-medics-logo.png"></a>
            </div>
            <!-- <div class="col-md-1 col-sm-2 iconmenu pull-right"></div> -->
            <div class="col-md-4"></div> <!-- dummy -->
            <div class="col-md-8 col-sm-9 mainmenu">
                <button type="button" class="navbar-toggle pull-right" data-toggle="collapse" data-target="#navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbar-collapse">
                    <nav>
                        <ul class="nav navbar-nav nav-menu text-center">
                            <?php
if (!$_SESSION['p_id'] || !$_SESSION['p_name']) {; // not logged in status
    ?>
                            <li class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">About Us</a>
                                <ul class="dropdown-menu">
                                    <li><a href="/about/greeting.php">Greeting</a></li>
                                    <li><a href="/about/history.php">History</a></li>
                                    <li><a href="/about/location.php">Location</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a data-toggle="dropdown" class="dropdown-toggle" href="">Products</a>
                                <ul class="dropdown-menu">
                                    <?php show_category($connect);?>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" href="/about/contact-us.php">Contact Us</a>
                            </li>
                            <li class="dropdown">
                                <a data-toggle="dropdown-toggle" href="/bbs/list.php?code=notice">Notice <?=check_new_last_post($connect, 'notice', 3);?></a>
                            </li>
                            <?php
} else {
    ?>
                            <li class="dropdown">
                                <a class="dropdown-toggle" href="/shop/cart.php">Cart</a>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" href="/shop/catalog-list.php">Order</a>
                            </li>
                            <li class="dropdown">
                                <a data-toggle="dropdown-toggle" href="/shop/order-list.php">My Order</a>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" href="/member/register_form.php?mode=edit">Setting</a>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" href="/bbs/list.php?code=notice">Notice <?=check_new_last_post($connect, 'notice', 3);?></a>
                            </li>
                            <?php
}
?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>