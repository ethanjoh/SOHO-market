<?php include_once '../include/header.php';?>

<?php

/*
LG유플러스 결제 페이지 시작
 */
// session_start();
/*
 * [결제 인증요청 페이지(STEP2-1)]
 *
 * 샘플페이지에서는 기본 파라미터만 예시되어 있으며, 별도로 필요하신 파라미터는 연동메뉴얼을 참고하시어 추가 하시기 바랍니다.
 */

/*
 * 1. 기본결제 인증요청 정보 변경
 *
 * 기본정보를 변경하여 주시기 바랍니다.(파라미터 전달시 POST를 사용하세요)
 */

$CST_PLATFORM = $_POST["CST_PLATFORM"]; //LG유플러스 결제 서비스 선택(test:테스트, service:서비스)
$CST_MID      = $_POST["CST_MID"]; //상점아이디(LG유플러스으로 부터 발급받으신 상점아이디를 입력하세요)
//테스트 아이디는 't'를 반드시 제외하고 입력하세요.
$LGD_MID         = (("test" == $CST_PLATFORM) ? "t" : "") . $CST_MID; //상점아이디(자동생성)
$LGD_OID         = $_POST["LGD_OID"]; //주문번호(상점정의 유니크한 주문번호를 입력하세요)
$LGD_AMOUNT      = $_POST["LGD_AMOUNT"]; //결제금액("," 를 제외한 결제금액을 입력하세요)
$LGD_BUYER       = $_POST["LGD_BUYER"]; //구매자명
$LGD_PRODUCTINFO = $_POST["LGD_PRODUCTINFO"]; //상품명

// 제품명 표시
if (count($LGD_PRODUCTINFO) > 1) {
    $LGD_PRODUCTINFO = $LGD_PRODUCTINFO[0] . " 외 " . (count($LGD_PRODUCTINFO) - 1) . " 건";
} else {
    $LGD_PRODUCTINFO = $LGD_PRODUCTINFO[0];
}

$LGD_BUYEREMAIL       = $_POST["LGD_BUYEREMAIL"]; //구매자 이메일
$LGD_CUSTOM_FIRSTPAY  = $_POST["LGD_CUSTOM_FIRSTPAY"]; //상점정의 초기결제수단
$LGD_TIMESTAMP        = date('YmdHms'); //타임스탬프
$LGD_CUSTOM_SKIN      = "red"; //상점정의 결제창 스킨
$LGD_CUSTOM_USABLEPAY = $_POST["LGD_CUSTOM_USABLEPAY"]; //디폴트 결제수단 (해당 필드를 보내지 않으면 결제수단 선택 UI 가 노출됩니다.)
$LGD_WINDOW_VER       = "2.5"; //결제창 버젼정보
// $LGD_WINDOW_TYPE          = $_POST["LGD_WINDOW_TYPE"];          //결제창 호출방식 (수정불가)
// $LGD_CUSTOM_SWITCHINGTYPE = $_POST["LGD_CUSTOM_SWITCHINGTYPE"]; //신용카드 카드사 인증 페이지 연동 방식 (수정불가)
$LGD_WINDOW_TYPE          = "iframe"; //결제창 호출방식 (수정불가)
$LGD_CUSTOM_SWITCHINGTYPE = "IFRAME"; //신용카드 카드사 인증 페이지 연동 방식 (수정불가)
// $configPath               = "../lgpay";                         //LG유플러스에서 제공한 환경파일("/conf/lgdacom.conf") 위치 지정.
$configPath = "/home/hosting_users/ssss01047271791/lgpay"; //LG유플러스에서 제공한 환경파일("/conf/lgdacom.conf") 위치 지정.

$LGD_CUSTOM_PROCESSTYPE = "TWOTR"; //수정불가

// 2020.2.26 추가
// https 프로토콜 추가
// $protocol = check_protocol($sslPort);

/*
 * 가상계좌(무통장) 결제 연동을 하시는 경우 아래 LGD_CASNOTEURL 을 설정하여 주시기 바랍니다.
 */
// $LGD_CASNOTEURL = $protocol . "//" . $_SERVER['SERVER_NAME'] . ':' . $sslPort . "/pay/cas_noteurl.php";
$LGD_CASNOTEURL = "http://" . $_SERVER['SERVER_NAME'] . "/pay/cas_noteurl.php";

/*
 * LGD_RETURNURL 을 설정하여 주시기 바랍니다. 반드시 현재 페이지와 동일한 프로트콜 및  호스트이어야 합니다. 아래 부분을 반드시 수정하십시요.
 */
// $LGD_RETURNURL = $protocol . "//" . $_SERVER['SERVER_NAME'] . ':' . $sslPort . "/pay/returnurl.php";
$LGD_RETURNURL = "http://" . $_SERVER['SERVER_NAME'] . "/pay/returnurl.php";

/*
 *************************************************
 * 2. MD5 해쉬암호화 (수정하지 마세요) - BEGIN
 *
 * MD5 해쉬암호화는 거래 위변조를 막기위한 방법입니다.
 *************************************************
 *
 * 해쉬 암호화 적용( LGD_MID + LGD_OID + LGD_AMOUNT + LGD_TIMESTAMP + LGD_MERTKEY )
 * LGD_MID          : 상점아이디
 * LGD_OID          : 주문번호
 * LGD_AMOUNT       : 금액
 * LGD_TIMESTAMP    : 타임스탬프
 * LGD_MERTKEY      : 상점MertKey (mertkey는 상점관리자 -> 계약정보 -> 상점정보관리에서 확인하실수 있습니다)
 *
 * MD5 해쉬데이터 암호화 검증을 위해
 * LG유플러스에서 발급한 상점키(MertKey)를 환경설정 파일(lgdacom/conf/mall.conf)에 반드시 입력하여 주시기 바랍니다.
 */
// require_once "../lgpay/XPayClient.php";
require_once "/home/hosting_users/ssss01047271791/lgpay/XPayClient.php";
$xpay = new XPayClient($configPath, $CST_PLATFORM);
$xpay->Init_TX($LGD_MID);
$LGD_HASHDATA = md5($LGD_MID . $LGD_OID . $LGD_AMOUNT . $LGD_TIMESTAMP . $xpay->config[$LGD_MID]);

/*
 *************************************************
 * 2. MD5 해쉬암호화 (수정하지 마세요) - END
 *************************************************
 */

$payReqMap['CST_PLATFORM']             = $CST_PLATFORM; // 테스트, 서비스 구분
$payReqMap['LGD_WINDOW_TYPE']          = 'iframe'; // 수정불가
$payReqMap['LGD_CUSTOM_SWITCHINGTYPE'] = 'IFRAME'; // 신용카드 카드사 인증 페이지 연동 방식
$payReqMap['CST_MID']                  = $CST_MID; // 상점아이디
$payReqMap['LGD_MID']                  = $LGD_MID; // 상점아이디
$payReqMap['LGD_OID']                  = $LGD_OID; // 주문번호
$payReqMap['LGD_BUYER']                = $LGD_BUYER; // 구매자
$payReqMap['LGD_PRODUCTINFO']          = $LGD_PRODUCTINFO; // 상품정보
$payReqMap['LGD_AMOUNT']               = $LGD_AMOUNT; // 결제금액
$payReqMap['LGD_BUYEREMAIL']           = $LGD_BUYEREMAIL; // 구매자 이메일
$payReqMap['LGD_CUSTOM_SKIN']          = $LGD_CUSTOM_SKIN; // 결제창 SKIN
$payReqMap['LGD_CUSTOM_PROCESSTYPE']   = $LGD_CUSTOM_PROCESSTYPE; // 트랜잭션 처리방식
$payReqMap['LGD_TIMESTAMP']            = $LGD_TIMESTAMP; // 타임스탬프
$payReqMap['LGD_HASHDATA']             = $LGD_HASHDATA; // MD5 해쉬암호값
$payReqMap['LGD_RETURNURL']            = $LGD_RETURNURL; // 응답수신페이지
$payReqMap['LGD_VERSION']              = "PHP_2.5"; // 버전정보 (삭제하지 마세요)
$payReqMap['LGD_CUSTOM_USABLEPAY']     = $LGD_CUSTOM_USABLEPAY; // 디폴트 결제수단
$payReqMap['LGD_WINDOW_VER']           = $LGD_WINDOW_VER;

// 가상계좌(무통장) 결제연동을 하시는 경우  할당/입금 결과를 통보받기 위해 반드시 LGD_CASNOTEURL 정보를 LG 유플러스에 전송해야 합니다 .
// 가상계좌 NOTEURL
$payReqMap['LGD_CASNOTEURL'] = $LGD_CASNOTEURL;

//Return URL에서 인증 결과 수신 시 셋팅될 파라미터 입니다.*/
$payReqMap['LGD_RESPCODE'] = "";
$payReqMap['LGD_RESPMSG']  = "";
$payReqMap['LGD_PAYKEY']   = "";

$_SESSION['PAYREQ_MAP'] = $payReqMap;

/**
 * checkout.php에서 넘어온 값
 * payres.php에서 DB에 저장한다.
 */
//수령자가 다를 경우
$check_diff_addr     = set_var($_POST['check_diff_addr']);
$recipient_name      = set_var($_POST['recipient_name']);
$recipient_zipcode   = set_var($_POST['recipient_zipcode01']);
$recipient_address01 = set_var($_POST['recipient_address01']);
$recipient_address02 = set_var($_POST['recipient_address02']);
$recipient_phone     = set_var($_POST['recipient_phone']);
$recipient_hphone    = set_var($_POST['recipient_hphone']);

$memo_to_delivery = set_var($_POST['memo_to_delivery']);
$memo_to_admin    = set_var($_POST['memo_to_admin']);
$sessionFlag      = $_SESSION['p_flag']; //사용자 구분 플래그, 'c':기업회원,  'p':개인회원

?>

        <script language="javascript" src="https://xpay.uplus.co.kr/xpay/js/xpay_crossplatform.js" type="text/javascript"></script>
        <script type="text/javascript">
        /*
        * 수정불가.
        */
        // var LGD_window_type = '<?php echo $LGD_WINDOW_TYPE; ?>';
        var LGD_window_type = 'iframe';

        /*
        * 수정불가
        */
        function launchCrossPlatform(){
            // lgdwin = openXpay(document.getElementById('LGD_PAYINFO'), '<?php echo $CST_PLATFORM; ?>', LGD_window_type, null, "", "");
            lgdwin = openXpay(document.getElementById('LGD_PAYINFO'), '<?php echo $CST_PLATFORM; ?>', 'iframe', null, "", "");
        }
        /*
        * FORM 명만  수정 가능
        */
        function getFormObject() {
            return document.getElementById("LGD_PAYINFO");
        }
        /*
        * 인증결과 처리
        */
        function payment_return() {
            var fDoc;
            fDoc = lgdwin.contentWindow || lgdwin.contentDocument;
            if (fDoc.document.getElementById('LGD_RESPCODE').value == "0000") {
                document.getElementById("LGD_PAYKEY").value = fDoc.document.getElementById('LGD_PAYKEY').value;
                document.getElementById("LGD_PAYINFO").target = "_self";
                document.getElementById("LGD_PAYINFO").action = "payres.php";
                document.getElementById("LGD_PAYINFO").submit();
            } else {
                alert("LGD_RESPCODE (결과코드) : " + fDoc.document.getElementById('LGD_RESPCODE').value + "\n" + "LGD_RESPMSG (결과메시지): " + fDoc.document.getElementById('LGD_RESPMSG').value);
                closeIframe();
            }
        }
        </script>

       <form method="post" name="LGD_PAYINFO" id="LGD_PAYINFO" action="payres.php">

        <section class="collapse_area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="check">
                            <h1>최종확인</h1>
                        </div>

                        <div class="row" >
                            <div class="col-md-12 payinfo-form">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <td><i class="fa fa-check-square"></i> 구매자명: </td>
                                                <td><?php echo $LGD_BUYER; ?></td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-check-square"></i> 상품정보: </td>
                                                <td><?php echo $LGD_PRODUCTINFO; ?></td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-check-square"></i> 결제금액: </td>
                                                <td><?php echo $LGD_AMOUNT; ?> 원</td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-check-square"></i> 이 메 일: </td>
                                                <td><?php echo $LGD_BUYEREMAIL; ?></td>
                                            </tr>
                                            <tr>
                                                <td><i class="fa fa-check-square"></i> 주문번호: </td>
                                                <td><?php echo $LGD_OID; ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                        <div class="row payinfo-button" >
                            <div class="col-md-12">
                                <button type="button" class="btn btn-danger" data-dismiss="modal" id="cancel">취소</button>
                                <!-- <button type="submit" class="btn btn-success" onclick="launchCrossPlatform();">결제하기</button> -->
                                <input type="button" class="btn btn-success" onclick="launchCrossPlatform();" value="결제하기">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <input type="hidden" name="check_diff_addr" value="<?php echo $check_diff_addr; ?>">
        <input type="hidden" name="recipient_name" value="<?php echo $recipient_name; ?>">
        <input type="hidden" name="recipient_zipcode" value="<?php echo $recipient_zipcode; ?>">
        <input type="hidden" name="recipient_address01" value="<?php echo $recipient_address01; ?>">
        <input type="hidden" name="recipient_address02" value="<?php echo $recipient_address02; ?>">
        <input type="hidden" name="recipient_phone" value="<?php echo $recipient_phone; ?>">
        <input type="hidden" name="recipient_hphone" value="<?php echo $recipient_hphone; ?>">
        <input type="hidden" name="memo_to_delivery" value="<?php echo $memo_to_delivery; ?>">
        <input type="hidden" name="memo_to_admin" value="<?php echo $memo_to_admin; ?>">
        <input type="hidden" name="sessionFlag" id="sessionFlag" value="<?php echo $sessionFlag; ?>">
        <input type="hidden" name="LGD_ENCODING" id="LGD_ENCODING" value="UTF-8">
<?php

foreach ($payReqMap as $key => $value) {
    echo '        <input type="hidden" name="' . $key . '" id="' . $key . '" value="' . $value . '">' . "\r\n";
}
echo '';

// echo '<pre>';
// var_dump($_SESSION);
// echo '</pre>';

?>
        </form>


<?php include_once '../include/brands.php';?>

<?php include_once '../include/footer.php';?>


        <script>
            $(document).ready(function() {
                $( "#cancel" ).click(function() {
                    window.location.replace("../shop/cart.php");
                });
            });
        </script>

    </body>
</html>

