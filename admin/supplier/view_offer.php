<?php

//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

//메타정보
$info_query = "SELECT * FROM admin_setup";
$info_res = mysqli_query($connect, $info_query);
$info = mysqli_fetch_array($info_res);

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

    <title><?=$info['company_name']?> :: 운영업체 관리자 홈</title>

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
        <?php include "../include/admin_head.php"; ?>
        <!--header end-->

        <!--sidebar start-->
        <?php include "../include/admin_sidebar.php"; ?>
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
                <li><i class="fa fa-info-circle"></i> 입고수량 등이 바뀌었을 경우에만 [수정버튼]을 누르시고, 반드시 [입고완료] 버튼을 눌러야 정확한 금액이 저장됩니다.</li>
                <li><i class="fa fa-info-circle"></i> 입고수량 등을 확인한 후에는 반드시 [입고완료] 버튼을 눌러주세요.</li>
                <li><i class="fa fa-info-circle"></i> 입고완료 후에라도 수량 등의 변경이 가능합니다.</li>
              </ul>
            </section>
          </div>
        </div>
        <!-- info end -->

      <?php
      	$sql = "SELECT * FROM offer WHERE num = '$oid' ";
      	$res = mysqli_query($connect, $sql);
      	$row = mysqli_fetch_array($res);

      	//공급업체 정보, 수수료 가져오기
      	$sql1    = "SELECT * FROM supplier WHERE id='$row[id]' ";
      	$result1 = mysqli_query($connect, $sql1);
      	$rows2   = mysqli_fetch_array($result1);

      	$a_goods_fk  = explode(",", $row['goods_fk']);
      	$price       = explode(",", $row['goods_price']);
      	$org_volume  = explode(",", $row['goods_count']); //주문수량
      	$mod_volume  = explode(",", $row['mod_count']); //주문수량
      	$option      = explode(",", $row['goods_kind']); //옵션정보
      ?>

         <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading table-head">
                  발주 내역
              </header>
                <div class="panel-body">
                  <div class="table-responsive">
                    <form name="form" class="form-inline" role="form" action="update_offer.php" method="post">
                    <input type="hidden" name="oid" value="<?=$oid?>" />
                    <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>이미지</th>
                          <th>상품명</th>
                          <th>옵션</th>
                          <th>제조사</th>
                          <th>주문수량</th>
                          <th>입고수량</th>
                          <th>판매가</th>
                          <th>입고가</th>
                          <th>입고가합</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                      	//물건 정보를 불러옵니다.
                      	for($i=0; $i<sizeof($a_goods_fk); $i++){
                         		$pro_sql="SELECT * FROM products WHERE num='$a_goods_fk[$i]'";
                         		$pro_result = mysqli_query($connect, $pro_sql);
                         		$pro_row = mysqli_fetch_array($pro_result);

                         		$goods_name= $pro_row['name'];
                      ?>
                      <tr>
                        <td><img src="<?=$pro_row['s_image_name']?>" width="50" height="50" border="0" onerror="this.src='../images/noimage.gif'" alt="product image" /></td>
                        <td>
                          <a href="#" onclick="javascript:open_win('edit_pro.php?oid=<?=$oid?>&amp;p_num=<?=$pro_row['num']?>&amp;lcode=<?=$pro_row['category_l']?>&amp;mcode=<?=$pro_row['category_m']?>&amp;scode=<?=$pro_row['category_s']?>','nwin','scrollbars=yes,resizable=yes, width=800,height=650');">
                          <?=stripslashes($goods_name)?>
                          </a>
                        </td>
                        <td>
                          <?php
              		        if($option[$i]) echo "$option[$i]";
              		        ?>
                        </td>
                        <td><?=$pro_row['company']?></td>
                        <td><?=$org_volume[$i]?></td>
                        <td>
                          <input class="form-control" type="text" name="mod_volume[]" value="<?=$mod_volume[$i]?>" size="5" />
                          <input class="form-control" type="submit" value="수정">
                          <!-- <button class="btn btn-primary" onclick="form.submit()">수정</button> -->
                        </td>
                        <td><?=number_format($pro_row['retail_price'])?> 원</td>
                        <td><?=number_format($price[$i])?> 원</td>
                        <?php
                        		$sub_amount = (int)$mod_volume[$i] * (int)$price[$i];
                        ?>
                        <td><?=number_format($sub_amount)?> 원</td>
                      </tr>
                        <?php
                      		  $tot_amount += $sub_amount;
                      	} // end for loop
                      ?>
                      <tr>
                        <td colspan="8"><strong>총  발주금액 (VAT포함) :</td>
                        <td>
                          <?php
                            if($rows2['tax'] == 'I')
                              echo number_format($tot_amount)." 원";
                            else
                              echo number_format($tot_amount*1.1)." 원";
                                 ?>
                        </td>
                      </tr>
                      <input type="hidden" name="last_amount" value="<?=$tot_amount?>" />
                      <tr>
                        <td>메 모</td>
                        <td colspan="8"><?=nl2br($row['offer_memo'])?></td>
                      </tr>
                    </tbody>
                  </table>
                  </div>
                  </form>
                </div>
              </div>
            </section>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <div class="panel-body">
                <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <th>발주일</th>
                      <th>상 태 </th>
                      <th>입고처리</th>
                    </thead>
                    <tbody>
                      <tr>
                        <td><?=$row['createdate']?></td>
                        <td>
                        <?php
                          switch ($row['status']) {
                    				case "1" :
                    					echo "발주 미확인 상태입니다.";
                    					break;
                    				case "2" :
                    					echo "발주를 확인한 상태입니다.";
                    					break;
                    				case "3" :
                    					echo "출고된 상태입니다.(".$row['track_no'].")";
                    					break;
                    				case "4" :
                    					echo "입고완료된 상태입니다.";
                    					break;
              			     }
            			     ?>
                        </td>
                        <td>
                            <form name="offerSaveForm" method="post" action="update_cart.php">
                              <input type="hidden" name="mode" value="ok" />
                              <input type="hidden" name="from" value="view" />
                              <input type="hidden" name="oid" value="<?=$oid?>" />
                              <input type="hidden" name="last_amount" value="<?=$tot_amount?>" />
                              <i class="fa fa-check-circle"></i><a href="#" onclick="save();">입고 완료하기</a>
                            </form>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </section>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table">
            <tbody>
              <tr>
                <td>
                <?php
            			if($from == "stat") {
            				echo "<a class=\"btn btn-default\" type=\"button\" href=\"\" onclick=\"window.close()\">닫기</a>";
            			}else {
                  ?>
                      <a class="btn btn-primary" type="button" href="" onclick="open_win('barcode_order.php?oid=<?=$oid?>','nwin','scrollbars=yes,resizable=yes');">발주서 출력</a>
                      <a class="btn btn-default" type="button"href="offer_list.php">목록</a>
                      <a class="btn btn-info pull-right" type="button" href="barcode_order_toexcel.php?oid=<?=$oid?>"><i class="fa fa-file-excel-o"></i> 발주서 엑셀로 다운로드</a>
                  <?php
            			}
                  ?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

      </section>
    </section>
    <!--main content end-->

  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="/js/jquery-2.1.1.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/admin/js/jquery.dcjqaccordion.2.7.js" class="include" type="text/javascript" ></script>
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