<?php

include_once "../include/admin_auth.php";
include_once "../../util/util.php";

$p_num = set_var($_GET['p_num']);
$lcode = set_var($_GET['lcode']);
$mcode = set_var($_GET['mcode']);
// $scode = set_var($_GET['scode']);
$page = set_var($_GET['page']);

$query  = "SELECT * FROM products WHERE num='$p_num'";
$result = mysqli_query($connect, $query);
$row    = mysqli_fetch_array($result);

// ex) $imgPath = "../../upload/p_image/B068-02/b/4848_3.jpg"
// $dir = "../../upload/p_image/B068-02"
$imgPath = $row['b_image1_name'];
$dir     = reverse_strrchr($imgPath, '/');

// 서브디렉토리까지 모두 삭제
if (recurse_rmdir($dir)) {
    // 해당 상품데이타 삭제
    $query = "DELETE FROM products WHERE num='$p_num' ";
    mysqli_query($connect, $query);
    msg("상품 및 이미지를 삭제했습니다.");
} else {
    // 해당 상품데이타 삭제
    $query = "DELETE FROM products WHERE num='$p_num' ";
    mysqli_query($connect, $query);
    msg("상품을 삭제했습니다.");

}

// 리스트로 이동
// echo ("<meta http-equiv='refresh' content='0; URL=top_pro_list.php?lcode=$lcode&amp;mcode=$mcode&amp;page=$page'>");
header("Location: top_pro_list.php?lcode=" . $lcode . "&mcode=" . $mcode . "&page=" . $page . "");
