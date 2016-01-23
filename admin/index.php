<?php
include "../util/config.php";
include "../util/util.php";
$connect    = my_connect($host, $dbid, $dbpass, $dbname);
$info_query = "SELECT * FROM admin_setup";
$info_res   = mysqli_query($connect, $info_query);
$info       = mysqli_fetch_array($info_res);
?>
<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="keyword" content="">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <link rel="shortcut icon" href="img/favicon.png">
        <title><?=$info['site_name'];?> 관리자 홈</title>
        <!-- Bootstrap core CSS -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="css/bootstrap-reset.css" rel="stylesheet">
        <!--external css-->
        <link href="../css/font-awesome.min.css" rel="stylesheet" />
        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/style-responsive.css" rel="stylesheet" />
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="login-body">
        <div class="container">
            <form role="form" class="form-signin" action="//<?=$_SERVER['SERVER_NAME'];?>:<?=$port;?>/admin/check_login.php" method="post" name="login" onsubmit="return chkLogin(this);">
                <!-- <form role="form" class="form-signin" action="http://<?=$_SERVER['SERVER_NAME'];?>/admin/check_login.php" method="post" name="login" onsubmit="return chkLogin(this);"> -->
                <div class="form-signin-heading">
                    <img src="../img/logo/shinsoo-logo.svg" class="admin-logo">
                </div>
                <h3 class="text-center">ADMIN LOGIN</h3>
                <div class="login-wrap">
                    <input name="admin_id" id="admin_id" type="text" class="form-control" value="<?=$_COOKIE['save_id'] == "Y" ? $_COOKIE['ROOT_ID'] : "";?>" placeholder="Admin ID" autofocus>
                    <input name="admin_pass" id="admin_pass" type="password" class="form-control" placeholder="Password">
                    <label class="checkbox">
                        <input type="checkbox" name="save_id" id="save_id" <?=$_COOKIE['save_id'] == "Y" ? "checked" : "";?> > 아이디 저장
                    </label>
                    <button class="btn btn-lg btn-login btn-block" type="submit">로그인</button>
                </div>
            </form>
        </div>
        <!-- js placed at the end of the document so the pages load faster -->
        <script src="../js/vendor/jquery-1.11.3.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="js/admin.js"></script>
    </body>
</html>