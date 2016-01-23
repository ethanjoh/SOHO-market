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

$sql_1 = "SELECT num FROM mall_order WHERE cancel='N' AND status='3' AND user_id <> 'guest' ";
$res_1 = mysqli_query($connect, $sql_1);
$unchk_total = mysqli_num_rows($res_1);

?>
<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keyword" content="">
    <link rel="shortcut icon" href="/favicon.ico">

    <title><?=$info['company_name']?> :: 운영업체 관리자 홈</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/admin/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="/css/font-awesome.min.css" rel="stylesheet" />

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

        <!-- info start-->
        <div class="row">
              <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading">
                사용방법
              </header>
              <ul class="info-body">
                <li><i class="fa fa-info-circle"></i> 택배 시스템에서 다운받은 운송장 파일을 콤마(,)로 분리된 <i class="fa fa-file-excel-o"></i> 파일명.csv 파일로 저장합니다.</li>
                <li><i class="fa fa-info-circle"></i> csv 파일의 첫 번째 줄부터 처리하므로 불필요한 열은 삭제 후 저장하시기 바랍니다.</li>
                <li><i class="fa fa-info-circle"></i> *.csv 파일을 업로드합니다.</li>
              </ul>
            </section>
          </div>
        </div>
        <!-- info end -->


        <form class="form-inline" role"form" method="post" name="myForm" id="myForm" enctype="multipart/form-data">
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading table-head">
                  운송장 파일 업로드 ( <i class="fa fa-file-excel-o"></i> *.csv )
              </header>
                <div class="panel-body">
                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <td>
                          <input class="form-control" type="file" id="userfile" name="userfile">
                          <button class="btn btn-success" onclick="document.myForm.submit();"><i class="fa fa-upload"></i> 업로드</button>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <div id="loading"></div>
                          <div id="result"><p class="text-center">처리 결과가 없습니다.</p></div>
                        </td>
                      </tr>
                    </table>
                  </div>
                </div>
              </section>
            </div>
          </div>
          </form>

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
    <script class="include" type="text/javascript" src="/admin/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="/admin/js/jquery.scrollTo.min.js"></script>
    <script src="/admin/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="/admin/js/respond.min.js" ></script>

    <!--common script for all pages-->
    <script src="/admin/js/common-scripts.js"></script>

    <!-- custom scripts -->
    <script src="/js/global.js" ></script>
    <script src="/admin/js/admin.js" ></script>

    <script>
    $(document).ready(function() {

     $('#myForm').submit(function (e) {
        e.preventDefault();

        setTimeout(function(){
          $('#loading').html('<img src="../images/indicator.gif"> loading...');
        }, 3000);

        var data = new FormData(this);

         // run ajax request
         $.ajax({
             type: "POST",
             data : data,
             url: "track_fromexcel_process.php",
             // dataType: 'json',
             cache: false,
             contentType: false,
             processData: false,
             success: function(data){
               // console.log(data);
               $("#result").html(data);
               $('#loading').hide();
             }
         });

     });


    });
    </script>

  </body>
</html>
