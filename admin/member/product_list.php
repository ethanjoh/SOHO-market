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
                <li><i class="fa fa-info-circle"></i> 구매가능 설정을 위해 우측의 체크박스에 체크하세요.</li>
                <li><i class="fa fa-info-circle"></i> 전체선택을 하려면 구매가능을 클릭하세요.</li>
                <li><i class="fa fa-info-circle"></i> 설정 후에는 저장버튼을 눌러 저장합니다.</li>
              </ul>
            </section>
          </div>
        </div>
        <!-- info end -->

        <!-- search start -->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading table-head">
                  상품 찾기
              </header>
              <div class="panel-body text-center">
                <form class="form-inline" action="product_list.php" name="search" method="post" >
                <select name="key" class="form-control">
                  <option value="name">상품명</option>
                  <option value="company">제조사</option>
                </select>
                <input type="hidden" name="mode" value="search" />
                <input type="hidden" name="lcode" value="<?php echo $lcode; ?>" />
                <input type="hidden" name="mcode" value="<?php echo $mcode; ?>" />
                <input type="hidden" name="scode" value="<?php echo $scode; ?>" />
                <div class="ui-widget form-group">
                  <input type="text" class="form-control" name="keyword" size="16" />
                  <button class="btn btn-primary" onclick="search.submit()"><i class="fa fa-search"></i>검 색</button>
                </div>
                </form>
              </div>
            </section>
          </div>
        </div>
        <!-- search end -->

<?php

if ($lcode != "" && $pmode != "end") {
    $qry_char = "del_chk <> 'Y' AND category_l ='$lcode' ";
} else if ($lcode == "" && $pmode == "end") {
    $qry_char = "del_chk = 'Y' ";
} else {
    $qry_char = "del_chk <> 'Y' ";
}

if ($mcode) {
    $qry_char .= " AND category_m ='$mcode' ";
}

if ($scode) {
    $qry_char .= " AND category_s ='$scode' ";
}

if ($mode == "search") {
    $qry_char .= " AND $key LIKE '%$keyword%' ";
}

if ($pmode == "out") {
    $qry_char .= "AND del_chk = 'O' ";
} else if ($pmode == "cut") {
    $qry_char .= "AND del_chk = 'C' ";
} else if ($pmode == "end" && $lcode != "") {
    $qry_char = "del_chk = 'Y' AND category_l ='$lcode' ";
} else if ($pmode == "end" && $lcode = "") {
    $qry_char = "del_chk = 'Y' ";
}

// 상품의 정보를 모두 가져옴
$query  = "SELECT * FROM products WHERE $qry_char ";
$result = mysqli_query($connect, $query);

if ($result) {
    $total = mysqli_num_rows($result);
    mysqli_free_result($result);
}
?>


        <!-- products list start -->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading table-head">
                  상품 리스트 (총 등록상품 수: <?php echo $total; ?> 개)
              </header>
              <div class="panel-body">
              <div class="table-responsive">
                <form name="form1" class="form-inline" role="form" method="post" action="javascript:buy_save();">
                <input type="hidden" name="com_id" value="<?php echo $id; ?>">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>번호</th>
                      <th colspan="2">제품명</th>
                      <th>옵션</th>
                      <th>개별 공급가<p class="help-block">(VAT 별도)</p></th>
                      <th><a href="#" onclick="checkAll();">구매가능 여부</a><br>(클릭시 전체선택)
                          <div id="show"></div>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
<?php

$scale = 10;

if ($page == "") {
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

$query1  = "SELECT * FROM products WHERE $qry_char ORDER BY num DESC LIMIT $cline, $scale1";
$result1 = mysqli_query($connect, $query1);

if ($result1) {
    //에러처리

    for ($i = 0; $prow = mysqli_fetch_array($result1); $i++) {
        $list_num = $total - ($cline + $i);

        $query2  = "SELECT * FROM buy_product WHERE com_id = '$id' ";
        $result2 = mysqli_query($connect, $query2);
        $no      = mysqli_num_rows($result2);

        if ($no > 0) {
            $brow      = mysqli_fetch_array($result2);
            $available = explode(',', $brow['available']);
            $price     = explode(',', $brow['price']);
            $flag      = "edit";
        }

        ?>
                  <tr>
                    <td><?php echo $list_num; ?></td>
                    <td><img src="<?php echo $prow['s_image_name']; ?>" width="50" height="50" alt="small image" /></td>
                    <td><?php echo show_icon($prow); ?><?php echo stripslashes($prow['name']); ?>
                      &nbsp;<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/shop/detail.php?pnum=<?php echo $prow['num']; ?>&amp;lcode=<?php echo $prow['category_l']; ?>&amp;mcode=<?php echo $prow['category_m']; ?>&amp;scode=<?php echo $prow['category_s']; ?>" target="_blank"><img src="../images/browser_explorer.png" alt="상품보기" /></a>
                    </td>
                    <td>
<?php

        if ($prow['opt']) {
            show_option($prow);
        }

        ?>
                    </td>
                    <td><input type="text" name="price[]" class="form-control" value="<?php echo trim($price[$i]); ?>"> 원</td>
                    <td>
                      <input type="checkbox" name="num[]" value="<?php echo $i; ?>" <?php echo $available[$i] == "Y" ? "checked" : ""; ?> >
                      <input type="hidden" name="pro_id[]" value="<?php echo $prow['prod_code']; ?>">
                    </td>
                  </tr>
<?php

          // $count += $i;
    } // end of for loop

} //if($result1)

if ($total == 0) {
    ?>
                  <tr>
                    <td colspan="6"><p>등록된 상품이 없습니다.</p></td>
                  </tr>
                  <?php
}
?>
                </tbody>
              </table>
              <input type="hidden" name="flag" value="<?php echo $flag; ?>">
              <input type="hidden" name="count" value="<?php echo $i; ?>">

              </div>
            </div>
          </section>
        </div>
      </div>
      <!-- products list end -->

      <div class="row col-sm-12">

        <!-- page navigation start -->
        <div class="pull-left">
<?php

$url = $_SERVER['PHP_SELF'] . "?mode=" . $mode . "&pmode=" . $pmode . "&lcode=" . $lcode . "&mcode=" . $mcode . "&scode=" . $scode . "&key=" . $key . "&keyword=" . $keyword;
page_nav($totalpage, $cpage, $url);
?>
        </div>
        <!-- page navigation end -->

        <!-- function buttons start -->
        <div class="pull-right margin-20">
          <a class="btn btn-default" href="top_member_list.php">목록</a>
          <button class="btn btn-success" onclick="form1.submit();">저장</button>
        </div>
        <!-- function buttons end -->
        </form>

      </div>

          </section>
      </section>
      <!--main content end-->


     <!--footer start-->
    <?php include_once "../include/admin_footer.php";?>
      <!--footer end-->

  </body>
</html>
