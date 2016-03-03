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

$mode = set_var($_GET['mode']);
$num  = set_var($_GET['num']);
$pos  = set_var($_GET['pos']);

if ("update" == $mode) {
    $qry = "SELECT * FROM banner WHERE pos='$pos' AND num='$num'";
    $res = mysqli_query($connect, $qry);
    $row = mysqli_fetch_array($res);
    // mysqli_free_result($result);
} else {
    $mode = "insert";
}

if ('main' == $pos) {
    $j     = 5;
    $title = '메인배너 업로드 (1920x650px)';
} elseif ('top' == $pos) {
    $j     = 3;
    $title = '상단배너 업로드 (370x243px)';
} elseif ('middle' == $pos) {
    $j     = 2;
    $title = '중간배너 업로드 (570x298px)';
} elseif ('bottom' == $pos) {
    $j     = 1;
    $title = '하단배너 업로드 (1168x90px)';
}
?>

        <!-- setup start -->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading table-head">
                  <h4><?php echo $title; ?></h4>
                </header>
                <div class="panel-body">
                <form class="form-group" role="form" name="banner" action="banner_setting_ok.php" enctype="multipart/form-data" method="post">
                <input type="hidden" name="mode" value="<?php echo $mode; ?>">
                <input type="hidden" name="num" value="<?php echo $num; ?>">
                <input type="hidden" name="pos" value="<?php echo $pos; ?>">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <tbody>

<?php

for ($i = 1; $i <= $j; $i++) {

    echo <<<HEREDOC

                        <tr>
                          <th rowspan="2" class="wide-10">배너 {$i} </th>
                          <th class="wide-15"><i class="fa fa-picture-o"></i> 이미지 {$i}</th>
                          <td>
HEREDOC;

    $file = 'm_banner' . $i . '_image';
    $flag = 'm_banner' . $i;

    if ("Y" == $row[$flag]) {
        echo '<img src="' . $row[$file] . '" alt="main banner ' . $i . '" width="25%">';
    } else {
        echo "등록된 배너가 없습니다.";
    }

    $link = 'm_link' . $i;

    echo <<<HEREDOC

                            <p>
                              <input type="file" name="uploadfile[]" size="25" />
                            </p>
                          </td>
                        </tr>
                        <tr>
                          <th><i class="fa fa-link"></i> 링크 {$i}</th>
                          <td><input type="text" class="form-control" name="link[]" value="{$row[$link]}" id="m_link{$i}" size="150" /></td>
                        </tr>

HEREDOC;
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

          <div class="row text-center">
            <div class="col-sm-12">
              <button class="btn btn-success" type="submit" >등록하기</button>
              <a type="button" class="btn btn-default" href="banner_list.php">취소</a>
            </div>
          </div>
          </form>

         </section>
      </section>
      <!--main content end-->

      <!--footer start-->
    <?php include_once '../include/admin_footer.php';?>
      <!--footer end-->


  </body>
</html>

