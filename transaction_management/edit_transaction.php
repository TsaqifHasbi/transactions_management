<?php
include 'includes/db.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}
$id = $_GET['id'];


$stmt = $pdo->query('SELECT * FROM accounts');
$accounts = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amount = $_POST['amount'];
    $transaction_date = $_POST['transaction_date'];
    $id_account = $_POST['id_account'];

    $stmt = $pdo->prepare('UPDATE transactions SET amount = :amount, transaction_date = :transaction_date, id_account = :id_account WHERE id = :id');
    $stmt->execute([
        'amount' => $amount,
        'transaction_date' => $transaction_date,
        'id_account' => $id_account,
        'id' => $id
    ]);

    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare('SELECT * FROM transactions WHERE id = :id');
$stmt->execute(['id' => $id]);
$transaction = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaction</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Transaction</h2>
        <form method="POST">
            <div class="form-group">
                <label for="amount">Amount</label>
                <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="<?= $transaction['amount'] ?>" required>
            </div>
            <div class="form-group">
                <label for="transaction_date">Transaction Date</label>
                <input type="date" class="form-control" id="transaction_date" name="transaction_date" value="<?= $transaction['transaction_date'] ?>" required>
            </div>
            <div class="form-group">
                <label for="id_account">Account</label>
                <select class="form-control" id="id_account" name="id_account" required>
                    <option value="">Select Account</option>
                    <?php foreach ($accounts as $account): ?>
                        <option value="<?= $account['id'] ?>" <?= $account['id'] == $transaction['id_account'] ? 'selected' : '' ?>>
                            <?= $account['account_number'] ?> - <?= $account['account_holder'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-warning">Update Transaction</button>
        </form>
    </div>
</body>
</html>