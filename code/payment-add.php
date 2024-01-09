<?php
require_once 'sms-send.php';
require_once 'session-start.php';
require_once 'database-connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Extract and sanitize input
    $orderId = isset($_POST['orderid']) ? intval($_POST['orderid']) : 0;
    $method = isset($_POST['method']) ? mysqli_real_escape_string($conn, trim($_POST['method'])) : '';
    $amount = isset($_POST['amount']) ? doubleval($_POST['amount']) : 0.0;
    $additionalnote = isset($_POST['additionalnote']) ? mysqli_real_escape_string($conn, trim($_POST['additionalnote'])) : '';

    // Basic validation
    if ($orderId == 0 || empty($method) || $amount <= 0) {
        // Handle error - Redirect or show an error message
        echo "<script> alert('Unauthorized action.'); window.history.back(); </script>";
    }

    // Prepare SQL statement to insert payment data
    $insertQuery = "INSERT INTO orderpayment (orderid, method, amount, additionalnote) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insertQuery);
    mysqli_stmt_bind_param($stmt, 'isds', $orderId, $method, $amount, $additionalnote);

    // Execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        // Fetch customer contact number
        $customerQuery = "SELECT contactnumber FROM `order` WHERE orderid = $orderId";
        $customerResult = mysqli_query($conn, $customerQuery);
        if ($row = mysqli_fetch_assoc($customerResult)) {
            $customerContact = $row['contactnumber'];

            // Prepare SMS message
            $smsMessage = "Golden Munch Bakeshop Order Update:\n\nPayment received: PHP " . number_format($amount, 2) . " for Order ID: $orderId. Method: $method. " . ($additionalnote ? "Note: $additionalnote" : "");

            // Send SMS notification
            sendSMS($customerContact, $smsMessage);
        }

        // Redirect to order view page or another appropriate page
        header('Location: ../order-view.php?id=' . $orderId);
        exit();
    } else {
        // Handle error - Redirect or show an error message
        echo "<script> alert('Error: ". mysqli_error($conn) ."'); window.history.back(); </script>";
    }
} else {
    // Redirect or show an error if not a POST request
    echo "<script> alert('Unauthorized action.'); window.history.back(); </script>";
    exit();
}
