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
        <div class="body2">
          
        <div class="content">
            <form action="search.php" method="post" enctype="multipart/form-data">
                <input type="text" name="inputsearch" placeholder="Search" id="">
                <button name="searchbtn">Search</button>
            </form>
            
            <?php

            
if(isset($_POST['editbtn'])){
    include 'connection.php';
    $pid=$_POST['pid'];
    $editview="SELECT * FROM products where P_ID='$pid'";
    $run2=mysqli_query($connect,$editview);
    if(mysqli_num_rows($run2)){
        while($show2=mysqli_fetch_array($run2)){
            ?>
       

       <div class="form2" style="scale:1 !important;">
        <div class="closeform2">&times;</div>
        <h2>Edit Product Details</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <span>Serial Number</span>
            <input type="text" name="eserial" id="" value="<?php echo $show2['serial_number'];?>">
            <span>Product Name</span>
            <input type="text" name="ename" id=""  value=<?php echo $show2['P_name'];?> required>
            <span>Price</span>
            <input type="number" name="eprice" id="" value="<?php echo $show2['P_unit_price'];?>"required>
            <span>Info</span>
            <input type="text" name="einfo" id="" value="<?php echo $show2['P_Description'];?>" required>
            <span>Company/Brand </span>
            <input type="text" name="ecompany" id="" value="<?php echo $show2['P_Company'];?>">
            <span>Qty.</span>
            <input type="number" name="eqty" id="" value="<?php echo $show2['P_Qty'];?>"required>
           <span>Category</span>
           <select name="e_category" id="" value="<?php echo $show2['P_Qty'];?>"required>
           <option value="Laptop" <?php if($show2['P_category']=='Laptop') echo 'selected' ?>>Laptop</option>
                <option value="Accessory" <?php if($show2['P_category']=='Accessory') echo 'selected' ?>>Accessory</option>
                <option value="Software" <?php if($show2['P_category']=='Software') echo 'selected' ?>>Software</option>
                
            </select>
            <span>Warranty</span>
            <input type="text" name="ewaranty" value="<?php echo $show2['waranty'];?>">
         
            
            <input type="hidden" name="pid" id="" value="<?php echo $show2['P_ID'];?>">
            <button name="edit">Add</button>
        </form>
    </div>
    
<?php
     
    }
}

}
if(isset($_POST['edit'])){
    include 'connection.php';
       // Collect other form data
       $pid=$_POST['pid'];
       $ename = $_POST['ename'];
       $eprice = $_POST['eprice'];
       $einfo = $_POST['einfo'];
       $ecompany = $_POST['ecompany'];
       $eqty = $_POST['eqty'];
       $e_category = $_POST['e_category'];
       $ewaranty=$_POST['ewaranty'];
       $eserial=$_POST['eserial'];
       
   
       
        
       $edit="UPDATE products set serial_number='$eserial', P_name='$ename', P_Description='$einfo', P_Company='$ecompany', 
       P_category='$e_category', P_unit_price='$eprice', P_Qty='$eqty',waranty='$ewaranty' where P_ID='$pid'";
       $editQ=mysqli_query($connect,$edit);
       if($edit){
           ?>
           <script>
               alert("Details Have Updated Succesfully");
           </script>
           <?php
       }else{
           ?>
           <script>
               alert("Details updated failed");
           </script>
           <?php
       }
}


?>
            
        </div>
        <hr>
        <div class="details">
        
        <div class="list2">
        <div class="item">ITEM</div>
        <div class="price">UNIT_PRICE</div>
        <div class="qty">QTY</div>
        <div class="date">DATE</div>
        <div class="company">COMPANY</div>
        <div class="category">CATEGORY</div>
        <div class="action">ACTION</div>
        </div>
        <?php 

       if(isset($_POST['searchbtn'])){
        include 'connection.php';
            $search_input=$_POST['inputsearch'];
             if($search_input!=empty(true)){
                
              
    
             
            $search="SELECT * FROM products where serial_number like '%$search_input%' order by P_ID desc";
            $searchrun=mysqli_query($connect,$search);
            if(mysqli_num_rows($searchrun)>0){
                while($show=mysqli_fetch_array($searchrun)){?>
                    <div class="list2">
                    <div class="item"><?php echo $show['P_name'];?></div>
        <div class="price"><?php echo "Rs.",number_format($show['P_unit_price']),".00";?></div>
        <div class="qty"><?php echo $show['P_Qty'];?></div>
        <div class="date"><?php echo date("M d, y",strtotime($show['P_issue_date']));?></div>
        <div class="company"><?php echo $show['P_Company'];?></div>
        <div class="category"><?php echo $show['P_category'];?></div>
        <div class="action">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="pid" value="<?php echo $show['P_ID'];?>">
            <button name="editbtn"style="padding: 5px 10px;
    background: linear-gradient(45deg, #206f78, #1b4a81);
    border: none;
    border-radius: 3px;
    font-size: 13px;
    color: white;
    text-transform: uppercase;
    font-weight: bold;">Edit</button></form></div>
                    </div><?php
                }
            }else{
                ?>
                <h2>
                    No Products Found!
                </h2>
                <?php
            }}else{
                 echo "Empty Value Given !";
            }
       }




?>




        </div>
        </div> </div>
              
        </div>
        <script>
               var closeform2=document.querySelector(".closeform2");
    var form2=document.querySelector(".form2");
    closeform2.addEventListener('click',function(){
form2.style.scale="0"
form2.style.transition="0.3s";
    })
        </script>
<style>
.form2{
            height: 400px;
            overflow: hidden;
            overflow-y: scroll
        }
        .form2 h2{
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            margin-bottom: 30px;
            
        }
        .closeform1,.closeform2{
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
    scale:0;
    transition: all 0.2s ease-in;
    left: 500px;
    box-shadow: 0 0 4px rgb(0, 0, 0, 0.7);
        }
</style>
        <style>
            .content form input{
                padding: 10px 40px;
                border: 1px solid black;
                outline: none;

            }
            content form button{
                background: black;
                padding: 6px;
            }
             .list2 .item{
        width:30%;
          
    }
    .list2 .price{
        width: 13%;
    }
   .list2 .qty{
    width:5%;
   }
   .list2 .date{
    width: 8%;

   }
   .list2 .category{
    width: 13%;
   }
   .list2 .company{
    width: 10%;
   }
            .details .list2{
                display: flex;
                flex-direction: row;
                gap:20px;

            }
            .body2{
                margin-left: 30px;
                margin-right: 30px;
                width: 100%;
            }
            .content form input{
                padding: 10px 40px;
                border: 1px solid black;
                outline: none;
            }
            .content form button{
                border: none;
                background-color: black;
                color: white;
                padding: 11px 10px;
            }
            .content{
                margin-top:50px;
               margin-bottom: 20px;
            }
          .container{
            display: flex;
          }

        </style>
        </body>
        </html>