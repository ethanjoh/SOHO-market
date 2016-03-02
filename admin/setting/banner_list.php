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
        <!-- 메인배너 start -->
<?php

	$query       = "SELECT * FROM main_banner ORDER BY created DESC";
	$result      = mysqli_query($connect, $query);
	$total_count = mysqli_num_rows($result);
?>
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
                            <a class="btn btn-info" type="button" href="main_banner_setting.php?mode=update&num=<?php echo $row['num']; ?>" ><i class="fa fa-pencil-square-o"></i></a>
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

                    <form method="post" action="banner_list.php">
                        <a class="btn btn-success" href="banner_setting.php?mode=tins">새 배너 등록하기</a>
                    </form>

                  </div>
                </div>
              </section>
            </div>
          </div>
          <!-- setup end -->

        <!-- 상단 배너 start -->
<?php

	$tqry    = "SELECT * FROM top_banner ORDER BY created DESC";
	$tres    = mysqli_query($connect, $tqry);
	$t_count = mysqli_num_rows($tres);
?>
        <div class="row margin-top-30">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading table-head">
                  <h4>상단 배너 관리</h4>
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

	for ($i = 0; $mrow = mysqli_fetch_array($tres); $i++) {
    ?>
                        <tr>
                          <td><?php echo ($i + 1); ?></td>
                          <td><?php echo $mrow['created']; ?></td>
                          <td>
                            <a class="btn btn-info" type="button" href="top_banner_setting.php?mode=update&num=<?php echo $mrow['num']; ?>" ><i class="fa fa-pencil-square-o"></i></a>
                            <a class="btn btn-danger" type="button" href="banner_delete.php?num=<?php echo $mrow['num']; ?>" onclick="return confirm('정말 삭제하시겠습니까?')"><i class="fa fa-trash-o"></i></a></td>
                        </tr>
<?php

	} // end of for loop
	mysqli_free_result($tres);

	if ($t_count == 0) {
    ?>
                        <tr class="text-center">
                          <td colspan="6">등록된 배너가 없습니다.</td>
                        </tr>
<?php

	}
?>
                      </tbody>
                    </table>

                    <form method="post" action="banner_list.php">
                        <a class="btn btn-success" href="top_banner_setting.php">새 배너 등록하기</a>
                    </form>

                  </div>
                </div>
              </section>
            </div>
          </div>
          <!-- setup end -->


        <!-- 중간 배너 start -->
<?php

	$mqry    = "SELECT * FROM middle_banner ORDER BY created DESC";
	$mres    = mysqli_query($connect, $mqry);
	$m_count = mysqli_num_rows($mres);
?>
        <div class="row margin-top-30">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading table-head">
                  <h4>중간 배너 관리</h4>
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

	for ($i = 0; $mrow = mysqli_fetch_array($mres); $i++) {
    ?>
                        <tr>
                          <td><?php echo ($i + 1); ?></td>
                          <td><?php echo $mrow['created']; ?></td>
                          <td>
                            <a class="btn btn-info" type="button" href="middle_banner_setting.php?mode=update&num=<?php echo $mrow['num']; ?>" ><i class="fa fa-pencil-square-o"></i></a>
                            <a class="btn btn-danger" type="button" href="banner_delete.php?num=<?php echo $mrow['num']; ?>" onclick="return confirm('정말 삭제하시겠습니까?')"><i class="fa fa-trash-o"></i></a></td>
                        </tr>
<?php

	} // end of for loop
	mysqli_free_result($mres);

	if ($m_count == 0) {
    ?>
                        <tr class="text-center">
                          <td colspan="6">등록된 배너가 없습니다.</td>
                        </tr>
<?php

	}
?>
                      </tbody>
                    </table>

                    <form method="post" action="banner_list.php">
                        <a class="btn btn-success" href="middle_banner_setting.php">새 배너 등록하기</a>
                    </form>

                  </div>
                </div>
              </section>
            </div>
          </div>
          <!-- setup end -->

        <!-- 하단 배너 start -->
<?php

	$bqry    = "SELECT * FROM bottom_banner ORDER BY created DESC";
	$bres    = mysqli_query($connect, $bqry);
	$b_count = mysqli_num_rows($bres);
?>

        <div class="row margin-top-30">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading table-head">
                  <h4>하단 배너 관리</h4>
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

	for ($i = 0; $brow = mysqli_fetch_array($bres); $i++) {
    ?>
                        <tr>
                          <td><?php echo ($i + 1); ?></td>
                          <td><?php echo $brow['created']; ?></td>
                          <td>
                            <a class="btn btn-info" type="button" href="bottom_banner_setting.php?mode=update&num=<?php echo $brow['num']; ?>" ><i class="fa fa-pencil-square-o"></i></a>
                            <a class="btn btn-danger" type="button" href="banner_delete.php?num=<?php echo $brow['num']; ?>" onclick="return confirm('정말 삭제하시겠습니까?')"><i class="fa fa-trash-o"></i></a></td>
                        </tr>
<?php

	} // end of for loop
	mysqli_free_result($bres);

	if ($b_count == 0) {
    ?>
                        <tr class="text-center">
                          <td colspan="6">등록된 배너가 없습니다.</td>
                        </tr>
<?php

	}
?>
                      </tbody>
                    </table>

                    <form method="post" action="banner_list.php">
                        <a class="btn btn-success" href="bottom_banner_setting.php">새 배너 등록하기</a>
                    </form>

                  </div>
                </div>
              </section>
            </div>
          </div>
          <!-- setup end -->

          </section>
      </section>
      <!--main content end-->

      <!--footer start-->
    <?php include_once "../include/admin_footer.php";?>
      <!--footer end-->

  </body>
</html>

