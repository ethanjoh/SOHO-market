<?php
include_once "../include/admin_auth.php";
include_once "../../util/util.php";

$mode = set_var($_GET['mode']);
$num  = set_var($_GET['num']);

if ('main' == $pos) {
    $j = 5;
} elseif ('top' == $pos) {
    $j = 3;
} elseif ('middle' == $pos) {
    $j = 2;
} elseif ('bottom' == $pos) {
    $j = 1;
}

// if ("main" == $mode) {
$query  = "SELECT * FROM main_banner WHERE num='$num'";
$result = mysqli_query($connect, $query);
$row    = mysqli_fetch_array($result);
mysqli_free_result($result);

for ($i = 1; $i <= $j; $i++) {

    $file = 'm_banner' . $i . '_image';
    $flag = 'm_banner' . $i;

    if ($row['flag'] == "Y") {
        if (file_exists($row['file'])) {
            if (is_writable($row['file'])) {
                unlink($row['file']);
            }
        }
    }
}

// if ($row['m_banner2'] == "Y") {
//     if (file_exists($row['m_banner2_image'])) {
//         if (is_writable($row['m_banner2_image'])) {
//             unlink($row['m_banner2_image']);
//         }
//     }
// }

// if ($row['m_banner3'] == "Y") {
//     if (file_exists($row['m_banner3_image'])) {
//         if (is_writable($row['m_banner3_image'])) {
//             unlink($row['m_banner3_image']);
//         }
//     }
// }

// if ($row['m_banner4'] == "Y") {
//     if (file_exists($row['m_banner4_image'])) {
//         if (is_writable($row['m_banner4_image'])) {
//             unlink($row['m_banner4_image']);
//         }
//     }
// }

// if ($row['m_banner5'] == "Y") {
//     if (file_exists($row['m_banner5_image'])) {
//         if (is_writable($row['m_banner5_image'])) {
//             unlink($row['m_banner5_image']);
//         }
//     }
// }

$qry = "DELETE FROM banner WHERE num='$num'";
$res = mysqli_query($connect, $qry);

if ($res) {
    $msg = "배너를 삭제했습니다.";
    $url = "banner_list.php";

    show_msg($msg, $url);
} else {
    err_msg('메인배너 삭제 중 DB오류가 발생했습니다.');
}
// }
