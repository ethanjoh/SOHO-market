<?php
include "../util/config.php";
// 각종 유틸함수
include "../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);
if(!$_COOKIE[p_sid]){
$SID = md5(uniqid(rand()));
SetCookie("p_sid",$SID,0,"/");
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
    <link rel="stylesheet" type="text/css" href="../css/ddsmoothmenu.css" />

    <?php include_once "../include/inc_script.html"; ?>

    <script language="JavaScript" src="../js/global.js"></script>
    <script language="JavaScript" src="../js/member.js"></script>
    <!-- category -->
    <!--[if lte IE 7]>
    <style type="text/css">
    html .ddsmoothmenu{height: 1%;} /*Holly Hack for IE7 and below*/
    </style>
    <![endif]-->
    <!--<script type="text/javascript" src="../js/jquery-1.2.6.pack.js"></script> -->
    <script type="text/javascript" src="../js/ddsmoothmenu.js">
    /***********************************************
    * Smooth Navigational Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
    * This notice MUST stay intact for legal use
    * Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
    ***********************************************/
    </script>
    <!-- category end -->
  </head>
  <body>
    <div id="wrapper">
      <?php
      //상단 메뉴 부분을 파일에서 불러옵니다.
      include '../include/top_menu.php';
      ?>
      <div id="bodyblock">
        <div id="content">
          <form name="form1" method="post" action="find_id_ok.php">
            <p>
            <fieldset class="member">
              <legend>아이디 찾기</legend>
              <label for="id">담당자 이메일주소:</label>
              <input type="text" name="md_email" size="18" />
              </p>
              <p>
              <label for="license_no">사업자등록번호:</label>
              <input size=3 name="license_no1" OnKeyUp="focus_move();"> - <input size=2 name="license_no2" OnKeyUp="focus_move();"> - <input size=5 name="license_no3" >
              <p>
              <div class="clear"> <a class="button" href="#" onclick="this.blur();javascript:lost_checkInput1();"><span>찾기</span></a> <a class="button" href="../shop/index.php" onclick="this.blur();"><span>취소</span></a></div>
              </p>
            </fieldset>
            </p>
          </form>
          <form name="form2" method="post" action="find_pass_ok.php">
            <p>
            <fieldset class="member">
              <legend>비밀번호 초기화</legend>
              <label for="id">아이디:</label>
              <input type="text" name="id" size="10" />
              </p>
              <p>
              <label for="license_no">사업자등록번호:</label>
              <input size=3 name="license_no1" OnKeyUp="focus_move();"> - <input size=2 name="license_no2" OnKeyUp="focus_move();"> - <input size=5 name="license_no3" >
              <p align="center">(초기화된 비밀번호는 등록한 이메일로 발송됩니다.)</p>
              <p>
              <div class="clear"> <a class="button" href="#" onclick="this.blur();javascript:lost_checkInput2();"><span>찾기</span></a> <a class="button" href="../shop/index.php" onclick="this.blur();"><span>취소</span></a></div>
              </p>
            </fieldset>
            </p>
          </form>
          <p></p>
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