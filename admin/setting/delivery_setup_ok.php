<?php

include_once "../include/admin_auth.php";
include_once "../../util/util.php";

$mode            = set_var($_POST['mode']);
$admin_id        = set_var($_POST['admin_id']);
$logistics       = set_var($_POST['logistics']);
$delivery_charge = set_var($_POST['delivery_charge']);
$min_sum         = set_var($_POST['min_sum']);
$delivery_policy = set_var($_POST['delivery_policy']);
$refund_policy   = set_var($_POST['refund_policy']);

$delivery_policy = addslashes($delivery_policy);
$refund_policy   = addslashes($refund_policy);

if ($mode == 'insert') {
    $query = "INSERT INTO misc_setup (id,
									 logistics,
									 d_charge,
									 min_sum,
									 d_policy,
									 r_policy)
	                VALUES('$admin_id',
							'$logistics',
							'$min_sum',
							'$delivery_charge',
							'$delivery_policy',
							'$refund_policy')";

    $result = mysqli_query($connect, $query);

    // 저장과정에서 오류가 발생하면
    if (!$result) {
        err_msg('설정 중 데이터베이스 오류가 발생하였습니다.');
    } else {
        $msg = "정상적으로 설정했습니다.";
        msg($msg);

        $re_url = "delivery_setup.php";
        redirect($re_url);

        // echo("<meta http-equiv='content-type' content='text/html; charset=UTF-8' />
        //     <script>
        //    window.alert('정상적으로 설정하였습니다.');
        //    </script>");
        // echo "<meta http-equiv='Refresh' content='0; URL= top_setting.php'>";
    }

} else if ($mode == 'update') {
    $query = "UPDATE misc_setup SET
									logistics = '$logistics',
									d_charge = '$delivery_charge',
									min_sum = '$min_sum',
									d_policy = '$delivery_policy',
									r_policy = '$refund_policy'
					WHERE id='$admin_id' ";

    $result = mysqli_query($connect, $query);

    // 저장과정에서 오류가 발생하면
    if (!$result) {
        err_msg('수정 중 데이터베이스 오류가 발생하였습니다.');
    } else {

        $msg = "정상적으로 수정했습니다.";
        msg($msg);

        $re_url = "delivery_setup.php";
        redirect($re_url);

        // echo("<meta http-equiv='content-type' content='text/html; charset=UTF-8' />
        //       <script>
        //    window.alert('정상적으로 수정하였습니다.');
        //    </script>");
        // echo "<meta http-equiv='Refresh' content='0; URL= top_setting.php'>";
    }
}
