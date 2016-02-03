<?php

include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);
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
      <form action="or_quot_list.php" name="f" method="post" >
      <?php

switch ($mode) {
    case 'search':
        $sql_2 = "SELECT orderid FROM mall_order
			   WHERE cancel = 'N' AND user_id = 'guest'
			   AND $key LIKE '%$key_value%' ";
        break;
    case 'date':
        $sql_2 = "SELECT orderid FROM mall_order
		          WHERE cancel = 'N' AND user_id = 'guest'
				  AND createdate BETWEEN '$date1' AND '$date2' ";
        break;
    case 'today':
        $today = date("Y-m-d");
        $sql_2 = "SELECT orderid FROM mall_order
		          WHERE cancel = 'N' AND user_id = 'guest'
				  AND createdate = '$today' ";
        break;
    case 'unchk':
        $sql_2 = "SELECT orderid FROM mall_order
		          WHERE cancel = 'N' AND user_id = 'guest'
				  AND status = '3' ";
        break;
    case 'cancel':
        $sql_2 = "SELECT orderid FROM mall_order
		          WHERE cancel = 'Y'
				 AND user_id = 'guest' ";
    default:
        $sql_2 = "SELECT orderid FROM mall_order WHERE cancel='N' AND user_id='guest' ";
}

$res_2 = mysqli_query($connect, $sql_2);
$total = mysqli_num_rows($res_2);

$scale = 30;
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
      <form method="get" action="or_quot_list.php">
        <input type="hidden" name="mode" value="date" />
        <fieldset>
        <legend>날짜 검색</legend>
        <p>
          <label for="sd">시작일 :</label>
          <input type="text" class="w8em format-y-m-d divider-dash highlight-days-67 range-low-2008-01-01 no-transparency" name="date1" id="sd" value="" size="10" />
        </p>
        <p>
          <label for="ed">종료일 :</label>
          <input type="text" class="w8em format-y-m-d divider-dash highlight-days-67 range-low-2008-01-01 no-transparency" name="date2" id="ed" value="" size="10" />
        </p>
        <input type="image" src="../images/search_btn.gif" style="background-color:#FFFFFF; border:none; vertical-align: middle;" />
        </fieldset>
      </form>
      <table summary="functions">
        <tbody>
          <tr>
            <td><div class="full"><a class="button" href="or_quot_list.php?mode=today" onclick="this.blur();"><span>금일 주문</span></a><a class="button" href="or_quot_list.php?mode=unchk" onclick="this.blur();"><span>미확인 주문</span></a><a class="button" href="or_quot_list.php?mode=cancel" onclick="this.blur();"><span>주문취소건</span></a><a class="button" href="or_quot_list.php?mode=all" onclick="this.blur();"><span>전체 주문목록</span></a></div></td>
          </tr>
        </tbody>
      </table>
      <table summary="view the total quotation list">
        <caption>
        비회원 주문목록
        </caption>
        <thead>
          <tr class="odd">
            <th class="member" scope="col">주문번호</th>
            <th class="member" scope="col">주문일</th>
            <th class="member" scope="col">주문자</th>
            <th class="member" scope="col">주문액</th>
            <th class="member" scope="col">확정액</th>
            <th class="member" scope="col">처리</th>
            <th class="member" scope="col">취소</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <td colspan="8" align="center"><?php
$url = "$PHP_SELF?mode=$mode&key=$key&key_value=$key_value";
page_avg($totalpage, $cpage, $url);
?></td>
          </tr>
          <tr>
            <td  colspan="10" align='center' ><select name='key'>
                <option value='user_id'>아이디</option>
                <option value='buyer_name'>성명</option>
              </select>
              <input type='hidden' name='mode' value='search'>
              <input type='text' name='key_value' size='16'>
              <input type="image" src="../images/search_btn.gif" style="background-color:#FFFFFF; border:none; vertical-align: middle;" /></td>
          </tr>
        </tfoot>
        <tbody>
          <?php
switch ($mode) {
    case 'search':
        $sql_4 = "SELECT * FROM mall_order
             WHERE user_id = 'guest'
			 AND $key LIKE '%$key_value%'
			 ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'date':
        $sql_4 = "SELECT * FROM mall_order
		          WHERE user_id = 'guest'
				  AND createdate BETWEEN '$date1' AND '$date2'
				  ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'today':
        $today = date("Y-m-d");
        $sql_4 = "SELECT * FROM mall_order
		          WHERE user_id = 'guest'
				  AND createdate = '$today' ";
        break;
    case 'unchk':
        $sql_4 = "SELECT * FROM mall_order
		          WHERE user_id = 'guest'
				  AND status = '3'
				  ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    case 'cancel':
        $sql_4 = "SELECT * FROM mall_order
		          WHERE cancel = 'Y'
				 AND user_id = 'guest'
				  ORDER BY num DESC LIMIT $cline,$scale1 ";
        break;
    default:
        $sql_4 = "SELECT * FROM mall_order
   		     WHERE user_id = 'guest'
             ORDER BY num DESC LIMIT $cline,$scale1 ";
}

$a_pay_type['1'] = "무통장 입금";
$a_pay_type['2'] = "신용카드";
$a_pay_type['3'] = "휴대폰 결제";

$res_4 = mysqli_query($connect, $sql_4);
$t_no  = mysqli_num_rows($res_4);

if ($t_no > 0) {

    $total = 0; //금일주문총액

    for ($i = 0; $row = mysqli_fetch_array($res_4); $i++) {
        if ($row['cancel'] == 'Y') {
            $c_color    = "#EBEBEB";
            $status_now = "주문취소";
            ?>
          <tr bgcolor="<?=$c_color;?>">
            <td><a href="or_quot_view.php?oid=<?=$row['num'];?>&amp;page=<?=$page;?>">
              <?=$row['orderid'];?>
              </a></td>
            <td><?=$row['createdate'];?></td>
            <td><?=$row['buyer_name'];?></td>
            <td><?=number_format($row['amount']);?>
              원</td>
            <td>-</td>
            <td><?=$status_now;?></td>
            <td><a href="javascript:alert('이미 취소된 주문입니다.')"><img src="../images/forbbiden.gif"  alt="취소불가" /></a></td>
          </tr>
          <?php
} else {

            if ($row['status'] == '1') {
                $c_color    = '#FFC8C8';
                $status_now = "미처리";
            } else if ($row['status'] == '3') {
                $c_color    = '#FFC8C8';
                $status_now = "미처리";
            } else if ($row['status'] == '5') {
                $c_color    = '#E0FFE0';
                $status_now = "주문확인";
            } else if ($row['status'] == '7') {
                $c_color    = '#EFFCFC';
                $status_now = "포장완료";
            } else if ($row['status'] == '8') {
                $c_color    = '#FFFFFF';
                $status_now = "발송완료";
            }

            ?>
          <tr bgcolor="<?=$c_color;?>">
            <td><a href='or_quot_view.php?oid=<?=$row['num'];?>&amp;page=<?=$page;?>'>
              <?=$row['orderid'];?>
              </a></td>
            <td><?=$row['createdate'];?></td>
            <td><?=$row['buyer_name'];?></td>
            <td><?=number_format($row['amount']);?>
              원</td>
            <td><?php echo ($row['last_amount'] == 0) ? " 미확정" : number_format($row['last_amount']) . " 원"; ?></td>
            <td><?=$status_now;?></td>
            <td><a href="or_delete.php?oid=<?=$row['num'];?>&amp;page=<?=$page;?>&amp;from=quot" onclick="return confirm('주문을 취소하시겠습니까?')"><img src="../images/delete.gif" border="0" /></a></td>
          </tr>
          <?php

            $total += $row['amount'];
        }
    }
    ?>
          <tr class="odd">
            <td colspan="10">주문 총합:
              <?=number_format($total);?>
              원</td>
          </tr>
          <?php
} else {
    ?>
          <tr>
            <td colspan="10"><p>해당 주문 내역이 없습니다.</p></td>
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
