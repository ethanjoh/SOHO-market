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
<!-- popup calendar -->
<script type="text/javascript" src="../js/datepicker.js"></script>
<link href="../css/datepicker.css" rel="stylesheet" type="text/css" />
<!-- popup calendar end -->
<!-- ckeditor -->
<link href="css/default.css" rel="stylesheet" type="text/css" />
<script src="/bbs/ckeditor/ckeditor.js" charset="utf-8"></script>
<!-- ckeditor end -->
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
if ($mode == "update") {
    if ($prod_code) {
        $update_qry = "SELECT * FROM products WHERE prod_code='$prod_code' ";
    } else {
        $update_qry = "SELECT * FROM products WHERE num=$p_num";
    }
    $update_result = mysqli_query($connect, $update_qry);
    $update_row    = mysqli_fetch_array($update_result);
    mysqli_free_result($update_result);
} else {
    $mode = "insert";
}
?>
    <div id="content">
      <form name="form1" method="post" enctype="multipart/form-data" action="sp_pro_register_ok.php">
        <input type="hidden" name="con_html" value="1" />
        <input type="hidden" name="prod_code" value="<?=$prod_code;?>" />
        <table summary="register product">
          <tr class="odd">
            <th colspan="2"><img src="../images/order_state_mini_1.gif" width="16" height="16" /> <strong>관리 정보</strong></th>
          </tr>
          <tr class="odd">
            <th scope="row" class="column1">상품등록 관리</th>
            <td class="member"><input type="radio" name="del_chk" value="N" <?php if (($mode == 'insert') || ($update_row['del_chk'] == 'N')) {
    echo ("checked");
}
?>/>
              등록
              <input type="radio" name="del_chk" value="Y" <?php if ($update_row['del_chk'] == 'Y') {
    echo ("checked");
}
?> />
              판매중지(숨김)
              <input type="radio" name="del_chk" value="O" <?php if ($update_row['del_chk'] == 'O') {
    echo ("checked");
}
?> />
              <img src="../images/outofstock_icon.gif" alt="품절" width="43" height="16" /> </td>
          </tr>
          <tr>
            <th scope="row" class="column1">메인화면 표시</th>
            <td class="member"><input type="checkbox" name="main_new"
		  <?php if ($update_row['main_new'] == 'Y') {
    echo "checked";
}
?> />
              신상품
              <input type="checkbox" name="main_special"
		  <?php if ($update_row['main_special'] == 'Y') {
    echo "checked";
}
?> />
              기획상품
              <input type="checkbox" name="main_best"
		  <?php if ($update_row['main_best'] == 'Y') {
    echo "checked";
}
?> />
              인기상품</td>
          </tr>
          <tr class="odd">
            <th class="column1" scope="row">아이콘 표시</th>
            <td class="member"><input type="checkbox" name="option1_chk"
		  <?php if ($update_row['option1_chk'] == 'Y') {
    echo "checked";
}
?> />
              <img src="../images/New_icons_44.gif" alt="신상품" width="28" height="11" />
              <input type="checkbox" name="option2_chk"
		  <?php if ($update_row['option2_chk'] == 'Y') {
    echo "checked";
}
?> onclick="javascript:alert('아래 항목에서 해당 내용을 설정 또는 해제하세요.');" />
              <img src="../images/event_icon.gif" alt="기획상품" width="43" height="16" />
              <input type="checkbox" name="option3_chk"
		  <?php if ($update_row['option3_chk'] == 'Y') {
    echo "checked";
}
?> />
              <img src="../images/best_icon.gif" alt="인기상품" width="43" height="16" />
              <input type="checkbox" name="option4_chk"
		  <?php if ($update_row['option4_chk'] == 'Y') {
    echo "checked";
}
?> onclick="javascript:alert('아래 항목에서 해당 내용을 설정 또는 해제하세요.');" />
              <img src="../images/sale_icon.gif" alt="할인상품" width="43" height="16" />
              <input type="checkbox" name="option5_chk"
		  <?php if ($update_row['option5_chk'] == 'Y') {
    echo "checked";
}
?> />
              <img src="../images/delivery_icon.gif" alt="당사직송" width="43" height="16" /></td>
          </tr>
          <tr>
            <th rowspan="2" class="column1" scope="row">이벤트 신청</th>
            <td class="member"><input type="radio" name="event" value="0" <?php if (($mode == 'insert') || ($update_row['event'] == '0')) {
    echo ("checked");
}
?> />
              해당사항 없음(중지)
              <input type="radio" name="event" value="1" <?php if ($update_row['event'] == '1') {
    echo ("checked");
}
?>/>
              할인판매
              <input type="radio" name="event" value="2" <?php if ($update_row['event'] == '2') {
    echo ("checked");
}
?>/>
              사은품 증정
              <input type="radio" name="event" value="3" <?php if ($update_row['event'] == '3') {
    echo ("checked");
}
?>/>
              할인+사은품 증정
              <input type="radio" name="event" value="4" <?php if ($update_row['event'] == '4') {
    echo ("checked");
}
?>/>
              1+1 </td>
          </tr>
          <tr>
            <td class="member">기간 :
              <input type="text" class="w8em format-y-m-d divider-dash highlight-days-67 range-low-2008-01-01 no-transparency" name="date1" id="sd" value="<?=$update_row['date1'];?>" size="10" />
              &nbsp;~&nbsp;
              <input type="text" class="w8em format-y-m-d divider-dash highlight-days-67 range-low-2008-01-01 no-transparency" name="date2" id="ed" value="<?=$update_row['date2'];?>" size="10" />
            </td>
          </tr>
          <tr >
            <th colspan="2"><img src="../images/order_state_mini_1.gif" alt="" width="16" height="16" /> <strong>상품 정보</strong></th>
          </tr>
          <caption>
          상품 등록
          </caption>
          <tbody>
            <tr >
              <th scope="row" class="column1">대분류명</th>
              <td class="member"><select name="lcode" onChange="sp_change_code()">
                  <?php
$ca1_qry    = "SELECT * FROM products_category1 ";
$ca1_result = mysqli_query($connect, $ca1_qry);

for ($i = 0; $ca1_row = mysqli_fetch_array($ca1_result); $i++) {
    if ($ca1_row['code'] == $lcode) {
        ?>
                  <option value="<?=$ca1_row['code'];?>" selected="selected">
                  <?=$ca1_row['name'];?>
                  </option>
                  <?php
} else {
        ?>
                  <option value="<?=$ca1_row['code'];?>">
                  <?=$ca1_row['name'];?>
                  </option>
                  <?php

    }
}
mysqli_free_result($ca1_result);
?>
                </select>
                <select name="mcode" onChange="sp_change_code()">
                  <option value="">선택하세요</option>
                  <?php
$ca2_qry    = "SELECT * FROM products_category2 WHERE up_category='$lcode'";
$ca2_result = mysqli_query($connect, $ca2_qry);

for ($i = 0; $ca2_row = mysqli_fetch_array($ca2_result); $i++) {
    if ($ca2_row['code'] == $mcode) {
        ?>
                  <option value="<?=$ca2_row['code'];?>" selected="selected">
                  <?=$ca2_row['name'];?>
                  </option>
                  <?php
} else {
        ?>
                  <option value="<?=$ca2_row['code'];?>">
                  <?=$ca2_row['name'];?>
                  </option>
                  <?php
}
}
mysqli_free_result($ca2_result);
?>
                </select>
                <select name="scode" onChange="sp_change_code()">
                  <option value="">선택하세요</option>
                  <?php
$ca3_qry    = "SELECT * FROM products_category3 WHERE up_category='$mcode'";
$ca3_result = mysqli_query($connect, $ca3_qry);

for ($i = 0; $ca3_row = mysqli_fetch_array($ca3_result); $i++) {
    if ($ca3_row['code'] == $scode) {
        ?>
                  <option value="<?=$ca3_row['code'];?>" selected="selected" >
                  <?=$ca3_row['name'];?>
                  </option>
                  <?php
} else {
        ?>
                  <option value='<?=$ca3_row['code'];?>' >
                  <?=$ca3_row['name'];?>
                  </option>
                  <?php
}
}
mysqli_free_result($ca3_result);
?>
                </select>
              </td>
            </tr>
            <tr >
              <th scope="row" class="column1">상품명</th>
              <td class="member"><div align="left">
                  <input type="text" name="name" value="<?=$update_row['name'];?>" size="25" />
                </div></td>
            </tr>
            <tr class="odd">
              <th scope="row" class="column1">제조/공급사</th>
              <td class="member"><input type="text" name="company" value="<?=$update_row['company'];?>" />
              </td>
            </tr>
            <tr >
              <th scope="row" class="column1">원산지</th>
              <td class="member"><input name="origin" type="text" value="<?=$update_row['origin'];?>" />
              </td>
            </tr>
            <tr class="odd">
              <th scope="row" class="column1">소비자가</th>
              <td class="member"><input name="retail_price" class="num" type="text" value="<?=$update_row['retail_price'];?>" />
                원 (콤마없이 숫자로만 입력) (<img src="../images/warning.gif" alt="주의" />부가세 포함가로 입력하세요.)</td>
            </tr>
            <tr >
              <th scope="row" class="column1">할인가</th>
              <td class="member"><input name="sale_price" class="num" type="text"  value="<?=$update_row['sale_price'];?>" />
                원 (콤마없이 숫자로만 입력) (<img src="../images/warning.gif" alt="주의" />할인 시에만 입력)</td>
            </tr>
            <tr class="odd">
              <th scope="row" class="column1">고정공급가</th>
              <td class="member"><input name="fixed_price" class="num" type="text"  value="<?=$update_row['fixed_price'];?>" />
                원 (콤마없이 숫자로만 입력) (<img src="../images/warning.gif" alt="주의" />할인 등으로 별도의 공급가를 책정할 때만 입력)</td>
            </tr>
            <tr >
            <tr >
              <th scope="row" class="column1">최소 구매수량</th>
              <td class="member"><input type="text" class="num" name="moq" value="<?=$update_row['moq'];?>" size="5"/>
                개</td>
            </tr>
          <th scope="row" class="column1">구매 적립금</th>
            <td class="member"><input type="text" name="mileage" value="<?=$update_row['mileage'];?>" />
              원 (콤마없이 숫자로만 입력)</td>
          </tr>
          <tr class="odd">
            <th rowspan="2" class="column1" scope="row">옵션</th>
            <td class="member"><input name="opt" type="text" value="<?=$update_row['opt'];?>" size='50' >
              <p> 구분은 '|' 하세요 (예:블루|레드|블랙)</p></td>
          </tr>
          <tr class="odd">
            <td class="member"><input name="opt_stock" type="text" value="<?=$update_row['opt_stock'];?>" size='50' />
              <p>선택사항 별 재고 구분은 '|' 하세요 (예:100|100|100) </p></td>
          </tr>
          <tr>
            <th scope="row" class="column1">크기</th>
            <td class="member"><input type="text" name="size" value="<?=$update_row['size'];?>" />
              (예: 10 x 20 cm)</td>
          </tr>
          <tr class="odd">
            <th scope="row" class="column1">재질</th>
            <td class="member"><input type="text" name="material" value="<?=$update_row['material'];?>" /></td>
          </tr>
          <tr>
            <th scope="row" class="column1">재고</th>
            <td class="member"><input type="text" name="stock" size="5" value="<?=$update_row['stock'];?>" />
              개 (<img src="../images/warning.gif" alt="주의" /> 선택사항이 있을 경우 입력하지 마세요.)</td>
          </tr>
          <tr class="odd">
            <th colspan="2"><img src="../images/camera_picture.png" alt="" width="16" height="16" /> <strong>상품 이미지</strong></th>
          </tr>
          <tr >
            <th scope="row" class="column1">상품이미지 1(대:확대)</th>
            <td class="member"><input type="file" name="b_image1" size="30" />
              (400x400)
              <?php if ($update_row['b_image1']) {
    echo "<img src=\"$update_row[b_image1_name]\" width=\"50\" height=\"50\" onerror=\"this.src='../images/no_image50.gif'\"/>";
}
?></td>
          </tr>
          <tr class="odd">
            <th scope="row" class="column1">상품이미지 2(대:확대)</th>
            <td class="member"><input type="file" name="b_image2" size="30" />
              (400x400)
              <?php if ($update_row['b_image2']) {
    echo "<img src=\"$update_row[b_image2_name]\" width=\"50\" height=\"50\" onerror=\"this.src='../images/no_image50.gif'\"/>";
}
?></td>
          </tr>
          <tr >
            <th scope="row" class="column1">상품이미지 3(대:확대)</th>
            <td class="member"><input type="file" name="b_image3" size="30" />
              (400x400)
              <?php if ($update_row['b_image3']) {
    echo "<img src=\"$update_row[b_image3_name]\" width=\"50\" height=\"50\" onerror=\"this.src='../images/no_image50.gif'\"/>";
}
?></td>
          </tr>
          <tr class="odd">
            <th scope="row" class="column1">상품이미지 4(대:확대)</th>
            <td class="member"><input type="file" name="b_image4" size="30" />
              (400x400)
              <?php if ($update_row['b_image4']) {
    echo "<img src=\"$update_row[b_image4_name]\" width=\"50\" height=\"50\" onerror=\"this.src='../images/no_image50.gif'\"/>";
}
?></td>
          </tr>
          <tr >
            <th scope="row" class="column1">상품이미지 5(대:확대)</th>
            <td class="member"><input type="file" name="b_image5" size="30" />
              (400x400)
              <?php if ($update_row['b_image5']) {
    echo "<img src=\"$update_row[b_image5_name]\" width=\"50\" height=\"50\" onerror=\"this.src='../images/no_image50.gif'\"/>";
}
?></td>
          </tr>
          <tr class="odd">
            <th scope="row" class="column1">상품 상세설명</th>
            <td class="member"><textarea name="contents" id="contents" style="width:650px; height:300px"><?=stripslashes($update_row['contents']);?></textarea></td>
          </tr>
          <tr >
            <th scope="row" class="column1">상세설명 이미지</th>
            <td class="member"><input type="file" name="d_image" size="30" />
              (가로 600px)</td>
          </tr>
          </tbody>

        </table>
        <table>
          <tbody>
            <tr>
              <td align="center"><input type="hidden" name="mode" value="<?=$mode;?>" />
                <input type="hidden" name="p_num" value="<?=$p_num;?>" />
                <input type="hidden" name="level" value="<?=$level;?>" />
                <input type="hidden" name="page" value="<?=$page;?>" />
                <input type="hidden" name="old_l_cate" value="<?=$update_row['category_m'];?>" />
                <div class="clear"><a class="button" href="#" onclick="this.blur();javascript:send_post();"><span>등록</span></a><a class="button" href="#" onclick="this.blur();javascript:document.form1.reset();"><span>다시 쓰기</span></a><a class="button" href="sp_products_list.php?lcode=<?=$lcode;?>&mcode=<?=$mcode;?>&scode=<?=$scode;?>&page=<?=$page;?>" onclick="this.blur();"><span>취소</span></a></div></td>
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
<script>
if (typeof CKEDITOR !== 'undefined') {
    CKEDITOR.replace('contents', {
        width: '100%',
        height: '350px'
    });
}
</script>
</html>
