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

$id = set_var($_GET['id']);
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
    <link href="/admin/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
    <link rel="stylesheet" href="/admin/css/owl.carousel.css" type="text/css">

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
      <div class="row">
        <div class="col-sm-12">
          <section class="panel">
            <header class="panel-heading table-head">
                아이디 중복확인
            </header>
            <div class="panel-body">
              <form method="get" name="id_check" action="id_check.php">
              <table class="table">
                <tbody>
                <?
                  $query  = "SELECT id FROM member WHERE id='$id'";
                  $result = mysqli_query($connect, $query);
                  $total_num = mysqli_num_rows($result);
                  if($total_num){
                ?>
                  <tr>
                    <td>
                      <p>선택하신 아이디 : <?=$id?> 는 현재 사용 중인 아이디입니다.</p>
                    </td>
                  </tr>
                </tbody>
              </table>

              <div class="row text-center">
                <div class="col-sm-12">
                  <input type="text" class="form-control" name="id" size="15">
                  <a type="button" class="btn btn-success" href="#" onClick="javascript:send(id_check);">재검색</a>
                  <a type="button" class="btn btn-default" href="#" onclick="javascript:window.close();">닫 기</a>
                </div>
              </div>

                <?
                }else{
                ?>
                <tr>
                  <td>
                    <p>선택하신 아이디 : <?=$id?> 는 사용하실 수 있습니다.</p>
                  </td>
                </tr>
                </tbody>
              </table>

              <div class="row text-center">
                <div class="col-sm-12">
                  <a type="button" class="btn btn-success" href="#" onClick="javascript:form_send('<?=$id?>')">사 용</a>
                  <a type="button" class="btn btn-default" href="#" onclick="javascript:window.close();">닫 기</a>
                </div>
              </div>

            <?  } ?>

            </form>
            </div>
            <!-- panel body end -->
          </section>
        </div>
      </div>
      <!-- member list end -->

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

    <!-- custom scripts -->
    <script src="/js/global.js" ></script>
    <script src="/admin/js/admin.js" ></script>
    <script language = "JavaScript">
    <!--
    function send() {
     if(!document.id_check.id.value)
     {
       alert("ID를 입력하세요.");
       document.id_check.id.focus();
       return;
     }
       document.id_check.submit()
    }

    function form_send(s_id) {
     opener.document.form1.id.value=s_id;
     self.close();
    }
    -->
    </script>
</body>
</html>
