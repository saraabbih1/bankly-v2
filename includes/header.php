<?php
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: /banklyv2/auth/login.php");
    exit;
}
?>

<header>
    <nav>
        <ul class="nav-menu">
            <li><a href="/banklyv2/dashboard.php">Dashboard</a></li>
            <li><a href="/banklyv2/clients/list_clients.php">Clients</a></li>
            <li><a href="/banklyv2/accounts/list_accounts.php">Comptes</a></li>
            <li><a href="/banklyv2/transactions/list_transactions.php">Transactions</a></li>
            <li><a href="/banklyv2/auth/logout.php">Déconnexion</a></li>
        </ul>
    </nav>
</header>
