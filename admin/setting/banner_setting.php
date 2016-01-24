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
if ($mode == "update") {
    $query  = "SELECT * FROM banner WHERE num='$num' ";
    $result = mysqli_query($connect, $query);
    $row    = mysqli_fetch_array($result);
    mysqli_free_result($result);
} else {
    $mode = "insert";
}
?>

        <!-- setup start -->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading table-head">
                  <h4>배너 업로드 (2000x1000px)</h4>
                </header>
                <div class="panel-body">
                <form class="form-group" role="form" name="banner" action="banner_setting_ok.php" enctype="multipart/form-data" method="post">
                <input type="hidden" name="mode" value="<?=$mode;?>">
                <input type="hidden" name="num" value="<?=$num;?>">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <tbody>
                        <tr>
                          <th rowspan="2">배너 1 </th>
                          <th>이미지 1</th>
                          <td><?=($row['m_banner1'] == "Y") ? "<img src=\"$row[m_banner1_image]\" alt=\"banner\" width=\"250\">" : "NO BANNER";?>
                            <p>
                              <input type="file" name="m_banner1_image" size="25" />
                            </p>
                          </td>
                        </tr>
                        <tr>
                          <th>링크 1</th>
                          <td><input type="text" class="form-control" name="m_link1" value="<?=$row['m_link1'];?>" id="m_link1" size="150" /></td>
                        </tr>
                        <tr>
                          <th rowspan="2">배너 2</th>
                          <th>이미지 2</th>
                          <td><?=($row['m_banner2'] == "Y") ? "<img src=\"$row[m_banner2_image]\" alt=\"banner\" width=\"250\">" : "NO BANNER";?>
                            <p>
                              <input type="file" name="m_banner2_image" size="25" />
                            </p>
                          </td>
                        </tr>
                        <tr>
                          <th>링크 2</th>
                          <td><input type="text" class="form-control" name="m_link2" id="m_link2" value="<?=$row['m_link2'];?>" size="150" /></td>
                        </tr>
                        <tr>
                          <th rowspan="2">배너 3</th>
                          <th>이미지 3</th>
                          <td><?=($row['m_banner3'] == "Y") ? "<img src=\"$row[m_banner3_image]\" alt=\"banner\" width=\"250\">" : "NO BANNER";?>
                            <p>
                              <input type="file" name="m_banner3_image" size="25" />
                            </p></td>
                        </tr>
                        <tr>
                          <th>링크 3</th>
                          <td><input type="text" class="form-control" name="m_link3" id="m_link3" value="<?=$row['m_link3'];?>" size="150" /></td>
                        </tr>
                        <tr>
                          <th rowspan="2">배너 4</th>
                          <th>이미지 4</th>
                          <td><?=($row['m_banner4'] == "Y") ? "<img src=\"$row[m_banner4_image]\" alt=\"banner\" width=\"250\">" : "NO BANNER";?>
                            <p>
                              <input type="file" name="m_banner4_image" size="25" />
                            </p></td>
                        </tr>
                        <tr>
                          <th>링크 4</th>
                          <td><input type="text" class="form-control" name="m_link4" id="m_link4" value="<?=$row['m_link4'];?>" size="150" /></td>
                        </tr>
                        <tr>
                          <th rowspan="2">배너 5</th>
                          <th>이미지 5</th>
                          <td><?=($row['m_banner5'] == "Y") ? "<img src=\"$row[m_banner5_image]\" alt=\"banner\" width=\"250\">" : "NO BANNER";?>
                            <p>
                              <input type="file" name="m_banner5_image" size="25" />
                            </p></td>
                        </tr>
                        <tr>
                          <th>링크 5</th>
                          <td><input type="text" class="form-control" name="m_link5" id="m_link5" value="<?=$row['m_link5'];?>" size="150" /></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </section>
            </div>
          </div>
          <!-- setup end -->

          <div class="row text-center">
            <div class="col-sm-12">
              <button class="btn btn-success" onclick="javascript:document.banner.submit();">등록하기</button>
              <a type="button" class="btn btn-default" href="banner_list.php">취소</a>
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

