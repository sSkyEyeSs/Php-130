<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome POST</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #115176ff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .box {
            background: #ff0000ff;
            padding: 30px 40px;
            border-radius: 12px;
            width: 360px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #a92020ff;
        }
        .info {
            font-size: 16px;
            color: #db1f1fff;
            margin: 10px 0;
            padding: 10px;
            background: #376278ff;
            border-radius: 8px;
            border: 1px solid #000000ff;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Welcome!</h2>

    <div class="info">
        <strong>Name:</strong> 
        <?php echo htmlspecialchars($_POST["name"]); ?>
    </div>

    <div class="info">
        <strong>Email:</strong> 
        <?php echo htmlspecialchars($_POST["email"]); ?>
    </div>
</div>

</body>
</html>
