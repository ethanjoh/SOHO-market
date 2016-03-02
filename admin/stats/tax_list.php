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

        <!-- info start-->
        <div class="row">
              <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading">
                사용방법
              </header>
              <ul class="info-body">
                <li><i class="fa fa-info-circle"></i> 조회하실 기간을 설정하신 후 잠시 기다리시기 바랍니다.</li>
                <li><i class="fa fa-info-circle"></i> 업체명을 클릭해 상세주문내역과 비교확인하신 후 발행하시기 바랍니다.</li>
              </ul>
            </section>
          </div>
        </div>
        <!-- info end -->

        <!-- calendar start -->
        <form name="form" method="get" action="tax_list.php" class="form-inline form-group" role="form">
        <input type="hidden" name="mode" value="date" />
        <input type="hidden" name="key" value="<?php echo $key; ?>" />
        <input type="hidden" name="key_value" value="<?php echo $key_value; ?>" />
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

<?php

$total = 0; //공급가합
$sales = array();

if ($mode == "date") {
    $search_qry = " AND createdate BETWEEN '$date1' AND '$date2' ";
    $date       = "(" . $date1 . " ~ " . $date2 . ")";

    ?>


            <!-- order list start -->
            <div class="row">
              <div class="col-sm-12">
                <section class="panel">
                  <header class="panel-heading table-head">
                      기간별 정산 리스트 ( <?php echo $date1; ?> ~ <?php echo $date2; ?> )
                    </header>
                    <div class="panel-body">
                      <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th>번호</th>
                            <th>업체명 (ID)</th>
                            <th>상품명</th>
                            <th>거래형태</th>
                            <th>공급가액 (세액)</th>
                            <th>영수/청구</th>
                          </tr>
                        </thead>
                        <tbody>
<?php

    //1. 기간별 주문을 구한다.
    $sql = "SELECT * FROM mall_order
                                WHERE cancel='N' AND status='8' $search_qry
                                ORDER BY num DESC";
    $res = mysqli_query($connect, $sql);

    //2. 각 주문에서 제품코드를 구한다.
    for ($i = 0; $row = mysqli_fetch_array($res); $i++) {
        //판매금액 집계를 위한 배열
        $sales[] = array(num => $row['num'], id => $row['user_id'], sub_total => $row['last_amount']);
        $total += $row['last_amount'];
    } //for end

    foreach ($sales as $key => $values) {
        //$sum[$values['company_name']] += $values['sub_total'];
        $sum[$values['id']] += $values['sub_total'];
    }

    reset($sum);
    arsort($sum);

    $i = 0;
    foreach ($sum as $id => $sub_total) {
        ?>
                          <tr>
                            <td><?php echo $i + 1; ?></td>
                            <td>
<?php

        $c_sql    = "SELECT * FROM member WHERE id='$id' ";
        $c_result = mysqli_query($connect, $c_sql);
        $c_row    = mysqli_fetch_array($c_result);

        echo "<a href=\"mem_stat_list.php?mode=date&id=" . $id . "&amp;date1=" . $date1 . "&amp;date2=" . $date2 . "\" target=\"_blank\">" . $c_row['company_name'] . " (" . $id . ")</a>";
        ?>
                            </td>
                            <td>의료기기</td>
                            <td><?php echo $c_row['seller'] == '2' ? "위탁" : ""; ?></td>
                            <td><?php echo number_format($sub_total); ?> (<?php echo number_format($sub_total * 0.1); ?>)<br><strong><?php echo number_format($sub_total * 1.1); ?></strong></td>
                            <td>
<!--
                              <form name="reg<?php echo $i; ?>" class="form-inline" role="form" method="post" action="reg_tax.php?m=date">
                              <div class="form-group">
                                <label for="reg_date"><i class="fa fa-calendar"></i>발행일 :</label>
                                <input type="text" class="form-control reg_date" name="reg_date" id="reg_date<?php echo $i; ?>"  value="" >
                              </div>
<?php

        if ($c_row['payment_day'] == "1") {
            echo "<input type=\"radio\" name=\"paid\" value=\"Y\" checked />영수\n
                                        <input type=\"radio\" name=\"paid\" value=\"N\" />청구\n";
        } else {
            echo "<input type=\"radio\" name=\"paid\" value=\"Y\" />영수\n
                                        <input type=\"radio\" name=\"paid\" value=\"N\" checked />청구\n";
        }
        ?>
                                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                                <input type="hidden" name="sum" value="<?php echo $sub_total; ?>" />
                                <input type="hidden" name="goods_name" value="의료기기" />
                                <input type="hidden" name="date1" value="<?php echo $date1; ?>" />
                                <input type="hidden" name="date2" value="<?php echo $date2; ?>" />
                                <button class="btn btn-success" href="" onclick="javascript:document.reg<?php echo $i; ?>.submit()">발행</button>
                              </form>
                               -->
<?php

        if ($c_row['payment_day'] == "1") {
            echo "<input type=\"radio\" name=\"paid[<?=$i?>]\" value=\"Y\" checked />영수\n
                                        <input type=\"radio\" name=\"paid[<?=$i?>]\" value=\"N\" />청구\n";
        } else {
            echo "<input type=\"radio\" name=\"paid[<?=$i?>]\" value=\"Y\" />영수\n
                                        <input type=\"radio\" name=\"paid[<?=$i?>]\" value=\"N\" checked />청구\n";
        }
        ?>
<!--                                <input type="radio" name="paid[<?php echo $i; ?>]" value="Y">영수
                               <input type="radio" name="paid[<?php echo $i; ?>]" value="N" checked>청구 -->
                            </td>
                          </tr>
<?php

/*
if($i!=0) {
$temp_createdate .= ",";
$temp_total .= ",";
}
$temp_createdate .= $date;
$temp_total .= $sub_total;
 */
        $i++;
    }

    ?>
                          </tr>
                          <tr>
                            <td colspan="4"><strong>매출액 총합(VAT 포함):</strong></td>
                            <td><?php echo number_format($total); ?> (<?php echo number_format($total * 0.1); ?>)<br><strong><?php echo number_format($total * 1.1); ?></strong></td>
                            <td>&nbsp;</td>
                          </tr>
                        </tbody>
                      </table>
                      </div>
                    </div>
                  </section>
                </div>
              </div>
              <!-- order list end -->

              <div class="row text-center">
                <div class="col-sm-12">
<!--                   <form name="excel_f" method="post" action="hometax_excel.php">
                    <button class="btn btn-success" onclick="excel_f.submit();"><i class="fa fa-file-excel-o"></i> 홈택스 업로드용 엑셀로 저장하기</button>
                  </form> -->

                  <a type="button" class="btn btn-success" href="hometax_excel.php?date1=<?php echo $date1; ?>&date2=<?php echo $date2; ?>"><i class="fa fa-file-excel-o"></i> 홈택스 업로드용 엑셀로 저장하기</a>
                </div>
              </div>

<?php

} else {
    ?>

              <div class="row text-center">
                <div class="col-sm-12">
                  <p>조회 기간을 설정하세요.</p>
                  <p>검색내용이 많을 수록 시간이 오래걸립니다. 기다리세요.</p>
                </div>
              </div>

<?php

}
; // end of else
?>
          </section>
      </section>
      <!--main content end-->

      <!--footer start-->
    <?php include_once '../include/admin_footer.php';?>
      <!--footer end-->

    <script src="/admin/js/jquery-ui.min.js"></script>
    <script src="/admin/js/jq_datepicker.js" ></script>

  </body>
</html>