<?php

include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<title>B2B SCM</title>
<meta charset="UTF-8" />
<link rel="stylesheet" href="../css/admin_layout.css" />
<script src="../../js/global.js" ></script>
<script src="../js/admin.js" ></script>
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
$query  = "SELECT * FROM products WHERE num=$p_num";
$result = mysqli_query($connect, $query);
$row    = mysqli_fetch_array($result);
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
    case '0':
        echo "이벤트 없음";
        break;
    case '1':
        echo "할인판매 (기간: " . $row['date1'] . " ~ " . $row['date2'] . " )";
        break;
    case '2':
        echo "사은품 증정 (기간: " . $row['date1'] . " ~ " . $row['date2'] . " )";
        break;
    case '3':
        echo "할인+사은품 증정 (기간: " . $row['date1'] . " ~ " . $row['date2'] . " )";
        break;
    case '4':
        echo "1+1 (기간: " . $row['date1'] . " ~ " . $row['date2'] . " )";
        break;
}
?>
          </td>
        </tr>
        <tr class="odd">
          <th scope="row" class="column1">이벤트상품 여부</th>
          <td class="member"><?=$row['main_special'];?></td>
        </tr>
        <tr>
          <th scope="row" class="column1">신상품 여부</th>
          <td class="member"><?=$row['main_new'];?></td>
        </tr>
        <tr class="odd">
          <th scope="row" class="column1">인기상품 여부</th>
          <td class="member"><?=$row['main_best'];?></td>
        </tr>
        <tr>
          <th scope="row" class="column1">제품 판매상태</th>
          <td class="member"><?php
switch ($row['del_chk']) {
    case "Y":echo "판매 중지(숨김)";
        break;
    case "N":echo "판매 중";
        break;
    case "O":echo "<img src=\"../images/outofstock_icon.gif\" alt=\"품절\" />";
        break;
}
?></td>
        </tr>
        <tr>
          <th scope="row" class="column1">등록일자</th>
          <td class="member"><?=$row['created'];?></td>
        </tr>
        <tr>
          <th colspan="2"><img src="../images/order_state_mini_1.gif" alt="" width="16" height="16" /> <strong>상품 정보</strong></th>
        </tr>
        <caption>
        상품 등록정보
        </caption>
        <tbody>
          <tr class="odd">
            <th scope="row" class="column1">상품 카테고리</th>
            <td class="member"><?php

$ca1_qry    = "select * from products_category1 where code='$row[category_l]'";
$ca1_result = mysqli_query($connect, $ca1_qry);
$ca1_row    = mysqli_fetch_array($ca1_result);
mysqli_free_result($ca1_result);
echo "$ca1_row[name]";

if ($row['category_m']) {
    $ca2_qry    = "select * from products_category2 where code='$row[category_m]'";
    $ca2_result = mysqli_query($connect, $ca2_qry);
    $ca2_row    = mysqli_fetch_array($ca2_result);
    mysqli_free_result($ca2_result);
    echo " <img src=\"../images/arrow_collapse.gif\" /> ";
    echo " $ca2_row[name]";
}
if ($row['category_s']) {
    $ca3_qry    = "select * from products_category3 where code='$row[category_s]'";
    $ca3_result = mysqli_query($connect, $ca3_qry);
    $ca3_row    = mysqli_fetch_array($ca3_result);
    mysqli_free_result($ca3_result);
    echo " <img src=\"../images/arrow_collapse.gif\" /> ";
    echo " $ca3_row[name]";
}
?>
            </td>
          </tr>
          <tr>
            <th scope="row" class="column1">상품명</th>
            <td class="member"><?=$row['name'];?></td>
          </tr>
          <tr class="odd">
            <th scope="row" class="column1">제조/공급사</th>
            <td class="member"><?=$row['company'];?></td>
          </tr>
          <tr>
            <th scope="row" class="column1">원산지</th>
            <td class="member"><?=$row['origin'];?></td>
          </tr>
          <tr class="odd">
            <th scope="row" class="column1">소비자가</th>
            <td class="member"><?=number_format($row['retail_price']);?>
              원</td>
          </tr>
          <tr>
            <th scope="row" class="column1">할인가</th>
            <td class="member"><?=number_format($row['sale_price']);?>
              원</td>
          </tr>
          <tr class="odd">
            <th scope="row" class="column1">고정공급가</th>
            <td class="member"><?=number_format($row['fixed_price']);?>
              원 (할인행사 등으로 별도의 공급가 책정 시에만)</td>
          </tr>
          <tr>
            <th scope="row" class="column1">최소 구매수량</th>
            <td class="member"><?=number_format($row['moq']);?>
              개</td>
          </tr>
          <tr>
            <th scope="row" class="column1">적립금</th>
            <td class="member"><?=number_format($row['mileage']);?>
              원</td>
          </tr>
          <tr class="odd">
            <th scope="row" class="column1">옵션</th>
            <td class="member"><?php
if ($row['opt']) {
    $opt       = explode('|', $row['opt']);
    $opt_stock = explode('|', $row['opt_stock']);
    ?>
              <select name="selected_opt">
                <?php
for ($i = 0; $i < sizeof($opt); $i++) {
        if ($opt_stock[$i] == 0) {
            $opt_stock[$i] = "품절";
        }
        ?>
                <option value="<?=trim($opt[$i]);?>" <?=($selected);?>>
                <?=shortenStr(trim($opt[$i]), 24);?>
                (
                <?=$opt_stock[$i];?>
                개) </option>
                <?php
}
    ; // for end
    ?>
              </select>
            </td>
          </tr>
          <tr>
            <th scope="row" class="column1">재고</th>
            <td class="member"><?="옵션 재고에서 확인";?>
            </td>
          </tr>
          <?php
} else {
    ?>
        <select name="selected_opt">
          <option value="nothing">--옵션이 없습니다.--</option>
        </select>
        </td>

        </tr>

        <tr>
          <th scope="row" class="column1">재고</th>
          <td class="member"><?=$row['stock'];?>
            개 </td>
        </tr>
        <?php
}
?>
        <tr class="odd">
          <th scope="row" class="column1">크기</th>
          <td class="member"><?=$row['size'];?></td>
        </tr>
        <tr>
          <th scope="row" class="column1">재질</th>
          <td class="member"><?=$row['material'];?></td>
        </tr>
        <tr>
          <th scope="row" class="column1">이미지(소)</th>
          <td class="member"><img src="<?=$row['s_image_name'];?>" width="100" height="100" onerror="this.src='../images/no_image100.gif'" /> </td>
        </tr>
        <tr>
          <th scope="row" class="column1">확대 이미지 1(대)</th>
          <td class="member"><img src="<?=$row['b_image1_name'];?>" width="100" height="100" onerror="this.src='../images/no_image100.gif'" /> </td>
        </tr>
        <tr>
          <th scope="row" class="column1">확대 이미지 2(대)</th>
          <td class="member"><img src="<?=$row['b_image2_name'];?>" width="100" height="100" onerror="this.src='../images/no_image100.gif'"/> </td>
        </tr>
        <tr>
          <th scope="row" class="column1">확대 이미지 3(대)</th>
          <td class="member"><img src="<?=$row['b_image3_name'];?>" width="100" height="100" onerror="this.src='../images/no_image100.gif'" /> </td>
        </tr>
        <tr>
          <th scope="row" class="column1">확대 이미지 4(대)</th>
          <td class="member"><img src="<?=$row['b_image4_name'];?>" width="100" height="100" onerror="this.src='../images/no_image100.gif'" /> </td>
        </tr>
        <tr>
          <th scope="row" class="column1">확대 이미지 5(대)</th>
          <td class="member"><img src="<?=$row['b_image5_name'];?>" width="100" height="100" onerror="this.src='../images/no_image100.gif'" /> </td>
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

if ($row['d_image'] == 'Y') {
    ?>
            <p align="center"> <img src="<?=$row['d_image_name'];?>" alt="상세 이미지"  /> </p>
            <?php
}
?>
          </td>
        </tr>
        </tbody>

      </table>
      <table summary="buttons">
        <tbody>
          <tr>
            <td><div class="clear"><a class="button" href="sp_products_list.php?lcode=<?=$lcode;?>&amp;mcode=<?=$mcode;?>&amp;scode=<?=$scode;?>&amp;page=<?=$page;?>" onclick="this.blur();"><span>목록</span></a><a class="button" href="sp_pro_register.php?mode=update&amp;p_num=<?=$p_num;?>&amp;lcode=<?=$lcode;?>&amp;mcode=<?=$mcode;?>&amp;scode=<?=$scode;?>&amp;page=<?=$page;?>" onclick="this.blur();"><span>수정</span></a><a class="button" href="sp_pro_delete.php?p_num=<?=$p_num;?>&amp;lcode=<?=$lcode;?>&amp;mcode=<?=$mcode;?>&amp;scode=<?=$scode;?>&amp;page=<?=$page;?>" onclick="this.blur(); return confirm('정말 삭제하시겠습니까?')"><span>삭제</span></a></div></td>
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
