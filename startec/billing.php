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
        <div class="body2">
            <h2>Select An Item</h2>
            <br>
            <div class="content">
                <div class="card-content">
                    <?php 
                 include 'connection.php';
                 $sql="SELECT * FROM products";
                 $run=mysqli_query($connect,$sql);
                 if(mysqli_num_rows($run)){
                    while($show=mysqli_fetch_array($run)){
                        ?>
                        <a href="checkout.php?pid=<?php echo $show['P_ID'];?>">
                         <div class="card">
                        <div class="img3">
                            <img src="thumb/<?php echo $show['thumb'];?>" alt="">
                        </div>
                        <span><?php echo substr($show['P_name'],0,15),"...";?></span>
                        <span class="id"><?php echo $show['serial_number'];?></span>
                    </div></a> <?php
                    }
                 }


?>
               
                </div>
            </div>
        </div>
        </div>
        </div>
        </div>
        </body>
        </html>

        <style>
            .card span{
                font-weight: 800;
                font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            }
            span.id{
                font-size: 13px;
                color:rgb(0,0,0,0.7);
            }
            .card .img3 img{
                width: 150px;
                height:150px;
            }
            .card{
                padding: 10px;
                box-shadow: 0 0 5px black;
                display: flex;
                flex-direction: column;
            }
            .card-content{
              display: flex;
              gap: 10px;
              flex-wrap: wrap;
            }
            .container{
                display: flex;
                gap:10px;
            }
        </style>