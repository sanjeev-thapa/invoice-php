<?php

    require_once __DIR__ . '/database.class.php'; 
    $db = new Database();

    if(isset($_GET['response'])){
        if($_GET['response'] ==='su' && isset($_GET['oid']) && isset($_GET['amt']) && isset($_GET['refId'])){
            // Success
            $oid = $_GET['oid'];
            $amt = $_GET['amt'];
            $refId = $_GET['refId'];

            $db->verifyTransaction($oid, $amt, $refId);

            $updateStatus = $db->updateStatus($_GET);
    
            echo "$updateStatus";
        }else{
            echo '<h2>Failure.</h2>';
        }
        exit();
    }

    if(!isset($_GET['invoice'])){
        echo '{"request" : "invalid"}';
        exit();
    }else{
        $invoice = $_GET['invoice'];
    }

    $selectInvoices = $db->selectUnpaidInvoiceSlug($invoice);
    if(!$selectInvoices){
        echo '{"payment" : "error"}';
        exit();
    }else{
        while($row = $selectInvoices->fetch_assoc()){
            $amount = $row['invoice_amount'];
        }
    }

?>

<form action="https://uat.esewa.com.np/epay/main" method="POST">
    <input value="<?php echo $amount; ?>" name="tAmt" type="hidden">
    <input value="<?php echo $amount; ?>" name="amt" type="hidden">
    <input value="0" name="txAmt" type="hidden">
    <input value="0" name="psc" type="hidden">
    <input value="0" name="pdc" type="hidden">
    <input value="EPAYTEST" name="scd" type="hidden">
    <input value="<?php echo $invoice .'-'. time(); ?>" name="pid" type="hidden">
    <input value="http://localhost:8888/test/payment?response=su" type="hidden" name="su">
    <input value="http://localhost:8888/test/payment?response=fu" type="hidden" name="fu">
</form>

<script>
    document.querySelector('form').submit();
</script>