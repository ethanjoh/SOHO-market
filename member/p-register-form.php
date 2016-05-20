<?php include_once '../include/header.php';?>

<?php

$p_id   = set_var($_SESSION['p_id']);
$p_name = set_var($_SESSION['p_name']);
$mode   = set_var($_GET['mode']);
?>
				<section class="main_shop_area">
						<div class="breadcrumbs">
								<div class="container">
										<div class="row">
												<div class="col-md-12">
														<div class="container-inner">
																<ul>
																		<li class="home">
																				<a href="/">Home</a>
																				<span>
																						<i class="fa fa-angle-right"></i>
																				</span>
																		</li>
																		<li class="category3">
<?php

if ($mode == "edit") {
    echo '<strong>개인회원 정보수정</strong>';
} else {
    echo '<strong>개인회원 가입폼 작성</strong>';
}
?>
																		</li>
																</ul>
														</div>
												</div>
										</div>
								</div>
						</div> <!-- /.breadcrumbs -->


<?php
if ($mode == "edit") {

    // 이름과 아이디에 해당되는 세션이 존재하는지 확인
    if (!isset($p_id) || !isset($p_name)) {
        err_msg('로그인 정보가 없습니다. 다시 로그인해 주세요.');
        // getLoginWindow(0, $port);
    } else {
        // 회원테이블에서 정보추출
        // $qry  = "SELECT * FROM member WHERE id='$_SESSION[p_id]' ";
        $qry = "SELECT * FROM p_member WHERE id='$p_id' ";

        $res  = mysqli_query($connect, $qry);
        $rows = mysqli_fetch_array($res);

        // $hphone = explode("-",$rows['hphone']);
        // $license_no = explode("-",$rows['license_no']);
        $o_zipno = explode("-", $rows['o_zipcode']);
        // $o_phone = explode("-",$rows['o_phone']);
        // $o_fax = explode("-",$rows['o_fax']);
        $d_zipno = explode("-", $rows['d_zipcode']);
        // $d_phone = explode("-",$rows['d_phone']);
        // $d_fax = explode("-",$rows['d_fax']);
    }

}
?>

				<div class="container">
					<div class="row">

<!--
Start Edit Form =============================================================
 -->

<?php

if ($mode == "edit") {
    ?>

										<div class="panel panel-danger">
										<div class="panel-heading"><h4>비밀번호 변경</h4></div>
											<div class="panel-body">
												<form name="pw_form" id="pw_form" role="form" class="form-group" method="post" action="//<?php echo $_SERVER['SERVER_NAME']; ?>:<?php echo $sslPort; ?>/member/p-change-passwd-ok.php">
												<input type="hidden" name="session_id" value="<?php echo $p_id; ?>">
												<input type="hidden" name="session_name" value="<?php echo $p_name; ?>">

												<div class="row">
													<div class="col-xs-12 col-md-3 register-font">
														새 비밀번호
													</div>
													<div class="col-xs-12 col-md-3">
														<label class="sr-only" for="new_passwd">new_passwd</label>
														<input class="form-control" type="password" id="new_passwd" name="new_passwd" />
													</div>
												</div>

												<div class="row">
													<div class="col-xs-12 col-md-3 register-font">
														새 비밀번호 확인
													</div>
													<div class="col-xs-12 col-md-3">
														<label class="sr-only" for="new_passwd2">new_passwd2</label>
														<input class="form-control" type="password" id="new_passwd2" name="new_passwd2" />
													</div>
												</div>

										 </div><!-- /.panel-body -->
										</div><!-- /.panel -->

										<div class="row">
											<div class="col-sm-12 text-center">
												<button class="btn btn-warning" type="submit" onclick="changePwConfirm()">비밀번호 변경</button> <a class="btn btn-default" role="button" href="../shop/index.php" >취 소</a>
											</div>
										</div>
												</form>

									<form name="form1" id="form1" role="form" class="form-group" method="post" action="//<?php echo $_SERVER['SERVER_NAME']; ?>:<?php echo $sslPort; ?>/member/register-ok.php">
									<input type="hidden" name="mode" value="edit">
									<input type="hidden" name="session_id" value="<?php echo $p_id; ?>">
									<input type="hidden" name="session_name" value="<?php echo $p_name; ?>">

									<div class="panel panel-info margin-top-10">
										<div class="panel-heading"><h4>기본정보</h4></div>
											<div class="panel-body">

												<div class="row">
													<div class="col-xs-12 col-md-3 register-font">아이디</div>
													<div class="col-xs-12 col-md-3">
															<label class="sr-only" for="userid">ID</label>
															<input class="form-control" name="userid" type="text" id="userid" value="<?php echo $rows['id']; ?>" readonly />
														</div>
														<div class="col-md-6">
															<p class="text-danger">(ID는 수정불가)</p>
														</div>
												</div>

												<div class="row">
													<div class="col-xs-12 col-md-3 register-font">비밀번호</div>
													<div class="col-xs-12 col-md-3">
															<label class="sr-only" for="passwd">password</label>
															<input class="form-control" type="password" id="passwd" name="passwd" required />
													</div>
													<div class="col-md-6">
														<p class="text-info">정보 수정 시에는 기존 비밀번호 입력</p>
													</div>
												</div>

												<div class="row">
													<div class="col-xs-12 col-md-3 register-font">비밀번호 확인</div>
													<div class="col-xs-12 col-md-3">
															<label class="sr-only" for="passwd2">password2</label>
															<input class="form-control" type="password" id="passwd2" name="passwd2" required />
													</div>
												</div>

												<div class="row">
													<div class="col-xs-12 col-md-3 register-font">성명</div>
													<div class="col-xs-12 col-md-3">
														<label class="sr-only" for="name">성명</label>
														<input class="form-control" type="text" id="name" name="name" value="<?php echo $rows['name']; ?>" required />
													</div>
												</div>

												<div class="row">
													<div class="col-xs-12 col-md-3 register-font">이메일</div>
													<div class="col-xs-12 col-md-3">
														<label class="sr-only" for="md_email">이메일</label>
														<input class="form-control" type="email" id="email" name="email" value="<?php echo $rows['email']; ?>" required />
													</div>
													<div class="col-md-6">
														<input type="checkbox" name="optin" value="Y" checked="checked" /> 이메일 수신동의
													</div>
												</div>
										 </div>
											<!-- end panel-body -->
										</div>
										<!-- end panel -->




										<div class="panel panel-warning">
											<div class="panel-heading"><h4>기본주소 정보</h4></div>
												<div class="panel-body">

													<div class="row">
														<div class="col-xs-12 col-md-3 register-font">
															기본주소
														</div>
														<div class="col-xs-6 col-md-2">
															<input class="form-control" type="text" name="o_zipcode1" id="o_zipcode1" value="<?php echo $o_zipno[0]; ?>" readonly />
														</div>
														<div class="col-xs-6 col-md-2">
                                                            <button class="btn btn-primary" type="button" onclick="openDaumPostcode()">우편번호 검색</button>
														</div>
													</div>

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

													<div class="row">
														<div class="col-xs-12 col-md-3 register-font">
														</div>
														<div class="col-xs-12 col-md-4">
															<input class="form-control" type="text" name="o_addr1" id="o_addr1" value="<?php echo $rows['o_addr1']; ?>" readonly="readonly" />
														</div>
														<div class="col-xs-12 col-md-4">
															<label class="sr-only" for="o_addr2">상세주소</label>
															<input class="form-control" type="text" name="o_addr2" id="o_addr2" value="<?php echo $rows['o_addr2']; ?>" required />
														</div>
													</div>

													<div class="row">
														<div class="col-xs-12 col-md-3 register-font">
															전화번호
														</div>
														<div class="col-xs-12 col-md-3">
															<label class="sr-only" for="o_phone">전화번호</label>
															<input class="form-control" type="text" id="o_phone" name="o_phone" value="<?php echo $rows['o_phone']; ?>" required />
														</div>
													</div>

													<div class="row">
														<div class="col-xs-12 col-md-3 register-font">휴대폰</div>
														<div class="col-xs-12 col-md-3">
															<label class="sr-only" for="hphone">휴대폰</label>
															<input class="form-control" type="text" id="hphone" name="hphone" value="<?php echo $rows['hphone']; ?>" required />
														</div>
													</div>

											</div>
											<!-- end panel-body -->
										</div>
										<!-- end panel -->

										<div class="panel panel-info">
											<div class="panel-heading"><h4>배송지 정보</h4><p>(택배 주문 시 받으실 주소)</p></div>
												<div class="panel-body">

													<div class="row">
														<div class="col-xs-12 col-md-12">
																<input type="checkbox" name="same_info" onClick="usePmemberSameAddr()" > 기본주소와 동일한 경우 체크
														</div>
													</div>

												 	<div class="row">
														<div class="col-xs-12 col-md-3 register-font">
															배송지 주소
														</div>
														<div class="col-xs-6 col-md-2">
															<input class="form-control" type="text" name="d_zipcode1" id="d_zipcode1" value="<?php echo $d_zipno[0]; ?>" readonly="readonly" />
														</div>
														<div class="col-xs-6 col-md-2">
															<button class="btn btn-primary" type="button" onclick="openDaumPostcode2()">우편번호 검색</button>
														</div>
													</div>

													<!-- postcode searching function -->
													<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
													<script>
															function openDaumPostcode2() {
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
																					document.getElementById('d_zipcode1').value = data.zonecode; //5자리 새우편번호 사용

																					//전체 주소에서 연결 번지 및 ()로 묶여 있는 부가정보를 제거하고자 할 경우,
																					//아래와 같은 정규식을 사용해도 된다. 정규식은 개발자의 목적에 맞게 수정해서 사용 가능하다.
																					document.getElementById('d_addr1').value = fullAddr;
																					document.getElementById('d_addr2').focus();
																			}
																	}).open();
															}
													</script>

													<div class="row">
														<div class="col-xs-12 col-md-3 register-font">
														</div>
														<div class="col-xs-12 col-md-4">
															<input class="form-control" type="text" name="d_addr1" id="d_addr1" value="<?php echo $rows['d_addr1']; ?>" readonly="readonly" />
														</div>
														<div class="col-xs-12 col-md-4">
															<label class="sr-only" for="d_addr2">배송지 주소</label>
															<input class="form-control" type="text" name="d_addr2" id="d_addr2" value="<?php echo $rows['d_addr2']; ?>" required />
														</div>
													</div>

													<div class="row">
														<div class="col-xs-12 col-md-3 register-font">
															배송지 전화번호
														</div>
														<div class="col-sm-12 col-md-3">
															<label class="sr-only" for="d_phone">배송지 전화번호</label>
															<input class="form-control" type="text" name="d_phone" value="<?php echo $rows['d_phone']; ?>" required />
														</div>
													</div>

													<div class="row">
														<div class="col-xs-12 col-md-3 register-font">휴대폰</div>
														<div class="col-xs-12 col-md-3">
															<label class="sr-only" for="hphone">휴대폰</label>
															<input class="form-control" type="text" id="d_hphone" name="d_hphone" value="<?php echo $rows['hphone']; ?>" required />
														</div>
													</div>

											</div>
											<!-- end panel-body -->
										</div>
										<!-- end panel -->

										<div class="row">
											<div class="col-sm-12 text-center">
												<button class="btn btn-warning" type="submit" onclick="registerConfirm()">수 정</button> <a class="btn btn-default" role="button" href="../shop/index.php" >취 소</a>
											</div>
										</div>

									</form>


<?php

} else {; //end edit mode
    ?>

<!--
Start Register Form =============================================================
 -->

							<form name="form1" id="form1" role="form" class="form-group" method="post" action="//<?php echo $_SERVER['SERVER_NAME']; ?>:<?php echo $sslPort; ?>/member/p-register-ok.php">
									<div class="panel panel-info margin-top-10">
										<div class="panel-heading"><h4>기본정보</h4></div>
											<div class="panel-body">

												<div class="row">
													<div class="col-xs-12 col-md-3 register-font">아이디</div>
													<div class="col-xs-12 col-md-3">
															<label class="sr-only" for="userid">ID</label>
															<input class="form-control" name="userid" type="text" id="userid" style="ime-mode:disabled;" required />
															<p class="help-block">ID는 영문/숫자만 가능합니다.</p>
														</div>
														<div class="col-md-6">
															<span id="useridLoading"><img src="../images/indicator.gif" alt="Ajax Indicator" /></span>
															<span id="useridResult"></span>
															<input type="hidden" name="chkavailibility" value="0">
														</div>
												</div>

												<div class="row">
													<div class="col-xs-12 col-md-3 register-font">비밀번호</div>
													<div class="col-xs-12 col-md-3">
															<label class="sr-only" for="passwd">password</label>
															<input class="form-control" type="password" id="passwd" name="passwd" required />
													</div>
												</div>

												<div class="row">
													<div class="col-xs-12 col-md-3 register-font">비밀번호 확인</div>
													<div class="col-xs-12 col-md-3">
															<label class="sr-only" for="passwd2">password2</label>
															<input class="form-control" type="password" id="passwd2" name="passwd2" required />
													</div>
												</div>

												<div class="row">
													<div class="col-xs-12 col-md-3 register-font">성명</div>
													<div class="col-xs-12 col-md-3">
														<label class="sr-only" for="name">성명</label>
														<input class="form-control" type="text" id="name" name="name" required />
													</div>
												</div>

												<div class="row">
													<div class="col-xs-12 col-md-3 register-font">이메일</div>
													<div class="col-xs-12 col-md-3">
														<label class="sr-only" for="email">이메일</label>
														<input class="form-control" type="email" id="email" name="email" required />
													</div>
													<div class="col-md-6">
														<input type="checkbox" name="optin" value="Y" checked="checked" /> 이메일 수신동의
													</div>
												</div>

											</div> <!-- /.panel-body -->
										</div><!-- /.panel -->


										<div class="panel panel-info">
											<div class="panel-heading"><h4>기본주소 정보</h4> </div>
												<div class="panel-body">

														<div class="row">
														<div class="col-xs-12 col-md-3 register-font">
															기본 주소
														</div>
														<div class="col-xs-6 col-md-2">
															<input class="form-control" type="text" name="o_zipcode1" id="o_zipcode1" readonly="readonly" />
														</div>
														<div class="col-xs-6 col-md-2">
                                                    		<button class="btn btn-primary" type="button" onclick="openDaumPostcode()">우편번호 검색</button>
														</div>
													</div>
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
																					document.getElementById('o_zipcode1').value = data.zonecode; //5자리 새우편번호 사용
																					document.getElementById('o_addr1').value = fullAddr;
																					document.getElementById('o_addr2').focus();
																			}
																	}).open();
															}
													</script>

													<div class="row">
														<div class="col-xs-12 col-md-3 register-font">
														</div>
														<div class="col-xs-12 col-md-4">
															<input class="form-control" type="text" name="o_addr1" id="o_addr1" readonly="readonly" />
														</div>
														<div class="col-xs-12 col-md-4">
															<label class="sr-only" for="o_addr2">상세주소</label>
															<input class="form-control" type="text" id="o_addr2" name="o_addr2" required />
														</div>
													</div>

													<div class="row">
														<div class="col-xs-12 col-md-3 register-font">휴대폰</div>
														<div class="col-xs-12 col-md-3">
																<label class="sr-only" for="hphone">휴대폰</label>
																<input class="form-control" type="text" id="hphone" name="hphone" placeholder="010-xxxx-xxxx (-를 삽입해 주세요)" required />
														</div>
													</div>

													<div class="row">
														<div class="col-xs-12 col-md-3 register-font">
															일반 전화번호
														</div>
														<div class="col-xs-12 col-md-3">
															<label class="sr-only" for="o_phone">일반 전화번호</label>
															<input class="form-control" type="text" id="o_phone" name="o_phone" placeholder="02-xxx-xxxx (-를 삽입해 주세요)" required /> (없으면 휴대폰 번호를 넣어주세요)
														</div>
													</div>

											</div> <!-- ./panel-body -->
										</div><!-- ./panel -->

										<div class="panel panel-info">
											<div class="panel-heading"><h4>배송지 정보</h4><p>(택배 주문 시 받으실 주소)</p></div>
												<div class="panel-body">

													<div class="row">
														<div class="col-xs-12 col-md-12">
																<input type="checkbox" name="same_info" onClick="usePmemberSameAddr()" > 기본 주소정보와 동일한 경우 체크
														</div>
													</div>

												 <div class="row">
														<div class="col-xs-12 col-md-3 register-font">
															배송지 주소
														</div>
														<div class="col-xs-6 col-md-2">
															<input class="form-control" type="text" name="d_zipcode1" id="d_zipcode1" readonly="readonly" />
														</div>
														<div class="col-xs-6 col-md-2">
															<button class="btn btn-primary" type="button" onclick="openDaumPostcode2()">우편번호 검색</button>
														</div>
													</div>
													<!-- postcode searching function -->
													<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
													<script>
															function openDaumPostcode2() {
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
																					document.getElementById('d_zipcode1').value = data.zonecode; //5자리 새우편번호 사용

																					//전체 주소에서 연결 번지 및 ()로 묶여 있는 부가정보를 제거하고자 할 경우,
																					//아래와 같은 정규식을 사용해도 된다. 정규식은 개발자의 목적에 맞게 수정해서 사용 가능하다.
																					document.getElementById('d_addr1').value = fullAddr;
																					document.getElementById('d_addr2').focus();

																			}
																	}).open();
															}
													</script>

													<div class="row">
														<div class="col-xs-12 col-md-3 register-font">
														</div>
														<div class="col-xs-12 col-md-4">
																<input class="form-control" type="text" name="d_addr1" id="d_addr1" readonly="readonly" />
														</div>
														<div class="col-xs-12 col-md-4">
															<label class="sr-only" for="d_addr2">배송지 주소</label>
															<input class="form-control" type="text" name="d_addr2" id="d_addr2" required />
														</div>
													</div>

													<div class="row">
														<div class="col-xs-12 col-md-3 register-font">휴대폰</div>
														<div class="col-xs-12 col-md-3">
																<label class="sr-only" for="d_hphone">휴대폰</label>
																<input class="form-control" type="text" id="d_hphone" name="d_hphone" placeholder="010-xxxx-xxxx (-를 삽입해 주세요)" required />
														</div>
													</div>

													<div class="row">
														<div class="col-xs-12 col-md-3 register-font">
															배송지 전화번호
														</div>
														<div class="col-sm-12 col-md-3">
															<label class="sr-only" for="d_phone">배송지 전화번호</label>
															<input class="form-control" type="text" name="d_phone" placeholder="02-xxx-xxxx (-를 삽입해 주세요)" required /> (없으면 휴대폰 번호를 넣어주세요)
														</div>
													</div>

											</div><!-- ./panel-body -->
										</div><!-- ./panel -->

										<div class="row">
											<div class="col-sm-12 text-center">
											<button class="btn btn-success" type="submit" onclick="registerConfirm()">등 록</button> <a class="btn btn-primary" role="button" href="/" >취 소</a>
											</div>
										</div>

											</form>
										<?php
}
; //end else
?>

					</div>
			 </div> <!-- ./container -->

</section> <!-- /.section -->

<?php include_once '../include/brands.php';?>


<?php include_once '../include/footer.php';?>

				<script src="/js/member.js"></script>
				<!-- check id -->
				<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/jquery.validate.min.js"></script>
				<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/additional-methods.min.js"></script>
				<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.0/localization/messages_ko.js "></script>

				<script>
					$(document).ready(function() {
						$('#useridLoading').hide();

            $("#userid").keyup(function(event){
                    if (!(event.keyCode >=37 && event.keyCode<=40)) {
                        var inputVal = $(this).val();
                        $(this).val(inputVal.replace(/[^a-z0-9]/gi,''));
                    }
            });

						$('#userid').blur(function(){
							$('#useridLoading').show();
							$.post("checkAvail.php", {
								userid: $('#userid').val()
							}, function(response){
								$('#useridResult').fadeOut();
								setTimeout("finishAjax('useridResult', '"+escape(response)+"')", 400);
							});

							return false;

						});

					});


					function finishAjax(id, response) {

						$('#useridLoading').hide();
						$('#'+id).html(unescape(response));
						$('#'+id).fadeIn();

					} //finishAjax

				</script>
				<!-- check id end -->

		</body>
</html>