<?php

include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

$term   = $_GET["term"];
$sql    = "SELECT * FROM member WHERE company_name LIKE '%$term%'";
$result = mysqli_query($connect, $sql);
while ($data = mysqli_fetch_array($result)) {
    $arr[] = array("label" => $data['company_name'], "value" => $data['company_name']);
}

echo json_encode($arr);
// mysqli_close($result);
