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
        <div class="main">
        <div class="body">  <div class="title"><h3>Products</h3></div>
        <div class="add-btn"><button class="addbtn">Add New Entry</button></div>
    </div>
    <div class="body2">
    <form action="search.php" method="post" enctype="multipart/form-data" class="searchform">
                <input type="text" name="inputsearch" id="" placeholder="Search">
                <button name="searchbtn">Search</button>
            </form>
    </div>
    <br>
    <hr>
    <div class="scroll">
    <div class="list1">
        <span class="name">ITEM</span>
        <span class="id">Serial Number</span>
        <span class="date">date</span>
        <span class="price">amount</span>
        <span class="qty">Qty</span>
        <span class="actionbtns">Action</span>

    </div>
    <?php 
include  'connection.php';
  $view="SELECT * FROM products";
  $query1=mysqli_query($connect,$view);
  if(mysqli_num_rows($query1)>0){
    while($show=mysqli_fetch_array($query1)){
        ?>
<div class="list-details">
         <span class="name1"><?php echo $show['P_name'];?></span>
        <span class="id1"><?php echo $show['serial_number'];?></span>
        <span class="date1"><?php echo date("M d,Y",strtotime($show['P_issue_date']));?></span>
        <span class="price1"><?php echo "Rs.",number_format($show['P_unit_price']),".00";?></span>
        <span class="qty1"><?php echo $show['P_Qty'];?></span>
        <span class="actionbtns1"><form action="" method="post" enctype="multipart/form-data"><input type="hidden" name="pid" id="" value="<?php echo $show['P_ID'];?>"><button name="editbtn">Edit</button>
    </form></span>
    </div>

    

<?php
    }
  }else{
    ?>
    <div class="add-btn" style="display:flex; justify-content:center;align-items:center;
    flex-direction:column;padding:30px;gap:10px;color:red;"><h3>No Records Found !</h3><button class="addbtn">Add New Entry</button></div><?php
  }
?>
</div><?php
if(isset($_POST['editbtn'])){
    
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
    </div>
    </div>
    <div class="head">
        
     
    </div>
    </div>

    <div class="form1">
        <div class="closeform1">&times;</div>
        <h2>Add New Product</h2>
        <form action="" method="post" enctype="multipart/form-data">
        <span>Serial Number</span>
        <input type="text" name="serial" id="" required>
            <span>Product Name</span>
            <input type="text" name="pname" id="" required>
            <span>Price</span>
            <input type="number" name="pprice" id="" required>
            <span>Info</span>
            <input type="text" name="info" id="" required>
            <span>Company/Brand </span>
            <input type="text" name="company" id="">
            <span>Qty.</span>
            <input type="number" name="pqty" id="" required>
            <span>Category</span>
            <select name="p_category" id="">
            <option value="Laptop">Laptop</option>
                <option value="Accessory">Accessory</option>
                <option value="Software">Software</option>
                <option value="Service">Service</option>
            </select>
           <span>Warranty</span>
           <input type="text" name="warranty" id="">
            <button name="add">Add</button>
        </form>
    </div>

    <script>
        var addbtn=document.querySelectorAll(".addbtn");
        var closebtn=document.querySelector(".closeform1");
        var form1=document.querySelector(".form1");
      
        closebtn.addEventListener('click',function(){
            form1.style.scale="0";
        });
       addbtn.forEach(add_btn=> {
        add_btn.addEventListener('click',function(){
            form1.style.scale="1";
        })
       });
      

    </script>

    <script>
         var form2=document.querySelector(".form2");
       var closebtn2=document.querySelectorAll(".closeform2");
       closebtn2.forEach(cls2 => {
        cls2.addEventListener('click',function(){
            form2.style.scale="0";
       });
        
        })
    </script>

<?php 


include 'connection.php';

if(isset($_POST['add'])){
    $name=$_POST['pname'];
     $company=$_POST['company'];
    $price=$_POST['pprice'];
    $info=$_POST['info'];
    $category=$_POST['p_category'];
    $date = date("Y-m-d");
    $qty=$_POST['pqty'];
    $waranty=$_POST['warranty'];
    $serial_number=$_POST['serial'];
     

    $sql="INSERT INTO products (serial_number,P_name,P_issue_date,P_Description,P_Company,P_category,P_Unit_price,P_Qty,waranty)values('$serial_number','$name','$date','$info','$company','$category','$price','$qty','$waranty')";
    $run=mysqli_query($connect,$sql);
    if($run){
         
         
            ?>
            <script>
                alert("you have succesfully Added a New Entry");
            </script><?php
        }else{
            ?>
            <script>
                alert("you have an issue while add an New Entry");
            </script><?php
        }
        
    } 




?>
    <style>
       
        .form1,.form2{
            height: 400px;
            overflow: hidden;
            overflow-y: scroll
        }
        .scroll{
            height: 350px;
            
            overflow: hidden;
            overflow-y: scroll;
        
        }
        .list-details span.actionbtns1 button{
            
    padding: 5px 10px;
    background: linear-gradient(45deg, #206f78, #1b4a81);
    border: none;
    border-radius: 3px;
    font-size: 13px;
    color: white;
    text-transform: uppercase;
    font-weight: bold;
        }
        .actionbtns1 form{
            display: inline-flex;
            flex-direction: row;
            gap:3px;
            justify-content: center !important;
            margin-left:50px;

        }
        .list-details{
            padding-left: 30px;
            display: flex;
            padding: 10px;
            flex-direction: row;
            align-items: center;
            border-bottom: 1px solid black;
             
        }
        .searchform input{
            padding: 10px 40px;
            border: 1px solid black;
            outline: none;
        }
        .searchform button{
            padding: 11px 20px;
            background-color: black;
            color: white;
            border: none;
        }
        .name1{
            display: inline-flex;
            width: 340px;
        }
        .id1{
            display: inline-flex;
    width: 140px;
        }
        .date1{
            display: inline-flex;
    width: 120px;
        }
        .qty1{
            display: inline-flex;
     
        }
        .price1{
            display: inline-flex;
    width: 120px;
        }
        .form1 h2,.form2 h2{
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            margin-bottom: 30px;
            
        }
        .closeform1,.closeform2{
            float: right;
    font-size: 40px;
    font-weight: 800;
    cursor: pointer;
        }
        .form1 form span,.form2 form span{
            margin-bottom: -15px;
        }
        .form1 form, .form2 form{
            display: flex;
    flex-direction: column;
    gap: 20px;
        }
        .form1 form input,.form2 form input{
            padding: 10px;
    border: none;
    border-radius: 2px;
    outline: none;
        }
        .form1 button,.form2 button{
            background: linear-gradient(45deg, #32519d, #233cb0);
    border-radius: 3px;
    border: none;
    color: white;
    font-size: 15px;
    padding: 10px;
    text-transform: uppercase;
    font-weight: bold;
        }
        .form1,.form2{
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

        .title{
            font-size: 20px;
            text-transform: uppercase;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }
        .list1{
            margin-top: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid black;
        }
         
        .list1 span{
            text-transform: uppercase;
            font-size:14px;
            font-weight: 700;
        }
        .add-btn button{
            padding: 10px 15px;
    background: #84b43a;
    border: none;
    font-size: 13px;
    border-radius: 5px;
    color: white;
    text-transform: uppercase;
    font-weight: 800;
        }
        .name{
            padding-right:270px;
            padding-left: 30px;
            text-align: left;
        }
        .date{
            padding-right: 60px;
        }
        .id{
            padding-right: 30px;
        }
        .price{
            padding-right: 60px;

        }
        .qty{
            padding-right: 40px;
        }
        .main{
            width:100%;
            padding: 30px
        }
        .body{
            display: flex;
    justify-content: space-between !important;
    width: 100%;
    align-items: center;
     
        }
        .body2{
 margin-top: 40px;

        }
        .container{
            display: flex;
        }

    </style>
</body>
</html>