<?php 

    $customerActive = 'active';
    require_once __DIR__ . '/templates/header.php'; 

    if(isset($_POST['first']) && isset($_POST['last']) && isset($_POST['company']) && isset($_POST['pan']) && isset($_POST['email']) && isset($_POST['phone'])){
       $insertCustomer = $db->insertCustomer($_POST);
    }

?>

<div class="container w-25 mt-5">

    <h2>Create Customers</h2>

    <?php echo $insertCustomer ?? ''; ?>

    <form method="post" class="form">
        <div class="d-flex">
            <div class="form-group mr-1">
                <label>First</label>
                <input type="text" class="form-control" name="first">
            </div>
            <div class="form-group ml-1">
                <label>Last</label>
                <input type="text" class="form-control" name="last">
            </div>
        </div>
        <div class="form-group">
            <label>Company</label>
            <input type="text" class="form-control" name="company">
        </div>
        <div class="form-group">
            <label>PAN/VAT</label>
            <input type="text" class="form-control" name="pan">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="text" class="form-control" name="email">
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input type="text" class="form-control" name="phone">
        </div>
        <div class="d-flex">
            <a href="customers" class="btn btn-secondary"><i class="fas fa-chevron-circle-left"></i> Back</a>
            <button class="btn btn-primary ml-auto">Create <i class="fas fa-plus-circle"></i></button>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/templates/footer.php'; ?>