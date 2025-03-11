<?php
include 'includes/db.php';

$stmt = $pdo->query('SELECT * FROM accounts');
$accounts = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amount = $_POST['amount'];
    $transaction_date = $_POST['transaction_date'];
    $id_account = $_POST['id_account'];

    $stmt = $pdo->prepare('INSERT INTO transactions (amount, transaction_date, id_account) VALUES (:amount, :transaction_date, :id_account)');
    $stmt->execute([
        'amount' => $amount,
        'transaction_date' => $transaction_date,
        'id_account' => $id_account
    ]);
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Transaction</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Add Transaction</h2>
        <form method="POST">
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
            </div>
            <div class="form-group">
                <label for="transaction_date">Transaction Date</label>
                <input type="date" class="form-control" id="transaction_date" name="transaction_date" required>
            </div>
            <div class="form-group">
                <label for="id_account">Account</label>
                <select class="form-control" id="id_account" name="id_account" required>
                    <option value="">Select Account</option>
                    <?php foreach ($accounts as $account): ?>
                        <option value="<?= $account['id'] ?>">
                            <?= $account['account_number'] ?> - <?= $account['account_holder'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Transaction</button>
        </form>
    </div>
</body>
</html>