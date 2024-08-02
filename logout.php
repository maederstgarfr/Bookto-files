<?php
include 'config.php';

session_start();
session_unset();
swssion_destroy();


header('location:login.php');


?>