<?php

include_once "../util/util.php";

session_start();

$page           = set_var($_POST['page']);
$lcode          = set_var($_POST['lcode']);
$products_count = set_var($_POST['products_count']);
$pnum           = set_var($_POST['pnum']);
$selected_opt   = set_var($_POST['selected_opt']);
$amount         = set_var($_POST['amount']);
$chk            = set_var($_POST['chk']);

//POST 방식 변수
$md      = set_var($_POST['md']);
$from    = set_var($_POST['from']);
$cart_id = set_var($_POST['cart_id']);

//GET 방식 변수
$mode    = set_var($_GET['mode']);
$where   = set_var($_GET['where']);
$cart_no = set_var($_GET['cart_no']);

$p_id = set_var($_SESSION['p_id']);

if (!$_COOKIE['p_sid']) {
    $SID = md5(uniqid(rand()));
    SetCookie("p_sid", $SID, 0, "/");
}

if (!$p_id) {
    $id_fk = "guest";
} else {
    $id_fk = $p_id;
}

/**
 * 카트에서 주문하기
 */
if ("cart" == $from || "cart" == $where) {
    if ($mode == "del") {
        $query = "DELETE FROM products_cart WHERE cart_id='$cart_no' ";
        mysqli_query($connect, $query);
    } else if ($md == "edit") {
        $query = "UPDATE products_cart SET volume='$products_count' WHERE cart_id='$cart_id' ";
        mysqli_query($connect, $query);
    }

    // echo "<meta http-equiv='Refresh' content='0; URL=cart.php'>";
    // redirect('cart.php');
    header("Location: cart.php");

/**
 * 상품 상세에서 주문하기
 */
} else if ("detail" == $from) {

    //카트에 있는 상품확인
    $qry = "SELECT * FROM products_cart WHERE user_id='$id_fk' AND product_code='$pnum' AND p_opt='$selected_opt'  ";
    $res = mysqli_query($connect, $qry);
    $row = mysqli_fetch_array($res);

    if (count($row) > 0) {
        $products_count += $row['volume'];

        $query = "UPDATE products_cart SET volume = '$products_count' WHERE cart_id='$row[cart_id]' AND user_id='$id_fk' ";
        mysqli_query($connect, $query);
    } else {
        $query = "INSERT INTO products_cart VALUES ('', '$id_fk', '$_COOKIE[p_sid]', '$pnum', '$products_count', '$amount', '$selected_opt', now() )";
        mysqli_query($connect, $query);
    }

    if ($chk == "2") {
        redirect('checkout.php?from=detail');
        // echo "<meta http-equiv='Refresh' content='0; URL=checkout.php?from=detail'>";
    } else {

        $msg = "<meta http-equiv='content-type' content='text/html; charset=UTF-8' />\n";
        $msg .= "<script>\n";
        $msg .= "window.alert('카트에 담았습니다.')\n";
        $msg .= "</script>\n";

        // get quantity from cart
        $t_qry5  = "SELECT sum(volume) AS cnt_2 FROM products_cart WHERE user_id = '$id_fk'";
        $t_res5  = mysqli_query($connect, $t_qry5);
        $t_rows5 = mysqli_fetch_array($t_res5);
        mysqli_free_result($t_res5);

        echo json_encode(array("msg" => $msg, "qty" => $t_rows5['cnt_2']));

    }

/**
 * 상품 목록에서 주문하기
 */
} else if ("list" == $from) {
    if (!$products_count) {
        $products_count = 1;
    }

    //카트에 있는 상품확인
    $qry = "SELECT * FROM products_cart WHERE user_id='$id_fk' AND product_code='$pnum' AND p_opt='$selected_opt'  ";
    $res = mysqli_query($connect, $qry);
    $row = mysqli_fetch_array($res);

    if (count($row) > 0) {
        $products_count += $row['volume'];

        $query  = "UPDATE products_cart SET volume = '$products_count' WHERE cart_id='$row[cart_id]' AND user_id='$id_fk' ";
        $result = mysqli_query($connect, $query);
    } else {
        $query  = "INSERT INTO products_cart VALUES ('', '$id_fk', '$_COOKIE[p_sid]', '$pnum', '$products_count', '$amount', '$selected_opt', now() )";
        $result = mysqli_query($connect, $query);
    }

    if ($chk == "2") {
        redirect('checkout.php?from=detail');
    } else {
        $msg = "<meta http-equiv='content-type' content='text/html; charset=UTF-8' />\n";
        $msg .= "<script>\n";
        $msg .= "window.alert('카트에 담았습니다.')\n";
        $msg .= "</script>\n";

        // get quantity from cart
        $t_qry5  = "SELECT sum(volume) AS cnt_2 FROM products_cart WHERE user_id = '$id_fk'";
        $t_res5  = mysqli_query($connect, $t_qry5);
        $t_rows5 = mysqli_fetch_array($t_res5);
        // mysqli_free_result($t_res5);

        echo json_encode(array("msg" => $msg, "qty" => $t_rows5['cnt_2']));
    }

} else if ("new" == $from) {
    if (!$products_count) {
        $products_count = 1;
    }

    //카트에 있는 상품확인
    $qry = "SELECT * FROM products_cart WHERE user_id='$id_fk' AND product_code='$pnum' AND p_opt='$selected_opt'  ";
    $res = mysqli_query($connect, $qry);
    $row = mysqli_fetch_array($res);

    if (count($row) > 0) {
        $products_count += $row['volume'];

        $query = "UPDATE products_cart SET volume = '$products_count' WHERE cart_id='$row[cart_id]' AND user_id='$id_fk' ";
        mysqli_query($connect, $query);
    } else {
        $query = "INSERT INTO products_cart VALUES ('',	'$id_fk','$_COOKIE[p_sid]', '$pnum', '$products_count',	'$amount', '$selected_opt', now() )";
        mysqli_query($connect, $query);
    }

    if ($chk == "2") {
        redirect('checkout.php?from=detail');
        // echo "<meta http-equiv='Refresh' content='0; URL=checkout.php?from=detail'>";
    } else {
        $url = "sub_list.php?mode=$mode&page=$page";
        show_msg('카트에 담았습니다.', $url);
    }
} else if ("dir" == $from) {
    // 비회원 바로구매
    //카트에 있는 상품확인
    $qry = "SELECT * FROM products_cart WHERE user_id='$id_fk' AND product_code='$pnum' AND p_opt='$selected_opt'  ";
    $res = mysqli_query($connect, $qry);
    $row = mysqli_fetch_array($res);

    if (count($row) > 0) {
        $products_count += $row['volume'];

        $query = "UPDATE products_cart SET volume = '$products_count' WHERE cart_id='$row[cart_id]' AND user_id='$id_fk' ";
        mysqli_query($connect, $query);
    } else {
        $query = "INSERT INTO products_cart VALUES ('', '$id_fk', '$_COOKIE[p_sid]', '$pnum', '$products_count', '$amount', '$selected_opt', now() )";
        mysqli_query($connect, $query);
    }
    redirect('purchase_p.php?from=dir');
    // echo "<meta http-equiv='Refresh' content='0; URL=purchase_p.php?from=dir'>"; //별도의 구매페이지로 이동
} else if ("5" == $chk) {
    // 검색결과
    //카트에 있는 상품확인
    $qry = "SELECT * FROM products_cart WHERE user_id='$id_fk' AND product_code='$pnum' AND p_opt='$selected_opt'  ";
    $res = mysqli_query($connect, $qry);
    $row = mysqli_fetch_array($res);

    if (count($row) > 0) {
        $products_count += $row['volume'];

        $query = "UPDATE products_cart SET volume = '$products_count' WHERE cart_id='$row[cart_id]' AND user_id='$id_fk' ";
        mysqli_query($connect, $query);
    } else {
        $query = "INSERT INTO products_cart VALUES ('', '$id_fk', '$_COOKIE[p_sid]', '$pnum', '$products_count', '$amount', '$selected_opt', now() )";
        mysqli_query($connect, $query);
    }

    $url = "sub_list.php?mode=search&key=$key&keyword=$keyword&page=$page";
    show_msg('카트에 담았습니다.', $url);
} else {
    redirect('cart.php');
    // echo "<meta http-equiv='Refresh' content='0; URL=cart.php'>";
}
