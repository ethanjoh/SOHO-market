<?php include_once '../include/header.php';?>
<body>
    <section id="container" >
        <!--header start-->
        <?php include "../include/admin_head.php";?>
        <!--header end-->
        <!--sidebar start-->
        <?php include "../include/admin_sidebar.php";?>
        <!--sidebar end-->
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">

                <div class="row">
                    <div class="col-md-12">

<?php

    $sender       = "=?EUC-KR?B?" . base64_encode(iconv("UTF-8", "EUC-KR", $_POST['sender'])) . "?=\r\n";
    $sender_email = set_var($_POST['sender_email']);
    // $subject = set_var($_POST['subject']);
    $subject  = "=?EUC-KR?B?" . base64_encode(iconv("UTF-8", "EUC-KR", $_POST['subject'])) . "?=\r\n";
    $contents = set_var($_POST['contents']);

    $subject  = addslashes($subject);
    $contents = addslashes($contents);

    $headers = "Return-Path: $sender_email\r\n";
    $headers .= "From: $sender <$sender_email>\r\n";

    $boundary = "----" . uniqid("part");

    if ($_FILES['upfile']['name'] && $_FILES['upfile']['size']) {
        $filename = basename($_FILES['upfile']['name']);
        $fp       = fopen($_FILES['upfile']['tmp_name'], "r");
        $file     = fread($fp, $_FILES['upfile']['size']);
        fclose($fp);

        if ($_FILES['upfile']['type'] == "") {
            $upfile_type = "application/octet-stream";
        }

        $boundary = "--------" . uniqid("part");

        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"";

        $message = "This is a multi-part message in MIME format.\r\n\r\n";
        $message .= "--$boundary\r\n";

        $message .= "Content-Type: text/html; charset=utf-8\r\n";
        $message .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
        $message .= nl2br(stripslashes($contents)) . "\r\n\r\n";
        $message .= "--$boundary\r\n";
        $message .= "Content-Type: $upfile_type; name=\"$filename\"\r\n";
        $message .= "Content-Transfer-Encoding: base64\r\n\r\n";
        $message .= ereg_replace("(.{80})", "\\1\r\n", base64_encode($file));
        $message .= "\r\n--$boundary--";

    } else {
        $headers .= "Content-Type: text/html; charset=utf-8\r\n";
        $message = stripslashes($contents);
    }

    // for ($i = 0; $i < sizeof($num); $i++) {
    for ($i = 0; $i < 150; $i++) {
        // $query  = "SELECT * FROM member WHERE seq_num='$num[$i]' ";
        // $result = mysqli_query($connect, $query);
        // $rows   = mysqli_fetch_array($result);

        // $to = $rows['md_email'];
        $to = "osakabiz@naver.com";

        mail($to, $subject, $message, $headers);

        // echo $to . "님에게 메일을 보냈습니다.<br>";

        //50개씩 보내고 시차를 둔다.
        if ($i % 50 == 0) {
            sleep(10);
            echo '<p align="center">(' . ($i) . ') 완료.</p>' . "\r\n";
        }

    }

    $to = $sender_email; //관리자에게 메일 전송
    mail($to, $subject, $message, $headers);

    $msg = "메일전송이 끝났습니다. 창을 닫아주세요.";
    msg($msg);
?>

                    </div>
                </div>
            </section>
        </section>
        <!--main content end-->
        <!--footer start-->
        <?php include_once "../include/admin_footer.php";?>
        <!--footer end-->

    </body>
</html>


