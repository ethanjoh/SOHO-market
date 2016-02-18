<?php include_once '../include/header.php';?>

<?php

$mode  = set_var($_GET['mode']);
$date1 = set_var($_GET['date1']);
$date2 = set_var($_GET['date2']);

?>
    <!-- HOME -->
    <div class="overlay home medium-size">
        <div class="bg bg-shop" data-stellar-background-ratio="0.5"></div>
        <div class="container vmiddle">
            <div class="row text-center">
                <div class="icon-big color icon-caddie-shopping-streamline"></div>
                <h1>통계 조회</h1>
            </div>
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
              <a href="order-list.php" type="button" class="btn btn-primary"><i class="fa fa-check-square-o"></i>주문 조회가기</a>
            </div>
            <div class="col-sm-3">
              <a href="#" type="button" class="btn btn-default">통계 조회</a>
            </div>
          </div>
          <!-- end order/stat section -->

          <div class="row margin-top-30 margin-bottom-30">
            <ul>
              <li><i class="fa fa-info-circle"></i> 기간 별 구매통계를 보여줍니다.</li>
              <li><i class="fa fa-info-circle"></i> 그래프 하단의 수량과 금액을 각각 누를 때 마다 해당 통계를 온/오프할 수 있습니다.</li>
            </ul>
          </div>

          <div class="row">

            <!-- calendar start -->
            <form method="get" action="order-stat-list.php" class="form-inline form-group" role="form">
              <input type="hidden" name="mode" value="date" />
              <div class="panel panel-info">
                <div class="panel-heading">날짜 검색</div>
                <div class="panel-body text-center">

                  <div class="row text-center">
                    <div class="form-group date-input">
                        <label for="sd"><i class="fa fa-calendar"></i>시작일 :</label>
                        <input type="text" class="form-control" name="date1" id="sd" value="" size="10" />
                    </div>
                    <div class="form-group">
                        <label for="ed"><i class="fa fa-calendar"></i>종료일 :</label>
                        <input type="text" class="form-control" name="date2" id="ed" value="" size="10" />
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-sm" onclick="submit()"><i class="fa fa-search"></i>검색</button>
                    </div>
                  </div>

                </div>
              </div>
            </form>
            <!-- calendar end -->


<?php

$total = 0; //공급가합
$sales = array();

if ("date" == $mode) {
    $search_qry = " AND createdate BETWEEN '$date1' AND '$date2' ";
    $date       = "(" . $date1 . " ~ " . $date2 . ")";
} else {
    $today      = date("Y-m-d");
    $search_qry = " AND createdate='$today' ";
    $date       = "(" . $today . " ~ " . $today . ")";
}
?>

              <div id="progressbar1"></div>

              <div>
                <div id="graph1"></div>
              </div>

              <table class="highchart" data-graph-container-before="1" data-graph-container="#graph1" data-graph-type="column" data-graph-margin-left="50" data-graph-margin-right="50" data-graph-subtitle-text="<?php echo $date; ?>" style="display:none;">
                <caption>구매 TOP 10 리스트  </caption>
                <thead>
                  <tr>
                    <!-- <th>번호</th> -->
                    <th>상품명</th>
                    <!-- <th scope="col">옵션</th> -->
                    <th>수량</th>
                    <th>금액(단위 만원)</th>
                  </tr>
                </thead>
                <tbody>
<?php

$p_no = 0;

//1. 전체 주문을 구한다.
$sql = "SELECT * FROM mall_order WHERE cancel='N' AND status='8' AND user_id='$_SESSION[p_id]' $search_qry  ORDER BY num DESC";
$res = mysqli_query($connect, $sql);

$sales[] = array('num', 'createdate', 'sub_total');

//2. 각 주문에서 제품코드를 구한다.
for ($i = 0; $row = mysqli_fetch_array($res); $i++) {
    $a_goods_fk = explode(",", $row['goods_fk']);
    $mod_volume = explode(",", $row['mod_count']); //변경된 수량
    $mod_price  = explode(",", $row['mod_price']); //변경된 수량
    $option     = explode(",", $row['goods_kind']); //옵션정보

    //구매금액 집계를 위한 배열
    $sales[] = array(
        'num'        => $row['num'],
        'createdate' => $row['createdate'],
        'sub_total'  => $row['last_amount'],
    );

    $total += $row['last_amount'];

    //3. 해당 주문에서 해당 공급업체의 상품이 있는지 확인한다.
    for ($j = 0; $j < sizeof($a_goods_fk); $j++) {
        $p_sql    = "SELECT * FROM products WHERE num='$a_goods_fk[$j]' ";
        $p_result = mysqli_query($connect, $p_sql);

        $p_row = mysqli_fetch_array($p_result);
        $p_no  = mysqli_num_rows($p_result);

        //$offer_price = $p_row['retail_price'];
        $offer_price = $mod_price[$j];
        //$sub_total = $offer_price * $mod_volume[$j];

        $goods[] = array(
            'num'      => $p_row['num'],
            'company'  => $p_row['company'],
            'name'     => $p_row['name'],
            'option'   => $option[$j],
            'quantity' => $mod_volume[$j],
            'amount'   => $mod_price[$j] * $mod_volume[$j],
        );
        //$total += $sub_total;
    } //for end
} //for end

// echo "<pre>";
// print_r($goods);
// echo "</pre>";

function cmp($a, $b)
{
    if ($a["quantity"] == $b["quantity"]) {
        return 0;
    }

    return ($a["quantity"] > $b["quantity"]) ? -1 : 1;

    //return strcmp($a["quantity"], $b["quantity"]);
}

if ($p_no) {

    foreach ($goods as $key => $values) {

        $new[$values['num']]['company'] = $values['company'];
        $new[$values['num']]['name']    = $values['name'];
        $new[$values['num']]['option']  = $values['option'];
        $new[$values['num']]['quantity'] += $values['quantity'];
        $new[$values['num']]['amount'] += $values['amount'];

    }

    unset($values);

    usort($new, "cmp"); //수량에 따라 정열

    $i = 0;
    foreach ($new as $row) {
        ?>
                  <tr>
                    <!-- <td><?php echo $i + 1; ?></td> -->
                    <td>[<?php echo $row['company']; ?>] <?php echo $row['name']; ?></td>
                    <!-- <td><?php echo $row['option']; ?></td> -->
                    <td><?php echo $row['quantity']; ?></td>
                    <td><?php echo ($row['amount'] / 10000); ?></td>
                  </tr>
                  <?php
if ($i != 0) {
            $temp_qty .= ",";
            $temp_name .= ",";
        }
        $temp_qty .= $row['quantity'];
        $temp_name .= $row['name'];

        if ($i <= 10) {
            $i++;
        } else {
            break;
        }

    }

    unset($row);
    ?>
              </tbody>
            </table>

            <div>
              <div id="graph2"></div>
            </div>

            <table class="highchart" data-graph-container-before="1" data-graph-container="#graph2" data-graph-type="line" data-graph-margin-left="50" data-graph-margin-right="50" data-graph-subtitle-text="<?php echo $date; ?>" style="display:none;">
              <caption>구매금액 집계 </caption>
              <thead>
                <tr>
                  <!-- <th scope="col">번호</th> -->
                  <th>구매일</th>
                  <th>확정금액 소계(VAT 포함 / 단위 만원)</th>
                </tr>
              </thead>
              <tbody>
<?php

    foreach ($sales as $key => $values) {
        $sum[$values['createdate']] += $values['sub_total'];
    }

    reset($sum);
    ksort($sum);

    $day = array("일", "월", "화", "수", "목", "금", "토");
    $i   = 0;
    foreach ($sum as $date => $sub_total) {
        ?>
                <tr>
                  <!-- <td><?php echo $i + 1; ?></td> -->
                  <td><?php echo $date; ?> (<?php echo $day[date("w", strtotime($date))]; ?>)</td>
                  <td><?php echo ($sub_total / 10000); ?></td>
                </tr>
                <?php

        if ($i != 0) {
            $temp_createdate .= ",";
            $temp_total .= ",";
        }
        $temp_createdate .= $date;
        $temp_total .= $sub_total;

        $i++;
    }

    ?>
              </tr>
            </tbody>
          </table>

          <table id="total">
              <tr>
                <td colspan="2"><strong>총합:</strong></td>
                <td><strong><?php echo number_format($total); ?> 원(VAT 포함)</strong></td>
              </tr>
          </table>


<?php

} else {
    ?>
          <tr>
            <td colspan="4"><p>조회 결과가 없습니다.</p></td>
          </tr>
        </tbody>
      </table>
<?php

}
?>
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

    </body>
</html>
