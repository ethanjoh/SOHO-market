<?php
// $arr_browser = array ("iPhone","iPod","IEMobile","Mobile","lgtelecom","PPC");

// for($indexi = 0 ; $indexi < count($arr_browser) ; $indexi++) {
//     if(strpos($_SERVER['HTTP_USER_AGENT'],$arr_browser[$indexi]) == true){
//       // 모바일 브라우저라면  모바일 URL로 이동
//        header("Location: http://www.$_SERVER[SERVER_NAME]/m/index.php");
//        exit;
//      }
// }

//header("location:https://".$_SERVER['SERVER_NAME']."/shop/");
//exit;


    if (strpos($_SERVER['HTTP_HOST'], 'www.') === false) {
        // if(!isset($_SERVER["HTTPS"])) {
            $url = "https://www." . $_SERVER['HTTP_HOST'] . "/shop/";
            header("Location: $url");
            exit();
        // }
    }else if(!isset($_SERVER["HTTPS"]) && strpos($_SERVER['HTTP_HOST'], 'www.') === false) {
        echo $_SERVER['HTTP_HOST'];
            $url = "https://www." . $_SERVER['HTTP_HOST'] . "/shop/";
            header("Location: $url");
            exit();     
        // }
   
    }else if(!isset($_SERVER["HTTPS"]) === false) {
        echo $_SERVER['HTTP_HOST'];
            $url = "https://" . $_SERVER['HTTP_HOST'] . "/shop/";
            header("Location: $url");
            exit();     
        // }
   
    }else{
        $url = "https://" . $_SERVER['HTTP_HOST'] . "/shop/";
        header("Location: $url");
        exit();  
    }
    


