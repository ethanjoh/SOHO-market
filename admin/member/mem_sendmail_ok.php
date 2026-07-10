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

    $num          = set_var($_POST['num']);
    $sender       = set_var($_POST['sender']);
    $subject      = set_var($_POST['subject']);
    $sender_email = set_var($_POST['sender_email']);
    $contents     = set_var($_POST['contents']);
    $subject      = addslashes($subject);
    $contents     = addslashes($contents);

    $sender  = "=?EUC-KR?B?" . base64_encode(iconv("UTF-8", "EUC-KR", $sender)) . "?=\r\n";
    $subject = "=?EUC-KR?B?" . base64_encode(iconv("UTF-8", "EUC-KR", $subject)) . "?=\r\n";

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
        $message .= chunk_split(base64_encode($file), 80, "\r\n");
        $message .= "\r\n--$boundary--";

    } else {
        $headers .= "Content-Type: text/html; charset=utf-8\r\n";
        $message = stripslashes($contents);
    }

    for ($i = 0; $i < sizeof($num); $i++) {

        $query  = "SELECT * FROM member WHERE seq_num='$num[$i]' ";
        $result = mysqli_query($connect, $query);
        $rows   = mysqli_fetch_array($result);

        $to = $rows['md_email'];
        // echo $to;

        mail($to, $subject, $message, $headers);
        echo str_pad("", 1024, " "); //BROWSER TWEAKS
        echo " <br />";              //BROWSER TWEAKS

        //10개씩 보내고 시차를 둔다.
        if ($i % 10 == 0) {
            sleep(5);
            echo '<p align="center">메일 보내기 ( ' . $i . ' ) 완료.</p>' . "\r\n";
        }

        //telling php to show the stuff as soon as echo is done
        ob_flush();
        flush();

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


