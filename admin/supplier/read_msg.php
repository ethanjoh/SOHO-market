<?php

//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);
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
      $query2 = "SELECT * FROM message_info WHERE mnum='$mnum' ";
	  $result2 = mysqli_query($connect, $query2);
	  $rows2 = mysqli_fetch_array($result2);
      

	  //받은 편지함 & 수신전
      if($gb=='1' && ($rows2['receive_chk'] =='N')){
	    $query1  = "UPDATE message_info 
				    SET receive_chk='Y',
					receive_reg=now() 
					WHERE mnum='$mnum' ";
		$result1 = mysqli_query($connect, $query1);
      }
?>
            <tr>
              <td class="left"><?=nl2br(stripslashes($rows2['message']))?>
                </a> </td>
              <td><?=$rows2['send_reg']?></td>
            </tr>
          </tbody>
        </table>
        <table summary="button">
          <tbody>
            <tr>
              <td><div class="clear"><a class="button" href="../del_msg.php?mode=view&amp;gb=<?=$gb?>"><span>삭제</span></a><a class="button" href="new_msg.php?mode=reply&amp;id=<?=$rows2['sendid_fk']?>"><span>답변</span></a></div></td>
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
