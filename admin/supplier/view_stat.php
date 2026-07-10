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
<script src="../../js/global.js" type="text/javascript"></script>
<script src="../js/admin.js" type="text/javascript"></script>
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
      <?php

if ($mode == 'search') {
    $search_keyword .= " AND createdate BETWEEN  '$date1' AND '$date2' ";
}

//회원 테이블의 리스트를 불러옵니다.
//$query = "SELECT * FROM member WHERE 1 $search_keyword ";
$query  = "SELECT orderid FROM offer WHERE id='$id' AND status = '4'  $search_keyword ";
$result = mysqli_query($connect, $query);
$total  = mysqli_num_rows($result);

?>
      <form name="stat" method="get" action="view_stat.php">
        <input type="hidden" name="mode" value="search" />
        <input type="hidden" name="id" value="<?=$id;?>" />
        <fieldset>
        <legend>날짜 검색</legend>
        <p>
          <label for="sd">시작일 :</label>
          <input type="text" class="w8em format-y-m-d divider-dash highlight-days-67 range-low-2008-01-01 no-transparency" name="date1" id="sd" value="" size="10" />
          <br />
          <label for="ed">종료일 :</label>
          <input type="text" class="w8em format-y-m-d divider-dash highlight-days-67 range-low-2008-01-01 no-transparency" name="date2" id="ed" value="" size="10" />
        </p>
        <div class="clear"><a class="button" href="javascript:document.stat.submit()" onclick="this.blur();"><span>찾 기</span></a></div>
        </fieldset>
      </form>
      <form name="reg" method="post" action="reg_tax.php">
        <input type="hidden" name="id" value="<?=$id;?>" />
        <table summary="member list">
          <caption>
          공급업체 정산리스트 (
          <?=number_format($total);?>
          건 )<br />
          (입고 완료된 건에 대해서만 출력됩니다.)
          </caption>
          <thead>
            <tr class="odd">
              <th scope="col">번호</th>
              <th scope="col">발주일</th>
              <th scope="col">업체명</th>
              <th scope="col">품목</th>
              <th scope="col">발주액</th>
              <th scope="col">실정산액</th>
              <th scope="col">상세내용</th>
            </tr>
          </thead>
          <tbody>
            <?php
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

$sql_2 = "SELECT * FROM supplier, offer
	          WHERE (supplier.id='$id')
			  AND (offer.id='$id')
			  AND (offer.status = '4' )
			  ORDER BY offer.num DESC LIMIT $cline,$scale1";

$result_2 = mysqli_query($connect, $sql_2);
$total_2  = mysqli_num_rows($result_2);

if ($total_2 == 0) {
    ?>
            <tr>
              <td colspan="7"><p>정산할 내역이 없습니다.</p></td>
            </tr>
            <?php
} else {

    for ($i = 1; $list = mysqli_fetch_array($result_2); $i++) {

        $or_sql = "SELECT * FROM offer WHERE num = '$list[num]' ";
        $or_res = mysqli_query($connect, $or_sql);
        $or_row = mysqli_fetch_array($or_res);

        $a_goods_fk = explode(",", $or_row['goods_fk']);

        $pro_sql    = "SELECT * FROM products WHERE num='$a_goods_fk[0]'";
        $pro_result = mysqli_query($connect, $pro_sql);
        $pro_row    = mysqli_fetch_array($pro_result);

        $goods_name = shortenStr($pro_row['name'], 30);

        $bunho = $total - ($i + $cline) + 1;

        if ($i % 2 == 0) {
            echo "<tr class=odd>\n";
        }

        ?>
          <td><?=$bunho;?></td>
            <td><?=$list['createdate'];?></td>
            <td><?=$list['company_name'];?></td>
            <td class="left"><?=$goods_name;?>
              (외)</td>
            <td><?=number_format($list['amount']);?>
              원</td>
            <td><?=number_format($list['last_amount']);?>
              원</td>
            <td><a href="#" onclick="javascript:open_win('view_offer.php?oid=<?=$list['num'];?>&amp;from=stat&amp;page=<?=$page;?>&amp;id=<?=$id;?>');"> <img src="../images/details.gif" alt="발주내역 보기" /> </a></td>
          </tr>
          <?php
$goods_name = $goods_name . " (외)";
        $tot_amount = $tot_amount + (int) $list['last_amount'];
    }

    mysqli_free_result($result_2);
    ?>
          <tr>
            <td colspan="5">실정산액 합계:</td>
            <td><?=number_format($tot_amount);?>
              원</td>
            <td></td>
          </tr>
          <?php
}
?>
          </tbody>

        </table>
        <fieldset>
        <legend>정산등록</legend>
        <p>
          <label for="reg_date">발행일 :</label>
          <input type="text" class="w8em format-y-m-d divider-dash highlight-days-67 range-low-2008-01-01 no-transparency" name="reg_date" id="reg_date"  value="" size="10" />
          <br />
          <label for="paid">결제여부 :</label>
          <input type="radio" name="paid" value="Y" />
          결제
          <input type="radio" name="paid" value="N" checked />
          미결제
          <input type="hidden" name="sum" value="<?=$tot_amount;?>" />
          <input type="hidden" name="goods_name" value="<?=$goods_name;?>" />
        </p>
        <div class="clear"><a class="button" href="javascript:document.reg.submit()" onclick="this.blur();"><span>등록</span></a></div>
        </fieldset>
      </form>
      <table summary="page nav">
        <tbody>
          <tr>
            <td height="40" align="center" class="text"><?php
$url = "view_stat.php?id=$id&mode=$mode&license_no=$license_no&company_name=$company_name";
page_avg($totalpage, $cpage, $url);
?>
              &nbsp; </td>
          </tr>
          <tr>
            <td><div class="clear"><a class="button" href="stat_list.php" onclick="this.blur();"><span>정산 목록</span></a></div></td>
          </tr>
        </tbody>
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
