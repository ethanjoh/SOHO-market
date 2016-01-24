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

$sql_1       = "SELECT num FROM mall_order WHERE cancel='N' AND status='3' AND user_id <> 'guest' ";
$res_1       = mysqli_query($connect, $sql_1);
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

        <form name="form" method="get" action="track_a.php" class="form-inline form-group" role="form">

        <!-- info start-->
        <div class="row">
              <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading">
                사용방법
              </header>
              <ul class="info-body">
                <li><i class="fa fa-info-circle"></i> 날짜와 관계없이 포장완료된 주문만 표시됩니다.</li>
                <li><i class="fa fa-info-circle"></i> 포장이 완료되어야 나타납니다.</li>
              </ul>
            </section>
          </div>
        </div>
        <!-- info end -->

      <?php
$today = date("Y-m-d");

//if (empty($date1)) $date1 = $today;
//if (empty($date2)) $date2 = $today;

switch ($mode) {
    case 'search':
        $sql_2 = "SELECT orderid FROM mall_order
      			   WHERE delivery_type = 'L'
      			   AND cancel = 'N'
      			   AND status = '7'
      			   AND trans_cost <> '-1'
      			   AND $key LIKE '%$key_value%' ";
        break;
    case 'date':
        $sql_2 = "SELECT orderid FROM mall_order
      		          WHERE cancel = 'N'
      				  AND delivery_type = 'L'
      				  AND status = '7'
      				  AND trans_cost <> '-1'
      				  AND createdate BETWEEN '$date1' AND '$date2' ";
        break;
    default:
        $sql_2 = "SELECT orderid FROM mall_order
      	   				  WHERE delivery_type = 'L'
      					  AND cancel = 'N'
      					  AND status = '7'
      					  AND trans_cost <> '-1' ";
}

$res_2 = mysqli_query($connect, $sql_2);
$total = mysqli_num_rows($res_2);

$scale = 50;
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

        <!-- calendar start -->
        <input type="hidden" name="mode" value="date" />
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
        </form>
        <!-- calendar end -->

      <!-- list start -->
      <form action="track_a.php" name="f" method="post" >
      <div class="row">
        <div class="col-sm-12">
          <section class="panel">
            <header class="panel-heading table-head">
                주문 목록 ( <?=$date1;?>  ~ <?=$date2;?>  기간 내 총 <?=$total;?> 건) <i class="fa fa-file-excel-o"></i> <a href="tracktoexcel_a.php?date1=<?=$date1;?>&amp;date2=<?=$date2;?>">엑셀로 다운로드</a>
            </header>
              <div class="panel-body">
                <div class="table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>주문번호</th>
                        <th>주문일</th>
                        <th>받는사람</th>
                        <th>상품명</th>
                        <th>수량(소)</th>
                        <th>우편번호</th>
                        <th>주소</th>
                        <th>전화번호</th>
                        <th>휴대폰번호</th>
                        <th>운임구분<br>(선불: 3)</th>
                        <th>운임</th>
                        <th>특기사항</th>
                        <!--
                        <th class="member" scope="col">주문자</th>
                        <th class="member" scope="col">주문자전화번호</th>
                        -->
                      </tr>
                    </thead>
                    <tbody>
                  <?php
switch ($mode) {
    case 'search':
        $sql_4 = "SELECT * FROM mall_order
                               WHERE $key LIKE '%$key_value%'
                  			 ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'date':
        $sql_4 = "SELECT * FROM mall_order
                  		          WHERE cancel = 'N'
                  				  AND createdate BETWEEN '$date1' AND '$date2'
                  				  ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    default:
        $sql_4 = "SELECT * FROM mall_order
                     		     		WHERE status = '7'
                  					AND cancel = 'N'
                  					AND delivery_type = 'L'
                  					AND trans_cost <> '-1'
                               		ORDER BY num DESC LIMIT $cline,$scale1 ";
}

$res_4 = mysqli_query($connect, $sql_4);
$t_no  = mysqli_num_rows($res_4);

if ($t_no > 0) {

    $total = 0; //금일주문총액

    for ($i = 0; $row = mysqli_fetch_array($res_4); $i++) {
        ?>
                      <tr>
                        <td><?=$row['orderid'];?></td>
                        <td><?=$row['createdate'];?></td>
                        <td><?=$row['recipient_name'] ? $row['recipient_name'] : $row['buyer_name'];?></td>
                  <?php
//상품명 가져옴
        $a_goods_fk = explode(",", $row['goods_fk']);

        $pro_sql    = "SELECT * FROM products WHERE num='$a_goods_fk[0]'";
        $pro_result = mysqli_query($connect, $pro_sql);
        $pro_row    = mysqli_fetch_array($pro_result);

        if (count($a_goods_fk) > 1) {
            $goods_name = cut_string_utf8($pro_row['name'], 30, '...');
            $goods_name .= " (외)";
        } else {
            $goods_name = cut_string_utf8($pro_row['name'], 30, '...');
        }

        //배송정책 가져옴
        $query4  = "SELECT * FROM misc_setup WHERE id='admin' ";
        $result4 = mysqli_query($connect, $query4);
        $misc    = mysqli_fetch_array($result4);

        //if($row['last_amount'] >=$misc['min_sum'] || $row['trans_cost'] == '0')
        if ($row['trans_cost'] == '0') {
            $str    = "3"; //신용
            $t_cost = "2200";
        } else {
            $str    = "2"; //착불
            $t_cost = "2500";
        }
        ?>
                        <td><?=$goods_name;?></td>
                        <td>1</td>
                        <td><?=$row['recipient_name'] ? $row['recipient_zipno'] : $row['buyer_zipno'];?></td>
                        <td><?=$row['recipient_name'] ? $row['recipient_address'] : $row['buyer_address'];?></td>
                        <td><?=$row['recipient_name'] ? $row['recipient_phone'] : $row['buyer_phone'];?></td>
                        <td><?=$row['recipient_name'] ? $row['recipient_hphone'] : $row['buyer_hphone'];?></td>
                        <td><?=$str;?></td>
                        <td><?=$t_cost;?></td>
                        <td>
                        <?php
if ($row['memo']) {
            echo $row['memo'];
        }

        ?>
                        </td>
                      <!--
                      <td><?=$row['recipient_name'] ? $row['buyer_name'] : "";?></td>
                      <td><?=$row['recipient_name'] ? $row['buyer_phone'] : "";?></td>
                      -->
                      </tr>
                  <?php
}
    ; // for loop end
    ?>
                  <?php
} else {
    ?>
                      <tr>
                        <td colspan="12"><p class="text-center">해당 주문내역이 없습니다.</p></td>
                      </tr>
                  <?php
}
?>
                    </tbody>
                  </table>
                </form>
              </div>
            </div>
          </section>
        </div>
      </div>

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

    <!--right slidebar-->
    <script src="/admin/js/slidebars.min.js"></script>

    <!--common script for all pages-->
    <script src="/admin/js/common-scripts.js"></script>

    <!--script for this page-->
    <script src="/admin/js/sparkline-chart.js"></script>
    <!-- // <script src="js/easy-pie-chart.js"></script> -->
    <script src="/admin/js/count.js"></script>

    <!-- custom scripts -->
    <script src="/js/global.js" ></script>
    <script src="/admin/js/admin.js" ></script>
    <script src="/admin/js/jquery-ui.min.js"></script>
    <script src="/admin/js/jq_datepicker.js" ></script>
  </body>
</html>
