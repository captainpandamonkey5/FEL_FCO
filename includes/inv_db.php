<context>
<?php

    require_once('main_db.php');
    global $selectedItem;

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
        $id = $_GET["id"];
        try{
            

            $delQuery = "DELETE FROM product WHERE ProductID = ? ";

            $stmnt = $pdo -> prepare ($delQuery);
            $stmnt->execute([$id]);

            $pdo=null;
            $stmnt=null;

            header("Location: ../FEL_FCO/Inventory.php");
            die();

        }catch(PDOException $e){
            echo $id ;
            die( "Delete failed " . $e->getMessage());
        }
    }

    function updateItem() {
	global $pdo;
    	try {
            $id = $_POST["prodId"];
            $prodName = $_POST["prodName"];
            $prodCategory = $_POST["prodCategory"];
            $prodPrice = $_POST["prodPrice"];
            $prodDescription = $_POST["prodDescription"];

            $updateQuery = "UPDATE product SET ProductName=?, Category=?, Price=?, ProductDesc=? WHERE ProductID=?";
            $stmnt = $pdo->prepare($updateQuery);
            $stmnt->execute([$prodName, $prodCategory, $prodPrice, $prodDescription, $id]);

            $pdo = null;
            $stmnt = null;

            echo "tite";

            header("Location: ../Inventory.php");
            die();

      	    } catch(PDOException $e) {
        	die("Update failed: " . $e->getMessage());
    	    }
	}

    

    
        
    if(isset($_GET["deleteItem"])){
        deleteItem();
    }
     
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        if(isset($_POST["insertItem"])){
            insertItem();
        }
        else if(isset($_POST["updateItem"])){
            updateItem();
        }
        else{
            header("Location: ../Inventory.php");
            die("Failed ");
        }

    }

	
