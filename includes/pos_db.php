
<?php

    require_once('main_db.php');

    function productSearch (){
        global $pdo;
	    $productSearch = $_GET["productsearch"];
        try{
            
            $searchQuery = "SELECT * FROM product WHERE `ProductID` LIKE :productsearch OR `ProductName` LIKE :productsearch OR `Category` LIKE :productsearch";

            $stmt = $pdo->prepare($searchQuery);
            $productSearch = $productSearch.'%';
            $stmt->bindParam(':productsearch', $productSearch);
            $stmt->execute();

	        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
          
	    die();

        }catch(PDOException $e){
            die( "Search failed " . $e->getMessage());
        }
    }

    function categorySearch (){
        global $pdo;
	    $productSearch = $_GET["categorysearch"];
        try{
            
            $searchQuery = "SELECT * FROM product WHERE `Category` = :productsearch";

            $stmt = $pdo->prepare($searchQuery);
            $stmt->bindParam(':productsearch', $productSearch);
            $stmt->execute();

	        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $results;
          
	    die();

        }catch(PDOException $e){
            die( "Search failed " . $e->getMessage());
        }
    }

    
