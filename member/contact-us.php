<?php include_once '../include/header.php';?>

        <!-- start main_shop_area
		============================================ -->
        <section class="main_contact_area">
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
                                        <strong>문의 </strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row contact-content-area">
                        <h2>고객센터 -<strong> 연락처</strong></h2>
                        <div class="contact-baner">
                            <div class="contact-text">
                                <h2>Contact info</h2>
                                <p>get in touch</p>
                            </div>
                        </div>
                    </div>
                    <div class="row contact-map">
                        <h3>위치</h3>
                        <div id="map" style="height: 500px;"></div>
                    </div>
                    <div class="contact-from-atea">
                        <div class="form-and-info">
                            <div class="col-sm-5 col-md-4 npl">
                                <div class="contactDetails contactHead">
                                <?php $com_info = get_company_info();?>
                                    <h3>주소 및 연락처</h3>
                                    <p>
                                        <span class="iconContact">
                                            <i class="fa fa-map-marker"></i>
                                        </span>
                                        (<?php echo $com_info['zipcode']; ?>)<br>
                                        <?php echo $com_info['addr1']; ?> <?php echo $com_info['addr2']; ?>
                                    </p>
                                    <p>
                                        <span class="iconContact">
                                            <i class="fa fa-phone"></i>
                                        </span>
                                        TEL: <?php echo $com_info['tel']; ?>
                                        <br>
                                        FAX: <?php echo $com_info['fax']; ?>
                                    </p>
                                    <p>
                                        <span class="iconContact">
                                            <i class="fa fa-envelope-o"></i>
                                        </span>
                                        이메일: <?php echo $com_info['email']; ?>
                                        <br>
                                        웹사이트: <?php echo $com_info['homepage']; ?>
                                    </p>
                                </div>
                                <div class="social-area contactHead">
                                    <h3>패밀리 사이트</h3>
                                    <ul class="socila-icon">
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-facebook"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-twitter"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-7 col-md-8 npr">
                                <div class="contactfrom">
                                    <div class="alert alert-success hidden" id="contactSuccess">
                                        <strong>성공!</strong> 메시지를 보냈습니다.
                                    </div>

                                    <div class="alert alert-danger hidden" id="contactError">
                                        <strong>에러!</strong> 메시지를 보내는 중에 에러가 발생했습니다.
                                    </div>
                                    <h1>문의</h1>
                                    <form id="contactForm" action="php/contact-form.php" method="POST">
                                        <div class="form-group">
                                            <div class="col-md-4 npl">
                                                <label>성함 *</label>
                                                <input type="text" value="" data-msg-required="성함을 입력하세요." maxlength="100" class="form-control" name="name" id="name" required>
                                            </div>
                                            <div class="col-md-4 contactemail">
                                                <label>이메일 주소 *</label>
                                                <input type="email" value="" data-msg-required="이메일주소를 입력하세요." maxlength="100" class="form-control" name="email" id="email" required>
                                            </div>
                                            <div class="col-md-4 npr">
                                                <label>전화번호 *</label>
                                                <input type="tel" value="" data-msg-required="전화번호를 입력하세요."  maxlength="20" class="form-control" name="phone" id="phone" required>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label>제목</label>
                                                    <input type="text" value="" data-msg-required="제목을 입력하세요." maxlength="100" class="form-control" name="subject" id="subject" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label>문의내용 *</label>
                                                    <textarea maxlength="5000" data-msg-required="내용을 입력하세요." rows="10" class="form-control" name="message" id="message" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <input type="submit" value="문의 보내기" class="btn btnContact" data-loading-text="보내는 중...">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<?php include_once '../include/brands.php';?>

<?php include_once '../include/footer.php';?>


        <!-- 다음지도 사용 -->
        <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=bd304e45f96a8096611c3c07f751655c&libraries=services"></script>
        <script>
        var container = document.getElementById('map'); //지도를 담을 영역의 DOM 레퍼런스
        var options = { //지도를 생성할 때 필요한 기본 옵션
            center: new kakao.maps.LatLng(37.5296591, 127.1308992), //지도의 중심좌표.
            level: 3 //지도의 레벨(확대, 축소 정도)
        };

        var map = new kakao.maps.Map(container, options); //지도 생성 및 객체 리턴

        // 마커가 표시될 위치입니다
        var markerPosition  = new kakao.maps.LatLng(37.5296591, 127.1308992);

        // 마커를 생성합니다
        var marker = new kakao.maps.Marker({
            position: markerPosition
        });

        // 마커가 지도 위에 표시되도록 설정합니다
        marker.setMap(map);

        var iwContent = '<div style="padding:5px;">(주)신수트레이딩<br><a href="https://map.kakao.com/link/map/(주)신수트레이딩,37.5296591, 127.1308992" style="color:blue" target="_blank">큰지도보기</a> <a href="https://map.kakao.com/link/to/(주)신수트레이딩,37.5296591, 127.1308992" style="color:blue" target="_blank">길찾기</a></div>', // 인포윈도우에 표출될 내용으로 HTML 문자열이나 document element가 가능합니다
        iwPosition = new kakao.maps.LatLng(37.5296591, 127.1308992); //인포윈도우 표시 위치입니다

        // 인포윈도우를 생성합니다
        var infowindow = new kakao.maps.InfoWindow({
            position : iwPosition,
            content : iwContent
        });

        // 마커 위에 인포윈도우를 표시합니다. 두번째 파라미터인 marker를 넣어주지 않으면 지도 위에 표시됩니다
        infowindow.open(map, marker);

        // 일반 지도와 스카이뷰로 지도 타입을 전환할 수 있는 지도타입 컨트롤을 생성합니다
        var mapTypeControl = new kakao.maps.MapTypeControl();

        // 지도에 컨트롤을 추가해야 지도위에 표시됩니다
        // kakao.maps.ControlPosition은 컨트롤이 표시될 위치를 정의하는데 TOPRIGHT는 오른쪽 위를 의미합니다
        map.addControl(mapTypeControl, kakao.maps.ControlPosition.TOPRIGHT);

        // 지도 확대 축소를 제어할 수 있는  줌 컨트롤을 생성합니다
        var zoomControl = new kakao.maps.ZoomControl();
        map.addControl(zoomControl, kakao.maps.ControlPosition.RIGHT);
        </script>
		<!-- main JS
		============================================ -->
        <script src="/js/jquery.validation.min.js"></script>
        <script src="/js/view.contact.js"></script>

    </body>
</html>
