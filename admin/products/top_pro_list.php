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

        <!-- info start-->
        <div class="row">
              <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading">
                사용방법
              </header>
              <ul class="info-body">
                <li><i class="fa fa-info-circle"></i> 상품을 등록할 카테고리를 먼저 선택하세요.</li>
                <li><i class="fa fa-info-circle"></i> 유사상품을 반복해서 등록할 때는 [복사] 기능을 이용하세요.</li>
                <li><i class="fa fa-info-circle"></i> 본 페이지에서는 관리자가 등록한 상품만 출력됩니다. 공급업체 등록상품은 [공급업체 관리] > [상품관리] 에서 확인하세요.</li>
                <li><i class="fa fa-info-circle"></i> 신상품/기획상품/인기상품은 메인화면에 표시 여부입니다.</li>
                <li><i class="fa fa-info-circle"></i> <i class="fa fa-lock"></i> 표시는 숨김상품입니다.</li>

              </ul>
            </section>
          </div>
        </div>
        <!-- info end -->

        <!-- category list start -->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading table-head">
                  카테고리 리스트
                </header>
                <div class="panel-body">
                  <form name="category">
                  <div class="table-responsive">
                  <table class="table">
                    <tbody>
                        <tr>
                          <td>
                              <select class="form-control" name="lcode" onchange="show_msub();">
                                <option>--- 카테고리 ---</option>
                                <?php
$query   = "SELECT * FROM products_category1 ORDER BY num ";
$result2 = mysqli_query($connect, $query);
// 현재위치 표시
for ($i = 1; $row2 = mysqli_fetch_array($result2); $i++) {
    if ($lcode == $row2['code']) {
        $sel = "selected=\"selected\"";
    } else {
        $sel = "";
    }

    echo "<option value=\"$row2[code]\" $sel>$row2[name]</option>\n";
}
mysqli_free_result($result2);
?>
                              </select>
                          </td>
                          <td>
                            <select class="form-control" name="mcode" onchange="show_ssub('<?=$lcode;?>');">
                              <option>--- 중분류 ---</option>
                              <?php
if ($lcode) {
    $query  = "SELECT * FROM products_category2 WHERE up_category='$lcode' ORDER BY code";
    $result = mysqli_query($connect, $query);

    for ($i = 0; $row = mysqli_fetch_array($result); $i++) {
        if ($mcode == $row['code']) {
            $sel2 = "selected=\"selected\"";
        } else {
            $sel2 = "";
        }

        echo "<option value=\"$row[code]\" $sel2>$row[name]</option>\n";
    }
}
?>
                            </select>
                          </td>
                          <td>
                            <select class="form-control" name="scode" onchange="show_last('<?=$lcode;?>', '<?=$mcode;?>');">
                              <option>--- 소분류 ---</option>
                              <?php
if ($mcode) {
    $query3  = "SELECT * FROM products_category3 WHERE up_category='$mcode' ORDER BY code";
    $result3 = mysqli_query($connect, $query3);

    for ($i = 0; $srow = mysqli_fetch_array($result3); $i++) {
        if ($scode == $srow['code']) {
            $sel3 = "selected=\"selected\"";
        } else {
            $sel3 = "";
        }

        echo "<option value=\"$srow[code]\" $sel3>$srow[name]</option>\n";
    }
}
?>
                            </select>
                          </td>
                        </tr>

                    </tbody>
                  </table>
                  </div>
                  </form>
                </div>
              </section>
            </div>
          </div>
          <!-- category list start -->

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

            <!-- buttons start -->
            <div class="row">
              <div class="col-sm-12">
              <div class="table-responsive">
                <table class="table">
                  <tbody>
                    <tr>
                      <td>
                        <a class="btn btn-default" href="top_pro_list.php?pmode=out&lcode=<?=$lcode;?>&mcode=<?=$mcode;?>&scode=<?=$scode;?>&page=<?=$page;?>">[품절상품]만 보기</a>
                        <a class="btn btn-default" href="top_pro_list.php?pmode=cut&lcode=<?=$lcode;?>&mcode=<?=$mcode;?>&scode=<?=$scode;?>&page=<?=$page;?>">[단종상품]만 보기</a>
                        <a class="btn btn-default" href="top_pro_list.php?pmode=end&lcode=<?=$lcode;?>&mcode=<?=$mcode;?>&scode=<?=$scode;?>&page=<?=$page;?>">[판매종료 상품]만 보기</a>
                        <a class="btn btn-primary" href="top_pro_list.php?lcode=<?=$lcode;?>&mcode=<?=$mcode;?>&scode=<?=$scode;?>&page=<?=$page;?>">전체보기(판매종료 제외)</a>
                      </td>
                    </tr>
                  </tbody>
                </table>
                </div>
              </div>
            </div>
            <!-- buttons end -->


        <!-- products list start -->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading table-head">
                  상품 리스트 (총 등록상품 수: <?=$total;?> 개)
                  <?php
if ($lcode) {
    echo "<a href=\"pro_list.php?lcode=$lcode\"><i class=\"fa fa-file-excel-o\"></i> 엑셀로 상품목록 다운로드</a>";
}

?>
              </header>
              <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>번호</th>
                      <th colspan="2">제품명</th>
                      <th>옵션</th>
                      <th>판매가</th>
                      <th>신상품</th>
                      <th>기획상품</th>
                      <th>인기상품</th>
                      <th>복사</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
$scale = 50;

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

$query1 = "SELECT * FROM products WHERE $qry_char ORDER BY num DESC LIMIT $cline,$scale1";
//echo $query1;
$result1 = mysqli_query($connect, $query1);

if ($result1) {
    //에러처리

    for ($i = 0; $prow = mysqli_fetch_array($result1); $i++) {
        $list_num = $total - ($cline + $i);

        if ($i % 2 == 1) {
            echo "<tr class=\"odd\">\n";
        } else {
            echo "<tr>\n";
        }

        ?>
                    <td><?=$list_num;?></td>
                    <td><img src="<?=$prow['s_image_name'];?>" width="50" height="50" alt="small image" /></td>
                    <td class="left"><?=show_icon($prow);?>
                      <a href="pro_register.php?mode=update&amp;pmode=<?=$pmode;?>&amp;p_num=<?=$prow['num'];?>&amp;lcode=<?=$prow['category_l'];?>&amp;mcode=<?=$prow['category_m'];?>&amp;scode=<?=$prow['category_s'];?>&amp;page=<?=$page;?>">
                      <?=stripslashes($prow['name']);?></a>
                      </a>&nbsp;<a href="http://<?=$_SERVER['HTTP_HOST'];?>/shop/catalog-list.php?lcode=<?=$prow['category_l'];?>&amp;mcode=<?=$prow['category_m'];?>&amp;scode=<?=$prow['category_s'];?>" target="_blank"><img src="../images/browser_explorer.png" alt="상품보기" /> </a>
                    </td>
                    <td>
                    <?php
if ($prow['opt']) {
            show_option($prow);
        }

        ?>
                    </td>
                    <td><?=number_format(trim($prow['retail_price']));?> 원</td>
                    <td><?php if ($prow['main_new'] == 'Y') {
            echo "<a type=\"button\" class=\"btn btn-round btn-success\" href=\"pro_opt.php?p_num=" . $prow['num'] . "&mode=del&lcode=" . $prow['category_l'] . "&mcode=" . $prow['category_m'] . "&scode=" . $prow['category_s'] . "&ck=main_new&page=" . $page . "\"><i class=\"fa fa-times\"></i> ON</a>";
        } else {
            echo "<a type=\"button\" class=\"btn btn-round btn-default\" href=\"pro_opt.php?p_num=" . $prow['num'] . "&mode=insert&lcode=" . $prow['category_l'] . "&mcode=" . $prow['category_m'] . "&scode=" . $prow['category_s'] . "&ck=main_new&page=" . $page . "\"><i class=\"fa fa-check\"></i> OFF</a>";
        }
        ?>  </td>
                    <td><?php if ($prow['main_special'] == 'Y') {
            echo "<a <a type=\"button\" class=\"btn btn-round btn-success\" href=\"pro_opt.php?p_num=" . $prow['num'] . "&mode=del&lcode=" . $prow['category_l'] . "&mcode=" . $prow['category_m'] . "&scode=" . $prow['category_s'] . "&ck=main_special&page=" . $page . "\"><i class=\"fa fa-times\"></i> ON</a>";
        } else {
            echo "<a type=\"button\" class=\"btn btn-round btn-default\" href=\"pro_opt.php?p_num=" . $prow['num'] . "&mode=insert&lcode=" . $prow['category_l'] . "&mcode=" . $prow['category_m'] . "&scode=" . $prow['category_s'] . "&ck=main_special&page=" . $page . "\"><i class=\"fa fa-check\"></i> OFF</a>";
        }
        ?>  </td>
                    <td><?php if ($prow['main_best'] == 'Y') {
            echo "<a <a type=\"button\" class=\"btn btn-round btn-success\" href=\"pro_opt.php?p_num=" . $prow['num'] . "&mode=del&lcode=" . $prow['category_l'] . "&mcode=" . $prow['category_m'] . "&scode=" . $prow['category_s'] . "&ck=main_best&page=" . $page . "\"><i class=\"fa fa-times\"></i> ON</a>";
        } else {
            echo "<a type=\"button\" class=\"btn btn-round btn-default\" href=\"pro_opt.php?p_num=" . $prow['num'] . "&mode=insert&lcode=" . $prow['category_l'] . "&mcode=" . $prow['category_m'] . "&scode=" . $prow['category_s'] . "&ck=main_best&page=" . $page . "\"><i class=\"fa fa-check\"></i> OFF</a>";
        }
        ?>  </td>
                    <form name="register" action="pro_register_ok.php" method="post" onsubmit="javascript:return confirm('상품을 복사하시겠습니까?');">
                      <input type="hidden" name="mode" value="copy" />
                      <input type="hidden" name="p_num" value="<?=$prow['num'];?>" />
                      <input type="hidden" name="page" value="<?=$page;?>" />
                      <td>
                        <button class="btn btn-warning" onclick="register.submit();" /><i class="fa fa-files-o"></i></button>
                      </td>
                    </form>
                  </tr>
                  <?php
} // end of for loop

}
; //if($result1)

?>
          <?php
if ($total == 0) {
    ?>
                  <tr>
                    <td colspan="9"><p>등록된 상품이 없습니다.</p></td>
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
      <!-- products list end -->

      <div class="row col-sm-12">

        <!-- page navigation start -->
        <div class="pull-left">
          <?php
$url = $PHP_SELF . "?mode=" . $mode . "&pmode=" . $pmode . "&lcode=" . $lcode . "&mcode=" . $mcode . "&scode=" . $scode . "&key=" . $key . "&keyword=" . $keyword;
page_nav($totalpage, $cpage, $url);
?>
        </div>
        <!-- page navigation end -->

        <!-- function buttons start -->
        <div class="pull-right margin-20">
          <a type="button" class="btn btn-success" href="pro_register.php?lcode=<?=$lcode;?>&amp;mcode=<?=$mcode;?>&amp;scode=<?=$scode;?>&amp;page=<?=$page;?>">상품등록</a>
        </div>
        <!-- function buttons end -->

      </div>


        <!-- search start -->
        <div class="row text-center">
          <div class="col-sm-12">
            <form class="form-inline" action="top_pro_list.php" name="search" method="post" >
              해당 카테고리 내 검색 :
              <select name="key" class="form-control">
                <option value="name">상품명</option>
              </select>
              <input type="hidden" name="mode" value="search" />
              <input type="hidden" name="lcode" value="<?=$lcode;?>" />
              <input type="hidden" name="mcode" value="<?=$mcode;?>" />
              <input type="hidden" name="scode" value="<?=$scode;?>" />
              <div class="ui-widget form-group">
                <input type="text" class="form-control" name="keyword" size="16" />
                <button class="btn btn-primary" onclick="search.submit()"><i class="fa fa-search"></i>검 색</button>
              </div>
            </form>
          </div>
        </div>
        <!-- search end -->

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
