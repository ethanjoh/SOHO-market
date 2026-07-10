<?php
include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

//거래명세서, 세금계산서 출력용 클래스정의 파일
include "../include/class.trade_note.php";
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8" />
<title>거래명세서 출력</title>
</head>

<body>
<?php
$today = date("Y-m-d");

//공급자 정보
$query  = "SELECT * FROM admin_setup WHERE type='1'";
$result = mysqli_query($connect, $query);
$row    = mysqli_fetch_array($result);

$address = $row['addr1'] . " " . $row['addr2'];

//거래명세서 출력용 라이브러리
$NFORM = new Gizmo_TradeNote;

// VAT포함가로 출력합니다. $NFORM->AddArticle() 로 단가 또는 금액 입력시 VAT 포함가가 들어가야 합니다.
// $NFORM->SetTaxAdded(false); 이면 입력하는 단가나 금액은 VAT 별도가입니다.
$NFORM->SetTaxAdded(false);

// 공급자 정보를 입력합니다. 상호는 필수.
$NFORM->SetCompany($row['company_name'], $row['ceo'], $row['license_no'], $address, $row['category1'], $row['category2']);

// 작성일을 'YYYY-mm-dd' 포맷으로 지정합니다.
$NFORM->SetIssuedDate($today);

// 명세서 일련번호를 설정합니다.
$serial = date(Ymd) + rand(0, 1000);
$NFORM->SetSerial($serial);

// 페이지 번호를 입력합니다.
$NFORM->SetPage(1);

// 출력매수 (공통:BOTH(공급자용/공급받는자용), 세금계산서:BLUE(공급받는자용만)/RED(공급자용만), 거래명세서:SINGLE(1매만)
$NFORM->SetPair('BOTH');

// 공급자 직인 이미지의 URL경로 (배경이 투명해야함, 60*60px 이하가 적당)
$NFORM->SetSignPath($row['sign_image_name']);

//주문정보
$or_qry = "SELECT * FROM mall_order WHERE num = '$oid' ";
$or_res = mysqli_query($connect, $or_qry);
$or_row = mysqli_fetch_array($or_res);

$a_goods_fk = explode(",", $or_row['goods_fk']);
$mod_price  = explode(",", $or_row['mod_price']); //변경된 공급가
$mod_volume = explode(",", $or_row['mod_count']); //변경된 수량
$option     = explode(",", $or_row['goods_kind']); //옵션

// 공급받는자 정보를 입력합니다. 상호는 필수.
if ($from != "quot") {
    $buyer_qry = "SELECT * FROM member WHERE id='$or_row[user_id]'";
    $buyer_res = mysqli_query($connect, $buyer_qry);
    $buyer_row = mysqli_fetch_array($buyer_res);

    $address2 = $buyer_row['o_addr1'] . " " . $buyer_row['o_addr2'];

    $NFORM->SetCustomer($buyer_row['company_name'], $address2, $buyer_row['o_phone']); //주문자 정보
} else {
    $NFORM->SetCustomer($or_row['buyer_name'], $or_row['buyer_address'], $or_row['buyer_phone']); // 견적요청자 정보
}

//주문상품 정보를 불러옵니다.
for ($i = 0; $i < sizeof($a_goods_fk); $i++) {
    $pro_sql    = "SELECT * FROM products WHERE num='$a_goods_fk[$i]'";
    $pro_result = mysqli_query($connect, $pro_sql);
    $pro_row    = mysqli_fetch_array($pro_result);

    $goods_name = "[" . $pro_row['company'] . "] " . $pro_row['name'];

    // 품목정보를 필요한 만큼 입력합니다.
    // 단가나 금액은 한가지만 넣어주면 수량을 참조하여 나머지를 자동으로 채워 넣습니다.
    // 단가와 금액 모두를 넣어주면 별도로 연산하지 않고 그대로 사용합니다.
    // (bool)영수에 false 를 지정하면 [청구]로 표시되며, 하단에 청구금액으로 합산됩니다.
    //$NFORM->AddArticle('품목명', (int)단가, (int)금액(단가*수량), (int)수량, '거래일(YYYY-mm-dd)', '규격', '비고', (bool)영수);
    $NFORM->AddArticle($goods_name, $mod_price[$i], '', $mod_volume[$i], $today, $option[$i], '', false);
}

// 거래명세서 HTML 양식 출력
// 인수로 양식파일의 경로를 지정할 수 있습니다. 기본 설치했을 경우는 현재 디렉토리의 form_note.php 를 불러옵니다.
if ($from != "quot") {
    $NFORM->PrintNote(); //거래명세서 출력
} else {
    $NFORM->PrintQuot(); //견적서 출력
}
?>
</body>
</html>
