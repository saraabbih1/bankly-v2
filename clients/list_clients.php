<?php

session_start();
require_once '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$stmt = $conn->query("SELECT * FROM clients ORDER BY id DESC");
$clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (isset($_POST['save'])) {
    $stmt = $conn->prepare("INSERT INTO clients (full_name, email, cin, phone) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $_POST['full_name'],
        $_POST['email'],
        $_POST['cin'],
        $_POST['phone']
    ]);
    header("Location: list_clients.php");   
    exit;
}

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
    <a href="#" class="btn-add" onclick="openForm()">+ Ajouter client</a>

<div id="addClientForm" style="display:none; border:1px solid #ccc; padding:20px; margin-top:20px;">
    <h3>Ajouter un client</h3>
    <form method="POST">
        <input type="text" name="full_name" placeholder="Nom complet" required><br><br>
        <input type="email" name="email" placeholder="Email"><br><br>
        <input type="text" name="cin" placeholder="CIN"><br><br>
        <input type="text" name="phone" placeholder="Téléphone"><br><br>
        <button type="submit" name="save">Enregistrer</button>
        <button type="button" onclick="closeForm()">Annuler</button>
    </form>
</div>

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
<script>
function openForm() {
    document.getElementById('addClientForm').style.display = 'block';
}

function closeForm() {
    document.getElementById('addClientForm').style.display = 'none';
}
</script>

</body>
</html>
