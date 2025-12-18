<?php
session_start();

// รับค่าจากฟอร์ม
$username = $_POST['username'];
$password = $_POST['password'];

// กำหนด user & pass ตัวอย่าง
if ($username == "student01" && $password == "1234") {

    // สร้าง session
    $_SESSION['username'] = $username;
    $_SESSION['role'] = "admin";

    // ไปหน้า home
    header("Location: home.php");
    exit();

} else {
    echo "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
    echo "<br><a href='login.php'>กลับหน้า Login</a>";
}
?>
