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

            header("Location: ../Inventory.php");
            die();

        }catch(PDOException $e){
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


            header("Location: ../Inventory.php");
            die();

      	    } catch(PDOException $e) {
        	die("Update failed: " . $e->getMessage());
    	    }
	}

    function addQty() {
        global $pdo;
            try {
                $id = $_POST["prodId"];
                $prodSuppName = $_POST["prodSuppName"];
                $prodDate = $_POST["prodDate"];
                $prodQty = $_POST["prodQty"];
                $prodCost = $_POST["prodCost"];
                $prodTotalCost = $_POST["prodTotalCost"];
    
                $query = "SELECT Quantity FROM product WHERE ProductID = :id";
                $stmnt = $pdo->prepare($query);
                $stmnt->bindParam(':id', $id);
                $stmnt->execute();
                $currentQty = $stmnt->fetchColumn();

                $newQty = $currentQty + $prodQty;

                $updateQuery = "UPDATE product SET Quantity = :newQty WHERE ProductID = :id";
                $updateStmnt = $pdo->prepare($updateQuery);
                $updateStmnt->bindParam(':newQty', $newQty);
                $updateStmnt->bindParam(':id', $id);
                $updateStmnt->execute();

                $insertQuery = "INSERT INTO supplierorder ( ProductOrdered, SupplierName, OrderDate, QuantityOrdered, CostPerUnit, TotalCost) VALUES (?,?,?,?,?,?)";
                $stmnt = $pdo -> prepare ($insertQuery);
                $stmnt->execute([$id,$prodSuppName, $prodDate, $prodQty, $prodCost, $prodTotalCost]);

        
                $pdo = null;
                $stmnt = null;
    
    
                header("Location: ../Inventory.php");
                die();
    
                  } catch(PDOException $e) {
                die("Update failed: " . $e->getMessage());
                }
        }

        function decQty() {
            global $pdo;
                try {
                    $id = $_POST["prodId"];
                    $prodSuppName = null;
                    $prodDate = $_POST["prodDate"];
                    $prodQty = $_POST["prodQty"] * -1;
                    $prodCost = null;
                    $prodTotalCost = null;
        
                    $query = "SELECT Quantity FROM product WHERE ProductID = :id";
                    $stmnt = $pdo->prepare($query);
                    $stmnt->bindParam(':id', $id);
                    $stmnt->execute();
                    $currentQty = $stmnt->fetchColumn();
    
                    $newQty = $currentQty + $prodQty;
    
                    $updateQuery = "UPDATE product SET Quantity = :newQty WHERE ProductID = :id";
                    $updateStmnt = $pdo->prepare($updateQuery);
                    $updateStmnt->bindParam(':newQty', $newQty);
                    $updateStmnt->bindParam(':id', $id);
                    $updateStmnt->execute();
    
                    $insertQuery = "INSERT INTO supplierorder ( ProductOrdered, SupplierName, OrderDate, QuantityOrdered, CostPerUnit, TotalCost) VALUES (?,?,?,?,?,?)";
                    $stmnt = $pdo -> prepare ($insertQuery);
                    $stmnt->execute([$id,$prodSuppName, $prodDate, $prodQty, $prodCost, $prodTotalCost]);
    
            
                    $pdo = null;
                    $stmnt = null;
        
        
                    header("Location: ../Inventory.php");
                    die();
        
                      } catch(PDOException $e) {
                    die("Update failed: " . $e->getMessage());
                    }
            }

    

    
        
    if(isset($_GET["deleteItem"])){
        deleteItem();
        echo "tite";
    }
     
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        if(isset($_POST["insertItem"])){
            insertItem();
        }
        else if(isset($_POST["updateItem"])){
            updateItem();
        }
        else if(isset($_POST["addQty"])){
            addQty();
        }
        else if(isset($_POST["decQty"])){
            decQty();
        }
        else{
            header("Location: ../Inventory.php");
            die("Failed ");
        }

    }

	
