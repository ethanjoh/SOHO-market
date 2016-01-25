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
$query       = "SELECT * FROM products_category2 WHERE up_category='$lcode' ";
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
                    <li><i class="fa fa-info-circle"></i> 하단의 중분류 등록하기를 통해 등록하세요.</li>
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
                      중분류 목록 (총 <?php echo ($total_count); ?>개)
                  </header>
                  <div class="panel-body">

                    <form method="post" action="ca_msub_list.php">
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>코드</th>
                            <th>중분류명</th>
                            <th>하위 소분류 수</th>
                            <th>등록된 상품수</th>
                            <th>관리</th>
                          </tr>
                        </thead>
                        <tbody>
            <?php
for ($i = 0; $row = mysqli_fetch_array($result); $i++) {
    $query1    = "SELECT * FROM products_category3 WHERE up_category='$row[code]'";
    $result1   = mysqli_query($connect, $query1);
    $sub_count = mysqli_num_rows($result1);
    mysqli_free_result($result1);

    $query          = "select * from products where category_m='$row[code]'";
    $result2        = mysqli_query($connect, $query);
    $products_count = mysqli_num_rows($result2);
    mysqli_free_result($result2);

    ?>
                          <tr>
                            <td><?php echo $row['code']; ?></td>
                            <td><a href="ca_ssub_list.php?lcode=<?php echo $lcode; ?>&amp;mcode=<?php echo $row['code']; ?>"><?php echo $row['name']; ?></a></td>
                            <td><?php echo $sub_count; ?></td>
                            <td><?php echo $products_count; ?></td>
                            <td><a href='ca_msub_register.php?mode=update&amp;id=<?php echo $row['id']; ?>&amp;lcode=<?php echo $row['up_category']; ?>'><img src="../images/edit.gif" alt="수정" /></a>&nbsp; <a href='ca_msub_delete.php?id=<?php echo $row['id']; ?>&amp;lcode=<?php echo $row['up_category']; ?>' onClick="return confirm('정말 삭제하시겠습니까?')"><img src="../images/delete.gif" alt="삭제" /></a> </td>
                          </tr>
          <?php
}
mysqli_free_result($result);

if ($total_count == 0) {
    ?>
                          <tr>
                            <td colspan="5" class="text-center"><p>등록된 중분류가 없습니다.</p></td>
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
                <a type="button" class="btn btn-success" href="ca_msub_register.php?lcode=<?php echo $lcode; ?>">중분류 등록하기</a>
                <a type="button" class="btn btn-default" href="top_ca_list.php">대분류로 가기</a>
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
