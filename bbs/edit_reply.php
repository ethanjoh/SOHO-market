<?php

include "../util/util.php";
include "../util/config.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

$board = 'bbs_re_'.$code;
$sql = "SELECT * FROM $board  WHERE main_no=$main_no AND reply_no=$reply_no";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_array($result);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>답글 수정하기</title>
<link href="../css/bootstrap.css" rel="stylesheet">
<link href="../css/style.css" rel="stylesheet">
<script language="JavaScript">
<!--
    function send() {
        if (document.edit_reply_form.title.value.length <1) {
            alert("제목을 입력하십시오.");
            document.edit_reply_form.title.focus();
            return false;
        }
		    oEditors[0].exec("UPDATE_CONTENTS_FIELD", []);
        document.edit_reply_form.submit();
    }
-->
</script>
</head>
<!-- smart editor -->
<link href="css/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/HuskyEZCreator.js" charset="utf-8"></script>
<!-- smart editor end -->
<body>
<!-- wrapper -->
<div id="wrapper">
  <!-- header -->
  <!-- header end -->
  <div id="bodyblock">
    <!-- contents -->
    <div id="content" style="width:600px">
      <?php
	if($row['id'] != $id) {
		echo "<meta HTTP-EQUIV='CONTENT-TYPE' content='text/html;charset=UTF-8'>
			<script language=\"JavaScript\" type=\"text/javascript\">
	           alert(\"본인이 작성한 글이 아닙니다.\");
			       window.close();
      </script>";
	} else {
	?>
      <form name="edit_reply_form" action="edit_reply_ok.php" method="post">
        <input type="hidden" name="code" value="<?=$code?>">
        <input type="hidden" name="id" value="<?=$_SESSION['p_id']?>">
        <input type="hidden" name="main_no" value="<?=$main_no?>" />
        <input type="hidden" name="reply_no" value="<?=$reply_no?>" />
        <table summary="body">
          <tbody>
            <tr>
              <td class="left"><input type="text" name="title" size="75" maxlength="50" value="<?=$row['title']?>"></td>
            </tr>
            <tr>
              <td class="left"><textarea name="contents" id="contents" style="width:100%; height:300px"><?=$row['contents']?></textarea></td>
            </tr>
            <tr>
              <td><div><a class="btn btn-edit" href="#" onclick="javascript:send();">수 정</a><a class="btn btn-primary" href="#" onclick="javascript:window.close();">닫 기</a></div></td>
            </tr>
          </tbody>
        </table>
      </form>
      <?php
	 }
	 ?>
    </div>
    <!-- contents end -->
  </div>
  <!-- bodyblock end -->
</div>
<!-- wrapper end -->
</body>
<script>
var oEditors = [];
nhn.husky.EZCreator.createInIFrame({
	oAppRef: oEditors,
	elPlaceHolder: "contents",
	sSkinURI: "SmartEditor2Skin.html",
	htParams : {bUseToolbar : true,
		fOnBeforeUnload : function(){
			//alert("아싸!");
		}
	}, //boolean
	fOnAppLoad : function(){
		//예제 코드
		//oEditors.getById["contents"].exec("PASTE_HTML", ["* 세금계산서 신청은 계산서신청 게시판에 해주세요.(본 안내글은 삭제 후 작성해주세요.)"]);
	},
	fCreator: "createSEditor2"
});


</script>
</html>
