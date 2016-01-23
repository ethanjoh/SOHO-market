<?php

//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);


// »иБ¦ЗП°нАЪ ЗПґВ Д«ЕЧ°нё®АЗ ДЪµе°ЄА» ±ёЗФ
$query = "select * from products_category1 where id='$num' ";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_array($result);
mysqli_free_result($result);


//Д«ЕЧ°нё®їЎ јУЗПґВ »уЗ°Б¤єё »иБ¦
$query1 = "delete from products where id='$row[id]'";
mysqli_query($connect, $query1);

//ЗПА§ Д«ЕЧ°нё® Б¤єё »иБ¦
$query2 = "delete from products_category2 where code='$row[code]' ";
mysqli_query($connect, $query2);

// АЪЅЕА» Бцїт
$query3 = "delete from products_category1 where id='$row[id]' ";
mysqli_query($connect, $query3);

$query4 = "delete from supplier where id='$row[id]' ";
mysqli_query($connect, $query3);


echo ("<meta http-equiv='refresh' content='0; URL=top_ca_list.php'>");
?>
