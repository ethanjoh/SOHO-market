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
$mode = set_var($_POST['get']);
$p_id = set_var($_SESSION['p_id']);

$today = date("Y-m-d");

//미확인건
$unchk_sql   = "SELECT * FROM mall_order WHERE cancel='N' AND status='3' AND user_id = '$p_id' ";
$unchk_res   = mysqli_query($connect, $unchk_sql);
$unchk_total = mysqli_num_rows($unchk_res);

//금일주문건
$today_sql   = "SELECT * FROM mall_order WHERE cancel='N' AND createdate='$today' AND user_id = '$p_id' ";
$today_res   = mysqli_query($connect, $today_sql);
$today_total = mysqli_num_rows($today_res);

//발송대기건
$paid_sql   = "SELECT * FROM mall_order WHERE cancel='N' AND status='7' AND user_id = '$p_id' ";
$paid_res   = mysqli_query($connect, $paid_sql);
$paid_total = mysqli_num_rows($paid_res);

switch ($mode) {
    case 'search':
        $sql_2 = "SELECT num FROM mall_order WHERE user_id = '$p_id' AND $key LIKE '%$key_value%' ";
        break;
    case 'date':
        $sql_2 = "SELECT num FROM mall_order WHERE user_id = '$p_id' AND createdate BETWEEN '$date1' AND '$date2' ";
        break;
    case 'today':
        $today = date("Y-m-d");
        $sql_2 = "SELECT num FROM mall_order WHERE cancel = 'N' AND user_id = '$p_id' AND createdate = '$today' ";
        break;
    case 'unchk':
        $sql_2 = "SELECT num FROM mall_order WHERE cancel = 'N' AND user_id = '$p_id' AND status = '3' ";
        break;
    case 'chk':
        $sql_2 = "SELECT num FROM mall_order WHERE cancel = 'N' AND user_id = '$p_id' AND status = '5' ";
        break;
    case 'paid':
        $sql_2 = "SELECT num FROM mall_order WHERE cancel = 'N' AND user_id = '$p_id' AND status = '7' ";
        break;
    case 'finish':
        $sql_2 = "SELECT num FROM mall_order WHERE cancel = 'N' AND user_id = '$p_id' AND status = '8' ";
        break;
    case 'cancel':
        $sql_2 = "SELECT num FROM mall_order WHERE cancel = 'Y' AND user_id = '$p_id' ";
        break;
    default:
        $sql_2 = "SELECT num FROM mall_order WHERE user_id = '$p_id' ";
}

// 자료 총수 구하기
$res_2 = mysqli_query($connect, $sql_2);
$total = mysqli_num_rows($res_2);

//적립금 계산
// if ($_SESSION['p_id']) {
//     $msql2  = "SELECT SUM(mileage) AS mileage FROM mileage WHERE id_fk = '$p_id' ";
//     $mres2  = mysqli_query($connect, $msql2);
//     $mrow2  = mysqli_fetch_array($mres2);
//     $t_mile = number_format($mrow2['mileage']);
// } else {
//     $t_mile = 0;
// }

//$total = mysqli_num_rows($res_2);

//if($total) {
$scale = 20;
$page  = '';

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

                    <a class="btn btn-default btn-sm" type="button" href="order-list.php?mode=today">금일 주문건 ( <?php echo $today_total; ?> )</a>
                    <a class="btn btn-default btn-sm" type="button" href="order-list.php?mode=unchk">미처리 주문건 ( <?php echo $unchk_total; ?> )</a>
                    <a class="btn btn-default btn-sm" type="button" href="order-list.php?mode=chk">주문확인건</a>
                    <a class="btn btn-default btn-sm" type="button" href="order-list.php?mode=paid">발송대기건 ( <?php echo $paid_total; ?> )</a>
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
switch ($mode) {
    case 'search':
        $sql_4 = "SELECT * FROM mall_order
                        WHERE $key LIKE '%$key_value%'
                        AND user_id = '$p_id'
                        ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'date':
        $sql_4 = "SELECT * FROM mall_order
                              WHERE createdate BETWEEN '$date1' AND '$date2'
                          AND user_id = '$p_id'
                          ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'today':
        $today = date("Y-m-d");
        $sql_4 = "SELECT * FROM mall_order
                              WHERE cancel = 'N'
                          AND user_id = '$p_id'
                          AND createdate = '$today'
                          ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'unchk':
        $sql_4 = "SELECT * FROM mall_order
                              WHERE cancel = 'N'
                          AND status = '3'
                          AND user_id = '$p_id'
                          ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'chk':
        $sql_4 = "SELECT * FROM mall_order
                              WHERE cancel = 'N'
                          AND user_id = '$p_id'
                          AND status = '5'
                          ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'paid':
        $sql_4 = "SELECT * FROM mall_order
                              WHERE cancel = 'N'
                          AND user_id = '$p_id'
                          AND status = '7'
                          ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'finish':
        $sql_4 = "SELECT * FROM mall_order
                              WHERE cancel = 'N'
                          AND user_id = '$p_id'
                          AND status = '8'
                          ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'cancel':
        $sql_4 = "SELECT * FROM mall_order
                              WHERE cancel = 'Y'
                          AND user_id = '$p_id'
                          ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    default:
        $sql_4 = "SELECT * FROM mall_order
                              WHERE user_id = '$p_id'
                                ORDER BY num DESC LIMIT $cline,$scale1 ";
}

$res_4      = mysqli_query($connect, $sql_4);
$t_no       = mysqli_num_rows($res_4);
$status_now = '';

if ($t_no > 0) {

    $total = 0; //금일주문총액

    for ($i = 0; $row = mysqli_fetch_array($res_4); $i++) {
        $a_goods_fk = explode(",", $row['goods_fk']);

        $pro_sql    = "SELECT * FROM products WHERE num='$a_goods_fk[0]'";
        $pro_result = mysqli_query($connect, $pro_sql);
        $pro_row    = mysqli_fetch_array($pro_result);

        if (count($a_goods_fk) > 1) {
            $goods_name = cut_string_utf8($pro_row['name'], 30, '...') . " (외)";
        } else {
            $goods_name = cut_string_utf8($pro_row['name'], 30, '...');
        }

        if ($row['cancel'] == 'Y') {
            $status_now = '<i class="fa fa-remove"></i> 주문취소';
            $total -= $row['last_amount'];
            ?>
                    <tr>
                      <td>
                        <a href="order-detail.php?oid=<?php echo $row['num']; ?>&amp;page=<?php echo $page; ?>"><?php echo $row['createdate']; ?></a></td>
                      <td><?php echo $goods_name; ?>&nbsp;
                      <?php
if ($row['supplement']) {
                ?>
                      <i class="fa fa-comment-o pop" data-toggle="popover" data-container="body" title="관리자 메모" data-content="<?php echo $row['supplement']; ?>"></i>
                    <?php
}
            ?>
                      </td>
                      <td><?php echo $row['recipient_name']; ?></td>
                      <td> - <br /></td>
                      <td><?php echo $status_now; ?></td>
                      <td><a href="#" onclick="javascript:alert('이미 취소된 주문입니다.')"><i class="fa fa-remove"></i></a></td>
                      <?php
} else {
            //end cancel

            if ($row['status'] == '1') {
                $status_now = '<i class="fa fa-pause"></i> 입금대기';
            } else if ($row['status'] == '3') {
                $status_now = '<i class="fa fa-pause"></i> 대기';
            } else if ($row['status'] == '5') {
                $status_now = '<i class="fa fa-check"></i> 주문확인';
            } else if ($row['status'] == '7') {
                $status_now = '<i class="fa fa-flag-checkered"></i> 발송대기';
            } else if ($row['status'] == '8') {
                $status_now = '<i class="fa fa-check-square-o"></i> 발송완료';
            }

            ?>
                    <tr>
                      <td><a href="order-detail.php?oid=<?php echo $row['num']; ?>&amp;page=<?php echo $page; ?>"><?php echo $row['createdate']; ?></a></td>
                      <td><?php echo $goods_name; ?>&nbsp;
                        <?php
if ($row['supplement']) {
                ?>
                        <i class="fa fa-comment-o pop" data-toggle="popover" data-container="body" title="관리자가 남긴 메모가 있습니다." data-content="<?php echo $row['supplement']; ?>"></i>
                        <?php
}
            ?>
                      </td>
                      <td><?php echo $row['recipient_name'] ? $row['recipient_name'] : ""; ?></td>
                      <td><?php echo number_format($row['amount']); ?></td>
                      <!-- <td><a href="javascript:alert('상품이 발송되어 취소가 되지 않습니다.')"><i class="fa fa-remove"></i></a></td> -->
                      <td><?php echo $status_now; ?></td>
                      <td><a href="order-delete.php?oid=<?php echo $row['num']; ?>&amp;page=<?php echo $page; ?>" onclick="return confirm('정말 주문을 취소하시겠습니까?')"><i class="fa fa-remove"></i></a></td>
                    </tr>
                    <?php

            // $total += $row['last_amount'];
            $total += ($row['amount']);
        } // if-else end
    }
    ; // for loop end
    ?>
                    <tr>
                      <td colspan="3"><strong>총합(VAT 포함):</strong></td>
                      <td><strong><?php echo number_format($total); ?></strong></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>

                <?php
} else {
    ?>
                    <tr>
                      <td class="text-center" colspan="6"><div class="alert alert-danger"><h3>해당 주문내역이 없습니다.</h3></div></td>
                    </tr>

                    <?php
}
?>

                  </tbody>
                </form>
                </table>
                </div> <!-- end panel-body -->
              </div> <!-- end panel -->

              <div class="row text-center">
                  <div class="col-sm-12">
                  <?php
$key       = set_var($_GET['key']);
$key_value = set_var($_GET['key_value']);
$date1     = set_var($_GET['date1']);
$date2     = set_var($_GET['date2']);

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
</div>
<!-- /.wrapper -->

<?php include_once '../include/brands.php';?>

<?php include_once '../include/footer.php';?>

      <script src="/js/jquery.plugins.js"></script>
      <script src="/js/jquery-ui.min.js"></script>
      <script src="/js/highcharts.js"></script>
      <script src="/js/jquery.highchartTable-min.js"></script>
      <script src="/js/showChart.js"></script>
      <script src="/js/jq_datepicker.js"></script>

    </body>
</html>
