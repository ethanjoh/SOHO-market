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

$sql     = "select * from products_category2 where code='$mcode' ";
$result1 = mysqli_query($connect, $sql);
$ca_m    = mysqli_fetch_array($result1);

if ($mode == "update") {
    $query  = "select * from products_category3 where id=$id";
    $result = mysqli_query($connect, $query);
    $row    = mysqli_fetch_array($result);
    mysqli_free_result($result);
} else {
    $mode   = "insert";
    $query  = "SELECT max(code) AS max_code FROM products_category3";
    $result = mysqli_query($connect, $query);
    $row    = mysqli_fetch_array($result);
    mysqli_free_result($result);

    if ($row['max_code']) {
        $max_code = $row['max_code'] + 1;
    } else {
        $max_code = "1";
    }
}
?>
      <form name="form1" method="post" action="ca_ssub_insert.php">
        <input type="hidden" name="mode" value="<?=$mode;?>">
        <input type="hidden" name="id" value="<?=$id;?>">
        <input type='hidden' name='lcode' value="<?=$lcode;?>">
        <input type='hidden' name='mcode' value="<?=$mcode;?>">
        <fieldset class="member">
        <legend>소분류 등록</legend>
        <p>
          <label for="up_category">상위 중분류:</label>
          <input type="text" name="up_category" value="<?=$ca_m['name'];?>" "readonly" />
        </p>
        <p>
          <label for="code">코드:</label>
          <input type="text" name="code" value="<?=($mode == "insert") ? $max_code : $row['code'];?>" "readonly" size="20" maxlength="5">
          *자동입력(변경불가)</p>
        <p>
          <label for="ca_sname">소분류명:</label>
          <input type="text" name="ca_sname" value="<?=$row['name'];?>" size="20" maxlength="20">
        </p>
        <p>
        <div class="clear"><a class="button" href="#" onclick="this.blur();javascript:sform_send();"><span>등록</span></a><a class="button" href="#" onclick="this.blur();history.back();"><span>취소</span></a></div>
        </p>
        </fieldset>
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
