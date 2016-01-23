<?php
//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
include "../include/graph.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
  <head>
    <title>B2B SCM</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="../css/admin_layout.css" />
    <link rel="stylesheet" type="text/css" href="../chrometheme/chromestyle.css" />
    <script language="JavaScript" src="../../js/global.js" ></script>
    <script language="JavaScript" src="../js/admin.js" ></script>
    <script language="JavaScript" src="../js/chrome.js" >
    /***********************************************
    * Chrome CSS Drop Down Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
    * This notice MUST stay intact for legal use
    * Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
    ***********************************************/
    </script>
    <!-- popup calendar -->
    <script type="text/javascript" src="../js/datepicker.js"></script>
    <link href="../css/datepicker.css" rel="stylesheet" type="text/css" />
    <!-- popup calendar end -->
  </head>
  <body>
    <!-- wrapper -->
    <div id="wrapper">
      <!-- header -->
      <?php
      include "../include/admin_top.php";
      ?>
      <!-- header end -->
      <div id="bodyblock">
        <!-- contents -->
        <div id="content">
          <form name="f" method="get" action="sale_list.php">
            <input type="hidden" name="mode" value="date" />
            <fieldset>
              <legend>날짜 검색</legend>
              <p>
              <label for="sd">시작일 :</label>
              <input type="text" class="w8em format-y-m-d divider-dash highlight-days-67 range-low-2006-01-01 no-transparency" name="date1" id="sd" value="" size="10" />
              </p>
              <p>
              <label for="ed">종료일 :</label>
              <input type="text" class="w8em format-y-m-d divider-dash highlight-days-67 range-low-2006-01-01 no-transparency" name="date2" id="ed" value="" size="10" />
              </p>
              <input type="image" src="../images/search_btn.gif" style="background-color:#FFFFFF; border:none;vertical-align: middle; " />
            </fieldset>
          </form>
          <?php
          $total = 0; //공급가합
          $sales = array();
          if($mode == "date") {
            $search_qry = " AND createdate BETWEEN '$date1' AND '$date2' ";
            $date = "(".$date1." ~ ".$date2.")";
          }else {
            $today = date("Y-m-d");
            $search_qry = " AND createdate='$today' ";
            $date = "(".$today." ~ ".$today.")";
          }
          ?>
          <table summary="view total order list">
            <caption>
            <?=$date?> 베스트상품 판매 리스트
            </caption>
            <thead>
              <tr class="odd">
                <th scope="col">번호</th>
                <th scope="col">상품명</th>
                <th scope="col">옵션</th>
                <th scope="col">수량</th>
              </tr>
            </thead>
            <tbody>
              <?php
                        
              //1. 전체 주문을 구한다.
              $sql = "SELECT * FROM mall_order WHERE cancel='N' AND status='8'  $search_qry ORDER BY num DESC";
              $res = mysqli_query($connect, $sql);
                //2. 각 주문에서 제품코드를 구한다.
                for($i=0; $row = mysqli_fetch_array($res); $i++) {
                  $a_goods_fk = explode(",", $row['goods_fk']);
                  $mod_volume = explode(",", $row['mod_count']); //변경된 수량
                  $mod_price = explode(",", $row['mod_price']); //변경된 수량
                  $option = explode(",", $row['goods_kind']); //옵션정보
                  
                  //판매금액 집계를 위한 배열
                    $sales[] = array(num=>$row['num'], createdate=>$row['createdate'], sub_total=>$row['last_amount']);
                    $total += $row['last_amount'];
                

                  //3. 해당 주문에서 해당 공급업체의 상품이 있는지 확인한다.
                  for($j=0; $j<sizeof($a_goods_fk); $j++){
                    $p_sql="SELECT * FROM products WHERE num='$a_goods_fk[$j]' ";
                    $p_result = mysqli_query($connect, $p_sql);
                    $p_row = mysqli_fetch_array($p_result);
                    $p_no = mysqli_num_rows($p_result);
                    
                    //$offer_price = $p_row['retail_price'];
                    $offer_price = $mod_price[$j];
                    //$sub_total = $offer_price * $mod_volume[$j];
                
                    $goods[] = array(num=>$p_row['num'], company=>$p_row['company'], name=>$p_row['name'], option=>$option[$j], quantity=>$mod_volume[$j]);
                      //$total += $sub_total;
                  }//for end
                }//for end

                    // echo "<pre>";
                    // print_r($goods);
                    // echo "</pre>";

              function cmp($a, $b)
              {
                if ($a["quantity"] == $b["quantity"]) {
                  return 0;
                }
                
                return ($a["quantity"] > $b["quantity"]) ? -1 : 1;
                
              //return strcmp($a["quantity"], $b["quantity"]);
              }


              if($p_no) {
                foreach($goods as $values) {
                  $new[$values['num']]['company']   = $values['company'];
                  $new[$values['num']]['name']      = $values['name'];
                  $new[$values['num']]['option']    = $values['option'];
                  $new[$values['num']]['quantity'] += $values['quantity'];
              }

                   
                usort($new, "cmp");

                    echo "<pre>";
                    print_r($new);
                    echo "</pre>";


                $i=0;
                foreach($new as $row) {

              ?>
              <tr>
                <td><?=$i+1?></td>
                <td class="left">[<?=$row['company']?>] <?=$row['name']?></td>
                <td><?=$row['option']?></td>
                <td><?=$row['quantity']?>
                개</td>
              </tr>
              <?php
                  if($i!=0) {
                    $temp_qty .= ",";
                    $temp_name .= ",";
                  }
                    $temp_qty .= $row['quantity'];
                    $temp_name .= $row['name'];
                  
                  $i++;
                }
              
                
              ?>
            </tr>
          </tbody>
        </table>
        <table summary="graph">
          <caption>
          판매수량별 그래프
          </caption>
          <tbody>
            <tr>
              <td><?php
                          $q = explode(",",$temp_qty);
                          $n = explode(",",$temp_name);
                          draw_graph("[판매수량 통계그래프]", 800, 545, 20, $n, $q, "../images/graph1.png");
                ?>
              </td>
            </tr>
          </tbody>
        </table>
        <table summary="view total order list">
          <caption>
          판매금액 집계
          </caption>
          <thead>
            <tr class="odd">
              <th scope="col">번호</th>
              <th scope="col">판매일</th>
              <th scope="col">확정액합(VAT 별도)</th>
            </tr>
          </thead>
          <tbody>
            <?php
              foreach($sales as $key => $values) {
                $sum[$values['createdate']] += $values['sub_total'];
              }
              
              reset($sum);
              ksort($sum);
              
            $day = array("일","월","화","수","목","금","토");
              $i=0;
              foreach($sum as $date=>$sub_total) {
            ?>
            <tr>
              <td><?=$i+1?></td>
              <td><?=$date?> (<?=$day[date("w",strtotime($date))]?>)</td>
              <td class="won"><?=number_format($sub_total)?></td>
            </tr>
            <?php
                
                if($i!=0) {
                  $temp_createdate .= ",";
                  $temp_total .= ",";
                }
                  $temp_createdate .= $date;
                  $temp_total .= $sub_total;
                
                $i++;
              }
              
            ?>
          </tr>
          
          <tr class="odd">
            <td class="won" colspan="2"><strong>확정금액 총합:</strong></td>
            <td class="won"><strong>
            <?=number_format($total)?></strong></td>
          </tr>
        </tbody>
      </table>
      <table summary="graph">
        <caption>
        판매금액별 그래프
        </caption>
        <tbody>
          <tr>
            <td><?php
                        $n = explode(",",$temp_createdate);
                        $t = explode(",",$temp_total);
                      draw_graph("[판매금액 통계그래프]", 800, 545, 20, $n, $t, "../images/graph2.png");
              ?>
            </td>
          </tr>
        </tbody>
      </table>
      <?php
      } else {
      ?>
      <tr>
        <td colspan="4"><p>조회 결과가 없습니다.</p></td>
      </tr>
    </tbody>
  </table>
  <?php
  }
  ?>
</div>
<!-- contens end -->
</div>
<!-- bodyblock end -->
<!-- copyright -->
<?php
include "../include/admin_bottom.php";
?>
<!-- copyright  end -->
</div>
<!-- wrapper end -->
</body>
</html>