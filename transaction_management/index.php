<?php
include 'includes/db.php';

try {
    $stmt = $pdo->query('
        SELECT t.id, t.amount, t.transaction_date, a.account_number, a.account_holder
        FROM transactions t
        LEFT JOIN accounts a ON t.id_account = a.id
    ');
    $transactions = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error fetching transactions: " . $e->getMessage());
}

$stmt = $pdo->query('SELECT * FROM accounts');
$accounts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction and Account Management</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Transaction List</h2>
        <a href="add_transaction.php" class="btn btn-primary mb-3">Add Transaction</a>
        <table id="transactionsTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Amount</th>
                    <th>Transaction Date</th>
                    <th>Account Number</th>
                    <th>Account Holder</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $transaction): ?>
                <tr>
                    <td><?= $transaction['id'] ?></td>
                    <td><?= $transaction['amount'] ?></td>
                    <td><?= $transaction['transaction_date'] ?></td>
                    <td><?= $transaction['account_number'] ?? 'N/A' ?></td>
                    <td><?= $transaction['account_holder'] ?? 'N/A' ?></td>
                    <td>
                        <a href="edit_transaction.php?id=<?= $transaction['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_transaction.php?id=<?= $transaction['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h2>Account List</h2>
        <a href="add_account.php" class="btn btn-success mb-3">Add Account</a>
        <table id="accountsTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Account Number</th>
                    <th>Account Holder</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($accounts as $account): ?>
                <tr>
                    <td><?= $account['id'] ?></td>
                    <td><?= $account['account_number'] ?></td>
                    <td><?= $account['account_holder'] ?></td>
                    <td>
                        <a href="edit_account.php?id=<?= $account['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_account.php?id=<?= $account['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#transactionsTable').DataTable();
            $('#accountsTable').DataTable();
        });
    </script>
</body>
</html>