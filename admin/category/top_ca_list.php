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

            <?php
// 상위카테고리 코드값으로 부터 현 카테고리 값을 구함
$query       = "SELECT * FROM products_category1 ORDER BY code";
$result      = mysqli_query($connect, $query);
$total_count = mysqli_num_rows($result);
?>

            <!-- info start-->
            <div class="row">
              <div class="col-sm-12">
                <section class="panel">
                  <header class="panel-heading">
                    사용방법
                  </header>
                  <ul class="info-body">
                    <li><i class="fa fa-info-circle"></i> 하단의 카테고리 등록하기를 통해 등록하세요.</li>
                    <li><i class="fa fa-info-circle"></i> 카테고리 등록 후 중분류 등록은 해당 카테고리명을 클릭하세요.</li>
                    <li><i class="fa fa-info-circle"></i> 등록 후에도 수정이 가능합니다.</li>
                    <li><i class="fa fa-info-circle"></i> 메인메뉴에서 감추려면 '숨김'을 누르세요.</li>
                    <li><i class="fa fa-info-circle"></i> <i class="fa fa-external-link"></i>를 클릭하면 새 창에서 해당 카테고리가 열립니다.</li>
                  </ul>
                </section>
              </div>
            </div>
            <!-- info end -->

            <!-- category list start -->
            <div class="row">
              <div class="col-sm-12">
                <section class="panel">
                  <header class="panel-heading table-head">
                      카테고리 목록 (총 <?php echo $total_count; ?> 개)
                  </header>
                  <div class="panel-body">

                    <form method="post" name="register" action="top_ca_list.php">
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>코드</th>
                            <th>카테고리명</th>
                            <th>하위 중분류 수</th>
                            <th>등록 상품수</th>
                            <th>숨기기</th>
                            <th>관리</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
for ($i = 0; $row = mysqli_fetch_array($result); $i++) {

    $query     = "SELECT * FROM products_category2 WHERE up_category='$row[code]'";
    $result2   = mysqli_query($connect, $query);
    $sub_count = mysqli_num_rows($result2);
    mysqli_free_result($result2);

    $query1         = "SELECT * FROM products WHERE category_l='$row[code]'";
    $result3        = mysqli_query($connect, $query1);
    $products_count = mysqli_num_rows($result3);
    mysqli_free_result($result3);

    ?>
                          <tr>
                            <td><?php echo $i + 1; ?></td>
                            <td><a href="ca_msub_list.php?lcode=<?php echo $row['code']; ?>"><?php echo $row['name']; ?></a>
                              <a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/shop/catalog-list.php?lcode=<?php echo $row['code']; ?>" target="_blank"><i class="fa fa-external-link"></i></a>
                            </td>
                            <td><?php echo $sub_count; ?></td>
                            <td><?php echo $products_count; ?> 개</td>
                            <td>
                              <?php
if ($row['hide'] == "Y") {
        echo "<a type=\"button\" class=\"btn btn-round btn-success\" href='ca_hide.php?code=" . $row['code'] . "&amp;chk=Y'><i class=\"fa fa-times\"></i> ON</a>";
    } else {
        echo "<a type=\"button\" class=\"btn btn-round btn-default\" href='ca_hide.php?code=" . $row['code'] . "&amp;chk=N'><i class=\"fa fa-check\"></i> OFF</a>";
    }
    ?>
                            </td>
                            <td>
                              <a type="button" class="btn btn-default" href="ca_register.php?mode=update&amp;num=<?php echo $row['num']; ?>" ><i class="fa fa-pencil-square-o"></i></a>
                              <a type="button" class="btn btn-danger" href="ca_delete.php?num=<?php echo $row['num']; ?>" onclick="return confirm('정말 삭제하시겠습니까?')"><i class="fa fa-trash-o"></i></a>
                            </td>
                          </tr>
                              <?php
} // end of for loop

mysqli_free_result($result);

if ($total_count == 0) {
    ?>
                          <tr>
                            <td colspan="5" class="text-center"><p>등록된 카테고리가 없습니다.</p></td>
                          </tr>
                  <?php
}
?>
                        </tbody>
                      </table>
                      </div>
                    </form>
                  </div>
                </section>
              </div>
            </div>
            <!-- category list end -->

            <!-- buttons start -->
            <div class="row text-center">
              <div class="col-sm-12">
                <a type="button" class="btn btn-success" href="ca_register.php">카테고리 등록하기</a>
              </div>
            </div>
            <!-- buttons end -->

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
    <script src="/admin/js/jquery.customSelect.min.js" ></script>
    <script src="/admin/js/respond.min.js" ></script>

    <!--common script for all pages-->
    <script src="/admin/js/common-scripts.js"></script>

    <!-- custom scripts -->
    <script src="/js/global.js" ></script>
    <script src="/admin/js/admin.js" ></script>

    <script>
        //custom select box
        $(function(){
            $('select.styled').customSelect();
        });

    </script>

  </body>
</html>
