<?php

include_once "../include/admin_auth.php";
include_once "../../util/util.php";

$mode        = set_var($_POST['mode']);
$oid         = set_var($_POST['oid']);
$key         = set_var($_POST['key']);
$keyword     = set_var($_POST['keyword']);
$page        = set_var($_POST['page']);
$track_no    = set_var($_POST['track_no']);
$senddate    = set_var($_POST['senddate']);
$last_amount = set_var($_POST['last_amount']);
$uri         = set_var($_POST['reUrl']);
$uri         = urldecode($uri);

//택배비 변경
if ($mode == 'd1') {
    $update = "UPDATE mall_order SET trans_cost='0' WHERE num='$oid' ";
    $result = mysqli_query($connect, $update);

    echo "<meta http-equiv='refresh' content='0; URL=$uri?mode=$mode&amp;oid=$oid&amp;key=$key&amp;keyword=$keyword&amp;page=$page'>";
}
if ($mode == 'd2') {
    $update = "UPDATE mall_order SET trans_cost='2500' WHERE num='$oid' ";
    $result = mysqli_query($connect, $update);

    echo "<meta http-equiv='refresh' content='0; URL=$uri?mode=$mode&amp;oid=$oid&amp;key=$key&amp;keyword=$keyword&amp;page=$page'>";
}
if ($mode == 'd3') {
    $update = "UPDATE mall_order SET trans_cost='-1' WHERE num='$oid' ";
    $result = mysqli_query($connect, $update);

    echo "<meta http-equiv='refresh' content='0; URL=$uri?mode=$mode&amp;oid=$oid&amp;key=$key&amp;keyword=$keyword&amp;page=$page'>";
}
if ($mode == 'd4') {
    $update = "UPDATE mall_order SET status='$status', returndate='$returndate' WHERE num='$oid' ";
    $result = mysqli_query($connect, $update);

    echo "<meta http-equiv='refresh' content='0; URL=$uri?mode=$mode&amp;oid=$oid&amp;key=$key&amp;keyword=$keyword&amp;page=$page&amp;status=$status&amp;returndate=$returndate'>";
}

//결제확인 체크
if ($mode == "pchk1") {
    $update = "UPDATE mall_order SET pchk='Y' WHERE num='$oid' ";
    $result = mysqli_query($connect, $update);

    echo "<meta http-equiv='refresh' content='0; URL=$uri?mode=$mode&amp;oid=$oid&amp;key=$key&amp;keyword=$keyword&amp;page=$page'>";
}
if ($mode == "pchk2") {
    $update = "UPDATE mall_order SET pchk='N' WHERE num='$oid' ";
    $result = mysqli_query($connect, $update);

    echo "<meta http-equiv='refresh' content='0; URL=$uri?mode=$mode&amp;oid=$oid&amp;key=$key&amp;keyword=$keyword&amp;page=$page'>";
}
if ($mode == "pchk3") {
    $update = "UPDATE mall_order SET pchk='R' WHERE num='$oid' ";
    $result = mysqli_query($connect, $update);

    echo "<meta http-equiv='refresh' content='0; URL=$uri?mode=$mode&amp;oid=$oid&amp;key=$key&amp;keyword=$keyword&amp;page=$page'>";
}

/**
 * 주문확인
 * from or_view.php
 */
if ($mode == "orderConfirm") {
    $update = "UPDATE mall_order SET status='5' WHERE num='$oid' ";
    $result = mysqli_query($connect, $update);

    header("Location:" . $uri . "");
}

/**
 * 포장완료
 * from or_view.php
 */
if ($mode == "packingDone") {
    $update = "UPDATE mall_order SET status='7', last_amount='$last_amount' WHERE num='$oid' ";
    $result = mysqli_query($connect, $update);

    header("Location:" . $uri . "");
}

/**
 * 발송완료
 * sent: from or_view.php
 * 4: 사입
 * all: from insert_waybill.php
 */
if ($mode == "sent" || $mode == '4' || $mode == 'all') {

    $update = "UPDATE mall_order SET status='8', track_no='$track_no', last_amount='$last_amount', senddate='$senddate' WHERE num='$oid' ";
    $result = mysqli_query($connect, $update);

}

/**
 * 발송지연
 * from or_view.php
 */
if ($mode == "delay") {
    $update = "UPDATE mall_order SET status='0' WHERE num='$oid' ";
    $result = mysqli_query($connect, $update);

    header("Location:" . $uri . "");
}

//직송 운송장 입력 시 운송장번호만 입력
if ($mode == "d") {

    $qry  = "SELECT * FROM mall_order WHERE num='$oid' ";
    $res  = mysqli_query($connect, $qry);
    $rows = mysqli_fetch_array($res);

    $update = "UPDATE mall_order SET track_no='$track_no' WHERE num='$oid' ";
    $result = mysqli_query($connect, $update);
}

######### SMS 발송처리 (회원 SMS 수신 Y, 관리자 SMS 사용여부 Y 에만)
######### $sms: 회원 SMS 수신여부
$res     = mysqli_query($connect, "SELECT * FROM sms");
$sms_row = mysqli_fetch_array($res);

//관리페이지에서 SMS 사용여부 확인
if ($sms_row['sms'] == "Y") {
    //구매자에게 SMS 발송, 승인된 회원만 구매가능하므로 승인여부 제외, 직접수령 제외
    if ($sms == "Y" && $sms_row['orderout_chk'] == "Y" && $delivery_type != "D") {
        //send_sms(받는 사람 핸드폰번호, 메시지 타입, 날짜)
        //메시지 타입 4: 발송완료 처리, 날짜가 빈칸이면 즉시 발송
        send_sms($buyer_hphone, 4, $buyer_name, "", $connect);
    }

}
####### SMS 발송 끝

//DB 업데이트 후 복귀할 URL
if ($mode == "sent") {
    // echo "<meta http-equiv='refresh' content='0; URL=top_order_list.php?mode=" . $mode . "&amp;oid=" . $oid . "&amp;key=" . $key . "&amp;keyword=" . $keyword . "&amp;page=" . $page . "'>";
    header("Location:" . $uri . "");

} else if ($mode == "4") {
    //사입입력
    echo "<meta http-equiv='refresh' content='0; URL=track_list.php'>";
} else if ($mode == "all") {
    //전체입력
    header("Location:" . $uri . "");
    // echo "<meta http-equiv='refresh' content='0; URL=insert_waybill.php'>";
} else if ($mode == "d") {
    //직송입력
    echo "<meta http-equiv='refresh' content='0; URL=track_d_list.php'>";
}
