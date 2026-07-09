// 토스페이먼츠 결제 요청을 처리하고 JS SDK 결제창을 자동으로 띄우는 클라이언트 페이지
<?php
include_once '../include/header.php';

// 세션 시작 (header.php에 session_start가 포함되어 있지 않은 경우를 대비)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 1. checkout.php에서 넘어온 주문서 작성 정보 전체를 세션에 안전하게 백업
$_SESSION['toss_temp_order'] = $_POST;

$CST_PLATFORM = set_var($_POST["CST_PLATFORM"]);
$LGD_OID      = set_var($_POST["LGD_OID"]);         // 주문번호
$LGD_AMOUNT   = set_var($_POST["LGD_AMOUNT"]);      // 결제금액
$LGD_BUYER    = set_var($_POST["LGD_BUYER"]);       // 구매자명
$LGD_BUYEREMAIL = set_var($_POST["LGD_BUYEREMAIL"]); // 구매자 이메일
$LGD_PRODUCTINFO = $_POST["LGD_PRODUCTINFO"];       // 상품명 배열 또는 문자열

// 제품명 문자열 변환
if (is_array($LGD_PRODUCTINFO)) {
    if (count($LGD_PRODUCTINFO) > 1) {
        $product_name = $LGD_PRODUCTINFO[0] . " 외 " . (count($LGD_PRODUCTINFO) - 1) . " 건";
    } else {
        $product_name = $LGD_PRODUCTINFO[0];
    }
} else {
    $product_name = $LGD_PRODUCTINFO;
}

// 결제수단 설정 매핑 (구 U+ 결제수단 코드를 토스 SDK 명칭으로 전환)
$usable_pay = set_var($_POST["LGD_CUSTOM_USABLEPAY"]);
$toss_method = '카드'; // 기본값

if ($usable_pay == 'SC0010') {
    $toss_method = '카드';
} elseif ($usable_pay == 'SC0030') {
    $toss_method = '계좌이체';
} elseif ($usable_pay == 'SC0040') {
    $toss_method = '가상계좌';
}

// 프로토콜 및 호스트 주소 빌드
$protocol = "https";
$host_url = $protocol . "://" . $_SERVER['SERVER_NAME'];

// 토스 클라이언트 키 로드 (util.php 전역 변수 참조)
$client_key = $tossClientKey;
?>

<section class="collapse_area">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center" style="padding: 100px 0;">
                <div class="loader" style="margin: 0 auto 20px; border: 5px solid #f3f3f3; border-top: 5px solid #3498db; border-radius: 50%; width: 50px; height: 50px; animation: spin 2s linear infinite;"></div>
                <h3>결제창을 불러오는 중입니다. 잠시만 기다려 주세요...</h3>
            </div>
        </div>
    </div>
</section>

<style>
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<!-- 토스페이먼츠 SDK 로드 -->
<script src="https://js.tosspayments.com/v1/"></script>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
        try {
            const tossPayments = TossPayments("<?php echo $client_key; ?>");
            
            tossPayments.requestPayment("<?php echo $toss_method; ?>", {
                amount: <?php echo (int)$LGD_AMOUNT; ?>,
                orderId: "<?php echo $LGD_OID; ?>",
                orderName: "<?php echo addslashes($product_name); ?>",
                customerName: "<?php echo addslashes($LGD_BUYER); ?>",
                customerEmail: "<?php echo addslashes($LGD_BUYEREMAIL); ?>",
                successUrl: "<?php echo $host_url; ?>/pay/success_toss.php",
                failUrl: "<?php echo $host_url; ?>/pay/fail_toss.php"
            }).catch(function (error) {
                if (error.code === 'USER_CANCEL') {
                    // 사용자가 결제창을 닫았을 때 실패 페이지로 유도
                    window.location.href = "<?php echo $host_url; ?>/pay/fail_toss.php?code=" + error.code + "&message=" + encodeURIComponent("사용자가 결제창을 닫았습니다.");
                } else {
                    window.location.href = "<?php echo $host_url; ?>/pay/fail_toss.php?code=" + error.code + "&message=" + encodeURIComponent(error.message);
                }
            });
        } catch (e) {
            alert("결제창 초기화 중 오류가 발생했습니다: " + e.message);
            window.location.href = "/shop/cart.php";
        }
    });
</script>

<?php include_once '../include/footer.php'; ?>
