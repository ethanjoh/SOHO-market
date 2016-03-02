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
          <?php
$sql    = "SELECT * FROM sms";
$result = mysqli_query($connect, $sql);
if ($result) {
    $row = mysqli_fetch_array($result);
}

$sql2    = "SELECT * FROM admin_setup";
$result2 = mysqli_query($connect, $sql2);
$row2    = mysqli_fetch_array($result2);
?>

            <!-- info start -->
            <div class="row">
              <div class="col-sm-12">
                <section class="panel">
                  <header class="panel-heading">
                    사용방법
                  </header>
                  <ul class="info-body">
                    <li><i class="fa fa-info-circle"></i> SMS 서비스를 이용하시려면 먼저 <a href="http://www.whoisweb.net/main/smsh.php?ch=smsh" target="_blank">후이즈 SMS호스팅</a>에 가입 후  이용요금을 결제해야 합니다.</li>
                    <li><i class="fa fa-info-circle"></i> 후이즈 SMS 호스팅에 가입하신 아이디와 비밀번호를 아래에 입력하세요.</li>
                    <li><i class="fa fa-info-circle"></i> SMS를 보내기 원하는 옵션의 체크박스에 체크 후 사용하세요.</li>
                    <li><i class="fa fa-info-circle"></i> 회원이 SMS 수신을 원했을 경우에만 발송이 됩니다.</li>
                    <li><i class="fa fa-info-circle"></i> SMS 발송 시에는 회사명이 자동으로 붙어 전송되니 별도로 입력하실 필요없습니다.</li>

                  </ul>
                </section>
              </div>
            </div>
            <!-- info end -->

            <!-- bbs list start -->

            <div class="row">
              <div class="col-sm-12">
                <section class="panel">
                  <header class="panel-heading table-head">
                      SMS 설정
                    </header>
                    <div class="panel-body">
                      <form class="form-group" role="form" name="sms" method="post" action="sms_ok.php">
                      <div class="table-responsive">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th class="text-center" colspan="4">사용 설정 (
                              <input type="radio" name="sms" value="Y" <?php if ($row['sms'] == "Y") {
    echo "checked=\"checked\"";
}
?>/> 사용함
                              <input type="radio" name="sms" value="N" <?php if ($row['sms'] == "N") {
    echo "checked=\"checked\"";
}
?> /> 사용 안함)
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <th>SMS 아이디:</th>
                            <td>
                              <div class="col-sm-6">
                                <input type="text" class="form-control" name="sms_id" value="<?php echo $row['id']; ?>" />
                              </div>
                            </td>
                            <th>SMS 비밀번호:</th>
                            <td>
                              <div class="col-sm-6">
                                <input type="text" class="form-control" name="sms_passwd" value="<?php echo $row['passwd']; ?>" />
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th>발신자 연락처:</th>
                            <td colspan="3">
                              <div class="col-sm-3">
                                <input type="text" class="form-control" name="from_phone" value="<?php echo $row['from_phone']; ?>" />
                                <p class="help-block">(예: 010-111-1234 또는 02-111-1234)</p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th>수신 연락처:</th>
                            <td colspan="3">
                              <div class="col-sm-3">
                                <input type="text" class="form-control" name="to_phone" size="13" value="<?php echo $row['to_phone']; ?>" />
                                <p class="help-block">(예: 010-111-1234 또는 02-111-1234)</p>(예: 010-111-1234) * 주문 접수 시에 사용됩니다.</p>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th>
                              <input type="checkbox" name="reg_chk" value="Y" <?php if ($row['reg_chk'] == "Y") {
    echo "checked=\"checked\"";
}
?> />회원승인
                            </th>
                            <td>
                              <textarea class="form-control" name="reg_msg" cols="25" rows="5"><?php echo $row['reg_msg']; ?></textarea>
                            </td>
                            <th>
                              <input type="checkbox" name="orderin_chk" value="Y" <?php if ($row['orderin_chk'] == "Y") {
    echo "checked=\"checked\"";
}
?> />주문접수
                            </th>
                            <td>
                              <textarea class="form-control" name="orderin_msg" cols="25" rows="5"><?php echo $row['orderin_msg']; ?></textarea>
                            </td>
                          </tr>
                          <tr>
                            <th>
                              <input type="checkbox" name="order_chk" value="Y" <?php if ($row['order_chk'] == "Y") {
    echo "checked=\"checked\"";
}
?> />구매완료
                            </th>
                            <td>
                              <textarea class="form-control" name="order_msg" cols="25" rows="5"><?php echo $row['order_msg']; ?></textarea>
                            </td>
                            <th>
                              <input type="checkbox" name="orderout_chk" value="Y" <?php if ($row['orderout_chk'] == "Y") {
    echo "checked=\"checked\"";
}
?> />상품발송
                            </th>
                            <td>
                              <textarea class="form-control" name="orderout_msg" cols="25" rows="5"><?php echo $row['orderout_msg']; ?></textarea>
                            </td>
                          </tr>
                          <tr>
                            <th>
                              <input type="checkbox" name="tax_chk" value="Y" <?php if ($row['tax_chk'] == "Y") {
    echo "checked=\"checked\"";
}
?> />세금계산서 발행
                            </th>
                            <td>
                              <textarea class="form-control" name="tax_msg" cols="25" rows="5"><?php echo $row['tax_msg']; ?></textarea>
                            </td>
                            <th>
                              <input type="checkbox" name="offer_chk" value="Y" <?php if ($row['offer_chk'] == "Y") {
    echo "checked=\"checked\"";
}
?> />발주서 발송
                            </th>
                            <td>
                              <textarea class="form-control" name="offer_msg" cols="25" rows="5"><?php echo $row['offer_msg']; ?></textarea>
                            </td>
                          </tr>
                        </tbody>
                      </table>

                      <div class="row text-center">
                        <div class="col-sm-12">
                          <button class="btn btn-success" onclick="javascript:document.sms.submit();">설정 저장</button>
                          <a class="btn btn-default" type="button" href="/admin/main.php">취소</a>
                        </div>
                      </div>

                    </div>
                </form>
              </div>
            </section>
          </div>
        </div>
        <!-- bbs list end -->

      <?php if ($row['sms'] == "Y") {?>
      <table summary="stats">
        <thead>
          <tr>
            <th>SMS 통계(<?php echo check_remain_sms($connect); ?>)</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?php echo sms_stats($connect); ?></td>
          </tr>
        </tbody>
      </table>
      <?php }
?>
         </section>
      </section>
      <!--main content end-->

      <!--footer start-->
    <?php include_once "../include/admin_footer.php";?>
      <!--footer end-->

  </body>
</html>
