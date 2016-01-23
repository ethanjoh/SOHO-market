<?php

//관리자 인증 파일
include "../../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../../util/config.php";
// 각종 유틸함수
include "../../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>
<title>회원 메일 발송</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="../../css/admin_layout.css" />
<script language="JavaScript" src="../../../js/global.js" ></script>
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
	form.submit();
}
//-->
</script>
</head>
<body>
<div id="content" class="mail">
  <form method="post" name="mail" action="sendmail_all_ok.php">
    <?php
	$tot_cnt = sizeof($num);
	
 for($i=0;$i < sizeof($num);$i++){
 ?>
    <input type=hidden name='num[]' value='<?=$num[$i]?>'>
    <?php
  }
 ?>
    <table summary="send mail">
      <caption>
      메일 발송 (발송할 회원 수 :
      <?=$tot_cnt?>
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
          <th scope="col">발송 내용
            </td>
          <td class="member"><textarea name="contents" cols="60" rows="8" ></textarea>
          </td>
        </tr>
      </tbody>
    </table>
    <table summary="buttons">
      <tbody>
        <tr bgcolor='#FFFFFF'>
          <td align='right'><input type='button' value=" 메일 발송 " onClick="javascript:send_check()">
            <input type='reset' value=" 다시 작성 ">
          </td>
        </tr>
      </tbody>
    </table>
  </form>
</div>
</body>
</html>
