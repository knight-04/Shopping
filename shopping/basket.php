<?php

    session_start();

    require_once('dbcontroller.php');

    if(!empty($_GET["action"])){
        switch($_GET["action"]){
            case "add":
                if(!empty($_POST["quantity"])){
                    $select_add_query = "SELECT * FROM posts WHERE code='". $_GET["code"]. "'";
                    $result = mysqli_query($conn, $select_add_query);
                    while($row=mysqli_fetch_assoc($result)) {
                        $resultset[] = $row;
                    }
                    $productByCode = $resultset;
                    $itemArray = array($productByCode[0]["code"]=>(array('name'=>$productByCode[0]["name"],
                                                                        'code'=>$productByCode[0]["code"],
                                                                        'image'=>$productByCode[0]["image"],
                                                                        'price'=>$productByCode[0]["price"],
                                                                        'quantity'=>$_POST[0]["quantity"])));
                                                                            
                }
                if(!empty($_SESSION["cart_item"])){
                    if(in_array($productByCode[0]["post_id"], array_keys($_SESSION["cart_item"]))){
                        foreach($_SESSION["cart_item"] as $k => $v){
                            if($productByCode[0]["post_id"] == $k){
                                if(empty($_SESSION["cart_item"][$k]["quantity"])){
                                    $_SESSION["cart_item"][$k]["quantity"] = 0;
                                }
                                $_SESSION["cart_item"][$k]["quantity"] += $_POST["quantity"];
                            }
                        }
                    } else {
                        $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"], $itemArray);
                    }
                } else {
                    $_SESSION["cart_item"] = $itemArray;
                }
            break;
            case "remove":
                if(!empty($_SESSION["cart_item"])){
                    foreach($_SESSION["cart_item"] as $k => $v){
                        if($_GET["post_id"] == $k){
                            unset($_SESSION["cart_item"][$k]);
                        }
                        if(empty($_SESSION["cart_item"])){
                            unset($_SESSION["cart_item"]);
                        }
                    }
                }
            break;
            case "empty":
                unset($_SESSION["cart_item"]);
                unset($_SESSION["cart_vac"]);
            break;
            case "addvac";
                if(empty($_SESSION["cart_vac"])){
                    $vac_item = "vaccine";
                    $_SESSION["cart_vac"] = $vac_item;
                }
            break;   
            case "removevac":
                unset($_SESSION["cart_vac"]);
            break;
        }
    }

    if(isset($_POST['submitpayment'])){

        $total_pc = $_POST['tatoalprice'];
        $bsk_id = $_POST['basketID'];

        $insert_query_basket = "INSERT INTO `product`(`id`, `name`, `code`, `image`, `price`) VALUES ('','$bsk_id','$total_pc')";

        if(mysqli_query($conn, $insert_query_basket)){
            echo "<script>alert('insert update successfully');</script>";
            //เพิ่มตัวนี้เข้าไป
            unset($_SESSION["cart_item"]);
            unset($_SESSION["cart_vac"]);
            //เพ่มข้างบนเข้าไป
            //เด้งอัพเดตเสร็จจะเปลี่ยนไปหน้าview_stock.php
            header("location: payment.php");
            //ไม่อยากเด้งก็ไม่ใส่ก็ได้
        }else{
            echo "<script>alert('somthing wrong');</script>";
        }





    }


?>




<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <title>CAT store</title>
        <link rel="stylesheet" type="text/css" href="../css/mystyle.css">
    </head>
    <body>
        <header>
            <div class="container">
                <h1> <a href="../index.html">JIRANTHANIN CAT SHOP </a></h1>
            </div>
        </header>
        <div>
            <div style="text-align: left; margin-left: 2rem;">
                <button style="margin-right: 2rem; margin-top: 2rem" onclick="location.href='page21.php'">หน้าเลือกสินค้า</button>
            </div>

    
            <div style="text-align: right;">
                <a href="basket.php?action=empty" style="background-color: #ffffff; border: #d00000 1px solid; padding: 5px 10px; color: #d00000; text-decoration: none; border-radius: 3px;">Empty Cart</a>
            </div>
        </div>



        <div style="text-align: center; margin-left: 3rem;">
            <?php
                
                if(isset($_SESSION["cart_item"])){
                    $total_quantity = 0;
                    $total_price = 0;
                

            ?>
            <table class="tbl-cart" cellpadding="10" cellspacing="1" border="1">
                <tbody>
                    <tr>
                        <th style="text-align: center;">PostID</th>
                        <th style="text-align: left;">img</th>
                        <th style="text-align: left;">Name</th>
                        <th style="text-align: right;" width="5%">Quantity</th>
                        <th style="text-align: right;" width="10%">Unit Price</th>
                        <th style="text-align: right;" width="10%">Price</th>
                        <th style="text-align: center;" width="5%">Remove</th>
                    </tr>

                    <?php
                    
                        foreach($_SESSION["cart_item"] as $item){
                            $item_price = $item["quantity"] * $item["post_price"];
                        

                    ?>

                    <tr>
                        <td><?php echo $item["post_id"]; ?></td>
                        <td><img src="../img/admin/<?php echo $item["post_image"]; ?>" width="80" height="80" alt=""></td>
                        <td style="text-align: left;"><?php echo $item["post_species"]; ?></td>
                        <td style="text-align: right;"><?php echo $item["quantity"]; ?></td>
                        <td style="text-align: right;"><?php echo "฿ " .$item["post_price"]; ?></td>
                        <td style="text-align: right;"><?php echo "฿ " . number_format($item_price, 2); ?></td>
                        <td style="text-align: center;"><a href="basket.php?action=remove&post_id=<?php echo $item["post_id"]; ?>">DEL</a></td>
                    </tr>



                    <?php
                        $total_quantity += $item["quantity"];
                        $total_price += ($item["post_price"] * $item["quantity"]);
                        }
                    ?>

                    <tr>
                        <td colspan="3" align="right">Total:</td>
                        <td align="right"><?php echo $total_quantity; ?></td>
                        <td align="right" colspan="2"><?php echo "฿ ". number_format($total_price, 2) ?></td>
                        <td></td>
                    </tr>
                </tbody>

            </table>
            <?php } else { ?>
                <div class="no-records">Your cart is empty</div>
            <?php
            }
            ?>
        </div>
        <!--vaccine-->

        
        <div style="text-align: center; margin-left: 3rem;">
            <br>
            <?php
                /*add vaccine*/
                if(isset($_SESSION["cart_vac"])){


            ?>
            <table class="tbl-cart" cellpadding="10" cellspacing="1" border="1">
                <tbody>
                    <tr>
                        <th style="text-align: left;">img</th>
                        <th style="text-align: left;">Name</th>
                        <th style="text-align: right;" width="5%">Quantity</th>
                        <th style="text-align: right;" width="10%">Unit Price</th>
                        <th style="text-align: right;" width="10%">Price</th>
                        <th style="text-align: center;" width="5%">Remove</th>
                    </tr>

                    <?php
                        $vaccine_quantity = $_POST["quantityvac"];
                        $item_price_vac = $vaccine_quantity * 1000;

                    ?>

                    <tr>
                        <td><img src="../img/other/<?php echo "vaccine.jpg" ?>" width="80" height="80" alt=""></td>
                        <td style="text-align: left;"><?php echo "VACCINE"; ?></td>
                        <td style="text-align: right;"><?php echo $vaccine_quantity;?></td>
                        <td style="text-align: right;"><?php echo "฿ 1000"; ?></td>
                        <td style="text-align: right;"><?php echo "฿ " . number_format($item_price_vac, 2); ?></td>
                        <td style="text-align: center;"><a href="basket.php?action=removevac&vaccine">DEL</a></td>
                    </tr>

                    <?php
                        if(!empty($total_price)){
                            $totalprice_vac_and_cat = $total_price + $item_price_vac;
                        }
                        else{
                            $totalprice_vac_and_cat = $item_price_vac;
                        }
                    ?>

                    <tr>
                        <td colspan="3" align="right">Total(vaccine and cat):</td>
                        <td align="right" colspan="2"><?php echo "฿ ". number_format($totalprice_vac_and_cat, 2) ?></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <?php
            }else{
                $totalprice_vac_and_cat = 0;
            }
            ?>
        </div>
        <!--end vaccine-->
        <!--สินค้า-->
        <!---->

        <!--
            <?php
            
            $code = "VACCINE";
            $image_vac = "vaccine.jpg";
            $price_vac = 1000;
            
            ?>
            <div id="product-grid">
                <div class="txt-heading">Products</div>
                <div class="product-item">
                    <form action="basket.php?action=addvac&code=<?php echo $code; ?>" method="post">
                        <div class="product-image">
                            <img src="../img/other/<?php echo $image_vac; ?>" alt="img_vaccine" width="150" height="150">
                        </div>
                        <div class="product-title-footer">
                            <div class="product-title"><?php echo $code; ?></div>
                            <div class="product-price"><?php echo $price_vac; ?></div>
                            <div class="cart-action">
                                <input type="text" class="product-quantity" name="quantityvac" value="1" size="2">
                                <input type=submit value="Add to cart" class="btnAddAction">
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            -->

            <div>
                <form action="basket.php" method="post" style="margin-right: 3rem;">
                    <input type="hidden" id="bskID" name="basketID" value="<?php echo $item["post_id"] ?>">
                    <input type="hidden" id="custId" name="tatoalprice" value="<?php echo $total_price ?>">
                    <input class="btnAddAction" type="submit" name="submitpayment" value="payment" enctype="multipart/form-data">
                </form>
            </div>
        <!---->



    </body>
</html>