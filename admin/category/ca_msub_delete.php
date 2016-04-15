<?php

include_once "../include/admin_auth.php";
include_once "../../util/util.php";

$id    = set_var($_GET['id']);
$lcode = set_var($_GET['lcode']);

// 삭제하고자 하는 카테고리의 코드값을 구함
// $query  = "SELECT * FROM products_category2 WHERE id='$id' ";
// $result = mysqli_query($connect, $query);
// $row    = mysqli_fetch_array($result);

// $code = $row['code'];

//카테고리에 속하는 상품정보 삭제
// $query1 = "DELETE FROM products WHERE l_category_fk='$code' ";
// mysqli_query($connect, $query1);

// 자신을 지움
$query = "UPDATE products_category2 SET del='Y' WHERE id='$id' ";
mysqli_query($connect, $query);

// echo ("<meta http-equiv='refresh' content='0; URL=ca_msub_list.php?lcode=$lcode'>");
header("Location: ca_msub_list.php?lcode=" . $lcode . "");
