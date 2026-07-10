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
// 상위카테고리 코드값으로 부터 현 카테고리 값을 구함
$query       = "SELECT * FROM products_category3 WHERE up_category='$mcode' ";
$result      = mysqli_query($connect, $query);
$total_count = mysqli_num_rows($result);
?>
      <form method="post" action="ca_ssub_list.php">
        <table summary="view category list">
          <caption>
          소분류 목록 (총 <?php echo $total_count;?>개)
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
for ($i = 0; $row = mysqli_fetch_array($result); $i++) {
    $query2         = "SELECT * FROM products WHERE category_s='$row[code]'";
    $result2        = mysqli_query($connect, $query2);
    $products_count = mysqli_num_rows($result2);
    mysqli_free_result($result2);

    if ($i % 2 == 1) {
        echo "<tr class=\"odd\">\n";
    }

    ?>
            <td><?php echo $row['code'];?></td>
            <td><?php echo $row['name'];?></td>
            <td><?php echo $products_count;?></td>
            <td><a href='ca_ssub_register.php?mode=update&amp;id=<?php echo $row['id'];?>&amp;lcode=<?php echo $lcode;?>&amp;mcode=<?php echo $row['up_category'];?>'><img src="../images/edit.gif" alt="수정" /></a>&nbsp; <a href='ca_ssub_delete.php?id=<?php echo $row['id'];?>&amp;lcode=<?php echo $lcode;?>&amp;mcode=<?php echo $row['up_category'];?>' onClick="return confirm('정말 삭제하시겠습니까?')"><img src="../images/delete.gif" alt="삭제" /></a> </td>
          </tr>
          <?php
}
//mysqli_free_result($result);

if ($total_count == 0) {
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
            <td align="center"><div class="full"><a class="button" href="ca_ssub_register.php?lcode=<?php echo $lcode;?>&amp;mcode=<?php echo $mcode;?>" onclick="this.blur();"><span>소분류 등록하기</span></a><a class="button" href="ca_msub_list.php?lcode=<?php echo $lcode;?>&amp;mcode=<?php echo $mcode;?>" onclick="this.blur();"><span>중분류로 가기</span></a><a class="button" href="top_ca_list.php" onclick="this.blur();"><span>대분류로 가기</span></a></div></td>
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
