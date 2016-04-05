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
                        <li><i class="fa fa-info-circle"></i> 각 배너별로 최근에 등록한 배너가 쇼핑몰에 표시됩니다.</li>
                        <li><i class="fa fa-info-circle"></i> 각 배너 사이즈 및 갯수를 확인하세요.</li>

                    </ul>
                </section>
            </div>
        </div>
        <!-- info end -->

        <!-- 메인배너 start -->
        <div class="row">
          <div class="col-sm-6">
            <section class="panel">
              <header class="panel-heading table-head">
                  <h4>메인 배너 등록 (1920 x 650px) * MAX 5</h4>
                </header>
                <div class="panel-body">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>번호</th>
                          <th>등록일</th>
                          <th>삭제</th>
                        </tr>
                      </thead>
                      <tbody>
<?php

$query  = "SELECT * FROM banner WHERE pos = 'main' ORDER BY num DESC";
$result = mysqli_query($connect, $query);

if ($result) {
    $total_count = mysqli_num_rows($result);

    for ($i = 0; $row = mysqli_fetch_array($result); $i++) {
        ?>
                        <tr>
                          <td><?php echo $row['num']; ?></td>
                          <td><?php echo $row['created']; ?></td>
                          <td>
                            <a class="btn btn-danger" type="button" href="banner_delete.php?pos=main&amp;num=<?php echo $row['num']; ?>" onclick="return confirm('정말 삭제하시겠습니까?')"><i class="fa fa-trash-o"></i></a></td>
                        </tr>
<?php

    } // end of for loop
    mysqli_free_result($result);

} else {
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
                        <a class="btn btn-success" href="banner_setting.php?pos=main">새 배너 등록하기</a>
                    </form>

                  </div>
                </div>
              </section>
            </div>
          <!-- </div> -->
          <!-- setup end -->

        <!-- 상단 배너 start -->
<!--         <div class="row margin-top-30"> -->
          <div class="col-sm-6">
            <section class="panel">
              <header class="panel-heading table-head">
                  <h4>상단 배너 등록 (370 x 243px) * 3</h4>
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

$tqry = "SELECT * FROM banner WHERE pos = 'top' ORDER BY num DESC";
$tres = mysqli_query($connect, $tqry);

if ($tres) {
    $t_count = mysqli_num_rows($tres);

    for ($i = 0; $trow = mysqli_fetch_array($tres); $i++) {
        ?>
                        <tr>
                          <td><?php echo $trow['num']; ?></td>
                          <td><?php echo $trow['created']; ?></td>
                          <td>
                            <a class="btn btn-danger" type="button" href="banner_delete.php?pos=top&amp;num=<?php echo $trow['num']; ?>" onclick="return confirm('정말 삭제하시겠습니까?')"><i class="fa fa-trash-o"></i></a></td>
                        </tr>
<?php

    } // end of for loop
    mysqli_free_result($tres);

} else {
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
                        <a class="btn btn-success" href="banner_setting.php?pos=top">새 배너 등록하기</a>
                    </form>

                  </div>
                </div>
              </section>
            </div>
          </div>
          <!-- setup end -->


        <!-- 중간 배너 start -->
        <div class="row margin-top-30">
          <div class="col-sm-6">
            <section class="panel">
              <header class="panel-heading table-head">
                  <h4>중간 배너 등록 (570 x 298px) * 2</h4>
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

$mqry = "SELECT * FROM banner WHERE pos = 'middle' ORDER BY num DESC";
$mres = mysqli_query($connect, $mqry);

if ($mres) {
    $m_count = mysqli_num_rows($mres);

    for ($i = 0; $mrow = mysqli_fetch_array($mres); $i++) {
        ?>
                        <tr>
                          <td><?php echo $mrow['num']; ?></td>
                          <td><?php echo $mrow['created']; ?></td>
                          <td>
                            <a class="btn btn-danger" type="button" href="banner_delete.php?pos=middle&amp;num=<?php echo $mrow['num']; ?>" onclick="return confirm('정말 삭제하시겠습니까?')"><i class="fa fa-trash-o"></i></a></td>
                        </tr>
<?php

    } // end of for loop
    mysqli_free_result($mres);

} else {
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
                        <a class="btn btn-success" href="banner_setting.php?pos=middle">새 배너 등록하기</a>
                    </form>

                  </div>
                </div>
              </section>
            </div>
          <!-- </div> -->
          <!-- setup end -->

        <!-- 하단 배너 start -->
        <!-- <div class="row margin-top-30"> -->
          <div class="col-sm-6">
            <section class="panel">
              <header class="panel-heading table-head">
                  <h4>하단 배너 등록 (1168 x 90px) * 1</h4>
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

$bqry = "SELECT * FROM banner WHERE pos = 'bottom' ORDER BY num DESC";
$bres = mysqli_query($connect, $bqry);

if ($bres) {
    $b_count = mysqli_num_rows($bres);

    for ($i = 0; $brow = mysqli_fetch_array($bres); $i++) {
        ?>
                        <tr>
                          <td><?php echo $brow['num']; ?></td>
                          <td><?php echo $brow['created']; ?></td>
                          <td>
                            <a class="btn btn-danger" type="button" href="banner_delete.php?pos=bottom&amp;num=<?php echo $brow['num']; ?>" onclick="return confirm('정말 삭제하시겠습니까?')"><i class="fa fa-trash-o"></i></a></td>
                        </tr>
<?php

    } // end of for loop
    mysqli_free_result($bres);

} else {
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
                        <a class="btn btn-success" href="banner_setting.php?pos=bottom">새 배너 등록하기</a>
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

