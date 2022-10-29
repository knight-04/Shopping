<?php
    $connect = mysqli_connect('localhost','thyt', '2543', 'payment');
    if (mysqli_connect_error()){
        echo 'Failed to connect';
    }
?>
