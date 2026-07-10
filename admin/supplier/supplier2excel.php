<?php

$file_name = "supplier_list_" . date("Y-m-d");

header("Content-type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=$file_name.xls");
header("Content-Description: PHP4 Generated Data");

include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

$sel = $_GET['sel'];

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<title>B2B SCM</title>
<meta charset="UTF-8" />
</head>
<body>
<!-- wrapper -->
<?php

//회원 테이블의 리스트를 불러옵니다.
$query  = "SELECT * FROM supplier WHERE 1 ORDER BY company_name";
$result = mysqli_query($connect, $query);
$total  = mysqli_num_rows($result);

?>
<table>
  <tbody>
    <td>First Name</td>
    <td>E-mail Address</td>
    <td>Business Phone</td>
    <td>Mobile Phone></td>
    <?php

$sql_2    = "SELECT * FROM supplier WHERE 1 ORDER BY company_name";
$result_2 = mysqli_query($connect, $sql_2);
$total_2  = mysqli_num_rows($result_2);

if ($total_2) {
    for ($i = 1; $list = mysqli_fetch_array($result_2); $i++) {

        $bunho = $total - ($i + $cline) + 1;

        if ($i % 2 == 0) {
            echo "<tr>\n";
        } else {
            echo "<tr>\n";
        }

        ?>
    <td><?=stripslashes($list['company_name']);?></td>
    <td><?=$list['md_email'];?></td>
    <td><?=$list['o_phone'];?></td>
    <td><?=$list['md_hphone'];?></td>
  </tr>
  <?php
}
    mysqli_free_result($result_2);
} else {
    ?>
  <tr>
    <td colspan="4"><p>등록된 업체가 없습니다.</p></td>
  </tr>
  <?php
}
?>
    </tbody>

</table>
n
<!-- wrapper end -->
</body>
</html>
