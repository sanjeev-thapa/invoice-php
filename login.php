<?php

    session_start();
    require_once __DIR__ . '/database.class.php';
    if(isset($_SESSION['login']) && $_SESSION['login']){
        header("Location: .");
        exit();
    }

    $db = new Database();
    if(isset($_POST['user']) && isset($_POST['pass'])){
        $loginAdmin = $db->loginAdmin($_POST);
    }


?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>Login</title>
</head>

<body class="bg-light">

    <div class="w-25 mx-auto mt-5">

        <?php echo $loginAdmin ?? ''; ?>

        <form method="post" class="form p-5 bg-white border rounded">
            <div class="form-group">
                <label>Username</label>
                <input type="text" class="form-control" name="user">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" class="form-control" name="pass">
            </div>
            <button class="btn btn-primary">Login</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>
</body>

</html>