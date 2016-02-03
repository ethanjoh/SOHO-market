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

    if ($md_hphone) {
        $search_keyword .= " and md_hphone like '%$md_hphone%' ";
    }

    if ($company_name) {
        $search_keyword .= " and company_name like '%$company_name%' ";
    }
}

$time = date('Y-m-d');

// 오늘 일자의 회원정보 검색
$query  = "SELECT * FROM member WHERE date_format(reg_date,'%Y-%m-%d')='$time' $search_keyword ";
$result = mysqli_query($connect, $query);
$total  = mysqli_num_rows($result);
?>
      <form name="mb" method="post" action="registered_today.php">
        <input type='hidden' name='mode' value='search'>
        <fieldset>
        <legend>회원업체 찾기</legend>
        <label for="id">아이디:</label>
        <input type="text" name="id" value='<?=$id;?>' size="20">
        <br/>
        <label for="company_name">업체명:</label>
        <input type="text" name="company_name" value='<?=$company_name;?>' size="20" >
        <br />
        <p>
          <input type="submit" value="회원 찾기">
        </p>
        </fieldset>
      </form>
      <table summary="member list">
        <caption>
        금일 총 가입업체 (
        <?=number_format($total);?>
        개 )
        </caption>
        <thead>
          <tr class="odd">
            <th scope="col" class="member">번호</th>
            <th scope="col" class="member">아이디</th>
            <th scope="col" class="member">업체명</th>
            <th scope="col" class="member">사업자등록번호</th>
            <th scope="col" class="member">사무실 전화번호</th>
            <th scope="col" class="member">담당자</th>
            <th scope="col" class="member">휴대폰</th>
            <th scope="col" class="member">가입일자</th>
            <th scope="col" class="member">삭제</th>
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

$sql_2    = "select * from member where 1 $search_keyword order by seq_num desc LIMIT $cline,$scale1 ";
$result_2 = mysqli_query($connect, $sql_2);

if ($total) {
    for ($i = 1; $list = mysqli_fetch_array($result_2); $i++) {
        $bunho = $total - ($i + $cline) + 1;
        ?>
          <tr>
            <th scope="row" class="column1"><?=$bunho;?></th>
            <td ><a href="javascript:open_win('admin_view_member.php?num=<?=$list['seq_num'];?>','nwin','scrollbars=yes,resizable=yes, width=650,height=650');">
              <?=$list['id'];?>
              </a></td>
            <td><?=$list['company_name'];?></td>
            <td><?=$list['license_no'];?></td>
            <td><?=$list['o_phone'];?></td>
            <td><?=$list['md_name'];?></td>
            <td><?=$list['md_hphone'];?></td>
            <td><?=$list['reg_date'];?></td>
            <td><div class="clear"><a class="button" href="mem_delete_member.php?m_num=<?=$list['seq_num'];?>&amp;page=<?=$page;?>" onclick="this.blur(); return confirm('삭제를 하시게 되면 이 회원의 모든 정보가 삭제됩니다. \n삭제하시겠습니까?')"><span>delete</span></a></div></td>
          </tr>
          <?php
}
    mysqli_free_result($result_2);

} else {
    ?>
          <tr>
            <td colspan="9">금일 가입 업체가 없습니다.</td>
          </tr>
          <?php
}
?>
        </tbody>
      </table>
      <table summary="page nav">
        <tbody>
          <tr>
            <td height="40" align="center" class="text"><?php
$url = "admin_registered_today.php?$id=$id&mode=$mode&license_no=$license_no&md_email=$md_email&o_phone=$o_phone&company_name=$company_name&md_hphone=$md_hphone";
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
