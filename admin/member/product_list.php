<?php

include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

//메타정보
$info_query = "SELECT * FROM admin_setup";
$info_res   = mysqli_query($connect, $info_query);
$info       = mysqli_fetch_array($info_res);

?>
<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keyword" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="shortcut icon" href="/favicon.ico">

    <title><?=$info['company_name'];?> :: 운영업체 관리자 홈</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/admin/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="/css/font-awesome.min.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="/admin/css/style.css" rel="stylesheet">
    <link href="/admin/css/style-responsive.css" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>

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
                <input type="hidden" name="lcode" value="<?=$lcode;?>" />
                <input type="hidden" name="mcode" value="<?=$mcode;?>" />
                <input type="hidden" name="scode" value="<?=$scode;?>" />
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
                  상품 리스트 (총 등록상품 수: <?=$total;?> 개)
              </header>
              <div class="panel-body">
              <div class="table-responsive">
                <form name="form1" class="form-inline" role="form" method="post" action="javascript:buy_save();">
                <input type="hidden" name="com_id" value="<?=$id;?>">
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
                    <td><?=$list_num;?></td>
                    <td><img src="<?=$prow['s_image_name'];?>" width="50" height="50" alt="small image" /></td>
                    <td><?=show_icon($prow);?><?=stripslashes($prow['name']);?>
                      &nbsp;<a href="http://<?=$_SERVER['HTTP_HOST'];?>/shop/detail.php?pnum=<?=$prow['num'];?>&amp;lcode=<?=$prow['category_l'];?>&amp;mcode=<?=$prow['category_m'];?>&amp;scode=<?=$prow['category_s'];?>" target="_blank"><img src="../images/browser_explorer.png" alt="상품보기" /></a>
                    </td>
                    <td>
                    <?php
if ($prow['opt']) {
            show_option($prow);
        }

        ?>
                    </td>
                    <td><input type="text" name="price[]" class="form-control" value="<?=trim($price[$i]);?>"> 원</td>
                    <td>
                      <input type="checkbox" name="num[]" value="<?=$i;?>" <?=$available[$i] == "Y" ? "checked" : "";?> >
                      <input type="hidden" name="pro_id[]" value="<?=$prow['prod_code'];?>">
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
              <input type="hidden" name="flag" value="<?=$flag;?>">
              <input type="hidden" name="count" value="<?=$i;?>">

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
<!--
    <script>
      $(document).ready(function(){
          $("input:checkbox[name='num[]']").change(function(){
              if($(this).prop('checked') === true){
                  $(this).attr("value", 'Y');
                 $('#show').text($(this).attr('value'));
              }else{
                  $(this).attr("value", 'N');
                   $('#show').text($(this).attr('value'));
              }
          });
      });
    </script>
    -->
  </body>
</html>
