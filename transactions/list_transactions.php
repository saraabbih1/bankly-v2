<?php
session_start();
require_once '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$stmt = $conn->query("SELECT * FROM transactions ORDER BY transaction_date DESC");
$transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Historique des transactions</title>
    <link rel="stylesheet" href="../assets/css/clients.css">
</head>
<body>
<?php include '../includes/header.php'; ?>
<h2>Historique des transactions</h2>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>ID Compte</th>
        <th>Type</th>
        <th>Montant</th>
        <th>Date</th>
    </tr>

    <?php foreach ($transactions as $t): ?>
    <tr>
        <td><?= $t['id'] ?></td>
        <td><?= $t['account_id'] ?></td>
        <td><?= htmlspecialchars($t['transaction_type']) ?></td>
        <td><?= number_format($t['amount'], 2, ',', ' ') ?> MAD</td>
        <td><?= date('d/m/Y H:i', strtotime($t['transaction_date'])) ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include '../includes/footer.php'; ?>
</body>
</html>
