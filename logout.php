<?php
include 'config.php';
session_destroy();
session_unset();
session_reset();
header('location:login.php');
?>