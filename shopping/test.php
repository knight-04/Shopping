<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>แจ้งชำระเงิน EURO SHOP</title>
</head>
<body style="background-color: #FFE4E3;">
    <style>
        .textbox {
            border: 3px inset #FFA5A5;
            outline:0;
            height:25px;
            width: 275px;
        }

        .button {
            background-color: #FFFFFF;
            border: 28px;
            color: black;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 20px;
            margin: 4px 2px;
            cursor: pointer;
        }
        .button4 {
            border-radius: 12px;
            border: 2px solid #FF69B4;
        }
    </style>

    <h1 align="center">แจ้งชำระเงิน__ @ EURO SHOP</h1>
    <hr color=#FF69B4 size="6">
    <form action="process.php" method="post">
        <h4 align="center"><br/><label>-- ชื่อ&สกุล --<br></label>
        <input class="textbox" type="text" name="Name"><br/>
        
        <br/><br/><label>-- ที่อยู่ --<br></label>
        <input class="textbox" type="text" name="Address"><br/>
        
        <br/><br/><label>-- เบอร์โทร --<br></label>
        <input class="textbox" type="text" name="Tel"><br/>
        
        <br/><br/><label>-- Email --<br></label>
        <input class="textbox" type="text" name="Email"><br/>

        <br/><br/><label>-- ธนาคารที่โอนเงิน --<br></label>
        <input class="textbox" type="text" name="Bank"><br/>

        <br/><br/><label>-- เวลาที่โอนเงิน --<br></label>
        <input class="textbox" type="text" name="Time"><br/>
        
        <br/><br/><label>-- จำนวนเงินที่โอน --<br></label>
        <input class="textbox" type="text" name="Money"><br/></h4>
        
        <h4 align="center"><input type="submit" class="button button4" value="ยืนยัน"></h4>
    </form>
    
</body>
</html>