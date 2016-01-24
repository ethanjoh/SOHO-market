<?php

//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
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
    <link href="/admin/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
    <link rel="stylesheet" href="/admin/css/owl.carousel.css" type="text/css">

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

        <!--main content start-->
        <!-- <section id="main-content"> -->
          <!-- <section class="wrapper"> -->
      <?php
$num  = set_var($_GET['num']);
$page = set_var($_GET['page']);

$query  = "SELECT * FROM supplier WHERE seq_num=$num ";
$result = mysqli_query($connect, $query);
$rows   = mysqli_fetch_array($result);

$md_hphone  = explode("-", $rows['md_hphone']);
$o_zipno    = explode("-", $rows['o_zipcode']);
$o_phone    = explode("-", $rows['o_phone']);
$o_fax      = explode("-", $rows['o_fax']);
$d_zipno    = explode("-", $rows['d_zipcode']);
$d_phone    = explode("-", $rows['d_phone']);
$d_fax      = explode("-", $rows['d_fax']);
$license_no = explode("-", $rows['license_no']);
?>

      <!-- member info start -->
      <div class="row">
        <div class="col-sm-12">
          <section class="panel">
            <header class="panel-heading table-head">
                업체 정보수정/관리
            </header>
            <div class="panel-body">
              <form name="form1" role="form" class="form-inline" method="post" action="https://<?=$_SERVER['SERVER_NAME'];?>:<?=$port;?>/admin/supplier/edit_supplier.php">
              <!-- <form role="form" class="form-inline" name="form1" method="post" action="http://<?=$_SERVER['SERVER_NAME'];?>/admin/supplier/edit_supplier.php"> -->
                <input type="hidden" name="num" value="<?=$num;?>">
                <input type="hidden" name="page" value="<?=$page;?>">
                <div class="table-responsive">
                <table class="table table-striped">
                  <tbody>
                    <tr>
                      <th>아이디</th>
                      <td><?=$rows['id'];?> (변경 불가)</td>
                    </tr>
                    <tr>
                      <th>비밀번호 변경</th>
                      <td>
                        <input type="password" class="form-control" name="passwd2" />
                        <p class="help-block"><input type="checkbox" name="changePw" /> 비밀번호 변경 시에만 체크</p>
                      </td>
                    </tr>
                    <tr>
                      <th>담당자 성명 (직함)</th>
                      <td>
                        <div class="form-group">
                          <input type="text" class="form-control" name="md_name" value="<?=$rows['md_name'];?>" />
                          <input type="text" class="form-control" name="job_title" value="<?=$rows['job_title'];?>" />
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <th>담당자 이메일</th>
                      <td>
                        <input type="text" class="form-control" name="md_email" size="25" value='<?=$rows['md_email'];?>' />
                      </td>
                    </tr>
                    <tr>
                      <th>담당자 휴대폰</th>
                      <td>
                        <select name="md_hphone1" class="form-control" />
                          <option value="">선택</option>
                          <option value="010" <?php if ($md_hphone[0] == '010') {
    echo "selected";
}
?>>010</option>
                          <option value="011" <?php if ($md_hphone[0] == '011') {
    echo "selected";
}
?>>011</option>
                          <option value="016" <?php if ($md_hphone[0] == '016') {
    echo "selected";
}
?>>016</option>
                          <option value="017" <?php if ($md_hphone[0] == '017') {
    echo "selected";
}
?>>017</option>
                          <option value="018" <?php if ($md_hphone[0] == '018') {
    echo "selected";
}
?>>018</option>
                          <option value="019" <?php if ($md_hphone[0] == '019') {
    echo "selected";
}
?>>019</option>
                        </select>
                        -
                        <input type="text" class="form-control" name="md_hphone2" size="4"  value="<?=$md_hphone[1];?>" />
                        -
                        <input type="text" class="form-control" name="md_hphone3" size="4"  value="<?=$md_hphone[2];?>" />
                      </td>
                    </tr>
                    <tr>
                      <th>사업자등록번호</th>
                      <td>
                          <input type="text" class="form-control" name="license_no1" size="3" value="<?=$license_no[0];?>"> -
                          <input type="text" class="form-control" name="license_no2" size="2" value="<?=$license_no[1];?>"> -
                          <input type="text" class="form-control" name="license_no3" size="5" value="<?=$license_no[2];?>">
                      </td>
                    </tr>
                    <tr>
                      <th>상 호(법인명)</th>
                      <td>
                        <input type="text" class="form-control" name="company_name" size="25" value="<?=stripslashes($rows['company_name']);?>" />
                      </td>
                    </tr>
                    <tr>
                      <th>대표 성명</th>
                      <td>
                        <input type="text" class="form-control" name="ceo" size="10" value='<?=$rows['ceo'];?>' />
                      </td>
                    </tr>
                    <tr>
                      <th>사업장 우편번호</th>
                      <td>
                        <input type="text" class="form-control" name="o_zipcode1" id="o_zipcode1" size="3"  value="<?=$o_zipno[0];?>" readonly />
                        <input type="text" class="form-control" name="o_zipcode2" id="o_zipcode2" size="3"  value="<?=$o_zipno[1];?>" readonly />
                        <input type="button" class="form-control" onclick="openDaumPostcode()" value="우편번호 찾기"><br />
                        <script src="http://dmaps.daum.net/map_js_init/postcode.js"></script>
                        <script>
                            function openDaumPostcode() {
                                new daum.Postcode({
                                    oncomplete: function(data) {
                                        // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
                                        // 우편번호와 주소 정보를 해당 필드에 넣고, 커서를 상세주소 필드로 이동한다.
                                        document.getElementById('o_zipcode1').value = data.postcode1;
                                        document.getElementById('o_zipcode2').value = data.postcode2;
                                        // document.getElementById('o_addr1').value = data.address;

                                        //전체 주소에서 연결 번지 및 ()로 묶여 있는 부가정보를 제거하고자 할 경우,
                                        //아래와 같은 정규식을 사용해도 된다. 정규식은 개발자의 목적에 맞게 수정해서 사용 가능하다.
                                        var addr = data.address.replace(/(\s|^)\(.+\)$|\S+~\S+/g, '');
                                        document.getElementById('o_addr1').value = addr;

                                        document.getElementById('o_addr2').focus();
                                    }
                                }).open();
                            }
                        </script>
                      </td>
                    </tr>
                    <tr>
                      <th rowspan="2">사업장 소재지</th>
                      <td>
                        <input type="text" class="form-control" name="o_addr1" id="o_addr1" size="50" value='<?=$rows['o_addr1'];?>' readonly /></td>
                    </tr>
                    <tr>
                      <td><input type="text" class="form-control" name="o_addr2" id="o_addr2" size="50" value='<?=$rows['o_addr2'];?>' /></td>
                    </tr>
                    <tr>
                      <th>업태</th>
                      <td><input type="text" class="form-control" name="category1" size="25" value='<?=$rows['category1'];?>' /></td>
                    </tr>
                    <tr>
                      <th>종목</th>
                      <td><input type="text" class="form-control" name="category2" size="25" value='<?=$rows['category2'];?>' /></td>
                    </tr>
                    <tr>
                    <th>과세여부</th>
                      <td>
                        <?php
switch ($rows['tax_type']) {
    case "I":$chk1 = "checked=\"checked\"";
        break;
    case "G":$chk2 = "checked=\"checked\"";
        break;
}
?>
                      <input type="radio" class="form-control" name="tax_type" value="1" <?=$chk1;?> />일반과세자 <input type="radio" class="form-control" name="tax_type" value="2" <?=$chk2;?> />간이과세자</td>
                    </tr>
                    <tr>
                      <th>사업장 전화번호</th>
                      <td>
                        <label class="form-inline">
                          <input type="text" class="form-control" name="o_phone1" size="3"  value="<?=$o_phone[0];?>"  /> -
                          <input type="text" class="form-control" name="o_phone2" size="4"  value="<?=$o_phone[1];?>"  /> -
                          <input type="text" class="form-control" name="o_phone3" size="4"  value="<?=$o_phone[2];?>"  />
                        </label>
                      </td>
                    </tr>
                    <tr>
                      <th>사업장 팩스</th>
                      <td>
                        <input type="text" class="form-control" name="o_fax1" size="3" value="<?=$o_fax[0];?>" /> -
                        <input type="text" class="form-control" name="o_fax2" size="4" value="<?=$o_fax[1];?>" /> -
                        <input type="text" class="form-control" name="o_fax3" size="4" value="<?=$o_fax[2];?>" />
                      </td>
                    </tr>
                    <tr>
                      <th>홈페이지</th>
                      <td>
                        http:// <input type="text" class="form-control" name="homepage" size="30" value='<?=$rows['homepage'];?>' />
                        <?=$rows['homepage'] ? "&nbsp;&nbsp;<a href=\"http://$rows[homepage]\" target=\"_blank\"><img src=\"../images/browser_explorer.png\" alt=\"홈페이지 가기\" /></a>" : "";?>
                      </td>
                    </tr>
                    <tr>
                      <th colspan="2">배송지 정보
                        <input type="checkbox" name="same_info" onClick="useSameAddr();" >
                        사업장 소재지와 동일. 사무실과 물류창고 주소가 다른 경우 입력.)</th>
                    </tr>
                    <tr>
                      <th>배송지 우편번호</th>
                      <td>
                        <input type="text" class="form-control" name="d_zipcode1" id="d_zipcode1" size="3" value="<?=$d_zipno[0];?>" readonly /> -
                        <input type="text" class="form-control" name="d_zipcode2" id="d_zipcode2" size="3"   value="<?=$d_zipno[1];?>" readonly />
                        <input type="button" class="form-control" onclick="openDaumPostcode1()" value="우편번호 찾기"><br />
                        <script src="http://dmaps.daum.net/map_js_init/postcode.js"></script>
                        <script>
                            function openDaumPostcode1() {
                                new daum.Postcode({
                                    oncomplete: function(data) {
                                        // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
                                        // 우편번호와 주소 정보를 해당 필드에 넣고, 커서를 상세주소 필드로 이동한다.
                                        document.getElementById('d_zipcode1').value = data.postcode1;
                                        document.getElementById('d_zipcode2').value = data.postcode2;
                                        // document.getElementById('d_addr1').value = data.address;

                                        //전체 주소에서 연결 번지 및 ()로 묶여 있는 부가정보를 제거하고자 할 경우,
                                        //아래와 같은 정규식을 사용해도 된다. 정규식은 개발자의 목적에 맞게 수정해서 사용 가능하다.
                                        var addr = data.address.replace(/(\s|^)\(.+\)$|\S+~\S+/g, '');
                                        document.getElementById('d_addr1').value = addr;

                                        document.getElementById('d_addr2').focus();
                                    }
                                }).open();
                            }
                        </script>
                      </td>
                    </tr>
                    <tr>
                      <th rowspan="2">배송지</th>
                      <td>
                        <input type="text" class="form-control" name="d_addr1" id="d_addr1" size="50" value='<?=$rows['d_addr1'];?>' readonly />
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <input type="text" class="form-control" name="d_addr2" id="d_addr2" size="50" value='<?=$rows['d_addr2'];?>' />
                      </td>
                    </tr>
                    <tr>
                      <th>배송지 전화번호</th>
                      <td>
                        <input type="text" class="form-control" name="d_phone1" size="3"  value="<?=$d_phone[0];?>" /> -
                        <input type="text" class="form-control" name="d_phone2" size="4"  value="<?=$d_phone[1];?>" />  -
                        <input type="text" class="form-control" name="d_phone3" size="4"  value="<?=$d_phone[2];?>" />
                      </td>
                    </tr>
                    <tr>
                      <th>배송지 팩스</th>
                      <td>
                        <input type="text" class="form-control" name="d_fax1" size="3" value="<?=$d_fax[0];?>" /> -
                        <input type="text" class="form-control" name="d_fax2" size="4" value="<?=$d_fax[1];?>" /> -
                        <input type="text" class="form-control" name="d_fax3" size="4" value="<?=$d_fax[2];?>" />
                      </td>
                    </tr>
                    <tr>
                      <th>거래형태</th>
                      <td>
                        <?php
switch ($rows['seller']) {
    case "1":
        echo "<input type=\"radio\" name=\"seller\" value=\"1\" checked >입고배송 위탁거래
                                    <input type=\"radio\" name=\"seller\" value=\"3\">사입 거래";
        break;
    case "2":
        echo "<input type=\"radio\" name=\"seller\" value=\"1\">입고배송 위탁거래
                                    <input type=\"radio\" name=\"seller\" value=\"3\"  checked>사입 거래";
        break;
}
?>
                      </td>
                    </tr>
                    <tr>
                      <th>기본 수수료율</th>
                      <td>
                        <input type="text" class="form-control" name="margin" value="<?=$rows['margin'];?>" size="3"/>
                        <?php
switch ($rows['tax']) {
    case "E":
        echo "<input type=\"radio\" name=\"tax\" value=\"E\" checked >(VAT 별도)
                                    <input type=\"radio\" name=\"tax\" value=\"I\">(VAT 포함)";
        break;
    case "I":
        echo "<input type=\"radio\" name=\"tax\" value=\"E\">(VAT 별도)
                                    <input type=\"radio\" name=\"tax\" value=\"I\" checked>(VAT 포함)";
        break;
}
?>
                      </td>
                    </tr>
                    <tr>
                      <th>결제일</th>
                      <td>
                        <select name="payment_day" class="form-control">
                          <option value="1" <?php echo ($rows['payment_day'] == 1) ? "selected>" : ">"; ?>당일 결제</option>
                          <option value="2" <?php echo ($rows['payment_day'] == 2) ? "selected>" : ">"; ?>당월 말</option>
                          <option value="3" <?php echo ($rows['payment_day'] == 3) ? "selected>" : ">"; ?>익월 5일</option>
                          <option value="4" <?php echo ($rows['payment_day'] == 4) ? "selected>" : ">"; ?>익월 10일</option>
                          <option value="5" <?php echo ($rows['payment_day'] == 5) ? "selected>" : ">"; ?>익월 15일</option>
                          <option value="6" <?php echo ($rows['payment_day'] == 6) ? "selected>" : ">"; ?>익월 20일</option>
                          <option value="7" <?php echo ($rows['payment_day'] == 7) ? "selected>" : ">"; ?>익월 25일</option>
                          <option value="8" <?php echo ($rows['payment_day'] == 8) ? "selected>" : ">"; ?>익월 말</option>
                          <option value="9" <?php echo ($rows['payment_day'] == 9) ? "selected>" : ">"; ?>기타</option>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <th> 승인상태 </th>
                      <td>
                        <?php
switch ($rows['approved']) {
    case "Y":
        echo "<input type=\"radio\" name=\"approved\" value=\"Y\" checked />승인
                                    <input type=\"radio\" name=\"approved\" value=\"N\" />미승인";
        break;
    case "N":
        echo "<input type=\"radio\" name=\"approved\" value=\"Y\" />승인
                                    <input type=\"radio\" name=\"approved\" value=\"N\" checked />미승인";
        break;
}
?>
                      </td>
                    </tr>
                    <tr>
                      <th>대표자 도장 이미지
                        <p>(거래명세서 발행용)</p></th>
                      <td colspan="2">
                        <?php echo ($rows['sign_image'] == 'Y') ? "<img src=\"$rows[sign_image_name]\"  alt=\"[거래명세서 발행용 도장 이미지]\" />" : "[도장 이미지를 등록해 주세요.]"; ?>
                        <p class="help-block">이미지 사이즈: 60x60px 으로 등록해 주세요.(투명 배경 GIF 이미지)</p>
                      </td>
                    </tr>
                    <tr>
                      <th>사업자용 계좌</th>
                      <td colspan="2">
                        <input type="text" class="form-control" value="<?=$rows['bank'];?>" name="bank_account" size="50" readonly />
                        <p class="help-block">예)우리은행 000-0000-0000(예금주:홍길동)</p>
                      </td>
                    </tr>

                  </tbody>
                </table>
              </div>

              <div class="row text-center">
                <div class="col-sm-12">
                  <a type="button" class="btn btn-warning" href="#" onclick="javascript:document.form1.submit();">수정</a>
                  <a type="button" class="btn btn-default" href="#" onclick="opener.location.replace('top_supplier_list.php?page=<?=$page;?>');window.close();">닫기</a>
                </div>
              </div>
            </form>
            </div>
            <!-- panel body end -->
          </section>
        </div>
      </div>
      <!-- member list end -->


          <!-- </section> -->
      <!-- </section> -->
      <!--main content end-->

  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="/js/vendor/jquery-2.2.0.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/admin/js/jquery.dcjqaccordion.2.7.js" class="include" type="text/javascript" ></script>
    <script src="/admin/js/jquery.scrollTo.min.js"></script>
    <script src="/admin/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="/admin/js/jquery.sparkline.js" type="text/javascript"></script>
    <!-- // <script src="jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script> -->
    <script src="/admin/js/owl.carousel.js" ></script>
    <script src="/admin/js/jquery.customSelect.min.js" ></script>
    <script src="/admin/js/respond.min.js" ></script>

    <!--common script for all pages-->
    <script src="/admin/js/common-scripts.js"></script>

    <!-- custom scripts -->
    <script src="/js/global.js" ></script>
    <script src="/admin/js/admin.js" ></script>

  </body>
</html>

