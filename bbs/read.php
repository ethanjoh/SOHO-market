<?php
include "../util/config.php";
include "../util/util.php";

$connect = my_connect($host,$dbid,$dbpass,$dbname);

if(!$_COOKIE[p_sid]){
    $SID = md5(uniqid(rand()));
    SetCookie("p_sid",$SID,0,"/");
}

$info_query = "SELECT * FROM admin_setup";
$info_res = mysqli_query($connect, $info_query);
$info = mysqli_fetch_array($info_res);

$bqry = "SELECT * FROM code WHERE code='$code' ";
$bres = mysqli_query($connect, $bqry);
$brow = mysqli_fetch_array($bres);


//조회수 증가
$board = 'bbs_'.$code;
mysqli_query($connect, "UPDATE $board SET count = count+1 WHERE main_no = $main_no");

//테이블 값을 불러온다
$sql = "SELECT * FROM $board WHERE main_no=$main_no ";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_array($result);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
    <meta name="keywords" content="<?=$info['keywords']?>" />
    <meta name="description" content="<?=$info['description']?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?=$info['site_name']?></title>
    <link href="favicon.ico" rel="shortcut icon" type="image/x-icon">
    <link href="../css/bootstrap.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">

    <script src="js/HuskyEZCreator.js" charset="utf-8"></script>
    <script language="javascript" type="text/javascript">
    <!--
    function editwindow(url) {
      newwindow=window.open(url,'edit_window','height=400,width=600, left=100, top=100, resizable=yes,scrollbars=yes,status=yes');

    }

    // -->
    </script>

    <script type="text/javascript" src="jquery.color.js"></script>

    <script type="text/javascript">
    $(document).ready(function(){

      $(".pane:even").addClass("alt");

      $(".pane .btn-delete").click(function(){
        $(this).parents(".pane").animate({ backgroundColor: "#fbc7c7" }, "fast")
        .animate({ backgroundColor: "#ffffff" }, "slow")
        return true;
      });

      $(".pane .btn-edit").click(function(){
        $(this).parents(".pane").animate({ backgroundColor: "#dafda5" }, "fast")
        .animate({ backgroundColor: "#ffffff" }, "slow")
        .removeClass("spam")
        return false;
      });

    });
    </script>

    <!-- smart editor end -->
    <script language="JavaScript">
    <!--
        function send(id)
        {
            if (document.getElementById(id).value <0) {
                alert("내용을 입력하십시오.");
                document.getElementById(id).focus();
                return false;
            }
        oEditors.getById[id].exec("UPDATE_CONTENTS_FIELD", []);
            document.reply_form.submit();
        }
    -->
    </script>

</head>
<body>

<!-- Preloader -->
<div id="preloader">
    <div id="status">&nbsp;</div>
</div>

<!-- WRAPPER -->
<div class="wrapper">

    <!-- HEADER -->
    <?php include "../include/header.php"; ?>
    <!-- /.header -->

   <!-- HOME -->
    <div class="overlay home medium-size">
        <div class="bg bg-help" data-stellar-background-ratio="0.5"></div>
        <div class="container vmiddle">
            <div class="row text-center">
                <div class="icon-big color icon-bag-shopping-streamline"></div>
                <h1>NOTICE</h1>
            </div>
        </div>
    </div>
    <!-- /.home -->

    <!-- contents -->
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="table-responsive">

                <?php
                  if(!$_SESSION['p_id'] && $brow['readonly'] == 'N') {
                    $msg = "잘못된 접근이거나 로그인하시기 바랍니다.";
                    $url = "list.php?code=".$code;
                    show_msg($msg, $url);
                  }else if($_SESSION['p_id'] !='admin' && $brow['readonly'] == 'N' && $row['id'] != 'admin') {
                    $sql1 = "SELECT * FROM member WHERE id='$_SESSION[p_id]' ";
                    $result1 = mysqli_query($connect, $sql1);
                    $row1 = mysqli_fetch_array($result1);

                    if($row1['id'] != $row['id']) {
                      $msg = "본인이 작성한 글이 아니거나 로그인하시기 바랍니다.";
                      $url = "list.php?code=".$code;
                      err_msg($msg, $url);
                    }
                  } // end else if


                	if($_SESSION['p_id'] =='admin' || $row1['id'] == $row['id'] || $brow['readonly'] == 'Y ' || $row['id'] == 'admin') {
                	?>
                      <table class="table">
                        <thead>
                          <tr>
                            <th>번호</th>
                            <th>제목</th>
                            <th>작성자</th>
                            <th>작성일</th>
                            <th>조회</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td><?=$row['main_no']?></td>
                            <td class="left"><?=stripslashes($row['title'])?></td>
                            <td><a href="mailto:<?=$row['email']?>"><?=$row['name']?></a></td>
                            <td><?=$row['date']?></td>
                            <td><?=$row['count']?></td>
                          </tr>
                          <tr>
                            <td class="smartOutput" colspan="5" style="text-align:left">
                              <p><?=stripslashes($row['contents'])?></p>
                              <p>[ 최종수정일 : <?=$row['mod_date']?> ]</p>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                      <?php
                      ////////////////////////첨부파일 표시//////////////////////////////////
                      $max_file_num = 1; //업로드 파일 갯수 지정

                      if($row['filename']) {
                	  ?>
                      <table class="table">
                        <tbody>
                          <tr>
                            <td><?php
                            for($i=0; $i < $max_file_num; $i++) {
                            	if($row['filename']) {
                            		$path = $row['filename'];

                            		//Array 값으로 분리, [0]에는 "_"이전 값이, [1]에는 "_"이후 값이 들어있다.
                            		$chk_name = explode("_", $row['filename']);
                            		$real_name = $chk_name[sizeof($chk_name)-1];
                		?>
                              <img src="images/i_disk.gif" width="16" height="16" alt="첨부파일" /><a href="<?=$path?>">
                              <?=$real_name?>
                              </a>
                              <?php
                               }
                            }
                			?></td>
                          </tr>
                        </tbody>
                      </table>
                      <?php
                      } //if문
                	  ?>
                      <!-- 게시판 기능 버튼 -->
                      <div class="text-center"> <a class="btn btn-primary btn-xs" href="list.php?code=<?=$code?>&amp;page=<?=$page?>">목 록</a> &nbsp; <a class="btn btn-warning btn-xs" href="post.php?mode=edit&amp;code=<?=$code?>&amp;main_no=<?=$row['main_no']?>">수 정</a> &nbsp; <?php echo ($_SESSION['p_id'] == 'admin') ? "<a class=\"btn btn-danger btn-xs\" href=\"admin_delete.php?code=".$code."&amp;main_no=".$row['main_no']."&amp;from=read\" return confirm('삭제하시겠습니까?');\"><i class=\"fa fa-trash-o\"></i>삭 제<a>" : " <a class=\"btn btn-danger btn-xs\" href=\"delete.php?mode=parent&code=".$code."&amp;main_no=".$row['main_no']."\" return confirm('삭제하시겠습니까?'); \"><i class=\"fa fa-trash-o\"></i>삭 제</a>"; ?> </div>
                      <p></p>
                      <?php

                      /////////////////////////답글이 있다면 순차적을 정열한다./////////////////////////
                      if($row['depth'] > 0) {
                	      $board = 'bbs_re_'.$code;
                	      $re_sql = "SELECT * FROM $board WHERE main_no = $main_no ORDER BY reply_no ASC";
                	      $re_result = mysqli_query($connect, $re_sql);

                	      $i = 1;

                	      while($re_row = mysqli_fetch_array($re_result)) {
                	   ?>
                      <div class="pane">
                        <strong><img src="Chat_32.png" width="32" height="32" border="0" alt="답변"><?=$re_row['name']?> 답변: <?=$re_row['title']?></strong>
                        <p>
                        <div class="smartOutput margin-top-10">
                          <p><?=stripslashes($re_row['contents'])?></p>
                        </div>
                        </p>
                        <p>작성일 : <?=$re_row['date']?></p>
                        <p><a href="edit_reply.php?code=<?=$code?>&amp;main_no=<?=$main_no?>&amp;reply_no=<?=$re_row['reply_no']?>&amp;id=<?=$_SESSION['p_id']?>" onClick="editwindow(this.href); return false;" class="btn btn-primary btn-xs">수 정</a> &nbsp; <?php echo ($_SESSION['p_id'] == 'admin' ) ? "<a href=\"admin_delete.php?code=".$code."&amp;main_no=".$main_no."&amp;reply_no=".$re_row['reply_no']."&amp;from=reply\" onclick=\"return confirm('답변을 삭제하시겠습니까?');\" class=\"btn btn-danger btn-xs\"><i class=\"fa fa-trash-o\"></i>삭 제</a>" : "<a href=\"delete.php?mode=child&code=".$code."&amp;main_no=".$main_no."&amp;reply_no=".$re_row['reply_no']."\" class=\"btn btn-danger btn-xs\"><i class=\"fa fa-trash-o\"></i>삭 제</a>"?> </p>
                      </div>
                      <?php
                		        $reply_no = $re_row['reply_no']; // 마지막 답글 번호를 저장해 답변 시 넘긴다.
                		        $i++;
                		    }
                      }

                	  if($_SESSION['p_id'] && $_SESSION['p_name']) { //로그인을 했을 때만 댓글입력할 수 있도록
                	  	if($_SESSION['p_id'] == 'admin' || $row1['id'] == $row['id']) {
                      ?>

                      <!-- 댓글 -->
                      <form name="reply_form" method="post" action="https://<?=$_SERVER['SERVER_NAME']?>:<?=$port?>/bbs/post_ok.php">
                      <!-- <form name="reply_form" method="post" action="http://www.<?=$_SERVER['SERVER_NAME']?>/bbs/post_ok.php"> -->
                        <input type="hidden" name="mode" value="reply" />
                        <input type="hidden" name="main_no" value="<?=$main_no?>" />
                        <input type="hidden" name="reply_no" value="<?=$reply_no?>" />
                        <input type="hidden" name="code" value="<?=$code?>" />
                        <input type="hidden" name="id" value="<?=$_SESSION['p_id']?>" />
                        <input type="hidden" name="name" value="<?=$_SESSION['p_name']?>" />
                        <table class="table">
                          <tbody>
                            <tr>
                              <td><textarea name="contents" id="contents" style="width:100%; height:200px"></textarea></td>
                            </tr>
                          </tbody>
                        </table>
                        <div class="pull-right"><a class="btn btn-success" href="#" onClick="javascript:send('contents');"><span>댓글 남기기</span></a></div>
                      </form>
                      <?php
                		}

                	  } //if end

                	}else{
                		echo "ERROR";
                	}


                	/*
                   }else {
                        echo "<script>alert('잘못된 접근이거나 로그인하시기 바랍니다.');\n
                			      history.back(-1);</script>";
                   }
                      */

                	  ?>
                      <p></p>
          </div>
        </div>
      </div>
    </div>
    <!-- contents end -->


<!-- FOOTER -->
<?php include"../include/footer.php"; ?>

<script src="../js/jquery-2.1.1.min.js"></script>
<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDv0RLj_LBhRntn4AOCr4zHSYv0-F8gVeA&sensor=false"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/jquery.plugins.js"></script>
<script src="../js/custom.js"></script>
<script src="../js/global.js"></script>
<script src="../js/member.js"></script>

<script>
var oEditors = [];
nhn.husky.EZCreator.createInIFrame({
  oAppRef: oEditors,
  elPlaceHolder: "contents",
  sSkinURI: "SmartEditor2Skin.html",
  htParams : {bUseToolbar : true,
    fOnBeforeUnload : function(){
      //alert("아싸!");
    }
  }, //boolean
  fOnAppLoad : function(){
    //예제 코드
    //oEditors.getById["contents"].exec("PASTE_HTML", ["* 세금계산서 신청은 계산서신청 게시판에 해주세요.(본 안내글은 삭제 후 작성해주세요.)"]);
  },
  fCreator: "createSEditor2"
});

</script>

</body>
</html>

