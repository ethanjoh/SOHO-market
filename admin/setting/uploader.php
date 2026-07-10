<?php
$url = "http://".$_SERVER["HTTP_HOST"];
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8" />
<title>이미지 삽입</title>
<script type="text/javascript">
function putImg(id, file) {
	opener.pasteHTMLDemo(id, file);
	self.close();
}
</script>
</head>
<body>
<?php
if($mode=="ok") {
	?>
<div align="center">
  <p> <img src="../images/image.png" /></p>
  <p>이미지가 저장되었습니다.</p>
  <p> <a href="#" onclick="javascript:putImg('<?=$_GET['id']?>', '<img src=<?=$url?>/<?=$_GET['file']?>>');">확인</a> </p>
</div>
<?php
}else {
	?>
<p>
<form action="uploader_ok.php" enctype="multipart/form-data" method="post">
  <input type="hidden" name="id" value="<?=$_GET['id']?>" />
  <input type="file" name="uploadedfile" />
  <input type="submit" value="업로드" />
</form>
</p>
<?php
}
	?>
</body>
</html>
