<?php include_once '../include/header.php';?>

        <section class="collapse_area">
            <div class="container">
                <div class="row">
                    <div class="col-md-9 col-sm-9">
                        <div class="check">
                            <h1>결제하기</h1>
                        </div>
                        <div class="faq-accordion">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingOne">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                <span class="number">1</span>
                                                기본 배송지
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
                                                배송지 변경
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                                        <!-- <div class="row"> -->

                                            <div class="easy">
                                                <div class="billing-info">
                                                    <div class="row">
                                                        <div class="input-one form-list col-sm-4">
                                                            <label class="required">
                                                                <i class="fa fa-exclamation-circle"></i> 다른 주소로 배송 시 체크해 주세요
                                                            <input type="checkbox" name="optionsCheckbox2" id="optionsChackbox2" value="option1">

                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="input-one form-list col-sm-4">
                                                            <label class="required">
                                                                수령인 또는 회사명
                                                                <em>*</em>
                                                            </label>
                                                            <input class="email" type="text" name="recipient_name" value="" required="">
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
                                                            <label class="required">
                                                                &nbsp;
                                                            </label>
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
                                                            <input class="email" type="text" required="" name="recipient_address01" id="recipient_address01" value="" type="text" readonly="readonly">
                                                        </div>
                                                        <div class="input-one form-list col-sm-6">
                                                            <label class="required">
                                                                상세주소
                                                                <em>*</em>
                                                            </label>
                                                            <input class="email" type="text" required="" name="recipient_address02" id="recipient_address02" value="">
                                                        </div>
                                                    </div>
                                                    <div class="row">

                                                        <div class="input-one form-list col-sm-6">
                                                            <label class="required">
                                                                휴대전화
                                                                <em>*</em>
                                                            </label>
                                                            <input class="email" name="recipient_hphone" id="recipient_hphone" type="text" placeholder="(- 삽입)" value="" required="">
                                                        </div>
                                                        <div class="input-one form-list col-sm-6">
                                                            <label class="required">
                                                                일반전화
                                                            </label>
                                                            <input class="email" name="recipient_phone" id="recipient_phone" type="text" placeholder="(- 삽입)" value="" required="">
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
                                        <!-- </div> -->

                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingFour">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                <span class="number">4</span>
                                                배송 방법
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour" aria-expanded="false" style="height: 0px;">
                                        <div class="easy">
                                            <div class="shiping-method">
                                                <p>Flat Rate</p>
                                                <p>Fixed $40.00</p>
                                                <div class="block-button-right">
                                                    <a class="o-back-to" href="#">
                                                    <i class="fa fa-arrow-up"></i>
                                                    Back
                                                    </a>
                                                    <button class="button2 get" type="button" title="">
                                                        <span>Continue</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingFive">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                                <span class="number">5</span>
                                                결제 정보
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive" aria-expanded="false" style="height: 0px;">
                                        <div class="easy">
                                            <div class="checkout-option">
                                                <div class="method-input-box">
                                                    <p>
                                                        <input type="radio" value="check" name="payment">
                                                        <label>Check / Money order </label>
                                                    </p>
                                                    <p>
                                                        <input type="radio" checked="" value="card" name="payment">
                                                        <label>Credit Card (saved) </label>
                                                    </p>
                                                </div>
                                                <div class="master-card-info">
                                                    <form action="#">
                                                        <div class="input-one form-list col-sm-12">
                                                            <label class="required">
                                                                Name on Card
                                                                <em>*</em>
                                                            </label>
                                                            <input class="email" type="text" required="">
                                                        </div>
                                                        <div class=" input-one form-list col-sm-12">
                                                            <label class="required">Credit Card Type</label>
                                                            <select class="email s-email s-wid">
                                                                <option>--Please Select--</option>
                                                                <option>American Express</option>
                                                                <option>Visa</option>
                                                                <option>MasterCard</option>
                                                                <option>Discover</option>
                                                            </select>
                                                        </div>
                                                        <div class="input-one form-list col-sm-12">
                                                            <label class="required">
                                                                Credit Card Number
                                                                <em>*</em>
                                                            </label>
                                                            <input class="email" type="text" required="">
                                                        </div>
                                                        <div class="experi">
                                                            <div class="input-one form-list col-sm-12">
                                                                <label class="required">Expiration Date</label>

                                                            </div>
                                                            <div class="date">
                                                                <select class="email s-email">
                                                                    <option>--Month--</option>
                                                                    <option>01 - January</option>
                                                                    <option>02 - February</option>
                                                                    <option>03 - March</option>
                                                                    <option>04 - April</option>
                                                                    <option>05 - May</option>
                                                                    <option>06 - June</option>
                                                                    <option>07 - July</option>
                                                                    <option>08 - August</option>
                                                                    <option>09 - September</option>
                                                                    <option>10 - October</option>
                                                                    <option>11 - November</option>
                                                                    <option>12 - December</option>
                                                                </select>
                                                                <select class="email s-email">
                                                                    <option>--Year--</option>
                                                                    <option>2015</option>
                                                                    <option>2016</option>
                                                                    <option>2017</option>
                                                                    <option>2018</option>
                                                                    <option>2019</option>
                                                                    <option>2020</option>
                                                                    <option>2021</option>
                                                                    <option>2022</option>
                                                                    <option>2023</option>
                                                                    <option>2024</option>
                                                                    <option>2025</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="verificationcard input-one form-list col-sm-12">
                                                            <label class="required">
                                                                Card Verification Number
                                                                <em>*</em>
                                                            </label>
                                                            <input class="email" type="text" required="">
                                                        </div>
                                                    </form>
                                                    <div class="block-button-right">
                                                        <a class="o-back-to" href="#">
                                                            <i class="fa fa-arrow-up"></i>
                                                            Back
                                                        </a>
                                                        <button class="button2 get" type="button" title="">
                                                            <span>Continue</span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="headingSix">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                                <span class="number">6</span>
                                                주문내역 확인
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix" aria-expanded="false" style="height: 0px;">
                                        <div class="easy">
                                            <div class="order-review">
                                                <div class="table-responsive">
                                                    <?php echo show_checkout_item(); ?>
                                                </div>
                                                <div class="block-right">
                                                    <span>
                                                        상품을 수정하시려면?
                                                        <a class="o-back-to" href="cart.php"> 카트 편집</a>

                                                    </span>
                                                    <button class="button2 get" type="button" title="">
                                                        <span>Continue</span>
                                                    </button>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


<?php include_once '../include/brands.php';?>

<?php include_once '../include/footer.php';?>

    </body>
</html>