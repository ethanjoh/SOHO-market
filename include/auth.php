<?php
// 미로그인
if (!(isset($_SESSION['p_id'])) || !(isset($_SESSION['p_name']))) {
    header("Location: http://" . $_SERVER['SERVER_NAME'] . "/member/login.php");
}

