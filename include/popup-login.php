<?php
//로그인 이전의 URL로 돌아가기
$uri = $_SERVER["REQUEST_URI"];
$uri = urlencode($uri);
?>

<div class="block-popup popup plogin" id="login">
    <a href="" class="pclose small"><i class="custom-icon custom-icon-close-s"></i></a>
    <h3 class="text-center">Login to account</h3>
    <!-- <form method='post' name='login' class="loginform" action='https://www.<?=$_SERVER['SERVER_NAME']?>:<?=$port?>/member/login_ok.php' onsubmit="JavaScript:return(login_check());"> -->
    <form method="post" name="loginform" class="loginform" action="http://<?=$_SERVER['SERVER_NAME']?>/member/login_ok.php">
      <input type="hidden" name="uri" value="<?=$uri?>">

        <div class="formwrap">
            <div class="form-group">
                <input type="text" class="form-control" name="id" placeholder="ID">
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control login-password" name="pwd" placeholder="Password" id="login-password">
            </div>
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" value="">
                Remember me
            </label>
        </div>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-default block">Login</button>
            <a href="">Forgot password?</a>
        </div>

    </form>
    <div class="footlogin highlight text-center">
        <p><a href="privacy_policy.html" class="a-privacy text-center">Privacy Policy</a></p>
    </div>
</div>
