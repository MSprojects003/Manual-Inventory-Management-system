<?php
include 'connection.php';

if(isset($_POST['pay'])){
    $oid = $_POST['oidd'];
    $new = $_POST['newpending'];
    $new_pending = $_POST['pending'] - $new;
    $new_paid = $_POST['paid'] + $new;
    
    $sql3 = "UPDATE `order` SET paid_amount='$new_paid', overdue_amount='$new_pending' WHERE O_ID='$oid'";
    $run3 = mysqli_query($connect, $sql3);
    
    if($run3){
       ?>
       <script>
        window.location.href="summary.php";

       </script>
       <?php
        

    } else {
       echo "error";
    }
}
?>
