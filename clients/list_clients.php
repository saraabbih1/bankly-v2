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
    <link rel="stylesheet" href="../assets/css/listclient.css">

</head>
<body>

<?php include '../includes/header.php'; ?>

<div class="container">
    <h2>Liste des clients</h2>
    <a href="add_client.php" class="btn">+ Ajouter client</a>

    <table>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Email</th>
            <th>CIN</th>
            <th>Téléphone</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($clients as $c): ?>
        <tr>
            <td><?= $c['id'] ?></td>
            <td><?= $c['full_name'] ?></td>
            <td><?= $c['email'] ?></td>
            <td><?= $c['cin'] ?></td>
            <td><?= $c['phone'] ?></td>
            <td>
                <a href="edit_client.php?id=<?= $c['id'] ?>">modifier</a>
                <a href="delete_client.php?id=<?= $c['id'] ?>" onclick="return confirm('Supprimer ce client ?')">supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
</body>
</html>
