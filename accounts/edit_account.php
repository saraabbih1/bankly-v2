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

$stmt = $conn->prepare("
    SELECT accounts.*, clients.full_name
    FROM accounts
    JOIN clients ON accounts.client_id = clients.id
    WHERE accounts.id = ?
");
$stmt->execute([$id]);
$account = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$account) {
    header("Location: list_accounts.php");
    exit;
}


if (isset($_POST['update'])) {
    $account_number = $_POST['account_number'];
    $balance = $_POST['balance'];

    $stmt = $conn->prepare("
        UPDATE accounts
        SET account_number = ?, balance = ?
        WHERE id = ?
    ");
    $stmt->execute([$account_number, $balance, $id]);

    header("Location: list_accounts.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier compte</title>
    <link rel="stylesheet" href="../assets/css/clients.css">
</head>
<body>

<?php include '../includes/header.php'; ?>

<div class="container">
    <h2>Modifier le compte</h2>

    <form method="POST">
        <label>Client</label>
        <input type="text" value="<?= $account['full_name'] ?>" disabled>

        <label>Numéro de compte</label>
        <input type="text" name="account_number"
               value="<?= $account['account_number'] ?>" required>

        <label>Solde (MAD)</label>
        <input type="number" step="0.01" name="balance"
               value="<?= $account['balance'] ?>" required>

        <button type="submit" name="update">Mettre à jour</button>
        <a href="list_accounts.php" class="btn-cancel">Annuler</a>
    </form>
</div>

<?php include '../includes/footer.php'; ?>

</body>
</html>
