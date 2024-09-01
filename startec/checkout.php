<?php session_start();
include 'connection.php';
?>
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

   }?>
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
                <h3>Enter Serial Number</h3>
            </div>
            <div class="search-form">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="text" name="search_input" id="" placeholder="Serial number">
                    <button  name="search">Enter</button>
                </form>
            </div>
            <hr>
            <div class="content1">
            <div class="list2">
                <span class="item">Item</span>
                <span class="snumber">Serial Number</span>
                <span>Available Qty.</span>
                 
               </div>
               <?php

if(isset($_POST['go'])){
    $cname = $_POST['cname'];
    $cphone = $_POST['cphone'];
    $caddress = $_POST['caddress'];
    $date = date("Y-m-d");
    $total1 = $_POST['total_price1'];
    $paid = $_POST['paid'];
    $overdue = $_POST['balance'];
    $topic=$_POST['topic'];
     

    $sql1 = "INSERT INTO customer(cname, cphone, caddress) VALUES ('$cname', '$cphone', '$caddress')";
    $cadd = mysqli_query($connect, $sql1);
    
    if($cadd){
        $cid = mysqli_insert_id($connect);
        
        $oadd = "INSERT INTO `order` (topic,invoice_no, O_date, O_total, CID, paid_amount, overdue_amount) VALUES ('$topic',NULL, '$date', '$total1', '$cid', '$paid', '$overdue')";
        $a_run = mysqli_query($connect, $oadd);
        $oid=mysqli_insert_id($connect);
        $invoice= "QEH".date("yd")."00".$oid;
        if($a_run)
        {
            $invoiceadd="UPDATE `order` SET invoice_no='$invoice' where O_ID='$oid'";
            $invoiceRun=mysqli_query($connect,$invoiceadd);
            if($invoiceadd){
                $addbill="INSERT INTO bill(OID,PID,B_qty) values(?,?,?)";
                $stmt=mysqli_prepare($connect,$addbill);
                $result=false;

                foreach($_SESSION['cart'] as $index=> $item){
                    $pid=$item['p_id'];
                    $Qty=$item['p_qty'];
                    mysqli_stmt_bind_param($stmt,"iii",$oid,$pid,$Qty);
                    $final_query=mysqli_stmt_execute($stmt);
                   if($final_query){
                    $result=true;
                   }
                   
                }
                if($result==true){
                    unset($_SESSION['cart']);
                    ?>
                    <script>
                        alert("done");
                        
                    </script><?php
                }else{
                    ?>
                    <script>
                        alert("error");
                    </script><?php
                }
            }

            
             

           
            
        }
    } else {
        echo "<script>alert('error adding customer');</script>";
    }
}


?>

               <?php 
               include 'connection.php';
               if(isset($_POST['search'])){
                $serial_id=$_POST['search_input'];
                $sql="SELECT * FROM products where serial_number='$serial_id'";
                $run=mysqli_query($connect,$sql);
                if(mysqli_num_rows($run)){
                    while($show=mysqli_fetch_array($run)){?>
                        <div class="list2">
                        <form action="" method="post" enctype="multipart/form-data">
                        <span class="item"><?php echo $show['P_name'];?></span>
                        <span class="snumber"><?php echo $show['serial_number'];?></span>
                        <span class="qty1"><?php echo $show['P_Qty'];?></span>
                        
                        <span class="input"><input type="number" name="qty" id="" class="input1" >
                    <input type="hidden" name="quantity" id="" value="<?php echo $show['P_Qty'];?>"></span>
                        <span class="btn">
                       
                            <input type="hidden"name="pid" value="<?php echo $show['P_ID'];?>">
                            <input type="hidden" name="uprice" id="" value="<?php echo $show['P_unit_price'];?>">
                          
                        <button class="addbtn" name="addcart">ADD</button></span> </form> 
                       </div><?php
                    }
                }
               }


               if(isset($_POST['addcart'])){
                 $P_ID=$_POST['pid'];
                 $qty=$_POST['qty'];
                 $uprice=$_POST['uprice'];
                 $stotal=$qty* $uprice;
                 $quantity=$_POST['quantity'];
                 $new_qty=$quantity-$qty;
                 

                $items=array(
                    'p_id'=>$P_ID,
                    'p_qty'=>$qty,
                    'up_price'=>$uprice,
                    'utotal'=>$stotal,
                );
                if(isset($_SESSION['cart'])){
                     $_SESSION['cart'][]=$items;
                }else{
                    $_SESSION['cart'][0]=$items;
                }

                

                $update="UPDATE products set P_Qty='$new_qty' where P_ID='$P_ID'";
                $run=mysqli_query($connect,$update);
                
               }
               if(isset($_POST['remove'])){
                 $rqty=$_POST['rqty'];
                 $rpid=$_POST['rpid'];
                 $qtynew=$_POST['qtynew'];
                $removeIndex=$_POST['index'];
                if(isset($_SESSION['cart'][$removeIndex])){
                    unset($_SESSION['cart'][$removeIndex]);
                    $_SESSION['cart'] = array_values($_SESSION['cart']); 
                }
                $new_quantity1=$rqty+$qtynew;
                
              $reupdate="UPDATE products set P_Qty='$new_quantity1' where P_ID='$rpid'";
              $reupdate_run=mysqli_query($connect,$reupdate);

        
            }

?>

            </div>
            <?php

if(isset($_SESSION['cart'])&& !empty($_SESSION['cart'])){?>
            <div class="content2">
                
                <div class="list-content">
    <h3>Selected Items</h3>
    
    <div class="list">
         
        <span class="item-name">Item</span>
        <span class="serial-number">Serial</span>
        <span class="Qty">Qty</span>
        <span class="uprice">Unit price</span>
        <span class="total">Total</span>
        <span class="remove">Remove</span>
    </div>

   
<?php
$netTotal=0;
        foreach($_SESSION['cart'] as $index=> $item){
            $PID=$item['p_id'];
            $pqty=$item['p_qty'];
            $total=$item['utotal'];
            
           
            
            $sql3="SELECT * FROM  products where P_ID='$PID'";
            $run3=mysqli_query($connect,$sql3);
            if(mysqli_num_rows($run3)){
                while($show=mysqli_fetch_array($run3)){?>
                    <div class="list">
        
        <span class="item-name"><?php echo $show['P_name'];?></span>
        <span class="serial-number"><?php echo $show['serial_number'];?></span>
        <span class="Qty"> <?php echo $pqty;?></span>
        <span class="uprice"><?php echo "Rs.",number_format($show['P_unit_price']);?></span>
        <span class="total"><?php  
                                  echo "Rs.",number_format($total);?></span>
        <form action="" method="post" enctype="multipart/form-data"><span class="remove"></span>
            <input type="hidden" name="index" value="<?php echo $index;?>">
            <input type="hidden" name="rqty" value="<?php echo $pqty;?>">
            <input type="hidden" name="qtynew" id="" value="<?php echo $show['P_Qty'];?>">
            <input type="hidden" name="rpid" id="" value="<?php echo $PID;?>">
       <button name="remove" class="rmve">Remove</button></span> </form>
       
       
    </div><?php
   
                }
                  
            }
            $netTotal += $total;
           
        }
       
        ?>
        <hr>
        <div class="total-container">
        <span>Net Total : Rs.<?php echo number_format($netTotal);?></span>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="total_price1" id="" value="<?php echo $netTotal;?>">
       
        <button class="contin" name="continue">Continue</button> </form>
        </div> <?php
    }

   
    ?>    <style>
         .form2 h2{
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            margin-bottom: 30px;
            
        }
        .closeform2{
            float: right;
    font-size: 40px;
    font-weight: 800;
    cursor: pointer;
        }
         .form2 form span{
            margin-bottom: -15px;
        }
         .form2 form{
            display: flex;
    flex-direction: column;
    gap: 20px;
        }
        .form2 form input{
            padding: 10px;
    border: none;
    border-radius: 2px;
    outline: none;
        }
       .form2 button{
            background: linear-gradient(45deg, #32519d, #233cb0);
    border-radius: 3px;
    border: none;
    color: white;
    font-size: 15px;
    padding: 10px;
    text-transform: uppercase;
    font-weight: bold;
        }
       .form2{
            width: 30%;
    padding: 30px;
    background: #c8c8d9f2;
    position: absolute;
    top: 100px;
    scale:1;
    transition: all 0.2s ease-in;
    left: 500px;
    box-shadow: 0 0 4px rgb(0, 0, 0, 0.7);
        }
        .pay{
            display: flex;
            justify-content: space-between;
            margin-bottom:20px;
            gap:10px;
            align-items: center
        }
        .pay span{
            display: flex;
            flex-direction: column;
        }
    </style>

</div>
            </div>
            <div class="form">
            <?php
            if(isset($_POST['continue'])){
                $nteTotal1=$_POST['total_price1'];
        ?>
        
       <div class="form2">
        <div class="closeform2">&times;</div>
        <h2>Enter Customer name</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <span>Topic</span>
            <input type="text" name="topic" id="">
            <span>Customer Name</span>
            <input type="text" name="cname" id="" required>
            <span>Phone</span>
            <input type="number" name="cphone" id="" required>
            <span>Address</span>
            <input type="text" name="caddress" id="" required>
            <input type="hidden"  name="total_price1" id="totalprice1" value="<?php echo $nteTotal1;?>">
            <hr>
            <div class="pay">
                <span>Now Paying
                <input type="number" name="paid" id="total_value" value="<?php echo $nteTotal1;?>" onkeydown="checkEnter(event);"></span>
                <span class="balance-payment">Balance Payment
                <h4 class="final">Rs.0</h4></span>
                <input type="hidden" name="balance" id="balance">
            </div>
            <script>
    function checkEnter(event) {
        if (event.key === "Enter") {
            event.preventDefault();
             var total_value=document.querySelector("#total_value").value;
             var total_price=document.querySelector("#totalprice1").value;
             var final=document.querySelector(".final");
             var balance=document.querySelector("#balance");
             final.textContent=total_price-total_value;
             balance.value=final.textContent;

         
            var btngo=document.querySelector(".button-go");
            btngo.innerHTML=`<button name="go" id="btn1">Next</button>`;
            var btn1=document.querySelector(".btn1");
             
        }
    }
</script>
             
            <div class="button-go"></div>
            

    </form>
    </div>

        <?php
    }
    
    
    ?>
    


    </div>

        </div>
        </div>
        </div>
        <script>
           var qty = parseInt(document.querySelector(".qty1").textContent);
    var inputqty = document.querySelector(".input1");
    var addbtn = document.querySelector(".addbtn");

    addbtn.addEventListener('click', function(evnt) {
        var enteredQty = parseInt(inputqty.value);
        
        if (enteredQty > qty) {
            evnt.preventDefault();
            alert("No more quantities available");
        }
    });


        </script>
        </div>
        <script>
         var form2=document.querySelector(".form2");
       var closebtn2=document.querySelectorAll(".closeform2");
       closebtn2.forEach(cls2 => {
        cls2.addEventListener('click',function(){
            form2.style.scale="0";
       });
        
        })
    </script>
        </body>
        </html>
        <style>
            .contin{
                background: linear-gradient(45deg, #332e2e, #4b3d3d);
    color: white;
    border: none;
    padding: 13px 30px;
    font-size: 17px;
    border-radius: 5px;
    text-transform: uppercase;
    font-weight: 900;
    box-shadow: 0 0 3px black;
    font-family: 'Roboto';
            }
            .total-container span{
                font-size: 25px;
    font-family: 'Roboto';
    font-weight: 900;
    color: #3e3636;
            }
            .total-container{
                display: flex;
                justify-content: space-between;
                padding: 20px;
                align-items: center;
            }
            button.rmve{
                border: none;
    padding: 10px 20px;
    background: linear-gradient(45deg, #34918b, #2bbc8c);
    color: white;
    font-family: 'Roboto';
    font-weight: 800;
    font-size: 17px;
    border-radius: 3px;
    box-shadow: 0 0 7px silver;
            }
            .list .img img{
                width: 80px;
                height: 80px;
            }
            .list-content{
                margin: 20px;
            }
            .total{
                width: 150px;
                display: inline-flex;
            }
            .uprice{
                display: inline-flex;
                width: 100px;
            }
            .Qty{
                display: inline-flex;
                width: 80px;
            }
            .list{
                padding: 10px;
                border-bottom: 1px solid black;
                padding-bottom: 10px;
                padding-top: 10px;
                display: flex;
                align-items: center;
                
            }
            .item-name{
                display: inline-flex;
                width:200px;
            }
            .serial-number{
                display: inline-flex;
                width: 100px;
            }
            .img{
                display: inline-flex;
                width: 100px;
            }
            .content2 h3{
                padding: 20px;
            }
            body{
                margin: 0;
                padding: 0;
            }
            .content2{
                height: 250px;
                overflow: hidden;
                border: 1px solid black;
                border-radius: 10px;
                overflow-y: scroll;
                
            }
            .btn{
                padding-left: 40px;
            }
            .btn button{
                padding: 12px 20px;
    border: none;
    background: linear-gradient(45deg, #8c2634, #8d3030);
    border-radius: 5px;
    color: white;
    font-weight: 800;
    font-family: 'Roboto';
    box-shadow: 0 0 4px #796d6d;
            }
            span.qty1{
               display: inline-flex;
                width: 150px;

            }
            .input input{
                padding: 10px 10px;
            }
            .content1{
                margin-top: 30px;
                height: 150px;
                
            }
            .list2{
                padding-top: 10px;
                padding-bottom: 10px;
                border-bottom: 1px solid black;
            }
            span.item{
                display: inline-flex;
                width:300px;

            }
            span.snumber{
                display: inline-flex;
                width:100px;
            }
            .search-form 
            {
                margin: 20px;
            }
            .search-form form input{
                padding: 10px 40px;
    border: 1px solid black;
    outline: none;
    text-align: left;
            }
            .search-form form button{
                padding: 11px 20px;
    border: none;
    background: linear-gradient(45deg, #335da1, #1b7b92);
    color: white;
    text-transform: uppercase;
    font-family: 'Roboto';
    font-weight: bold;
            }
            .container{
                gap: 10px;
                display: flex;
                
}
.body{
    margin: 20px;
    width: 100%;
}
            .title{
                margin: 20px;
    font-family: 'Roboto';
            }
        </style>