<?php include_once '../include/header.php';?>

  <body>
    <section id="container" >

        <!--main content start-->
        <!-- <section id="main-content"> -->
          <!-- <section class="wrapper"> -->
          <?php

$num  = set_var($_GET['num']);
$page = set_var($_GET['page']);
$from = set_var($_GET['from']);

$query  = "SELECT * FROM p_member WHERE seq_num='$num' ";
$result = mysqli_query($connect, $query);
$rows   = mysqli_fetch_array($result);

$hphone   = explode("-", $rows['hphone']);
$o_phone  = explode("-", $rows['o_phone']);
$d_phone  = explode("-", $rows['d_phone']);
$d_hphone = explode("-", $rows['d_hphone']);

$protocol = check_protocol($sslPort);
?>

            <!-- member info start -->
            <div class="row">
              <div class="col-sm-12">
                <section class="panel">
                  <header class="panel-heading table-head">
                      개인회원 정보수정/관리
                  </header>
                  <div class="panel-body">
                  <form name="form1" role="form" class="form-inline" method="post" action="<?php echo $protocol; ?>//<?php echo $_SERVER['SERVER_NAME']; ?>:<?php echo $sslPort; ?>/admin/member/p_mem_edit_member.php">
                    <input type="hidden" name="num" value="<?php echo $num; ?>">
                    <input type="hidden" name="sms" value="<?php echo $rows['sms']; ?>">
                    <input type="hidden" name="page" value="<?php echo $page; ?>">
                    <div class="table-responsive">
                      <table class="table table-striped">
                        <tbody>
                          <tr>
                            <th>아이디</th>
                            <td><?php echo $rows['id']; ?> (변경 불가)</td>
                          </tr>
                          <tr>
                            <th>비밀번호 변경</th>
                            <td>
                              <input type="password" class="form-control" name="passwd2" />
                              <p class="help-block"><input type="checkbox" name="changePw" /> 비밀번호 변경 시에만 체크</p>
                            </td>
                          </tr>
                          <tr>
                            <th>성명</th>
                            <td>
                              <div class="form-group">
                                <input type="text" class="form-control" name="name" value="<?php echo $rows['name']; ?>" />
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th>이메일</th>
                            <td>
                              <input type="text" class="form-control" name="email" size="25" value='<?php echo $rows['email']; ?>' />
                              <?php
if ($rows['optin'] == "Y") {
    echo "<p class=\"help-block\">(이메일 수신 함)</p>";
} else {
    echo "<p class=\"help-block\">(이메일 미수신 함)</p>";
}

?>
                            </td>
                          </tr>
                          <tr>
                            <th>기본 주소지 우편번호</th>
                            <td>
                              <input type="text" class="form-control" name="o_zipcode1" id="o_zipcode1" size="5"  value="<?php echo $rows['o_zipcode']; ?>" readonly />
                              <input type="button" class="form-control" onclick="openDaumPostcode()" value="우편번호 찾기"><br />
                          <!-- <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script> -->
                          <script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
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

                            </td>
                          </tr>
                          <tr>
                            <th rowspan="2">기본 주소지</th>
                            <td>
                              <input type="text" class="form-control" name="o_addr1" id="o_addr1" style="width: 80%;" value='<?php echo $rows['o_addr1']; ?>' readonly /></td>
                          </tr>
                          <tr>
                            <td><input type="text" class="form-control" name="o_addr2" id="o_addr2" style="width: 80%;" value='<?php echo $rows['o_addr2']; ?>' /></td>
                          </tr>
                          <tr>
                            <th>기본 주소지 전화번호</th>
                            <td>
                              <label class="form-inline">
                                <input type="text" class="form-control" name="o_phone1" size="3"  value="<?php echo $o_phone[0]; ?>"  /> -
                                <input type="text" class="form-control" name="o_phone2" size="4"  value="<?php echo $o_phone[1]; ?>"  /> -
                                <input type="text" class="form-control" name="o_phone3" size="4"  value="<?php echo $o_phone[2]; ?>"  />
                              </label>
                            </td>
                          </tr>
                          <tr>
                            <th>휴대폰</th>
                            <td>
                              <select name="hphone1" class="form-control" />
                                <option value="">선택</option>
                                <option value="010"
                                <?php echo ($hphone[0] == '010') ? "selected" : ""; ?>>010</option>
                                <option value="011"
                                <?php echo ($hphone[0] == '011') ? "selected" : ""; ?>>011</option>
                                <option value="016"
                                <?php echo ($hphone[0] == '016') ? "selected" : ""; ?>>016</option>
                                <option value="017"
                                <?php echo ($hphone[0] == '017') ? "selected" : ""; ?>>017</option>
                                <option value="018"
                                <?php echo ($hphone[0] == '018') ? "selected" : ""; ?>>018</option>
                                <option value="019"
                                <?php echo ($hphone[0] == '019') ? "selected" : ""; ?>>019</option>
                              </select>
                              -
                              <input type="text" class="form-control" name="hphone2" size="4"  value="<?php echo $hphone[1]; ?>" />
                              -
                              <input type="text" class="form-control" name="hphone3" size="4"  value="<?php echo $hphone[2]; ?>" />
                              <?php
if ($rows['sms'] == "Y") {
    echo "<p class=\"help-block\">(SMS 수신 함)</p>";
} else {
    echo "<p class=\"help-block\">(SMS 미수신 함)</p>";
}

?>
                            </td>
                          </tr>
                          <tr>
                            <th colspan="2">배송지 정보
                              <input type="checkbox" name="same_info" onClick="useSameAddr();" >
                              기본 주소지와 동일할 경우 체크)</th>
                          </tr>
                          <tr>
                            <th>배송지 우편번호</th>
                            <td>
                              <input type="text" class="form-control" name="d_zipcode1" id="d_zipcode1" size="5" value="<?php echo $rows['d_zipcode']; ?>" readonly />
                              <input type="button" class="form-control" onclick="openDaumPostcode1()" value="우편번호 찾기"><br />
                          <!-- <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script> -->
                          <script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
                          <script>
                              function openDaumPostcode1() {
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
                                          document.getElementById('o_zipcode1').value = data.zonecode; //5자리 새우편번호 사용

                                          //전체 주소에서 연결 번지 및 ()로 묶여 있는 부가정보를 제거하고자 할 경우,
                                          //아래와 같은 정규식을 사용해도 된다. 정규식은 개발자의 목적에 맞게 수정해서 사용 가능하다.
                                          document.getElementById('o_addr1').value = fullAddr;

                                          document.getElementById('o_addr2').focus();
                                      }
                                  }).open();
                              }
                          </script>

                            </td>
                          </tr>
                          <tr>
                            <th rowspan="2">배송지</th>
                            <td>
                              <input type="text" class="form-control" name="d_addr1" id="d_addr1" style="width: 80%;" value='<?php echo $rows['d_addr1']; ?>' readonly />
                            </td>
                          </tr>
                          <tr>
                            <td>
                              <input type="text" class="form-control" name="d_addr2" id="d_addr2" style="width: 80%;" value='<?php echo $rows['d_addr2']; ?>' />
                            </td>
                          </tr>
                          <tr>
                            <th>배송지 전화번호</th>
                            <td>
                              <input type="text" class="form-control" name="d_phone1" size="3"  value="<?php echo $d_phone[0]; ?>" /> -
                              <input type="text" class="form-control" name="d_phone2" size="4"  value="<?php echo $d_phone[1]; ?>" />  -
                              <input type="text" class="form-control" name="d_phone3" size="4"  value="<?php echo $d_phone[2]; ?>" />
                            </td>
                          </tr>
                          <tr>
                            <th>배송지 팩스</th>
                            <td>
                              <input type="text" class="form-control" name="d_hphone1" size="3" value="<?php echo $d_hphone[0]; ?>" /> -
                              <input type="text" class="form-control" name="d_hphone2" size="4" value="<?php echo $d_hphone[1]; ?>" /> -
                              <input type="text" class="form-control" name="d_hphone3" size="4" value="<?php echo $d_hphone[2]; ?>" />
                            </td>
                          </tr>
                          <tr>
                            <th>기본할인율</th>
                            <td>
                              <input type="text" class="form-control" name="dc_rate" value="<?php echo $rows['dc_rate']; ?>" size="3"/> % DC
<?php

switch ($rows['tax']) {
    case "E":
        echo '<input type="radio" name="tax" value="E" checked >(VAT 별도)
                                      		<input type="radio" name="tax" value="I">(VAT 포함)';
        break;
    case "I":
        echo '<input type="radio" name="tax" value="E">(VAT 별도)
                                      		<input type="radio" name="tax" value="I" checked>(VAT 포함)';
        break;
}
?>
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
                              ( <input type="checkbox" name="sms_chk" value="Y" /> 승인 시 SMS보내기)
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>

                    <div class="row text-center">
                      <div class="col-sm-12">
                        <a type="button" class="btn btn-warning" href="#" onclick="document.form1.submit();">수정</a>
                        <a type="button" class="btn btn-danger" href="p_mem_delete_member.php?m_num=<?php echo $num; ?>&amp;from=mail" onclick="return confirm('이 회원의 모든 정보가 즉시 삭제되며 복구할 수 없습니다. \n삭제하시겠습니까?')">삭제</a>
<?php

if ($from == "mail") {
    echo '<a type="button" class="btn btn-default" href="#" onclick="opener.location.replace(\'mem_sendmail_list.php\');window.close();">닫기</a>' . "\r\n";
} else {
    echo '<a type="button" class="btn btn-default" href="#" onclick="opener.location.replace(\'p_top_member_list.php?page=' . $page . '\');window.close();">닫기</a>' . "\r\n";
}
?>
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
