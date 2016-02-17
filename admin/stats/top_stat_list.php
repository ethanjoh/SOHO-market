<?php include_once '../include/header.php';?>

  <!-- <body onLoad=init();> -->
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

if ($mode == 'search') {
    if ($id) {
        $search_keyword .= " AND id = '$id' ";
    }

    if ($company_name) {
        $search_keyword .= " AND company_name LIKE '%$company_name%' ";
    }

}

//회원 테이블의 리스트를 불러옵니다.
$query  = "SELECT * FROM member WHERE 1 $search_keyword ";
$result = mysqli_query($connect, $query);
$total  = mysqli_num_rows($result);

?>


        <!-- search start-->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading table-head">
                  회원업체 찾기
              </header>
              <div class="panel-body">

                <form name="mb" class="form-horizontal" role="form" method="post" action="top_stat_list.php">
                <input type="hidden" name="mode" value="search" />
                  <div class="form-group">
                      <label for="id" class="col-lg-2 col-sm-2 control-label">아이디:</label>
                      <div class="col-sm-3">
                          <input type="text" class="form-control" name="id" value="<?=$id;?>">
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="company_name" class="col-lg-2 col-sm-2 control-label">업체명:</label>
                      <div class="col-sm-3">
                          <input type="text" class="form-control" name="company_name" value="<?=$company_name;?>">
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


        <!-- company list start -->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading table-head">
                  업체 목록 ( <?=number_format($total);?> 개 )<p>(정산할 업체를 선택하세요.)
                </header>
                <div class="panel-body">
                  <div class="table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>번호</th>
                        <th>아이디</th>
                        <th>업체명</th>
                        <th>사업자등록번호</th>
                        <th>사무실 전화번호</th>
                        <th>담당자</th>
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

$sql_2 = "SELECT * FROM member
                  					WHERE 1 $search_keyword
                  					ORDER BY seq_num DESC LIMIT $cline,$scale1 ";

$result_2 = mysqli_query($connect, $sql_2);

for ($i = 1; $list = mysqli_fetch_array($result_2); $i++) {

    $bunho = $total - ($i + $cline) + 1;

    ?>
                      <tr>
                        <td><?=$bunho;?></td>
                          <td><a href="mem_stat_list.php?id=<?=$list['id'];?>"><?=$list['id'];?></a></td>
                          <td><?=$list['company_name'];?></td>
                          <td><?=$list['license_no'];?></td>
                          <td><?=$list['o_phone'];?></td>
                          <td><?=$list['md_name'];?></td>
                      </tr>
                      <?php
}
mysqli_free_result($result_2);
?>
                    </tbody>
                  </table>
                </div>
              </div>
            </section>
          </div>
        </div>
        <!-- company list end -->

            <!-- page navigation start -->
        <div class="row text-center">
          <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table">
                  <tbody>
                    <tr>
                      <td>
                        <?php
$url = "top_stat_list.php?id=" . $id . "&mode=" . $mode . "&license_no=" . $license_no . "&company_name=" . $company_name;
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
    <?php include "../include/admin_footer.php";?>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="/js/vendor/jquery-2.2.0.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="/admin/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="/admin/js/jquery.scrollTo.min.js"></script>
    <script src="/admin/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="/admin/js/respond.min.js" ></script>

    <!--common script for all pages-->
    <script src="/admin/js/common-scripts.js"></script>

    <!-- custom scripts -->
    <script src="/js/global.js" ></script>
    <script src="/admin/js/admin.js" ></script>

  </body>
</html>

</body>
</html>
