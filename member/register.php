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
                                    <p><span class="text-left"><i class="fa fa-arrow-circle-right"></i> 기업회원은 용품 판매자분들을 위한 가입메뉴입니다.</span></p>
                                    <p><span class="text-left"><i class="fa fa-arrow-circle-right"></i> 일반 소비자분들은 개인회원 가입을 이용해 주세요.</span></p>
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
                                    <p><span class="text-left"><i class="fa fa-arrow-circle-right"></i> 일반 소비자분들을 위한 개인회원 가입입니다.</span></p>
                                    <p><span class="text-left"><i class="fa fa-arrow-circle-right"></i> 판매자분들은 기업회원 가입을 이용해 주세요.</span></p>
                                    <div class="form-group" style="font-size: 12px;">
                                        <h5>개인정보 수집 및 이용동의</h5>
                                        <div class="col-md-12" style="margin-bottom: 10px; border: 1px dashed; padding: 10px;">
                                            이용자 식별 및 본인확인을 위해 성명, 아이디, 비밀번호를,
                                            계약이행을 위한 연락, 민원 등 고객의 고충처리를 위해 연락처(이메일, 휴대전화번호)를 수집하고 있으며, 보유기간은 회원탈퇴 시까지입니다.
                                        </div>
                                        <div class="checkbox">
                                            <label><input type="checkbox" id="agree" value="yes"> 개인정보 수집 및 이용에 동의합니다 </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-bottom-line about-optima-text">
                                    <button class="button2 elit" type="button" id="submit-btn"><strong>가입하기</strong></button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center">
                             <div class="login-form-element">
                                <a class="btn btn-default" type="button" href="/member/privacy-policy.php">이용약관</a>
                                <a class="btn btn-default" type="button" href="/member/privacy-policy.php">개인정보 처리방침</a>
                            </div>
                        </div>
                    </div>
                </div>

        </section>

<?php include_once '../include/brands.php';?>

<?php include_once '../include/footer.php';?>

        <script src="/js/member.js"></script>
        <script type="text/javascript">
        $(function(){
             $("#submit-btn").click(function () {
                var chk = $('#agree').is(":checked");//.attr('checked');
                if(!chk) {
                    alert("개인정보 수집 및 이용에 체크해 주세요");
                    return false;
                }else {
                    location.href = '/member/p-register-form.php';
                }
            });
        });
        </script>
        <!-- END: PAGE SCRIPTS -->
    </body>
</html>