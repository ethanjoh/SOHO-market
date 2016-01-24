<?php

//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect = my_connect($host, $dbid, $dbpass, $dbname);

//메타정보
$info_query = "SELECT * FROM admin_setup";
$info_res   = mysqli_query($connect, $info_query);
$info       = mysqli_fetch_array($info_res);

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

    <title><?=$info['company_name'];?> :: 운영업체 관리자 홈</title>

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
        <?php include "../include/admin_head.php";?>
        <!--header end-->

        <!--sidebar start-->
        <?php include "../include/admin_sidebar.php";?>
        <!--sidebar end-->


        <!--main content start-->
        <section id="main-content">
          <section class="wrapper">
          <?php
$sql    = "SELECT * FROM sms";
$result = mysqli_query($connect, $sql);
if ($result) {
    $row = mysqli_fetch_array($result);
}

$sql2    = "SELECT * FROM admin_setup";
$result2 = mysqli_query($connect, $sql2);
$row2    = mysqli_fetch_array($result2);
?>

            <!-- info start -->
            <div class="row">
              <div class="col-sm-12">
                <section class="panel">
                  <header class="panel-heading">
                    사용방법
                  </header>
                  <ul class="info-body">
                    <li><i class="fa fa-info-circle"></i> SMS 서비스를 이용하시려면 먼저 <a href="http://www.whoisweb.net/main/smsh.php?ch=smsh" target="_blank">후이즈 SMS호스팅</a>에 가입 후  이용요금을 결제해야 합니다.</li>
                    <li><i class="fa fa-info-circle"></i> 후이즈 SMS 호스팅에 가입하신 아이디와 비밀번호를 아래에 입력하세요.</li>
                    <li><i class="fa fa-info-circle"></i> SMS를 보내기 원하는 옵션의 체크박스에 체크 후 사용하세요.</li>
                    <li><i class="fa fa-info-circle"></i> 회원이 SMS 수신을 원했을 경우에만 발송이 됩니다.</li>
                    <li><i class="fa fa-info-circle"></i> SMS 발송 시에는 회사명이 자동으로 붙어 전송되니 별도로 입력하실 필요없습니다.</li>

                  </ul>
                </section>
              </div>
            </div>
            <!-- info end -->

            <!-- bbs list start -->

            <div class="row">
              <div class="col-sm-12">
                <section class="panel">
                  <header class="panel-heading table-head">
                      SMS 설정
                    </header>
                    <div class="panel-body">
                      <form class="form-group" role="form" name="sms" method="post" action="sms_ok.php">
                      <div class="table-responsive">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th class="text-center" colspan="4">사용 설정 (
                              <input type="radio" name="sms" value="Y" <?php if ($row['sms'] == "Y") {
    echo "checked=\"checked\"";
}
?>/> 사용함
                              <input type="radio" name="sms" value="N" <?php if ($row['sms'] == "N") {
    echo "checked=\"checked\"";
}
?> /> 사용 안함)
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th>SMS 아이디:</th>
                            <td>
                              <div class="col-sm-6">
                                <input type="text" class="form-control" name="sms_id" value="<?=$row['id'];?>" />
                              </div>
                            </td>
                            <th>SMS 비밀번호:</th>
                            <td>
                              <div class="col-sm-6">
                                <input type="text" class="form-control" name="sms_passwd" value="<?=$row['passwd'];?>" />
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th>발신자 연락처:</th>
                            <td colspan="3">
                              <div class="col-sm-3">
                                <input type="text" class="form-control" name="from_phone" value="<?=$row['from_phone'];?>" />
                                <p class="help-block">(예: 010-111-1234 또는 02-111-1234)</p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th>수신 연락처:</th>
                            <td colspan="3">
                              <div class="col-sm-3">
                                <input type="text" class="form-control" name="to_phone" size="13" value="<?=$row['to_phone'];?>" />
                                <p class="help-block">(예: 010-111-1234 또는 02-111-1234)</p>(예: 010-111-1234) * 주문 접수 시에 사용됩니다.</p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th>
                              <input type="checkbox" name="reg_chk" value="Y" <?php if ($row['reg_chk'] == "Y") {
    echo "checked=\"checked\"";
}
?> />회원승인
                            </th>
                            <td>
                              <textarea class="form-control" name="reg_msg" cols="25" rows="5"><?=$row['reg_msg'];?></textarea>
                            </td>
                            <th>
                              <input type="checkbox" name="orderin_chk" value="Y" <?php if ($row['orderin_chk'] == "Y") {
    echo "checked=\"checked\"";
}
?> />주문접수
                            </th>
                            <td>
                              <textarea class="form-control" name="orderin_msg" cols="25" rows="5"><?=$row['orderin_msg'];?></textarea>
                            </td>
                          </tr>
                          <tr>
                            <th>
                              <input type="checkbox" name="order_chk" value="Y" <?php if ($row['order_chk'] == "Y") {
    echo "checked=\"checked\"";
}
?> />구매완료
                            </th>
                            <td>
                              <textarea class="form-control" name="order_msg" cols="25" rows="5"><?=$row['order_msg'];?></textarea>
                            </td>
                            <th>
                              <input type="checkbox" name="orderout_chk" value="Y" <?php if ($row['orderout_chk'] == "Y") {
    echo "checked=\"checked\"";
}
?> />상품발송
                            </th>
                            <td>
                              <textarea class="form-control" name="orderout_msg" cols="25" rows="5"><?=$row['orderout_msg'];?></textarea>
                            </td>
                          </tr>
                          <tr>
                            <th>
                              <input type="checkbox" name="tax_chk" value="Y" <?php if ($row['tax_chk'] == "Y") {
    echo "checked=\"checked\"";
}
?> />세금계산서 발행
                            </th>
                            <td>
                              <textarea class="form-control" name="tax_msg" cols="25" rows="5"><?=$row['tax_msg'];?></textarea>
                            </td>
                            <th>
                              <input type="checkbox" name="offer_chk" value="Y" <?php if ($row['offer_chk'] == "Y") {
    echo "checked=\"checked\"";
}
?> />발주서 발송
                            </th>
                            <td>
                              <textarea class="form-control" name="offer_msg" cols="25" rows="5"><?=$row['offer_msg'];?></textarea>
                            </td>
                          </tr>
                        </tbody>
                      </table>

                      <div class="row text-center">
                        <div class="col-sm-12">
                          <button class="btn btn-success" onclick="javascript:document.sms.submit();">설정 저장</button>
                          <a class="btn btn-default" type="button" href="/admin/main.php">취소</a>
                        </div>
                      </div>

                    </div>
                </form>
              </div>
            </section>
          </div>
        </div>
        <!-- bbs list end -->

      <?php if ($row['sms'] == "Y") {?>
      <table summary="stats">
        <thead>
          <tr>
            <th>SMS 통계(<?=check_remain_sms($connect);?>)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?=sms_stats($connect);?></td>
          </tr>
        </tbody>
      </table>
      <?php }
?>
         </section>
      </section>
      <!--main content end-->

      <!--footer start-->
    <?php include "../include/admin_footer.php";?>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="/js/vendor/jquery-2.2.0.min.js"></script>
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

  </body>
</html>
