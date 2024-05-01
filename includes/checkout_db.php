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
            $productID = $_POST["productID"];
            $productQty = $_POST["productQty"];
            $discount = $_POST["discount"];

            for($i=0; $i < count($productID); $i++){
                            
                $query = "SELECT Quantity FROM product WHERE `ProductID` = $productID[$i] ";
                $stmnt = $pdo -> prepare ($query);
                $stmnt->execute();
                $productResult = $stmnt -> fetch(); 
                
                if($productResult["Quantity"] < $productQty[$i]){
                    echo"<script>window.alert('Quantity not satisfied'); window.location.href = '../POS.php';</script>";
                    print("kulang");
                    die();
                }

            }

            if($payment>=($totalcost-$discount)){
                $change = $payment - ($totalcost-$discount);
                $status = true;
            }
            else
                $balance = ($totalcost-$discount) - $payment;

            $insertQuery = "INSERT INTO customerorder ( CustomerName, OrderDate, TotalCost, Discount, Payment, `Change`, Balance, Status, Cashier, Remarks) VALUES (?,?,?,?,?,?,?,?,?,?)";

            $stmnt = $pdo -> prepare ($insertQuery);
            $stmnt->execute([$customername,$orderDate,$totalcost,$discount,$payment,$change,$balance,$status,$cashier,$remarks]);

            $last_id = $pdo->lastInsertId();
            session_start();
            $_SESSION['last_id'] = $last_id;

            for($i=0; $i < count($productID); $i++){
                $insertQuery = "INSERT INTO `order` (OrderNo, ProductID, OrderQty ) VALUES (?,?,?)";
                $stmnt = $pdo -> prepare ($insertQuery);
                $stmnt->execute([$last_id,$productID[$i],$productQty[$i]]);      

                $query = "SELECT Quantity FROM product WHERE ProductID = $productID[$i]";
                $stmnt = $pdo->prepare($query);
                $stmnt->execute();
                $currentQty = $stmnt->fetchColumn();

                $newQty = $currentQty - $productQty[$i];
                
                $updateQuery = "UPDATE product SET Quantity = $newQty WHERE ProductID = $productID[$i]";
                $stmnt = $pdo->prepare($updateQuery);
                $stmnt->execute();
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