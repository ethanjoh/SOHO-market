<?php
include "../util/config.php";
include "../util/util.php";

$connect = my_connect($host,$dbid,$dbpass,$dbname);

if(!$_COOKIE[p_sid]){
    $SID = md5(uniqid(rand()));
    SetCookie("p_sid",$SID,0,"/");
}

$info_query = "SELECT * FROM admin_setup";
$info_res = mysqli_query($connect, $info_query);
$info = mysqli_fetch_array($info_res);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <meta name="keywords" content="<?=$info['keywords']?>" />
    <meta name="description" content="<?=$info['description']?>" />
    <title><?=$info['site_name']?></title>
    <link href="favicon.ico" rel="shortcut icon" type="image/x-icon">
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

    <!-- smart editor -->
    <!-- <link href="css/smart_editor2.css" rel="stylesheet" type="text/css" /> -->

</head>
<body>

<!-- Preloader -->
<div id="preloader">
    <div id="status">&nbsp;</div>
</div>

<!-- WRAPPER -->
<div class="wrapper">

    <!-- HEADER -->
    <?php include "../include/header.php"; ?>
    <!-- /.header -->

    <!-- HOME -->
    <div class="overlay home medium-size">
        <div class="bg bg-help" data-stellar-background-ratio="0.5"></div>
        <div class="container vmiddle">
            <div class="row text-center">
                <div class="icon-big color icon-bag-shopping-streamline"></div>
                <h1>NOTICE</h1>
            </div>
        </div>
    </div>
    <!-- /.home -->

    <!-- CONTENT -->
    <div class="content">

        <!-- CONTAINER -->
        <div class="container">
          <form name="delete_form" action="delete_ok.php" method="post" class="form-group">
            <input type="hidden" name="mode"      value="<?=$mode?>" />
            <input type="hidden" name="main_no"   value="<?=$main_no?>" />
            <input type="hidden" name="reply_no"  value="<?=$reply_no?>" />
            <input type="hidden" name="id"        value="<?=$_SESSION['p_id']?>" />
            <input type="hidden" name="code"      value="<?=$code?>" />

            <div class="row">
              <div class="col-md-4 col-md-offset-4">
                  <label for="passwd">비밀번호 (게시판 관리 비밀번호): </label>
                  <input type="password" class="form-control" name="passwd">
              </div>
            </div>
            <div class="row text-center">
              <div class="col-md-4 col-md-offset-4">
                <a class="btn btn-primary btn-xs" href="list.php?code=<?=$code?>" >목록</a> 
                <a class="btn btn-danger btn-xs" href="#" onclick="javascript:send();"><i class="fa fa-trash-o"></i>삭제</a> 
                <a class="btn btn-primary btn-xs" href="read.php?code=<?=$code?>&amp;main_no=<?=$main_no?>" >취소</a> 
              </div>
            </div>
          </form>
        </div>
        <!-- /.containder -->

    </div>
    <!-- /.content -->
</div>
<!-- /.wrapper -->

<!-- FOOTER -->
<?php include"../include/footer.php"; ?>


<script src="../js/jquery-2.1.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery.plugins.js"></script>
<script src="../js/custom.js"></script>
<script src="../js/global.js"></script>
<script src="../js/member.js"></script>
<script src="js/HuskyEZCreator.js" charset="utf-8"></script>
<!-- smart editor end -->
<script>
function send()  {
  var x = window.confirm("정말 삭제하시겠습니까?");

  if(x = true)
     document.delete_form.submit();
        else
    document.location.replace("read.php?code=<?=$code?>&amp;main_no=<?=$main_no?>");
}
</script>
</body>
</html>
