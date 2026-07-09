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
                            <?php $reVal = show_cart_item();?>
                            <!-- 카트 아이템 보여주기 -->
                                <div class="a-all ">
                                    <div class="a-left">
                                        <button class="button2  notice" type="button" onclick="location.href='/shop/'">
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
                        <i class="fa fa-check-circle"></i> 택배비 안내: <?php echo show_min_delivery_fee(); ?>원 이상 무료배송입니다.<br>
                        <i class="fa fa-check-circle"></i> 수량 변경 후 변경 버튼을 눌러주세요.

                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="totals">
                            <div class="subtotal">
<?php $reAddedFee = show_delivery_fee($reVal['tot_money']);?>
                                <p><i class="fa fa-truck"></i> 택배비: <span><?php echo $reAddedFee['msg']; ?></span></p>
                                <p class="grand-total">총  합: <span><i class="fa fa-krw"></i> <?php echo number_format($reVal['tot_money'] + $reAddedFee['trans_cost']); ?></span> (VAT 포함)</p>
                            </div>
<?php

$pflag = $reVal['pflag']; // 상품품절여부
$oflag = $reVal['oflag']; // 옵션품절여부

if ($pflag == "Y") {
    echo <<<HEREDOC

                            <button class="button2 get" type="button" onclick="alert('품절/단종된 상품이 있습니다. 해당상품 삭제 후 다시 주문하시기 바랍니다.')">
                                <span><i class="fa fa-check-circle"></i> 주문서 작성하기</span>
                            </button>
HEREDOC;
} elseif ($oflag == "Y") {
    echo <<<HEREDOC

                            <button class="button2 get" type="button" onclick="alert('품절/단종된 옵션이 있습니다. 해당상품 삭제 후 다시 주문하시기 바랍니다.')">
                                <span><i class="fa fa-check-circle"></i> 주문서 작성하기</span>
                            </button>
HEREDOC;
} else {

    // 2020.2.26 추가
    // https 프로토콜 추가
    $protocol = check_protocol($sslPort);

    $go_order = go_purchase($reVal['tot_money']);
    
    echo <<<HEREDOC

    <button class="button2 get" type="button" onclick="location.href='/shop/{$go_order}'">
                <span><i class="fa fa-check-circle"></i> 주문서 작성하기</span>
            </button>
HEREDOC;

//    echo <<<HEREDOC

//                            <button class="button2 get" type="button" onclick="location.href='{$protocol}//{$_SERVER['SERVER_NAME']}:{$sslPort}/shop/{$go_order}'">
//                                        <span><i class="fa fa-check-circle"></i> 주문서 작성하기</span>
//                                    </button>
// HEREDOC;

//     echo <<<HEREDOC

//                             <button class="button2 get" type="button" onclick="{$go_order}">
    //                                     <span><i class="fa fa-check-circle"></i> 주문서 작성하기</span>
    //                                 </button>
    // HEREDOC;

}

?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end shopping-cart-area
        ============================================ -->

<?php include_once '../include/brands.php';?>

<?php include_once '../include/footer.php';?>

      <script>
          $(document).ready(function() {

              setTimeout("location.reload();",60000);

          });
      </script>

    </body>
</html>