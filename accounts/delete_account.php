<?php
session_start();
require_once '../config/config.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}


if (!isset($_GET['id'])) {
    header("Location: list_accounts.php");
    exit;
}

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM accounts WHERE id = ?");
$stmt->execute([$id]);

header("Location: list_accounts.php");
exit;
