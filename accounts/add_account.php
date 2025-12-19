<?php
session_start();
require_once '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$msg = "";

if (isset($_POST['submit'])) {
    $client_id = $_POST['client_id'];
    $account_type = $_POST['account_type'];
    $balance = $_POST['balance'];

    $stmt = $conn->prepare("INSERT INTO accounts (client_id, account_type, balance) VALUES (?, ?, ?)");
    if ($stmt->execute([$client_id, $account_type, $balance])) {
        $msg = "Compte ajouté avec succès.";
        header("Location: list_accounts.php");
        exit;
    } else {
        $msg = "Erreur lors de l'ajout.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ajouter compte</title>
    <link rel="stylesheet" href="../assets/css/clients.css">
</head>
<body>

<?php include '../includes/header.php'; ?>

<div class="container">
    <h2>Ajouter un compte</h2>

    <?php if ($msg): ?>
        <p><?= $msg ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Client</label><br>
        <select name="client_id" required>
            <?php
            $stmt = $conn->query("SELECT id, full_name FROM clients");
            while ($client = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$client['id']}'>{$client['full_name']}</option>";
            }
            ?>
        </select><br><br>

        <label>Type de compte</label><br>
        <select name="account_type" required>
            <option value="checking">Compte courant</option>
            <option value="savings">Compte épargne</option>
        </select><br><br>

        <label>Solde initial</label><br>
        <input type="number" name="balance" step="0.01" min="0" value="0" required><br><br>

        <button type="submit" name="submit">Ajouter</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>

</body>
</html>
