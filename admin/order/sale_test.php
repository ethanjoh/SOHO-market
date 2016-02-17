<?php
//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
include "../include/graph.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);
?>
<!DOCTYPE html>
<html lang="ko">
  <head>
    <title>B2B SCM</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="../css/jquery-ui.min.css">
    <link rel="stylesheet" href="../css/admin_layout.css" />
    <link rel="stylesheet" href="../chrometheme/chromestyle.css" />
    <!-- <link href="../css/datepicker.css" rel="stylesheet" type="text/css" /> -->
    <!-- popup calendar end -->
    <script src="../js/jquery-1.11.1.min.js"></script>
    <script src="../js/jquery-ui.min.js"></script>
    <script src="../js/highcharts.js"></script>
    <script src="../js/jquery.highchartTable-min.js"></script>
    <script src="../js/jq_datepicker.js"></script>
    <script src="../../js/global.js" ></script>
    <script src="../js/admin.js" ></script>
    <script src="../js/chrome.js" >
    /***********************************************
    * Chrome CSS Drop Down Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
    * This notice MUST stay intact for legal use
    * Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
    ***********************************************/
    </script>
    <!-- popup calendar -->
    <script src="../js/showChart.js"></script>
  </head>
  <body>
    <!-- wrapper -->
    <div id="wrapper">
      <!-- header -->
      <?php
      include "../include/admin_top.php";
      ?>
      <!-- header end -->
      <div id="bodyblock">
        <!-- contents -->
        <div id="content">

          <div id="progressbar1"></div>
          <div>
            <div id="graph2"></div>
          </div>

<?php
            $total = 0; //공급가합
            $sales = array();

            $today = date("Y-m-d");
            $one_year = date("Y-m-01",strtotime ("-1 year"));
            $date = "(".$one_year." ~ ".$today.")";
            ?>

        <table class="highchart" data-graph-container-before="1" data-graph-container="#graph2" data-graph-type="line" data-graph-margin-left="150" data-graph-margin-right="150" data-graph-subtitle-text="<?=$date?>" style="display:none;">
          <caption>연간 판매금액 집계 </caption>
          <thead>
            <tr class="odd">
              <th>판매일</th>
              <th>확정금액 소계(VAT 별도 / 단위 만원)</th>
            </tr>
          </thead>
          <tbody>

              <?php


              //1. 전체 주문을 구한다.
              $sql = "SELECT date_format(createdate, '%Y-%m') AS group_date, sum(last_amount) AS sum_amount FROM mall_order 
                                                  WHERE cancel='N' AND status='8' AND createdate >= '$one_year' 
                                                  GROUP BY date_format(createdate, '%Y-%m')  ";

              $res = mysqli_query($connect, $sql);

              //2. 각 주문에서 제품코드를 구한다.
              for($i=0; $row = mysqli_fetch_array($res); $i++) {

?>
            <tr>
              <td><?=$row['group_date']?></td>
              <td><?=$row['sum_amount']/10000?></td>
            </tr>

<?
              $total += $row['sum_amount'];

              }
?>

        </tbody>
      </table>

      <table id="total">
          <tr class="odd">
            <td class="won" colspan="2"><strong>확정금액 총합:</strong></td>
            <td class="won"><strong><?=number_format($total)?></strong></td>
          </tr>
      </table>

  </div>
<!-- contens end -->
</div>
<!-- bodyblock end -->
<!-- copyright -->
<?php
include "../include/admin_bottom.php";
?>
<!-- copyright  end -->
</div>
<!-- wrapper end -->
</body>
</html>