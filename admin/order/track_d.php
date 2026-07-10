<?php

include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<title>B2B SCM</title>
<meta charset="UTF-8" />
<link rel="stylesheet" href="../css/admin_layout.css" />
<script src="../../js/global.js" ></script>
<script src="../js/admin.js" ></script>
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
      <form action="track_d.php" name="f" method="post" >
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
			   AND recipient_name <> ''
			   AND track_no is null
			   AND $key LIKE '%$key_value%' ";
        break;
    case 'date':
        $sql_2 = "SELECT orderid FROM mall_order
		          WHERE cancel = 'N'
				  AND delivery_type = 'L'
				  AND status = '7'
				  AND trans_cost <> '-1'
				  AND recipient_name <> ''
				  AND track_no is null
				  AND createdate BETWEEN '$date1' AND '$date2' ";
        break;
    default:
        $sql_2 = "SELECT orderid FROM mall_order
	   				  WHERE delivery_type = 'L'
					  AND cancel = 'N'
					  AND status = '7'
					  AND recipient_name <> ''
					  AND track_no is null
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
      <form method="get" action="track_d.php">
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
            <td><img src="../images/excel_icon.gif" width="16" height="16" alt="excel" /><a href="tracktoexcel_d.php?date1=<?=$date1;?>&amp;date2=<?=$date2;?>">엑셀로 다운로드</a></td>
          </tr>
        </tbody>
      </table>
      <table summary="view the total order list">
        <caption>
        주문 목록 (
        <?=$date1;?>
        ~
        <?=$date2;?>
        기간 내 총
        <?=$total;?>
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
            <th class="member" scope="col">휴대폰번호</th>
            <th class="member" scope="col">전화번호</th>
            <th class="member" scope="col">운임구분<br />(선불: 3)</th>
            <th class="member" scope="col">운임</th>
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
			 AND recipient_name <> ''
			 AND track_no is null
			 ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'date':
        $sql_4 = "SELECT * FROM mall_order
		          WHERE cancel = 'N'
				  AND recipient_name <> ''
				  AND track_no is null
				  AND createdate BETWEEN '$date1' AND '$date2'
				  ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    default:
        $sql_4 = "SELECT * FROM mall_order
   		     		WHERE status = '7'
					AND cancel = 'N'
					AND delivery_type = 'L'
					AND trans_cost <> '-1'
					AND recipient_name <> ''
					AND track_no is null
             		ORDER BY num DESC LIMIT $cline,$scale1 ";
}

$res_4 = mysqli_query($connect, $sql_4);
$t_no  = mysqli_num_rows($res_4);

if ($t_no > 0) {

    $total = 0; //금일주문총액

    for ($i = 0; $row = mysqli_fetch_array($res_4); $i++) {
        ?>
          <tr>
            <td><?=$row['orderid'];?></td>
            <td><?=$row['createdate'];?></td>
            <td><?=$row['recipient_name'] ? $row['recipient_name'] : $row['buyer_name'];?></td>
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

        if ($row['ship_cost'] > 0) //도선료 추가
        {
            $t_cost += $row['ship_cost'];
        }

        ?>
            <td class="left"><?=$goods_name;?></td>
            <td>1</td>
            <td><?=$row['recipient_name'] ? $row['recipient_zipno'] : $row['buyer_zipno'];?></td>
            <td class="left"><?=$row['recipient_name'] ? $row['recipient_address'] : $row['buyer_address'];?></td>
            <td><?=$row['recipient_name'] ? $row['recipient_hphone'] : $row['buyer_hphone'];?></td>
            <td><?=$row['recipient_name'] ? $row['recipient_phone'] : $row['buyer_phone'];?></td>
            <td><?=$str;?></td>
            <td><?=$t_cost;?></td>
            <td><?php

        if ($row['memo']) {
            echo $row['memo'];
        }

        ?></td>
            <!--
            <td><?=$row['recipient_name'] ? $row['buyer_name'] : "";?></td>
            <td><?=$row['recipient_name'] ? $row['buyer_phone'] : "";?></td>
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
