<?php include_once '../include/header.php';?>

<?php

$mode     = set_var($_GET['mode']);
$main_no  = set_var($_GET['main_no']);
$reply_no = set_var($_GET['reply_no']);
$code     = set_var($_GET['code']);

?>
    <!-- HOME -->
    <div class="container">
        <div class="row text-center">
            <h1>글 삭제</h1>
        </div>
    </div>
    <!-- /.home -->

    <!-- CONTAINER -->
    <div class="container">
        <form name="delete_form" action="delete_ok.php" method="post" class="form-group">
            <input type="hidden" name="mode"      value="<?php echo $mode; ?>" />
            <input type="hidden" name="main_no"   value="<?php echo $main_no; ?>" />
            <input type="hidden" name="reply_no"  value="<?php echo $reply_no; ?>" />
            <input type="hidden" name="code"      value="<?php echo $code; ?>" />
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <label for="passwd">로그인 비밀번호: </label>
                    <input type="password" class="form-control" name="passwd">
                </div>
            </div>
            <div class="row text-center margin-top-10">
                <div class="col-md-4 col-md-offset-4">
                    <a class="btn btn-primary" href="list.php?code=<?php echo $code; ?>" >목록</a>
                    <a class="btn btn-danger" href="#" onclick="javascript:send();"><i class="fa fa-trash-o"></i>삭제</a>
                    <a class="btn btn-primary" href="read.php?code=<?php echo $code; ?>&amp;main_no=<?php echo $main_no; ?>" >취소</a>
                </div>
            </div>
        </form>
    </div>
    <!-- /.containder -->

<!-- FOOTER -->
<?php include_once '../include/brands.php';?>

<?php include_once '../include/footer.php';?>

        <script>
        function send()  {
            var x = window.confirm("정말 삭제하시겠습니까?");

            if(x) {
             document.delete_form.submit();
            }
            else {
            document.location.replace("read.php?code=<?php echo $code; ?>&amp;main_no=<?php echo $main_no; ?>");
            }
         }

        </script>
    </body>
</html>
