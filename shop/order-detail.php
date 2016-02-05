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

// retrieve PG data
// $pg_sql    = "SELECT * FROM pg_info WHERE LGD_OID='$row[lgd_oid]' ";
// $pg_result = mysqli_query($connect, $pg_sql);
// $pg_row    = mysqli_fetch_array($pg_result);

// switch ($pg_row['LGD_PAYTYPE']) {
//   case 'SC0040':
//     if($pg_row['LGD_RESPCODE'] == "0000")
//       if($pg_row['LGD_CASFLAG'] == "R") {

//         $pay_status = "<img src='../images/bank--pencil.png' alt='가상계좌 할당' /> 계좌할당 : <h4>가상계좌 - ".$pg_row['LGD_ACCOUNTNUM']."</h4>\n";
//         $pay_status .= "<p>1) 가상계좌는 일회성 계좌이므로 재사용시(다시 그 계좌로 입금하시는 경우) 타인의 계좌로 입금될 가능성이 있습니다.<br />\n";
//         $pay_status .= "이 경우는 고객의 책임이므로 사용에 주의하시기 바랍니다. <br />\n";
//         $pay_status .= "2) 가상계좌의 경우 CD기에서 현금입금 하실 수 없습니다.  CD기에서 이체는 가능합니다.</p>\n";

//       }elseif($pg_row['LGD_CASFLAG'] == "I")
//         $pay_status = "<img src='../images/bank--plus.png' alt='가상계좌 입금' /> 입금완료";
//     elseif($pg_row['LGD_CASFLAG'] == "C")
//         $pay_status = "<img src='../images/bank.png' alt='가상계좌 취소' /> 입금취소";
//     else
//       $pay_status = "<img src='../images/bank--exclamation.png' alt='계좌이체 실패' /> 이체실패(".$pg_row['LGD_RESPCODE'].")";

//     break;
//   case 'SC0030':
//     if($pg_row['LGD_RESPCODE'] == "0000")
//       $pay_status = "<img src='../images/bank.png' alt='계좌이체 완료' /> 이체완료";
//     else
//       $pay_status = "<img src='../images/bank--exclamation.png' alt='계좌이체 실패' /> 이체실패(".$pg_row['LGD_RESPCODE'].")";

//     break;

//   default: //SC0010 credit card
//     if($pg_row['LGD_RESPCODE'] == "0000")
//       $pay_status = "<img src='../images/credit-card-green.png' alt='카드결제 완료' /> 결제완료";
//     else
//       $pay_status = "<img src='../images/credit-card--exclamation.png' alt='카드결제 실패' /> 결제실패(".$pg_row['LGD_RESPCODE'].")";

//     break;
// }

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