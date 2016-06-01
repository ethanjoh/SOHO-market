<?php

include_once "../include/admin_auth.php";
include_once "../../util/util.php";

$mode  = set_var($_POST['mode']);
$num   = set_var($_POST['num']);
$link  = set_var($_POST['link']);
$pos   = set_var($_POST['pos']);
$count = set_var($_POST['count']);

$saveDir       = "../../images/banner/";
const MAX_SIZE = 1024000; // 최대 파일 크기

if ($mode == 'insert') {

    $mimg_chk = array();
    $file     = array();
    $mlink    = array();

    $fileNums = count($_FILES['uploadfile']['name']);

    // 파일이 업로드 되어 있는지를 확인합니다.
    if (isset($_FILES['uploadfile'])) {

        for ($i = 0; $i < $fileNums; $i++) {

            if ($_FILES['uploadfile']['name'][$i] == "") {
                $mimg_chk[$i] = "N";
                $file[$i]     = '';
                $mlink[$i]    = '';
            }

            list($result, $ext, $error_msg) = check_file($i);

            if ($result) {
                $mimg_chk[$i] = "Y";
                // $file[$i]     = $saveDir . $_FILES['uploadfile']['name'][$i];
                $mlink[$i] = $link[$i];
                $tmp_name  = $_FILES['uploadfile']['tmp_name'][$i];
                $name      = $_FILES['uploadfile']['name'][$i];

                // 여기에서는 저장할 디렉토리 아래에 「"upfile_" + 현재의 타임스탬프 + 일련 번호 +
                // "_" + 마이크로초와 전 파일 이름과 연결 전 IP 주소에 근거하는 MD5 + 확장자」 로
                // 배치합니다.
                if ($pos == 'main') {
                    $sub = 'main_';
                } elseif ($pos == 'top') {
                    $sub = 'top_';
                } elseif ($pos == 'middle') {
                    $sub = 'middle_';
                } elseif ($pos == 'bottom') {
                    $sub = 'bottom_';
                }

                $move_to  = $saveDir . $sub . time() . $i . '_' . md5(microtime() . $name . $_SERVER['REMOTE_ADDR']) . '.' . $ext;
                $file[$i] = $move_to;

                if (is_dir($saveDir)) {
                    move_uploaded_file($tmp_name, $move_to);
                } else {
                    mkdir($saveDir, 0755, true);
                    move_uploaded_file($tmp_name, $move_to);
                }

            }

            // 에러 메시지가 있으면 표시합니다.
            if (count($error_msg) > 0) {
                foreach ($error_msg as $msg) {
                    msg($msg);
                }
            }

        }

    } else {
        for ($i = 0; $i < 6; $i++) {
            $mimg_chk[$i] = "N";
            $file[$i]     = "";
            $mlink[$i]    = "";
        }

        // err_msg('업로드 이미지가 없습니다.');
    }

    if ($fileNums < 6) {
        $limit = 6 - $fileNums;
        $j     = $fileNums;

        for ($i = 0; $i < $limit; $i++) {

            $mimg_chk[$j] = "N";
            $file[$j]     = "";
            $mlink[$j]    = "";

            $j++;
        }
    }

    $qry = "INSERT INTO banner(  pos,
                                  m_banner1,  m_banner1_image, m_link1,
                                  m_banner2,  m_banner2_image, m_link2,
                                  m_banner3,  m_banner3_image, m_link3,
                                  m_banner4,  m_banner4_image, m_link4,
                                  m_banner5,  m_banner5_image, m_link5,
                                  m_banner6,  m_banner6_image, m_link6,
                                  created)
              VALUES( '$pos',
                      '$mimg_chk[0]', '$file[0]', '$mlink[0]',
                      '$mimg_chk[1]', '$file[1]', '$mlink[1]',
                      '$mimg_chk[2]', '$file[2]', '$mlink[2]',
                      '$mimg_chk[3]', '$file[3]', '$mlink[3]',
                      '$mimg_chk[4]', '$file[4]', '$mlink[4]',
                      '$mimg_chk[5]', '$file[5]', '$mlink[5]',
                      now() )";
    $res = mysqli_query($connect, $qry);

    // debug
    // $txt  = print_r($qry, true);
    // $file = fopen("debug.txt", "w+");
    // fwrite($file, $txt);
    // fclose($file);

    if ($res) {
        $msg = "배너를 등록했습니다.";
        $url = "banner_list.php";

        show_msg($msg, $url);

    } else {
        err_msg('배너 등록 중 DB오류가 발생했습니다.');
    }

}

function check_file($i)
{
    $error_msg = array();
    $ext       = '';

    $size     = $_FILES['uploadfile']['size'][$i];
    $error    = $_FILES['uploadfile']['error'][$i];
    $img_type = $_FILES['uploadfile']['type'][$i];
    $tmp_name = $_FILES['uploadfile']['tmp_name'][$i];

    if ($error != UPLOAD_ERR_OK) {
        // 업로드 에러의 경우
        if ($error == UPLOAD_ERR_NO_FILE) {
            // 업로드 되지 않은 경우는 에러 처리를 하지 않는다.
        } elseif ($error == UPLOAD_ERR_INI_SIZE ||
            $error == UPLOAD_ERR_FORM_SIZE) {
            // 파일 크기 에러
            $error_msg[] = '파일 크기는 1MB 이하로 해주세요';
        } else {
            // 그 외의 에러의 경우
            $error_msg[] = '업로드 에러입니다';
        }
        return array(false, $ext, $error_msg);
    } else {
        // 업로드 에러가 아닌 경우
        // 전송된 MIME 타입으로부터 확장자를 결정
        if ($img_type == 'image/gif') {
            $ext = 'gif';
        } elseif ($img_type == 'image/jpeg' || $img_type == 'image/pjpeg') {
            $ext = 'jpg';
        } elseif ($img_type == 'image/png' || $img_type == 'image/x-png') {
            $ext = 'png';
        }

        // 이미지 파일의 MIME 타입을 판별합니다.
        $finfo     = new finfo(FILEINFO_MIME_TYPE);
        $finfoType = $finfo->file($tmp_name);

        // 이미지 파일의 크기 하한을 확인합니다.
        if ($size == 0) {
            $error_msg[] = '파일이 존재하지 않거나 빈 파일입니다.';
            // 이미지 파일의 크기 상한을 확인합니다.
        } elseif ($size > MAX_SIZE) {
            $error_msg[] = '파일 크기는 1MB 이하로 해주세요';
            // 전송된 MIME 타입과 이미지 파일의 MIME 타입이 일치하는지 확인합니다.
        } elseif ($img_type != $finfoType) {
            $error_msg[] = 'MIME 타입이 일치하지 않습니다.';
            // 이미지 파일의 확장자를 확인합니다.
        } elseif ($ext != 'gif' && $ext != 'jpg' && $ext != 'png') {
            $error_msg[] = '업로드 가능한 파일은 gif, jpg, png 입니다';
        } else {
            return array(true, $ext, $error_msg);
        }
    }
    return array(false, $ext, $error_msg);
}
