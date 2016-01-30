<?php
// 데이타베이스 연결정보 및 기타설정
include "../util/config.php";
// 각종 유틸함수
include "../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);
$id = set_var($_POST['id']);
$license_no1 = set_var($_POST['license_no1']);
$license_no2 = set_var($_POST['license_no2']);
$license_no3 = set_var($_POST['license_no3']);

if(!$id || !$license_no1 || !$license_no2 || !$license_no3){
	err_msg('정식으로 접속하세요.');
}

$license_no = $license_no1."-".$license_no2."-".$license_no3;
$query = "SELECT * FROM member WHERE license_no ='$license_no' AND id='$id' ";
$result = mysqli_query($connect, $query);
$check = mysqli_fetch_array($result);
mysqli_free_result($result);

if(!$check){
	err_msg('아이디나 사업자등록번호와 일치하는 정보가 없습니다.');
}else {
	$qry = "UPDATE member SET passwd = '011c945f30ce2cbafc452f39840f025693339c42'
	WHERE license_no ='$license_no' AND id='$id' ";
	mysqli_query($connect, $qry);

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
					<table summary="body">
						<thead>
							<tr>
								<th>비밀번호 찾기 검색결과</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><?php
									$res = mysqli_query($connect, "SELECT * FROM admin_setup");
									$row = mysqli_fetch_array($res);
									
									$sender_email = $row['email'];
									$receiver_email = $check['md_email'];
									
									$subject  = "비밀번호 초기화 문의 결과안내";
									$mailheaders = "Return-Path: $sender_email\r\n";
									$mailheaders .= "From: $sender <$sender_email>\r\n";
									$boundary = "----".uniqid("part");
									$mailheaders = "Return-Path: $sender_email\r\n";
									$mailheaders .= "From: $sender <$sender_email>\r\n";
									$mailheaders .= "Content-Type: text/html; charset=utf-8\r\n";
									
									$contents = "(<strong><a href=\"http://www."$row['homepage']." target=\"_blank\">".$row['site_name']."</a></strong>)에서 ".$check['company_name']." 님이 문의하신 비밀번호입니다.";
									$contents .= "<p>회원님의 비밀번호는 1111 (숫자 '1' 4개)로 임시변경되었습니다.</p>";
									$contents .= "<p>로그인 후 반드시 비밀번호를 변경하세요.</p>";
    								$contents .= "<p></p><p>만약 초기화를 요청한 적이 없다면 타인에 의해 시도일 수 있으니 보안을 위해 반드시 비밀번호를 변경하세요.</p>";

									$bodytext =  stripslashes($contents);
					
									mail($receiver_email,$subject,$bodytext,$mailheaders);
									
									if(mail) {
										echo "<p>".$check['md_email']."로 비밀번호 초기화를 전송했습니다.</p>";
									}else {
										echo"<p></p><p>메일 전송에 실패했습니다. 관리자에게 문의바랍니다.</p>";
									}
									?>
								</td>
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