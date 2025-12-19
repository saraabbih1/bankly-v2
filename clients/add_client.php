<?php
session_start();
require_once '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$stmt = $conn->query("SELECT * FROM clients ORDER BY id DESC");
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Liste des clients</title>
    <link rel="stylesheet" href="../assets/css/clients.css">
</head>
<body>

<?php include '../includes/header.php'; ?>

<div class="container">
    <h2>Liste des clients</h2>
    <a href="add_client.php" class="btn-add">Ajouter client</a>

    <table class="clients-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>CIN</th>
                <th>Téléphone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clients as $client): ?>
            <tr>
                <td><?= $client['id'] ?></td>
                <td><?= $client['full_name'] ?></td>
                <td><?= $client['email'] ?></td>
                <td><?= $client['cin'] ?></td>
                <td><?= $client['phone'] ?></td>
                <td class="actions">
                    <a href="edit_client.php?id=<?= $client['id'] ?>">modifie</a>
                    <a href="delete_client.php?id=<?= $client['id'] ?>"
                       onclick="return confirm('Supprimer ce client ?')">suprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>

</body>
</html>
