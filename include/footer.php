        <!-- start ma-footer-stati
		============================================ -->
        <div class="ma-footer-static">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="container-inner">
                            <div class="footer-static-top">
                                <div class="row">

                                    <div class="f-col f-col2 col-md-6 hidden-sm col-xs-12">
                                        <div class="static_all">
<?php echo get_bbs_title('notice', 5); ?>
                                        </div>
                                    </div>
                                    <div class="f-col f-col3 col-md-3 col-sm-4  col-xs-12">
                                        <div class="static_all">
                                            <div class="footer-static-title">
                                                <h3>고객센터</h3>
                                            </div>
                                            <div class="footer-static-content">
                                                <ul>
                                                    <li>
<?php

$sessionId = set_var($_SESSION['p_id']);

if ($sessionId) {
    echo '                                                        <a href="/bbs/list.php?code=qna">1:1 문의</a>' . "\r\n";
} else {
    echo '                                                        <a href="/member/login.php">1:1 문의</a>' . "\r\n";
}

?>
                                                    </li>
                                                    <li>
                                                        <a href="/member/help.php">이용 안내</a>
                                                    </li>
                                                    <li>
                                                        <a href="/member/privacy-policy.php">이용약관/정보보호정책</a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="footer-escrow">
                                                <div class="escrowWrap">
                                                    <div class="escrow">
                                                        <script language="javascript" src="https://pgweb.dacom.net/WEB_SERVER/js/escrowValid.js"></script>
                                                        <span class=""><img src="/images/footer/pg-logo.png" alt=""/></span>
                                                        <span class="escrow-check"><a onclick="goValidEscrow('shinsoo');"><img src="/images/footer/pg-check.gif" alt="" style="cursor:hand"/></a></span>
                                                    </div>
                                                    <div class="text">
                                                        고객님은 현금으로 결제시  안전거래를 위해 구매<br/>
                                                        안전서비스를 받으실 수 있습니다.
                                                    </div>
                                                </div>
                                            </div> <!-- end footer_escrow -->

                                        </div>
                                    </div>
                                    <div class="f-col f-col4 col-md-3 col-sm-4  col-xs-12">
                                        <div class="footer-static-title">
                                            <h3>회사 정보</h3>
                                        </div>
                                        <div class="footer-static-content">
                                            <div class="footer-contact">
                                                <?php $com_info = get_company_info();?>
                                                <p class="company"><?php echo $com_info['company_name']; ?><br>
                                                (<?php echo $com_info['zipcode']; ?>)<?php echo $com_info['addr1']; ?><?php echo $com_info['addr2']; ?></p>
                                                <p class="phone">TEL:                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php echo $com_info['tel']; ?><br>
                                                FAX:                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php echo $com_info['fax']; ?><br>
                                                Email:                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php echo $com_info['email']; ?></p>
                                                <p>대표:                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php echo $com_info['ceo']; ?> | 사업자등록번호:<?php echo $com_info['license_no']; ?><br>
                                                통신판매업신고:                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         <?php echo $com_info['online_license']; ?><br>
                                                Hosting by 심플렉스인터넷(주)</p>
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
        <!-- end ma-footer-stati
		============================================ -->
        <!-- end footer-address
		============================================ -->
        <footer class="footer-address">
            <div class="container">
                <div class="container-inner">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <address>
                                Copyright ©
                                <a href="#">신수상사</a>
                                All Rights Reserved
                            </address>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="footer-payment">
                                <a href="#">
                                    <img alt="" src="/images/footer/footer-payment.png">
                                </a>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end footer-address
		============================================ -->
        <!-- start scrollUp
		============================================ -->
        <div id="toTop">
            <i class="fa fa-chevron-up"></i>
        </div>
        <!-- end scrollUp
		============================================ -->




		<!-- jquery
		============================================ -->
        <script src="/js/vendor/jquery-2.2.0.min.js"></script>
		<!-- bootstrap JS
		============================================ -->
        <script src="/js/bootstrap.min.js"></script>
		<!-- wow JS
		============================================ -->
        <script src="/js/wow.min.js"></script>
        <!-- Img Zoom js -->
		<script src="/js/img-zoom/jquery.simpleLens.min.js"></script>
		<!-- meanmenu JS
		============================================ -->
        <script src="/js/jquery.meanmenu.js"></script>
		<!-- owl.carousel JS
		============================================ -->
        <script src="/js/owl.carousel.min.js"></script>
		<!-- scrollUp JS
		============================================ -->
        <script src="/js/jquery.scrollUp.min.js"></script>
		<!-- Nivo slider js
		============================================ -->
		<script src="/lib/js/jquery.nivo.slider.js" type="text/javascript"></script>
		<script src="/lib/home.js" type="text/javascript"></script>
		<!-- plugins JS
		============================================ -->
        <script src="/js/plugins.js"></script>
		<!-- main JS
		============================================ -->
        <script src="/js/main.js"></script>
        <script src="/js/member.js"></script>
        <script src="/js/addcart.js"></script>
        <script src="/js/shopping.js"></script>

