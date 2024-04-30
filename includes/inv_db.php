<?php

    require_once('main_db.php');

    function productSearch(){
        global $pdo;
        if(isset($_GET["productsearch"])) {
            $productSearch = $_GET["productsearch"];
            try {
                $searchQuery = "SELECT * FROM product WHERE `ProductID` LIKE :productsearch OR `ProductName` LIKE :productsearch OR `Category` LIKE :productsearch";
                $stmt = $pdo->prepare($searchQuery);
                $productSearch = '%' . $productSearch . '%'; // Add wildcards to search for partial matches
                $stmt->bindParam(':productsearch', $productSearch, PDO::PARAM_STR);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $results;
            } catch(PDOException $e) {
                die("Search failed " . $e->getMessage());
            }
        }
        return [];
    }

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
        try {

            $checkQuery = "SELECT Quantity FROM product WHERE ProductID = ?";
            $checkStmt = $pdo->prepare($checkQuery);
            $checkStmt->execute([$id]);
            $row = $checkStmt->fetch(PDO::FETCH_ASSOC);
            if (!$row || $row['Quantity'] > 0) {
                echo "<script>alert('Cannot delete item because there is still an amount in the database.');</script>";
                return;
            }

            $delQuery = "DELETE FROM product WHERE ProductID = ?";
            $stmnt = $pdo->prepare($delQuery);
            $stmnt->execute([$id]);

            $pdo = null;
            $stmnt = null;

            header("Location: ../Inventory.php");
            die();
        } catch(PDOException $e){
            die( "Delete failed " . $e->getMessage());
        }
    }

    function getItem() {
    	global $pdo;
	$id = $_GET["productID"];
    	try {

            $getquery = "SELECT ProductName, Category, Price, ProductDesc FROM product WHERE ProductID = ?";

            $stmnt = $pdo->prepare($getquery);
            $stmnt->execute([$id]);

            $productDetails = $stmnt->fetch(PDO::FETCH_ASSOC);

            return $productDetails;

	    } catch(PDOException $e) {
                die("Error retrieving product details: " . $e->getMessage());
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

        	    if ($newQty < 0) {
            	        echo "<script>alert('Insufficient quantity!');</script>";
            		echo "<script>window.location.href = '../Inventory.php';</script>";
            		exit; // Stop execution
        	    }

        	    $updateQuery = "UPDATE product SET Quantity = :newQty WHERE ProductID = :id";
        	    $updateStmnt = $pdo->prepare($updateQuery);
        	    $updateStmnt->bindParam(':newQty', $newQty);
        	    $updateStmnt->bindParam(':id', $id);
        	    $updateStmnt->execute();

       	 	    $insertQuery = "INSERT INTO supplierorder ( ProductOrdered, SupplierName, OrderDate, QuantityOrdered, CostPerUnit, TotalCost) VALUES (?,?,?,?,?,?)";
        	    $stmnt = $pdo->prepare($insertQuery);
        	    $stmnt->execute([$id, $prodSuppName, $prodDate, $prodQty, $prodCost, $prodTotalCost]);

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
        header("Location: ../Inventory.php");
    } else if(isset($_GET["productID"])) {
        $id = $_GET["productID"];
        $productDetails = getItem($id);
        // Return product details as JSON
        header('Content-Type: application/json');
        echo json_encode($productDetails);
    } else {
        // No id provided in the request
        //http_response_code(400); // Bad Request
        //echo json_encode(array("message" => "Product ID (id) is required"));
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