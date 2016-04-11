<?php include_once '../include/header.php';?>

<?php

    $mode     = set_var($_GET['mode']);
    $p_id     = set_var($_SESSION['p_id']);
    $main_no  = set_var($_GET['main_no']);
    $code     = set_var($_GET['code']);
    $bbs_name = '';

    if ($mode == 'edit') {
        $board  = 'bbs_' . $code;
        $sql    = "SELECT * FROM $board WHERE main_no='$main_no' ";
        $result = mysqli_query($connect, $sql);
        $row    = mysqli_fetch_array($result);

        if ($row['id'] != $p_id) {
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

        $bbs_name = $row['title'];

    } else if ($mode == 'reply') {
        $board = 'bbs_' . $code;
        $sql   = "SELECT * FROM $board WHERE main_no='$main_no' ";

        $result = mysqli_query($connect, $sql);
        $row    = mysqli_fetch_array($result);

        $bbs_name = $row['title'];

    } else {
        $bqry1 = "SELECT * FROM code WHERE code='$code' ";
        $bres1 = mysqli_query($connect, $bqry1);
        $brow1 = mysqli_fetch_array($bres1);

        $bbs_name = $brow1['bbs_name'];
    }

    $protocol = check_protocol($sslPort);
?>

    <!-- HOME -->
    <div class="container">
        <div class="row text-center">
            <h1><?php echo $bbs_name; ?></h1>
        </div>
    </div>
    <!-- /.home -->



    <!-- CONTENT -->
        <div class="container">
            <div class="row">
                <div class="table-responsive">

                  <form name="write_form" method="post" ENCTYPE="multipart/form-data" action="<?php echo $protocol; ?>//<?php echo $_SERVER['SERVER_NAME']; ?>:<?php echo $sslPort; ?>/bbs/post_ok.php">
                    <input type="hidden" name="mode"    value="<?php echo $mode; ?>" />
                    <input type="hidden" name="main_no" value="<?php echo $main_no; ?>" />
                    <input type="hidden" name="code"    value="<?php echo $code; ?>" />
                    <input type="hidden" name="id"      value="<?php echo $p_id; ?>" />
                    <table class="table">
                      <tbody>
                        <tr>
                          <td>이 름</td>
                          <td><?php echo $_SESSION['p_name']; ?></td>
                        </tr>
                        <tr>
                          <td>이메일</td>
                          <td><input type="text" name="email" size="30" maxlength="30"  value="<?php echo $_SESSION['p_email']; ?>"></td>
                        </tr>
                        <tr>
                          <td>제 목</td>
                          <td class="left">
<?php

    if ('edit' == $mode) {
        echo '<input type="text" name="title" size="50" maxlength="50" value="' . stripcslashes($row['title']) . '" /></td>';
    } else {
        echo '<input type="text" name="title" size="50" maxlength="50" /></td>';
    }
?>
                        </tr>
                        <tr>
                          <td colspan="2">
<?php

    if ($mode == 'edit') {
        $contents = stripslashes($row['contents']);
        echo <<<HEREDOC
		                            <textarea name="contents" class="form-control" id="contents">{$contents}</textarea>
                            <script type="text/javascript">
                                CKEDITOR.replace( 'contents' );
                            </script>
                            <div class="margin-top-30">
                                <i class="fa fa-paperclip"></i>파일 첨부 (20MB 이하)
                                <input type="file" name="uploadedfile" size="30">
                            </div>

HEREDOC;

    } else {
        echo <<<HEREDOC
		                            <textarea name="contents" class="form-control" id="contents"></textarea>
                            <script type="text/javascript">
                                CKEDITOR.replace( 'contents' );
                            </script>
                            <div class="margin-top-30">
                                <i class="fa fa-paperclip"></i>파일 첨부 (20MB 이하)
                                <input type="file" name="uploadedfile" size="30">
                            </div>
HEREDOC;
}
?></td>
                        </tr>
                      </tbody>
                    </table>

                    <!-- 글쓰기 버튼 -->
                    <div class="row text-center">
                        <a class="btn btn-success" href="#" onClick="send('contents');">작성하기</a> &nbsp;
                        <a class="btn btn-primary" href="list.php?code=<?php echo $code; ?>">목 록</a>
                    </div>

                  </form>

          </div>
        </div>
      </div>
    <!-- /.content -->



<!-- FOOTER -->
<?php include_once '../include/brands.php';?>

<?php include_once '../include/footer.php';?>

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
                // oEditors.getById[id].exec("UPDATE_CONTENTS_FIELD", []);
                document.write_form.submit();
            }
        -->
        </script>
    </body>
</html>

