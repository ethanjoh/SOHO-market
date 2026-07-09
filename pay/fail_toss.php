// 토스페이먼츠 결제 실패 혹은 사용자가 결제를 취소했을 때 안내해 주는 페이지
<?php
include_once '../include/header.php';

$code = isset($_GET['code']) ? set_var($_GET['code']) : '';
$message = isset($_GET['message']) ? set_var($_GET['message']) : '결제가 취소되었거나 실패했습니다.';
?>

<section class="collapse_area">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="check" style="margin-bottom:30px;">
                    <h1>결제 오류 안내</h1>
                </div>

                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-exclamation-triangle"></i> 결제 요청을 처리하지 못했습니다.</h3>
                    </div>
                    <div class="panel-body text-center" style="padding: 50px 0;">
                        <p style="font-size: 16px; margin-bottom: 30px;">
                            <?php if ($code) { echo "<strong>오류 코드:</strong> [" . htmlspecialchars($code) . "]<br><br>"; } ?>
                            <?php echo htmlspecialchars($message); ?>
                        </p>
                        
                        <div class="btn-group">
                            <a href="/shop/cart.php" class="btn btn-default"><i class="fa fa-shopping-cart"></i> 장바구니 보기</a>
                            <a href="/shop/checkout.php" class="btn btn-primary"><i class="fa fa-credit-card"></i> 다시 결제하기</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include_once '../include/footer.php';
?>
