<?php

if ($update == 'N') {

    // 포장완료 등 처리는 했으나 아직 입금이 안된 경우도 있을 수 있음
    // 주문처리 상태를 확인해야함
    // $qry = "SELECT * FROM mall_order WHERE orderid = '" . $lgd_oid . "' ";
    // $res = mysqli_query($connect, $qry);
    // $row = mysqli_fetch_array($res);

    // $status = "1"; //주문진행 상태(입금대기)

    // $query  = "UPDATE mall_order SET status='" . $row['status'] . "' WHERE orderid = '" . $lgd_oid . "' ";
    // $result = mysqli_query($connect, $query);

// 결제정보 DB에 저장
    $query2 = "INSERT INTO pg_info(LGD_RESPCODE, LGD_RESPMSG, LGD_MID, LGD_OID, LGD_AMOUNT, LGD_TID, LGD_PAYTYPE, LGD_PAYDATE,
                                            LGD_HASHDATA, LGD_FINANCECODE, LGD_FINANCENAME, LGD_ESCROWYN, LGD_TIMESTAMP, LGD_FINANCEAUTHNUM,
                                            LGD_CARDNUM, LGD_CARDINSTALLMONTH, LGD_CARDNOINTYN, LGD_TRANSAMOUNT, LGD_EXCHANGERATE, LGD_ACCOUNTNUM,
                                            LGD_CASTAMOUNT, LGD_CASCAMOUNT, LGD_CASFLAG, LGD_CASSEQNO, LGD_CASHRECEIPTNUM, LGD_CASHRECEIPTSELFYN, LGD_CASHRECEIPTKIND, LGD_DEFAULTCASHRECEIPTUSE)
                                    VALUES ('$LGD_RESPCODE', '$LGD_RESPMSG', '$LGD_MID', '$LGD_OID', '$LGD_AMOUNT', '$LGD_TID', '$LGD_PAYTYPE', '$LGD_PAYDATE',
                                            '$LGD_HASHDATA', '$LGD_FINANCECODE', '$LGD_FINANCENAME', '$LGD_ESCROWYN', '$LGD_TIMESTAMP', '$LGD_FINANCEAUTHNUM',
                                            '$LGD_CARDNUM', '$LGD_CARDINSTALLMONTH', '$LGD_CARDNOINTYN', '$LGD_TRANSAMOUNT', '$LGD_EXCHANGERATE', '$LGD_ACCOUNTNUM',
                                            '$LGD_CASTAMOUNT', '$LGD_CASCAMOUNT', '$LGD_CASFLAG', '$LGD_CASSEQNO', '$LGD_CASHRECEIPTNUM', '$LGD_CASHRECEIPTSELFYN', '$LGD_CASHRECEIPTKIND' , '$LGD_DEFAULTCASHRECEIPTUSE')";

    $result2 = mysqli_query($connect, $query2);

    if ($result2) {
        $resultMSG = "OK";
    } else {
        $resultMSG = "FAIL";
    }
} elseif ($update == 'I') {

    $query2 = "UPDATE pg_info SET
                                LGD_RESPCODE              = '$LGD_RESPCODE',
                                LGD_RESPMSG               = '$LGD_RESPMSG',
                                LGD_PAYDATE               = '$LGD_PAYDATE',
                                LGD_ESCROWYN              = '$LGD_ESCROWYN',
                                LGD_TIMESTAMP             = '$LGD_TIMESTAMP',
                                LGD_CASTAMOUNT            = '$LGD_CASTAMOUNT',
                                LGD_CASCAMOUNT            = '$LGD_CASCAMOUNT',
                                LGD_CASFLAG               = '$LGD_CASFLAG',
                                LGD_CASSEQNO              = '$LGD_CASSEQNO',
                                LGD_CASHRECEIPTNUM        = '$LGD_CASHRECEIPTNUM',
                                LGD_CASHRECEIPTSELFYN     = '$LGD_CASHRECEIPTSELFYN',
                                LGD_CASHRECEIPTKIND       = '$LGD_CASHRECEIPTKIND',
                                LGD_DEFAULTCASHRECEIPTUSE = '$LGD_DEFAULTCASHRECEIPTUSE'
                            WHERE LGD_OID = '$lgd_oid'";

    $result2 = mysqli_query($connect, $query2);

    if ($result2) {
        $resultMSG = "OK";
    } else {
        $resultMSG = "FAIL";
    }
} elseif ($update == 'C') {
    $query2  = "UPDATE pg_info SET LGD_CASFLAG = 'C' WHERE LGD_OID = '$lgd_oid'";
    $result2 = mysqli_query($connect, $query2);

    if ($result2) {
        $resultMSG = "OK";
    } else {
        $resultMSG = "FAIL";
    }
}

//주문상품 장바구니에서 삭제
for ($i = 0; $i < sizeof($products_num); $i++) {
    $qry2 = "DELETE FROM products_cart WHERE user_id = '$user_id' AND product_code='$products_num[$i]' ";
    mysqli_query($connect, $qry2);
}

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
