<?php

    require_once('main_db.php');

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        try{
            $prodName = $_POST["prodName"];
            $prodCategory = $_POST["prodCategory"];
            $prodPrice = $_POST["prodPrice"];
            $prodDescription = $_POST["prodDescription"];
            $prodQty = "0";

            $insertQuery = "INSERT INTO product ( ProductName, Category, Price, ProductDesc, Quantity) VALUES (?,?,?,?,?)";

            $stmnt = $pdo -> prepare ($insertQuery);
            $stmnt->execute([$prodName, $prodCategory, $prodPrice, $prodDescription, $prodQty]);

            $pdo=null;
            $stmnt=null;

            header("Location: ../Inventory.php");
            die();

        }catch(PDOException $e){
            die( "Insert failed " . $e->getMessage());
        }
        

    }else{
        header("Location: ../Inventory.php");
        die( "Insert failed " . $e->getMessage());
    }