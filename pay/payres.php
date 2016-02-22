<?php include_once '../include/header.php';?>

        <section class="collapse_area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="check">
                            <h1>주문 처리결과</h1>
                        </div>

<?php
	/**
	 * payreq_crossplatform.php에서 넘어온 값
	 */
	//수령자가 다를 경우
	$check_diff_addr     = set_var($_POST['check_diff_addr']);
	$recipient_name      = set_var($_POST['recipient_name']);
	$recipient_zipcode   = set_var($_POST['recipient_zipcode01']);
	$recipient_address01 = set_var($_POST['recipient_address01']);
	$recipient_address02 = set_var($_POST['recipient_address02']);
	$recipient_phone     = set_var($_POST['recipient_phone']);
	$recipient_hphone    = set_var($_POST['recipient_hphone']);
	$recipient_address   = $recipient_address01 . ' ' . $recipient_address02;

	$memo_to_delivery = set_var($_POST['memo_to_delivery']);
	$memo_to_admin    = set_var($_POST['memo_to_admin']);

	/*
	 * [최종결제요청 페이지(STEP2-2)]
	 *
	 * LG유플러스으로 부터 내려받은 LGD_PAYKEY(인증Key)를 가지고 최종 결제요청.(파라미터 전달시 POST를 사용하세요)
	 */

	$configPath = "../lgpay/"; //LG유플러스에서 제공한 환경파일("/conf/lgdacom.conf,/conf/mall.conf") 위치 지정.

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

	require_once "../lgpay/XPayClient.php";
	$xpay = &new XPayClient($configPath, $CST_PLATFORM);
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
	    $LGD_RESPCODE          = $xpay->Response_Code();
	    $LGD_RESPMSG           = $xpay->Response_Msg();
	    $LGD_TID               = $xpay->Response("LGD_TID", 0);
	    $LGD_OID               = $xpay->Response("LGD_OID", 0);
	    $LGD_BUYER             = $xpay->Response("LGD_BUYER", 0);
	    $LGD_BUYEREMAIL        = $xpay->Response("LGD_BUYEREMAIL", 0);
	    $LGD_PRODUCTINFO       = $xpay->Response("LGD_PRODUCTINFO", 0);
	    $LGD_AMOUNT            = $xpay->Response("LGD_AMOUNT", 0);
	    $LGD_PAYTYPE           = $xpay->Response("LGD_PAYTYPE", 0);
	    $LGD_PAYDATE           = $xpay->Response("LGD_PAYDATE", 0);
	    $LGD_FINANCECODE       = $xpay->Response("LGD_FINANCECODE", 0);
	    $LGD_FINANCENAME       = $xpay->Response("LGD_FINANCENAME", 0);
	    $LGD_FINANCEAUTHNUM    = $xpay->Response("LGD_FINANCEAUTHNUM", 0);
	    $LGD_ACCOUNTNUM        = $xpay->Response("LGD_ACCOUNTNUM", 0);
	    $LGD_HASHDATA          = $xpay->Response("LGD_HASHDATA", 0);
	    $LGD_ESCROWYN          = $xpay->Response("LGD_ESCROWYN", 0);
	    $LGD_TRANSAMOUNT       = $xpay->Response("LGD_TRANSAMOUNT", 0);
	    $LGD_EXCHANGERATE      = $xpay->Response("LGD_EXCHANGERATE", 0);
	    $LGD_CARDNUM           = $xpay->Response("LGD_CARDNUM", 0);
	    $LGD_CARDINSTALLMONTH  = $xpay->Response("LGD_CARDINSTALLMONTH", 0);
	    $LGD_CARDNOINTYN       = $xpay->Response("LGD_CARDNOINTYN", 0);
	    $LGD_TIMESTAMP         = $xpay->Response("LGD_TIMESTAMP", 0);
	    $LGD_PAYTELNUM         = $xpay->Response("LGD_PAYTELNUM", 0);
	    $LGD_ACCOUNTNUM        = $xpay->Response("LGD_ACCOUNTNUM", 0);
	    $LGD_CASTAMOUNT        = $xpay->Response("LGD_CASTAMOUNT", 0);
	    $LGD_CASCAMOUNT        = $xpay->Response("LGD_CASCAMOUNT", 0);
	    $LGD_CASFLAG           = $xpay->Response("LGD_CASFLAG", 0);
	    $LGD_CASSEQNO          = $xpay->Response("LGD_CASSEQNO", 0);
	    $LGD_CASHRECEIPTNUM    = $xpay->Response("LGD_CASHRECEIPTNUM", 0);
	    $LGD_CASHRECEIPTSELFYN = $xpay->Response("LGD_CASHRECEIPTSELFYN", 0);
	    $LGD_CASHRECEIPTKIND   = $xpay->Response("LGD_CASHRECEIPTKIND", 0);
	    $LGD_OCBSAVEPOINT      = $xpay->Response("LGD_OCBSAVEPOINT", 0);
	    $LGD_OCBTOTALPOINT     = $xpay->Response("LGD_OCBTOTALPOINT", 0);
	    $LGD_OCBUSABLEPOINT    = $xpay->Response("LGD_OCBUSABLEPOINT", 0);

	    // $amount = number_format($LGD_AMOUNT);
	    // $paydate = date('Y-m-d h:i:s', $LGD_PAYDATE);

	    echo <<<HEREDOC

                        <div class="alert alert-success" role="alert">주문완료! 결제에 성공하였습니다.</div>
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
                	          <td>{$LGD_ACCOUNTNUM}<br><i class="fa fa-info-circle"></i> 주문조회에서도 확인이 가능합니다.</td>
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

	    // echo "결제요청이 완료되었습니다.  <br>";
	    // echo "TX Response_code = " . $xpay->Response_Code() . "<br>";
	    // echo "TX Response_msg = " . $xpay->Response_Msg() . "<p>";

	    // echo "거래번호 : " . $xpay->Response("LGD_TID", 0) . "<br>";
	    // echo "상점아이디 : " . $xpay->Response("LGD_MID", 0) . "<br>";
	    // echo "상점주문번호 : " . $xpay->Response("LGD_OID", 0) . "<br>";
	    // echo "결제금액 : " . $xpay->Response("LGD_AMOUNT", 0) . "<br>";
	    // echo "결과코드 : " . $xpay->Response("LGD_RESPCODE", 0) . "<br>";
	    // echo "결과메세지 : " . $xpay->Response("LGD_RESPMSG", 0) . "<p>";

	    // $keys = $xpay->Response_Names();
	    // foreach ($keys as $name) {
	    //     echo $name . " = " . $xpay->Response($name, 0) . "<br>";
	    // }

	    // echo "<p>";

	    if ("0000" == $xpay->Response_Code()) {
	        //최종결제요청 결과 성공 DB처리
	        require_once 'save_pginfo_to_db.php';

	        //최종결제요청 결과 성공 DB처리 실패시 Rollback 처리
	        $isDBOK = true; //DB처리 실패시 false로 변경해 주세요.
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
	    echo <<<HEREDOC

                        <div class="alert alert-danger" role="alert">주문실패! 결제에 실패하였습니다.<p>관리자에게 문의하세요</p></div>
                            <table class="table table-striped">
                                <tr>
                                    <th>결과코드 :</th>
                                    <td>{$LGD_RESPCODE}</td>
                                </tr>
                                <tr>
                                    <th>결과메세지 :</th>
                                    <td>{$LGD_RESPMSG}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="row payinfo-button" >
                            <button type="button" class="btn btn-danger" data-dismiss="modal" id="cancel">카트로 돌아가기</button>
                        </div>

HEREDOC;

	    // echo "결제요청이 실패하였습니다.  <br>";
	    // echo "TX Response_code = " . $xpay->Response_Code() . "<br>";
	    // echo "TX Response_msg = " . $xpay->Response_Msg() . "<p>";

	    // //최종결제요청 결과 실패 DB처리
	    // echo "최종결제요청 결과 실패 DB처리하시기 바랍니다.<br>";
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