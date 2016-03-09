<?php

include_once "../include/admin_auth.php";
include_once "../../util/util.php";

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>
<title>B2B SCM</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="../css/admin_layout.css" />
<link rel="stylesheet" type="text/css" href="../chrometheme/chromestyle.css" />
<script language="JavaScript" src="../../js/global.js" ></script>
<script language="JavaScript" src="../js/admin.js" ></script>
<script language="JavaScript" src="../js/chrome.js" >
/***********************************************
* Chrome CSS Drop Down Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/
</script>
<!-- popup calendar -->
<script type="text/javascript" src="../js/datepicker.js"></script>
<link href="../css/datepicker.css" rel="stylesheet" type="text/css" />
<!-- popup calendar end -->
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
      <form action="track.php" name="f" method="post" >
      <?php
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
			   AND recipient_name = ''
			   AND $key LIKE '%$key_value%' ";
        break;
    case 'date':
        $sql_2 = "SELECT orderid FROM mall_order
		          WHERE cancel = 'N'
				  AND delivery_type = 'L'
				  AND status = '7'
				  AND trans_cost <> '-1'
				  AND recipient_name = ''
				  AND createdate BETWEEN '$date1' AND '$date2' ";
        break;
    default:
        $sql_2 = "SELECT orderid FROM mall_order
	   				  WHERE delivery_type = 'L'
					  AND cancel = 'N'
					  AND status = '7'
					  AND recipient_name = ''
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
      <form method="get" action="track.php">
        <input type="hidden" name="mode" value="date" />
        <fieldset>
          <legend>날짜 검색</legend>
          <p>
            <label for="sd">시작일 :</label>
            <input type="text" class="w8em format-y-m-d divider-dash highlight-days-67 range-low-2006-01-01 no-transparency" name="date1" id="sd" value="" size="10" />
          </p>
          <p>
            <label for="ed">종료일 :</label>
            <input type="text" class="w8em format-y-m-d divider-dash highlight-days-67 range-low-2006-01-01 no-transparency" name="date2" id="ed" value="" size="10" />
          </p>
          <input type="image" src="../images/search_btn.gif" style="background-color:#FFFFFF; border:none;vertical-align: middle; " />
        </fieldset>
      </form>
      <table summary="functions">
        <tbody>
          <tr>
            <td><img src="../images/excel_icon.gif" width="16" height="16" alt="excel" /><a href="tracktoexcel.php?date1=<?php echo $date1;?>&amp;date2=<?php echo $date2;?>">엑셀로 다운로드</a></td>
          </tr>
        </tbody>
      </table>
      <table summary="view the total order list">
        <caption>
        주문 목록 (
        <?php echo $date1;?>
        ~
        <?php echo $date2;?>
        기간 내 총
        <?php echo $total;?>
        건)
        </caption>
        <thead>
          <tr class="odd">
            <th class="member" scope="col">주문번호</th>
            <th class="member" scope="col">주문일</th>
            <th class="member" scope="col">받는사람</th>
            <th class="member" scope="col">상품명</th>
            <th class="member" scope="col">수량(소)1</th>
            <th class="member" scope="col">우편번호</th>
            <th class="member" scope="col">주소</th>
            <th class="member" scope="col">전화번호</th>
            <th class="member" scope="col">휴대폰번호</th>
            <th class="member" scope="col">운임구분</th>
            <th class="member" scope="col">운임<br />(선불: 3)</th>
            <th class="member" scope="col">특기사항</th>
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
			 AND recipient_name = ''
			 ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'date':
        $sql_4 = "SELECT * FROM mall_order
		          WHERE cancel = 'N'
				  AND recipient_name = ''
				  AND createdate BETWEEN '$date1' AND '$date2'
				  ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    default:
        $sql_4 = "SELECT * FROM mall_order
   		     		WHERE status = '7'
					AND cancel = 'N'
					AND delivery_type = 'L'
					AND trans_cost <> '-1'
					AND recipient_name = ''
             		ORDER BY num DESC LIMIT $cline,$scale1 ";
}

$res_4 = mysqli_query($connect, $sql_4);
$t_no  = mysqli_num_rows($res_4);

if ($t_no > 0) {

    $total = 0; //금일주문총액

    for ($i = 0; $row = mysqli_fetch_array($res_4); $i++) {
        ?>
          <tr>
            <td><?php echo $row['orderid'];?></td>
            <td><?php echo $row['createdate'];?></td>
            <td><?php echo $row['recipient_name'] ? $row['recipient_name'] : $row['buyer_name'];?></td>
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

        //배송정책 가져옴
        $query4  = "SELECT * FROM misc_setup WHERE id='admin' ";
        $result4 = mysqli_query($connect, $query4);
        $misc    = mysqli_fetch_array($result4);

//if($row['last_amount'] >=$misc['min_sum'] || $row['trans_cost'] == '0')
        if ($row['trans_cost'] == '0') {
            $str    = "3"; //신용
            $t_cost = "2200";
        } else {
            $str    = "2"; //착불
            $t_cost = "2500";
        }
        ?>
            <td><?php echo $goods_name;?></td>
            <td>1</td>
            <td><?php echo $row['recipient_name'] ? $row['recipient_zipno'] : $row['buyer_zipno'];?></td>
            <td><?php echo $row['recipient_name'] ? $row['recipient_address'] : $row['buyer_address'];?></td>
            <td><?php echo $row['recipient_name'] ? $row['recipient_phone'] : $row['buyer_phone'];?></td>
            <td><?php echo $row['recipient_name'] ? $row['recipient_hphone'] : $row['buyer_hphone'];?></td>
            <td><?php echo $str;?></td>
            <td><?php echo $t_cost;?></td>
            <td><?php
if ($row['memo']) {
            echo $row['memo'];
        }

        ?></td>
            <!--
            <td><?php echo $row['recipient_name'] ? $row['buyer_name'] : "";?></td>
            <td><?php echo $row['recipient_name'] ? $row['buyer_phone'] : "";?></td>
            -->
          </tr>
          <?php
}
    ; // for loop end
    ?>
          <?php
} else {
    ?>
          <tr>
            <td colspan="12"><p>해당 주문내역이 없습니다.</p></td>
          </tr>
          <?php
}
?>
        </tbody>
      </table>
      </form>
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
