<?php include_once '../include/header.php';?>

    <!-- HOME -->
    <div class="container">
        <div class="row text-center">
            <h1>주문 조회</h1>
        </div>
    </div>
    <!-- /.home -->

    <!-- content -->
    <div class="content">

        <!-- CONTAINER: order list -->
        <div class="container">

          <!-- order/stat section -->
          <div class="row text-center">
            <div class="col-sm-3 col-sm-offset-3">
              <a href="#" type="button" class="btn btn-default">주문 조회</a>
            </div>
            <div class="col-sm-3 ">
              <a href="order-stat-list.php" type="button" class="btn btn-primary"><i class="fa fa-bar-chart"></i>통계 조회 가기</a>
            </div>
          </div>
          <!-- end order/stat section -->

          <div class="row margin-top-30 margin-bottom-30">
            <ul>
              <li><i class="fa fa-info-circle"></i> 주문일을 클릭하시면 상세내역을 보실 수 있습니다.</li>
              <li><i class="fa fa-info-circle"></i> 그래프 하단의 수량과 금액을 각각 누를 때 마다 해당 통계를 온/오프할 수 있습니다.</li>
            </ul>
          </div>

          <?php
$mode  = set_var($_GET['mode']);
$cpage = set_var($_GET['page']);

// $today = date("Y-m-d");
// $p_id      = set_var($_SESSION['p_id']);
$key       = set_var($_GET['key']);
$key_value = set_var($_GET['key_value']);
$date1     = set_var($_GET['date1']);
$date2     = set_var($_GET['date2']);

//페이징을 위한 페이지수 구하기
$scale         = get_page_num($mode, $key, $key_value, $date1, $date2, 1, 20);
$cline         = $scale[0];
$last_page_num = $scale[1];
$cpage         = $scale[2];
$totalpage     = $scale[3];

?>

          <div class="row">

              <!-- calendar start -->
              <form method="get" action="order-list.php" class="form-inline form-group" role="form">
                <input type="hidden" name="mode" value="date" />
                <div class="panel panel-info margin-top-10">
                  <div class="panel-heading">날짜 검색</div>
                  <div class="panel-body text-center">

                    <div class="row text-center">
                      <div class="form-group date-input">
                          <label for="sd"><i class="fa fa-calendar"></i>시작일 :</label>
                          <input type="text" class="form-control " name="date1" id="sd" value="" size="10" />
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
              <div class="panel panel-info margin-top-10">
                <div class="panel-heading">주문 목록</div>
                <div class="panel-body">

                  <div class="row text-center">

                    <a class="btn btn-default btn-sm" type="button" href="order-list.php?mode=today">금일 주문건 ( <?php echo check_today_order(); ?> )</a>
                    <a class="btn btn-default btn-sm" type="button" href="order-list.php?mode=unchk">미처리 주문건 ( <?php echo check_unChk_order(); ?> )</a>
                    <a class="btn btn-default btn-sm" type="button" href="order-list.php?mode=chk">주문확인건</a>
                    <a class="btn btn-default btn-sm" type="button" href="order-list.php?mode=paid">발송대기건 ( <?php echo check_readyToSend_order(); ?> )</a>
                    <a class="btn btn-default btn-sm" type="button" href="order-list.php?mode=finish">발송완료건</a>
                    <a class="btn btn-default btn-sm" type="button" href="order-list.php?mode=cancel">주문취소건</a>
                    <a class="btn btn-primary btn-sm" type="button" href="order-list.php?mode=all">전체 주문</a>

                  </div>

                <form action="order-list.php" name="f" method="post" >
                <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>주문일</th>
                      <th>상품명</th>
                      <th>수령자</th>
                      <th>주문액</th>
                      <th>처리상태</th>
                      <th>취소</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

//페이징을 위한 페이지수 구하기
$ret   = get_page_result($mode, $key, $key_value, $date1, $date2, $cline, $last_page_num);
$t_no  = $ret[0];
$res_4 = $ret[1];

// 주문리스트 보여주기
echo show_order_list($t_no, $res_4, $cpage);
?>

                  </tbody>
                </form>
                </table>
                </div> <!-- end panel-body -->
              </div> <!-- end panel -->

              <div class="row text-center">
                  <div class="col-sm-12">
                  <?php

$url = "order-list.php?mode=" . $mode . "&key=" . $key . "&key_value=" . $key_value . "&date1=" . $date1 . "&date2=" . $date2;
page_nav($totalpage, $cpage, $url);
?>
                  </div>
              </div>

              <div class="row">
                <form method="get" name="search" action="order-list.php">
                  <div class="col-sm-2 col-sm-offset-3">
                    <select name="key" data-width="100%">
                      <option value="goods_name">상품명</option>
                      <option value="recipient_name">수령자</option>
                    </select>
                  </div>

                  <div class="col-sm-3">
                    <input type="text" name="key_value" placeholder="검색어">
                  </div>

                  <div class="col-sm-3">
                    <button class="btn btn-primary btn-sm" type="submit"><i class="fa fa-search"></i>검색</button>
                  </div>
                </form>
              </div> <!-- end row -->

          </div>
          <!-- end top row -->
        </div>
        <!-- /.container -->

    </div>
    <!-- /.content -->


<?php include_once '../include/brands.php';?>

<?php include_once '../include/footer.php';?>

      <script src="/js/jquery.plugins.js"></script>
      <script src="/js/jquery-ui.min.js"></script>
      <script src="/js/highcharts.js"></script>
      <script src="/js/jquery.highchartTable-min.js"></script>
      <script src="/js/showChart.js"></script>
      <script src="/js/jq_datepicker.js"></script>
      <script>
          $(document).ready(function() {

              $(".pop").popover({
                placement : 'top'
              });

              $("#guestModal0").modal("show");

          });
      </script>
    </body>
</html>
