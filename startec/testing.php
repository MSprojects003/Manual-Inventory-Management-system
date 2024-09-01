<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<?php 
session_start();

if (isset($_POST['add'])) {
  $item = array(
      'id' => ($_POST['pid']),
      'price' =>($_POST['price']),
  );

  if (isset($_SESSION['cart'])) {
      // Add the new item to the cart
      $_SESSION['cart'][] = $item;
  } else {
      // Initialize the cart with the first item
      $_SESSION['cart'][0] = $item;
  }
}

if(isset($_POST['remove'])){
  $indexid=$_POST['index'];
  if(isset($_SESSION['cart'][$indexid])){
    unset($_SESSION['cart'][$indexid]);
    $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex the array to avoid gaps
  }
}

// Display the cart contents
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {?>
  <table border="1">
    <tr>
      <th>ID</th>
      <th>Price</th>
      <th>Action</th>
    </tr>
    <?php
    foreach($_SESSION['cart'] as $index => $cartItem) { ?>
      <tr>
        <td><?php echo $cartItem['id']; ?></td>
        <td><?php echo $cartItem['price']; ?></td>
        <td>
          <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="index" value="<?php echo $index; ?>">
            <button name="remove">Delete</button>
          </form>
        </td>
      </tr>
    <?php } ?>
    <tr><td colspan="3"><?php 
    $total=0;
    foreach($_SESSION['cart'] as $cart){
      $total +=$cart['price'];
     
    }
    echo $total;
    
    ?></td></tr>
  </table>
<?php } ?>

<form action="" method="post" enctype="multipart/form-data">
  <label for="pid">Product ID:</label>
  <input type="text" name="pid" id="pid" required>
  <label for="price">Price:</label>
  <input type="number" name="price" id="price" required>
  <button name="add">Add to Cart</button>
</form>





<script>
    function updateQuantity() {
      var quantity = document.getElementById('quantity').value;
      var enteredValue = document.getElementById('enteredValue').value;

      if (enteredValue !== '') {
        enteredValue = parseInt(enteredValue);
        if (enteredValue <= quantity) {
          quantity -= enteredValue;
          document.getElementById('quantity').value = quantity;
        } else {
          alert('Entered value cannot be greater than the default quantity (' + quantity + ')');
          // Reset the entered value input field if needed
          document.getElementById('enteredValue').value = '';
        }
      }
    }
  </script>
</head>
<body>
  <form action="" method="post" enctype="multipart/form-data">
    <label for="quantity">Default Quantity:</label>
    <input type="number" id="quantity" name="quantity" value="10" readonly>
    <br><br>
    <label for="enteredValue">Enter Value:</label>
    <input type="number" id="enteredValue" name="enteredValue" onkeyup="updateQuantity()">
    <br><br>
    <button type="button" >Update Quantity</button>
  </form>
</body>
</html>
