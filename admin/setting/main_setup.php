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
      <?php
$qry  = "SELECT * FROM main_setup ";
$res  = mysqli_query($connect, $qry);
$rows = mysqli_fetch_array($res);

?>
      <form name="form" action="main_setup_ok.php" method="post" enctype="multipart/form-data">
        <table summary="main setup">
          <thead>
            <tr>
              <th colspan="2">메인 화면 설정</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th width="16%" class="column1">메인 상단 로고</th>
              <td width="84%" class="member"><input type="file" name="logo_image" />
                &nbsp;
                <?php echo ($rows['logo_image'] == 'Y') ? "<img src=\"$rows[logo_image_name]\" width=\"150\" alt=\"[LOGO]\" />" : "[로고 이미지를 등록해 주세요.]";?>
                <p>이미지 사이즈: 200x50px 으로 등록해 주세요.</p></td>
            </tr>
            <tr class="odd">
              <th class="column1">신상품 타이틀바</th>
              <td class="member"><input type="file" name="new_image" />
                &nbsp;
                <?php echo ($rows['new_image'] == 'Y') ? "<img src=\"$rows[new_image_name]\" width=\"300\" alt=\"[신상품]\" />" : "[이미지를 등록해 주세요.]";?>
                <p>이미지 사이즈: 928x40px 으로 등록해 주세요.</p></td>
            </tr>
            <tr class="odd">
              <th class="column1">신상품 전시</th>
              <td class="member"><input type="checkbox" name="show_new" value="Y" <?php if ($rows['show_new'] == "Y") {
    echo "checked=\"checked\"";
}
?>  />
                메인에 보이기 / 보여줄 상품 갯수:
                  <input type="text" class="num" name="new_num" size="2" value="<?php echo $rows['new_num'];?>" />
                  개 (5개 단위)</td>
            </tr>
            <tr>
              <th class="column1">기획상품 타이틀바</th>
              <td class="member"><input type="file" name="special_image" />
                &nbsp;
                <?php echo ($rows['special_image'] == 'Y') ? "<img src=\"$rows[special_image_name]\" width=\"300\" alt=\"[기획상품]\" />" : "[이미지를 등록해 주세요.]";?>
                <p>이미지 사이즈: 928x40px 으로 등록해 주세요.</p></td>
            </tr>
            <tr>
              <th class="column1">기획상품 전시</th>
              <td class="member"><input type="checkbox" name="show_special" value="Y" <?php if ($rows['show_special'] == "Y") {
    echo "checked=\"checked\"";
}
?>  />
                메인에 보이기 / 보여줄 상품 갯수:
                <input type="text" class="num" name="special_num" size="2" value="<?php echo $rows['special_num'];?>" />
                개 (5개 단위)</td>
            </tr>
            <tr class="odd">
              <th class="column1">인기상품 타이틀바</th>
              <td class="member"><input type="file" name="best_image" />
                &nbsp;
                <?php echo ($rows['best_image'] == 'Y') ? "<img src=\"$rows[best_image_name]\" width=\"300\" alt=\"[인기상품]\" />" : "[이미지를 등록해 주세요.]";?>
                <p>이미지 사이즈: 928x40px 으로 등록해 주세요.</p></td>
            </tr>
            <tr class="odd">
              <th class="column1">인기상품 전시</th>
              <td class="member"><input type="checkbox" name="show_best" value="Y" <?php if ($rows['show_best'] == "Y") {
    echo "checked=\"checked\"";
}
?>  />
                메인에 보이기 / 보여줄 상품 갯수:
                <input type="text" class="num" name="best_num" size="2" value="<?php echo $rows['best_num'];?>" />
                개 (5개 단위)</td>
            </tr>
          </tbody>
        </table>
        <table summary="buttons">
          <tbody>
            <tr>
              <td> <div class="clear"><a class="button" href="#" onclick="this.blur();javascript:document.form.submit();"><span>업로드</span></a></div></td>
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
