<?php include_once '../include/header.php';?>

<?php

$mode     = set_var($_GET['mode']);
$code     = set_var($_GET['code']);
$main_no  = set_var($_POST['main_no']);
$reply_no = set_var($_POST['reply_no']);

$p_id   = set_var($_SESSION['p_id']);
$p_name = set_var($_SESSION['p_name']);

$s_sql = '';

if ($mode == "search") {
    switch ($key) {
        case 'title':
            $s_sql .= " AND title LIKE '%$keyword%' ";
            break;

        case 'contents':
            $s_sql .= " AND contents LIKE '%$keyword%' ";
            break;

        case 'name':
            $s_sql .= " AND name LIKE '%$keyword%' ";
            break;
    }
}

//게시판 코드값을 가져온다.
if ($code) {
    //게시판 코드에서 readable 속성 추출
    $bqry = "SELECT * FROM code WHERE code='$code' ";
    $bres = mysqli_query($connect, $bqry);
    $brow = mysqli_fetch_array($bres);

    $board = 'bbs_' . $code;

    $readable = $brow['readable'];
    $writable = $brow['writable'];

    //해당 아이디 사용자의 글만 추출
    // if ($readable == 'E' && 'admin' != $p_id) {
    //     $sql = "SELECT * FROM $board WHERE (id='$p_id' OR id='admin') $s_sql ORDER BY main_no DESC ";
    // } else {
    //     $sql = "SELECT * FROM $board WHERE 1 $s_sql ORDER BY main_no DESC";
    // }

    $sql    = "SELECT * FROM $board ORDER BY main_no DESC";
    $result = mysqli_query($connect, $sql);
    //테이블에 있는 총 갯수를 가져온다.
    if ($result) {
        $total = mysqli_num_rows($result);
    } else {
        $total = 0;
    }

} else {
    err_msg('선택한 게시판이 없습니다.', 1);
    exit;
}
?>

    <!-- HOME -->
    <div class="container">
        <div class="row text-center">
            <h1><?php echo $brow['bbs_name']; ?></h1>
        </div>
    </div>
    <!-- /.home -->


<?php

$page  = set_var($_GET['page']);
$scale = 20;

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

// not logged in status
// if (!$p_id) {
?>

        <!-- CONTAINER -->
<!--         <div class="container">
            <div class="row">
              <div class="text-center alert alert-danger" role="alert">
                <p><a href="/member/login.php" class="a-login btn btn-primary">로그인</a></p>
                <p class="help-block">가입업체 전용 게시판입니다. 먼저 로그인하세요</p>
              </div>
            </div> -->
            <!-- row -->

<?php
// logged in status
// } else {

;?>

      <form name="form1" method="post" action="admin_delete.php?code=<?php echo $code; ?>">
        <input type="hidden" name="code" value="<?php echo $code; ?>" />

        <!-- CONTAINER -->
        <div class="container">
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
<?php

if ($p_id == 'admin') {
    echo '<th>선택</th>';
}
?>
                                <th>번호</th>
                                <th>제 목</th>
                                <th>작성자</th>
                                <th>작성일</th>
                                <th>조 회</th>
                            </tr>
                        </thead>
                        <tbody>

<?php

if ($p_id == 'admin') {
    $num = 6;
} else {
    $num = 5;
}

// 만약 검색 결과가 없다면,
if ($total == 0) {

    ?>

                            <tr>
                              <td colspan="<?php echo $num; ?>"><p class="text-center">아직 글이 없습니다.</p></td>
                            </tr>

<?php

} else {
    // if ($p_id == 'admin') {
    //     $num = 6;
    // } else {
    //     $num = 5;
    // }

    if ($readable == 'M' && $p_id != 'admin') {
        $sql = "SELECT * FROM $board WHERE (id='$_SESSION[p_id]' OR id='admin') $s_sql ORDER BY create_date DESC LIMIT $cline,$scale1";
    } else {
        $sql = "SELECT * FROM $board WHERE 1 $s_sql ORDER BY create_date DESC LIMIT $cline,$scale1";
    }

    //쿼리 후 결과를 저장한다.
    $result = mysqli_query($connect, $sql);

    for ($i = 0; $row = mysqli_fetch_array($result); $i++) {

        echo "<tr>\n";

        if ($p_id == 'admin') {
            echo '<td><input type="checkbox" name="chk[]" value="' . $row['main_no'] . '"></td>' . "\r\n";
        }
        ?>
                              <td><?php echo $row['main_no']; ?></td>

<?php

        if ($row['depth'] > 0) {
            $hasReply = '&nbsp;<span class="badge">' . $row['depth'] . '</span>';
        } else {
            $hasReply = '';
        }

        if ($row['filename']) {
            $hasAttachment = '&nbsp;<i class="fa fa-floppy-o"></i>&nbsp;';
        } else {
            $hasAttachment = '';
        } // //답변만 있는 경우; // if ($row['depth'] > 0 && (!$row['filename'])) {

        //날짜 형식을 바꾼다.
        $post_date = substr($row['create_date'], 0, 11);
        ?>
                              <td><a href="read.php?code=<?php echo $code; ?>&amp;main_no=<?php echo $row['main_no']; ?>&amp;page=<?php echo $page; ?>"><?php echo stripslashes($row['title']); ?></a><?php echo $hasAttachment; ?><?php echo $hasReply; ?></td>
                              <td><?php echo $row['name']; ?></td>
                              <td><?php echo $post_date; ?></td>
                              <td><?php echo $row['count']; ?></td>
                            </tr>
<?php

    }
}
; // end else
?>
                        </tbody>
                        <tfoot>
                            <tr>
                              <td colspan="<?php echo $num; ?>" class="text-center">
<?php

//쪽 수를 표시
$url = $_SERVER['PHP_SELF'] . "?code=" . $code;
page_nav($totalpage, $cpage, $url);

// end else -->
?>
<!--                               </td>
                            </tr>
                        </tfoot> -->
                    </table>
                </div> <!-- table-responsive -->
            </div> <!-- row -->

<?php

// $qry  = "SELECT * FROM code WHERE code='$code' ";
// $res  = mysqli_query($connect, $qry);
// $row1 = mysqli_fetch_array($res);

//관리자 전용쓰기 게시판 여부 확인
// 읽기권한: 회원 및 관리자

switch ($writable) {
    case 'A':
        if ($p_id == 'admin') {
            $showButton = '<a class="btn btn-success" href="post.php?code=' . $code . '"><i class="fa fa-pencil-square-o"></i> 쓰 기</a>' . "\r\n";
            $showButton .= '<a class="btn btn-danger" href="#" onClick="javascript:del_send();"><i class="fa fa-trash-o"></i> 삭 제</a></p>' . "\r\n";
        } else {
            $showButton = '<button type="button" class="btn btn-xs btn-primary pull-right" data-toggle="modal" data-target="#login2">' . "\r\n";
            $showButton .= '<i class="fa fa-cog"></i> ADMIN LOGIN' . "\r\n";
            $showButton .= '</button>' . "\r\n";
        }

        break;

    case 'M':
        if ($p_id && $p_id != 'admin') {
            $showButton = '<a class="btn btn-success" href="post.php?code=' . $code . '"><i class="fa fa-pencil-square-o"></i> 쓰 기</a> &nbsp;' . "\r\n";
        } elseif ($p_id == 'admin') {
            $showButton = '<a class="btn btn-success" href="post.php?code=' . $code . '"><i class="fa fa-pencil-square-o"></i> 쓰 기</a>' . "\r\n";
            $showButton .= '<a class="btn btn-danger" href="#" onClick="del_send();"><i class="fa fa-trash-o"></i> 삭 제</a>' . "\r\n";
            $showButton .= '<a class="btn btn-warning" href="/member/logout.php">로그아웃</a>' . "\r\n";
        } else {
            $showButton = '<button type="button" class="btn btn-xs btn-primary pull-right" data-toggle="modal" data-target="#login2">' . "\r\n";
            $showButton .= '<i class="fa fa-cog"></i> ADMIN LOGIN' . "\r\n";
            $showButton .= '</button>' . "\r\n";
        }

        break;

    case 'E':
        $showButton = '<a class="btn btn-success" href="post.php?code=' . $code . '"><i class="fa fa-pencil-square-o"></i> 쓰 기</a> &nbsp;' . "\r\n";
        $showButton .= '<button type="button" class="btn btn-xs btn-primary pull-right" data-toggle="modal" data-target="#login2">' . "\r\n";
        $showButton .= '<i class="fa fa-cog"></i> ADMIN LOGIN' . "\r\n";
        $showButton .= '</button>' . "\r\n";

        break;
}

?>
            <div class="row">
              <p>
                <?php echo $showButton; ?>
              </p>
            </div>

        </form>

        <form name="search_form" class="form-inline" action="list.php?code=<?php echo $code; ?>" method="post">
            <input type="hidden" name="mode" value="search" />
            <input type="hidden" name="code" value="<?php echo $code; ?>" />
            <div class="row margin-top-10 text-center">
              <div class="col-md-12">
                <select class="form-control">
                  <option value="title">제 목</option>
                  <option value="name">작성자</option>
                  <option value="content">내 용</option>
                </select>
                <input type="text" class="form-control" name="keyword" placeholder="검색어" />
                <button type="submit" class="btn btn-primary" name="submit" /><i class="fa fa-search"></i>검 색</button>
              </div>
            </div>
        </form>

        <!-- Popup: BBS admin login -->
        <div class="modal fade" id="login2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">게시판 관리자 로그인</h4>
              </div>
              <div class="modal-body">
                  <form method="post" name="login" class="loginform" action="//<?php echo $_SERVER['SERVER_NAME']; ?>:<?php echo $sslPort; ?>/bbs/login_ok.php" onsubmit="JavaScript:return(admin_login_check());">
                  <input type="hidden" name="main_no"  value="<?php echo $main_no; ?>">
                  <input type="hidden" name="reply_no" value="<?php echo $reply_no; ?>">
                  <input type="hidden" name="code"     value="<?php echo $code; ?>">
                  <input type="hidden" name="uri"      value="<?php echo $uri; ?>">
                  <div class="formwrap">
                      <div class="form-group has-feedback">
                          <input type="password" class="form-control login-password" name="pwd2" placeholder="게시판 관리용 비밀번호" id="login-password2">
                      </div>
                  </div>
                  <div class="form-group text-center">
                      <button type="submit" class="btn btn-primary block">로그인</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">닫기</button>
                  </div>
                  </form>
              </div>
            </div>
          </div>
        </div>
        <!-- end popup -->


<?php

//회원로그인 else end
// }
;?>
      </div> <!-- /.container -->



<?php include_once '../include/brands.php';?>

<?php include_once '../include/footer.php';?>

      <script type="text/javascript">
        function del_send() {
          var form = document.form1;
          var b=0;

          for (i=0; i < form.elements.length; i++) {
          if (form.elements[i].name =="chk[]") {
                  if (form.elements[i].checked == true) {
                b++;
            }
            }
        }

        if(b == 0) {
          alert("삭제할 게시물을 하나 이상 선택하세요.");
            return;
          }

        var x = confirm('답글까지 모두 삭제됩니다.\n삭제하시겠습니까?');
          if(x == true) {
            form.submit();
          }
      }
      </script>
    </body>
</html>

