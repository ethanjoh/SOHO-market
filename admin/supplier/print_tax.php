<?php
//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";

// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

//거래명세서, 세금계산서 출력용 클래스정의 파일
include "../include/class.trade_note.php";
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>역세금계산서 출력</title>
</head>

<body>
<?php
	$today = date("Y-m-d");
	
	//공급받는자 정보(역발행 세금계산서이므로 관리자가 공급받는자가 된다.)
	$query = "SELECT * FROM admin_setup WHERE type='1'";
	$result = mysqli_query($connect, $query);
	$buyer_row = mysqli_fetch_array($result);
	
	$address2 = $buyer_row['addr1']." ".$buyer_row['addr2'];

	 //계산서 목록에서 정보를 가져온다.
	 $tax_qry = "SELECT * FROM sp_tax_list WHERE num='$num'";
	 $tax_res = mysqli_query($connect, $tax_qry);
	 $tax_row = mysqli_fetch_array($tax_res);

	 $NFORM = new Gizmo_TradeNote;

  	// VAT포함가로 출력합니다. $NFORM->AddArticle() 로 단가 또는 금액 입력시 VAT 포함가가 들어가야 합니다.
  	// $NFORM->SetTaxAdded(false); 이면 입력하는 단가나 금액은 VAT 별도가입니다.
  	$NFORM->SetTaxAdded(true);
  
  	// 일련번호를 지정합니다. (옵션)
  	//$NFORM->SetSerial('010022');
  
  	// 비고란 (개인 매출시 주민번호등 기록용) 내용입니다 (옵션)
  	//$NFORM->SetTaxNote('790222-1111111);

  	// 매출액의 청구/영수 여부를 지정합니다 (true:영수, false:청구 (기본:청구))
	if($tax_row['paid'] == 'N') {
  		$NFORM->SetReceipt(false);
	}else {
		$NFORM->SetReceipt(true);
	}

  	// 공급자 정보를 입력합니다. (계산서가 유효하기 위해서는 모든 항목을 정확히 입력해야 합니다)
	//역발행세금계산서이므로 공급업체가 공급자가 된다.
	$sp_qry = "SELECT * FROM supplier WHERE id='$id' ";
	$sp_res = mysqli_query($connect, $sp_qry);
	$sp_row = mysqli_fetch_array($sp_res);	
	
	$address = $sp_row['o_addr1']." ".$sp_row['o_addr2'];
	
  	$NFORM->SetCompany($sp_row['company_name'], $sp_row['ceo'], $sp_row['license_no'], $address, $sp_row['category1'], $sp_row['category2']);
  
  	// 공급받는자 정보를 입력합니다. (거래명세서 작성시에도 $this->SetCustomerTax() 를 사용할 수 있지만, 입력해야 할 항목들이 늘어납니다)	 
  	$NFORM->SetCustomerTax($buyer_row['company_name'], $buyer_row['ceo'], $buyer_row['license_no'], $address2, $buyer_row['category1'], $buyer_row['category2']);

 
    // 작성일을 'YYYY-mm-dd' 포맷으로 지정합니다.
    $NFORM->SetIssuedDate($tax_row['reg_date']);

  	// 출력매수 (공통:BOTH(공급자용/공급받는자용), 세금계산서:BLUE(공급받는자용만)/RED(공급자용만), 거래명세서:SINGLE(1매만)
  	$NFORM->SetPair('BLUE');

  	// 공급자 직인 이미지의 URL경로 (배경이 투명해야함, 60*60px 이하가 적당)
  	$temp = explode("/",$sp_row['sign_image_name']);
	for($i=1; $i < sizeof($temp); $i++) {
		$path = "../../scm/images/sign/";
		$path .= $temp[$i];//파일명과 확장자만 추출해서 경로에 붙인다.
	}
	$NFORM->SetSignPath($path);

  	// 재발행건수를 설정합니다. (1 이상으로 설정시 우측하단에 재발행 메시지와 함께 카운트가 표시됩니다)
  	$NFORM->SetReissue(0);

  	// 품목정보를 필요한 만큼 입력합니다. (거래명세서와 동일)
  	// 단가나 금액은 한가지만 넣어주면 수량을 참조하여 나머지를 자동으로 채워 넣습니다.
  	// 단가와 금액 모두를 넣어주면 별도로 연산하지 않고 그대로 사용합니다.
  	//$NFORM->AddArticle('품목명', 금액, '거래일(YYYY-mm-dd)', '규격', '비고');
  	$NFORM->AddArticle2($tax_row['goods_name'], $tax_row['sum'], $tax_row['reg_date'], '', '');

  	// 세금계산서 HTML 양식 출력
  	// 인수로 양식파일의 경로를 지정할 수 있습니다. 기본 설치했을 경우는 현재 디렉토리의 form_tax.php 를 불러옵니다.
  	$NFORM->PrintTax();

  ?>
</body>
</html>
