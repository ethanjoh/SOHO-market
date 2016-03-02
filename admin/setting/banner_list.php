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

// 상위카테고리 코드값으로 부터 현 카테고리 값을 구함
$query       = "SELECT * FROM banner ORDER BY created DESC";
$result      = mysqli_query($connect, $query);
$total_count = mysqli_num_rows($result);
?>

        <!-- setup start -->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading table-head">
                  <h4>메인 배너 관리</h4>
                </header>
                <div class="panel-body">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>번호</th>
                          <th>등록일</th>
                          <th>관리</th>
                        </tr>
                      </thead>
                      <tbody>
<?php

for ($i = 0; $row = mysqli_fetch_array($result); $i++) {

    ?>
                        <tr>
                          <td><?php echo ($i + 1); ?></td>
                          <td><?php echo $row['created']; ?></td>
                          <td>
                            <a class="btn btn-info" type="button" href="banner_setting.php?mode=update&num=<?php echo $row['num']; ?>" ><i class="fa fa-pencil-square-o"></i></a>
                            <a class="btn btn-danger" type="button" href="banner_delete.php?num=<?php echo $row['num']; ?>" onclick="return confirm('정말 삭제하시겠습니까?')"><i class="fa fa-trash-o"></i></a></td>
                        </tr>
<?php

} // end of for loop
mysqli_free_result($result);

if ($total_count == 0) {
    ?>
                        <tr class="text-center">
                          <td colspan="6">등록된 배너가 없습니다.</td>
                        </tr>
                      <?php
}
?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </section>
            </div>
          </div>
          <!-- setup end -->

          <form method="post" action="banner_list.php">
          <div class="row">
            <div class="col-sm-12">
              <a class="btn btn-success" href="banner_setting.php">새 배너 등록하기</a>
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

