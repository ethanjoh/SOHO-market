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
<!-- smarteditor css -->
<link href="css/style.css" rel="stylesheet" type="text/css" />
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
    <?php
$query = "SELECT * FROM products WHERE num=$p_num";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_array($result);
mysqli_free_result($result);
    
?>
    <div id="content">
      <table summary="view product info">
        <tr class="odd">
          <th colspan="2"><img src="../images/order_state_mini_1.gif" width="16" height="16" /> <strong>관리 정보</strong></th>
        </tr>
        <tr>
          <th class="column1" scope="row">이벤트 관리</th>
          <td class="member"><?php 
		  		switch ($row['event']) {
					case '0' :
						echo "이벤트 없음";
						break;
					case '1' : 
						echo "할인판매 (기간: ".$row['date1']." ~ ".$row['date2']." )";
						break;
					case '2' :
						echo "사은품 증정 (기간: ".$row['date1']." ~ ".$row['date2']." )";
						break;
					case '3' :
						echo "할인+사은품 증정 (기간: ".$row['date1']." ~ ".$row['date2']." )";
						break;						
					case '4' :
						echo "1+1 (기간: ".$row['date1']." ~ ".$row['date2']." )";
						break;
				}
			?></td>
        </tr>
        <tr class="odd">
          <th scope="row" class="column1">이벤트상품 여부</th>
          <td class="member"><?=$row['main_special']?></td>
        </tr>
        <tr>
          <th scope="row" class="column1">신상품 여부</th>
          <td class="member"><?=$row['main_new']?></td>
        </tr>
        <tr class="odd">
          <th scope="row" class="column1">인기상품 여부</th>
          <td class="member"><?=$row['main_best']?></td>
        </tr>
        <tr>
          <th scope="row" class="column1">제품 판매상태</th>
          <td class="member"><?php
		  	switch ($row['del_chk']) {
				case "Y" : echo "판매 중지(숨김)";
							   break;
			 	case "N" : echo "판매 중";
							   break;
				case "O" : echo "<img src=\"../images/outofstock_icon.gif\" alt=\"품절\" />";
							   break;					   
			}
			?></td>
        </tr>
        <tr>
          <th scope="row" class="column1">등록일자</th>
          <td class="member"><?=$row['created']?></td>
        </tr>
        <tr>
          <th colspan="2"><img src="../images/order_state_mini_1.gif" alt="" width="16" height="16" /> <strong>상품 정보</strong></th>
        </tr>
        <thead>
          <tr>
            <th colspan="2">상품 등록정보</th>
          </tr>
        </thead>
        <tbody>
          <tr class="odd">
            <th scope="row" class="column1">상품 카테고리</th>
            <td class="member"><?
	 $ca1_qry = "select * from products_category1 where code='$row[category_l]'";
	 $ca1_result = mysqli_query($connect, $ca1_qry);
	 $ca1_row = mysqli_fetch_array($ca1_result);
	 mysqli_free_result($ca1_result);
     echo"$ca1_row[name]";

	 if($row['category_m']){
	  $ca2_qry = "select * from products_category2 where code='$row[category_m]'";
	  $ca2_result = mysqli_query($connect, $ca2_qry);
 	  $ca2_row = mysqli_fetch_array($ca2_result);
 	  mysqli_free_result($ca2_result);
	  echo" <img src=\"../images/arrow_collapse.gif\" /> ";
	  echo" $ca2_row[name]";
	 }
 if($row['category_s']){
	  $ca3_qry = "select * from products_category3 where code='$row[category_s]'";
	  $ca3_result = mysqli_query($connect, $ca3_qry);
 	  $ca3_row = mysqli_fetch_array($ca3_result);
 	  mysqli_free_result($ca3_result);
	  echo" <img src=\"../images/arrow_collapse.gif\" /> ";
	  echo" $ca3_row[name]";
	 }	 
	?></td>
          </tr>
          <tr>
            <th scope="row" class="column1">상품명</th>
            <td class="member"><?=$row['name']?></td>
          </tr>
          <tr>
            <th scope="row" class="column1">옵션</th>
            <td class="member"><?php
		  		if($row['opt']) {
            		show_option($row);
			  	}else {
					echo "<select name=\"selected_opt\">\n
                                <option value=\"nothing\">--옵션이 없습니다.--</option>\n
                             </select>\n";
			    }
			?></td>
          </tr>
          <tr class="odd">
            <th scope="row" class="column1">제조/공급사</th>
            <td class="member"><?=$row['company']?></td>
          </tr>
          <tr>
            <th scope="row" class="column1">원산지</th>
            <td class="member"><?=$row['origin']?></td>
          </tr>
          <tr class="odd">
            <th scope="row" class="column1">소비자가</th>
            <td class="member"><?=number_format($row['retail_price'])?>
              원</td>
          </tr>
          <tr>
            <th scope="row" class="column1">할인가</th>
            <td class="member"><?=number_format($row['sale_price'])?>
              원</td>
          </tr>
          <tr class="odd">
            <th scope="row" class="column1">고정공급가</th>
            <td class="member"><?=number_format($row['fixed_price'])?>
              원 (할인행사 등으로 별도의 공급가 책정 시에만)</td>
          </tr>
          <tr>
            <th scope="row" class="column1">적립금</th>
            <td class="member"><?=number_format($row['mileage'])?>
              원</td>
          </tr>
          <tr class="odd">
            <th scope="row" class="column1">최소 구매수량</th>
            <td class="member"><?=number_format($row['moq'])?>
              개</td>
          </tr>
           <tr>
            <th scope="row" class="column1">전체 재고</th>
            <td class="member"><?=$row['stock']?>
              개 </td>
          </tr>         
          <tr class="odd">
            <th scope="row" class="column1">크기</th>
            <td class="member"><?=$row['size']?></td>
          </tr>
          <tr>
            <th scope="row" class="column1">재질</th>
            <td class="member"><?=$row['material']?></td>
          </tr>
          <tr>
            <th scope="row" class="column1">검색어</th>
            <td class="member"><?=$row['tag']?></td>
          </tr>
          <tr>
            <th scope="row" class="column1">이미지(소)</th>
            <td class="member"><img src="<?=$row['s_image_name']?>" width="50" height="50" onerror="this.src='../images/no_image100.gif'" /></td>
          </tr>
          <tr>
            <th scope="row" class="column1">대  1</th>
            <td class="member"><img src="<?=$row['b_image1_name']?>" width="100" height="100" onerror="this.src='../images/no_image100.gif'" /></td>
          </tr>
          <tr>
            <th scope="row" class="column1">대 2</th>
            <td class="member"><img src="<?=$row['b_image2_name']?>" width="100" height="100" onerror="this.src='../images/no_image100.gif'"/></td>
          </tr>
          <tr>
            <th scope="row" class="column1">대  3</th>
            <td class="member"><img src="<?=$row['b_image3_name']?>" width="100" height="100" onerror="this.src='../images/no_image100.gif'" /></td>
          </tr>
          <tr>
            <th scope="row" class="column1">대 4</th>
            <td class="member"><img src="<?=$row['b_image4_name']?>" width="100" height="100" onerror="this.src='../images/no_image100.gif'" /></td>
          </tr>
          <tr>
            <th scope="row" class="column1">대 5</th>
            <td class="member"><img src="<?=$row['b_image5_name']?>" width="100" height="100" onerror="this.src='../images/no_image100.gif'" /></td>
          </tr>
          <tr>
            <th scope="row" class="column1">상품설명</th>
            <td class="smartOutput" style="text-align:left;"><?php
		  /*
	 if($row['con_html'] =='1'){
	  echo(stripslashes($row['contents']));
	 }
	 else{
	   echo(nl2br(stripslashes($row['contents'])));
     }*/
	 
	 echo stripslashes($row['contents']);
	 
	 if($row['d_image']=='Y'){
	 ?>
              <p align="center"> <img src="<?=$row['d_image_name']?>" alt="상세 이미지"  /> </p>
              <?php
	 }
	 ?></td>
          </tr>
        </tbody>
      </table>
      <table summary="buttons">
        <tbody>
          <tr>
            <td><div class="clear"><a class="button" href="top_pro_list.php?lcode=<?=$lcode?>&amp;mcode=<?=$mcode?>&amp;scode=<?=$scode?>&amp;page=<?=$page?>" onclick="this.blur();"><span>목록</span></a><a class="button" href="pro_register.php?mode=update&amp;p_num=<?=$p_num?>&amp;lcode=<?=$lcode?>&amp;mcode=<?=$mcode?>&amp;scode=<?=$scode?>&amp;page=<?=$page?>" onclick="this.blur();"><span>수정</span></a><a class="button" href="pro_delete.php?p_num=<?=$p_num?>&amp;lcode=<?=$lcode?>&amp;mcode=<?=$mcode?>&amp;scode=<?=$scode?>&amp;page=<?=$page?>" onclick="this.blur(); return confirm('정말 삭제하시겠습니까?')"><span>삭제</span></a></div></td>
          </tr>
        </tbody>
      </table>
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
