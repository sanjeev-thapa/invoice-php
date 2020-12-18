<?php

    class Database{

        public $conn;

        public function __construct(){
            $this->conn = new mysqli('localhost', 'root', 'root', 'test');
            if(!$this->conn){
                echo 'Database error';
                exit();
            }
        }

        public function alert($type, $messages){
            return "<div class='alert alert-$type my-2' role='alert'>$messages</div>";
        }

        public function loginAdmin($post){
            $user = $post['user'];
            $pass = md5($post['pass']);

            $result  = $this->conn->query("SELECT * FROM admin WHERE BINARY admin_user = '$user' AND BINARY admin_pass = '$pass'");
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    $_SESSION['login'] = true;
                    $_SESSION['admin_id'] = $row['admin_id'];
                }
            }else{
                return $this->alert('danger', 'Invalid Username or Password');
            }
        }

        // Customers
        public function selectCustomers(){
            $result  = $this->conn->query("SELECT * FROM customer");
            if($result->num_rows > 0){
                return $result;
            }else{
                return false;
            }
        }

        public function selectCustomerCount(){
            $result = $this->conn->query("SELECT COUNT(*) count FROM customer");
            if($result){
                while($row = $result->fetch_assoc()){
                    return $row['count'];
                }
            }else{
                echo 'Error in getting customers';
                exit();
            }
        }

        public function insertCustomer($post){
            $first = $post['first'];
            $last = $post['last'];
            $company = $post['company'];
            $pan = $post['pan'];
            $email = $post['email'];
            $phone = $post['phone'];

            $result  = $this->conn->query("INSERT INTO customer(customer_first, customer_last, customer_company, customer_pan, customer_email, customer_phone)
                        VALUES('$first', '$last', '$company', '$pan', '$email', '$phone')");
            if($result){
                return $this->alert('success', 'Customer Created Successfully');
            }else{
                return $this->alert('danger', 'Error Creating Customer');
            }
        }


        //Invoice
        public function selectInvoices(){
            $result  = $this->conn->query("SELECT * FROM invoice INNER JOIN customer ON invoice.customer_id = customer.customer_id");
            if($result->num_rows > 0){
                return $result;
            }else{
                return false;
            }
        }

        public function selectInvoiceCount(){
            $result = $this->conn->query("SELECT COUNT(*) count FROM invoice");
            if($result){
                while($row = $result->fetch_assoc()){
                    return $row['count'];
                }
            }else{
                echo 'Error in getting invoice';
                exit();
            }
        }

        public function selectTotalAmount(){
            $result = $this->conn->query("SELECT * FROM invoice WHERE invoice_status = '0'");
            if($result){
                if($result->num_rows > 0){
                    $total = 0;
                    while($row = $result->fetch_assoc()){
                        $total += $row['invoice_amount'];
                    }
                    return $total;
                }else{
                    return 0;
                }
            }else{
                echo 'Error in getting total amount';
                exit();
            }
        }

        public function selectInvoiceSlug($slug){
            $result  = $this->conn->query("SELECT * FROM invoice INNER JOIN customer ON invoice.customer_id = customer.customer_id WHERE invoice_slug = '$slug'");
            if($result->num_rows > 0){
                return $result;
            }else{
                return false;
            }
        }

        public function selectUnpaidInvoiceSlug($slug){
            $result  = $this->conn->query("SELECT * FROM invoice INNER JOIN customer ON invoice.customer_id = customer.customer_id WHERE invoice_slug = '$slug' AND invoice_status = 1");
            if($result->num_rows > 0){
                return $result;
            }else{
                return false;
            }
        }

        public function insertInvoice($post){
            $slug = md5(time() . rand());
            $amount = $post['amount'];
            $status = $post['status'];
            $customer_id = $post['customer'];

            $result  = $this->conn->query("INSERT INTO invoice(invoice_slug, invoice_amount, invoice_status, customer_id)
                        VALUES('$slug', '$amount', '$status', '$customer_id')");
            if($result){
                return $this->alert('success', 'Invoice Created Successfully');
            }else{
                return $this->alert('danger', 'Error Creating Invoice');
            }
        }

        public function updateStatus($get){
            $oid = $get['oid'];
            $amt = $get['amt'];
            $refId = $get['refId'];

            $oidArray = explode('-', $oid);
            $slug = $oidArray[0];

            $selectResult = $this->selectInvoiceSlug($slug);
            if(!$selectResult){
                return 'Fraud Payment';
            }else{
                while($row = $selectResult->fetch_assoc()){
                    $invoiceId = $row['invoice_id'];
                }
            }

            if(!$this->verifyTransaction($oid, $amt, $refId)){
                return 'Fraud Payment';
            }

            $result = $this->conn->query("UPDATE invoice SET invoice_transaction = '$refId', invoice_status = 0 WHERE invoice_id = '$invoiceId'");
            if($result){
                header("Location: pay?invoice=$slug");
                return false;;
            }else{
                return "An error occurred. Please contact support with <strong>Reference ID: {$oidArray[0]}-{$oidArray[1]}</strong>";
            }
        }

        public function verifyTransaction($oid, $amt, $refId){
            $url = "https://uat.esewa.com.np/epay/transrec";
            $post = array("amt" => "$amt", "scd" => "EPAYTEST", "pid" => "$oid", "rid" => "$refId");

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($curl);
            curl_close($curl);

            $xml = simplexml_load_string($response);
            if(trim($xml->response_code) === 'Success'){
                return true;
            }else{
                return false;
            }
        }

    }

?>