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
    if ($id) {
        $search_keyword .= " and id = '$id' ";
    }

    if ($company_name) {
        $search_keyword .= " and company_name like '%$company_name%' ";
    }

}

//회원 테이블의 리스트를 불러옵니다.
$query  = "SELECT * FROM supplier WHERE 1 $search_keyword ";
$result = mysqli_query($connect, $query);
if ($result) {
    $total = mysqli_num_rows($result);
}

?>
      <form name="mb" method="post" action="../stats/top_stat_list.php">
        <input type="hidden" name="mode" value="search" />
        <fieldset>
        <legend>공급업체 찾기</legend>
        <p>
          <label for="id">아이디:</label>
          <input type="text" name="id" value='<?=$id;?>' size="20">
        </p>
        <p>
          <label for="company_name">업체명:</label>
          <input type="text" name="company_name" value='<?=$company_name;?>' size="20" >
        </p>
        <input type="image" src="../images/search_btn.gif" style="background-color:#FFFFFF; border:none;vertical-align: middle; " />
        </fieldset>
      </form>
      <table summary="member list">
        <caption>
        정산업체 목록 (
        <?=number_format($total);?>
        개 )
        </caption>
        <thead>
          <tr class="odd">
            <th scope="col">번호</th>
            <th scope="col">아이디</th>
            <th scope="col">업체명</th>
            <th scope="col">사업자등록번호</th>
            <th scope="col">사무실 전화번호</th>
            <th scope="col">담당자</th>
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

$sql_2 = "SELECT * FROM supplier
					WHERE 1 $search_keyword
					ORDER BY seq_num DESC LIMIT $cline,$scale1 ";

$result_2 = mysqli_query($connect, $sql_2);
if ($result_2) {
    for ($i = 1; $list = mysqli_fetch_array($result_2); $i++) {

        $bunho = $total - ($i + $cline) + 1;

        if ($i % 2 == 0) {
            echo "<tr class=odd>\n";
        }

        ?>
        <td><?=$bunho;?></td>
          <td><a href="view_stat.php?id=<?=$list['id'];?>">
            <?=$list['id'];?>
            </a></td>
          <td><?=$list['company_name'];?></td>
          <td><?=$list['license_no'];?></td>
          <td><?=$list['o_phone'];?></td>
          <td><?=$list['md_name'];?></td>
        </tr>
        <?php
}
    mysqli_free_result($result_2);
}
?>
        </tbody>
      </table>
      <table summary="page nav">
        <tbody>
          <tr>
            <td height="40" align="center" class="text"><?php
$url = "stat_list.php?$id=$id&amp;mode=$mode&amp;license_no=$license_no&amp;company_name=$company_name";
page_avg($totalpage, $cpage, $url);
?>
              &nbsp; </td>
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
