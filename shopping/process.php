<link rel="stylesheet" href="style3.css">

<body style="background-color: #FFE4E3;">
    <div align="center">
        <img src="product-image/31a3a48593db095619c3abc8e756b8e9.gif" class="kitty" alt="images">
    </div>
<?php include 'connect.php'; ?>
<?php
    $Name = $_POST['Name'];
    $Address = $_POST['Address'];
    $Tel = $_POST['Tel'];
    $Email = $_POST['Email'];
    $Bank = $_POST['Bank'];
    $Time = $_POST['Time'];
    $Money = $_POST['Money'];
    $Image = $_POST['Image'];

    /*mysqli_query($connect,"INSERT INTO payment_db (Name,Address,Tel,Email,Bank,Time,Money,Image) 
                           VALUES('$Name','$Address','$Tel','$Email','$Bank','$Time','$Money', '$Image')");
    
    if (mysqli_affected_rows($connect) > 0) {
        echo '<div class="txt"><a>Payment Success!!!</a>';
        echo '<a href="index.php?action=empty" id="btnBack">Back to Homepage</a>';
        
    }else {
        echo 'Payment failed';
        echo mysqli_connect_error();
    }*/
    
?>
<div class="txt"><a>Payment Success!!!</a>
<a href="index.php?action=empty" id="btnBack">Back to Homepage</a></div>

</body>