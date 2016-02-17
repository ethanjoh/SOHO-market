<?php

include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

//메타정보
$info_query = "SELECT * FROM admin_setup";
$info_res   = mysqli_query($connect, $info_query);
$info       = mysqli_fetch_array($info_res);

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

    <title><?=$info['company_name'];?> :: 운영업체 관리자 홈</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/admin/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="/css/font-awesome.min.css" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="/admin/css/style.css" rel="stylesheet">
    <link href="/admin/css/style-responsive.css" rel="stylesheet" />
    <link href="css/default.css" rel="stylesheet" type="text/css" />


    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->

    <script language="JavaScript">
    <!--
    function form_check() {
      var form = document.mail;
      if(!form.sender.value){
        alert('보내는 사람 이름을 입력하지 않았습니다.');
        form.sender.focus();
        return;
      }

      if(!form.sender_email.value){
        alert('보내는 사람 이메일을 입력하지 않았습니다.');
        form.sender_email.focus();
        return;
      }

      if(!form.subject.value){
        alert('메일 제목을 입력하지 않았습니다.');
        form.subject.focus();
        return;
      }

    /*
      if(!form.contents.value){
        alert('발송 내용을 입력하지 않았습니다.');
        form.contents.focus();
        return;
      }
    */
      oEditors.getById["contents"].exec("UPDATE_IR_FIELD", []);
      form.submit();
    }
    //-->
    </script>
  </head>

  <body>
    <section id="container" >
        <!--header start-->
        <?php include "../include/admin_head.php";?>
        <!--header end-->

        <!--sidebar start-->
        <?php include "../include/admin_sidebar.php";?>
        <!--sidebar end-->


      <!--main content start-->
      <section id="main-content">
        <section class="wrapper">

          <!-- info start-->
          <div class="row">
            <div class="col-sm-12">
              <section class="panel">
                <header class="panel-heading">
                  사용방법
                </header>
                <ul class="info-body">
                  <li><i class="fa fa-info-circle"></i> 다음 화면이 나올 때까지 절대 브라우저를 닫지 마세요.</li>
                  <li><i class="fa fa-info-circle"></i> 메일을 보내는 동안 화면이 멈춰있는 것처럼 보일 수 있습니다.</li>
                  <li><i class="fa fa-info-circle"></i> 수신자가 많을 수록 시간이 오래 걸립니다.</li>
                </ul>
              </section>
            </div>
          </div>
          <!-- info end -->

          <form class="form-horizontal" role="form" method="post" name="mail" action="mem_sendmail_ok.php"  enctype="multipart/form-data">
            <?php
$tot_cnt = sizeof($num);

for ($i = 0; $i < sizeof($num); $i++) {
    ?>
            <input type=hidden name='num[]' value='<?=$num[$i];?>'>
            <?php
}
?>
            <!-- send mail start-->
            <div class="row">
              <div class="col-sm-12">
                <section class="panel">
                  <header class="panel-heading table-head">
                      메일 발송 (발송할 회원 수 : <?=$tot_cnt;?>)
                  </header>
                  <div class="panel-body">
                  <div class="table-responsive">

                    <table class="table">
                      <tbody>
                        <tr>
                          <th>보내는 사람</th>
                          <td><input type='text' size='100' name="sender" value="<?=$info['company_name'];?>">
                          </td>
                        </tr>
                        <tr>
                          <th>보내는 Email</th>
                          <td><input type='text' size='100' name="sender_email" value="sales@smedics.co.kr">
                          </td>
                        </tr>
                        <tr>
                          <th>메일 제목</th>
                          <td><input type='text' size='100' name="subject" >
                          </td>
                        </tr>
                        <tr>
                          <th>첨부 이미지</th>
                          <td><input type='file' size='100' name="upfile" /></td>
                        </tr>
                        <tr>
                          <th>발송 내용</th>
                          <td>
                            <textarea name="contents" id="contents" style="width:100%; height:350px"></textarea>
                            <!--<textarea name="contents" cols="60" rows="8" ></textarea>-->
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                    <!-- buttons start -->
                    <div class="row">
                      <div class="col-sm-12">
                      <div class="table-responsive">
                        <table class="table">
                          <tbody>
                            <tr>
                              <td class="text-center">
                                  <a class="btn btn-success" href="#" onclick="javascript:form_check();">메일 발송</a>
                                  <a class="btn btn-default" href="#" onclick="javascript:document.post.reset();">다시 작성</a>
                                  <a class="btn btn-primary" href="top_member_list.php">전체 목록</a>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                      </div>
                    </div>
                    <!-- buttons end -->

                  </form>
                  </div>
              </section>
            </div>
          </div>
          <!-- send mail end -->

        </section>
    </section>
    <!--main content end-->

     <!--footer start-->
    <?php include "../include/admin_footer.php";?>
      <!--footer end-->
  </section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="/js/vendor/jquery-2.2.0.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/admin/js/jquery.dcjqaccordion.2.7.js" class="include" type="text/javascript" ></script>
    <script src="/admin/js/jquery.scrollTo.min.js"></script>
    <script src="/admin/js/jquery.nicescroll.js" type="text/javascript"></script>
    <script src="/admin/js/jquery.customSelect.min.js" ></script>
    <script src="/admin/js/respond.min.js" ></script>

    <!--common script for all pages-->
    <script src="/admin/js/common-scripts.js"></script>

    <!-- custom scripts -->
    <script src="/js/global.js" ></script>
    <script src="/admin/js/admin.js" ></script>
    <script src="js/HuskyEZCreator.js" charset="utf-8"></script>

    <script>
    var oEditors = [];
    // 마지막 옵션은 체감 속도 증진을 위해서 페이지 로딩 완료시 까지 화면 표시를 하지 않는 옵션 입니다.
    // 개발 작업시에는 이 값을 false로 설정 하세요.
    //nhn.husky.EZCreator.createInIFrame(oEditors, "contents", "SEditorSkin.html", "createSEditorInIFrame", null, false);
    nhn.husky.EZCreator.createInIFrame({
      oAppRef: oEditors,
      elPlaceHolder: "contents",
      sSkinURI: "SEditorSkin.html",
      fCreator: "createSEditorInIFrame"
    });
    </script>

  </body>
</html>
