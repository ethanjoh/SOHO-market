<?php //include_once '../include/auth.php';;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;;?>

<?php include_once '../include/header.php';?>


        <!-- start shopping-cart-area
		============================================ -->
        <div class="shopping-cart-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="s-cart-all">
                            <div class="page-title">
                                <h1>카트</h1>
                            </div>
                            <div class="cart-form table-responsive">
                            <!-- 카트 아이템 보여주기 반환값: 총합 -->
                            <?php $total = show_cart_item();?>
                            <!-- 카트 아이템 보여주기 -->
                                <div class="a-all ">
                                    <div class="a-left">
                                        <button class="button2  notice" type="button">
                                            <span>쇼핑 계속하기</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cart-collaterals row">
                    <div class="col-md-8 col-sm-12">
                        <i class="fa fa-check-circle"></i> 택배비 안내: 5만원 이상 무료배송입니다.<br>
                        <i class="fa fa-check-circle"></i> 수량 변경 후 변경 버튼을 눌러주세요.

                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="totals">
                            <div class="subtotal">
                                <p><i class="fa fa-truck"></i> 택배비: <span><?php echo show_delivery_fee($total); ?></span></p>
                                <p class="grand-total">총  합: <span><i class="fa fa-krw"></i>                                                                                                 <?php echo number_format($total); ?></span> (VAT 포함)</p>
                            </div>
                            <button class="button2 get" type="button" onclick="<?php echo go_purchase($total); ?>">
                                <span><i class="fa fa-check-circle"></i> 주문서 작성하기</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end shopping-cart-area
		============================================ -->

<?php include_once '../include/brands.php';?>

<?php include_once '../include/footer.php';?>

    </body>
</html>