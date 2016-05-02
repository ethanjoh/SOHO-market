<?php

include_once "../include/admin_auth.php";
include_once "../../util/util.php";

$m_num = set_var($_GET['m_num']);
$from  = set_var($_GET['from']);
$page  = set_var($_GET['page']);

$query  = "SELECT * FROM p_member WHERE seq_num='$m_num' ";
$result = mysqli_query($connect, $query);
$rows   = mysqli_fetch_array($result);

//마일리지 정보 삭제
$query1  = "SELECT * FROM mileage WHERE id_fk='$rows[id]' ";
$result1 = mysqli_query($connect, $query1);
$rows1   = mysqli_fetch_array($result1);

//회원정보 삭제
$query2 = "DELETE FROM p_member WHERE seq_num='$m_num' ";
mysqli_query($connect, $query2);

msg('업체정보를 삭제했습니다.');

if ($from == "mail") {
    echo "<meta http-equiv='content-type' content='text/html; charset=UTF-8' />
    <script>
      window.close()
    </script>";
} else {
    header("Location: p_top_member_list.php?page=" . $page . "");
}
