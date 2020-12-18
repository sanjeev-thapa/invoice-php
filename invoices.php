<?php 

    $invoiceActive = 'active';
    require_once __DIR__ . '/templates/header.php'; 

    $selectInvoices = $db->selectInvoices();

?>

<div class="container mt-5">

    <div class="row mb-3">
        <div class="col">
            <h2>Invoice</h2>
        </div>
        <div class="col">
            <div class="ml-auto w-fit-content">
                <a class="btn btn-primary" href="create-invoice">Create Invoice <i class="fas fa-file-invoice"></i></a>
            </div>
        </div>
    </div>
    <table class="table border border-dark rounded">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Invoice ID</th>
                <th scope="col">Customer Name</th>
                <th scope="col">Amount</th>
                <th scope="col">Transaction#</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            
                if($selectInvoices){
                    while($row = $selectInvoices->fetch_assoc()){
                
            ?>
            <tr>
                <th>
                    <a class="text-dark" target="_blank" href="pay?invoice=<?php echo $row['invoice_slug']; ?>">
                        <?php echo $row['invoice_slug']; ?>
                    </a>
                </th>
                <td><?php echo $row['customer_first'] .' '. $row['customer_last']; ?></td>
                <td><?php echo $row['invoice_amount']; ?></td>
                <td><?php echo $row['invoice_transaction']; ?></td>
                <td>
                    <?php if($row['invoice_status'] == 0){ ?>
                    <strong class="text-success">Paid <i class="fas fa-check-circle"></i></strong>
                    <?php } else { ?>
                    <strong class="text-danger">Unpaid <i class="fas fa-times-circle"></i></strong>
                    <?php } ?>
                </td>
            </tr>
            <?php } } else { ?>
            <tr>
                <th class="h5 text-muted text-center" colspan=7>No Invoice Yet</th>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div> <?php require_once __DIR__ . '/templates/footer.php'; ?>