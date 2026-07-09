<?php

session_start();
session_destroy();

SetCookie("p_sid", "", time(), '/');

header('Location: https://' . $_SERVER['SERVER_NAME'] . '/shop/');
