<?php include_once '../include/header.php';?>

        <!-- start main_shop_area
		============================================ -->
        <section class="main_shop_area">
            <div class="breadcrumbs">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="container-inner">
                                <ul>
                                    <li class="home">
                                        <a href="#">Home</a>
                                        <span>
                                            <i class="fa fa-angle-right"></i>
                                        </span>
                                    </li>
                                    <li class="category3">
                                        <strong>로그인</strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 client-say">
                            <div class="login-form-head">
                                <h2>로그인</h2>
                                <form method="post" name="login" action="//<?php echo $_SERVER['SERVER_NAME']; ?>:<?php echo $port; ?>/member/login-ok.php" onsubmit="return(login_check());">
                                <div class="login-form">
                                    <input type="hidden" name="uri" value="<?php echo $uri; ?>">
                                    <ul>
                                        <li>
                                            <input class="form-control" type="text" name="id" placeholder="아이디">
                                        </li>
                                        <li>
                                            <input  class="form-control" type="password" name="pwd" placeholder="비밀번호">
                                        </li>
                                    </ul>
                                </div>
                                <div class="form-bottom-line about-optima-text">
                                    <button class="button2 elit" type="submit"><strong>로그인</strong></button>
                                </div>
                                </form>

                                <div class="login-form-element">
                                    <a class="btn btn-default" type="button" href="/member/register.php">가입하기</a>
                                    <a class="btn btn-default" type="button" href="/member/find-id.php">아이디 찾기</a>
                                    <a class="btn btn-default" type="button" href="/member/find-pass.php">비밀번호 찾기</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

        </section>

<?php include_once '../include/brands.php';?>

<?php include_once '../include/footer.php';?>

        <script src="/js/member.js"></script>

    </body>
</html>