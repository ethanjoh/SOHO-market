<?php include_once '../include/header.php';?>

        <section class="collapse_area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="check">
                            <h1>주문 처리결과</h1>
                        </div>

<?php

/*
 * [최종결제요청 페이지(STEP2-2)]
 *
 * LG유플러스으로 부터 내려받은 LGD_PAYKEY(인증Key)를 가지고 최종 결제요청.(파라미터 전달시 POST를 사용하세요)
 */

// $configPath = "../lgpay"; //LG유플러스에서 제공한 환경파일("/conf/lgdacom.conf,/conf/mall.conf") 위치 지정.
$configPath = "/home/hosting_users/ssss01047271791/lgpay";

/*
 *************************************************
 * 1.최종결제 요청 - BEGIN
 *  (단, 최종 금액체크를 원하시는 경우 금액체크 부분 주석을 제거 하시면 됩니다.)
 *************************************************
 */
$CST_PLATFORM = $_POST["CST_PLATFORM"];
$CST_MID      = $_POST["CST_MID"];
$LGD_MID      = (("test" == $CST_PLATFORM) ? "t" : "") . $CST_MID;
$LGD_PAYKEY   = $_POST["LGD_PAYKEY"];

$sessionFlag = $_SESSION['p_flag']; //사용자 구분 플래그, 'c':기업회원,  'p':개인회원

// require_once "../lgpay/XPayClient.php";//
require_once "/home/hosting_users/ssss01047271791/lgpay/XPayClient.php";

$xpay = new XPayClient($configPath, $CST_PLATFORM);
$xpay->Init_TX($LGD_MID);

$xpay->Set("LGD_TXNAME", "PaymentByKey");
$xpay->Set("LGD_PAYKEY", $LGD_PAYKEY);

//금액을 체크하시기 원하는 경우 아래 주석을 풀어서 이용하십시요.
//$DB_AMOUNT = "DB나 세션에서 가져온 금액"; //반드시 위변조가 불가능한 곳(DB나 세션)에서 금액을 가져오십시요.
//$xpay->Set("LGD_AMOUNTCHECKYN", "Y");
//$xpay->Set("LGD_AMOUNT", $DB_AMOUNT);

/*
 *************************************************
 * 1.최종결제 요청(수정하지 마세요) - END
 *************************************************
 */

/*
 * 2. 최종결제 요청 결과처리
 *
 * 최종 결제요청 결과 리턴 파라미터는 연동메뉴얼을 참고하시기 바랍니다.
 */
if ($xpay->TX()) {
    //1)결제결과 화면처리(성공,실패 결과 처리를 하시기 바랍니다.)
    $LGD_RESPCODE = $xpay->Response_Code();
    $LGD_RESPMSG  = $xpay->Response_Msg();
    // $LGD_IFOS              = $xpay->Response("LGD_IFOS", 0);
    /**
     * 공통
     */
    $LGD_MID          = $xpay->Response("LGD_MID", 0); //상점 아이디
    $LGD_OID          = $xpay->Response("LGD_OID", 0); //상점 주문번호
    $LGD_AMOUNT       = $xpay->Response("LGD_AMOUNT", 0); //결제금액
    $LGD_TID          = $xpay->Response("LGD_TID", 0); //유플러스 거래번호
    $LGD_PAYTYPE      = $xpay->Response("LGD_PAYTYPE", 0); //결제수단 코드
    $LGD_PAYDATE      = $xpay->Response("LGD_PAYDATE", 0); //결제일시
    $LGD_HASHDATA     = $xpay->Response("LGD_HASHDATA", 0); //해시데이터
    $LGD_FINANCECODE  = $xpay->Response("LGD_FINANCECODE", 0); //결제기관코드
    $LGD_FINANCENAME  = $xpay->Response("LGD_FINANCENAME", 0); // 결제기관명
    $LGD_ESCROWYN     = $xpay->Response("LGD_ESCROWYN", 0); //최종 에스크로 적용여부
    $LGD_TRANSAMOUNT  = $xpay->Response("LGD_TRANSAMOUNT", 0); //환율적용금액
    $LGD_EXCHANGERATE = $xpay->Response("LGD_EXCHANGERATE", 0); //적용환율
    $LGD_BUYER        = $xpay->Response("LGD_BUYER", 0); //구매자명
    $LGD_BUYERID      = $xpay->Response("LGD_BUYERID", 0); //구매자아이디
    $LGD_BUYERPHONE   = $xpay->Response("LGD_BUYERPHONE", 0); //고객휴대폰번호
    $LGD_BUYEREMAIL   = $xpay->Response("LGD_BUYEREMAIL", 0); //구매자 이메일
    $LGD_PRODUCTINFO  = $xpay->Response("LGD_PRODUCTINFO", 0); //구매내역
    $LGD_TIMESTAMP    = $xpay->Response("LGD_TIMESTAMP", 0); //구매내역

    /**
     * 신용카드
     */
    $LGD_CARDNUM          = $xpay->Response("LGD_CARDNUM", 0); //카드번호
    $LGD_CARDINSTALLMONTH = $xpay->Response("LGD_CARDINSTALLMONTH", 0); //할부개월
    $LGD_CARDNOINTYN      = $xpay->Response("LGD_CARDNOINTYN", 0); //무이자여부
    $LGD_FINANCEAUTHNUM   = $xpay->Response("LGD_FINANCEAUTHNUM", 0); //결제기관승인번호

    /**
     * 계좌이체
     */
    $LGD_CASHRECEIPTNUM        = $xpay->Response("LGD_CASHRECEIPTNUM", 0); //현금영수증 승인번호
    $LGD_CASHRECEIPTSELFYN     = $xpay->Response("LGD_CASHRECEIPTSELFYN", 0); //현금영수증 자진발급제유무
    $LGD_CASHRECEIPTKIND       = $xpay->Response("LGD_CASHRECEIPTKIND", 0); //현금영수증 종류
    $LGD_DEFAULTCASHRECEIPTUSE = $xpay->Response("LGD_DEFAULTCASHRECEIPTUSE", 0); //현금영수증 발급용도

    /**
     * 무통장
     */
    $LGD_ACCOUNTNUM = $xpay->Response("LGD_ACCOUNTNUM", 0); //입금할 계좌번호
    $LGD_CASTAMOUNT = $xpay->Response("LGD_CASTAMOUNT", 0); //입금누적금액
    $LGD_CASCAMOUNT = $xpay->Response("LGD_CASCAMOUNT", 0); //현 입금금액
    $LGD_CASFLAG    = $xpay->Response("LGD_CASFLAG", 0); //거래종류(R:할당, I:입금, C:취소)
    $LGD_CASSEQNO   = $xpay->Response("LGD_CASSEQNO", 0); //가상계좌일련번호

    // db에 저장하기 위한 변수 설정
    require_once 'variables_from_payreq.php';

    // $keys = $xpay->Response_Names();
    // foreach ($keys as $name) {
    //     echo $name . " = " . $xpay->Response($name, 0) . "<br>";
    // }

    echo <<<HEREDOC

                        <div class="alert alert-success" role="alert">주문완료! 주문조회에서 확인하세요.</div>
                        <table class="table table-striped">
                            <tr>
                                <th>거래번호 :</th>
                                <td>{$LGD_TID}</td>
                            </tr>
                            <tr>
                                <th>주문번호 :</th>
                                <td>{$LGD_OID}</td>
                            </tr>

HEREDOC;

    if ("SC0010" == $LGD_PAYTYPE) {
        //신용카드 결제시
        echo <<<HEREDOC

                            <tr>
                              <th>카드사명 :</th>
                              <td>{$LGD_FINANCENAME}</td>
                            </tr>
                            <tr>
                              <th>승인번호 :</th>
                              <td>{$LGD_FINANCEAUTHNUM}</td>
                            </tr>

HEREDOC;

    } else if ("SC0030" == $LGD_PAYTYPE) {
        //계좌이체 결제시
        echo <<<HEREDOC

                            <tr>
                              <th>결제은행 :</th>
                              <td>{$LGD_FINANCENAME}</td>
                            </tr>

HEREDOC;

    } else if ("SC0040" == $LGD_PAYTYPE) {
        //가상계좌 결제시 (할당)
        echo <<<HEREDOC

                            <tr>
                              <th>입금은행 :</th>
                              <td>{$LGD_FINANCENAME}</td>
                            </tr>
                            <tr>
                              <th>입금계좌번호 :</th>
                              <td>{$LGD_ACCOUNTNUM} <i class="fa fa-info-circle"></i> 주문조회에서도 확인이 가능합니다.</td>
                            </tr>

HEREDOC;

    } else {
        //기타 결제시
        echo <<<HEREDOC

                            <tr>
                              <th>결제사명 :</th>
                              <td>{$LGD_FINANCENAME}</td>
                            </tr>

HEREDOC;

    }
    ?>
                            </table>
                        </div>
                      <div class="row payinfo-button" >
                        <button type="button" class="btn btn-success" id="success">주문조회 가기</button>
                      </div>

<?php

    if ("0000" == $xpay->Response_Code()) {
        //최종결제요청 결과 성공 DB처리
        /**
         * 최종결제요청 결과 성공 DB처리 실패시 Rollback 처리
         * DB처리 실패시 false로 변경해 주세요.
         * $isDBOK = true;
         */
        // echo "최종결제요청 결과 성공 DB처리하시기 바랍니다.<br>";

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

        $result = mysqli_query($connect, $query);

        if (!$result) {
            err_msg('데이터베이스 에러가 났습니다.');
        } else {
            ######### SMS 발송처리 (회원 SMS 수신 Y, 관리자 SMS 사용여부 Y 에만)
            ######### $sms: 회원 SMS 수신여부
            $res     = mysqli_query($connect, "SELECT * FROM sms");
            $sms_row = mysqli_fetch_array($res);

            //관리페이지에서 SMS 사용여부 확인
            if ($sms_row['sms'] == "Y") {
                //구매자에게 SMS 발송, 승인된 회원만 구매가능하므로 승인여부 제외
                if ($sms == "Y" && $sms_row['order_chk'] == "Y") {
                    //send_sms(받는 사람 핸드폰번호, 메시지 타입, 날짜, db연결)
                    //메시지 타입 3: 주문완료 처리, 날짜가 빈칸이면 즉시 발송
                    send_sms($buyer_hphone, 3, $buyer_name, "", $connect);
                }

                //관리자에게 SMS 발송
                if ($sms_row['orderin_chk'] == "Y") {
                    //send_sms(self->관리자에게, 메시지 타입, 날짜, db연결)
                    //메시지 타입 2: 주문접수 처리
                    send_sms("self", 2, $buyer_name, "", $connect);
                }

            }
        }

        // 결제정보 DB에 저장
        $query2 = "INSERT INTO pg_info(LGD_RESPCODE, LGD_RESPMSG, LGD_MID, LGD_OID, LGD_AMOUNT, LGD_TID, LGD_PAYTYPE, LGD_PAYDATE,
                                            LGD_HASHDATA, LGD_FINANCECODE, LGD_FINANCENAME, LGD_ESCROWYN, LGD_TIMESTAMP, LGD_FINANCEAUTHNUM,
                                            LGD_CARDNUM, LGD_CARDINSTALLMONTH, LGD_CARDNOINTYN, LGD_TRANSAMOUNT, LGD_EXCHANGERATE, LGD_ACCOUNTNUM,
                                            LGD_CASTAMOUNT, LGD_CASCAMOUNT, LGD_CASFLAG, LGD_CASSEQNO, LGD_CASHRECEIPTNUM, LGD_CASHRECEIPTSELFYN, LGD_CASHRECEIPTKIND, LGD_DEFAULTCASHRECEIPTUSE)
                                    VALUES ('$LGD_RESPCODE', '$LGD_RESPMSG', '$LGD_MID', '$LGD_OID', '$LGD_AMOUNT', '$LGD_TID', '$LGD_PAYTYPE', '$LGD_PAYDATE',
                                            '$LGD_HASHDATA', '$LGD_FINANCECODE', '$LGD_FINANCENAME', '$LGD_ESCROWYN', '$LGD_TIMESTAMP', '$LGD_FINANCEAUTHNUM',
                                            '$LGD_CARDNUM', '$LGD_CARDINSTALLMONTH', '$LGD_CARDNOINTYN', '$LGD_TRANSAMOUNT', '$LGD_EXCHANGERATE', '$LGD_ACCOUNTNUM',
                                            '$LGD_CASTAMOUNT', '$LGD_CASCAMOUNT', '$LGD_CASFLAG', '$LGD_CASSEQNO', '$LGD_CASHRECEIPTNUM', '$LGD_CASHRECEIPTSELFYN', '$LGD_CASHRECEIPTKIND', '$LGD_DEFAULTCASHRECEIPTUSE' )";

        $result2 = mysqli_query($connect, $query2);

        if ($result2) {
            $isDBOK = true;
        } else {
            $isDBOK = false;
        }

        //주문상품 장바구니에서 삭제
        for ($i = 0; $i < sizeof($products_num); $i++) {
            $qry2 = "DELETE FROM products_cart WHERE user_id = '$user_id' AND product_code='$products_num[$i]' ";
            mysqli_query($connect, $qry2);
        }

        ////////////////////////////////////
        // 주문내역 이메일로 보내기
        ///////////////////////////////////
        $com_info = get_company_info();

        switch ($LGD_PAYTYPE) {
            case 'SC0010':
                $pay_type = "신용카드 - " . $LGD_FINANCENAME;
                break;
            case 'SC0030':
                $pay_type = "실시간 계좌이체 - " . $LGD_FINANCENAME;
                break;
            case 'SC0040':
                $pay_type = "무통장입금(가상계좌) - " . $LGD_FINANCENAME;
                break;
            default:
                $pay_type = "기타 - " . $LGD_FINANCENAME;
                break;
        }

        $sender       = "=?EUC-KR?B?" . base64_encode(iconv("UTF-8", "EUC-KR", "" . $com_info['company_name'] . "")) . "?=\r\n";
        $sender_email = 'noreply@' . $_SERVER['SERVER_NAME'];

        $subject   = $buyer_name . "님, 주문하신 내역입니다.";
        $subject_c = "=?EUC-KR?B?" . base64_encode(iconv("UTF-8", "EUC-KR", $subject)) . "?=\r\n";
        $subject_c = addslashes($subject_c);

        //상단 컨텐츠
        $contents = <<<HEREDOC

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Untitled Document</title>
</head>

<body>
    <div id="readFrame">
        <table cellspacing="0" cellpadding="0" border="0" width="750">
            <tbody>
                <tr>
                    <td>
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tbody>
                                <tr>
                                    <td style="padding:50px 30px 20px">
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <p style="margin:0;"><img src="http://{$_SERVER['SERVER_NAME']}/mail/images/order-top.png" alt="신수마켓 주문이 정상적으로 완료 되었습니다." width="750" height="30"></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size:20px;color:#000;font-weight:bold;padding-top:50px;">
                                                        <p style="margin:0;"><span style="color:#0068b7;">{$buyer_name}</span>님, 주문을 확인해 주세요.</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size:13px;color:#666;padding-top:20px;line-height:1.5;">
                                                        {$com_info['company_name']}를 이용해 주셔서 감사합니다.
                                                        <br>무통장 입금의 경우 1회성 가상계좌가 발급되며 주문 후 7일 후에 소멸되므로 소멸 전에 입금하셔야 합니다.
                                                        <br>7일이 지난 이후에는 재주문하여주시기 바랍니다.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size:16px;color:#000;font-weight:bold;padding:50px 0 10px;">주문상품정보<span style="font-size:11px;font-weight:normal;padding-left:12px;">(주문번호 : {$trade_code})</span></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="width:100px;background-color:#f7f7f7;border-top:2px solid #222;border-bottom:1px solid #d1d1d1;height:42px;vertical-align:middle;text-align:center;font-weight:bold;color:#444;font-size:12px;">이미지</td>
                                                                    <td style="width:150px;background-color:#f7f7f7;border-top:2px solid #222;border-bottom:1px solid #d1d1d1;height:42px;vertical-align:middle;text-align:center;font-weight:bold;color:#444;font-size:12px;">상품명</td>
                                                                    <td style="background-color:#f7f7f7;border-top:2px solid #222;border-bottom:1px solid #d1d1d1;height:42px;vertical-align:middle;text-align:center;font-weight:bold;color:#444;font-size:12px;">옵션</td>
                                                                    <td style="width:77px;background-color:#f7f7f7;border-top:2px solid #222;border-bottom:1px solid #d1d1d1;height:42px;vertical-align:middle;text-align:center;font-weight:bold;color:#444;font-size:12px;">수량</td>
                                                                    <td style="width:78px;background-color:#f7f7f7;border-top:2px solid #222;border-bottom:1px solid #d1d1d1;height:42px;vertical-align:middle;text-align:center;font-weight:bold;color:#444;font-size:12px;">상품단가</td>
                                                                    <td style="width:104px;background-color:#f7f7f7;border-top:2px solid #222;border-bottom:1px solid #d1d1d1;height:42px;vertical-align:middle;text-align:center;font-weight:bold;color:#444;font-size:12px;">소계</td>
                                                                </tr>
HEREDOC;

        // 주문상세내역
        $contents .= show_order_item_on_mail($trade_code);

        $show_total      = number_format($tot_money + $trans_cost);
        $show_trans_cost = number_format($trans_cost);

        $contents .= <<<HEREDOC
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size:16px;color:#000;font-weight:bold;padding:50px 0 10px;">결제정보</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="width:99px;background-color:#f7f7f7;border-top:2px solid #222;border-bottom:1px solid #d1d1d1;height:41px;vertical-align:middle;text-align:center;font-weight:bold;color:#444;font-size:12px;">총 상품금액</td>
                                                                    <td style="color:#444;font-size:12px;padding-left:20px;width:246px;text-align:left;vertical-align:middle;border-top:2px solid #222;border-bottom:1px solid #d1d1d1;height:41px;">{$show_total} 원</td>
                                                                    <td style="width:99px;width:99px;background-color:#f7f7f7;border-top:2px solid #222;border-bottom:1px solid #d1d1d1;height:41px;vertical-align:middle;text-align:center;font-weight:bold;color:#444;font-size:12px;">배송금액</td>
                                                                    <td style="color:#444;font-size:12px;text-align:left;padding-left:20px;vertical-align:middle;border-bottom:1px solid #d1d1d1;border-top:2px solid #222;height:41px;">{$show_trans_cost} 원</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="background-color:#f7f7f7;border-bottom:1px solid #d1d1d1;height:41px;vertical-align:middle;text-align:center;font-weight:bold;color:#444;font-size:12px;">결제수단</td>
                                                                    <td colspan="3" style="color:#444;font-size:12px;padding-left:20px;width:246px;text-align:left;vertical-align:middle;border-bottom:1px solid #d1d1d1;height:41px;">{$pay_type}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="background-color:#f2f2f2;border-bottom:1px solid #d1d1d1;height:40px;vertical-align:middle;text-align:center;font-weight:bold;color:#444;font-size:12px;">총 결제금액</td>
                                                                    <td colspan="3" style="background-color:#f2f2f2;border-bottom:1px solid #d1d1d1;height:40px;vertical-align:middle;text-align:left;padding-left:20px;font-size:12px;color:#0068b7;font-weight:bold;">
                                                                        {$show_total} 원
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size:16px;color:#000;font-weight:bold;padding:50px 0 10px;">주문하시는 분 (보내시는 분)</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="width:99px;background-color:#f7f7f7;border-top:2px solid #222;border-bottom:1px solid #d1d1d1;height:41px;vertical-align:middle;text-align:center;font-weight:bold;color:#444;font-size:12px;">주문하시는 분 </td>
                                                                    <td style="color:#444;font-size:12px;padding-left:20px;text-align:left;vertical-align:middle;border-top:2px solid #222;border-bottom:1px solid #d1d1d1;height:41px;">{$buyer_name}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="background-color:#f7f7f7;border-bottom:1px solid #d1d1d1;height:41px;vertical-align:middle;text-align:center;font-weight:bold;color:#444;font-size:12px;">이메일</td>
                                                                    <td style="color:#444;font-size:12px;padding-left:20px;text-align:left;vertical-align:middle;border-bottom:1px solid #d1d1d1;height:41px;">{$buyer_email}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="background-color:#f7f7f7;border-bottom:1px solid #d1d1d1;height:41px;vertical-align:middle;text-align:center;font-weight:bold;color:#444;font-size:12px;">연락처</td>
                                                                    <td style="color:#444;font-size:12px;padding-left:20px;text-align:left;vertical-align:middle;border-bottom:1px solid #d1d1d1;height:41px;">{$buyer_hphone}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="background-color:#f7f7f7;border-bottom:1px solid #d1d1d1;height:41px;vertical-align:middle;text-align:center;font-weight:bold;color:#444;font-size:12px;">주소</td>
                                                                    <td style="color:#444;font-size:12px;padding-left:20px;text-align:left;vertical-align:middle;border-bottom:1px solid #d1d1d1;height:41px;">{$buyer_zipcode} {$buyer_address}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="font-size:16px;color:#000;font-weight:bold;padding:50px 0 10px;">받으시는 분 (배송지) </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="width:99px;background-color:#f7f7f7;border-top:2px solid #222;border-bottom:1px solid #d1d1d1;height:41px;vertical-align:middle;text-align:center;font-weight:bold;color:#444;font-size:12px;">받으시는 분 </td>
                                                                    <td style="color:#444;font-size:12px;padding-left:20px;text-align:left;vertical-align:middle;border-top:2px solid #222;border-bottom:1px solid #d1d1d1;height:41px;">{$recipient_name}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="background-color:#f7f7f7;border-bottom:1px solid #d1d1d1;height:41px;vertical-align:middle;text-align:center;font-weight:bold;color:#444;font-size:12px;">연락처</td>
                                                                    <td style="color:#444;font-size:12px;padding-left:20px;text-align:left;vertical-align:middle;border-bottom:1px solid #d1d1d1;height:41px;">{$recipient_hphone}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="background-color:#f7f7f7;border-bottom:1px solid #d1d1d1;height:41px;vertical-align:middle;text-align:center;font-weight:bold;color:#444;font-size:12px;">주소</td>
                                                                    <td style="color:#444;font-size:12px;padding-left:20px;text-align:left;vertical-align:middle;border-bottom:1px solid #d1d1d1;height:41px;">{$recipient_zipcode} {$recipient_address}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="background-color:#f7f7f7;border-bottom:1px solid #d1d1d1;height:41px;vertical-align:middle;text-align:center;font-weight:bold;color:#444;font-size:12px;">배송메모</td>
                                                                    <td style="color:#444;font-size:12px;padding-left:20px;text-align:left;vertical-align:middle;border-bottom:1px solid #d1d1d1;height:41px;">{$memo_to_delivery}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="background-color:#f7f7f7;border-bottom:1px solid #d1d1d1;height:41px;vertical-align:middle;text-align:center;font-weight:bold;color:#444;font-size:12px;">담당자에게 메모</td>
                                                                    <td style="color:#444;font-size:12px;padding-left:20px;text-align:left;vertical-align:middle;border-bottom:1px solid #d1d1d1;height:41px;">{$memo_to_admin}</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:center;">
                                        <a href="http://{$_SERVER['SERVER_NAME']}/shop/order-list.php" target="_blank" title="새창"><img src="http://{$_SERVER['SERVER_NAME']}/mail/images/order-list-button.png" alt="주문내역 바로가기" width="250" height="50" border="0"></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <table cellspacing="0" cellpadding="0" border="0" width="750">
            <tbody>
                <tr>
                    <td>
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tbody>
                                <tr>
                                    <td style="padding:70px 0 0;margin:0;">
                                        <p>
                                            <a href="http://{$_SERVER['SERVER_NAME']}/bbs/list.php?code=qna" target="_blank" title="새창"><img src="http://{$_SERVER['SERVER_NAME']}/mail/images/cs-center.png" alt="회신이 되지않는 발신전용메일입니다. 신수마켓 이용 관련문의는 1:1 게시판을 이용해 주세요." width="750" height="30" border="0"></a>
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:13px 0 0;margin:0;">
                                        <a href="mailto:{$com_info['email']}" target="_blank" alt="e-mail : {$com_info['email']}"><img src="http://{$_SERVER['SERVER_NAME']}/mail/images/email-footer.png" alt="사업자등록번호: 212-02-66119 | 대표: 최홍규 | 통신판매업신고: 강동-0181호 (05395)서울 강동구 성내로17길 66 (성내동)1F 신수상사 TEL: 02-479-2142 FAX: 02-479-2141" width="750" height="150" border="0"></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>

HEREDOC;

        $headers = "Return-Path: $sender_email\r\n";
        $headers .= "From: $sender <$sender_email>\r\n";

        $boundary = "----" . uniqid("part");

        $headers .= "Content-Type: text/html; charset=utf-8\r\n";
        $message = $contents;
        $to      = $buyer_email;

        mail($to, $subject_c, $message, $headers);
        ////////////////////////////////////
        // 주문내역 이메일로 보내기 끝
        ///////////////////////////////////

        if (!$isDBOK) {
            echo "<p>";
            $xpay->Rollback("상점 DB처리 실패로 인하여 Rollback 처리 [TID:" . $xpay->Response("LGD_TID", 0) . ",MID:" . $xpay->Response("LGD_MID", 0) . ",OID:" . $xpay->Response("LGD_OID", 0) . "]");

            echo "TX Rollback Response_code = " . $xpay->Response_Code() . "<br>";
            echo "TX Rollback Response_msg = " . $xpay->Response_Msg() . "<p>";

            if ("0000" == $xpay->Response_Code()) {
                echo "자동취소가 정상적으로 완료 되었습니다.<br>";
            } else {
                echo "자동취소가 정상적으로 처리되지 않았습니다.<br>";
            }
        }
    } else {
        //최종결제요청 결과 실패 DB처리
        echo "최종결제요청 결과 실패 DB처리하시기 바랍니다.<br>";
    }
} else {
    //2)API 요청실패 화면처리
    //결과 메시지는 정규 서비스할 때 삭제할 것(정보노출 위험)
    echo <<<HEREDOC

                        <div class="alert alert-danger" role="alert">주문실패! 결제에 실패하였습니다.<p>관리자에게 문의하세요</p></div>
                            <table class="table table-striped">
                                <tr>
                                    <th>결과코드 :</th>
                                    <td>{$xpay->Response_Code()}</td>
                                </tr>
                                <tr>
                                    <th>결과메세지 :</th>
                                    <td>{$xpay->Response_Msg()}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="row payinfo-button" >
                            <button type="button" class="btn btn-danger" data-dismiss="modal" id="cancel">카트로 돌아가기</button>
                        </div>

HEREDOC;

    echo "결제요청이 실패하였습니다.  <br>";
    // echo "TX Response_code = " . $xpay->Response_Code() . "<br>";
    // echo "TX Response_msg = " . $xpay->Response_Msg() . "<p>";

    // //최종결제요청 결과 실패 DB처리
    echo "최종결제요청 결과 실패 DB처리하시기 바랍니다.<br>";

}

?>
                    </div>
                </div>
            </div>
        </section>

<?php include_once '../include/brands.php';?>

<?php include_once '../include/footer.php';?>

        <script>
            $(document).ready(function() {
                $( "#cancel" ).click(function() {
                    window.location.replace("/shop/cart.php");
                });

                $( "#success" ).click(function() {
                    window.location.replace("/shop/order-list.php");
                });

            });
        </script>

    </body>
</html>