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
                                        <strong>배송/환불정책</strong>
                                    </li>
                                </ul>
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
                                <p><i class="fa fa-check-square-o" aria-hidden="true"></i> 영업일 기준으로 1~3일 이내 발송합니다. </p>
                                <p><i class="fa fa-check-square-o" aria-hidden="true"></i> 택배비는 50,000원 이상 주문 시 무료배송입니다.</p>
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
                                <i class="fa fa-check-square-o" aria-hidden="true"></i> 고객의 부주의로 인한 파손 등에 대해서는 교환이나 환불처리 되지 않으며, 보증기간 내에는 무상수리됩니다. 그 외 사유에서는 유상처리됩니다.<br>
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
