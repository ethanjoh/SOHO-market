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
<link rel="stylesheet" href="../css/jquery-ui.min.css">
<link rel="stylesheet" href="../css/admin_layout.css" />
<link rel="stylesheet" type="text/css" href="../chrometheme/chromestyle.css" />
<script src="../js/jquery-1.11.1.min.js"></script>
<script src="../js/jquery-ui.min.js"></script>
<script language="JavaScript" src="../../js/global.js" type="text/javascript"></script>
<script language="JavaScript" src="../js/admin.js" type="text/javascript"></script>
<script language="JavaScript" src="../js/chrome.js" type="text/javascript">
/***********************************************
* Chrome CSS Drop Down Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/
</script>
<!-- popup calendar -->
<script type="text/javascript" src="../js/jq_datepicker.js"></script>
<!-- <link href="../css/datepicker.css" rel="stylesheet" type="text/css" /> -->
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
      <fieldset class="info">
        <legend><img src="../images/info.png" alt="안내" /> 사용방법</legend>
        <ul>
          <li style="text-align:left">업체가 확인 후 승인을 해야 출력이 가능합니다.</li>
          <li style="text-align:left">오랫동안 미승인일 경우 해당업체로 연락바랍니다.</li>
          <li style="text-align:left">정산금액 오류 등으로 업체가 반려할 경우 [반려] 표시가 뜹니다.</li>
        </ul>
      </fieldset>
      <form name="stat" method="get" action="monthly_stat_list.php">
        <input type="hidden" name="mode" value="search" />
        <input type="hidden" name="key" value="company_name" />
        <!-- <input type="hidden" name="key_value" value="<?=$key_value;?>" />           -->
        <fieldset>
          <legend>날짜 검색</legend>
          <p>
            <label for="sd">시작일 :</label>
            <input type="text" name="date1" id="sd" value="" />
          </p>
          <p>
            <label for="ed">종료일 :</label>
            <input type="text" name="date2" id="ed" value="" />
          </p>
          <p>
            <label for="company_name">업체명:</label>
            <input type="text" name="key_value" value='<?=$company_name;?>' size="20" >
          </p>
          <input type="image" src="../images/search_btn.gif" style="background-color:#FFFFFF; border:none;vertical-align: middle; " />
        </fieldset>
      </form>
      <form action="monthly_stat_list.php" name="f" method="get" >
        <table summary="functions">
          <tbody>
            <tr>
              <td><div class="full"><a class="button" href="monthly_stat_list.php" onclick="this.blur();"><span>전체</span></a><a class="button" href="monthly_stat_list.php?mode=chk" onclick="this.blur();"><span>승인건</span></a><a class="button" href="monthly_stat_list.php?mode=unchk" onclick="this.blur();"><span>미승인건</span></a><a class="button" href="monthly_stat_list.php?mode=cancel" onclick="this.blur();"><span>취소건</span></a></div></td>
            </tr>
          </tbody>
        </table>
        <table summary="member list">
          <caption>
          세금계산서 발행리스트
          </caption>
          <thead>
            <tr class="odd">
              <th scope="col" class="member">번호</th>
              <th scope="col" class="member">제목</th>
              <th scope="col" class="member">발행일자</th>
              <th scope="col" class="member">공급받는자</th>
              <th scope="col" class="member">품목</th>
              <th scope="col" class="member">발행금액<br />(NET)</th>
              <th scope="col" class="member">승인</th>
              <th scope="col" class="member">출력</th>
              <th scope="col" class="member">취소/삭제</th>
            </tr>
          </thead>
          <tbody>
            <?php
switch ($mode) {
    case 'search':
        if ($key_value != '') {
            $sql_1    = "SELECT * FROM member WHERE $key LIKE '%$key_value%' ";
            $result_1 = mysqli_query($connect, $sql_1);
            $list     = mysqli_fetch_array($result_1);

            $sql_2 = "SELECT * FROM member m, tax_list t WHERE t.id = '$list[id]' AND m.id = '$list[id]' ORDER BY t.num DESC ";
        } else {
            $sql_2 = "SELECT * FROM member m, tax_list t WHERE m.id=t.id AND t.reg_date BETWEEN '$date1' AND '$date2' ORDER BY t.num DESC ";
        }
        break;
    case 'chk':
        $sql_2 = "SELECT * FROM member m, tax_list t WHERE m.id=t.id AND t.approved='Y' ORDER BY t.num DESC ";
        break;
    case 'unchk':
        $sql_2 = "SELECT * FROM member m, tax_list t WHERE m.id=t.id AND t.approved='N' ORDER BY t.num DESC ";
        break;
    case 'cancel':
        $sql_2 = "SELECT * FROM member m, tax_list t WHERE m.id=t.id AND t.cancel = 'Y' ORDER BY t.num DESC ";
        break;
    default:
        $sql_2 = "SELECT * FROM member m, tax_list t WHERE m.id=t.id ORDER BY t.num DESC ";
}

$res_2 = mysqli_query($connect, $sql_2);
$total = mysqli_num_rows($res_2);

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

//쿼리 결과가 없을 경우
if ($total == 0) {
    ?>
            <tr>
              <td colspan="8"><p>발행 목록이 없습니다.</p></td>
            </tr>
            <?php
} else {

    switch ($mode) {
        case 'search':
            if ($key_value != '') {
                $sql_1    = "SELECT * FROM member WHERE $key LIKE '%$key_value%' ";
                $result_1 = mysqli_query($connect, $sql_1);
                $list     = mysqli_fetch_array($result_1);
                $list_num = mysqli_num_rows($result_1);

                //결과 갯수를 카운팅해서 for 문으로 돌린다. (유사업체명 출력)

                $sql_2 = "SELECT * FROM member m, tax_list t WHERE t.id = '$list[id]' AND m.id = '$list[id]' ORDER BY t.num DESC ";

            } else {
                $sql_2 = "SELECT * FROM member m, tax_list t WHERE m.id=t.id AND t.reg_date BETWEEN '$date1' AND '$date2' ORDER BY t.num DESC ";
            }
            break;
        case 'chk':
            $sql_2 = "SELECT * FROM member m, tax_list t WHERE m.id=t.id AND t.approved='Y' ORDER BY t.num DESC ";
            break;
        case 'unchk':
            $sql_2 = "SELECT * FROM member m, tax_list t WHERE m.id=t.id AND t.approved='N' ORDER BY t.num DESC ";

            break;
        case 'cancel':
            $sql_2 = "SELECT * FROM member m, tax_list t WHERE m.id=t.id AND t.cancel = 'Y' ORDER BY t.num DESC ";
            break;
        default:
            $sql_2 = "SELECT * FROM member m, tax_list t WHERE m.id = t.id ORDER BY t.num DESC LIMIT $cline,$scale1";
    }

    $result_2 = mysqli_query($connect, $sql_2);

    for ($i = 1; $list = mysqli_fetch_array($result_2); $i++) {

        $bunho = $total - ($i + $cline) + 1;

        if ($i % 2 == 0) {
            echo "<tr class=\"odd\">\n";
        }

        ?>
          <td><?=$bunho;?></td>
            <td><?=$list['title'];?></td>
            <td><?=$list['reg_date'];?></td>
            <td class="left"><?=$list['company_name'];?></td>
            <td class="left"><?=$list['goods_name'];?></td>
            <?php
if ($list['approved'] == "Y" && $list['cancel'] == "N") {
            echo "<td class=\"won\">" . number_format($list['sum']) . "</td>\n";
            echo "<td><img src=\"../images/9.png\" />승인</td>\n";
            echo "<td><a href=\"javascript:open_win('print_tax.php?num=" . $list['num'] . "&id=" . $list['id'] . "','nwin','scrollbars=yes,resizable=yes');\"><img src=\"../images/printer_go.png\" /></a>
              </td>\n";
        } else if ($list['approved'] == "N" && $list['cancel'] == "N") {
            echo "<td class=\"won\">" . number_format($list['sum']) . "</td>\n";
            echo "<td><img src=\"../images/pause_blue.png\" />미승인</td>\n";
            echo "<td><a href=\"javascript:open_win('print_tax.php?num=" . $list['num'] . "&id=" . $list['id'] . "','nwin','scrollbars=yes,resizable=yes');\"><img src=\"../images/printer_go.png\" /></a>
              </td>\n";
        } else if ($list['approved'] == "N" && $list['cancel'] == "Y") {
            echo "<td class=\"won\">-</td>\n";
            echo "<td><img src=\"../images/rewind_blue.png\" /><font color=\"#990000\"><strong>반려/취소</strong></font></td>\n";
            echo "<td>&nbsp;</td>\n";
            $tot_amount = $tot_amount - (int) $list['sum'];
        } else if ($list['approved'] == "Y" && $list['cancel'] == "Y") {
            echo "<td class=\"won\">-</td>\n";
            echo "<td><img src=\"../images/rewind_blue.png\" /><font color=\"#990000\"><strong>반려/취소</strong></font></td>\n";
            echo "<td>&nbsp;</td>\n";
            $tot_amount = $tot_amount - (int) $list['sum'];
        }

        if ($list['cancel'] == "Y") {
            ?>
            <td><a href="delete_tax.php?mode=del&num=<?=$list['num'];?>"><img src="../images/delete.gif" /></a></td>
      <?php
} else {
            ?>
            <td><a href="delete_tax.php?mode=cancel&num=<?=$list['num'];?>"><img src="../images/delete.gif" /></a></td>
      <?php

        }
        ?>
          </tr>
          <?php

        $tot_amount = $tot_amount + (int) $list['sum'];
    }
    mysqli_free_result($result_2);
    ?>
          <tr>
            <td colspan="5"><strong>발행금액 합계:</strong></td>
            <td class="won"><strong>
              <?=number_format($tot_amount);?>
              </strong></td>
            <td colspan="2"></td>
          </tr>
            </tbody>

        </table>
        <table summary="page nav">
          <tbody>
            <tr>
              <td height="40" align="center" class="text">
              <?php
$url = "monthly_stat_list.php?mode=$mode";
    page_avg($totalpage, $cpage, $url);
    ?>
                &nbsp; </td>
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
