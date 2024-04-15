<?php

    require_once('main_db.php');

    function checkoutOrder(){
        global $pdo;
        try{
            $customername = $_POST["customername"];
            $orderDate = $_POST["orderDate"];
            $totalcost = (float)$_POST["totalcost"];
            $payment = (float)$_POST["payment"];
            $remarks = $_POST["remarks"];
            $cashier = $_POST["cashier"];
            $change=0;
            $balance=0;
            $status=false;
            if($payment>=$totalcost){
                $change = $payment-$totalcost;
                $status = true;
            }
            else
                $balance = $totalcost-$payment;

            $insertQuery = "INSERT INTO customerorder ( CustomerName, OrderDate, TotalCost, Payment, `Change`, Balance, Status, Cashier, Remarks) VALUES (?,?,?,?,?,?,?,?,?)";

            $stmnt = $pdo -> prepare ($insertQuery);
            $stmnt->execute([$customername,$orderDate,$totalcost,$payment,$change,$balance,$status,$cashier,$remarks]);

            $pdo=null;
            $stmnt=null;
            

            header("Location: ../POS.php");
            die();

        }catch(PDOException $e){
            die( "Insert failed " . $e->getMessage());
        }
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        if(isset($_POST["checkoutOrder"])){
            checkoutOrder();
        }
        else{
            header("Location: ../POS.php");
            die("Failed ");
        }

    }