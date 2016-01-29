<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <meta name="keywords" content="<?=$info['keywords'];?>" />
    <meta name="description" content="<?=$info['description'];?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?=$info['site_name'];?></title>
    <link href="favicon.ico" rel="shortcut icon" type="image/x-icon">
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>

<!-- Preloader -->
<div id="preloader">
    <div id="status">&nbsp;</div>
</div>

<!-- WRAPPER -->
<div class="wrapper">

    <!-- HEADER -->
    <?php include "../include/header.php";?>
    <!-- /.header -->

    <!-- HOME -->
    <div class="overlay home medium-size">
        <div class="bg bg-cart" data-stellar-background-ratio="0.5"></div>
        <div class="container vmiddle">
            <div class="row text-center">
                <div class="icon-big color icon-caddie-shopping-streamline"></div>
                <h1>Shopping Cart</h1>
            </div>
        </div>
    </div>
    <!-- /.home -->

    <!-- CONTENT -->
    <div class="content">

        <!-- CONTAINER: cart -->
        <div class="container cart">

            <!-- TABLE -->
            <div class="table-responsive">
                <table class="cart-table border-bottom">
                    <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th>제 품 명</th>
                        <th>공 급 가</th>
                        <th>세    액</th>
                        <th>수    량</th>
                        <th>소    계</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php
//JOIN문을 사용해 장바구니와 제품정보에서 데이터를 가져옴
// 카테고리와 등록 순서로 정렬
$query       = "SELECT * FROM products p, products_cart c WHERE c.user_id='$_SESSION[p_id]' AND p.num=c.product_fk ORDER BY p.category_l ASC, num DESC ";
$result      = mysqli_query($connect, $query);
$total_count = mysqli_num_rows($result);

$tot_money = 0;
$tot_mny1  = 0;

if (!$total_count) {
    ?>

                        <tr>
                            <td class="text-center" colspan="7"><div class="alert alert-danger"><h3>카트가 비었습니다.</h3></div></td>
                        </tr>

                    <?php
} else {

    for ($i = 1; $rows = mysqli_fetch_array($result); $i++) {
        $s_tot     = (int) $rows['volume'] * (int) $rows['amount'];
        $tot_money = $tot_money + $s_tot;

        //상품품절 확인
        if ($rows['del_chk'] != "N") {
            $pflag = "Y";
        }

        //상품옵션 품절표시
        //상품 옵션이 있는지 확인 후 진행
        if ($rows['opt'] != "") {
            //장바구니의 옵션과 제품정보를 비교하여 품절옵션이 있는지 확인
            $t_opt       = explode(",", $rows['opt']); //장바구니 제품의 옵션명을 배열로 만들어준다
            $t_opt_stock = explode(",", $rows['opt_stock']); //제품의 옵션재고를 배열로 만들어준다

            //옵션의 문자열 비교
            for ($j = 0; $j < count($t_opt); $j++) {
                $str = strcmp($t_opt[$j], $rows['p_opt']);

                if (!$str) {
                    //문자열이 같다면 문자열 대체
                    if ($t_opt_stock[$j] == "0") {
                        $rows['p_opt'] .= " <font color=\"blue\">(품절)</font>";
                        $oflag = "Y";
                    } elseif ($t_opt_stock[$j] == "-1") {
                        $rows['p_opt'] .= " <font color=\"red\">(단종)</font>";
                        $oflag = "Y";
                    } else {
                        $rows['p_opt'] = $t_opt[$j];
                    }

                }
            } //end of for loop
        }
        ; //end of if clause

        ?>
                        <form name="basket<?=$i;?>" method="post" action="cart-update.php">
                        <input type="hidden" name="from" value="basket" />
                        <input type="hidden" name="pflag" value="<?=$pflag;?>" />
                        <input type="hidden" name="oflag" value="<?=$oflag;?>" />

                        <tr>
                            <td class="text-center">
                                <a href="detail.php?pnum=<?=$rows['num'];?>&lcode=<?=$rows['category_l'];?>&mcode=<?=$rows['category_m'];?>&scode=<?=$rows['category_s'];?>"><img src="<?=$rows['s_image_name'];?>"></a>
                            </td>
                            <td class="td-descr">
                                <a href="detail.php?pnum=<?=$rows['num'];?>&lcode=<?=$rows['category_l'];?>&mcode=<?=$rows['category_m'];?>&scode=<?=$rows['category_s'];?>"><?=stripslashes($rows['name']);?></a>
                                <p><?=$rows['p_opt'];?></p>
                            </td>
                            <td>
                                <div class="cost"><i class="fa fa-krw"></i> <?=number_format($rows['amount']);?></div>
                            </td>
                            <td>
                                <div class="cost"><i class="fa fa-krw"></i> <?=number_format($rows['amount'] * .1);?></div>
                            </td>
                            <td>
                                <div class="counting inline-block">
                                    <a href="" class="a-less disabled">-</a>
                                    <input type="text" name="products_count" value="<?=$rows['volume'];?>">
                                    <a href="" class="a-more">+</a>
                                    <input type="hidden" name="md" value="edit" />
                                    <input type="hidden" name="cart_id" value="<?=$rows['cart_id'];?>"/>
                                    <input type="submit" value="변경" />
                                </div>
                            </td>
                            <td>
                                <div class="cost"><i class="fa fa-krw"></i> <?=number_format($s_tot * 1.1);?></div>
                            </td>
                            <td class="text-center">
                                <a href="cart-update.php?md=del&amp;cart_id=<?=$rows['cart_id'];?>&amp;from=basket" ><i class="custom-icon custom-icon-close-s"></i></a>
                            </td>
                        </tr>
                        </form>
                    <?php
} // end for loop
}
; // end if(!$total_count)
?>


                    </tbody>
                </table>
            </div>
            <!-- /table -->

            <!-- row -->
            <div class="row border-bottom">
                <div class="col-md-4 col-sm-5 col-md-offset-8 col-sm-offset-7">
                    <h3 class="normal">카트 합</h3>
                    <table class="product-table">
                        <tr>
                            <th>배송비</th>
                            <td>무 료</td>
                        </tr>
                        <tr>
                            <th>주문 총계</th>
                            <td><i class="fa fa-krw"></i> <?=number_format($tot_money * 1.1);?> (inc. VAT)</td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- /.row -->

            <?php
if ($total_count == 0) {
    $go_purchase = "javascript:alert('카트에 상품이 없습니다.')";
} else {
    $go_purchase = "checkout.php?from=basket&amp;delivery=L";
}
?>

            <!-- row -->
            <div class="row">
                <div class="col-md-12 col-sm-12 text-center">
                    <a href="<?=$go_purchase;?>" class="btn btn-success">주문서 작성하기</a>
                </div>
            </div>
        </div>
        <!-- /.container -->
    </div>
    <!-- /.content -->
</div>
<!-- /.wrapper -->

<!-- FOOTER -->
<?php include "../include/footer.php";?>

<script src="../js/jquery-2.1.1.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDv0RLj_LBhRntn4AOCr4zHSYv0-F8gVeA&sensor=false"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery.plugins.js"></script>
<script src="../js/custom.js"></script>
<script src="../js/global.js"></script>
<script src="../js/member.js"></script>

</body>
</html>