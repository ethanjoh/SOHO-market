<?php
$file_name = "tracklist_a_" . date("Y-m-d");
header("Content-type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=$file_name.xls");
header("Content-Description: PHP4 Generated Data");
include_once "../include/admin_auth.php";
include_once "../../util/util.php";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
  <head>
    <title>운송장 출력</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  </head>
  <body>
    <table summary="view the total order list" border="1">
      <tbody>
<?php

$date1 = set_var($_GET['date1']);
$date2 = set_var($_GET['date2']);
//$today = date("Y-m-d");
if (empty($date1)) {
    $date1 = $date1;
}
if (empty($date2)) {
    $date2 = $date2;
}
$sql = "SELECT * FROM mall_order
                  WHERE delivery_type = 'L'
                  AND cancel = 'N'
                  AND status = '7'
                  AND trans_cost <> '-1'
                  ORDER BY num DESC ";
/*
$sql = "SELECT * FROM mall_order
WHERE delivery_type='L'
AND cancel = 'N'
AND status = '7'
AND createdate BETWEEN '$date1' AND '$date2'
ORDER BY num DESC ";
 */
$res  = mysqli_query($connect, $sql);
$t_no = mysqli_num_rows($res);

if ($t_no > 0) {
    for ($i = 0; $row = mysqli_fetch_array($res); $i++) {
        ?>
        <tr>
          <td><?php echo $row['orderid']; ?></td>
          <td><?php echo $row['recipient_name'] ? $row['recipient_name'] : $row['buyer_name']; ?></td>
<?php

//상품명 가져옴
        $a_goods_fk = explode(",", $row['goods_fk']);
        $pro_sql    = "SELECT * FROM products WHERE num='$a_goods_fk[0]'";
        $pro_result = mysqli_query($connect, $pro_sql);
        $pro_row    = mysqli_fetch_array($pro_result);

        if (count($a_goods_fk) > 1) {
            $goods_name = cut_string_utf8($pro_row['name'], 30, '...');
            $goods_name .= " (외)";
        } else {
            $goods_name = cut_string_utf8($pro_row['name'], 30, '...');
        }

        //배송정책 가져옴
        // $re = define_delivery_fee($row['trans_cost']);
        //
        // 택배비 결정 및 제주도 택배비 설정
        if ($row['recipient_name']) {
            $re = define_delivery_fee($row['trans_cost'], $row['recipient_zipcode']);
        } else {
            $re = define_delivery_fee($row['trans_cost'], $row['buyer_zipcode']);
        }
        ?>
          <td><?php echo $goods_name; ?></td>
          <td>1</td>
          <td><?php echo $row['recipient_name'] ? $row['recipient_zipcode'] : $row['buyer_zipcode']; ?></td>
          <td><?php echo $row['recipient_name'] ? $row['recipient_address'] : $row['buyer_address']; ?></td>
          <td><?php echo $row['recipient_name'] ? $row['recipient_phone'] : $row['buyer_phone']; ?></td>
          <td><?php echo $row['recipient_name'] ? $row['recipient_hphone'] : $row['buyer_hphone']; ?></td>
          <td><?php echo $re['credit']; ?></td>
          <td><?php echo $re['t_cost']; ?></td>
          <td>
<?php

        if ($row['memo_to_delivery']) {
            echo $row['memo_to_delivery'];
        }
        ?></td>
          <td><?php echo $re['jeju']; ?></td>
        </tr>
<?php

    }

} else {
    ?>
        <tr>
          <td colspan="12"><p>해당 주문내역이 없습니다.</p></td>
        </tr>
<?php

}
?>
      </tbody>
    </table>
  </body>
</html>