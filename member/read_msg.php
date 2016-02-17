<?php
include "../util/config.php";
// 각종 유틸함수
include "../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

// 이름과 아이디에 해당되는 세션이 존재하는지 확인
if(!isset($_SESSION["p_id"]) || !isset($_SESSION["p_name"])){
  err_msg('로그인 정보가 없습니다. 다시 로그인해 주세요.');
}

//메타정보
$info_query = "SELECT * FROM admin_setup";
$info_res = mysqli_query($connect, $info_query);
$info = mysqli_fetch_array($info_res);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="<?=$info['keywords']?>" />
<meta name="description" content="<?=$info['description']?>" />
<title><?=$info['site_name']?></title>
<link rel="stylesheet" type="text/css" href="../css/shop_layout.css" />
<script language="JavaScript" src="../js/global.js"></script>
<script language="JavaScript" src="../js/member.js"></script>
<!-- category -->
<link rel="stylesheet" type="text/css" href="../css/ddsmoothmenu.css" />
<!--[if lte IE 7]>
<style type="text/css">
html .ddsmoothmenu{height: 1%;} /*Holly Hack for IE7 and below*/
</style>
<![endif]-->
<script type="text/javascript" src="../js/jquery-1.2.6.pack.js"></script>
<script type="text/javascript" src="../js/ddsmoothmenu.js">
/***********************************************
* Smooth Navigational Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/
</script>
</head>
<body>
<div id="wrapper">
  <?php  
//상단 메뉴 부분을 파일에서 불러옵니다.
include '../include/top_menu.php';  
?>
  <div id="bodyblock">
    <div id="content">
        <input type="hidden" name="gb" value="<?=$gb?>">
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
              <td>메시지</td>
              <td>보낸 시간</td>
              <td>삭제</td>
            </tr>
            <?php	  
               $query2 = "SELECT * FROM message_info WHERE mnum='$mnum' ";
	             $result2 = mysqli_query($connect, $query2);
	             $rows2 = mysqli_fetch_array($result2);
      

	  //받은 편지함 & 수신전
      if($gb=='1' && ($rows2['receive_chk'] =='N')){
  	    $query1  = "UPDATE message_info SET receive_chk='Y', receive_reg=now() WHERE mnum='$mnum' ";
  		  $result1 = mysqli_query($connect, $query1);
      }
?>
            <tr>
              <td width="80%" class="left"><?=nl2br(stripslashes($rows2['message']))?></a></td>
              <td><?=$rows2['send_reg']?></td>
              <td><a href="del_msg.php?mode=view&mnum=<?=$mnum?>&gb=<?=$gb?>"><img src="../images/delete.gif" alt="쪽지삭제" /></a></td>
            </tr>
          </tbody>
        </table>
        <table summary="button">
          <tbody>
            <tr>
              <td></td>
            </tr>
          </tbody>
        </table>
    </div>
    <!-- content end -->
  </div>
  <!-- bodyblock end -->
  <!-- copyright -->
  <?php
include '../include/bottom.php';
?>
  <!-- copyright end -->
</div>
<!-- wrapper end -->
</body>
</html>
