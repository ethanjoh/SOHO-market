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

    $search_keyword = '';
    $id             = '';
    $name           = '';
    $phone          = '';

    if ("search" == $mode) {

        if ($id) {
            $search_keyword .= " AND id LIKE '%$id%' ";
        }

        if ($name) {
            $search_keyword .= " AND name LIKE '%$name%' ";
        }

        if ($phone) {
            $search_keyword .= " AND o_phone LIKE '%$phone%' OR hphone LIKE '%$phone%' ";
        }

    } else if ($mode == "nonapproved") {
        $search_keyword .= " AND approved='N' ";
    } else if ($mode == "today") {
        $today = date("Y-m-d");
        $search_keyword .= " AND reg_date='$today' ";
    }

    //회원 테이블의 리스트를 불러옵니다.
    $query  = "SELECT * FROM p_member WHERE 1 $search_keyword ORDER BY name";
    $result = mysqli_query($connect, $query);
    $total  = mysqli_num_rows($result);

?>


              <!-- search start-->
              <div class="row">
                <div class="col-sm-12">
                  <section class="panel">
                    <header class="panel-heading table-head">
                        개인회원 찾기
                    </header>
                    <div class="panel-body">

                      <form name="mb" class="form-horizontal" role="form" method="post" action="top_member_list.php">
                      <input type="hidden" name="mode" value="search" />
                        <div class="form-group">
                            <label for="id" class="col-lg-2 col-sm-2 control-label">아이디:</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="id" value="<?php echo $id; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-lg-2 col-sm-2 control-label">회원명:</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="name" value="<?php echo $name; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-lg-2 col-sm-2 control-label">연락처:</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="phone" value="<?php echo $phone; ?>" >
                                <p class="help-block">(예 : 02-123-4567 또는 010-1234-5678)</p>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 text-center">
                              <button class="btn btn-primary" onclick="mb.submit()"><i class="fa fa-search"></i>검색</button>
                            </div>
                        </div>
                      </form>

                    </div>
                  </section>
                </div>
              </div>
              <!-- search end -->

              <!-- buttons start -->
              <div class="row">
                <div class="col-sm-12">
                <div class="table-responsive">
                  <table class="table">
                    <tbody>
                      <tr>
                        <td class="text-center">
                            <a class="btn btn-default" href="top_member_list.php?mode=nonapproved">미승인 회원</a>
                            <a class="btn btn-default" href="top_member_list.php?mode=today">금일 가입회원</a>
                            <a class="btn btn-primary" href="top_member_list.php">전체 목록</a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                </div>
              </div>
              <!-- buttons end -->


            <!-- member list start -->
            <div class="row">
              <div class="col-sm-12">
                <section class="panel">
                  <header class="panel-heading table-head">
                      가입회원 리스트 (<?php echo number_format($total); ?> 개 ) <a href="pmember2excel.php"><i class="fa fa-file-excel-o"></i> 엑셀로 저장하기</a>
                  </header>
                  <div class="panel-body">
                  <div class="table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>번 호</th>
                        <th>아이디</th>
                        <th>회원명</th>
                        <th>할인율</th>
                        <th>연락처</th>
                        <th>휴대폰</th>
                        <th>가입일자</th>
                        <th>승인여부</th>
                        <th>삭 제</th>
                      </tr>
                    </thead>
                    <tbody>
<?php

    $page  = set_var($_GET['page']);
    $scale = 20;
    $page  = (isset($_GET['page']) ? $_GET['page'] : '');

    if ('' == $page) {
        $page = 1;
    }

    $cpage     = intval($page);
    $totalpage = intval($total / $scale);

    if ($totalpage * $scale != $total) {
        $totalpage = $totalpage + 1;
    }

    if (1 == $cpage) {
        $cline = 0;
    } else {
        $cline = ($cpage * $scale) - $scale;
    }

    $limit = $cline + $scale;

    if ($limit >= $total) {
        $limit = $total;
    }

    $scale1 = $limit - $cline;

    $sql_2    = "SELECT * FROM p_member WHERE 1 $search_keyword ORDER BY reg_date DESC LIMIT $cline,$scale1 ";
    $result_2 = mysqli_query($connect, $sql_2);
    $total_2  = mysqli_num_rows($result_2);

    if ($total_2) {
        for ($i = 1; $list = mysqli_fetch_array($result_2); $i++) {

            $bunho = $total - ($i + $cline) + 1;
        ?>
                      <tr>
                        <td><?php echo $bunho; ?></td>
                        <td>
                          <a href="javascript:open_win('p_mem_view_member.php?num=<?php echo $list['seq_num']; ?>&amp;page=<?php echo $page; ?>','nwin','scrollbars=yes,resizable=yes, width=800,height=650');"><?php echo $list['id']; ?></a>
                        </td>
                        <td>
<?php

            echo stripslashes($list['name']);
        ?>
                        </td>
                        <td><?php echo $list['dc_rate']; ?> % DC
<?php

            switch ($list['tax']) {
                case "E":echo " (VAT 별도)";
                    break;
                case "I":echo " (VAT 포함)";
                    break;
            }
        ?>
                        </td>
                        <td><?php echo $list['o_phone']; ?></td>
                        <td><?php echo $list['hphone']; ?></td>
                        <td><?php echo $reg_date = substr($list['reg_date'], 0, 10); ?></td>
                        <td>
<?php

            if ($list['approved'] == "Y") {
                echo '<i class="fa fa-check"></i> OK';
            } else {
                echo '<i class="fa fa-pause"></i> PAUSE';
            }

        ?>
                        </td>
                        <td>
                          <a type="button" class="btn btn-xs btn-danger" href="mem_delete_member.php?m_num=<?php echo $list['seq_num']; ?>&amp;page=<?php echo $page; ?>" onclick="return confirm('이 회원의 모든 정보가 즉시 삭제되며 복구할 수 없습니다. \n삭제하시겠습니까?')"><i class="fa fa-trash-o"></i></a>
                        </td>
                      </tr>
<?php

        } // end of for loop

        mysqli_free_result($result_2);
    } else {
    ?>
                      <tr>
                        <td colspan="9"><p>등록된 회원이 없습니다.</p></td>
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
            <!-- member list end -->


            <!-- page navigation start -->
            <div class="row text-center">
              <div class="col-sm-12">
                <div class="table-responsive">
                    <table class="table">
                      <tbody>
                        <tr>
                          <td>
<?php

    $url = $_SERVER['PHP_SELF'] . '?mode=' . $mode;
    page_nav($totalpage, $cpage, $url);
?>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
              </div>
            </div>
            <!-- page navigation end -->


          </section>
      </section>
      <!--main content end-->

    <!--footer start-->
    <?php include_once "../include/admin_footer.php";?>
      <!--footer end-->

  </body>
</html>
