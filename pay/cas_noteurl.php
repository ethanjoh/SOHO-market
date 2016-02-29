<?php
require_once '../util/util.php';

/*
 * [상점 결제결과처리(DB) 페이지]
 *
 * 1) 위변조 방지를 위한 hashdata값 검증은 반드시 적용하셔야 합니다.
 *
 */
$LGD_RESPCODE          = $_POST['LGD_RESPCODE'];          // 응답코드: 0000(성공) 그외 실패
$LGD_RESPMSG           = $_POST['LGD_RESPMSG'];           // 응답메세지
$LGD_MID               = $_POST['LGD_MID'];               // 상점아이디
$LGD_OID               = $_POST['LGD_OID'];               // 주문번호
$LGD_AMOUNT            = $_POST['LGD_AMOUNT'];            // 거래금액
$LGD_TID               = $_POST['LGD_TID'];               // LG유플러스에서 부여한 거래번호
$LGD_PAYTYPE           = $_POST['LGD_PAYTYPE'];           // 결제수단코드
$LGD_PAYDATE           = $_POST['LGD_PAYDATE'];           // 거래일시(승인일시/이체일시)
$LGD_HASHDATA          = $_POST['LGD_HASHDATA'];          // 해쉬값
$LGD_FINANCECODE       = $_POST['LGD_FINANCECODE'];       // 결제기관코드(은행코드)
$LGD_FINANCENAME       = $_POST['LGD_FINANCENAME'];       // 결제기관이름(은행이름)
$LGD_ESCROWYN          = $_POST['LGD_ESCROWYN'];          // 에스크로 적용여부
$LGD_TIMESTAMP         = $_POST['LGD_TIMESTAMP'];         // 타임스탬프
$LGD_ACCOUNTNUM        = $_POST['LGD_ACCOUNTNUM'];        // 계좌번호(무통장입금)
$LGD_CASTAMOUNT        = $_POST['LGD_CASTAMOUNT'];        // 입금총액(무통장입금)
$LGD_CASCAMOUNT        = $_POST['LGD_CASCAMOUNT'];        // 현입금액(무통장입금)
$LGD_CASFLAG           = $_POST['LGD_CASFLAG'];           // 무통장입금 플래그(무통장입금) - 'R':계좌할당, 'I':입금, 'C':입금취소
$LGD_CASSEQNO          = $_POST['LGD_CASSEQNO'];          // 입금순서(무통장입금)
$LGD_CASHRECEIPTNUM    = $_POST['LGD_CASHRECEIPTNUM'];    // 현금영수증 승인번호
$LGD_CASHRECEIPTSELFYN = $_POST['LGD_CASHRECEIPTSELFYN']; // 현금영수증자진발급제유무 Y: 자진발급제 적용, 그외 : 미적용
$LGD_CASHRECEIPTKIND   = $_POST['LGD_CASHRECEIPTKIND'];   // 현금영수증 종류 0: 소득공제용 , 1: 지출증빙용
$LGD_PAYER             = $_POST['LGD_PAYER'];             // 입금자명

/*
 * 구매정보
 */
$LGD_BUYER         = isset($_POST["LGD_BUYER"]);         // 구매자
$LGD_PRODUCTINFO   = isset($_POST["LGD_PRODUCTINFO"]);   // 상품명
$LGD_BUYERID       = isset($_POST["LGD_BUYERID"]);       // 구매자 ID
$LGD_BUYERADDRESS  = isset($_POST["LGD_BUYERADDRESS"]);  // 구매자 주소
$LGD_BUYERPHONE    = isset($_POST["LGD_BUYERPHONE"]);    // 구매자 전화번호
$LGD_BUYEREMAIL    = isset($_POST["LGD_BUYEREMAIL"]);    // 구매자 이메일
$LGD_BUYERSSN      = isset($_POST["LGD_BUYERSSN"]);      // 구매자 주민번호
$LGD_PRODUCTCODE   = isset($_POST["LGD_PRODUCTCODE"]);   // 상품코드
$LGD_RECEIVER      = isset($_POST["LGD_RECEIVER"]);      // 수취인
$LGD_RECEIVERPHONE = isset($_POST["LGD_RECEIVERPHONE"]); // 수취인 전화번호
$LGD_DELIVERYINFO  = isset($_POST["LGD_DELIVERYINFO"]);  // 배송지

//LG유플러스에서 발급한 상점키로 변경해 주시기 바랍니다.
$LGD_MERTKEY   = $MERTKEY;
$LGD_HASHDATA2 = md5($LGD_MID . $LGD_OID . $LGD_AMOUNT . $LGD_RESPCODE . $LGD_TIMESTAMP . $LGD_MERTKEY);

/*
 * 상점 처리결과 리턴메세지
 *
 * OK  : 상점 처리결과 성공
 * 그외 : 상점 처리결과 실패
 *
 * ※ 주의사항 : 성공시 'OK' 문자이외의 다른문자열이 포함되면 실패처리 되오니 주의하시기 바랍니다.
 */
$resultMSG = "결제결과 상점 DB처리(LGD_CASNOTEURL) 결과값을 입력해 주시기 바랍니다.";

require_once 'variables_from_payreq.php';

//해쉬값 검증이 성공이면
if ($LGD_HASHDATA2 == $LGD_HASHDATA) {
    //결제가 성공이면
    if ("0000" == $LGD_RESPCODE) {
        if ("R" == $LGD_CASFLAG) {
            /*
             * 무통장 할당 성공 결과 상점 처리(DB) 부분
             * 상점 결과 처리가 정상이면 "OK"
             */
            // $update = 'N';
            // require_once 'save_wireinfo_to_db.php';
            //if( 무통장 할당 성공 상점처리결과 성공 )
            // $resultMSG = "OK";

            $status = "1"; //주문진행 상태(입금대기)

            $query = "INSERT INTO mall_order(orderid,goods_fk,goods_price, mod_price,
                                goods_name,goods_kind,goods_count,mod_count,
                                user_id, amount, volume, trans_cost, createdate,
                                buyer_name,buyer_zipcode,buyer_address,buyer_phone,
                                buyer_hphone,buyer_email,
                                recipient_name,recipient_zipcode,recipient_address,
                                recipient_phone,recipient_hphone,payment_type,status,
                                delivery_type, memo_to_delivery, memo_to_admin )
         VALUES ('$trade_code','$temp_code','$temp_price', '$temp_price',
                '$temp_name','$temp_kind', '$temp_count', '$temp_count',
                '$user_id', '$tot_money', '$temp_count','$trans_cost', now(),
                '$buyer_name','$buyer_zipcode', '$buyer_address', '$buyer_phone',
                '$buyer_hphone', '$buyer_email',
                '$recipient_name', '$recipient_zipcode','$recipient_address',
                '$recipient_phone','$recipient_hphone', '$payment_type', '$status',
                '$delivery_type', '$memo_to_delivery', '$memo_to_admin')";

            $result = mysqli_query($connect, $query);

// 결제정보 DB에 저장
            $query2 = "INSERT INTO pg_info(LGD_RESPCODE, LGD_RESPMSG, LGD_MID, LGD_OID, LGD_AMOUNT, LGD_TID, LGD_PAYTYPE, LGD_PAYDATE,
                                            LGD_HASHDATA, LGD_FINANCECODE, LGD_FINANCENAME, LGD_ESCROWYN, LGD_TIMESTAMP, LGD_FINANCEAUTHNUM,
                                            LGD_CARDNUM, LGD_CARDINSTALLMONTH, LGD_CARDNOINTYN, LGD_TRANSAMOUNT, LGD_EXCHANGERATE, LGD_ACCOUNTNUM,
                                            LGD_CASTAMOUNT, LGD_CASCAMOUNT, LGD_CASFLAG, LGD_CASSEQNO, LGD_CASHRECEIPTNUM, LGD_CASHRECEIPTSELFYN, LGD_CASHRECEIPTKIND)
                                    VALUES ('$LGD_RESPCODE', '$LGD_RESPMSG', '$LGD_MID', '$LGD_OID', '$LGD_AMOUNT', '$LGD_TID', '$LGD_PAYTYPE', '$LGD_PAYDATE',
                                            '$LGD_HASHDATA', '$LGD_FINANCECODE', '$LGD_FINANCENAME', '$LGD_ESCROWYN', '$LGD_TIMESTAMP', '$LGD_FINANCEAUTHNUM',
                                            '$LGD_CARDNUM', '$LGD_CARDINSTALLMONTH', '$LGD_CARDNOINTYN', '$LGD_TRANSAMOUNT', '$LGD_EXCHANGERATE', '$LGD_ACCOUNTNUM',
                                            '$LGD_CASTAMOUNT', '$LGD_CASCAMOUNT', '$LGD_CASFLAG', '$LGD_CASSEQNO', '$LGD_CASHRECEIPTNUM', '$LGD_CASHRECEIPTSELFYN', '$LGD_CASHRECEIPTKIND' )";

            $result2 = mysqli_query($connect, $query2);

            if ($result2) {
                $resultMSG = "OK";
            } else {
                echo "Error occured while updating CASFLAG";
            }
            // debug
            $re   = '$LGD_CASFLAG: ' . $LGD_CASFLAG . ' - $resultMSG: ' . $resultMSG . "\n";
            $txt  = print_r($re, true);
            $file = fopen("r_log.txt", "a+b");
            fwrite($file, $txt);
            fclose($file);

        } else if ("I" == $LGD_CASFLAG) {
            /*
             * 무통장 입금 성공 결과 상점 처리(DB) 부분
             * 상점 결과 처리가 정상이면 "OK"
             */
            // $update = 'I';
            // require_once 'save_wireinfo_to_db.php';
            //if( 무통장 입금 성공 상점처리결과 성공 )
            // $resultMSG = "OK";

            $status = "3"; //주문진행 상태(주문 미처리)

            $query  = "UPDATE mall_order SET status='$status' WHERE orderid = '$lgd_oid' ";
            $result = mysqli_query($connect, $query);

            $query2 = "UPDATE pg_info SET
                                        LGD_RESPCODE            = '$LGD_RESPCODE',
                                        LGD_RESPMSG             = '$LGD_RESPMSG',
                                        LGD_PAYDATE             = '$LGD_PAYDATE',
                                        LGD_ESCROWYN            = '$LGD_ESCROWYN',
                                        LGD_TIMESTAMP           = '$LGD_TIMESTAMP',
                                        LGD_CASTAMOUNT          = '$LGD_CASTAMOUNT',
                                        LGD_CASCAMOUNT          = '$LGD_CASCAMOUNT',
                                        LGD_CASFLAG             = '$LGD_CASFLAG',
                                        LGD_CASSEQNO            = '$LGD_CASSEQNO',
                                        LGD_CASHRECEIPTNUM      = '$LGD_CASHRECEIPTNUM',
                                        LGD_CASHRECEIPTSELFYN   = '$LGD_CASHRECEIPTSELFYN',
                                        LGD_CASHRECEIPTKIND     = '$LGD_CASHRECEIPTKIND'
                                    WHERE LGD_OID = '$lgd_oid'";

            $result2 = mysqli_query($connect, $query2);

            if ($result2) {
                $resultMSG = "OK";
                // $resultMSG = iconv("euc-kr", "utf-8", $resultMSG);
            } else {
                echo "Error occured while updating CASFLAG";
            }

            // debug
            $re   = '$LGD_CASFLAG: ' . $LGD_CASFLAG . ' - $resultMSG: ' . $resultMSG . "\n";
            $txt  = print_r($re, true);
            $file = fopen("i_log.txt", "a+b");
            fwrite($file, $txt);
            fclose($file);

        } else if ("C" == $LGD_CASFLAG) {
            /*
             * 무통장 입금취소 성공 결과 상점 처리(DB) 부분
             * 상점 결과 처리가 정상이면 "OK"
             */
            //if( 무통장 입금취소 성공 상점처리결과 성공 )
            // $resultMSG = "OK";
            $update = 'C';
            require_once 'save_wireinfo_to_db.php';
        }
    } else {
        //결제가 실패이면
        /*
         * 거래실패 결과 상점 처리(DB) 부분
         * 상점결과 처리가 정상이면 "OK"
         */
        //if( 결제실패 상점처리결과 성공 )
        $resultMSG = "OK";

    }
} else {
    //해쉬값이 검증이 실패이면
    /*
     * hashdata검증 실패 로그를 처리하시기 바랍니다.
     */
    $resultMSG = "결제결과 상점 DB처리(LGD_CASNOTEURL) 해쉬값 검증이 실패하였습니다.";
}

echo $resultMSG;
