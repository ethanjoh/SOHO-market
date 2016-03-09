<?php
/* 아미지 디렉토리 문제로 basic.php보다 상위 디렉토리에 위치시킨다. */
include_once "../include/admin_auth.php";
include_once "../../util/util.php";

$admin_id = set_var($_POST['admin_id']);
// $admin_pass         = set_var($_POST['admin_pass']);
$admin_pass1     = set_var($_POST['admin_pass1']);
$changePw        = set_var($_POST['changePw']);
$admin_email     = set_var($_POST['admin_email']);
$admin_name      = set_var($_POST['admin_name']);
$info_name       = set_var($_POST['info_name']);
$site_name       = set_var($_POST['site_name']);
$keywords        = set_var($_POST['keywords']);
$description     = set_var($_POST['description']);
$company_name    = set_var($_POST['company_name']);
$license_no1     = set_var($_POST['license_no1']);
$license_no2     = set_var($_POST['license_no2']);
$license_no3     = set_var($_POST['license_no3']);
$online_license  = set_var($_POST['online_license']);
$ceo             = set_var($_POST['ceo']);
$privacy_manager = set_var($_POST['privacy_manager']);
$category1       = set_var($_POST['category1']);
$category2       = set_var($_POST['category2']);
$o_zipcode1      = set_var($_POST['o_zipcode1']);
// $o_zipcode2      = set_var($_POST['o_zipcode2']);
$o_addr1         = set_var($_POST['o_addr1']);
$o_addr2         = set_var($_POST['o_addr2']);
$tel1            = set_var($_POST['tel1']);
$tel2            = set_var($_POST['tel2']);
$tel3            = set_var($_POST['tel3']);
$fax1            = set_var($_POST['fax1']);
$fax2            = set_var($_POST['fax2']);
$fax3            = set_var($_POST['fax3']);
$type            = set_var($_POST['type']);
$homepage        = set_var($_POST['homepage']);
$logo_image_name = set_var($_POST['logo_image_name']);
$sign_image_name = set_var($_POST['sign_image_name']);
$bank            = set_var($_POST['bank_account']);

$license_no  = $license_no1 . "-" . $license_no2 . "-" . $license_no3;
$admin_email = addslashes($admin_email);
$description = addslashes($description);
$addr1       = addslashes($o_addr1);
$addr2       = addslashes($o_addr2);

$tel = $tel1 . "-" . $tel2 . "-" . $tel3;
$fax = $fax1 . "-" . $fax2 . "-" . $fax3;
// $zipcode = $o_zipcode1 . "-" . $o_zipcode2;
$zipcode = $o_zipcode1;

if ($changePw) {
    $new_pass = sha1($admin_pass1);

    ########## 어드민 테이블에 입력값을 등록한다. ##########
    $query  = "UPDATE admin_setup SET passwd = '$new_pass' WHERE id='$admin_id' ";
    $result = mysqli_query($connect, $query);

    ######### 게시판의 글들에 대한 비밀번호도 모두 수정한다. #########
    $query2  = "UPDATE board SET passwd='$new_pass' WHERE id='$admin_id' ";
    $result2 = mysqli_query($connect, $query2);

    // 저장과정에서 오류가 발생하면
    if (!$result) {
        err_msg('DB 오류가 발생했습니다.');
    } else if (!result2) {
        err_msg('게시판 비밀번호 수정 중 DB 오류가 발생했습니다.');
    } else {
        $msg = "비밀번호를 정상적으로 수정했습니다.";
        msg($msg);

        $re_url = "http://www." . $_SERVER['SERVER_NAME'] . "/admin/setting/admin_setup.php";
        redirect($re_url);
    }

} else {
    /////////// 인감 등록하기
    $res = mysqli_query($connect, "SELECT * FROM admin_setup");
    $row = mysqli_fetch_array($res);

    if ($_FILES['sign_image']['name']) {
        $file_ext1 = substr(strrchr($_FILES['sign_image']['name'], "."), 1);
        $file_ext1 = strtolower($file_ext1);

        if ($file_ext1 != 'jpg' && $file_ext1 != 'gif' && $file_ext1 != 'jpeg' && $file_ext1 != 'png') {
            err_msg("이미지 파일만 올릴 수 있습니다.");
        }
        if (!$_FILES['sign_image']['size']) {
            err_msg("지정한 파일(소)이 없거나 파일 크기가 0KB입니다.");
        }

        if ($row['sign_image'] == "Y") {
            unlink($row['sign_image_name']);
        }

        $savedir    = "../images";
        $savedir2   = "../../images";
        $sign_image = "Y";
        $temp1      = $savedir . "/sign/" . $_FILES['sign_image']['name'];
        $temp2      = $savedir2 . "/sign/" . $_FILES['sign_image']['name'];

        move_uploaded_file($_FILES['sign_image']['tmp_name'], $temp1);
        copy($temp1, $temp2); // /images/sign 으로 인감복사
    } else {
        if ($row['sign_image'] == "Y") {
            $sign_image = "Y";
            $temp1      = $row['sign_image_name'];
        } else {
            $sign_image = "N";
            $temp1      = "";
        }
    }

    /////////// 인감 등록하기 끝

    ########## 어드민 테이블에 입력값을 등록한다. ##########
    $query = "UPDATE admin_setup SET
					type = '1',
					site_name = '$site_name',
					keywords = '$keywords',
					description = '$description',
					company_name = '$company_name',
					homepage = '$homepage',
					email = '$admin_email',
					privacy_manager = '$privacy_manager',
					name = '$admin_name',
					license_no = '$license_no',
					online_license = '$online_license',
					ceo = '$ceo',
					category1 = '$category1',
					category2 = '$category2',
					tel = '$tel',
					fax = '$fax',
					zipcode = '$zipcode',
					addr1 = '$addr1',
					addr2 = '$addr2',
					sign_image='$sign_image',
					sign_image_name='$temp1',
					bank='$bank'
					WHERE id='$admin_id' ";

    $result = mysqli_query($connect, $query);

    // 저장과정에서 오류가 발생하면
    if (!$result) {
        err_msg('수정사항 저장 시 DB 오류가 발생했습니다.');
    } else {
        $msg = "정상적으로 수정했습니다.";
        msg($msg);

        $re_url = "http://" . $_SERVER['SERVER_NAME'] . "/admin/setting/admin_setup.php";
        redirect($re_url);

    }

}
