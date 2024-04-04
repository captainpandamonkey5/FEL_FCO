<context>
<?php

    require_once('main_db.php');

    function productSearch (){
        global $pdo;
	$productSearch = $_POST["productsearch"];
        try{
            
            $searchQuery = "SELECT * FROM product WHERE `ProductID` = :productsearch OR `ProductName` = :productsearch";

            $stmt = $pdo->prepare($searchQuery);
            $stmt->bindParam(':productsearch', $productSearch);
            $stmt->execute();

	    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
           
	    if (isset($results)) {
        	if (empty($results)) {
            	    echo "<div>";
            	    echo "<p>Product not Found</p>";
            	    echo "</div>";
            } else {
            	echo "<div>";
            	    foreach ($results as $row) {
			echo "<div>";
                        echo "<h4>" . htmlspecialchars($row["ProductID"]) . "</h4>";
                        echo "<p>" . htmlspecialchars($row["ProductName"]) . "</p>";
                        echo "<p>" . htmlspecialchars($row["Category"]) . "</p>";
                        echo "<p>" . htmlspecialchars($row["Price"]) . "</p>";
                        echo "</div>";
                }
            echo "</div>";
            }
    	}

	    $pdo=null;
            $stmnt=null;

	    die();

        }catch(PDOException $e){
            die( "Search failed " . $e->getMessage());
        }
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        
        if(isset($_POST["productsearch"])){
            productSearch();
        }
        else{
            header("Location: ../POS.php");
            die("Failed ");
        }
}