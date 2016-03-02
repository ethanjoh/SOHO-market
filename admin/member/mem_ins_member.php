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

$num = set_var($_GET['num']);
?>

            <!-- search start-->
            <div class="row">
              <div class="col-sm-12">
                <section class="panel">
                  <header class="panel-heading table-head">
                      회원등록
                  </header>
                  <div class="panel-body">

                  <!-- <form name='primary' method='post' action='https://www.<?php echo $_SERVER['SERVER_NAME']; ?>:<?php echo $port; ?>/admin/member/mem_ins_ok.php'> -->
                  <form class="form-horizontal" role="form" name="primary" method="post" action="http://<?php echo $_SERVER['SERVER_NAME']; ?>/admin/member/mem_ins_ok.php">
                    <input type="hidden" name="num" value="<?php echo $num; ?>">
                    <div class="form-group">
                        <label for="id" class="col-lg-2 col-sm-2 control-label">아이디 :</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="id" id="id">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="company_name" class="col-lg-2 col-sm-2 control-label">비밀번호 :</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="passwd" id="passwd">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="company_name" class="col-lg-2 col-sm-2 control-label">거래형태 :</label>
                        <div class="col-sm-4">
                          <label class="checkbox-inline">
                            <input type="radio" name="seller" value="1" checked > 사입
                            <input type="radio" name="seller" value="2"> 당사배송 위탁거래
                            <input type="radio" name="seller" value="3"> 판매자배송 위탁거래
                          </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="company_name" class="col-lg-2 col-sm-2 control-label">기본할인율(VAT 포함) :</label>
                        <div class="col-sm-4 form-inline">
                            <input type="text" class="form-control" name="dc_rate" size="3"/> % DC
                            <label class="checkbox-inline">
                              <input type="radio" name="tax" value="E" checked > (VAT 별도)
                              <input type="radio" name="tax" value="I"> (VAT 포함)
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="company_name" class="col-lg-2 col-sm-2 control-label">사업자등록번호 :</label>
                        <div class="col-sm-4">
                          <label class="form-inline">
                            <input type="text" class="form-control" name="license_no1" size="3" maxlength="3"> -
                            <input type="text" class="form-control" name="license_no2" size="2" maxlength="2"> -
                            <input type="text" class="form-control" name="license_no3" size="5" maxlength="5">
                          </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="company_name" class="col-lg-2 col-sm-2 control-label">업체명 :</label>
                        <div class="col-sm-4">
                            <input class="form-control" type="text" name="company_name" id="company_name" size="15" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-12 text-center">
                          <button class="btn btn-success" onclick="javascript:document.primary.submit()">추가하기</button>
                          <button class="btn btn-default" onclick="javascript:document.primary.reset()">취소</button>
                        </div>
                    </div>
                  </form>
              </section>
            </div>
          </div>

       </section>
    </section>
    <!--main content end-->

     <!--footer start-->
    <?php include_once "../include/admin_footer.php";?>
      <!--footer end-->

  </body>
</html>
