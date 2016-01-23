<?php

//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

//메타정보
$info_query = "SELECT * FROM admin_setup";
$info_res = mysqli_query($connect, $info_query);
$info = mysqli_fetch_array($info_res);

?>
<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keyword" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="shortcut icon" href="/favicon.ico">

    <title><?=$info['company_name']?> :: 운영업체 관리자 홈</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/admin/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="/css/font-awesome.min.css" rel="stylesheet" />
    <link href="/admin/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
    <link rel="stylesheet" href="/admin/css/owl.carousel.css" type="text/css">

    <!--right slidebar-->
    <link href="/admin/css/slidebars.css" rel="stylesheet">

    <!-- Custom styles for this template -->

    <link href="/admin/css/style.css" rel="stylesheet">
    <link href="/admin/css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <section id="container" >
        <!--header start-->
        <?php include "../include/admin_head.php"; ?>
        <!--header end-->

        <!--sidebar start-->
        <?php include "../include/admin_sidebar.php"; ?>
        <!--sidebar end-->


        <!--main content start-->
        <section id="main-content">
          <section class="wrapper">

            <?php
            $num = set_var($_GET['num']);
            ?>

            <!-- search start-->
            <div class="row">
              <div class="col-sm-12">
                <section class="panel">
                  <header class="panel-heading table-head">
                      회원등록
                  </header>
                  <div class="panel-body">

                  <!-- <form name='primary' method='post' action='https://www.<?=$_SERVER['SERVER_NAME']?>:<?=$port?>/admin/member/mem_ins_ok.php'> -->
                  <form class="form-horizontal" role="form" name="primary" method="post" action="http://<?=$_SERVER['SERVER_NAME']?>/admin/member/mem_ins_ok.php">
                    <input type="hidden" name="num" value="<?=$num?>">
                    <div class="form-group">
                        <label for="id" class="col-lg-2 col-sm-2 control-label">아이디 :</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="id" id="id">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="company_name" class="col-lg-2 col-sm-2 control-label">비밀번호 :</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="passwd" id="passwd">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="company_name" class="col-lg-2 col-sm-2 control-label">거래형태 :</label>
                        <div class="col-sm-4">
                          <label class="checkbox-inline">
                            <input type="radio" name="seller" value="1" checked > 사입
                            <input type="radio" name="seller" value="2"> 당사배송 위탁거래
                            <input type="radio" name="seller" value="3"> 판매자배송 위탁거래
                          </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="company_name" class="col-lg-2 col-sm-2 control-label">기본할인율(VAT 포함) :</label>
                        <div class="col-sm-4 form-inline">
                            <input type="text" class="form-control" name="dc_rate" size="3"/> % DC
                            <label class="checkbox-inline">
                              <input type="radio" name="tax" value="E" checked > (VAT 별도)
                              <input type="radio" name="tax" value="I"> (VAT 포함)
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="company_name" class="col-lg-2 col-sm-2 control-label">사업자등록번호 :</label>
                        <div class="col-sm-4">
                          <label class="form-inline">
                            <input type="text" class="form-control" name="license_no1" size="3" maxlength="3"> -
                            <input type="text" class="form-control" name="license_no2" size="2" maxlength="2"> -
                            <input type="text" class="form-control" name="license_no3" size="5" maxlength="5"> 
                          </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="company_name" class="col-lg-2 col-sm-2 control-label">업체명 :</label>
                        <div class="col-sm-4">
                            <input class="form-control" type="text" name="company_name" id="company_name" size="15" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                          <button class="btn btn-success" onclick="javascript:document.primary.submit()">추가하기</button>
                          <button class="btn btn-default" onclick="javascript:document.primary.reset()">취소</button>
                        </div>
                    </div>
                  </form>
              </section>
            </div>
          </div>

       </section>
    </section>
    <!--main content end-->

     <!--footer start-->
    <?php include "../include/admin_footer.php"; ?>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="/js/jquery-2.1.1.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/admin/js/jquery.dcjqaccordion.2.7.js" class="include" type="text/javascript" ></script>
    <script src="/admin/js/jquery.scrollTo.min.js"></script>
    <script src="/admin/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="/admin/js/jquery.sparkline.js" type="text/javascript"></script>
    <!-- // <script src="jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script> -->
    <script src="/admin/js/owl.carousel.js" ></script>
    <script src="/admin/js/jquery.customSelect.min.js" ></script>
    <script src="/admin/js/respond.min.js" ></script>

    <!--common script for all pages-->
    <script src="/admin/js/common-scripts.js"></script>

    <!--script for this page-->
    <script src="/admin/js/sparkline-chart.js"></script>
    <!-- // <script src="js/easy-pie-chart.js"></script> -->
    <script src="/admin/js/count.js"></script>

    <!-- custom scripts -->
    <script src="/js/global.js" ></script>
    <script src="/admin/js/admin.js" ></script>

  <script>

      //owl carousel

      $(document).ready(function() {
          $("#owl-demo").owlCarousel({
              navigation : true,
              slideSpeed : 300,
              paginationSpeed : 400,
              singleItem : true,
              autoPlay:true

          });
      });

      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

  </script>

  </body>
</html>
