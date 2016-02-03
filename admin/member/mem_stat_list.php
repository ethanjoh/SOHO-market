<?php

include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

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
    <link href="/css/bootstrap.min.css" rel="stylesheet">
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
    <link href="/admin/css/jquery-ui.min.css" rel="stylesheet">

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
        <?php include "../include/admin_head.php"; ?>
        <!--header end-->

        <!--sidebar start-->
        <?php include "../include/admin_sidebar.php"; ?>
        <!--sidebar end-->

    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">

        <?php

        if($mode == 'search'){
            $search_keyword .= " AND createdate BETWEEN  '$date1' AND '$date2' ";
        }

        //회원 테이블의 리스트를 불러옵니다.
        //$query = "SELECT * FROM member WHERE 1 $search_keyword ";
        $query = "SELECT orderid FROM mall_order WHERE cancel = 'N' AND user_id='$id' AND status = '8'  $search_keyword ";
        $result = mysqli_query($connect, $query);
        $total = mysqli_num_rows($result);

        ?>

            <!-- calendar start -->
            <form name="form" method="get" action="mem_stat_list.php" class="form-inline form-group" role="form">
            <input type="hidden" name="mode" value="search" />
            <input type="hidden" name="id" value="<?=$id?>" />
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

            <!-- order list start -->
            <div class="row">
              <div class="col-sm-12">
                <section class="panel">
                  <header class="panel-heading table-head">
                      개별업체 정산리스트 ( <?=number_format($total)?> 건 )
                    </header>
                    <div class="panel-body">
                      <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <tr>
                              <th>번호</th>
                              <th>주문일</th>
                              <th>업체명</th>
                              <th>사업자등록번호</th>
                              <th>주문액</th>
                              <th>실정산액</th>
                              <th>상세내용</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php
                            $scale=30;
                            if ($page == ''){
                              $page=1;
                            }

                            $cpage = intval($page);
                            $totalpage = intval($total/$scale);

                            if ($totalpage*$scale != $total)
                               $totalpage = $totalpage + 1;

                            if ($cpage ==1) {
                              $cline = 0 ;
                            }else {
                              $cline = ($cpage*$scale) - $scale ;
                            }

                            $limit=$cline+$scale;

                            if ($limit >= $total)
                              $limit=$total;

                            $scale1 = $limit - $cline;

                            $sql_2 = "SELECT * FROM member, mall_order
                                    WHERE (mall_order.cancel = 'N')
                                	  AND (member.id='$id')
                                	  AND (mall_order.user_id='$id')
                                	  AND (mall_order.status = '8' )
                                	  ORDER BY mall_order.num DESC LIMIT $cline,$scale1";

                            $result_2 = mysqli_query($connect, $sql_2);
                            for($i=1; $list = mysqli_fetch_array($result_2); $i++){

                              $bunho = $total - ( $i + $cline) + 1;
                          ?>
                            <tr>
                              <td><?=$bunho?></td>
                              <td><?=$list['createdate']?></td>
                              <td><?=$list['company_name']?></td>
                              <td><?=$list['license_no']?></td>
                              <td><?=number_format($list['amount'])?> 원</td>
                              <td><?=number_format($list['last_amount'])?> 원</td>
                              <td><a href='../order/or_view.php?oid=<?=$list['num']?>&amp;page=<?=$page?>'> <img src="../images/details.gif" alt="주문내역 보기" /> </a></td>
                            </tr>

                          <?php
                          		$tot_amount = $tot_amount + (int)$list['last_amount'];
                          	} // end of for loop
                              mysqli_free_result($result_2);
                            ?>
                            <tr>
                              <td colspan="5">실정산액 합계:</td>
                              <td><?=number_format($tot_amount)?> 원</td>
                              <td></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </section>
                </div>
              </div>
              <!-- order list end -->


              <!-- page navigation start -->
              <div class="row text-center">
                <div class="col-sm-12">
                      <table class="table">
                        <tbody>
                          <tr>
                            <td>
                              <?php
                                  $url = $PHP_SELF."?id=".$id."&mode=".$mode".&license_no=".$license_no."&company_name=".$company_name;
                                  page_nav($totalpage,$cpage,$url);
                               ?>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                </div>
              </div>
              <!-- page navigation end -->

              <div class="row text-center">
                <div class="col-sm-12">
                  <a class="btn btn-default" href="../stats/top_stat_list.php">업체 목록</a>
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
    <script src="/js/vendor/jquery-2.2.0.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="/admin/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="/admin/js/jquery.scrollTo.min.js"></script>
    <script src="/admin/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="/admin/js/jquery.sparkline.js" type="text/javascript"></script>
    <!-- // <script src="jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script> -->
    <script src="/admin/js/owl.carousel.js" ></script>
    <script src="/admin/js/jquery.customSelect.min.js" ></script>
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
    <script>
      //custom select box

      $(function(){
        $('select.styled').customSelect();
      });

    </script>

  </body>
</html>
