<?php
include_once "../../util/util.php";

$mode     = set_var($_POST['mode']);
$num      = set_var($_POST['num']);
$title    = set_var($_POST['title']);
$passwd   = set_var($_POST['passwd']);
$code     = set_var($_POST['code']);
$writable = set_var($_POST['writable']);
$readable = set_var($_POST['readable']);

if ("modify" == $mode) {
    $query  = "UPDATE code SET bbs_name='$title' WHERE num = '$num' ";
    $result = mysqli_query($connect, $query);

    if (!$result) {
        err_msg('DB 오류가 발생했습니다.');
    } else {
        $url = 'bbs_list.php';
        show_msg('게시판명을 수정했습니다.', $url);
    }

} else if ("del" == $mode) {
    $query  = "DELETE FROM code WHERE num = '$num' ";
    $result = mysqli_query($connect, $query);

    //메인 게시판 삭제
    $board   = 'bbs_' . $code;
    $query2  = "DROP TABLE $board ";
    $result2 = mysqli_query($connect, $query2);

    //답변 게시판 삭제
    $board3  = 'bbs_re_' . $code;
    $query3  = "DROP TABLE $board3 ";
    $result3 = mysqli_query($connect, $query3);

    if (!$result || !$result2 || !$result3) {
        err_msg('DB Error while making table.');
    } else {
        $url = 'bbs_list.php';
        show_msg('게시판을 삭제했습니다.', $url);
    }

} else if ("ins" == $mode) {
    $passwd = sha1($passwd);
    $query  = "INSERT INTO code (code, bbs_name, passwd, writable, readable)
				    VALUES ('$code', '$title', '$passwd', '$writable[0]', '$readable[0]' )";
    $result = mysqli_query($connect, $query);

    //메인 게시판 테이블 생성
    $board  = 'bbs_' . $code;
    $query2 = "CREATE TABLE IF NOT EXISTS $board (
				  main_no int(11) unsigned NOT NULL AUTO_INCREMENT,
				 id varchar(11) NOT NULL,
				 title varchar(30) NOT NULL,
				 name varchar(20) NOT NULL,
				 contents mediumtext NOT NULL,
				 passwd varchar(41) NOT NULL,
				 date datetime NOT NULL,
				 mod_date datetime NOT NULL,
				 count int(10) unsigned NOT NULL default '0',
				 email  varchar(40),
				 depth int(3) unsigned NOT NULL default '0',
				 filename varchar(255),
				 PRIMARY KEY (main_no),
				 KEY (title, name)
				)ENGINE=MyISAM,CHARSET=utf8";

    $result2 = mysqli_query($connect, $query2);

    //답변 게시판 테이블 생성
    $board2 = 'bbs_re_' . $code;
    $query3 = "CREATE TABLE IF NOT EXISTS $board2 (
				 reply_no int(11) unsigned NOT NULL AUTO_INCREMENT,
				 main_no int(11) unsigned NOT NULL,
				 id varchar(11) NOT NULL,
				 name varchar(20) NOT NULL,
				 contents mediumtext NOT NULL,
				 passwd varchar(41) NOT NULL,
				 date datetime NOT NULL,
				 email  varchar(40),
				 PRIMARY KEY (reply_no),
				 KEY (main_no)
				)ENGINE=MyISAM,CHARSET=utf8";

    $result3 = mysqli_query($connect, $query3);

    if (!$result || !$result2 || !$result3) {
        err_msg('DB Error while making table.');
    } else {
        $url = 'bbs_list.php';
        show_msg('게시판을 생성했습니다.', $url);
    }

} else if ("pw" == $mode) {
    $passwd = sha1($passwd);
    $query  = "UPDATE code SET passwd='$passwd' WHERE num = '$num' ";
    $result = mysqli_query($connect, $query);

    if (!$result) {
        err_msg('DB Error while changing password.');
    } else {
        $url = 'bbs_list.php';
        show_msg('작업을 완료했습니다.', $url);
    }

} else if ("edit" == $mode) {
    $query  = "UPDATE code SET writable = '$writable[0]', readable = '$readable[0]' WHERE code='$code'";
    $result = mysqli_query($connect, $query);

    if (!$result) {
        err_msg('DB Error while editing proviliges.');
    } else {
        $url = 'bbs_list.php';
        show_msg('권한을 수정했습니다.', $url);
    }

}
