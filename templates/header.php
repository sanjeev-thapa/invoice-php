<?php

    session_start();
    if(!isset($_SESSION['login']) || !$_SESSION['login']){
        header("Location: login");
        exit();
    }

    require_once __DIR__ . '/../database.class.php'; 
    $db = new Database();

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

<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item <?php  echo $indexActive ?? ''; ?>">
                    <a class="nav-link" href=".">Dashboard <i class="fas fa-home"></i></a>
                </li>
                <li class="nav-item <?php  echo $customerActive ?? ''; ?>">
                    <a class="nav-link" href="customers">Customers <i class="fas fa-user"></i></a>
                </li>
                <li class="nav-item <?php  echo $invoiceActive ?? ''; ?>">
                    <a class="nav-link" href="invoices">Invoices <i class="fas fa-file-invoice"></i></a>
                </li>
            </ul>
        </div>
    </nav>