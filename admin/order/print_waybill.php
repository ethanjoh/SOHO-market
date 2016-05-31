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
                <li><i class="fa fa-info-circle"></i> 택배시스템에 대량으로 업로드하려면 엑셀파일을 다운받으세요.</li>
                <li><i class="fa fa-info-circle"></i> 엑셀파일을 열 때 경고창이 나오면 "예"를 누르세요.</li>
              </ul>
            </section>
          </div>
        </div>
        <!-- info end -->

<?php

$mode  = set_var($_GET['mode']);
$page  = set_var($_GET['page']);
$date1 = set_var($_GET['date1']);
$date2 = set_var($_GET['date2']);
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
                주문 목록 ( <?php echo $date1; ?>  ~ <?php echo $date2; ?>  기간 내 총 <?php echo $total; ?> 건)
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
                        <td><?php echo $row['orderid']; ?></td>
                        <td><?php echo $row['createdate']; ?></td>
                        <td><?php echo $row['recipient_name'] ? $row['recipient_name'] : $row['buyer_name']; ?></td>
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

        // 택배비 결정 및 제주도 택배비 설정
        if ($row['recipient_name']) {
            $re = define_delivery_fee($row['trans_cost'], $row['recipient_zipcode']);
        } else {
            $re = define_delivery_fee($row['trans_cost'], $row['buyer_zipcode']);
        }

        ?>
                        <td><?php echo $goods_name; ?></td>
                        <td>1</td>
                        <td><?php echo $row['recipient_name'] ? $row['recipient_zipcode'] : $row['buyer_zipcode']; ?></td>
                        <td><?php echo $row['recipient_name'] ? $row['recipient_address'] : $row['buyer_address']; ?></td>
                        <td><?php echo $row['recipient_name'] ? $row['recipient_phone'] : $row['buyer_phone']; ?></td>
                        <td><?php echo $row['recipient_name'] ? $row['recipient_hphone'] : $row['buyer_hphone']; ?></td>
                        <td><?php echo $re['credit']; ?></td>
                        <td><?php echo $re['t_cost']; ?></td>
                        <td>
<?php

        if ($row['memo_to_delivery']) {
            echo $row['memo_to_delivery'];
        }

        ?>
                        </td>
                      <!--
                      <td><?php echo $row['recipient_name'] ? $row['buyer_name'] : ""; ?></td>
                      <td><?php echo $row['recipient_name'] ? $row['buyer_phone'] : ""; ?></td>
                      -->
                      </tr>
<?php

    }
    ; // for loop end
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
            <div class="row text-center">
              <div class="col-sm-12 excel_btn">
                <a type="button" class="btn btn-success" href="tracktoexcel_a.php?date1=<?php echo $date1; ?>&amp;date2=<?php echo $date2; ?>"><i class="fa fa-file-excel-o"></i> 엑셀로 다운로드</a>
              </div>
            </div>
          </section>
        </div>
      </div>

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
