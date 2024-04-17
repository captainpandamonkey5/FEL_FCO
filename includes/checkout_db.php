<?php

    require_once('main_db.php');
    

    function checkoutOrder(){
        global $pdo;
        global $last_id;
        try{
            $customername = $_POST["customername"];
            $orderDate = $_POST["orderDate"];
            $totalcost = $_POST["totalcost"];
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

            $last_id = $pdo->lastInsertId();
            session_start();
            $_SESSION['last_id'] = $last_id;

            $productID = $_POST["productID"];
            $productQty = $_POST["productQty"];
            $discount = 0;

            for($i=0; $i < count($productID); $i++){
                $insertQuery = "INSERT INTO `order` (OrderNo, ProductID, OrderQty,Discount ) VALUES (?,?,?,?)";

                $stmnt = $pdo -> prepare ($insertQuery);
                $stmnt->execute([$last_id,$productID[$i],$productQty[$i],$discount]);            
            }

            $pdo=null;
            $stmnt=null;
            
            echo"<script>window.open('../Receipt.php'); window.location.href = '../POS.php';</script>";



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