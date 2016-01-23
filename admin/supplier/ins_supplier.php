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
        <!--header start-->
        <?php include "../include/admin_head.php"; ?>
        <!--header end-->

        <!--sidebar start-->
        <?php include "../include/admin_sidebar.php"; ?>
        <!--sidebar end-->

        <!--main content start-->
        <section id="main-content">
          <section class="wrapper">

            <!-- member info start -->
            <div class="row">
              <div class="col-sm-12">
                <section class="panel">
                  <header class="panel-heading table-head">
                      공급업체 등록
                  </header>
                  <div class="panel-body">

                  <form name="form1" class="form-inline" role="form" method="post" action="https://<?=$_SERVER['SERVER_NAME']?>:<?=$port?>/admin/supplier/ins_supplier_ok.php">
                  <!-- <form name="form1" class="form-inline" role="form" method="post" action="http://<?=$_SERVER['SERVER_NAME']?>/admin/supplier/ins_supplier_ok.php"> -->
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <tbody>
                        <tr>
                          <th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 업체 아이디</th>
                          <td>
                            <input type="text" class="form-control" name="id" />
                            <a type="button" href="#" class="btn btn-default btn-sm" onclick="javascript:check_ID_Window('../member/id_check.php')">중복확인</a>
                            <p class="help-block">특수문자, 한글, 공백을 포함할 수 없으며 모든 소문자를 처리됩니다.(4~10자 사이)</p>
                          </td>
                        </tr>
                        <tr>
                          <th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 비밀번호</th>
                          <td>
                            <input class="form-control" name="passwd" type="password" value="1111">
                            <p class="help-block">(초기 비밀번호는 1111 입니다.)</p>
                          </td>
                        </tr>
                        <tr>
                          <th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 담당자 성명</th>
                          <td><input class="form-control" type="text" name="md_name" /></td>
                        </tr>
                        <tr>
                          <th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 담당자 이메일</th>
                          <td>
                            <input type="text" class="form-control" name="md_email" />
                          </td>
                        </tr>
                        <tr>
                          <th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 담당자 휴대폰</th>
                          <td>
                            <select name="md_hphone1" class="form-control">
                              <option value="">선택</option>
                              <option value="010">010</option>
                              <option value="011">011</option>
                              <option value="016">016</option>
                              <option value="017">017</option>
                              <option value="018">018</option>
                              <option value="019">019</option>
                            </select>
                            -
                            <input type="text" class="form-control" name="md_hphone2" size="4" />
                            -
                            <input type="text" class="form-control" name="md_hphone3" size="4" />
                            <input type="checkbox" name="sms" value="Y" checked="checked" /> SMS 수신
                          </td>
                        </tr>
                        <tr>
                          <th colspan="2"><strong><img src="../images/order_state_mini_1.gif" width="16" height="16" /> (사업자등록증과 동일하게 작성)</strong></th>
                        </tr>
                        <tr>
                          <th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 사업자 등록번호</th>
                          <td>
                            <input type="text" class="form-control" name="license_no1" size="3" OnKeyUp="focus_move();"> -
                            <input type="text" class="form-control" name="license_no2" size="2" OnKeyUp="focus_move();"> -
                            <input type="text" class="form-control" name="license_no3" size="5" >
                          </td>
                        </tr>
                        <tr>
                          <th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 업체명</th>
                          <td><input type="text" class="form-control" name="company_name" /></td>
                        </tr>
                        <tr>
                          <th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 대표자 성명</th>
                          <td>
                            <input type="text" class="form-control" name="ceo" size="10"  />
                          </td>
                        </tr>
                        <tr>
                          <th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 사업장 우편번호</th>
                          <td>
                            <input type="text" class="form-control" name="o_zipcode1" id="o_zipcode1" size="3"  value="<?=$o_zipno[0]?>" readonly />
                            <input type="text" class="form-control" name="o_zipcode2" id="o_zipcode2" size="3"  value="<?=$o_zipno[1]?>" readonly />
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
                          <th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 사업장 소재지</th>
                          <td>
                            <input type="text" class="form-control" name="o_addr1" id="o_addr1" size="50" readonly />
                            <input type="text" class="form-control" name="o_addr2" id="o_addr2" size="50" />
                          </td>
                        </tr>
                        <tr>
                          <th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 업태</th>
                          <td>
                            <input type="text" class="form-control" name="category1" />
                          </td>
                        </tr>
                        <tr>
                          <th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 종목</th>
                          <td>
                            <input type="text" class="form-control" name="category2" />
                          </td>
                        </tr>
                        <tr>
                          <th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 사업장 전화번호</th>
                          <td>
                            <input type="text" class="form-control" name="o_phone1" size="3"  /> -
                            <input type="text" class="form-control" name="o_phone2" size="4"  /> -
                            <input type="text" class="form-control" name="o_phone3" size="4"  />
                          </td>
                        </tr>
                        <tr>
                          <th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 사업장 팩스</th>
                          <td>
                            <input type="text" class="form-control" name="o_fax1" size="3" /> -
                            <input type="text" class="form-control" name="o_fax2" size="4" /> -
                            <input type="text" class="form-control" name="o_fax3" size="4" />
                          </td>
                        </tr>
                        <tr>
                          <th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 홈페이지</th>
                          <td>
                            http://<input type="text" class="form-control" name="homepage" size="35" />
                          </td>
                        </tr>
                        <tr>
                          <th colspan="2">
                            <strong><img src="../images/order_state_mini_1.gif" alt="" width="16" height="16" /> 반품 주소 정보  (
                              <input type="checkbox" name="same_info" onClick="useSameAddr();" >
                            사업장 소재지와 동일한 경우 체크)</strong>
                          </th>
                        </tr>
                        <tr>
                          <th> <img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 우편번호</th>
                          <td>
                            <input type="text" class="form-control" name="d_zipcode1" id="d_zipcode1" size="3" value="<?=$d_zipno[0]?>" readonly /> -
                            <input type="text" class="form-control" name="d_zipcode2" id="d_zipcode2" size="3"   value="<?=$d_zipno[1]?>" readonly />
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
                          <th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 주소</th>
                          <td>
                            <input type="text" class="form-control" name="d_addr1" id="d_addr1" size="50" readonly />
                            <input type="text" class="form-control" name="d_addr2" id="d_addr2" size="50" />
                          </td>
                        </tr>
                        <tr>
                          <th> <img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 전화번호</th>
                          <td>
                            <input type="text" class="form-control" name="d_phone1" size="4"  /> -
                            <input type="text" class="form-control" name="d_phone2" size="4"  /> -
                            <input type="text" class="form-control" name="d_phone3" size="4"  />
                          </td>
                        </tr>
                        <tr>
                          <th> <img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 팩스</th>
                          <td>
                            <input type="text" class="form-control" name="d_fax1" size="4"  /> -
                            <input type="text" class="form-control" name="d_fax2" size="4"  /> -
                            <input type="text" class="form-control" name="d_fax3" size="4"  />
                          </td>
                        </tr>
                        <tr>
                          <th colspan="2"><strong><img src="../images/order_state_mini_1.gif" width="16" height="16" /> 거래 형태</strong></th>
                        </tr>
                        <tr>
                          <th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 기본 거래형태</th>
                          <td>
                            <input type="radio" name="seller" value="1" />
                            입고배송 위탁거래
                            <input type="radio" name="seller" value="2"  checked="checked"/>
                            사입 거래
                          </td>
                        </tr>
                        <tr>
                          <th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 기본 할인율</th>
                          <td>
                            <input type="text" class="form-control" name="margin" size="3"/> %
                            <input type="radio" name="tax" value="E" /> (VAT 별도)
                            <input type="radio" name="tax" value="I" checked="checked" /> (VAT 포함)
                          </td>
                        </tr>
                        <tr>
                          <th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 결제일</th>
                          <td>
                            <select name="payment_day" class="form-control">
                              <option value="1">당일 결제 </option>
                              <option value="2" selected="selected">당월 말</option>
                              <option value="3">익월 5일</option>
                              <option value="4">익월 10일</option>
                              <option value="5">익월 15일</option>
                              <option value="6">익월 20일</option>
                              <option value="7">익월 25일</option>
                              <option value="8">익월 말</option>
                              <option value="9">기타</option>
                            </select>
                          </td>
                        </tr>
                        <tr>
                          <th> <img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 승인상태 </th>
                          <td>
                            <input type="radio" name="approved" value="Y" checked="checked" />
                            승인
                            <input type="radio" name="approved" value="N" />
                            미승인
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    </div>

                    <!-- buttons start -->
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="table-responsive">
                        <table class="table">
                          <tbody>
                            <tr>
                              <td class="text-center">
                                  <a class="btn btn-success" href="#" onclick="this.blur(); document.form1.submit();">등록</a>
                                  <a class="btn btn-default" href="top_supplier_list.php">취소</a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                        </div>
                      </div>
                    </div>
                    <!-- buttons end -->

                    </form>

                  </div>
                  <!-- panel body end -->
                </section>
              </div>
            </div>
            <!-- member list end -->

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

