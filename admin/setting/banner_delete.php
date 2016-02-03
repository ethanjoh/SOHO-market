<?php
include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

$query  = "SELECT * FROM banner WHERE num=$num";
$result = mysqli_query($connect, $query);
$row    = mysqli_fetch_array($result);
mysqli_free_result($result);

if ($row['m_banner1'] == "Y" && file_exists($row['m_banner1_image'])) {
    unlink($row['m_banner1_image']);
}

if ($row['m_banner2'] == "Y" && file_exists($row['m_banner2_image'])) {
    unlink($row['m_banner2_image']);
}

if ($row['m_banner2'] == "Y" && file_exists($row['m_banner2_image'])) {
    unlink($row['m_banner2_image']);
}

$result1 = mysqli_query($connect, "DELETE FROM banner WHERE num=$num");

if ($result1) {
    echo ("<meta http-equiv='content-type' content='text/html; charset=UTF-8' />
       <script>
	    window.alert('배너를 삭제했습니다.')
	   </script>
	  ");
    echo "<meta http-equiv='Refresh' content='0; URL=banner_list.php'>";
} else {
    err_msg('배너 삭제 중 DB오류가 발생했습니다.');
}
