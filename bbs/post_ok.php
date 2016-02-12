<?php

include '../util/util.php';
include '../util/config.php';
// MySQL 연결
$connect = my_connect($host, $dbid, $dbpass, $dbname);

//post.php에서 넘어온 값들을 변수에 저장한다.
//사용자 함수를 사용해서 변수값을 가져온다.
$mode     = set_var($_POST['mode']);
$id       = set_var($_POST['id']);
$name     = set_var($_POST['name']);
$main_no  = set_var($_POST['main_no']);
$reply_no = set_var($_POST['reply_no']);
$code     = set_var($_POST['code']);
$title    = set_var($_POST['title']);
$contents = set_var($_POST['contents']);
$email    = set_var($_POST['email']);
$p_id     = set_var($_SESSION['p_id']);

$title = addslashes($title);
$email = addslashes($email);
//$contents = addslashes($contents);

$max_file_size = 20971520;
$uploaddir     = './upload'; //서버에 저장될 디렉토리의 권한은 777로 해둔다.

//글 수정 시
if ($mode == 'edit') {
    $board  = 'bbs_' . $code;
    $pw_sql = "SELECT * FROM $board WHERE main_no='$main_no' ";
    $result = mysqli_query($connect, $pw_sql);
    $row    = mysqli_fetch_array($result);

    /***************************************************************************
    /* 업로드할 파일이 있는지 먼저 체크 후 삭제할 파일이 체크되어 있는지 확인
    /* 삭제체크가 되어 있거나 있어도 새로 첨부하는 경우, DB정보 업데이트 후 서버에서 삭제
    /* chk_delete에 값이 들어있다면 체크가 된 것이다.
     ****************************************************************************/
    if ($_FILES['uploadedfile']['name']) {
        if (!empty($_POST['chk_delete']) || !empty($_POST['old_file'])) {
            unlink($row['filename']);
        }

        // 중복되지 않는 파일로 만든다
        $filename = $uploaddir . substr(md5(uniqid($g4[server_time])), 0, 8) . "_" . $_FILES['uploadedfile']['name'];

        //파일 확장자 확인
        $chk_file  = explode('.', $_FILES['uploadedfile']['name']);
        $extension = $chk_file[sizeof($chk_file) - 1];

        if ($extension == 'html' || $extension == 'htm' || $extension == 'php' || $extension == 'asp' || $extension == 'jsp' || $extension == 'exe') {
            $errmsg = $_FILES['uploadedfile']['name'] . ' 파일은 금지된 확장자입니다.';
            exit;
        }

        //파일용량 확인
        if ($_FILES['uploadedfile']['size'] > $max_file_size) {
            $errmsg = $_FILES['uploadedfile']['name'] . ' 파일 용량이 너무 큽니다.';
            exit;
        }

        //임시파일은 옮기거나 이름을 바꾸지 않으면 자동으로 삭제된다.
        move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $filename);
        chmod('$filename', 0707); // 파일에 권한 설정

        ///////////////////테이블 업데이트//////////////////////////////
        if ($errmsg == '') {
            $board = 'bbs_' . $code;
            $sql   = "UPDATE $board SET title='$title',
									contents='$contents',
									mod_date=now(),
									email='$email',
									filename='$filename'
	      				       WHERE main_no=$main_no";

            mysqli_query($connect, $sql);

            $url = "http://www." . $_SERVER['SERVER_NAME'] . "/bbs/read.php?code=" . $code . "&main_no=" . $main_no;
            show_msg('글을 수정했습니다.', $url);
        } else {
            $url = "http://www." . $_SERVER['SERVER_NAME'] . "/bbs/post.php?mode=edit&code=" . $code . "&main_no=" . $main_no;
            show_msg($errmsg, $url);
        }
    } else if (!empty($_POST['chk_delete'])) {
        //업로드 파일없이 기존 첨부파일 삭제만 할 경우
        unlink($row['filename']);
        $board = 'bbs_' . $code;
        $sql   = "UPDATE $board SET title='$title',
								 contents='$contents',
								 mod_date=now(),
								 email='$email',
								 filename=''
	      				      WHERE main_no=$main_no";

        mysqli_query($connect, $sql);

        $url = "http://www." . $_SERVER['SERVER_NAME'] . "/bbs/read.php?code=" . $code . "&main_no=" . $main_no;
        show_msg('글을 수정했습니다.', $url);
    } else {
        //업로드할 파일과 기존 첨부파일이 없는 경우
        $board = 'bbs_' . $code;
        $sql   = "UPDATE $board SET title='$title',
								 contents='$contents',
								 mod_date=now(),
								 email='$email'
	      		    WHERE main_no=$main_no";

        $result1 = mysqli_query($connect, $sql);

        if (!$result1) {
            $url = "http://www." . $_SERVER['SERVER_NAME'] . "/bbs/post.php?mode=edit&code=" . $code . "&main_no=" . $main_no;
            show_msg('수정 중 DB 에러가 발생했습니다.', $url);
        } else {
            $url = "http://www." . $_SERVER['SERVER_NAME'] . "/bbs/read.php?code=" . $code . "&main_no=" . $main_no;
            show_msg('글을 수정했습니다.', $url);
        }
    }
} else if ('reply' == $mode) {
    //글 작성 시 암호는 회원 로그인 암호를 자동입력
    if ($id == 'admin') {
        $query = "SELECT * FROM code WHERE code='$code' ";
    } else {
        $query = "SELECT * FROM member WHERE id='$id' ";
    }

    $result = mysqli_query($connect, $query);
    $mrow   = mysqli_fetch_array($result);
    $passwd = $mrow['passwd'];

    //컬럼의 순서에 주의하며 DB에 삽입한다.
    //int값은 작은 따옴표로 묶지 않는다.
    //reply_no는 자동으로 증가하므로 넣지 않는다.
    $board = 'bbs_re_' . $code;
    $sql   = "INSERT INTO $board ( reply_no, main_no, id, title, name, contents, passwd, date, email)
	           VALUES ( '', $main_no, '$id', '$title', '$name', '$contents', '$passwd', now(), '$email' )";

    mysqli_query($connect, $sql) or dbError(mysql_error());

    //부모글의 depth를 업데이트해 list.php에서 답변글 갯수를 보여줄 수 있도록 한다.
    $board = 'bbs_' . $code;
    $sql2  = "UPDATE $board SET depth=depth+1, mod_date=now()
							WHERE main_no=$main_no ";

    mysqli_query($connect, $sql2);

    $url = '//' . $_SERVER['SERVER_NAME'] . '/bbs/read.php?code=' . $code . '&main_no=' . $main_no;
    show_msg('답변을 작성했습니다.', $url);

//신규 글 작성
} else {
    //글 작성 시 암호는 회원 로그인 암호를 자동입력
    if ($id == 'admin') {
        $query = "SELECT * FROM code WHERE code='$code' ";
    } else {
        $query = "SELECT * FROM member WHERE id='$id' ";
    }

    $result = mysqli_query($connect, $query);
    $mrow   = mysqli_fetch_array($result);
    $passwd = $mrow['passwd'];

    //////////////////////파일 업로드 처리////////////////////////////
    if ($_FILES['uploadedfile']['name']) {
        // 중복되지 않는 파일로 만든다
        $filename = $uploaddir . "/" . substr(md5(uniqid($g4[server_time])), 0, 8) . "_" . $_FILES['uploadedfile']['name'];

        $chk_file  = explode('.', $filename);
        $extension = $chk_file[sizeof($chk_file) - 1];

        if ($extension == 'html' || $extension == 'htm' || $extension == 'php' || $extension == 'asp' || $extension == 'jsp' || $extension == 'exe') {
            $errmsg = $_FILES['uploadedfile']['name'] . ' 파일은 금지된 확장자입니다.';
            exit;
        }

        //파일용량 확인
        if ($_FILES['uploadedfile']['size'] > $max_file_size) {
            $errmsg = $_FILES['uploadedfile']['name'] . ' 파일 용량이 너무 큽니다.';
            exit;
        }

        // move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $uploaddir."/".$filename);
        move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $filename);
        //chmod('$filename',0707); // 파일에 권한 설정

        //main_no는 자동증가하므로 공백 입력
        //depth 필드도 현재는 필요없으므로 삽입하지 않아야 기본값 0으로 세팅된다.
        $board = 'bbs_' . $code;
        $sql   = "INSERT INTO $board ( main_no, id, title, name, contents, passwd, date, mod_date, count,  email, filename )
								VALUES ( '', '$id', '$title', '$name', '$contents', '$passwd', now(), now(), '0', '$email', '$filename' )";
    } else {
        //첨부파일이 없다면 filename 필드는 추가를 하지 않아야 기본 NULL 값으로 된다.
        //DB 작성 시 filename 은 기본값 NULL 로 지정.
        $board = 'bbs_' . $code;
        $sql   = "INSERT INTO $board ( main_no, id, title, name, contents, passwd, date, mod_date, count, email )
					VALUES ( '', '$id', '$title', '$name', '$contents', '$passwd', now(), now(), '0', '$email')";
    }

    $result = mysqli_query($connect, $sql);

    $url = '//' . $_SERVER['SERVER_NAME'] . '/bbs/list.php?code=' . $code;

    if ($result) {
        show_msg('글을 작성했습니다.', $url);
    } else {
        show_msg($errmsg, $url);
    }
}
