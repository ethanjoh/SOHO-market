<?php

########## 데이터베이스에 연결한다. ##########
// 데이타베이스 연결정보 및 기타설정
include "../util/config.php";
// 각종 유틸함수
include "../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

if(!$from)
	$what = "1";
else 
	$what = $from;

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<title>B2B</title>
<link rel="stylesheet" type="text/css" href="../css/shop_layout.css" />
<script language="JavaScript" src="../js/global.js"></script>
<script language="JavaScript" src="../js/member.js"></script>
<script language="JavaScript" src="../js/shopping.js"></script>
</head>
<body topmargin="0" style="background-color:#ffffff">
<table summary="head">
  <thead>
    <tr class="odd">
      <td>우편번호 검색</td>
    </tr>
  </thead>
  <tbody>
  <form name="zipsearch" method="post" action="<?=$PHP_SELF?>" onSubmit="return checkInput()">
    <tr>
      <td>동 이름 : <input type="text" name="dong" size="12">
      <input type='hidden' name='mode' value='search'>
      <input type='hidden' name='what' value='<?=$what?>'>
      <input type='hidden' name='from' value='<?=$from?>'>      
      <input type="submit" name="btn" value="확인">
      </td>
    </tr>
  </form>
  <?php
if($mode == 'search'){

  $query  = "SELECT * FROM zipcode 
             		WHERE dong LIKE '%$dong%' ORDER BY seq";
  $result = mysqli_query($connect, $query);
  $total_num = mysqli_num_rows($result);

?>
  <tr>
    <td><font color="#000099">해당 주소를 클릭하시면 자동입력됩니다.</font></td>
  </tr>
  </tbody>
  
</table>
<table summary="body">
  <tbody>
    <?php
				  if($total_num){
				    for($i=0 ;$i<$rows=mysqli_fetch_array($result);$i++){
              $post_num1 = substr($rows['ZIPCODE'], 0, 3);
              $post_num2 = substr($rows['ZIPCODE'], 3, 6);

              $post_num = $post_num1."-".$post_num2;              
              $address1 = $rows['SIDO'];
              $address1 .= " ".$rows['GUGUN'];
              $address1 .= " ".$rows['DONG'];
              $address1 .= " ".$rows['RI'];
              $address1 .= " ".$rows['BUNJI'];
              $address1 .= " ".$rows['BLDG'];

              $address2 = $rows['SIDO'];
              $address2 .= " ".$rows['GUGUN'];
              $address2 .= " ".$rows['DONG'];
              $address2 .= " ".$rows['RI'];
              //$address2 .= " ".$rows['BUNJI'];
              $address2 .= " ".$rows['BLDG'];
					  	  
			          if($i%2 == 1)
                		echo "<tr class=odd>\n";
				 ?>
      <td width="25%"><a href="javascript:open_move<?=$what?>('<?=$post_num?>','<?=$address2?>')"><?=$post_num?></a></td>
      <td class="left"><a href="javascript:open_move<?=$what?>('<?=$post_num?>','<?=$address2?>')"><?=$address1?></a></td>
    </tr>
    			<?php
				      }
				   }
				   else{
                 ?>
    <tr>
      <td colspan="2"><p>해당하는 주소가 없습니다.</p></td>
    </tr>
    <?php }  
	  }
	 else{
	 ?>
    <tr>
      <td><font color="#000099">검색하려는 주소의 동이름을 입력하세요. </font></td>
    </tr>
    <?php } ?>
    <tr>
      <td colspan="2"><div class="clear"><a class="button" href="javascript:window.close();" onblur="this.blur();"><span>닫기</span></a></div></td>
    </tr>
  </tbody>
</table>
</body>
</html>
