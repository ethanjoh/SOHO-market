<?php
$file_name = $lcode . "_pro_list_" . date("Y-m-d");

header("Content-type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=$file_name.xls");
header("Content-Description: PHP4 Generated Data");

include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<title>상품 목록</title>
<meta charset="UTF-8" />
</head>
<body>
<?php
// 상품의 정보를 모두 가져옴
$query  = "SELECT * FROM products WHERE del_chk <> 'Y' AND category_l ='$lcode' ";
$result = mysqli_query($connect, $query);

if ($result) {
    $total = mysqli_num_rows($result);
    mysqli_free_result($result);
}
?>

      <table border="1">
        <thead>
          <tr>
            <th>이미지</th>
            <th>제품명</th>
            <th>옵션</th>
            <th>소비자가</th>
            <th>할인가</th>
          </tr>
        </thead>
        <tbody>
          <?php

$query1  = "SELECT * FROM products WHERE del_chk <> 'Y' AND category_l ='$lcode' ORDER BY num DESC ";
$result1 = mysqli_query($connect, $query1);

if ($result1) {
    //에러처리

    for ($i = 0; $prow = mysqli_fetch_array($result1); $i++) {

        $path = explode("/", $prow['s_image_name']);

        if ($i % 2 == 1) {
            echo "<tr class=\"odd\">\n";
        } else {
            echo "<tr>\n";
        }

        ?>
          <td height="55"><img src="http://www.<?=$_SERVER['SERVER_NAME'];?>/upload/p_image/s/<?=$path[5];?>" width="50" height="50" alt="small image" /></td>
          <td><?=stripslashes($prow['name']);?></td>
          <td><?php
if ($prow['opt']) {
            echo $prow['opt'];
        }

        ?></td>
          <td><?=number_format(trim($prow['retail_price']));?></td>
          <td><?php

        if ($prow['sale_price'] > 0) {
            ?>
            <?=number_format(trim($prow['sale_price']));?>
            <?php
}
        ?></td>

        <?php
}

}
; //if($result1)

?>
        <?php
if ($total == 0) {
    ?>
        <tr>
          <td colspan="5"><p>등록된 상품이 없습니다.</p></td>
        </tr>
        <?php
}
?>
          </tbody>

      </table>
</body>
</html>
