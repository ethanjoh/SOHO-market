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

        <!-- info start -->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading">
                사용방법
              </header>
              <ul class="info-body">
                <li><i class="fa fa-info-circle"></i> 각 정책 등은 예제를 참고해서 작성하시기 바랍니다.</li>
                <li><i class="fa fa-info-circle"></i> 무료배송 금액, 배송비 등을 입력할 때는 , 없이 입럭하세요.</li>
              </ul>
            </section>
          </div>
        </div>
        <!-- info end -->


          <?php

$qry   = "SELECT * FROM misc_setup ";
$res   = mysqli_query($connect, $qry);
$total = mysqli_num_rows($res);

if ($total > 0) {
    $mode = "update";
    $rows = mysqli_fetch_array($res);
} else {
    $mode = "insert";
}
?>
        <!-- setup start -->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading table-head">
                  <h4>배송정보 설정</h4>
                </header>
                <div class="panel-body">
                  <form class="form-group" role="form" name="form1" action="delivery_setup_ok.php" method="post">
                  <input type="hidden" name="admin_id" value="<?php echo $_COOKIE['ROOT_ID']; ?>" />
                  <input type="hidden" name="mode" value="<?php echo $mode; ?>">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <tbody>
                        <tr>
                          <th>배송업체</th>
                          <td width="15%"><input type="text" class="form-control" name="logistics" id="logistics" value="<?php echo $rows['logistics']; ?>"/></td>
                          <th>무료배송 금액</th>
                          <td><input type="text" class="form-control" name="min_sum" id="min_sum" value="<?php echo $rows['min_sum']; ?>"/> 원 이상 무료배송</td>
                          <th>배송료</th>
                          <td width="15%"><input type="text" class="form-control" name="delivery_charge" id="delivery_charge" size="5"  value="<?php echo $rows['d_charge']; ?>"/></td>
                        </tr>
                        <tr>
                          <th>배송정책 설정</th>
                          <td colspan="5">
                            <textarea class="form-control" name="delivery_policy" rows="8" cols="100"><?php echo $rows['d_policy']; ?></textarea>
                            <p class="help-block">
                              - 총 구매액 10만원이상 구매시 배송비는 무료이며, 그 이하 구매시 배송비 2,500원이 별도 부과됩니다. <br />
                              - 결제확인 후 상품발송이 이뤄집니다.<br />
                              - 배송기간은 결제완료일로부터 최소 1일 ~ 최장 5일 정도 소요됩니다.(토요일/공휴일 제외)<br />
                              - 도서, 산간 지방의 경우 배송정책과 관계없이 도선료 등이 추가로 부과될 수 있습니다.<br /></p>
                          </td>
                        </tr>
                        <tr>
                          <th>환불/반품정책 설정</th>
                          <td colspan="5">
                            <textarea class="form-control" name="refund_policy" rows="8" cols="100"><?php echo $rows['r_policy']; ?></textarea>
                            <p class="help-block">
                              - 배송 시 파손 등은 수령일로부터 7일 이내에 접수와 상품이 확인이 되어야, 교환/반품/환불이 가능합니다. <br />
                              - 판매자가 판매 후 소비자 과실에 의한 파손 또는 불량은 반품사유가 되지 않습니다.<br />
                              - 사입 후 미판매 재고 등에 대한 환불 등은 해드리지 않으니 양해하시기 바랍니다. <br /></p>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </section>
            </div>
          </div>
          <!-- setup end -->

            <div class="row text-center">
              <div class="col-sm-12">
                <button class="btn btn-success" onClick="document.form1.submit();">저장</button>
                <a class="btn btn-default" href="../main/main.php">취소</a>
              </div>
            </div>
            </form>


           </section>
      </section>
      <!--main content end-->

      <!--footer start-->
    <?php include_once "../include/admin_footer.php";?>
      <!--footer end-->

  </body>
</html>

