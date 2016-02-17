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

$query  = "SELECT * FROM code WHERE 1 ORDER BY num DESC";
$result = mysqli_query($connect, $query);
$total  = mysqli_num_rows($result);
?>

        <!-- info start -->
        <div class="row">
              <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading">
                사용방법
              </header>
              <ul class="info-body">
                <li><i class="fa fa-info-circle"></i> 쇼핑몰의 HELP 페이지에 생성됩니다.</li>
                <li><i class="fa fa-info-circle"></i> 생성한 순서대로 보여지므로 공지사항 게시판을 먼저 생성하세요.</li>
                <!-- <li><i class="fa fa-info-circle"></i> 공지사항 게시판의 코드는 반드시 <strong>notice</strong>로 해야합니다.</li> -->
                <li><i class="fa fa-info-circle"></i> 코드명은 영문으로 입력하세요.</li>
                <li><i class="fa fa-info-circle"></i> 비밀번호는 각 게시판에 관리자권한으로 접속할 때 필요합니다.</li>
                <li><i class="fa fa-info-circle"></i> 게시판 생성 후 코드명을 클릭하면 권한수정이 가능합니다.</li>
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
                게시판 목록
              </header>
              <div class="panel-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>순서</th>
                        <th>코드명</th>
                        <th>게시판명</th>
                        <th>게시물 수</th>
                        <th>비밀번호</th>
                        <th>쓰기권한</th>
                        <th>읽기권한</th>
                        <th>삭제</th>
                      </tr>
                    </thead>
                    <tbody>
<?php

$mode = set_var($_GET['mode']);
$code = set_var($_GET['code']);

$page  = '';
$scale = 10;

if ($page == '') {
    $page = 1;
}

$cpage     = intval($page);
$totalpage = intval($total / $scale);

if ($totalpage * $scale != $total) {
    $totalpage = $totalpage + 1;
}

if ($cpage == 1) {
    $cline = 0;
} else {
    $cline = ($cpage * $scale) - $scale;
}

$limit = $cline + $scale;

if ($limit >= $total) {
    $limit = $total;
}

$scale1 = $limit - $cline;

if ($total == 0) {
    echo "<tr>\n
                			           <td colspan=\"4\">등록된 게시판이 없습니다.</td>\n
                			         </tr>\n";
} else {
    for ($i = 0; $rows = mysqli_fetch_array($result); $i++) {
        $board   = 'bbs_' . $rows['code'];
        $query2  = "SELECT * FROM $board WHERE 1 ";
        $result2 = mysqli_query($connect, $query2);
        if ($result2) {
            $total2 = mysqli_num_rows($result2);
        } else {
            $total2 = 0;
        }

        $bunho = $total - ($i + $cline);

        ?>
                    <tr>
                      <td><?php echo $bunho; ?></td>
                      <td><a href="bbs_list.php?mode=edit&amp;code=<?php echo $rows['code']; ?>"><?php echo $rows['code']; ?></a><a href="../../bbs/list.php?code=<?php echo $rows['code']; ?>" target="_blank"> <i class="fa fa-external-link"></a></td>
                      <td>
                        <form class="form-inline" role="form" name="bbs_name<?php echo $i; ?>" action="update_bbs.php" method="post">
                        <input type="hidden" name="mode" value="modify" />
                        <input type="hidden" name="num" value="<?php echo $rows['num']; ?>" />
                        <input type="text" class="form-control" name="title" value="<?php echo $rows['bbs_name']; ?>" />
                        &nbsp;
                        <button class="btn btn-warning" onclick="document.bbs_name<?php echo $i; ?>.submit();" />변경</button>
                        </form>
                      </td>
                      <td><?php echo $total2; ?></td>
                      <td>
                        <form class="form-inline" role="form" name="pass<?php echo $i; ?>" action="update_bbs.php" method="post">
                        <input type="hidden" name="mode" value="pw" />
                        <input type="hidden" name="num" value="<?php echo $rows['num']; ?>" />
                        <input type="password" class="form-control" name="passwd" value="">
                        &nbsp;
                        <button class="btn btn-warning" onclick="document.pass<?php echo $i; ?>.submit();" />변경</button>
                        </form>
                      </td>
                      <td>
<?php

        switch ($rows['writable']) {
            case "E":
                echo "비회원 가능";
                break;
            case "A":
                echo "관리자전용";
                break;
            case "M":
                echo "관리자 및 회원전용";
                break;

        }
        ?>
                      </td>
                      <td>
<?php

        switch ($rows['readable']) {
            case "E":
                echo "비회원 가능";
                break;
            case "M":
                echo "회원전용";
                break;
        }
        ?>
                      </td>

                      <td>
                        <form class="form-inline" role="form" name="del" action="update_bbs.php" method="post">
                        <input type="hidden" name="mode" value="del" />
                        <input type="hidden" name="num" value="<?php echo $rows['num']; ?>" />
                        <input type="hidden" name="code" value="<?php echo $rows['code']; ?>" />
                        <button class="btn btn-danger" onclick="return confirm('정말 삭제하시겠습니까?');" /><i class="fa fa-trash-o"></i></button>
                      </td>
                      </form>
                    </tr>
<?php

    }
}
?>
                    </tbody>
                  </table>
                </div>
              </div>
            </section>
          </div>
        </div>
        <!-- bbs list end -->

        <!-- bbs making start -->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading table-head">
                  신규 게시판 생성 / 권한수정
                </header>
                <div class="panel-body">
                  <form class="form-horizontal" role="form" name="ins" method="post" action="update_bbs.php">
                      <div class="form-group">
                          <label for="id" class="col-lg-2 col-sm-2 control-label">코드명 :</label>
                          <div class="col-sm-3">
<?php

if ("edit" == $mode) {

    $query  = "SELECT * FROM code WHERE code='$code'";
    $result = mysqli_query($connect, $query);
    $row    = mysqli_fetch_array($result);
}

if ("edit" == $mode) {
    echo '<input type="text" class="form-control" name="code" id="code" value="' . $row['code'] . '" readonly="readonly">';
} else {
    echo '<input type="text" class="form-control" name="code" id="code">';
}

?>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="id" class="col-lg-2 col-sm-2 control-label">게시판명 :</label>
                          <div class="col-sm-3">
<?php

if ("edit" == $mode) {
    echo '<input type="text" class="form-control" name="title" id="title" value="' . $row['bbs_name'] . '" readonly="readonly" >';
} else {
    echo '<input type="text" class="form-control" name="title" id="title">';
}

?>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="id" class="col-lg-2 col-sm-2 control-label">쓰기권한 :</label>
                          <div class="col-sm-4">
<?php

if ("edit" == $mode) {
    switch ($row['writable']) {
        case 'M':
            echo <<<HEREDOC
                            <input type="radio" name="writable" id="writable" value="M" checked="checked" />관리자/회원
                            <input type="radio" name="writable" id="writable" value="E" />비회원 가능
                            <input type="radio" name="writable" id="writable" value="A" />관리자 전용
HEREDOC;
            break;

        case 'E':
            echo <<<HEREDOC
                            <input type="radio" name="writable" id="writable" value="M" />관리자/회원
                            <input type="radio" name="writable" id="writable" value="E" checked="checked" />비회원 가능
                            <input type="radio" name="writable" id="writable" value="A" />관리자 전용
HEREDOC;
            break;

        case 'A':
            echo <<<HEREDOC
                            <input type="radio" name="writable" id="writable" value="M" />관리자/회원
                            <input type="radio" name="writable" id="writable" value="E" />비회원 가능
                            <input type="radio" name="writable" id="writable" value="A" checked="checked" />관리자 전용
HEREDOC;
            break;
    }

} else {
    echo <<<HEREDOC
                            <input type="radio" name="writable" id="writable" value="M" />관리자/회원
                            <input type="radio" name="writable" id="writable" value="E" />비회원 가능
                            <input type="radio" name="writable" id="writable" value="A" />관리자 전용
HEREDOC;

}
?>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="id" class="col-lg-2 col-sm-2 control-label">읽기권한 :</label>
                          <div class="col-sm-3">
<?php

if ("edit" == $mode) {
    switch ($row['readable']) {
        case 'E':
            echo <<<HEREDOC
                            <input type="radio" name="readable" id="readable" value="E" checked="checked" />비회원 가능
                            <input type="radio" name="readable" id="readable" value="A" />관리자 전용
                            <input type="radio" name="readable" id="readable" value="M" />회원 전용
HEREDOC;
            break;

        case 'A':
            echo <<<HEREDOC
                            <input type="radio" name="readable" id="readable" value="E" />비회원 가능
                            <input type="radio" name="readable" id="readable" value="A" checked="checked" />관리자 전용
                            <input type="radio" name="readable" id="readable" value="M" />회원 전용
HEREDOC;
            break;

        case 'M':
            echo <<<HEREDOC
                            <input type="radio" name="readable" id="readable" value="E" />비회원 가능
                            <input type="radio" name="readable" id="readable" value="A" />관리자 전용
                            <input type="radio" name="readable" id="readable" value="M" checked="checked" />회원 전용
HEREDOC;
            break;

    }
} else {
    echo <<<HEREDOC
                            <input type="radio" name="readable" id="readable" value="E" />비회원 가능
                            <input type="radio" name="readable" id="readable" value="A" />관리자 전용
                            <input type="radio" name="readable" id="readable" value="M" />회원 전용
HEREDOC;

}
?>

                          </div>
                      </div>
                      <div class="text-center">
<?php

if ("edit" == $mode) {
    echo '<input type="hidden" name="mode" value="edit" />';
    echo '<button class="btn btn-success" type="submit">권한수정</button>';
} else {
    echo '<input type="hidden" name="mode" value="ins" />';
    echo '<button class="btn btn-success" type="submit">만들기</button>';
}

?>
                      </div>

                  </form>
                </div>
            </section>
          </div>
        </div>
        <!-- bbs list end -->

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
    <script src="/admin/js/jquery-ui.min.js"></script>
    <script src="/admin/js/jq_datepicker.js" ></script>

    <script>

      //custom select box

      $(function(){
        $('select.styled').customSelect();
      });

    </script>

  </body>
</html>
