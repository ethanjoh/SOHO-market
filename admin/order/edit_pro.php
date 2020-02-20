<?php include_once '../include/header.php';?>


  <body>
    <section id="container" >


<?php

$oid   = set_var($_GET['oid']);
$p_num = set_var($_GET['p_num']);
$lcode = set_var($_GET['lcode']);
$mcode = set_var($_GET['mcode']);

$query  = "SELECT * FROM products WHERE num='$p_num' ";
$result = mysqli_query($connect, $query);
$row    = mysqli_fetch_array($result);

?>

        <!-- product info start -->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading table-head">
                  상품등록 관리
              </header>
              <div class="panel-body">

                <form class="form-inline" role="form" name="form1" action="edit_pro_ok.php" method="post">
                <div class="table-responsive">
                <table class="table table-striped">
                  <tr>
                    <td colspan="2">
                      <input type="radio" name="del_chk" value="N" <?php if (($mode == 'insert') || ($row['del_chk'] == 'N')) {
    echo ("checked");
}
?>/> 등록
                      <input type="radio" name="del_chk" value="Y" <?php if ($row['del_chk'] == 'Y') {
    echo ("checked");
}
?> /> 판매중지(숨김)
                      <input type="radio" name="del_chk" value="O" <?php if ($row['del_chk'] == 'O') {
    echo ("checked");
}
?> /> <span class="label label-warning">일시품절</span>
                      <input type="radio" name="del_chk" value="C" <?php if ($row['del_chk'] == 'C') {
    echo ("checked");
}
?> /> <span class="label label-danger">단 종</span></td>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2" class="text-center"><img src="<?php echo $row['b_image1_name']; ?>" onerror="this.src='../images/no_image100.gif'" /></td>
                  </tr>
                  <tr >
                    <th width="20%">상품명</th>
                    <td><?php echo $row['name']; ?></td>
                  </tr>
                  <tr>
                    <th>제조/공급사</th>
                    <td><?php echo $row['company']; ?></td>
                  </tr>
                  <tr>
                    <th>소비자가</th>
                    <td><?php echo number_format($row['shop_price']); ?> 원</td>
                  </tr>
                  <tr>
                    <th>공급가</th>
                    <td><?php echo number_format($row['retail_price']); ?> 원</td>
                  </tr>
                  <tr>
                    <th>옵션</th>
<?php

if (isset($row['opt'])) {
    ?>
                    <td>
<?php

    $optname  = explode(",", $row['opt']);
    $optcount = explode(",", $row['opt_count']);
    $optstock = explode(",", $row['opt_stock']);

    for ($i = 0; $i < sizeof($optname); $i++) {
        echo '<input class="form-control" name="optname[]" type="text" value="' . $optname[$i] . '" size="30" > ' . "\r\n";

        if ($optstock[$i] == 1) {
            $a = "checked";
        } else {
            $a = "";
        }

        if ($optstock[$i] == 0) {
            $b = "checked";
        } else {
            $b = "";
        }

        if ($optstock[$i] == -1) {
            $c = "checked";
        } else {
            $c = "";
        }

        echo '<input class="form-control" name="optcount[]" type="text" value="' . $optcount[$i] . '" size="5" > ' . "\r\n";
        echo '<input name="optstock[' . $i . '] " type="radio" value="1" ' . $a . ' />재고 있음 ' . "\r\n";
        echo '<input name="optstock[' . $i . '] " type="radio" value="0" ' . $b . ' />품절 ' . "\r\n";
        echo '<input name="optstock[' . $i . '] " type="radio" value="-1" ' . $c . ' />단종' . "\r\n";
    }

    ?>
                    </td>

<?php

} else {
    ?>

                    <td><p>N/A</p></td>
                  </tr>
<?php

}
?>
                  </tr>
                </table>


                  <div class="col - sm - 12text - center">
                    <input type="hidden" name="oid" value=" <  ? phpecho $oid;?>" />
                    <input type="hidden" name="id" value="<?php echo $id; ?>" />
                    <input type="hidden" name="from" value="<?php echo $from; ?>" />
                    <input type="hidden" name="p_num" value="<?php echo $p_num; ?>" />
                    <input type="hidden" name="lcode" value="<?php echo $lcode; ?>" />
                    <input type="hidden" name="mcode" value="<?php echo $mcode; ?>" />
                    <a type="button" class="btn btn-primary" href="#" onclick="javescript:send_edit();">수정</a>
                    <a type="button" class="btn btn-default" href="#" onclick="opener.location.replace('or_view.php?oid=<?php echo $oid; ?>');window.close();">닫기</a>
                  </div>

              </div>
              </form>
            </div>
            <!-- panel body end -->
          </section>
        </div>
      </div>
      <!-- product list end -->

  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="/js/vendor/jquery-2.2.0.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
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
