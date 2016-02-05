<?php
include "../util/config.php";
include "../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

if (!$_COOKIE[p_sid]) {
    $SID = md5(uniqid(rand()));
    SetCookie("p_sid", $SID, 0, "/");
}

$info_query = "SELECT * FROM admin_setup";
$info_res   = mysqli_query($connect, $info_query);
$info       = mysqli_fetch_array($info_res);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <meta name="keywords" content="<?=$info['keywords'];?>" />
    <meta name="description" content="<?=$info['description'];?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?=$info['site_name'];?></title>
    <link href="favicon.ico" rel="shortcut icon" type="image/x-icon">
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

    <!-- smart editor -->
    <!-- <link href="css/smart_editor2.css" rel="stylesheet" type="text/css" /> -->
    <script type="text/javascript" src="js/HuskyEZCreator.js" charset="utf-8"></script>
    <!-- smart editor end -->
    <script language="JavaScript">
    <!--
        function send(id)
        {
            if (document.write_form.title.value.length <1) {
                alert("제목을 입력하십시오.");
                document.write_form.title.focus();
                return false;
            }
            //oEditors[0].exec("UPDATE_IR_FIELD", []);
            oEditors.getById[id].exec("UPDATE_CONTENTS_FIELD", []);
            document.write_form.submit();
        }
    -->
    </script>

</head>
<body>

<!-- Preloader -->
<div id="preloader">
    <div id="status">&nbsp;</div>
</div>

<!-- WRAPPER -->
<div class="wrapper">

    <!-- HEADER -->
    <?php include "../include/header.php";?>
    <!-- /.header -->

<?php

if ($mode == 'edit') {
    $board  = 'bbs_' . $code;
    $sql    = "SELECT * FROM $board WHERE main_no=$main_no ";
    $result = mysqli_query($connect, $sql);
    $row    = mysqli_fetch_array($result);

    if ($row['id'] != $_SESSION['p_id']) {
        $url = 'read.php?code=' . $code . '&main_no=' . $main_no;
        show_msg('본인이 작성한 글이 아닙니다.', $url);
    }

    //기존 첨부파일 여부 체크
    if (strlen($row['filename']) > 0) {
        $path = 'upload/' . $row['filename'];

        //Array 값으로 분리, [0]에는 "_"이전 값이, [1]에는 "_"이후 값이 들어있다.
        $chk_name = explode('_', $row['filename']);
        $old_file = $chk_name[sizeof($chk_name) - 1];
    }
} else if ($mode == 'reply') {
    $board = 'bbs_' . $code;
    $sql   = "SELECT * FROM $board WHERE main_no=$main_no ";

    $result = mysqli_query($connect, $sql);
    $row    = mysqli_fetch_array($result);
}

?>
   <!-- HOME -->
    <div class="overlay home medium-size">
        <div class="bg bg-shop" data-stellar-background-ratio="0.5"></div>
        <div class="container vmiddle">
            <div class="row text-center">
                <div class="icon-big color icon-bag-shopping-streamline"></div>
                <h1>HELP</h1>
            </div>
        </div>
    </div>
    <!-- /.home -->

    <!-- CONTENT -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="table-responsive">

                  <!-- <form name="write_form" method="post" ENCTYPE="multipart/form-data" action="https://www.<?=$_SERVER['SERVER_NAME'];?>:<?=$port;?>/bbs/post_ok.php"> -->
                  <form name="write_form" method="post" ENCTYPE="multipart/form-data" action="http://<?=$_SERVER['SERVER_NAME'];?>/bbs/post_ok.php">

                    <input type="hidden" name="mode" value="<?=$mode;?>" />
                    <input type="hidden" name="main_no" value="<?=$main_no;?>" />
                    <input type="hidden" name="code" value="<?=$code;?>" />
                    <input type="hidden" name="id" value="<?=$_SESSION['p_id'];?>" />
                    <input type="hidden" name="name" value="<?=$_SESSION['p_name'];?>" />
                    <table class="table">
                      <tbody>
                        <tr>
                          <td>이 름</td>
                          <td><?=$_SESSION['p_name'];?></td>
                        </tr>
                        <tr>
                          <td>이메일</td>
                          <td><input type="text" name="email" size="30" maxlength="30"  value="<?=$_SESSION['p_email'];?>"></td>
                        </tr>
                        <tr>
                          <td>제 목</td>
                          <td class="left"><?php
if ($mode == 'edit') {
    echo '<input type="text" name="title" size="50" maxlength="50" value="' . stripcslashes($row[title]) . '" /></td>\n';
} else {
    echo '<input type="text" name="title" size="50" maxlength="50" /></td>\n';
}
?>
                        </tr>
                        <tr>
                          <td>내 용</td>
                          <td><?php
if ($mode == 'edit') {
    echo "<div><textarea name=\"contents\" id=\"contents\" style=\"width:100%; height:300px\">$row[contents]</textarea></div>\n
            					<i class=\"fa fa-paperclip\"></i>파일 첨부 (20MB 이하)
                                <input type=\"file\" name=\"uploadedfile\" size=\"30\"><br/>\n
            					";
} else {
    echo "<div><textarea name=\"contents\" id=\"contents\" style=\"width:100%; height:300px\"></textarea></div>\n
            					<i class=\"fa fa-paperclip\"></i>파일 첨부 (20MB 이하)
                                <input type=\"file\" name=\"uploadedfile\" size=\"30\"><br/>\n";
}
?></td>
                        </tr>
                      </tbody>
                    </table>

                    <!-- 글쓰기 버튼 -->
                    <div class="row text-center">
                        <a class="btn btn-success btn-xs" href="#" onClick="javascript:send('contents');">작성하기</a> &nbsp;
                        <a class="btn btn-primary  btn-xs" href="list.php?code=<?=$code;?>">목 록</a>
                    </div>


                  </form>


          </div>
        </div>
      </div>
    </div>
    <!-- /.content -->
</div>
<!-- /.wrapper -->


<!-- FOOTER -->
<?php include "../include/footer.php";?>

<script src="../js/jquery-2.1.1.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDv0RLj_LBhRntn4AOCr4zHSYv0-F8gVeA&sensor=false"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery.plugins.js"></script>
<script src="../js/custom.js"></script>
<script src="../js/global.js"></script>
<script src="../js/member.js"></script>

<script>
var oEditors = [];
nhn.husky.EZCreator.createInIFrame({
    oAppRef: oEditors,
    elPlaceHolder: "contents",
    sSkinURI: "SmartEditor2Skin.html",
    htParams : {bUseToolbar : true,
        fOnBeforeUnload : function(){
            //alert("아싸!");
        }
    }, //boolean
    fOnAppLoad : function(){
        //예제 코드
        // oEditors.getById["contents"].exec("PASTE_HTML", ["* 세금계산서 신청은 계산서신청 게시판에 해주세요.(본 안내글은 삭제 후 작성해주세요.)"]);
    oEditors.getById["contents"].exec("PASTE_HTML", [""]);
    },
    fCreator: "createSEditor2"
});

function pasteHTMLDemo(id, sHTML){
    oEditors.getById[id].exec("PASTE_HTML", [sHTML]);
}
</script>

</body>
</html>

