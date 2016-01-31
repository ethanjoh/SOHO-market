<?php include_once '../include/auth.php';?>

<?php include_once '../include/header.php';?>


        <!-- start shopping-cart-area
		============================================ -->
        <form method="post" action="checkout.php">
        <div class="shopping-cart-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <div class="s-cart-all">
                            <div class="page-title">
                                <h1>카트</h1>
                            </div>
                            <div class="cart-form table-responsive">
                                <table id="shopping-cart-table" class="data-table cart-table">
                                    <tr>
                                        <th>제거</th>
                                        <th>이미지</th>
                                        <th>제품명</th>
                                        <th>공급가</th>
                                        <th>수량</th>
                                        <th>소계</th>
                                    </tr>
                                    <tr>
                                        <td class="sop-icon">
                                            <a href="#"><i class="fa fa-times"></i></a>
                                        </td>
                                        <td class="sop-cart">
                                            <a href="#"><img class="primary-image" alt="" src="../images/product/01_1.jpg"></a>
                                        </td>
                                        <td class="sop-cart"><a href="#">Cras neque metus</a></td>
                                        <td class="sop-cart"><i class="fa fa-krw"></i> 150</td>
                                        <td><input class="input-text qty" type="text" name="qty" maxlength="12" value="1" title="Qty"></td>
                                        <td class="sop-cart"><i class="fa fa-krw"></i> 150</td>
                                    </tr>
                                    <tr>
                                        <td class="sop-icon">
                                            <a href="#"><i class="fa fa-times"></i></a>
                                        </td>
                                        <td class="sop-cart">
                                            <a href="#"><img class="primary-image" alt="" src="../images/product/01_1.jpg"></a>
                                        </td>
                                        <td class="sop-cart"><a href="#">Accumsan elit </a></td>
                                        <td class="sop-cart"><i class="fa fa-krw"></i> 100</td>
                                        <td><input class="input-text qty" type="text" name="qty" maxlength="12" value="1" title="Qty"></td>
                                        <td class="sop-cart price"><i class="fa fa-krw"></i> 100</td>
                                    </tr>
                                    <tr class="totals">
                                        <td colspan="5" class="total-text">합계</td>
                                        <td class="total-amount"><i class="fa fa-krw"></i> 155</td>
                                    </tr>
                                </table>
                                <div class="a-all ">
                                    <div class="a-left">
                                        <button class="button2  notice" type="button">
                                            <span>쇼핑 계속하기</span>
                                        </button>
                                    </div>
                                    <div class="a-right">
                                        <button class="button2 notice Estimate" type="button">
                                            <span>카트 비우기</span>
                                        </button>
                                        <button class="button2 notice " type="button">
                                            <span>카트 업데이트</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cart-collaterals row">
                    <div class="col-md-8 col-sm-12">
                        <i class="fa fa-check-circle"></i> 택배비 안내: 5만원 이상 무료배송입니다.
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="totals">
                            <div class="subtotal">
                                <p><i class="fa fa-plus-circle"></i> 택배비: <span>5만원 미만 착불</span></p>
                                <p class="grand-total">총  합: <span><i class="fa fa-krw"></i> 5,000</span></p>
                            </div>
                            <button class="button2 get" type="submit">
                                <span>결제하기</span>
                            </button>
                            </form>
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