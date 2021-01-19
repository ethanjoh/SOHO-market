<?php include_once '../include/header.php';?>

        <!-- start main_shop_area
		============================================ -->
        <section class="main_shop_area">
            <div class="breadcrumbs">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="container-inner">
                                <ul>
                                    <li class="home">
                                        <a href="#">Home</a>
                                        <span>
                                            <i class="fa fa-angle-right"></i>
                                        </span>
                                    </li>
                                    <li class="category3">
                                        <strong>이용안내</strong>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
<?php $com_info = get_company_info();?>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="about-optima-text">
                                <h1>
                                    About
                                    <strong>회원가입</strong>
                                </h1>
                                <p> Shinsoo-Market은 기본적으로는 회원제로 운영하고 있습니다.<br>
                                    개인회원 가입은 무료이며 회원가입 즉시 회원으로 Shinsoo-Market 이용이 가능합니다.<br>
                                    기업회원 가입은 승인절차 승인 후 기업회원으로 Shinsoo-Market 이용이 가능합니다.
                                </p>
                                <p>[기업회원 승인절차]</p>
                                <p><i class="fa fa-check-square-o" aria-hidden="true"></i> 회원가입 페이지에서 기업회원 가입을 선택하고 회원 가입 <br>
                                <i class="fa fa-check-square-o" aria-hidden="true"></i> 사업자 등록증 사본 팩스로 전송 (<?php echo $com_info['fax']; ?>) 또는 사업자 등록증 전체가 잘 나오도록 사진을 찍어서 <?php echo $com_info['email']; ?>으로 파일을 첨부하여 전송. <br>
                                이때 사업자 등록증 상의 주소가 자택으로 되어있는 경우 매장 사진을 함께 첨부.<br>
                                </p>
                                <p>
                                <i class="fa fa-check-square-o" aria-hidden="true"></i> 기존에 오프라인으로 본사와 거래가 있으셨던 고객님들은 사업자 등록증을 보내시지 않으셔도 되지만 회원가입을 하셔야 하며 담당자 승인 후 바로 이용이 가능합니다. <br>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="about-optima-text">
                                <h1>
                                    About
                                    <strong>회원 가입 시 혜택</strong>
                                </h1>
                                <p><i class="fa fa-check-square-o" aria-hidden="true"></i>본사 규정에 근거하여 우수 거래 시 등급을 부여해드리고 주문 시에 바로 할인 혜택을 드립니다.  <br>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="about-optima-text">
                                <h1>
                                    About
                                    <strong>주문 및 결제</strong>
                                </h1>
                                <p> 비회원은 주문을 하실 수 없습니다.<br>
                                </p>
                                <p><i class="fa fa-check-square-o" aria-hidden="true"></i> 로그인 후 상품 검색 후 카트에 담기 <br>
                                <i class="fa fa-check-square-o" aria-hidden="true"></i> 주문서 작성 후 결제(신용카드, 실시간 계좌이체, 무통장입금)<br>
                                <i class="fa fa-check-square-o" aria-hidden="true"></i> 주문 성공 후 주문조회에서 주문내역 확인 가능<br>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="about-optima-text">
                                <h1>
                                    About
                                    <strong>주문확인 및 조회</strong>
                                </h1>
                                <p><i class="fa fa-check-square-o" aria-hidden="true"></i> 로그인 후 상단 마이메뉴에서 주문내역을 통해 주문처리 과정을 실시간으로 확인하실 수 있습니다.<br>
                                <i class="fa fa-check-square-o" aria-hidden="true"></i> 발송이 완료되면 주문조회에서 해당 주문일을 클릭하시면 상세 내역 하단 운송장번호로 배송과정을 추적할 수 있습니다.<br>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="about-optima-text">
                                <h1>
                                    About
                                    <strong>배송</strong>
                                </h1>
                                <p><i class="fa fa-check-square-o" aria-hidden="true"></i> 평일 16:00시 이전에 결제가 확인된 주문에 대해서는 당일 출고합니다. (토요일 휴무)<br>
                                <i class="fa fa-check-square-o" aria-hidden="true"></i> 영업시간 외 입금이 확인된 주문건은 익일 출고가 됩니다.<br>
                                <i class="fa fa-check-square-o" aria-hidden="true"></i> 택배비는 100,000원 이상 주문 시 무료배송입니다.</p>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="about-optima-text">
                                <h1>
                                    About
                                    <strong>반품/환불</strong>
                                </h1>
<?php $com_info = get_company_info();?>
                                <p>[공통사항]</p>
                                <p><i class="fa fa-check-square-o" aria-hidden="true"></i> 상품 불량 및 파손 등은 동일 상품으로 맞교환 또는 환불 처리(품절 등의 사유)해 드립니다. <br>
                                <i class="fa fa-check-square-o" aria-hidden="true"></i> 고객의 부주의로 인한 파손 등에 대해서는 교환이나 환불처리 되지 않습니다.<br>
                                <i class="fa fa-check-square-o" aria-hidden="true"></i> 주문취소는 주문 미확인 전에는 회원님이 직접 주문조회 목록에서 취소할 수 있습니다.<br>
                                <i class="fa fa-check-square-o" aria-hidden="true"></i> 무통장입금의 경우 일정기간 동안 송금을 하지 않으면 자동 취소가 됩니다.<br>
                                <i class="fa fa-check-square-o" aria-hidden="true"></i> 카드결제의 경우 승인 취소가 가능하면 취소해드리고, 그렇지 않은 경우 송금해 드립니다.<br>
                                <i class="fa fa-check-square-o" aria-hidden="true"></i> 반송을 하실 때에는 주문번호, 회원아이디, 연락처를 메모하여 동봉해서 보내주시면 신속한 처리에 도움이 됩니다.(문의전화 <?php echo $com_info['tel']; ?>)<br>
                                </p>
                                <p>
                                <i class="fa fa-check-square-o" aria-hidden="true"></i> 반품주소: (<?php echo $com_info['zipcode']; ?>) <?php echo $com_info['addr1']; ?> <?php echo $com_info['addr2']; ?>
                                </p>
                                <p>[기업회원]</p>
                                <p><i class="fa fa-check-square-o" aria-hidden="true"></i> 방문하는 영업 사원에게 반품 하시거나 택배를 이용하여 본사로 직접 보내주셔도 됩니다. <br>
                                <i class="fa fa-check-square-o" aria-hidden="true"></i> 반품 및 환불절차는 담당자 확인 후 진행됩니다.
                                </p>
                                <p>[개인회원]</p>
                                <p><i class="fa fa-check-square-o" aria-hidden="true"></i> 상품의 실제 수령일부터 1개월 이내에만 가능합니다. <br>
                                <i class="fa fa-check-square-o" aria-hidden="true"></i> 상품을 사용한 흔적이 있다거나 상품이 훼손 되었다면 환불 및 반품이 절대 불가합니다.<br>
                                <i class="fa fa-check-square-o" aria-hidden="true"></i> 만약 1개월 이후 환불 및 반품을 요청하실 시에는 영업손실 등의 이유로 15% 차감된 금액으로 담당자 확인 후 처리됩니다.<br>
                                <i class="fa fa-check-square-o" aria-hidden="true"></i> 상품수령 후 5일 이내 단순변심에 의한 반품 시에는 택배비 선불 또는 (무료배송 상품의 경우) 왕복택배비 동봉 후 착불처리하여야 합니다.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

		<!-- end shop_area
		============================================ -->
<?php include_once '../include/brands.php';?>

<?php include_once '../include/footer.php';?>

    </body>
</html>
