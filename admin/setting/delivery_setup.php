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

        <!-- info start -->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading">
                사용방법
              </header>
              <ul class="info-body">
                <li><i class="fa fa-info-circle"></i> 비밀번호를 분실하지 않도록 주의하시기 바랍니다.</li>
                <li><i class="fa fa-info-circle"></i> 인감이미지는 배경을 투명하게 하십시오.</li>
              </ul>
            </section>
          </div>
        </div>
        <!-- info end -->


          <?php
            $qry = "SELECT * FROM misc_setup ";
            $res = mysqli_query($connect, $qry);
            $total = mysqli_num_rows($res);

            if($total > 0) {
              $mode = "update";
              $rows = mysqli_fetch_array($res);
            } else {
              $mode = "insert";
            }
          ?>

        <!-- setup start -->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading table-head">
                  <h4>배송정보 설정</h4>
                </header>
                <div class="panel-body">
                  <form class="form-group" role="form" name="form1" action="delivery_setup_ok.php" method="post">
                  <input type="hidden" name="admin_id" value="<?=$_COOKIE['ROOT_ID']?>" />
                  <input type="hidden" name="mode" value="<?=$mode?>">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <tbody>
                        <tr>
                          <th>배송업체</th>
                          <td><input type="text" class="form-control" name="logistics" id="logistics" size="5"  value="<?=$rows['logistics']?>"/></td>
                          <th>배송료</th>
                          <td><input type="text" class="form-control" name="delivery_charge" id="delivery_charge" size="5"  value="<?=$rows['d_charge']?>"/></td>
                        </tr>
                        <tr>
                          <th>배송정책 설정</th>
                          <td colspan="3">
                            <textarea class="form-control" name="delivery_policy" rows="8" cols="100"><?=$rows['d_policy']?></textarea>
                            <p class="help-block">
                              - 총 구매액 10만원이상 구매시 배송비는 무료이며, 그 이하 구매시 배송비 2,500원이 별도 부과됩니다. <br />
                              - 결제확인 후 상품발송이 이뤄집니다.<br />
                              - 배송기간은 결제완료일로부터 최소 1일 ~ 최장 5일 정도 소요됩니다.(토요일/공휴일 제외)<br />
                              - 도서, 산간 지방의 경우 배송정책과 관계없이 도선료 등이 추가로 부과될 수 있습니다.<br /></p>
                          </td>
                        </tr>
                        <tr>
                          <th>환불/반품정책 설정</th>
                          <td colspan="3">
                            <textarea class="form-control" name="refund_policy" rows="8" cols="100"><?=$rows['r_policy']?></textarea>
                            <p class="help-block">
                              - 배송 시 파손 등은 수령일로부터 7일 이내에 접수와 상품이 확인이 되어야, 교환/반품/환불이 가능합니다. <br />
                              - 판매자가 판매 후 소비자 과실에 의한 파손 또는 불량은 반품사유가 되지 않습니다.<br />
                              - 사입 후 미판매 재고 등에 대한 환불 등은 해드리지 않으니 양해하시기 바랍니다. <br /></p>
                          </td>
                        </tr>
                      </tbody>
                    </table>

                    <div class="row text-center">
                      <div class="col-sm-12">
                        <button class="btn btn-success" onClick="document.form1.submit();">저장</button>
                        <a class="btn btn-default" href="../main.php">취소</a>
                      </div>
                    </div>
                    </form>

                  </div>
                </div>
              </section>
            </div>
          </div>
          <!-- setup end -->


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

  </body>
</html>

