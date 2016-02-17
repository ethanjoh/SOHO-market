<?php include_once '../include/header.php';?>

  <body onLoad="init()">
    <section id="container" >
      <!--header start-->
      <?php include "../include/admin_head.php";?>
      <!--header end-->
      <!--sidebar start-->
      <?php include "../include/admin_sidebar.php";?>
      <!--sidebar end-->
<?php

$today      = date("Y-m-d");
$month      = date("Y-m");
$this_month = date("F, Y", strtotime($month));

//총주문
// $sql = "SELECT * FROM mall_order WHERE cancel='N' AND createdate='$today' AND user_id <> 'guest' ";
// $res = mysqli_query($connect, $sql);
// $total = mysqli_num_rows($res);

//미확인건
$sql_1       = "SELECT * FROM mall_order WHERE cancel='N' AND status='3' AND user_id <> 'guest' ";
$res_1       = mysqli_query($connect, $sql_1);
$unchk_total = mysqli_num_rows($res_1);

//발송완료건
// $sql_2 = "SELECT * FROM mall_order WHERE cancel='N' AND status='8' AND createdate='$today' AND user_id <> 'guest' ";
// $res_2 = mysqli_query($connect, $sql_2);
// $end_total = mysqli_num_rows($res_2);

//주문취소건
// $sql_3 = "SELECT * FROM mall_order WHERE cancel='Y' AND createdate='$today' AND user_id <> 'guest' ";
// $res_3 = mysqli_query($connect, $sql_3);
// $cancel_total = mysqli_num_rows($res_3);

//금일 가입업체
// $sql_4        = "SELECT * FROM member WHERE reg_date='$today' ";
// $res_4        = mysqli_query($connect, $sql_4);
// $member_total = mysqli_num_rows($res_4);

//미승인 업체
$sql_5             = "SELECT * FROM member WHERE approved='N' ";
$res_5             = mysqli_query($connect, $sql_5);
$nonapproved_total = mysqli_num_rows($res_5);

//쪽지
// $sql_8 = "SELECT * FROM message_info WHERE receive_chk='N' AND receiveid_fk = 'admin'  ";
// $res_8 = mysqli_query($connect, $sql_8);
// $msg_total = mysqli_num_rows($res_8);

//승인 상품
$sql_9 = "SELECT * FROM products WHERE approved='Y' ";
$res_9 = mysqli_query($connect, $sql_9);
if ($res_9) {
    $sp_total = mysqli_num_rows($res_9);
} else {
    $sp_total = 0;
}

//발송지연건
// $sql_12 = "SELECT * FROM mall_order WHERE cancel='N' AND status='0' AND user_id <> 'guest' ";
// $res_12 = mysqli_query($connect, $sql_12);
// $delay_total = mysqli_num_rows($res_12);

//미답변 문의
// $sql_10 = "SELECT * FROM bbs_qa WHERE depth = '0'";
// $res_10 = mysqli_query($connect, $sql_10);
// $row_10 = mysqli_fetch_array($res_10);
// if($row_10['depth'] == 0)
// $noreply_total = mysqli_num_rows($res_10);

mysqli_query($connect, 'set names utf8');
?>
      <!--main content start-->
      <section id="main-content">
        <section class="wrapper">
          <!--state overview start-->
          <div class="row state-overview">
            <div class="col-lg-4 col-sm-6">
              <section class="panel">
                <div class="symbol yellow">
                  <i class="fa fa-cart-plus"></i>
                </div>
                <div class="value">
                  <h1>
                  <a href="../order/top_order_list.php?mode=unchk"><?php echo $unchk_total; ?></a>
                  </h1>
                  <p>신규 주문</p>
                </div>
              </section>
            </div>
            <div class="col-lg-4 col-sm-6">
              <section class="panel">
                <div class="symbol terques">
                  <i class="fa fa-user-plus"></i>
                </div>
                <div class="value">
                  <h1>
                  <a href="../member/top_member_list.php?mode=nonapproved"><?php echo $nonapproved_total; ?></a>
                  </h1>
                  <p>신규 회원</p>
                </div>
              </section>
            </div>
            <div class="col-lg-4 col-sm-6">
              <section class="panel">
                <div class="symbol red">
                  <i class="fa fa-cube"></i>
                </div>
                <div class="value">
                  <h1>
                  <a href="../products/top_pro_list.php"><?php echo $sp_total; ?></a>
                  </h1>
                  <p>상품등록</p>
                </div>
              </section>
            </div>
          </div>
          <!--state overview end-->
          <div class="row">
            <div class="col-lg-6">
              <!-- today's sales start-->
              <section class="panel">
                <header class="panel-heading">
                  <?php echo $this_month; ?> :: 월 상품판매량 (단위: 개)
                </header>
                <div class="panel-body">
                  <div id="hero-bar" class="graph"></div>
                </div>
              </section>
              <!-- today's sales end-->
            </div>
            <div class="col-lg-6">
              <!-- monthly sales start-->
              <section class="panel">
                <header class="panel-heading">
                  월 판매액 (단위: 원)
                </header>
                <div class="panel-body">
                  <div id="hero-graph" class="graph"></div>
                </div>
              </section>
              <!-- monthly sales end-->
            </div>
          </div>

          <!-- bbs start -->
          <div class="row">
<?php

$query  = "SELECT * FROM code WHERE 1 ORDER BY num";
$result = mysqli_query($connect, $query);
$total  = mysqli_num_rows($result);

if ($total == 0) {
    ?>
            <div class="col-sm-12">
              <div class="alert alert-danger" role="alert">
                <p>생성된 게시판이 없습니다.</p>
                <p>관리자 페이지 > 환경설정 > <a href="/admin/bbs/bbs_list.php">게시판 설정</a>에서 게시판을 생성해 주세요.</p>
              </div>
<?php

} else {
    if ($total % 2 == 0) {
        echo '        <div class="col-sm-6">';
    } else {
        echo '        <div class="col-sm-6">';
    }

    for ($i = 0; $rows = mysqli_fetch_array($result); $i++) {
        $board   = 'bbs_' . $rows['code'];
        $query2  = "SELECT * FROM $board WHERE 1 ORDER BY mod_date DESC LIMIT 5";
        $result2 = mysqli_query($connect, $query2);

        if ($result2) {
            $total2 = mysqli_num_rows($result2);
        } else {
            $total2 = 0;
        }
        ?>
                        <section class="panel">
                          <div class="weather-bg">
                            <header class="panel-heading">
                              <a href="/bbs/list.php?code=<?php echo $rows['code']; ?>" target="_blank"><span class="bbs-title"><?php echo $rows['bbs_name']; ?></span></a>
                            </header>
                          </div>
                          <div class="table-responsive">
                            <table class="table table-striped">
                              <thead>
                                <tr>
                                  <th>#</th>
                                  <th>제 목</th>
                                  <th>날 짜</th>
                                </tr>
                              </thead>
                              <tbody>
<?php

        if ($total2 == 0) {
            echo <<<HEREDOC
                              <tr>
                                <td colspan="4"><p>등록된 글이 없습니다</p></td>
                              </tr>
HEREDOC;
        } else {
            for ($j = 0; $rows2 = mysqli_fetch_array($result2); $j++) {
                //날짜 형식을 바꾼다.
                $post_date = substr($rows2['date'], 0, 10);
                //답변있는 경우
                if ($rows2['depth'] > 0) {
                    ?>
                              <tr>
                                <td><?php echo $rows2['main_no']; ?></td>
                                <td><a href="/bbs/read.php?code=<?php echo $rows['code']; ?>&main_no=<?php echo $rows2['main_no']; ?>" target="_blank"><?php echo stripslashes($rows2['title']); ?></a>&nbsp;<span class="badge"><?php echo $rows2['depth']; ?></span></td>
                                <td><?php echo $post_date; ?></td>
                              </tr>
<?php

                } else {
                    ?>
                              <tr>
                                <td><?php echo $j + 1; ?></td>
                                <td><a href="/bbs/read.php?code=<?php echo $rows['code']; ?>&main_no=<?php echo $rows2['main_no']; ?>" target="_blank"><?php echo stripslashes($rows2['title']); ?></a></td>
                                <td><?php echo $post_date; ?></td>
                              </tr>
<?php

                } // end of inner if
            } // end of inner for loop
        }
        ; // end of outer if
        ?>
                              </tbody>
                            </table>
                          </div>
                        </section>
<?php

        if ($total2 % 2 == 0) {
            echo <<<HEREDOC
                       </div> <!-- end of col-sm-6 -->
                     </div>
                     <div class="row">
                       <div class="col-sm-6">
HEREDOC;
        } else {
            echo <<<HEREDOC
                       </div> <!-- end of col-sm-6 -->
                       <div class="col-sm-6">

HEREDOC;
        }
    } // end of outer for loop
}
; //end of if($total == 0)
?>
                      </div>
                    </div><!-- end of bbs -->
                  </section>
                </section><!--main content end-->


          <!--footer start-->
          <?php include_once "../include/admin_footer.php";?>
          <!--footer end-->
        </section>
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="/js/vendor/jquery-2.2.0.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/admin/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="/admin/js/jquery.scrollTo.min.js"></script>
    <script src="/admin/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="/admin/assets/morris.js-0.4.3/morris.min.js" type="text/javascript"></script>
    <script src="/admin/assets/morris.js-0.4.3/raphael-min.js" type="text/javascript"></script>
    <script src="/admin/js/respond.min.js" ></script>
    <!--common script for all pages-->
    <script src="/admin/js/common-scripts.js"></script>
    <!-- custom scripts -->
    <script src="/js/global.js" ></script>
    <script src="/admin/js/admin.js" ></script>
    <script src="/admin/js/showMainChart.js"></script>
  </body>
</html>