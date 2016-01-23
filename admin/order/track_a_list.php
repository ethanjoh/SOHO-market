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
        <?php include "../include/admin_head.php"; ?>
        <!--header end-->

        <!--sidebar start-->
        <?php include "../include/admin_sidebar.php"; ?>
        <!--sidebar end-->

    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">

      <form action="track_a_list.php" class="form-inline" role="form" name="f" method="post" >

      <?php
       $today = date("Y-m-d");

    	switch ($mode) {
    	case 'search' :
    		$sql_2="SELECT orderid FROM mall_order
    			   WHERE delivery_type = 'L'
    			   AND cancel = 'N'
    			   AND status = '7'
    			   AND $key LIKE '%$key_value%' ";
    		break;
    	case 'date' :
    		$sql_2 = "SELECT orderid FROM mall_order
    		          WHERE cancel = 'N'
    				  AND delivery_type = 'L'
    				  AND status = '7'
    				  AND createdate BETWEEN '$date1' AND '$date2' ";
    		break;
    	default :
    	   $sql_2 = "SELECT orderid FROM mall_order
    	   				  WHERE delivery_type = 'L'
    					  AND cancel = 'N'
    					  AND status = '7' ";
    	}

    	$res_2 = mysqli_query($connect, $sql_2);
    	$total = mysqli_num_rows($res_2);

       $scale=50;
       if ($page == ''){
          $page=1;
       }

       $cpage = intval($page);
       $totalpage = intval($total/$scale);

        if ($totalpage*$scale != $total)
      		$totalpage = $totalpage + 1;

        if ($cpage ==1) {
    	  $cline = 0 ;
        } else {
     	  $cline = ($cpage*$scale) - $scale ;
        }

         $limit=$cline+$scale;

         if ($limit >= $total)
           	$limit=$total;

         $scale1 = $limit - $cline;
    ?>
        <!-- calendar start -->
        <form name="form" method="get" action="track_a_list.php" class="form-inline form-group" role="form">
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
                    <button class="btn btn-primary btn-sm" type="submit" onclick="form.submit()"><i class="fa fa-search"></i> 검색</button>
                </div>
              </div>

            </div>
        </div>
        </form>
        <!-- calendar end -->

      <div class="row">
        <div class="col-sm-12">
          <section class="panel">
            <header class="panel-heading table-head">
                운송장번호 입력 (총 <?=number_format($total)?> 건)
            </header>
              <div class="panel-body">
                <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>주문번호</th>
                      <th>주문일</th>
                      <th>업체명</th>
                      <th>운송장번호</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
              switch ($mode) {
              	case 'search' :
                 		$sql_4 = "SELECT * FROM mall_order
                           WHERE $key LIKE '%$key_value%'
              			 ORDER BY num DESC LIMIT $cline,$scale1 ";
              		break;
              	case 'date' :
              		$sql_4 = "SELECT * FROM mall_order
              		          WHERE cancel = 'N'
              				  AND createdate BETWEEN '$date1' AND '$date2'
              				  ORDER BY num DESC LIMIT $cline,$scale1 ";
              		break;
              	default :
                 		$sql_4 = "SELECT * FROM mall_order
                 		     		WHERE status = '7'
              					AND cancel = 'N'
              					AND delivery_type = 'L'
                           		ORDER BY num DESC LIMIT $cline,$scale1 ";
              }

              $res_4 = mysqli_query($connect, $sql_4);
              $t_no = mysqli_num_rows($res_4);

              if($t_no > 0) {

              	for($i=0; $row = mysqli_fetch_array($res_4); $i++){

              	?>
                    <tr>
                      <td>
                        <a href="or_view.php?mode=<?=$mode?>&amp;oid=<?=$row['num']?>&amp;key=<?=$key?>&amp;key_value=<?=$key_value?>&amp;page=<?=$page?>">
                        <?=$row['orderid']?></a>
                      </td>
                      <td><?=$row['createdate']?></td>
                      <td><?=$row['recipient_name'] ? $row['recipient_name'] : $row['buyer_name']?></td>
                      <td>
                        <form name="form1" class="form-inline" role="form" method="get" action="or_changed.php">
                          <input type="hidden" name="mode" value="a" />
                          <input type="hidden" name="oid" value="<?=$row['num']?>" />
                          <input type="hidden" name="last_amount" value="<?=$row['last_amount']?>" />
                          <input type="hidden" name="senddate" value="<?=$today?>" />
                          <input type="text" class="form-control" name="track_no" value="<?=$row['track_no']?>" size="80" />
                          &nbsp;
                          <button class="btn btn-success" type="submit" onclick="form1.submit()"><i class="fa fa-paper-plane"></i> 발 송</button>
                        </form>
                      </td>
                    </tr>
                    <?php
                  } // for loop end

                }else {

                ?>
                    <tr>
                      <td colspan="4"><p class="text-center">송장입력이 완료되었거나 해당 주문내역이 없습니다.</p></td>
                    </tr>
                    <?php
                } ?>
                  </tbody>
                </table>
                </form>
               </div>
            </div>

            </section>
          </div>
        </div>

          <!-- page navigation start -->
            <div class="row text-center">
              <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table">
                      <tbody>
                        <tr>
                          <td>
                            <?php
                                $url = "$PHP_SELF?mode=".$mode."&key=".$key."&key_value=".$key_value;
                                page_nav($totalpage,$cpage,$url);
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
                  <form class="form-inline" role="form" method="get" name="search" action="track_a_list.php">
                    <input type="hidden" name="mode" value="search">
                    <div class="ui-widget form-group">
                      <select class="form-control" name="key">
                        <option value="buyer_name">업체명</option>
                        <option value="user_id">아이디</option>
                      </select>
                      <input type="text" class="form-control" name="key_value" id="key_value">
                      <button class="btn btn-primary" type="submit" onclick="search.submit()"><i class="fa fa-search"></i>검 색</button>
                    </div>
                  </form>
              </div>
            </div>
            <!-- search end -->

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
    <script src="/admin/js/jquery-ui.min.js"></script>
    <script src="/admin/js/jq_datepicker.js" ></script>

  </body>
</html>