<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("location: fel1Login.php");
    exit();
}

$referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

if ($referer && strpos($referer, 'fel1Login.php') !== false) {
    exit();
} else {
    $redirect = $referer ? $referer : 'fel1Login.php';
    header("location: $redirect");
    exit();
}
?>
