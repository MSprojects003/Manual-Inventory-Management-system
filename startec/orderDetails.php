<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php if(isset($_POST['viewo'])){
   include 'connection.php';
   $change=false;
   $oid=$_POST['oid'];

   $sql="SELECT * FROM customer c inner join `order` o on c.C_ID=o.CID where o.O_ID = '$oid'";
   $run=mysqli_query($connect,$sql);
   if(mysqli_num_rows($run)){
    while($show=mysqli_fetch_array($run)){
        
    
?>
    <div class="container">
    <button class="btn1">Go back</button>
<h2>Order Details</h2> 

<script>
    var btn1=document.querySelector(".btn1");
    btn1.addEventListener('click',function(){
        window.location.href=document.referrer;
    });
</script>

<hr> 
     <div class="invoice-number">
        invoice : <?php echo $show['invoice_no'];?>
     </div>
     <div class="odate">Date : <?php echo date("M d, Y", strtotime($show['O_date']));?></div>
     <br>
     <br>
     <div class="customer">
        <div class="head">
        <div class="cname">Customer : </div>
        <div class="cphone">Phone : </div>
        <div class="address">Address : </div>
        </div>
        <div class="h-details">
            <div class="cd-name"><?php echo $show['cname'];?></div>
            <div class="cd-phone"><?php echo $show['cphone'];?></div>
            <div class="cd-address"><?php echo $show['caddress'];?></div>

        </div>
     </div><?php 
     ?>
     <div class="items">
        <div class="list" style="font-weight:600;">
            <span class="serial">serial</span>
            <span class="item">Item</span>
            <span class="price">Unit price</span>
            <span class="qty">Qty.</span>
            <span class="total">Total</span>
            
        </div>
        <?php 
        $sql2="SELECT * FROM bill inner join products on bill.PID=products.P_ID where OID='$oid'";
        $run2=mysqli_query($connect,$sql2);
        if(mysqli_num_rows($run2)){
            while($show2=mysqli_fetch_array($run2)){?>
                <div class="list" >
                <span class="serial"><?php echo $show2['serial_number'];?></span>
                <span class="item"><?php echo $show2['P_name'];?></span>
                <span class="price"><?php echo $show2['P_unit_price'];?></span>
                <span class="qty"><?php echo $show2['B_qty'];?></span>
                <span class="total"><?php echo $show2['P_unit_price']*$show2['B_qty'];?></span>
                
            </div>
          <?php  }
        }


?>
        
        <div class="list">
            <span class="ftotal">Total : Rs.<?php echo number_format( $show['O_total'],2);?></span>
        </div>
     </div>
     <div class="paid-status">
        <div class="paid">
            
           Paid : <?php    $paid=$show['paid_amount'];
           echo $paid;?>
        </div>
       
            <?php $pending = $show['overdue_amount'];
                             if($pending==0){
                                ?>
<h3 class="completed">Payments Completed</h3>
                                <?php
                             }else{
                                ?>
                                 <div class="pending">Pending : Rs.<?php
                             echo $pending; 
                             $change=true;
                             ?></div>
                             
                             
                             <?php
                             }?>
       
     </div>


</div>
<?php 
   

if($change==true){

    



    ?>
<div class="change">
<span>Complete Overdue Payment </span>
    <form action="updateBalance.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="oidd" value="<?php echo $oid;?>">
        <input type="hidden" name="pending" value="<?php echo $pending;?>">
        <input type="hidden" name="paid" id="" value="<?php echo $paid;?>">
        <input type="number" name="newpending" id="" >
        <button name="pay">OK</button>
    </form>
</div>

<?php

}?>
<div class="generate">
     
        
    <a href="invoice.php?oid=<?php echo $oid;?>">View Invoice</a>
    
</div><?php
}}
?>

<?php
}
?>
</body>
</html>
<style>
    .generate{
        margin: 40px;
    }
    .generate a{
        border: 1px solid red;
    padding: 10px 30px;
    font-size: 20px;
    text-transform: uppercase;
    text-decoration: none;
    background: none;
    font-weight: 900;
    font-family: 'Roboto';
    color: #5a5151;
    transform: transition;
    }
    .generate button:hover{
        background: linear-gradient(45deg, #bd2626, #710909);
        color: white;
         
        transition: 0.9s ease-in-out;
    }
    .change span{
        color: blue;
        font-weight: 900;
        font-family: 'Roboto';
        font-size: 20px;
        margin:5px;
    }
    .change{
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .change form button{
        padding:10px 30px;
        border: none;
        background-color: black;
        color: red;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        font-weight: 800;

    }
    .change form input{
        padding: 10px 60px;
        border-radius: 0px;
        border: 1px solid black;
    }
    .completed{
        color:blue;
    }
    .invoice-number{
        font-size: 30px;
    font-family: 'Roboto';
    font-weight: 900;
    color: #306c89;
    }
    .paid-status{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        width: 70%;
        align-items: center;
        margin: 10px;
    }
    .pending{
        font-size: 20px;
    color: red;
    font-family: 'Roboto';
    font-weight: 900;
    text-transform: uppercase;
}
    
    .paid{
        font-size: 20px;
    font-weight: 800;
    text-transform: uppercase;
    font-family: 'Roboto';
    }
    .ftotal{
        font-weight: 800;
        font-size: 20px;
        font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    }
    .serial{
        display: inline-flex;
    width: 150px;
    }.serial, .item, .price, .qty, .total {
            display: inline-block;
        }
        .serial {
            width: 150px;
        }
        .item {
            width: 400px;
            flex-wrap: wrap;
            white-space: normal;
            overflow-wrap: break-word;
            word-wrap: break-word;
        }
        .price {
            width: 150px;
        }
        .qty {
            width: 100px;
        }
        .total {
            width: 100px;
        }
    .list{
        display: flex;
        gap: 10px;
        border-bottom: 1px solid black;
        padding-top: 10px;
        padding-bottom: 10px;
    }


.items{
padding: 30px;
border: 1px solid black;
margin-bottom: 20px;

width: 80%;
background: linear-gradient(45deg, #e5d8d8, #f0e6e6);
}
    .customer{
        display: flex;
    gap: 20px;
    border: 1px solid black;
    border-radius: 5px;
    padding: 40px;
    width: 60%;
    }
    .h-details{
        font-size: 17px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    font-family: 'Roboto';
    }
    .head {
        font-size: 17px;
    font-weight: 600;
    display: flex;
    flex-direction: column;
    gap: 10px;
    font-family: 'Roboto';
    text-transform: uppercase;
    width: 20%;
    }
    .container{
        margin: 40px;
        display: flex;
        flex-direction: column;
        gap: 20px
    }
    button.btn1{
    border: none;
    border-radius: 5px;
    padding: 13px 30px;
    font-size: 15px;
    font-family: 'Roboto';
    text-transform: uppercase;
    font-weight: 600;
    background: linear-gradient(45deg, #295388, #4679db);
    color: wheat;
    box-shadow: 0 0 4px rgb(0, 0, 0, 0.6);
    width:20%;
    }
</style>