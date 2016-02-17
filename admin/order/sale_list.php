<?php include_once '../include/header.php';?>

<?php
$mode  = set_var($_GET['mode']);
$date1 = set_var($_GET['date1']);
$date2 = set_var($_GET['date2']);
$id    = set_var($_GET['id']);

?>

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
                <li><i class="fa fa-info-circle"></i> 조회하실 기간을 설정하신 후 검색 버튼을 누릅니다.</li>
                <li><i class="fa fa-info-circle"></i> 업체명별로 검색을 원할 때는 해당 업체를 선택합니다.</li>
                <li><i class="fa fa-info-circle"></i> 날짜로만 검색 시에는 모든 업체의 통계가 합산되어 나옵니다.</li>
              </ul>
            </section>
          </div>
        </div>
        <!-- info end -->

        <!-- calendar start -->
        <form name="f" method="get" action="sale_list.php" class="form-inline form-group" role="form">
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
                    <button class="btn btn-primary btn-sm" onclick="document.f.submit()"><i class="fa fa-search"></i>검색</button>
                </div>
              </div>

            </div>
        </div>
        </form>
        <!-- calendar end -->

<?php

if ($mode == "date") {

    ?>
        <!-- search company start -->
        <form name="f1" method="get" action="sale_list.php" class="form-inline form-group" role="form">
        <input type="hidden" name="mode" value="com" />
        <div class="panel panel-info">
          <div class="panel-heading">업체별 검색</div>
            <div class="panel-body text-center">

              <div class="row text-center">
                <div class="form-group">
                    <select name="id" class="form-control" onchange="show_sales('<?=$date1;?>','<?=$date2;?>');">
                      <option>업체명 - 아이디</option>
                    <?php
$mqry = "SELECT * FROM member ORDER BY company_name ";
    $mres = mysqli_query($connect, $mqry);

    for ($i = 0; $mrow = mysqli_fetch_array($mres); $i++) {
        echo "<option value=" . $mrow['id'] . ">" . $mrow['company_name'] . " - " . $mrow['id'] . "</option>\n";
    }
    ?>
                    </select>
                </div>

<!--                 <div class="form-group">
                    <button class="btn btn-primary btn-sm" onclick="document.f1.submit()"><i class="fa fa-search"></i>검색</button>
                </div> -->
              </div>

            </div>
        </div>
        </form>
        <!-- search company end -->
<?php
}
?>


          <?php
$total = 0; //공급가합
$sales = array();
if ($mode == "date") {
    $search_qry = " AND date(createdate) BETWEEN '$date1' AND '$date2' ";
    $date       = "(" . $date1 . " ~ " . $date2 . ")";
} else if ($mode == "com") {
    $search_qry = " AND user_id = '$id' AND date(createdate) BETWEEN '$date1' AND '$date2' ";
    $date       = "(" . $date1 . " ~ " . $date2 . ")";
} else {
    $today      = date("Y-m-d");
    $search_qry = " AND date(createdate) = '$today' ";
    $date       = "(" . $today . " ~ " . $today . ")";
}
?>

          <div>
            <div id="graph1"></div>
          </div>

          <table class="highchart" data-graph-container-before="1" data-graph-container="#graph1" data-graph-type="column" data-graph-margin-left="150" data-graph-margin-right="150" data-graph-subtitle-text="<?=$date;?>" style="display:none;">
            <caption>판매 TOP 10 리스트</caption>
            <thead>
              <tr>
                <th>상품명</th>
                <th>수량</th>
                <th>금액(VAT 별도 / 단위 만원)</th>
              </tr>
            </thead>
            <tbody>
              <?php

//1. 전체 주문을 구한다.
$sql = "SELECT * FROM mall_order WHERE cancel='N' AND status='8' $search_qry  ORDER BY num DESC";
$res = mysqli_query($connect, $sql);

$p_no = 0;

//2. 각 주문에서 제품코드를 구한다.
for ($i = 0; $row = mysqli_fetch_array($res); $i++) {
    $a_goods_fk = explode(",", $row['goods_fk']);
    $mod_volume = explode(",", $row['mod_count']); //변경된 수량
    $mod_price  = explode(",", $row['mod_price']); //변경된 수량
    $option     = explode(",", $row['goods_kind']); //옵션정보

    //판매금액 집계를 위한 배열
    //날짜형식 변환 Y-m-d H:i:s -> Y-m-d
    $raw_date     = date_create($row['createdate']);
    $convert_date = date_format($raw_date, "Y-m-d");

    $sales[] = array(
        'num'        => $row['num'],
        'createdate' => $convert_date,
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

        // if (isset($values['quantity'])) {
        $new[$values['num']]['quantity'] += $values['quantity'];
        // }

        // if (isset($values['amount'])) {
        $new[$values['num']]['amount'] += $values['amount'];
        // }
    }

    unset($values);

    usort($new, "cmp"); //수량에 따라 정열

    $i = 0;
    foreach ($new as $row) {
        ?>
              <tr>
                <td>[<?=$row['company'];?>] <?=$row['name'];?></td>
                <td><?=$row['quantity'];?></td>
                <td><?=$row['amount'] / 10000;?></td>
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

        <table class="highchart" data-graph-container-before="1" data-graph-container="#graph2" data-graph-type="line" data-graph-margin-left="150" data-graph-margin-right="150" data-graph-subtitle-text="<?=$date;?>" style="display:none;">
          <caption>일별 판매금액 집계 </caption>
          <thead>
            <tr>
              <th>판매일</th>
              <th>확정금액 소계(VAT 별도 / 단위 만원)</th>
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
              <td><?=$date;?> (<?=$day[date("w", strtotime($date))];?>)</td>
              <td><?=$sub_total / 10000;?></td>
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
            <td colspan="2"><strong>확정금액 총합:</strong></td>
            <td><strong><?=number_format($total);?></strong></td>
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
    <script src="/admin/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="/admin/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="/admin/js/jquery.scrollTo.min.js"></script>
    <script src="/admin/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="/admin/js/respond.min.js" ></script>

    <!--common script for all pages-->
    <script src="/admin/js/common-scripts.js"></script>

    <!-- custom scripts -->
    <script src="/js/global.js" ></script>
    <script src="/admin/js/admin.js" ></script>

    <script src="/admin/js/jq_datepicker.js" ></script>
    <script src="/admin/js/highcharts.js"></script>
    <script src="/admin/js/jquery.highchartTable-min.js"></script>
    <script src="/admin/js/showChart.js"></script>

  </body>
</html>


