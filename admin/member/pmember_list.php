<?php

include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

$sel = $_GET['sel'];

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

if ($mode == "search") {
    if ($id) {
        $search_keyword .= " AND id = '$id' ";
    }

    if ($company_name) {
        $search_keyword .= " AND name like '%$name%' ";
    }

} else if ($mode == "nonapproved") {
    $search_keyword .= " AND approved='N' ";
} else if ($mode == "today") {
    $today = date("Y-m-d");
    $search_keyword .= " AND reg_date='$today' ";
}

//회원 테이블의 리스트를 불러옵니다.
$query  = "SELECT * FROM pmember WHERE 1 $search_keyword ";
$result = mysqli_query($connect, $query);
$total  = mysqli_num_rows($result);

?>
      <form name="mb" method="post" action="pmember_list.php">
        <input type="hidden" name="mode" value="search" />
        <fieldset>
        <legend>개인회원 찾기</legend>
        <p>
          <label for="id">아이디:</label>
          <input type="text" name="id" value="<?=$id;?>" size="20">
         </p>
         <p>
          <label for="name">성명:</label>
          <input type="text" name="cname" value="<?=$name;?>" size="20" >
        </p>
        <input type="image" src="../images/search_btn.gif" style="background-color:#FFFFFF; border:none;vertical-align: middle; " />
        </fieldset>
      </form>
      <table summary="functions">
        <tbody>
          <tr>
            <td><div class="full"><a class="button" href="pmember_list.php?mode=nonapproved" onclick="this.blur();"><span>미승인 회원</span></a><a class="button" href="pmember_list.php?mode=today" onclick="this.blur();"><span>금일 가입회원</span></a><a class="button" href="pmember_list.php" onclick="this.blur();"><span>전체 목록</span></a></div></td>
          </tr>
        </tbody>
      </table>
      <table summary="member list">
        <caption>
        총 개인회원 리스트 (
        <?=number_format($total);?>
        개 )
        </caption>
        <thead>
          <tr class="odd">
            <th scope="col" class="member">번호</th>
            <th scope="col" class="member">아이디</th>
            <th scope="col" class="member">성명</th>
            <th scope="col" class="member">할인율</th>
            <th scope="col" class="member">전화</th>
            <th scope="col" class="member">가입일자</th>
            <th scope="col" class="member">승인</th>
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

$sql_2    = "SELECT * FROM pmember WHERE 1 $search_keyword ORDER BY seq_num DESC LIMIT $cline,$scale1 ";
$result_2 = mysqli_query($connect, $sql_2);
$total_2  = mysqli_num_rows($result_2);

if ($total_2) {
    for ($i = 1; $list = mysqli_fetch_array($result_2); $i++) {

        $bunho = $total - ($i + $cline) + 1;

        if ($i % 2 == 0) {
            echo "<tr class=odd>\n";
        } else {
            echo "<tr>\n";
        }

        ?>
            <td><?=$bunho;?></td>
            <td><a href="javascript:open_win('mem_view_pmember.php?num=<?=$list['seq_num'];?>&amp;page=<?=$page;?>','nwin','scrollbars=yes,resizable=yes, width=650,height=450');">
              <?=$list['id'];?>
              </a></td>
            <td><?=$list['name'];?></td>
            <td><?=$list['dc_rate'];?>
              % DC
              <?php
switch ($list['tax']) {
            case "E":
                echo " (VAT 별도)";
                break;
            case "I":
                echo " (VAT 포함)";
                break;
        }
        ?></td>
            <td><?=$list['hphone'];?></td>
            <td><?php

        echo $reg_date = substr($list['reg_date'], 0, 10); ?></td>
            <td><?php

        if ($list['approved'] == "Y") {
            echo "<img src=\"../images/order_state_mini_2.gif\" alt=\"승인\" />";
        } else {
            echo "<img src=\"../images/pause_blue.png\" alt=\"미승인\" />";
        }
        ?></td>
            <td><a href="mem_delete_pmember.php?m_num=<?=$list['seq_num'];?>&amp;page=<?=$page;?>" onclick="this.blur(); return confirm('삭제를 하시게 되면 이 회원의 모든 정보가 삭제됩니다. \n삭제하시겠습니까?')"><img src="../images/delete.gif" alt="삭제" /></a></td>
          </tr>
          <?php
}
    mysqli_free_result($result_2);
} else {
    ?>
          <tr>
            <td colspan="9"><p>등록된 개인회원이 없습니다.</p></td>
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
$url = "pmember_list.php?$id=$id&mode=$mode&email=$md_email&hphone=$hphone&name=$name&phone=$phone";
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
