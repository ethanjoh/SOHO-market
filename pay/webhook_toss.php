// 토스페이먼츠 가상계좌(무통장입금) 및 결제 상태 통보 웹훅 수신 처리 스크립트
<?php
require_once '../util/util.php';

// 세션 시작 (사용자 상태 체크 등을 위한 참조용)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 1. 토스페이먼츠 웹훅 JSON 데이터 수신
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (empty($data) || !isset($data['eventType'])) {
    http_response_code(400);
    echo "FAIL (Invalid Payload)";
    exit;
}

$eventType = $data['eventType'];
$orderId = set_var($data['data']['orderId']);
$paymentKey = set_var($data['data']['paymentKey']);
$amount = set_var($data['data']['amount']);

// 기존 입금 처리 및 후처리 파일(save_wireinfo_to_db.php)에 필요한 공통 변수 셋팅
$lgd_oid = $orderId;
$LGD_OID = $orderId;
$LGD_TID = $paymentKey;
$LGD_AMOUNT = $amount;
$LGD_RESPCODE = '0000';
$LGD_RESPMSG = '성공';
$LGD_PAYDATE = date('YmdHms', strtotime($data['createdAt']));
$LGD_TIMESTAMP = date('YmdHms');
$LGD_ESCROWYN = 'N';

// 가상계좌 은행 및 계좌번호 추출
$LGD_FINANCENAME = isset($data['data']['virtualAccount']['bank']) ? set_var($data['data']['virtualAccount']['bank']) : '';
$LGD_ACCOUNTNUM = isset($data['data']['virtualAccount']['accountNumber']) ? set_var($data['data']['virtualAccount']['accountNumber']) : '';
$LGD_FINANCECODE = '';

$LGD_CARDNUM = '';
$LGD_CARDINSTALLMONTH = '0';
$LGD_CARDNOINTYN = 'N';
$LGD_TRANSAMOUNT = $amount;
$LGD_EXCHANGERATE = '1';
$LGD_CASSEQNO = '1';

$LGD_CASHRECEIPTNUM = '';
$LGD_CASHRECEIPTSELFYN = 'N';
$LGD_CASHRECEIPTKIND = '';
$LGD_DEFAULTCASHRECEIPTUSE = '';

// DB 쿼리를 위해 buyer_hphone, buyer_name 등 사용자 정보 복원
// webhook은 비동기 호출이므로 세션이 존재하지 않으므로 DB에서 직접 orderid 기반으로 사용자 정보를 가져와 설정함
$qry_order = "SELECT * FROM mall_order WHERE orderid = '$orderId'";
$res_order = mysqli_query($connect, $qry_order);
if ($res_order && mysqli_num_rows($res_order) > 0) {
    $order_data = mysqli_fetch_array($res_order);
    $user_id = $order_data['user_id'];
    $buyer_name = $order_data['buyer_name'];
    $buyer_hphone = $order_data['buyer_hphone'];
    $buyer_email = $order_data['buyer_email'];
    $sessionFlag = $order_data['user_flag'];
} else {
    // 주문서 삽입 전에 웹훅이 올 가능성에 대비하여 pg_info 단독 처리가 가능한 경우만 처리
    $user_id = '';
    $buyer_name = '';
    $buyer_hphone = '';
    $buyer_email = '';
    $sessionFlag = 'p';
}

if ($eventType === 'DEPOSIT_RECEIVED') {
    // 2. 가상계좌 입금 성공 웹훅 수신
    $update = 'I'; // 입금 완료 상태로 바인딩
    $LGD_CASFLAG = 'I';
    $LGD_CASTAMOUNT = $amount;
    $LGD_CASCAMOUNT = $amount;
    
    // DB의 mall_order 테이블 주문 상태 갱신 (입금완료 - 4)
    // 기존 시스템 규격: status '3' = 입금대기, '4' = 결제완료/입금확인
    $status = '4';
    $query_update = "UPDATE mall_order SET status='$status' WHERE orderid='$orderId'";
    mysqli_query($connect, $query_update);
    
    // 기존 결제 처리 파일 호출 (pg_info 업데이트 및 SMS 전송 처리 자동 실행)
    require_once 'save_wireinfo_to_db.php';
    
    http_response_code(200);
    echo "OK";
    exit;
    
} elseif ($eventType === 'WAITING_FOR_DEPOSIT') {
    // 3. 가상계좌 할당 성공 (대기) 웹훅 수신
    $update = 'N'; // 할당 상태로 바인딩
    $LGD_CASFLAG = 'R';
    $LGD_CASTAMOUNT = '0';
    $LGD_CASCAMOUNT = '0';
    
    $status = '3'; // 입금대기 상태
    $query_update = "UPDATE mall_order SET status='$status' WHERE orderid='$orderId'";
    mysqli_query($connect, $query_update);
    
    require_once 'save_wireinfo_to_db.php';
    
    http_response_code(200);
    echo "OK";
    exit;
    
} else {
    // 기타 이벤트 (승인 등) 무시 처리 또는 일반 성공 반환
    http_response_code(200);
    echo "OK (Unhandled Event)";
    exit;
}
