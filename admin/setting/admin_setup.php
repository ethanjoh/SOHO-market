<?php include_once '../include/header.php';?>

  <!-- <body onLoad=init();> -->
  <body>
    <section id="container" >
        <!--header start-->
        <?php include_once "../include/admin_head.php";?>
        <!--header end-->

        <!--sidebar start-->
        <?php include_once "../include/admin_sidebar.php";?>
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
                  <form class="form-inline" role="form" name="form1" action="//<?php echo $_SERVER['SERVER_NAME']; ?>:<?php echo $sslPort; ?>/admin/setting/admin_setup_ok.php" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="type" value="1" />
                  <input type="hidden" name="admin_id" value="<?php echo $rows['id']; ?>">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <tbody>
                        <tr>
                          <th>관리자 아이디</th>
                          <td><?php echo $rows['id']; ?></td>
                          <th>관리자 성명</th>
                          <td><input type="text" class="form-control" name="admin_name" value="<?php echo $rows['name']; ?>"></td>
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
                          <td><input type="text" class="form-control" name="site_name" value="<?php echo $rows['site_name']; ?>" size="50"></td>
                          <th></th>
                          <td></td>
                        </tr>
                        <tr>
                          <th>사이트 키워드</th>
                          <td colspan="3">
                            <input type="text" class="form-control width-100" name="keywords" style="width:100%" value="<?php echo $rows['keywords']; ?>" size="100">
                            <p class="help-block">(, 구분)</p>
                          </td>
                        </tr>
                        <tr>
                          <th>사이트 설명</th>
                          <td colspan="3">
                            <textarea class="form-control" name="description" style="width:100%; height:100px"><?php echo $rows['description']; ?></textarea>
                            <p class="help-block">(200자 이내)</p>
                          </td>
                        </tr>
                        <tr>
                          <th>업체명</th>
                          <td><input type="text" class="form-control" name="company_name" value="<?php echo $rows['company_name']; ?>" size="50"></td>
                          <th></th>
                          <td></td>
                        </tr>
                        <tr>
                          <th>대표자명 </th>
                          <td><input type="text" class="form-control" name="ceo" value="<?php echo $rows['ceo']; ?>"></td>
                          <th></th>
                          <td></td>
                        </tr>
                        <tr>
                          <th>회사 홈페이지</th>
                          <td>
                            <input type="text" class="form-control" name="homepage" value="<?php echo $rows['homepage']; ?>" size="50">
                            <p class="help-block">http:// 제외</p>
                          </td>
                          <th></th>
                          <td></td>
                        </tr>
                        <tr>
                          <th>관리자 이메일 </th>
                          <td><input type="text" class="form-control" name="admin_email" value="<?php echo $rows['email']; ?>" size="50"></td>
                          <th></th>
                          <td></td>
                        </tr>
                        <tr>
                          <th>개인정보 관리책임자 </th>
                          <td><input type="text" class="form-control" name="privacy_manager" value="<?php echo $rows['privacy_manager']; ?>" ></td>
                          <th></th>
                          <td></td>
                        </tr>
                        <tr>
                          <th colspan="4"><h5><i class="fa fa-cog"></i> 사업자 정보</h5></th>
                        </tr>
                        <tr>
                          <th>사업자등록번호</th>
                          <td>
                            <input type="text" class="form-control" size=3 value="<?php echo $license_no[0]; ?>" name="license_no1"> -
                            <input type="text" class="form-control" size=2 value="<?php echo $license_no[1]; ?>" name="license_no2"> -
                            <input type="text" class="form-control" size=5 value="<?php echo $license_no[2]; ?>" name="license_no3" >
                          </td>
                          <th>통신판매업 신고</th>
                          <td><input type="text" class="form-control" name="online_license" value="<?php echo $rows['online_license']; ?>" ></td>
                        </tr>
                        <tr>
                          <th>대표전화</th>
                          <td>
                            <input type="text" class="form-control" size=3 value="<?php echo $tel[0]; ?>" name="tel1"> -
                            <input type="text" class="form-control" size=4 value="<?php echo $tel[1]; ?>" name="tel2"> -
                            <input type="text" class="form-control" size=4 value="<?php echo $tel[2]; ?>" name="tel3">
                          </td>
                          <th>팩스번호</th>
                          <td>
                            <input type="text" class="form-control" size=3 value="<?php echo $fax[0]; ?>" name="fax1"> -
                            <input type="text" class="form-control" size=4 value="<?php echo $fax[1]; ?>" name="fax2"> -
                            <input type="text" class="form-control" size=4 value="<?php echo $fax[2]; ?>" name="fax3">
                          </td>
                        </tr>
                        <tr>
                          <th>업태</th>
                          <td><input type="text" class="form-control" name="category1" value="<?php echo $rows['category1']; ?>" size="50"></td>
                          <th>업종</th>
                          <td><input type="text" class="form-control" name="category2" value="<?php echo $rows['category2']; ?>" size="50"></td>
                        </tr>
                        <tr>
                          <th>우편번호</th>
                          <td>
                            <input type="text" class="form-control" size="5" value="<?php echo $zipcode[0]; ?>" name="o_zipcode1" id="o_zipcode1" readonly />
                            <input type="button" class="form-control" onclick="openDaumPostcode()" value="우편번호 찾기"><br />
                          <!-- postcode searching function -->
                          <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
                          <script>
                              function openDaumPostcode() {
                                  new daum.Postcode({
                                      oncomplete: function(data) {
                                          // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                                          // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                                          // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                                          var fullAddr = ''; // 최종 주소 변수
                                          var extraAddr = ''; // 조합형 주소 변수

                                          // 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                                          if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                                              fullAddr = data.roadAddress;

                                          } else { // 사용자가 지번 주소를 선택했을 경우(J)
                                              fullAddr = data.jibunAddress;
                                          }

                                          // 사용자가 선택한 주소가 도로명 타입일때 조합한다.
                                          if(data.userSelectedType === 'R'){
                                              //법정동명이 있을 경우 추가한다.
                                              if(data.bname !== ''){
                                                  extraAddr += data.bname;
                                              }
                                              // 건물명이 있을 경우 추가한다.
                                              if(data.buildingName !== ''){
                                                  extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                                              }
                                              // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                                              fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
                                          }


                                          // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
                                          // 우편번호와 주소 정보를 해당 필드에 넣고, 커서를 상세주소 필드로 이동한다.
                                          // document.getElementById('o_zipcode1').value = data.postcode1;
                                          // document.getElementById('o_zipcode2').value = data.postcode2;
                                          // document.getElementById('o_addr1').value = data.address;
                                          document.getElementById('o_zipcode1').value = data.zonecode; //5자리 새우편번호 사용

                                          //전체 주소에서 연결 번지 및 ()로 묶여 있는 부가정보를 제거하고자 할 경우,
                                          //아래와 같은 정규식을 사용해도 된다. 정규식은 개발자의 목적에 맞게 수정해서 사용 가능하다.
                                          // var addr = data.address.replace(/(\s|^)\(.+\)$|\S+~\S+/g, '');
                                          // document.getElementById('o_addr1').value = addr;
                                          document.getElementById('o_addr1').value = fullAddr;

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
                          <td colspan="3"><input type="text" class="form-control" value="<?php echo $rows['addr1']; ?>" name="o_addr1" id="o_addr1" readonly size="100"></td>
                        </tr>
                        <tr>
                          <th></th>
                          <td colspan="3"><input type="text" class="form-control" value="<?php echo $rows['addr2']; ?>" name="o_addr2" id="o_addr2" size="100"></td>
                        </tr>
<!--                         <tr>
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
                        </tr> -->
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
    <?php include_once "../include/admin_footer.php";?>
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

