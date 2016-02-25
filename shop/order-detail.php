<?php include_once '../include/header.php';?>

    <!-- HOME -->
    <div class="container">
        <div class="row text-center">
            <h1>주문 내역</h1>
        </div>
    </div>
    <!-- /.home -->

    <!-- content -->
    <div class="content">

        <!-- CONTAINER: order list -->
        <div class="container">

<?php
	$oid  = set_var($_GET['oid']);
	$page = set_var($_GET['page']);

?>

                <div class="row margin-top-30 margin-bottom-30">
                    <ul>
                      <li><i class="fa fa-info-circle"></i> 주문하신 상세 내역을 조회할 수 있습니다.</li>
                    </ul>
                </div>

                <div class="panel panel-success margin-top-10">
                    <div class="panel-heading">주문 상세내역</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table order-detail">
                                <thead>
                                    <tr>
                                        <th>이미지</th>
                                        <th>상품명</th>
                                        <th>옵  션</th>
                                        <th>주문수량</th>
                                        <!-- <th>출고수량</th> -->
                                        <th>공 급 가</th>
                                        <!-- <th>변경공급가</th> -->
                                        <th>소    계</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php show_order_item($oid);?>
                                </tbody>
                            </table>
                        </div>
                    </div> <!-- end of table-resposive -->
                </div>

                <div class="panel panel-info">
                  <div class="panel-heading">주문정보</div>
                    <div class="panel-body">
                        <?php show_buyer_detail($oid);?>
                    </div> <!-- end panel body -->
                </div> <!-- end panel -->
                <div class="row text-center">
                  <a class="btn btn-primary" href="order-list.php?page=<?php echo $page; ?>">주문 목록</a>
                </div>

        </div>
        <!-- /.container -->
    </div>
    <!-- /.content -->


<?php include_once '../include/brands.php';?>

<?php include_once '../include/footer.php';?>

    </body>
</html>