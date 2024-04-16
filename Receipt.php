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
        <p style="text-align: center;">(Address)</p>
        <p style="text-align: center;" id="recepit_OrderNo">(Order No.)</p><br>
        <p style="text-align: center;">------------------------------------</p><br>
        <p>Customer Name: <span id="recepit_CustomerName">(Name)</span></p>
        <p>List of Items: <span id="recepit_Order">(Items with quantity and price maybe)</span></p><br>
        <p style="text-align: center;">------------------------------------</p><br>
        <p>Total Cost: <span id="recepit_TotalCost">(Cost)</span></p><br>
        <p>Payment: <span id="recepit_Payment">(Payment)</span></p><br>
        <p>Change: <span id="recepit_Change">(Change)</span></p><br>
        <p>Remaining Balance : <span id="recepit_Balance">(Balance)</span></p><br>
        <p>Remarks: <span id="recepit_Remarks">(Remarks)</span></p><br>
        <p style="text-align: center;">------------------------------------</p><br>
        <p>Order Date: <span id="recepit_OrderDate">(Date)</span></p>
        <p>Status: <span id="recepit_Status">(Status)</span></p>
        <p>Cashier: <span id="recepit_Cashier">(Cashier)</span></p>
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
