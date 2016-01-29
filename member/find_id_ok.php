<?php
// 데이타베이스 연결정보 및 기타설정
include "../util/config.php";
// 각종 유틸함수
include "../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

$md_email = set_var($_POST['md_email']);
$license_no1 = set_var($_POST['license_no1']);
$license_no2 = set_var($_POST['license_no2']);
$license_no3 = set_var($_POST['license_no3']);

if(!$md_email || !$license_no1 || !$license_no2 || !$license_no3){
  err_msg('정식으로 접속하세요.');
}

$license_no = $license_no1."-".$license_no2."-".$license_no3;

$query = "SELECT * FROM member 
		  WHERE md_email='$md_email' 
		  AND license_no ='$license_no' ";
$result = mysqli_query($connect, $query);
$check = mysqli_fetch_array($result);
mysqli_free_result($result);

if(!$check){
  err_msg('이메일 주소나 사업자등록번호와 일치하는 정보가 없습니다.');
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
<title>
<?=$info['site_name']?>
</title>
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
      <table summary="find id">
        <thead>
          <tr>
            <th>아이디 찾기 검색결과</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><p>
                <?=$check['company_name']?>
                님의 아이디는 <strong>
                <?=$check['id']?>
                </strong> 입니다.</p></td>
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
