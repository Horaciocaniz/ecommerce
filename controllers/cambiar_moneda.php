<?php
session_start();
if (isset($_POST['moneda'])) {
    $_SESSION['moneda'] = $_POST['moneda'];
}
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
