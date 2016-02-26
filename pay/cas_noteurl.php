<?php
$config  = parse_ini_file('../util/config.ini');
$host    = $config['host'];
$dbid    = $config['dbid'];
$dbpass  = $config['dbpass'];
$dbname  = $config['dbname'];
$port    = $config['port'];
$MERTKEY = $config['mertkey'];

$connect = mysqli_connect($host, $dbid, $dbpass, $dbname);

/*
 * [상점 결제결과처리(DB) 페이지]
 *
 * 1) 위변조 방지를 위한 hashdata값 검증은 반드시 적용하셔야 합니다.
 *
 */
$LGD_RESPCODE          = $HTTP_POST_VARS["LGD_RESPCODE"];          // 응답코드: 0000(성공) 그외 실패
$LGD_RESPMSG           = $HTTP_POST_VARS["LGD_RESPMSG"];           // 응답메세지
$LGD_MID               = $HTTP_POST_VARS["LGD_MID"];               // 상점아이디
$LGD_OID               = $HTTP_POST_VARS["LGD_OID"];               // 주문번호
$LGD_AMOUNT            = $HTTP_POST_VARS["LGD_AMOUNT"];            // 거래금액
$LGD_TID               = $HTTP_POST_VARS["LGD_TID"];               // LG유플러스에서 부여한 거래번호
$LGD_PAYTYPE           = $HTTP_POST_VARS["LGD_PAYTYPE"];           // 결제수단코드
$LGD_PAYDATE           = $HTTP_POST_VARS["LGD_PAYDATE"];           // 거래일시(승인일시/이체일시)
$LGD_HASHDATA          = $HTTP_POST_VARS["LGD_HASHDATA"];          // 해쉬값
$LGD_FINANCECODE       = $HTTP_POST_VARS["LGD_FINANCECODE"];       // 결제기관코드(은행코드)
$LGD_FINANCENAME       = $HTTP_POST_VARS["LGD_FINANCENAME"];       // 결제기관이름(은행이름)
$LGD_ESCROWYN          = $HTTP_POST_VARS["LGD_ESCROWYN"];          // 에스크로 적용여부
$LGD_TIMESTAMP         = $HTTP_POST_VARS["LGD_TIMESTAMP"];         // 타임스탬프
$LGD_ACCOUNTNUM        = $HTTP_POST_VARS["LGD_ACCOUNTNUM"];        // 계좌번호(무통장입금)
$LGD_CASTAMOUNT        = $HTTP_POST_VARS["LGD_CASTAMOUNT"];        // 입금총액(무통장입금)
$LGD_CASCAMOUNT        = $HTTP_POST_VARS["LGD_CASCAMOUNT"];        // 현입금액(무통장입금)
$LGD_CASFLAG           = $HTTP_POST_VARS["LGD_CASFLAG"];           // 무통장입금 플래그(무통장입금) - 'R':계좌할당, 'I':입금, 'C':입금취소
$LGD_CASSEQNO          = $HTTP_POST_VARS["LGD_CASSEQNO"];          // 입금순서(무통장입금)
$LGD_CASHRECEIPTNUM    = $HTTP_POST_VARS["LGD_CASHRECEIPTNUM"];    // 현금영수증 승인번호
$LGD_CASHRECEIPTSELFYN = $HTTP_POST_VARS["LGD_CASHRECEIPTSELFYN"]; // 현금영수증자진발급제유무 Y: 자진발급제 적용, 그외 : 미적용
$LGD_CASHRECEIPTKIND   = $HTTP_POST_VARS["LGD_CASHRECEIPTKIND"];   // 현금영수증 종류 0: 소득공제용 , 1: 지출증빙용
$LGD_PAYER             = $HTTP_POST_VARS["LGD_PAYER"];             // 입금자명

/*
 * 구매정보
 */
$LGD_BUYER         = $HTTP_POST_VARS["LGD_BUYER"];         // 구매자
$LGD_PRODUCTINFO   = $HTTP_POST_VARS["LGD_PRODUCTINFO"];   // 상품명
$LGD_BUYERID       = $HTTP_POST_VARS["LGD_BUYERID"];       // 구매자 ID
$LGD_BUYERADDRESS  = $HTTP_POST_VARS["LGD_BUYERADDRESS"];  // 구매자 주소
$LGD_BUYERPHONE    = $HTTP_POST_VARS["LGD_BUYERPHONE"];    // 구매자 전화번호
$LGD_BUYEREMAIL    = $HTTP_POST_VARS["LGD_BUYEREMAIL"];    // 구매자 이메일
$LGD_BUYERSSN      = $HTTP_POST_VARS["LGD_BUYERSSN"];      // 구매자 주민번호
$LGD_PRODUCTCODE   = $HTTP_POST_VARS["LGD_PRODUCTCODE"];   // 상품코드
$LGD_RECEIVER      = $HTTP_POST_VARS["LGD_RECEIVER"];      // 수취인
$LGD_RECEIVERPHONE = $HTTP_POST_VARS["LGD_RECEIVERPHONE"]; // 수취인 전화번호
$LGD_DELIVERYINFO  = $HTTP_POST_VARS["LGD_DELIVERYINFO"];  // 배송지

// $LGD_MERTKEY = "e57352760ea5a2a1fce315c6ead11ece"; //LG유플러스에서 발급한 상점키로 변경해 주시기 바랍니다.
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

require_once 'variable_from_payreq.php';

if ($LGD_HASHDATA2 == $LGD_HASHDATA) {
    //해쉬값 검증이 성공이면
    if ("0000" == $LGD_RESPCODE) {
        //결제가 성공이면
        if ("R" == $LGD_CASFLAG) {
            /*
             * 무통장 할당 성공 결과 상점 처리(DB) 부분
             * 상점 결과 처리가 정상이면 "OK"
             */
            //if( 무통장 할당 성공 상점처리결과 성공 )
            // $resultMSG = "OK";
            $update = 'N';
            require_once 'save_wireinfo_to_db.php';

        } else if ("I" == $LGD_CASFLAG) {
            /*
             * 무통장 입금 성공 결과 상점 처리(DB) 부분
             * 상점 결과 처리가 정상이면 "OK"
             */
            //if( 무통장 입금 성공 상점처리결과 성공 )
            // $resultMSG = "OK";
            // $update = 'I';
            // require_once 'save_wireinfo_to_db.php';

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

            if (!$result2) {
                echo "Error occured while saving payment data.";
                $resultMSG = "FAIL";
            } else {
                $resultMSG = "OK";
            }

            //주문상품 장바구니에서 삭제
            // for ($i = 0; $i < sizeof($products_num); $i++) {
            //     $qry2 = "DELETE FROM products_cart WHERE user_id = '$user_id' AND product_code='$products_num[$i]' ";
            //     mysqli_query($connect, $qry2);
            // }

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
                ####### SMS 발송 끝
            }
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
