<?php
include_once "../include/admin_auth.php";
include_once "../../util/util.php";

$pos = set_var($_GET['pos']);
$num = set_var($_GET['num']);

// $saveDir = "../../images/banner/";

if ($pos == 'main') {
    $j = 5;
} elseif ($pos == 'top') {
    $j = 3;
} elseif ($pos == 'middle') {
    $j = 2;
} elseif ($pos == 'bottom') {
    $j = 1;
}

// if ("main" == $mode) {
$query  = "SELECT * FROM banner WHERE num='$num'";
$result = mysqli_query($connect, $query);
$row    = mysqli_fetch_array($result);
mysqli_free_result($result);

for ($i = 1; $i <= $j; $i++) {

    $file = 'm_banner' . $i . '_image';
    $flag = 'm_banner' . $i;

    if ($row[$flag] == "Y") {
        if (file_exists($row[$file])) {
            if (is_writable($row[$file])) {
                unlink($row[$file]);
            }
        }
    }
}

$qry = "DELETE FROM banner WHERE num='$num'";
$res = mysqli_query($connect, $qry);

if ($res) {
    $msg = "배너를 삭제했습니다.";
    $url = "banner_list.php";

    show_msg($msg, $url);
} else {
    err_msg('배너 삭제 중 DB오류가 발생했습니다.');
}
// }
