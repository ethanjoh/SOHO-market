// 토스페이먼츠 결제 승인을 서버 간 API 통신으로 최종 처리하고 DB 주문 데이터를 적재하는 완료 페이지
<?php
include_once '../include/header.php';

// 세션 시작
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$paymentKey = set_var($_GET['paymentKey']);
$orderId    = set_var($_GET['orderId']);
$amount     = set_var($_GET['amount']);

if (empty($paymentKey) || empty($orderId) || empty($amount)) {
    err_msg('잘못된 결제 승인 요청입니다.');
    exit;
}

// 1. 토스페이먼츠 결제 승인 API 호출 (cURL 활용)
$secretKey = $tossSecretKey;
$credential = base64_encode($secretKey . ":");

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.tosspayments.com/v1/payments/confirm",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode([
        "paymentKey" => $paymentKey,
        "orderId" => $orderId,
        "amount" => (int)$amount
    ]),
    CURLOPT_HTTPHEADER => [
        "Authorization: Basic " . $credential,
        "Content-Type: application/json"
    ]
]);

$response = curl_exec($curl);
$status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

$result = json_decode($response, true);

?>

<section class="collapse_area">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="check">
                    <h1>주문 처리결과</h1>
                </div>

<?php
if ($status_code === 200 && isset($result['status']) && ($result['status'] === 'DONE' || $result['status'] === 'WAITING_FOR_DEPOSIT')) {
    // 결제 승인 성공
    
    // 2. 임시 저장해둔 세션 정보를 $_POST에 복원하여 기존 변수 할당 파일(variables_from_payreq.php)이 동작하도록 매핑
    if (isset($_SESSION['toss_temp_order'])) {
        $_POST = $_SESSION['toss_temp_order'];
    }
    
    $sessionFlag = isset($_SESSION['p_flag']) ? $_SESSION['p_flag'] : 'p';
    
    // U+ 변수 규격으로 변환하여 매핑 수행
    $LGD_OID = $orderId;
    $LGD_TID = $paymentKey;
    $LGD_AMOUNT = $amount;
    $LGD_RESPCODE = '0000';
    $LGD_RESPMSG = '성공';
    $LGD_PAYDATE = date('YmdHms');
    $LGD_TIMESTAMP = date('YmdHms');
    $LGD_ESCROWYN = $result['useEscrow'] ? 'Y' : 'N';
    
    // 결제 수단 판정 및 금융사명 바인딩
    $toss_method = $result['method'];
    $LGD_PAYTYPE = 'SC0010'; // 기본 신용카드
    $LGD_FINANCENAME = '';
    $LGD_FINANCECODE = '';
    $LGD_FINANCEAUTHNUM = '';
    
    // 가상계좌 전용 변수
    $LGD_ACCOUNTNUM = '';
    $LGD_CASTAMOUNT = '0';
    $LGD_CASCAMOUNT = '0';
    $LGD_CASFLAG = '';
    $LGD_CASSEQNO = '';
    
    // 신용카드 전용 변수
    $LGD_CARDNUM = '';
    $LGD_CARDINSTALLMONTH = '0';
    $LGD_CARDNOINTYN = 'N';
    $LGD_TRANSAMOUNT = $amount;
    $LGD_EXCHANGERATE = '1';
    
    // 현금영수증 관련 변수
    $LGD_CASHRECEIPTNUM = '';
    $LGD_CASHRECEIPTSELFYN = 'N';
    $LGD_CASHRECEIPTKIND = '';
    $LGD_DEFAULTCASHRECEIPTUSE = '';

    if ($toss_method === '카드') {
        $LGD_PAYTYPE = 'SC0010';
        $LGD_FINANCENAME = $result['card']['company'];
        $LGD_FINANCECODE = $result['card']['issuerCode'];
        $LGD_FINANCEAUTHNUM = $result['card']['approveNo'];
        $LGD_CARDNUM = $result['card']['number'];
        $LGD_CARDINSTALLMONTH = $result['card']['installmentPlanMonths'];
        $LGD_CARDNOINTYN = $result['card']['isInterestFree'] ? 'Y' : 'N';
    } elseif ($toss_method === '계좌이체') {
        $LGD_PAYTYPE = 'SC0030';
        $LGD_FINANCENAME = $result['transfer']['bank'];
    } elseif ($toss_method === '가상계좌') {
        $LGD_PAYTYPE = 'SC0040';
        $LGD_FINANCENAME = $result['virtualAccount']['bank'];
        $LGD_ACCOUNTNUM = $result['virtualAccount']['accountNumber'];
        $LGD_CASFLAG = 'R'; // 할당 상태 표시
        $LGD_CASCAMOUNT = $amount;
    }
    
    // DB 등록을 위한 변수 생성 처리 호출
    require_once 'variables_from_payreq.php';
    
    // 3. 주문 DB 처리 (mall_order 테이블 적재)
    $query = "INSERT INTO mall_order(orderid,goods_fk,goods_price, mod_price,
                            goods_name,goods_kind,goods_count,mod_count,
                            user_id, user_flag, amount, volume, trans_cost, createdate,
                            buyer_name,buyer_zipcode,buyer_address,buyer_phone,
                            buyer_hphone,buyer_email,
                            recipient_name,recipient_zipcode,recipient_address,
                            recipient_phone,recipient_hphone,payment_type,status,
                            delivery_type, memo_to_delivery, memo_to_admin )
     VALUES ('$trade_code','$temp_code','$temp_price', '$temp_price',
            '$temp_name','$temp_kind', '$temp_count', '$temp_count',
            '$user_id', '$sessionFlag','$tot_money', '$temp_count','$trans_cost', now(),
            '$buyer_name','$buyer_zipcode', '$buyer_address', '$buyer_phone',
            '$buyer_hphone', '$buyer_email',
            '$recipient_name', '$recipient_zipcode','$recipient_address',
            '$recipient_phone','$recipient_hphone', '$payment_type', '$status',
            '$delivery_type', '$memo_to_delivery', '$memo_to_admin')";

    $result_db = mysqli_query($connect, $query);

    if (!$result_db) {
        echo "<div class='alert alert-danger'>데이터베이스 에러가 발생했습니다: " . mysqli_error($connect) . "</div>";
    } else {
        // SMS 발송 처리
        $res     = mysqli_query($connect, "SELECT * FROM sms");
        $sms_row = mysqli_fetch_array($res);

        if ($sms_row && $sms_row['sms'] == "Y") {
            if ($sms == "Y" && $sms_row['order_chk'] == "Y") {
                send_sms($buyer_hphone, 3, $buyer_name, "", $connect);
            }
            if ($sms_row['orderin_chk'] == "Y") {
                send_sms("self", 2, $buyer_name, "", $connect);
            }
        }
    }

    // 4. 결제 정보 DB 백업 저장 (pg_info 테이블 적재)
    $query2 = "INSERT INTO pg_info(LGD_RESPCODE, LGD_RESPMSG, LGD_MID, LGD_OID, LGD_AMOUNT, LGD_TID, LGD_PAYTYPE, LGD_PAYDATE,
                                        LGD_HASHDATA, LGD_FINANCECODE, LGD_FINANCENAME, LGD_ESCROWYN, LGD_TIMESTAMP, LGD_FINANCEAUTHNUM,
                                        LGD_CARDNUM, LGD_CARDINSTALLMONTH, LGD_CARDNOINTYN, LGD_TRANSAMOUNT, LGD_EXCHANGERATE, LGD_ACCOUNTNUM,
                                        LGD_CASTAMOUNT, LGD_CASCAMOUNT, LGD_CASFLAG, LGD_CASSEQNO, LGD_CASHRECEIPTNUM, LGD_CASHRECEIPTSELFYN, LGD_CASHRECEIPTKIND, LGD_DEFAULTCASHRECEIPTUSE)
                                VALUES ('$LGD_RESPCODE', '$LGD_RESPMSG', '$LGD_MID', '$LGD_OID', '$LGD_AMOUNT', '$LGD_TID', '$LGD_PAYTYPE', '$LGD_PAYDATE',
                                        '$LGD_HASHDATA', '$LGD_FINANCECODE', '$LGD_FINANCENAME', '$LGD_ESCROWYN', '$LGD_TIMESTAMP', '$LGD_FINANCEAUTHNUM',
                                        '$LGD_CARDNUM', '$LGD_CARDINSTALLMONTH', '$LGD_CARDNOINTYN', '$LGD_TRANSAMOUNT', '$LGD_EXCHANGERATE', '$LGD_ACCOUNTNUM',
                                        '$LGD_CASTAMOUNT', '$LGD_CASCAMOUNT', '$LGD_CASFLAG', '$LGD_CASSEQNO', '$LGD_CASHRECEIPTNUM', '$LGD_CASHRECEIPTSELFYN', '$LGD_CASHRECEIPTKIND',
                                        '$LGD_DEFAULTCASHRECEIPTUSE' )";

    mysqli_query($connect, $query2);

    // 5. 주문상품 장바구니에서 삭제
    for ($i = 0; $i < sizeof($products_num); $i++) {
        $qry_del = "DELETE FROM products_cart WHERE user_id = '$user_id' AND product_code='$products_num[$i]' ";
        mysqli_query($connect, $qry_del);
    }

    // 6. 이메일 발송 처리
    $com_info = get_company_info();
    switch ($LGD_PAYTYPE) {
        case 'SC0010': $pay_type = "신용카드 - " . $LGD_FINANCENAME; break;
        case 'SC0030': $pay_type = "실시간 계좌이체 - " . $LGD_FINANCENAME; break;
        case 'SC0040': $pay_type = "무통장입금(가상계좌) - " . $LGD_FINANCENAME; break;
        default: $pay_type = "기타 - " . $LGD_FINANCENAME; break;
    }
    
    $sender = "=?EUC-KR?B?" . base64_encode(iconv("UTF-8", "EUC-KR", $com_info['company_name'])) . "?=\r\n";
    $sender_email = 'noreply@' . $_SERVER['SERVER_NAME'];
    $subject = $buyer_name . "님, 주문하신 내역입니다.";
    
    // 메일 내용 빌드 및 발송
    require_once 'payres_email.php';
    
    // 7. 세션 클리어
    unset($_SESSION['toss_temp_order']);
    
    // 결과 화면 템플릿 출력
    ?>
    <div class="alert alert-success" role="alert">주문이 성공적으로 완료되었습니다! 주문조회에서 확인하세요.</div>
    <table class="table table-striped">
        <tr>
            <th>거래번호 :</th>
            <td><?php echo $LGD_TID; ?></td>
        </tr>
        <tr>
            <th>주문번호 :</th>
            <td><?php echo $LGD_OID; ?></td>
        </tr>
        <tr>
            <th>결제금액 :</th>
            <td><?php echo number_format($LGD_AMOUNT); ?> 원</td>
        </tr>
        <tr>
            <th>결제수단 :</th>
            <td><?php echo $pay_type; ?></td>
        </tr>
        <?php if ($toss_method === '가상계좌') { ?>
        <tr>
            <th>입금은행 :</th>
            <td><?php echo $LGD_FINANCENAME; ?></td>
        </tr>
        <tr>
            <th>입금계좌번호 :</th>
            <td><strong style="color:#0054ff;"><?php echo $LGD_ACCOUNTNUM; ?></strong> (예금주: <?php echo $com_info['company_name']; ?>)</td>
        </tr>
        <?php } ?>
    </table>
    
    <div class="row payinfo-button" style="margin-top:20px;">
        <button type="button" class="btn btn-success" id="success" onclick="window.location.href='/shop/order-list.php'">주문조회 가기</button>
    </div>
    
    <?php
} else {
    // 결제 승인 실패 또는 에러 응답
    $error_msg = isset($result['message']) ? $result['message'] : '승인 처리 도중 알 수 없는 에러가 발생했습니다.';
    ?>
    <div class="alert alert-danger" role="alert">결제 처리에 실패하였습니다.</div>
    <div class="panel panel-default">
        <div class="panel-body text-center" style="padding: 40px 0;">
            <p style="font-size: 16px; color:#e00; margin-bottom:20px;"><i class="fa fa-exclamation-triangle"></i> <?php echo htmlspecialchars($error_msg); ?></p>
            <button type="button" class="btn btn-primary" onclick="window.location.href='/shop/cart.php'">장바구니로 돌아가기</button>
        </div>
    </div>
    <?php
}
?>
            </div>
        </div>
    </div>
</section>

<?php
include_once '../include/footer.php';
?>
