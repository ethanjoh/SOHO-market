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
$query  = "SELECT * FROM supplier WHERE md_email <> '' $search_keyword ";
$result = mysqli_query($connect, $query);
if ($result) {
    $total = mysqli_num_rows($result);
}

?>
      <form name="form1" method="post" action="sendmail_list.php">
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
        <table summary="member list">
          <caption>
          전체 공급업체 메일보내기 (총 업체 수:
          <?=number_format($total);?>
          건 )
          </caption>
          <thead>
            <tr class="odd">
              <th width="9%" scope="col">번호</strong></th>
              <th width="13%" scope="col">아이디</strong></th>
              <th width="12%" scope="col">업체명</strong></th>
              <th width="15%" scope="col">담당자명</th>
              <th width="21%" scope="col">담당자 이메일</th>
              <th width="18%" scope="col">가입날짜</th>
              <th width="12%" scope="col"><a href="javascript:checkAll()">선택</a></th>
            </tr>
          </thead>
          <tbody>
            <?php
if (!$page_scale) {
    $scale = 30;
} else if ($page_scale == "all") {
    if ($total == 0) {
        $scale = 1;
    } else {
        $scale = $total;
    }
    $checked = "checked";
}

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

//이메일이 등록되어 있지 않으면 출력안됨
$sql_2    = "SELECT * FROM supplier WHERE md_email <> '' $sear_char ORDER BY seq_num DESC LIMIT $cline,$scale1 ";
$result_2 = mysqli_query($connect, $sql_2);
if ($result_2) {
    for ($i = 1; $list = mysqli_fetch_array($result_2); $i++) {

        $bunho = $total - ($i + $cline) + 1;

        if ($i % 2 == 0) {
            echo "<tr class=odd>\n";
        }

        ?>
          <td><?=$bunho;?></td>
            <td><a href="javascript:open_win('view_supplier.php?num=<?=$list['seq_num'];?>','nwin','scrollbars=yes,resizable=yes, width=650,height=650');">
              <?=$list['id'];?>
              </a></td>
            <td><?=$list['company_name'];?></td>
            <td><?=$list['md_name'];?></td>
            <td><?=$list['md_email'];?></td>
            <td><?=$list['reg_date'];?></td>
            <td><input type="checkbox" name="num[]" value="<?=$list['seq_num'];?>"></td>
          </tr>
          <?php
}
    mysqli_free_result($result_2);
}
?>
          </tbody>

        </table>
        <table summary="send mail">
          <tbody>
            <tr>
              <td width="20%"><div class="full"><a class="button" href="#" onclick="this.blur();javascript:mail_send2();"><span>메일 보내기</span></a></div></td>
              <td width="45%"><?php
$url = "sendmail_list.php?$id=$id=$id&mode=$mode&license_no=$license_no&md_email=$md_email&o_phone=$o_phone&company_name=$company_name&page_scale=$page_scale";

page_avg($totalpage, $cpage, $url);
?>
                &nbsp; </td>
              <td width="22%"><input type="checkbox" name="page_scale" value="all" <?=$checked;?> onClick="document.form1.submit()">
                한 화면으로 보기 </td>
            </tr>
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
