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

$sql_1       = "SELECT num FROM mall_order WHERE cancel='N' AND status='3' AND user_id <> 'guest' ";
$res_1       = mysqli_query($connect, $sql_1);
$unchk_total = mysqli_num_rows($res_1);

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

  <!-- <body onLoad=init();> -->
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

        <!-- info start -->
        <div class="row">
              <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading">
                사용방법
              </header>
              <ul class="info-body">
                <li><i class="fa fa-info-circle"></i> 비밀번호를 분실하지 않도록 주의하시기 바랍니다.</li>
                <li><i class="fa fa-info-circle"></i> 인감이미지는 배경을 투명하게 하십시오.</li>
              </ul>
            </section>
          </div>
        </div>
        <!-- info end -->


          <?php
$qry  = "SELECT * FROM admin_setup ";
$res  = mysqli_query($connect, $qry);
$rows = mysqli_fetch_array($res);

// 사업자등록번호를  "-"를 기준으로 나눕니다.
$license_no = explode("-", $rows['license_no']);
// 전화번호를 "-"를 기준으로 나눕니다.
$tel     = explode("-", $rows['tel']);
$fax     = explode("-", $rows['fax']);
$zipcode = explode("-", $rows['zipcode']);

?>

        <!-- setup start -->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading table-head">
                  <h4>관리자 정보 설정</h4>
                </header>
                <div class="panel-body">
                  <form class="form-inline" role="form" name="form1" action="https://<?=$_SERVER['SERVER_NAME'];?>:<?=$port;?>/admin/setting/admin_setup_ok.php" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="type" value="1" />
                  <input type="hidden" name="admin_id" value="<?=$rows['id'];?>">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <tbody>
                        <tr>
                          <th>관리자 아이디</th>
                          <td><?=$rows['id'];?></td>
                          <th>관리자 성명</th>
                          <td><input type="text" class="form-control" name="admin_name" value="<?=$rows['name'];?>"></td>
                        </tr>
                        <tr>
                          <th>비밀번호 변경</th>
                          <td>
                            <input type="password" class="form-control" value="" name="admin_pass1" size="50">
                            <p class="help-block"><input type="checkbox" name="changePw" /> 비밀번호 변경 시에만 체크</p>
                          </td>
                          <th></th>
                          <td></td>
                        </tr>
                        <tr>
                          <th colspan="4"><h5><i class="fa fa-cog"></i> 사이트 정보</h5></th>
                        </tr>
                        <tr>
                          <th>사이트명</th>
                          <td><input type="text" class="form-control" name="site_name" value="<?=$rows['site_name'];?>" size="50"></td>
                          <th></th>
                          <td></td>
                        </tr>
                        <tr>
                          <th>사이트 키워드</th>
                          <td colspan="3">
                            <input type="text" class="form-control width-100" name="keywords" style="width:100%" value="<?=$rows['keywords'];?>" size="100">
                            <p class="help-block">(, 구분)</p>
                          </td>
                        </tr>
                        <tr>
                          <th>사이트 설명</th>
                          <td colspan="3">
                            <textarea class="form-control" name="description" style="width:100%; height:100px"><?=$rows['description'];?></textarea>
                            <p class="help-block">(200자 이내)</p>
                          </td>
                        </tr>
                        <tr>
                          <th>업체명</th>
                          <td><input type="text" class="form-control" name="company_name" value="<?=$rows['company_name'];?>" size="50"></td>
                          <th></th>
                          <td></td>
                        </tr>
                        <tr>
                          <th>대표자명 </th>
                          <td><input type="text" class="form-control" name="ceo" value="<?=$rows['ceo'];?>"></td>
                          <th></th>
                          <td></td>
                        </tr>
                        <tr>
                          <th>회사 홈페이지</th>
                          <td>
                            <input type="text" class="form-control" name="homepage" value="<?=$rows['homepage'];?>" size="50">
                            <p class="help-block">http:// 제외</p>
                          </td>
                          <th></th>
                          <td></td>
                        </tr>
                        <tr>
                          <th>관리자 이메일 </th>
                          <td><input type="text" class="form-control" name="admin_email" value="<?=$rows['email'];?>" size="50"></td>
                          <th></th>
                          <td></td>
                        </tr>
                        <tr>
                          <th>개인정보 관리책임자 </th>
                          <td><input type="text" class="form-control" name="privacy_manager" value="<?=$rows['privacy_manager'];?>" ></td>
                          <th></th>
                          <td></td>
                        </tr>
                        <tr>
                          <th colspan="4"><h5><i class="fa fa-cog"></i> 사업자 정보</h5></th>
                        </tr>
                        <tr>
                          <th>사업자등록번호</th>
                          <td>
                            <input type="text" class="form-control" size=3 value="<?=$license_no[0];?>" name="license_no1"> -
                            <input type="text" class="form-control" size=2 value="<?=$license_no[1];?>" name="license_no2"> -
                            <input type="text" class="form-control" size=5 value="<?=$license_no[2];?>" name="license_no3" >
                          </td>
                          <th>통신판매업 신고</th>
                          <td><input type="text" class="form-control" name="online_license" value="<?=$rows['online_license'];?>" ></td>
                        </tr>
                        <tr>
                          <th>대표전화</th>
                          <td>
                            <input type="text" class="form-control" size=3 value="<?=$tel[0];?>" name="tel1"> -
                            <input type="text" class="form-control" size=4 value="<?=$tel[1];?>" name="tel2"> -
                            <input type="text" class="form-control" size=4 value="<?=$tel[2];?>" name="tel3">
                          </td>
                          <th>팩스번호</th>
                          <td>
                            <input type="text" class="form-control" size=3 value="<?=$fax[0];?>" name="fax1"> -
                            <input type="text" class="form-control" size=4 value="<?=$fax[1];?>" name="fax2"> -
                            <input type="text" class="form-control" size=4 value="<?=$fax[2];?>" name="fax3">
                          </td>
                        </tr>
                        <tr>
                          <th>업태</th>
                          <td><input type="text" class="form-control" name="category1" value="<?=$rows['category1'];?>" size="50"></td>
                          <th>업종</th>
                          <td><input type="text" class="form-control" name="category2" value="<?=$rows['category2'];?>" size="50"></td>
                        </tr>
                        <tr>
                          <th>우편번호</th>
                          <td>
                            <input type="text" class="form-control" size="3" value="<?=$zipcode[0];?>" name="o_zipcode1" id="o_zipcode1" readonly /> - <input type="text" class="form-control" size="3" value="<?=$zipcode[1];?>" name="o_zipcode2" id="o_zipcode2" readonly />
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
                            <th></th>
                            <td></td>
                          </td>
                        </tr>
                        <tr>
                          <th>사업장 주소</th>
                          <td colspan="3"><input type="text" class="form-control" value="<?=$rows['addr1'];?>" name="o_addr1" id="o_addr1" readonly size="100"></td>
                        </tr>
                        <tr>
                          <th></th>
                          <td colspan="3"><input type="text" class="form-control" value="<?=$rows['addr2'];?>" name="o_addr2" id="o_addr2" size="100"></td>
                        </tr>
                        <tr>
                          <th>인감 이미지
                            <p>(세금계산서 발행용)</p></th>
                          <td colspan="3">
                            <input type="file" name="sign_image"  />
                            &nbsp;<?php echo ($rows['sign_image'] == 'Y') ? "<img src=\"$rows[sign_image_name]\"  alt=\"[세금계산서 발행용 인감 이미지]\" />" : "[인감 이미지를 등록해 주세요.]"; ?>
                            <p class="help-block">이미지 사이즈: 60x60px 으로 등록해 주세요.(배경은 투명하게)</p>
                          </td>
                        </tr>
                        <tr>
                          <th>입금계좌</th>
                          <td colspan="3"><?php echo ($rows['bank'] != '') ? "<input type=\"text\" class=\"form-control\" value=\"" . $rows['bank'] . "\" name=\"bank_account\" size=\"50\"/>" : "<input type=\"text\" class=\"form-control\" value=\"계좌번호 입력\" name=\"bank_account\" size=\"50\"/>"; ?>
                          <p class="help-block">예)우리은행 000-0000-0000(예금주:홍길동)</p></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </section>
            </div>
          </div>
          <!-- setup end -->

          <div class="row text-center">
            <div class="col-sm-12">
              <button class="btn btn-success" onClick="document.form1.submit();">저장</button>
              <button class="btn btn-default" onClick="document.from1.reset();">취소</button>
            </div>
          </div>
                  </form>

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

    <!--common script for all pages-->
    <script src="/admin/js/common-scripts.js"></script>

    <!-- custom scripts -->
    <script src="/js/global.js" ></script>
    <script src="/admin/js/admin.js" ></script>

  </body>
</html>

