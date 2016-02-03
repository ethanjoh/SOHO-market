<?php

include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

$query  = "SELECT * FROM products WHERE num='$p_num'";
$result = mysqli_query($connect, $query);
$row    = mysqli_fetch_array($result);
mysqli_free_result($result);

//작은 이미지가 있으면 삭제
if ($row['s_image'] == 'Y') {
    unlink($row['s_image_name']);
}
if ($row['b_image1'] == 'Y') {
    unlink($row['b_image1_name']);
}
if ($row['b_image2'] == 'Y') {
    unlink($row['b_image2_name']);
}
if ($row['b_image3'] == 'Y') {
    unlink($row['b_image3_name']);
}
if ($row['b_image4'] == 'Y') {
    unlink($row['b_image4_name']);
}
if ($row['b_image5'] == 'Y') {
    unlink($row['b_image5_name']);
}
if ($row['d_image'] == 'Y') {
    unlink($row['d_image_name']);
}

// 해당데이타 삭제
$query = "DELETE FROM products WHERE num=$p_num";
mysqli_query($connect, $query);

// 리스트로 이동
echo ("<meta http-equiv='refresh' content='0; URL=top_pro_list.php?lcode=$lcode&amp;mcode=$mcode&amp;scode=$scode&amp;page=$page'>");
