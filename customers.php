<?php 

    $customerActive = 'active';
    require_once __DIR__ . '/templates/header.php'; 

    $selectCustomers = $db->selectCustomers();

?>

<div class="container mt-5">

    <div class="row mb-3">
        <div class="col">
            <h2>Customers</h2>
        </div>
        <div class="col">
            <div class="ml-auto w-fit-content">
                <a class="btn btn-primary" href="create-customer">Create Customer <i class="fas fa-user"></i></a>
            </div>
        </div>
    </div>
    <table class="table border border-dark rounded">
        <thead class="thead-dark">
            <tr>
                <th scope="col">Customer ID</th>
                <th scope="col">First</th>
                <th scope="col">Last</th>
                <th scope="col">Company</th>
                <th scope="col">PAN/VAT</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            
                if($selectCustomers){
                    while($row = $selectCustomers->fetch_assoc()){
                
            ?>
            <tr>
                <th><?php echo $row['customer_id']; ?></th>
                <td><?php echo $row['customer_first']; ?></td>
                <td><?php echo $row['customer_last']; ?></td>
                <td><?php echo $row['customer_company']; ?></td>
                <td><?php echo $row['customer_pan']; ?></td>
                <td><?php echo $row['customer_email']; ?></td>
                <td><?php echo $row['customer_phone']; ?></td>
            </tr>
            <?php } } else { ?>
            <tr>
                <th class="h5 text-muted text-center" colspan=7>No Customer Yet</th>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div> <?php require_once __DIR__ . '/templates/footer.php'; ?>