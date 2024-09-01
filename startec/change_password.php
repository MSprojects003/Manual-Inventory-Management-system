
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="form1">
        <div class="numberform">
        <a href="index.php" class="back">Go back</a>
            <h2>Check Phone Number</h2>
            <form action="" method="post" enctype="multipart/form-data" class="form-1">
                <span>Enter the Phone Number : <input type="number"name="number" placeholder="+94..."></span>
                <button name="check">Check</button>
            </form>
        </div>
    </div>
    <?php 
    include 'connection.php';

if(isset($_POST['check'])){
    $number=$_POST['number'];
     
    $sql="SELECT * from Admin";
    $run=mysqli_query($connect,$sql);
    if(mysqli_num_rows($run)){
        while($show=mysqli_fetch_array($run)){
            if($number==$show['phone_number']){
                ?>

                <script>
                    var form1=document.querySelector(".form-1");
                    var content=document.querySelector(".numberform");
                    form1.style.display="none";
                    content.innerHTML=`
                     
                     <h2>New verification Details</h2>
                    <form action=""method="post" enctype="multipart/form-data">
                    <span>New Username :
                    <input type="text" name="uname" ></span>
                    <span>New Password :
                    <input type="password" name="paswd"></span>
                    <button name="edit">OK</button>
                </form>
                    
                    `;
                     
                </script>
                
                <?php

            }else{?>
                <script>
                    alert("Incorrect Number");
                   
                </script>
                <?php
            }
        } 

    } 
}



if(isset($_POST['edit'])){
    $uname=$_POST['uname'];
    $paswd=password_hash($_POST['paswd'],PASSWORD_BCRYPT);
    $sql2 = "UPDATE Admin SET Admin.user_name='$uname', Admin.password='$paswd' WHERE Admin.A_ID=1";

    $query=mysqli_query($connect,$sql2);
    if($query){
        ?>
        <script>
          alert("Password has Changed");
        </script>
        <?php
    }else{
        ?>
        <script>
          alert("Failed to change the Details");
        </script>
        <?php
    }
}
?>

</body>
</html>
<style>
    .back{
    position: absolute;
    top: 15px;
    text-decoration: none;

    margin-left: -390px;
    padding: 10px 20px;
    background: black;
    color: white;
    border: none;
    border-radius: 2px;
    }
    .form1{
        display: flex;
    justify-content: center;
     
    }
    form button{
        padding: 10px 50px;
    border: none;
    border-radius: 2px;
    background: black;
    color: white
    }
    .numberform form{
        display: flex;
        gap:20px;
        flex-direction: column;
        align-items: center;

    }
    form input{
        padding: 10px;
        border: none;
        outline: none;
        border-radius: 2px;
    }
    .numberform{
    background: silver;
    width: 500px;
    height: 300px;
    align-items: center;
    display: flex;
    flex-direction: column;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
    justify-content: center;
    }
</style>