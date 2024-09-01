<?php 



include 'connection.php';

$sql="INSERT INTO test(serial,name)values(NULL,'hello')";
$run=mysqli_query($connect,$sql);

if($run){
   $id=mysqli_insert_id($connect);
   $sid="hello".$id;
     
    $update="UPDATE test Set serial = '$sid'";
    $run2=mysqli_query($connect,$update);
    if($run2){
        echo"done";
    }else{
        echo "error";
    }
}




?>