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
                        <div id="hastech"></div>
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
                                    <h1>문의</h1>
                                    <form class="">
                                        <div class="col-md-6 npl">
                                            <input id="InputName" class="form-control" type="text" placeholder="성함" required="">
                                        </div>
                                        <div class="col-md-6 contactemail npr">
                                            <input id="InputEmail" class="form-control" type="email" placeholder="연락처" required="">
                                        </div>
                                        <div class="col-md-12 margin-top-10">
                                            <textarea class="form-control margin-top-10" rows="13" placeholder="내용" required=""></textarea>
                                        </div>
                                        <button class="btn btnContact" type="submit">보내기</button>
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

        <!-- google map api
		============================================ -->
        <script src="http://maps.googleapis.com/maps/api/js"></script>
         <script>
            var myCenter=new google.maps.LatLng(37.5297013, 127.1309124);
            function initialize()
            {
            var mapProp = {
              center:myCenter,
              scrollwheel: false,
              zoom:17,
              mapTypeId:google.maps.MapTypeId.ROADMAP
              };
            var map=new google.maps.Map(document.getElementById("hastech"),mapProp);
            var marker=new google.maps.Marker({
              position:myCenter,
                animation:google.maps.Animation.BOUNCE,
              icon:'/images/map-marker.png',
                map: map,
              });

            marker.setMap(map);
            }
            google.maps.event.addDomListener(window, 'load', initialize);
        </script>
		<!-- main JS
		============================================ -->
        <script src="js/main.js"></script>
    </body>
</html>
