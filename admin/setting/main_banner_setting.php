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

	$mode = set_var($_GET['mode']);
	$num  = set_var($_GET['num']);

	if ("update" == $mode) {
	    $query  = "SELECT * FROM banner WHERE num='$num' ";
	    $result = mysqli_query($connect, $query);
	    $row    = mysqli_fetch_array($result);
	    mysqli_free_result($result);
	} else {
	    $mode = "insert";
	}
?>

        <!-- setup start -->
        <div class="row">
          <div class="col-sm-12">
            <section class="panel">
              <header class="panel-heading table-head">
                  <h4>메인배너 업로드 (1920x650px)</h4>
                </header>
                <div class="panel-body">
                <form class="form-group" role="form" name="banner" action="main_banner_setting_ok.php" enctype="multipart/form-data" method="post">
                <input type="hidden" name="mode" value="<?php echo $mode; ?>">
                <input type="hidden" name="num" value="<?php echo $num; ?>">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <tbody>
                        <tr>
                          <th rowspan="2" class="wide-10">배너 1 </th>
                          <th class="wide-15"><i class="fa fa-picture-o"></i> 이미지 1</th>
                          <td>
<?php

	if ($row['m_banner1'] == "Y") {
	    echo '<img src="' . $row['m_banner1_image'] . '" alt="main banner 1" width="25%">';
	} else {
	    echo "등록된 배너가 없습니다.";
	}
?>
                            <p>
                              <input type="file" name="m_banner1_image" size="25" />
                            </p>
                          </td>
                        </tr>
                        <tr>
                          <th><i class="fa fa-link"></i> 링크 1</th>
                          <td><input type="text" class="form-control" name="m_link1" value="<?php echo $row['m_link1']; ?>" id="m_link1" size="150" /></td>
                        </tr>
                        <tr>
                          <th rowspan="2">배너 2</th>
                          <th><i class="fa fa-picture-o"></i> 이미지 2</th>
                          <td>
<?php

	if ($row['m_banner2'] == "Y") {
	    echo '<img src="' . $row['m_banner2_image'] . '" alt="main banner 2" width="25%">';
	} else {
	    echo "등록된 배너가 없습니다.";
	}
?>
                            <p>
                              <input type="file" name="m_banner2_image" size="25" />
                            </p>
                          </td>
                        </tr>
                        <tr>
                          <th><i class="fa fa-link"></i> 링크 2</th>
                          <td><input type="text" class="form-control" name="m_link2" id="m_link2" value="<?php echo $row['m_link2']; ?>" size="150" /></td>
                        </tr>
                        <tr>
                          <th rowspan="2">배너 3</th>
                          <th><i class="fa fa-picture-o"></i> 이미지 3</th>
                          <td>
<?php

	if ($row['m_banner3'] == "Y") {
	    echo '<img src="' . $row['m_banner3_image'] . '" alt="main banner 3" width="25%">';
	} else {
	    echo "등록된 배너가 없습니다.";
	}
?>
                            <p>
                              <input type="file" name="m_banner3_image" size="25" />
                            </p></td>
                        </tr>
                        <tr>
                          <th><i class="fa fa-link"></i> 링크 3</th>
                          <td><input type="text" class="form-control" name="m_link3" id="m_link3" value="<?php echo $row['m_link3']; ?>" size="150" /></td>
                        </tr>
                        <tr>
                          <th rowspan="2">배너 4</th>
                          <th><i class="fa fa-picture-o"></i> 이미지 4</th>
                          <td>
<?php

	if ($row['m_banner4'] == "Y") {
	    echo '<img src="' . $row['m_banner4_image'] . '" alt="main banner 4" width="25%">';
	} else {
	    echo "등록된 배너가 없습니다.";
	}
?>

                            <p>
                              <input type="file" name="m_banner4_image" size="25" />
                            </p></td>
                        </tr>
                        <tr>
                          <th><i class="fa fa-link"></i> 링크 4</th>
                          <td><input type="text" class="form-control" name="m_link4" id="m_link4" value="<?php echo $row['m_link4']; ?>" size="150" /></td>
                        </tr>
                        <tr>
                          <th rowspan="2">배너 5</th>
                          <th><i class="fa fa-picture-o"></i> 이미지 5</th>
                          <td>
<?php

	if ($row['m_banner5'] == "Y") {
	    echo '<img src="' . $row['m_banner5_image'] . '" alt="main banner 5" width="25%">';
	} else {
	    echo "등록된 배너가 없습니다.";
	}
?>
                            <p>
                              <input type="file" name="m_banner5_image" size="25" />
                            </p></td>
                        </tr>
                        <tr>
                          <th><i class="fa fa-link"></i> 링크 5</th>
                          <td><input type="text" class="form-control" name="m_link5" id="m_link5" value="<?php echo $row['m_link5']; ?>" size="150" /></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </section>
            </div>
          </div>
          <!-- setup end -->

          <div class="row text-center">
            <div class="col-sm-12">
              <button class="btn btn-success" onclick="javascript:document.banner.submit();">등록하기</button>
              <a type="button" class="btn btn-default" href="banner_list.php">취소</a>
            </div>
          </div>
          </form>

         </section>
      </section>
      <!--main content end-->

      <!--footer start-->
    <?php include_once '../include/admin_footer.php';?>
      <!--footer end-->


  </body>
</html>

