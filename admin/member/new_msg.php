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

 function send_chk(){
  var form = document.form1;

  if(!form.msg.value) {
     alert("보낼 내용을 입력하세요!");
	 form.msg.focus();
	 return ;
  }

  form.submit();
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
      <table summary="message box">
        <tbody>
          <tr>
            <td><a href="check_msg.php">받은 쪽지함</a> | <a href="sent_msg.php">보낸 쪽지함</a> | <b>쪽지 쓰기</b></td>
          </tr>
        </tbody>
      </table>
      <form method="post" name="form1" action="new_msg_ok.php">
      <input type="hidden" name="mode" value="<?=$mode;?>" />
      <input type="hidden" name="reply_id" value="<?=$id;?>" />
        <table summary="body">
          <tbody>
            <tr>
              <td class="column1">받는 사람</td>
              <td class="left"><?php
if ($mode == "reply") {
    echo $id;
    $query2  = "SELECT * FROM message_info WHERE mnum='$mnum' ";
    $result2 = mysqli_query($connect, $query2);
    $rows2   = mysqli_fetch_array($result2);
} else {
    echo "<select name='receive_id'>\n";

    $mqry = "SELECT * FROM member ORDER BY company_name ";
    $mres = mysqli_query($connect, $mqry);

    for ($i = 0; $mrow = mysqli_fetch_array($mres); $i++) {
        echo "<option value=" . $mrow['id'] . ">" . $mrow['company_name'] . "(" . $mrow['id'] . ")</option>\n";
    }
    echo "</select>\n";
}

?>              </td>
            </tr>
            <tr>
              <td class="column1">내용</td>
              <td class="left"><textarea name="msg" cols="50" rows="15" ><?php if ($mnum) {
    echo stripslashes($rows2['message']) . "\n";
    echo "---------------";}
?></textarea>
              </td>
            </tr>
          </tbody>
        </table>
      </form>
      <table summary="button">
        <tbody>
          <tr>
            <td><div class="clear"><a class="button" href="javascript:send_chk()" onclick="this.blur();"><span>보내기</span></a><a class="button" href="check_msg.php"><span>목록</span></a></div></td>
          </tr>
        </tbody>
      </table>
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
