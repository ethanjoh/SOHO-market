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
                    <li><i class="fa fa-info-circle"></i> 중분류명을 입력하시고 등록 버튼을 클릭하세요.</li>
                  </ul>
                </section>
              </div>
            </div>
            <!-- info end -->

<?php

$mode  = set_var($_GET['mode']);
$lcode = set_var($_GET['lcode']);
$id    = set_var($_GET['id']);

$sql     = "SELECT * FROM products_category1 WHERE code='$lcode' ";
$result1 = mysqli_query($connect, $sql);
$ca_m    = mysqli_fetch_array($result1);

if ($mode == "update") {
    $query         = "SELECT * FROM products_category2 WHERE id='$id'";
    $result        = mysqli_query($connect, $query);
    $row           = mysqli_fetch_array($result);
    $category_name = $row['name'];
    $code          = $row['code'];
} else {
    $mode   = "insert";
    $query  = "SELECT max(code) AS max_code FROM products_category2";
    $result = mysqli_query($connect, $query);
    $row    = mysqli_fetch_array($result);
    mysqli_free_result($result);

    if ($row['max_code']) {
        $max_code = $row['max_code'] + 1;
    } else {
        $max_code = "1";
    }

    $category_name = '';
    $code          = $max_code;
}
?>


            <!-- category register start -->
            <div class="row">
              <div class="col-sm-12">
                <section class="panel">
                  <header class="panel-heading table-head">
                      중분류 등록
                  </header>
                  <div class="panel-body">

                    <form name="form1" method="post" class="form-horizontal" action="ca_msub_insert.php">
                      <input type="hidden" name="mode" value="<?php echo $mode; ?>">
                      <input type="hidden" name="id" value="<?php echo $id; ?>">
                      <input type='hidden' name='lcode' value="<?php echo $lcode; ?>">

                      <div class="form-group">
                          <label for="up_category" class="col-lg-2 col-sm-2 control-label">상위분류:</label>
                          <div class="col-sm-3">
                            <input type="text" class="form-control" name="up_category" value="<?php echo $ca_m['name']; ?>" readonly />
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="code" class="col-lg-2 col-sm-2 control-label">코드:</label>
                          <div class="col-sm-3">
                            <input type="text" class="form-control" name="code" value="<?php echo $code; ?>" readonly />
                            <p class="help">*자동입력(변경불가)</p>
                          </div>
                      </div>

                      <div class="form-group">
                          <label for="ca_mname" class="col-lg-2 col-sm-2 control-label">중분류명:</label>
                          <div class="col-sm-3">
                            <input type="text" class="form-control" name="ca_mname" value="<?php echo $category_name; ?>" />
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
                    <a type="button" class="btn btn-success" href="#" onclick="javascript:mform_send();">등록</a>
                    <a type="button" class="btn btn-default" href="#" onclick="history.back(-1)">취소</a>
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
