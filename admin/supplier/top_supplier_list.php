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

if ($mode == "search") {

    if ($id) {
        $search_keyword .= " AND id LIKE '%$id%' ";
    }

    if ($company_name) {
        $search_keyword .= " AND company_name LIKE '%$company_name%' ";
    }

    if ($phone) {
        $search_keyword .= " AND o_phone LIKE '%$phone%' OR md_hphone LIKE '%$phone%' ";
    }
}

//회원 테이블의 리스트를 불러옵니다.
$query  = "SELECT * FROM supplier WHERE 1 $search_keyword ";
$result = mysqli_query($connect, $query);
if ($result) {
    $total = mysqli_num_rows($result);
}
?>

              <!-- search start-->
              <div class="row">
                <div class="col-sm-12">
                  <section class="panel">
                    <header class="panel-heading table-head">
                        공급업체 찾기
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
                            <label for="company_name" class="col-lg-2 col-sm-2 control-label">업체명:</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="company_name" value="<?php echo $company_name; ?>">
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

            <!-- member list start -->
            <div class="row">
              <div class="col-sm-12">
                <section class="panel">
                  <header class="panel-heading table-head">
                      공급업체 리스트 ( <?php echo number_format($total); ?> 개 ) <a href="supplier2excel.php"><i class="fa fa-file-excel-o"></i> 엑셀로 저장하기</a>
                  </header>
                  <div class="panel-body">
                  <div class="table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>번호</th>
                        <th>아이디</th>
                        <th>업체명</th>
                        <th>수수료율</th>
                        <th>사무실 전화번호</th>
                        <th>담당자명</th>
                        <th>담당자 휴대폰</th>
                        <th>등록일자</th>
                        <th>삭제</th>
                      </tr>
                    </thead>
                    <tbody>
<?php

$scale = 30;

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

$sql_2    = "SELECT * FROM supplier WHERE 1 $search_keyword ORDER BY seq_num DESC LIMIT $cline,$scale1 ";
$result_2 = mysqli_query($connect, $sql_2);

if ($result_2) {
    $total_2 = mysqli_num_rows($result_2);
}

if ($total_2) {
    for ($i = 1; $list = mysqli_fetch_array($result_2); $i++) {

        $bunho = $total - ($i + $cline) + 1;
        ?>
                      <tr>
                        <th><?php echo $bunho; ?></th>
                        <td >
                          <a href="javascript:open_win('view_supplier.php?num=<?php echo $list['seq_num']; ?>&amp;page=<?php echo $page; ?>','nwin','scrollbars=yes,resizable=yes, width=850,height=650');"><?php echo $list[id]; ?></a>
                        </td>
                        <td>
                          <?php echo $list['company_name']; ?><?php echo $list['homepage'] ? "&nbsp;&nbsp;<a href=\"http://$list[homepage]\" target=\"_blank\"><img src=\"../images/browser_explorer.png\" alt=\"홈페이지 가기\" /></a>" : ""; ?>
                        </td>
                        <td>
                          <?php echo $list['margin']; ?> %
<?php

        switch ($list['tax']) {
            case "E":
                echo " (VAT 별도)";
                break;
            case "I":
                echo " (VAT 포함)";
                break;
        }
        ?>
                        </td>
                        <td><?php echo $list['o_phone']; ?></td>
                        <td><?php echo $list['md_name']; ?></td>
                        <td><?php echo $list['md_hphone']; ?></td>
                        <td><?php echo $list['reg_date']; ?></td>
                        <td>
                          <a type="button" class="btn btn-danger" href="delete_supplier.php?m_num=<?php echo $list['seq_num']; ?>&amp;page=<?php echo $page; ?>" onclick="return confirm('이 회원의 모든 정보가 즉시 삭제되며 복구할 수 없습니다 \n삭제하시겠습니까?')"><i class="fa fa-trash-o"></i></a>
                        </td>
                      </tr>
<?php

    } // end of for loop

    mysqli_free_result($result_2);
} else {
    ?>
                      <tr>
                        <td colspan="9"><p>등록된 공급업체가 없습니다.</p></td>
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

$url = $_SERVER['PHP_SELF'] . "?id=" . $id . "&mode=" . $mode . "&license_no=" . $license_no . "&md_email=" . $md_email . "&o_phone=" . $o_phone . "&company_name=" . $company_name . "&md_hphone=" . $md_hphone;
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
