<meta charset="UTF-8">
<meta name="viewport" content="width=1024, initial-scale=1.0">
<title>PHP Built-in Function ฟังก์ชันที่มีพร้อมใช้ใน php</title>
</head>
<body>

<h1>PHP Built-in Function ฟังก์ชันที่มีพร้อมใช้ใน php</h1>
<h2>ทดสอบการใช้ function date()</h2>

<?php
    echo "วันนี้วันที่ " . date("d/m/Y") . "<br>";
    echo "เวลาขณะนี้คือ " . date("H:i:s") . "<br>";
    echo "วันนี้เป็นวัน " . date("l");
?>

<h2>ทดสอบการใช้ function date_diff</h2>
<?php
    $date1 = date_create("2000-01-01");
    $date2 = date_create("2024-06-15");
    $diff  = date_diff($date1, $date2);

    echo "จำนวนวันระหว่างวันที่ 1 มกราคม 2000 ถึง 15 มิถุนายน 2024 คือ "
         . $diff->days . " วัน<br>";

    echo "หรือเท่ากับ "
         . $diff->y . " ปี, "
         . $diff->m . " เดือน, "
         . $diff->d . " วัน<br>";
?>
<h2>ทดสอบการใช้ Math functions</h2>
<?php
    $num1 = 10.3;
    $num2 = 15.7;
    $pi   = 3.14159;

    echo "ค่าปัดเศษของ \$num1 คือ = " . ceil($num1) . "<br>";
    echo "ค่าปัดเศษของ \$num2 คือ = " . floor($num2) . "<br>";
    echo "ค่าของ pi ปัดเป็นทศนิยม 2 ตำแหน่ง คือ = " . round($pi, 2) . "<br>";
    echo "ค่าของ pi คือ = " . pi() . "<br>";
    echo "ค่ารากที่ 2 ของ 49 คือ = " . sqrt(49) . "<br>";
    echo "ค่ากำลัง 5 ยกกำลัง 3 คือ = " . pow(5, 3) . "<br>";

    echo "สุ่มตัวเลข 1 ถึง 100 คือ = " . rand(1, 100) . "<br>";
    echo "สุ่มตัวเลข 50 ถึง 150 คือ = " . rand(50, 150) . "<br>";
    echo "ค่าสุ่ม คือ = " . rand() . "<br>";

    $arr = array(3, 5, 1, 8, 2);

    echo "ค่ามากใน Array คือ = " . max($arr) . "<br>";
    echo "ค่าน้อยใน Array คือ = " . min($arr) . "<br>";
?>
<h2>ทดสอบการใช้ String Function</h2>
<?php
    $str = "Hello PHP Function";

    echo "ความยาวของข้อความ \"$str\" คือ : " . strlen($str) . "<br>";
    echo "แปลงข้อความ \"$str\" เป็นตัวพิมพ์ใหญ่ คือ : " . strtoupper($str) . "<br>";
    echo "แปลงข้อความ \"$str\" เป็นตัวพิมพ์เล็ก คือ : " . strtolower($str) . "<br>";
    echo "ตัวอักษรตัวแรกเป็นตัวพิมพ์ใหญ่ คือ : " . ucfirst($str) . "<br>";
    echo "ทำตัวอักษรขึ้นต้นแต่ละคำเป็นพิมพ์ใหญ่ คือ : " . ucwords($str) . "<br><br>";
    $substr = "PHP";
    echo "ตำแหน่งของคำ \"$substr\" ในข้อความ \"$str\" คือ : " . strpos($str, $substr) . "<br><br>";
    $replace = str_replace("Function", "ฟังก์ชัน", $str);
    echo "ข้อความหลังแทนที่ : " . $replace . "<br><br>";
    $str2 = "   PHP Function with Spaces   ";
    echo "ก่อน trim: '$str2' <br>";
    echo "หลัง trim: '" . trim($str2) . "' <br>";
?>
<?php myFooter(" Nonthawat Nawiang "); ?>   <!-- เรียกใช้ function -->

</body>
</html>

<?php
function myFooter() {
    echo "<footer><hr>";
    echo "<p>PHP Built-in Function Example &copy; 2024</p>";
    echo "<p>สร้างโดย: Nonthawat Nawiang</p>";
    echo "</footer>";
}
?>

</body>
</html>