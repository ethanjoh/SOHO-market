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
<div id="wrapper">
  <?php
include "../include/admin_top.php";
?>
  <div id="bodyblock">
    <div id="content">
      <form method="post" name="form1" action="../del_msg.php">
        <input type="hidden" name="gb">
        <table summary="message box">
          <tbody>
            <tr>
              <td><a href="check_msg.php">받은 쪽지함</a> | <a href="sent_msg.php">보낸 쪽지함</a> | <a href="new_msg.php">쪽지 쓰기</a> </td>
            </tr>
          </tbody>
        </table>
        <table summary="body">
          <tbody>
            <tr class="odd">
              <td width="70%">메시지</td>
              <td>보낸 시간</td>
            </tr>
            <?php

$query2  = "SELECT * FROM message_info WHERE mnum='$mnum' ";
$result2 = mysqli_query($connect, $query2);
$rows2   = mysqli_fetch_array($result2);

//받은 편지함 & 수신전
if ($gb == '1' && ($rows2['receive_chk'] == 'N')) {
    $query1  = "UPDATE message_info SET receive_chk='Y', receive_reg=now() WHERE mnum='$mnum' ";
    $result1 = mysqli_query($connect, $query1);
}
?>
            <tr>
              <td class="left"><?=nl2br(stripslashes($rows2['message']));?>
                </a> </td>
              <td><?=$rows2['send_reg'];?></td>
            </tr>
          </tbody>
        </table>
        <table summary="button">
          <tbody>
            <tr>
              <td><div class="clear"><a class="button" href="del_msg.php?mode=view&amp;mnum=<?=$mnum;?>&amp;gb=<?=$gb;?>"><span>삭제</span></a><a class="button" href="new_msg.php?mode=reply&amp;id=<?=$rows2['sendid_fk'];?>&amp;mnum=<?=$mnum;?>"><span>답변</span></a></div></td>
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
