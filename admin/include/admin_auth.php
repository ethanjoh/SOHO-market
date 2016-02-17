<?php

if (!isset($_COOKIE['ROOT_ID']) && !isset($_COOKIE['ROOT_PASS'])) {
    $msg = "로그인 하시기 바랍니다.";
    $url = "/admin/index.php";

    echo "<meta HTTP-EQUIV='CONTENT-TYPE' content='text/html;charset=UTF-8'>
			<script language=\"JavaScript\">
	          alert(\"$msg\");
             document.location.replace(\"$url\");
            </script>";

    exit;
}
