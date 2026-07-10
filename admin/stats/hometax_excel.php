<?php
$file_name = "hometax_excel_" . date("Y-m-d");

header("Content-type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=$file_name.xls");
header("Content-Description: PHP4 Generated Data");

include_once "../include/admin_auth.php";
include_once "../../util/util.php";

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<title>홈택스 업로드용 엑셀양식</title>
<meta charset="UTF-8" />
<style>
br {
  mso-data-placement:same-cell;
}

body {
  font-family: "돋움", sans-serif;
}

.ess {
  font-size: 11px;
  text-align: center;
  background-color: rgb(255,204,153);
}

.non-ess {
  font-size: 11px;
  text-align: center;
  background-color: rgb(204,255,204);
}

.txt {
  font-size: 11px;
}

.fntRed {
  color: red;
  font-size: 14px;
}

.fntTitle {
  font-weight: bold;
  font-size: 18px;
}
</style>
</head>
<body>
<table border="1">
  <tbody>
    <tr>
      <td colspan="59" class="fntTitle">엑셀 업로드 양식(전자세금계산서-일반(영세율))</td>
    </tr>
    <tr>
      <td colspan="59" class="fntRed">
        ★주황색으로 표시된 부분은 필수입력항목으로 반드시 입력하셔야 합니다.<br>
        ★아래 '항목설명' 시트를 참고하여 작성하시기 바랍니다.
      </td>
    </tr>
    <tr>
      <td colspan="59" class="fntRed">
        ★실제 업로드할 DATA는 7행부터 입력하여야 합니다. 최대 100건까지 입력이 가능하나, 발급은 최대 10건씩 처리가 됩니다.(100건 초과 자료는 처리 안됨)<br>
        ★임의로 행을 추가하거나 삭제하는 경우 파일을 제대로 읽지 못하는 경우가 있으므로, 주어진 양식안에 반드시 작성을 하시기 바랍니다.
      </td>
    </tr>
    <tr>
      <td colspan="59" class="fntRed">
        ★전자(세금)계산서 종류는 엑셀 업로드 양식에 따라 해당 전자(세금)계산서 종류코드를 반드시 입력하셔야 합니다.<br>
        ★품목은 1건이상 입력해야 합니다.<br>
        ★공급받는자 등록번호는 사업자등록번호, 주민등록번호를 입력할 수 있습니다. <br>
        외국인인 경우 '9999999999999'를 입력하시고, 비고란에  외국인등록번호 또는 여권번호를 입력하시기 바랍니다.
      </td>
    </tr>
    <tr>
      <td colspan="59"></td>
    </tr>
    <tr>
      <td class="ess">전자(세금)계산서 종류<br>(01:일반, 02:영세율)</td>
      <td class="ess">작성일자</td>
      <td class="ess">공급자 등록번호<br>("-" 없이 입력)</td>
      <td class="non-ess">공급자<br> 종사업장번호</td>
      <td class="ess">공급자 상호</td>
      <td class="ess">공급자 성명</td>
      <td class="non-ess">공급자 사업장주소</td>
      <td class="non-ess">공급자 업태</td>
      <td class="non-ess">공급자 종목</td>
      <td class="non-ess">공급자 이메일</td>
      <td class="ess">공급받는자 등록번호<br>("-" 없이 입력)</td>
      <td class="non-ess">공급받는자<br>종사업장번호</td>
      <td class="ess">공급받는자 상호</td>
      <td class="ess">공급받는자 성명</td>
      <td class="non-ess">공급받는자 사업장주소</td>
      <td class="non-ess">공급받는자 업태</td>
      <td class="non-ess">공급받는자 종목</td>
      <td class="non-ess">공급받는자 이메일1</td>
      <td class="non-ess">공급받는자 이메일2</td>
      <td class="ess">공급가액</td>
      <td class="ess">세액</td>
      <td class="non-ess">비고</td>
      <td class="ess">일자1<br>(2자리, 작성년월 제외)</td>
      <td class="non-ess">품목1</td>
      <td class="non-ess">규격1</td>
      <td class="non-ess">수량1</td>
      <td class="non-ess">단가1</td>
      <td class="ess">공급가액1</td>
      <td class="ess">세액1</td>
      <td class="non-ess">품목비고1</td>
      <td class="non-ess">일자2<br>(2자리, 작성년월 제외)</td>
      <td class="non-ess">품목2</td>
      <td class="non-ess">규격2</td>
      <td class="non-ess">수량2</td>
      <td class="non-ess">단가2</td>
      <td class="non-ess">공급가액2</td>
      <td class="non-ess">세액2</td>
      <td class="non-ess">품목비고2</td>
      <td class="non-ess">일자3<br>(2자리, 작성년월 제외)</td>
      <td class="non-ess">품목3</td>
      <td class="non-ess">규격3</td>
      <td class="non-ess">수량3</td>
      <td class="non-ess">단가3</td>
      <td class="non-ess">공급가액3</td>
      <td class="non-ess">세액3</td>
      <td class="non-ess">품목비고3</td>
      <td class="non-ess">일자4<br>(2자리, 작성년월 제외)</td>
      <td class="non-ess">품목4</td>
      <td class="non-ess">규격4</td>
      <td class="non-ess">수량4</td>
      <td class="non-ess">단가4</td>
      <td class="non-ess">공급가액4</td>
      <td class="non-ess">세액4</td>
      <td class="non-ess">품목비고4</td>
      <td class="non-ess">현금</td>
      <td class="non-ess">수표</td>
      <td class="non-ess">어음</td>
      <td class="non-ess">외상미수금</td>
      <td class="ess">영수(01),<br>청구(02)</td>
    </tr>

<?php

$date1     = $_GET['date1'];
$date2     = $_GET['date2'];
$makedate  = date("m.d");
$makedate2 = date("d");

$info_query = "SELECT * FROM admin_setup";
$info_res   = mysqli_query($connect, $info_query);
$info       = mysqli_fetch_array($info_res);

if (empty($date1)) {
    $date1 = $date1;
}

if (empty($date2)) {
    $date2 = $date2;
}

//1. 기간별 주문을 구한다.
$sql = "SELECT * FROM mall_order
            WHERE cancel='N' AND status='8' AND createdate BETWEEN '$date1' AND '$date2'
            ORDER BY num DESC";
$res = mysqli_query($connect, $sql);

$total = 0; //공급가합
$sales = array();

//2. 각 주문에서 제품코드를 구한다.
for ($i = 0; $row = mysqli_fetch_array($res); $i++) {
    //판매금액 집계를 위한 배열
    $sales[] = array("num" => $row['num'], "id" => $row['user_id'], "sub_total" => $row['last_amount']);
    $total += $row['last_amount'];
} //for end

$sum = array();
foreach ($sales as $key => $values) {
    //$sum[$values['company_name']] += $values['sub_total'];
    @$sum[$values['id']] += $values['sub_total'];
}

reset($sum);
arsort($sum);

$i = 0;
foreach ($sum as $id => $sub_total) {

    // 공급받는자 상호
    $c_sql    = "SELECT * FROM member WHERE id='$id' ";
    $c_result = mysqli_query($connect, $c_sql);
    $c_row    = mysqli_fetch_array($c_result);

    ?>
    <tr>
      <td class="ess" style="mso-number-format:\@">01</td>
      <td class="ess" style="mso-number-format:mm\/dd"><?php echo $makedate; ?></td>
      <td class="ess" style="mso-number-format:\@"><?php echo $info['license_no']; ?></td>
      <td class="txt"></td>
      <td class="ess"><?php echo $info['company_name']; ?></td>
      <td class="ess"><?php echo $info['ceo']; ?></td>
      <td class="txt"><?php echo $info['addr1']; ?> <?php echo $info['addr2']; ?></td>
      <td class="txt"><?php echo $info['category1']; ?></td>
      <td class="txt"><?php echo $info['category2']; ?></td>
      <td class="txt"><?php echo $info['email']; ?></td>
      <td class="ess" style="mso-number-format:\@"><?php echo $c_row['license_no']; ?></td>
      <td class="txt"></td>
      <td class="ess"><?php echo $c_row['company_name']; ?></td>
      <td class="ess"><?php echo $c_row['ceo']; ?></td>
      <td class="txt"><?php echo $c_row['o_addr1']; ?> <?php echo $c_row['o_addr2']; ?></td>
      <td class="txt"><?php echo $c_row['category1']; ?></td>
      <td class="txt"><?php echo $c_row['category2']; ?></td>
      <td class="txt"><?php echo $c_row['md_email']; ?></td>
      <td class="txt"></td>
      <td class="ess"><?php echo number_format($sub_total); ?></td>
      <td class="ess"><?php echo number_format($sub_total * .1); ?></td>
      <td class="txt"></td>
      <td class="ess" style="mso-number-format:\@"><?php echo $makedate2; ?></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="ess"><?php echo number_format($sub_total); ?></td>
      <td class="ess"><?php echo number_format($sub_total * .1); ?></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="txt"></td>
      <td class="ess" style="mso-number-format:\@">02</td>
    </tr>

<?php
}
; // for loop end

?>
  </tbody>
</table>
</body>
</html>