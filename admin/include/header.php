<?php

include_once '../include/admin_auth.php';
include_once '../../util/util.php';

$info_query = "SELECT * FROM admin_setup";
mysqli_query($connect, 'set names utf8');

$info_res = mysqli_query($connect, $info_query);
$info     = mysqli_fetch_array($info_res);

?>
<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keyword" content="<?php echo $info['keywords']; ?>">
    <meta name="description" content="<?php echo $info['description']; ?>">
    <meta name="author" content="nwlab.co.kr">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="shortcut icon" href="/admin/img/favicon.png">
    <title><?php echo $info['company_name']; ?> :: 운영업체 관리자 홈</title>
    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/admin/css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="/css/font-awesome.min.css" rel="stylesheet" />
    <link href="/admin/assets/morris.js-0.4.3/morris.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="/admin/css/style.css" rel="stylesheet">
    <link href="/admin/css/style-responsive.css" rel="stylesheet" />
    <link href="/admin/css/jquery-ui.min.css" rel="stylesheet">
    <link href="/css/myshop.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
    <script src="/admin/js/html5shiv.js"></script>
    <script src="/admin/js/respond.min.js"></script>
    <![endif]-->
    <script src="/admin/ckeditor/ckeditor.js" charset="utf-8"></script>

  </head>