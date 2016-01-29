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
<!DOCTYPE html">
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>우편번호 찾기</title>
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.0/jquery.mobile-1.3.0.min.css" />
<script src="http://code.jquery.com/jquery-1.8.2.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.0/jquery.mobile-1.3.0.min.js"></script>

<link rel="stylesheet" href="../css/m_shop_layout.css" />
<script language="JavaScript" src="../js/global.js"></script>
<script language="JavaScript" src="../js/shopping.js"></script>
</head>
<body>
<div data-role="page">
  <div data-role="content" class="nopm bgW">
    <div class="tbar">
       <h3>우편번호 찾기</h3>
    </div>
  <div class="box6 bgW ac">  
    검색하려는 주소의 동이름을 입력하세요
  </div>

  <form name="zipsearch" method="post" action="<?=$PHP_SELF?>" onSubmit="return checkInput()" data-ajax="false">
    <input type='hidden' name='mode' value='search'>
    <input type='hidden' name='what' value='<?=$what?>'>
    <input type='hidden' name='from' value='<?=$from?>'>      
    <div class="box5 bgW ac">
      <input type="text" name="dong" size="12" data-mini="true" data-inline="true">
      <input type="submit" name="btn" data-role="button" data-icon="search" data-theme="b" data-iconpos="right" value="검색" data-inline="true" data-mini="true">
    </div>
  </form>   

    <?php
      if($mode == 'search'){

      ########## 주소 데이터베이스에서 사용자가 입력한 주소와 일치하는 레코드를 검색한다. ##########
      $query  = "SELECT * FROM zipcode WHERE dong LIKE '%$dong%' ORDER BY seq";
      $result = mysqli_query($connect, $query);
      $total_num = mysqli_num_rows($result);
      ########## 검색결과가 존재하면 리스트박스 형태로 출력한다. ########## 
    ?>
    <div class="box6 bgW ac">  
    해당 주소를 누르시면 자동입력됩니다.
    </div>

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
				 ?>
         <div class="box5 ac"> 
           <dl class="overHidden">
             <dt class="fl"><a href="#" onclick="javascript:open_move<?=$what?>('<?=$post_num?>','<?=$address2?>');"><?=$post_num?></a></dt>
             <dd class="fr"><a href="#" onclick="javascript:open_move<?=$what?>('<?=$post_num?>','<?=$address2?>');"><?=$address1?></a></dd>
           </dl>
         </div>
    			<?php
				      }
				   }
				   else{
                 ?>
        <div class="box5 bgG ac">  
        해당하는 주소가 없습니다.
        </div>                 
    <?php 
          }  
	  }
?>
  <div class="box6 bgW ac">  
    <a type="button" href="javascript:window.close();" data-mini="true">닫기</a>
  </div>

</div>
</body>
</html>
