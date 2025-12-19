<?php
session_start();
require_once '../config/config.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}


$stmt = $conn->query("
    SELECT accounts.id, accounts.account_number, accounts.balance,
           clients.full_name
    FROM accounts
    JOIN clients ON accounts.client_id = clients.id
    ORDER BY accounts.id DESC
");

$accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des comptes</title>
    <link rel="stylesheet" href="../assets/css/listclient.css">
</head>
<body>

<?php include '../includes/header.php'; ?>

<div class="container">
    <h2>Liste des comptes</h2>

    <a href="add_account.php" class="btn-add">+ Ajouter compte</a>

    <table class="clients-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Numéro de compte</th>
                <th>Solde (MAD)</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>

        <?php foreach ($accounts as $a): ?>
            <tr>
                <td><?= $a['id'] ?></td>
                <td><?= $a['full_name'] ?></td>
                <td><?= $a['account_number'] ?></td>
                <td><?= number_format($a['balance'], 2) ?></td>
                <td class="actions">
                    <a href="edit_account.php?id=<?= $a['id'] ?>">modifier</a>
                    <a href="delete_account.php?id=<?= $a['id'] ?>"
                       onclick="return confirm('Supprimer ce compte ?')">
                       supprimer
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>

</body>
</html>
