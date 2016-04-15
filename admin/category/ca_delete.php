<?php

include_once "../include/admin_auth.php";
include_once "../../util/util.php";

$num = set_var($_GET['num']);

$query  = "SELECT * FROM products_category1 WHERE num='$num' ";
$result = mysqli_query($connect, $query);
$row    = mysqli_fetch_array($result);

// $query1 = "DELETE FROM products WHERE id='$row[id]'";
// mysqli_query($connect, $query1);

$query2 = "UPDATE products_category2 SET del='Y' WHERE up_category='$row[code]' ";
mysqli_query($connect, $query2);

$query3 = "UPDATE products_category1 SET del='Y' WHERE num='$num' ";
mysqli_query($connect, $query3);

// $query4 = "DELETE FROM supplier WHERE id='$row[id]' ";
// mysqli_query($connect, $query3);

header("Location: top_ca_list.php");
