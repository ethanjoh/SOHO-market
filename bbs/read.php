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
$flag     = set_var($_GET['flag']); // 미사용
$p_id     = set_var($_SESSION['p_id']);

$bqry = "SELECT * FROM code WHERE code='$code' ";
$bres = mysqli_query($connect, $bqry);
$brow = mysqli_fetch_array($bres);

$readable = $brow['readable'];
$writable = $brow['writable'];

if ($code) {
    $board = 'bbs_' . $code;
} else {
    $board = 'bbs_notice';
}

//조회수 증가
if ($p_id != 'admin') {
    mysqli_query($connect, "UPDATE $board SET count = count+1 WHERE main_no = '$main_no' ");
}

if ($readable == 'E') {
    $sql    = "SELECT * FROM $board WHERE main_no='$main_no' ";
    $result = mysqli_query($connect, $sql);
} elseif ($readable == 'A') {
    // 작성자 및 관리자만 읽기 가능 (1:1 게시판 등)
    $qry    = "SELECT * FROM $board WHERE main_no='$main_no' ";
    $res    = mysqli_query($connect, $qry);
    $trow   = mysqli_fetch_array($res);
    $writer = $trow['id'];

    if ($p_id == 'admin' || $p_id == $writer) {
        $sql    = "SELECT * FROM $board WHERE main_no='$main_no' AND (id='$writer' OR id='admin') ";
        $result = mysqli_query($connect, $sql);
    } else {
        echo <<<HEREDOC
                  <div class="container">
                    <div class="row">
                      <div class="text-center alert alert-danger" role="alert">
                        <p class="help-block">본인이 작성한 글이 아닙니다.</p>
                        <p><button class="btn btn-default" onClick="history.back(-1);">뒤로 가기</button></p>
                      </div>
                    </div>
                  </div>
HEREDOC;

    }
} elseif ($readable == 'M') {
    if ($p_id) {
        $sql    = "SELECT * FROM $board WHERE main_no='$main_no' ";
        $result = mysqli_query($connect, $sql);
    } else {
        echo <<<HEREDOC

                    <div class="row">
                      <div class="text-center alert alert-danger" role="alert">
                        <p class="help-block">가입업체 전용 게시판입니다.</p>
                        <p><button class="btn btn-default" onClick="history.back(-1);">뒤로 가기</button></p>
                      </div>
                    </div>
HEREDOC;

    }
}

?>

        <!-- contents -->
        <div class="container">

<?php

if (isset($result)) {
    // $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_array($result);

    ?>
            <div class="row">
                <div id="bbs_contents">
                   <div class="bbs_wordwrap bbs_underline">제 목: [<?php echo $row['main_no']; ?>] <?php echo stripslashes($row['title']); ?></div>
                   <div class="bbs_underline">작성자: <a href="mailto:<?php echo $row['email']; ?>"><?php echo $row['name']; ?></a></div>
                   <div class="bbs_underline">작성일: <?php echo $row['create_date']; ?></div>
                   <div class="bbs_underline">조 회:<?php echo $row['count']; ?></div>
                   <div class="bbs_wordwrap bbs_underline">
                    <p><?php echo stripcslashes($row['contents']); ?></p>
                    <p class="mod_date_padding">[ 최종수정일 :                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php echo $row['mod_date']; ?> ]</p>
                   </div>
                </div>
            </div>
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
    ; // end if ($row['filename'])
    ?>
                      <!-- 게시판 기능 버튼 -->
                    <div class="text-center">
                        <a class="btn btn-primary" href="list.php?code=<?php echo $code; ?>&amp;page=<?php echo $page; ?>">목 록</a>
                        <a class="btn btn-warning" href="post.php?mode=edit&amp;code=<?php echo $code; ?>&amp;main_no=<?php echo $row['main_no']; ?>">수 정</a>
<?php

    if ($writable == 'A' && $p_id == 'admin') {
        echo '<a class="btn btn-danger" href="admin_delete.php?code=' . $code . '&amp;main_no=' . $row['main_no'] . '&amp;from=read" return confirm(\'삭제하시겠습니까?\')"><i class="fa fa-trash-o"></i>삭 제</a>';
    } else {
        echo '<a class="btn btn-danger" href="delete.php?mode=parent&code=' . $code . '&amp;main_no=' . $row['main_no'] . '" return confirm(\'삭제하시겠습니까?\')"><i class="fa fa-trash-o"></i>삭 제</a>';
    }
    ?>

                    </div>
                    <hr>

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

            if ($writable == 'A' && $p_id == 'admin') {
                echo '<a href="admin_delete.php?code=' . $code . '&amp;main_no=' . $main_no . '&amp;reply_no=' . $re_row['reply_no'] . '&amp;from=reply" onclick="return confirm(\'답변을 삭제하시겠습니까?\');" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></a>';
            } else {
                echo '<a href="delete.php?mode=child&code=' . $code . '&amp;main_no=' . $main_no . '&amp;reply_no=' . $re_row['reply_no'] . '" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></a>';
            }
            ?>
<?php echo $re_row['name']; ?> 답변:
                            <p>
                                <div class="margin-top-10">
                                    <p><?php echo stripslashes($re_row['contents']); ?></p>
                                </div>
                            </p>
                            <p class="pull-right">[작성일 :
                              <?php echo $re_row['create_date']; ?>]
                            </p>
                        </div>
<?php

            $reply_no = $re_row['reply_no']; // 마지막 답글 번호를 저장해 답변 시 넘긴다.
            $i++;
        } // end while
    } // end if ($row['depth'] > 0)

    //로그인을 했을 때만 댓글입력할 수 있도록
    if ($p_id == 'admin' || $p_id) {

        $protocol = check_protocol($sslPort);
        ?>

                      <!-- 댓글 -->
                        <form name="reply_form" method="post" action="<?php echo $protocol; ?>//<?php echo $_SERVER['SERVER_NAME']; ?>:<?php echo $sslPort; ?>/bbs/post_ok.php">
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

    } // end if ($p_id == 'admin' || $p_id)

}

?>
          </div>
        </div>
      </div>
    <!-- contents end -->


<!-- FOOTER -->
<?php include_once '../include/brands.php';?>

<?php include_once '../include/footer.php';?>

    <script language="JavaScript">
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
    </script>
  </body>
</html>

