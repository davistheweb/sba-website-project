<?php
require 'db_connect.php';

if (!isset($_SESSION['admin_logged_in'])) {
    die('Unauthorized');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $invoice_id = filter_input(INPUT_POST, 'invoice_id', FILTER_SANITIZE_NUMBER_INT);
        $payment_method = filter_input(INPUT_POST, 'payment_method', FILTER_SANITIZE_STRING);
        
        // Validate invoice
        $invoice = $conn->prepare("SELECT * FROM invoices WHERE id = ?");
        $invoice->execute([$invoice_id]);
        $invoice = $invoice->fetch(PDO::FETCH_ASSOC);

        if (!$invoice || $invoice['status'] !== 'pending') {
            throw new Exception('Invalid invoice');
        }

        // Handle file uploads
        $proof_paths = [];
        if ($payment_method === 'cashapp' && !empty($_FILES['proof'])) {
            $upload_dir = __DIR__.'/payment_proofs/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0755, true);

            foreach ($_FILES['proof']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['proof']['error'][$key] === UPLOAD_ERR_OK) {
                    $filename = uniqid().'_'.basename($_FILES['proof']['name'][$key]);
                    $target = $upload_dir.$filename;
                    
                    // Validate file type
                    $allowed = ['image/jpeg', 'image/png', 'application/pdf'];
                    $mime = mime_content_type($tmp_name);
                    if (!in_array($mime, $allowed)) {
                        throw new Exception('Invalid file type');
                    }

                    move_uploaded_file($tmp_name, $target);
                    $proof_paths[] = $filename;
                }
            }
        }

        // Create payment record
        $stmt = $conn->prepare("INSERT INTO payments 
            (invoice_id, payment_method, amount, status, proof_paths)
            VALUES (?, ?, ?, ?, ?)");

        $status = ($payment_method === 'cashapp') ? 'pending' : 'completed';
        $stmt->execute([
            $invoice_id,
            $payment_method,
            $invoice['amount'],
            $status,
            json_encode($proof_paths)
        ]);

        // Update invoice status
        $conn->prepare("UPDATE invoices SET status = ? WHERE id = ?")
            ->execute([$status, $invoice_id]);

        header("Location: payment_dashboard.php");
        exit;

    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}
