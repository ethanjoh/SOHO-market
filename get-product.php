<?php
$uploaddir = "upload/prixe_goods.csv";

//hosting information
$host = "localhost";
$id   = "kimsj2010";
$pw   = "PRIXE2010";
$db   = "kimsj2010";

//connect local db
$connect = mysqli_connect($host, $id, $pw);
mysqli_select_db($connect, $db);

mysqli_query($connect, "TRUNCATE TABLE products");

$fp = fopen("$uploaddir", "r");

$line = 1;

while ($data = fgetcsv($fp, 4000, ",")) {
    /*
    echo "<pre>";
    print_r($data);
    echo "</pre>";
     */

    // generate prod_code

    /*$query = "INSERT INTO products_code VALUES ('')";
    mysqli_query($connect, $query);

    $query = "SELECT max(num) AS maxid FROM products_code";
    $result = mysqli_query($connect, $query);
    $row = mysqli_fetch_array($result);
    mysqli_free_result($result);

    $p_code = $row['maxid'];
     */
    $p_code = $data['0']; //주문내역에서 참조하기 위해 그대로 가져옴

    $wdate     = date('md');
    $prod_code = "p" . $wdate . "-" . $p_code;

    //substitute goods_code and match category
    $goods_code = $data['0'];
    $no         = substr($goods_code, 0, 4);

    switch ($no) {
        case "0100": //열쇠고리
            $lcode = "10"; //프릭스
            $mcode = "1";
            $scode = "11";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "0200": //핸드폰줄
            $lcode = "10";
            $mcode = "1";
            $scode = "12";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "0500": //그 외
            $lcode = "10";
            $mcode = "5";
            $scode = "0";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "0601": //주방/욕실용품 > 주방
            $lcode = "10";
            $mcode = "3";
            $scode = "20";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "0602": //주방/욕실용품 > 욕실
            $lcode = "10";
            $mcode = "3";
            $scode = "21";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "0701": //개인소품 > 명함케이스
            $lcode = "10";
            $mcode = "1";
            $scode = "8";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "0703": //개인소품 > 담배케이스
            $lcode = "10";
            $mcode = "1";
            $scode = "7";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "0705": //개인소품 > 휴대용품/카메라
            $lcode = "10";
            $mcode = "1";
            $scode = "10";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "0706": //개인소품 > 문구사무
            $lcode = "10";
            $mcode = "4";
            $scode = "0";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "0707": //개인소품 > 안마기
            $lcode = "10";
            $mcode = "1";
            $scode = "9";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "0801": //인테리어소품 > 데스크용품
            $lcode = "10";
            $mcode = "2";
            $scode = "13";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "0802": //인테리어소품 > 시계
            $lcode = "10";
            $mcode = "2";
            $scode = "17";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "0803": //인테리어소품 > 인테리어용품
            $lcode = "10";
            $mcode = "2";
            $scode = "18";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "0804": //인테리어소품 > 손목쿠션
            $lcode = "10";
            $mcode = "2";
            $scode = "16";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "0805": //인테리어소품 > 메모홀더
            $lcode = "10";
            $mcode = "2";
            $scode = "15";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "0806": //인테리어소품 > 폰파우치
            $lcode = "10";
            $mcode = "2";
            $scode = "19";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "0807": //인테리어소품 > 라디오
            $lcode = "10";
            $mcode = "2";
            $scode = "14";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "0900": //디버거
            $lcode = "20";
            $mcode = "0";
            $scode = "0";

            $id      = "dburger";
            $company = "디버거";
            break;
        case "1001": //멀티플초이스
            $lcode = "10";
            $mcode = "3";
            $scode = "20";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "1200": //마네키네코
            $lcode = "22";
            $mcode = "0";
            $scode = "0";

            $id      = "klaus";
            $company = "클라우스";
            break;
        case "1300": //디자인웁스
            $lcode = "23";
            $mcode = "0";
            $scode = "0";

            $id      = "oops";
            $company = "디자인웁스";
            break;
        case "1400": //시소그라픽스
            $lcode = "33";
            $mcode = "0";
            $scode = "0";

            $id      = "seeso";
            $company = "시소그라픽스";
            break;
        case "1600": //레드카메라
            $lcode = "25";
            $mcode = "0";
            $scode = "0";

            $id      = "redcamera";
            $company = "레드카메라";
            break;
        case "2100": //캐릭원
            $lcode = "39";
            $mcode = "0";
            $scode = "0";

            $id      = "characone";
            $company = "캐릭원";
            break;
        case "2200": //대하상사
            $lcode = "19";
            $mcode = "0";
            $scode = "0";

            $id      = "daeha";
            $company = "대하상사";
            break;
        case "2400": //코모레비
            $lcode = "40";
            $mcode = "0";
            $scode = "0";

            $id      = "komorebi";
            $company = "코모레비";
            break;
        case "2500": //문구용품
            $lcode = "10";
            $mcode = "4";
            $scode = "0";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "2502": //선물북
            $lcode = "37";
            $mcode = "0";
            $scode = "0";

            $id      = "indigo";
            $company = "인디고";
            break;
        case "2503": //노트 외
            $lcode = "10";
            $mcode = "4";
            $scode = "0";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "2505": //리폼스티커
            $lcode = "10";
            $mcode = "4";
            $scode = "0";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "2600": //7321
            $lcode = "1";
            $mcode = "0";
            $scode = "0";

            $id      = "7321";
            $company = "7321";
            break;
        case "2700": //마법수프
            $lcode = "28";
            $mcode = "0";
            $scode = "0";

            $id      = "magicsoup";
            $company = "마법수프";
            break;
        case "3300": //퍼니맨
            $lcode = "43";
            $mcode = "0";
            $scode = "0";

            $id      = "funnyman";
            $company = "퍼니맨";
            break;
        case "3400": //라이프데코
            $lcode = "24";
            $mcode = "0";
            $scode = "0";

            $id      = "jayce";
            $company = "라이프데코";
            break;
        case "3500": //제토이
            $lcode = "38";
            $mcode = "0";
            $scode = "0";

            $id      = "jetoy";
            $company = "제토이";
            break;
        case "3800": //TOMY
            $lcode = "13";
            $mcode = "0";
            $scode = "0";

            $id      = "tomy";
            $company = "TOMY";
            break;
        case "4102": //신지가토(사무용품)
            $lcode = "34";
            $mcode = "9";
            $scode = "0";

            $id      = "oops";
            $company = "디자인웁스";
            break;
        case "4103": //신지가토(생활용품)
            $lcode = "34";
            $mcode = "10";
            $scode = "0";

            $id      = "oops";
            $company = "디자인웁스";
            break;
        case "4300": //모노폴리
            $lcode = "8";
            $mcode = "0";
            $scode = "0";

            $id      = "monopoly";
            $company = "모노폴리";
            break;
        case "4400": //노아
            $lcode = "17";
            $mcode = "0";
            $scode = "0";

            $id      = "oops";
            $company = "디자인웁스";
            break;
        case "4500": //무즈앤뷰즈
            $lcode = "9";
            $mcode = "0";
            $scode = "0";

            $id      = "moods";
            $company = "무즈앤뷰즈";
            break;
        case "4700": //풀디자인
            $lcode = "7";
            $mcode = "0";
            $scode = "0";

            $id      = "fulldesign";
            $company = "풀디자인";
            break;
        case "4900": //레종
            $lcode = "10";
            $mcode = "4";
            $scode = "0";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "5000": //블루버드
            $lcode = "4";
            $mcode = "0";
            $scode = "0";

            $id      = "bluebud";
            $company = "내가원하는디자인";
            break;
        case "5200": //미니버스
            $lcode = "29";
            $mcode = "0";
            $scode = "0";

            $id      = "minibus";
            $company = "미니버스";
            break;
        case "5401": //2008 다이어리
            $lcode = "47";
            $mcode = "6";
            $scode = "1";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "5600": //UiT
            $lcode = "14";
            $mcode = "0";
            $scode = "0";

            $id      = "uit";
            $company = "유아이티";
            break;
        case "5700": //롤러코스터
            $lcode = "27";
            $mcode = "0";
            $scode = "0";

            $id      = "roller";
            $company = "롤러코스터";
            break;
        case "5900": //안테나샵
            $lcode = "3";
            $mcode = "0";
            $scode = "0";

            $id      = "antenna";
            $company = "안테나샵";
            break;
        case "6100": //쓰바
            $lcode = "35";
            $mcode = "0";
            $scode = "0";

            $id      = "ssba";
            $company = "쓰바";
            break;
        case "6300": //포니브라운
            $lcode = "44";
            $mcode = "0";
            $scode = "0";

            $id      = "pony";
            $company = "포니브라운";
            break;
        case "6500": //뽀신
            $lcode = "30";
            $mcode = "0";
            $scode = "0";

            $id      = "bbosin";
            $company = "뽀신";
            break;
        case "6800": //슈크
            $lcode = "31";
            $mcode = "0";
            $scode = "0";

            $id      = "shuk";
            $company = "슈크";
            break;
        case "7100": //로모
            $lcode = "26";
            $mcode = "0";
            $scode = "0";

            $id      = "lomo";
            $company = "로모그래피 카메라";
            break;
        case "7200": //토리아드
            $lcode = "41";
            $mcode = "0";
            $scode = "0";

            $id      = "toriad";
            $company = "토리아드";
            break;
        case "7300": //인디고
            $lcode = "37";
            $mcode = "0";
            $scode = "0";

            $id      = "indigo";
            $company = "인디고";
            break;
        case "7400": //후지
            $lcode = "45";
            $mcode = "0";
            $scode = "0";

            $id      = "fuji";
            $company = "후지 인스탁스";
            break;
        case "7500": //2009 다이어리
            $lcode = "47";
            $mcode = "7";
            $scode = "0";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "7502": //2009 다이어리
            $lcode = "47";
            $mcode = "7";
            $scode = "2";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "7503": //2009 다이어리
            $lcode = "47";
            $mcode = "7";
            $scode = "3";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "7504": //2009 다이어리
            $lcode = "47";
            $mcode = "7";
            $scode = "4";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "7505": //2009 다이어리
            $lcode = "47";
            $mcode = "7";
            $scode = "5";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "7506": //2009 다이어리
            $lcode = "47";
            $mcode = "7";
            $scode = "6";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "7600": //로마네
            $lcode = "11";
            $mcode = "0";
            $scode = "0";

            $id      = "romane";
            $company = "로마네";
            break;
        case "7800": //잭팟 스티커
            $lcode = "46";
            $mcode = "0";
            $scode = "0";
            $id    = "admin";

            $company = "프릭스";
            break;
        case "7900": //디자인 펍
            $lcode = "22";
            $mcode = "0";
            $scode = "0";

            $id      = "klaus";
            $company = "클라우스";
            break;
        case "8000": //아이코닉
            $lcode = "36";
            $mcode = "0";
            $scode = "0";

            $id      = "iconic";
            $company = "아이코닉";
            break;
        case "8600": //2010 다이어리
            $lcode = "47";
            $mcode = "8";
            $scode = "0";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "8200": //건망증
            $lcode = "15";
            $mcode = "0";
            $scode = "0";

            $id      = "gunmang";
            $company = "건망증";
            break;
        case "8300": //디자인다다
            $lcode = "21";
            $mcode = "0";
            $scode = "0";

            $id      = "dada";
            $company = "디자인다다";
            break;
        case "8400": //씨플레이
            $lcode = "5";
            $mcode = "0";
            $scode = "0";

            $id      = "cplay";
            $company = "CPLAY";
            break;
        case "8500": //스페이스바
            $lcode = "32";
            $mcode = "0";
            $scode = "0";

            $id      = "spacebar";
            $company = "스페이스바";
            break;
        case "8700": //도아
            $lcode = "6";
            $mcode = "0";
            $scode = "0";

            $id      = "doa";
            $company = "DOA";
            break;
        case "8800": //다이모
            $lcode = "18";
            $mcode = "0";
            $scode = "0";

            $id      = "dymo";
            $company = "다이모";
            break;
        case "8900": //마이티월렛
            $lcode = "48";
            $mcode = "0";
            $scode = "0";

            $id      = "mighty";
            $company = "마이티월렛";
            break;
        case "9000": //나니쇼
            $lcode = "16";
            $mcode = "0";
            $scode = "0";

            $id      = "nanishow";
            $company = "나니쇼";
            break;
        case "9100": //프릭스
            $lcode = "10";
            $mcode = "5";
            $scode = "0";

            $id      = "admin";
            $company = "프릭스";
            break;
        case "9200": //SLR
            $lcode = "12";
            $mcode = "0";
            $scode = "0";

            $id      = "slr";
            $company = "SLR";
            break;
        case "9300": //7321 주얼리
            $lcode = "2";
            $mcode = "0";
            $scode = "0";

            $id      = "7321";
            $company = "7321 쥬얼리";
            break;
    }

    //product name, [브랜드네임] 삭제
    $t1 = substr($data['1'], 0, 1);
    if ($t1 == "[") {
        $t2   = explode("]", $data['1']);
        $name = addslashes($t2['1']);
    } else {
        $name = addslashes($data['1']);
    }

    //retail price
    $retail_price = $data['2'];

    //fixed price
    if ($data['19'] != "0") {
        $fixed_price = $data['19'];
    } else {
        $fixed_price = "";
    }

    //images
    $savedir = "../../upload/p_image";

    if ($data['7'] != null) {
        $simg_chk = "Y";
        $file1    = $savedir . "/s/" . $data['7'];
        copy("img/" . $data['7'], "upload/p_image/s/" . $data['7']);
    } else {
        $simg_chk = "N";
        $file1    = "";
    }

    if ($data['6'] != null) {
        $bimg1_chk = "Y";
        $file3     = $savedir . "/b/" . $data['6'];
        copy("img/" . $data['6'], "upload/p_image/b/" . $data['6']);
    } else {
        $bimg1_chk = "N";
        $file3     = "";
    }

    if ($data['8'] != null) {
        $bimg2_chk = "Y";
        $file4     = $savedir . "/b/" . $data['8'];
        copy("img/" . $data['8'], "upload/p_image/b/" . $data['8']);
    } else {
        $bimg2_chk = "N";
        $file4     = "";
    }

    if ($data['9'] != null) {
        $bimg3_chk = "Y";
        $file5     = $savedir . "/b/" . $data['9'];
        copy("img/" . $data['9'], "upload/p_image/b/" . $data['9']);
    } else {
        $bimg3_chk = "N";
        $file5     = "";
    }

    if ($data['10'] != null) {
        $bimg4_chk = "Y";
        $file6     = $savedir . "/b/" . $data['10'];
        copy("img/" . $data['10'], "upload/p_image/b/" . $data['10']);
    } else {
        $bimg4_chk = "N";
        $file6     = "";
    }

    if ($data['11'] != null) {
        $bimg5_chk = "Y";
        $file7     = $savedir . "/b/" . $data['11'];
        copy("img/" . $data['11'], "upload/p_image/b/" . $data['11']);
    } else {
        $bimg5_chk = "N";
        $file7     = "";
    }

    $d_image = "N";

    //stock
    switch ($data['15']) {
        case "-1": //out of stock
            $stock   = "0";
            $del_chk = "O";
            break;
        case "-2": //suspended
            $stock   = "0";
            $del_chk = "Y";
            break;
        default:
            $stock   = $data['15'];
            $del_chk = "N";
    }

    //content
    $contents = htmlspecialchars($data['16'], ENT_QUOTES);

    //spcode
    switch ($data['17']) {
        case "1":
            $main_new     = "Y";
            $main_special = "N";
            $main_best    = "N";

            $option1_chk = "Y";
            $option2_chk = "N";
            $option3_chk = "N";
            $option4_chk = "N";
            $option5_chk = "N";
            break;
        case "2":
            $main_new     = "N";
            $main_special = "N";
            $main_best    = "Y";

            $option1_chk = "N";
            $option2_chk = "N";
            $option3_chk = "Y";
            $option4_chk = "N";
            $option5_chk = "N";
            break;
        case "3":
            $main_new     = "N";
            $main_special = "Y";
            $main_best    = "N";

            $option1_chk = "N";
            $option2_chk = "Y";
            $option3_chk = "N";
            $option4_chk = "N";
            $option5_chk = "N";
            break;
        default:
            $main_new     = "N";
            $main_special = "N";
            $main_best    = "N";

            $option1_chk = "N";
            $option2_chk = "N";
            $option3_chk = "N";
            $option4_chk = "N";
            $option5_chk = "N";
    }

    $opt_stock = ""; //must be initialized
    //option
    if (!empty($data['18'])) {
        $temp = explode(",", $data['18'], 2);
        $opt  = $temp['1'];

        //option stock
        $temp2 = explode(",", $opt);
        $no    = count($temp2);

        for ($i = 0; $i < $no; $i++) {
            if ($i == ($no - 1)) {
                $temp[$i] = "1";
                $opt_stock .= $temp[$i];
            } else {
                $temp[$i] = "1,";
                $opt_stock .= $temp[$i];
            }
        }
    } else {
        $opt       = "";
        $opt_stock = "";
    }

    $event = "0";

    //approval status
    $approved = "Y";

    $moq = "1";

    $sql = "INSERT INTO products(prod_code, category_l, category_m, category_s,
   														name, company, id, origin, retail_price, sale_price, fixed_price,
	              										mileage, moq, opt, opt_stock, size, material, stock, contents,
														s_image,   s_image_name,
														b_image1, b_image1_name,
														b_image2, b_image2_name,
														b_image3, b_image3_name,
														b_image4, b_image4_name,
														b_image5, b_image5_name,
														d_image,  d_image_name,
				  										created, main_new, main_special, main_best,
														option1_chk, option2_chk, option3_chk, option4_chk, option5_chk,
														del_chk, event, date1, date2, approved)
			    		VALUES('$prod_code', '$lcode', '$mcode', '$scode',
					  		 		'$name', '$company', '$id', '$origin', '$retail_price', '$sale_price', '$fixed_price',
				      		 		'$mileage', '$moq',  '$opt', '$opt_stock', '$size', '$material', '$stock', '$contents',
					  		 		'$simg_chk',   '$file1',
					   		 		'$bimg1_chk', '$file3',
							 		'$bimg2_chk', '$file4',
							 		'$bimg3_chk', '$file5',
							 		'$bimg4_chk', '$file6',
							 		'$bimg5_chk', '$file7',
							 		'$dimg_chk',  '$file8',
							 		now(), '$main_new', '$main_special', '$main_best',
									'$option1_chk', '$option2_chk', '$option3_chk', '$option4_chk', '$option5_chk',
									'$del_chk', '$event', '$date1', '$date2', '$approved')";

    $result = mysqli_query($connect, $sql);

    if ($result) {
        echo "Line $line : <$company> $p_code-> inserted done! ...";
    }

    //decode HTML entities
    $sql2    = "SELECT * FROM products WHERE prod_code = '$prod_code' ";
    $result2 = mysqli_query($connect, $sql2);
    $row2    = mysqli_fetch_array($result2);

    $decoded = html_entity_decode($row2['contents']);

    $sql3    = "UPDATE products SET contents='$decoded' WHERE prod_code = '$prod_code' ";
    $result3 = mysqli_query($connect, $sql3);

    if ($result3) {
        echo "decoded done! <br/>";
    }

    $line++;
}

fclose($fp);
