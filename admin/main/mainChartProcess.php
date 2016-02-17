<?php

include "../include/admin_auth.php";
include "../../util/config.php";
include "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

$start_date = date("Y-m-01");
$today      = date("Y-m-d");

//1. 전체 주문을 구한다.
$sql = "SELECT * FROM mall_order WHERE cancel='N' AND status='8' AND date(createdate) BETWEEN '$start_date' AND '$today'  ORDER BY num DESC";
$res = mysqli_query($connect, $sql);

//2. 각 주문에서 제품코드를 구한다.
for ($i = 0; $row = mysqli_fetch_array($res); $i++) {
    $a_goods_fk = explode(",", $row['goods_fk']);
    $mod_volume = explode(",", $row['mod_count']); //변경된 수량

    //3. 해당 주문에서 해당 공급업체의 상품이 있는지 확인한다.
    for ($j = 0; $j < sizeof($a_goods_fk); $j++) {
        $p_sql    = "SELECT * FROM products WHERE num='" . $a_goods_fk[$j] . "' ";
        $p_result = mysqli_query($connect, $p_sql);
        $p_row    = mysqli_fetch_array($p_result);
        $p_no     = mysqli_num_rows($p_result);

        // $offer_price = $mod_price[$j];

        $goods[] = array(
            'num'      => $p_row['num'],
            'name'     => $p_row['name'],
            'quantity' => $mod_volume[$j],
        );

        //$total += $sub_total;
    } // inner for end
} // outer for end

function cmp($a, $b)
{
    if ($a["quantity"] == $b["quantity"]) {
        return 0;
    }

    return ($a["quantity"] > $b["quantity"]) ? -1 : 1;

}

if ($p_no) {

    foreach ($goods as $key => $values) {
        $new[$values['num']]['name'] = $values['name'];

        if (isset($values['quantity'])) {
            $new[$values['num']]['quantity'] += $values['quantity'];
        }

    }

    unset($values);
    usort($new, "cmp"); //수량에 따라 정열

    // $i = 0;

    foreach ($new as $row) {
        $data[] = array(
            'item'     => $row['name'],
            'quantity' => $row['quantity'],
        );
    }

    unset($row);

}

// monthly sales
$one_year = date("Y-m-01", strtotime("-1 year"));
$sql      = "SELECT date_format(createdate, '%Y-%m') AS group_date, sum(last_amount) AS sum_amount FROM mall_order
                                      WHERE cancel='N' AND status='8' AND date_format(createdate, '%Y-%m-%d') >= '$one_year'
                                      GROUP BY date_format(createdate, '%Y-%m')  ";

$res = mysqli_query($connect, $sql);

for ($i = 0; $row = mysqli_fetch_array($res); $i++) {
    $sales_data[] = array(
        'period' => $row['group_date'],
        'amount' => $row['sum_amount'],
    );
}

// $sales_data = array(
//     array(
//         "period" => "2015-06",
//         "amount" => 120000000,
//     ),
//     array(
//         "period" => "2015-05",
//         "amount" => 150000000,
//     ),
//     array(
//         "period" => "2015-04",
//         "amount" => 140000000,
//     ),
//     array(
//         "period" => "2015-03",
//         "amount" => 130000000,
//     ),
//     array(
//         "period" => "2015-02",
//         "amount" => 120000000,
//     ),
// );

echo json_encode(array("item" => $data, "monthly" => $sales_data));
