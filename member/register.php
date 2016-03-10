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
                                        <strong>회원가입</strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 client-say">
                            <div class="login-form-head">
                                <h2>기업회원 가입</h2>
                                <div class="register-intro">
                                    <p><span class="text-left"><i class="fa fa-arrow-circle-right"></i> 소매판매를 위한 기업회원은 도매로 구입이 가능합니다.</span></p>
                                    <p><span class="text-left"><i class="fa fa-arrow-circle-right"></i> 가입 후 관리자의 승인을 받아야 이용이 가능합니다.</span></p>
                                    <p><span class="text-left"><i class="fa fa-arrow-circle-right"></i> 기존 대리점 점주분들께서도 온라인 주문을 위해서는 가입하시고 관리자의 승인을 받아야 합니다.</span></p>
                                </div>
                                <div class="form-bottom-line about-optima-text">
                                    <button class="button2 elit" type="button" onclick="goto('/member/register-form.php');"><strong>가입하기</strong></button>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-6 client-say">
                            <div class="login-form-head">
                                <h2>개인회원 가입</h2>
                                <div class="register-intro">
                                    <p><span class="text-left"><i class="fa fa-arrow-circle-right"></i> 일반 구매를 위한 개인회원 가입입니다.</span></p>
                                </div>
                                <div class="form-bottom-line about-optima-text">
                                    <button class="button2 elit" type="button" onclick="goto('/member/p-register-form.php');"><strong>가입하기</strong></button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                             <div class="login-form-element">
                                <a class="btn btn-default" type="button" href="#">이용약관</a>
                                <a class="btn btn-default" type="button" href="#">정보보호정책</a>
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