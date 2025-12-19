<?php
session_start();
require_once '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$msg = "";

   
if (isset($_POST['submit'])) {
    $account_id = $_POST['account_id'];
    $type = $_POST['type']; // deposit ou withdraw
    $amount = $_POST['amount'];

     
    $stmt = $conn->prepare("SELECT balance FROM accounts WHERE id = ?");
    $stmt->execute([$account_id]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($account) {
        $balance = $account['balance'];

        if ($type == 'withdraw' && $amount > $balance) {
            $msg = " Solde insuffisant";
        } else {
              
            if ($type == 'deposit') {
                $new_balance = $balance + $amount;
            } else {
                $new_balance = $balance - $amount;
            }

            $stmt = $conn->prepare("UPDATE accounts SET balance = ? WHERE id = ?");
            $stmt->execute([$new_balance, $account_id]);

              
            $stmt = $conn->prepare("
                INSERT INTO transactions (account_id, type, amount)
                VALUES (?, ?, ?)
            ");
            $stmt->execute([$account_id, $type, $amount]);

            $msg = " Transaction effectuée avec succès";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Transaction</title>
</head>
<body>

<h2>Dépôt / Retrait</h2>

<?php if ($msg): ?>
    <p><?= $msg ?></p>
<?php endif; ?>

<form method="POST">
    <label>ID Compte</label><br>
    <input type="number" name="account_id" required><br><br>

    <label>Type</label><br>
    <select name="type">
        <option value="deposit">Dépôt</option>
        <option value="withdraw">Retrait</option>
    </select><br><br>

    <label>Montant</label><br>
    <input type="number" name="amount" required><br><br>

    <button type="submit" name="submit">Valider</button>
</form>

</body>
</html>
