<?php

include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

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

  <!-- <body onLoad=init();> -->
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
// 상위카테고리 코드값으로 부터 현 카테고리 값을 구함
$query       = "SELECT * FROM banner ORDER BY created DESC";
$result      = mysqli_query($connect, $query);
$total_count = mysqli_num_rows($result);
?>

        <!-- setup start -->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading table-head">
                  <h4>메인 배너 관리</h4>
                </header>
                <div class="panel-body">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>번호</th>
                          <th>등록일</th>
                          <th>관리</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
for ($i = 0; $row = mysqli_fetch_array($result); $i++) {

    ?>
                        <tr>
                          <td><?=($i + 1);?></td>
                          <td><?=$row['created'];?></td>
                          <td>
                            <a class="btn btn-info" type="button" href="banner_setting.php?mode=update&num=<?=$row['num'];?>" ><i class="fa fa-pencil-square-o"></i></a>
                            <a class="btn btn-danger" type="button" href="banner_delete.php?num=<?=$row['num'];?>" onclick="return confirm('정말 삭제하시겠습니까?')"><i class="fa fa-trash-o"></i></a></td>
                        </tr>
                      <?php
} // end of for loop
mysqli_free_result($result);

if ($total_count == 0) {
    ?>
                        <tr class="text-center">
                          <td colspan="6">등록된 배너가 없습니다.</td>
                        </tr>
                      <?php
}
?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </section>
            </div>
          </div>
          <!-- setup end -->

          <form method="post" action="banner_list.php">
          <div class="row">
            <div class="col-sm-12">
              <a class="btn btn-success" href="banner_setting.php">새 배너 등록하기</a>
            </div>
          </div>
          </form>

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

