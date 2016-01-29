<?php
include 'config.php';

//메인에 팝업공지 띄우기
function show_popup()
{
    echo "<script language=\"Javascript\">\n
			if ( getCookie( \"Notice\" ) != \"done\" ) {
	     		noticeWindow = window.open(\"../shop/popup.html\", \"notice\", \"width=400, height=500,resizable=no,status=no,scrollbars=yes,menubar=no\");
				noticeWindow.opener = self;
			}
	   </script> \n";
}

function show_modal($connect)
{
    $query  = "SELECT * FROM popup where 1";
    $result = mysqli_query($connect, $query);
    $rows   = mysqli_fetch_array($result);

    if ($rows['chk'] == 'Y') {

        echo "<div id=\"notice\" class=\"reveal-modal\">\n";
        echo "	<h2>공지사항</h2>\n";
        echo "	<div id=\"popup\" title=\"notice\">\n";
        echo $rows['contents'];
        echo "		<form name=\"formpop\">\n";
        echo "  	<table>\n";
        echo "  		<tr>\n";
        echo "				<td align=\"center\">\n";
        echo "					<input type=\"checkbox\" id=\"chkNotice\" name=\"chkNotice\">\n";
        echo "					<span style=\"font-size:9pt;color:#000000\">오늘 이 창을 다시 열지 않음</span>\n";
        echo "					<input type=\"button\" id=\"close\" onclick=\"closeWin()\" value=\"닫기\">\n";
        echo "				</td>\n";
        echo "			</tr>\n";
        echo "		</table>\n";
        echo "		</form>\n";
        echo "	</div>\n";
        echo "	<a class=\"close-reveal-modal\">&#215;</a>\n";
        echo "</div>\n";

    }

}

//메인 화면에 게시판 보여주기
function show_bbs($bbs_name, $connect)
{
    $query  = "SELECT * FROM code WHERE code='$bbs_name' ORDER BY num";
    $result = mysqli_query($connect, $query);
    $total  = mysqli_num_rows($result);
    $rows   = mysqli_fetch_array($result);

    if ($total == 0) {
        echo "<p>생성된 게시판이 없습니다.</p>";
    } else {
        $board   = 'bbs_' . $bbs_name;
        $query2  = "SELECT * FROM $board WHERE 1 ORDER BY main_no DESC LIMIT 5";
        $result2 = mysqli_query($connect, $query2);
        $total2  = mysqli_num_rows($result2);

        if ($total2 == 0) {
            echo "<p><li>등록된 글이 없습니다</li></p>\n";
        } else {
            for ($j = 0; $rows2 = mysqli_fetch_array($result2); $j++) {
                //날짜 형식을 바꾼다.
                $post_date = substr($rows2['date'], 0, 11);

                echo "<li>\n";
                echo "    <div class=\"fa fa-newspaper-o\"></div><p><a href=\"/bbs/read.php?code=" . $bbs_name . "&main_no=" . $rows2['main_no'] . "\">" . stripslashes($rows2['title']) . "</a></p>\n";
                echo "    <div class=\"date\">" . $post_date . "</div>\n";
                echo "</li>\n";
            }
        }
    }

}

//썸네일 이미지 자동생성
function make_thumbnail($source_file, $_width, $_height, $object_file)
{
    list($img_width, $img_height, $type) = getimagesize($source_file);
    if ($type == 1) {
        $img_sour = imagecreatefromgif($source_file);
    } else if ($type == 2) {
        $img_sour = imagecreatefromjpeg($source_file);
    } else if ($type == 3) {
        $img_sour = imagecreatefrompng($source_file);
    } else if ($type == 15) {
        $img_sour = imagecreatefromwbmp($source_file);
    } else {
        return false;
    }

    if ($img_width > $img_height) {
        $width  = round($_height * $img_width / $img_height);
        $height = $_height;
    } else {
        $width  = $_width;
        $height = round($_width * $img_height / $img_width);
    }
    if ($width < $_width) {
        $width  = round(($height + $_width - $width) * $img_width / $img_height);
        $height = round(($width + $_width - $width) * $img_height / $img_width);
    } else if ($height < $_height) {
        $height = round(($width + $_height - $height) * $img_height / $img_width);
        $width  = round(($height + $_height - $height) * $img_width / $img_height);
    }
    $x_last = round(($width - $_width) / 2);
    $y_last = round(($height - $_height) / 2);
    if ($img_width < $_width || $img_height < $_height) {
        $img_last = imagecreatetruecolor($_width, $_height);
        $x_last   = round(($_width - $img_width) / 2);
        $y_last   = round(($_height - $img_height) / 2);

        imagecopy($img_last, $img_sour, $x_last, $y_last, 0, 0, $width, $height);
        imagedestroy($img_sour);
        $white = imagecolorallocate($img_last, 255, 255, 255);
        imagefill($img_last, 0, 0, $white);
    } else {
        $img_dest = imagecreatetruecolor($width, $height);
        imagecopyresampled($img_dest, $img_sour, 0, 0, 0, 0, $width, $height, $img_width, $img_height);
        $img_last = imagecreatetruecolor($_width, $_height);
        imagecopy($img_last, $img_dest, 0, 0, $x_last, $y_last, $width, $height);
        imagedestroy($img_dest);
    }
    if ($object_file) {
        if ($type == 1) {
            imagegif($img_last, $object_file, 100);
        } else if ($type == 2) {
            imagejpeg($img_last, $object_file, 100);
        } else if ($type == 3) {
            imagepng($img_last, $object_file, 100);
        } else if ($type == 15) {
            imagebmp($img_last, $object_file, 100);
        }

    } else {
        if ($type == 1) {
            imagegif($img_last);
        } else if ($type == 2) {
            imagejpeg($img_last);
        } else if ($type == 3) {
            imagepng($img_last);
        } else if ($type == 15) {
            imagebmp($img_last);
        }

    }
    imagedestroy($img_last);
    return true;
}

//상품명 앞에 아이콘 보이기
//function show_icon(상품정보 쿼리결과값)
function show_icon(&$rows)
{
    //품절 처리 시
    if ($rows['del_chk'] == "O") {
        return $str = '<span class="label label-warning">일시품절</span>';
    } else if ($rows['del_chk'] == "Y") //감춤상품
    {
        return $str = '<span class="label label-default">판매중지</span>';
    } else if ($rows['del_chk'] == "C") //단종상품
    {
        return $str = '<span class="label label-danger">단종</span>';
    }

    if ($rows['option5_chk'] == "Y") {
        if ($rows['option1_chk'] == "Y") //신상품 Y
        {
            return $str = '<span class="label label-success">NEW</span>&nbsp;<span class="label label-info">당사직송</span>';
        } else if ($rows['option2_chk'] == "Y") //이벤트 Y
        {
            return $str = '<span class="label label-info">EVENT</span>&nbsp;<span class="label label-info">당사직송</span>';
        } else if ($rows['option3_chk'] == "Y") //인기상품 Y
        {
            return $str = '<span class="label label-danger">BEST</span>&nbsp;<span class="label label-info">당사직송</span>';
        } else if ($rows['option4_chk'] == "Y") {
            return $str = '<span class="label label-warning">SALE</span>&nbsp;<span class="label label-info">당사직송</span>';
        } else {
            return $str = '<span class="label label-info">당사직송</span>';
        }

    } else if ($rows['option1_chk'] == "Y") //신상품 Y
    {
        return $str = '<span class="label label-success">NEW</span>';
    } else if ($rows['option2_chk'] == "Y") //이벤트 Y
    {
        return $str = '<span class="label label-info">EVENT</span>';
    } else if ($rows['option3_chk'] == "Y") //인기상품 Y
    {
        return $str = '<span class="label label-danger">BEST</span>';
    } else if ($rows['option4_chk'] == "Y") {
        return $str = '<span class="label label-warning">SALE</span>';
    }

}

function admin_show_icon(&$rows)
{

    if ($rows['del_chk'] == "O") //품절 처리 시
    {
        return $str = "<img src=\"../images/out.gif\" alt=\"out of stock\" /> ";
    } else if ($rows['del_chk'] == "Y") //감춤상품
    {
        return $str = "<i class=\"fa fa-lock\"></i> ";
    } else if ($rows['del_chk'] == "C") //단종상품
    {
        return $str = "<img src=\"../images/cutstock.gif\" alt=\"out\" /> ";
    }

    if ($rows['option5_chk'] == "Y") {
        if ($rows['option1_chk'] == "Y") //신상품 Y
        {
            return $str = "<img src=\"../images/new-text.png\" alt=\"신상품\" />&nbsp;<img src=\"../images/delivery_icon.gif\" alt=\"당사직송\" /> ";
        } else if ($rows['option2_chk'] == "Y") //이벤트 Y
        {
            return $str = "<img src=\"../images/event_icon.gif\" alt=\"기획상품\" />&nbsp;<img src=\"../images/delivery_icon.gif\" alt=\"당사직송\" /> ";
        } else if ($rows['option3_chk'] == "Y") //인기상품 Y
        {
            return $str = "<img src=\"../images/best_icon.gif\" alt=\"인기상품\" />&nbsp;<img src=\"../images/delivery_icon.gif\" alt=\"당사직송\" /> ";
        } else if ($rows['option4_chk'] == "Y") {
            return $str = "<img src=\"../images/label_sale_yellow.png\" alt=\"할인상품\" />&nbsp;<img src=\"../images/delivery_icon.gif\" alt=\"당사직송\" /> ";
        } else {
            return $str = "<img src=\"../images/delivery_icon.gif\" alt=\"당사직송\" /> ";
        }

    } else if ($rows['option1_chk'] == "Y") //신상품 Y
    {
        return $str = "<img src=\"../images/new-text.png\" alt=\"신상품\" /> ";
    } else if ($rows['option2_chk'] == "Y") //이벤트 Y
    {
        return $str = "<img src=\"../images/event_icon.gif\" alt=\"기획상품\" /> ";
    } else if ($rows['option3_chk'] == "Y") //인기상품 Y
    {
        return $str = "<img src=\"../images/best_icon.gif\" alt=\"인기상품\" /> ";
    } else if ($rows['option4_chk'] == "Y") {
        return $str = "<img src=\"../images/sale_icon.gif\" alt=\"할인상품\" /> ";
    }

}

//구매 페이지에서 결제정보 보이기
//function show_payment(거래형태, 업체명, 입금계좌)
function show_payment($type, $company_name, $bank)
{
    if ($type != 1) {
        switch ($type) {
            case "2":
                echo "결제일 : 당월 말";
                break;
            case "3":
                echo "결제일 : 익월 5일";
                break;
            case "4":
                echo "결제일 : 익월 10일";
                break;
            case "5":
                echo "결제일 : 익월 15일";
                break;
            case "6":
                echo "결제일 : 익월 20일";
                break;
            case "7":
                echo "결제일 : 익월 25일";
                break;
            case "8":
                echo "결제일 : 익월 말";
                break;
            case "6":
                echo "결제일 : 기타";
                break;
        }
    } else {
        $deposit_date = date("Y-m-d");
        echo "<p>입금 은행 : \n";
        echo "<select class=\"form-control\" name=\"bank_name\">\n";
        echo "	<option>" . $bank . "</option>\n";
        echo "</select>\n";
        echo "<br />\n";
        echo "입금예정일 :\n";
        echo "<input class=\"form-control\" size=\"10\" value=\"" . $deposit_date . "\" name=\"deposit_date\" />\n";

        echo "<br />\n";
        echo "입 금 자 : <input class=\"form-control\" size=\"20\" value=\"" . $company_name . "\" name=\"company_name\" />\n";
    }
}

// require "xmlrpc.inc.php";
// require "class.EmmaSMS.php";

//$connect :  db 연결
function sms_stats($connect)
{
    //sms 관리 테이블
    $sql    = "SELECT * FROM sms";
    $result = mysqli_query($connect, $sql);
    $row    = mysqli_fetch_array($result);

    $sms = new EmmaSMS();
    $sms->login($row['id'], $row['passwd']); // $sms->login( [고객 ID], [고객 패스워드]);

    $retValue = $sms->statistics(date(Y), date(m)); // 2008년 11월
    if ($retValue) {
        echo "[발송한 날짜] : [성공 건수] / [전송 건수]<br />";
        foreach ($retValue as $day => $point) {
            echo $day . ": " . $point . "<br />";
        }
        echo "<h4>잔여 건수</h4>";
        echo $sms->Point . "<br />";
    } else {
        echo "<h3>에러</h3>";
        echo $sms->errMsg;
    }
}

function check_remain_sms($connect)
{
    //sms 관리 테이블
    $sql    = "SELECT * FROM sms";
    $result = mysqli_query($connect, $sql);
    $row    = mysqli_fetch_array($result);

    $sms = new EmmaSMS();
    $sms->login($row['id'], $row['passwd']); // $sms->login( [고객 ID], [고객 패스워드]);
    $point = $sms->point();

    if ($point != false) {
        echo "남은 건수는 : " . $point . "건 입니다.";
    } else {
        echo "[에러] " . $sms->errMsg;
    }

}

function send_sms($to, $msg_type, $name, $sdate, $connect)
{

    //sms 관리 테이블
    $sql    = "SELECT * FROM sms";
    $result = mysqli_query($connect, $sql);
    $row    = mysqli_fetch_array($result);

    //어드민 정보 테이블
    $sql2    = "SELECT * FROM admin_setup";
    $result2 = mysqli_query($connect, $sql2);
    $row2    = mysqli_fetch_array($result2);

    switch ($msg_type) {
        case "1":
            $sms_msg = "(" . $name . ")" . $row['reg_msg'] . "[" . $row2['company_name'] . "]"; //회원승인 메시지
            break;
        case "2":
            $sms_msg = "(" . $name . ")" . $row['orderin_msg'] . "[" . $row2['company_name'] . "]"; //주문 접수 메시지
            break;
        case "3":
            $sms_msg = "(" . $name . ")" . $row['order_msg'] . "[" . $row2['company_name'] . "]"; //주문 완료 메시지
            break;
        case "4":
            $sms_msg = "(" . $name . ")" . $row['orderout_msg'] . "[" . $row2['company_name'] . "]"; //상품 발송 메시지
            break;
        case "5":
            $sms_msg = "(" . $name . ")" . $row['tax_msg'] . "[" . $row2['company_name'] . "]"; //세금계산서 발송 메시지
            break;
        case "6":
            $sms_msg = "(" . $name . ")" . $row['offer_msg'] . "[" . $row2['company_name'] . "]"; //발주서 발송 메시지
            break;
    }

    if ($to == "self") {
        $sms_to = $row['to_phone']; //관리자 수신번호
    } else {
        $sms_to = $to;
    }

    $sms_from = $row['from_phone']; //관리자 발신번호

    if ($sdate) {
        $sms_date = $sdate;
    } else {
        $sms_date = "";
    }

    $sms = new EmmaSMS();
    $sms->login($row['id'], $row['passwd']); // $sms->login( [고객 ID], [고객 패스워드]);
    $ret = $sms->send($sms_to, $sms_from, $sms_msg, $sms_date);

    if (!$ret) {
        echo $sms->errMsg;
    }

}

/**
 * [main_show_products description]
 * @param  [type] $main_flag [best, new 구분]
 * @param  [type] $no_item   [표시할 개수]
 * @return [type]            [description]
 */
function show_main_products($main_flag, $no_item)
{
    global $host, $dbid, $dbpass, $dbname;
    $connect = mysqli_connect($host, $dbid, $dbpass, $dbname);

    if ('best' == $main_flag) {
        $flag = "main_best='Y'";
    } elseif ('new' == $main_flag) {
        $flag = "main_new='Y'";
    }

    $query  = "SELECT * FROM products WHERE del_chk='N' AND $flag AND approved = 'Y' ORDER BY rand() DESC LIMIT 0,$no_item ";
    $result = mysqli_query($connect, $query);

    if ($result) {

        for ($i = 0; $rows = mysqli_fetch_array($result); $i++) {

            $dealer_price = number_format($rows['retail_price']);
            $item_name    = stripslashes($rows['name']);

            echo <<<HEREDOC
                                <!-- single-product start -->
                                <div class="col-md-3">
                                    <div class="single-product">
                                        <div class="product-img">
                                            <a href="detail.php?pnum={$rows['num']}&lcode={$rows['category_l']}&mcode={$rows['category_m']}&scode={$rows['category_s']}">
                                                <img class="primary-image" src="{$rows['b_image1_name']}" alt="" />
                                            </a>
                                        </div>
                                        <div class="product-content">
                                            <div class="price-box">
                                                <span class="special-price"><i class="fa fa-krw"></i> {$dealer_price}</span>
                                            </div>
                                            <h2 class="product-name"><a href="detail.php?pnum={$rows['num']}&lcode={$rows['category_l']}&mcode={$rows['category_m']}&scode={$rows['category_s']}">{$item_name}</a></h2>
                                            <div class="product-icon">
                                                <a href="#"><i class="fa fa-shopping-cart"> </i></a>
                                                <a href="#"><i class="fa fa-check"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- single-product end -->

HEREDOC;

        }
        //end for
        mysqli_free_result($result);

    } else {
        echo "<p>등록된 상품이 없습니다.</p><p>관리자 페이지 > 상품관리에서 상품을 등록해 주세요.</p>\n";
    }

}

/**
 * [show_catalog_products description]
 * @param  [type] $lcode [description]
 * @param  [type] $mcode [description]
 * @param  [type] $tabid [description]
 * @return [type]        [description]
 */
function show_catalog_products($lcode, $mcode, $tabid)
{
    global $host, $dbid, $dbpass, $dbname;
    $connect = mysqli_connect($host, $dbid, $dbpass, $dbname);

    if ($mcode) {
        $code_qry = " AND category_l = '$lcode' AND category_m = '$mcode'";
    } else {
        $code_qry = " AND category_l = '$lcode'";
    }

    $query  = "SELECT * FROM products WHERE del_chk='N'" . $code_qry . " AND approved = 'Y' ORDER BY num DESC LIMIT 0, 12 ";
    $result = mysqli_query($connect, $query);

    if ($result) {

        for ($i = 0; $rows = mysqli_fetch_array($result); $i++) {

            $dealer_price = number_format($rows['retail_price']);
            $item_name    = stripslashes($rows['name']);

            if ($prow['opt']) {
                $option = show_option($prow);
            }

            if ('home' == $tabid) {
                echo <<<HEREDOC

                                                        <!-- single-product start -->
                                                        <div class="col-md-3 col-sm-6">
                                                            <div class="single-product">
                                                                <div class="product-img">
                                                                    <a href="detail.php?pnum={$rows['num']}&lcode={$rows['category_l']}&mcode={$rows['category_m']}&scode={$rows['category_s']}">
                                                                        <img class="primary-image" src="{$rows['b_image1_name']}" alt="" />
                                                                    </a>
                                                                </div>
                                                                <div class="product-content">
                                                                    <div class="price-box">
                                                                        <span class="special-price"><i class="fa fa-krw"></i> {$dealer_price}</span>
                                                                    </div>
                                                                    <h2 class="product-name"><a href="detail.php?pnum={$rows['num']}&lcode={$rows['category_l']}&mcode={$rows['category_m']}&scode={$rows['category_s']}">{$item_name}</a></h2>
                                                                    <div class="product-icon">
                                                                        <a href="#"><i class="fa fa-shopping-cart"> </i></a>
                                                                        <a href="#"><i class="fa fa-check"></i></a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- single-product end -->
HEREDOC;
            } elseif ('profile' == $tabid) {
                echo <<<HEREDOC
                                                    <!-- single-product start -->
                                                    <div class="li-item">
                                                        <div class="col-md-4 col-sm-4">
                                                            <div class="single-product">
                                                                <div class="product-img">
                                                                    <a href="detail.php?pnum={$rows['num']}&lcode={$rows['category_l']}&mcode={$rows['category_m']}&scode={$rows['category_s']}">
                                                                        <img class="primary-image" src="{$rows['b_image1_name']}" alt="">
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-8 col-sm-8">
                                                            <div class="f-fix">
                                                                <h2 class="product-name">
                                                                    <a href="detail.php?pnum={$rows['num']}&lcode={$rows['category_l']}&mcode={$rows['category_m']}&scode={$rows['category_s']}">{$item_name}</a>
                                                                </h2>
                                                                <p class="desc">[모델:] {$rows['short_desc']} <span class="spec">[스펙:] {$rows['opt']}</span></p>
                                                                <div class="p-box">
                                                                    <span class="special-price"><i class="fa fa-krw"></i> {$dealer_price}</span>
                                                                </div>
                                                                <div class="product-icon">
                                                                    <a href="#"><i class="fa fa-shopping-cart"></i></a>
                                                                    <a href="#"><i class="fa fa-check"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <!-- single-product end -->

HEREDOC;
            }

        }
        //end for
        mysqli_free_result($result);

    } else {
        echo "<p>등록된 상품이 없습니다.</p><p>관리자 페이지 > 상품관리에서 상품을 등록해 주세요.</p>\n";
    }

}

function show_brand_name($lcode)
{
    global $host, $dbid, $dbpass, $dbname;
    $connect = mysqli_connect($host, $dbid, $dbpass, $dbname);

    $query  = "SELECT * FROM products_category1 WHERE code = '$lcode' ";
    $result = mysqli_query($connect, $query);

    if ($result) {

        $rows = mysqli_fetch_array($result);
        echo '<a href="category-list.php?lcode=' . $lcode . '">' . stripslashes($rows['name']) . '</a>';

        mysqli_free_result($result);

    }

}

/**
 * [show_brands 대카테고리를 보여줌]
 * @return [type] [description]
 */
function show_brands()
{

    global $host, $dbid, $dbpass, $dbname;
    $connect = mysqli_connect($host, $dbid, $dbpass, $dbname);

    // 쇼핑몰 대분류
    $l_qry = "SELECT * FROM products_category1 WHERE hide='N' ORDER BY num ";
    $l_res = mysqli_query($connect, $l_qry);
    $total = mysqli_num_rows($l_res);

    echo '<ul>';

    if ($total > 0) {

        // 대분류 표시
        for ($i = 0; $l_rows = mysqli_fetch_array($l_res); $i++) {
            // 신제품 표시
            // $newq   = "SELECT * FROM products WHERE category_l = '$l_rows[code]' ORDER BY num DESC LIMIT 1";
            // $newr   = mysqli_query($connect, $newq);
            // $newrow = mysqli_fetch_array($newr);

            // if ($newrow['main_new'] == 'Y' && $newrow['del_chk'] != "Y") {
            //     $cat_name = $l_rows['name'] . ' <span class="label label-success">NEW</span>';
            // } else {
            //     $cat_name = $l_rows['name'];
            // }

            $cat_name = $l_rows['name'];

            echo <<<HEREDOC
                                            <li>
                                                <a href="/shop/catalog-list.php?lcode={$l_rows['code']}">
                                                    <span class="cat-thumb">
                                                        <i class="fa fa-hashtag"></i>
                                                    </span>
                                                    {$cat_name}
                                                </a>
                                            </li>

HEREDOC;

        }
    } else {
        echo '<li>브랜드를 등록해주세요</li>';
    }

    echo '</ul>';

}

function show_sub_category($lcode)
{

    global $host, $dbid, $dbpass, $dbname;
    $connect = mysqli_connect($host, $dbid, $dbpass, $dbname);

    $m_qry      = "SELECT * FROM products_category2 WHERE up_category = '$lcode' ORDER BY name";
    $m_res      = mysqli_query($connect, $m_qry);
    $msub_total = mysqli_num_rows($m_res);

    echo '<ul>';

    if ($msub_total > 0) {

        // 중분류 표시
        for ($i = 0; $m_rows = mysqli_fetch_array($m_res); $i++) {

            $cat_name = $m_rows['name'];

            echo <<<HEREDOC
                                            <li>
                                                <a href="catalog-list.php?lcode={$lcode}&mcode={$m_rows['code']}">
                                                    {$cat_name}
                                                </a>
                                            </li>

HEREDOC;

        }
    } else {
        echo '<li>서브 카테고리를 등록해주세요</li>';
    }

    echo '</ul>';

}

function show_sub_category_name($lcode, $mcode)
{
    global $host, $dbid, $dbpass, $dbname;
    $connect = mysqli_connect($host, $dbid, $dbpass, $dbname);

    $m_qry      = "SELECT * FROM products_category2 WHERE up_category = '$lcode' AND code = '$mcode'";
    $m_res      = mysqli_query($connect, $m_qry);
    $msub_total = mysqli_num_rows($m_res);

    if ($msub_total) {

        $rows = mysqli_fetch_array($m_res);
        echo '<a href="category-list.php?lcode=' . $lcode . '&amp;mcode=' . $mcode . '">' . stripslashes($rows['name']) . '</a>';

        mysqli_free_result($m_res);

    }

}

//메인 배너 보이기
//function show_banner(db 연결)
function show_banner($connect)
{
    $qry = "SELECT MAX(num) FROM banner";
    $res = mysqli_query($connect, $qry);
    $max = mysqli_fetch_array($res);

    $b_qry = "SELECT * FROM banner WHERE num='$max[0]' ";
    $b_res = mysqli_query($connect, $b_qry);

    $rows = mysqli_fetch_array($b_res);

    if ($rows['m_banner1'] == 'Y') {
        echo "<div id='slide-1' class='slide'>\n
					<h1>$rows[title1]</h1>\n
					<p>" . nl2br(stripslashes($rows['info1'])) . "</p>\n
					<a href=\"$rows[m_link1]\"><img src=\"$rows[m_banner1_image]\" alt=\"banner1\" /></a>\n
					</div>\n";
    }

    if ($rows['m_banner2'] == 'Y') {
        echo "<div class='slide'>\n
					<h1>$rows[title2]</h1>\n
					<p>" . nl2br(stripslashes($rows['info2'])) . "</p>\n
					<a href=\"$rows[m_link2]\"><img src=\"$rows[m_banner2_image]\" alt=\"banner2\" /></a>\n
					</div>\n";
    }

    if ($rows['m_banner3'] == 'Y') {
        echo "<div class='slide'>\n
					<h1>$rows[title3]</h1>\n
					<p>" . nl2br(stripslashes($rows['info3'])) . "</p>\n
					<a href=\"$rows[m_link3]\"><img src=\"$rows[m_banner3_image]\" alt=\"banner3\" /></a>\n
					</div>\n";
    }
}

//메인 배너 보이기
//function show_banner2(db 연결)
function show_banner2($connect)
{
    $qry = "SELECT MAX(num) FROM banner";
    $res = mysqli_query($connect, $qry);
    $max = mysqli_fetch_array($res);

    $b_qry = "SELECT * FROM banner WHERE num='$max[0]' ";
    $b_res = mysqli_query($connect, $b_qry);

    //$rows = mysqli_fetch_array($b_res);

    echo "<div id=\"slider\">\n
      <ul>\n";

    for ($i = 0; $rows = mysqli_fetch_array($b_res); $i++) {
        if ($rows["m_banner1"] == 'Y') {
            echo "<li><a href=\"$rows[m_link1]\"><img src=\"$rows[m_banner1_image]\" alt=\"banner1\" /></a></li>\n";
            $banner1 = "Y";
        }
        if ($rows["m_banner2"] == 'Y') {
            echo "<li><a href=\"$rows[m_link2]\"><img src=\"$rows[m_banner2_image]\" alt=\"banner2\" /></a></li>\n";
            $banner2 = "Y";
        }
        if ($rows["m_banner3"] == 'Y') {
            echo "<li><a href=\"$rows[m_link3]\"><img src=\"$rows[m_banner3_image]\" alt=\"banner3\" /></a></li>\n";
            $banner3 = "Y";
        }
        if ($rows["m_banner4"] == 'Y') {
            echo "<li><a href=\"$rows[m_link4]\"><img src=\"$rows[m_banner4_image]\" alt=\"banner4\" /></a></li>\n";
            $banner4 = "Y";
        }
        if ($rows["m_banner5"] == 'Y') {
            echo "<li><a href=\"$rows[m_link5]\"><img src=\"$rows[m_banner5_image]\" alt=\"banner5\" /></a></li>\n";
            $banner5 = "Y";
        }
    }

    echo "</ul>\n
    </div>\n";
}

//옵션 보이기
//function show_option(쿼리 결과값)
function show_option(&$rows)
{
    $opt       = explode(',', $rows['opt']);
    $opt_stock = explode(',', $rows['opt_stock']);

    for ($i = 0; $i < sizeof($opt); $i++) {
        if ($opt_stock[$i] == 0) {
            if ($rows['restock_date'] == "1111-00-00") {
                $opt[$i] .= "(품절 - 재입고 미정)";
                $dis[$i] .= "disabled";
            } else if ($rows['restock_date'] == "0000-00-00") {
                $opt[$i] .= "<br/>(품절 - 재입고일 미입력)";
                $dis[$i] .= "disabled";
            } else {
                $opt[$i] .= "(품절 - " . $rows['restock_date'] . " 재입고 예정)";
                $dis[$i] .= "disabled";
            }
        } else if ($opt_stock[$i] == -1) {
            $opt[$i] .= "(단종)";
            $dis[$i] .= "disabled";
        }
    }

    echo '<select class="form-control" name="selected_opt_' . $rows['num'] . '" id="selected_opt_' . $rows['num'] . '" data-width="100%">';

    for ($i = 0; $i < sizeof($opt); $i++) {
        if (trim($opt[$i]) == $selected_opt) {
            $selected = "selected";
        } else {
            $selected = "";
        }

        echo '<option value="' . trim($opt[$i]) . '' . $selected . '' . $dis[$i] . '">' . $opt[$i] . '</option>';
    } // for end
    echo '</select>';
}

//옵션 보이기
//function show_option(쿼리 결과값)
function show_option2(&$rows)
{
    $opt2       = explode(',', $rows['opt2']);
    $opt_stock2 = explode(',', $rows['opt_stock2']);

    for ($i = 0; $i < sizeof($opt2); $i++) {
        if ($opt_stock2[$i] == 0) {
            if ($rows['restock_date'] == "1111-00-00") {
                $opt2[$i] .= "(품절 - 재입고 미정)";
                $dis2[$i] .= "disabled";
            } else if ($rows['restock_date'] == "0000-00-00") {
                $opt2[$i] .= "<br/>(품절 - 재입고일 미입력)";
            } else {
                $opt2[$i] .= "(품절 - " . $rows['restock_date'] . " 재입고 예정)";
                $dis2[$i] .= "disabled";
            }
        } else if ($opt_stock2[$i] == -1) {
            $opt2[$i] .= "(단종)";
            $dis2[$i] .= "disabled";
        }
    }

    echo "<select class=\"form-control\" name=\"selected_opt2\" id=\"selected_opt2_" . $rows['num'] . "\">\n";

    for ($i = 0; $i < sizeof($opt2); $i++) {
        if (trim($opt2[$i]) == $selected_opt2) {
            $selected2 = "selected";
        } else {
            $selected2 = "";
        }

        echo "<option value=\"" . trim($opt2[$i]) . "\" $selected2 $dis2[$i]>" . $opt2[$i] . "</option>\n";
    } // for end
    echo "</select>\n";
}

//재입고 일정보이기
function show_restock(&$rows)
{
    if ($rows['restock_date'] == "1111-00-00") {
        echo "<br/>(재입고 미정)";
    } else if ($rows['restock_date'] == "0000-00-00") {
        echo "<br/>(재입고일 미입력)";
    } else {
        echo "(" . $rows['restock_date'] . " 재입고 예정)";
    }

}

//공급가 계산
//function calc_price(Array retail price, Array dc rate)
function calc_price(&$retail_price, &$dc_rate)
{
    return $retail_price * (1 - ($dc_rate / 100));
}

/*할인에 따른 공급가 계산
/*인수로 상품쿼리와 멤버쿼리를 받는다.
/* function check_price(Array 쿼리결과값, Array 멤버쿼리결과값) */
function check_price(&$rows, &$mrow)
{
    //할인가가 있는 경우 부가세에 따른 공급가 처리
    if ($rows['sale_price']) {
        if ($rows['fixed_price']) {
            $offer_price = $rows['fixed_price'];
        } else {
            $offer_price = $rows['sale_price'] * (1 - ($mrow['dc_rate'] / 100));
        }

        switch ($mrow['tax']) {
            case 'E':
                $offer_price  = $offer_price * 1.1;
                return $price = $offer_price;
                break;
            case 'I':
                return $price = $offer_price;
                break;
        }
    } else {
        $offer_price = $rows['retail_price'] * (1 - ($mrow['dc_rate'] / 100));

        switch ($mrow['tax']) {
            case 'E':
                $offer_price  = $offer_price * 1.1;
                return $price = $offer_price;
                break;
            case 'I':
                return $price = $offer_price;
                break;
        }
    }
}

//GET, POST, FILES 처리.
//function set_var(Array)
function set_var(&$ary)
{
    if (isset($ary) == true) {
        return $ary;
    } else {
        return null;
    }

}

//function show_msg(string, string)
function show_msg($msg, $url)
{
    echo "<meta HTTP-EQUIV='CONTENT-TYPE' content='text/html;charset=UTF-8'>
			<script language=\"JavaScript\">
	          alert(\"$msg\");
             document.location.replace(\"$url\");
            </script>";
}

//function show_msg(string, string)
function show_msg_close($msg)
{
    echo "<meta HTTP-EQUIV='CONTENT-TYPE' content='text/html;charset=UTF-8'>
			<script language=\"JavaScript\">
	          alert(\"$msg\");
			  opener.document.location.reload();
			  window.close();
            </script>";
}

function show_msg_close2($msg, $url)
{
    echo "<meta HTTP-EQUIV='CONTENT-TYPE' content='text/html;charset=UTF-8'>
			<script language=\"JavaScript\">
	          window.alert(\"$msg\");
			  opener.document.location.replace(\"$url\");
			  window.close();
            </script>";
}

function err_msg($msg, $bool = "1")
{
    if ($bool) {
        echo "  <meta http-equiv='content-type' content='text/html; charset=UTF-8' />
				<script>
				window.alert('$msg');
				history.go(-1);
				</script>
				";
        exit;
    }
}

function msg($msg)
{
    echo ("  <meta http-equiv='content-type' content='text/html; charset=UTF-8' />
        <script>
	    window.alert('$msg')
	    </script>
	    ");
}

function err_close($msg)
{
    echo "<meta http-equiv='content-type' content='text/html; charset=UTF-8' />
		<script>
		window.alert('$msg');
		self.close();
		</script>
		";
    exit;
}

function err_msg2($msg, $to, $bool = "1")
{
    if ($bool) {
        echo "<meta http-equiv='content-type' content='text/html; charset=UTF-8' />
			<script>
			window.alert('$msg');
			window.open('$to','_self');
			</script>
		";
        exit;
    }
}

// ��û�ϴ� �������� �̵�
function redirect($re_url)
{
    echo "<meta http-equiv='Refresh' content='0; URL=$re_url'>";
    exit;
}

// MYSQL ����
function my_connect($host, $id, $pass, $db)
{
    $connect = mysqli_connect($host, $id, $pass);
    mysqli_select_db($connect, $db);
    return $connect;
}

// HTML Tag�� �����ϴ� �Լ�
function del_html($str)
{
    $str = str_replace(">", "&gt;", $str);
    $str = str_replace("<", "&lt;", $str);
    $str = str_replace("\"", "&quot;", $str);
    return $str;
}

// ���� HTML �±׸� �̿��� �׷�����
function avoid_crack($str)
{
    $str = eregi_replace("<", "&lt;", $str);
    $str = eregi_replace("&lt;div", "<div", $str);
    $str = eregi_replace("&lt;p ", "<p ", $str);
    $str = eregi_replace("&lt;font", "<font", $str);
    $str = eregi_replace("&lt;b", "<b", $str);
    $str = eregi_replace("&lt;marquee", "<marquee", $str);
    $str = eregi_replace("&lt;img", "<img", $str);
    $str = eregi_replace("&lt;a ", "<a ", $str);
    $str = eregi_replace("&lt;embed", "<embed", $str);

    $str = eregi_replace("&lt;/div", "</div", $str);
    $str = eregi_replace("&lt;/p ", "</p ", $str);
    $str = eregi_replace("&lt;/font", "</font", $str);
    $str = eregi_replace("&lt;/b", "</b", $str);
    $str = eregi_replace("&lt;/marquee", "</marquee", $str);
    $str = eregi_replace("&lt;/img", "</img", $str);
    $str = eregi_replace("&lt;/a>", "</a>", $str);
    $str = eregi_replace("&lt;/embed", "</embed", $str);
    $str = eregi_replace("&gt;", ">", $str);
    return $str;
}

function page_avg($totalpage, $cpage, $url)
{

    if (!$pagenumber) {
        $pagenumber = 10;
    }

    $startpage = intval(($cpage - 1) / $pagenumber) * $pagenumber + 1;
    $endpage   = intVal(((($startpage - 1) + $pagenumber) / $pagenumber) * $pagenumber);

    if ($totalpage <= $endpage) {
        $endpage = $totalpage;
    }

    if ($cpage > $pagenumber) {

        $curpage  = intval($startpage - 1);
        $url_page = "<a href='$url" . "&page=$curpage'>";
        echo ("$url_page");
        echo ("<</a> .. ");
    } else {
        echo ("<</a>  ");
    }

    $curpage = $startpage;

    while ($curpage <= $endpage):

        if ($curpage == $cpage) {
            echo "<b>$cpage</b> ";
        } else {
            $url_page = "<a href='$url" . "&amp;page=$curpage'>";
            echo ("$url_page");
            echo ("[$curpage]</a> ");
        }
        $curpage++;

    endwhile;

    if ($totalpage > $endpage) {
        $curpage  = intval($endpage + 1);
        $url_page = " .. <a href='$url" . "&amp;page=$curpage'>";
        echo ("$url_page");
        echo ("></a> ");
    } else {
        echo ("  >");
    }
}

function page_nav($totalpage, $cpage, $url)
{

    if (!$pagenumber) {
        $pagenumber = 10;
    }

    echo "<ul class=\"pagination\">\n";

    $startpage = intval(($cpage - 1) / $pagenumber) * $pagenumber + 1;
    $endpage   = intVal(((($startpage - 1) + $pagenumber) / $pagenumber) * $pagenumber);

    if ($totalpage <= $endpage) {
        $endpage = $totalpage;
    }

    if ($cpage > $pagenumber) {

        $curpage = intval($startpage - 1);
        echo "			<li><a href=\"" . $url . "&page=" . $curpage . "\"> < </a></li>\n";
        //       $url_page = "<a href='$url"."&page=$curpage'>";
        //     echo ("$url_page");
        // echo("<</a> .. ");
    } else {
        // echo("<</a>  ");
        echo "				<li><a href=\"#\"><i class=\"fa fa-chevron-left\"></i></a></li>\n";
    }

    $curpage = $startpage;

    while ($curpage <= $endpage) {

        if ($curpage == $cpage) {
            echo "			<li class=\"active\"><a href=\"#\">" . $cpage . "<span class=\"sr-only\">(current)</span></a></li>\n";
            // echo "<b>$cpage</b>";
        } else {
            echo "			<li><a href=\"" . $url . "&page=" . $curpage . "\">" . $curpage . "</a></li>\n";

            //  $url_page = "<a href='$url"."&page=$curpage'>";
            //  echo ("$url_page");
            // echo("[$curpage]</a>");
        }
        $curpage++;

    }

    if ($totalpage > $endpage) {
        $curpage = intval($endpage + 1);
        echo "			<li><a href=\"" . $url . "&page=" . $curpage . "\"> .. > </a></li>\n";
        //         $url_page = " .. <a href='$url"."&page=$curpage'>";
        //          echo ("$url_page");
        // echo("></a>");
    } else {
        echo "				<li><a href=\"#\"><i class=\"fa fa-chevron-right\"></i></a></li>\n";
        // echo("  >");
    }

    echo "		</ul>\n";
}

// ��ۺ� ���
function trans_cal($money)
{
    if ((int) $money < 100000) {
        $a_money = 2500;
    } else {
        $a_money = 0;
    }

    return $a_money;
}

/* ��¥������ ���� ��ȯ : 20020512 --> 2002-05-12 */
function shortdate($strvalue)
{
    $date_str = substr($strvalue, 0, 4) . "-" . substr($strvalue, 4, 2) . "-" . substr($strvalue, 6, 2);
    return $date_str;
}

/* �ѱ� ���ڿ� �ڸ��� �Լ� */
function shortenStr($str, $maxlen)
{

    if (strlen($str) <= $maxlen) {
        return $str;
    }

    $effective_max = $maxlen - 3;
    $remained_byte = $effective_max;
    $retStr        = "";

    $hanStart = 0;

    for ($i = 0; $i < $effective_max; $i++) {
        $char = substr($str, $i, 1);

        if (ord($char) <= 127) {
            $retStr .= $char;
            $remained_byte--;
            continue;
        }

        if (!$hanStart && $remained_byte > 1) {
            $hanStart = true;
            $retStr .= $char;
            $remained_byte--;
            continue;
        }

        if ($hanStart) {
            $hanStart = false;
            $retStr .= $char;
            $remained_byte--;
        }
    }
    return $retStr .= "...";
}

// function cut_string_utf8($str, $max_len, $suffix)
// 유니코드용 문자열 자르기 함수.
//
function cut_string_utf8($str, $max_len, $suffix)
{
    $n   = 0;
    $noc = 0;
    $len = strlen($str);
    while ($n < $len) {
        $t = ord($str[$n]);
        if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
            $tn = 1;
            $n++;
            $noc++;
        } else if (194 <= $t && $t <= 223) {
            $tn = 2;
            $n += 2;
            $noc += 2;
        } else if (224 <= $t && $t < 239) {
            $tn = 3;
            $n += 3;
            $noc += 2;
        } else if (240 <= $t && $t <= 247) {
            $tn = 4;
            $n += 4;
            $noc += 2;
        } else if (248 <= $t && $t <= 251) {
            $tn = 5;
            $n += 5;
            $noc += 2;
        } else if ($t == 252 || $t == 253) {
            $tn = 6;
            $n += 6;
            $noc += 2;
        } else { $n++;}
        if ($noc >= $max_len) {break;}
    }
    if ($noc <= $max_len) {
        return $str;
    }

    if ($noc > $max_len) {$n -= $tn;}
    return substr($str, 0, $n) . $suffix;
}

//도서산간지역 우편번호 체크
function check_zipno($zipno, &$row)
{
    //예외 우편번호 배열
    $zip_ex = array(235, 250, 252, 409, 417, 535, 537, 548, 556, 650, 690, 695, 697, 699, 799);

    $zipno1 = explode('-', $row['buyer_zipno']);
    if ($row['recipient_zipno']) {
        $zipno2 = explode('-', $row['recipient_zipno']);
    }

    if (in_array($zipno1[0], $zip_ex)) //배열 내의 값과 비교
    {
        $bg1 = "bgcolor = \"#FFC8C8\" ";
    }

    if (in_array($zipno2[0], $zip_ex)) {
        $bg2 = "bgcolor = \"#FFC8C8\" ";
    }

    return $bg = array($bg1, $bg2);

}

function getBbsMenu($connect)
{
    $bqry = "SELECT * FROM code WHERE 1 ORDER BY num";
    $bres = mysqli_query($connect, $bqry);

    if ($bres) {
        for ($i = 0; $brow = mysqli_fetch_array($bres); $i++) {
            echo "<li><a href=\"http://www." . $_SERVER['SERVER_NAME'] . "/bbs/list.php?code=" . $brow['code'] . "\">" . $brow['bbs_name'] . "</a></li>\n";
        }
    } else {
        echo "<li>게시판 없음</li>\n";
    }

}

function getLoginWindow($i, $port)
{

    if (!$_SESSION['p_id']) {
        echo "<div class=\"modal fade\" id=\"guestModal" . $i . "\">\n";
        echo "  <div class=\"modal-dialog modal-sm\">\n";
        echo "    <div class=\"modal-content\">\n";
        echo "      <div class=\"modal-header\">\n";
        // echo "        <button type=\"button\" class=\"close\" data-dismiss=\"modal\"><span aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>\n";
        echo "        <h5 class=\"modal-title\">로그인</h5>\n";
        echo "      </div>\n";
        echo "      <div class=\"modal-body\">\n";
        echo "        <form name=\"guestLoginform" . $i, "\" class=\"form-group\" role=\"form\" action=\"https://www." . $_SERVER['SERVER_NAME'] . ":" . $port . "/member/login_ok.php\" method=\"post\">\n";
        echo "        <label for=\"id\">아이디: </label>\n";
        echo "        <input class=\"form-control\" type=\"text\" name=\"id\" />\n";
        echo "        <label for=\"pwd\">비밀번호: </label>\n";
        echo "        <input class=\"form-control\" type=\"password\" name=\"pwd\" />\n";
        echo "      </div>\n";
        echo "      <div class=\"modal-footer\">\n";
        echo "        <a href=\"/member/register.php\" role=\"button\" class=\"btn btn-info pull-left\" id=\"register" . $i . "\" >회원가입</a>\n";
        echo "        <a href=\"/shop/index.php\" role=\"button\" class=\"btn btn-default\" >홈으로 가기</a>\n";

        // echo "        <button type=\"button\" class=\"btn btn-default\" id=\"closeModal".$i."\" data-dismiss=\"modal\">닫 기</button>\n";
        echo "        <button type=\"submit\" class=\"btn btn-success\">로그인</button>\n";
        echo "      </div>\n";
        echo "        </form>\n";
        echo "    </div>\n";
        echo "  </div>\n";
        echo "</div>\n";
    }

}

function show_offerPrice($rows)
{

    if ($rows['diff_num']) {
        $diff_num   = explode(",", $rows['diff_num']);
        $diff_price = explode(",", $rows['diff_price']);

        echo "<ul class=\"diff_num list-unstyled\">\n";

        for ($i = 0; $i < count($diff_num); $i++) {
            if ($i + 1 == count($diff_num)) {
                echo "<li>" . number_format($diff_num[$i]) . " 개 이상 : &nbsp;";
                echo "<span class=\"diff_price\">" . number_format($diff_price[$i]) . " 원&nbsp;</span></li>\n";
            } else {
                echo "<li>" . number_format($diff_num[$i]) . " ~ " . number_format($diff_num[$i + 1] - 1) . " 개 : &nbsp;";
                echo "<span class=\"diff_price\">" . number_format($diff_price[$i]) . " 원&nbsp;</span></li>\n";
            }
        }

        echo "</ul>\n";
    }

}

function show_category($connect, $flag)
{

    // 대분류
    $l_qry = "SELECT * FROM products_category1 WHERE hide='N' ORDER BY code ";
    $l_res = mysqli_query($connect, $l_qry);
    $total = mysqli_num_rows($l_res);

    if ($total > 0) {

        // 대분류 표시
        for ($i = 0; $l_rows = mysqli_fetch_array($l_res); $i++) {
            // 신제품 표시
            $newq       = "SELECT * FROM products WHERE category_l = '$l_rows[code]' ORDER BY num DESC ";
            $newr       = mysqli_query($connect, $newq);
            $newrow     = mysqli_fetch_array($newr);
            $total_bnum = mysqli_num_rows($newr);

            // if($newrow['main_new'] == 'Y' && $newrow['del_chk'] != "Y")
            //   $cat_name = $l_rows['name']." <img src=\"../images/badge_new_or.png\">";
            // else
            $cat_name = $l_rows['name'];

            //    if($flag == 1)
            //     echo "<li><a href=\"../shop/catalog-list.php?lcode=".$l_rows['code']."\">".$cat_name." (".$total_bnum.")</a></li>\n";
            // else
            echo "<li><a href=\"../shop/catalog-list.php?lcode=" . $l_rows['code'] . "\">" . $cat_name . "</a></li>\n";

        }
    }

}

function show_bbs_list($connect)
{

    $bqry = "SELECT * FROM code WHERE 1 ORDER BY num";
    $bres = mysqli_query($connect, $bqry);

    if ($bres) {
        for ($i = 0; $brow = mysqli_fetch_array($bres); $i++) {
            echo "<li><a href=\"../bbs/list.php?code=" . $brow['code'] . "\">" . $brow['bbs_name'] . "</a></li>\n";
        }
    }

}

function check_avail($connect, $com_id, $pro_id)
{
    $sql    = "SELECT * FROM buy_product WHERE com_id = '$com_id'";
    $result = mysqli_query($connect, $sql);

    if ($result) {
        $row       = mysqli_fetch_array($result);
        $pro_code  = explode(',', $row['pro_id']);
        $available = explode(',', $row['available']);

        for ($i = 0; $i < count($pro_code); $i++) {
            if ($pro_id == $pro_code[$i]) {
                return $available[$i];
            }
        }

    } else {
        return "N";
    }

}

// 각 업체별 공급가를 보여준다.
function show_sup_price($connect, $com_id, $pro_id)
{
    $sql    = "SELECT * FROM buy_product WHERE com_id = '$com_id'";
    $result = mysqli_query($connect, $sql);

    if ($result) {
        $row       = mysqli_fetch_array($result);
        $pro_code  = explode(',', $row['pro_id']);
        $available = explode(',', $row['available']);
        $price     = explode(',', $row['price']);

        for ($i = 0; $i < count($pro_code); $i++) {
            if ($pro_id == $pro_code[$i]) {
                return $price[$i];
            }
        }

    } else {
        return "0";
    }
}

/* $day는 new가 표시되는 기간
 * 게시판 목록에서 사용하는 함수 */
function check_new_post($connect, $code, $main_no, $day)
{
    $bbs_name = "bbs_" . $code;

    $sql    = "SELECT * FROM $bbs_name WHERE main_no = $main_no";
    $result = mysqli_query($connect, $sql);

    if ($result) {
        $today = date("Y-m-d");

        $row       = mysqli_fetch_array($result);
        $post_date = substr($row['date'], 0, 11);
        $diff      = intval((strtotime($today) - strtotime($post_date)) / 86400);
        // echo $diff;

        if ($diff <= $day) {
            echo "<img src=\"/images/New_icons_50.gif\">";
        }
    } else {
        echo "NO DATA";
    }
}

/* 메뉴에서 사용하는 함수 */
function check_new_last_post($connect, $code, $day)
{
    $bbs_name = "bbs_" . $code;

    $sql    = "SELECT * FROM $bbs_name ORDER BY main_no DESC LIMIT 1";
    $result = mysqli_query($connect, $sql);

    if ($result) {
        $today = date("Y-m-d");

        $row       = mysqli_fetch_array($result);
        $post_date = substr($row['date'], 0, 11);
        $diff      = intval((strtotime($today) - strtotime($post_date)) / 86400);
        // echo $diff;

        if ($diff <= $day) {
            echo "<img src=\"/images/new.gif\">";
        }
    } else {
        echo "NO DATA";
    }
}
