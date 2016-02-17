<?php

include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

// 카테고리값이 1이상이 아닐경우 1로..
if (!$level) {
    $level = 1;
}
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
      <fieldset class="info">
      <legend><img src="../images/info.png" alt="안내" /> 사용방법</legend>
      <ul>
        <li style="text-align:left">관리자가 등록한 상품만 표시됩니다.</li>
        <li style="text-align:left">품절 시 전체재고란에 0을 입력하세요.</li>
        <li style="text-align:left">옵션은 각 옵션별 품절처리만 가능합니다. (품절: 0, 그 외 1)</li>
        <li style="text-align:left">옵션품절에서 각 품절 여부는 '|'로 구분하세요. (예: 0|1|1|0)</li>
      </ul>
      </fieldset>
      <table summary="view product list">
        <caption>
        상품 재고리스트
        </caption>
        <thead>
          <tr class="odd">
            <th class="member" scope="col">번호</th>
            <th class="member" colspan="2" scope="col">제품명</th>
            <th class="member" scope="col">옵션</th>
            <th class="member" scope="col">옵션품절</th>
            <th class="member" scope="col">전체재고</th>
            <th class="member" scope="col">수정</th>
          </tr>
        </thead>
        <tbody>
          <?php
if ($mode == 'search') {
    $search_keyword = " AND $key LIKE '%$key_value%' ";
}

// 상품의 갯수를 가져옴
$query  = "SELECT * FROM products WHERE id='$_COOKIE[ROOT_ID]' $search_keyword ";
$result = mysqli_query($connect, $query);

if ($result) {
    $total = mysqli_num_rows($result);
    mysqli_free_result($result);
}

$scale = 15;

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

$query1 = "SELECT * FROM products WHERE id='$_COOKIE[ROOT_ID]' $search_keyword
							    ORDER BY num DESC LIMIT $cline,$scale1";
$result1 = mysqli_query($connect, $query1);

if ($result1) {

    for ($i = 0; $row = mysqli_fetch_array($result1); $i++) {
        $list_num = $total - ($cline + $i);

        if ($i % 2 == 1) {
            echo "<tr class=\"odd\">\n";
        } else {
            echo "<tr>";
        }

        ?>
        <td><?=$list_num;?></td>
          <td><img src="<?=$row['s_image_name'];?>" width="30" height="30" alt="small image" /></td>
          <td class="left"><?=$row['name'];?></td>
          <form name="s" method="post" action="change_stock.php">
          <input type="hidden" name="num" value="<?=$row['num'];?>" />
          <input type="hidden" name="page" value="<?=$page;?>" />
          <td><?php
if ($row['opt']) {
            show_option($row);
            ?></td>
          <td>
            <input type="text" name="opt_stock[]" value="<?=$row['opt_stock'];?>" />
            </td>
          <td><input class="num" type="text" name="stock" value="<?=$row['stock'];?>" size="5" /> 개</td>
          <?php

        } else {
            ?>
          <td>N/A</td>
            <td><input class="num" type="text" name="stock" value="<?=$row['stock'];?>" size="5" />
              개</td>
            <?php
}
        ?>
            <td><input type="submit" name="modify" id="modify" value="수정" />
            </td>
          </form>
        </tr>
        <?php
}

    mysqli_free_result($result1);

}
; //if($result1)
?>
        <?php
if ($total == 0) {
    ?>
        <tr>
          <td colspan="8"><p>등록된 상품이 없습니다.</p></td>
        </tr>
        <?php
}
?>
        </tbody>

      </table>
      <form action='pro_stock_list.php' name='f' method='post' >
        <tr bgcolor="#FFFFFF" align="center">
          <td colspan="10">
            <select name='key'>
              <option value='name'>상품명</option>
              <option value='company'>제조사</option>
            </select>
            <input type='hidden' name='mode' value='search' />
            <input type='text' name='key_value' size='16' />
            <input type="image" src="../images/search_btn.gif" style="background-color:#FFFFFF; border:none;vertical-align: middle; " />
          </td>
        </tr>
      </form>
      </table>
      </td>
      </tr>
      </table>
      <table summary="page nav">
        <tbody>
          <tr bgcolor="#FFFFFF" align="center">
            <td><?php
$url = "$PHP_SELF?mode=$mode&amp;key=$key&amp;key_value=$key_value";
page_avg($totalpage, $cpage, $url);
?>
            </td>
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
