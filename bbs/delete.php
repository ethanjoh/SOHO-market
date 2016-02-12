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
            <input type="hidden" name="mode"      value="<?=$mode;?>" />
            <input type="hidden" name="main_no"   value="<?=$main_no;?>" />
            <input type="hidden" name="reply_no"  value="<?=$reply_no;?>" />
            <input type="hidden" name="id"        value="<?=$_SESSION['p_id'];?>" />
            <input type="hidden" name="code"      value="<?=$code;?>" />
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <label for="passwd">비밀번호 (게시판 관리 비밀번호): </label>
                    <input type="password" class="form-control" name="passwd">
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-4 col-md-offset-4">
                    <a class="btn btn-primary" href="list.php?code=<?=$code;?>" >목록</a>
                    <a class="btn btn-danger" href="#" onclick="javascript:send();"><i class="fa fa-trash-o"></i>삭제</a>
                    <a class="btn btn-primary" href="read.php?code=<?=$code;?>&amp;main_no=<?=$main_no;?>" >취소</a>
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

          if(x = true)
             document.delete_form.submit();
                else
            document.location.replace("read.php?code=<?=$code;?>&amp;main_no=<?=$main_no;?>");
        }
        </script>
    </body>
</html>
