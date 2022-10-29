<?php
    session_start();
    include('product.php');

    $errors = array();

    if(isset($_POST['productdb'])){
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $code = mysqli_real_escape_string($conn, $_POST['code']);
        $price = mysqli_real_escape_string($conn, $_POST['price']);

        if(empty($name)){
            array_push($errors, "product name is required");
        }
        if(empty($email)){
            array_push($errors, "code name is required");
        }
        if(empty($password_1)){
            array_push($errors, "price is required");
        }

        $user_check_query = "SELECT * FROM product WHERE code = '$code' ";
        $query = mysqli_query($conn, $user_check_query);
        //$result = mysqli_fetch_assoc($query);

        if($result){        //if user exists
            if($result['code'] === $code){
                array_push($errors, "Username already exists");
            }
    
        }
        if(count($errors) == 0){
            //$password = md5($password_1);

            $sql = "INSERT INTO product (code, price) VALUES ('$code', '$price')";
            mysqli_query($conn, $sql);

            $_SESSION['code'] = $code;
            $_SESSION['success'] = "You are now logged in";
            header('location: admin.php');
        }
    }
?>

