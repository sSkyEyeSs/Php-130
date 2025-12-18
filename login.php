<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>

<h2>เข้าสู่ระบบ</h2>

<form action="check_login.php" method="post">
    <label>ชื่อผู้ใช้ :</label><br>
    <input type="text" name="username" required><br><br>

    <label>รหัสผ่าน :</label><br>
    <input type="password" name="password" required><br><br>

    <button type="submit">เข้าสู่ระบบ</button>
</form>

</body>
</html>
