<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $account_number = $_POST['account_number'];
    $account_holder = $_POST['account_holder'];

    $stmt = $pdo->prepare('INSERT INTO accounts (account_number, account_holder) VALUES (:account_number, :account_holder)');
    $stmt->execute(['account_number' => $account_number, 'account_holder' => $account_holder]);
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Account</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Add Account</h2>
        <form method="POST">
            <div class="form-group">
                <label for="account_number">Account Number</label>
                <input type="text" class="form-control" id="account_number" name="account_number" required>
            </div>
            <div class="form-group">
                <label for="account_holder">Account Holder</label>
                <input type="text" class="form-control" id="account_holder" name="account_holder" required>
            </div>
            <button type="submit" class="btn btn-success">Add Account</button>
        </form>
    </div>
</body>
</html>