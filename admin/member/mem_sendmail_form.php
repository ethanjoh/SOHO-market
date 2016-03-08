<?php include_once '../include/header.php';?>

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

$num     = set_var($_POST['num']);
$tot_cnt = sizeof($num);

for ($i = 0; $i < sizeof($num); $i++) {
    echo '<input type=hidden name="num[]" value="' . $num[$i] . '">' . "\r\n";
}
?>
            <!-- send mail start-->
            <div class="row">
              <div class="col-sm-12">
                <section class="panel">
                  <header class="panel-heading table-head">
                      메일 발송 (발송할 회원 수 : <?php echo $tot_cnt; ?>)
                  </header>
                  <div class="panel-body">
                  <div class="table-responsive">

                    <table class="table">
                      <tbody>
                        <tr>
                          <th>보내는 사람</th>
                          <td><input type='text' size='100' name="sender" value="<?php echo $info['company_name']; ?>">
                          </td>
                        </tr>
                        <tr>
                          <th>보내는 Email</th>
                          <td><input type='text' size='100' name="sender_email" value="<?php echo $info['email']; ?>">
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
                            <textarea name="contents" class="form-control" id="contents"></textarea>
                            <script type="text/javascript">
                                CKEDITOR.replace( 'contents' );
                            </script>
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
                                  <a class="btn btn-success" href="#" onclick="form_check();">메일 발송</a>
                                  <a class="btn btn-default" href="#" onclick="document.post.reset();">다시 작성</a>
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
    <?php include_once "../include/admin_footer.php";?>
      <!--footer end-->

<!--     <script src="js/HuskyEZCreator.js" charset="utf-8"></script>

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
    </script> -->
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
      // oEditors.getById["contents"].exec("UPDATE_IR_FIELD", []);
      form.submit();
    }
    //-->
    </script>
  </body>
</html>
