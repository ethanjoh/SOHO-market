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
<script type="text/javascript">
<!--
function m_check(frm) {
	ret = confirm('적립금을 수정하시겠습니까?');
	if(ret == true) {
		frm.submit();
	}
}
-->
</script>
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
    if ($id_fk) {
        $keyword = " WHERE id_fk LIKE '%$id_fk%' ";
    }
}

$query  = "SELECT * FROM mileage $keyword";
$result = mysqli_query($connect, $query);
$total  = mysqli_num_rows($result);
?>
      <table summary="mileage list">
        <caption>
        업체별 적립금 관리 (총
        <?=number_format($total);?>
        건)
        </caption>
        <thead>
          <tr class="odd">
            <th width="11%" class="member" scope="col">번호</th>
            <th width="13%" class="member" scope="col">아이디</th>
            <th width="18%" class="member" scope="col">적립금</th>
            <th colspan="2" class="member" scope="col">적립금 수정</th>
            <th width="18%" class="member" scope="col">적립금 내역</th>
            <th width="15%" class="member" scope="col">적립일</th>
          </tr>
        </thead>
        <?php
$scale = 100;
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

$sql_2    = "SELECT * FROM mileage $keyword ORDER BY num DESC LIMIT $cline,$scale1 ";
$result_2 = mysqli_query($connect, $sql_2);

for ($i = 1; $row = mysqli_fetch_array($result_2); $i++) {
    $bunho = $total - ($i + $cline) + 1;
    ?>
        <tbody>
          <tr>
            <td><?=$bunho;?></td>
            <td><?=$row['id_fk'];?></td>
            <td><?=$row['mileage'];?></td>
            <form name="mileage<?=$i;?>" method="get" action="mem_update_mileage.php">
              <input type="hidden" name="id_fk" value="<?=$row['id_fk'];?>" />
              <td width="13%"><input class="num" type="text" name="mod_mileage" size="5" value="" /></td>
              <td width="12%"><div class="full"><a class="button" href="#" onclick="this.blur();m_check(document.mileage<?=$i;?>);"><span>수정</span></a></div></td>
            </form>
            <td><?=$row['mile_desc'];?></td>
            <td><?=$row['wdate'];?></td>
          </tr>
          <?php

}
mysqli_free_result($result);
?>
          <?php

if ($total == 0) {
    ?>
          <tr>
            <td colspan="6">등록된 적립금 목록이 없습니다.</td>
          </tr>
          <?php

}
?>
        </tbody>
      </table>
      </form>
      <form action='mem_mileage_list.php' name='f' method='post'>
      <input type='hidden' name='mode' value='search' />
        <table summary="search">
          <tbody>
            <tr>
              <td colspan="10">
                아이디
                <input type='text' name='id_fk' size='16'>
                <input type="image" src="../images/search_btn.gif" style="background-color:#FFFFFF; border:none;vertical-align: middle; " /></td>
            </tr>
          </tbody>
        </table>
      </form>
    </div>
    <!-- contents end -->
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
