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
                                <strong>아이디 찾기</strong>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                  <div class="panel-heading">아이디 찾기</div>
                  <div class="panel-body">
                    <form name="form1" method="post" action="p-find-id-ok.php">
                        <div class="form-group form-inline">
                            <label for="id">이메일:</label>
                            <input class="form-control" type="text" name="email" />
                        </div>
                        <div class="form-group form-inline">
                            <label for="license_no">휴대폰 번호:</label>
                            <input class="form-control"  size="3" name="phone_no1" OnKeyUp="p_focus_move();">
                            - <input class="form-control"  size="4" name="phone_no2" OnKeyUp="p_focus_move();">
                            - <input class="form-control" size="4" name="phone_no3" >
                        </div>
                        <p class="text-center">
                            <a class="btn btn-primary" href="#" onclick="find_p_id();"><span>찾기</span></a>
                            <a class="btn btn-default" href="/" ><span>취소</span></a>
                        </p>
                    </form>
                  </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                  <div class="panel-heading">비밀번호 초기화</div>
                  <div class="panel-body">
                    <form name="form2" method="post" action="p-find-pass-ok.php">
                        <div class="form-group form-inline">
                            <label for="id">아이디:</label>
                            <input class="form-control" type="text" name="id" />
                        </div>
                        <div class="form-group form-inline">
                            <label for="license_no">휴대폰 번호:</label>
                            <input class="form-control"  size="3" name="phone_no1" OnKeyUp="p_pw_move();">
                            - <input class="form-control" size="4" name="phone_no2" OnKeyUp="p_pw_move();">
                            - <input class="form-control" size="4" name="phone_no3" >
                        </div>
                        <p class="text-center">
                            <a class="btn btn-primary" href="#" onclick="find_p_pw();"><span>초기화</span></a>
                            <a class="btn btn-default" href="/" ><span>취소</span></a>
                        </p>
                    </form>
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