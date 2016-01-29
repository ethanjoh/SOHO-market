<?php
include "../util/config.php";
// 각종 유틸함수
include "../util/util.php";
// MySQL 연결
$connect = my_connect($host, $dbid, $dbpass, $dbname);

if (!$_COOKIE['p_sid']) {
    $SID = md5(uniqid(rand()));
    SetCookie("p_sid", $SID, 0, "/");
}

//메타정보
$info_query = "SELECT * FROM admin_setup";
$info_res   = mysqli_query($connect, $info_query);
$info       = mysqli_fetch_array($info_res);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="<?=$info['keywords'];?>" />
<meta name="description" content="<?=$info['description'];?>" />
<title><?=$info['site_name'];?></title>
<link rel="stylesheet" type="text/css" href="../css/shop_layout.css" />
<script language="JavaScript" src="../js/global.js"></script>
<script language="JavaScript" src="../js/shopping.js"></script>
<!-- category -->
<link rel="stylesheet" type="text/css" href="../css/ddsmoothmenu.css" />
<!--[if lte IE 7]>
<style type="text/css">
html .ddsmoothmenu{height: 1%;} /*Holly Hack for IE7 and below*/
</style>
<![endif]-->
<script type="text/javascript" src="../js/jquery-1.2.6.pack.js"></script>
<script type="text/javascript" src="../js/ddsmoothmenu.js">
/***********************************************
* Smooth Navigational Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/
</script>
<!-- category end -->
<link rel="stylesheet" type="text/css" href="../css/tabcontent.css" />
<script type="text/javascript" src="../js/tabcontent.js">
/***********************************************
* Tab Content script v2.2- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/
</script>
</head>
<body>
<div id="wrapper">
  <?php
include "../include/top_menu.php";
?>
  <!-- main content -->
  <div id="bodyblock">
    <div id="content">
      <table summary="contracts">
        <thead>
          <tr>
            <th><p>회원 및 비회원 구매안내</p></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><ul class="reg2">
                <li>회원께서는 상단메뉴에서 로그인을 먼저 하신 후 구매해 주시기 바랍니다.</li>
                <li>비회원께서는 하단에서 회원가입을 먼저 하신 후 구매하시면 이후 이용하시는데 매우 편리합니다.</li>
                <!--<li>회원가입없이 구매를 원하실 경우 하단의 비회원 구매를 눌러주세요. </li>
                <li>비회원은 한번에 한 상품만 구매가 가능합니다. 장바구니 기능을 이용하시려면 회원 가입을 해주세요.</li>-->
              </ul></td>
          </tr>
          <tr>
            <td><ul id="contracts" class="shadetabs">
                <li><a href="#" rel="contract1" class="selected">가입안내</a></li>
                <li><a href="#" rel="contract2">이용약관</a></li>
              </ul>
              <div style="border:1px solid gray; width:900px; margin-bottom: 1em; padding: 10px">
                <div id="contract1" class="tabcontent">
                  <?php include_once 'inc/reg_info.html';?>
                  <br />
                </div>
                <div id="contract2" class="tabcontent">
                  <?php include_once 'inc/contract1.html';?>
                  <br />
                </div>
                <script type="text/javascript">
			var contracts=new ddtabcontent("contracts")
			contracts.setpersist(true)
			contracts.setselectedClassTarget("link") //"link" or "linkparent"
			contracts.init()
		</script>
              </div></td>
          </tr>
        </tbody>
      </table>
      <table summary="button">
        <tbody>
          <tr class="odd">
            <td><div class="clear"><a class="button" href="register_form.php" onClick="this.blur();"><span>기업회원 가입신청</span></a><!-- <a class="button" href="register_form2.php" onClick="this.blur();"><span>개인회원 가입신청</span></a>--><a class="button" href="info.php?p=overseas" onClick="this.blur();"><span>Overseas buyer</span></a><a class="button" href="../shop/index.php" onClick="this.blur();"><span>취소</span></a></div>
                <form name="form" method="post">
                  <input type="hidden" name="pnum" value="<?=$pnum;?>">
                  <input type="hidden" name="lcode" value="<?=$lcode;?>">
                  <input type="hidden" name="mcode" value="<?=$mcode;?>">
                  <input type="hidden" name="scode" value="<?=$scode;?>">
                  <input type="hidden" name="page" value="<?=$page;?>">
                  <input type="hidden" name="amount" value="<?=$amount;?>">
                  <input type="hidden" name="products_count" value="<?=$products_count;?>">
                  <input type="hidden" name="selected_opt" value="<?=$selected_opt;?>">
                  <!--<a class="button" href="#" onClick="this.blur();javascript:goDirOrder2(document.form);"><span>비회원 구매</span></a>-->
                </form>
              </div></td>
          </tr>
        </tbody>
      </table>
    </div>
    <!-- main content end -->
  </div>
  <!-- bodyblock end -->
  <?php
include "../include/bottom.php";
?>
</div>
<!-- wrapper end -->
</body>
</html>
