<?php
session_start();
require_once 'auth_check.php';

$servername = "sql202.infinityfree.com";
$username = "if0_37330629";
$password = "lvdwqnWnZjwU5";
$dbname = "if0_37330629_grants";

// Database connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle invoice creation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_invoice']) && $_SESSION['role'] === 'admin') {
    $invoice_number = $conn->real_escape_string($_POST['invoice_number']);
    $order_id = $conn->real_escape_string($_POST['order_id']);
    $amount = $conn->real_escape_string($_POST['amount']);
    $billed_to = $conn->real_escape_string($_POST['billed_to']);
    $due_date = $conn->real_escape_string($_POST['due_date']);
    $user_id = $conn->real_escape_string($_POST['user_id']);
    $items = json_encode(["item1" => "Product A", "item2" => "Product B"]);
    $admin_id = $_SESSION['user_id'];
    $expires_at = date("Y-m-d H:i:s", strtotime("+7 days"));

    $stmt = $conn->prepare("INSERT INTO invoices (invoice_number, order_id, amount, status, expires_at, due_date, billed_to, items, admin_id, user_id) VALUES (?, ?, ?, 'pending', ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdssssii", $invoice_number, $order_id, $amount, $expires_at, $due_date, $billed_to, $items, $admin_id, $user_id);
    
    if ($stmt->execute()) {
        echo "<script>Swal.fire('Success!', 'Invoice created successfully!', 'success');</script>";
    } else {
        echo "<script>Swal.fire('Error!', 'Error creating invoice: " . addslashes($conn->error) . "', 'error');</script>";
    }
    $stmt->close();
}

// Get users for admin dropdown
$users = [];
if ($_SESSION['role'] === 'admin') {
    $userResult = $conn->query("SELECT id, acct_name FROM UserInformation WHERE role = 'user'");
    while($row = $userResult->fetch_assoc()) {
        $users[] = $row;
    }
}

// Get invoices
if ($_SESSION['role'] === 'admin') {
    $sql = "SELECT i.*, u.acct_name as user_name FROM invoices i JOIN UserInformation u ON i.user_id = u.id ORDER BY created_at DESC";
} else {
    $sql = "SELECT * FROM invoices WHERE user_id = " . $_SESSION['user_id'] . " ORDER BY created_at DESC";
}
$result = $conn->query($sql);
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SBA Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-blue: #002e6d;
            --secondary-blue: #f0f4f9;
        }
        .dashboard-container {
            display: flex;
            min-height: 100vh;
            background: var(--secondary-blue);
        }
        .sidebar {
            width: 280px;
            background: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
        }
        .user-header {
            background: var(--primary-blue);
            color: white;
            padding: 2rem;
        }
        .nav-item {
            padding: 0.8rem 1.5rem;
            transition: 0.3s;
        }
        .payment-card {
            background: white;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: 0.3s;
            border: 1px solid #dee2e6;
        }
        .payment-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .copy-box {
            display: flex;
            gap: 10px;
            align-items: center;
            background: #f8f9fa;
            padding: 8px 12px;
            border-radius: 5px;
        }
        .copy-btn {
            background: var(--primary-blue);
            color: white;
            border: none;
            padding: 4px 8px;
            border-radius: 4px;
            cursor: pointer;
        }
        .timer {
            font-size: 24px;
            color: #dc3545;
            font-weight: bold;
            text-align: center;
            margin: 1rem 0;
        }
        .invoice-item {
            border-bottom: 1px solid #eee;
            padding: 1rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="user-header">
                <h5>Welcome Back</h5>
                <h4><?= htmlspecialchars($_SESSION['name']) ?></h4>
                <small class="text-light"><?= $_SESSION['role'] === 'admin' ? 'Administrator' : 'User' ?></small>
            </div>
            
            <div class="p-3">
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <button class="btn btn-primary w-100 mb-3" data-bs-toggle="modal" data-bs-target="#createInvoiceModal">
                        + Create Invoice
                    </button>
                <?php endif; ?>
                
                <div class="nav flex-column">
                    <div class="nav-item">Dashboard</div>
                    <div class="nav-item">Invoices</div>
                    <div class="nav-item">Payments</div>
                    <div class="nav-item mt-auto">
                        <a href="logout.php" class="btn btn-danger w-100">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-grow-1 p-4">
            <h3 class="mb-4">Payment Gateway</h3>
            
            <!-- Payment Methods -->
            <div class="row g-4">
                <!-- Cash App -->
                <div class="col-md-6">
                    <div class="payment-card" data-bs-toggle="modal" data-bs-target="#cashAppModal">
                        <h5>Cash App</h5>
                        <p class="text-muted mb-0">Click for payment instructions</p>
                    </div>
                </div>

                <!-- PayPal -->
                <div class="col-md-6">
                    <div class="payment-card" data-bs-toggle="modal" data-bs-target="#paypalModal">
                        <h5>PayPal</h5>
                        <p class="text-muted mb-0">Click for payment instructions</p>
                    </div>
                </div>

                <!-- Invoices Section -->
                <div class="col-12 mt-5">
                    <h4 class="mb-4"><?= $_SESSION['role'] === 'admin' ? 'All Invoices' : 'Your Invoices' ?></h4>
                    <div class="invoice-list">
                        <?php if ($result->num_rows > 0): ?>
                            <?php while($invoice = $result->fetch_assoc()): ?>
                                <div class="payment-card" data-bs-toggle="modal" data-bs-target="#invoiceModal" 
                                    data-invoice='<?= htmlspecialchars(json_encode($invoice), ENT_QUOTES, 'UTF-8') ?>'>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6>#<?= htmlspecialchars($invoice['invoice_number']) ?></h6>
                                            <?php if($_SESSION['role'] === 'admin'): ?>
                                                <small class="text-muted">Client: <?= htmlspecialchars($invoice['user_name']) ?></small>
                                            <?php endif; ?>
                                            <div class="text-muted">Due: <?= htmlspecialchars($invoice['due_date']) ?></div>
                                        </div>
                                        <div class="text-end">
                                            <h4>$<?= number_format($invoice['amount'], 2) ?></h4>
                                            <span class="badge bg-<?= $invoice['status'] === 'paid' ? 'success' : 'warning' ?>">
                                                <?= ucfirst($invoice['status']) ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <div class="alert alert-info">No invoices found</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <!-- Create Invoice Modal -->
    <div class="modal fade" id="createInvoiceModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Invoice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <?php if($_SESSION['role'] === 'admin'): ?>
                        <div class="mb-3">
                            <label>Select User:</label>
                            <select name="user_id" class="form-select" required>
                                <?php foreach($users as $user): ?>
                                <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['acct_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <?php endif; ?>
                        
                        <div class="mb-3">
                            <label>Invoice Number:</label>
                            <input type="text" name="invoice_number" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Order ID:</label>
                            <input type="text" name="order_id" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Amount:</label>
                            <input type="number" step="0.01" name="amount" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Billed To:</label>
                            <input type="text" name="billed_to" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Due Date:</label>
                            <input type="date" name="due_date" class="form-control" required>
                        </div>
                        <button type="submit" name="create_invoice" class="btn btn-success w-100">Create Invoice</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoice Details Modal -->
    <div class="modal fade" id="invoiceModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Invoice Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="timer text-center mb-4">30:00</div>
                    <div id="invoiceDetails">
                        <!-- Dynamic content loaded via JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Method Modals -->
    <?php include 'payment_modals.php'; ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Timer Logic
        function startTimer(duration, display) {
            let timer = duration, minutes, seconds;
            const interval = setInterval(() => {
                minutes = parseInt(timer / 60, 10);
                seconds = parseInt(timer % 60, 10);
                display.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                if (--timer < 0) clearInterval(interval);
            }, 1000);
        }

        // Initialize timers
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('show.bs.modal', (e) => {
                const timerDisplay = modal.querySelector('.timer');
                if(timerDisplay) startTimer(1800, timerDisplay);
            });
        });

        // Copy Functionality
        function copyToClipboard(button) {
            const text = button.previousElementSibling.textContent;
            navigator.clipboard.writeText(text).then(() => {
                button.textContent = "Copied!";
                setTimeout(() => button.textContent = "Copy", 2000);
            }).catch(err => alert('Failed to copy. Please copy manually.'));
        }

        // Invoice Details Handler
        const invoiceModal = document.getElementById('invoiceModal');
        invoiceModal.addEventListener('show.bs.modal', event => {
            const invoice = JSON.parse(event.relatedTarget.dataset.invoice);
            const detailsDiv = document.getElementById('invoiceDetails');
            
            detailsDiv.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Invoice Number:</strong> ${invoice.invoice_number}</p>
                        <p><strong>Order ID:</strong> ${invoice.order_id}</p>
                        ${invoice.user_name ? `<p><strong>Client:</strong> ${invoice.user_name}</p>` : ''}
                    </div>
                    <div class="col-md-6">
                        <p><strong>Due Date:</strong> ${invoice.due_date}</p>
                        <p><strong>Status:</strong> <span class="badge bg-${invoice.status === 'paid' ? 'success' : 'warning'}">${invoice.status}</span></p>
                    </div>
                </div>
                <div class="mt-4">
                    <h5>Items</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            ${Object.entries(JSON.parse(invoice.items)).map(([key, value]) => `
                                <tr>
                                    <td>${value}</td>
                                    <td>$${invoice.amount}</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
                <div class="text-end mt-4">
                    <button class="btn btn-primary" data-bs-target="#paymentModal" data-bs-toggle="modal">
                        Pay Now
                    </button>
                </div>
            `;
        });
    </script>
</body>
</html>