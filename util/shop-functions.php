<?php
// include_once 'config.php';
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
    $p_id   = set_var($_SESSION['p_id']);
    $p_name = set_var($_SESSION['p_name']);

// 미로그인
    if (!$p_id || !$p_name) {
        echo <<<HEREDOC
                                <div class="top-cart-wrapper">
                                    <div class="top-cart-contain">
                                        <div class="block-cart">
                                            <div class="top-cart-title">
                                                <a href="/shop/cart.php"><p><span>빈 카트</span></p></a>
                                            </div>
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

                                <div class="top-login">
                                    <div class=" block-compare">
                                        <div class="compare">
                                            <a href="/member/login.php"><i class="fa fa-key"></i> 로그인 </a>
                                        </div>
                                        <div class="home" id="right">

                                        </div>
                                    </div>
                                </div>
HEREDOC;

// 로그인
    } else {
        $numberOfItems = get_cart_item();

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

                                <div class="top-register">
                                    <div class=" block-compare">
                                        <div class="compare">
                                            <a href="#"><i class="fa fa-cog"></i> 마이페이지 </a>
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

                                <div class="top-login">
                                    <div class=" block-compare">
                                        <div>
                                            <a href="/member/logout.php"><i class="fa fa-unlock"></i> 로그아웃 </a>
                                        </div>
                                    </div>
                                </div>

HEREDOC;
    }

}

/**
 * [get_cart_item 카트에 담긴 상품수량 보여주기]
 * @return [type] [description]
 */
function get_cart_item()
{
    global $connect;

    $p_id = set_var($_SESSION['p_id']);

    $qry = "SELECT sum(volume) AS numberOfItems FROM products_cart WHERE user_id = '$p_id'";
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
 * [show_main_products[ 메인페이지에 표시]
 * @param  [type] $main_flag      [best, new 구분]
 * @param  [type] $no_item        [표시할 개수]
 * @return [type] [description]
 */
function show_main_products($main_flag, $no_item)
{
    global $connect;

    if ('best' == $main_flag) {
        $flag = "main_best='Y'";
    } elseif ('new' == $main_flag) {
        $flag = "main_new='Y'";
    }

    $query  = "SELECT * FROM products WHERE del_chk='N' AND $flag AND approved = 'Y' ORDER BY rand() DESC LIMIT 0,$no_item ";
    $result = mysqli_query($connect, $query);

    if ($result) {

        for ($i = 0; $rows = mysqli_fetch_array($result); $i++) {

            // $dealer_price = number_format($rows['retail_price']);
            $item_name  = stripslashes($rows['name']);
            $pnum       = $rows['num'];
            $category_l = $rows['category_l'];
            $category_m = $rows['category_m'];
            // $category_s   = $rows['category_s'];
            $option       = $rows['opt'];
            $moq          = $rows['moq'];
            $p_id         = set_var($_SESSION['p_id']);
            $offer_price  = calc_offer_price($rows['retail_price'], $p_id);
            $dealer_price = number_format($offer_price);

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

            echo show_me_price($pnum);
            // $option = show_option($pnum);

            echo <<<HEREDOC
                                            </div>
                                            <h2 class="product-name"><a href="detail.php?pnum={$pnum}&lcode={$category_l}&mcode={$category_m}">{$item_name}</a> <span class="product-option">[{$option}]</span></h2>
                                            <div class="product-icon">
HEREDOC;

            // if ($p_id) {
            //     echo '                          <input type="text" name="products_count" id="products_count_' . $pnum . '" value="' . $moq . '" size="2">
            //                                     <a href="#" id="' . $pnum . '" class="addCart_submit"><i class="fa fa-shopping-cart"></i></a>
            //                                     <a href="/shop/cart.php"><i class="fa fa-check"></i></a>
            //                                     <div id="loadplace' . $pnum . '"></div>
            //                                     <input type="hidden" name="amount" id="amount_' . $pnum . '" value="' . $offer_price . '">
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
 * [show_catalog_products 카달로그 리스트에서 표시]
 * @param  [type] $lcode          [description]
 * @param  [type] $mcode          [description]
 * @param  [type] $tabid          [description]
 * @return [type] [description]
 */
function show_catalog_products($result, $tabid)
{
    global $connect;

    if ($result) {

        for ($i = 0; $rows = mysqli_fetch_array($result); $i++) {

            // $dealer_price = number_format($rows['retail_price']);
            $item_name  = stripslashes($rows['name']);
            $pnum       = $rows['num'];
            $category_l = $rows['category_l'];
            $category_m = $rows['category_m'];
            $category_s = $rows['category_s'];
            $moq        = $rows['moq'];
            $short_desc = $rows['short_desc'];
            // $option       = $rows['opt'];
            $p_id         = set_var($_SESSION['p_id']);
            $offer_price  = calc_offer_price($rows['retail_price'], $p_id);
            $dealer_price = number_format($offer_price);
            $price        = show_me_price($pnum);

            $option = show_option($pnum);

            if ('home' == $tabid) {
                echo <<<HEREDOC

                                <!-- single-product start -->
                                <form name="form_{$pnum}" method="post" action="">
                                <input type="hidden" name="pnum" id="pnum_{$pnum}" value="{$pnum}">
                                <div class="col-md-3">
                                    <div class="single-product">
                                        <div class="product-img">
                                            <a href="detail.php?pnum={$pnum}&lcode={$category_l}&mcode={$category_m}&scode={$category_s}">
                                                <img class="primary-image" src="{$rows['b_image1_name']}" alt="" />
                                            </a>
                                        </div>
                                        <div class="product-content">
                                            <div class="price-box">
                                                {$price}
                                            </div>
                                            <h2 class="product-name"><a href="detail.php?pnum={$pnum}&lcode={$category_l}&mcode={$category_m}&scode={$category_s}">{$item_name}</a></h2>
                                            <span class="desc">{$option}</span>
                                            <div class="product-icon">
HEREDOC;

                if ($p_id) {
                    echo <<<HEREDOC
                                                <input type="text" name="products_count" id="products_count_{$pnum}" value="{$moq}" size="2">
                                                <a href="#" id="{$pnum}" class="addCart_submit"><i class="fa fa-shopping-cart"></i></a>
                                                <div id="loadplace{$pnum}"></div>
                                                <input type="hidden" name="amount" id="amount_{$pnum}" value="{$offer_price}">
                                                <input type="hidden" name="from" id="from" value="list">
HEREDOC;

                } else {
                    echo '                      <a href="/member/login.php"><i class="fa fa-shopping-cart"></i></a>';
                }

                echo <<<HEREDOC

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </form>
                                <!-- single-product end -->

HEREDOC;
            } elseif ('profile' == $tabid) {
                $option = show_option($pnum);

                echo <<<HEREDOC
                                <!-- single-product start -->
                                <form name="form_{$pnum}" method="post" action="">
                                <input type="hidden" name="pnum" id="pnum_{$pnum}" value="{$pnum}">
                                <div class="li-item">
                                    <div class="col-md-4 col-sm-4">
                                        <div class="single-product">
                                            <div class="product-img">
                                                <a href="detail.php?pnum={$pnum}&lcode={$category_l}&mcode={$category_m}&scode={$category_s}">
                                                    <img class="primary-image" src="{$rows['b_image1_name']}" alt="">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-8">
                                        <div class="f-fix">
                                            <h2 class="product-name">
                                                <a href="detail.php?pnum={$pnum}&lcode={$category_l}&mcode={$category_m}&scode={$category_s}">{$item_name}</a>
                                            </h2>
                                            <p class="desc">[모델:] {$short_desc}<br>
                                            <span class="spec">{$option}</span></p>
                                            <div class="p-box">
                                                {$price}
                                            </div>
                                            <div class="product-icon">
HEREDOC;
                if ($p_id) {
                    echo '                      <input type="text" name="products_count" id="products_count_' . $pnum . '" value="' . $moq . '" size="2">
                                                <a href="#" id="' . $pnum . '" class="addCart_submit"><i class="fa fa-shopping-cart"></i></a>
                                                <div id="loadplace' . $pnum . '"></div>
                                                <input type="hidden" name="amount" id="amount_' . $pnum . '" value="' . $offer_price . '">
                                                <input type="hidden" name="from" id="from" value="list">';

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
        echo "<p>등록된 상품이 없습니다.</p><p>관리자 페이지 > 상품관리에서 상품을 등록해 주세요.</p>\n";
    }

}

/**
 * [show_me_price 웹페이지에 공급가 보여주기]
 * @param  [type] $session_id     [세션 아이디]
 * @param  [type] $pnum           [제품번호]
 * @return [type] [description]
 */
function show_me_price($pnum)
{

    global $connect;

    $query  = "SELECT * FROM products WHERE num='$pnum'";
    $result = mysqli_query($connect, $query);
    $rows   = mysqli_fetch_array($result);

    $p_id = set_var($_SESSION['p_id']);

    $offer_price  = calc_offer_price($rows['retail_price'], $p_id);
    $dealer_price = number_format($offer_price);
    $shop_price   = number_format($rows['shop_price']);

    if ($p_id) {
        $ret = '                                <span class="special-price"><i class="fa fa-krw"></i> ' . $dealer_price . '</span>';
    } else {
        $ret = '                                <span class="shop-price"><i class="fa fa-krw"></i> ' . $shop_price . '</span>';
    }

    return $ret;
}

/**
 * [show_brand_name 브랜드 목록 보이기]
 * @param  [type] $lcode          [대 카테고리번호]
 * @return [type] [description]
 */
function show_brand_name($lcode)
{
    global $connect;

    $query  = "SELECT * FROM products_category1 WHERE code = '$lcode' ";
    $result = mysqli_query($connect, $query);

    if ($result) {

        $rows = mysqli_fetch_array($result);
        echo '<a href="catalog-list.php?lcode=' . $lcode . '">' . stripslashes($rows['name']) . '</a>';

        mysqli_free_result($result);

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
    $l_qry = "SELECT * FROM products_category1 WHERE hide='N' ORDER BY num ";
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

/**
 * [show_sub_category_name 상단 breadcomb에서 이름 보여주기]
 * @param  [type] $lcode          [description]
 * @param  [type] $mcode          [description]
 * @return [type] [description]
 */
function show_sub_category_name($lcode, $mcode)
{
    global $connect;

    $m_qry      = "SELECT * FROM products_category2 WHERE up_category = '$lcode' AND code = '$mcode'";
    $m_res      = mysqli_query($connect, $m_qry);
    $msub_total = mysqli_num_rows($m_res);

    if ($msub_total) {

        $rows = mysqli_fetch_array($m_res);
        echo '<a href="category-list.php?lcode=' . $lcode . '&amp;mcode=' . $mcode . '">' . stripslashes($rows['name']) . '</a>';

        mysqli_free_result($m_res);

    }

}

/**
 * [show_image 제품사진 보여주기]
 * @param  [type] $size           [빅사이즈, 스몰사이즈 'b', 's']
 * @param  [type] $no             [description]
 * @param  [type] $pnum           [description]
 * @return [type] [description]
 */
function show_image($size, $no, $pnum)
{

    global $connect;

    $query  = "SELECT * FROM products WHERE num='$pnum'";
    $result = mysqli_query($connect, $query);
    $rows   = mysqli_fetch_array($result);
    mysqli_free_result($result);

    if ('b' == $size) {
        switch ($no) {
            case '2':
                if ('Y' == $rows['b_image2']) {
                    $b_image2 = $rows['b_image2_name'];
                    return $b_image2;
                }
                break;
            case '3':
                if ('Y' == $rows['b_image3']) {
                    $b_image3 = $rows['b_image3_name'];
                }
                break;
            case '4':
                if ('Y' == $rows['b_image4']) {
                    $b_image4 = $rows['b_image4_name'];
                }
                break;
            default:
                if ('Y' == $rows['b_image1']) {
                    $b_image1 = $rows['b_image1_name'];
                    return $b_image1;
                }
                break;
        }

    } elseif ('s' == $size) {
        switch ($no) {
            case '2':
                if ('Y' == $rows['s_image2']) {
                    $s_image2 = $rows['s_image2_name'];
                    return $s_image2;
                }
                break;
            case '3':
                if ('Y' == $rows['s_image3']) {
                    $s_image3 = $rows['s_image3_name'];
                    return $s_image3;
                }
                break;
            case '4':
                if ('Y' == $rows['s_image4']) {
                    $s_image4 = $rows['s_image4_name'];
                    return $s_image4;
                }
                break;
            default:
                if ('Y' == $rows['s_image1']) {
                    $s_image1 = $rows['s_image1_name'];
                    return $s_image1;
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
    mysqli_free_result($result);

    if ('d' == $policy) {
        $d_policy = nl2br($rows['d_policy']);
        echo <<<HEREDOC
            <p><i class="fa fa-check-circle"></i> 택배사: {$rows['logistics']} </p>
            <p> {$d_policy} </p>
HEREDOC;
    } elseif ('r' == $policy) {
        $r_policy = nl2br($rows['r_policy']);

        echo '<p> ' . $r_policy . ' </p>';
    }
}

/**
 * [show_cart_item 카트 내 아이템 출력]
 * @return [type] [총합]
 */
function show_cart_item()
{
    global $connect;

    $p_id = set_var($_SESSION['p_id']);

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
    $query       = "SELECT * FROM products p, products_cart c WHERE c.user_id='$p_id' AND p.num=c.product_code ORDER BY p.category_l ASC, num DESC ";
    $result      = mysqli_query($connect, $query);
    $total_count = mysqli_num_rows($result);

    if (!$total_count) {
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
            $s_tot       = (int) $rows['volume'] * (int) $rows['amount']; // 소계
            $tot_money   = $tot_money + $s_tot;
            $show_stotal = number_format($s_tot); //소계 천단위표시
                                                  // $total       = $tot_money;
            $show_total = number_format($tot_money);

            $pnum          = $rows['num'];
            $category_l    = $rows['category_l'];
            $category_m    = $rows['category_m'];
            $category_s    = $rows['category_s'];
            $s_image1_name = $rows['s_image1_name'];
            $item_name     = stripslashes($rows['name']);

            $offer_price  = calc_offer_price($rows['retail_price'], $p_id); // 업체별 공급가 확인
            $dealer_price = number_format($offer_price);                    // 천단위 구분
            $price        = show_me_price($p_id, $pnum);
            $qty          = $rows['volume'];
            $cart_id      = $rows['cart_id'];

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

            echo <<<HEREDOC
                                    <tr>
                                        <td class="sop-icon">
                                            <a href="cart-update.php?mode=del&amp;cart_no={$cart_id}&amp;where=cart" onclick="return confirm('해당 상품을 삭제하시겠습니까?')"><i class="fa fa-times"></i></a>
                                        </td>
                                        <td class="sop-cart">
                                            <a href="detail.php?pnum={$pnum}&amp;lcode={$category_l}&smp;mcode={$category_m}&amp;scode={$category_s}"><img class="primary-image" alt="" src="{$s_image1_name}"></a>
                                        </td>
                                        <td class="sop-cart"><a href="detail.php?pnum={$pnum}&amp;lcode={$category_l}&amp;mcode={$category_m}&amp;scode={$category_s}">{$item_name}</a><br>[{$p_opt}]</td>
                                        <td class="sop-cart cost"> {$dealer_price}</td>
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
                                        <td class="sop-cart cost">{$show_stotal}</td>
                                    </tr>

HEREDOC;

        } // ./ for ($i = 1; $rows = mysqli_fetch_array($result); $i++)

        echo <<<HEREDOC
                                    <tr class="totals">
                                        <td colspan="5" class="total-text">합계</td>
                                        <td class="total-amount cost"><i class="fa fa-krw"></i> {$show_total}</td>
                                    </tr>
                                </table>
HEREDOC;

        return $tot_money;

    } // ./else

}

/**
 * [go_purchase 주문하기 버튼처리]
 * @param  [type] $total     [총합]
 * @return [type] [링크]
 */
function go_purchase($total)
{
    if (0 == $total) {
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

    $p_id = set_var($_SESSION['p_id']);
    // $show_total = '';

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
    $query       = "SELECT * FROM products p, products_cart c WHERE c.user_id='$p_id' AND p.num=c.product_code ORDER BY p.category_l ASC, num DESC ";
    $result      = mysqli_query($connect, $query);
    $total_count = mysqli_num_rows($result);

    if (!$total_count) {
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
            $s_tot       = (int) $rows['volume'] * (int) $rows['amount']; // 소계
            $tot_money   = $tot_money + $s_tot;
            $show_stotal = number_format($s_tot);
            $show_total  = number_format($tot_money);

            $pnum          = $rows['num'];
            $category_l    = $rows['category_l'];
            $category_m    = $rows['category_m'];
            $category_s    = $rows['category_s'];
            $s_image1_name = $rows['s_image1_name'];
            $item_name     = stripslashes($rows['name']);

            $offer_price  = calc_offer_price($rows['retail_price'], $p_id); // 업체별 공급가 확인
            $dealer_price = number_format($offer_price);                    // 천단위 구분
            $price        = show_me_price($p_id, $pnum);
            $qty          = $rows['volume'];
            $cart_id      = $rows['cart_id'];

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

            echo <<<HEREDOC

                                                            <tr>
                                                                <td>
                                                                    <div class="o-pro-dec">
                                                                        <p>{$item_name} [{$p_opt}]</p>
                                                                        <input type="hidden" name="LGD_PRODUCTINFO[]"   value="{$item_name}">
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-price">
                                                                        <p>{$dealer_price}</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-qty">
                                                                        <p>{$qty}</p>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="o-pro-subtotal">
                                                                        <p>{$show_stotal}</p>
                                                                    </div>
                                                                </td>
                                                            </tr>
HEREDOC;

        } // ./ for ($i = 1; $rows = mysqli_fetch_array($result); $i++)

        $show_delivery_fee = show_delivery_fee($tot_money);
        echo <<<HEREDOC
                                                        </tbody>
                                                        <tfoot>
                                                            <tr class="tr-f">
                                                                <td colspan="3">배송비</td>
                                                                <td colspan="1">{$show_delivery_fee}</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3">총합</td>
                                                                <td colspan="1">{$show_total}</td>
                                                                <input type="hidden" name="LGD_AMOUNT"   value="{$tot_money}">
                                                            </tr>
                                                        </tfoot>
                                                    </table>
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

    $p_id = set_var($_SESSION['p_id']);

    // 중복되지 않는 주문번호 생성
    $timestamp = date('YmdHms');
    $rd        = "ABCDE";
    $r_oid     = $p_id . "-" . $timestamp . "-" . str_shuffle($rd);

    if ($p_id) {
        $m_qry = "SELECT * FROM member WHERE id='$p_id' ";
        $m_res = mysqli_query($connect, $m_qry);
        $row   = mysqli_fetch_array($m_res);

        $company_name = $row['company_name'];
        $d_zipcode    = $row['d_zipcode'];
        $d_phone      = $row['d_phone'];
        $md_name      = $row['md_name'];
        $md_email     = $row['md_email'];
        $md_hphone    = $row['md_hphone'];
        $d_addr1      = $row['d_addr1'];
        $d_addr2      = $row['d_addr2'];
        $zipcode      = explode('-', $d_zipcode);

        echo <<<HEREDOC
                                                    <span>{$md_name}</span>
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

    $p_id = set_var($_SESSION['p_id']);
    $p_id = mysqli_escape_string($connect, $p_id);

//미확인건
    $unchk_sql   = "SELECT * FROM mall_order WHERE cancel='N' AND status='3' AND user_id = '$p_id' ";
    $unchk_res   = mysqli_query($connect, $unchk_sql);
    $unchk_total = mysqli_num_rows($unchk_res);

    return $unchk_total;

}

/**
 * [check_today_order 금일 주문건수]
 * @return [type] [주문건수]
 */
function check_today_order()
{
    global $connect;

    $p_id  = set_var($_SESSION['p_id']);
    $today = date("Y-m-d");

//금일주문건
    $today_sql   = "SELECT * FROM mall_order WHERE cancel='N' AND createdate='$today' AND user_id = '$p_id' ";
    $today_res   = mysqli_query($connect, $today_sql);
    $today_total = mysqli_num_rows($today_res);

    return $today_total;

}

/**
 * [check_readyToSend_order 발송준비 주문건수]
 * @return [type] [주문건수]
 */
function check_readyToSend_order()
{
    global $connect;

    $p_id = set_var($_SESSION['p_id']);

//발송대기건
    $paid_sql   = "SELECT * FROM mall_order WHERE cancel='N' AND status='7' AND user_id = '$p_id' ";
    $paid_res   = mysqli_query($connect, $paid_sql);
    $paid_total = mysqli_num_rows($paid_res);

    return $paid_total;

}

/**
 * [show_loginForm 로그인폼 보여주기]
 * @return [type] [description]
 */
function show_loginForm()
{
    global $port;
    $uri = set_var($_POST['uri']);

    echo <<<HEREDOC
        <!-- start login_form_area
		============================================ -->
        <section class="main_shop_area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 client-say">
                        <div class="login-form-head">
                            <h2>로그인</h2>
                            <form method="post" name="login" action="//{$_SERVER['SERVER_NAME']}:{$port}/member/login-ok.php" onsubmit="return(login_check());">
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
                            </div>
                            <div class="form-bottom-line about-optima-text">
                                <button class="button2 elit" type="submit"><strong>로그인</strong></button>
                            </div>
                            </form>

                            <div class="login-form-element">
                                <a class="btn btn-default" type="button" href="/member/register.php">가입하기</a>
                                <a class="btn btn-default" type="button" href="/member/find-id.php">아이디 찾기</a>
                                <a class="btn btn-default" type="button" href="/member/find-pass.php">비밀번호 찾기</a>
                            </div>
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
 * @param  [type] $key_value     [검색 키워드]
 * @param  [type] $date1         [검색 시작날짜]
 * @param  [type] $date2         [검색 종료날짜]
 * @param  [type] $page          [전달받은 페이지 번호]
 * @param  [type] $scale         [한 페이지에 보여질 페이지수]
 * @return [type] $cline [현재 라인수]
 * @return [type] $last_page_num [마지막 페이지수]
 * @return [type] $cpage [현재 페이지]
 * @return [type] $totalpage [전체 페이지수]
 */
function get_page_num($mode, $key, $keyword, $date1, $date2, $page, $scale)
{
    global $connect;

    $p_id  = set_var($_SESSION['p_id']);
    $today = date("Y-m-d");

    switch ($mode) {
        case 'search':
            $qry = "SELECT num FROM mall_order WHERE user_id = '$p_id' AND $key LIKE '%$keyword%' ";
            break;
        case 'date':
            $qry = "SELECT num FROM mall_order WHERE user_id = '$p_id' AND createdate BETWEEN '$date1' AND '$date2' ";
            break;
        case 'today':
            $qry = "SELECT num FROM mall_order WHERE cancel = 'N' AND user_id = '$p_id' AND createdate = '$today' ";
            break;
        case 'unchk':
            $qry = "SELECT num FROM mall_order WHERE cancel = 'N' AND user_id = '$p_id' AND status = '3' ";
            break;
        case 'chk':
            $qry = "SELECT num FROM mall_order WHERE cancel = 'N' AND user_id = '$p_id' AND status = '5' ";
            break;
        case 'paid':
            $qry = "SELECT num FROM mall_order WHERE cancel = 'N' AND user_id = '$p_id' AND status = '7' ";
            break;
        case 'finish':
            $qry = "SELECT num FROM mall_order WHERE cancel = 'N' AND user_id = '$p_id' AND status = '8' ";
            break;
        case 'cancel':
            $qry = "SELECT num FROM mall_order WHERE cancel = 'Y' AND user_id = '$p_id' ";
            break;
        default:
            $qry = "SELECT num FROM mall_order WHERE user_id = '$p_id' ";
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

    $last_page_num = $limit - $cline;

    return array($cline, $last_page_num, $cpage, $totalpage);

}

/**
 * [get_page_result 검색결과]
 * @param  [type] $mode          [검색모드]
 * @param  [type] $key           [검색 키]
 * @param  [type] $key_value     [검색 키워드]
 * @param  [type] $date1         [검색 시작날짜]
 * @param  [type] $date2         [검색 종료날짜]
 * @param  [type] $cline         [현재 라인수]
 * @param  [type] $last_page_num [마지막 페이지수]
 * @return [type] $t_no [쿼리 결과 갯수]
 * @return [type] $res [쿼리 결과]
 */
function get_page_result($mode, $key, $key_value, $date1, $date2, $cline, $last_page_num)
{
    global $connect;

    $p_id  = set_var($_SESSION['p_id']);
    $today = date("Y-m-d");

    switch ($mode) {
        case 'search':
            $qry = "SELECT * FROM mall_order WHERE $key LIKE '%$key_value%'
                        AND user_id = '$p_id'
                        ORDER BY num DESC LIMIT $cline,$last_page_num ";
            break;
        case 'date':
            $qry = "SELECT * FROM mall_order WHERE createdate BETWEEN '$date1' AND '$date2'
                          AND user_id = '$p_id'
                          ORDER BY num DESC LIMIT $cline,$last_page_num ";
            break;
        case 'today':
            $qry = "SELECT * FROM mall_order
                              WHERE cancel = 'N'
                          AND user_id = '$p_id'
                          AND createdate = '$today'
                          ORDER BY num DESC LIMIT $cline,$last_page_num ";
            break;
        case 'unchk':
            $qry = "SELECT * FROM mall_order
                              WHERE cancel = 'N'
                          AND status = '3'
                          AND user_id = '$p_id'
                          ORDER BY num DESC LIMIT $cline,$last_page_num ";
            break;
        case 'chk':
            $qry = "SELECT * FROM mall_order
                              WHERE cancel = 'N'
                          AND user_id = '$p_id'
                          AND status = '5'
                          ORDER BY num DESC LIMIT $cline,$last_page_num ";
            break;
        case 'paid':
            $qry = "SELECT * FROM mall_order
                              WHERE cancel = 'N'
                          AND user_id = '$p_id'
                          AND status = '7'
                          ORDER BY num DESC LIMIT $cline,$last_page_num ";
            break;
        case 'finish':
            $qry = "SELECT * FROM mall_order
                              WHERE cancel = 'N'
                          AND user_id = '$p_id'
                          AND status = '8'
                          ORDER BY num DESC LIMIT $cline,$last_page_num ";
            break;
        case 'cancel':
            $qry = "SELECT * FROM mall_order
                              WHERE cancel = 'Y'
                          AND user_id = '$p_id'
                          ORDER BY num DESC LIMIT $cline,$last_page_num ";
            break;
        default:
            $qry = "SELECT * FROM mall_order
                              WHERE user_id = '$p_id'
                                ORDER BY num DESC LIMIT $cline,$last_page_num ";
    }

    $res  = mysqli_query($connect, $qry);
    $t_no = mysqli_num_rows($res);

    return array($t_no, $res);

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

    $code_qry = '';

    //중분류 선택시
    if ($mcode) {
        $code_qry = " AND category_m = '$mcode'";
    }

    if ("search" == $mode) {
        $search_qry .= " AND (name LIKE '%$keyword%' OR prod_code LIKE '$keyword' OR company LIKE '%$keyword%') ";
        $qry = "SELECT * FROM products WHERE approved='Y' AND del_chk != 'Y' $search_qry ";

    } else {
        $qry = "SELECT * FROM products WHERE category_l='$lcode' AND del_chk != 'Y' AND approved='Y' $code_qry";
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

    $last_page_num = $limit - $cline;

    return array($cline, $last_page_num, $cpage, $totalpage);
}

/**
 * [get_list_page_result 페이징 쿼리 결과]
 * @param  [type] $mode           [description]
 * @param  [type] $lcode          [description]
 * @param  [type] $mcode          [description]
 * @param  [type] $key            [description]
 * @param  [type] $keyword        [description]
 * @param  [type] $cline          [description]
 * @param  [type] $last_page_num  [description]
 * @return [type] [description]
 */
function get_list_page_result($mode, $lcode, $mcode, $key, $keyword, $cline, $last_page_num)
{
    global $connect;

    $code_qry = '';

    if ($mcode) {
        $code_qry = " AND category_m = '$mcode'";
    }

    if ("search" == $mode) {
        $search_qry .= " AND (name LIKE '%" . $keyword . "%' OR prod_code LIKE '" . $keyword . "' OR company LIKE '%" . $keyword . "%') ";
        $qry = "SELECT * FROM products WHERE approved='Y' AND del_chk != 'Y' " . $search_qry . " ORDER BY num DESC LIMIT " . $cline . ", " . $last_page_num . "";
    } else {
        $qry = "SELECT * FROM products WHERE del_chk='N'" . $code_qry . " AND approved = 'Y' ORDER BY num DESC LIMIT " . $cline . ", " . $last_page_num . "";
    }

    $res  = mysqli_query($connect, $qry);
    $t_no = mysqli_num_rows($res);

    return array($t_no, $res);

}

/**
 * [show_order_list 주문목록 보여주기]
 * @param  [type] $t_no           [쿼리결과 갯수]
 * @param  [type] $result         [쿼리결과]
 * @param  [type] $cpage          [현재 페이지]
 * @return [type] [description]
 */
function show_order_list($t_no, $result, $cpage)
{
    global $connect, $MERTKEY, $CST_MID, $CST_PLATFORM;

    $status_now = '';

    if ($t_no > 0) {

        $total = 0; //금일주문총액

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
                $status_now = '<i class="fa fa-remove"></i> 주문취소';
                $total -= $row['last_amount'];

                echo <<<HEREDOC
	                    <tr>
	                      <td>
	                        <a href="order-detail.php?oid={$row['num']}&amp;page={$cpage}">{$order_date}</a></td>
	                      <td>{$goods_name}&nbsp;
HEREDOC;

                echo $show_admin_memo;
                $pay_status = get_pg_info2($row['orderid']);

                echo <<<HEREDOC

	                      </td>
	                      <td>{$row['recipient_name']}</td>
	                      <td class="num-right"> - <br /></td>
                          <td>{$pay_status}</td>
                          <td>{$status_now}</td>
                          <td>&nbsp;</td>
	                      <td><a href="#" onclick="alert('이미 취소된 주문입니다.')"><i class="fa fa-ban"></i></a></td>
HEREDOC;

            } else {
                //end cancel

                if ($row['status'] == '1') {
                    $status_now = '<i class="fa fa-pause"></i> 입금대기';
                } else if ($row['status'] == '3') {
                    $status_now = '<i class="fa fa-pause"></i> 대기';
                } else if ($row['status'] == '5') {
                    $status_now = '<i class="fa fa-check"></i> 주문확인';
                } else if ($row['status'] == '7') {
                    $status_now = '<i class="fa fa-flag-checkered"></i> 발송대기';
                } else if ($row['status'] == '8') {
                    $status_now = '<i class="fa fa-check-square-o"></i> 발송완료';
                } else if ($row['status'] == '0') {
                    $status_now = '<i class="fa fa-minus-square"></i> 발송지연';
                }

                echo <<<HEREDOC
                    <tr>
                      <td><a href="order-detail.php?oid={$row['num']}&amp;page={$cpage}">{$row['createdate']}</a></td>
                      <td>{$goods_name}&nbsp;
HEREDOC;

                echo $show_admin_memo;

                $show_order_amount = number_format($row['amount']);
                $pay_status        = get_pg_info2($row['orderid']);
                $print_receipt     = '';

                if ($row['status'] == '8') {

                    // $MERTKEY  = 'e57352760ea5a2a1fce315c6ead11ece';
                    $authdata = md5($pg_row['LGD_MID'] . $pg_row['LGD_TID'] . $MERTKEY);

                    // 테스트에는 포트 7085 사용
                    $print_receipt = '<script language="JavaScript" src="http://pgweb.uplus.co.kr:7085/WEB_SERVER/js/receipt_link.js"></script>';

                    if ($pg_row['LGD_PAYTYPE'] == "SC0010") {
                        //신용카드 결제일 때
                        $print_receipt = '<a href="javascript:showReceiptByTID(\'' . $pg_row['LGD_MID'] . '\', \'' . $pg_row['LGD_TID'] . '\', \'' . $authdata . '\')"><i class="fa fa-print"></i></a>';
                    } elseif ($pg_row['LGD_PAYTYPE'] == "SC0030" || $pg_row['LGD_PAYTYPE'] == "SC0040") {
                                                //계좌이체일 때
                        $seqno         = "t/t"; //계좌이체는 임의의 정보 입력
                        $print_receipt = '<a href="javascript:showCashReceipts(\'' . $pg_row['LGD_MID'] . '\',\'' . $pg_row['LGD_OID'] . '\',\'' . $seqno . '\',\'BANK\',\'service\')"><i class="fa fa-print"></i></a>';
                    }
                }

                echo <<<HEREDOC
                      </td>
                      <td>{$recipient_name}</td>
                      <td class="num-right">{$show_order_amount}</td>
                      <td>{$pay_status}</td>
                      <td>{$status_now}</td>
                      <td>{$print_receipt}</td>
                      <td>
                          <form name="or_delete_{$i}" method="post" id="LGD_PAYINFO" action="../shop/order-delete.php">
                          <input type="hidden" name="oid" value="{$row['num']}">
                          <input type="hidden" name="page" value="{$cpage}">
                          <input type="hidden" name="CST_MID" value="{$CST_MID}">
                          <input type="hidden" name="CST_PLATFORM" value="{$CST_PLATFORM}">
                          <input type="hidden" name="LGD_TID" value="{$pg_row['LGD_TID']}">
                          <button type="submit" class="btn btn-xs btn-danger" onclick="return confirm('정말 주문을 취소하시겠습니까?')"><i class="fa fa-remove"></i></button>
                          </form>
                      </td>
                    </tr>
HEREDOC;

                $total += ($row['amount']);
            } // ./ if-else end
        } // ./for ($i = 0; $row = mysqli_fetch_array($result); $i++)

        $show_total_amount = number_format($total);

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

    $a_goods_fk = explode(",", $row['goods_fk']);
    $org_price  = explode(",", $row['goods_price']);
    $mod_price  = explode(",", $row['mod_price']);
    $org_volume = explode(",", $row['goods_count']);
    $mod_volume = explode(",", $row['mod_count']);
    $option     = explode(",", $row['goods_kind']);
    $tot_amount = 0;
    $org_amount = 0;
    $t_count    = 0;
    $mt_count   = 0;
    $pay_status = '';

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
                                    <td>{$org_volume[$i]}</td>
HEREDOC;

        if ($fixed_price) {
            echo '                          <td><i class="fa fa-lock"></i>' . number_format($org_price[$i]) . '</td>';
        } else {
            echo '                          <td>' . number_format($org_price[$i]) . '</td>';
        }

        $sub_amount      = (int) $mod_volume[$i] * (int) $mod_price[$i];
        $show_sub_amount = number_format($sub_amount);
        echo <<<HEREDOC
                                    <td>{$show_sub_amount}</td>
                                </tr>
HEREDOC;

        $tot_amount = $tot_amount + ((int) $mod_price[$i] * (int) $mod_volume[$i]);
        $org_amount = $org_amount + ((int) $org_price[$i] * (int) $org_volume[$i]);
        $t_count    = $t_count + (int) $org_volume[$i];
        $mt_count   = $mt_count + (int) $mod_volume[$i];
    } // ./ for ($i = 0; $i < sizeof($a_goods_fk); $i++)

    $last_cost         = $tot_amount;
    $show_delivery_fee = show_delivery_fee($last_cost);
    $show_last_cost    = number_format($last_cost);

    echo <<<HEREDOC
                                <tr>
                                    <td colspan="3">총 수량 :</td>
                                    <td>{$t_count} 개</td>
                                    <td></td>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td colspan="3">택배비 :</td>
                                    <td></td>
                                    <td></td>
                                    <td colspan="2"><i class="fa fa-plus-circle"></i> {$show_delivery_fee}</td>

                                </tr>
                                <tr>
                                    <td colspan="3"><h4>총 합 : </h4></td>
                                    <td></td>
                                    <td></td>
                                    <td colspan="2"><h4>{$show_last_cost}</h4>(VAT 포함)</td>
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
            return $ret = '<i class="fa fa-pause"></i> 상품을 준비 중입니다.';
            break;
        case '5':
            return $ret = '<i class="fa fa-check"></i> 주문확인 후 포장 중입니다.';
            break;
        case '7':
            return $ret = '<i class="fa fa-flag-checkered"></i> 포장완료 후 발송 준비 중입니다.';
            break;
        case '8':
            return $ret = '<i class="fa fa-check-square-o"></i> 상품을 발송했습니다. (운송장 번호: ' . show_logistics() . ' ' . show_track_no($oid) . ' )';
            break;
        case '0':
            return $ret = '<i class="fa fa-minus-square"></i> 발송이 지연됩니다.';
            break;
        default:
            return $ret = '<i class="fa fa-pause"></i> 상품을 준비 중입니다.';
            break;
    }

    // $a_status['3'] = '<i class="fa fa-pause"></i> 상품을 준비 중입니다.';
    // $a_status['5'] = '<i class="fa fa-check"></i> 주문확인 후 포장 중입니다.';
    // $a_status['7'] = '<i class="fa fa-flag-checkered"></i> 포장완료 후 발송 준비 중입니다.';
    // $a_status['8'] = '<i class="fa fa-check-square-o"></i> 상품을 발송했습니다. (운송장 번호: ' . show_logistics() . ' ' . show_track_no($oid) . ' )';

    // return $a_status;
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

    $pay_status = get_pg_info($row['orderid']);

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
                            {$pay_status}

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

    $show_org_amount  = number_format($row['amount']);
    $status           = show_order_status($oid, $row['status']);
    $memo_to_delivery = nl2br($row['memo_to_delivery']);
    $memo_to_admin    = nl2br($row['memo_to_admin']);
    $memo_from_admin  = nl2br($row['supplement']);

    echo <<<HEREDOC
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 buyer-info-padding">주문금액</div>
                        <div class="col-sm-9 buyer-info-padding">{$show_org_amount} 원 (VAT 포함)</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 buyer-info-padding">처리상태</div>
                        <div class="col-sm-9 buyer-info-padding">{$status}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 buyer-info-padding">배송 시 요청사항</div>
                        <div class="col-sm-9 buyer-info-padding">{$memo_to_delivery}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 buyer-info-padding">담당자에게 요청사항</div>
                        <div class="col-sm-9 buyer-info-padding">{$memo_to_admin}</div>
                    </div>
                    <div class="row bg-danger">
                        <div class="col-sm-3 buyer-info-padding">※ 관리자 메모</div>
                        <div class="col-sm-9 buyer-info-padding">{$memo_from_admin}</div>
                    </div>

HEREDOC;
}

/**
 * [show_product_image 상세페이지 상품이미지 보여주기]
 * @param  [type] $pnum           [상품번호]
 * @return [type] [description]
 */
function show_product_image($pnum)
{
    global $connect;

    // $query  = "SELECT * FROM products WHERE num='$pnum'";
    // $result = mysqli_query($connect, $query);
    // isset($b_image1)fetch_array($result);
    // mysqli_free_result($result);

    echo <<<HEREDOC
                                  <!-- Tab panes -->
                                    <div class="tab-content">
HEREDOC;

    $b_image1 = show_image('b', 1, $pnum);
    $b_image2 = show_image('b', 2, $pnum);
    $b_image3 = show_image('b', 3, $pnum);
    $b_image4 = show_image('b', 4, $pnum);

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

    $s_image1 = show_image('s', 1, $pnum);
    $s_image2 = show_image('s', 2, $pnum);
    $s_image3 = show_image('s', 3, $pnum);
    $s_image4 = show_image('s', 4, $pnum);

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
 * [show_product_info 상세페이지 상품 정보보여주기]
 * @param  [type] $pnum           [상품번호]
 * @return [type] [description]
 */
function show_product_info($pnum)
{

    global $connect;

    $qry  = "SELECT * FROM products WHERE del_chk='N' AND approved = 'Y' AND num='$pnum' ";
    $res  = mysqli_query($connect, $qry);
    $rows = mysqli_fetch_array($res);

    $p_id = set_var($_SESSION['p_id']);

    $item_name   = stripslashes($rows['name']);
    $moq         = $rows['moq'];
    $short_desc  = $rows['short_desc'];
    $offer_price = calc_offer_price($rows['retail_price'], $p_id);
    $price       = show_me_price($pnum);
    $option      = show_option($pnum);

    echo <<<HEREDOC
                            <!-- show product info -->
                            <form name="form_{$pnum}" method="post" action="">
                            <input type="hidden" name="pnum" id="pnum_{$pnum}" value="{$pnum}">

                            <div class="cras">
                                <div class="product-name">
                                    <h1>{$item_name}</h1>
                                </div>
                                <div class="pro-rating">
                                    모델명: {$short_desc}
                                </div>
                                <p class="availability in-stock">
                                    재고:
                                    <span>있음</span>
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

    if ($p_id) {
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
                                                <input type="hidden" name="amount" id="amount_{$pnum}" value="{$offer_price}">
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
function show_relative_item($lcode, $mcode)
{
    global $connect;

    $qry = "SELECT * FROM products WHERE del_chk='N' AND category_l='$lcode' AND category_m='$mcode' AND approved = 'Y' ORDER BY rand() LIMIT 4 ";
    $res = mysqli_query($connect, $qry);

    for ($i = 0; $i < $rows = mysqli_fetch_array($res); $i++) {
        $p_id = set_var($_SESSION['p_id']);

        $small_image  = $rows['s_image1_name'];
        $product_name = $rows['name'];
        $short_desc   = get_short($rows['short_desc'], 25);
        $shop_price   = number_format($rows['shop_price']);
        $offer_price  = calc_offer_price($rows['retail_price'], $p_id);
        $dealer_price = number_format($offer_price);

        echo <<<HEREDOC

                                        <div class="ma-box-content">
                                            <div class="product-img-right">
                                                <a href="#">
                                                    <img class="primary-image" alt="" src="{$small_image}">
                                                </a>
                                            </div>
                                            <div class="product-content">
                                                <h2 class="product-name">
                                                    <a href="#">{$product_name}</a>
                                                </h2>
                                                <div class="pro-rating">
                                                    {$short_desc}
                                                </div>
                                                <div class="price-box">
HEREDOC;

        if ($p_id) {
            echo '                                                <span class="special"><i class="fa fa-krw"></i> ' . $dealer_price . '</span>';
        } else {
            echo '                                                <span class="shop"><i class="fa fa-krw"></i> ' . $shop_price . '</span>';
        }

        echo <<<HEREDOC
                                                </div>
                                            </div>
                                        </div>

HEREDOC;
    }
}

function get_contents($pnum)
{
    global $connect;

    $query  = "SELECT * FROM products WHERE num='$pnum'";
    $result = mysqli_query($connect, $query);
    $rows   = mysqli_fetch_array($result);

    return $rows['contents'];
}
