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

$today     = date("Y-m-d");
$month     = date("Y-m");
$thisMonth = date("F, Y", strtotime($month));

//기업회원 미확인건
$sql_1      = "SELECT * FROM mall_order WHERE user_flag = 'c' AND cancel='N' AND status='3' AND user_id <> 'guest' ";
$res_1      = mysqli_query($connect, $sql_1);
$unchkTotal = mysqli_num_rows($res_1);

//개인회원 미확인건
$sql_2       = "SELECT * FROM mall_order WHERE user_flag = 'p' AND cancel='N' AND status='3' AND user_id <> 'guest' ";
$res_2       = mysqli_query($connect, $sql_2);
$pUnchkTotal = mysqli_num_rows($res_2);

//게시판 미답변 문의글
$sql_3   = "SELECT * FROM bbs_qna WHERE depth=0 ";
$res_3   = mysqli_query($connect, $sql_3);
$unReply = mysqli_num_rows($res_3);

//미승인 업체
$sql_5         = "SELECT * FROM member WHERE approved='N' ";
$res_5         = mysqli_query($connect, $sql_5);
$newCorpMember = mysqli_num_rows($res_5);

if ($newCorpMember == 0) {
    $newCorpMember = 0;
}

//신규 개인회원
$sql_6             = "SELECT * FROM p_member WHERE reg_date='$today' ";
$res_6             = mysqli_query($connect, $sql_6);
$newPersonalMember = mysqli_num_rows($res_6);

if ($newPersonalMember == 0) {
    $newPersonalMember = 0;
}

//승인 상품
$sql_9 = "SELECT * FROM products WHERE approved='Y' ";
$res_9 = mysqli_query($connect, $sql_9);
if ($res_9) {
    $sp_total = mysqli_num_rows($res_9);
} else {
    $sp_total = 0;
}

mysqli_query($connect, 'set names utf8');
?>
      <!--main content start-->
      <section id="main-content">
        <section class="wrapper">
          <!--state overview start-->
          <div class="row state-overview">
            <div class="col-lg-3 col-sm-6">
              <section class="panel">
                <div class="symbol yellow">
                  <i class="fa fa-cart-plus"></i>
                </div>
                <div class="value">
                  <h1>
                  <a href="../order/top_order_list.php?mode=unchk"><?php echo $unchkTotal; ?></a>
                  </h1>
                  <p>기업회원 신규 주문</p>
                </div>
              </section>
            </div>
            <div class="col-lg-3 col-sm-6">
              <section class="panel">
                <div class="symbol blue">
                  <i class="fa fa-cart-plus"></i>
                </div>
                <div class="value">
                  <h1>
                  <a href="../order/p_top_order_list.php?mode=unchk"><?php echo $pUnchkTotal; ?></a>
                  </h1>
                  <p>개인회원 신규 주문</p>
                </div>
              </section>
            </div>
            <div class="col-lg-3 col-sm-6">
              <section class="panel">
                <div class="symbol terques">
                  <i class="fa fa-user-plus"></i>
                </div>
                <div class="value">
                  <h1>
                  <a href="../member/top_member_list.php?mode=nonapproved"><?php echo $newCorpMember; ?></a>
                  </h1>
                  <p>미승인 신규 기업회원</p>
                </div>
              </section>
            </div>
            <div class="col-lg-3 col-sm-6">
              <section class="panel">
                <div class="symbol green">
                  <i class="fa fa-user-plus"></i>
                </div>
                <div class="value">
                  <h1>
                  <a href="../member/p_top_member_list.php?mode=nonapproved"><?php echo $newPersonalMember; ?></a>
                  </h1>
                  <p>금일 신규 개인회원</p>
                </div>
              </section>
            </div>
          </div>
          <!--state overview end-->

          <div class="row state-overview">
            <div class="col-lg-3 col-sm-6">
              <section class="panel">
                <div class="symbol red">
                  <i class="fa fa-cube"></i>
                </div>
                <div class="value">
                  <h1>
                  <a href="../products/top_pro_list.php"><?php echo $sp_total; ?></a>
                  </h1>
                  <p>등록상품</p>
                </div>
              </section>
            </div>
            <div class="col-lg-3 col-sm-6">
              <section class="panel">
                <div class="symbol purple">
                  <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                </div>
                <div class="value">
                  <h1>
                  <a href="/bbs/list.php?code=qna" target="_blank"><?php echo $unReply; ?></a>
                  </h1>
                  <p>미답변 문의글</p>
                </div>
              </section>
            </div>
          </div>



          <!-- 기업회원 통계 -->
          <div class="row">
            <div class="col-lg-6">
              <!-- today's sales start-->
              <section class="panel">
                <header class="panel-heading">
                  <?php echo $thisMonth; ?> :: 기업회원 주문수량 월 집계 (단위: 개)
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
                  기업회원 주문액 월 집계 (단위: 원)
                </header>
                <div class="panel-body">
                  <div id="hero-graph" class="graph"></div>
                </div>
              </section>
              <!-- monthly sales end-->
            </div>
          </div>

          <!-- 개인회원 통계 -->
          <div class="row">
            <div class="col-lg-6">
              <!-- today's sales start-->
              <section class="panel">
                <header class="panel-heading">
                  <?php echo $thisMonth; ?> :: 개인회원 주문수량 월 집계 (단위: 개)
                </header>
                <div class="panel-body">
                  <div id="hero-bar2" class="graph"></div>
                </div>
              </section>
              <!-- today's sales end-->
            </div>
            <div class="col-lg-6">
              <!-- monthly sales start-->
              <section class="panel">
                <header class="panel-heading">
                  개인회원 주문액 월 집계 (단위: 원)
                </header>
                <div class="panel-body">
                  <div id="hero-graph2" class="graph"></div>
                </div>
              </section>
              <!-- monthly sales end-->
            </div>
          </div>
          <!-- bbs start -->
          <div class="row">
            <div class="col-sm-6">

<?php

$query    = "SELECT * FROM code WHERE 1 ORDER BY num";
$result   = mysqli_query($connect, $query);
$numOfBbs = mysqli_num_rows($result);

if ($numOfBbs == 0) {
    ?>
            <div class="col-sm-12">
              <div class="alert alert-danger" role="alert">
                <p>생성된 게시판이 없습니다.</p>
                <p>관리자 페이지 > 환경설정 > <a href="/admin/bbs/bbs_list.php">게시판 설정</a>에서 게시판을 생성해 주세요.</p>
              </div>
<?php

} else {

    for ($i = 0; $rows = mysqli_fetch_array($result); $i++) {
        $board   = 'bbs_' . $rows['code'];
        $query2  = "SELECT * FROM $board WHERE 1 ORDER BY mod_date DESC LIMIT 5";
        $result2 = mysqli_query($connect, $query2);

        if ($result2) {
            $numOfPosts = mysqli_num_rows($result2);
        } else {
            $numOfPosts = 0;
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
                                  <th class="text-center" width="10%">#</th>
                                  <th class="text-center">제 목</th>
                                  <th width="20%" class="text-center">날 짜</th>
                                </tr>
                              </thead>
                              <tbody>
<?php

        if ($numOfPosts == 0) {
            echo <<<HEREDOC
                              <tr>
                                <td colspan="4"><p>등록된 글이 없습니다</p></td>
                              </tr>
HEREDOC;
        } else {
            for ($j = 0; $rows2 = mysqli_fetch_array($result2); $j++) {
                //날짜 형식을 바꾼다.
                $post_date = substr($rows2['create_date'], 0, 10);
                //답변있는 경우
                if ($rows2['depth'] > 0) {
                    ?>
                                <tr>
                                  <td class="text-center"><?php echo $rows2['main_no']; ?></td>
                                  <td><a href="/bbs/read.php?code=<?php echo $rows['code']; ?>&amp;main_no=<?php echo $rows2['main_no']; ?>" target="_blank"><?php echo stripslashes($rows2['title']); ?></a>&nbsp;<span class="badge"><?php echo $rows2['depth']; ?></span></td>
                                  <td class="text-center"><?php echo $post_date; ?></td>
                                </tr>
<?php

                } else {
                    ?>
                                <tr>
                                  <td class="text-center"><?php echo $j + 1; ?></td>
                                  <td><a href="/bbs/read.php?code=<?php echo $rows['code']; ?>&amp;main_no=<?php echo $rows2['main_no']; ?>" target="_blank"><?php echo stripslashes($rows2['title']); ?></a></td>
                                  <td class="text-center"><?php echo $post_date; ?></td>
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

        if (($i % 2) == 1) {
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

    <script src="/admin/assets/morris.js-0.4.3/morris.min.js" type="text/javascript"></script>
    <script src="/admin/assets/morris.js-0.4.3/raphael-min.js" type="text/javascript"></script>
    <script src="/admin/js/showMainChart.js"></script>
  </body>
</html>