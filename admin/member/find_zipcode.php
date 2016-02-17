<?php

########## 데이터베이스에 연결한다. ##########
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
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
<link rel="stylesheet" href="../css/admin_layout.css" />
<script language="JavaScript" src="../../js/global.js" ></script>
<script language="JavaScript" src="../js/admin.js" ></script>
<script language="JavaScript">
<!--
function checkInput(form){
   var form = document.zipsearch;
   if(!form.dong.value) {
        alert("찾기를 원하는 동을 입력하세요!");
        form.dong.focus();
	    return false;
   }else{
       form.submit();
   }
}
//-->
</script>
<script language="javascript">

<!-- 회원가입에서 호출  -->
function open_move1(zipcode,adr) {
   
   var form_object = eval("opener.document.form1");
      
      zip1=zipcode.substring(0,3);
      zip2=zipcode.substring(4,7);
      b=adr
            
      form_object.o_zipcode1.value = zip1;
      form_object.o_zipcode2.value = zip2;
      form_object.o_addr1.value = b;
	    form_object.o_addr2.focus();
   
      self.close();
}

<!-- 구매에서 호출 -->
function open_move2(zipcode,adr) {
   
   var form_object = eval("opener.document.purchase");
      
      zip1=zipcode.substring(0,3);
      zip2=zipcode.substring(4,7);
      b=adr
            
      form_object.buyer_zipcode01.value = zip1;
      form_object.buyer_zipcode02.value = zip2;
      form_object.buyer_address01.value = b;
	    form_object.buyer_address02.focus();
   
      self.close();
}

<!-- 구매에서 호출 -->
function open_move3(zipcode,adr) {
   
   var form_object = eval("opener.document.purchase");
      
      zip1=zipcode.substring(0,3);
      zip2=zipcode.substring(4,7);
      b=adr
            
      form_object.recipient_zipcode01.value = zip1;
      form_object.recipient_zipcode02.value = zip2;
      form_object.recipient_address01.value = b;
	    form_object.recipient_address02.focus();
   
      self.close();
}

<!-- 회원가입 배송지에서 호출  -->
function open_move4(zipcode,adr) {
   
   var form_object = eval("opener.document.form1");
      
      zip1=zipcode.substring(0,3);
      zip2=zipcode.substring(4,7);
      b=adr
            
      form_object.d_zipcode1.value = zip1;
      form_object.d_zipcode2.value = zip2;
      form_object.d_addr1.value = b;
	    form_object.d_addr2.focus();
   
      self.close();
}
</script>
</head>
<body>
<div id="wrapper">
  <div id="bodyblock">
    <div id="content">
      <table summary="head">
        <thead>
          <tr class="odd">
            <td>우편번호 검색</td>
          </tr>
        </thead>
        <tbody>
        <form name="zipsearch" method="post" action="<?=$PHP_SELF?>" onSubmit="return checkInput()">
          <tr>
            <td>동 이름 :
              <input type="text" name="dong" size="12">
              <input type='hidden' name='mode' value='search'>
              <input type='hidden' name='what' value='<?=$what?>'>
              <input type='hidden' name='from' value='<?=$from?>'>
              <input type="submit" name="btn" value="확인"></td>
          </tr>
        </form>
        <?php
        if($mode == 'search'){

        ########## 주소 데이터베이스에서 사용자가 입력한 주소와 일치하는 레코드를 검색한다. ##########
        $query  = "SELECT * FROM zipcode WHERE dong LIKE '%$dong%' ORDER BY seq";
        $result = mysqli_query($connect, $query);
        $total_num = mysqli_num_rows($result);
        ########## 검색결과가 존재하면 리스트박스 형태로 출력한다. ########## 
        ?>
        <tr>
          <td><font color="#000099">해당 
            주소를 클릭하시면 자동입력됩니다.</font></td>
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
    </div>
  </div>
</div>
</body>
</html>
