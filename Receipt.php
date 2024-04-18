<?php
    session_start();

	require_once('includes/main_db.php');

    $last_ID=$_SESSION['last_id'];

	$query = "SELECT * FROM customerorder WHERE OrderNo='$last_ID'";
	$stmnt = $pdo -> prepare ($query);
	$stmnt->execute();
	$lastOrder = $stmnt -> fetch(); 

    $query = "SELECT OrderNo, product.ProductName, product.Price, OrderQty, Discount FROM `order` JOIN product ON product.ProductID = `order`.ProductID WHERE OrderNo='$last_ID'";
    $stmnt = $pdo -> prepare ($query);
	$stmnt->execute();
	$allOrder = $stmnt -> fetchAll(); 

    $statusString = "Pending Balance *";
    if ($lastOrder['Status'] == 1){
        $statusString = "No Pending Balance";
    }

    $query = "SELECT Username FROM `user` WHERE UserID = {$lastOrder['Cashier']} ";
    $stmnt = $pdo->prepare($query);
    $stmnt->execute();
    $cashierName = $stmnt->fetchColumn();
    
    $pdo=null;
    $stmnt=null;

    //var_dump($allOrder);


  
?>

<html>
    <title>AJC Bike Shop MIS</title>
    <link rel="stylesheet" href="css/main_style.css">
    <style>
        body{
            background:rgb(41, 41, 41);
        }
        .receipt {
        display:block;
        position: fixed;
        z-index: 100;
        background-color: white;
        box-shadow: 5px 0px 20px #0000009c;
        width: 400px;
        height: 80%;
        justify-content: center;
        align-items: center;
        padding: 1rem;
        border-radius: 1.25rem;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        overflow-y: auto;
        font-family: Courier New;
        margin:2rem 0;
        }
        .receipt p {
        margin: 0; /* Remove default margin for paragraphs */
        display: block;
        }

        .receipt p span {
        font-weight: bold; /* Example: make the content bold */
        }

        .receipt_btns{
        display:flex;
        }
        .receipt_btns button{
        flex:1;
        margin:0.2rem;
        background-color: #2C586E;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin-top: 10px;
        cursor: pointer;
        border: none;
        border-radius: 5px;
        }
    </style>
    </head>
    <body>
        <div class="receipt">
            <p style="text-align: center;">AJC Bike Shop</p>
            <p style="text-align: center;">122(A) Estrella St. Sto. Rosario City of Malolos Bulacan<br>09169596101</p>
            <p style="text-align: center;" id="recepit_OrderNo">Order No : <?php echo $lastOrder['OrderNo'];?></p><br>
            <p style="text-align: center;">------------------------------------</p><br>
            <p>Customer Name: <span id="recepit_CustomerName"><?php echo $lastOrder['CustomerName']; ?></span></p>
            <p>List of Items: <span id="recepit_Order"></span></p><br>
            <?php foreach($allOrder as $ao){?>
                <p> <span><?php echo $ao['ProductName'];?></span></p>
                <p> <?php echo $ao['OrderQty'];?> PC : &nbsp &nbsp <span> PHP  <?php echo ($ao['Price']*$ao['OrderQty']);?></span></p>
            <?php }?>
            <br>
            <p style="text-align: center;">------------------------------------</p><br>
            <p>Total Cost: <span id="recepit_TotalCost">PHP <?php echo $lastOrder['TotalCost'];?></span></p>
            <p>Payment: <span id="recepit_Payment">PHP <?php echo $lastOrder['Payment'];?></span></p>
            <p>Change: <span id="recepit_Change">PHP <?php echo $lastOrder['Change'];?></span></p>
            <p>Remaining Balance : <span id="recepit_Balance">PHP <?php echo $lastOrder['Balance'];?></span></p>
            <p>Remarks: <span id="recepit_Remarks"><?php echo $lastOrder['Remarks'];?></span></p><br>
            <p style="text-align: center;">------------------------------------</p><br>
            <p>Order Date: <span id="recepit_OrderDate"><?php echo $lastOrder['OrderDate'];?></span></p>
            <p>Status: <span id="recepit_Status"><?php echo $statusString;?></span></p>
            <p>Cashier: <span id="recepit_Cashier"><?php echo $cashierName;?></span></p>
            <br>

            <div class="receipt_btns">
                <button id="print-receipt-btn" > <span> PRINT </span> </button>
                <button id="done-receipt-btn"> <span> DONE </span> </button>
            </div>

        <script>
            document.getElementById('print-receipt-btn').addEventListener("click", e=>{ 
                window.close();
                //some printing codes 
            }) 
    
            document.getElementById('done-receipt-btn').addEventListener("click", e=>{ 
                window.close();
            }) 
        </script>
        </div>
    </body>
</html>
