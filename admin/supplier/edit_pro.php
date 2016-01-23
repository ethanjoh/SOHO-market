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


    <?php
      $query = "SELECT * FROM products WHERE num='$p_num' ";
      $result = mysqli_query($connect, $query);
      $row = mysqli_fetch_array($result);
      mysqli_free_result($result);

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
                      <input type="radio" name="del_chk" value="N" <?php if(($mode=='insert') || ($row['del_chk']=='N')) echo("checked"); ?>/> 등록
                      <input type="radio" name="del_chk" value="Y" <?php if($row['del_chk']=='Y') echo("checked"); ?> /> 판매중지(숨김)
                      <input type="radio" name="del_chk" value="O" <?php if($row['del_chk']=='O') echo("checked"); ?> /> <img src="../images/out.gif" alt="품절" width="42" height="14" />
                      <input type="radio" name="del_chk" value="C" <?php if($row['del_chk']=='C') echo("checked"); ?> /> <img src="../images/cutstock.gif" width="43" height="16" alt="단종" /></td>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="2"><img src="<?=$row['b_image1_name']?>" onerror="this.src='../images/no_image100.gif'" /></td>
                  </tr>
                  <tr >
                    <th>상품명</th>
                    <td><?=$row['name']?></td>
                  </tr>
                  <tr>
                    <th>제조/공급사</th>
                    <td><?=$row['company']?></td>
                  </tr>
                  <tr>
                    <th>소비자가</th>
                    <td><?=number_format($row['retail_price'])?> 원</td>
                  </tr>
                  <tr>
                    <th>할인가</th>
                    <td><?=number_format($row['sale_price'])?> 원</td>
                  </tr>
                  <tr>
                    <th>고정공급가</th>
                    <td><?=number_format($row['fixed_price'])?> 원</td>
                  </tr>
                  <tr>
                    <th>선택사항 (바코드)</th>
                    <?php
                if($row['opt']) {
                ?>
                    <td>
                      <?php
                        $optname = explode(",", $row['opt']);
                        $optstock = explode(",", $row['opt_stock']);
                        $barcode = explode(",", $update_row['barcode']);

                        for($i=0;$i<count($optname);$i++) {
                          echo "<input class=\"form-control\" name=\"optname[]\" type=\"text\" value=\"$optname[$i]\" size=\"20\" >&nbsp;";
                          if($optstock[$i] == 1)
                            $a = "checked";
                          else
                            $a = "";

                          if($optstock[$i] == 0)
                            $b = "checked";
                          else
                            $b = "";

                          if($optstock[$i] == -1)
                            $c = "checked";
                          else
                            $c = "";


                          echo "<input name=\"optstock[$i]\" type=\"radio\" value=\"1\" $a />재고 있음&nbsp;";
                          echo "<input name=\"optstock[$i]\" type=\"radio\" value=\"0\" $b />품절&nbsp;";
                          echo "<input name=\"optstock[$i]\" type=\"radio\" value=\"-1\" $c />단종";
                          echo "<input name=\"barcode[]\" type=\"text\" value=\"$barcode[$i]\" /> (바코드)<br />";
                       }

                      ?>
                    </td>

                  <?php
              }else{
                ?>

                    <td><p>N/A</p></td>
                  </tr>
                  <?php
              }
              ?>
                  </tr>
                  <tr>
                    <th>전체 재고</th>
                    <td>
                      <input class="form-control" type="text" name="stock" value="<?=$row['stock']?>" />  개
                      <p class="help-block"> 선택사항이 있을 경우 각 옵션재고를 합한 전체 재고를 입력하세요.</p>
                    </td>
                  </tr>
                  <tr>
                    <th>검색어</th>
                    <td>
                      <input class="form-control" type="text" name="tag" value="<?=$row['tag']?>" />
                      <p class="help-control"> , 로 구분하세요</p>
                    </td>
                  </tr>
                </table>

                <div class="row text-center">
                  <div class="col-sm-12">
                    <input type="hidden" name="oid" value="<?=$oid?>" />
                    <input type="hidden" name="id" value="<?=$id?>" />
                    <input type="hidden" name="from" value="<?=$from?>" />
                    <input type="hidden" name="p_num" value="<?=$p_num?>" />
                    <input type="hidden" name="lcode" value="<?=$lcode?>" />
                    <input type="hidden" name="mcode" value="<?=$mcode?>" />
                    <input type="hidden" name="scode" value="<?=$scode?>" />
                <?php
                  if($from == "pre_offer") {
                  ?>
                    <a type="button" class="btn btn-primary" href="#" onclick="javescript:send_edit();">수정</a>
                    <a type="button" class="btn btn-default" href="#" onclick="opener.location.replace('pre_offer.php?id=<?=$id?>');window.close();">닫기</a>
                        <?php
                  }else {
                  ?>
                    <a type="button" class="btn btn-primary" href="#" onclick="javescript:send_edit();">수정</a>
                    <a type="button" class="btn btn-default" href="#" onclick="opener.location.replace('view_offer.php?oid=<?=$oid?>');window.close();">닫기</a>

                        <?php 
                  }
                  ?>

                  </div>
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
    <script src="/js/jquery-2.1.1.min.js"></script>
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
