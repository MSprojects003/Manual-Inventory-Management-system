<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>products</title>
    <link rel="stylesheet" href="nav.css">
</head>
<body>
    <?php 
   if(!isset($_SESSION['login'])|| !$_SESSION['login']){

    header("location:index.php");

   }
   include 'connection.php';
   ?>
    <div class="head1">
<div class="dahsboard">
    <div class="container">
        <div class="nav">
            <div class="logo">
                <img src="images/logo.png" alt="">
            </div>
            <div class="actions">
            <a href="index.php">Dashboard</a>
                <a href="products.php">Products</a>
                <a href="category.php">Category</a>
                <a href="checkout.php">Bill a Product</a>
                <a href="summary.php">Summary</a>
            </div>
        </div>
        <div class="body">

            <div class="title">
                Summary
            </div>
            <div class="content">
            <div class="card-container">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="type" value="paid">
           <button class="card" name="view">
            <div class="c-title">
                Paid Amount
            </div>
            <div class="c-count">
                <?php
            $total = 0;
    $currentMonth = date("m"); // Format the date to include year and month

    $pricesql = "SELECT * FROM `order` WHERE DATE_FORMAT(O_date, '%m') = '$currentMonth'";
    $runprice = mysqli_query($connect, $pricesql);

    if ($runprice && mysqli_num_rows($runprice) > 0) {
        while ($show = mysqli_fetch_array($runprice)) {
            $paid = $show['paid_amount'];
            $total += $paid;
            
        }
    }
     

    echo "Rs." . number_format($total, 2);
?>

            </div>
            <span>Over this Month</span>
           </button></form>
            

         

<form action="" method="post" enctype="multipart/form-data">

           <button class="card" name="view">
            <div class="c-title">
                Overdue Amount
            </div>
            <div class="c-count">
            <?php
            $total = 0;
    $currentMonth = date("m"); // Format the date to include year and month

    $pricesql = "SELECT * FROM `order` WHERE DATE_FORMAT(O_date, '%m') = '$currentMonth'";
    $runprice = mysqli_query($connect, $pricesql);

    if ($runprice && mysqli_num_rows($runprice) > 0) {
        while ($show = mysqli_fetch_array($runprice)) {
            $paid = $show['overdue_amount'];
            $total += $paid;
            
        }

    }
     ?>
<input type="hidden" name="type" value="Pending"><?php
    echo "Rs." . number_format($total, 2);
?>

            </div>
            <span>Over this Month</span>
</button></form>
           </div>

           <?php
if(isset($_POST['view'])){
    
    $type= $_POST['type'];
    if($type=='paid'){

        $level=0;
    
        
$currentMonth = date("Y-m"); // Format the date to include year and month?>
<h2>Paid List</h2>
      
      <div class="lists">
       <hr>
      <?Php
$pricesql = "SELECT * FROM `order` WHERE DATE_FORMAT(O_date, '%Y-%m') = '$currentMonth' order by O_ID desc";
$runprice = mysqli_query($connect, $pricesql);

if ($runprice && mysqli_num_rows($runprice) > 0) {
    while ($show = mysqli_fetch_array($runprice)) {?>
        <div class="list">
            <form action="orderDetails.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="oid" value="<?php echo $show['O_ID'];?>">
        <button class="invoice" name="viewo">Invoice No. : <?php echo $show['invoice_no'];?></button></form>
        <span class="odate"> <?php echo date("M d, y",strtotime($show['O_date']));?></span>
        <span class="balance">Total: Rs.<?php echo number_format($show['O_total'],2);?></span>
        </div>
         
        <?php
    }
}else{
    echo"<br>";
    echo "<h3>No paid Lists Avaialable for this month</h3>";}?>
</div>
 

      

      





<?php
    }else if($type=='Pending'){
        $currentMonth = date("Y-m"); // Format the date to include year and month
        $level=0;?>
        <h2>Pending List</h2>
              
              <div class="lists">
               <hr>
              <?Php
        $pricesql = "SELECT * FROM `order` WHERE DATE_FORMAT(O_date, '%Y-%m') = '$currentMonth' AND overdue_amount != '$level' order by O_ID desc";
        $runprice = mysqli_query($connect, $pricesql);
        
        if ($runprice && mysqli_num_rows($runprice) > 0) {
            while ($show = mysqli_fetch_array($runprice)) {?>
                <div class="list">
                    <form action="orderDetails.php" method="post" enctype="multipart/form-data">
                <button class="invoice">Invoice No. : <?php echo $show['invoice_no'];?></button></form>
                <span class="odate"> <?php echo date("M d, y",strtotime($show['O_date']));?></span>
                <span class="balance">Total: Rs.<?php echo number_format($show['overdue_amount'],2);?></span>
                </div>
                 
                <?php
            }
        }else{
            echo"<br>";
            echo "<h3>No pending Lists Avaialable for this Month</h3>";}?>
        </div>
         <?php
    }
    
    
}
            ?>

            



            </div>
        </div>
        </div>
        </div>
        </div>
        </body>

        </html><style>
          .lists{
            margin: 20px;
            height: 300px;
            overflow: hidden;
            overflow-y: scroll;

          }
          .list{
            align-items: center;
            box-shadow: 0 0 3px black;
           padding: 15px;
            display: flex;
            justify-content: space-between;
          }
          .list form button.invoice{
            border: none;
    box-shadow: 0 0 3px silver;
    background: linear-gradient(45deg, #204374, #2c79a9);
    padding: 10px;
    border-radius: 4px;
    color: white;
    font-weight: 900;
    font-size: 15px;
          }
          .list span{
            font-weight: 600;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            text-transform: uppercase;
            font-size: 15px;
          }
             .card .c-title{
        font-weight: bold;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }
    .card{
        display: flex;
        flex-direction: column;
        padding: 30px;
        
        border-radius: 5px;
        box-shadow: 0 0 5px black;
    }
     
             .card-container{
        display: flex;
        gap: 30px;
        margin: 20px;
        flex-direction: row;
    }
    .c-count{
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        font-size: 40px;
        font-weight: 900;
    }
    .card span{
        color:rgb(0,0,0,0.7);
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        font-size: 13px;
    }
            .container{
                display: flex;
                gap: 10px;
            }
            .body .title
            {
             font-weight: 800;

             font-size: 20px;
            }
        </style>