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
    <link href="/admin/css/jquery-ui.min.css" rel="stylesheet">

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

        <!-- info start-->
        <div class="row">
              <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading">
                사용방법
              </header>
              <ul class="info-body">
                <li><i class="fa fa-info-circle"></i> 발주할 업체를 선택 후 발주서를 작성합니다.</li>
                <li><i class="fa fa-info-circle"></i> 입고가 되면 해당 발주내역을 클릭하여 입고상품 수량 등을 확인하여 품절상품을 해제합니다.</li>
                <li><i class="fa fa-info-circle"></i> 발주서 작성이 끝나면 해당 발주내역 하단에서 발주서를 출력할 수 있습니다.</li>
              </ul>
            </section>
          </div>
        </div>
        <!-- info end -->

        <!-- list start-->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading table-head">
                  발주서 작성
              </header>
              <div class="panel-body">

                <form action="offer_list.php" class="form-inline" role="form" name="f" method="post" >
                <?php
switch ($mode) {
    case 'search':
        $nres = mysqli_query($connect, "SELECT id FROM supplier WHERE $key LIKE '%$key_value%' ");
        $nrow = mysqli_fetch_array($nres);

        $sql = "SELECT * FROM offer WHERE id='$nrow[id]' ";
        break;
    case 'date':
        //$nres = mysqli_query($connect, "SELECT id FROM supplier WHERE id=$id ");
        //$nrow = mysqli_fetch_array($nres);
        $sql = "SELECT * FROM offer WHERE id='$key_value' AND createdate BETWEEN '$date1' AND '$date2' ";
        break;
    default:
        $sql = "SELECT * FROM offer WHERE 1 ORDER BY num DESC";
}
?>

                  <label for="id" class="col-sm-2 control-label">업체 선택 :</label>
                  <div class="col-sm-4 col-lg-8">
                    <select name="id" class="form-control" onchange="change();">
                      <option>업체명 - 아이디</option>
                    <?php
$mqry = "SELECT * FROM supplier ORDER BY company_name ";
$mres = mysqli_query($connect, $mqry);

for ($i = 0; $mrow = mysqli_fetch_array($mres); $i++) {
    echo "<option value=" . $mrow['id'] . ">" . $mrow['company_name'] . " - " . $mrow['id'] . "</option>\n";
}
?>
                    </select>
                  </div>
                </form>


            <?php
$result = mysqli_query($connect, $sql);
$total  = mysqli_num_rows($result);

$scale = 30;

if ($page == '') {
    $page = 1;
}

$cpage     = intval($page);
$totalpage = intval($total / $scale);

if ($totalpage * $scale != $total) {
    $totalpage = $totalpage + 1;
}

if ($cpage == 1) {
    $cline = 0;
} else {
    $cline = ($cpage * $scale) - $scale;
}

$limit = $cline + $scale;

if ($limit >= $total) {
    $limit = $total;
}

$scale1 = $limit - $cline;

?>


              </div> <!-- panel-body end -->
            </section>
          </div>
        </div>
        <!-- list end -->

        <?php
if ($mode == "search") {
    ?>
        <!-- calendar start -->
        <form method="get" action="offer_list.php" class="form-inline form-group" role="form">
        <input type="hidden" name="mode" value="date" />
        <input type="hidden" name="id" value="<?=$key_value;?>" />
        <!-- <div class="col-sm-12"> -->
          <div class="panel panel-info">
            <div class="panel-heading">날짜 검색</div>
              <div class="panel-body text-center">
                <div class="row text-center">
                  <div class="form-group">
                      <label for="sd"><i class="fa fa-calendar"></i>시작일 :</label>
                      <input type="text" class="form-control" name="date1" id="sd" value="" size="10" />
                  </div>
                  <div class="form-group">
                      <label for="ed"><i class="fa fa-calendar"></i>종료일 :</label>
                      <input type="text" class="form-control" name="date2" id="ed" value="" size="10" />
                  </div>
                  <div class="form-group">
                      <button class="btn btn-primary btn-sm" onclick="document.form.submit()"><i class="fa fa-search"></i>검색</button>
                  </div>
                </div>
              </div>
          </div>
        <!-- </div> -->
        </form>
        <!-- calendar end -->

        <?php
}
; // end of if($mode == "search")
?>


        <!-- offer list start -->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading table-head">
                  발주 리스트
              </header>
              <div class="panel-body">
              <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>발주일</th>
                    <th>업체명(ID)</th>
                    <th>발주내역</th>
                    <th>발주금액<br />(NET)</th>
                    <th>입고금액<br />(NET)</th>
                    <th>확인</th>
                    <th>삭제</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
$nres1 = mysqli_query($connect, "SELECT id FROM supplier WHERE $key LIKE '%$key_value%' ");

if ($nres1 && $mode == "search") {
    $nrow1 = mysqli_fetch_array($nres1);
    $sql2  = "SELECT * FROM offer WHERE id='$nrow1[id]' ORDER BY num DESC LIMIT $cline,$scale1";
} else if ($mode == "date") {
    $sql2 = "SELECT * FROM offer WHERE id='$id' AND createdate BETWEEN '$date1' AND '$date2' ORDER BY num DESC ";
} else {
    $sql2 = "SELECT * FROM offer WHERE 1 ORDER BY num DESC LIMIT $cline,$scale1";
}

$result2 = mysqli_query($connect, $sql2);
$total2  = mysqli_num_rows($result2);

if ($total2 == 0) {
    echo "<tr>\n<td colspan=\"7\"><p>발주 내역이 없습니다.</p></td>\n</tr>\n";
} else {

    for ($i = 0; $row = mysqli_fetch_array($result2); $i++) {

        $sql3    = "SELECT * FROM supplier WHERE id='$row[id]' ";
        $result3 = mysqli_query($connect, $sql3);

        if ($result3) {
            $row3 = mysqli_fetch_array($result3);
        }
        ?>
                  <tr>
                    <td>
                      <a href="view_offer.php?oid=<?=$row['num'];?>"><?=$row['createdate'];?></a>
                    </td>
                    <td>
                      <?="<a href=\"offer_list.php?mode=search&amp;key=id&amp;key_value=" . $row['id'] . "\">" . $row3['company_name'] . "</a>";?> (<?=$row['id'];?>)</td>
                    <td>
                      <?php
$name = explode(',', $row['goods_name']);
        echo $name[0];
        ?>
                      (외)
                    </td>
                    <td><?=number_format($row['amount']);?></td>
                    <td><?=number_format($row['last_amount']);?></td>
                    <td>
                    <?php
switch ($row['status']) {
            case "1":
                echo "미입고";
                break;
            case "2":
                echo "발주확인";
                break;
            case "3":
                echo "출고완료";
                break;
            case "4":
                echo "입고완료";
                break;
        }
        ?>
                    </td>
                    <td>
                      <a type="button" class="btn btn-danger" href="update_cart.php?mode=del&amp;from=list&amp;oid=<?=$row['num'];?>" onclick="return confirm('발주를 삭제하시겠습니까?');"><i class="fa fa-trash-o"></i></a>
                    </td>
                  </tr>
            <?php
$o_total += $row['amount'];
        $in_total += $row['last_amount'];
    } // for end
}
; // else end
?>
                  <tr>
                    <td colspan="3">
                      <strong>총합(NET):</strong>
                    </td>
                    <td>
                      <strong><?=number_format($o_total);?></strong>
                    </td>
                    <td>
                      <strong><?=number_format($in_total);?></strong>
                    </td>
                    <td></td>
                    <td></td>
                  </tr>
                </tbody>
              </table>
              </div>
              </div>
            </section>
          </div>
        </div>
        <!-- offer list end -->

        <!-- page navigation start -->
        <div class="row text-center">
          <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table">
                  <tbody>
                    <tr>
                      <td>
                        <?php
$url = $PHP_SELF . "?mode=" . $mode . "&amp;key=" . $key . "&amp;key_value=" . $key_value;
page_nav($totalpage, $cpage, $url);
?>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
          </div>
        </div>
        <!-- page navigation end -->

        <!-- search start -->
        <div class="row text-center">
          <div class="col-sm-12">
              <form class="form-inline" role="form" method="get" name="search" action="offer_list.php">
                <input type="hidden" name="mode" value="search">
                <div class="ui-widget form-group">
                  <select name="key" class="form-control">
                      <option value='company_name'>업체명</option>
                      <option value='id'>아이디</option>
                  </select>
                  <input type="text" class="form-control" name="key_value" id="key_value" placeholder="검색어">
                  <button class="btn btn-primary" onclick="search.submit()"><i class="fa fa-search"></i>검 색</button>
                </div>
              </form>
          </div>
        </div>
        <!-- search end -->

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
    <script src="/admin/js/jquery-ui.min.js"></script>
    <script src="../js/jq_datepicker.js"></script>

  </body>
</html>
