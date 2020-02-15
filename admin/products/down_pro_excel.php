<?php
$file_name = "products_list";

header("Content-type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=$file_name.xls");
header("Content-Description: PHP4 Generated Data");

include_once "../include/admin_auth.php";
include_once "../../util/util.php";

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>
<title>상품목록 다운로드</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
</head>
<body>
<table summary="view the total order list" border="1">
  <tbody>
    <?php

$sql = "SELECT * FROM products ORDER BY num ";

$res = mysqli_query($connect, $sql);

for ($i = 0; $row = mysqli_fetch_array($res); $i++) {
    ?>
    <tr>
      <td><?php echo $row['num']; ?></td>
      <td><?php echo $row['name']; ?></td>
      <td><?php echo $row['opt']; ?></td>
      <td><?php echo $row['opt_count']; ?></td>
      <td><?php echo $row['opt_stock']; ?></td>
    </tr>
    <?php

}
; // for loop end
?>

  </tbody>
</table>
</body>
</html>
