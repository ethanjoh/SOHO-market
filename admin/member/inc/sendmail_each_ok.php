<?
// 각종 유틸함수
include "../../../util/util.php";

$sender_email = set_var($_POST['sender_email']);
$sender = set_var($_POST['sender']);
$receiver_email = set_var($_POST['receiver_email']); 
$subject = set_var($_POST['subject']);
$contents = set_var($_POST['contents']);

$subject  = addslashes($subject);
$contents = addslashes($contents);

$mailheaders = "Return-Path: $sender_email\r\n";
$mailheaders .= "From: $sender <$sender_email>\r\n";

$boundary = "----".uniqid("part");

$mailheaders = "Return-Path: $sender_email\r\n";
$mailheaders .= "From: $sender <$sender_email>\r\n";
      
if ($_FILES['upfile']['name'] && $_FILES['upfile']['size']) {
     
   $filename=basename($_FILES['upfile']['name']);
   $fp=fopen($_FILES['upfile']['tmp_name'],"r");
   $file=fread($fp,$_FILES['upfile']['size']);
   fclose($fp);

   if ($_FILES['upfile']['type'] == ""){
     $upfile_type = "application/octet-stream";
   }

   $boundary = "--------".uniqid("part");

   $mailheaders .= "MIME-Version: 1.0\r\n";
   $mailheaders .= "Content-Type: multipart/mixed; boundary=\"$boundary\"";

   $bodytext  = "This is a multi-part message in MIME format.\r\n\r\n";
   $bodytext .= "--$boundary\r\n";

   $bodytext .= "Content-Type: text/html; charset=utf-8\r\n";
   $bodytext .= "Content-Transfer-Encoding: 8bit\r\n\r\n";
   $bodytext .= nl2br(stripslashes($contents)) . "\r\n\r\n";
   $bodytext .= "--$boundary\r\n";
   $bodytext .= "Content-Type: $upfile_type; name=\"$filename\"\r\n";
   $bodytext .= "Content-Transfer-Encoding: base64\r\n\r\n";
   $bodytext .= chunk_split(base64_encode($file), 80, "\r\n");
   $bodytext .= "\r\n--$boundary--";

 }
 else {
   $mailheaders .= "Content-Type: text/html; charset=utf-8\r\n";
   $bodytext =  stripslashes($contents);
 }
     
mail($receiver_email,$subject,$bodytext,$mailheaders);
       
echo " <meta charset="UTF-8" />
   <script language=\"JavaScript\">
    alert(\"메일을 보냈습니다.\");
   </script>
     ";
echo "<meta http-equiv='Refresh' content='0; URL=../mem_sendmail_list.php'>";
?>













