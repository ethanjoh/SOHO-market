<?php

include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

// 삭제하고자 하는 카테고리의 코드값을 구함
$query  = "select * from products_category2 where id=$id";
$result = mysqli_query($connect, $query);
$row    = mysqli_fetch_array($result);
mysqli_free_result($result);
$code = $row[code];

//카테고리에 속하는 상품정보 삭제
$query1 = "delete from products where l_category_fk='$code'";
mysqli_query($connect, $query1);

// 자신을 지움
$query = "delete from products_category2 where id=$id";
mysqli_query($connect, $query);

echo ("<meta http-equiv='refresh' content='0; URL=ca_msub_list.php?lcode=$lcode'>");
