<?php

    if (strpos($_SERVER['HTTP_HOST'], 'www.') === false) {
        $url = "https://www." . $_SERVER['HTTP_HOST']. "/admin/login.php";
        header("Location: $url");
        exit();
    }else{
        $url = "https://" . $_SERVER['HTTP_HOST']. "/admin/login.php";
        header("Location: $url");
        exit();        
    }
    

?>
