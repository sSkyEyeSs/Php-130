<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "workshop_api";

// สร้างการเชื่อมต่อ
$conn = new mysqli($host, $user, $pass, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die(json_encode([
        "status" => "error",
        "message" => "Database connection failed: " . $conn->connect_error
    ]));
}
?>
