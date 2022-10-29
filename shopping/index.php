<?php 
    session_start();
    if(!isset($_SESSION['username'])){
        $_SESSION['msg'] = "You must log in first";
        header('location: login.php');
    }
    if(isset($_GET['logout'])){
        session_destroy();
        unset($_SESSION['username']);
        header('location: login.php');
        
    }
?>

<?php

    //session_start();
    require_once('dbcontroller.php');
    $db_handle=new DBController();

    if(!empty($_GET["action"])) {
        switch($_GET["action"]) {
            case "add":
                if(!empty($_POST["quantity"])) {
                    $productByCode = $db_handle->runQuery("SELECT * FROM product WHERE code='" . $_GET["code"] . "'");
                    $itemArray = array($productByCode[0]["code"]=>array('name'=>$productByCode[0]["name"], 
                                                                        'code'=>$productByCode[0]["code"], 
                                                                        'quantity'=>$_POST["quantity"], 
                                                                        'price'=>$productByCode[0]["price"], 
                                                                        'image'=>$productByCode[0]["image"]));
                }
                if(!empty($_SESSION["cart_item"])) {
                    if(in_array($productByCode[0]["code"],array_keys($_SESSION["cart_item"]))) {
                        foreach($_SESSION["cart_item"] as $k => $v) {
                            if($productByCode[0]["code"] == $k) {
                                if(empty($_SESSION["cart_item"][$k]["quantity"])) {
                                        $_SESSION["cart_item"][$k]["quantity"] = 0;
                                }
                                $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                            }
                        }
                    } else {
                        $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
                    }
                } else {
                        $_SESSION["cart_item"] = $itemArray;
            }    
            break;

            case "remove":
                if(!empty($_SESSION["cart_item"])) {
                    foreach($_SESSION["cart_item"] as $k => $v) {
                        if($_GET["code"] == $k)
                            unset($_SESSION["cart_item"][$k]);

                        if(empty($_SESSION["cart_item"]))
                            unset($_SESSION["cart_item"]);
                    }
                }
            break;
            case "empty":
                unset($_SESSION["cart_item"]);
            break;
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>shopping cart</title>
    <link rel="stylesheet" href="style1.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}


</style>
</head>
<body style="background-color: #FFE4E3;">
</br>
<div id="shopping-cart">
<div class="container">

    <a href="logout.php?action" id="btnLogout">Log out</a>
    <div class="txt-heading">Thyt SHOP</div>
    <a href="index.php?action=empty" id="btnEmpty">Empty Cart</a>
    
    
    <?php
        if (isset($_SESSION["cart_item"])) {
            $total_quantity=0;
            $total_price=0;
        
    ?>
    
    <table class="tbl-cart" cellpadding="10" cellspacing="1">
        <tbody >
            <tr  class="alert alert-dark" role="alert">
                    <th style="text-align: center; ">Name</th>
                    <th style="text-align:center;">Code</th>
                    <th style="text-align: center;" width="5%">Quantity</th>
                    <th style="text-align: center;" width="10%">Price</th>
                    <th style="text-align: center;" width="10%">Remove</th>
            </tr>

        <?php
            foreach($_SESSION["cart_item"] as $item) { //loop
                $item_pirce = $item["quantity"] * $item["price"];
        ?>
            <tr>
                    <td>
                        <img src="<?php echo $item["image"]; ?>" class="cart-item-image" alt="">
                        <?php echo $item["name"];?>
                    </td>
                    <td style="text-align:center;"><?php echo $item["code"];?></td>
                    <td style="text-align:center;"  width="5%"><?php echo " " . $item["quantity"];?></td>
                    <td style="text-align:center;"  width="10%"><?php echo "฿ " . $item["price"];?></td>
                    <td style="text=align:center"><a href="index.php?action=remove&code=<?php echo $item["code"]; ?>" 
                        id="btnRemoveAction">Remove</a></td>
            </tr>
                <?php
                    $total_quantity += $item["quantity"];
                    $total_price += ($item["price"] * $item["quantity"]);
            }
                ?>

            <tr>
                    <td colspan="2" style="text-align:right;">Total:</td>
                    <td style="text-align:center;"><?php echo $total_quantity; ?></td>
                    <td style="text-align:center;" colspan="1"><?php echo "฿ " . $total_price; ?></td>
                    <td style="text=align:center"><a href="payment.php?action" id="btnPayment">Payment</a></td>
                    
            </tr>
        </tbody>
    </table>
    <?php
        } else {
    ?>
    <div class="no-records">Your cart is Empty</div>
    <?php
            }
    ?>
    <br/>
    
    <div id="product-grid">
        <div class="txt-heading">Product</div>

        <?php
            $product_array=$db_handle->runQuery("SELECT * FROM product ORDER BY id ASC");

            if (!empty($product_array)) {
                foreach($product_array as $key => $value) {
        ?>
        <div class="product-item"> 
        
            <form action="index.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>" 
                                                    method="post" class="alert alert-light" role="alert">
                <div class="product-image" style="text-align:center;" >            
                        <img src="<?php echo $product_array[$key]["image"]; ?>" alt="images">
                </div>
            
                <div class="product-title-footer" style="text-align:left;">
                    <div class="product-title"><?php echo $product_array[$key]["name"]; ?></div>
                    <div class="product-price"><?php echo "฿ " . $product_array[$key]["price"]; ?></div>
                    <div class="cart-action" style="text-align:right;">
                        <input type="text" class="product-quantity" name="quantity" value="1" size="2">                    
                        <input type="submit" value="Add to cart" class="btnAddAction">
                    </div>
                </div>
            </form>
        </div>

        <?php
                }
            }
        ?>
    </div>
</body>
</html>
