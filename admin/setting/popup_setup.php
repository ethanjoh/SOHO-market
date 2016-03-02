<?php include_once '../include/header.php';?>

  <body>
    <section id="container" >
        <!--header start-->
        <?php include_once "../include/admin_head.php";?>
        <!--header end-->

        <!--sidebar start-->
        <?php include_once "../include/admin_sidebar.php";?>
        <!--sidebar end-->

    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
<?php

$qry    = "SELECT * FROM popup LIMIT 1";
$result = mysqli_query($connect, $qry);
$row    = mysqli_fetch_array($result);
mysqli_free_result($result);
?>

        <!-- info start-->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading">
                사용방법
              </header>
              <ul class="info-body">
                <li><i class="fa fa-info-circle"></i> 사이트 메인화면 팝업공지창 관리화면입니다.</li>
                <li><i class="fa fa-info-circle"></i> 쇼핑몰 메인화면에 공지사항을 띄우려면 "공지사항 보이기"에 체크 후 등록하시기 바랍니다.</li>
                <li><i class="fa fa-info-circle"></i> 줄바꿈 시에 줄 간격을 줄이려면 SHIFT+ENTER 키를 누르세요.</li>
              </ul>
            </section>
          </div>
        </div>

        <!-- popoup start -->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading table-head">
                  팝업 공지
                </header>
                <div class="panel-body">
                <div class="table-responsive">
                  <form name="form1" method="post" enctype="multipart/form-data" action="popup_setup_ok.php">
                  <table class="table">
                    <tbody>
                      <tr>
                        <td>
                          <input type="checkbox" name="chk" value="<?php echo $row['chk'] == 'Y' ? "Y" : "N"; ?>" <?php echo $row['chk'] == 'Y' ? "checked" : ""; ?>  />
                          팝업 공지사항 보이기
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <textarea name="contents" class="form-control" id="contents"><?php echo stripslashes($row['contents']); ?></textarea>
                          <script type="text/javascript">
                              CKEDITOR.replace( 'contents' );
                          </script>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </section>
          </div>
        </div>

        <div class="row text-center">
          <div class="col-sm-12">
            <button class="btn btn-success" onclick="send_popup();">저장</button>
            <a type="button" class="btn btn-default" href="../main/main.php">취소</a>
          </div>
        </div>
                  </form>

          </section>
      </section>
      <!--main content end-->

      <!--footer start-->
    <?php include_once "../include/admin_footer.php";?>
      <!--footer end-->

  </body>
</html>

