
<?php
	require_once('includes/main_db.php');
	$selectAllQuery = "SELECT * FROM product";
	$stmnt = $pdo -> prepare ($selectAllQuery);
	$stmnt->execute();
	$results = $stmnt -> fetchAll(); 

	require_once('includes/inv_db.php');
	if(isset($_GET["productsearch"])){
		$results = productSearch();
	}
	
	$pdo=null;
    $stmnt=null;
?>

<html>
    <head>
		
		<title>AJC Bike Shop MIS</title>
		<link rel="shortcut icon" href="#">
		<link rel="stylesheet" href="css/main_style.css">
		<link rel="stylesheet" href="css/inv_style.css">
		<style>
            #inv_btn{
                background-color: rgb(41, 41, 41);
                color:white
            }
            #inv_btn path, #inv_btn svg,  #inv_btn rect{
                fill:white;
            }
        </style>
    </head>
    <body>

        <!-- for MANAGING THE STOCKS, allows create read update delete -->
		
		<div class="nav_bar">
			<ul class="main_nav">
				<a href = "POS.php">
					<li id="pos_btn">
						<svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 32 32" id="swipe-machine"><path fill="#231f20" d="M19.12 7H4.26a2.05 2.05 0 0 0-2 2v20.9A2.06 2.06 0 0 0 4.26 32H19.12a2.06 2.06 0 0 0 2.06-2.06V9A2.05 2.05 0 0 0 19.12 7zM7.62 28.72H5.73v-1.9H7.62zm0-4.71H5.73v-1.9H7.62zm0-4.71H5.73V17.4H7.62zm5 9.42H10.74v-1.9h1.91zm0-4.71H10.74v-1.9h1.91zm0-4.71H10.74V17.4h1.91zm5 9.42h-1.9v-1.9h1.9zm0-4.71h-1.9v-1.9h1.9zm0-4.71h-1.9V17.4h1.9zm.65-6a.34.34 0 0 1-.33.34H5.41a.34.34 0 0 1-.33-.34V10.59a.33.33 0 0 1 .33-.33H18a.33.33 0 0 1 .33.33zM28.45 10.4H28V28.58h.5a1.34 1.34 0 0 0 1.34-1.34V11.75A1.34 1.34 0 0 0 28.45 10.4z"></path><rect width="2.93" height="18.19" x="22.11" y="10.4" fill="#231f20"></rect><rect width="1.26" height="18.19" x="25.86" y="10.4" fill="#231f20"></rect><path fill="#231f20" d="M20.61 1.79A1.78 1.78 0 0 0 20.09.52 1.82 1.82 0 0 0 18.82 0 1.79 1.79 0 0 0 17 1.79V2.85h3.58zM16.21 1.79a1.52 1.52 0 0 1 0-.29 1.36 1.36 0 0 1 0-.21l-.1 0 .12 0A1 1 0 0 1 16.33 1 .86.86 0 0 1 16.4.8a2.39 2.39 0 0 1 .29-.52 1 1 0 0 1 .08-.11L16.91 0H8.81A1.63 1.63 0 0 0 7.18 1.62V6.06h9z"></path></svg><p>Order</p>
					</li>
				</a>
				<a href = "Inventory.php">
					<li id="inv_btn">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" id="box"><path d="M18.399 2H1.6c-.332 0-.6.267-.6.6V5h18V2.6a.6.6 0 0 0-.601-.6zM2 16.6c0 .77.629 1.4 1.399 1.4h13.2c.77 0 1.4-.631 1.4-1.4V6H2v10.6zM7 8h6v2H7V8z"></path></svg><p>Inventory</p>
					</li>
				</a>
				<a href = "OrderReport.php">
					<li id="report_btn">
						<svg xmlns="http://www.w3.org/2000/svg" data-name="Layer 1" viewBox="0 0 64 64" id="business-analysis"><path fill="#010101" d="M41.56,5.23h-4.1a1,1,0,0,1-1-1,4.43,4.43,0,0,0-8.85,0,1,1,0,0,1-1,1h-4.1L20.62,12.1H43.38ZM32,9.31a3.26,3.26,0,1,1,3.26-3.26A3.26,3.26,0,0,1,32,9.31Z"></path><path fill="#010101" d="M53.26 9.59h-8.4l.86 3.27a1 1 0 0 1-.17.9 1.06 1.06 0 0 1-.83.4H19.28a1 1 0 0 1-1-1.3l.86-3.27h-8.4a1 1 0 0 0-1 1V63a1 1 0 0 0 1 1H53.26a1 1 0 0 0 1-1V10.62A1 1 0 0 0 53.26 9.59zM23.59 60.88a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1V53.23a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1zM40.8 36.38a1 1 0 1 1 .63-2l3.4 1.08h0a1 1 0 0 1 .62.54 1 1 0 0 1 0 .8v0l-1.34 3.31a1 1 0 0 1-1 .65 1.08 1.08 0 0 1-.38-.08 1 1 0 0 1-.57-1.35l.36-.87L19.93 49.18a1.15 1.15 0 0 1-.44.09 1 1 0 0 1-.44-2L41.69 36.66zm-5.25 24.5a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1V48.07a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1zm12 0a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1v-18a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1zm.4-32.42H16.09a1 1 0 0 1 0-2.07H47.91a1 1 0 0 1 0 2.07zm0-6.89H16.09a1 1 0 1 1 0-2.06H47.91a1 1 0 1 1 0 2.06zM32 4.54a1.51 1.51 0 1 0 1.5 1.51A1.51 1.51 0 0 0 32 4.54z"></path><rect width="2.96" height="5.58" x="18.57" y="54.27" fill="#010101"></rect><rect width="2.96" height="10.75" x="30.52" y="49.1" fill="#010101"></rect><rect width="2.97" height="15.91" x="42.47" y="43.94" fill="#010101"></rect></svg><p>Report</p>
					</li>
				</a>
				<a href = "Account.php">
					<li id="acc_btn">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" id="Accountant"><path fill="#000000" d="m43.41 38.69-.44-.16c-1.74-.62-2.7-2.08-3.25-3.47 5.33-3.4 9.14-10.07 9.14-17.37C48.87 7.61 41.61 0 32.01 0 22.4 0 15.14 7.61 15.14 17.7c0 7.29 3.8 13.96 9.13 17.36-.69 1.78-1.78 2.95-3.25 3.48l-.44.16c-7.17 2.57-15.29 5.49-16.4 17.02-.06.59.25 1.14.76 1.41C13.69 61.69 22.69 64 31.71 64c9.01 0 18.21-2.31 27.31-6.86.53-.27.84-.83.78-1.42-1.1-11.53-9.22-14.45-16.39-17.03zM21.12 15.17c3.13.75 12.48 2.32 19.96-2.92.8 1.18 2.32 3.91 3.28 8.49h-.08c-.24-.57-.66-1.17-1.25-1.76-.59-.59-1.41-.93-2.23-.93H22.83c-.84 0-1.63.33-2.23.93-.25.25-.45.5-.64.74.43-1.28.86-2.82 1.16-4.55zm-2.33 7.75c.03 0 .05.01.07.01h.46c.37 1.34 1.4 4.21 3.62 5.25.57.27 1.16.4 1.78.4.92 0 1.9-.3 2.92-.89 2.39-1.39 3.69-3.02 3.86-4.86.08-.85-.1-1.72-.53-2.59h1.69c-.43.86-.61 1.73-.53 2.59.17 1.84 1.47 3.47 3.86 4.86 1.02.59 2 .89 2.93.89.61 0 1.21-.13 1.77-.4 2.16-1 3.19-3.66 3.62-5.25h.45c.05.32.09.64.14.98-2.19 6.05-7.35 10.65-12.88 10.65-5.86 0-11.27-5.11-13.23-11.64zm16.67 36.22L32 57.32l-3.46 1.82.66-3.85-2.8-2.73 3.87-.56L32 48.5l1.73 3.5 3.87.56-2.8 2.73.66 3.85zm-3.45-15.6a74.43 74.43 0 0 1-6.49-4.88c.52-.66.95-1.43 1.31-2.28 1.65.67 3.39 1.05 5.18 1.05 1.78 0 3.52-.38 5.16-1.04.36.86.79 1.63 1.31 2.29-2.69 2.28-5.37 4.12-6.47 4.86z" class="color292f64 svgShape"></path></svg><p>Account</p>
					</li>
				</a>
			</ul>
			
			<ul class="misc_nav">
				<a href = "Help.php">
					<li id="help_btn">
						<p>Help</p>
					</li>
				</a>
				<a href = "AboutUs.php">
					<li id="info_btn">
						<p>About Us</p>
					</li>
				</a>
			</ul>
		</div>


		<div class="main_section">

			<div class="search_bar">
   				<form action="" method="GET">
					<input type="text" name="productsearch" id="searchInput" placeholder="Search items">
				</form>
			</div>

			<div class="container">

			<div class="inv_misc">
				<button id="addItem_btn">
					<svg class="add-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="add">
        				<g data-name="20. Add">
            				<path d="M17 8a8.94 8.94 0 0 1 5 1.52V4a4 4 0 0 0-4-4H4a4 4 0 0 0-4 4v14a4 4 0 0 0 4 4h5.52A9 9 0 0 1 17 8Z"></path>
            				<path d="M17 10a7 7 0 1 0 7 7 7.008 7.008 0 0 0-7-7Zm2 8h-1v1a1 1 0 0 1-2 0v-1h-1a1 1 0 0 1 0-2h1v-1a1 1 0 0 1 2 0v1h1a1 1 0 0 1 0 2Z"></path>
        				</g>
   					</svg>
				</button>
			</div>
			<div class="inventory_section">
				<table>
							<tr>
								<th style="width:10%">ProductID</th>
								<th>Name</th> 
								<th style="width:10%">Category </th> 
								<th>Price</th>
								<th>Description</th>
								<th>Quantity</th>
								<th style="width:7%">Actions</th>
							</tr>
							
							<?php
								foreach ($results as $row){
							?>
								<tr>
									<td><p><?php echo $row["ProductID"] ?></p></td>
									<td><p><?php echo $row["ProductName"] ?></p>
									</td>
									<td><p><?php echo $row["Category"] ?></p>
									</td>
									<td ><p>PHP <?php echo $row["Price"] ?></p>
										
									</td>
									<td>
									    <p><?php echo $row["ProductDesc"] ?></p>
									</td>
									<td><p style="<?php echo ($row["Quantity"] == 0) ? 'color: red; font-weight: bold;' : 'color: black; font-weight: bold;'; ?>"><?php echo $row["Quantity"]; ?></p>
										<button class="decQty_btn" value="<?php echo $row['ProductID']?>" style="background-color: rgba(255, 0, 0, 0.9);">-</button>
										<button class="addQty_btn" value="<?php echo $row['ProductID']?>" style="background-color: rgba(0, 128, 0, 0.9);">+</button>
									</td>
									<td>
										<form action="includes/inv_db.php" method="get">
											<input type="hidden" name ="id" value="<?php echo $row['ProductID']?>">
											
											<button type="button" class="editItem_btn" name ="passItem" value="<?php echo $row['ProductID']?>">
												<svg class="edit-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" id="pencil">
        											<path d="M8.661 19.113 3 21l1.887-5.661ZM20.386 7.388a2.1 2.1 0 0 0 0-2.965l-.809-.809a2.1 2.1 0 0 0-2.965 0L6.571 13.655l3.774 3.774Z"></path>
    												</svg>
											</button>

											<button type="submit" name="deleteItem" onclick="confirmDelete()">
												<svg class="delete-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" id="delete">
        											<path fill="#000" d="M15 3a1 1 0 0 1 1 1h2a1 1 0 1 1 0 2H6a1 1 0 0 1 0-2h2a1 1 0 0 1 1-1h6Z"></path>
        											<path fill="#000" fill-rule="evenodd" d="M6 7h12v12a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2V7Zm3.5 2a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 1 0v-9a.5.5 0 0 0-.5-.5Zm5 0a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 1 0v-9a.5.5 0 0 0-.5-.5Z" clip-rule="evenodd"></path>
    												</svg>
											</button>	
										</form>
									</td>
								</tr>

							<?php
								}
							?>							
				</table>
			</div>
			<div class="addItem_form" id="addItem_form">
				<h2>Add a Product</h2>
				<form action="includes/inv_db.php" method="post" id="productForm">
					<input type="text" name="prodName" placeholder="Product Name">
					<input type="text" name="prodCategory" placeholder="Category">
					<input type="number" step="0.01" name="prodPrice" placeholder="Price">
					<input type="text" name="prodDescription" placeholder="Descripition">
					<button class="submitItem_btn" type="submit" name="insertItem">Submit</button>
				</form>	
			</div>

			<div class="editItem_form" id="editItem_form">
					<?php?>
    				<h2>Edit Product</h2>
    				<form action="includes/inv_db.php" method="post" id="editProductForm">
        				<input type="number" name="prodId" id="edit_prod_id" value="" readonly>
        				<input type="text" name="prodName" id="edit_prod_name" value="" placeholder="Product Name">
        				<input type="text" name="prodCategory" id="edit_prod_category" value="" placeholder="Category">
        				<input type="number" step="0.01" name="prodPrice" id="edit_prod_price" value="" placeholder="Price">
        				<input type="text" name="prodDescription" id="edit_prod_description" value="" placeholder="Descripition">
        				<button class="submitItem_btn" type="submit" name="updateItem">Update</button>
   				</form>
			</div>

			<div class="addQty_form" id="addQty_form">
					<?php?>
    				<h2>Add Quantity</h2>
    				<form action="includes/inv_db.php" method="post" id="addProductForm">
        				<input type="hidden" name="prodId" id="add_prod_id" value="" >
						<input type="text" name="prodName" id="add_prod_name" value="" readonly>
						<input type="date" name="prodDate" id="add_prod_date" value="" readonly>
						<input type="text" name="prodSuppName" id="add_prod_suppname" value="" placeholder="Supplier Name">
						<input type="number" name="prodQty" id="add_prod_qty" value="" placeholder="Quantity" step="1" required>
						<input type="number" name="prodCost" id="add_prod_cost" value="" placeholder="Cost Per Unit" step="0.01" required>
						<input type="number" name="prodTotalCost" id="add_prod_totalcost" value="" placeholder="Total Cost" step="0.01" required>
        				<button class="submitItem_btn" type="submit" name="addQty">Add</button>
   				</form>
			</div>

			<div class="decQty_form" id="decQty_form">
					<?php?>
    				<h2>Deduct Quantity</h2>
    				<form action="includes/inv_db.php" method="post" id="decProductForm">
        				<input type="hidden" name="prodId" id="dec_prod_id" value="" >
						<input type="text" name="prodName" id="dec_prod_name" value="" readonly>
						<input type="date" name="prodDate" id="dec_prod_date" value="" readonly>
						<input type="number" name="prodQty" id="dec_prod_qty" value="" placeholder="Quantity" step="1" required>
        				<button class="submitItem_btn" type="submit" name="decQty">Deduce</button>
   				</form>
			</div>
		
		</div>

		<script src="inventory.js"> 
	</script>

	</body>

</html>