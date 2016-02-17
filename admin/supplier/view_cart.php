<?php

include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

//메타정보
$info_query = "SELECT * FROM admin_setup";
$info_res   = mysqli_query($connect, $info_query);
$info       = mysqli_fetch_array($info_res);

$id = set_var($_GET['id']);
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

      <div class="row">
        <div class="col-sm-12">
          <section class="panel">
            <header class="panel-heading table-head">
                발주 내역
            </header>
            <div class="panel-body">

              <form name="basket" class="form-group" role="form" method="post" action="register_offer.php">
              <input type="hidden" name="id" value="<?=$id;?>" />
              <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th colspan="2">상품명</th>
                    <th>옵션</th>
                    <th>발주수량</th>
                    <th>입고가</th>
                    <th>소계</th>
                    <th>삭제</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
$query = "SELECT * FROM products p, offer_cart c
                	          			WHERE c.user_id='$id'
                			  			AND p.num=c.product_code
                			   			ORDER BY c.cart_id DESC ";

$result      = mysqli_query($connect, $query);
$total_count = mysqli_num_rows($result);

$tot_money = 0;
$tot_mny1  = 0;

if (!$total_count) {
    ?>
                  <tr>
                    <td colspan="7"><p>등록된 발주 상품이 없습니다.</p></td>
                  </tr>
                </tbody>
              </table>
              </div>
            </div>
            <!-- panel body end -->
          </section>
        </div>
      </div>
      <!-- cart list end -->

      <div class="row text-center">
        <div class="col-sm-12">
          <a type="button" class="btn btn-default" href="#" onclick="javascript:window.close();">닫 기</a>
        </div>
      </div>

                  <?php
} else {
    $sub_tot = 0;

    for ($i = 1; $row = mysqli_fetch_array($result); $i++) {
        $s_tot     = (int) $row['volume'] * (int) $row['amount'];
        $tot_money = $tot_money + $s_tot;
        ?>
                  <tr>
                    <td><img src="<?=$row['s_image_name'];?>" width="50" height="50" border="0" onerror="this.src='../images/noimage.gif'" alt="product image" /></td>
                    <td><?=stripslashes($row['name']);?><br />
                      <?php
if ($row['barcode']) {
            echo "[ " . $row['barcode'] . " ]";
        }

        ?>
                    </td>
                    <td><?=$row['p_opt'];?></td>
                    <td align="center"><?=$row['volume'];?></td>
                    <td><?=number_format($row['amount']);?> 원</td>
                    <td><?=number_format($s_tot);?> 원</td>
                    <td>
                      <a type="button" class="btn btn-danger"href="update_cart.php?id=<?=$id;?>&amp;mode=del&amp;from=basket&amp;cart_id=<?=$row['cart_id'];?>"><i class="fa fa-trash-o"></i></a>
                    </td>
                    <input type="hidden" name="products_fk[]" value="<?=$row['num'];?>">
                    <input type="hidden" name="products_name[]" value="<?=$row['name'];?>">
                    <input type="hidden" name="products_kind[]" value="<?=$row['p_opt'];?>">
                    <input type="hidden" name="products_count[]" value="<?=$row['volume'];?>">
                    <input type="hidden" name="products_price[]" value="<?=$row['amount'];?>">
                    <input type="hidden" name="products_barcode[]" value="<?=$row['barcode'];?>">

                      <?php
$sub_tot = $sub_tot + $s_tot;
    }
    ; // end of for loop
    ?>
                  </tr>
                  <tr>
                    <td colspan="7">
                      <strong>총  발주금액 : <?=number_format($tot_money);?> 원 (VAT 포함) </strong>
                    </td>
                  </tr>
                  <tr>
                    <td>메모</td>
                    <td colspan="6">
                      <textarea name="offer_memo" style="width:100%; height:150px;"></textarea>
                    </td>
                  </tr>
                </tbody>
              </table>
              </div>
              <input type="hidden" name="amount" value="<?=$sub_tot;?>">
            </div>
            <!-- panel body end -->
          </section>
        </div>
      </div>
      <!-- cart list end -->

      <!-- function buttons start -->
      <div class="row text-center">
        <div class="col-sm-12">
          <button  class="btn btn-success" href="" onclick="javascript:document.basket.submit();">발주 등록</button>
          <button  class="btn btn-default" href="" onclick="window.close();">취소</button>
        </div>
      </div>
      <!-- function buttons end -->

            </form>
                    <?php
}
; //end of else
?>

        </section>
    </section>
    <!--main content end-->

  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="/js/vendor/jquery-2.2.0.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="/admin/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="/admin/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="/admin/js/respond.min.js" ></script>

    <!--common script for all pages-->
    <script src="/admin/js/common-scripts.js"></script>

    <!-- custom scripts -->
    <script src="/js/global.js" ></script>
    <script src="/admin/js/admin.js" ></script>

</body>
</html>
