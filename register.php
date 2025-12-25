<?php
if (isset($_POST['submit'])) {

    $fullname = $_POST['fullname'];
    $email    = $_POST['email'];
    $course   = $_POST['course'];
    $type     = $_POST['type'];

    if (isset($_POST['food'])) {
        $food = implode(",", $_POST['food']);
    } else {
        $food = "ไม่ระบุ";
    }

    if ($type == "Onsite") {
        $price = 1500;
    } else {
        $price = 800;
    }

    $data = $fullname."|".$email."|".$course."|".$food."|".$type."|".$price."\n";
    file_put_contents("register.txt", $data, FILE_APPEND);
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>ฟอร์มลงทะเบียนอบรม</title>

<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body{
    min-height:100vh;
    background: linear-gradient(135deg,#667eea,#764ba2);
}

.card{
    border-radius:18px;
}

.card-header{
    border-radius:18px 18px 0 0;
}

.btn-primary{
    background: linear-gradient(45deg,#4facfe,#00c6ff);
    border:none;
}

.btn-primary:hover{
    opacity:0.9;
}

.table thead{
    background: linear-gradient(45deg,#4facfe,#00c6ff);
    color:#fff;
}

.form-control, .form-select{
    border-radius:10px;
}
</style>
</head>

<body>

<div class="container py-5">
<div class="row justify-content-center">
<div class="col-md-6">

<!-- ฟอร์ม -->
<div class="card shadow-lg mb-4">
<div class="card-header bg-transparent text-white text-center">
    <h4 class="fw-bold">ฟอร์มลงทะเบียนอบรม</h4>
</div>

<div class="card-body bg-white">

<form method="post">

<div class="mb-3">
    <label class="form-label fw-semibold">ชื่อ-นามสกุล</label>
    <input type="text" name="fullname" class="form-control" required>
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">Email</label>
    <input type="email" name="email" class="form-control" required>
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">หัวข้ออบรม</label>
    <select name="course" class="form-select">
        <option value="AI สำหรับงานสำนักงาน">AI สำหรับงานสำนักงาน</option>
        <option value="Excel สำหรับการทำงาน">Excel สำหรับการทำงาน</option>
        <option value="การเขียนเว็บด้วย PHP">การเขียนเว็บด้วย PHP</option>
    </select>
</div>

<div class="mb-3">
    <label class="form-label fw-semibold">อาหารที่ต้องการ</label><br>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" name="food[]" value="ปกติ">
        <label class="form-check-label">ปกติ</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" name="food[]" value="มังสวิรัติ">
        <label class="form-check-label">มังสวิรัติ</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" name="food[]" value="ฮาลาล">
        <label class="form-check-label">ฮาลาล</label>
    </div>
</div>

<div class="mb-4">
    <label class="form-label fw-semibold">รูปแบบการเข้าร่วม</label><br>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="type" value="Onsite" required>
        <label class="form-check-label">Onsite</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="type" value="Online">
        <label class="form-check-label">Online</label>
    </div>
</div>

<div class="d-grid">
    <button type="submit" name="submit" class="btn btn-primary btn-lg">
        ลงทะเบียน
    </button>
</div>

</form>
</div>
</div>

<!-- แสดงผล -->
<?php if (isset($_POST['submit'])) { ?>
<div class="alert alert-success shadow-sm">
    <h5 class="fw-bold">ลงทะเบียนสำเร็จ</h5>
    ชื่อ: <?= $fullname ?><br>
    Email: <?= $email ?><br>
    หัวข้อ: <?= $course ?><br>
    อาหาร: <?= $food ?><br>
    รูปแบบ: <?= $type ?><br>
    ค่าลงทะเบียน: <strong><?= number_format($price,2) ?> บาท</strong>
</div>
<?php } ?>

<!-- ตาราง -->
<?php
if (file_exists("register.txt")) {
    echo "<div class='card shadow-lg mt-4'>";
    echo "<div class='card-header bg-dark text-white fw-bold'>รายชื่อผู้ลงทะเบียนทั้งหมด</div>";
    echo "<div class='card-body p-0'>";
    echo "<table class='table table-bordered table-striped m-0'>";
    echo "<thead>
            <tr>
                <th>ชื่อ</th>
                <th>Email</th>
                <th>หัวข้อ</th>
                <th>อาหาร</th>
                <th>รูปแบบ</th>
                <th>ราคา</th>
            </tr>
          </thead><tbody>";

    $lines = file("register.txt");
    foreach ($lines as $line) {
        if (trim($line) == "") continue;
        list($n,$e,$c,$f,$t,$p) = explode("|", trim($line));
        echo "<tr>
                <td>$n</td>
                <td>$e</td>
                <td>$c</td>
                <td>$f</td>
                <td>$t</td>
                <td>".number_format($p,2)."</td>
              </tr>";
    }
    echo "</tbody></table></div></div>";
}
?>

</div>
</div>
</div>

</body>
</html>
