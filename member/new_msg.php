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
<!-- category -->
<link rel="stylesheet" type="text/css" href="../css/ddsmoothmenu.css" />
<!--[if lte IE 7]>
<style type="text/css">
html .ddsmoothmenu{height: 1%;} /*Holly Hack for IE7 and below*/
</style>
<![endif]-->

<?php include_once "../include/inc_script.html"; ?>

<script language="JavaScript" src="../js/global.js"></script>
<script language="JavaScript" src="../js/member.js"></script>
<!-- <script type="text/javascript" src="../js/jquery-1.2.6.pack.js"></script> -->
<script type="text/javascript" src="../js/ddsmoothmenu.js">
/***********************************************
* Smooth Navigational Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/
</script>
<!-- category end -->
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
//상단 메뉴 부분을 파일에서 불러옵니다.
include '../include/top_menu.php';  
?>
  <div id="bodyblock">
    <div id="content">
      <table summary="message box">
        <tbody>
          <tr>
            <td><a href="check_msg.php">받은 쪽지함</a> | <a href="sent_msg.php">보낸 쪽지함</a> | <b>쪽지 쓰기</b> </td>
          </tr>
        </tbody>
      </table>
      <form method='post' name=form1 action="new_msg_ok.php">
        <table summary="body">
          <tbody>
            <tr>
              <td class="column1">받는 사람</td>
              <td class="left">관리자
              </td>
            </tr>
            <tr>
              <td class="column1">내용</td>
              <td class="left"><textarea name="msg" cols="50" rows="15" ></textarea>
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
include '../include/bottom.php';
?>
  <!-- copyright end -->
</div>
<!-- wrapper end -->
</body>
</html>
