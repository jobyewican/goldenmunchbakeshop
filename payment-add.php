<?php
require_once 'code/session-start.php';
require_once 'code/database-connect.php';

$title = 'Add Payment';
require_once 'template/header.php';

$orderId = $_GET['orderid'] ?? 0; // Get order ID from the URL

// You may want to add some validation here to check if the order ID is valid.
?>

<div class="container mt-4">
    <h1 class="text-center my-5">Add Payment</h1>

    <form action="code/payment-add.php" method="POST">
        <input type="hidden" name="orderid" value="<?= $orderId; ?>">

        <div class="mb-3">
            <label for="method" class="form-label">Payment Method:</label>
            <select class="form-control" id="method" name="method" required>
                <option value="">-Select Method-</option>
                <option value="cash">Cash</option>
                <option value="gcash">Gcash - 09157323793</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">Amount:</label>
            <input type="number" class="form-control" id="amount" name="amount" min="0" step="0.01" required>
        </div>

        <div class="mb-3">
            <label for="additionalnote" class="form-label">Notes (Put reference number here for Gcash payments):</label>
            <textarea class="form-control" id="additionalnote" name="additionalnote" rows="3" placeholder="Put reference number here for Gcash payments"></textarea>
        </div>

        <button type="submit" class="btn btn-success">Submit Payment</button>
    </form>
</div>

<?php 
    require_once 'template/footer.php'; 
?>
