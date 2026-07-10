<?php
include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

$sender       = set_var($_POST['sender']);
$sender_email = set_var($_POST['sender_email']);
$subject      = set_var($_POST['subject']);
$contents     = set_var($_POST['contents']);

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
    $message .= chunk_split(base64_encode($file), 80, "\r\n");
    $message .= "\r\n--$boundary--";

} else {
    $headers .= "Content-Type: text/html; charset=utf-8\r\n";
    $message = stripslashes($contents);
}

for ($i = 0; $i < sizeof($num); $i++) {
    $query  = "SELECT * FROM supplier WHERE seq_num='$num[$i]' ";
    $result = mysqli_query($connect, $query);
    $rows   = mysqli_fetch_array($result);

    //$toname = $rows['company_name'];
    $to = $rows['md_email'];

    mail($to, $subject, $message, $headers);
}

echo "<meta http-equiv='content-type' content='text/html; charset=UTF-8' />
	   <script>
		 window.alert('메일을 발송했습니다.')
		 self.close()
		</script>";
