<?php

$useragent = $_SERVER['HTTP_USER_AGENT'];
if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
    $payUrl = "/smartpay/payreq_crossplatform.php";
} else {
    $payUrl = "/pay/payreq_crossplatform.php";
}

?>

<?php include_once '../include/header.php';?>

<?php $protocol = check_protocol($sslPort);?>

        <form name="LGD_PAYINFO" id="LGD_PAYINFO" method="post" action="<?php echo $payUrl; ?>">
        <section class="collapse_area">
            <div class="container">
                <div class="row">
                    <div class="col-md-9 col-sm-9">
                        <div class="check">
                            <h1>주문서 작성</h1>
                        </div>
                        <div class="faq-accordion">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                <span class="number">1</span>
                                                주문자 정보
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
                                        <div class="easy">
                                            <div class="left-info ship-info">
                                                <div class="left-up">
                                                    <?php show_buyer_info();?>
                                                </div>
                                                <!-- <a href="#">회원정보 수정하기</a> -->

                                                <div class="block-button-right back">
                                                    <button class="button2 get" type="button" title="" onclick="window.open('/member/register-form.php?mode=edit')">
                                                        <span>배송지 정보 수정하기</span>
                                                    </button>
                                                </div>
                                                    <p class="text-right help-block"><i class="fa fa-check-circle-o"></i> 수정 후에는 반드시 새로고침하세요</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingTwo">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                <span class="number">2</span>
                                                다른 주소로 배송
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                                        <div class="easy">
                                            <div class="billing-info">
                                                <div class="row">
                                                    <div class="input-one form-list col-sm-6">
                                                        <label class="required">
                                                            <i class="fa fa-exclamation-circle"></i> 다른 주소로 배송 시에만 체크 후 아래 양식에 입력해 주세요
                                                        <input type="checkbox" name="check_diff_addr" id="check_diff_addr" value="option1">

                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="input-one form-list col-sm-4">
                                                        <label class="required">
                                                            수령인 또는 회사명
                                                            <em>*</em>
                                                        </label>
                                                        <input class="email" type="text" name="recipient_name" value="">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="input-one form-list col-sm-3">
                                                        <label class="required">
                                                            우편번호
                                                            <em>*</em>
                                                        </label>
                                                        <input class="form-control" type="text" name="recipient_zipcode01" id="recipient_zipcode01" value="" readonly="readonly" />
                                                    </div>
                                                    <div class="input-one form-list col-sm-3">
                                                        <label class="empty">
                                                        &nbsp;
                                                        </label>
                                                        <em>&nbsp;</em>
                                                        <br>
                                                        <button class="button2" type="button" onclick="openDaumPostcode2()">우편번호 검색</button>
                                                    </div>
                                                </div>
                                                    <!-- postcode searching function -->
                                                    <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
                                                    <script>
                                                            function openDaumPostcode2() {
                                                                    new daum.Postcode({
                                                                            oncomplete: function(data) {
                                                                                    // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                                                                                    // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                                                                                    // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                                                                                    var fullAddr = ''; // 최종 주소 변수
                                                                                    var extraAddr = ''; // 조합형 주소 변수

                                                                                    // 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                                                                                    if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                                                                                            fullAddr = data.roadAddress;

                                                                                    } else { // 사용자가 지번 주소를 선택했을 경우(J)
                                                                                            fullAddr = data.jibunAddress;
                                                                                    }

                                                                                    // 사용자가 선택한 주소가 도로명 타입일때 조합한다.
                                                                                    if(data.userSelectedType === 'R'){
                                                                                            //법정동명이 있을 경우 추가한다.
                                                                                            if(data.bname !== ''){
                                                                                                    extraAddr += data.bname;
                                                                                            }
                                                                                            // 건물명이 있을 경우 추가한다.
                                                                                            if(data.buildingName !== ''){
                                                                                                    extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                                                                                            }
                                                                                            // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                                                                                            fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
                                                                                    }


                                                                                    // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
                                                                                    // 우편번호와 주소 정보를 해당 필드에 넣고, 커서를 상세주소 필드로 이동한다.
                                                                                    document.getElementById('recipient_zipcode01').value = data.zonecode; //5자리 새우편번호 사용

                                                                                    //전체 주소에서 연결 번지 및 ()로 묶여 있는 부가정보를 제거하고자 할 경우,
                                                                                    //아래와 같은 정규식을 사용해도 된다. 정규식은 개발자의 목적에 맞게 수정해서 사용 가능하다.
                                                                                    document.getElementById('recipient_address01').value = fullAddr;
                                                                                    document.getElementById('recipient_address02').focus();
                                                                            }
                                                                    }).open();
                                                            }
                                                    </script>
                                                <div class="row">
                                                    <div class="input-one form-list col-sm-6">
                                                        <label class="required">
                                                            주소
                                                            <em>*</em>
                                                        </label>
                                                        <input class="email" type="text" name="recipient_address01" id="recipient_address01" value="" type="text" readonly="readonly">
                                                    </div>
                                                    <div class="input-one form-list col-sm-6">
                                                        <label class="required">
                                                            상세주소
                                                            <em>*</em>
                                                        </label>
                                                        <input class="email" type="text" name="recipient_address02" id="recipient_address02" value="">
                                                    </div>
                                                </div>
                                                <div class="row">

                                                    <div class="input-one form-list col-sm-6">
                                                        <label class="required">
                                                            휴대전화
                                                            <em>*</em>
                                                        </label>
                                                        <input class="email" name="recipient_hphone" id="recipient_hphone" type="text" placeholder="(- 삽입)" value="">
                                                    </div>
                                                    <div class="input-one form-list col-sm-6">
                                                        <label class="required">
                                                            일반전화
                                                        </label>
                                                        <input class="email" name="recipient_phone" id="recipient_phone" type="text" placeholder="(- 삽입)" value="">
                                                    </div>
                                                </div>

                                                <div class="block-button-right">
                                                    <a class="o-back-to" href="#">
                                                        <i class="fa fa-arrow-up"></i>
                                                        Back
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingThree">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                <span class="number">3</span>
                                                배송 시 요청 또는 전달사항
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false" style="height: 0px;">
                                        <div class="easy">
                                            <div class="left-info ship-info">
                                                <div class="left-up">
                                                    <p class="help-block"><i class="fa fa-envelope-square"></i> 택배기사에게 전달하고 싶은 메모 </p>
                                                    <textarea name="memo_to_delivery" class="textarea-bottom"></textarea>
                                                    <p class="help-block"><i class="fa fa-envelope-square"></i> 신수상사 담당자에게 전달하고 싶은 메모 </p>
                                                    <textarea name="memo_to_admin"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingFour">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                <span class="number">4</span>
                                                주문내역 확인
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour" aria-expanded="false" style="height: 0px;">
                                        <div class="easy">
                                            <div class="order-review">
                                                <div class="table-responsive">
                                                    <?php echo show_checkout_item(); ?>
                                                </div>
                                                <div class="block-right">
                                                    <span>
                                                        <i class="fa fa-pencil-square"></i> 상품을 수정하시려면?
                                                        <a class="o-back-to" href="cart.php"> 카트 편집</a>
                                                    </span>
                                                </div>
                                                <div class="pay-method">
                                                    <span><i class="fa fa-credit-card"></i> 결제방법 선택:</span>
                                                    <select class="form-control" name="LGD_CUSTOM_USABLEPAY" id="LGD_CUSTOM_USABLEPAY">
                                                        <option value="SC0010">신용카드</option>
                                                        <option value="SC0030">실시간 계좌이체</option>
                                                        <option value="SC0040">무통장입금(가상계좌 발급)</option>
                                                    </select>

                                                    <input type="hidden" name="CST_MID" id="CST_MID" value="shinsoo">
                                                    <input type="hidden" name="CST_PLATFORM" id="CST_PLATFORM" value="<?php echo $CST_PLATFORM; ?>">
                                                    <input type="hidden" name="LGD_WINDOW_TYPE" id="LGD_WINDOW_TYPE" value="iframe">
                                                    <input type="hidden" name="LGD_CUSTOM_SWITCHINGTYPE" id="LGD_CUSTOM_SWITCHINGTYPE" value="IFRAME">
                                                    <input type="hidden" name="LGD_CUSTOM_FIRSTPAY" id="LGD_CUSTOM_FIRSTPAY" value="SC0010">

                                                    <button class="button2 get" type="submit" >결제하기</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <div class="Register4">
                            <h3>결제방법 안내</h3>
                            <div class="Checkout-sidebar">
                                <p><i class="fa fa-circle"></i> 기본 배송지 변경은 회원 정보에서 수정하세요.</p>
                                <p><i class="fa fa-circle"></i> 배송지 변경을 원하시면 2번에서 입력하세요.</p>
                                <p><i class="fa fa-circle"></i> 3번 항목에서는 택배기사 또는 담당자에게 메모를 남길 수 있습니다.</p>
                                <p><i class="fa fa-circle"></i> 최종적으로 주문내역을 확인하시고, 결제하기를 누르시면 됩니다.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        </form>


<?php include_once '../include/brands.php';?>

<?php include_once '../include/footer.php';?>

    </body>
</html>