<?php
include '../util/util.php';
include '../util/config.php';
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>B2B</title>
<link rel="stylesheet" type="text/css" href="../css/shop_layout.css" />
<link rel="stylesheet" type="text/css" href="css/bbs.css" />
<script language="JavaScript" src="../js/global.js"></script>
<!-- category -->
<link rel="stylesheet" type="text/css" href="../css/ddsmoothmenu.css" />
<!--[if lte IE 7]>
<style type="text/css">
html .ddsmoothmenu{height: 1%;} /*Holly Hack for IE7 and below*/
</style>
<![endif]-->
<script type="text/javascript" src="../js/jquery-1.2.6.pack.js"></script>
<script type="text/javascript" src="../js/ddsmoothmenu.js">
/***********************************************
* Smooth Navigational Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/
</script>
<!-- category end -->
<script language="JavaScript">
<!--
function send() {
	var form = document.form;
	if(form.passwd.value.length == 0)	{
		alert('비밀번호를 입력하세요');
    	form.passwd.focus();
	} else {
		form.submit();
	}
}
-->
</script>
</head>
<body>
<!-- wrapper -->
<div id="wrapper"> 
  <!-- header -->
  <?php
include '../include/top_menu.php';
?>
  <!-- header end -->
  <div id="bodyblock"> 
    <!-- contents -->
    <div id="content">
      <table summary="bbs title">
        <thead>
          <tr>
            <th>관리자 로그인</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><form name="form" action="login_ok.php" method="post">
                <input type="hidden" name="main_no" value="<?=$main_no ?>">
                <input type="hidden" name="reply_no" value="<?=$reply_no ?>">
                <input type="hidden" name="code" value="<?=$code ?>">
                <fieldset>
                  <legend>확 인</legend>
                  <p>
                    <label for="passwd">비밀번호: </label>
                    <input type="password" name="passwd" size="12" maxlength="12" />
                  </p>
                </fieldset>
              </form></td>
          </tr>
          <tr>
            <td><div class="clear"><a class="button" href="javascript:send();" onclick="this.blur();"><span>확인</span></a> <a class="button" href="#" onclick="this.blur();javascript:history.back(-1);"><span>취소</span></a> <a class="button" href="list.php?code=<?=$code?>" onclick="this.blur();"><span>목록</span></a></div></td>
          </tr>
        </tbody>
      </table>
      </p>
      </form>
    </div>
    <!-- contents end --> 
  </div>
  <!-- bodyblock end -->
  <?php
include '../include/bottom.php';
?>
</div>
<!-- wrapper end -->
</body>
</html>
