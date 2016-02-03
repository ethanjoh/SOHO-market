<?php
include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

$mode  = set_var($_POST['mode']);
$num   = set_var($_POST['num']);
$link1 = set_var($_POST['m_link1']);
$link2 = set_var($_POST['m_link2']);
$link3 = set_var($_POST['m_link3']);
$link4 = set_var($_POST['m_link4']);
$link5 = set_var($_POST['m_link5']);

if ($_FILES['m_banner1_image']['name']) {
    $file_ext1 = substr(strrchr($_FILES['m_banner1_image']['name'], "."), 1);
    $file_ext1 = strtolower($file_ext1);

    if ($file_ext1 != 'jpg' && $file_ext1 != 'gif' && $file_ext1 != 'jpeg' && $file_ext1 != 'png') {
        err_msg("이미지 파일만 올릴 수 있습니다.");
    }
    if (!$_FILES['m_banner1_image']['size']) {
        err_msg("지정한 파일(메인배너1)이 없거나 파일 크기가 0KB입니다.");
    }
}

if ($_FILES['m_banner2_image']['name']) {
    $file_ext2 = substr(strrchr($_FILES['m_banner2_image']['name'], "."), 1);
    $file_ext2 = strtolower($file_ext2);

    if ($file_ext2 != 'jpg' && $file_ext2 != 'gif' && $file_ext2 != 'jpeg' && $file_ext2 != 'png') {
        err_msg("이미지 파일만 올릴 수 있습니다.");
    }
    if (!$_FILES['m_banner2_image']['size']) {
        err_msg("지정한 파일(메인배너2)이 없거나 파일 크기가 0KB입니다.");
    }
}

if ($_FILES['m_banner3_image']['name']) {
    $file_ext3 = substr(strrchr($_FILES['m_banner3_image']['name'], "."), 1);
    $file_ext3 = strtolower($file_ext3);

    if ($file_ext3 != 'jpg' && $file_ext3 != 'gif' && $file_ext3 != 'jpeg' && $file_ext3 != 'png') {
        err_msg("이미지 파일만 올릴 수 있습니다.");
    }
    if (!$_FILES['m_banner3_image']['size']) {
        err_msg("지정한 파일(메인배너3)이 없거나 파일 크기가 0KB입니다.");
    }
}

if ($_FILES['m_banner4_image']['name']) {
    $file_ext4 = substr(strrchr($_FILES['m_banner4_image']['name'], "."), 1);
    $file_ext4 = strtolower($file_ext4);

    if ($file_ext4 != 'jpg' && $file_ext4 != 'gif' && $file_ext4 != 'jpeg' && $file_ext4 != 'png') {
        err_msg("이미지 파일만 올릴 수 있습니다.");
    }
    if (!$_FILES['m_banner4_image']['size']) {
        err_msg("지정한 파일(메인배너4)이 없거나 파일 크기가 0KB입니다.");
    }
}

if ($_FILES['m_banner5_image']['name']) {
    $file_ext5 = substr(strrchr($_FILES['m_banner5_image']['name'], "."), 1);
    $file_ext5 = strtolower($file_ext5);

    if ($file_ext5 != 'jpg' && $file_ext5 != 'gif' && $file_ext5 != 'jpeg' && $file_ext5 != 'png') {
        err_msg("이미지 파일만 올릴 수 있습니다.");
    }
    if (!$_FILES['m_banner5_image']['size']) {
        err_msg("지정한 파일(메인배너5)이 없거나 파일 크기가 0KB입니다.");
    }
}

if ($mode == 'insert') {

    $query = "INSERT INTO banner VALUES ('')";
    mysqli_query($connect, $query);

    $query  = "SELECT max(num) AS maxid FROM banner";
    $result = mysqli_query($connect, $query);
    $row    = mysqli_fetch_array($result);
    mysqli_free_result($result);

    $savedir = "../../gallery";

    if ($_FILES['m_banner1_image']['name']) {
        $file1 = $savedir . "/m/" . substr(md5(uniqid($g4[server_time])), 0, 8) . "_" . $_FILES['m_banner1_image']['name'];
        move_uploaded_file($_FILES['m_banner1_image']['tmp_name'], $file1);
        $mimg1_chk = "Y";
        $link1     = $m_link1;
    } else {
        $mimg1_chk = "N";
    }

    if ($_FILES['m_banner2_image']['name']) {
        $file2 = $savedir . "/m/" . substr(md5(uniqid($g4[server_time])), 0, 8) . "_" . $_FILES['m_banner2_image']['name'];
        move_uploaded_file($_FILES['m_banner2_image']['tmp_name'], $file2);
        $mimg2_chk = "Y";
        $link2     = $m_link2;
    } else {
        $mimg2_chk = "N";
    }

    if ($_FILES['m_banner3_image']['name']) {
        $file3 = $savedir . "/m/" . substr(md5(uniqid($g4[server_time])), 0, 8) . "_" . $_FILES['m_banner3_image']['name'];
        move_uploaded_file($_FILES['m_banner3_image']['tmp_name'], $file3);
        $mimg3_chk = "Y";
        $link3     = $m_link3;
    } else {
        $mimg3_chk = "N";
    }

    if ($_FILES['m_banner4_image']['name']) {
        $file4 = $savedir . "/m/" . substr(md5(uniqid($g4[server_time])), 0, 8) . "_" . $_FILES['m_banner4_image']['name'];
        move_uploaded_file($_FILES['m_banner4_image']['tmp_name'], $file4);
        $mimg4_chk = "Y";
        $link4     = $m_link4;
    } else {
        $mimg4_chk = "N";
    }

    if ($_FILES['m_banner5_image']['name']) {
        $file5 = $savedir . "/m/" . substr(md5(uniqid($g4[server_time])), 0, 8) . "_" . $_FILES['m_banner5_image']['name'];
        move_uploaded_file($_FILES['m_banner5_image']['tmp_name'], $file5);
        $mimg5_chk = "Y";
        $link5     = $m_link5;
    } else {
        $mimg5_chk = "N";
    }

    $dbinsert1 = "INSERT INTO banner(  m_banner1,  m_banner1_image, m_link1,
                                      m_banner2,  m_banner2_image, m_link2,
                                      m_banner3,  m_banner3_image, m_link3,
                                      m_banner4,  m_banner4_image, m_link4,
                                      m_banner5,  m_banner5_image, m_link5,
                                      created)
              VALUES( '$mimg1_chk',   '$file1', '$link1',
                      '$mimg2_chk',  '$file2', '$link2',
                      '$mimg3_chk', '$file3', '$link3',
                      '$mimg4_chk', '$file4', '$link4',
                      '$mimg5_chk', '$file5', '$link5',
                      now() )";
    $result1 = mysqli_query($connect, $dbinsert1);

    if ($result1) {
        echo ("<meta http-equiv='content-type' content='text/html; charset=UTF-8' />
           <script>
          window.alert('배너를 등록했습니다.')
         </script>
    ");
        echo "<meta http-equiv='Refresh' content='0; URL=banner_list.php'>";
    } else {
        err_msg('배너 등록 중 DB오류가 발생했습니다.');
    }
} else if ($mode == 'update') {

    $query  = "SELECT * FROM banner WHERE num='$num' ";
    $result = mysqli_query($connect, $query);
    $row    = mysqli_fetch_array($result);
    mysqli_free_result($result);

    $savedir = "../../gallery";

    if ($_FILES['m_banner1_image']['name']) {
        $temp1 = $savedir . "/m/" . substr(md5(uniqid($g4[server_time])), 0, 8) . "_" . $_FILES['m_banner1_image']['name'];
        move_uploaded_file($_FILES['m_banner1_image']['tmp_name'], $temp1);
        $mimg1_chk = 'Y';
    } else if ($row['m_banner1'] == "Y") {
        $temp1     = $row['m_banner1_image'];
        $mimg1_chk = 'Y';
    } else {
        $mimg1_chk = 'N';
    }
    $temp1_char = " m_banner1='$mimg1_chk' , m_banner1_image='$temp1', m_link1='$link1' ";

    if ($_FILES['m_banner2_image']['name']) {
        $temp2 = $savedir . "/m/" . substr(md5(uniqid($g4[server_time])), 0, 8) . "_" . $_FILES['m_banner2_image']['name'];
        move_uploaded_file($_FILES['m_banner2_image']['tmp_name'], $temp2);
        $mimg2_chk = 'Y';
    } else if ($row['m_banner2'] == "Y") {
        $temp2     = $row['m_banner2_image'];
        $mimg2_chk = 'Y';
    } else {
        $mimg2_chk = 'N';
    }

    $temp2_char = ", m_banner2='$mimg2_chk' , m_banner2_image='$temp2' , m_link2='$link2' ";

    if ($_FILES['m_banner3_image']['name']) {
        $temp3 = $savedir . "/m/" . substr(md5(uniqid($g4[server_time])), 0, 8) . "_" . $_FILES['m_banner3_image']['name'];
        move_uploaded_file($_FILES['m_banner3_image']['tmp_name'], $temp3);
        $mimg3_chk = 'Y';
    } else if ($row['m_banner3'] == "Y") {
        $temp3     = $row['m_banner3_image'];
        $mimg3_chk = 'Y';
    } else {
        $mimg3_chk = 'N';
    }

    $temp3_char = ", m_banner3='$mimg3_chk' , m_banner3_image='$temp3', m_link3='$link3' ";

    if ($_FILES['m_banner4_image']['name']) {
        $temp4 = $savedir . "/m/" . substr(md5(uniqid($g4[server_time])), 0, 8) . "_" . $_FILES['m_banner4_image']['name'];
        move_uploaded_file($_FILES['m_banner4_image']['tmp_name'], $temp4);
        $mimg4_chk = 'Y';
    } else if ($row['m_banner4'] == "Y") {
        $temp4     = $row['m_banner4_image'];
        $mimg4_chk = 'Y';
    } else {
        $mimg4_chk = 'N';
    }

    $temp4_char = ", m_banner4='$mimg4_chk' , m_banner4_image='$temp4', m_link4='$link4' ";

    if ($_FILES['m_banner5_image']['name']) {
        $temp5 = $savedir . "/m/" . substr(md5(uniqid($g4[server_time])), 0, 8) . "_" . $_FILES['m_banner5_image']['name'];
        move_uploaded_file($_FILES['m_banner5_image']['tmp_name'], $temp5);
        $mimg5_chk = 'Y';
    } else if ($row['m_banner5'] == "Y") {
        $temp5     = $row['m_banner5_image'];
        $mimg5_chk = 'Y';
    } else {
        $mimg5_chk = 'N';
    }

    $temp5_char = ", m_banner5='$mimg5_chk' , m_banner5_image='$temp5', m_link5='$link5' ";

    $dbinsert1 = "UPDATE banner SET
                   $temp1_char
                   $temp2_char
                   $temp3_char
                   $temp4_char
                   $temp5_char
          WHERE num='$num' ";
    $result1 = mysqli_query($connect, $dbinsert1);

    if ($result1) {
        echo ("
     <meta http-equiv='content-type' content='text/html; charset=UTF-8' />
       <script>
      window.alert('배너를 수정했습니다.')
     </script>
    ");
        echo "<meta http-equiv='Refresh' content='0; URL=banner_list.php'>";
    } else {
        err_msg('배너 수정 중 DB오류가 발생했습니다.');
    }
}
