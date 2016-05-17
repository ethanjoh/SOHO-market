<?php
include_once 'util.php';

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

/**
 * [show_login_menu description]
 * @return [type] [description]
 */
function show_login_menu()
{
    $sessionId   = set_var($_SESSION['p_id']);
    $sessionName = set_var($_SESSION['p_name']);
    $sessionFlag = set_var($_SESSION['p_flag']);

// 미로그인
    if (!$sessionId || !$sessionName || !$sessionFlag) {
        echo <<<HEREDOC
                                <div class="top-cart-wrapper">
                                    <div class="top-cart-contain">
                                        <div class="block-cart">
                                            <div class="top-cart-title">
                                                <a href="/member/login.php"><p><span>빈 카트</span></p></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="top-login">
                                    <div class=" block-compare">
                                        <div class="compare">
                                            <a href="/member/login.php"><i class="fa fa-key"></i> 로그인 </a>
                                        </div>
                                        <div class="home" id="right">
                                        </div>
                                    </div>
                                </div>

                                <div class="top-register">
                                    <div class=" block-compare">
                                        <div class="compare">
                                            <a href="/member/register.php"><i class="fa fa-user"></i>
                                                회원가입
                                            </a>
                                        </div>
                                    </div>
                                </div>


HEREDOC;

// 기업회원 로그인
    } elseif ($sessionFlag == "c") {
        $numberOfItems = count_items_in_cart();

        echo <<<HEREDOC
                                <div class="top-cart-wrapper">
                                    <div class="top-cart-contain">
                                        <div class="block-cart">
                                            <div class="top-cart-title">
                                                <a href="/shop/cart.php">
                                                <span id="cartInfo" class="cart-item">{$numberOfItems}</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="top-login">
                                    <div class=" block-compare">
                                        <div>
                                            <a href="/member/logout.php"><i class="fa fa-unlock"></i> 로그아웃 </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="top-register">
                                    <div class=" block-compare">
                                        <div class="compare">
                                            <a href="#"><i class="fa fa-cog"></i> 마이메뉴 </a>
                                        </div>
                                        <div class="home" id="right">
                                            <ul>
                                                <li><a href="/shop/order-list.php"><i class="fa fa-list-alt"></i> 주문내역</a></li>
                                                <li><a href="/shop/order-stat-list.php"><i class="fa fa-bar-chart"></i> 통계보기</a></li>
                                                <li><a href="/member/register-form.php?mode=edit"><i class="fa fa-wrench"></i> 정보수정</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>



HEREDOC;
//개인회원 로그인
    } elseif ($sessionFlag == "p") {
        $numberOfItems = count_items_in_cart();

        echo <<<HEREDOC
                                <div class="top-cart-wrapper">
                                    <div class="top-cart-contain">
                                        <div class="block-cart">
                                            <div class="top-cart-title">
                                                <a href="/shop/cart.php">
                                                <span id="cartInfo" class="cart-item">{$numberOfItems}</span></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="top-login">
                                    <div class=" block-compare">
                                        <div>
                                            <a href="/member/logout.php"><i class="fa fa-unlock"></i> 로그아웃 </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="top-register">
                                    <div class=" block-compare">
                                        <div class="compare">
                                            <a href="#"><i class="fa fa-cog"></i> 마이메뉴 </a>
                                        </div>
                                        <div class="home" id="right">
                                            <ul>
                                                <li><a href="/shop/order-list.php"><i class="fa fa-list-alt"></i> 주문내역</a></li>
                                                <li><a href="/shop/order-stat-list.php"><i class="fa fa-bar-chart"></i> 통계보기</a></li>
                                                <li><a href="/member/p-register-form.php?mode=edit"><i class="fa fa-wrench"></i> 정보수정</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>



HEREDOC;
    }
}

/**
 * [count_items_in_cart 카트에 담긴 상품수량 보여주기]
 * @return [type] [description]
 */
function count_items_in_cart()
{
    global $connect;

    $sessionId = set_var($_SESSION['p_id']);

    $qry = "SELECT sum(volume) AS numberOfItems FROM products_cart WHERE user_id = '$sessionId'";
    $res = mysqli_query($connect, $qry);
    $row = mysqli_fetch_array($res);

    if ($row['numberOfItems'] > 0) {
        $numberOfItems = $row['numberOfItems'];
    } else {
        $numberOfItems = 0;
    }

    return $numberOfItems;

}
/**
 * [show_items_on_main[ 메인페이지에 표시]
 * @param  [type] $newOrBest      [best, new 구분]
 * @param  [type] $howManyItems   [표시할 개수]
 * @return [type] [description]
 */
function show_items_on_main($newOrBest, $howManyItems)
{
    global $connect;
    $sessionId    = set_var($_SESSION['p_id']);
    $sessionFlag  = set_var($_SESSION['p_flag']);
    $isApprovedId = check_approved_id();
    $calcPrice    = 0;

    if ($newOrBest == 'best') {
        $isYes = "main_best='Y'";
    } elseif ($newOrBest == 'new') {
        $isYes = "main_new='Y'";
    }

    $query  = "SELECT * FROM products WHERE del_chk='N' AND $isYes AND approved = 'Y' ORDER BY rand() DESC LIMIT 0,$howManyItems ";
    $result = mysqli_query($connect, $query);

    if ($result) {

        for ($i = 0; $rows = mysqli_fetch_array($result); $i++) {

            // if ($sessionFlag == "c") {
            //     $calcPrice = $rows['retail_price'];
            // } elseif ($sessionFlag == "p") {
            //     $calcPrice = $rows['shop_price'];
            // }

            $itemName   = stripslashes($rows['name']);
            $pnum       = $rows['num'];
            $category_l = $rows['category_l'];
            $category_m = $rows['category_m'];
            $option     = $rows['opt'];
            $moq        = $rows['moq'];

            $calcWholesalePrice = show_me_wholesale_price($pnum);

            // $calcWholesalePrice = calc_offer_price($calcPrice, $sessionId);
            // $price              = '';
            // $commaWholesalePrice = number_format($calcWholesalePrice);

            echo <<<HEREDOC
                                <!-- single-product start -->
                                <div class="col-md-3">
                                    <div class="single-product">
                                        <div class="product-img">
                                            <a href="detail.php?pnum={$pnum}&lcode={$category_l}&mcode={$category_m}">
                                                <img class="primary-image" src="{$rows['b_image1_name']}" alt="" />
                                            </a>
                                        </div>
                                        <div class="product-content">
                                            <div class="price-box">

HEREDOC;

            if ($sessionId && $sessionFlag == "c" && $isApprovedId) {
                $commaWholesalePrice = number_format($calcWholesalePrice);
                echo $price          = '                                <span class="special-price"><i class="fa fa-krw"></i> ' . $commaWholesalePrice . '</span>' . "\r\n";
            } elseif ($sessionId && $sessionFlag == "p") {
                $commaCustomerPrice = number_format($calcWholesalePrice);
                echo $price         = '                                <span class="shop-price"><i class="fa fa-krw"></i> ' . $commaCustomerPrice . '</span>' . "\r\n";
            } else {
                $commaCustomerPrice = number_format($rows['shop_price']);
                echo $price         = '                                <span class="shop-price"><i class="fa fa-krw"></i> ' . $commaCustomerPrice . '</span>' . "\r\n";
            }

            echo <<<HEREDOC
                                            </div>
                                            <h2 class="product-name"><a href="detail.php?pnum={$pnum}&lcode={$category_l}&mcode={$category_m}">{$itemName}</a> <span class="product-option">[{$option}]</span></h2>
                                            <div class="product-icon">
HEREDOC;

            // if ($sessionId) {
            //     echo '                          <input type="text" name="products_count" id="products_count_' . $pnum . '" value="' . $moq . '" size="2">
            //                                     <a href="#" id="' . $pnum . '" class="addCart_submit"><i class="fa fa-shopping-cart"></i></a>
            //                                     <a href="/shop/cart.php"><i class="fa fa-check"></i></a>
            //                                     <div id="loadplace' . $pnum . '"></div>
            //                                     <input type="hidden" name="amount" id="amount_' . $pnum . '" value="' . $calcWholesalePrice . '">
            //                                     <input type="hidden" name="from" id="from" value="list">';

            // } else {
            //     // echo '                          <a href="/member/login.php"><i class="fa fa-shopping-cart"></i></a>
            //     //                                 <a href="/member/login.php"><i class="fa fa-check"></i></a>';
            // }

            echo <<<HEREDOC
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
 * [show_me_wholesale_price 웹페이지에 공급가 보여주기]
 * @param  [type] $session_id     [세션 아이디]
 * @param  [type] $pnum           [제품번호]
 * @return [type] [description]
 */
function show_me_wholesale_price($pnum)
{

    global $connect;

    $query  = "SELECT * FROM products WHERE num='$pnum'";
    $result = mysqli_query($connect, $query);
    $rows   = mysqli_fetch_array($result);

    $calcPrice   = 0;
    $rePrice     = 0;
    $sessionId   = set_var($_SESSION['p_id']);
    $sessionFlag = set_var($_SESSION['p_flag']);

    if ($sessionId && $sessionFlag == "c") {
        $calcPrice          = $rows['retail_price'];
        $calcWholesalePrice = calc_offer_price($calcPrice, $sessionId);
        $rePrice            = $calcWholesalePrice;
    } elseif ($sessionId && $sessionFlag == "p") {
        $calcPrice = $rows['shop_price'];
        $rePrice   = $calcPrice;
    }

    return $rePrice;
}

/**
 * [show_brand_name 브랜드 목록 보이기]
 * @param  [type] $lcode          [대 카테고리번호]
 * @return [type] [description]
 */
function show_brand_name($lcode)
{
    global $connect;
    $mode = set_var($_GET['mode']);

    if ($mode == "search") {
        echo '검색결과';
    } else {

        $query  = "SELECT * FROM products_category1 WHERE code = '$lcode' ";
        $result = mysqli_query($connect, $query);

        if ($result) {

            $rows = mysqli_fetch_array($result);
            echo '<a href="catalog-list.php?lcode=' . $lcode . '">' . stripslashes($rows['name']) . '</a>';

            mysqli_free_result($result);

        }
    }

}

/**
 * [show_brands 대카테고리를 보여줌]
 * @return [type] [description]
 */
function show_brands()
{

    global $connect;

    // 쇼핑몰 대분류
    $l_qry = "SELECT * FROM products_category1 WHERE hide='N' AND del='N' ORDER BY num ";
    $l_res = mysqli_query($connect, $l_qry);
    $total = mysqli_num_rows($l_res);

    echo "                               <ul>\n";

    if ($total > 0) {

        // 대분류 표시
        for ($i = 0; $l_rows = mysqli_fetch_array($l_res); $i++) {
            // 신제품 표시
            // $newq   = "SELECT * FROM products WHERE category_l = '$l_rows[code]' ORDER BY num DESC LIMIT 1";
            // $newr   = mysqli_query($connect, $newq);
            // $newrow = mysqli_fetch_array($newr);

            // if ($newrow['main_new'] == 'Y' && $newrow['del_chk'] != "Y") {
            //     $categoryName = $l_rows['name'] . ' <span class="label label-success">NEW</span>';
            // } else {
            //     $categoryName = $l_rows['name'];
            // }

            $categoryName = $l_rows['name'];

            echo <<<HEREDOC
                                            <li>
                                                <a href="/shop/catalog-list.php?lcode={$l_rows['code']}">
                                                    <span class="cat-thumb">
                                                        <i class="fa fa-hashtag"></i>
                                                    </span>
                                                    {$categoryName}
                                                </a>
                                            </li>

HEREDOC;

        }
    } else {
        echo '<li>브랜드를 등록해주세요</li>';
    }

    echo "                               </ul>\n";

}

/**
 * [show_sub_category 카달로그 리스트에서 좌측에 서브 카테고리 보여주기]
 * @param  [type] $lcode          [description]
 * @return [type] [description]
 */
function show_sub_category($lcode)
{

    global $connect;
    $mode = set_var($_GET['mode']);

    $m_qry     = "SELECT * FROM products_category2 WHERE up_category = '$lcode' ORDER BY name";
    $m_res     = mysqli_query($connect, $m_qry);
    $numOfRows = mysqli_num_rows($m_res);

    echo '<ul>';

    if ($numOfRows > 0) {

        // 중분류 표시
        for ($i = 0; $m_rows = mysqli_fetch_array($m_res); $i++) {

            $categoryName = $m_rows['name'];

            echo <<<HEREDOC
                                            <li>
                                                <a href="catalog-list.php?lcode={$lcode}&mcode={$m_rows['code']}">
                                                    {$categoryName}
                                                </a>
                                            </li>

HEREDOC;

        }
    } elseif ($mode = "search") {
        echo '<li></li>';
    } else {
        echo '<li>서브 카테고리를 등록해주세요</li>';
    }

    echo '</ul>';

}

/**
 * [show_sub_category_name 상단 breadcomb에서 이름 보여주기]
 * @param  [type] $lcode          [top category code]
 * @param  [type] $mcode          [middle category code]
 * @return [type] [description]
 */
function show_sub_category_name($lcode, $mcode)
{
    global $connect;

    $m_qry     = "SELECT * FROM products_category2 WHERE up_category = '$lcode' AND code = '$mcode'";
    $m_res     = mysqli_query($connect, $m_qry);
    $numOfRows = mysqli_num_rows($m_res);

    if ($numOfRows) {

        $rows = mysqli_fetch_array($m_res);
        echo '<a href="catalog-list.php?lcode=' . $lcode . '&amp;mcode=' . $mcode . '">' . stripslashes($rows['name']) . '</a>';

        mysqli_free_result($m_res);

    }

}

/**
 * [get_item_image 제품사진 보여주기]
 * @param  [type] $size           ['빅사이즈, 스몰사이즈' 'b' or 's']
 * @param  [type] $imageOrderNo   [이미지 순서번호]
 * @param  [type] $pnum           [제품번호]
 * @return [type] [description]
 */
function get_item_image($size, $imageOrderNo, $pnum)
{

    global $connect;

    $query  = "SELECT * FROM products WHERE num='$pnum'";
    $result = mysqli_query($connect, $query);
    $rows   = mysqli_fetch_array($result);
    mysqli_free_result($result);

    if ($size == 'b') {
        switch ($imageOrderNo) {
            case '2':
                if ($rows['b_image2'] == 'Y') {
                    $bImagePath2 = $rows['b_image2_name'];
                    return $bImagePath2;
                }
                break;
            case '3':
                if ($rows['b_image3'] == 'Y') {
                    $bImagePath3 = $rows['b_image3_name'];
                    return $bImagePath3;
                }
                break;
            case '4':
                if ($rows['b_image4'] == 'Y') {
                    $bImagePath4 = $rows['b_image4_name'];
                    return $bImagePath4;
                }
                break;
            default:
                if ($rows['b_image1'] == 'Y') {
                    $bImagePath1 = $rows['b_image1_name'];
                    return $bImagePath1;
                }
                break;
        }

    } elseif ($size == 's') {
        switch ($imageOrderNo) {
            case '2':
                if ($rows['s_image2'] == 'Y') {
                    $sImagePath2 = $rows['s_image2_name'];
                    return $sImagePath2;
                }
                break;
            case '3':
                if ($rows['s_image3'] == 'Y') {
                    $sImagePath3 = $rows['s_image3_name'];
                    return $sImagePath3;
                }
                break;
            case '4':
                if ($rows['s_image4'] == 'Y') {
                    $sImagePath4 = $rows['s_image4_name'];
                    return $sImagePath4;
                }
                break;
            default:
                if ($rows['s_image1'] == 'Y') {
                    $sImagePath1 = $rows['s_image1_name'];
                    return $sImagePath1;
                }
                break;
        }
    }

}

/**
 * [show_policy 배송정책 외 ]
 * @param  [type] $policy         [배송 또는 반품정책 구분]
 * @return [type] [description]
 */
function show_policy($policy)
{
    global $connect;

    $query  = "SELECT * FROM misc_setup";
    $result = mysqli_query($connect, $query);
    $rows   = mysqli_fetch_array($result);

    if ($policy == 'd') {
        $deliveryPolicy = nl2br($rows['d_policy']);
        echo <<<HEREDOC
            <p><i class="fa fa-check-circle"></i> 택배사: {$rows['logistics']} </p>
            <p> {$deliveryPolicy} </p>
HEREDOC;
    } elseif ($policy == 'r') {
        $returnPolicy = nl2br($rows['r_policy']);

        echo '<p> ' . $returnPolicy . ' </p>';
    }
}

/**
 * [show_cart_item 카트 내 아이템 출력]
 * @return [type] [총합]
 */
function show_cart_item()
{
    global $connect;

    $sessionId   = set_var($_SESSION['p_id']);
    $sessionFlag = set_var($_SESSION['p_flag']);
    $calcPrice   = 0;

    echo <<<HEREDOC
                                <table id="shopping-cart-table" class="data-table cart-table">
                                    <tr>
                                        <th>삭제</th>
                                        <th>이미지</th>
                                        <th>제품명</th>
                                        <th>단가</th>
                                        <th>수량</th>
                                        <th>소계</th>
                                    </tr>

HEREDOC;

    //JOIN문을 사용해 장바구니와 제품정보에서 데이터를 가져옴
    // 카테고리와 등록 순서로 정렬
    $query     = "SELECT * FROM products p, products_cart c WHERE c.user_id='$sessionId' AND p.num=c.product_code ORDER BY p.category_l ASC, num DESC ";
    $result    = mysqli_query($connect, $query);
    $numOfRows = mysqli_num_rows($result);

    if (!$numOfRows) {
        $total = 0;

        echo <<<HEREDOC
                                    <tr>
                                        <td class="text-center" colspan="6"><div class="alert alert-danger"><h4>카트가 비었습니다.</h4></div></td>
                                    </tr>
                                    <tr class="totals">
                                        <td colspan="5" class="total-text">합계</td>
                                        <td class="total-amount cost"><i class="fa fa-krw"></i> {$total}</td>
                                    </tr>
                                </table>
HEREDOC;
        return $total;

    } else {

        $tot_money = 0;
        $tot_mny1  = 0;

        for ($i = 1; $rows = mysqli_fetch_array($result); $i++) {
            if ($sessionFlag == "c") {
                $calcPrice = $rows['retail_price'];
            } elseif ($sessionFlag == "p") {
                $calcPrice = $rows['shop_price'];
            }

            $subTotal      = (int) $rows['volume'] * (int) $rows['amount']; // 소계
            $commaSubTotal = number_format($subTotal);                      //소계 천단위표시
            $tot_money     = $tot_money + $subTotal;
            $commaTotal    = number_format($tot_money);

            $pnum          = $rows['num'];
            $category_l    = $rows['category_l'];
            $category_m    = $rows['category_m'];
            $category_s    = $rows['category_s'];
            $s_image1_name = $rows['s_image1_name'];
            $itemName      = stripslashes($rows['name']);

            // $calcWholesalePrice  = calc_offer_price($calcPrice, $sessionId); // 업체별 공급가 확인
            // $commaWholesalePrice = number_format($calcWholesalePrice);       // 천단위 구분
            // $price               = show_me_wholesale_price($sessionId, $pnum);
            $qty     = $rows['volume'];
            $cart_id = $rows['cart_id'];

            $pflag = '';
            $oflag = '';

            // $option = show_option($pnum);

            //상품품절 확인
            if ($rows['del_chk'] != "N") {
                $pflag = "Y";
            }

            //상품옵션 품절표시
            //상품 옵션이 있는지 확인 후 진행
            if ($rows['opt'] != "") {
                                                                 //장바구니의 옵션과 제품정보를 비교하여 품절옵션이 있는지 확인
                $t_opt       = explode(",", $rows['opt']);       //장바구니 제품의 옵션명을 배열로 만들어준다
                $t_opt_stock = explode(",", $rows['opt_stock']); //제품의 옵션재고를 배열로 만들어준다

                //옵션의 문자열 비교
                for ($j = 0; $j < count($t_opt); $j++) {
                    $str = strcmp($t_opt[$j], $rows['p_opt']);

                    if (!$str) {
                        //문자열이 같다면 문자열 대체
                        if ($t_opt_stock[$j] == "0") {
                            $rows['p_opt'] .= ' <span class="soldout">(품절)</span>';
                            $oflag = "Y";
                        } elseif ($t_opt_stock[$j] == "-1") {
                            $rows['p_opt'] .= ' <span class="cutout">(단종)</span>';
                            $oflag = "Y";
                        } else {
                            $rows['p_opt'] = $t_opt[$j];
                        }
                    }
                } // ./for ($j = 0; $j < count($t_opt); $j++)

            } // ./ if($rows['opt'] != "")

            $p_opt = $rows['p_opt'];

            $calcWholesalePrice = show_me_wholesale_price($pnum);

            if ($sessionId && $sessionFlag == "c") {
                $commaWholesalePrice = number_format($calcWholesalePrice);
                $price               = $commaWholesalePrice;
                $passingPrice        = $calcWholesalePrice;
            } elseif ($sessionId && $sessionFlag == "p") {
                $commaCustomerPrice = number_format($calcWholesalePrice);
                $price              = $commaCustomerPrice;
                $passingPrice       = $calcWholesalePrice;
            } else {
                $commaCustomerPrice = number_format($rows['shop_price']);
                $price              = $commaCustomerPrice;
            }

            $icon = show_icon($rows['num']);

            echo <<<HEREDOC
                                    <tr>
                                        <td class="sop-icon">
                                            <a href="cart-update.php?mode=del&amp;cart_no={$cart_id}&amp;where=cart" onclick="return confirm('해당 상품을 삭제하시겠습니까?')"><i class="fa fa-times"></i></a>
                                        </td>
                                        <td class="sop-cart">
                                            <a href="detail.php?pnum={$pnum}&amp;lcode={$category_l}&amp;mcode={$category_m}"><img class="primary-image" alt="" src="{$s_image1_name}"></a>
                                        </td>
                                        <td class="sop-cart"><a href="detail.php?pnum={$pnum}&amp;lcode={$category_l}&amp;mcode={$category_m}">{$icon} {$itemName}</a><br>[{$p_opt}]</td>
                                        <td class="sop-cart cost"> {$price}</td>
                                        <td>
                                            <form name="basket{$i}" method="post" action="cart-update.php">
                                            <input type="hidden" name="md" value="edit" />
                                            <input type="hidden" name="from" value="cart" />
                                            <input type="hidden" name="pflag" value="{$pflag}" />
                                            <input type="hidden" name="oflag" value="{$oflag}" />
                                            <input type="hidden" name="cart_id" value="{$cart_id}"/>
                                            <input class="input-text qty" type="text" name="products_count" maxlength="12" value="{$qty}" title="Qty">
                                            <button type="submit" class="btn btn-default btn-warning" />변경</button>
                                            </form>
                                        </td>
                                        <td class="sop-cart cost">{$commaSubTotal}</td>
                                    </tr>

HEREDOC;

        } // ./ for ($i = 1; $rows = mysqli_fetch_array($result); $i++)

        echo <<<HEREDOC
                                    <tr class="totals">
                                        <td colspan="5" class="total-text">합계</td>
                                        <td class="total-amount cost"><i class="fa fa-krw"></i> {$commaTotal}</td>
                                    </tr>
                                </table>
HEREDOC;

        return array('tot_money' => $tot_money, 'pflag' => $pflag, 'oflag' => $oflag);

    } // ./else

}

/**
 * [go_purchase 주문하기 버튼처리]
 * @param  [type] $total     [총합]
 * @return [type] [링크]
 */
function go_purchase($total)
{
    if ($total == 0) {
        return $ret = "alert('카트에 상품이 없습니다.')";
    } else {
        return $ret = "location.href='checkout.php?where=cart&amp;delivery=L'";
    }
}

/**
 * [show_checkout_item 결제페이지에서 주문상품 보여주기]
 * @return [type] [description]
 */
function show_checkout_item()
{
    global $connect;

    $sessionId   = set_var($_SESSION['p_id']);
    $sessionFlag = set_var($_SESSION['p_flag']);

    echo <<<HEREDOC
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th class="width-1">제품명</th>
                                                                <th class="width-2">공급가</th>
                                                                <th class="width-3">수량</th>
                                                                <th class="width-4">소계</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

HEREDOC;

    //JOIN문을 사용해 장바구니와 제품정보에서 데이터를 가져옴
    // 카테고리와 등록 순서로 정렬
    $query     = "SELECT * FROM products p, products_cart c WHERE c.user_id='$sessionId' AND p.num=c.product_code ORDER BY p.category_l ASC, num DESC ";
    $result    = mysqli_query($connect, $query);
    $numOfRows = mysqli_num_rows($result);

    if (!$numOfRows) {
        $show_total = 0;

        echo <<<HEREDOC
                                    <tr>
                                        <td class="text-center" colspan="4"><div class="alert alert-danger"><h4>카트가 비었습니다.</h4></div></td>
                                    </tr>
                                    <tr class="totals">
                                        <td colspan="3" class="total-text">합계</td>
                                        <td class="total-amount cost"><i class="fa fa-krw"></i> {$show_total}</td>
                                    </tr>
                                </table>
HEREDOC;

    } else {

        $tot_money = 0;
        $tot_mny1  = 0;

        for ($i = 1; $rows = mysqli_fetch_array($result); $i++) {
            if ($sessionFlag == "c") {
                $calcPrice = $rows['retail_price'];
            } elseif ($sessionFlag == "p") {
                $calcPrice = $rows['shop_price'];
            }

            $subTotal      = (int) $rows['volume'] * (int) $rows['amount']; // 소계
            $commaSubTotal = number_format($subTotal);                      //소계 천단위표시
            $tot_money     = $tot_money + $subTotal;
            // $show_stotal   = number_format($subTotal);
            $commaTotal = number_format($tot_money);

            $pnum          = $rows['num'];
            $category_l    = $rows['category_l'];
            $category_m    = $rows['category_m'];
            $category_s    = $rows['category_s'];
            $s_image1_name = $rows['s_image1_name'];
            $itemName      = stripslashes($rows['name']);

            // $calcWholesalePrice  = calc_offer_price($rows['retail_price'], $sessionId); // 업체별 공급가 확인
            // $commaWholesalePrice = number_format($calcWholesalePrice);                  // 천단위 구분
            // $price               = show_me_wholesale_price($sessionId, $pnum);
            $qty     = $rows['volume'];
            $cart_id = $rows['cart_id'];

            $pflag = '';
            $oflag = '';

            // $option = show_option($pnum);

            //상품품절 확인
            if ($rows['del_chk'] != "N") {
                $pflag = "Y";
            }

            //상품옵션 품절표시
            //상품 옵션이 있는지 확인 후 진행
            if ($rows['opt'] != "") {
                                                                 //장바구니의 옵션과 제품정보를 비교하여 품절옵션이 있는지 확인
                $t_opt       = explode(",", $rows['opt']);       //장바구니 제품의 옵션명을 배열로 만들어준다
                $t_opt_stock = explode(",", $rows['opt_stock']); //제품의 옵션재고를 배열로 만들어준다

                //옵션의 문자열 비교
                for ($j = 0; $j < count($t_opt); $j++) {
                    $str = strcmp($t_opt[$j], $rows['p_opt']);

                    if (!$str) {
                        //문자열이 같다면 문자열 대체
                        if ($t_opt_stock[$j] == "0") {
                            $rows['p_opt'] .= ' <span class="soldout">(품절)</span>';
                            $oflag = "Y";
                        } elseif ($t_opt_stock[$j] == "-1") {
                            $rows['p_opt'] .= ' <span class="cutout">(단종)</span>';
                            $oflag = "Y";
                        } else {
                            $rows['p_opt'] = $t_opt[$j];
                        }
                    }
                } // ./for ($j = 0; $j < count($t_opt); $j++)

            } // ./ if($rows['opt'] != "")

            $p_opt = $rows['p_opt'];

            $calcWholesalePrice = show_me_wholesale_price($pnum);

            if ($sessionId && $sessionFlag == "c") {
                $commaWholesalePrice = number_format($calcWholesalePrice);
                $price               = $commaWholesalePrice;
                $passingPrice        = $calcWholesalePrice;
            } elseif ($sessionId && $sessionFlag == "p") {
                $commaCustomerPrice = number_format($calcWholesalePrice);
                $price              = $commaCustomerPrice;
                $passingPrice       = $calcWholesalePrice;
            } else {
                $commaCustomerPrice = number_format($rows['shop_price']);
                $price              = $commaCustomerPrice;
            }

            echo <<<HEREDOC

                                                            <tr>
                                                                <td>
                                                                    <div class="o-pro-dec">
                                                                        <p>{$itemName} [{$p_opt}]</p>
                                                                        <input type="hidden" name="LGD_PRODUCTINFO[]"   value="{$itemName}">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-price">
                                                                        <p>{$price}</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-qty">
                                                                        <p>{$qty}</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-subtotal">
                                                                        <p>{$commaSubTotal}</p>
                                                                    </div>
                                                                </td>
                                                            </tr>
HEREDOC;

        } // ./ for ($i = 1; $rows = mysqli_fetch_array($result); $i++)

        $reAddedFee = show_delivery_fee($tot_money);
        $trans_cost = number_format($reAddedFee['trans_cost']);
        $commaTotal = number_format($tot_money + $reAddedFee['trans_cost']);
        $finalSum   = $tot_money + $reAddedFee['trans_cost'];

        echo <<<HEREDOC
                                                        </tbody>
                                                        <tfoot>
                                                            <tr class="tr-f">
                                                                <td colspan="3">배송비</td>
                                                                <td colspan="1"><i class="fa fa-plus-circle"></i> {$trans_cost}</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">총합</td>
                                                                <td colspan="1">{$commaTotal}</td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                    <input type="hidden" name="LGD_AMOUNT"   value="{$finalSum}">

HEREDOC;

    } // ./else

}

/**
 * [show_buyer_info 결제페이지에서 주문자 정보보여주기]
 * @return [type] [description]
 */
function show_buyer_info()
{
    global $connect;

    $sessionId   = set_var($_SESSION['p_id']);
    $sessionFlag = set_var($_SESSION['p_flag']);

    // 중복되지 않는 주문번호 생성
    $timestamp = date('YmdHms');
    $rd        = "ABCDE";
    $r_oid     = $sessionId . "-" . $timestamp . "-" . str_shuffle($rd);

    if ($sessionId) {
        if ($sessionFlag == "c") {
            $m_qry = "SELECT * FROM member WHERE id='$sessionId' ";
            $m_res = mysqli_query($connect, $m_qry);
            $row   = mysqli_fetch_array($m_res);

            $company_name = $row['company_name'];
            $d_zipcode    = $row['d_zipcode'];
            $d_phone      = $row['d_phone'];
            // $md_name      = $row['md_name'];
            $md_email  = $row['md_email'];
            $md_hphone = $row['md_hphone'];
            $d_addr1   = $row['d_addr1'];
            $d_addr2   = $row['d_addr2'];
            $zipcode   = explode('-', $d_zipcode);

        } elseif ($sessionFlag == "p") {
            $m_qry = "SELECT * FROM p_member WHERE id='$sessionId' ";
            $m_res = mysqli_query($connect, $m_qry);
            $row   = mysqli_fetch_array($m_res);

            $company_name = $row['name'];
            $d_zipcode    = $row['d_zipcode'];
            $d_phone      = $row['d_phone'];
            // $md_name      = $row['name'];
            $md_email  = $row['email'];
            $md_hphone = $row['hphone'];
            $d_addr1   = $row['d_addr1'];
            $d_addr2   = $row['d_addr2'];
            $zipcode   = explode('-', $d_zipcode);
        }

        echo <<<HEREDOC

                                                    <span>{$company_name}</span>
                                                    <span>{$zipcode[0]}</span>
                                                    <span>{$d_addr1} {$d_addr2}</span>
                                                    <span><i class="fa fa-mobile"></i> {$md_hphone} / <i class="fa fa-phone"></i> {$d_phone}</span>
                                                    <input type="hidden" name="LGD_BUYER"      id="LGD_BUYER"      value="{$company_name}"/>
                                                    <input type="hidden" name="LGD_BUYEREMAIL" id="LGD_BUYEREMAIL" value="{$md_email}"/>
                                                    <input type="hidden" name="LGD_OID"        id="LGD_OID"        value ="{$r_oid}">

HEREDOC;
    }

}

/**
 * [check_unChk_order 미확인주문건수]
 * @return [type] [주문건수]
 */
function check_unChk_order()
{
    global $connect;

    $sessionId = set_var($_SESSION['p_id']);
    $sessionId = mysqli_escape_string($connect, $sessionId);

//미확인건
    $unchk_sql = "SELECT * FROM mall_order WHERE cancel='N' AND status='3' AND user_id = '$sessionId' ";
    $unchk_res = mysqli_query($connect, $unchk_sql);
    $numOfRows = mysqli_num_rows($unchk_res);

    return $numOfRows;

}

/**
 * [check_today_order 금일 주문건수]
 * @return [type] [주문건수]
 */
function check_today_order()
{
    global $connect;

    $sessionId = set_var($_SESSION['p_id']);
    $today     = date("Y-m-d");

//금일주문건
    $today_sql = "SELECT * FROM mall_order WHERE cancel='N' AND createdate='$today' AND user_id = '$sessionId' ";
    $today_res = mysqli_query($connect, $today_sql);
    $numOfRows = mysqli_num_rows($today_res);

    return $numOfRows;

}

/**
 * [check_readyToSend_order 발송준비 주문건수]
 * @return [type] [주문건수]
 */
function check_readyToSend_order()
{
    global $connect;

    $sessionId = set_var($_SESSION['p_id']);

//발송대기건
    $paid_sql  = "SELECT * FROM mall_order WHERE cancel='N' AND status='7' AND user_id = '$sessionId' ";
    $paid_res  = mysqli_query($connect, $paid_sql);
    $numOfRows = mysqli_num_rows($paid_res);

    return $numOfRows;

}

/**
 * [show_login_form 로그인폼 보여주기]
 * @return [type] [description]
 */
function show_login_form()
{
    global $sslPort;
    $uri = set_var($_POST['uri']);

    echo <<<HEREDOC
        <!-- start login_form_area
		============================================ -->
        <section class="main_shop_area">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 client-say">
                        <div class="login-form-head">
                            <h2>기업회원 로그인</h2>
                            <form method="post" name="login" action="//{$_SERVER['SERVER_NAME']}:{$sslPort}/member/login-ok.php" onsubmit="return(login_check());">
                            <input type="hidden" name="uri" value="{$uri}">

                            <div class="login-form">
                                <ul>
                                    <li>
                                        <input class="form-control" type="text" name="id" placeholder="아이디">
                                    </li>
                                    <li>
                                        <input  class="form-control margin-top-10" type="password" name="pwd" placeholder="비밀번호">
                                    </li>
                                </ul>
                            </div> <!-- //.login-form -->
                            <div class="form-bottom-line about-optima-text">
                                <button class="button2 elit" type="submit"><strong>로그인</strong></button>
                                <div>
                                    <input type="checkbox" name="msave_all">아이디 저장
                                </div>

                                <div class="login-form-element">
                                    <a class="btn btn-default" type="button" href="/member/find-id.php">아이디/비밀번호 찾기</a>
                                </div>

                            </div>
                            </form>
                        </div> <!-- //.login-form-head -->
                    </div> <!-- //.col-md-6 client-say -->
                    <div class="col-md-6 client-say">
                        <div class="login-form-head">
                            <h2>개인회원 로그인</h2>
                            <form method="post" name="p_login" action="//{$_SERVER['SERVER_NAME']}:{$sslPort}/member/p-login-ok.php" onsubmit="return(p_login_check());">
                            <input type="hidden" name="uri" value="{$uri}">

                            <div class="login-form">
                                <ul>
                                    <li>
                                        <input class="form-control" type="text" name="id" placeholder="아이디">
                                    </li>
                                    <li>
                                        <input  class="form-control margin-top-10" type="password" name="pwd" placeholder="비밀번호">
                                    </li>
                                </ul>
                            </div> <!-- //.login-form -->
                            <div class="form-bottom-line about-optima-text">
                                <button class="button2 elit" type="submit"><strong>로그인</strong></button>
                                <div>
                                    <input type="checkbox" name="msave_all">아이디 저장
                                </div>
                                <div class="login-form-element">
                                    <a class="btn btn-default" type="button" href="/member/p-find-id.php">아이디/비밀번호 찾기</a>
                                </div>
                            </div>


                            </form>
                        </div> <!-- //.login-form-head -->
                    </div> <!-- //.col-md-6 client-say -->
                </div>

                <div class="row">
                    <div class="col-md-12 text-center">
                        <div class="login-form-element">
                            <a class="btn btn-default" type="button" href="/member/register.php">가입하기</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end login_form_area
        ============================================ -->


HEREDOC;
}

/**
 * [get_page_num 페이지 수를 구하기 위한 함수]
 * @param  [type] $mode          [검색모드]
 * @param  [type] $key           [검색 키]
 * @param  [type] $keyword       [검색 키워드]
 * @param  [type] $start_date    [검색 시작날짜]
 * @param  [type] $end_date      [검색 종료날짜]
 * @param  [type] $page          [전달받은 페이지 번호]
 * @param  [type] $scale         [한 페이지에 보여질 페이지수]
 * @return [type] $cline [현재 라인수]
 * @return [type] $numOfLastPage [마지막 페이지수]
 * @return [type] $cpage [현재 페이지]
 * @return [type] $totalPage [전체 페이지수]
 */
function get_page_num($mode, $key, $keyword, $start_date, $end_date, $page, $scale)
{
    global $connect;

    $sessionId = set_var($_SESSION['p_id']);
    $today     = date("Y-m-d");

    switch ($mode) {
        case 'search':
            $qry = "SELECT num FROM mall_order WHERE user_id = '$sessionId' AND $key LIKE '%$keyword%' ";
            break;
        case 'date':
            $qry = "SELECT num FROM mall_order WHERE user_id = '$sessionId' AND createdate BETWEEN '$start_date' AND '$end_date' ";
            break;
        case 'today':
            $qry = "SELECT num FROM mall_order WHERE cancel = 'N' AND user_id = '$sessionId' AND createdate = '$today' ";
            break;
        case 'unchk':
            $qry = "SELECT num FROM mall_order WHERE cancel = 'N' AND user_id = '$sessionId' AND status = '3' ";
            break;
        case 'chk':
            $qry = "SELECT num FROM mall_order WHERE cancel = 'N' AND user_id = '$sessionId' AND status = '5' ";
            break;
        case 'paid':
            $qry = "SELECT num FROM mall_order WHERE cancel = 'N' AND user_id = '$sessionId' AND status = '7' ";
            break;
        case 'finish':
            $qry = "SELECT num FROM mall_order WHERE cancel = 'N' AND user_id = '$sessionId' AND status = '8' ";
            break;
        case 'cancel':
            $qry = "SELECT num FROM mall_order WHERE cancel = 'Y' AND user_id = '$sessionId' ";
            break;
        default:
            $qry = "SELECT num FROM mall_order WHERE user_id = '$sessionId' ";
    }

// 자료 총수 구하기
    $res   = mysqli_query($connect, $qry);
    $total = mysqli_num_rows($res);

    $scale = $scale;
    $page  = $page;

    if ($page == '') {
        $page = 1;
    }

    $cpage     = intval($page);
    $totalPage = intval($total / $scale);

    if ($totalPage * $scale != $total) {
        $totalPage = $totalPage + 1;
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

    $numOfLastPage = $limit - $cline;

    return array($cline, $numOfLastPage, $cpage, $totalPage);

}

/**
 * [get_page_result 검색결과]
 * @param  [type] $mode          [검색모드]
 * @param  [type] $key           [검색 키]
 * @param  [type] $keyword       [검색 키워드]
 * @param  [type] $start_date    [검색 시작날짜]
 * @param  [type] $end_date      [검색 종료날짜]
 * @param  [type] $cline         [현재 라인수]
 * @param  [type] $numOfLastPage [마지막 페이지수]
 * @return [type] $numOfRows [쿼리 결과 갯수]
 * @return [type] $res [쿼리 결과]
 */
function get_page_result($mode, $key, $keyword, $start_date, $end_date, $cline, $numOfLastPage)
{
    global $connect;

    $sessionId = set_var($_SESSION['p_id']);
    $today     = date("Y-m-d");

    switch ($mode) {
        case 'search':
            $qry = "SELECT * FROM mall_order WHERE $key LIKE '%$keyword%'
                        AND user_id = '$sessionId'
                        ORDER BY num DESC LIMIT $cline,$numOfLastPage ";
            break;
        case 'date':
            $qry = "SELECT * FROM mall_order WHERE createdate BETWEEN '$start_date' AND '$end_date'
                          AND user_id = '$sessionId'
                          ORDER BY num DESC LIMIT $cline,$numOfLastPage ";
            break;
        case 'today':
            $qry = "SELECT * FROM mall_order
                              WHERE cancel = 'N'
                          AND user_id = '$sessionId'
                          AND createdate = '$today'
                          ORDER BY num DESC LIMIT $cline,$numOfLastPage ";
            break;
        case 'unchk':
            $qry = "SELECT * FROM mall_order
                              WHERE cancel = 'N'
                          AND status = '3'
                          AND user_id = '$sessionId'
                          ORDER BY num DESC LIMIT $cline,$numOfLastPage ";
            break;
        case 'chk':
            $qry = "SELECT * FROM mall_order
                              WHERE cancel = 'N'
                          AND user_id = '$sessionId'
                          AND status = '5'
                          ORDER BY num DESC LIMIT $cline,$numOfLastPage ";
            break;
        case 'paid':
            $qry = "SELECT * FROM mall_order
                              WHERE cancel = 'N'
                          AND user_id = '$sessionId'
                          AND status = '7'
                          ORDER BY num DESC LIMIT $cline,$numOfLastPage ";
            break;
        case 'finish':
            $qry = "SELECT * FROM mall_order
                              WHERE cancel = 'N'
                          AND user_id = '$sessionId'
                          AND status = '8'
                          ORDER BY num DESC LIMIT $cline,$numOfLastPage ";
            break;
        case 'cancel':
            $qry = "SELECT * FROM mall_order
                              WHERE cancel = 'Y'
                          AND user_id = '$sessionId'
                          ORDER BY num DESC LIMIT $cline,$numOfLastPage ";
            break;
        default:
            $qry = "SELECT * FROM mall_order
                              WHERE user_id = '$sessionId'
                                ORDER BY num DESC LIMIT $cline,$numOfLastPage ";
    }

    $res       = mysqli_query($connect, $qry);
    $numOfRows = mysqli_num_rows($res);

    return array($numOfRows, $res);

}

/**
 * [get_list_page_num 상품목록에서 페이지 번호 구하기]
 * @param  [type] $mode           [모드]
 * @param  [type] $lcode          [대카테고리]
 * @param  [type] $mcode          [중카테고리]
 * @param  [type] $key            [검색 키]
 * @param  [type] $keyword        [검색 키워드]
 * @param  [type] $page           [페이지값]
 * @param  [type] $scale          [한 페이지에 보여지는 상품 수]
 * @return [type] [description]
 */
function get_list_page_num($mode, $lcode, $mcode, $key, $keyword, $page, $scale)
{
    global $connect;

    $added_qry  = '';
    $search_qry = '';

    //중분류 선택시
    if ($mcode) {
        $added_qry = " AND category_m = '$mcode'";
    }

    if ($mode == "search") {
        $search_qry .= " AND (name LIKE '%$keyword%' OR opt LIKE '%$keyword%' OR company LIKE '%$keyword%') ";
        $qry = "SELECT * FROM products WHERE approved='Y' AND del_chk != 'Y' $search_qry ";

    } else {
        $qry = "SELECT * FROM products WHERE category_l='$lcode' AND del_chk != 'Y' AND approved='Y' $added_qry";
    }

    // 자료 총수 구하기
    $res   = mysqli_query($connect, $qry);
    $total = mysqli_num_rows($res);

    $scale = $scale;
    $page  = $page;

    if ($page == '') {
        $page = 1;
    }

    $currentPageNum = intval($page);
    $totalPageNum   = intval($total / $scale);

    if ($totalPageNum * $scale != $total) {
        $totalPageNum = $totalPageNum + 1;
    }

    if ($currentPageNum == 1) {
        $scaleTimesPageNum = 0;
    } else {
        $scaleTimesPageNum = ($currentPageNum * $scale) - $scale;
    }

    $limit = $scaleTimesPageNum + $scale;

    if ($limit >= $total) {
        $limit = $total;
    }

    $numPerPage = $limit - $scaleTimesPageNum;

    // $scaleTimesPageNum: 아이템수 x 페이지번호(1페이지는 0)
    // $numPerPage: 페이지당 아이템수
    // $currentPageNum: 현재 페이지번호
    return array($scaleTimesPageNum, $numPerPage, $currentPageNum, $totalPageNum);
}

/**
 * [get_list_page_result 페이징 쿼리 결과]
 * @param  [type] $mode           [description]
 * @param  [type] $lcode          [description]
 * @param  [type] $mcode          [description]
 * @param  [type] $key            [description]
 * @param  [type] $keyword        [description]
 * @param  [type] $cline          [description]
 * @param  [type] $noumfLastPage  [description]
 * @return [type] [description]
 */
function get_list_page_result($mode, $lcode, $mcode, $key, $keyword, $scaleTimesPageNum, $numOfLastPage)
{
    global $connect;

    $added_qry  = '';
    $search_qry = '';

    if ($mcode) {
        $added_qry = " AND category_m = '$mcode'";
    }

    if ($mode == "search") {
        $search_qry .= " AND (name LIKE '%" . $keyword . "%' OR opt LIKE '%" . $keyword . "%' OR company LIKE '%" . $keyword . "%') ";
        $qry = "SELECT * FROM products WHERE approved='Y' AND del_chk != 'Y' " . $search_qry . " ORDER BY name DESC LIMIT " . $scaleTimesPageNum . ", " . $numOfLastPage . "";
    } else {
        $qry = "SELECT * FROM products WHERE category_l = '$lcode' AND del_chk !='Y'" . $added_qry . " AND approved = 'Y' ORDER BY name DESC LIMIT " . $scaleTimesPageNum . ", " . $numOfLastPage . "";
    }

    $res       = mysqli_query($connect, $qry);
    $numOfRows = mysqli_num_rows($res);

    // return array($numOfRows, $res);
    return $res;

}

/**
 * [show_items_on_catalog 카탈로그 리스트에서 상품표시]
 * @param  [type] $result         [페이징 결과]
 * @param  [type] $tabid          [표시방법 탭]
 * @return [type] [description]
 */
function show_items_on_catalog($result, $tabid)
{
    global $connect;

    // $calcPrice   = 0;
    $sessionId   = set_var($_SESSION['p_id']);
    $sessionFlag = set_var($_SESSION['p_flag']);

    if ($sessionFlag == 'c') {
        $isApprovedId = check_approved_id();
    } elseif ($sessionFlag == 'p') {
        $isApprovedId = true;
    }

    $total = mysqli_num_rows($result);

    // $qry  = "SELECT * FROM member WHERE id='$sessionId' ";
    // $res  = mysqli_query($connect, $qry);
    // $mrow = mysqli_fetch_array($res);

    if ($total > 0) {

        for ($i = 0; $rows = mysqli_fetch_array($result); $i++) {

            $saleNewTag = '';

            $itemName   = stripslashes($rows['name']);
            $pnum       = $rows['num'];
            $category_l = $rows['category_l'];
            $category_m = $rows['category_m'];
            $moq        = $rows['moq'];
            $shortDesc  = $rows['short_desc'];
            $option     = show_option($pnum);

            // $option       = $rows['opt'];
            // $calcWholesalePrice  = calc_offer_price($calcPrice, $sessionId);
            $calcWholesalePrice = show_me_wholesale_price($pnum);
            // $commaWholesalePrice = number_format($calcWholesalePrice);
            // $price               = show_me_wholesale_price($pnum);

            if ($sessionId && $sessionFlag == "c" && $isApprovedId) {
                $commaWholesalePrice = number_format($calcWholesalePrice);
                $price               = '                                <span class="special-price"><i class="fa fa-krw"></i> ' . $commaWholesalePrice . '</span>' . "\r\n";
                $passingPrice        = $calcWholesalePrice;
            } elseif ($sessionId && $sessionFlag == "p") {
                $commaCustomerPrice = number_format($calcWholesalePrice);
                $price              = '                                <span class="shop-price"><i class="fa fa-krw"></i> ' . $commaCustomerPrice . '</span>' . "\r\n";
                $passingPrice       = $calcWholesalePrice;
            } else {
                $commaCustomerPrice = number_format($rows['shop_price']);
                $price              = '                                <span class="shop-price"><i class="fa fa-krw"></i> ' . $commaCustomerPrice . '</span>' . "\r\n";
                $passingPrice       = $calcWholesalePrice;
            }

            if ($rows['main_best'] == "Y") {
                $saleNewTag = '<span class="best-text">Best</span>';
            } elseif ($rows['main_new'] == "Y") {
                $saleNewTag = '<span class="new-text">New</span>';
            } elseif ($rows['main_special'] == "Y") {
                $saleNewTag = '<span class="sale-text">Sale</span>';
            } elseif ($rows['del_chk'] == "C") {
                $saleNewTag = '<span class="cut-text">단종</span>';
            } elseif ($rows['del_chk'] == "O") {
                $saleNewTag = '<span class="out-text">일시품절</span>';
            }

            if ($tabid == 'home') {
                echo <<<HEREDOC

                                <!-- single-product start -->
                                <form name="form_{$pnum}" method="post" action="">
                                <input type="hidden" name="pnum" id="pnum_{$pnum}" value="{$pnum}">
                                <div class="col-md-3">
                                    <div class="single-product">
                                        {$saleNewTag}
                                        <div class="product-img">
                                            <a href="detail.php?pnum={$pnum}&lcode={$category_l}&mcode={$category_m}">
                                                <img class="primary-image" src="{$rows['b_image1_name']}" alt="" />
                                            </a>
                                        </div>
                                        <div class="product-content">
                                            <div class="price-box">
                                                {$price}
                                            </div>
                                            <h2 class="product-name"><a href="detail.php?pnum={$pnum}&lcode={$category_l}&mcode={$category_m}">{$itemName}</a></h2>
                                            <span class="desc">{$option}</span>
                                            <div class="product-icon">
HEREDOC;

                if ($sessionId && $sessionFlag == 'c' && !$isApprovedId) {
                    echo '<a href="#" onclick="alert(\'미승인 회원입니다. \\n관리자에게 문의하세요\')"><i class="fa fa-shopping-cart"></i></a>' . "\r\n";
                } elseif ($sessionId && $rows['del_chk'] == "N") {
                    echo <<<HEREDOC
                                                <input type="text" name="products_count" id="products_count_{$pnum}" value="{$moq}" size="2">
                                                <a href="#" id="{$pnum}" class="addCart_submit"><i class="fa fa-shopping-cart"></i></a>
                                                <div id="loadplace{$pnum}"></div>
                                                <input type="hidden" name="amount" id="amount_{$pnum}" value="{$passingPrice}">
                                                <input type="hidden" name="from" id="from" value="list">
HEREDOC;

                } elseif ($rows['del_chk'] == "C") {
                    echo '<a href="#" onclick="alert(\'단종입니다.\')"><i class="fa fa-shopping-cart"></i></a>' . "\r\n";
                } elseif ($rows['del_chk'] == "O") {
                    echo '<a href="#" onclick="alert(\'일시품절입니다.\')"><i class="fa fa-shopping-cart"></i></a>' . "\r\n";
                } else {
                    echo '<a href="/member/login.php"><i class="fa fa-shopping-cart"></i></a>' . "\r\n";
                }

                echo <<<HEREDOC
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </form>
                                <!-- single-product end -->

HEREDOC;
            } elseif ($tabid == 'profile') {
                $option = show_option($pnum);

                echo <<<HEREDOC
                                <!-- single-product start -->
                                <form name="form_{$pnum}" method="post" action="">
                                <input type="hidden" name="pnum" id="pnum_{$pnum}" value="{$pnum}">
                                <div class="li-item">
                                    <div class="col-md-4 col-sm-4">
                                        <div class="single-product">
                                            {$saleNewTag}
                                            <div class="product-img">
                                                <a href="detail.php?pnum={$pnum}&lcode={$category_l}&mcode={$category_m}">
                                                    <img class="primary-image" src="{$rows['b_image1_name']}" alt="">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-8">
                                        <div class="f-fix">
                                            <h2 class="product-name">
                                                <a href="detail.php?pnum={$pnum}&lcode={$category_l}&mcode={$category_m}">{$itemName}</a>
                                            </h2>
                                            <p class="desc">[모델:] {$shortDesc}<br>
                                            <span class="spec">{$option}</span></p>
                                            <div class="p-box">
                                                {$price}
                                            </div>
                                            <div class="product-icon">
HEREDOC;
                if ($sessionId && $sessionFlag == 'c' && !$isApprovedId) {
                    echo '<a href="#" onclick="alert(\'미승인 회원입니다. \\n관리자에게 문의하세요\')"><i class="fa fa-shopping-cart"></i></a>' . "\r\n";
                } elseif ($sessionId && $rows['del_chk'] == "N") {
                    echo '                      <input type="text" name="products_count" id="products_count_' . $pnum . '" value="' . $moq . '" size="2">
                                                <a href="#" id="' . $pnum . '" class="addCart_submit"><i class="fa fa-shopping-cart"></i></a>
                                                <div id="loadplace' . $pnum . '"></div>
                                                <input type="hidden" name="amount" id="amount_' . $pnum . '" value="' . $passingPrice . '">
                                                <input type="hidden" name="from" id="from" value="list">';
                } elseif ($rows['del_chk'] == "C") {
                    echo '<a href="#" onclick="alert(\'단종입니다.\')"><i class="fa fa-shopping-cart"></i></a>' . "\r\n";
                } elseif ($rows['del_chk'] == "O") {
                    echo '<a href="#" onclick="alert(\'일시품절입니다.\')"><i class="fa fa-shopping-cart"></i></a>' . "\r\n";
                } else {
                    echo '                      <a href="/member/login.php"><i class="fa fa-shopping-cart"></i></a>';
                }

                echo <<<HEREDOC
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </form>
                                <hr>
                                <!-- single-product end -->

HEREDOC;
            }

        }
        //end for
        mysqli_free_result($result);

    } else {
        echo '<p class="text-center">검색 상품이 없습니다.<br>띄워쓰기 없이 검색하시거나 다른 검색어를 입력해 보세요</p>' . "\r\n";
    }

}

/**
 * [show_order_list 주문목록 보여주기]
 * @param  [type] $numOfRows      [쿼리결과 갯수]
 * @param  [type] $result         [쿼리결과]
 * @param  [type] $cpage          [현재 페이지]
 * @return [type] [description]
 */
function show_order_list($numOfRows, $result, $cpage)
{
    global $connect, $MERTKEY, $CST_MID, $CST_PLATFORM;

    $orderStatus = '';

    if ($numOfRows > 0) {

        $todayOrderSum = 0; //금일주문총액

        for ($i = 0; $row = mysqli_fetch_array($result); $i++) {
            $a_goods_fk = explode(",", $row['goods_fk']);

            $pro_sql    = "SELECT * FROM products WHERE num='$a_goods_fk[0]'";
            $pro_result = mysqli_query($connect, $pro_sql);
            $pro_row    = mysqli_fetch_array($pro_result);

            // retrieve PG data
            $pg_sql    = "SELECT * FROM pg_info WHERE LGD_OID='$row[orderid]' ";
            $pg_result = mysqli_query($connect, $pg_sql);
            $pg_row    = mysqli_fetch_array($pg_result);

            $order_date = $row['createdate'];

            if (count($a_goods_fk) > 1) {
                $goods_name = cut_string_utf8($pro_row['name'], 30, '...') . " (외)";
            } else {
                $goods_name = cut_string_utf8($pro_row['name'], 30, '...');
            }

            // 수령인이 따로 있는 확인
            if ($row['recipient_name']) {
                $recipient_name = $row['recipient_name'];
            } else {
                $recipient_name = '';
            }

            //관리자 메모 있는지 확인
            if ($row['supplement']) {
                $show_admin_memo = '<i class="fa fa-envelope pop memo-color" data-toggle="popover" data-container="body" title="관리자 메모" data-content="' . $row['supplement'] . '"></i>';
            } else {
                $show_admin_memo = '';
            }

            //취소 시
            if ($row['cancel'] == 'Y') {
                $orderStatus = '<i class="fa fa-remove"></i> 주문취소';
                $todayOrderSum -= $row['last_amount'];

                echo <<<HEREDOC
	                    <tr>
	                      <td>
	                        <a href="order-detail.php?oid={$row['num']}&amp;page={$cpage}">{$order_date}</a></td>
	                      <td>{$goods_name}&nbsp;
HEREDOC;

                echo $show_admin_memo;
                $payStatus = get_pg_info2($row['orderid']);

                echo <<<HEREDOC

	                      </td>
	                      <td>{$row['recipient_name']}</td>
	                      <td class="num-right"> - <br /></td>
                          <td>{$payStatus}</td>
                          <td>{$orderStatus}</td>
                          <td>&nbsp;</td>
	                      <td><a href="#" onclick="alert('이미 취소된 주문입니다.')"><i class="fa fa-ban"></i></a></td>
HEREDOC;

            } else {
                //end cancel

                if ($row['status'] == '1') {
                    $orderStatus = '<i class="fa fa-pause"></i> 입금대기';
                } else if ($row['status'] == '3') {
                    $orderStatus = '<i class="fa fa-pause"></i> 대기';
                } else if ($row['status'] == '5') {
                    $orderStatus = '<i class="fa fa-check"></i> 주문확인';
                } else if ($row['status'] == '7') {
                    $orderStatus = '<i class="fa fa-flag-checkered"></i> 발송대기';
                } else if ($row['status'] == '8') {
                    $orderStatus = '<i class="fa fa-check-square-o"></i> 발송완료';
                } else if ($row['status'] == '0') {
                    $orderStatus = '<i class="fa fa-minus-square"></i> 발송지연';
                }

                echo <<<HEREDOC
                    <tr>
                      <td><a href="order-detail.php?oid={$row['num']}&amp;page={$cpage}">{$row['createdate']}</a></td>
                      <td>{$goods_name}&nbsp;
HEREDOC;

                echo $show_admin_memo;

                $show_order_amount = number_format($row['amount'] + $row['trans_cost']);
                $payStatus         = get_pg_info2($row['orderid']);
                $print_receipt     = '';

                if ($row['status'] == '8') {

                    $authdata = md5($pg_row['LGD_MID'] . $pg_row['LGD_TID'] . $MERTKEY);

                    if ($pg_row['LGD_PAYTYPE'] == "SC0010") {
                        //신용카드 결제일 때
                        $print_receipt = '<a href="javascript:showReceiptByTID(\'' . $pg_row['LGD_MID'] . '\', \'' . $pg_row['LGD_TID'] . '\', \'' . $authdata . '\')"><i class="fa fa-print"></i></a>';
                    } elseif ("SC0030" == $pg_row['LGD_PAYTYPE']) {
                                                //계좌이체일 때
                        $seqno         = "t/t"; //계좌이체는 임의의 정보 입력
                        $print_receipt = '<a href="javascript:showCashReceipts(\'' . $pg_row['LGD_MID'] . '\',\'' . $pg_row['LGD_OID'] . '\',\'' . $seqno . '\',\'BANK\',\'' . $CST_PLATFORM . '\')"><i class="fa fa-print"></i></a>';
                    } elseif ("SC0040" == $pg_row['LGD_PAYTYPE']) {
                        $seqno         = $pg_row['LGD_CASSEQNO'];
                        $print_receipt = '<a href="javascript:showCashReceipts(\'' . $pg_row['LGD_MID'] . '\',\'' . $pg_row['LGD_OID'] . '\',\'' . $seqno . '\',\'CAS\',\'' . $CST_PLATFORM . '\')"><i class="fa fa-print"></i></a>';
                    }
                }

                echo <<<HEREDOC
                      </td>
                      <td>{$recipient_name}</td>
                      <td class="num-right">{$show_order_amount}</td>
                      <td>{$payStatus}</td>
                      <td>{$orderStatus}</td>
                      <td>{$print_receipt}</td>
                      <td>
                          <form name="or_delete_{$i}" method="post" action="../shop/order-delete.php">
                          <input type="hidden" name="oid" value="{$row['num']}">
                          <input type="hidden" name="page" value="{$cpage}">
                          <input type="hidden" name="CST_MID" value="{$CST_MID}">
                          <input type="hidden" name="CST_PLATFORM" value="{$CST_PLATFORM}">
                          <input type="hidden" name="LGD_TID" value="{$pg_row['LGD_TID']}">
HEREDOC;

                if ($row['status'] == '8') {
                    echo '<a href="#" onclick="alert(\'상품이 발송되어 취소가 되지 않습니다.\n관리자에게 문의하세요.\')"><i class="fa fa-ban"></i></a>';
                } else {
                    echo '<button type="submit" class="btn btn-xs btn-danger" onclick="return confirm(\'정말 주문을 취소하시겠습니까?\')"><i class="fa fa-remove"></i></button>';
                }

                echo <<<HEREDOC

                          </form>
                      </td>
                    </tr>
HEREDOC;

                $todayOrderSum += ($row['amount'] + $row['trans_cost']);
            } // ./ if-else end
        } // ./for ($i = 0; $row = mysqli_fetch_array($result); $i++)

        $show_total_amount = number_format($todayOrderSum);

        echo <<<HEREDOC
                    <tr>
                      <td colspan="3"><h5>총합(VAT 포함):</h5></td>
                      <td class="num-right"><h5>{$show_total_amount}</h5></td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
HEREDOC;

    } else {

        echo <<<HEREDOC
                    <tr>
                      <td class="text-center" colspan="8"><div class="alert alert-danger"><h3>해당 주문내역이 없습니다.</h3></div></td>
                    </tr>
HEREDOC;

    }

}

/**
 * [show_order_item 주문내역에서 주문상품 보여주기]
 * @param  [type] $oid            [description]
 * @return [type] [description]
 */
function show_order_item($oid)
{

    global $connect;

    $sql = "SELECT * FROM mall_order WHERE num = '$oid' ";
    $res = mysqli_query($connect, $sql);
    $row = mysqli_fetch_array($res);

    $a_goods_fk          = explode(",", $row['goods_fk']);
    $unit_price          = explode(",", $row['goods_price']);
    $modified_unit_price = explode(",", $row['mod_price']);
    $ordered_item_num    = explode(",", $row['goods_count']);
    $modified_item_num   = explode(",", $row['mod_count']);
    $option              = explode(",", $row['goods_kind']);

    $final_order_sum         = 0;
    $original_order_sum      = 0;
    $total_order_item_num    = 0;
    $modified_total_item_num = 0;
    $payStatus               = '';

    //주문 상품 정보를 불러옵니다.
    for ($i = 0; $i < sizeof($a_goods_fk); $i++) {
        $pro_sql    = "SELECT * FROM products WHERE num='$a_goods_fk[$i]'";
        $pro_result = mysqli_query($connect, $pro_sql);
        $pro_row    = mysqli_fetch_array($pro_result);

        $goods_name  = $pro_row['name'];
        $img_char    = $pro_row['s_image1_name'];
        $pnum        = $pro_row['num'];
        $fixed_price = $pro_row['fixed_price'];
        $company     = $pro_row['company'];

        //상품옵션 품절표시
        //상품 옵션이 있는지 확인 후 진행
        if ($option[$i] != "" || $option2[$i] != "") {
                                                                //장바구니의 옵션과 제품정보를 비교하여 품절옵션이 있는지 확인
            $t_opt       = explode(",", $pro_row['opt']);       //제품의 옵션명을 배열로 만들어준다
            $t_opt_stock = explode(",", $pro_row['opt_stock']); //제품의 옵션재고를 배열로 만들어준다

            //옵션의 문자열 비교
            for ($j = 0; $j < count($t_opt); $j++) {
                $str = strcmp($t_opt[$j], $option[$i]);

                if (!$str) {
                    //문자열이 같다면 문자열 대체
                    if ($t_opt_stock[$j] == "0") {
                        $option[$i] .= " (품절)";
                    } elseif ($t_opt_stock[$j] == "-1") {
                        $option[$i] .= " (단종)";
                    } else {
                        $option[$i] = $t_opt[$j];
                    }

                }
            } // ./for ($j = 0; $j < count($t_opt); $j++)

        } // ./if ($option[$i] != "" || $option2[$i] != "")

        $goods_name = stripslashes($goods_name);
        $show_icon  = show_icon($pro_row['num']);

        echo <<<HEREDOC

                                <tr>
                                    <td><a href="detail.php?pnum={$pnum}" target="_blank"><img src="{$img_char}" /></a></td>
                                    <td><div class="brand">[{$company}]</div>{$show_icon}&nbsp;<a href="detail.php?pnum={$pnum}" target="_blank">{$goods_name}</a></td>
                                    <td>

HEREDOC;

        if ($option[$i]) {
            echo $option[$i];
        }

        echo <<<HEREDOC
                                    </td>
                                    <td>{$ordered_item_num[$i]}</td>
HEREDOC;

        if ($fixed_price) {
            echo '                          <td><i class="fa fa-lock"></i>' . number_format($unit_price[$i]) . '</td>';
        } else {
            echo '                          <td>' . number_format($unit_price[$i]) . '</td>';
        }

        $sub_amount      = (int) $modified_item_num[$i] * (int) $modified_unit_price[$i];
        $show_sub_amount = number_format($sub_amount);
        echo <<<HEREDOC
                                    <td>{$show_sub_amount}</td>
                                </tr>
HEREDOC;

        $final_order_sum         = $final_order_sum + ((int) $modified_unit_price[$i] * (int) $modified_item_num[$i]);
        $original_order_sum      = $original_order_sum + ((int) $unit_price[$i] * (int) $ordered_item_num[$i]);
        $total_order_item_num    = $total_order_item_num + (int) $ordered_item_num[$i];
        $modified_total_item_num = $modified_total_item_num + (int) $modified_item_num[$i];
    } // ./ for ($i = 0; $i < sizeof($a_goods_fk); $i++)

    // $last_cost  = $final_order_sum;
    $reAddedFee = show_delivery_fee($final_order_sum);
    $show_total = number_format($final_order_sum + $reAddedFee['trans_cost']);
    $trans_cost = number_format($reAddedFee['trans_cost']);

    echo <<<HEREDOC
                                <tr>
                                    <td colspan="3">총 수량 :</td>
                                    <td>{$total_order_item_num} 개</td>
                                    <td></td>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td colspan="3">택배비 :</td>
                                    <td></td>
                                    <td></td>
                                    <td colspan="2"><i class="fa fa-krw"></i> {$trans_cost} <i class="fa fa-plus-circle"></i></td>

                                </tr>
                                <tr>
                                    <td colspan="3"><h4>총 합 : </h4></td>
                                    <td></td>
                                    <td></td>
                                    <td colspan="2"><h4><i class="fa fa-krw"></i> {$show_total}</h4>(VAT 포함)</td>
                                </tr>
HEREDOC;
}

/**
 * [show_order_status 주문진행상황]
 * @param  [type] $oid            [description]
 * @param  [type] $order_status   [description]
 * @return [type] [description]
 */
function show_order_status($oid, $order_status)
{
    global $connect;

    $sql = "SELECT * FROM mall_order WHERE num = '$oid' ";
    $res = mysqli_query($connect, $sql);
    $row = mysqli_fetch_array($res);

    if ($row['payment_type'] == 1) {
        $payment_type = "무통장 입금";
    }

    if ($row['payment_type'] == 2) {
        $payment_type = "신용카드";
    }

    if ($row['payment_type'] == 3) {
        $payment_type = "실시간 계좌이체";
    }

    switch ($order_status) {
        case '3':
            return $return_status = '<i class="fa fa-pause"></i> 상품을 준비 중입니다.';
            break;
        case '5':
            return $return_status = '<i class="fa fa-check"></i> 주문확인 후 포장 중입니다.';
            break;
        case '7':
            return $return_status = '<i class="fa fa-flag-checkered"></i> 포장완료 후 발송 준비 중입니다.';
            break;
        case '8':
            return $return_status = '<i class="fa fa-check-square-o"></i> 상품을 발송했습니다. (운송장 번호: ' . show_logistics() . ' ' . show_track_no($oid) . ' )';
            break;
        case '0':
            return $return_status = '<i class="fa fa-minus-square"></i> 발송이 지연됩니다.';
            break;
        default:
            return $return_status = '<i class="fa fa-pause"></i> 상품을 준비 중입니다.';
            break;
    }

}

/**
 * [show_buyer_detail 주문상세내역에서 주문자 정보보여주기]
 * @param  [type] $oid            [description]
 * @return [type] [description]
 */
function show_buyer_detail($oid)
{
    global $connect;

    $sql = "SELECT * FROM mall_order WHERE num = '$oid' ";
    $res = mysqli_query($connect, $sql);
    $row = mysqli_fetch_array($res);

    $payStatus = get_pg_info($row['orderid']);

    echo <<<HEREDOC

	                    <div class="row">
                        <div class="col-sm-3 buyer-info-padding">주문번호</div>
                        <div class="col-sm-9 buyer-info-padding">{$row['orderid']} (주문일 : {$row['createdate']} )</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 buyer-info-padding">구매자( {$row['user_id']} )</div>
                        <div class="col-sm-9 buyer-info-padding">
                            {$row['buyer_name']}<br />
                            {$row['buyer_zipcode']} <br />
                            {$row['buyer_address']}<br />
                            {$row['buyer_phone']}<br />
                            {$row['buyer_hphone']}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 buyer-info-padding">수령자</div>
                        <div class="col-sm-9 buyer-info-padding">
                            {$row['recipient_name']}<br />
                            {$row['recipient_zipcode']}<br />
                            {$row['recipient_address']}<br />
                            {$row['recipient_phone']}<br />
                            {$row['recipient_hphone']}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 buyer-info-padding">결제방법</div>
                        <div class="col-sm-9 buyer-info-padding">
                            {$payStatus}

HEREDOC;
//무통장 입금시만 출력
    if ($row['payment_type'] == '3') {
        echo <<<HEREDOC
                                  <p>
                                  {$row['bank']}<br />
                                  (입금자: {$row['account']} / 입금예정일 : {$row['deposit_date']})
                                  </p>

HEREDOC;
    }

    $orderSum        = number_format($row['amount'] + $row['trans_cost']);
    $orderStatus     = show_order_status($oid, $row['status']);
    $memoForDelivery = nl2br($row['memo_to_delivery']);
    $memoForAdmin    = nl2br($row['memo_to_admin']);
    $memoFromAdmin   = nl2br($row['supplement']);

    echo <<<HEREDOC
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 buyer-info-padding">주문금액</div>
                        <div class="col-sm-9 buyer-info-padding">{$orderSum} 원 (VAT 포함)</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 buyer-info-padding">처리상태</div>
                        <div class="col-sm-9 buyer-info-padding">{$orderStatus}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 buyer-info-padding">배송 시 요청사항</div>
                        <div class="col-sm-9 buyer-info-padding">{$memoForDelivery}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 buyer-info-padding">담당자에게 요청사항</div>
                        <div class="col-sm-9 buyer-info-padding">{$memoForAdmin}</div>
                    </div>
                    <div class="row bg-danger">
                        <div class="col-sm-3 buyer-info-padding">※ 관리자 메모</div>
                        <div class="col-sm-9 buyer-info-padding">{$memoFromAdmin}</div>
                    </div>

HEREDOC;
}

/**
 * [show_item_images 상세페이지 상품이미지 보여주기]
 * @param  [type] $pnum           [상품번호]
 * @return [type] [description]
 */
function show_item_images($pnum)
{
    global $connect;

    echo <<<HEREDOC
                                  <!-- Tab panes -->
                                    <div class="tab-content">
HEREDOC;

    $b_image1 = get_item_image('b', 1, $pnum);
    $b_image2 = get_item_image('b', 2, $pnum);
    $b_image3 = get_item_image('b', 3, $pnum);
    $b_image4 = get_item_image('b', 4, $pnum);

    if (isset($b_image1)) {
        echo <<<HEREDOC
                                        <div id="image1" class="tab-pane fade in active">
                                            <div class="simpleLens-big-image-container">
                                                <a class="simpleLens-lens-image" data-lens-image="{$b_image1}">
                                                    <img alt="" src="{$b_image1}" class="simpleLens-big-image">
                                                </a>
                                            </div>
                                        </div>
HEREDOC;
    }

    if (isset($b_image2)) {
        echo <<<HEREDOC
                                        <div id="image2" class="tab-pane fade">
                                            <div class="simpleLens-big-image-container">
                                                <a class="simpleLens-lens-image" data-lens-image="{$b_image2}">
                                                    <img alt="" src="{$b_image2}" class="simpleLens-big-image">
                                                </a>
                                            </div>
                                        </div>
HEREDOC;
    }

    if (isset($b_image3)) {
        echo <<<HEREDOC
                                        <div id="image3" class="tab-pane fade">
                                            <div class="simpleLens-big-image-container">
                                                <a class="simpleLens-lens-image" data-lens-image="{$b_image3}">
                                                    <img alt="" src="{$b_image3}" class="simpleLens-big-image">
                                                </a>
                                            </div>
                                        </div>
HEREDOC;
    }

    if (isset($b_image4)) {
        echo <<<HEREDOC
                                        <div id="image4" class="tab-pane fade">
                                            <div class="simpleLens-big-image-container">
                                                <a class="simpleLens-lens-image" data-lens-image="{$b_image4}" >
                                                    <img alt="" src="{$b_image4}" class="simpleLens-big-image">
                                                </a>
                                            </div>
                                        </div>
HEREDOC;
    }

    echo <<<HEREDOC
                                    </div>
                                    <div class="thumnail-image fix">
                                        <ul class="tab-menu">
HEREDOC;

    $s_image1 = get_item_image('s', 1, $pnum);
    $s_image2 = get_item_image('s', 2, $pnum);
    $s_image3 = get_item_image('s', 3, $pnum);
    $s_image4 = get_item_image('s', 4, $pnum);

    if (isset($s_image1)) {
        echo '                                           <li class="active"><a data-toggle="tab" href="#image1"><img alt="" src="' . $s_image1 . '"></a></li>';
    }

    if (isset($s_image2)) {
        echo '                                           <li><a data-toggle="tab" href="#image2"><img alt="" src="' . $s_image2 . '" ></a></li>';
    }

    if (isset($s_image3)) {
        echo '                                           <li><a data-toggle="tab" href="#image3"><img alt="" src="' . $s_image3 . '"></a></li>';
    }

    if (isset($s_image4)) {
        echo '                                           <li><a data-toggle="tab" href="#image4"><img alt="" src="' . $s_image4 . '"></a></li>';
    }

    echo <<<HEREDOC
                                        </ul>
                                    </div>
HEREDOC;
}

/**
 * [show_item_info 상세페이지 상품 정보보여주기]
 * @param  [type] $pnum           [상품번호]
 * @return [type] [description]
 */
function show_item_info($pnum)
{

    global $connect;

    $qry  = "SELECT * FROM products WHERE del_chk != 'Y' AND approved = 'Y' AND num='$pnum' ";
    $res  = mysqli_query($connect, $qry);
    $rows = mysqli_fetch_array($res);

    $sessionId   = set_var($_SESSION['p_id']);
    $sessionFlag = set_var($_SESSION['p_flag']);

    if ($sessionFlag == 'c') {
        $isApprovedId = check_approved_id();
    } elseif ($sessionFlag == 'p') {
        $isApprovedId = true;
    }

    $itemName  = stripslashes($rows['name']);
    $moq       = $rows['moq'];
    $shortDesc = $rows['short_desc'];
    $option    = show_option($pnum);
    // $commaCustomerPrice = number_format($rows['shop_price']);
    // $calcWholesalePrice  = calc_offer_price($rows['retail_price'], $sessionId);
    $calcWholesalePrice = show_me_wholesale_price($pnum);
    // $commaWholesalePrice = number_format($calcWholesalePrice);
    // $price               = show_me_wholesale_price($pnum);

    if ($sessionId && $sessionFlag == "c" && $isApprovedId) {
        $commaWholesalePrice = number_format($calcWholesalePrice);
        $price               = '                                <span class="special-price"><i class="fa fa-krw"></i> ' . $commaWholesalePrice . '</span>' . "\r\n";
        $passingPrice        = $calcWholesalePrice;
    } elseif ($sessionId && $sessionFlag == "p") {
        $commaCustomerPrice = number_format($calcWholesalePrice);
        $price              = '                                <span class="shop-price"><i class="fa fa-krw"></i> ' . $commaCustomerPrice . '</span>' . "\r\n";
        $passingPrice       = $calcWholesalePrice;
    } else {
        $commaCustomerPrice = number_format($rows['shop_price']);
        $price              = '                                <span class="shop-price"><i class="fa fa-krw"></i> ' . $commaCustomerPrice . '</span>' . "\r\n";
        $passingPrice       = $calcWholesalePrice;
    }

    switch ($rows['del_chk']) {
        case "C":
            $stock     = "없음";
            $alert     = '<a href="#" onclick="alert(\'단종입니다.\')"><i class="fa fa-shopping-cart"></i></a>' . "\r\n";
            $show_icon = show_icon($rows['num']);
            break;

        case "O":
            $stock     = "없음";
            $show_icon = show_icon($rows['num']);
            break;

        default:
            $stock     = "있음";
            $show_icon = "";
            break;
    }

    echo <<<HEREDOC
                            <!-- show product info -->
                            <form name="form_{$pnum}" method="post" action="">
                            <input type="hidden" name="pnum" id="pnum_{$pnum}" value="{$pnum}">

                            <div class="cras">
                                <div class="product-name">
                                    <h1>{$show_icon} {$itemName}</h1>
                                </div>
                                <div class="pro-rating">
                                    규격: {$shortDesc}
                                </div>
                                <p class="availability in-stock">
                                    재고:
                                    <span>{$stock}</span>
                                </p>
                                <div class="short-description">
                                    <p> {$option} </p>
                                </div>
                                <div class="pre-box">
                                    {$price}
                                </div>
                                <div class="add-to-box1">
                                    <div class="add-to-box add-to-box2">
                                        <div class="add-to-cart">
HEREDOC;

    if ($sessionId && $sessionFlag == 'c' && !$isApprovedId) {
        echo <<<HEREDOC
                                            <div class="product-icon">
                                                <div class="input-content">
                                                    <label for="qty">수량: </label>
                                                    <input id="qty" name="qty" type="text" class="input-text qty" value="1">
                                                </div>
                                                <button class="button2 btn-cart" title="" type="button" onclick="alert('미승인 회원입니다.\\n관리자에게 문의하세요')">
                                                    <span>주문 불가</span>
                                                </button>
                                            </div>
HEREDOC;
    } elseif ($sessionId && $rows['del_chk'] == "N") {
        echo <<<HEREDOC
                                            <div class="product-icon">
                                                <div class="input-content">
                                                    <label for="products_count">수량: </label>
                                                    <input type="text" class="input-text qty" name="products_count" id="products_count_{$pnum}" value="{$moq}">
                                                </div>
                                                <button id="{$pnum}" class="button2 btn-cart addCart_submit" title="" type="button">
                                                    <span>카트 담기</span>
                                                </button>
                                                <div id="loadplace{$pnum}"></div>
                                                <input type="hidden" name="from" id="from" value="detail">
                                                <input type="hidden" name="amount" id="amount_{$pnum}" value="{$passingPrice}">
                                            </div>
HEREDOC;
    } elseif ($rows['del_chk'] == "C") {
        echo <<<HEREDOC
                                            <div class="product-icon">
                                                <div class="input-content">
                                                    <label for="qty">수량: </label>
                                                    <input id="qty" name="qty" type="text" class="input-text qty" value="1">
                                                </div>
                                                <button class="button2 btn-cart" title="" type="button" onclick="alert('단종입니다.')">
                                                    <span>주문 불가</span>
                                                </button>
                                            </div>
HEREDOC;
    } elseif ($rows['del_chk'] == "O") {
        echo <<<HEREDOC
                                            <div class="product-icon">
                                                <div class="input-content">
                                                    <label for="qty">수량: </label>
                                                    <input id="qty" name="qty" type="text" class="input-text qty" value="1">
                                                </div>
                                                <button class="button2 btn-cart" title="" type="button" onclick="alert('품절입니다.')">
                                                    <span>주문 불가</span>
                                                </button>
                                            </div>
HEREDOC;
    } else {
        echo <<<HEREDOC
                                            <div class="product-icon">
                                                <div class="input-content">
                                                    <label for="qty">수량: </label>
                                                    <input id="qty" name="qty" type="text" class="input-text qty" value="1">
                                                </div>
                                                <button class="button2 btn-cart" title="" type="button" onclick="location.href='/member/login.php'">
                                                    <span>카트 담기</span>
                                                </button>
                                            </div>
HEREDOC;
    }

    echo <<<HEREDOC
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </form>
HEREDOC;

}

/**
 * [show_relative_item 연관상품 보여주기]
 * @param  [type] $lcode          [대카테고리]
 * @param  [type] $mcode          [중카테고리]
 * @return [type] [description]
 */
function show_relative_items($lcode, $mcode)
{
    global $connect;

    $sessionId    = set_var($_SESSION['p_id']);
    $sessionFlag  = set_var($_SESSION['p_flag']);
    $isApprovedId = check_approved_id();

    $qry = "SELECT * FROM products WHERE del_chk='N' AND category_l='$lcode' AND category_m='$mcode' AND approved = 'Y' ORDER BY rand() LIMIT 4 ";
    $res = mysqli_query($connect, $qry);

    for ($i = 0; $i < $rows = mysqli_fetch_array($res); $i++) {

        $pnum           = $rows['num'];
        $firstThumbnail = $rows['s_image1_name'];
        $itemName       = $rows['name'];
        $shortDesc      = get_short($rows['short_desc'], 25);
        // $commaCustomerPrice  = number_format($rows['shop_price']);
        // $calcWholesalePrice = calc_offer_price($rows['retail_price'], $sessionId);
        $calcWholesalePrice = show_me_wholesale_price($pnum);
        // $commaWholesalePrice = number_format($calcWholesalePrice);

        echo <<<HEREDOC

                                        <div class="ma-box-content">
                                            <div class="product-img-right">
                                                <a href="detail.php?pnum={$pnum}&lcode={$lcode}&mcode={$mcode}">
                                                    <img class="primary-image" alt="" src="{$firstThumbnail}">
                                                </a>
                                            </div>
                                            <div class="product-content">
                                                <h2 class="product-name">
                                                    <a href="detail.php?pnum={$pnum}&lcode={$lcode}&mcode={$mcode}">{$itemName}</a>
                                                </h2>
                                                <div class="pro-rating">
                                                    {$shortDesc}
                                                </div>
                                                <div class="price-box">
HEREDOC;

        if ($sessionId && $sessionFlag == "c" && $isApprovedId) {
            $commaWholesalePrice = number_format($calcWholesalePrice);
            echo $price          = '                                <span class="special-price"><i class="fa fa-krw"></i> ' . $commaWholesalePrice . '</span>' . "\r\n";
        } elseif ($sessionId && $sessionFlag == "p") {
            $commaCustomerPrice = number_format($calcWholesalePrice);
            echo $price         = '                                <span class="shop-price"><i class="fa fa-krw"></i> ' . $commaCustomerPrice . '</span>' . "\r\n";
        } else {
            $commaCustomerPrice = number_format($rows['shop_price']);
            echo $price         = '                                <span class="shop-price"><i class="fa fa-krw"></i> ' . $commaCustomerPrice . '</span>' . "\r\n";
        }

        // if ($sessionId) {
        //     echo '                                                <span class="special"><i class="fa fa-krw"></i> ' . $commaWholesalePrice . '</span>';
        // } else {
        //     echo '                                                <span class="shop"><i class="fa fa-krw"></i> ' . $commaCustomerPrice . '</span>';
        // }

        echo <<<HEREDOC
                                                </div>
                                            </div>
                                        </div>

HEREDOC;
    }
}

/**
 * [get_contents 상세설명 가져오기]
 * @param  [type] $pnum           [상품번호]
 * @return [type] [description]
 */
function get_item_contents($pnum)
{
    global $connect;

    $query  = "SELECT * FROM products WHERE num='$pnum'";
    $result = mysqli_query($connect, $query);
    $rows   = mysqli_fetch_array($result);

    return $rows['contents'];
}

/**
 * [show_main_banner 메인 배너 보여주기]
 * @return [type] [description]
 */
function show_main_banner()
{
    global $connect;

    $qry = "SELECT * FROM banner WHERE pos='main' ORDER BY num DESC LIMIT 1";
    $res = mysqli_query($connect, $qry);

    if ($res) {
        $row = mysqli_fetch_array($res);

        echo <<<HEREDOC

        <section class="slider-area">
            <div class="bend niceties preview-2">
                <div id="ensign-nivoslider" class="slides">

HEREDOC;

        for ($i = 1; $i <= 5; $i++) {
            $imagePath = 'm_banner' . $i . '_image';
            $isYes     = 'm_banner' . $i . '';

            if ($row[$isYes] == "Y") {
                echo <<<HEREDOC
                    <img src="{$row[$imagePath]}" alt="" title="#slider-direction-{$i}">

HEREDOC;
            }
        }

        echo '              </div>' . "\r\n";

        for ($j = 1; $j <= 5; $j++) {
            $isYes = 'm_banner' . $j . '';
            $link  = 'm_link' . $j . '';

            if ($row[$link] != "") {
                $show_link = $row[$link];
            } else {
                $show_link = "#";
            }

            if ($row[$isYes] == "Y") {
                echo <<<HEREDOC

                <div id="slider-direction-{$j}" class="slider-direction">
                    <div class="slider-content t-lfr s-tb slider-2">
                        <div class="title-container s-tb-c">
                            <div class="s-title">
                                <a href="{$show_link}">자세히 보기</a>
                            </div>
                        </div>
                    </div>
                </div>
HEREDOC;
            }
        }

        echo <<<HEREDOC

            </div>
        </section>

HEREDOC;
    } else {

        echo <<<HEREDOC

        <section class="slider-area">
            <div class="bend niceties preview-2">
                <div id="ensign-nivoslider" class="slides">
                    <img src="http://placehold.it/1920x650" alt="" title="#slider-direction-1">
                </div>
                <div id="slider-direction-1" class="slider-direction">
                    <div class="slider-content t-lfr s-tb slider-2">
                        <div class="title-container s-tb-c">
                            <div class="s-title">
                                <a href="#">자세히 보기</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
HEREDOC;
    }
}

/**
 * [show_top_banner 상단배너 보여주기]
 * @return [type] [description]
 */
function show_top_banner()
{
    global $connect;

    $qry = "SELECT * FROM banner WHERE pos='top' ORDER BY num DESC LIMIT 1";
    $res = mysqli_query($connect, $qry);

    if ($res) {
        $row = mysqli_fetch_array($res);

        for ($i = 1; $i <= 3; $i++) {

            $imagePath = 'm_banner' . $i . '_image';
            $isYes     = 'm_banner' . $i . '';
            $link      = 'm_link' . $i . '';

            if ($row[$link] != "") {
                $show_link = $row[$link];
            } else {
                $show_link = "#";
            }

            if ("Y" == $row[$isYes]) {
                echo <<<HEREDOC

                        <div class="product col-md-4 col-sm-4 col-xs-12">
                            <a href="{$show_link}"><img src="{$row[$imagePath]}" alt=""></a>
                        </div>

HEREDOC;
            } else {
                echo <<<HEREDOC

                        <div class="product col-md-4 col-sm-4 col-xs-12">
                            <a href="#"></a>
                        </div>

HEREDOC;
            }
        }
    } else {
        for ($i = 1; $i <= 3; $i++) {
            echo <<<HEREDOC

                        <div class="product col-md-4 col-sm-4 col-xs-12">
                            <a href="#"><img src="http://placehold.it/370x243" alt=""></a>
                        </div>
HEREDOC;
        }
    }
}

/**
 * [show_middle_banner 중간배너 보여주기]
 * @return [type] [description]
 */
function show_middle_banner()
{
    global $connect;

    $qry = "SELECT * FROM banner WHERE pos='middle' ORDER BY num DESC LIMIT 1";
    $res = mysqli_query($connect, $qry);

    if ($res) {
        $row = mysqli_fetch_array($res);

        for ($i = 1; $i <= 2; $i++) {

            $imagePath = 'm_banner' . $i . '_image';
            $isYes     = 'm_banner' . $i . '';
            $link      = 'm_link' . $i . '';

            if ($row[$link] != "") {
                $show_link = $row[$link];
            } else {
                $show_link = "#";
            }

            if ($row[$isYes] == "Y") {
                echo <<<HEREDOC

                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="mid-banner">
                            <a href="{$show_link}"><img src="{$row[$imagePath]}" alt=""></a>
                        </div>
                    </div>

HEREDOC;
            } else {
                echo <<<HEREDOC

                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="mid-banner">
                            <a href="#"></a>
                        </div>
                    </div>

HEREDOC;
            }
        }
    } else {
        for ($i = 1; $i <= 2; $i++) {
            echo <<<HEREDOC

                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="mid-banner">
                            <a href="#"><img src="http://placehold.it/570x298" alt=""></a>
                        </div>
                    </div>
HEREDOC;
        }
    }
}

/**
 * [show_bottom_banner 하단배너 보여주기]
 * @return [type] [description]
 */
function show_bottom_banner()
{
    global $connect;

    $qry = "SELECT * FROM banner WHERE pos='bottom' ORDER BY num DESC LIMIT 1";
    $res = mysqli_query($connect, $qry);

    if ($res) {
        $row = mysqli_fetch_array($res);

        $imagePath = 'm_banner1_image';
        $isYes     = 'm_banner1';
        $link      = 'm_link1';

        if ($row[$link] != "") {
            $show_link = $row[$link];
        } else {
            $show_link = "#";
        }

        if ("Y" == $row[$isYes]) {
            echo <<<HEREDOC

                        <div class="banner">
                            <a href="{$show_link}"><img src="{$row[$imagePath]}" alt=""></a>
                        </div>

HEREDOC;
        } else {
            echo <<<HEREDOC

                        <div class="banner">
                            <a href="#"></a>
                        </div>

HEREDOC;
        }

    } else {
        echo <<<HEREDOC

                        <div class="banner">
                            <a href="#"><img src="http://placehold.it/1168x90" alt=""></a>
                        </div>
HEREDOC;
    }
}

function check_approved_id()
{
    global $connect;
    $sessionId = set_var($_SESSION['p_id']);

    $query  = "SELECT * FROM member WHERE id='" . $sessionId . "'";
    $result = mysqli_query($connect, $query);

    if ($result) {
        $row = mysqli_fetch_array($result);
        if ($row['approved'] == "Y") {
            return true;
        }
    } else {
        return false;
    }

}
