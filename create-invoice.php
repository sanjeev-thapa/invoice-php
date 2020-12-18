<?php 

    $invoiceActive = 'active';
    require_once __DIR__ . '/templates/header.php'; 

    $selectCustomers = $db->selectCustomers();

    if(isset($_POST['customer']) && isset($_POST['amount']) && isset($_POST['status'])){
       $insertInvoice = $db->insertInvoice($_POST);
    }

?>

<div class="container w-25 mt-5">

    <h2>Create Invoice</h2>

    <?php echo $insertInvoice ?? ''; ?>

    <form method="post" class="form">
        <div class="form-group mr-1">
            <label>Customer</label>
            <select name="customer" class="form-control">
                <?php
                    if($selectCustomers){ 
                        while($row = $selectCustomers->fetch_assoc()){
                ?>
                <option value="<?php echo $row['customer_id'] ?>">
                    <?php echo $row['customer_first'] .' '. $row['customer_last'] . ' (' . $row['customer_id'] . ')'; ?>
                </option>
                <?php } } ?>
            </select>
        </div>
        <div class="form-group">
            <label>Amount</label>
            <input type="text" class="form-control" name="amount">
        </div>
        <div class="form-group mr-1">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="0">Paid</option>
                <option value="1" selected>Unpaid</option>
            </select>
        </div>
        <div class="d-flex">
            <a href="invoices" class="btn btn-secondary"><i class="fas fa-chevron-circle-left"></i> Back</a>
            <button class="btn btn-primary ml-auto">Create <i class="fas fa-plus-circle"></i></button>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/templates/footer.php'; ?>