<?php
include "../util/config.php";
include "../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

if (!$_COOKIE[p_sid]) {
    $SID = md5(uniqid(rand()));
    SetCookie("p_sid", $SID, 0, "/");
}

$info_query = "SELECT * FROM admin_setup";
$info_res   = mysqli_query($connect, $info_query);
$info       = mysqli_fetch_array($info_res);

?>

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
        <div class="bg bg-shop" data-stellar-background-ratio="0.5"></div>
        <div class="container vmiddle">
            <div class="row text-center">
                <div class="icon-big color icon-caddie-shopping-streamline"></div>
                <h1>Checkout</h1>
            </div>
        </div>
    </div>
    <!-- /.home -->

    <!-- CONTENT -->
    <div class="content">

        <!-- CONTAINER: cart -->
        <div class="container cart">

            <form name="purchase" method="post" action="https://<?=$_SERVER['SERVER_NAME'];?>:<?=$port;?>/shop/checkout-ok.php">

            <!-- row -->
            <div class="row border-bottom">
                <div class="col-sm-3">
                    <h3 class="normal">배송 방법 :</h3>
                </div>
                <div class="col-sm-9">
                    <input type="radio" name="delivery_type" value="L"  checked="checked">택 배
                </div>
            </div>
            <!-- /.row -->

            <?php
//주문자 정보
if ($_SESSION['p_id']) {
    $m_qry = "SELECT * FROM member WHERE id='$_SESSION[p_id]' ";
    $m_res = mysqli_query($connect, $m_qry);
    $row   = mysqli_fetch_array($m_res);

    $company_name = $row['company_name'];
    $d_zipcode    = $row['d_zipcode'];
    $d_phone      = $row['d_phone'];
    $md_name      = $row['md_name'];
    $md_hphone    = $row['md_hphone'];
    $d_addr1      = $row['d_addr1'];
    $d_addr2      = $row['d_addr2'];
    //$md_email = $row['md_email'];
}
?>

            <!-- row -->
            <div class="row padding-bottom">
                <div class="col-sm-6">
                    <h3 class="normal">기본 배송지 주소</h3>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td colspan="2"><?=$md_name;?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><?=$company_name;?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><?=$d_zipcode;?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><?=$d_addr1;?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><?=$d_addr2;?></td>
                                    </tr>
                                    <tr>
                                        <td><i class="fa fa-mobile"></i> <?=$md_hphone;?></td>
                                        <td><i class="fa fa-phone"></i> <?=$d_phone;?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                </div>
                <div class="col-sm-6">
                    <label class="h3 normal" data-toggle="collapse" data-target="#shipto">
                            다른 주소로 배송?
                        <input type="checkbox" name="optionsCheckbox2" id="optionsChackbox2" value="option1">
                    </label>
                    <div id="shipto" class="collapse">
                        <div class="formwrap">
                            <div class="form-group">
                                <input type="text" name="recipient_name" placeholder="수령인 또는 회사명" value="">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="button" class="btn btn-primary btn-sm" onclick="openDaumPostcode()" value="우편번호 찾기">
                                    </div>
                                    <div class="col-md-4">
                                        <input name="recipient_zipcode01" id="recipient_zipcode01" type="text" readonly="readonly" value="">
                                    </div>
                                    <div class="col-md-4">
                                        <input name="recipient_zipcode02" id="recipient_zipcode02" type="text" readonly="readonly" value="">
                                    </div>
                                </div>

                                <script src="http://dmaps.daum.net/map_js_init/postcode.js"></script>
                                <script>
                                    function openDaumPostcode() {
                                        new daum.Postcode({
                                            oncomplete: function(data) {
                                                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
                                                // 우편번호와 주소 정보를 해당 필드에 넣고, 커서를 상세주소 필드로 이동한다.
                                                document.getElementById('recipient_zipcode01').value = data.postcode1;
                                                document.getElementById('recipient_zipcode02').value = data.postcode2;
                                                // document.getElementById('recipient_address01').value = data.address;

                                                //전체 주소에서 연결 번지 및 ()로 묶여 있는 부가정보를 제거하고자 할 경우,
                                                //아래와 같은 정규식을 사용해도 된다. 정규식은 개발자의 목적에 맞게 수정해서 사용 가능하다.
                                                var addr = data.address.replace(/(\s|^)\(.+\)$|\S+~\S+/g, '');
                                                document.getElementById('recipient_address01').value = addr;

                                                document.getElementById('recipient_address02').focus();
                                            }
                                        }).open();
                                    }
                                </script>
                            </div>
                            <div class="form-group">
                                <input name="recipient_address01" id="recipient_address01" value="" type="text" readonly="readonly" placeholder="주소 (자동입력)">
                            </div>
                            <div class="form-group">
                                <input name="recipient_address02" id="recipient_address02" value="" type="text" placeholder="나머지 주소">
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" placeholder="휴대폰 (- 삽입)" value="">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" placeholder="일반전화 (- 삽입)" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->

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
                    </tr>
                    </thead>
                    <tbody>

                       <?php
if ($from == "detail") {
    $query    = " SELECT * FROM products p, products_cart c WHERE user_id='$_SESSION[p_id]' AND p.num=c.product_fk ORDER BY p.category_l ASC, num DESC LIMIT 0,1";
    $cur_page = "checkout.php?from=detail"; //배송비 결정을 위함
} else if ($from == "basket") {
    $query    = "SELECT * FROM products p, products_cart c WHERE user_id='$_SESSION[p_id]' AND p.num=c.product_fk ORDER BY p.category_l ASC, num DESC";
    $cur_page = "checkout.php?from=basket";
}

$result = mysqli_query($connect, $query);

$num_tot = mysqli_num_rows($result);

$tot_money = 0;
// $sub_point = 0;

//volume = 카트에 담긴 수량, amount = 카트에 담긴 가격
for ($i = 0; $rows = mysqli_fetch_array($result); $i++) {
    $s_tot = (int) $rows['volume'] * (int) $rows['amount'];
    $stock = $rows['stock'] - $rows['volume'];

    ?>

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
                                    <?=$rows['volume'];?>
                                </div>
                            </td>
                            <td>
                                <div class="cost"><i class="fa fa-krw"></i> <?=number_format($s_tot * 1.1);?></div>
                            </td>
                        </tr>


                        <input type="hidden" name="products_fk[]"    value="<?=$rows['num'];?>">
                        <input type="hidden" name="products_name[]"  value="<?=$rows['name'];?>">
                        <input type="hidden" name="products_kind[]"  value="<?=$rows['p_opt'];?>">
                        <input type="hidden" name="products_count[]" value="<?=$rows['volume'];?>">
                        <input type="hidden" name="products_price[]" value="<?=$rows['amount'];?>">
                        <input type="hidden" name="products_stock[]" value="<?=$stock;?>">


                        <?php
$tot_money += $s_tot;
    // $sub_point = $sub_point + (int)$rows['mileage'];
} // end for loop

// 배송비 계산, (판매자 배송위탁판매, 직접수령, 퀵배송, 당사직송은 배송비 제외)
if ($row['seller'] == "3" || $delivery == "d" || $delivery == "q" || $row['option5_chk'] == "Y") {
    $trans_cost = 0;
    $last_cost  = $tot_money;
} else {
    $trans_cost = trans_cal($tot_money, $connect); //택배비 계산은 결제금액에서 제외
    //$last_cost = $tot_money + $trans_cost;
    $last_cost = $tot_money;
}

?>
                        <input type="hidden" name="seller"           value="<?=$rows['seller'];?>">
                        <input type="hidden" name="company_name"     value="<?=$company_name;?>">
                        <input type="hidden" name="buyer_name"       value="<?=$company_name;?>">
                        <input type="hidden" name="buyer_zipcode"    value="<?=$d_zipcode;?>">
                        <input type="hidden" name="buyer_address01"  value="<?=$d_addr1;?>">
                        <input type="hidden" name="buyer_address02"  value="<?=$d_addr2;?>">
                        <input type="hidden" name="buyer_phone"      value="<?=$d_phone;?>">
                        <input type="hidden" name="buyer_hphone"     value="<?=$md_hphone;?>">
                        <input type="hidden" name="sms"              value="<?=$rows['sms'];?>" />
                        <input type="hidden" name="trans_cost"       value="<?=$trans_cost;?>">
                        <input type="hidden" name="amount"           value="<?=$last_cost;?>">
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

            <!-- row -->
<!--             <div class="row border-bottom">
                <div class="panel-group" id="payment">
                    <div class="panel panel-default">
                        <div class="radio">
                            <label data-toggle="collapse" data-target="#payment-1" data-parent="#payment">
                                <input type="radio" name="pay_type" id="optionsRadios1" value="option1" checked>
                                무통장 입금
                            </label>
                        </div>
                        <div id="payment-1" class="collapse in payment col-md-7">
                            <p>입금은행 : <?=$info['bank'];?></p>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- /.row -->

            <!-- row -->
            <div class="row border-bottom">
                <div class="col-md-12">
                    <p>배송 시 요청사항을 남겨주세요
                    <textarea name="memo"></textarea>
                    </p>
                </div>
            </div>
            <!-- /.row -->

            <!-- row -->
            <div class="row">
                <div class="col-md-12 text-right">
                    <?php
if ($delivery == "l1" || $delivery == "q") {
    ?>
                    <button class="btn btn-default" href="" onclick="sendDOrder(document.purchase);">주문 완료하기</button>
                    <?php
} else {
    ?>
                      <button class="btn btn-default" href="" onclick="sendOrder(document.purchase);">주문 완료하기</button>
                    <?php
}
?>
                </div>
            </div>
            <!-- /.row -->
            </form>

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
<script src="../js/shopping.js"></script>

</body>
</html>

