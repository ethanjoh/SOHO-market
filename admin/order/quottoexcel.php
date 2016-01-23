<?php
$file_name = "quotation_".date("Y-m-d");

header( "Content-type: application/vnd.ms-excel; charset=utf-8" );
header( "Content-Disposition: attachment; filename=$file_name.xls" );
header( "Content-Description: PHP4 Generated Data" );

//������ ���� ����
include "../../util/admin_auth.php";
// ����Ÿ���̽� �������� �� ��Ÿ����
include "../../util/config.php";
// ���� ��ƿ�Լ�
include "../../util/util.php";

// MySQL ����
$connect=my_connect($host,$dbid,$dbpass,$dbname);
$oid = set_var($_GET['oid']);

$today = date("Y-m-d");

//������ ����
$query = "SELECT * FROM admin_setup WHERE type='1'";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_array($result);

$address = $row['addr1']." ".$row['addr2'];

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="600" border="1" cellpadding="0" cellspacing="0" bordercolor="#3399FF">
        <tr>
          <td colspan="8"><div align="center"><font size="4">거 래 명 세 서</font></div></td>
        </tr>
        <tr>
          <td colspan="2"><div align="center">
              <p>&nbsp;</p>
              <?php
					//주문정보
					$or_qry = "SELECT * FROM mall_order WHERE num = '$oid' ";
					$or_res = mysqli_query($connect, $or_qry);
					$or_row = mysqli_fetch_array($or_res);
					?>
              <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td height="34" align="center"><font size="3"><u>
                    <?=$or_row['createdate']?>
                    </u></font></td>
                </tr>
                <tr>
                  <td height="30" align="center"><font size="3"><u>
                    <?php
					$a_goods_fk = explode(",", $or_row['goods_fk']);
					$mod_price = explode(",", $or_row['mod_price']); //����� ���ް�
					$org_volume = explode(",", $or_row['goods_count']);
					$mod_volume = explode(",", $or_row['mod_count']); //����� ����
					$option = explode(",", $or_row['goods_kind']); //�ɼ�

					$buyer_qry = "SELECT * FROM member WHERE id='$or_row[user_id]'";
				    $buyer_res = mysqli_query($connect, $buyer_qry);
					$buyer_row = mysqli_fetch_array($buyer_res);

					$address2 = $buyer_row['o_addr1']." ".$buyer_row['o_addr2'];

				  	if($or_row['recipient_name'])
						echo $buyer_row['company_name']."&nbsp;-> ".$or_row['recipient_name']."&nbsp;&nbsp;귀 하</u></font></td>";
					else
						echo $buyer_row['company_name']."&nbsp;&nbsp;&nbsp;귀 하</u></font></td>";

  				  ?>
                </tr>
                <tr>
                  <td align=center><p></p>
                    <font size="2"><u>아래와 같이 계산합니다.</u></font>
                    </p></td>
                </tr>
              </table>
            </div></td>
          <td colspan="6"><table width="100%" height="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#3399FF">
              <tr>
                <td height="24" colspan="6"><div align="center"><font size="2">공&nbsp;&nbsp;급&nbsp;&nbsp;자</font></div></td>
              </tr>
              <tr>
                <td width="66"><p align="center"><font size="1">등 록<br>
                    번 호</font></p></td>
                <td colspan="5"><div align="center"><strong><font size="2">
                    <?=$row['license_no']?>
                    </font></strong></div></td>
              </tr>
              <tr>
                <td><div align="center"><font size="1">상 호</font></div></td>
                <td width="100"><div align="center"><font size="1"><?=$row['company_name']?></font></div></td>
                <td width="36"><div align="center"><font size="1">성 명</font> </div></td>
                <td width="174">
                  <div style="position: relative; background: url(http://www.prixe.co.kr/admin/images/sign/stamp.gif) no-repeat; background-position: 20px 0px; height: 60px; width: auto;">
                    <div style="position: absolute; bottom: 25px; margin:auto;"><font size="1"><?=$row['ceo']?> (인)</font></div>
                  </div>
                </td>
              </tr>
              <tr>
                <td><div align="center"><font size="1">사 업 장<br>
                    주 소 </font></div></td>
                <td colspan="5"><div align="center"><font size="1">
                    <?=$address?>
                    </font></div></td>
              </tr>
              <tr>
                <td height="24"><div align="center"><font size="1">업 태</font></div></td>
                <td><div align="center"><font size="1">
                    <?=$row['category1']?>
                    </font></div></td>
                <td><div align="center"><font size="1">종 목</font></div></td>
                <td><div align="center"><font size="1">
                    <?=$row['category2']?>
                    </font></div></td>
              </tr>
            </table></td>
        </tr>
        <tr>
          <td colspan="8" height=2></td>
        </tr>
        <tr>
          <td height=20><div align="center">상 품 명</div></td>
          <td><div align="center">옵 션</div></td>
          <td><div align="center">주 문</div></td>
          <td><div align="center">출 고</div></td>
          <td><div align="center">소비자가</div></td>
          <td><div align="center">단 가</div></td>
          <td><div align="center">공급가액</div></td>
          <td><div align="center">세 액</div></td>
        </tr>
        <?php
		 //�ֹ���ǰ ������ �ҷ��ɴϴ�.
		for($i=0; $i<sizeof($a_goods_fk); $i++) {
			$pro_sql="SELECT * FROM products WHERE num='$a_goods_fk[$i]'";
			$pro_result = mysqli_query($connect, $pro_sql);
			$pro_row = mysqli_fetch_array($pro_result);

			$goods_name= "[".$pro_row['company']."] ".$pro_row['name'];

		   //상품옵션 품절표시
		   //상품 옵션이 있는지 확인 후 진행
		   if($option[$i] != "") {
			   //장바구니의 옵션과 제품정보를 비교하여 품절옵션이 있는지 확인
			   $t_opt = explode(",", $pro_row['opt']); //제품의 옵션명을 배열로 만들어준다
			   $t_opt_stock = explode(",", $pro_row['opt_stock']); //제품의 옵션재고를 배열로 만들어준다

			   //옵션의 문자열 비교
			   for($j=0;$j<count($t_opt);$j++) {
				  $str = strcmp($t_opt[$j], $option[$i]);

				  if(!$str) { //문자열이 같다면 문자열 대체
					  if($t_opt_stock[$j] == "0")
						  $option[$i] .= " (품절)";
					  elseif($t_opt_stock[$j] == "-1")
						  $option[$i] .= " (단종)";
					  else
						  $option[$i] = $t_opt[$j];
				  }

			   }//end of for loop
		   }//end of if clause


			echo "<tr bgcolor=\"#ffffff\">
					<td align=\"left\"><font size=\"1\">".$goods_name."</font></td>\n
					<td align=\"center\"><font size=\"1\">".$option[$i]."</font></td>\n
					<td align=\"center\"><font size=\"1\">".$org_volume[$i]."</font></td>\n
					<td align=\"center\"><font size=\"1\">".$mod_volume[$i]."</font></td>\n";

			if ($pro_row['sale_price']) {
				  echo "<td align=\"right\"><font size=\"1\"><s>".number_format($pro_row['retail_price'])."</s><br/>".number_format($pro_row['sale_price'])."</font>\n";
			  }else {
			  	  echo "<td align=\"right\">".number_format($pro_row['retail_price'])."\n";
			  }

			echo   "<td align=\"right\"><font size=\"1\">".number_format($mod_price[$i])."</font></td>\n
					<td align=\"right\"><font size=\"1\">".number_format($mod_price[$i]*$mod_volume[$i])."</font></td>\n
					<td align=\"right\"><font size=\"1\">".number_format(($mod_price[$i]*$mod_volume[$i])*0.1)."</font></td>\n
					</tr>\n";

					$totalSum = $totalSum+(int)$mod_price[$i]*(int)$mod_volume[$i];
					//$vatSum = $vatSum+(int)($mod_price[$i]*$mod_volume[$i])*0.1;
					$t_count = $t_count + (int)$org_volume[$i];
					$mt_count = $mt_count + (int)$mod_volume[$i];

  }

  echo "<tr>\n";
  echo "<td class=\"left\">▶ SUB TOTAL </td>
		 <td>&nbsp;</td>
         <td align=center><font color='blue'>$t_count</font>개</td>
         <td align=center><font color='blue'>$mt_count</font>개</td>
         <td>&nbsp;</td>
		 <td>&nbsp;</td>
         <td class=\"won\"><strong>".number_format($totalSum)."</strong></td>
         <td class=\"won\"><strong>".number_format($totalSum*0.1)."</strong></td>
		 </tr>\n";


  $final = $totalSum + $last_cost2;

  echo "<tr>\n";
  echo "<td colspan=\"6\" class=\"left\"><strong>▶ TOTAL(inc.VAT) : </strong></td>\n
         <td class=\"won\" colspan=\"2\"><strong>".number_format($final*1.1)."</strong></td>\n
		 </tr>\n";

  echo "<tr>
		 <td colspan=\"8\">
	        <table width=\"100%\">
		    <tr>
        	    <td align=left><font size=\"1\">TEL :".$row['tel'].", FAX :  ".$row['fax']."</font> (주문마감시간 평일 오후 2시, 토/일 휴무)</td>
		    </tr>
		    </table>
		</td>
		</tr> \n";
  ?>
      </table></td>
  </tr>
</table>
<br>
</table>
</body></html>
