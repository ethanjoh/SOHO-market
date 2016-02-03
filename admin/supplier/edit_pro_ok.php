<?php
include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

$oid     = set_var($_POST['oid']);
$from    = set_var($_POST['from']);
$id      = set_var($_POST['id']);
$lcode   = set_var($_POST['lcode']);
$mcode   = set_var($_POST['mcode']);
$scode   = set_var($_POST['scode']);
$p_num   = set_var($_POST['p_num']);
$del_chk = set_var($_POST['del_chk']);

$optname      = set_var($_POST['optname']);
$optstock     = set_var($_POST['optstock']);
$barcode      = set_var($_POST['barcode']);
$stock        = set_var($_POST['stock']);
$restock_date = set_var($_POST['restock_date']);
$no_restock   = set_var($_POST['no_restock']);

for ($i = 0; $i < sizeof($optstock); $i++) {
    if ($i != 0) {
        $temp_stock .= ",";
    }
    $temp_stock .= $optstock[$i];
}

// 상품 업데이트
if ($optname) {
    $opt = implode(",", $optname);
    //$opt_stock = implode(",", $temp_stock);
    $opt_stock = $temp_stock;
    $barcode   = implode(",", $barcode);
}

if ($del_chk == "O" || $del_chk == "C") {
    $stock = "0";
}

//재입고일이 미정일 경우
if ($no_restock == "Y") {
    $restock_date = "1111-00-00";
}

$dbinsert1 = "UPDATE products SET tag='$tag',
								opt='$opt',
								 opt_stock = '$opt_stock',
								 barcode = '$barcode',
								 stock='$stock',
								 del_chk='$del_chk',
								 modified = now(),
								 restock_date = '$restock_date'
			  WHERE num='$p_num' ";
$result1 = mysqli_query($connect, $dbinsert1);

if ($result1) {
    if ($from == "pre_offer") {
        $url = "edit_pro.php?id=$id&p_num=$p_num&lcode=$lcode&mcode=$mcode&scode=$scode&from=$from";
        show_msg('상품 등록정보를 수정했습니다.', $url);
    } else
    //$url = "edit_pro.php?oid=$oid&p_num=$p_num&lcode=$lcode&mcode=$mcode&scode=$scode";
    {
        show_msg_close('상품 등록정보를 수정했습니다.');
    }

} else {
    err_msg('상품 수정 중 DB오류가 발생했습니다.');
}
