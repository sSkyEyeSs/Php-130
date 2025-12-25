<?php
if (isset($_POST['submit'])) {

    $fullname = $_POST['fullname'];
    $email    = $_POST['email'];
    $course   = $_POST['course'];
    $type     = $_POST['type'];

    // อาหาร (Checkbox)
    if (isset($_POST['food'])) {
        $food = implode(",", $_POST['food']);
    } else {
        $food = "ไม่ระบุ";
    }

    // ค่าลงทะเบียน (ตามรูป)
    if ($type == "Onsite") {
        $price = 1500;
    } else {
        $price = 800;
    }

    // บันทึกไฟล์
    $data = $fullname . "|" . $email . "|" . $course . "|" . $food . "|" . $type . "|" . $price . "\n";
    file_put_contents("register.txt", $data, FILE_APPEND);
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>ฟอร์มลงทะเบียนอบรม</title>
<style>
body {
    font-family: Tahoma;
    background:#f2f2f2;
}
.box {
    width: 420px;
    background:#fff;
    padding:20px;
    margin:30px auto;
    border-radius:8px;
}
h2 {
    text-align:center;
}
</style>
</head>
<body>

<div class="box">
<h2>ฟอร์มลงทะเบียนอบรม</h2>

<form method="post">
    ชื่อ-นามสกุล:<br>
    <input type="text" name="fullname" required><br><br>

    Email:<br>
    <input type="email" name="email" required><br><br>

    หัวข้ออบรม:<br>
    <select name="course">
        <option value="AI สำหรับงานสำนักงาน">AI สำหรับงานสำนักงาน</option>
        <option value="Excel สำหรับการทำงาน">Excel สำหรับการทำงาน</option>
        <option value="การเขียนเว็บด้วย PHP">การเขียนเว็บด้วย PHP</option>
    </select><br><br>

    อาหารที่ต้องการ:<br>
    <input type="checkbox" name="food[]" value="ปกติ"> ปกติ
    <input type="checkbox" name="food[]" value="มังสวิรัติ"> มังสวิรัติ
    <input type="checkbox" name="food[]" value="ฮาลาล"> ฮาลาล
    <br><br>

    รูปแบบการเข้าร่วม:<br>
    <input type="radio" name="type" value="Onsite" required> Onsite
    <input type="radio" name="type" value="Online"> Online
    <br><br>

    <button type="submit" name="submit">ลงทะเบียน</button>
</form>
</div>

<?php
if (isset($_POST['submit'])) {
    echo "<div class='box'>";
    echo "<h3>ลงทะเบียนสำเร็จ</h3>";
    echo "ชื่อ: $fullname <br>";
    echo "อีเมล: $email <br>";
    echo "หัวข้ออบรม: $course <br>";
    echo "อาหาร: $food <br>";
    echo "รูปแบบ: $type <br>";
    echo "ค่าลงทะเบียน: " . number_format($price,2) . " บาท";
    echo "</div>";
}
?>

<?php
if (file_exists("register.txt")) {
    echo "<div class='box'>";
    echo "<h3>รายชื่อผู้ลงทะเบียนทั้งหมด</h3>";

    $lines = file("register.txt");
    echo "<table border='1' cellpadding='5'>";
    echo "<tr>
            <th>ชื่อ</th>
            <th>Email</th>
            <th>หัวข้อ</th>
            <th>อาหาร</th>
            <th>รูปแบบ</th>
            <th>ค่าลงทะเบียน</th>
          </tr>";

    foreach ($lines as $line) {
        list($n,$e,$c,$f,$t,$p) = explode("|", trim($line));
        echo "<tr>
                <td>$n</td>
                <td>$e</td>
                <td>$c</td>
                <td>$f</td>
                <td>$t</td>
                <td>" . number_format($p,2) . "</td>
              </tr>";
    }
    echo "</table>";
    echo "</div>";
}
?>

</body>
</html>
