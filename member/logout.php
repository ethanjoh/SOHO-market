<?php

session_start();
session_destroy();

SetCookie("p_sid", "", time(), '/');

header('Location: http://' . $_SERVER['SERVER_NAME'] . '');
