<?php
if(!isset($_SESSION)) session_start();
if(!isset($_SESSION['user_id'])){
    header("Location: auth/login.php");
    exit;
}
?>

<header>
    <nav>
        <ul class="nav-menu">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="clients/list_clients.php">Clients</a></li>
            <li><a href="accounts/list_accounts.php">Comptes</a></li>
            <li><a href="transactions/list_transactions.php">Transactions</a></li>
            <li><a href="auth/logout.php">Déconnexion</a></li>
        </ul>
    </nav>
</header>
