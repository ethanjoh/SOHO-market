<footer class="footer ">
    <!-- CONTAINER -->
    <div class="container ftop text-center">
        <a href="index.php"><img src="../images/s-medics-logo.png" class="main-logo-bottom"></a><br>
        <div class="row foorow-3 foorow">
            <div class="col-md-12 col-sm-12 footer-addr text-center">
                <span>#208, Mukdong Xii, 6-9, Suksun Ongjuro, Jungrang-gu, Seoul, Korea / <i class="fa fa-envelope-o"></i> <a href="mailto:<?=$info['email'];?>">E-mail</a></span><br>
                T: +82-2-3437-8891 / F: +82-2-3437-8890
            </div>
        </div>
    </div>
    <!-- /.container -->
</footer>
<!-- /.footer -->
<!-- Popup: Login -->
<?php
//로그인 이전의 URL로 돌아가기
$uri = $_SERVER["REQUEST_URI"];
$uri = urlencode($uri);
?>
<div class="block-popup popup plogin" id="login">
    <a href="" class="pclose small"><i class="custom-icon custom-icon-close-s"></i></a>
    <h3 class="text-center">Login to account</h3>
    <form method="post" name="login" class="loginform" action="https://<?=$_SERVER['SERVER_NAME'];?>:<?=$port;?>/member/login_ok.php" onsubmit="return(login_check());">
        <input type="hidden" name="uri" value="<?=$uri;?>">
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
                <input type="checkbox" name="msave_all" value="">
                Remember me
            </label>
        </div>
        <div class="form-group text-center">
            <button type="submit" class="btn btn-success block">Login</button>
            <a href="">Forgot password?</a>
        </div>
    </form>
    <div class="footlogin highlight text-center">
        <p><a href="/member/register.php" class="btn btn-default btn-xs">Join</a></p>
    </div>
</div>
<!-- /.popup -->
<!-- ScrollTop Button -->
<a href="#" class="scrolltop">
    <i class="custom-icon custom-icon-scrolltop"></i>
</a>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-72068650-1', 'auto');
  ga('send', 'pageview');

</script>