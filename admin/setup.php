<?php
// 최종적으로 배포하기 전에는 보안을 위해 반드시 이 파일은 삭제
// 어드민 비밀번호 임시변경용임
include "../util/config.php";
include "../util/util.php";
$connect    = my_connect($host, $dbid, $dbpass, $dbname);
$info_query = "SELECT * FROM admin_setup";
$info_res   = mysqli_query($connect, $info_query);
$info       = mysqli_fetch_array($info_res);

if ($_POST) {
    $admin_pass = set_var($_POST['admin_pass']);
    $new_pass   = sha1($admin_pass);

########## 어드민 테이블에 입력값을 등록한다. ##########
    $query  = "UPDATE admin_setup SET passwd = '$new_pass' WHERE id='admin' ";
    $result = mysqli_query($connect, $query);

// 저장과정에서 오류가 발생하면
    if (!$result) {
        err_msg('DB 오류가 발생했습니다.');
    } else {
        $msg = "비밀번호를 정상적으로 수정했습니다.";
        msg($msg);

        $re_url = "index.php";
        redirect($re_url);
    }
}
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
        <title><?=$info['site_name'];?> 관리자 셋업</title>
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
            <form role="form" class="form-signin" action="setup.php" method="post" name="setup">
                <div class="form-signin-heading">
                    <img src="../img/logo/shinsoo-logo.svg" class="admin-logo">
                </div>
                <h3 class="text-center">ADMIN SETUP</h3>
                <div class="login-wrap">
                    <input name="admin_pass" id="admin_pass" type="password" class="form-control" placeholder="Password">
                    <button class="btn btn-lg btn-login btn-block" type="submit">저장</button>
                </div>
            </form>
        </div>
        <!-- js placed at the end of the document so the pages load faster -->
        <script src="../js/vendor/jquery-1.11.3.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="js/admin.js"></script>
    </body>
</html>