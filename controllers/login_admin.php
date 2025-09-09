<?php
session_start();
include_once('../includes/db.php');

$usuario = $_POST['usuario'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM usuarios_admin WHERE usuario = ?");
$stmt->execute([$usuario]);
$admin = $stmt->fetch();

if ($admin && password_verify($password, $admin['password'])) {
  $_SESSION['admin'] = $admin['usuario'];
  header('Location: ../views/admin/dashboard.php');
  exit;
} else {
  header('Location: ../views/admin/login.php?error=1');
  exit;
}
