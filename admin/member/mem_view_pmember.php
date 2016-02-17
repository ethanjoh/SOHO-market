<?php

include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>
<title>B2B SCM</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="../css/admin_layout.css" />
<script language="JavaScript" src="../../js/global.js" ></script>
<script language="JavaScript" src="../js/admin.js" ></script>
</head>
<body>
<div id="wrapper">
  <div id="bodyblock">
    <div id="content">
      <?php
$num = set_var($_GET['num']);

$query  = "SELECT * FROM pmember WHERE seq_num=$num ";
$result = mysqli_query($connect, $query);
$rows   = mysqli_fetch_array($result);

$hphone = explode("-", $rows['hphone']);
$zipno  = explode("-", $rows['zipcode']);
$phone  = explode("-", $rows['phone']);
?>
      <div id="member_detail">
        <form name='form1' method='post' action='https://www.<?=$_SERVER['SERVER_NAME'];?>:<?=$port;?>/admin/member/mem_edit_pmember.php'>
          <input type='hidden' name='num' value='<?=$num;?>'>
          <input type='hidden' name='sms' value='<?=$rows['sms'];?>'>
          <input type='hidden' name='page' value='<?=$page;?>'>
          <table summary="view member detail">
            <thead>
              <tr>
                <th colspan="2">개인회원 정보수정/관리 </th>
              </tr>
            </thead>
            <tbody>
              <tr class="odd">
                <th scope="row" class="column1">아이디</th>
                <td class="member"><?=$rows['id'];?></td>
              </tr>
              <tr class="odd">
                <th scope="row" class="column1">비밀번호</th>
                <td class="member"><input type="password" name="passwd" size="15" value="<?=$rows['passwd'];?>" /></td>
              </tr>
              <tr class="odd">
                <th scope="row" class="column1">비밀번호 재입력</th>
                <td class="member"><input type="password" name="passwd2" size="15" />
                  <img src="../images/info.png" alt="안내" />초기화할 때만 입력</td>
              </tr>
              <tr class="odd">
                <th scope="row" class="column1">성명</th>
                <td class="member"><input type="text" name="name" size="10" class="input" value='<?=$rows['name'];?>' /></td>
              </tr>
              <tr class="odd">
                <th scope="row" class="column1">이메일</th>
                <td class="member"><input type="text" name="md_email" size="25" class="input" value='<?=$rows['email'];?>' />
                  <?php if ($rows['optin'] == "Y") {
    echo "(이메일 수신)";
} else {
    echo "(이메일 미수신)";
}

?></td>
              </tr>
              <tr class="odd">
                <th scope="row" class="column1">휴대폰</th>
                <td class="member"><select name="hphone1" />

                  <option value="">선택</option>
                  <option value="010" <?php if ($hphone[0] == '010') {
    echo "selected";
}
?> >010</option>
                  <option value="011" <?php if ($hphone[0] == '011') {
    echo "selected";
}
?> >011</option>
                  <option value="016" <?php if ($hphone[0] == '016') {
    echo "selected";
}
?>>016</option>
                  <option value="017" <?php if ($hphone[0] == '017') {
    echo "selected";
}
?>>017</option>
                  <option value="018" <?php if ($hphone[0] == '018') {
    echo "selected";
}
?>>018</option>
                  <option value="019" <?php if ($hphone[0] == '019') {
    echo "selected";
}
?>>019</option>
                  </select>
                  -
                  <input type="text" name="hphone2" size="4"  value="<?=$hphone[1];?>" />
                  -
                  <input type="text" name="hphone3" size="4"  value="<?=$hphone[2];?>" />
                  <?php if ($rows['sms'] == "Y") {
    echo "(SMS 수신)";
} else {
    echo "(SMS 미수신)";
}

?></td>
              </tr>
              <tr class="odd">
                <th scope="row" class="column1">우편번호</th>
                <td class="member"><input type="text" name="zipcode1" size="3"  value="<?=$zipno[0];?>" />
                  -
                  <input type="text" name="zipcode2" size="3"  value="<?=$zipno[1];?>" />
                  <a href="javascript:ZipWindow('../member/find_zipcode.php', 1)">우편번호 검색</a></td>
              </tr>
              <tr class="odd">
                <th rowspan="2" class="column1" scope="row">주소</th>
                <td class="member"><input type="text" name="addr1" size="30" class="input" value='<?=$rows['addr1'];?>' /></td>
              </tr>
              <tr class="odd">
                <td class="member"><input type="text" name="addr2" size="30" class="input" value='<?=$rows['addr2'];?>' /></td>
              </tr>
              <tr class="odd">
                <th scope="row" class="column1">전화번호</th>
                <td class="member"><input type="text" name="phone1" size="3"   value="<?=$phone[0];?>"  />
                  -
                  <input type="text" name="phone2" size="4"   value="<?=$phone[1];?>"  />
                  -
                  <input type="text" name="phone3" size="4"   value="<?=$phone[2];?>"  /></td>
              </tr>
              <tr>
                <th scope="row" class="column1">기본할인율</th>
                <td class="member"><input type="text" name="dc_rate" value="<?=$rows['dc_rate'];?>" size="3"/>
                  % DC
                  <?php
switch ($rows['tax']) {
    case "E":
        echo "<input type=\"radio\" name=\"tax\" value=\"E\" checked >(VAT 별도)
                    			<input type=\"radio\" name=\"tax\" value=\"I\">(VAT 포함)";
        break;
    case "I":
        echo "<input type=\"radio\" name=\"tax\" value=\"E\">(VAT 별도)
                    			<input type=\"radio\" name=\"tax\" value=\"I\" checked>(VAT 포함)";
        break;
}
?></td>
              </tr>
              <tr>
                <th scope="row" class="column1">결제일</th>
                <td class="member"><select name="payment_day">
                    <option value="1" <?php echo ($rows['payment_day'] == 1) ? "SELECTED>" : ">"; ?>당일 결제



                    </option>
                    <option value="2" <?php echo ($rows['payment_day'] == 2) ? "SELECTED>" : ">"; ?>당월 말



                    </option>
                    <option value="3" <?php echo ($rows['payment_day'] == 3) ? "SELECTED>" : ">"; ?>익월 5일



                    </option>
                    <option value="4" <?php echo ($rows['payment_day'] == 4) ? "SELECTED>" : ">"; ?>익월 10일



                    </option>
                    <option value="5" <?php echo ($rows['payment_day'] == 5) ? "SELECTED>" : ">"; ?>익월 15일



                    </option>
                    <option value="6" <?php echo ($rows['payment_day'] == 6) ? "SELECTED>" : ">"; ?>익월 20일



                    </option>
                    <option value="7" <?php echo ($rows['payment_day'] == 7) ? "SELECTED>" : ">"; ?>익월 25일



                    </option>
                    <option value="8" <?php echo ($rows['payment_day'] == 8) ? "SELECTED>" : ">"; ?>익월 말



                    </option>
                    <option value="9" <?php echo ($rows['payment_day'] == 9) ? "SELECTED>" : ">"; ?>기타



                    </option>
                  </select></td>
              </tr>
              <tr>
                <th scope="row" class="column1"> 승인상태 </th>
                <td class="member"><?php
switch ($rows['approved']) {
    case "Y":
        echo "<input type=\"radio\" name=\"approved\" value=\"Y\" checked />승인
                    			<input type=\"radio\" name=\"approved\" value=\"N\" />미승인";
        break;
    case "N":
        echo "<input type=\"radio\" name=\"approved\" value=\"Y\" />승인
                    			<input type=\"radio\" name=\"approved\" value=\"N\" checked />미승인";
        break;
}
?>
                  (
                  <input type="checkbox" name="sms_chk" value="Y" />
                  승인 시 SMS보내기) </td>
              </tr>
            </tbody>
          </table>
          <table>
            <tr>
              <td><div class="clear"><a class="button" href="#" onclick="this.blur();javascript:document.form1.submit();"><span>수정</span></a>
                  <?=($from == "mail") ? "<a class=\"button\" href=\"#\" onclick=\"this.blur();opener.location.replace('pmem_sendmail_list.php');window.close();\"><span>닫기</span></a>" : "<a class=\"button\" href=\"#\" onclick=\"this.blur();opener.location.replace('pmember_list.php');window.close();\"><span>닫기</span></a>";?>
                </div></td>
            </tr>
          </table>
        </form>
      </div>
      <!-- member end -->
    </div>
  </div>
</div>
</body>
</html>
