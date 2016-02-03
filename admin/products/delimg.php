<?php

include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

$query  = "SELECT * FROM products WHERE prod_code='$prod_code' ";
$result = mysqli_query($connect, $query);
$row    = mysqli_fetch_array($result);

if ($img == 'b1') {
    $s = unlink($row['s_image_name']);
    $b = unlink($row['b_image1_name']);

    if ($s && $b) {
        $update = "UPDATE products SET s_image='N', s_image_name='',
														  b_image1='N', b_image1_name='' WHERE prod_code='$prod_code' ";
        $result = mysqli_query($connect, $update);

        msg('이미지를 삭제했습니다');

    } else {
        err_msg('해당 파일이 없습니다.');
    }
} else if ($img == 'b2') {
    $b = unlink($row['b_image2_name']);

    if ($b) {
        $update = "UPDATE products SET b_image2='N', b_image2_name='' WHERE prod_code='$prod_code' ";
        $result = mysqli_query($connect, $update);

        msg('이미지를 삭제했습니다');

    } else {
        err_msg('해당 파일이 없습니다.');
    }
} else if ($img == 'b3') {
    $b = unlink($row['b_image3_name']);

    if ($b) {
        $update = "UPDATE products SET b_image3='N', b_image3_name='' WHERE prod_code='$prod_code' ";
        $result = mysqli_query($connect, $update);

        msg('이미지를 삭제했습니다');

    } else {
        err_msg('해당 파일이 없습니다.');
    }
} else if ($img == 'b4') {
    $b = unlink($row['b_image4_name']);

    if ($b) {
        $update = "UPDATE products SET b_image4='N', b_image4_name='' WHERE prod_code='$prod_code' ";
        $result = mysqli_query($connect, $update);

        msg('이미지를 삭제했습니다');

    } else {
        err_msg('해당 파일이 없습니다.');
    }
} else if ($img == 'b5') {
    $b = unlink($row['b_image5_name']);

    if ($b) {
        $update = "UPDATE products SET b_image5='N', b_image5_name='' WHERE prod_code='$prod_code' ";
        $result = mysqli_query($connect, $update);

        msg('이미지를 삭제했습니다');

    } else {
        err_msg('해당 파일이 없습니다.');
    }
}

echo "<meta http-equiv='refresh' content='0; URL=pro_register.php?mode=update&amp;prod_code=$prod_code&amp;lcode=$lcode&amp;mcode=$mcode&amp;scode=$scode&amp;page=$page'>";
