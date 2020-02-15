<?php
include_once "../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

$oid  = set_var($_POST['oid']);
$page = set_var($_POST['page']);

/*
 * [결제취소 요청 페이지]
 *
 * LG유플러스으로 부터 내려받은 거래번호(LGD_TID)를 가지고 취소 요청을 합니다.(파라미터 전달시 POST를 사용하세요)
 * (승인시 LG유플러스으로 부터 내려받은 PAYKEY와 혼동하지 마세요.)
 */
$CST_PLATFORM = $_POST['CST_PLATFORM']; //LG유플러스 결제 서비스 선택(test:테스트, service:서비스)
$CST_MID      = $_POST['CST_MID']; //상점아이디(LG유플러스으로 부터 발급받으신 상점아이디를 입력하세요)
//테스트 아이디는 't'를 반드시 제외하고 입력하세요.
$LGD_MID = (("test" == $CST_PLATFORM) ? "t" : "") . $CST_MID; //상점아이디(자동생성)
$LGD_TID = $_POST['LGD_TID']; //LG유플러스으로 부터 내려받은 거래번호(LGD_TID)

$configPath = "/home/hosting_users/ssss01047271791/lgpay"; //LG유플러스에서 제공한 환경파일("/conf/lgdacom.conf") 위치 지정.

require_once "/home/hosting_users/ssss01047271791/lgpay/XPayClient.php";
$xpay = &new XPayClient($configPath, $CST_PLATFORM);
$xpay->Init_TX($LGD_MID);

$xpay->Set("LGD_TXNAME", "Cancel");
$xpay->Set("LGD_TID", $LGD_TID);

/**
 * 주문취소 처리
 */
//주문 취소에 따른 재고 복구
$qry = "SELECT * FROM mall_order WHERE num = '$oid' ";
$res = mysqli_query($connect, $qry);
$row = mysqli_fetch_array($res);

$a_goods_fk     = explode(",", $row['goods_fk']); //상품 코드
$a_goods_kind   = explode(",", $row['goods_kind']); //주문상품 옵션
$a_goods_volume = explode(",", $row['goods_count']); //변경된 수량
$new_opt_count  = array();

for ($i = 0; $i < sizeof($a_goods_fk); $i++) {
    $pro_sql    = "SELECT * FROM products WHERE num = '$a_goods_fk[$i]' ";
    $pro_result = mysqli_query($connect, $pro_sql);
    $pro_row    = mysqli_fetch_array($pro_result);

    /**
    취소 옵션 재고 업데이트
     **/
    // 주문제품의 옵션을 가져옴
    $products_opt       = explode(",", $pro_row['opt']); // 제품의 옵션을 배열로 저장
    $products_opt_count = explode(",", $pro_row['opt_count']); // 제품의 옵션을 배열로 저장

    // 옵션별 재고 업데이트
    for ($j = 0; $j < sizeof($products_opt); $j++) {
        if ($products_opt[$j] == $a_goods_kind[$i]) {
            $products_opt_count[$j] = $products_opt_count[$j] + $a_goods_volume[$i]; // 취소 주문수량 가감 후 전체재고 업데이트
            $final_opt_count        = implode(",", $products_opt_count);

            $qry2 = "UPDATE products SET opt_count='$final_opt_count' WHERE num = '$a_goods_fk[$i]' ";
            mysqli_query($connect, $qry2);
        }
    }
}

// 해당 주문정보를 취소처리 합니다.
$update = "UPDATE mall_order SET cancel='Y', last_amount=0 WHERE num='" . $oid . "' ";
$result = mysqli_query($connect, $update);

/*
 * 1. 결제취소 요청 결과처리
 *
 * 취소결과 리턴 파라미터는 연동메뉴얼을 참고하시기 바랍니다.
 */
if ($xpay->TX()) {
    $LGD_RESPCODE = $xpay->Response_Code();
    $LGD_RESPMSG  = $xpay->Response_Msg();

    $query2 = "UPDATE pg_info SET
                                        LGD_RESPCODE            = '$LGD_RESPCODE',
                                        LGD_RESPMSG             = '$LGD_RESPMSG'
                                    WHERE LGD_TID = '$LGD_TID'";

    $result2 = mysqli_query($connect, $query2);

    //1)결제취소결과 화면처리(성공,실패 결과 처리를 하시기 바랍니다.)
    $url = "order-list.php?page=" . $page;
    show_msg("결제 취소요청을 완료했습니다.", $url);
} else {
    //2)API 요청 실패 화면처리
    $url = "order-list.php?page=" . $page;
    show_msg("결제 취소요청이 실패하였습니다.", $url);
}
