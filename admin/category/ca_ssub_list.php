<?php

//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>
<title>B2B SCM</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="../css/admin_layout.css" />
<link rel="stylesheet" type="text/css" href="../chrometheme/chromestyle.css" />
<script language="JavaScript" src="../../js/global.js" ></script>
<script language="JavaScript" src="../js/admin.js" ></script>
<script language="JavaScript" src="../js/chrome.js" >
/***********************************************
* Chrome CSS Drop Down Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/
</script>
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
      <?php
// 상위카테고리 코드값으로 부터 현 카테고리 값을 구함
$query = "SELECT * FROM products_category3 WHERE up_category='$mcode' ";
$result = mysqli_query($connect, $query);
$total_count = mysqli_num_rows($result);
?>
      <form method="post" action="ca_ssub_list.php">
        <table summary="view category list">
          <caption>
          소분류 목록 (총 <?=$total_count?>개)
          </caption>
          <thead>
            <tr class="odd">
              <th scope="col">코드</th>
              <th scope="col">소분류명</th>
              <th scope="col">등록된 상품수</th>
              <th scope="col">관리</th>
            </tr>
          </thead>
          <tbody>
            <?php
for($i=0; $row = mysqli_fetch_array($result); $i++){
	$query2 = "SELECT * FROM products WHERE category_s='$row[code]'";
	$result2 = mysqli_query($connect, $query2);
	$products_count = mysqli_num_rows($result2);
	mysqli_free_result($result2);

	 if($i%2 == 1)
          echo "<tr class=\"odd\">\n";
?>
            <td><?=$row['code']?></td>
            <td><?=$row['name']?></td>
            <td><?=$products_count?></td>
            <td><a href='ca_ssub_register.php?mode=update&amp;id=<?=$row['id']?>&amp;lcode=<?=$lcode?>&amp;mcode=<?=$row['up_category']?>'><img src="../images/edit.gif" alt="수정" /></a>&nbsp; <a href='ca_ssub_delete.php?id=<?=$row['id']?>&amp;lcode=<?=$lcode?>&amp;mcode=<?=$row['up_category']?>' onClick="return confirm('정말 삭제하시겠습니까?')"><img src="../images/delete.gif" alt="삭제" /></a> </td>
          </tr>
          <?php
}
//mysqli_free_result($result);

if($total_count == 0){
?>
          <tr bgcolor="#FFFFFF" align="center">
            <td colspan="5">등록된 소분류가 없습니다.</td>
          </tr>
          <?php
	}
?>
          </tbody>
        </table>
        <table>
        <tbody>
          <tr>
            <td align="center"><div class="full"><a class="button" href="ca_ssub_register.php?lcode=<?=$lcode?>&amp;mcode=<?=$mcode?>" onclick="this.blur();"><span>소분류 등록하기</span></a><a class="button" href="ca_msub_list.php?lcode=<?=$lcode?>&amp;mcode=<?=$mcode?>" onclick="this.blur();"><span>중분류로 가기</span></a><a class="button" href="top_ca_list.php" onclick="this.blur();"><span>대분류로 가기</span></a></div></td>
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
