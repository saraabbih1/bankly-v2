<?php
session_start();
require_once '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM clients WHERE id = ?");
$stmt->execute([$id]);
$client = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['update'])) {
    $stmt = $conn->prepare("
        UPDATE clients 
        SET full_name=?, email=?, cin=?, phone=?, address=?
        WHERE id=?
    ");
    $stmt->execute([
        $_POST['full_name'],
        $_POST['email'],
        $_POST['cin'],
        $_POST['phone'],
        $_POST['address'],
        $id
    ]);

    header("Location: list_clients.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier client</title>
    <link rel="stylesheet" href="../assets/css/clients.css">

</head>
<body>

<?php include '../includes/header.php'; ?>

<div class="container">
    <h2>Modifier client</h2>

    <form method="POST">
        <input type="text" name="full_name" value="<?= $client['full_name'] ?>" required>
        <input type="email" name="email" value="<?= $client['email'] ?>">
        <input type="text" name="cin" value="<?= $client['cin'] ?>">
        <input type="text" name="phone" value="<?= $client['phone'] ?>">
        <textarea name="address"><?= $client['address'] ?></textarea>

        <button type="submit" name="update">Mettre à jour</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>
