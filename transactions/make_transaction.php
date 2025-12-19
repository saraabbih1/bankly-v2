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
    $type = $_POST['transaction_type']; // توحيد الاسم
    $amount = (float)$_POST['amount'];

    $stmt = $conn->prepare("SELECT balance FROM accounts WHERE id = ?");
    $stmt->execute([$account_id]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($account) {
        $balance = (float)$account['balance'];

        if ($type == 'withdraw' && $amount > $balance) {
            $msg = "Solde insuffisant";
        } elseif ($amount <= 0) {
            $msg = "Montant invalide";
        } else {
            if ($type == 'deposit') {
                $new_balance = $balance + $amount;
            } else {
                $new_balance = $balance - $amount;
            }

            // Mise à jour du solde
            $stmt = $conn->prepare("UPDATE accounts SET balance = ? WHERE id = ?");
            $stmt->execute([$new_balance, $account_id]);

            // Insertion dans transactions
            $stmt = $conn->prepare("INSERT INTO transactions (account_id, transaction_type, amount) VALUES (?, ?, ?)");
            $stmt->execute([$account_id, $type, $amount]);

            $msg = "Transaction effectuée avec succès";
        }
    } else {
        $msg = "Compte introuvable";
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
    <p><?= htmlspecialchars($msg) ?></p>
<?php endif; ?>

<form method="POST">
    <label>Compte:</label><br>
    <select name="account_id" required>
        <?php
        $stmt = $conn->query("SELECT id, balance FROM accounts");
        while($a = $stmt->fetch(PDO::FETCH_ASSOC)){
            echo "<option value='{$a['id']}'>Compte {$a['id']} - Solde: {$a['balance']} MAD</option>";
        }
        ?>
    </select><br><br>

    <label>Type de transaction:</label><br>
    <select name="transaction_type" required>
        <option value="deposit">Dépôt</option>
        <option value="withdraw">Retrait</option>
    </select><br><br>

    <label>Montant:</label><br>
    <input type="number" name="amount" step="0.01" min="0.01" required><br><br>

    <button type="submit" name="submit">Valider</button>
</form>

</body>
</html>
