<?php
// $arr_browser = array ("iPhone","iPod","IEMobile","Mobile","lgtelecom","PPC");

// for($indexi = 0 ; $indexi < count($arr_browser) ; $indexi++) {
//     if(strpos($_SERVER['HTTP_USER_AGENT'],$arr_browser[$indexi]) == true){
//       // 모바일 브라우저라면  모바일 URL로 이동
//        header("Location: http://www.$_SERVER[SERVER_NAME]/m/index.php");
//        exit;
//      }
// }

header("location:http://$_SERVER[SERVER_NAME]/web/");
exit;
