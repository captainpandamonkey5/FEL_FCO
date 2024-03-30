<?php

    require_once('main_db.php');

    function insertItem (){
        global $pdo;
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
    }

    function deleteItem (){
        global $pdo;
        $id = $_POST["id"];
        try{
            

            $delQuery = "DELETE FROM product WHERE ProductID = ? ";

            $stmnt = $pdo -> prepare ($delQuery);
            $stmnt->execute([$id]);

            $pdo=null;
            $stmnt=null;

            header("Location: ../Inventory.php");
            die();

        }catch(PDOException $e){
            echo $id ;
            die( "Delete failed " . $e->getMessage());
        }
    }

    function updateItem() {
	global $pdo;
    	try {
            $id = $_POST["id"];
            $prodName = $_POST["prodName"];
            $prodCategory = $_POST["prodCategory"];
            $prodPrice = $_POST["prodPrice"];
            $prodDescription = $_POST["prodDescription"];

            $updateQuery = "UPDATE product SET ProductName=?, Category=?, Price=?, ProductDesc=? WHERE ProductID=?";
            $stmnt = $pdo->prepare($updateQuery);
            $stmnt->execute([$prodName, $prodCategory, $prodPrice, $prodDescription, $id]);

            $pdo = null;
            $stmnt = null;

            header("Location: ../Inventory.php");
            die();

      	    } catch(PDOException $e) {
        	die("Update failed: " . $e->getMessage());
    	    }
	}

    function getItem() {
    	global $pdo;
    	try {
            $id = $_GET["id"];

            $selectQuery = "SELECT * FROM product WHERE ProductID=?";
            $stmnt = $pdo->prepare($selectQuery);
            $stmnt->execute([$id]);
            $item = $stmnt->fetch(PDO::FETCH_ASSOC);

            $pdo = null;
            $stmnt = null;

        } catch(PDOException $e) {
            die("Failed to fetch item: " . $e->getMessage());
        }
    }

    if($_SERVER["REQUEST_METHOD"] == "GET") {
    	if(isset($_GET["id"])) {
            getItem();
    	} else {
            header("Location: ../Inventory.php");
            die();
    }
} elseif($_SERVER["REQUEST_METHOD"] == "POST"){
        
        if(isset($_POST["insertItem"])){
            insertItem();
        }
        if(isset($_POST["deleteItem"])){
            deleteItem();
        }
	if(isset($_POST["updateItem"])){
	    updateItem();
    }else{
	header("Location: ../Inventory.php");
        die("Failed " . $e->getMessage());
    }
}