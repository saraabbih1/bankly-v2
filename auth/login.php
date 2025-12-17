<?php
session_start();
require '../config/config.php';

$error = '';

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);


    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
     
        if ($password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];

            header("Location: ../dashboard.php");
            exit;
        } else {
            $error = "Mot de passe incorrect.";
        }
    } else {
        $error = "Email non trouvé.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Login - Bankly V2</title>
    <link rel="stylesheet" href="../assets/css/login.css">
</head>
<body>
    <h2 class="connexion">Connexion</h2> 
    
    <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="POST" >
        <label>Email:</label>
        <input type="email" name="email" required><br><br>
        <label>Mot de passe:</label>
        <input type="password" name="password" required><br><br>
        <button type="submit" name="login">Se connecter</button>
    </form>
</body>
</html>
