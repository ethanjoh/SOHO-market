<?php include_once '../include/header.php';?>

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
          <!-- info start-->
          <div class="row">
            <div class="col-sm-12">
              <section class="panel">
                <header class="panel-heading">
                  사용방법
                </header>
                <ul class="info-body">
                  <li><i class="fa fa-info-circle"></i> 날짜와 관계없이 포장완료된 주문만 표시됩니다.</li>
                  <li><i class="fa fa-info-circle"></i> 포장이 완료되어야 나타납니다.</li>
                </ul>
              </section>
            </div>
          </div>
          <!-- info end -->
          <?php
if ($mode == "update") {
    if ($prod_code) {
        $update_qry = "SELECT * FROM products WHERE prod_code='$prod_code' ";
    } else {
        $update_qry = "SELECT * FROM products WHERE num=$p_num";
    }
    $update_result = mysqli_query($connect, $update_qry);
    $update_row    = mysqli_fetch_array($update_result);
    mysqli_free_result($update_result);
} else {
    $mode = "insert";
}
?>
          <form name="form1" class="form-inline" role="form" method="post" enctype="multipart/form-data" action="pro_register_ok.php">
            <!-- <input type="hidden" name="con_html" value="1" /> -->
            <input type="hidden" name="prod_code" value="<?=$prod_code;?>" />
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
                              <input type="radio" name="del_chk" value="N" <?php if (($mode == 'insert') || ($update_row['del_chk'] == 'N')) {
    echo ("checked");
}
?>/> 전시
                              <input type="radio" name="del_chk" value="Y" <?php if ($update_row['del_chk'] == 'Y') {
    echo ("checked");
}
?> /> <span class="label label-default">판매중지</span> (숨김)
                              <input type="radio" name="del_chk" value="O" <?php if ($update_row['del_chk'] == 'O') {
    echo ("checked");
}
?> /> <span class="label label-warning">일시품절</span>
                              <input type="radio" name="del_chk" value="C" <?php if ($update_row['del_chk'] == 'C') {
    echo ("checked");
}
?> /> <span class="label label-danger">단 종</span>
                            </td>
                          </tr>
                          <!-- hidden
                          <tr>
                            <th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 메인화면 표시</th>
                            <td>
                              <input type="checkbox" name="main_new" <?=($update_row['main_new'] == 'Y') ? "checked" : "";?> /> 신상품
                              <input type="checkbox" name="main_special" <?=($update_row['main_special'] == 'Y') ? "checked" : "";?> /> 기획상품
                              <input type="checkbox" name="main_best" <?=($update_row['main_best'] == 'Y') ? "checked" : "";?> /> 인기상품
                            </td>
                          </tr>
                          <tr>
                            <th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 아이콘 표시</th>
                            <td>
                              <input type="checkbox" name="option1_chk" <?php if ($update_row['option1_chk'] == 'Y') {
    echo "checked";
}
?> />
                              <img src="../images/New_icons_44.gif" alt="신상품" width="28" height="11" />
                              <input type="checkbox" name="option2_chk" <?php if ($update_row['option2_chk'] == 'Y') {
    echo "checked";
}
?> onclick="javascript:alert('아래 항목에서 해당 내용을 설정 또는 해제하세요.');" />
                              <img src="../images/event_icon.gif" alt="기획상품" width="43" height="16" />
                              <input type="checkbox" name="option3_chk" <?php if ($update_row['option3_chk'] == 'Y') {
    echo "checked";
}
?> />
                              <img src="../images/best_icon.gif" alt="인기상품" width="43" height="16" />
                              <input type="checkbox" name="option4_chk" <?php if ($update_row['option4_chk'] == 'Y') {
    echo "checked";
}
?> onclick="javascript:alert('아래 항목에서 해당 내용을 설정 또는 해제하세요.');" />
                              <img src="../images/sale_icon.gif" alt="할인상품" width="43" height="16" />
                              <input type="checkbox" name="option5_chk" <?php if ($update_row['option5_chk'] == 'Y') {
    echo "checked";
}
?> />
                              <img src="../images/delivery_icon.gif" alt="당사직송" width="43" height="16" />
                            </td>
                          </tr>
                          <tr>
                            <th rowspan="2"><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 이벤트 관리</th>
                            <td>
                              <input type="radio" name="event" value="0" <?php if (($mode == 'insert') || ($update_row['event'] == '0')) {
    echo ("checked");
}
?> /> 해당사항 없음(중지)
                              <input type="radio" name="event" value="1" <?php if ($update_row['event'] == '1') {
    echo ("checked");
}
?>/> 할인판매
                              <input type="radio" name="event" value="2" <?php if ($update_row['event'] == '2') {
    echo ("checked");
}
?>/> 사은품 증정
                              <input type="radio" name="event" value="3" <?php if ($update_row['event'] == '3') {
    echo ("checked");
}
?>/> 할인+사은품 증정
                              <input type="radio" name="event" value="4" <?php if ($update_row['event'] == '4') {
    echo ("checked");
}
?>/> 1+1
                            </td>
                          </tr>
                          <tr>
                            <td>
                              기간 : (시작일) <input type="text" class="w8em format-y-m-d divider-dash highlight-days-67 range-low-2008-01-01 no-transparency" name="date1" id="sd" value="<?=$update_row['date1'];?>" size="10" />&nbsp;~&nbsp;
                              (종료일) <input type="text" class="w8em format-y-m-d divider-dash highlight-days-67 range-low-2008-01-01 no-transparency" name="date2" id="ed" value="<?=$update_row['date2'];?>" size="10" />
                            </td>
                          </tr>
                          -->
                          <tr >
                            <th colspan="2"><i class="fa fa-cube"></i> 상품 정보</th>
                          </tr>
                          <tr >
                            <th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 분류</th>
                            <td>
                              <select class="form-control" name="lcode" onChange="change_code()">
                                <?php
$ca1_qry    = "SELECT * FROM products_category1 ORDER BY name";
$ca1_result = mysqli_query($connect, $ca1_qry);
for ($i = 0; $ca1_row = mysqli_fetch_array($ca1_result); $i++) {
    if ($ca1_row['code'] == $lcode) {
        ?>
                                <option value="<?=$ca1_row['code'];?>" selected="selected">
                                  <?=$ca1_row['name'];?>
                                </option>
                                <?php
} else {
        ?>
                                <option value="<?=$ca1_row['code'];?>">
                                  <?=$ca1_row['name'];?>
                                </option>
                                <?php

    }
} //end for
mysqli_free_result($ca1_result);
?>
                              </select>
                              <!-- hidden
                              <select class="form-group" name="mcode" onChange="change_code()">
                                <option value="">선택하세요</option>
                                <?php
$ca2_qry    = "SELECT * FROM products_category2 WHERE up_category='$lcode' ORDER BY code";
$ca2_result = mysqli_query($connect, $ca2_qry);
for ($i = 0; $ca2_row = mysqli_fetch_array($ca2_result); $i++) {
    if ($ca2_row['code'] == $mcode) {
        ?>
                                <option value="<?=$ca2_row['code'];?>" selected="selected">
                                  <?=$ca2_row['name'];?>
                                </option>
                                <?php
} else {
        ?>
                                <option value="<?=$ca2_row['code'];?>">
                                  <?=$ca2_row['name'];?>
                                </option>
                                <?php
}
}
mysqli_free_result($ca2_result);
?>
                              </select>
                              <select class="form-group" name="scode" onChange="change_code()">
                                <option value="">선택하세요</option>
                                <?php
$ca3_qry    = "SELECT * FROM products_category3 WHERE up_category='$mcode' ORDER BY code";
$ca3_result = mysqli_query($connect, $ca3_qry);
for ($i = 0; $ca3_row = mysqli_fetch_array($ca3_result); $i++) {
    if ($ca3_row['code'] == $scode) {
        ?>
                                <option value="<?=$ca3_row['code'];?>" selected="selected" ><?=$ca3_row['name'];?></option>
                                <?php
} else {
        ?>
                                <option value="<?=$ca3_row['code'];?>" ><?=$ca3_row['name'];?></option>
                                <?php
}
}
mysqli_free_result($ca3_result);
?>
                              </select>
                              -->
                            </td>
                          </tr>
                          <tr >
                            <th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 상품명</th>
                            <td>
                              <div align="left">
                                <input type="text" class="form-control" name="name" value="<?=stripslashes($update_row['name']);?>" size="100" />
                              </div>
                            </td>
                          </tr>
                          <tr >
                            <th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 상품 간략설명</th>
                            <td>
                              <div align="left">
                                <!-- <input type="text" class="form-control" name="short_desc" value="<?=stripslashes($update_row['short_desc']);?>" size="100%" /> -->
                                <textarea class="form-control" name="short_desc" style="width:100%; height:200px"><?=str_replace("<br />", "", $update_row['short_desc']);?></textarea>
                              </div>
                            </td>
                          </tr>
                          <tr>
                            <th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 제조사</th>
                            <td>
                              <input type="text" class="form-control" name="company" value="<?=$update_row['company'];?>" /> <!-- / <input type="text" class="form-control" name="importer" value="<?=$update_row['importer'];?>" /> -->
                              <p class="help-block"><i class="fa fa-exclamation-triangle"></i> 해당사항 없을 시 공란</p>
                            </td>
                          </tr>
                          <tr>
                            <th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 판매가</th>
                            <td><input name="retail_price" id="retail_price" class="form-control" type="text" value="<?=$update_row['retail_price'];?>" /> 원 (숫자만 입력) </td>
                          </tr>
                          <!-- hidden
                          <tr>
                            <th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 할인가</th>
                            <td>
                              <input name="sale_price" type="text" class="form-control" value="<?=$update_row['sale_price'];?>" /> 원
                              <p class="help-block"><i class="fa fa-exclamation-triangle"></i> 숫자만 입력</p>
                            </td>
                          </tr>
                          <tr>
                            <th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 고정공급가</th>
                            <td>
                              <input name="downRate" id="downRate" class="form-control" type="text"  value="" onkeyup="setPrice()" placeholder="할인율" size="3" />%↓
                              <input name="fixed_price" id="fixed_price" class="form-control" type="text" value="<?=$update_row['fixed_price'];?>" readonly="readonly" placeholder="자동계산" /> 원 (<img src="../images/warning.gif" alt="주의" />고정된 공급가로만 판매 시)<br />
                              <?php
if ($mode == "update") {
    ?>
                              <script>
                              getRate();
                              </script>
                              <?php
}
?>
                              <p class="help-block"><input type="checkbox" name="pflag" <?=($update_row['pflag'] == 'Y') ? "checked" : "";?> />
                            <i class="fa fa-exclamation-triangle"></i> 마진율 무시 특별공급가 책정 시 체크(업체에 관계없이 동일한 공급가 적용)</p>
                          </td>
                        </tr>
                        -->
                        <tr>
                          <th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 최소 구매수량</th>
                          <td><input type="text" class="form-control" name="moq" value="<?=$update_row['moq'];?>" size="5"/> 개</td>
                        </tr>
                        <tr>
                          <?php
if ($mode == "insert" || $flag == "1") {; //copy 할 때 옵션초기화를 위해 flag를 설정
    ?>
                          <th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 선택사항</th>
                          <td>
                            <input name="optname_ins" type="text" class="form-control" value="" size="100" >
                            <p class="help-block"><i class="fa fa-exclamation-triangle"></i> 구분은 ',(콤마)' 하세요 (예:블루,레드,블랙)</p>
                          </td>
                        </tr>
                        <!--                         <tr>
                          <th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 바코드</th>
                          <td>
                            <input name="barcode_ins" type="text" class="form-control" value="" size="100" >
                            <p class="help-block"><i class="fa fa-exclamation-triangle"></i> 구분은 ',(콤마)' 하세요 (예:8801201203,8801201204)</p>
                          </td>
                        </tr> -->
                        <?php
} else {
    ?>
                        <th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 선택사항</th>
                        <?php
if ($update_row['opt']) {
        ?>
                        <td>
                          <?php
$optname  = explode(",", $update_row['opt']);
        $optstock = explode(",", $update_row['opt_stock']);
        $barcode  = explode(",", $update_row['barcode']);
        for ($i = 0; $i < count($optname); $i++) {
            echo "<input name=\"optname[]\" type=\"text\" class=\"form-control\" value=\"$optname[$i]\" size=\"20\" >&nbsp;";
            //echo "<input name=\"optstock[]\" type=\"text\" value=$optstock[$i] size=\"2\" ><br/>";
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

            echo "<input name=\"opt_stock[$i]\" type=\"radio\" value=\"1\" $a />재고 있음&nbsp;";
            echo "<input name=\"opt_stock[$i]\" type=\"radio\" value=\"0\" $b />품절&nbsp;";
            echo "<input name=\"opt_stock[$i]\" type=\"radio\" value=\"-1\" $c />단종";
            echo "<input name=\"barcode[]\" type=\"text\" value=\"$barcode[$i]\" /> (바코드)<br />";
        }
        ?>
                        </td>
                        <?php
} else {
        ?>
                        <td><p>N/A</p></td>
                      </tr>
                      <!--                         <tr>
                        <th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 바코드</th>
                        <td><input name="barcode" type="text" class="form-control" value="<?=$update_row['barcode'];?>" /></td>
                      </tr> -->
                      <?php
}
}
?>
                      <!--                         <tr>
                        <th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 크기/무게</th>
                        <td>
                          <input type="text" name="size" class="form-control" value="<?=$update_row['size'];?>" />
                          <p class="help-block"><i class="fa fa-exclamation-triangle"></i> (예: 10 x 20 cm)</p>
                        </td>
                      </tr>
                      <tr>
                        <th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 재질</th>
                        <td><input type="text" name="material" class="form-control" value="<?=$update_row['material'];?>" size="50" /></td>
                      </tr>
                      <tr>
                        <th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 원산지</th>
                        <td><input name="origin" type="text" class="form-control" value="<?=$update_row['origin'];?>" size="50" /></td>
                      </tr>
                      <tr>
                        <th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 인증여부</th>
                        <td>
                          <input name="auth" type="text" class="form-control" value="<?=$update_row['auth'];?>" size="50" />
                          <p class="help-block"><i class="fa fa-exclamation-triangle"></i> 해당사항 없을 시 공란</p>
                        </td>
                      </tr>
                      <tr>
                        <th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> A/S</th>
                        <td><input name="service" type="text" class="form-control" value="<?=$update_row['service'];?>" size="50" /></td>
                      </tr>
                      <tr>
                        <th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 품질보증</th>
                        <td><input name="warranty" type="text" class="form-control" value="<?=$update_row['warranty'];?>" size="50" /></td>
                      </tr>
                      <tr>
                        <th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 취급시 주의사항</th>
                        <td><textarea name="caution" id="caution" class="form-control" style="width:400px; height:200px" /><?=stripslashes($update_row['caution']);?></textarea></td>
                      </tr>
                      <tr>
                        <th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 전체 재고</th>
                        <td>
                          <input type="text" name="stock" class="form-control" size="5" value="<?=$update_row['stock'];?>" /> 개
                          <p class="help-block"><i class="fa fa-exclamation-triangle"></i> 선택사항이 있을 경우 각 옵션재고를 합한 전체 재고를 입력하세요.</p>
                        </td>
                      </tr>
                      <tr>
                        <th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 검색어</th>
                        <td>
                          <input name="tag" type="text" class="form-control" value="<?=$update_row['tag'];?>" size="100" />
                          <p class="help-block"><i class="fa fa-exclamation-triangle"></i> ',(콤마)' 로 구분하세요.</p>
                        </td>
                      </tr>
                      -->        <!--                 <tr>
                        <th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 재입고 예정일</th>
                        <td><input type="text" class="form-control" class="w8em format-y-m-d divider-dash highlight-days-67 range-low-2008-01-01 no-transparency" name="restock_date" id="sd2" value="<?=$update_row['restock_date'];?>" size="10" />
                        <?php
if ($update_row['restock_date'] == "1111-00-00") {
    $chk = "checked='checked'";
}

?>
                        <input type="checkbox" name="no_restock"  value="Y" <?=$chk;?> /> 재입고 미정
                      </td>
                    </tr> -->
                    <tr>
                      <th colspan="2">
                        <i class="fa fa-picture-o"></i> 상품 이미지(소 이미지는 대1 이미지를 사용해 자동생성됩니다.)
                        <p class="help-block"><i class="fa fa-exclamation-triangle"></i>  이미지 사이즈는 최대 500x500</p>
                      </th>
                    </tr>
                    <tr >
                      <th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 대 1</th>
                      <td><input type="file" class="form-control" name="b_image1" size="30" />
                      <?php if ($update_row['b_image1'] == 'Y') {?>
                      <img src="<?=$update_row['b_image1_name'];?>" width="50" height="50" />
                      <?php } else {?>
                      <img src="http://placehold.it/50x50">
                    <?php }
?></td>
                  </tr>
                  <tr>
                    <th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 대 2</th>
                    <td><input type="file" class="form-control" name="b_image2" size="30" />
                    <?php if ($update_row['b_image2'] == 'Y') {?>
                    <img src="<?=$update_row['b_image2_name'];?>" width="50" height="50" />
                    <?php } else {?>
                    <img src="http://placehold.it/50x50">
                  <?php }
?></td>
                </tr>
                <tr >
                  <th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 대 3</th>
                  <td><input type="file" class="form-control" name="b_image3" size="30" />
                  <?php if ($update_row['b_image3'] == 'Y') {?>
                  <img src="<?=$update_row['b_image3_name'];?>" width="50" height="50" />
                  <?php } else {?>
                  <img src="http://placehold.it/50x50">
                <?php }
?></td>
              </tr>
              <tr>
                <th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 대 4</th>
                <td><input type="file" class="form-control" name="b_image4" size="30" />
                <?php if ($update_row['b_image4'] == 'Y') {?>
                <img src="<?=$update_row['b_image4_name'];?>" width="50" height="50" />
                <?php } else {?>
                <img src="http://placehold.it/50x50">
              <?php }
?></td>
            </tr>
            <tr >
              <th><img src="../images/icn_05.gif" width="24" height="14" alt="선택" /> 대 5</th>
              <td><input type="file" class="form-control" name="b_image5" size="30" />
              <?php if ($update_row['b_image5'] == 'Y') {?>
              <img src="<?=$update_row['b_image5_name'];?>" width="50" height="50" />
              <?php } else {?>
              <img src="http://placehold.it/50x50">
            <?php }
?></td>
          </tr>
          <tr>
            <th><img src="../images/icn_04.gif" width="24" height="14" alt="필수" /> 상세설명</th>
            <td>
              <textarea name="contents" class="form-control" id="contents" style="width:100%; height:600px"><?=stripslashes($update_row['contents']);?></textarea>
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
<input type="hidden" name="mode" value="<?=$mode;?>" />
<input type="hidden" name="pmode" value="<?=$pmode;?>" />
<input type="hidden" name="p_num" value="<?=$p_num;?>" />
<input type="hidden" name="page" value="<?=$page;?>" />
<input type="hidden" name="old_l_cate" value="<?=$update_row['category_m'];?>" />
<button class="btn btn-success" onclick="send_post('contents');">등록</button>
<a type="button" class="btn btn-default" href="top_pro_list.php?pmode=<?=$pmode;?>lcode=<?=$lcode;?>&mcode=<?=$mcode;?>&scode=<?=$scode;?>&page=<?=$page;?>">취소</a>
<a type="button" class="btn btn-danger" href="pro_delete.php?p_num=<?=$p_num;?>&amp;lcode=<?=$lcode;?>&amp;mcode=<?=$mcode;?>&amp;scode=<?=$scode;?>&amp;page=<?=$page;?>" onclick="return confirm('정말 삭제하시겠습니까?')">삭제</a>
</div>
</div>
</form>
</section>
</section>
<!--main content end-->
</section>
<!-- js placed at the end of the document so the pages load faster -->
<script src="/js/vendor/jquery-2.2.0.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/admin/js/jquery.dcjqaccordion.2.7.js" class="include" type="text/javascript" ></script>
<script src="/admin/js/jquery.scrollTo.min.js"></script>
<script src="/admin/js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="/admin/js/respond.min.js" ></script>
<!--common script for all pages-->
<script src="/admin/js/common-scripts.js"></script>
<!-- custom scripts -->
<script src="/js/global.js" ></script>
<script src="/admin/js/admin.js" ></script>
<script src="js/HuskyEZCreator.js" charset="utf-8"></script>
<script>
var oEditors = [];
nhn.husky.EZCreator.createInIFrame({
oAppRef: oEditors,
elPlaceHolder: "contents",
sSkinURI: "SmartEditor2Skin.html",
htParams : {bUseToolbar : true,
fOnBeforeUnload : function(){
//alert("아싸!");
}
}, //boolean
fOnAppLoad : function(){
//예제 코드
//oEditors.getById["ir1"].exec("PASTE_HTML", ["로딩이 완료된 후에 본문에 삽입되는 text입니다."]);
},
fCreator: "createSEditor2"
});
</script>
</body>
</html>