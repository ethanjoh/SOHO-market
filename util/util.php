<?php
include_once 'bank-codes.php';

$config = parse_ini_file('/[hosting_root]/config/config.ini');

$host         = $config['host'];
$dbid         = $config['dbid'];
$dbpass       = $config['dbpass'];
$dbname       = $config['dbname'];
$sslPort      = $config['port'];
$MERTKEY      = $config['mertkey'];
$CST_MID      = $config['cst_mid'];
$CST_PLATFORM = $config['cst_platform'];

// 토스페이먼츠 API 키 설정 (config.ini에 정의된 키가 없으면 기본 테스트 키 사용)
$tossClientKey = isset($config['toss_client_key']) ? $config['toss_client_key'] : 'test_ck_OALnQBNxMGdkbyA1ywB38XzDOKWO';
$tossSecretKey = isset($config['toss_secret_key']) ? $config['toss_secret_key'] : 'test_sk_Z5osxOZdxPz1e5P2kG18V15e';

$connect = mysqli_connect($host, $dbid, $dbpass, $dbname);

/**
 * 메인 화면 등에 공지사항 팝업창(모달)을 띄우는 함수
 * 
 * 데이터베이스(popup 테이블)를 조회하여 팝업 활성화 여부(chk)가 'Y'인 경우
 * 공지사항 내용을 담은 Bootstrap 모달 창을 화면에 렌더링합니다.
 * '오늘 이 창을 다시 열지 않음' 쿠키가 설정되어 있으면 표시하지 않습니다.
 * 
 * @global mysqli $connect 데이터베이스 연결 객체
 * @return void
 */
function show_notice()
{
    global $connect;

    $query  = "SELECT * FROM popup where 1";
    $result = mysqli_query($connect, $query);
    $rows   = mysqli_fetch_array($result);

    if ('Y' == $rows['chk']) {

        echo <<<HEREDOC

        <div class="modal fade" id="notice" style="z-index: 3000000000;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-center">공지사항</h4>
                    </div>
                    <div id="popup" title="notice" class="modal-body">
                        {$rows['contents']}
                    </div>
                    <div class="modal-footer">
                        <form name="formpop">
                        <input type="checkbox" id="chkNotice" name="chkNotice">
                        <span style="font-size:9pt;color:#000000">오늘 이 창을 다시 열지 않음</span>
                        <button type="button" class="btn btn-xs btn-default" onclick="closeWin();" data-dismiss="modal">닫기</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(window).load(function(){
                if ( getCookie( "chkNotice" ) != "done" ) {
                    $('#notice').modal('show');
                }
            });
        </script>

HEREDOC;
    } else {
        echo <<<HEREDOC

        <script type="text/javascript">
            $(window).load(function(){
                $('#notice').modal('hide');
            });
        </script>

HEREDOC;
    }
}

/**
 * 메인 화면에 특정 게시판의 최근 게시물 5개를 리스트 형태로 출력하는 함수
 * 
 * @param string $bbs_name 게시판 코드명 (예: 'notice', 'qna' 등)
 * @param mysqli $connect 데이터베이스 연결 객체
 * @return void
 */
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

/**
 * 원본 이미지로부터 지정된 크기의 썸네일 이미지를 자동 생성하여 저장하거나 출력하는 함수
 * 
 * GIF, JPEG, PNG, WBMP 형식을 지원하며, 이미지 비율을 유지하면서 썸네일을 생성합니다.
 * PNG 파일의 경우 투명 백그라운드를 유지하도록 처리합니다.
 * 
 * @param string $source_file 원본 파일 경로
 * @param int $_width 썸네일 가로 크기
 * @param int $_height 썸네일 세로 크기
 * @param string|null $object_file 저장할 썸네일 파일 경로 (null인 경우 브라우저로 직접 출력)
 * @return bool 썸네일 생성 성공 여부 (지원하지 않는 포맷일 경우 false 반환)
 */
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
        $white = imagecolorallocate($img_last, 255, 255, 255);
        imagefill($img_last, 0, 0, $white);
    } else {
        $img_dest = imagecreatetruecolor($width, $height);
        imagecopyresampled($img_dest, $img_sour, 0, 0, 0, 0, $width, $height, $img_width, $img_height);

        $img_last = imagecreatetruecolor($_width, $_height);
        imagecopy($img_last, $img_dest, 0, 0, $x_last, $y_last, $width, $height);
        imagedestroy($img_dest);
    }

    if ($img_sour) {
        imagedestroy($img_sour);
    }

    if ($object_file) {
        if ($type == 1) {
            imagegif($img_last, $object_file, 100);
        } else if ($type == 2) {
            imagejpeg($img_last, $object_file, 100);
        } else if ($type == 3) {
            //png가 32비트 일 때만 투명 백그라운드 지원
            imagealphablending($img_last, false);
            imagesavealpha($img_last, true);

            imagepng($img_last, $object_file, 0);
        } else if ($type == 15) {
            imagewbmp($img_last, $object_file);
        }
    } else {
        if ($type == 1) {
            imagegif($img_last);
        } else if ($type == 2) {
            imagejpeg($img_last);
        } else if ($type == 3) {
            imagealphablending($img_last, false);
            imagesavealpha($img_last, true);
            imagepng($img_last);
        } else if ($type == 15) {
            imagewbmp($img_last);
        }
    }
    imagedestroy($img_last);
    return true;
}

/**
 * 상품 고유 번호를 기반으로 상품의 상태(품절, 판매중지, 단종, 신상품 등)를 나타내는 HTML 뱃지 아이콘을 반환하는 함수
 * 
 * @global mysqli $connect 데이터베이스 연결 객체
 * @param int $pnum 상품 고유 번호 (products 테이블의 num)
 * @return string 상태 아이콘 HTML 문자열
 */
function show_icon($pnum)
{

    global $connect;

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

/**
 * 관리자 페이지에서 상품 목록 표시 시 각 상품 상태(품절, 판매중지, 신상품, 기획상품 등)에 따른 이미지 아이콘을 반환하는 함수
 * 
 * @param array $rows 상품 정보 레코드 배열 (참조 전달)
 * @return string 상태 아이콘 이미지 HTML 문자열
 */
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

/**
 * EmmaSMS 서비스를 이용하여 현재 연/월의 SMS 발송 통계 및 잔여 포인트를 출력하는 함수
 * 
 * @param mysqli $connect 데이터베이스 연결 객체
 * @return void
 */
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

/**
 * EmmaSMS 서비스를 이용하여 잔여 SMS 발송 가능 건수(포인트)를 조회하여 출력하는 함수
 * 
 * @param mysqli $connect 데이터베이스 연결 객체
 * @return void
 */
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

/**
 * 설정된 템플릿 메시지를 기반으로 회원 또는 관리자에게 SMS를 발송하는 함수
 * 
 * @param string $to 수신자 번호 ('self' 입력 시 관리자 수신 번호로 설정)
 * @param string $msg_type 메시지 유형 (1: 회원승인, 2: 주문접수, 3: 주문완료, 4: 상품발송, 5: 세금계산서발송, 6: 발주서발송)
 * @param string $name 수신자 이름 (메시지에 포함될 이름)
 * @param string|null $sdate 예약 발송 일시 (형식: YYYYMMDDHHMMSS, null인 경우 즉시 발송)
 * @param mysqli $connect 데이터베이스 연결 객체
 * @return void
 */
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
 * 주문 총액을 기준으로 배송비 부과 안내 문구와 배송비 금액을 반환하는 함수
 * 
 * 데이터베이스(misc_setup 테이블)의 설정값과 비교하여 최소 배송 무료 기준(min_sum) 미만일 경우 배송비(d_charge)를 부과하고,
 * 그 이상일 경우 '무료배송'으로 처리합니다.
 * 
 * @global mysqli $connect 데이터베이스 연결 객체
 * @param int $total 주문 총액
 * @return array 배송 안내 문구('msg') 및 부과되는 배송비('trans_cost')를 포함한 연관 배열
 */
function show_delivery_fee($total)
{
    global $connect;
    $sessionFlag = set_var($_SESSION['p_flag']);

    $query  = "SELECT * FROM misc_setup ";
    $result = mysqli_query($connect, $query);
    $row    = mysqli_fetch_array($result);

    if ($total < $row['min_sum'] && $total > 0) {
        // if ($sessionFlag == 'c') {
        //     $reMsg = "" . number_format($row['min_sum']) . "원 미만 착불";
        //     return array('msg' => $reMsg, 'trans_cost' => 0);
        // } elseif ($sessionFlag == 'p') {
        //     $reMsg = '<i class="fa fa-krw"></i> ' . number_format($row['d_charge']) . ' <i class="fa fa-plus-circle"></i>' . "\r\n";
        //     return array('msg' => $reMsg, 'trans_cost' => $row['d_charge']);
        // }

        $reMsg = '<i class="fa fa-krw"></i> ' . number_format($row['d_charge']) . ' <i class="fa fa-plus-circle"></i>' . "\r\n";
        return array('msg' => $reMsg, 'trans_cost' => $row['d_charge']);
    } elseif ($total == 0) {
        $reMsg = "-";
        return array('msg' => $reMsg, 'trans_cost' => 0);
    } elseif ($total >= $row['min_sum']) {
        $reMsg = "무료배송";
        return array('msg' => $reMsg, 'trans_cost' => 0);
    }
}

/**
 * 무료 배송이 적용되는 최소 주문 금액 기준을 반환하는 함수
 * 
 * @global mysqli $connect 데이터베이스 연결 객체
 * @return string 포맷팅된 최소 주문 금액 문자열 (예: 50,000)
 */
function show_min_delivery_fee()
{
    global $connect;
    $sessionFlag = set_var($_SESSION['p_flag']);

    $query  = "SELECT * FROM misc_setup ";
    $result = mysqli_query($connect, $query);
    $row    = mysqli_fetch_array($result);

    return number_format($row['min_sum']);
}

/**
 * 주문 후 데이터베이스에 주문 정보를 저장할 때 실제 부과할 배송비를 계산하는 함수
 * 
 * @global mysqli $connect 데이터베이스 연결 객체
 * @param int $orderSum 주문 총액
 * @return int 부과될 배송비 금액
 */
function calc_delivery_fee($orderSum)
{

    global $connect;
    // $sessionFlag = set_var($_SESSION['p_flag']);

    $query  = "SELECT * FROM misc_setup ";
    $result = mysqli_query($connect, $query);
    $row    = mysqli_fetch_array($result);

    if ($orderSum < $row['min_sum']) {
        $reDeliveryFee = $row['d_charge'];
    } else {
        $reDeliveryFee = 0;
    }

    return $reDeliveryFee;
}

/**
 * 배송비 정보 및 우편번호를 기준으로 결제 구분(신용/착불)과 제주도 지역 여부를 판별하는 함수
 * 
 * @global mysqli $connect 데이터베이스 연결 객체
 * @param int|string $transCost 배송비 금액 (0인 경우 신용(선불) 배송, 그 외에는 착불로 구분)
 * @param string $zipCode 배송지 우편번호 (앞 2자리가 63인 경우 제주도 지역으로 판별)
 * @return array 결제 구분 코드('credit'), 기본 배송비('t_cost'), 제주도 여부 문구('jeju')를 포함한 연관 배열
 */
function define_delivery_fee($transCost, $zipCode)
{

    global $connect;

    $query  = "SELECT * FROM misc_setup";
    $result = mysqli_query($connect, $query);
    $row    = mysqli_fetch_array($result);
    $t_cost = $row['d_charge'];

    if ($transCost == "0") {
        $credit = "3"; //신용
    } else {
        $credit = "2"; //착불
    }

    //제주도 우편번호 확인
    $jejuZipCode = substr($zipCode, 0, 2);

    if ($jejuZipCode == 63) {
        $jeju = "제주선착불";
    } else {
        $jeju = "";
    }

    return array('credit' => $credit, 't_cost' => $t_cost, 'jeju' => $jeju);
}

/**
 * 기본 설정된 택배사 이름을 반환하는 함수
 * 
 * @global mysqli $connect 데이터베이스 연결 객체
 * @return string 택배사 이름
 */
function show_logistics()
{
    global $connect;

    $log_sql    = "SELECT * FROM misc_setup";
    $log_result = mysqli_query($connect, $log_sql);
    $log_row    = mysqli_fetch_array($log_result);

    $logistics = $log_row['logistics'] . " ";

    return $logistics;
}

/**
 * 주문 번호를 기반으로 저장된 운송장 번호를 조회하고, 클릭 시 배송 추적 팝업을 띄울 수 있는 HTML 링크를 반환하는 함수
 * 
 * @global mysqli $connect 데이터베이스 연결 객체
 * @param int|string $oid 주문 고유 번호 (mall_order 테이블의 num)
 * @return string 운송장 번호와 클릭 이벤트를 포함한 HTML 링크 문자열
 */
function show_track_no($oid)
{
    global $connect;

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

/**
 * 슬라이더 형태의 메인 배너 영역을 데이터베이스 정보에 기반하여 화면에 출력하는 함수 (최대 3개 배너)
 * 
 * @param mysqli $connect 데이터베이스 연결 객체
 * @return void
 */
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

/**
 * 리스트 형태의 메인 배너(슬라이더 리스트 태그)를 데이터베이스 정보에 기반하여 화면에 출력하는 함수 (최대 5개 배너)
 * 
 * @param mysqli $connect 데이터베이스 연결 객체
 * @return void
 */
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
 * 상품 고유 번호를 받아 해당 상품의 옵션들을 드롭다운 선택 메뉴(HTML select) 형태로 생성하여 반환하는 함수
 * 
 * 품절 및 단종 상태에 따른 disabled 처리와 재고 수량을 옵션 텍스트 뒤에 표시합니다.
 * 
 * @global mysqli $connect 데이터베이스 연결 객체
 * @param int $pnum 상품 고유 번호
 * @return string HTML select 엘리먼트 문자열
 */
function show_option($pnum)
{
    global $connect;

    $query  = "SELECT * FROM products WHERE num='$pnum'";
    $result = mysqli_query($connect, $query);
    $rows   = mysqli_fetch_array($result);

    $opt       = explode(',', $rows['opt']);
    $opt_count = explode(',', $rows['opt_count']);
    $opt_stock = explode(',', $rows['opt_stock']);

    for ($i = 0; $i < sizeof($opt); $i++) {
        $dis[$i] = '';

        if ($opt_stock[$i] == 0) {
            if ($rows['restock_date'] == "1111-00-00") {
                $chk[$i] .= " (품절)";
                $dis[$i] .= "disabled";
            } else if ($rows['restock_date'] == "0000-00-00") {
                $chk[$i] .= "<br/>(품절)";
                $dis[$i] .= "disabled";
            } else {
                $chk[$i] .= " (품절)";
                $dis[$i] .= "disabled";
            }
        } else if ($opt_stock[$i] == -1) {
            $opt[$i] .= "(단종)";
            $dis[$i] .= "disabled";
        } else {
            $chk[$i] .= ' [재고: ' . $opt_count[$i] . ' 개]';
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

        $ret .= '<option value="' . trim($opt[$i]) . ' ' . $selected . '" ' . $dis[$i] . '>' . $opt[$i] . $chk[$i] . '</option>';
    } // for end
    $ret .= '</select>';

    return $ret;
}

/**
 * 상품 정보 레코드(옵션2 관련)를 참조하여 옵션2 드롭다운 선택 메뉴(HTML select)를 화면에 바로 출력하는 함수
 * 
 * 품절 사유(재입고 미정, 재입고 예정일 등) 및 단종 상태에 따른 disabled 처리를 수행합니다.
 * 
 * @param array $rows 상품 정보 레코드 배열 (참조 전달)
 * @return void
 */
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

/**
 * 상품의 재입고 일정 정보(restock_date)를 기반으로 안내 메시지를 화면에 출력하는 함수
 * 
 * @param array $rows 상품 정보 레코드 배열 (참조 전달)
 * @return void
 */
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
 * 소비자가(소매가)와 회원 ID를 받아, 해당 회원의 할인율(dc_rate)을 적용한 공급가를 계산하여 반환하는 함수
 * 
 * @global mysqli $connect 데이터베이스 연결 객체
 * @param int|float $retail_price 소비자가(소매가)
 * @param string $id 회원 ID
 * @return int|float 할인율이 적용된 공급가
 */
function calc_offer_price($retail_price, $id)
{
    global $connect;

    $query  = "SELECT * FROM member WHERE id='$id'";
    $result = mysqli_query($connect, $query);
    $row    = mysqli_fetch_array($result);

    return $retail_price * (1 - ($row['dc_rate'] / 100));
}

/**
 * 상품 세부 정보와 회원 등급/설정 정보를 전달받아, 부가세 처리 및 할인가 적용 여부에 따른 최종 공급가를 계산하여 반환하는 함수
 * 
 * 회원 등급 설정의 과세 구분(tax: 'E'는 부가세 별도 10% 추가, 'I'는 부가세 포함)에 따라 가격을 최종 조정합니다.
 * 
 * @param array $rows 상품 정보 레코드 배열 (참조 전달)
 * @param array $mrow 회원 정보 레코드 배열 (참조 전달)
 * @return int|float 세금 및 할인이 반영된 최종 공급가
 */
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
 * 전달받은 변수(주로 $_GET, $_POST, $_SESSION 등)가 정의되어 있는지 확인하고 값을 안전하게 반환하는 헬퍼 함수
 * 
 * @param mixed $ary 검사할 변수 (참조 전달)
 * @return mixed 변수가 존재하면 해당 값, 존재하지 않으면 null 반환
 */
function set_var(&$ary)
{
    if (isset($ary) == true) {
        return $ary;
    } else {
        return null;
    }
}

/**
 * 브라우저 경고창(Alert)을 띄우고 지정된 URL 페이지로 강제 리다이렉트하는 함수
 * 
 * @param string $msg 경고창에 표시할 메시지
 * @param string $url 이동할 대상 URL
 * @return void
 */
function show_msg($msg, $url)
{
    echo "<meta HTTP-EQUIV='CONTENT-TYPE' content='text/html;charset=UTF-8'>
            <script language=\"JavaScript\">
              alert(\"$msg\");
             document.location.replace(\"$url\");
            </script>";
}

/**
 * 브라우저 경고창(Alert)을 띄운 후, 부모 창(Opener)을 새로고침하고 현재 팝업 창을 닫는 함수
 * 
 * @param string $msg 경고창에 표시할 메시지
 * @return void
 */
function show_msg_close($msg)
{
    echo "<meta HTTP-EQUIV='CONTENT-TYPE' content='text/html;charset=UTF-8'>
            <script language=\"JavaScript\">
              alert(\"$msg\");
              opener.document.location.reload();
              window.close();
            </script>";
}

/**
 * 브라우저 경고창(Alert)을 띄운 후, 부모 창(Opener)을 지정된 URL로 이동시키고 현재 팝업 창을 닫는 함수
 * 
 * @param string $msg 경고창에 표시할 메시지
 * @param string $url 부모 창이 이동할 대상 URL
 * @return void
 */
function show_msg_close2($msg, $url)
{
    echo "<meta HTTP-EQUIV='CONTENT-TYPE' content='text/html;charset=UTF-8'>
            <script language=\"JavaScript\">
              window.alert(\"$msg\");
              opener.document.location.replace(\"$url\");
              window.close();
            </script>";
}

/**
 * 에러 경고창(Alert)을 출력하고 이전 페이지(history -1)로 돌려보낸 뒤 스크립트 실행을 종료(exit)하는 함수
 * 
 * @param string $msg 에러 메시지
 * @param string|int|bool $bool 에러 처리 실행 여부 플래그
 * @return void
 */
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

/**
 * 브라우저 경고창(Alert)을 화면에 띄우는 함수 (종료나 페이지 이동 없음)
 * 
 * @param string $msg 경고 메시지
 * @return void
 */
function msg($msg)
{
    echo '<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <script>
     window.alert("' . $msg . '");
    </script>';
}

/**
 * 에러 경고창(Alert)을 띄우고 현재 창(주로 팝업)을 닫은 뒤 스크립트 실행을 종료(exit)하는 함수
 * 
 * @param string $msg 에러 메시지
 * @return void
 */
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

/**
 * 에러 경고창(Alert)을 출력하고 지정한 대상 창/경로로 리다이렉트한 후 스크립트 실행을 종료(exit)하는 함수
 * 
 * @param string $msg 에러 메시지
 * @param string $to 이동할 대상 타겟 및 URL (예: '_self' 타겟과 URL 조합)
 * @param string|int|bool $bool 에러 처리 실행 여부 플래그
 * @return void
 */
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

/**
 * HTML 메타 태그를 이용하여 지정된 URL로 즉시 리다이렉트하고 스크립트 실행을 종료(exit)하는 함수
 * 
 * @param string $re_url 리다이렉트할 대상 URL
 * @return void
 */
function redirect($re_url)
{
    echo "<meta http-equiv='Refresh' content='0; URL=$re_url'>";
    exit;
}

/**
 * MySQL 데이터베이스 서버에 연결하고 데이터베이스를 선택하는 레거시 연결 함수
 * 
 * @param string $host 데이터베이스 호스트 주소
 * @param string $id 사용자 ID
 * @param string $pass 사용자 비밀번호
 * @param string $db 선택할 데이터베이스 이름
 * @return mysqli_link 데이터베이스 연결 리소스 객체
 */
function my_connect($host, $id, $pass, $db)
{
    $connect = mysqli_connect($host, $id, $pass);
    mysqli_select_db($connect, $db);
    return $connect;
}

/**
 * HTML 특수문자(<, >, ")를 HTML 엔티티(&lt;, &gt;, &quot;)로 변환하여 브라우저에 그대로 노출하도록 처리하는 함수 (XSS 방지용)
 * 
 * @param string $str 변환할 원본 문자열
 * @return string 변환 완료된 문자열
 */
function del_html($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

/**
 * 웹 취약성(스크립트 주입 등 크래킹 공격) 방지를 위해 기본적인 HTML 태그 외의 코드는 무력화(HTML 엔티티화)하는 함수
 * 
 * 허용된 안전한 태그(div, p, font, b, marquee, img, a, embed)는 복구하고 그 외의 태그(<, >)는 비활성화합니다.
 * 
 * @param string $str 입력받은 원본 문자열
 * @return string 필터링 처리가 적용된 문자열
 */
function avoid_crack($str)
{
    $str = str_ireplace("<", "&lt;", $str);
    $str = str_ireplace("&lt;div", "<div", $str);
    $str = str_ireplace("&lt;p ", "<p ", $str);
    $str = str_ireplace("&lt;font", "<font", $str);
    $str = str_ireplace("&lt;b", "<b", $str);
    $str = str_ireplace("&lt;marquee", "<marquee", $str);
    $str = str_ireplace("&lt;img", "<img", $str);
    $str = str_ireplace("&lt;a ", "<a ", $str);
    $str = str_ireplace("&lt;embed", "<embed", $str);

    $str = str_ireplace("&lt;/div", "</div", $str);
    $str = str_ireplace("&lt;/p ", "</p ", $str);
    $str = str_ireplace("&lt;/font", "</font", $str);
    $str = str_ireplace("&lt;/b", "</b", $str);
    $str = str_ireplace("&lt;/marquee", "</marquee", $str);
    $str = str_ireplace("&lt;/img", "</img", $str);
    $str = str_ireplace("&lt;/a>", "</a>", $str);
    $str = str_ireplace("&lt;/embed", "</embed", $str);
    $str = str_ireplace("&gt;", ">", $str);
    return $str;
}

/**
 * 기본 텍스트 링크 형태의 간단한 페이지 네비게이션을 화면에 출력하는 레거시 함수
 * 
 * @param int $totalpage 전체 페이지 수
 * @param int $cpage 현재 페이지 번호
 * @param string $url 링크로 사용할 대상 URL 경로 (파라미터 전 단계)
 * @return void
 */
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
 * Bootstrap 기반의 스타일이 적용된 페이지 네비게이션(pagination HTML)을 화면에 출력하는 함수
 * 
 * @param int $totalpage 전체 페이지 수
 * @param int $cpage 현재 페이지 번호
 * @param string $url 페이지 링크용 기본 URL
 * @return void
 */
function page_nav($totalpage, $cpage, $url)
{
    $pagenumber = null;

    if (!$pagenumber) {
        $pagenumber = 5;
    }

    echo '<ul class="pagination">' . "\r\n";

    $startpage = intval(($cpage - 1) / $pagenumber) * $pagenumber + 1;
    $endpage   = intVal(((($startpage - 1) + $pagenumber) / $pagenumber) * $pagenumber);

    if ($totalpage <= $endpage) {
        $endpage = $totalpage;
    }

    if ($cpage > $pagenumber) {

        $curpage = intval($startpage - 1);
        echo '          <li><a href="' . $url . '&page=' . $curpage . '"> <i class="fa fa-chevron-left"></i> </a></li>' . "\r\n";
    } else {
        // echo '                <li><a href="#"><i class="fa fa-chevron-left"></i></a></li>' . "\r\n";
    }

    $curpage = $startpage;

    while ($curpage <= $endpage) {

        if ($curpage == $cpage) {
            echo '          <li class="active"><a href="#">' . $cpage . '</a></li>' . "\r\n";
        } else {
            echo '          <li><a href="' . $url . '&page=' . $curpage . '">' . $curpage . '</a></li>' . "\r\n";
        }
        $curpage++;
    }

    if ($totalpage > $endpage) {
        $curpage = intval($endpage + 1);
        echo '          <li><a href="' . $url . '&page=' . $curpage . '"> &middot;&middot;&middot; <i class="fa fa-chevron-right"></i> </a></li>' . "\r\n";
    } else {
        // echo '            <li><a href="#"><i class="fa fa-chevron-right"></i></a></li>';
    }

    echo '      </ul>' . "\r\n";
}

/**
 * 구매 금액을 기준으로 배송비를 계산하여 반환하는 함수
 * 
 * 구매 금액이 100,000원 미만인 경우 2,500원 배송비를 부과하고, 100,000원 이상은 무료(0원) 배송입니다.
 * 
 * @param int|float $money 구매 금액
 * @return int 배송비 금액
 */
function trans_cal($money)
{
    if ((int) $money < 100000) {
        $a_money = 2500;
    } else {
        $a_money = 0;
    }

    return $a_money;
}

/**
 * 8자리 숫자 형식의 날짜 문자열(예: YYYYMMDD)을 하이픈(-)이 포함된 형식(YYYY-MM-DD)으로 변환하여 반환하는 함수
 * 
 * @param string $strvalue 8자리 날짜 문자열
 * @return string 하이픈(-)이 적용된 날짜 문자열
 */
function shortdate($strvalue)
{
    $date_str = substr($strvalue, 0, 4) . "-" . substr($strvalue, 4, 2) . "-" . substr($strvalue, 6, 2);
    return $date_str;
}

/**
 * 한글이 포함된 문자열을 지정된 바이트(Byte) 길이로 자르고 말줄임표(...)를 붙여 반환하는 함수 (EUC-KR 대응용 레거시)
 * 
 * @param string $str 원본 문자열
 * @param int $maxlen 제한할 최대 바이트 수
 * @return string 지정 크기로 잘린 문자열
 */
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

/**
 * UTF-8 인코딩 문자열을 글자 단위가 아닌 바이트와 멀티바이트 특성을 고려하여 안전하게 자르고 접미사(suffix)를 붙여 반환하는 함수
 * 
 * @param string $str 원본 UTF-8 문자열
 * @param int $max_len 제한할 길이
 * @param string $suffix 자르고 나서 붙일 접미사 (예: '...')
 * @return string 잘린 결과 문자열
 */
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
        } else {
            $n++;
        }
        if ($noc >= $max_len) {
            break;
        }
    }
    if ($noc <= $max_len) {
        return $str;
    }

    if ($noc > $max_len) {
        $n -= $tn;
    }
    return substr($str, 0, $n) . $suffix;
}

/**
 * 타이틀 텍스트를 지정한 너비(단위: 글자 수 기준 너비)에 맞추어 줄이고 말줄임표를 붙여 반환하는 함수 (UTF-8)
 * 
 * @param string $title 원본 타이틀 문자열
 * @param int $end 제한할 너비 값
 * @return string 역슬래시가 제거되고 축소된 문자열
 */
function get_short($title, $end)
{
    $str = mb_strimwidth($title, '0', $end, '&#183;&#183;&#183;', 'utf-8');
    return stripslashes($str);
}

/**
 * 주문자의 우편번호와 수령인의 우편번호를 확인하여 도서산간(예외) 지역에 해당할 경우 배경색 스타일 속성(HTML)을 반환하는 함수
 * 
 * @param string $zipcode 우편번호 (현재 사용되지 않음)
 * @param array $row 주문 정보 레코드 배열 (참조 전달)
 * @return array 주문자 영역 배경색('bg1') 및 수령자 영역 배경색('bg2') HTML 코드 문자열을 담은 배열
 */
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

/**
 * 생성된 전체 게시판 목록을 데이터베이스에서 조회하여 헤더/사이드 메뉴의 HTML li 태그 리스트로 출력하는 함수
 * 
 * @param mysqli $connect 데이터베이스 연결 객체
 * @return void
 */
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

/**
 * 로그인하지 않은 비회원 사용자에게 보여줄 로그인 팝업 모달 창(HTML)을 출력하는 함수
 * 
 * @param int|string $i 모달 엘리먼트 고유 식별을 위한 인덱스 접미사
 * @param int|string $sslPort 보안 접속을 위한 SSL 포트 번호
 * @return void
 */
function getLoginWindow($i, $sslPort)
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
        echo "        <form name=\"guestLoginform" . $i, "\" class=\"form-group\" role=\"form\" action=\"https://www." . $_SERVER['SERVER_NAME'] . ":" . $sslPort . "/member/login_ok.php\" method=\"post\">\n";
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

/**
 * 상품에 대량 구매(수량별 차등 단가) 조건이 설정된 경우, 구간별 공급가를 리스트(HTML ul) 형태로 화면에 출력하는 함수
 * 
 * @param array $rows 상품 정보 레코드 배열
 * @return void
 */
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

/**
 * 활성화된 대분류 상품 카테고리 목록을 조회하여 네비게이션용 HTML 링크(li) 리스트로 출력하는 함수
 * 
 * @param mysqli $connect 데이터베이스 연결 객체
 * @param int|string $flag 추가 로직 분기용 플래그
 * @return void
 */
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

/**
 * 전체 게시판 목록을 조회하여 HTML li 형태의 게시판 이동 링크로 화면에 바로 출력하는 함수 (getBbsMenu와 유사하나 경로가 다름)
 * 
 * @param mysqli $connect 데이터베이스 연결 객체
 * @return void
 */
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

/**
 * 특정 업체(com_id)에 특정 상품(pro_id)을 거래(공급)할 수 있는 권한 여부를 확인하는 함수
 * 
 * @param mysqli $connect 데이터베이스 연결 객체
 * @param string $com_id 업체(회사) ID
 * @param string $pro_id 상품 고유 코드
 * @return string 거래 가능 여부 ('Y' 또는 'N')
 */
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

/**
 * 특정 업체(com_id)에 설정된 특정 상품(pro_id)의 개별 공급가 단가를 데이터베이스에서 조회하여 반환하는 함수
 * 
 * @param mysqli $connect 데이터베이스 연결 객체
 * @param string $com_id 업체(회사) ID
 * @param string $pro_id 상품 고유 코드
 * @return string 공급가 금액 문자열 (해당 데이터가 없는 경우 "0" 반환)
 */
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

/**
 * 게시판 목록 표시 시 해당 게시글이 지정된 기간($day 일) 이내에 작성된 신규 글인지 확인하여 NEW 라벨(HTML)을 출력하는 함수
 * 
 * @global mysqli $connect 데이터베이스 연결 객체
 * @param string $code 게시판 코드명 (예: 'notice')
 * @param int $main_no 게시물 고유 번호
 * @param int $day 신규 게시글로 판단할 일수 기준 (예: 3일 이내 작성 시 NEW)
 * @return void
 */
function check_new_post($code, $main_no, $day)
{
    global $connect;

    $bbs_name = "bbs_" . $code;

    $sql    = "SELECT * FROM $bbs_name WHERE main_no = $main_no";
    $result = mysqli_query($connect, $sql);

    if ($result) {
        $today = date("Y-m-d");

        $row       = mysqli_fetch_array($result);
        $post_date = substr($row['create_date'], 0, 11);
        $diff      = intval((strtotime($today) - strtotime($post_date)) / 86400);
        // echo $diff;

        if ($diff <= $day) {
            echo '<span class="label label-success">NEW</span>';
        }
    } else {
        echo "NO DATA";
    }
}

/**
 * 메뉴 등에서 게시판 이름 옆에 최신 글이 존재하는지 판별하여 NEW 라벨(HTML)을 반환하는 함수
 * 
 * 게시판의 가장 최신 글이 작성된 지 지정일($day 일) 이하인 경우에 NEW 라벨을 설정합니다.
 * 
 * @param mysqli $connect 데이터베이스 연결 객체
 * @param string $code 게시판 코드명
 * @param int $day 신규 기준으로 적용할 일수
 * @return string NEW 라벨 HTML 또는 빈 문자열
 */
function check_new_last_post($connect, $code, $day)
{
    $newIcon  = '';
    $bbs_name = "bbs_" . $code;

    $sql    = "SELECT * FROM $bbs_name ORDER BY main_no DESC LIMIT 1";
    $result = mysqli_query($connect, $sql);

    if ($result) {
        $today = date("Y-m-d");

        $row       = mysqli_fetch_array($result);
        $post_date = substr($row['create_date'], 0, 11);
        $diff      = intval((strtotime($today) - strtotime($post_date)) / 86400);
        // echo $diff;

        if ($diff <= $day) {
            $newIcon = '<span class="label label-success">NEW</span>';
        }
    } else {
        $newIcon = "NO DATA";
    }

    return $newIcon;
}

/**
 * 데이터베이스(admin_setup 테이블)에서 사이트 기본 설정 및 회사 정보들을 조회하여 연관 배열로 반환하는 함수
 * 
 * @global mysqli $connect 데이터베이스 연결 객체
 * @return array 회사명, 연락처, 주소, 무통장 계좌 등 회사 설정 정보가 포함된 연관 배열
 */
function get_company_info()
{

    global $connect;

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

/**
 * 지정된 게시판($code)에서 관리자('admin')가 작성한 게시글 목록을 가져와 푸터 등 임베드 영역용 HTML 테이블로 렌더링하여 바로 출력하는 함수
 * 
 * @global mysqli $connect 데이터베이스 연결 객체
 * @param string $code 게시판 코드명 (예: 'notice')
 * @param int $limit 최대로 가져올 게시물 수
 * @return void
 */
function get_bbs_title($code, $limit)
{

    global $connect;

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
                                            <div class="footer-static-title">
                                                <h3>{$brow1['bbs_name']}</h3>
                                                <span class="bbs_more"><a href="/bbs/list.php?code={$code}"><i class="fa fa-plus-square-o" aria-hidden="true"></i> more</a></span>
                                            </div>
                                            <div class="footer-static-content">
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
                                                <hr>
                                                </div>
                                             </section>
                                            </div>

HEREDOC;
    } else {
        $sql    = "SELECT * FROM $board WHERE id='admin' ORDER BY create_date DESC LIMIT $cline,$scale1";
        $result = mysqli_query($connect, $sql);

        for ($i = 0; $row = mysqli_fetch_array($result); $i++) {
            // $title = cut_string_utf8($row['title'], 20, '&#183;&#183;&#183;');
            $title = get_short($row['title'], 50);
            $title = stripslashes($title);
            echo <<<HEREDOC

                                                        <tr>
                                                            <td class="text-left">
                                                                <a href="/bbs/read.php?code={$code}&amp;main_no={$row['main_no']}&amp;flag=r" >{$title}</a>
                                                            </td>
HEREDOC;

            //날짜 형식을 바꾼다.
            $post_date = substr($row['create_date'], 0, 11);
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
                                            </div>

HEREDOC;
    }
}

/**
 * 주문 번호를 기반으로 PG(LGD_PAYTYPE) 결제 상세 정보를 조회하여, 결제 상태에 따른 아이콘/상세 메시지 및 결제 타입을 배열로 반환하는 함수
 * 
 * @global mysqli $connect 데이터베이스 연결 객체
 * @param string $orderid 주문 번호 (pg_info 테이블의 LGD_OID)
 * @return array 결제상태 HTML('pay_status'), 영수증 신청종류('apply_receipt'), 결제타입('pay_type')을 담은 연관 배열
 */
function get_pg_info($orderid)
{

    global $connect;

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
                    $pay_status    = '              <i class="fa fa-check-circle pay-color"></i> 입금완료' . "\r\n";
                    $apply_receipt = $pg_row['LGD_CASHRECEIPTKIND'];
                    $pay_type      = 'BANK';
                } elseif ($pg_row['LGD_CASFLAG'] == "C") {
                    $pay_status = '<i class="fa fa-times-circle"></i> 입금취소' . "\r\n";
                } else {
                    $pay_status = '<i class="fa fa-exclamation-triangle fail-color"></i> 입금실패(' . $pg_row['LGD_RESPCODE'] . ')' . "\r\n";
                }
            }

            break;
        case 'SC0030':
            if ($pg_row['LGD_RESPCODE'] == "0000") {
                $pay_status    = '<i class="fa fa-check-circle pay-color"></i> 이체완료' . "\r\n";
                $apply_receipt = $pg_row['LGD_CASHRECEIPTKIND'];
                $pay_type      = 'WIRE';
            } else {
                $pay_status = '<i class="fa fa-exclamation-triangle fail-color"></i> 이체실패(' . $pg_row['LGD_RESPCODE'] . ')' . "\r\n";
            }

            break;

        case 'SC0010': //SC0010 credit card
            if ($pg_row['LGD_RESPCODE'] == "0000") {
                $pay_status    = '<i class="fa fa-credit-card pay-color"></i> 카드결제 완료' . "\r\n";
                $apply_receipt = '-';
                $pay_type      = 'CARD';
            } else {
                $pay_status = '<i class="fa fa-exclamation-triangle fail-color"></i> 결제실패(' . $pg_row['LGD_RESPCODE'] . ')' . "\r\n";
            }

            break;
    }

    // return $pay_status;
    return array('pay_status' => $pay_status, 'apply_receipt' => $apply_receipt, 'pay_type' => $pay_type);
}

/**
 * 주문 목록 화면에서 각 주문 번호별 결제수단(가상계좌, 실시간계좌이체, 신용카드)의 상태를 조회하여 라벨과 버튼 모달 팝업 형태로 변환해 반환하는 함수
 * 
 * 가상계좌의 경우 은행명과 계좌번호를 모달 팝업으로 확인할 수 있는 인터페이스를 포함합니다.
 * 
 * @global mysqli $connect 데이터베이스 연결 객체
 * @param string $orderid 주문 번호
 * @return string 결제수단 및 처리 상태에 대한 HTML 문자열
 */
function get_pg_info2($orderid)
{

    global $connect, $BANK_CODES, $CARD_CODES;

    if (isset($orderid)) {

        // retrieve PG data
        $pg_sql    = "SELECT * FROM pg_info WHERE LGD_OID='$orderid' ";
        $pg_result = mysqli_query($connect, $pg_sql);
        $pg_row    = mysqli_fetch_array($pg_result);

        $pay_status   = '';
        $finance_name = '';

        switch ($pg_row['LGD_PAYTYPE']) {
            case 'SC0040':
                if ($pg_row['LGD_RESPCODE'] == "0000") {
                    // 계좌할당: R
                    if ("R" == $pg_row['LGD_CASFLAG']) {

                        if (isset($BANK_CODES[$pg_row['LGD_FINANCECODE']])) {
                            $finance_name = $BANK_CODES[$pg_row['LGD_FINANCECODE']];
                        }

                        $pay_status = '<i class="fa fa-university"></i> <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#myModal_' . $orderid . '">입금계좌확인</button>';
                        $pay_status .= '  <div class="modal fade" id="myModal_' . $orderid . '">';
                        $pay_status .= '    <div class="modal-dialog">';
                        $pay_status .= '      <div class="modal-content">';
                        $pay_status .= '        <div class="modal-header">';
                        $pay_status .= '          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
                        $pay_status .= '          <h4 class="modal-title">입금계좌(가상계좌) 확인</h4>';
                        $pay_status .= '        </div>';
                        $pay_status .= '        <div class="modal-body">';
                        $pay_status .= '          <h4 class="alert alert-danger rol="alert">' . $finance_name . ': ' . $pg_row['LGD_ACCOUNTNUM'] . '</h4>';
                        $pay_status .= '          <p>1) 가상계좌는 일회성 계좌이므로 재사용시(다시 그 계좌로 입금하시는 경우) 타인의 계좌로 입금될 가능성이 있습니다.<br />';
                        $pay_status .= '             이 경우는 고객의 책임이므로 사용에 주의하시기 바랍니다. <br />';
                        $pay_status .= '             2) 가상계좌의 경우 CD기에서 현금입금 하실 수 없습니다.  CD기에서 이체는 가능합니다.</p>';
                        $pay_status .= '        </div>';
                        $pay_status .= '        <div class="modal-footer">';
                        $pay_status .= '          <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>';
                        $pay_status .= '        </div>';
                        $pay_status .= '      </div>'; //<!-- /.modal-content -->
                        $pay_status .= '    </div>';   //<!-- /.modal-dialog -->
                        $pay_status .= '  </div>';     //<!-- /.modal -->

                    } elseif ($pg_row['LGD_CASFLAG'] == "I") {
                        $pay_status = '<i class="fa fa-check-circle pay-color"></i> 입금완료';
                    } elseif ($pg_row['LGD_CASFLAG'] == "C") {
                        $pay_status = '<i class="fa fa-times-circle"></i> 입금취소';
                    } else {
                        $pay_status = '<i class="fa fa-exclamation-triangle fail-color"></i> 입금실패(' . $pg_row['LGD_RESPCODE'] . ')';
                    }
                } else {
                    $pay_status = '<i class="fa fa-exclamation-triangle fail-color"></i> <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal_' . $orderid . '">실패(' . $pg_row['LGD_RESPCODE'] . ')</button>';
                    $pay_status .= '  <div class="modal fade" id="myModal_' . $orderid . '">';
                    $pay_status .= '    <div class="modal-dialog">';
                    $pay_status .= '      <div class="modal-content">';
                    $pay_status .= '        <div class="modal-header">';
                    $pay_status .= '          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
                    $pay_status .= '          <h4 class="modal-title">입금취소 실패</h4>';
                    $pay_status .= '        </div>';
                    $pay_status .= '        <div class="modal-body">';
                    $pay_status .= '          <h4 class="alert alert-danger rol="alert"> ' . $pg_row['LGD_RESPCODE'] . ': ' . $pg_row['LGD_RESPMSG'] . '</h4>';
                    $pay_status .= '        </div>';
                    $pay_status .= '        <div class="modal-footer">';
                    $pay_status .= '          <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>';
                    $pay_status .= '        </div>';
                    $pay_status .= '      </div>'; //<!-- /.modal-content -->
                    $pay_status .= '    </div>';   //<!-- /.modal-dialog -->
                    $pay_status .= '  </div>';     //<!-- /.modal -->

                }

                break;
            case 'SC0030':
                if (isset($BANK_CODES[$pg_row['LGD_FINANCECODE']])) {
                    $finance_name = $BANK_CODES[$pg_row['LGD_FINANCECODE']];
                }

                if ($pg_row['LGD_RESPCODE'] == "0000") {
                    $pay_status = '<i class="fa fa-check-circle pay-color"></i> 이체완료';
                } else {
                    $pay_status = '<i class="fa fa-exclamation-triangle fail-color"></i> <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal_' . $orderid . '">이체실패(' . $pg_row['LGD_RESPCODE'] . ')</button>';
                    $pay_status .= '  <div class="modal fade" id="myModal_' . $orderid . '">';
                    $pay_status .= '    <div class="modal-dialog">';
                    $pay_status .= '      <div class="modal-content">';
                    $pay_status .= '        <div class="modal-header">';
                    $pay_status .= '          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
                    $pay_status .= '          <h4 class="modal-title">입금취소 실패</h4>';
                    $pay_status .= '        </div>';
                    $pay_status .= '        <div class="modal-body">';
                    $pay_status .= '          <h4 class="alert alert-danger rol="alert"> ' . $pg_row['LGD_RESPCODE'] . ': ' . $pg_row['LGD_RESPMSG'] . '</h4>';
                    $pay_status .= '        </div>';
                    $pay_status .= '        <div class="modal-footer">';
                    $pay_status .= '          <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>';
                    $pay_status .= '        </div>';
                    $pay_status .= '      </div>'; //<!-- /.modal-content -->
                    $pay_status .= '    </div>';   //<!-- /.modal-dialog -->
                    $pay_status .= '  </div>';     //<!-- /.modal -->
                    // $pay_status = '<i class="fa fa-exclamation-triangle fail-color"></i> 이체실패(' . $pg_row['LGD_RESPCODE'] . ')';
                }

                break;

            case 'SC0010': //SC0010 credit card
                if (isset($CARD_CODES[$pg_row['LGD_FINANCECODE']])) {
                    $finance_name = $CARD_CODES[$pg_row['LGD_FINANCECODE']];
                }

                //카드결제가 취소성공해도 0000이 넘어오므로 다른 값으로 체크
                if ("0000" == $pg_row['LGD_RESPCODE']) {
                    $pay_status = '<i class="fa fa-credit-card pay-color"></i> 카드결제 완료';
                } elseif ("취소성공" == $pg_row['LGD_RESPMSG']) {
                    $pay_status = '<i class="fa fa-exclamation-triangle fail-color"></i> 결제취소';
                } else {
                    $pay_status = '<i class="fa fa-exclamation-triangle fail-color"></i> <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#myModal_' . $orderid . '">결제실패(' . $pg_row['LGD_RESPCODE'] . ')</button>';
                    $pay_status .= '  <div class="modal fade" id="myModal_' . $orderid . '">';
                    $pay_status .= '    <div class="modal-dialog">';
                    $pay_status .= '      <div class="modal-content">';
                    $pay_status .= '        <div class="modal-header">';
                    $pay_status .= '          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
                    $pay_status .= '          <h4 class="modal-title">카드결제 취소 실패</h4>';
                    $pay_status .= '        </div>';
                    $pay_status .= '        <div class="modal-body">';
                    $pay_status .= '          <h4 class="alert alert-danger rol="alert"> ' . $pg_row['LGD_RESPCODE'] . ': ' . $pg_row['LGD_RESPMSG'] . '</h4>';
                    $pay_status .= '        </div>';
                    $pay_status .= '        <div class="modal-footer">';
                    $pay_status .= '          <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>';
                    $pay_status .= '        </div>';
                    $pay_status .= '      </div>'; //<!-- /.modal-content -->
                    $pay_status .= '    </div>';   //<!-- /.modal-dialog -->
                    $pay_status .= '  </div>';     //<!-- /.modal -->

                    // $pay_status = '<i class="fa fa-exclamation-triangle fail-color"></i> 결제실패(' . $pg_row['LGD_RESPCODE'] . ')';
                }

                break;
        }
    } else {
        $pay_status = '<i class="fa fa-exclamation-triangle fail-color"></i> 결제실패(' . $pg_row['LGD_RESPCODE'] . ')';
    }

    return $pay_status;
}

/**
 * 주문의 PG 결제 성공/실패 응답 데이터(결제기관 코드, 승인번호, 카드번호 등)를 리스트(HTML ul) 형태로 화면에 출력하는 함수
 * 
 * @global mysqli $connect 데이터베이스 연결 객체
 * @param string $orderid 주문 번호
 * @return void
 */
function show_pay_data($orderid)
{

    global $connect, $BANK_CODES, $CARD_CODES_DETAIL;

    // retrieve PG data
    $pg_sql    = "SELECT * FROM pg_info WHERE LGD_OID='$orderid' ";
    $pg_result = mysqli_query($connect, $pg_sql);
    $pg_row    = mysqli_fetch_array($pg_result);

    $finance_name = '';

    switch ($pg_row['LGD_PAYTYPE']) {
        case 'SC0040':
            if ($pg_row['LGD_RESPCODE'] == "0000") {
                // 입금완료: I
                if ($pg_row['LGD_CASFLAG'] == "I") {

                    if (isset($BANK_CODES[$pg_row['LGD_FINANCECODE']])) {
                        $finance_name = $BANK_CODES[$pg_row['LGD_FINANCECODE']];
                    }
                }
            }

            break;
        case 'SC0030':
            if (isset($BANK_CODES[$pg_row['LGD_FINANCECODE']])) {
                $finance_name = $BANK_CODES[$pg_row['LGD_FINANCECODE']];
            }

            break;

        case 'SC0010': //SC0010 credit card
            if (isset($CARD_CODES_DETAIL[$pg_row['LGD_FINANCECODE']])) {
                $finance_name = $CARD_CODES_DETAIL[$pg_row['LGD_FINANCECODE']];
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

/**
 * 현재 페이지의 URL 경로와 비교하여 해당 메뉴 아이템 활성화(class="active") 여부를 결정하는 함수
 * 
 * @param string $page_name 비교할 페이지 파일 이름 (예: 'index.php')
 * @return string|null 현재 활성화된 페이지인 경우 'class="active"', 그렇지 않으면 null 반환
 */
function check_active_class($page_name)
{
    $path = explode("/", $_SERVER['PHP_SELF']);
    if ($page_name == $path[3]) {
        return $active = 'class="active"';
    } else {
        return null;
    }
}

/**
 * 지정된 길이의 무작위 영숫자 조합 문자열(난수 비밀번호 등)을 생성하여 반환하는 함수
 * 
 * 가독성을 위해 헷갈리기 쉬운 글자(i, l, I)를 제외한 문자 풀에서 난수를 생성합니다.
 * 
 * @param int $length 생성할 문자열의 길이
 * @return string 생성된 임의의 문자열
 */
function GenerateString($length)
{
    $characters = "0123456789";
    $characters .= "abcdefghijkmnopqrstuvwxyz"; //비밀번호 l, i가 구분이 안되니 삭제
    $characters .= "ABCDEFGHJKLMNOPQRSTUVWXYZ"; //비밀번호 I 구분이 안되니 삭제

    $string_generated = "";

    $nmr_loops = $length;
    while ($nmr_loops--) {
        $string_generated .= $characters[mt_rand(0, strlen($characters))];
    }

    return $string_generated;
}

/**
 * 업로드된 파일명 또는 경로를 검사하여 허용된 이미지 확장자(jpg, jpeg, gif, png)인지 확인하고, 아닐 경우 에러 페이지로 돌려보내는 함수
 * 
 * @param string $uploadFile 검사할 파일 이름 또는 파일 경로
 * @return void
 */
function check_img_extension($uploadFile)
{

    $file_ext = substr(strrchr($uploadFile, "."), 1);
    $file_ext = strtolower($file_ext);

    if ($file_ext != 'jpg' && $file_ext != 'gif' && $file_ext != 'jpeg' && $file_ext != 'png') {
        err_msg("" . $uploadFile . " - " . $file_ext . " :: 이미지 파일만 올릴 수 있습니다.");
    }
}

/**
 * 파일 경로 등에서 마지막에 매칭되는 구분자(needle)를 기준으로 이전 경로(부모 디렉토리)까지 잘라 반환하는 함수
 * 
 * 예: haystack = "../../upload/p_image/B068-02/b/4848_3.jpg", needle = "/"
 * return "../../upload/p_image/B068-02"
 * 
 * @param string $haystack 전체 원본 문자열 (경로 등)
 * @param string $needle 자르기 기준이 될 마지막 찾을 구분 문자
 * @return string 기준 문자 이전까지의 문자열 경로
 */
function reverse_strrchr($haystack, $needle)
{
    $pos = strrpos($haystack, $needle);
    if ($pos === false) {
        return $haystack;
    }
    return substr($haystack, 0, $pos - 1);
}

/**
 * 대상 디렉토리와 하위의 모든 파일 및 서브 디렉토리를 재귀적으로 삭제하는 함수
 * 
 * @param string $dir 삭제할 대상 디렉토리 경로
 * @return bool 삭제 성공 여부
 */
function recurse_rmdir($dir)
{
    if (is_dir($dir)) {
        // 디렉토리 자신 「.」 과 상위 디렉토리 「..」 를 배열에서 제외
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? recurse_rmdir("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    } else {
        return false;
    }
}

/**
 * HTTP POST 파일 업로드($_FILES) 건에 대해 오류 여부, 허용 확장자, 최대 크기 초과 여부를 검증하는 함수
 * 
 * @param int $i 다중 업로드 파일 배열($_FILES) 내의 인덱스 번호
 * @return array 검증 결과 성공 여부(bool), 추출된 확장자(string), 에러 메시지 목록(array)을 포함한 연관 배열
 */
function check_uploaded_file($i)

{
    $error_msg = array();
    $ext       = '';

    $size     = $_FILES['b_image']['size'][$i];
    $error    = $_FILES['b_image']['error'][$i];
    $img_type = $_FILES['b_image']['type'][$i];
    $tmp_name = $_FILES['b_image']['tmp_name'][$i];

    if ($error != UPLOAD_ERR_OK) {
        // 업로드 에러의 경우
        if ($error == UPLOAD_ERR_NO_FILE) {
            // 업로드 되지 않은 경우는 에러 처리를 하지 않는다.
        } else {
            // 그 외의 에러의 경우
            $error_msg[] = '업로드 에러입니다';
        }
        return array(false, $ext, $error_msg);
    } else {
        // 업로드 에러가 아닌 경우
        // 전송된 MIME 타입으로부터 확장자를 결정
        if ($img_type == 'image/gif') {
            $ext = 'gif';
        } elseif ($img_type == 'image/jpeg' || $img_type == 'image/pjpeg') {
            $ext = 'jpg';
        } elseif ($img_type == 'image/png' || $img_type == 'image/x-png') {
            $ext = 'png';
        }

        // 이미지 파일의 크기 하한을 확인합니다.
        if ($size == 0) {
            $error_msg[] = '파일이 존재하지 않거나 빈 파일입니다.';
            // 이미지 파일의 크기 상한을 확인합니다.
        } elseif ($size > MAX_SIZE) {
            $error_msg[] = '파일 크기는 1MB 이하로 해주세요';
            // 전송된 MIME 타입과 이미지 파일의 MIME 타입이 일치하는지 확인합니다.
        } elseif ($ext != 'gif' && $ext != 'jpg' && $ext != 'png') {
            $error_msg[] = '업로드 가능한 파일은 gif, jpg, png 입니다';
        } else {
            return array(true, $ext, $error_msg);
        }
    }
    return array(false, $ext, $error_msg);
}

/**
 * 새로운 상품 등록 시 유일한 식별 코드를 생성하기 위해 임시 insert 작업을 실행하고 자동 증가 아이디와 오늘 날짜를 조합해 고유 코드를 반환하는 함수
 * 
 * 생성되는 코드 형식 예: "p0710-123"
 * 
 * @global mysqli $connect 데이터베이스 연결 객체
 * @return string|null 생성된 고유 상품 코드 문자열
 */
function generate_item_code()
{
    global $connect;

    $qry = "INSERT INTO products_code VALUES ('')";
    $res = mysqli_query($connect, $qry);

    if ($res) {
        $p_code = mysqli_insert_id($connect);
        $wdate  = date('md');
        $code   = "p" . $wdate . "-" . $p_code;
        return $code;
    }
}

/**
 * 상품 수정 폼에서 기존 상품 레코드 정보에 기반해 기존 등록된 옵션 목록(옵션명, 수량, 품절/단종 라디오 버튼)을 화면에 복원하여 출력하는 함수
 * 
 * @param array $row 상품 정보 레코드 배열
 * @return void
 */
function restore_option($row)
{
    $optname  = explode(",", $row['opt']);
    $optcount = explode(",", $row['opt_count']);
    $optstock = explode(",", $row['opt_stock']);

    for ($i = 0; $i < count($optname); $i++) {
        echo '<input name="opt_name[]" type="text" class="form-control" value="' . $optname[$i] . '" size="50" >&nbsp;';
        echo '<input name="opt_count[]" type="text" class="form-control" value="' . $optcount[$i] . '" size="5" >&nbsp;';

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

        echo <<<HEREDOC

        <input name="opt_stock['{$i}']" type="radio" value="1" {$a} />재고 있음&nbsp;
        <input name="opt_stock['{$i}']" type="radio" value="0" {$b} />품절&nbsp;
        <input name="opt_stock['{$i}']" type="radio" value="-1" {$c} />단종

HEREDOC;

        echo "<br>";
    }
}

/**
 * 상품 등록 또는 수정 시 대/중 카테고리 분류 선택 상자(HTML select)를 화면에 렌더링하고, 기존 선택되었던 카테고리를 복원 표시하는 함수
 * 
 * @global mysqli $connect 데이터베이스 연결 객체
 * @param string $mode 동작 모드 ('insert' 또는 'update')
 * @param string $lcode 대카테고리 코드
 * @param string $mcode 중카테고리 코드
 * @return void
 */
function restore_category($mode, $lcode, $mcode)
{
    global $connect;

    if ($mode == "insert") {
        $jsCode = "change_code();";
    } elseif ($mode == "update") {
        $p_num  = set_var($_GET['p_num']);
        $page   = set_var($_GET['page']);
        $jsCode = "change_lcode(" . $p_num . ", " . $page . ");";
    }
    echo <<<HEREDOC

                                                                <select class="form-control" name="lcode" onChange="{$jsCode}">
                                                                <option value="">선택하세요</option>
HEREDOC;

    $ca1_qry    = "SELECT * FROM products_category1 WHERE del='N' ORDER BY code";
    $ca1_result = mysqli_query($connect, $ca1_qry);

    // $lcode = set_var($_POST['lcode']);

    for ($i = 0; $ca1_row = mysqli_fetch_array($ca1_result); $i++) {
        if ($ca1_row['code'] == $lcode) {
            echo <<<HEREDOC

                                                                <option value="{$ca1_row['code']}" selected>
                                                                    {$ca1_row['name']}
                                                                </option>
HEREDOC;
        } else {
            echo <<<HEREDOC

                                                                <option value="{$ca1_row['code']}">
                                                                    {$ca1_row['name']}
                                                                </option>
HEREDOC;
        }
    }

    echo <<<HEREDOC
                                                            </select>

                                                            <select class="form-control" name="mcode">
                                                                <option value="">선택하세요</option>
HEREDOC;

    $ca2_qry    = "SELECT * FROM products_category2 WHERE up_category='$lcode' AND del='N' ORDER BY code";
    $ca2_result = mysqli_query($connect, $ca2_qry);

    for ($i = 0; $ca2_row = mysqli_fetch_array($ca2_result); $i++) {
        if ($ca2_row['code'] == $mcode) {
            echo <<<HEREDOC
                                                                <option value="{$ca2_row['code']}" selected="selected">
                                                                    {$ca2_row['name']}
                                                                </option>
HEREDOC;
        } else {
            echo <<<HEREDOC
                                                                <option value="{$ca2_row['code']}">
                                                                    {$ca2_row['name']}
                                                                </option>
HEREDOC;
        }
    }

    echo '</select>' . "\r\n";
}

/**
 * 포트 번호 존재 여부에 기반하여 보안 프로토콜(https) 적용 여부를 확인하고 해당 프로토콜 문자열을 반환하는 함수
 * 
 * @param int|string|null $port SSL 포트 번호 정보
 * @return string 프로토콜 접두어 ("https:" 또는 "http:")
 */
function check_protocol($port)
{
    $isSecured = set_var($port);

    if ($isSecured) {
        return $protocol = "https:";
    } else {
        return $protocol = "http:";
    }
}

/**
 * 템플릿 메일 파일에서 자리 표시자(Placeholder)들을 회원 및 사이트 설정 정보로 치환하여 발송 가능한 HTML 이메일 본문을 완성해 반환하는 함수
 * 
 * @param array $info 회원 설정 및 사이트 정보 연관 배열
 * @param string $file mail 디렉토리 내 치환에 사용할 템플릿 파일 이름
 * @return string 치환이 완료된 HTML 메일 본문 문자열
 */
function format_email($info, $file)
{

    //grab the template content
    $template = file_get_contents('../mail/' . $file . '');

    //replace all the tags
    $template = str_replace('{USERNAME}', $info['name'], $template);
    $template = str_replace('{ID}', $info['id'], $template);
    $template = str_replace('{EMAIL}', $info['email'], $template);
    $template = str_replace('{FAX}', $info['fax'], $template);
    $template = str_replace('{SITEPATH}', $info['homepage'], $template);

    //return the html of the template
    return $template;
}

/**
 * 주문 시 선택한 옵션의 남은 재고 수량과 주문 요청 수량을 비교하여 초과 주문 여부를 검사하는 함수
 * 
 * @global mysqli $connect 데이터베이스 연결 객체
 * @param int|string $product_num 주문하려는 상품 고유 번호
 * @param string $selected_opt 선택된 상품 옵션 문자열
 * @param int $order_count 주문하려는 수량
 * @return string|null 재고 수량이 부족하여 초과 주문일 경우 "over" 반환, 정상인 경우 null 반환
 */
function check_over_order($product_num, $selected_opt, $order_count)
{

    global $connect;

    // 상품옵션 재고 확인
    $qry = "SELECT * FROM products WHERE num='$product_num' ";
    $res = mysqli_query($connect, $qry);
    $row = mysqli_fetch_array($res);

    $products_opt       = explode(",", $row['opt']);       // 제품의 옵션을 배열로 저장
    $products_opt_count = explode(",", $row['opt_count']); // 제품의 옵션수량을 배열로 저장

    // 주문옵션 재고 확인
    for ($i = 0; $i < sizeof($products_opt); $i++) {
        if ($products_opt[$i] == $selected_opt) {
            if ($products_opt_count[$i] < $order_count) {
                return "over";
            }
        }
    }
}
