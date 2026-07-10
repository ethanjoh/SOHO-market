<?php

include_once '../util/util.php';

$connect = my_connect($host, $dbid, $dbpass, $dbname);

$chk  = set_var($_POST['chk']);
$code = set_var($_GET['code']);
$from = set_var($_GET['from']);

if ($from == 'read') {
    $board  = 'bbs_' . $code;
    $result = mysqli_query($connect, "SELECT * FROM $board WHERE main_no='$main_no' ") or dbError(mysqli_error($connect));
    $row    = mysqli_fetch_array($result);

    if ($row['depth'] > 0) {
        $board = 'bbs_re_' . $code;
        $sql   = "DELETE FROM $board WHERE main_no='$main_no' ";
        mysqli_query($connect, $sql) or dbError(mysqli_error($connect));
    }

    //부모글 삭제
    $board = 'bbs_' . $code;
    $sql   = "DELETE FROM $board WHERE main_no='$main_no' ";
    mysqli_query($connect, $sql) or dbError(mysqli_error($connect));

} else if ($from == 'reply') {
    //답변댓글 삭제
    $board = 'bbs_re_' . $code;
    $sql   = "DELETE FROM $board WHERE main_no=$main_no AND reply_no='$reply_no' ";
    mysqli_query($connect, $sql) or dbError(mysqli_error($connect));

    $board2 = 'bbs_' . $code;
    $sql2   = "UPDATE $board2 SET depth=(depth-1) WHERE main_no='$main_no' ";
    mysqli_query($connect, $sql2) or dbError(mysqli_error($connect));
} else {
    //list.php에서 삭제 시, for 문을 돌려 chk의 배열값만큼 실행한다.
    //chk[]에는 선택된 글의 main_no가 각각 들어가 있다.
    for ($i = 0; $i < count($chk); $i++) {
        $board  = 'bbs_' . $code;
        $result = mysqli_query($connect, "SELECT * FROM $board WHERE main_no='$chk[$i]' ");
        $row    = mysqli_fetch_array($result);

        if ($row['depth'] > 0) {
            $board2 = 'bbs_re_' . $code;
            $sql    = "DELETE FROM $board2 WHERE main_no='$chk[$i]' ";
            mysqli_query($connect, $sql) or dbError(mysqli_error($connect));
        }

        //부모글 삭제
        $sql = "DELETE FROM $board WHERE main_no='$chk[$i]' ";
        mysqli_query($connect, $sql) or dbError(mysqli_error($connect));
    }
}

$url = 'list.php?code=' . $code;
show_msg('글을 삭제했습니다.', $url);
