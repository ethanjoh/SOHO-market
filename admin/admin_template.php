<?php

include_once "../include/admin_auth.php";
include_once "../util/config.php";
include_once "../util/util.php";
// MySQL 연결
$connect = my_connect($host, $dbid, $dbpass, $dbname);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<title>B2B SCM</title>
<meta charset="UTF-8" />
<link rel="stylesheet" href="css/admin_layout.css" />
<script src="../js/global.js" ></script>
<script src="js/admin.js" ></script>
</head>
<body>
<!-- wrapper -->
<div id="wrapper">
  <!-- header -->
  <?php
include "include/admin_top.php";
?>
  <!-- header end -->

  <div id="bodyblock">
    <!-- contents -->
    <div id="content"> 관리자 어드민 초기화면입니다.
    </div>
    <!-- contents end -->
  </div><!-- bodyblock end -->

  <!-- copyright -->
  <?php
include "include/admin_bottom.php";
?>
  <!-- copyright  end -->
</div>
<!-- wrapper end -->
</body>
</html>
