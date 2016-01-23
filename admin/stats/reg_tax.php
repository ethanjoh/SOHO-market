<?php

//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

$id = set_var($_POST['id']);
$goods_name = set_var($_POST['goods_name']);
$sum = set_var($_POST['sum']);
$reg_date = set_var($_POST['reg_date']);
$paid = set_var($_POST['paid']);

$paid = $paid[0];

$title = explode("-", $reg_date);
$title =$title[0]."년 ".$title[1]."월 정산";

$sql = "INSERT INTO tax_list (id, title, goods_name, sum, reg_date, paid) 
	           VALUES('$id', '$title', '$goods_name','$sum', '$reg_date', '$paid' )";
$result = mysqli_query($connect, $sql);

if($result) {

	//회원정보 확인
	$result2 = mysqli_query($connect, "SELECT * FROM member WHERE id='$id'");
	$mrow = mysqli_fetch_array($result2);

	######### SMS 발송처리 (회원 SMS 수신 Y 에만)
	$res = mysqli_query($connect, "SELECT * FROM sms");
	$sms_row = mysqli_fetch_array($res);
	
	//관리페이지에서 SMS 사용여부 확인
	if($sms_row['sms'] == "Y") {
		//담당자에게 SMS 발송
		if($mrow['sms'] == "Y" && $sms_row['tax_chk'] == "Y") {	
			//send_sms(받는 사람 핸드폰번호, 메시지 타입, ,업체명, 날짜, db연결)
			//메시지 타입 5: 계산서 발행완료 처리, 날짜가 빈칸이면 즉시 발송
			send_sms($mrow['md_hphone'], 5, $mrow['compnay_name'], "", $connect);
		}		
	}
	####### SMS 발송 끝 
	
	if($m == 'date') { //기간별 정산관리에서 넘어옴
		$url = "tax_list.php?mode=date&date1=".$date1."&date2=".$date2;
	}else{
		$url = "monthly_stat_list.php";
	}
	
	$msg = "세금계산서를 발행했습니다.";
	
	show_msg($msg, $url);
	
} else {
	$msg = "DB 에러가 발생했습니다.";
	$url = "mem_stat_list.php?id=$id";
	
	show_msg($msg, $url);
	
}

?>
