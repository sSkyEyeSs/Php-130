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

    echo "เข้าสู่ระบบสำเร็จ <br>";
    echo "ยินดีต้อนรับ " . $_SESSION['username'];

} else {
    echo "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
}
?>