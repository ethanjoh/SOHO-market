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
<script language="JavaScript" type="text/JavaScript">
<!--

 function form_delete(){
  var form = document.form1;
  var b=0;
     for (i=0; i < form.elements.length; i++) {
		 if (form.elements[i].name =="mnum[]") {
            if (form.elements[i].checked == true) {
			  b++;
			 }
	     }
	 }

	if(b == 0) {
	 alert("적어도 하나의 항목은 선택하셔야 합니다.");
	     return;
    }
   form.gb.value="1";
   ret = confirm('삭제하시겠습니까?');
   if(ret) {
   	form.submit();
   }
  }

//-->
</script>
</head>
<body>
<div id="wrapper">
  <?php
include "../include/admin_top.php";
?>
  <div id="bodyblock">
    <div id="content">
      <form method='post' name="form1" action="del_msg.php">
        <input type="hidden" name="gb">
        <table summary="message box">
          <tbody>
            <tr>
              <td><b>받은 쪽지함</b> | <a href="sent_msg.php">보낸 쪽지함</a> | <a href="new_msg.php">쪽지 쓰기</a> </td>
            </tr>
          </tbody>
        </table>
        <table summary="body">
          <thead>
            <tr class="odd">
              <th width="10%">선택</th>
              <th width="17%">보낸 사람</th>
              <th width="42%">메시지</th>
              <th width="12%">확인유무</th>
              <th width="19%">보낸시간</th>
            </tr>
          </thead>
          <?php
$a_re_chk['Y'] = "<img src=\"../images/email_open.png\" alt=\"확인\" />";
$a_re_chk['N'] = "<img src=\"../images/email.png\" alt=\"미확인\" />";

$query = "SELECT mnum FROM message_info
	               WHERE receiveid_fk = 'admin'
				   AND receive_del = 'N' ";
$result     = mysqli_query($connect, $query);
$total_bnum = mysqli_num_rows($result);
mysqli_free_result($result);

if (!$page) {
    $page = 1;
}

$p_scale = 5;

$cpage     = intval($page);
$totalpage = intval($total_bnum / $p_scale);
if ($totalpage * $p_scale != $total_bnum) {
    $totalpage = $totalpage + 1;
}

if ($cpage == 1) {
    $cline = 0;
} else {
    $cline = ($cpage * $p_scale) - $p_scale;
}

$limit = $cline + $p_scale;

if ($limit >= $total_bnum) {
    $limit = $total_bnum;
}

$p_scale1 = $limit - $cline;

$query2 = "SELECT * FROM message_info
	             WHERE receiveid_fk = 'admin' AND receive_del = 'N'
		  	     ORDER BY mnum DESC LIMIT $cline,$p_scale1";
$result2 = mysqli_query($connect, $query2);

for ($i = 0; $rows2 = mysqli_fetch_array($result2); $i++) {
    $bunho    = $total_bnum - ($i + $cline) + 1;
    $msg_char = cut_string_utf8($rows2['message'], 30, "...");
    ?>
          <tbody>
            <tr>
              <td><input type="checkbox" name="mnum[]" value="<?=$rows2['mnum'];?>"></td>
              <td><?=$rows2['sendid_fk'];?>
                &nbsp; </td>
              <td class="left"><a href="read_msg.php?mnum=<?=$rows2['mnum'];?>&amp;gb=1">
                <?=$msg_char;?>
                </a> </td>
              <td><?=$a_re_chk[$rows2['receive_chk']];?></td>
              <td ><?=$rows2['send_reg'];?></td>
            </tr>
            <?php
}
mysqli_free_result($result2);
?>
          </tbody>
        </table>
        <table>
          <tbody>
            <tr>
              <td width="27%"><div class="full"><a class="button" href="#" onclick="this.blur();javascript:form_delete();"><span>삭제</span></a> </div></td>
              <td><?php
$url = "check_msg.php?gb=1";
page_avg($totalpage, $cpage, $url);
?>              </td>
            </tr>
          </tbody>
        </table>
      </form>
    </div>
    <!-- content end -->
  </div>
  <!-- bodyblock end -->
  <!-- copyright -->
  <?php
include "../include/admin_bottom.php";
?>
  <!-- copyright end -->
</div>
<!-- wrapper end -->
</body>
</html>
