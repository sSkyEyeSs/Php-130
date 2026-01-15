<?php
/* ================= db_connect_pdo.php (ฝังในไฟล์เดียว) ================= */
$host = "localhost";
$db   = "index"; // ชื่อฐานข้อมูล
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("เชื่อมต่อฐานข้อมูลไม่สำเร็จ: " . $e->getMessage());
}

/* ================= เพิ่ม / แก้ไข ================= */
if (isset($_POST['action']) && $_POST['action'] === 'save') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $sex = $_POST['sex'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];

    if ($id == "") {
        $sql = "INSERT INTO users (name,sex,phone,email,birthday) VALUES (?,?,?,?,?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name,$sex,$phone,$email,$birthday]);
    } else {
        $sql = "UPDATE users SET name=?, sex=?, phone=?, email=?, birthday=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name,$sex,$phone,$email,$birthday,$id]);
    }
    exit;
}

/* ================= ลบ (Ajax) ================= */
if (isset($_POST['action']) && $_POST['action'] === 'delete') {
    $id = $_POST['id'];
    $stmt = $pdo->prepare("DELETE FROM users WHERE id=?");
    $stmt->execute([$id]);
    exit;
}

/* ================= ดึงข้อมูล ================= */
$users = $pdo->query("SELECT * FROM users ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>CRUD PDO + Bootstrap</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body class="container mt-4">

<h3>จัดการข้อมูลผู้ใช้</h3>
<button class="btn btn-primary mb-3" onclick="addUser()">➕ เพิ่มข้อมูล</button>

<table class="table table-bordered">
<thead class="table-dark">
<tr>
  <th>ID</th><th>ชื่อ</th><th>เพศ</th><th>โทร</th><th>Email</th><th>วันเกิด</th><th>จัดการ</th>
</tr>
</thead>
<tbody>
<?php foreach ($users as $u): ?>
<tr>
  <td><?= $u['id'] ?></td>
  <td><?= htmlspecialchars($u['name']) ?></td>
  <td><?= $u['sex'] ?></td>
  <td><?= $u['phone'] ?></td>
  <td><?= $u['email'] ?></td>
  <td><?= $u['birthday'] ?></td>
  <td>
    <button class="btn btn-warning btn-sm" onclick='editUser(<?= json_encode($u) ?>)'>แก้ไข</button>
    <button class="btn btn-danger btn-sm" onclick="deleteUser(<?= $u['id'] ?>)">ลบ</button>
  </td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<!-- ================= Modal ================= -->
<div class="modal fade" id="userModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">ข้อมูลผู้ใช้</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="id">
        <label>ชื่อ</label>
        <input type="text" id="name" class="form-control mb-2">

        <label>เพศ</label><br>
        <input type="radio" name="sex" value="ชาย"> ชาย
        <input type="radio" name="sex" value="หญิง"> หญิง

        <label class="mt-2">โทร</label>
        <input type="text" id="phone" class="form-control mb-2">

        <label>Email</label>
        <input type="email" id="email" class="form-control mb-2">

        <label>วันเกิด</label>
        <input type="date" id="birthday" class="form-control">
      </div>
      <div class="modal-footer">
        <button class="btn btn-success" onclick="saveUser()">บันทึก</button>
        <button class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
      </div>
    </div>
  </div>
</div>

<script>
let modal = new bootstrap.Modal(document.getElementById('userModal'));

function addUser(){
  $('#id').val('');
  $('input').val('');
  modal.show();
}

function editUser(u){
  $('#id').val(u.id);
  $('#name').val(u.name);
  $('input[name=sex][value="'+u.sex+'"]').prop('checked',true);
  $('#phone').val(u.phone);
  $('#email').val(u.email);
  $('#birthday').val(u.birthday);
  modal.show();
}

function saveUser(){
  $.post('',{
    action:'save',
    id:$('#id').val(),
    name:$('#name').val(),
    sex:$('input[name=sex]:checked').val(),
    phone:$('#phone').val(),
    email:$('#email').val(),
    birthday:$('#birthday').val()
  },()=>location.reload());
}

function deleteUser(id){
  if(confirm('ยืนยันการลบข้อมูล?')){
    $.post('',{action:'delete',id:id},()=>location.reload());
  }
}
</script>

</body>
</html>
