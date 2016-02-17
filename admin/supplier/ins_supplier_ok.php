<?php

include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

$id = set_var($_POST['id']); 
$passwd = set_var($_POST['passwd']); 
$md_email = set_var($_POST['md_email']);
$md_name = set_var($_POST['md_name']);
$md_hphone1 = set_var($_POST['md_hphone1']);
$md_hphone2 = set_var($_POST['md_hphone2']);
$md_hphone3 = set_var($_POST['md_hphone3']);
$sms = set_var($_POST['sms']);
$company_name = set_var($_POST['company_name']); 
$license_no1 = set_var($_POST['license_no1']);
$license_no2 = set_var($_POST['license_no2']);
$license_no3 = set_var($_POST['license_no3']);
$ceo = set_var($_POST['ceo']); 
$o_zipcode1 = set_var($_POST['o_zipcode1']); 
$o_zipcode2 = set_var($_POST['o_zipcode2']); 
$o_addr1 = set_var($_POST['o_addr1']); 
$o_addr2 = set_var($_POST['o_addr2']); 
$o_phone1 = set_var($_POST['o_phone1']);  
$o_phone2 = set_var($_POST['o_phone2']);  
$o_phone3 = set_var($_POST['o_phone3']);  
$o_fax1 = set_var($_POST['o_fax1']);
$o_fax2 = set_var($_POST['o_fax2']);
$o_fax3 = set_var($_POST['o_fax3']);  
$category1 = set_var($_POST['category1']); 
$category2 = set_var($_POST['category2']);  
$homepage = set_var($_POST['homepage']);  
$d_zipcode1 = set_var($_POST['d_zipcode1']); 
$d_zipcode2 = set_var($_POST['d_zipcode2']); 
$d_addr1 = set_var($_POST['d_addr1']); 
$d_addr2 = set_var($_POST['d_addr2']); 
$d_phone1 = set_var($_POST['d_phone1']);
$d_phone2 = set_var($_POST['d_phone2']);
$d_phone3 = set_var($_POST['d_phone3']); 
$d_fax1 = set_var($_POST['d_fax1']);
$d_fax2 = set_var($_POST['d_fax2']); 
$d_fax3 = set_var($_POST['d_fax3']);  
$seller = set_var($_POST['seller']); 
$margin = set_var($_POST['margin']); 
$tax = set_var($_POST['tax']); 
$approved = set_var($_POST['approved']); 

$license_no = $license_no1."-".$license_no2."-".$license_no3;
$md_hphone = $md_hphone1."-".$md_hphone2."-".$md_hphone3;
$o_phone = $o_phone1."-".$o_phone2."-".$o_phone3;
$o_fax = $o_fax1."-".$o_fax2."-".$o_fax3;
$d_phone = $d_phone1."-".$d_phone2."-".$d_phone3;
$d_fax = $d_fax1."-".$d_fax2."-".$d_fax3;

$id = addslashes($id);
$tax = $tax[0];
$approved = $approved[0];
$sms = $sms[0];

$o_zipcode = $o_zipcode1."-".$o_zipcode2;
$d_zipcode = $d_zipcode1."-".$d_zipcode2;	

$passwd = sha1($passwd);

########## 동일 정보 존재여부 확인. ##########
/* 
$query  = "SELECT id FROM supplier WHERE license_no='$license_no' ";
$result = mysqli_query($connect, $query);
$total_num = mysqli_num_rows($result);

if($total_num){
	echo("<script>
	      window.alert('이미 등록된 사업자등록번호가 있습니다.')
	      history.go(-1)
	      </script>");
	exit;
}
else{
*/
	########## 회원정보 테이블에 입력값을 등록한다. ########## 
	$query = "INSERT INTO supplier (id, 
									passwd, 
									md_email, 
									md_name, 
									md_hphone, 
									sms,
									company_name, 
									license_no, 
									ceo, 
									o_zipcode, 
									o_addr1, 
									o_addr2, 
									o_phone, 
									o_fax, 
									category1,
									category2,
									homepage,
									d_zipcode,
									d_addr1,
									d_addr2,
									d_phone,
									d_fax,
									seller,
									reg_date,
									margin,
									tax,
									payment_day,
									approved ) 
			   VALUES ('$id', 
						'$passwd', 
						'$md_email', 
						'$md_name', 
						'$md_hphone',
						'$sms',
						'$company_name', 
						'$license_no', 
						'$ceo',
						'$o_zipcode', 
						'$o_addr1', 
						'$o_addr2', 
						'$o_phone', 
						'$o_fax', 
						'$category1',
						'$category2',
						'$homepage',
						'$d_zipcode',
						'$d_addr1',
						'$d_addr2',
						'$d_phone',
						'$d_fax',
						'$seller',
						now(),
						'$margin',
						'$tax',
						'$payment_day',
						'$approved')";
	$result = mysqli_query($connect, $query);
	
	// 저장과정에서 오류가 발생하면
	if (!$result) {      
	   err_msg('데이터베이스 오류가 발생하였습니다.\n 관리자에게 문의하시기 바랍니다.');
	}
	else {
		$msg = "정상적으로 공급업체를 추가했습니다.";
		$url = "top_supplier_list.php";
		
		show_msg($msg, $url);
		
	}
//}
?>
