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
<script type="text/javascript">
function open_win()
{
window.open("../../bbclone/","_blank","scrollbars=yes, resizable=no, copyhistory=yes, width=650, height=560")
}
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
    <!--
      <?php
 // install directory path, starting from the www-root and with a trailing slash 
 /*
 define("_BBCLONE_DIR", "../../bbclone/"); 
 
 if (is_readable(_BBCLONE_DIR."constants.php")) {
   require(_BBCLONE_DIR."constants.php");
 }
 else exit("invalid path given. it must end with a slash");

 $BBC_IMAGES_PATH = "../../bbclone/images/"; // a workaround 
 
 foreach (array("conf/config", "lib/selectlang", "var/access", "show_global") as $i) {
   if (is_readable(_BBCLONE_DIR.$i.".php")) require(_BBCLONE_DIR.$i.".php");
   else exit(bbc_msg(_BBCLONE_DIR.$i.".php"));
 }
*/
 ?>    
      <fieldset class="info">
        <legend><img src="../images/info.png" alt="안내" /> 사용방법</legend>
        <ul>
          <li style="text-align:left">제일 중요한 정보는 방문 페이지 순위입니다.</li>
          <li style="text-align:left">많이 본 상품이나 페이지 확인이 가능합니다.</li>
          <li style="text-align:left"> URL을 복사해 주소창에 붙여넣으시면 확인할 수 있습니다</li>
        </ul>
      </fieldset>
      <table summary="stats">
        <caption>
        접속 통계 (<a href="#" onclick="open_win();">상세정보 보기</a>)
        </caption>
        <tbody>
          <tr>
            <td colspan="2"><fieldset class="page">
                <legend><img src="../images/page_portrait.png" /> 방문 페이지 TOP 10</legend>
                <?php //bbc_show_top_pages()?>
              </fieldset></td>
          </tr>
        </tbody>
      </table>
    </div>
    -->
    <iframe src="http://www.<?=$_SERVER['SERVER_NAME']?>/bbclone/index.php" width="90%" height="700px"></iframe>
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
