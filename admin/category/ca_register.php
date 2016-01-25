<?php include_once '../include/header.php';?>

  <body>
    <section id="container" >
        <!--header start-->
        <?php include "../include/admin_head.php";?>
        <!--header end-->

        <!--sidebar start-->
        <?php include "../include/admin_sidebar.php";?>
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
                    <li><i class="fa fa-info-circle"></i> 해당 카테고리의 공급업체를 먼저 등록하신 후 카테고리를 등록해야 합니다.</li>
                    <li><i class="fa fa-info-circle"></i> 카테고리 입력 후 공급업체를 조회하여 선택하십시오.</li>
                  </ul>
                </section>
              </div>
            </div>
            <!-- info end -->


            <?php
if ($mode == "update") {
    $query  = "SELECT * FROM products_category1 WHERE num='$num'";
    $result = mysqli_query($connect, $query);
    $row    = mysqli_fetch_array($result);
} else {
    $mode   = "insert";
    $query  = "SELECT max(code) AS max_code FROM products_category1";
    $result = mysqli_query($connect, $query);
    $row    = mysqli_fetch_array($result);

    if ($row['max_code']) {
        $max_code = $row['max_code'] + 1;
    } else {
        $max_code = "1";
    }

}
?>

            <!-- category register start -->
            <div class="row">
              <div class="col-sm-12">
                <section class="panel">
                  <header class="panel-heading table-head">
                      카테고리 등록
                  </header>
                  <div class="panel-body">

                    <form name="f" method="post" action="ca_insert.php" class="form-horizontal" role="form">
                      <input type="hidden" name="mode" value="<?=$mode;?>">
                      <input type="hidden" name="num" value="<?=$num;?>">

                      <div class="form-group">
                          <label for="ca_name" class="col-lg-2 col-sm-2 control-label">카테고리명 :</label>
                          <div class="col-sm-3">
                            <input type="text" class="form-control" name="ca_name" value="<?=$row['name'];?>" size="20" maxlength="20" />
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="code" class="col-lg-2 col-sm-2 control-label">공급업체 선택 :</label>
                          <div class="col-sm-3">
                            <select name="id" id="id" class="form-control" onchange="sel();">
                              <option>업체명</option>
                          <?php
$mqry = "SELECT * FROM supplier ORDER BY company_name ";
$mres = mysqli_query($connect, $mqry);

for ($i = 0; $mrow = mysqli_fetch_array($mres); $i++) {
    echo "<option value=\"" . $mrow['id'] . "\">" . $mrow['company_name'] . "</option>\n";
}

?>
                              </select>
                              <input type="text" class="form-control" name="val" value="<?=$mrow['id'];?>" readonly />
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="code" class="col-lg-2 col-sm-2 control-label">카테고리 코드 :</label>
                          <div class="col-sm-3">
                              <input type="text" class="form-control" name="code" value="<?=($mode == "insert") ? $max_code : $row['code'];?>" readonly />
                              <p class="help-block">*자동입력(수정불가)</p>
                          </div>
                      </div>

                    </form>
                  </div>
                </section>
              </div>
            </div>
            <!-- category register end -->

            <div class="form-group row">
                <div class="col-sm-12 text-center">
                    <a type="button" class="btn btn-success" href="#" onclick="javascript:form_send();">등록</a>
                    <a type="button" class="btn btn-default" href="#" onclick="history.back(-1)">취소</a>
                </div>
            </div>

          </section>
      </section>
      <!--main content end-->

       <!--footer start-->
    <?php include "../include/admin_footer.php";?>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="/js/vendor/jquery-2.2.0.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="/admin/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="/admin/js/jquery.scrollTo.min.js"></script>
    <script src="/admin/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="/admin/js/jquery.sparkline.js" type="text/javascript"></script>
    <!-- // <script src="jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script> -->
    <script src="/admin/js/owl.carousel.js" ></script>
    <script src="/admin/js/jquery.customSelect.min.js" ></script>
    <script src="/admin/js/respond.min.js" ></script>

    <!--right slidebar-->
    <script src="/admin/js/slidebars.min.js"></script>

    <!--common script for all pages-->
    <script src="/admin/js/common-scripts.js"></script>

    <!--script for this page-->
    <script src="/admin/js/sparkline-chart.js"></script>
    <!-- // <script src="js/easy-pie-chart.js"></script> -->
    <script src="/admin/js/count.js"></script>

    <!-- custom scripts -->
    <script src="/js/global.js" ></script>
    <script src="/admin/js/admin.js" ></script>

  </body>
</html>
