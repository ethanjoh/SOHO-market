<?php

include "../../util/util.php";

$id           = set_var($_POST['id']);
$passwd       = set_var($_POST['passwd']);
$company_name = set_var($_POST['company_name']);
$license_no1  = set_var($_POST['license_no1']);
$license_no2  = set_var($_POST['license_no2']);
$license_no3  = set_var($_POST['license_no3']);
$seller       = set_var($_POST['seller']);
$dc_rate      = set_var($_POST['dc_rate']);
$tax          = set_var($_POST['tax']);

$license_no = $license_no1 . "-" . $license_no2 . "-" . $license_no3;
$id         = addslashes($id);
$tax        = $tax[0];
$passwd     = sha1($passwd);

########## 동일 정보 존재여부 확인. ##########
$query     = "SELECT id FROM member WHERE license_no='$license_no' ";
$result    = mysqli_query($connect, $query);
$total_num = mysqli_num_rows($result);

if ($total_num) {
    err_msg('이미 등록된 사업자등록번호가 있습니다.');
} else {

    ########## 회원정보 테이블에 입력값을 등록한다. ##########
    $query = "INSERT INTO member(id,
								passwd,
								company_name,
								license_no,
								seller,
								dc_rate,
								tax,
								reg_date)
			   VALUES ('$id',
			   				'$passwd',
							'$company_name',
							'$license_no',
							'$seller',
							'$dc_rate',
							'$tax',
							now() )";
    $result = mysqli_query($connect, $query);

    // 저장과정에서 오류가 발생하면
    if (!$result) {
        err_msg('데이터베이스 오류가 발생하였습니다.\n 관리자에게 문의하시기 바랍니다.');
    } else {
        $msg = '정상적으로 회원을 추가했습니다.';
        $url = 'top_member_list.php';

        show_msg($msg, $url);
    }
}
