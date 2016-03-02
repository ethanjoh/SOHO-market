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
                <li><i class="fa fa-info-circle"></i> 메일 수신을 원한 회원만 표시됩니다.</li>
                <li><i class="fa fa-info-circle"></i> 회원 정보에 이메일 주소가 없을 경우 표시되지 않습니다.</li>
              </ul>
            </section>
          </div>
        </div>


<?php

if ($mode == 'search') {
    if ($id) {
        $search_keyword .= " and id = '$id' ";
    }

    if ($company_name) {
        $search_keyword .= " AND company_name LIKE '%$company_name%' ";
    }

}

//회원 테이블의 리스트를 불러옵니다.
$query  = "SELECT * FROM member WHERE md_email <> '' AND optin='Y' $search_keyword ";
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

                    <form name="form1" class="form-horizontal" role="form" method="post" action="mem_sendmail_list.php">
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
                      <div class="form-group row">
                          <div class="col-sm-12 text-center">
                            <button class="btn btn-primary" onclick="form1.submit()"><i class="fa fa-search"></i>검색</button>
                          </div>
                      </div>
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
                    전체 회원업체 메일보내기 (총 업체 수: <?php echo number_format($total); ?> 건 )
                </header>

                <table class="table">
                  <thead>
                    <tr>
                      <th>번 호</th>
                      <th>아이디</th>
                      <th>업체명</th>
                      <th>담당자명</th>
                      <th>담당자 이메일</th>
                      <th>가입날짜</th>
                      <th><a href="#" onclick="javascript:checkAll();">전부 선택</a></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
if (!$page_scale) {
    $scale = 30;
} else if ($page_scale == "all") {
    if ($total == 0) {
        $scale = 1;
    } else {
        $scale = $total;
    }

    $checked = "checked";
}

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

$sql_2    = "SELECT * FROM member WHERE md_email <> '' $search_keyword ORDER BY seq_num DESC LIMIT $cline,$scale1 ";
$result_2 = mysqli_query($connect, $sql_2);

for ($i = 1; $list = mysqli_fetch_array($result_2); $i++) {

    $bunho = $total - ($i + $cline) + 1;
    ?>
                      <td><?php echo $bunho; ?></td>
                      <td>
                        <a href="" onclick="javascript:open_win('mem_view_member.php?num=<?php echo $list['seq_num']; ?>&amp;from=mail','nwin','scrollbars=yes,resizable=yes, width=650,height=650');"><?php echo $list['id']; ?></a>
                      </td>
                      <td><?php echo $list['company_name']; ?></td>
                      <td><?php echo $list['md_name']; ?></td>
                      <td><?php echo $list['md_email']; ?></td>
                      <td><?php echo $list['reg_date']; ?></td>
                      <td>
                        <div class="checkbox">
                          <label>
                            <input type="checkbox" name="num[]" value="<?php echo $list['seq_num']; ?>">
                          </label>
                        </div>
                      </td>
                    </tr>
                    <?php
} // end of for loop

mysqli_free_result($result_2);
?>
                  </tbody>
                </table>
              </section>
            </div>
          </div>
          <!-- member list end -->

          <!-- page navigation start -->
          <div class="row text-center">
            <div class="col-sm-12">
              <table class="table">
                <tbody>
                  <tr>
                    <td>
                      <a type="button" class="btn btn-success" href="#" onclick="javascript:mail_send();">메일 보내기</a>
                    </td>
                    <td>
                      <?php
$url = $PHP_SELF . "?id=" . $id . "&mode=" . $mode . "&license_no=" . $license_no . "&md_email=" . $md_email . "&o_phone=" . $o_phone . "&company_name=" . $company_name . "&page_scale=" . $page_scale;
page_nav($totalpage, $cpage, $url);
?>
                    </td>
                    <td>
                      <div class="checkbox pull-right">
                        <label>
                          <input type="checkbox" name="page_scale" value="all" <?php echo $checked; ?> onClick="document.form1.submit();">
                          한 화면으로 보기
                        </label>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
            </form>
          <!-- page navigation end -->

        </section>
    </section>
    <!--main content end-->

     <!--footer start-->
    <?php include_once "../include/admin_footer.php";?>
      <!--footer end-->

  </body>
</html>
