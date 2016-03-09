<?php

include_once "../include/admin_auth.php";
include_once "../../util/util.php";

// »иБ¦ЗП°нАЪ ЗПґВ Д«ЕЧ°нё®АЗ ДЪµе°ЄА» ±ёЗФ
$query  = "select * from products_category1 where id='$num' ";
$result = mysqli_query($connect, $query);
$row    = mysqli_fetch_array($result);
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
