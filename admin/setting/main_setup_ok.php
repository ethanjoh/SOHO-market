<?php
/* 아미지 디렉토리 문제로 basic.php보다 상위 디렉토리에 위치시킨다. */

//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

$logo_image = set_var($_FILES['logo_image']); 
$show_new = set_var($_POST['show_new']); 
$new_image = set_var($_FILES['new_image']); 
$new_num = set_var($_POST['new_num']); 
$show_special = set_var($_POST['show_special']); 
$special_image = set_var($_FILES['special_image']); 
$special_num = set_var($_POST['special_num']); 
$show_best = set_var($_POST['show_best']); 
$best_image = set_var($_FILES['best_image']);
$best_num = set_var($_POST['best_num']); 

$savedir ="../../images";  

/////////// 로고 등록하기
$res = mysqli_query($connect, "SELECT * FROM main_setup");
$row = mysqli_fetch_array($res);

if($_FILES['logo_image']['name']){
	$file_ext1 = substr(strrchr($_FILES['logo_image']['name'],"."), 1);
  	$file_ext1 = strtolower($file_ext1);
  
  	if ($file_ext1 != 'jpg' && $file_ext1 != 'gif' && $file_ext1 != 'jpeg' && $file_ext1 != 'png'  ){
		err_msg("이미지 파일만 올릴 수 있습니다.");  
  	}
  	if (!$_FILES['logo_image']['size']) {
		err_msg("지정한 파일(소)이 없거나 파일 크기가 0KB입니다.");  
  	}  
  	
	if($row['logo_image'] == "Y") {
		if(file_exists($row['logo_image_name']))
			unlink($row['logo_image_name']);  
	}
	
  	$logo_image = "Y"; 
  	$temp1 = $savedir."/".$_FILES['logo_image']['name'];
}else {
	if($row['logo_image'] == "Y") {
	 	$logo_image = "Y";
		$temp1 = $row['logo_image_name'];
	}else {
	 	$logo_image = "N";
		$temp1 = "";
	}
}	

move_uploaded_file($_FILES['logo_image']['tmp_name'], $temp1);	
////////// 로고 등록하기 끝

///////// 신상품 등록하기
if(!$show_new) {
	$show_new = "N";
}

if(!$new_num) {
	$new_num = 5;
}
	
if($_FILES['new_image']['name']){
	$file_ext1 = substr(strrchr($_FILES['new_image']['name'],"."), 1);
  	$file_ext1 = strtolower($file_ext1);
  
  	if ($file_ext1 != 'jpg' && $file_ext1 != 'gif' && $file_ext1 != 'jpeg' && $file_ext1 != 'png'  ){
		err_msg("이미지 파일만 올릴 수 있습니다.");  
  	}
  	if (!$_FILES['new_image']['size']) {
		err_msg("지정한 파일(소)이 없거나 파일 크기가 0KB입니다.");  
  	}  
  	
	if($row['new_image'] == "Y") {
		if(file_exists($row['new_image_name']))
			unlink($row['new_image_name']);  
	}
	
  	$new_image = "Y"; 
  	$temp2 = $savedir."/".$_FILES['new_image']['name'];
}else {	
	if($row['new_image'] == "Y") {
	 	$new_image = "Y";
		$temp2 = $row['new_image_name'];
	}else {
	 	$new_image = "N";
		$temp2 = "";
	}
}	

move_uploaded_file($_FILES['new_image']['tmp_name'], $temp2);	
////////// 신상품 등록하기 끝

///////// 기획상품 등록하기
if(!$show_special) {
	$show_special = "N";
}

if(!$special_num) {
	$special_num = 5;
}

if($_FILES['special_image']['name']){
	$file_ext2 = substr(strrchr($_FILES['special_image']['name'],"."), 1);
  	$file_ext2 = strtolower($file_ext2);
  
  	if ($file_ext2 != 'jpg' && $file_ext2 != 'gif' && $file_ext2 != 'jpeg' && $file_ext2 != 'png'  ){
		err_msg("이미지 파일만 올릴 수 있습니다.");  
  	}
  	if (!$_FILES['special_image']['size']) {
		err_msg("지정한 파일(소)이 없거나 파일 크기가 0KB입니다.");  
  	}  
  	
	if($row['special_image'] == "Y") {
		if(file_exists($row['special_image_name']))
			unlink($row['special_image_name']);  
	}
	
  	$special_image = "Y"; 
  	$temp3 = $savedir."/".$_FILES['special_image']['name'];
}else {	
	if($row['special_image'] == "Y") {
	 	$special_image = "Y";
		$temp3 = $row['special_image_name'];
	}else {
	 	$special_image = "N";
		$temp3 = "";
	}
}	

move_uploaded_file($_FILES['special_image']['tmp_name'], $temp3);	
////////// 기획상품 등록하기 끝

///////// 인기상품 등록하기
if(!$show_best) {
	$show_best = "N";
}

if(!$best_num) {
	$best_num = 5;
}

if($_FILES['best_image']['name']){
	$file_ext3 = substr(strrchr($_FILES['best_image']['name'],"."), 1);
  	$file_ext3 = strtolower($file_ext3);
  
  	if ($file_ext3 != 'jpg' && $file_ext3 != 'gif' && $file_ext3 != 'jpeg' && $file_ext3 != 'png'  ){
		err_msg("이미지 파일만 올릴 수 있습니다.");  
  	}
  	if (!$_FILES['best_image']['size']) {
		err_msg("지정한 파일(소)이 없거나 파일 크기가 0KB입니다.");  
  	}  
  	
	if($row['best_image'] == "Y") {
		if(file_exists($row['best_image_name']))
			unlink($row['best_image_name']);  
	}
	
  	$best_image = "Y"; 
  	$temp4 = $savedir."/".$_FILES['best_image']['name'];
}else {	
	if($row['best_image'] == "Y") {
	 	$best_image = "Y";
		$temp4 = $row['best_image_name'];
	}else {
	 	$best_image = "N";
		$temp4 = "";
	}
}	

move_uploaded_file($_FILES['best_image']['tmp_name'], $temp4);	
////////// 인기상품 등록하기 끝
	
########## 어드민 테이블에 입력값을 등록한다. ########## 
$query = "UPDATE main_setup SET 	
									logo_image='$logo_image',
									logo_image_name='$temp1',
									show_new='$show_new',
									new_image='$new_image',
									new_image_name='$temp2',
									new_num='$new_num',
									show_special='$show_special',
									special_image='$special_image',
									special_image_name='$temp3',
									special_num='$special_num',
									show_best='$show_best',
									best_image='$best_image',
									best_image_name='$temp4',
									best_num='$best_num' ";
				
$result = mysqli_query($connect, $query);
	
// 저장과정에서 오류가 발생하면
if (!$result) {      
   err_msg('DB 오류가 발생했습니다.');
} else {
   echo("<meta http-equiv='content-type' content='text/html; charset=UTF-8' />
		 <script>
	  window.alert('정상적으로 수정했습니다.');
	  </script>");
   echo "<meta http-equiv='Refresh' content='0; URL=main_setup.php'>"; 
}
?>
