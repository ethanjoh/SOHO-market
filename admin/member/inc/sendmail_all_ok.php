<?php
include_once "../../../include/admin_auth.php";
include_once "../../../util/config.php";
include_once "../../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

$sender       = set_var($_POST['sender']);
$sender_email = set_var($_POST['sender_email']);
$subject      = set_var($_POST['subject']);
$contents     = set_var($_POST['contents']);

$subject  = addslashes($subject);
$contents = addslashes($contents);

for ($i = 0; $i < sizeof($num); $i++) {
    $query  = "SELECT * FROM member WHERE seq_num='$num[$i]' ";
    $result = mysqli_query($connect, $query);
    $rows   = mysqli_fetch_array($result);

    //$md_email= $rows[md_email];

    $body = nl2br($contents);

    $fromname = $sender;
    $from     = $sender_email;

    $toname = $rows[company_name];
    $to     = $rows[md_email];

    $mailheaders = "Return-Path: $from\r\n";
    $mailheaders .= "From: $fromname <$from>\r\n";
    $mailheaders .= "Content-Type: text/html; charset=utf-8\r\n";
    mail($to, $subject, $body, $mailheaders);
}

echo ("
           <script>
	         window.alert('메일이 발송되었습니다.')
			 self.close()
	        </script>
	  ");
