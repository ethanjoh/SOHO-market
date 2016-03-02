<?php include_once '../include/header.php';?>

  <body>
    <section id="container" >
        <!--header start-->
        <?php include_once "../include/admin_head.php";?>
        <!--header end-->

        <!--sidebar start-->
        <?php include_once "../include/admin_sidebar.php";?>
        <!--sidebar end-->


        <!--main content start-->
        <section id="main-content">
          <section class="wrapper">

            <!-- info start-->
            <div class="row">
              <div class="col-sm-12">
                <section class="panel">
                  <header class="panel-heading">
                    사용방법
                  </header>
                  <ul class="info-body">
                    <li><i class="fa fa-info-circle"></i> 발주할 상품을 확인하고 수량입력 후 저장을 클릭합니다.</li>
                    <li><i class="fa fa-info-circle"></i> 하단의 [발주 보관함 보기]에서 발주상품을 확인할 수 있습니다.</li>
                    <li><i class="fa fa-info-circle"></i> 발주서 작성이 끝나면 발주목록으로 돌아가 해당 발주내역 하단에서 발주서를 출력할 수 있습니다.</li>
                  </ul>
                </section>
              </div>
            </div>
            <!-- info end -->

<?php

$sql    = "SELECT * FROM products WHERE id='$id' AND del_chk<>'C' AND del_chk<>'Y' ORDER BY num DESC";
$result = mysqli_query($connect, $sql);
$total  = mysqli_num_rows($result);

//공급업체 정보, 수수료 가져오기
$sql1    = "SELECT * FROM supplier WHERE id='$id' ";
$result1 = mysqli_query($connect, $sql1);
$rows2   = mysqli_fetch_array($result1);
?>

            <!-- offer list start -->
            <div class="row">
              <div class="col-sm-12">
                <section class="panel">
                  <header class="panel-heading table-head">
                      [ <?php echo $rows2['company_name']; ?> ] 발주서 작성
                      <p>(입고가란에는 변경할 경우에만 입력하세요.)</p>
                  </header>
                  <div class="panel-body">
                  <div class="table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th colspan="2">상품명</th>
                        <th>옵션</th>
                        <th>소비자가</th>
                        <th>입고가</th>
                        <th>입고가 수정</th>
                        <th>수량</th>
                        <th>저장</th>
                      </tr>
                    </thead>
                    <tbody>
<?php

if ($total == 0) {
    echo "<tr>\n";
    echo "  <td colspan=\"8\"><p>등록된 상품 내역이 없습니다.</p></td>\n";
    echo "</tr>\n";
} else {
    for ($i = 0; $pro_row = mysqli_fetch_array($result); $i++) {
        ?>
                      <!-- <form action="update_cart.php" name="form" method="post" target="nw" onSubmit="window.open('', 'nw', 'width=500,height=500')"> -->
                      <form action="" name="form_<?php echo $pro_row['num']; ?>" method="post" >

                        <input type="hidden" name="id" id="userid_<?php echo $pro_row['num']; ?>" value="<?php echo $id; ?>" />
                        <input type="hidden" name="pnum" id="pnum_<?php echo $pro_row['num']; ?>" value="<?php echo $pro_row['num']; ?>" />
                        <tr>
                          <td><img src="<?php echo $pro_row['s_image_name']; ?>" alt="image" width="50" height="50" /></td>
                          <td class="left"><?php echo show_icon($pro_row); ?> <a href="#" onclick="javascript:open_win('edit_pro.php?id=<?php echo $id; ?>&amp;p_num=<?php echo $pro_row['num']; ?>&amp;lcode=<?php echo $pro_row['category_l']; ?>&amp;mcode=<?php echo $pro_row['category_m']; ?>&amp;scode=<?php echo $pro_row['category_s']; ?>&amp;from=pre_offer','nwin','scrollbars=yes,resizable=yes, width=900,height=650');"><?php echo stripslashes($pro_row['name']); ?></a></td>
                          <td>
<?php

        if ($pro_row['opt']) {
            show_option($pro_row);
        } else {
            $selected_opt = "|" . $pro_row['barcode'];
            echo "<input type=\"hidden\" name=\"selected_opt\" value=\"$selected_opt\" id=\"selected_opt_" . $pro_row['num'] . "\">\n";
        }

        ?>
                          <td><?php echo number_format($pro_row['retail_price']); ?></td>
                          <td><?php echo number_format((1 - ($rows2['margin'] / 100)) * $pro_row['retail_price']); ?><?php echo $rows2['tax'] == "I" ? "(VAT 포함)" : "(VAT 별도)"; ?></td>
                          <td><input type="text" class="form-control" name="offer_price" id="offer_price_<?php echo $pro_row['num']; ?>" value="<?php echo (1 - ($rows2['margin'] / 100)) * $pro_row['retail_price']; ?>"  size="8"/><?php echo $rows2['tax'] == "I" ? "(VAT 포함)" : "(VAT 별도)"; ?></td>
                          <td><input type="text" class="form-control" name="count" id="count_<?php echo $pro_row['num']; ?>" size="5" value="" /></td>
                          <td>
                            <!-- <input type="submit" name="submit" value="저장" /> -->
                            <a type="button" class="btn btn-info addCart_submit" name="submit" id="<?php echo $pro_row['num']; ?>" onclick="form_<?php echo $pro_row['num']; ?>.submit();" /><i class="fa fa-floppy-o"></i></a>
                            <div id="loadplace<?php echo $pro_row['num']; ?>"></div>

                          </td>
                        </tr>
                      </form>
<?php

    } // for end
}
; // else end
?>
                      </tbody>
                    </table>
                    </div>
                  </div>
                </section>
              </div>
            </div>
            <!-- offer list end -->

            <!-- function buttons start -->
            <div class="row text-center">
              <div class="col-sm-12">
<?php

//장바구니에 담긴 수량 확인
$query  = "SELECT sum(volume) AS cnt FROM products p, offer_cart c WHERE c.user_id='$id' AND p.num=c.product_code ORDER BY c.cart_id DESC ";
$result = mysqli_query($connect, $query);
$row    = mysqli_fetch_array($result);

if ($row['cnt'] > 0) {
    ?>
                <a type="button" class="btn btn-info" href="" onclick="open_win('view_cart.php?id=<?php echo $id; ?>','win','width=900,height=600,scrollbars=yes,status=no');">발주 보관함 보기 <span class="badge" id="cartInfo"><?php echo $row['cnt']; ?></span></a>
<?php

} else {
    ?>
                <a type="button" class="btn btn-info" href="" onclick="open_win('view_cart.php?id=<?php echo $id; ?>','win','width=900,height=600,scrollbars=yes,status=no');">발주 보관함 보기 <span class="badge" id="cartInfo">0</span></a>
<?php

}
?>
                <a type="button" class="btn btn-default" href="offer_list.php">취소</a>

              </div>
            </div>
            <!-- function buttons end -->

        </section>
    </section>
    <!--main content end-->

    <!--footer start-->
    <?php include_once '../include/admin_footer.php';?>
      <!--footer end-->

    <script type="text/javascript" >
      $(document).ready(function() {
        $(".addCart_submit").click(function(){
          var element = $(this);
          var Id = element.attr("id");
          // var opt = "#selected_opt_"+Id;
          var qty = $("#count_"+Id).val();

          if(qty=='') {
            alert("주문수량을 넣어주세요.");
          } else {

              $.ajax({
                type : "POST",
                url  : "update_cart.php",
                data : {
                  pnum           : Id,
                  count          : qty,
                  id             : $("#userid_"+Id).val(),
                  selected_opt   : $("#selected_opt_"+Id).val(),
                  offer_price    : $("#offer_price_"+Id).val()
                },
                dataType: 'json',
                cache: false,
                success: function(data){
                  $("#loadplace"+Id).html(data.msg);
                  $("#cartInfo").html(data.qty);
                }
              });

          }return false;
        });
      });
    </script>

  </body>
</html>
