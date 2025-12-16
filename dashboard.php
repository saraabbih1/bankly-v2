<?php
session_start();
require_once 'config/config.php';

// Vérifier si l'utilisateur est connecté
if(!isset($_SESSION['user_id'])){
    header("Location: auth/login.php");
    exit;
}

// Récupérer les statistiques

// 1. Nombre total de clients
$stmt = $conn->query("SELECT COUNT(*) as total_clients FROM clients");
$totalClients = $stmt->fetch(PDO::FETCH_ASSOC)['total_clients'];

// 2. Nombre total de comptes
$stmt = $conn->query("SELECT COUNT(*) as total_accounts FROM accounts");
$totalAccounts = $stmt->fetch(PDO::FETCH_ASSOC)['total_accounts'];

// 3. Total des transactions du jour
$today = date('Y-m-d');
$stmt = $conn->prepare("SELECT SUM(amount) as total_transactions FROM transactions WHERE DATE(transaction_date) = :today");
$stmt->bindParam(':today', $today);
$stmt->execute();
$totalTransactions = $stmt->fetch(PDO::FETCH_ASSOC)['total_transactions'];
$totalTransactions = $totalTransactions ? $totalTransactions : 0; // éviter null
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Bankly V2</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container">
        <h1>Bienvenue, <?php echo $_SESSION['full_name']; ?>!</h1>
        <h2>Tableau de bord</h2>

        <div class="dashboard">
            <a href="clients/list_clients.php">
                <div class="card">
                    <h3>Total Clients</h3>
                    <p><?php echo $totalClients; ?></p>
                </div>
            </a>

            <a href="accounts/list_accounts.php">
                <div class="card">
                    <h3>Total Comptes</h3>
                    <p><?php echo $totalAccounts; ?></p>
                </div>
            </a>

            <a href="transactions/list_transactions.php">
                <div class="card">
                    <h3>Total Transactions Aujourd'hui</h3>
                    <p><?php echo number_format($totalTransactions, 2); ?> MAD</p>
                </div>
            </a>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
