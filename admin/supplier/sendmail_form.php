<?php

include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>
<title>회원 메일 발송</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="../css/admin_layout.css" />
<script language="JavaScript" src="../../js/global.js" ></script>
<script language="JavaScript">
<!--
function send_check() {
	var form = document.mail;
	if(!form.sender.value){
		alert('보내는 사람 이름을 입력하지 않았습니다.');
		form.sender.focus();
		return;
	}

	if(!form.sender_email.value){
		alert('보내는 사람 이메일을 입력하지 않았습니다.');
		form.sender_email.focus();
		return;
	}

	if(!form.subject.value){
		alert('메일 제목을 입력하지 않았습니다.');
		form.subject.focus();
		return;
	}

	if(!form.contents.value){
		alert('발송 내용을 입력하지 않았습니다.');
		form.contents.focus();
		return;
	}
	oEditors.getById["contents"].exec("UPDATE_IR_FIELD", []);
	form.submit();
}
//-->
</script>
<link href="css/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/HuskyEZCreator.js" charset="utf-8"></script>
</head>
<body topmargin="0" style="background-color:#ffffff">
  <form method="post" name="mail" action="sendmail_ok.php" enctype="multipart/form-data">
    <?php
$tot_cnt = sizeof($num);

for ($i = 0; $i < sizeof($num); $i++) {
    ?>
    <input type=hidden name='num[]' value='<?=$num[$i];?>'>
    <?php
}
?>
    <table summary="send mail">
      <caption>
      메일 발송 (발송할 회원 수 :
      <?=$tot_cnt;?>
      )
      </caption>
      <tbody>
        <tr>
          <th scope="col">보내는 사람</th>
          <td class="member"><input type='text' size='20' name="sender" value="블루버드 관리자">
          </td>
        </tr>
        <tr>
          <th scope="col">보내는 Email
            </td>
          <td class="member"><input type='text' size='50' name="sender_email" value="webmaster@bluebud.co.kr">
          </td>
        </tr>
        <tr>
          <th scope="col">메일 제목
            </td>
          <td class="member"><input type='text' size='60' name="subject" >
          </td>
        </tr>
        <tr>
          <th scope="col">첨부 파일</th>
          <td class="member"><input type='file' size='40' name="upfile" /></td>
        </tr>
        <tr>
          <th scope="col">발송 내용
            </td>
          <td class="member"><textarea name="contents" id="contents" style="width:450px; height:150px"></textarea>
          </td>
        </tr>
      </tbody>
    </table>
   <table summary="buttons">
    <tbody>
      <tr>
        <td><div class="full"><a class="button" href="#" onclick="this.blur();javascript:send_check();"><span>메일 발송</span></a> <a class="button" href="#" onclick="this.blur();javascript:document.mail.reset();"><span>다시 작성</span></a><a class="button" href="#" onclick="this.blur();javascript:window.close();"><span>닫기</span></a></div></td>
      </tr>
    </tbody>
  </table>
  </form>
</body>
<script>
var oEditors = [];
// 마지막 옵션은 체감 속도 증진을 위해서 페이지 로딩 완료시 까지 화면 표시를 하지 않는 옵션 입니다.
// 개발 작업시에는 이 값을 false로 설정 하세요.
//nhn.husky.EZCreator.createInIFrame(oEditors, "contents", "SEditorSkin.html", "createSEditorInIFrame", null, false);
nhn.husky.EZCreator.createInIFrame({
	oAppRef: oEditors,
	elPlaceHolder: "contents",
	sSkinURI: "SEditorSkin.html",
	fCreator: "createSEditorInIFrame"
});
</script>
</html>
