<?php

//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

//메타정보
$info_query = "SELECT * FROM admin_setup";
$info_res = mysqli_query($connect, $info_query);
$info = mysqli_fetch_array($info_res);

$sql_1 = "SELECT num FROM mall_order WHERE cancel='N' AND status='3' AND user_id <> 'guest' ";
$res_1 = mysqli_query($connect, $sql_1);
$unchk_total = mysqli_num_rows($res_1);

?>
<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keyword" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="shortcut icon" href="/favicon.ico">

    <title><?=$info['company_name']?> :: 운영업체 관리자 홈</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/admin/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="/css/font-awesome.min.css" rel="stylesheet" />
    <link href="/admin/jquery-easy-pie-chart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="/admin/css/owl.carousel.css" rel="stylesheet" >

    <!--right slidebar-->
    <link href="/admin/css/slidebars.css" rel="stylesheet">

    <!-- Custom styles for this template -->

    <link href="/admin/css/style.css" rel="stylesheet">
    <link href="/admin/css/style-responsive.css" rel="stylesheet" />
    <link href="/admin/css/jquery-ui.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <section id="container" >
        <!--header start-->
        <?php include "../include/admin_head.php"; ?>
        <!--header end-->

        <!--sidebar start-->
        <?php include "../include/admin_sidebar.php"; ?>
        <!--sidebar end-->

    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
      <?php
    		$query = "SELECT * FROM code WHERE 1 ORDER BY num DESC";
    		$result = mysqli_query($connect, $query);
    		$total = mysqli_num_rows($result);
       ?>

        <!-- info start -->
        <div class="row">
              <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading">
                사용방법
              </header>
              <ul class="info-body">
                <li><i class="fa fa-info-circle"></i> 쇼핑몰의 HELP 페이지에 생성됩니다.</li>
                <li><i class="fa fa-info-circle"></i> 생성한 순서대로 보여지므로 공지사항 게시판을 먼저 생성하세요.</li>
                <li><i class="fa fa-info-circle"></i> 공지사항 게시판의 코드는 반드시 <strong>notice</strong>로 해야합니다.</li>
                <li><i class="fa fa-info-circle"></i> 코드명은 영문으로 입력하세요.</li>
                <li><i class="fa fa-info-circle"></i> 비밀번호는 각 게시판에 관리자권한으로 접속할 때 필요합니다.</li>

              </ul>
            </section>
          </div>
        </div>
        <!-- info end -->


        <!-- bbs list start -->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading table-head">
                  게시판 목록
                </header>
                <div class="panel-body">
                  <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>순서</th>
                        <th>코드명</th>
                        <th>게시판명</th>
                        <th>게시물 수</th>
                        <th>비밀번호</th>
                        <th>쓰기권한</th>
                        <th>삭제</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
            			    $scale=10;

            				if ($page == ''){
                  				$page=1;
                			}

                			$cpage = intval($page);
                			$totalpage = intval($total/$scale);

            				if ($totalpage*$scale != $total)
                   				$totalpage = $totalpage + 1;

                			if ($cpage ==1) {
                  				$cline = 0 ;
                			} else {
                  				$cline = ($cpage*$scale) - $scale ;
            				}

            				$limit=$cline+$scale;

            	 			if ($limit >= $total)
                   				$limit=$total;

                			$scale1 = $limit - $cline;

            			if($total == 0) {
                			echo"<tr>\n
                			           <td colspan=\"4\">등록된 게시판이 없습니다.</td>\n
                			         </tr>\n";
                		} else {
                 			for($i=0; $rows = mysqli_fetch_array($result); $i++) {
            					  $board = 'bbs_'.$rows['code'];
                				$query2 = "SELECT * FROM $board WHERE 1 ";
                				$result2 = mysqli_query($connect, $query2);
                				$total2 = mysqli_num_rows($result2);

            					  $bunho = $total - ( $i + $cline);

                    ?>
                    <tr>
                      <td><?=$bunho?></td>
                      <td><a href="../../bbs/list.php?code=<?=$rows['code']?>" target="_blank"><?=$rows['code']?></a></td>
                      <td>
                        <form class="form-inline" role="form" name="bbs_name<?=$i?>" action="update_bbs.php" method="post">
                        <input type="hidden" name="mode" value="modify" />
                        <input type="hidden" name="num" value="<?=$rows['num']?>" />                      
                        <input type="text" class="form-control" name="title" value="<?=$rows['bbs_name']?>" />
                        &nbsp;
                        <button class="btn btn-warning" onclick="document.bbs_name<?=$i?>.submit();" />변경</button>
                        </form>                        
                      </td>
                      <td><?=$total2?></td>
                      <td>
                        <form class="form-inline" role="form" name="pass<?=$i?>" action="update_bbs.php" method="post">
                        <input type="hidden" name="mode" value="pw" />
                        <input type="hidden" name="num" value="<?=$rows['num']?>" />                        
                        <input type="password" class="form-control" name="passwd" value="">
                        &nbsp;
                        <button class="btn btn-warning" onclick="document.pass<?=$i?>.submit();" />변경</button>
                        </form>                          
                      </td>
                      <td>
                      <?php
            				switch ($rows['readonly']) {
            					case "Y" :
            						echo "관리자";
            						break;
            					case "N" :
            						echo "관리자/회원";
            						break;
            				}
            			?>
                      <form class="form-inline" role="form" name="del" action="update_bbs.php" method="post" onsubmit="javascript:return confirm('정말 삭제하시겠습니까?');">
                        <input type="hidden" name="mode" value="del" />
                        <input type="hidden" name="num" value="<?=$rows['num']?>" />
                        <input type="hidden" name="code" value="<?=$rows['code']?>" />
                      <td>
                        <button class="btn btn-danger" onclick="return confirm('정말 삭제하시겠습니까?');" /><i class="fa fa-trash-o"></i></button>
                      </td>
                      </form>
                    </tr>
                    <?php
                        }
                     }
                        ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </section>
          </div>
        </div>
        <!-- bbs list end -->

        <!-- bbs making start -->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading table-head">
                  신규 게시판 생성
                </header>
                <div class="panel-body">
                  <form class="form-horizontal" role="form" name="ins" method="post" action="update_bbs.php">
                    <input type="hidden" name="mode" value="ins" />

                      <div class="form-group">
                          <label for="id" class="col-lg-2 col-sm-2 control-label">코드명 :</label>
                          <div class="col-sm-3">
                              <input type="text" class="form-control" name="code" id="code">
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="id" class="col-lg-2 col-sm-2 control-label">게시판명 :</label>
                          <div class="col-sm-3">
                              <input type="text" class="form-control" name="title" id="title">
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="id" class="col-lg-2 col-sm-2 control-label">쓰기권한 :</label>
                          <div class="col-sm-3">
                            <input type="radio" name="readonly" id="readonly" value="N" checked="checked" />관리자/회원
                            <input type="radio" name="readonly" id="readonly" value="Y" />관리자 전용
                          </div>
                      </div>
                      <div class="text-center">
                        <button class="btn btn-success" onclick="javascript:document.ins.submit();">만들기</button>
                      </div>

                  </form>
                </div>
            </section>
          </div>
        </div>
        <!-- bbs list end -->                  

         </section>
      </section>
      <!--main content end-->

      <!--footer start-->
    <?php include "../include/admin_footer.php"; ?>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="/js/jquery-2.1.1.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="/admin/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="/admin/js/jquery.scrollTo.min.js"></script>
    <script src="/admin/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="/admin/js/jquery.sparkline.js" type="text/javascript"></script>
    <!-- // <script src="jquery-easy-pie-chart/jquery.easy-pie-chart.js"></script> -->
    <script src="/admin/js/owl.carousel.js" ></script>
    <script src="/admin/js/jquery.customSelect.min.js" ></script>
    <script src="/admin/js/respond.min.js" ></script>

    <!--right slidebar-->
    <script src="/admin/js/slidebars.min.js"></script>

    <!--common script for all pages-->
    <script src="/admin/js/common-scripts.js"></script>

    <!--script for this page-->
    <script src="/admin/js/sparkline-chart.js"></script>
    <!-- // <script src="js/easy-pie-chart.js"></script> -->
    <script src="/admin/js/count.js"></script>

    <!-- custom scripts -->
    <script src="/js/global.js" ></script>
    <script src="/admin/js/admin.js" ></script>
    <script src="/admin/js/jquery-ui.min.js"></script>
    <script src="/admin/js/jq_datepicker.js" ></script>

    <script>

      //custom select box

      $(function(){
        $('select.styled').customSelect();
      });

    </script>

  </body>
</html>
