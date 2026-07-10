<?php

include_once "../include/admin_auth.php";
include_once "../../util/util.php";

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<title>B2B SCM</title>
<meta charset="UTF-8" />
<link rel="stylesheet" href="../css/admin_layout.css" />
<script src="../../js/global.js" ></script>
<script src="../js/admin.js" ></script>
</head>
<body>
<!-- wrapper -->
<div id="wrapper">
  <!-- header -->
  <?php
include "../include/admin_top.php";
?>
  <!-- header end -->
  <div id="bodyblock">
    <!-- contents -->
    <div id="content">
      <form method="post" name="mail" action="mem_sendmail_each_ok.php" enctype="multipart/form-data">
        <table summary="send mail">
          <caption>
          개별 메일 발송
          </caption>
          <tbody>
            <tr>
              <th scope="col" class="column1">보내는 사람</th>
              <td class="member"><input type='text' size='20' name="sender" value="블루버드 관리자">              </td>
            </tr>
            <tr>
              <th scope="col"  class="column1">보내는 이메일
                </td>
              <td class="member"><input type='text' size='20' name="sender_email" value="ethan.joh@gmail.com">              </td>
            </tr>
            <tr>
              <th scope="col"  class="column1">받는 사람</th>
              <td class="member"><input type='text' size='20' name="receiver">              </td>
            </tr>
            <tr>
              <th scope="col"  class="column1">받는 사람 이메일 </th>
              <td class="member"><input type='text' size='20' name="receiver_email">              </td>
            </tr>
            <tr>
              <th scope="col" class="column1">메일 제목 </th>
              <td class="member"><input type='text' size='60' name="subject" >              </td>
            </tr>
            <tr>
              <th scope="col" class="column1">첨부 파일</th>
              <td class="member"><input type='file' size='40' name="upfile">              </td>
            </tr>
            <tr>
              <th scope="col" class="column1">발송 내용
                </td>
              <td class="member"><textarea name="contents" cols="60" rows="8" ></textarea>              </td>
            </tr>
          </tbody>
        </table>
        <table summary="buttons">
          <tbody>
            <tr bgcolor='#FFFFFF'>
              <td align='right'><div class="clear"><a class="button" href="javascript:mail_send()" onclick="this.blur();javascript:send_check()"><span>메일 보내기</span></a><a class="button" href="javascript:document.mail.reset();" onclick="this.blur();"><span>다시 작성</span></a></div></td>
            </tr>
          </tbody>
        </table>
      </form>
    </div>
    <!-- contens end -->
  </div>
  <!-- bodyblock end -->
  <!-- copyright -->
  <?php
include "../include/admin_bottom.php";
?>
  <!-- copyright  end -->
</div>
<!-- wrapper end -->
</body>
</html>
