<?php

    require_once __DIR__ . '/database.class.php'; 

    if(!isset($_GET['invoice'])){
        exit();
    }else{
        $invoice = $_GET['invoice'];
    }

    $db = new Database();
    $selectInvoices = $db->selectInvoiceSlug($invoice);
    if(!$selectInvoices){
        exit();
    }

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.7.0/css/all.min.css"
        integrity="sha512-gRH0EcIcYBFkQTnbpO8k0WlsD20x5VzjhOA1Og8+ZUAhcMUCvd+APD35FJw3GzHAP3e+mP28YcDJxVr745loHw=="
        crossorigin="anonymous" />

    <title>Dashboard</title>
    <style>
        .w-fit-content {
            width: fit-content;
        }
    </style>
</head>

<body>
    <div class="container mt-5">

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
                        <a class="text-dark" target="_blank"
                            href="pay?invoice=<?php echo $invoiceSlug = $row['invoice_slug']; ?>">
                            <?php echo $invoiceSlug; ?>
                        </a>
                    </th>
                    <td><?php echo $row['customer_first'] .' '. $row['customer_last']; ?></td>
                    <td><?php echo $row['invoice_amount']; ?></td>
                    <td><?php echo $row['invoice_transaction']; ?></td>
                    <td>
                        <?php 
                            $invoiceStatus = $row['invoice_status'];
                            if($invoiceStatus == 0){ 
                        ?>
                        <strong class="text-success">Paid <i class="fas fa-check-circle"></i></strong>
                        <?php } else { ?>
                        <strong class="text-danger">Unpaid <i class="fas fa-times-circle"></i></strong>
                        <?php } ?>
                    </td>
                </tr>
                <?php } } ?>
            </tbody>
        </table>

        <?php if($invoiceStatus != 0) { ?>
        <div class="w-fit-content ml-auto">
            <a class="btn btn-success" href="payment?invoice=<?php echo $invoiceSlug; ?>">Make Payment</a>
        </div>
        <?php } ?>

    </div>

    <?php require_once __DIR__ . '/templates/footer.php'; ?>