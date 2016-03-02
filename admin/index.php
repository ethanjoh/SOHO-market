<?php
include_once "../util/util.php";

$connect    = my_connect($host, $dbid, $dbpass, $dbname);
$info_query = "SELECT * FROM admin_setup";
$info_res   = mysqli_query($connect, $info_query);
$info       = mysqli_fetch_array($info_res);

$root_cookie = (isset($_COOKIE['save_id']) ? $_COOKIE['ROOT_ID'] : '');
$save_cookie = (isset($_COOKIE['save_id']) ? 'checked' : '');

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
        <title><?php echo $info['site_name'];?> 관리자 홈</title>
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
            <form role="form" class="form-signin" action="//<?php echo $_SERVER['SERVER_NAME'];?>:<?php echo $port;?>/admin/check_login.php" method="post" name="login" onsubmit="return chkLogin(this);">
                <!-- <form role="form" class="form-signin" action="http://<?php echo $_SERVER['SERVER_NAME'];?>/admin/check_login.php" method="post" name="login" onsubmit="return chkLogin(this);"> -->
                <div class="form-signin-heading">
                    <img src="/images/shinsoo-logo.svg" class="admin-logo">
                </div>
                <h3 class="text-center">ADMIN LOGIN</h3>
                <div class="login-wrap">
                    <input name="admin_id" id="admin_id" type="text" class="form-control" value="<?php echo $root_cookie; ?>" placeholder="관리자 ID" autofocus>
                    <input name="admin_pass" id="admin_pass" type="password" class="form-control" placeholder="비밀번호">
                    <label class="checkbox">
                        <input type="checkbox" name="save_id" id="save_id" <?php echo $save_cookie; ?> > 아이디 저장
                    </label>
                    <button class="btn btn-lg btn-login btn-block" type="submit">로그인</button>
                </div>
            </form>
        </div>
        <!-- js placed at the end of the document so the pages load faster -->
        <script src="/js/vendor/jquery-2.2.0.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/admin/js/admin.js"></script>
    </body>
</html>