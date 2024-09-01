<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="nav.css">
</head>
<body>

<?php session_start();
include 'connection.php';

if(!isset($_SESSION['login'])|| !$_SESSION['login']){

    ?>
    <style>
        .span1{
            
            font-size: 12px;
        }
        h3.log-in{
            margin-bottom: 0;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        .terms{
            color: rgb(0,0,0,0.8);
            font-size: 15px;
            margin-top: 5px;
        }
        .terms a{
            color: black;

            font-weight: bold;
            text-decoration: none;
        }
        .loginbtn{
            background-color: black;
            border: none;
            border-radius: 2px;
            padding: 7px;
            color: white;
            border-radius: 4px;

        }
        .login form{
            display: flex;
            justify-content: center;
            flex-direction: column;
            gap: 10px;
            width: 60%;
        }
        .form{
            display: flex;
            justify-content: center;
        }
        .login h3,span{
            text-align: center;
        }
        .login form input{
            padding: 5px;
            outline: none;
            border: none;
            border-radius: 2px;

            
        }
        .login{
            display: flex;
            justify-content: center;
           width: 500px;
           height: 350px;
            background-color:#bcc3cd;
            
            flex-direction: column;
        }
        .login-container{
            margin: 30px;
            display: flex;
            justify-content: center;
        }
         body{
            margin: 0;
         }
        .head{
            margin: 0;
            
            padding:20px;
            background-color: silver;
        }
        .content h5{
            color: red;
            font-size: 10px;
            margin-top: -3px;
            font-weight: 800;
            text-transform:uppercase;
        }
        .container .content{
            display: flex;
            justify-content: center;
            align-items: center;
            
            flex-direction: column;
        }
        
        .content img{
            width: auto;
            height: 100px;
        }
        .forgot{
        color: black;
        text-shadow: 0 0 10px black;
            
        }.forgot a{
            text-decoration: none;

        }

    </style>
     <div class="head">

</div>
<div class="container">
    <div class="content">
        <img src="images/logo.png" alt="">
        <h5>enterprise resourse management system</h5>
    </div>
   
</div>
<div class="login-container">
<div class="login">
        <h3 class="log-in">LOG IN</h3>
        <span class="span1">Enter your Email to Signup</span>
        <br>
        <div class="form">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="text" name="uname" id="">
            <input type="text" name="paswd" id="">
            <button class="loginbtn" name="login">CONTINUE</button>
            <span class="forgot">Forgot Password? <a href="change_password.php">Change Password</a></span>

            <span class="terms">By Clicking Cintinue,you agree to our <a href="">Terms of Services </a>and <a href="">Privacy Policy</a> </span>
        </form>
        </div>
    </div></div>
    <?php


    if(isset($_POST['login'])){
        $uname=$_POST['uname'];
        $paswd=$_POST['paswd'];
        $result=false;
        $sql="SELECT * FROM Admin";
        $query=mysqli_query($connect,$sql);
        if(mysqli_num_rows($query)){
            while($show=mysqli_fetch_array($query)){



                if($show['user_name']==$uname && password_verify($paswd,$show['password'])){
                    $result=true;
                }
            }
        }
        if($result==true){
            $_SESSION['login']=true;?>
            <script>window.location.href="index.php";</script>
            <?php
            
        }else{
            ?>
            <script>
             alert("Incorrect Verification");
             
            </script>
            <?php
        }
    }

}else{

?>
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
           <div class="title1">
            <h2>Dashboard</h2>
            <div class="admin">
               <div class="a-img">
                <img src="images/star.png" alt="">
               </div>
            <div class="a-name">ADMIN</div></div>
           </div>
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
     

    function formatNumber($number) {
        if ($number >= 1000000000000) {
            return number_format($number / 1000000000000, 1) . 'T';
        } elseif ($number >= 1000000000) {
            return number_format($number / 1000000000, 1) . 'B';
        } elseif ($number >= 1000000) {
            return number_format($number / 1000000, 1) . 'M';
        }  else {
            return number_format($number);
        }
    }
    
    // Format the total amount
    $formattedTotal = formatNumber($total);
    
    echo "Rs." . $formattedTotal;
    
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
   $formattedTotal = formatNumber($total);
    
   echo "Rs." . $formattedTotal;
?>

            </div>
            <span>Over this Month</span>
</button></form>            
<form action="" method="post" enctype="multipart/form-data">

<button class="card" name="view">
 <div class="c-title">
     Total Amount 
 </div>
 <div class="c-count">
 <?php
 $total = 0;
$currentMonth = date("m"); // Format the date to include year and month

$pricesql = "SELECT * FROM `order` ";
$runprice = mysqli_query($connect, $pricesql);

if ($runprice && mysqli_num_rows($runprice) > 0) {
while ($show = mysqli_fetch_array($runprice)) {
 $o_total = $show['O_total'];
 $total += $o_total;
 
}

}
?>
<input type="hidden" name="type" value="all"><?php
 $formattedTotal = formatNumber($total);
    
 echo "Rs." . $formattedTotal;
?>

 </div>
 <span>till Now</span>
</button></form>            

           </div>

<!---->
           <div class="wrap1">
           <div class="category-card">
            <div class="cat-title">
                Category
            </div>
            <div class="cat-detail1">
                <div class="cat-head1">Model</div>
                <div class="cat-qty">QTY</div>
            </div>
            <div class="cat-detail">

                <div class="cat-head1">Laptops</div>
                <div class="cat-qty">
<?php 

include 'connection.php';

$count1="SELECT COUNT(*) as count FROM products where P_category='Laptop'";
$runcount=mysqli_query($connect,$count1);
if(mysqli_num_rows($runcount)){
    while($showcont=mysqli_fetch_array($runcount)){
        echo $showcont['count'];
    }
}


      ?>          </div>
            </div>
            <div class="cat-detail">
                <div class="cat-head1">Accessories</div>
                <div class="cat-qty"><?php 

include 'connection.php';

$count1="SELECT COUNT(*) as count FROM products where P_category='Accessory'";
$runcount=mysqli_query($connect,$count1);
if(mysqli_num_rows($runcount)){
    while($showcont=mysqli_fetch_array($runcount)){
        echo $showcont['count'];
    }
}


      ?> </div>
            </div>
            <div class="cat-detail">
                <div class="cat-head1">Softwares</div>
                <div class="cat-qty"><?php 

include 'connection.php';

$count1="SELECT COUNT(*) as count FROM products where P_category='Software'";
$runcount=mysqli_query($connect,$count1);
if(mysqli_num_rows($runcount)){
    while($showcont=mysqli_fetch_array($runcount)){
        echo $showcont['count'];
    }
}


      ?> </div>
            </div>
           
           </div>
           <div class="lists">
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
        <button class="invoice" name="viewo">No. : <?php echo $show['invoice_no'];?></button></form>
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
                    <input type="hidden" name="oid" value="<?php echo $show['O_ID'];?>">
                <button class="invoice" name="viewo">No. : <?php echo $show['invoice_no'];?></button></form>
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
    }else if($type=='all'){
        $currentMonth = date("Y-m"); // Format the date to include year and month
        $level=0;?>
        <h2>list of All sale</h2>
              
              <div class="lists">
               <hr>
              <?Php
        $pricesql = "SELECT * FROM `order` order by O_ID desc";
        $runprice = mysqli_query($connect, $pricesql);
        
        if ($runprice && mysqli_num_rows($runprice) > 0) {
            while ($show = mysqli_fetch_array($runprice)) {?>
                <div class="list">
                    <form action="orderDetails.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="oid" value="<?php echo $show['O_ID'];?>">
                <button class="invoice" name="viewo">No. : <?php echo $show['invoice_no'];?></button></form>
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

   
   <style>
   
   </style>
</body>
</html>
<style>
     .lists{
            margin: 20px;
            height: 300px;
            width:500px;
            overflow: hidden;
            overflow-y: scroll;
            overflow-x: scroll;

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
    padding: 7px;
    border-radius: 4px;
    color: white;
    font-weight: 900;
    font-size: 10px;
          }
          .list span{
            font-weight: 600;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            text-transform: uppercase;
            font-size: 15px;
          }
    .wrap1{
        display: flex;

    }
    .cat-detail{
        border-bottom: 1px solid black;
        
        font-weight: 600;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }
    .cat-detail,.cat-detail1{
        display: flex;
        flex-direction: row;
        padding-top: 15px;
        padding-bottom: 15px;
        justify-content: space-between;
    }
   .cat-detail1{
    color: rgb(0,0,0,0.7);
    font-weight: 800;

    margin-top: 30px;
    border-bottom: 1px solid rgb(0,0,0,0.7);
   }
    .category-card{
        padding: 30px;
        border-radius: 5px;
        display: flex;
        width:30%;
        flex-direction: column;
        box-shadow: 0 0 5px;
        margin: 20px;
        margin-bottom: 0px;
        overflow: hidden;
        height: 200px;
        overflow-y: scroll;
    }
    .category-card .cat-title{
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 18px;
    }
    
    .card-container{
        display: flex;
        gap: 30px;
        margin: 20px;
        flex-direction: row;
    }
    .card span{
        color:rgb(0,0,0,0.7);
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        font-size: 13px;
    }
    .c-count{
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        font-size: 20px;
        font-weight: 900;
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
    .container{
        display: flex;

    }
    .body{
        margin:20px;
        width: 100%;
    }
    .title1{
        display: flex;
        
        align-items: center;
        justify-content: space-between;
    }
    .title1 .admin .a-img img{
        width:70px;
        height: 70px;
    }
    .admin{
        display: flex;
        flex-direction: column;
    }
</style>

<?php

}


?>