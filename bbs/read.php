<?php include_once '../include/header.php';?>


    <!-- HOME -->
    <div class="container">
        <div class="row text-center">
            <h1>읽 기</h1>
        </div>
    </div>
    <!-- /.home -->


<?php

$code     = set_var($_GET['code']);
$main_no  = set_var($_GET['main_no']);
$page     = set_var($_GET['page']);
$reply_no = set_var($_GET['reply_no']);

$p_id = set_var($_SESSION['p_id']);

$bqry = "SELECT * FROM code WHERE code='$code' ";
$bres = mysqli_query($connect, $bqry);
$brow = mysqli_fetch_array($bres);

//조회수 증가
if ('admin' != $p_id) {
    $board = 'bbs_' . $code;
    mysqli_query($connect, "UPDATE $board SET count = count+1 WHERE main_no = '$main_no' ");
}

//테이블 값을 불러온다
$sql    = "SELECT * FROM $board WHERE main_no='$main_no' ";
$result = mysqli_query($connect, $sql);
$row    = mysqli_fetch_array($result);

?>

    <!-- contents -->
        <div class="container">
            <div class="row">
                <div class="table-responsive">

<?php

if (!$p_id && $brow['readonly'] == 'N') {
    $msg = "잘못된 접근이거나 로그인하시기 바랍니다.";
    $url = "list.php?code=" . $code;
    show_msg($msg, $url);
} else if ($p_id != 'admin' && $brow['readonly'] == 'Y' && $row['id'] != 'admin') {
    $sql1    = "SELECT * FROM member WHERE id='$p_id' ";
    $result1 = mysqli_query($connect, $sql1);
    $row1    = mysqli_fetch_array($result1);

    if ($row1['id'] != $row['id']) {
        $msg = "본인이 작성한 글이 아니거나 로그인하시기 바랍니다.";
        $url = "list.php?code=" . $code;
        err_msg($msg, $url);
    }
} // end else if

if ('admin' == $p_id || $row1['id'] == $row['id'] || 'Y ' == $brow['readonly'] || 'admin' == $row['id']) {
    ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>번호</th>
                                <th>제목</th>
                                <th>작성자</th>
                                <th>작성일</th>
                                <th>조회</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $row['main_no']; ?></td>
                                <td class="left"><?php echo stripslashes($row['title']); ?></td>
                                <td><a href="mailto:<?php echo $row['email']; ?>"><?php echo $row['name']; ?></a></td>
                                <td><?php echo $row['date']; ?></td>
                                <td><?php echo $row['count']; ?></td>
                            </tr>
                            <tr>
                                <td class="smartOutput" colspan="5" style="text-align:left">
                                    <p><?php echo stripslashes($row['contents']); ?></p>
                                    <p>[ 최종수정일 : <?php echo $row['mod_date']; ?> ]</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
<?php

////////////////////////첨부파일 표시//////////////////////////////////
    $max_file_num = 1; //업로드 파일 갯수 지정

    if ($row['filename']) {
        ?>
                      <table class="table">
                        <tbody>
                          <tr>
                            <td>
<?php

        for ($i = 0; $i < $max_file_num; $i++) {
            if ($row['filename']) {
                $path = $row['filename'];

                //Array 값으로 분리, [0]에는 "_"이전 값이, [1]에는 "_"이후 값이 들어있다.
                $chk_name  = explode("_", $row['filename']);
                $real_name = $chk_name[sizeof($chk_name) - 1];
                ?>
                              <i class="fa fa-paperclip"></i> <a href="<?php echo $path; ?>"><?php echo $real_name; ?></a>
<?php

            }
        }
        ?>
                            </td>
                          </tr>
                        </tbody>
                      </table>
<?php

    }
    ; //if문
    ?>
                      <!-- 게시판 기능 버튼 -->
                    <div class="text-center">
                        <a class="btn btn-primary" href="list.php?code=<?php echo $code; ?>&amp;page=<?php echo $page; ?>">목 록</a>
                        <a class="btn btn-warning" href="post.php?mode=edit&amp;code=<?php echo $code; ?>&amp;main_no=<?php echo $row['main_no']; ?>">수 정</a>
<?php

    if ('admin' == $p_id) {
        echo '<a class="btn btn-danger" href="admin_delete.php?code=' . $code . '&amp;main_no=' . $row['main_no'] . '&amp;from=read" return confirm(\'삭제하시겠습니까?\')"><i class="fa fa-trash-o"></i>삭 제<a>';
    } else {
        echo '<a class="btn btn-danger" href="delete.php?mode=parent&code=' . $code . '&amp;main_no=' . $row['main_no'] . '" return confirm(\'삭제하시겠습니까?\')"><i class="fa fa-trash-o"></i>삭 제</a>';
    }
    ?>
                    </div>
                    <p><hr></p>

<?php

    /////////////////////////답글이 있다면 순차적을 정열한다./////////////////////////
    if ($row['depth'] > 0) {
        $board     = 'bbs_re_' . $code;
        $re_sql    = "SELECT * FROM $board WHERE main_no = $main_no ORDER BY reply_no ASC";
        $re_result = mysqli_query($connect, $re_sql);

        $i = 1;

        while ($re_row = mysqli_fetch_array($re_result)) {
            ?>
                      <div class="pane">
<?php

            if ('admin' == $p_id) {
                echo '<a href="admin_delete.php?code=' . $code . '&amp;main_no=' . $main_no . '&amp;reply_no=' . $re_row['reply_no'] . '&amp;from=reply" onclick="return confirm(\'답변을 삭제하시겠습니까?\');" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></a>';
            } else {
                echo '<a href="delete.php?mode=child&code=' . $code . '&amp;main_no=' . $main_no . '&amp;reply_no=' . $re_row['reply_no'] . '" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></a>';
            }
            ?>
                        <?php echo $re_row['name']; ?> 답변: <?php echo $re_row['title']; ?></strong>
                        <p>
                            <div class="margin-top-10">
                                <p><?php echo stripslashes($re_row['contents']); ?></p>
                            </div>
                        </p>
                        <p>작성일 : <?php echo $re_row['date']; ?></p>
                        </div>
<?php

            $reply_no = $re_row['reply_no']; // 마지막 답글 번호를 저장해 답변 시 넘긴다.
            $i++;
        }
    }

    if ($p_id) {
        //로그인을 했을 때만 댓글입력할 수 있도록
        if ('admin' == $p_id || $row1['id'] == $row['id']) {
            ?>

                      <!-- 댓글 -->
                        <form name="reply_form" method="post" action="//<?php echo $_SERVER['SERVER_NAME']; ?>:<?php echo $port; ?>/bbs/post_ok.php">
                            <!-- <form name="reply_form" method="post" action="http://www.<?php echo $_SERVER['SERVER_NAME']; ?>/bbs/post_ok.php"> -->
                            <input type="hidden" name="mode" value="reply" />
                            <input type="hidden" name="main_no" value="<?php echo $main_no; ?>" />
                            <input type="hidden" name="reply_no" value="<?php echo $reply_no; ?>" />
                            <input type="hidden" name="code" value="<?php echo $code; ?>" />
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td><textarea name="contents" id="contents" style="width:100%; height:100px"></textarea></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="pull-right"><a class="btn btn-success" href="#" onClick="javascript:send('contents');"><span>댓글 남기기</span></a></div>
                        </form>
<?php

        }

    } //if end

} else {
    echo "ERROR";
}

?>
          </div>
        </div>
      </div>
    <!-- contents end -->


<!-- FOOTER -->
<?php include_once '../include/brands.php';?>

<?php include_once '../include/footer.php';?>

    <script language="javascript" type="text/javascript">
    <!--
    function editwindow(url) {
      newwindow=window.open(url,'edit_window','height=400,width=600, left=100, top=100, resizable=yes,scrollbars=yes,status=yes');

    }

    // -->
    </script>


    <!-- smart editor end -->
    <script language="JavaScript">
    <!--
        function send(id)
        {
            if (document.getElementById(id).value <0) {
                alert("내용을 입력하십시오.");
                document.getElementById(id).focus();
                return false;
            }
        // oEditors.getById[id].exec("UPDATE_CONTENTS_FIELD", []);
            document.reply_form.submit();
        }
    -->
    </script>
  </body>
</html>

