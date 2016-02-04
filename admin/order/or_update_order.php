<?php
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect = my_connect($host, $dbid, $dbpass, $dbname);

$mod_volume = set_var($_POST['mod_volume']);
$mod_price  = set_var($_POST['mod_price']);
$oid        = set_var($_POST['oid']);
$page       = set_var($_POST['page']);
$mode       = set_var($_POST['mode']);
$key        = set_var($_POST['key']);
$key_value  = set_var($_POST['key_value']);
$t_cost     = set_var($_POST['t_cost']);
$s_cost     = set_var($_POST['s_cost']);
$trans_cost = set_var($_POST['trans_cost']);
$from       = set_var($_POST['from']);

$temp_count = '';
$temp_price = '';

if ($mode == "up_tcost") {
    $query  = "UPDATE mall_order SET delivery_cost='$t_cost', trans_cost='$trans_cost' WHERE num = '$oid' ";
    $result = mysqli_query($connect, $query);

} else if ($mode == "up_scost") {
    $query  = "UPDATE mall_order SET ship_cost='$s_cost', trans_cost='$trans_cost' WHERE num = '$oid' ";
    $result = mysqli_query($connect, $query);
} else {
    for ($i = 0; $i < sizeof($mod_volume); $i++) {
        if ($i != 0) {
            $temp_count .= ",";
        }
        $temp_count .= $mod_volume[$i];
    }

    for ($i = 0; $i < sizeof($mod_price); $i++) {
        if ($i != 0) {
            $temp_price .= ",";
        }
        $temp_price .= $mod_price[$i];
    }

    $query = "UPDATE mall_order SET mod_count='$temp_count', mod_price='$temp_price'
					WHERE num = '$oid' ";

    $result = mysqli_query($connect, $query);
}

if (!$result) {
    err_msg('수정 중 DB 오류가 발생했습니다.');
} else if ($from != "quot") {
    echo "<meta http-equiv='content-type' content='text/html; charset=UTF-8' />
   			<script>
   				alert('변경완료')
			</script>
   			<meta http-equiv='Refresh' content='0; URL=or_view.php?mode=$mode&oid=$oid&key=$key&key_value=$key_value&page=$page'>";
} else {
    echo "<meta http-equiv='content-type' content='text/html; charset=UTF-8' />
   			<script>
   				alert('변경완료')
			</script>
   			<meta http-equiv='Refresh' content='0; URL=or_quot_view.php?$mode&oid=$oid&key=$key&key_value=$key_value&page=$page'>";
}
