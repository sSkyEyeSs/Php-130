<?php
session_start();

// เช็คว่ามี session หรือไม่
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
</head>
<body>

<h2>หน้า Home</h2>

<p>ชื่อผู้ใช้: <?php echo $_SESSION['username']; ?></p>
<p>สิทธิ์: <?php echo $_SESSION['role']; ?></p>

<a href="Showsession.php">ดูข้อมูล Session</a><br>
<a href="logout.php">ออกจากระบบ</a>

</body>
</html>
