<?php include_once '../include/header.php'; ?>

  <body>
    <section id="container" >
        <!--header start-->
        <?php include_once "../include/admin_head.php"; ?>
        <!--header end-->

        <!--sidebar start-->
        <?php include_once "../include/admin_sidebar.php"; ?>
        <!--sidebar end-->

    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">

<?php

  $mode = set_var($_GET['mode']);
  $id = set_var($_GET['id']);
  $date1 = set_var($_GET['date1']);
  $date2 = set_var($_GET['date2']);
  $page = set_var($_GET['page']);

        if('search' = $mode){
            $search_query = " AND createdate BETWEEN  '$date1' AND '$date2' ";
        }

        //회원 테이블의 리스트를 불러옵니다.
        //$query = "SELECT * FROM member WHERE 1 $search_query ";
        $query = "SELECT orderid FROM mall_order WHERE user_id='$id' AND cancel = 'N' AND status = '8' $search_query ";
        $result = mysqli_query($connect, $query);
        $total = mysqli_num_rows($result);

        ?>

            <!-- calendar start -->
            <form name="form" method="get" action="mem_stat_list.php" class="form-inline form-group" role="form">
            <input type="hidden" name="mode" value="search" />
            <input type="hidden" name="id" value="<?php echo $id?>" />
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
                        <button class="btn btn-primary btn-sm" type="submit" ><i class="fa fa-search"></i>검색</button>
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
                      개별업체 정산리스트 ( <?php echo number_format($total)?> 건 )
                    </header>
                    <div class="panel-body">
                      <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <tr>
                              <th>번호</th>
                              <th>주문일</th>
                              <th>업체명</th>
                              <th>사업자등록번호</th>
                              <th>주문액</th>
                              <th>실정산액</th>
                              <th>상세내용</th>
                            </tr>
                          </thead>
                          <tbody>
<?php

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
                            }else {
                              $cline = ($cpage*$scale) - $scale ;
                            }

                            $limit=$cline+$scale;

                            if ($limit >= $total) {
                              $limit=$total;
                            }

                            $scale1 = $limit - $cline;

                            $sql_2 = "SELECT * FROM member, mall_order
                                    WHERE (member.id='$id')
                                	  AND (mall_order.cancel = 'N')
                                	  AND (mall_order.user_id='$id')
                                	  AND (mall_order.status = '8' )
                                	  ORDER BY mall_order.num DESC LIMIT $cline, $scale1";

                            $result_2 = mysqli_query($connect, $sql_2);

                            for($i=1; $list = mysqli_fetch_array($result_2); $i++){

                              $bunho = $total - ( $i + $cline) + 1;
                          ?>
                            <tr>
                              <td><?php echo $bunho?></td>
                              <td><?php echo $list['createdate']?></td>
                              <td><?php echo $list['company_name']?></td>
                              <td><?php echo $list['license_no']?></td>
                              <td><?php echo number_format($list['amount'])?> 원</td>
                              <td><?php echo number_format($list['last_amount'])?> 원</td>
                              <td><a href='../order/or_view.php?oid=<?php echo $list['num']?>&amp;page=<?php echo $page?>'> <img src="../images/details.gif" alt="주문내역 보기" /> </a></td>
                            </tr>

<?php

                          		$tot_amount = $tot_amount + (int)$list['last_amount'];
                          	} // end of for loop
                              mysqli_free_result($result_2);
                            ?>
                            <tr>
                              <td colspan="5">실정산액 합계:</td>
                              <td><?php echo number_format($tot_amount)?> 원</td>
                              <td></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </section>
                </div>
              </div>
              <!-- order list end -->


              <!-- page navigation start -->
              <div class="row text-center">
                <div class="col-sm-12">
                      <table class="table">
                        <tbody>
                          <tr>
                            <td>
<?php

                                  $url = $_SETVER['PHP_SELF']."?id=".$id."&mode=".$mode".&license_no=".$license_no."&company_name=".$company_name;
                                  page_nav($totalpage,$cpage,$url);
                               ?>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                </div>
              </div>
              <!-- page navigation end -->

              <div class="row text-center">
                <div class="col-sm-12">
                  <a class="btn btn-default" href="../stats/top_stat_list.php">업체 목록</a>
                </div>
              </div>

           </section>
      </section>
      <!--main content end-->

      <!--footer start-->
    <?php include_once "../include/admin_footer.php"; ?>
      <!--footer end-->

    <script src="/admin/js/jquery-ui.min.js"></script>
    <script src="/admin/js/jq_datepicker.js" ></script>

  </body>
</html>
