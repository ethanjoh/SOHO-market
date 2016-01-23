<?php
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

$pnum = set_var($_POST['pnum']);
$products_count = set_var($_POST['count']);
$amount = set_var($_POST['offer_price']);
$selected_opt = set_var($_POST['selected_opt']);

//$oid = set_var($_POST['oid']);
$last_amount = set_var($_POST['last_amount']);

if($from == 'basket' && $mode == 'del'){ //카트에 등록된 상품 삭제
     $query = "DELETE FROM offer_cart WHERE cart_id='$cart_id' ";
     $result = mysqli_query($connect, $query);

	 if($result) {
		$url = "view_cart.php?id=".$id;
		show_msg('상품을 삭제했습니다.', $url);
	}

}else if($from == 'list' && $mode == 'del') { //발주 목록에서 해당 발주 삭제
     $query = "DELETE FROM offer WHERE num='$oid' ";
     $result = mysqli_query($connect, $query);

	 if($result) {
		$url = "offer_list.php";
		show_msg('해당 발주서를 삭제했습니다.', $url);
	}

}else if($from == 'view' && $mode == 'ok') { //발주서 보기에서 입고확인
     $query = "UPDATE offer SET status = '4', last_amount='$last_amount' WHERE num='$oid' ";
     $result = mysqli_query($connect, $query);

	 echo "<meta http-equiv='Refresh' content='0; URL=offer_list.php'>";
}else {
	if(!$_COOKIE['p_sid']){
  		$SID = md5(uniqid(rand()));
  		SetCookie("p_sid",$SID,0,"/");
	}

	$optBarcode = explode('|', $selected_opt);

	$query = "INSERT INTO offer_cart (user_id, user_sid, product_fk,volume, amount, p_opt, barcode, wdate  )
				VALUES ('$id',
						'$_COOKIE[p_sid]',
						'$pnum',
						'$products_count',
						'$amount',
						'$optBarcode[0]',
						'$optBarcode[1]',
						now() )";
	$result = mysqli_query($connect, $query);

	if($result) {
		//$url = 'pre_offer.php?id='.$id;
		//show_msg('상품을 저장했습니다.', $url);

		//err_close('상품을 저장했습니다.');
		//장바구니에 담긴 수량 확인
		$query1 = "SELECT sum(volume) AS cnt FROM products p, offer_cart c WHERE c.user_id='$id' AND p.num=c.product_fk ORDER BY c.cart_id DESC ";
		$result1 = mysqli_query($connect, $query1);
		$row1 = mysqli_fetch_array($result1);

	    $msg = "<meta http-equiv='content-type' content='text/html; charset=UTF-8' />\n";
        $msg .= "<script>\n";
	    $msg .= "window.alert('장바구니에 담았습니다.')\n";
	    $msg .= "</script>\n";

		echo json_encode(array("msg"=>$msg, "qty"=>$row1['cnt']));

	}else{
		$msg = "<meta http-equiv='content-type' content='text/html; charset=UTF-8' />\n";
        $msg .= "<script>\n";
	    $msg .= "window.alert('장바구니에 담지 못했습니다.')\n";
	    $msg .= "</script>\n";

		echo json_encode(array("msg"=>$msg, "qty"=>$row1['cnt']));
	}
}

?>
