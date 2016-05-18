<?php include_once '../include/header.php';?>

  <body>
    <section id="container" >
        <!--header start-->
        <?php include_once "../include/admin_head.php";?>
        <!--header end-->

        <!--sidebar start-->
        <?php include_once "../include/admin_sidebar.php";?>
        <!--sidebar end-->

    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">

      <form action="track_a_list.php" class="form-inline" role="form" name="f" method="post" >

<?php

$mode    = set_var($_GET['mode']);
$date1   = set_var($_GET['date1']);
$date2   = set_var($_GET['date2']);
$key     = set_var($_GET['key']);
$keyword = set_var($_GET['keyword']);

switch ($mode) {
    case 'date':
        $sql_2 = "SELECT orderid FROM mall_order
    		          WHERE status = '7'
                        AND cancel = 'N'
              				  AND delivery_type = 'L'
              				  AND createdate BETWEEN '$date1' AND '$date2' ";
        break;
    default:
        $sql_2 = "SELECT orderid FROM mall_order
    	   				  WHERE status = '7'
                        AND delivery_type = 'L'
            					  AND cancel = 'N' ";
}

$res_2 = mysqli_query($connect, $sql_2);
$total = mysqli_num_rows($res_2);

$page  = set_var($_GET['page']);
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
                운송장번호 입력 (총 <?php echo number_format($total); ?> 건)
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
                               		ORDER BY num DESC LIMIT $cline,$scale1 ";
}

$res_4 = mysqli_query($connect, $sql_4);
$t_no  = mysqli_num_rows($res_4);

if ($t_no > 0) {

    for ($i = 0; $row = mysqli_fetch_array($res_4); $i++) {
        if ($row['user_flag'] == "c") {
            $order_view = 'or_view.php';
        } elseif ($row['user_flag'] == "p") {
            $order_view = 'p_or_view.php';
        }

        ?>
                    <tr>
                      <td>
                        <a href="<?php echo $order_view; ?>?mode=<?php echo $mode; ?>&amp;oid=<?php echo $row['num']; ?>&amp;key=<?php echo $key; ?>&amp;keyword=<?php echo $keyword; ?>&amp;page=<?php echo $page; ?>" target="_blank">
                        <?php echo $row['orderid']; ?></a>
                      </td>
                      <td><?php echo $row['createdate']; ?></td>
                      <td><?php echo $row['recipient_name'] ? $row['recipient_name'] : $row['buyer_name']; ?></td>
                      <td>
                        <form name="form1" class="form-inline" role="form" method="post" action="or_changed.php">
                          <input type="hidden" name="mode" value="all" />
                          <input type="hidden" name="oid" value="<?php echo $row['num']; ?>" />
                          <input type="hidden" name="last_amount" value="<?php echo $row['last_amount']; ?>" />
                          <input type="hidden" name="senddate" value="<?php echo date("Y-m-d H:i:s"); ?>" />
                          <input type="hidden" name="reUrl" value="<?php echo urlencode($_SERVER['PHP_SELF'] . "?" . $_SERVER['QUERY_STRING']); ?>" />
                          <input type="text" class="form-control" name="track_no" value="<?php echo $row['track_no']; ?>" size="80" />
                          &nbsp;
                          <button class="btn btn-success" type="submit" onclick="form1.submit()"><i class="fa fa-paper-plane"></i> 발 송</button>
                        </form>
                      </td>
                    </tr>
<?php

    } // for loop end

} else {

    ?>
                    <tr>
                      <td colspan="4"><p class="text-center">송장입력이 완료되었거나 해당 주문내역이 없습니다.</p></td>
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

          <!-- page navigation start -->
            <div class="row text-center">
              <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table">
                      <tbody>
                        <tr>
                          <td>
<?php

$url = $_SERVER['PHP_SELF'] . '?mode=' . $mode . '&key=' . $key . '&keyword=' . $keyword;
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

          </section>
      </section>
      <!--main content end-->

      <!--footer start-->
    <?php include_once "../include/admin_footer.php";?>
      <!--footer end-->

    <script src="/admin/js/jquery-ui.min.js"></script>
    <script src="/admin/js/jq_datepicker.js" ></script>

  </body>
</html>