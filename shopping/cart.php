<?php

    session_start();
    require_once('dbcontroller.php');
    $db_handle=new DBController();

    <div class="dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
										<i class="fa fa-shopping-cart"></i>
										<span>Your Cart</span>
										<div class="badge qty">0</div>
									</a>
									<div class="cart-dropdown"  >
										<div class="cart-list" id="cart_product">
										
											
										</div>
										
										<div class="cart-btns">
												<a href="cart.php" style="width:100%;"><i class="fa fa-edit"></i>  edit cart</a>
											
										</div>
									</div>
										
								</div>
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>shopping cart</title>
    <link rel="stylesheet" href="style.css">

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
<body>
</br>

<div id="shopping-cart">
<div class="container">
    <div class="txt-heading">Shopping Cart</div>
    <a href="index.php?action=empty" id="btnEmpty">Empty Cart</a>

    <?php
        if (isset($_SESSION["cart_item"])) {
            $total_quantity=0;
            $total_price=0;
        
    ?>
    <table class="tbl-cart" cellpadding="10" cellspacing="1">
        <tbody >
            <tr  class="alert alert-dark" role="alert">
                    <th style="text-align: left; ">Name</th>
                    <th style="text-align:center;">Code</th>
                    <th style="text-align: right;" width="5%">Quantity</th>
                    <th style="text-align: right;" width="10%">Price</th>
                    <th style="text-align: right;" width="10%">Remove</th>
            </tr>

        <?php
            foreach($_SESSION["cart_item"] as $item) {
                $item_pirce = $item["quantity"] * $item["price"];
        ?>
            

            <tr>
                    <td>
                        <img src="<?php echo $item["image"]; ?>" class="cart-item-image" alt="">
                        <?php echo $item["name"];?>
                    </td>
                    <td style="text-align:center;"><?php echo $item["code"];?></td>
                    <td style="text-align:right;"  width="5%"><?php echo "฿ " . $item["quantity"];?></td>
                    <td style="text-align:right;"  width="10%"><?php echo $item["price"];?></td>
                    <td style="text=align: right"><a href="index.php?action=remove&code=<?php echo $item["code"]; ?>" class="btnRemoveAction"><img src="product-image/rainbow.jpg" alt=""></a></td>
                    
            </tr>

                <?php
                    $total_quantity += $item["quantity"];
                    $total_price += ($item["price"] * $item["quantity"]);
            }
                ?>

            <tr>
                    <td colspan="2" style="text-align:right;">Tatal:</td>
                    <td style="text-align:right;"><?php echo $total_quantity; ?></td>
                    <td style="text-align:right;" colspan="2"><?php echo "฿ " . $item["quantity"]; ?></td>
                    
                    
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
        <div class="txt-heading">Euro's Product</div>

        <?php
            $product_array=$db_handle->runQuery("SELECT * FROM product ORDER BY id ASC");

            if (!empty($product_array)) {
                foreach($product_array as $key => $value) {
                
            
        ?>

        <div class="product-item">
            <form action="index.php?action=add&code=<?php echo $product_array[$key]["code"]; ?>" methode="post" class="alert alert-light" role="alert">
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
</div>
</div>
                
    
</body>
</html>
