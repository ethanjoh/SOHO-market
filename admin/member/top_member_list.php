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

} else if ($mode == "nonapproved") {
    $search_keyword .= " AND approved='N' ";
} else if ($mode == "today") {
    $today = date("Y-m-d");
    $search_keyword .= " AND reg_date='$today' ";
}

//회원 테이블의 리스트를 불러옵니다.
$query  = "SELECT * FROM member WHERE 1 $search_keyword ORDER BY company_name";
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

                      <form name="mb" class="form-horizontal" role="form" method="post" action="top_member_list.php">
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
                        <div class="form-group">
                            <label for="phone" class="col-lg-2 col-sm-2 control-label">연락처:</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" name="phone" value="<?=$phone;?>" >
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
                            <a class="btn btn-default" href="top_member_list.php?mode=nonapproved">미승인 업체</a>
                            <a class="btn btn-default" href="top_member_list.php?mode=today">금일 가입업체</a>
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
                      가입업체 리스트 ( <?=number_format($total);?> 개 ) <a href="member2excel.php"><i class="fa fa-file-excel-o"></i> 엑셀로 저장하기</a>
                  </header>
                  <div class="panel-body">
                  <div class="table-responsive">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>번 호</th>
                        <th>아이디</th>
                        <th>업체명</th>
                        <th>구매가능 상품</th>
                        <th>할인율</th>
                        <th>사무실</th>
                        <th>담당자</th>
                        <th>연락처</th>
                        <th>가입일자</th>
                        <th>승인여부</th>
                        <th>삭 제</th>
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

$sql_2    = "SELECT * FROM member WHERE 1 $search_keyword ORDER BY reg_date DESC LIMIT $cline,$scale1 ";
$result_2 = mysqli_query($connect, $sql_2);
$total_2  = mysqli_num_rows($result_2);

if ($total_2) {
    for ($i = 1; $list = mysqli_fetch_array($result_2); $i++) {

        $bunho      = $total - ($i + $cline) + 1;
        $license_no = explode("-", $list['license_no']);
        ?>
                      <tr>
                        <td><?=$bunho;?></td>
                        <td>
                          <a href="javascript:open_win('mem_view_member.php?num=<?=$list['seq_num'];?>&amp;page=<?=$page;?>','nwin','scrollbars=yes,resizable=yes, width=800,height=650');"><?=$list['id'];?></a>
                        </td>
                        <td>
                            <?php
if ($license_no[0] == "000") {
            echo "<img src=\"../images/user-medium-silhouette.png\">";
        }
        ?>
                            <?=stripslashes($list['company_name']);?>
                            <?=$list['homepage'] ? "&nbsp;&nbsp;<a href=\"http://$list[homepage]\" target=\"_blank\"><img src=\"../images/browser_explorer.png\" alt=\"홈페이지 가기\" /></a>" : "";?>
                        </td>
                        <td>
                          <a href="product_list.php?id=<?=$list['id'];?>">보기</a>
                        </td>
                        <td><?=$list['dc_rate'];?> % DC
                          <?php
switch ($list['tax']) {
            case "E":echo " (VAT 별도)";
                break;
            case "I":echo " (VAT 포함)";
                break;
        }
        ?>
                        </td>
                        <td><?=$list['o_phone'];?></td>
                        <td><?=$list['md_name'];?> ( <?=$list['job_title'];?> )</td>
                        <td><?=$list['md_hphone'];?></td>
                        <td>
                          <?php
echo $reg_date = substr($list['reg_date'], 0, 10); ?>
                        </td>
                        <td>
                          <?php
if ($list['approved'] == "Y") {
            echo "<i class=\"fa fa-check\"></i> OK";
        } else {
            echo "<i class=\"fa fa-pause\"></i> PAUSE";
        }

        ?>
                        </td>
                        <td>
                          <a type="button" class="btn btn-danger" href="mem_delete_member.php?m_num=<?=$list['seq_num'];?>&amp;page=<?=$page;?>" onclick="return confirm('이 회원의 모든 정보가 즉시 삭제되며 복구할 수 없습니다. \n삭제하시겠습니까?')"><i class="fa fa-trash-o"></i></a>
                        </td>
                      </tr>
                      <?php
} // end of for loop

    mysqli_free_result($result_2);
} else {
    ?>
                      <tr>
                        <td colspan="11"><p>등록된 업체가 없습니다.</p></td>
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
$url = $PHP_SELF . "?id=" . $id . "&mode=" . $mode . "&license_no=" . $license_no . "&md_email=" . $md_email . "&o_phone=" . $o_phone . "&company_name=" . $company_name . "&md_hphone=" . $md_hphone;
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

  <script>

      //owl carousel

      $(document).ready(function() {
          $("#owl-demo").owlCarousel({
              navigation : true,
              slideSpeed : 300,
              paginationSpeed : 400,
              singleItem : true,
              autoPlay:true

          });
      });

      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

  </script>

  </body>
</html>
