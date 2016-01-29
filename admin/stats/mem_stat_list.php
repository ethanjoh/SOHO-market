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
switch ($mode) {
    case 'date':
        $query = "SELECT * FROM member, mall_order
        	          				  WHERE (mall_order.cancel = 'N')
        			  				  AND (member.id='$id')
        			  				  AND (mall_order.user_id='$id')
        			  				  AND (mall_order.status = '8' )
        			  				  AND mall_order.createdate BETWEEN  '$date1' AND '$date2'
        			   				  ORDER BY mall_order.num DESC ";
        break;
    default:
        $query = "SELECT * FROM member, mall_order
        	          				  WHERE (mall_order.cancel = 'N')
        			  				  AND (member.id='$id')
        			  				  AND (mall_order.user_id='$id')
        			  				  AND (mall_order.status = '8' )
        			   				  ORDER BY mall_order.num DESC ";
}

$result = mysqli_query($connect, $query);
$total  = mysqli_num_rows($result);

/*
$scale=30;

if ($page == ''){
$page=1;
}

$cpage = intval($page);
$totalpage = intval($total/$scale);

if ($totalpage*$scale != $total)
$totalpage = $totalpage + 1;

if ($cpage ==1) {
$cline = 0 ;
} else {
$cline = ($cpage*$scale) - $scale ;
}

$limit=$cline+$scale;

if ($limit >= $total)
$limit=$total;

$scale1 = $limit - $cline;
 */
?>

        <!-- info start-->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading">
                사용방법
              </header>
              <ul class="info-body">
                <li><i class="fa fa-info-circle"></i> 정산할 날짜 범위를 검색해 정산금액을 확인합니다.</li>
              </ul>
            </section>
          </div>
        </div>

        <!-- calendar start -->
        <form name="form" method="get" action="mem_stat_list.php" class="form-inline form-group" role="form">
        <input type="hidden" name="mode" value="date" />
        <input type="hidden" name="id" value="<?=$id;?>" />
        <div class="panel panel-info">
          <div class="panel-heading">날짜 검색</div>
            <div class="panel-body text-center">

              <div class="row text-center">
                <div class="form-group">
                    <label for="sd"><i class="fa fa-calendar"></i>시작일 :</label>
                    <input type="text" class="form-control" name="date1" id="sd" value="" size="10" />
                </div>
                <div class="form-group">
                    <label for="ed"><i class="fa fa-calendar"></i>종료일 :</label>
                    <input type="text" class="form-control" name="date2" id="ed" value="" size="10" />
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-sm" onclick="document.form.submit()"><i class="fa fa-search"></i>검색</button>
                </div>
              </div>

            </div>
        </div>
        </form>
        <!-- calendar end -->

            <!-- order list start -->
            <div class="row">
              <div class="col-sm-12">
                <section class="panel">
                  <header class="panel-heading table-head">
                      개별업체 정산리스트 ( <?=number_format($total);?> 건 )
                    </header>
                    <div class="panel-body">
                      <div class="table-responsive">
                      <form class="form-inline" role="form" name="reg" method="post" action="reg_tax.php">
                      <input type="hidden" name="id" value="<?=$id;?>" />
                        <table class="table table-stiped">
                          <thead>
                            <tr>
                              <th>번호</th>
                              <th>주문일</th>
                              <th>업체명(구매자명)</th>
                              <th>품목</th>
                              <th>주문액<br />(NET)</th>
                              <th>실정산액<br />(NET)</th>
                              <th>상세내용</th>
                            </tr>
                          </thead>
                          <tbody>
                        <?php
switch ($mode) {
    case 'date':
        $sql_2 = "SELECT * FROM member, mall_order WHERE (mall_order.cancel = 'N') AND (member.id='$id') AND (mall_order.user_id='$id') AND (mall_order.status = '8' OR mall_order.status = '-1' ) AND mall_order.createdate BETWEEN  '$date1' AND '$date2' ORDER BY mall_order.num DESC ";
        break;
    default:
        $sql_2 = "SELECT * FROM member, mall_order WHERE (mall_order.cancel = 'N') AND (member.id='$id') AND (mall_order.user_id='$id') AND (mall_order.status = '8' OR mall_order.status = '-1' ) ORDER BY mall_order.num DESC ";
}

$result_2 = mysqli_query($connect, $sql_2);
$total_2  = mysqli_num_rows($result_2);

if ($total_2 == 0) {
    ?>
                            <tr>
                              <td colspan="7"><p>정산할 내역이 없습니다.</p></td>
                            </tr>
                                      <?php
} else {

    for ($i = 0; $list = mysqli_fetch_array($result_2); $i++) {

        $or_sql = "SELECT * FROM mall_order WHERE num = '$list[num]' ";
        $or_res = mysqli_query($connect, $or_sql);
        $or_row = mysqli_fetch_array($or_res);

        $a_goods_fk = explode(",", $or_row['goods_fk']);

        $pro_sql    = "SELECT * FROM products WHERE num='$a_goods_fk[0]'";
        $pro_result = mysqli_query($connect, $pro_sql);
        $pro_row    = mysqli_fetch_array($pro_result);

        //$goods_name= shortenStr($pro_row['name'],30);
        $goods_name = cut_string_utf8($pro_row['name'], 30, '...');

        $bunho = $total - ($i + $cline);

        if ($i % 2 == 0) {
            if ($or_row['status'] == "-1") {
                echo "<tr bgcolor=\"#FBAFFF\">\n";
            } else {
                echo "<tr>\n";
            }

        } else {
            if ($or_row['status'] == "-1") {
                echo "<tr bgcolor=\"#FBAFFF\">\n";
            } else {
                echo "<tr>\n";
            }

        }
        ?>

                              <td><?=$bunho;?></td>
                              <td><?=$list['createdate'];?></td>
                              <td><?=$list['company_name'] . " (" . $list['buyer_name'] . ")";?></td>
                              <td><?=$goods_name;?> (외)</td>
                              <td><?=number_format($list['amount']);?></td>
                              <td>
                            <?php
$tax_amount = $list['last_amount'];
        echo number_format($tax_amount);
        ?>
                              </td>
                              <td><a href='../order/or_view.php?oid=<?=$list['num'];?>&amp;page=<?=$page;?>&from=stats&id=<?=$id;?>'> <i class="fa fa-search-plus"></i> </a></td>
                            </tr>
                          <?php
$goods_name = $goods_name . " (외)";
        $tot_amount = $tot_amount + (int) $tax_amount;
    }
    mysqli_free_result($result_2);
    ?>
                            <tr>
                              <td colspan="5"><strong>실정산액 합계:</strong></td>
                              <td><?=number_format($tot_amount);?> (<?=number_format($tot_amount * 0.1);?>)<br>
                              (inc. VAT) <strong><?=number_format($tot_amount * 1.1);?></strong></td>
                              <td></td>
                            </tr>
                              <?php
}
?>
                          </tbody>
                        </table>

<!--                         <div class="row">
                          <div class="col-sm-offset-3 col-sm-6">
                            <div class="form-group">
                              <label for="reg_date"><i class="fa fa-calendar"></i>발행일 :</label>
                              <input type="text" class="form-control reg_date" name="reg_date" id="reg_date"  value="" />
                            </div>
                            <label for="paid">결제여부 :</label>
                            <input type="radio" name="paid" value="Y" checked /> 영수
                            <input type="radio" name="paid" value="N" /> 청구
                            <input type="hidden" name="sum" value="<?=$tot_amount;?>" />
                            <input type="hidden" name="goods_name" value="<?=$goods_name;?>" />
                            <button class="btn btn-success" href="" onclick="javascript:document.reg.submit()">발행</button>
                          </div>
                        </div>
 -->
                        </form>

                      </div>
                    </div>
                  </section>
                </div>
              </div>
              <!-- order list end -->

              <div class="row text-center">
                <div class="col-sm-12">
                  <a class="btn btn-default" href="top_stat_list.php">정산 목록</a>
                </div>
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

    <!--right slidebar-->
    <script src="/admin/js/slidebars.min.js"></script>

    <!--common script for all pages-->
    <script src="/admin/js/common-scripts.js"></script>

    <!-- custom scripts -->
    <script src="/js/global.js" ></script>
    <script src="/admin/js/admin.js" ></script>
    <script src="/admin/js/jquery-ui.min.js"></script>
    <script src="/admin/js/jq_datepicker.js" ></script>

  </body>
</html>
