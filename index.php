<?php 

    $indexActive = 'active';
    require_once __DIR__ . '/templates/header.php'; 

    $customerCount = $db->selectCustomerCount();
    $invoiceCount = $db->selectInvoiceCount();
    $totalAmount = $db->selectTotalAmount();

?>

<div class="container mt-5">
    <div class="row mx-auto">
        <div class="col-3">
            <h5 class="bg-white p-4 border rounded">
                <i class="fas fa-user mr-2"></i> Customers
                <span class="badge badge-dark ml-2"><?php echo $customerCount; ?></span>
            </h5>
        </div>
        <div class="col-3">
            <h5 class="bg-white p-4 border rounded">
                <i class="fas fa-file-invoice mr-2"></i> Invoices
                <span class="badge badge-dark ml-2"><?php echo $invoiceCount; ?></span>
            </h5>
        </div>
        <div class="col-3">
            <h5 class="bg-white p-4 border rounded">
                <i class="fas fa-coins mr-2"></i> Sales
                <span class="badge badge-dark ml-2">Rs. <?php echo $totalAmount; ?></span>
            </h5>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/templates/footer.php'; ?>