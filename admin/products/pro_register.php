<?php include_once '../include/header.php';?>

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
					<!-- info start-->
					<div class="row">
						<div class="col-sm-12">
							<section class="panel">
								<header class="panel-heading">
									사용방법
								</header>
								<ul class="info-body">
									<li><i class="fa fa-info-circle"></i> 노출이 되지 않도록 아예 감추려면 판매중지에 체크하세요.</li>
								</ul>
							</section>
						</div>
					</div>
					<!-- info end -->
<?php

$mode = $_GET['mode'];

if ($mode == "update") {

    // 상품목록에서 수정 시
    $p_num = set_var($_GET['p_num']);
    $page  = set_var($_GET['page']);

    $update_qry    = "SELECT * FROM products WHERE num='$p_num'";
    $update_result = mysqli_query($connect, $update_qry);
    $update_row    = mysqli_fetch_array($update_result);

    if (set_var($_POST['lcode'])) {
        // 키테고리 변경 시 POST 값으로 넘어옴
        $lcode = set_var($_POST['lcode']);
        $mcode = set_var($_POST['mcode']);
    } else {
        $lcode = $update_row['category_l'];
        $mcode = $update_row['category_m'];
    }

    ?>

					<form name="form1" class="form-inline" role="form" method="post" enctype="multipart/form-data" action="pro_register_ok.php">
						<div class="row">
							<div class="col-sm-12">
								<section class="panel">
									<header class="panel-heading table-head">
										상품 등록 및 수정
									</header>
									<div class="panel-body">
										<div class="table-responsive">
											<table class="table table-striped">
												<tbody>
													<tr>
														<th colspan="2"><i class="fa fa-cog"></i> 전시 관리</th>
													</tr>
													<tr>
														<th width="15%"><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 상품등록 관리</th>
														<td>
															<input type="radio" name="del_chk" value="N"															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                             <?php echo ($update_row['del_chk'] == 'N' || "insert" == $mode ? "checked" : ""); ?> /> 전시
															<input type="radio" name="del_chk" value="Y"															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                             <?php echo ($update_row['del_chk'] == 'Y' ? "checked" : ""); ?> /> <span class="label label-default">판매중지</span> (숨김)
															<input type="radio" name="del_chk" value="O"															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                             <?php echo ($update_row['del_chk'] == 'O' ? "checked" : ""); ?> /> <span class="label label-warning">일시품절</span>
															<input type="radio" name="del_chk" value="C"															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                            															                                             <?php echo ($update_row['del_chk'] == 'C' ? "checked" : ""); ?> /> <span class="label label-danger">단 종</span>
														</td>
													</tr>
                          <tr >
                            <th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 분류</th>
                            <td>
                                                            <?php echo restore_category($mode, $lcode, $mcode); ?>
                            </td>
                          </tr>
													<tr>
														<th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 메인페이지 노출</th>
														<td>
															<input type="checkbox" name="main_new"															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                      															                                       <?php echo ($update_row['main_new'] == 'Y') ? "checked" : ""; ?> /> 신상품
															<input type="checkbox" name="main_special"															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                           <?php echo ($update_row['main_special'] == 'Y') ? "checked" : ""; ?> /> 기획상품
															<input type="checkbox" name="main_best"															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                       															                                        <?php echo ($update_row['main_best'] == 'Y') ? "checked" : ""; ?> /> 인기상품
														</td>
													</tr>
													<tr>
														<th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 아이콘 표시</th>
														<td>
															<input type="checkbox" name="option1_chk"															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                          <?php echo ($update_row['option1_chk'] == 'Y' ? "checked" : ""); ?> />
															<span class="label label-success">NEW</span>
															<input type="checkbox" name="option2_chk"															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                          <?php echo ($update_row['option2_chk'] == 'Y' ? "checked" : ""); ?> onclick="javascript:alert('아래 항목에서 해당 내용을 설정 또는 해제하세요.');" />
															<span class="label label-info">기획</span>
															<input type="checkbox" name="option3_chk"															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                          <?php echo ($update_row['option3_chk'] == 'Y' ? "checked" : ""); ?> />
															<span class="label label-danger">인기</span>
															<input type="checkbox" name="option4_chk"															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                         															                                          <?php echo ($update_row['option4_chk'] == 'Y' ? "checked" : ""); ?> onclick="javascript:alert('아래 항목에서 해당 내용을 설정 또는 해제하세요.');" />
															<span class="label label-warning">SALE</span>
														</td>
													</tr>
<!-- 													<tr>
														<th rowspan="2"><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 이벤트 관리</th>
														<td>
															<input type="radio" name="event" value="0"															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                           <?php echo ($update_row['event'] == '0' || 'insert' == $mode ? "checked" : ""); ?> /> 해당사항 없음(중지)
															<input type="radio" name="event" value="1"															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                           <?php echo ($update_row['event'] == '1' ? "checked" : ""); ?>/> 할인판매
															<input type="radio" name="event" value="2"															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                           <?php echo ($update_row['event'] == '2' ? "checked" : ""); ?>/> 사은품 증정
															<input type="radio" name="event" value="3"															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                           <?php echo ($update_row['event'] == '3' ? "checked" : ""); ?>/> 할인+사은품 증정
															<input type="radio" name="event" value="4"															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                          															                                           <?php echo ($update_row['event'] == '4' ? "checked" : ""); ?>/> 1+1
														</td>
													</tr>
													<tr>
														<td>
															기간 : (시작일) <input type="text" class="w8em format-y-m-d divider-dash highlight-days-67 range-low-2008-01-01 no-transparency" name="date1" id="sd" value="<?php echo $update_row['date1']; ?>" size="10" />&nbsp;~&nbsp;
															(종료일) <input type="text" class="w8em format-y-m-d divider-dash highlight-days-67 range-low-2008-01-01 no-transparency" name="date2" id="ed" value="<?php echo $update_row['date2']; ?>" size="10" />
														</td>
													</tr> -->

													<tr >
														<th colspan="2"><i class="fa fa-cube"></i> 상품 정보</th>
													</tr>
													<tr >
														<th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 상품명</th>
														<td>
															<div align="left">
																<input type="text" class="form-control" name="name" style="width: 100%;" value="<?php echo stripslashes($update_row['name']); ?>" />
															</div>
														</td>
													</tr>
													<tr >
														<th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 상품 간략설명</th>
														<td>
															<div align="left">
																<!-- <input type="text" class="form-control" name="short_desc" value="<?php echo stripslashes($update_row['short_desc']); ?>" size="100%" /> -->
																<textarea class="form-control" name="short_desc" style="width:100%; height:200px"><?php echo str_replace("<br />", "", $update_row['short_desc']); ?></textarea>
															</div>
														</td>
													</tr>
													<tr>
														<th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 브랜드</th>
														<td>
															<input type="text" class="form-control" name="company" value="<?php echo $update_row['company']; ?>" /> <!-- / <input type="text" class="form-control" name="importer" value="<?php echo $update_row['importer']; ?>" /> -->
															<p class="help-block"><i class="fa fa-exclamation-triangle"></i> 해당사항 없을 시 공란</p>
														</td>
													</tr>
                          <tr>
                              <th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 소비자가</th>
                              <td><input name="shop_price" id="shop_price" class="form-control" type="text" value="<?php echo $update_row['shop_price']; ?>" /> 원 (숫자만 입력) </td>
                          </tr>
													<tr>
														<th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 공급가</th>
														<td><input name="retail_price" id="retail_price" class="form-control" type="text" value="<?php echo $update_row['retail_price']; ?>" /> 원 (숫자만 입력) </td>
													</tr>
    												<tr>
    													<th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 최소 구매수량</th>
    													<td><input type="text" class="form-control" name="moq" value="<?php echo $update_row['moq']; ?>" size="5"/> 개</td>
    												</tr>
    												<tr>
    													<th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 선택사항</th>
        												<td>
<?php

    if (isset($update_row['opt'])) {
        restore_option($update_row);
    } else {
        echo <<<HEREDOC

                                                            <input name="optname_ins" type="text" class="form-control" value="" size="100" >
HEREDOC;
    }
    ?>
                                                            <p class="help-block"><i class="fa fa-exclamation-triangle"></i> 구분은 ',(콤마)' 하세요 (예:블루,레드,블랙)</p>
                                                            <p class="help-block"><i class="fa fa-exclamation-triangle"></i> 하나의 옵션 중간에 ,(콤마) 가 들어가지 않도록 유의하세요</p>
                                                        </td>
        											</tr>
            										<tr>
            											<th colspan="2">
            												<i class="fa fa-picture-o"></i> 상품 이미지(소 이미지는 대1 이미지를 사용해 자동생성됩니다.)
            												<p class="help-block"><i class="fa fa-exclamation-triangle"></i>  이미지 해상도는 최대 800x800px(픽셀) / 이미지 크기는 1MB 이하로 하셔야 합니다.</p>
            											</th>
            										</tr>
            										<tr >
            											<th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 대 1</th>
            											<td><input type="file" class="form-control" name="b_image[]" size="30" />
<?php

    if ($update_row['b_image1'] == 'Y') {
        ?>
                											<img src="<?php echo $update_row['b_image1_name']; ?>" width="50" height="50" />
<?php

    } else {
        ?>
                											<img src="http://placehold.it/50x50">
<?php

    }
    ?>
                                                            </td>
                									</tr>
                									<tr>
                										<th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 대 2</th>
                										<td><input type="file" class="form-control" name="b_image[]" size="30" />
<?php

    if ($update_row['b_image2'] == 'Y') {
        ?>
                    										<img src="<?php echo $update_row['b_image2_name']; ?>" width="50" height="50" />
<?php

    } else {
        ?>
                    										<img src="http://placehold.it/50x50">
<?php

    }
    ?>
                                                        </td>
                    								</tr>
                    								<tr >
                    									<th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 대 3</th>
                    									<td><input type="file" class="form-control" name="b_image[]" size="30" />
<?php

    if ($update_row['b_image3'] == 'Y') {
        ?>
                        									<img src="<?php echo $update_row['b_image3_name']; ?>" width="50" height="50" />
<?php

    } else {
        ?>
                        									<img src="http://placehold.it/50x50">
<?php

    }
    ?>
                                                        </td>
                        							</tr>
                        							<tr>
                        								<th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 대 4</th>
                        								<td><input type="file" class="form-control" name="b_image[]" size="30" />
<?php

    if ($update_row['b_image4'] == 'Y') {
        ?>
                            								<img src="<?php echo $update_row['b_image4_name']; ?>" width="50" height="50" />
<?php } else {?>
                            								<img src="http://placehold.it/50x50">
<?php
}
    ?>
                                                        </td>
                            						</tr>
                                					<tr>
                                						<th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 상세설명</th>
                                						<td>
                                              <p class="help-block"><i class="fa fa-exclamation-triangle"></i> 상세설명에 삽입되는 이미지는 가로 최대 800px(픽셀) </p>
                                							<textarea name="contents" class="form-control" id="contents"><?php echo stripslashes($update_row['contents']); ?></textarea>
                                							<script type="text/javascript">
                                				                CKEDITOR.replace( 'contents' );
                                				            </script>
                                						</td>
                                					</tr>
                                				</tbody>
                                			</table>
                                		</div>
                                	</div>
                                </section>
                            </div>
                        </div>
                        <div class="row text-center">
                        	<div class="col-sm-12">
                            	<input type="hidden" name="mode" value="<?php echo $mode; ?>" />
                            	<input type="hidden" name="p_num" value="<?php echo $p_num; ?>" />
                            	<input type="hidden" name="page" value="<?php echo $page; ?>" />
                            	<input type="hidden" name="old_l_cate" value="<?php echo $update_row['category_m']; ?>" />
                            	<button class="btn btn-success" onclick="send_post('contents');">등록</button>
                            	<a type="button" class="btn btn-default" href="top_pro_list.php?lcode=<?php echo $lcode; ?>&mcode=<?php echo $mcode; ?>&page=<?php echo $page; ?>">취소</a>
                            	<a type="button" class="btn btn-danger" href="pro_delete.php?p_num=<?php echo $p_num; ?>&amp;lcode=<?php echo $lcode; ?>&amp;mcode=<?php echo $mcode; ?>&amp;page=<?php echo $page; ?>" onclick="return confirm('정말 삭제하시겠습니까?')">삭제</a>
                        	</div>
                        </div>
                    </form>


<?php
//////////////////////////////
    /////신상품 등록
    //////////////////////////////
} elseif ($mode == "insert") {
    $lcode = set_var($_POST['lcode']);
    $mcode = set_var($_POST['mcode']);
    ?>

					<form name="form1" class="form-inline" role="form" method="post" enctype="multipart/form-data" action="pro_register_ok.php">
						<div class="row">
							<div class="col-sm-12">
								<section class="panel">
									<header class="panel-heading table-head">
										상품 등록 및 수정
									</header>
									<div class="panel-body">
										<div class="table-responsive">
											<table class="table table-striped">
												<tbody>
													<tr>
														<th colspan="2"><i class="fa fa-cog"></i> 전시 관리</th>
													</tr>
													<tr>
														<th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 상품등록 관리</th>
														<td>
															<input type="radio" name="del_chk" value="N" checked /> 전시
															<input type="radio" name="del_chk" value="Y" /> <span class="label label-default">판매중지</span> (숨김)
															<input type="radio" name="del_chk" value="O" /> <span class="label label-warning">일시품절</span>
															<input type="radio" name="del_chk" value="C" /> <span class="label label-danger">단 종</span>
														</td>
													</tr>
                          <tr >
                            <th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 분류</th>
                            <td>
<?php echo restore_category($mode, $lcode, $mcode); ?>
                            </td>
                          </tr>
													<tr>
														<th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 메인페이지 노출</th>
														<td>
															<input type="checkbox" name="main_new" /> 신상품
															<input type="checkbox" name="main_special" /> 기획상품
															<input type="checkbox" name="main_best"  /> 인기상품
														</td>
													</tr>
													<tr>
														<th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 아이콘 표시</th>
														<td>
															<input type="checkbox" name="option1_chk" />
															<span class="label label-success">NEW</span>
															<input type="checkbox" name="option2_chk" onclick="javascript:alert('아래 항목에서 해당 내용을 설정 또는 해제하세요.');" />
															<span class="label label-info">기획</span>
															<input type="checkbox" name="option3_chk"  />
															<span class="label label-danger">인기</span>
															<input type="checkbox" name="option4_chk" onclick="javascript:alert('아래 항목에서 해당 내용을 설정 또는 해제하세요.');" />
															<span class="label label-warning">SALE</span>
														</td>
													</tr>
<!-- 													<tr>
														<th rowspan="2"><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 이벤트 관리</th>
														<td>
															<input type="radio" name="event" value="0" /> 해당사항 없음(중지)
															<input type="radio" name="event" value="1" /> 할인판매
															<input type="radio" name="event" value="2" /> 사은품 증정
															<input type="radio" name="event" value="3" /> 할인+사은품 증정
															<input type="radio" name="event" value="4" /> 1+1
														</td>
													</tr>
													<tr>
														<td>
															기간 : (시작일) <input type="text" class="w8em format-y-m-d divider-dash highlight-days-67 range-low-2008-01-01 no-transparency" name="date1" id="sd" value="" size="10" />&nbsp;~&nbsp;
															(종료일) <input type="text" class="w8em format-y-m-d divider-dash highlight-days-67 range-low-2008-01-01 no-transparency" name="date2" id="ed" value="" size="10" />
														</td>
													</tr> -->

													<tr >
														<th colspan="2"><i class="fa fa-cube"></i> 상품 정보</th>
													</tr>
													<tr >
														<th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 상품명</th>
														<td>
															<div align="left">
																<input type="text" class="form-control" name="name" value="" size="100" />
															</div>
														</td>
													</tr>
													<tr >
														<th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 상품 간략설명</th>
														<td>
															<div align="left">
																<!-- <input type="text" class="form-control" name="short_desc" value="" size="100%" /> -->
																<textarea class="form-control" name="short_desc" style="width:100%; height:200px"></textarea>
															</div>
														</td>
													</tr>
													<tr>
														<th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 브랜드</th>
														<td>
															<input type="text" class="form-control" name="company" value="" /> <!-- / <input type="text" class="form-control" name="importer" value="" /> -->
															<p class="help-block"><i class="fa fa-exclamation-triangle"></i> 해당사항 없을 시 공란</p>
														</td>
													</tr>
                          <tr>
                              <th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 소비자가</th>
                              <td><input name="shop_price" id="shop_price" class="form-control" type="text" value="" /> 원 (숫자만 입력) </td>
                          </tr>
													<tr>
														<th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 공급가</th>
														<td><input name="retail_price" id="retail_price" class="form-control" type="text" value="" /> 원 (숫자만 입력) </td>
													</tr>
    												<tr>
    													<th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 최소 구매수량</th>
    													<td><input type="text" class="form-control" name="moq" value="" size="5"/> 개</td>
    												</tr>
    												<tr>
    													<th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 선택사항</th>
    													<td>
    														<input name="optname_ins" type="text" class="form-control" value="" size="100" >
    														<p class="help-block"><i class="fa fa-exclamation-triangle"></i> 구분은 ',(콤마)' 하세요 (예:블루,레드,블랙)</p>
                                <p class="help-block"><i class="fa fa-exclamation-triangle"></i> 하나의 옵션 중간에 ,(콤마)가 들어가지 않도록 유의하세요</p>
    													</td>
    												</tr>

            										<tr>
            											<th colspan="2">
            												<i class="fa fa-picture-o"></i> 상품 이미지(소 이미지는 대1 이미지를 사용해 자동생성됩니다.)
            												<p class="help-block"><i class="fa fa-exclamation-triangle"></i>  이미지 해상도는 최대 800x800px(픽셀) / 이미지 크기는 1MB 이하로 하셔야 합니다.</p>
            											</th>
            										</tr>
            										<tr >
            											<th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 대 1</th>
            											<td><input type="file" class="form-control" name="b_image[]" size="30" /> <img src="http://placehold.it/50x50"></td>
            										</tr>
            										<tr>
            											<th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 대 2</th>
            											<td><input type="file" class="form-control" name="b_image[]" size="30" /> <img src="http://placehold.it/50x50"></td>
            										</tr>
            										<tr >
            											<th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 대 3</th>
            											<td><input type="file" class="form-control" name="b_image[]" size="30" /> <img src="http://placehold.it/50x50"></td>
            										</tr>
            										<tr>
            											<th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 대 4</th>
            											<td><input type="file" class="form-control" name="b_image[]" size="30" /> <img src="http://placehold.it/50x50"></td>
            										</tr>
            										<tr>
            											<th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 상세설명</th>
            											<td>
                                    <p class="help-block"><i class="fa fa-exclamation-triangle"></i> 상세설명에 삽입되는 이미지는 가로 최대 800px(픽셀) </p>
            												<textarea name="contents" class="form-control" id="contents"></textarea>
            												<script type="text/javascript">
            									                CKEDITOR.replace( 'contents' );
            									            </script>
            											</td>
            										</tr>
            									</tbody>
            								</table>
            							</div>
            						</div>
            					</section>
            				</div>
            			</div>
            			<div class="row text-center">
            				<div class="col-sm-12">
                				<input type="hidden" name="mode" value="<?php echo $mode; ?>" />
                				<button class="btn btn-success" onclick="send_post('contents');">등록</button>
                				<a type="button" class="btn btn-default" href="top_pro_list.php">취소</a>
                			</div>
            			</div>
            			</form>

<?php

}
?>

		</section>
	</section>
	<!--main content end-->

     <!--footer start-->
    <?php include_once "../include/admin_footer.php";?>
      <!--footer end-->

	</body>
</html>