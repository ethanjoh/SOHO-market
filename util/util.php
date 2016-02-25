<?php

$config = parse_ini_file('config.ini');
// require_once 'config.php';

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
function show_icon($pnum)
{

    global $config;

    $host   = $config['host'];
    $dbid   = $config['dbid'];
    $dbpass = $config['dbpass'];
    $dbname = $config['dbname'];

    // global $host, $dbid, $dbpass, $dbname;
    $connect = mysqli_connect($host, $dbid, $dbpass, $dbname);

    $qry  = "SELECT * FROM products WHERE num='$pnum'";
    $res  = mysqli_query($connect, $qry);
    $rows = mysqli_fetch_array($res);

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
 * [show_delivery_fee 택배비 보여주기]
 * @param  [type] $total     [총합]
 * @return [type] [문구]
 */
function show_delivery_fee($total)
{
    global $config;

    $host   = $config['host'];
    $dbid   = $config['dbid'];
    $dbpass = $config['dbpass'];
    $dbname = $config['dbname'];

    // global $host, $dbid, $dbpass, $dbname;
    $connect = mysqli_connect($host, $dbid, $dbpass, $dbname);

    $query  = "SELECT * FROM misc_setup ";
    $result = mysqli_query($connect, $query);
    $row    = mysqli_fetch_array($result);

    if ($row['min_sum'] > $total) {
        return $ret = "5만원 미만 착불";
    } elseif (0 == $total) {
        return $ret = "-";
    } elseif ($total >= $row['min_sum']) {
        return $ret = "무료배송";
    }
}

/**
 * [calc_delivery_fee 택배비 계산]
 * @param  [type] $total        [총합]
 * @return [type] [택배요금 반환]
 */
function calc_delivery_fee($total)
{

    global $config;

    $host   = $config['host'];
    $dbid   = $config['dbid'];
    $dbpass = $config['dbpass'];
    $dbname = $config['dbname'];

    // global $host, $dbid, $dbpass, $dbname;
    $connect = mysqli_connect($host, $dbid, $dbpass, $dbname);

    $query  = "SELECT * FROM misc_setup ";
    $result = mysqli_query($connect, $query);
    $row    = mysqli_fetch_array($result);

    if ($row['min_sum'] > $total) {
        $cost = $row['d_charge'];
    } else {
        $cost = 0;
    }

    return $cost;
}

/**
 * [show_logistics 택배사 보여주기]
 * @return [type] [description]
 */
function show_logistics()
{
    global $config;

    $host   = $config['host'];
    $dbid   = $config['dbid'];
    $dbpass = $config['dbpass'];
    $dbname = $config['dbname'];

    // global $host, $dbid, $dbpass, $dbname;
    $connect = mysqli_connect($host, $dbid, $dbpass, $dbname);

    $log_sql    = "SELECT * FROM misc_setup";
    $log_result = mysqli_query($connect, $log_sql);
    $log_row    = mysqli_fetch_array($log_result);

    $logistics = $log_row['logistics'];

    return $logistics;
}

/**
 * [show_track_no 운송장번호 보여주기]
 * @param  [type] $oid                [주문번호]
 * @return [type] [운송장번호]
 */
function show_track_no($oid)
{
    global $config;

    $host   = $config['host'];
    $dbid   = $config['dbid'];
    $dbpass = $config['dbpass'];
    $dbname = $config['dbname'];

    // global $host, $dbid, $dbpass, $dbname;
    $connect = mysqli_connect($host, $dbid, $dbpass, $dbname);

    $sql = "SELECT * FROM mall_order WHERE num = '$oid' ";
    $res = mysqli_query($connect, $sql);
    $row = mysqli_fetch_array($res);

    $t_no_arr = explode(",", $row['track_no']);

    for ($i = 0; $i < count($t_no_arr); $i++) {
        //운송장번호 '-' 제거
        $t_no     = preg_replace("/-/", "", $t_no_arr[$i]);
        $track_no = '<a href="#" onClick="TrackInfo(' . $t_no . ');">' . $t_no . '</a>';
    }

    return $track_no;
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

/**
 * [show_option 옵션 보여주기]
 * @param  [type] $pnum           [상품코드]
 * @return [type] [description]
 */
function show_option($pnum)
{
    global $config;

    $host   = $config['host'];
    $dbid   = $config['dbid'];
    $dbpass = $config['dbpass'];
    $dbname = $config['dbname'];

    // global $host, $dbid, $dbpass, $dbname;
    $connect = mysqli_connect($host, $dbid, $dbpass, $dbname);

    $query  = "SELECT * FROM products WHERE num='$pnum'";
    $result = mysqli_query($connect, $query);
    $rows   = mysqli_fetch_array($result);
    mysqli_free_result($result);

    $opt       = explode(',', $rows['opt']);
    $opt_stock = explode(',', $rows['opt_stock']);

    for ($i = 0; $i < sizeof($opt); $i++) {
        $dis[$i] = '';

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

    $ret = '<select class="form-control" name="selected_opt_' . $rows['num'] . '" id="selected_opt_' . $rows['num'] . '" data-width="100%">';

    $selected_opt = '';

    for ($i = 0; $i < sizeof($opt); $i++) {
        if (trim($opt[$i]) == $selected_opt) {
            $selected = "selected";
        } else {
            $selected = "";
        }

        $ret .= '<option value="' . trim($opt[$i]) . '' . $selected . '' . $dis[$i] . '">' . $opt[$i] . '</option>';
    } // for end
    $ret .= '</select>';

    return $ret;
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
// function calc_price(&$retail_price, &$dc_rate)
// {
//     return $retail_price * (1 - ($dc_rate / 100));
// }

/**
 * [calc_offer_price 공급가 계산]
 * @param  [type] $retail_price   [description]
 * @param  [type] $id             [description]
 * @return [type] [description]
 */
function calc_offer_price($retail_price, $id)
{
    global $config;

    $host   = $config['host'];
    $dbid   = $config['dbid'];
    $dbpass = $config['dbpass'];
    $dbname = $config['dbname'];

    // global $host, $dbid, $dbpass, $dbname;
    $connect = mysqli_connect($host, $dbid, $dbpass, $dbname);

    $query  = "SELECT * FROM member WHERE id='$id'";
    $result = mysqli_query($connect, $query);
    $row    = mysqli_fetch_array($result);

    return $retail_price * (1 - ($row['dc_rate'] / 100));
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

/**
 * [set_var GET, POST, SESSION 등 어레이값이 있는지 확인]
 * @param [type] &$ary [description]
 */
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
    $pagenumber = 1;

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

/**
 * [page_nav 페이지 표시]
 * @param  [type] $totalpage      [description]
 * @param  [type] $cpage          [description]
 * @param  [type] $url            [description]
 * @return [type] [description]
 */
function page_nav($totalpage, $cpage, $url)
{
    $pagenumber = null;

    if (!$pagenumber) {
        $pagenumber = 10;
    }

    echo '<ul class="pagination">' . "\r\n";

    $startpage = intval(($cpage - 1) / $pagenumber) * $pagenumber + 1;
    $endpage   = intVal(((($startpage - 1) + $pagenumber) / $pagenumber) * $pagenumber);

    if ($totalpage <= $endpage) {
        $endpage = $totalpage;
    }

    if ($cpage > $pagenumber) {

        $curpage = intval($startpage - 1);
        echo '			<li><a href="' . $url . '&page=' . $curpage . '"> <i class="fa fa-chevron-left"></i> </a></li>' . "\r\n";
    } else {
        // echo '                <li><a href="#"><i class="fa fa-chevron-left"></i></a></li>' . "\r\n";
    }

    $curpage = $startpage;

    while ($curpage <= $endpage) {

        if ($curpage == $cpage) {
            echo '			<li class="active"><a href="#">' . $cpage . '</a></li>' . "\r\n";
        } else {
            echo '			<li><a href="' . $url . '&page=' . $curpage . '">' . $curpage . '</a></li>' . "\r\n";
        }
        $curpage++;

    }

    if ($totalpage > $endpage) {
        $curpage = intval($endpage + 1);
        echo '			<li><a href="' . $url . '&page=' . $curpage . '"> &middot;&middot;&middot; <i class="fa fa-chevron-right"></i> </a></li>' . "\r\n";
    } else {
        // echo '            <li><a href="#"><i class="fa fa-chevron-right"></i></a></li>';
    }

    echo '		</ul>' . "\r\n";
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

/**
 * 타이틀 텍스트 줄이기
 * @param  string  $tite
 * @param  integer $end
 * @return string  $str
 */
function get_short($title, $end)
{
    $str = mb_strimwidth($title, '0', $end, '&#183;&#183;&#183;', 'utf-8');
    return stripslashes($str);
}

//도서산간지역 우편번호 체크
function check_zipno($zipcode, &$row)
{
    //예외 우편번호 배열
    $zip_ex = array(235, 250, 252, 409, 417, 535, 537, 548, 556, 650, 690, 695, 697, 699, 799);

    $zipcode1 = explode('-', $row['buyer_zipcode']);
    if ($row['recipient_zipcode']) {
        $zipcode2 = explode('-', $row['recipient_zipcode']);
    }

    if (in_array($zipcode1[0], $zip_ex)) //배열 내의 값과 비교
    {
        $bg1 = "bgcolor = \"#FFC8C8\" ";
    }

    if (in_array($zipcode2[0], $zip_ex)) {
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
function check_new_post($code, $main_no, $day)
{
    global $config;

    $host   = $config['host'];
    $dbid   = $config['dbid'];
    $dbpass = $config['dbpass'];
    $dbname = $config['dbname'];

    // global $host, $dbid, $dbpass, $dbname;
    $connect = mysqli_connect($host, $dbid, $dbpass, $dbname);

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
            echo '<span class="label label-success">NEW</span>';
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

/**
 * [get_company_info 회사정보 가져오기]
 * @return [array] [배열로 반환]
 */
function get_company_info()
{

    global $config;

    $host   = $config['host'];
    $dbid   = $config['dbid'];
    $dbpass = $config['dbpass'];
    $dbname = $config['dbname'];

    // global $host, $dbid, $dbpass, $dbname;
    $connect = mysqli_connect($host, $dbid, $dbpass, $dbname);

    $info_query = "SELECT * FROM admin_setup";
    $info_res   = mysqli_query($connect, $info_query);
    $info       = mysqli_fetch_array($info_res);

    $com_info['site_name']      = $info['site_name'];
    $com_info['keywords']       = $info['keywords'];
    $com_info['description']    = $info['description'];
    $com_info['company_name']   = $info['company_name'];
    $com_info['homepage']       = $info['homepage'];
    $com_info['email']          = $info['email'];
    $com_info['name']           = $info['name'];
    $com_info['info_name']      = $info['info_name'];
    $com_info['license_no']     = $info['license_no'];
    $com_info['online_license'] = $info['online_license'];
    $com_info['ceo']            = $info['ceo'];
    $com_info['category1']      = $info['category1'];
    $com_info['category2']      = $info['category2'];
    $com_info['tel']            = $info['tel'];
    $com_info['fax']            = $info['fax'];
    $com_info['zipcode']        = $info['zipcode'];
    $com_info['addr1']          = $info['addr1'];
    $com_info['addr2']          = $info['addr2'];
    $com_info['bank']           = $info['bank'];

    return $com_info;

}

function get_bbs_title($code, $limit)
{

    global $config;

    $host   = $config['host'];
    $dbid   = $config['dbid'];
    $dbpass = $config['dbpass'];
    $dbname = $config['dbname'];

    // global $host, $dbid, $dbpass, $dbname;
    $connect = mysqli_connect($host, $dbid, $dbpass, $dbname);

    $page = '';

    if (isset($code)) {
        $code = $code;
    } else {
        $code = "notice";
    }

    if ($code) {
        $bqry1 = "SELECT * FROM code WHERE code='$code' ";
        $bres1 = mysqli_query($connect, $bqry1);
        $brow1 = mysqli_fetch_array($bres1);
        $board = 'bbs_' . $code;

        $sql    = "SELECT * FROM $board WHERE id='admin' ORDER BY main_no DESC LIMIT $limit ";
        $result = mysqli_query($connect, $sql);
        $total  = mysqli_num_rows($result);
    } else {
        err_msg('선택한 게시판이 없습니다.', 1);
        exit;
    }

    mysqli_query($connect, 'set names utf8');

    $scale = 10;

    if ($page == '') {
        $page = 1;
    }

    $cpage     = intval($page);
    $totalpage = intval($total / $scale);

    if ($totalpage * $scale != $total) {
        $totalpage = $totalpage + 1;
    }

    if ($cpage == 1) {
        $cline = 0;
    } else {
        $cline = ($cpage * $scale) - $scale;
    }

    $limit = $cline + $scale;

    if ($limit >= $total) {
        $limit = $total;
    }

    $scale1 = $limit - $cline;

    echo <<<HEREDOC
          <!-- 게시판 본문 -->
          <section id="bbs-embed">
            <div class="col-md-11">
              <table class="table table-responsive">
                <tbody>
HEREDOC;

// 만약 검색 결과가 없다면,
    if ($total == 0) {
        echo <<<HEREDOC
                  <tr class="danger">
                    <td colspan="2"><p>등록된 글이 없습니다.</p></td>
                  </tr>
                </tbody>
              </table>
            </div>
HEREDOC;

    } else {
        $sql    = "SELECT * FROM $board WHERE id='admin' ORDER BY mod_date DESC LIMIT $cline,$scale1";
        $result = mysqli_query($connect, $sql);

        for ($i = 0; $row = mysqli_fetch_array($result); $i++) {
            // $title = cut_string_utf8($row['title'], 20, '&#183;&#183;&#183;');
            $title = get_short($row['title'], 36);
            $title = stripslashes($title);
            echo <<<HEREDOC
                    <tr>
                        <td class="text-left">
                            <a href="/bbs/read.php?code={$code}&amp;main_no={$row['main_no']}&amp;flag=r" >{$title}</a>
                        </td>
HEREDOC;

//날짜 형식을 바꾼다.
            $post_date = substr($row['date'], 0, 11);
            echo <<<HEREDOC
                        <td class="text-center">{$post_date}</td>
                    </tr>
HEREDOC;
        }

        echo <<<HEREDOC
                    </tbody>
                  </table>
                <hr>
                </div>
             </section>
HEREDOC;
    }
}

/**
 * [get_pg_info 결제상태 보여주기]
 * @param  [type] $orderid        [주문번호]
 * @return [type] [description]
 */
function get_pg_info($orderid)
{

    global $config;

    $host   = $config['host'];
    $dbid   = $config['dbid'];
    $dbpass = $config['dbpass'];
    $dbname = $config['dbname'];

    // global $host, $dbid, $dbpass, $dbname;
    $connect = mysqli_connect($host, $dbid, $dbpass, $dbname);

    // retrieve PG data
    $pg_sql    = "SELECT * FROM pg_info WHERE LGD_OID='$orderid' ";
    $pg_result = mysqli_query($connect, $pg_sql);
    $pg_row    = mysqli_fetch_array($pg_result);

    $pay_status = '';

    switch ($pg_row['LGD_PAYTYPE']) {
        case 'SC0040':
            if ($pg_row['LGD_RESPCODE'] == "0000") {
                if ($pg_row['LGD_CASFLAG'] == "R") {

                    $pay_status = '<i class="fa fa-university"></i> 가상계좌 발급 : <h4>입금계좌(가상계좌) - ' . $pg_row['LGD_ACCOUNTNUM'] . '</h4>';
                    $pay_status .= '<p>1) 가상계좌는 일회성 계좌이므로 재사용시(다시 그 계좌로 입금하시는 경우) 타인의 계좌로 입금될 가능성이 있습니다.<br />';
                    $pay_status .= '이 경우는 고객의 책임이므로 사용에 주의하시기 바랍니다. <br />';
                    $pay_status .= '2) 가상계좌의 경우 CD기에서 현금입금 하실 수 없습니다.  CD기에서 이체는 가능합니다.</p>';

                } elseif ($pg_row['LGD_CASFLAG'] == "I") {
                    $pay_status = '<i class="fa fa-check-circle pay-color"></i> 입금완료';
                } elseif ($pg_row['LGD_CASFLAG'] == "C") {
                    $pay_status = '<i class="fa fa-times-circle"></i> 입금취소';
                } else {
                    $pay_status = '<i class="fa fa-exclamation-triangle fail-color"></i> 입금실패(' . $pg_row['LGD_RESPCODE'] . ')';
                }
            }

            break;
        case 'SC0030':
            if ($pg_row['LGD_RESPCODE'] == "0000") {
                $pay_status = '<i class="fa fa-check-circle pay-color"></i> 이체완료';
            } else {
                $pay_status = '<i class="fa fa-exclamation-triangle fail-color"></i> 이체실패(' . $pg_row['LGD_RESPCODE'] . ')';
            }

            break;

        case 'SC0010': //SC0010 credit card
            if ($pg_row['LGD_RESPCODE'] == "0000") {
                $pay_status = '<i class="fa fa-credit-card pay-color"></i> 카드결제 완료';
            } else {
                $pay_status = '<i class="fa fa-exclamation-triangle fail-color"></i> 결제실패(' . $pg_row['LGD_RESPCODE'] . ')';
            }

            break;
    }

    return $pay_status;
}

/**
 * [get_pg_info2 주문목록에서 결제상태 보여주기]
 * @param  [type] $orderid        [주문번호]
 * @return [type] [description]
 */
function get_pg_info2($orderid)
{

    global $config;

    $host   = $config['host'];
    $dbid   = $config['dbid'];
    $dbpass = $config['dbpass'];
    $dbname = $config['dbname'];

    // global $host, $dbid, $dbpass, $dbname;
    $connect = mysqli_connect($host, $dbid, $dbpass, $dbname);

    // retrieve PG data
    $pg_sql    = "SELECT * FROM pg_info WHERE LGD_OID='$orderid' ";
    $pg_result = mysqli_query($connect, $pg_sql);
    $pg_row    = mysqli_fetch_array($pg_result);

    $pay_status = '';

    switch ($pg_row['LGD_PAYTYPE']) {
        case 'SC0040':
            if ($pg_row['LGD_RESPCODE'] == "0000") {
                // 계좌할당: R
                if ("R" == $pg_row['LGD_CASFLAG']) {

                    $bank_finance = array(
                        '003' => '기업은행',
                        '005' => '외환은행',
                        '004' => '국민은행',
                        '011' => '농협은행',
                        '020' => '우리은행',
                        '088' => '신한은행',
                        '023' => '제일은행',
                        '027' => '씨티은행',
                        '031' => '대구은행',
                        '032' => '부산은행',
                        '034' => '광주은행',
                        '037' => '전북은행',
                        '039' => '경남은행',
                        '071' => '우체국',
                        '081' => '하나은행',
                        '048' => '신협',
                        '045' => '새마을금고',
                        '035' => '제주은행',
                        '007' => '수협',
                        '002' => '산업은행',
                        '209' => '동양증권',
                        '230' => '미래에셋',
                        '278' => '신한금융투자',
                        '240' => '삼성증권',
                        '243' => '한국투자증권',
                        '269' => '한화증권',
                    );

                    if ($pg_row['LGD_PAYTYPE'] == "SC0040") {
                        foreach ($bank_finance as $key => $value) {
                            if ($pg_row['LGD_FINANCECODE'] == $key) {
                                $finance_name = $value;
                            }

                        }
                    }

                    $pay_status = '<i class="fa fa-university"></i> <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal">가상계좌확인</button>';
                    $pay_status .= '  <div class="modal fade" id="myModal">';
                    $pay_status .= '    <div class="modal-dialog">';
                    $pay_status .= '      <div class="modal-content">';
                    $pay_status .= '        <div class="modal-header">';
                    $pay_status .= '          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
                    $pay_status .= '          <h4 class="modal-title">가상계좌 확인</h4>';
                    $pay_status .= '        </div>';
                    $pay_status .= '        <div class="modal-body">';
                    $pay_status .= '          <h4 class="alert alert-danger rol="alert">입금하실 가상계좌 - ' . $finance_name . ': ' . $pg_row['LGD_ACCOUNTNUM'] . '</h4>';
                    $pay_status .= '          <p>1) 가상계좌는 일회성 계좌이므로 재사용시(다시 그 계좌로 입금하시는 경우) 타인의 계좌로 입금될 가능성이 있습니다.<br />';
                    $pay_status .= '             이 경우는 고객의 책임이므로 사용에 주의하시기 바랍니다. <br />';
                    $pay_status .= '             2) 가상계좌의 경우 CD기에서 현금입금 하실 수 없습니다.  CD기에서 이체는 가능합니다.</p>';
                    $pay_status .= '        </div>';
                    $pay_status .= '        <div class="modal-footer">';
                    $pay_status .= '          <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>';
                    $pay_status .= '        </div>';
                    $pay_status .= '      </div>'; //<!-- /.modal-content -->
                    $pay_status .= '    </div>'; //<!-- /.modal-dialog -->
                    $pay_status .= '  </div>'; //<!-- /.modal -->

                } elseif ($pg_row['LGD_CASFLAG'] == "I") {
                    $pay_status = '<i class="fa fa-check-circle pay-color"></i> 입금완료';
                } elseif ($pg_row['LGD_CASFLAG'] == "C") {
                    $pay_status = '<i class="fa fa-times-circle"></i> 입금취소';
                } else {
                    $pay_status = '<i class="fa fa-exclamation-triangle"></i> 입금실패(' . $pg_row['LGD_RESPCODE'] . ')';
                }
            }

            break;
        case 'SC0030':
            $wire_finance = array(
                '003' => '기업은행',
                '005' => '외환은행',
                '004' => '국민은행',
                '011' => '농협은행',
                '081' => '하나은행',
                '007' => '수협',
                '020' => '우리',
                '088' => '신한',
                '039' => '경남',
                '071' => '우체국',
                '032' => '부산',
                '031' => '대구',
            );

            if ($pg_row['LGD_PAYTYPE'] == "SC0010") {
                foreach ($wire_finance as $key => $value) {
                    if ($pg_row['LGD_FINANCECODE'] == $key) {
                        $finance_name = $value;
                    }

                }
            }

            if ($pg_row['LGD_RESPCODE'] == "0000") {
                $pay_status = '<i class="fa fa-check-circle pay-color"></i> 이체완료';
            } else {
                $pay_status = '<i class="fa fa-exclamation-triangle fail-color"></i> 이체실패(' . $pg_row['LGD_RESPCODE'] . ')';
            }

            break;

        case 'SC0010': //SC0010 credit card
            $card_finance = array(
                '11' => '국민',
                '21' => '외환',
                '30' => 'KDB산업체크',
                '31' => '비씨',
                '32' => '하나',
                '33' => '우리(구.평화VISA)',
                '34' => '수협',
                '35' => '전북',
                '36' => '씨티',
                '37' => '우체국체크',
                '38' => 'MG새마을금고체크',
                '39' => '저축은행체크',
                '41' => '신한(구.LG카드 포함)',
                '42' => '제주',
                '46' => '광주',
                '51' => '삼성',
                '61' => '현대',
                '62' => '신협체크',
                '71' => '롯데',
                '91' => 'NH',
                '3C' => '중국은련',
                '4J' => '해외JCB',
                '4V' => '해외VISA',
                '4M' => '해외MASTER',
                '6D' => '해외DINERS',
                '6I' => '해외DISCOVER',
            );

            if ($pg_row['LGD_PAYTYPE'] == "SC0010") {
                foreach ($card_finance as $key => $value) {
                    if ($pg_row['LGD_FINANCECODE'] == $key) {
                        $finance_name = $value;
                    }

                }
            }

            if ($pg_row['LGD_RESPCODE'] == "0000") {
                $pay_status = '<i class="fa fa-credit-card pay-color"></i> 카드결제 완료';
            } else {
                $pay_status = '<i class="fa fa-exclamation-triangle fail-color"></i> 결제실패(' . $pg_row['LGD_RESPCODE'] . ')';
            }

            break;
    }

    return $pay_status;
}

/**
 * [show_pay_data 결제수단 데이터 보여주기]
 * @param  [type] $orderid        [주문번호]
 * @return [type] [description]
 */
function show_pay_data($orderid)
{

    global $config;

    $host   = $config['host'];
    $dbid   = $config['dbid'];
    $dbpass = $config['dbpass'];
    $dbname = $config['dbname'];

    // global $host, $dbid, $dbpass, $dbname;
    $connect = mysqli_connect($host, $dbid, $dbpass, $dbname);

    // retrieve PG data
    $pg_sql    = "SELECT * FROM pg_info WHERE LGD_OID='$orderid' ";
    $pg_result = mysqli_query($connect, $pg_sql);
    $pg_row    = mysqli_fetch_array($pg_result);

    switch ($pg_row['LGD_PAYTYPE']) {
        case 'SC0040':
            if ($pg_row['LGD_RESPCODE'] == "0000") {
                // 계좌할당: R
                if ("R" == $pg_row['LGD_CASFLAG']) {

                    $bank_finance = array(
                        '003' => '기업은행',
                        '005' => '외환은행',
                        '004' => '국민은행',
                        '011' => '농협은행',
                        '020' => '우리은행',
                        '088' => '신한은행',
                        '023' => '제일은행',
                        '027' => '씨티은행',
                        '031' => '대구은행',
                        '032' => '부산은행',
                        '034' => '광주은행',
                        '037' => '전북은행',
                        '039' => '경남은행',
                        '071' => '우체국',
                        '081' => '하나은행',
                        '048' => '신협',
                        '045' => '새마을금고',
                        '035' => '제주은행',
                        '007' => '수협',
                        '002' => '산업은행',
                        '209' => '동양증권',
                        '230' => '미래에셋',
                        '278' => '신한금융투자',
                        '240' => '삼성증권',
                        '243' => '한국투자증권',
                        '269' => '한화증권',
                    );

                    if ($pg_row['LGD_PAYTYPE'] == "SC0040") {
                        foreach ($bank_finance as $key => $value) {
                            if ($pg_row['LGD_FINANCECODE'] == $key) {
                                $finance_name = $value;
                            }

                        }
                    }

                }
            }

            break;
        case 'SC0030':
            $wire_finance = array(
                '003' => '기업은행',
                '005' => '외환은행',
                '004' => '국민은행',
                '011' => '농협은행',
                '081' => '하나은행',
                '007' => '수협',
                '020' => '우리',
                '088' => '신한',
                '039' => '경남',
                '071' => '우체국',
                '032' => '부산',
                '031' => '대구',
            );

            if ($pg_row['LGD_PAYTYPE'] == "SC0010") {
                foreach ($wire_finance as $key => $value) {
                    if ($pg_row['LGD_FINANCECODE'] == $key) {
                        $finance_name = $value;
                    }
                }
            }

            break;

        case 'SC0010': //SC0010 credit card
            $card_finance = array(
                '11' => '국민',
                '21' => '외환',
                '30' => 'KDB산업체크',
                '31' => '비씨',
                '32' => '하나',
                '33' => '우리(구.평화VISA)',
                '34' => '수협',
                '35' => '전북',
                '36' => '씨티',
                '37' => '우체국체크',
                '38' => 'MG새마을금고체크',
                '39' => '저축은행체크',
                '41' => '신한(구.LG카드 포함)',
                '42' => '제주',
                '46' => '광주',
                '51' => '삼성',
                '61' => '현대',
                '62' => '신협체크',
                '71' => '롯데',
                '91' => 'NH',
                '3C' => '중국은련',
                '4J' => '해외JCB',
                '4V' => '해외VISA',
                '4M' => '해외MASTER',
                '6D' => '해외DINERS',
                '6I' => '해외DISCOVER',
            );

            if ($pg_row['LGD_PAYTYPE'] == "SC0010") {
                foreach ($card_finance as $key => $value) {
                    if ($pg_row['LGD_FINANCECODE'] == $key) {
                        $finance_name = $value;
                    }
                }
            }

            break;
    }

    echo <<<HEREDOC
                                 <ul class="pay-data">
                                    <li><i class="fa fa-angle-right"></i> 응답코드: {$pg_row['LGD_RESPCODE']}</li>
                                    <li><i class="fa fa-angle-right"></i> 응답메시지: {$pg_row['LGD_RESPMSG']}</li>
                                    <li><i class="fa fa-angle-right"></i> 거래일시: {$pg_row['LGD_PAYDATE']}</li>
                                    <li><i class="fa fa-angle-right"></i> 결제기관 코드: {$pg_row['LGD_FINANCECODE']} - {$finance_name}</li>
                                    <li><i class="fa fa-angle-right"></i> 결제기관 이름: {$pg_row['LGD_FINANCENAME']}</li>
                                    <li><i class="fa fa-angle-right"></i> 결제기관 승인번호: {$pg_row['LGD_FINANCEAUTHNUM']}</li>
                                    <li><i class="fa fa-angle-right"></i> 카드번호: {$pg_row['LGD_CARDNUM']}</li>
                                  </ul>
HEREDOC;
}
