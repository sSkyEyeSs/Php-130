<?php
include 'db_connect.php';

/* ================== ลบ (Soft Delete) ================== */
if (isset($_POST['confirm_delete'])) {
    $id = $_POST['delete_id'];
    $conn->query("UPDATE users SET deleted_at = NOW() WHERE id=$id");
    header("Location: index.php");
    exit;
}

/* ================== เพิ่ม / แก้ไข ================== */
if (isset($_POST['save'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $sex = $_POST['sex'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];

    if ($id == "") {
        $conn->query("INSERT INTO users (name,sex,phone,email,birthday)
                      VALUES ('$name','$sex','$phone','$email','$birthday')");
    } else {
        $conn->query("UPDATE users SET
                        name='$name',
                        sex='$sex',
                        phone='$phone',
                        email='$email',
                        birthday='$birthday'
                      WHERE id=$id");
    }
    header("Location: index.php");
    exit;
}

/* ================== ดึงข้อมูลแก้ไข ================== */
$data = ['id'=>'','name'=>'','sex'=>'','phone'=>'','email'=>'','birthday'=>''];
$edit = false;

if (isset($_GET['edit'])) {
    $edit = true;
    $id = $_GET['edit'];
    $res = $conn->query("SELECT * FROM users WHERE id=$id");
    if ($res && $res->num_rows > 0) {
        $data = $res->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>จัดการข้อมูลผู้ใช้</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="container mt-4">

<h3>จัดการข้อมูลผู้ใช้</h3>

<!-- ปุ่มเพิ่มข้อมูล -->
<button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#userModal">
➕ เพิ่มข้อมูล
</button>

<!-- ✅ ปุ่มถังขยะ (เพิ่มให้แล้ว) -->
<a href="trash.php" class="btn btn-secondary mb-3 ms-2">
🗑️ ถังขยะ
</a>

<!-- ================= MODAL เพิ่ม / แก้ไข ================= -->
<div class="modal fade" id="userModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="post">
      <div class="modal-content">

        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title"><?= $edit ? "แก้ไขข้อมูล" : "เพิ่มข้อมูล" ?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="id" value="<?= $data['id'] ?>">

          <label class="form-label">ชื่อ</label>
          <input type="text" name="name" class="form-control mb-2" value="<?= $data['name'] ?>" required>

          <label class="form-label">เพศ</label>
          <div class="mb-2">
            <input type="radio" name="sex" value="ชาย" <?= $data['sex']=="ชาย"?"checked":"" ?> required> ชาย
            <input type="radio" name="sex" value="หญิง" <?= $data['sex']=="หญิง"?"checked":"" ?>> หญิง
          </div>

          <label class="form-label">โทรศัพท์</label>
          <input type="text" name="phone" class="form-control mb-2" value="<?= $data['phone'] ?>">

          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control mb-2" value="<?= $data['email'] ?>">

          <label class="form-label">วันเกิด</label>
          <input type="date" name="birthday" class="form-control" value="<?= $data['birthday'] ?>">
        </div>

        <div class="modal-footer">
          <button type="submit" name="save" class="btn btn-success">💾 บันทึก</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
        </div>

      </div>
    </form>
  </div>
</div>

<?php if ($edit): ?>
<script>
new bootstrap.Modal(document.getElementById('userModal')).show();
</script>
<?php endif; ?>

<hr>

<h4>รายการข้อมูล</h4>

<table class="table table-bordered">
<thead class="table-dark">
<tr>
  <th>ID</th>
  <th>ชื่อ</th>
  <th>เพศ</th>
  <th>โทร</th>
  <th>Email</th>
  <th>วันเกิด</th>
  <th>จัดการ</th>
</tr>
</thead>

<tbody>
<?php
$result = $conn->query("SELECT * FROM users WHERE deleted_at IS NULL");
while ($row = $result->fetch_assoc()):
?>
<tr>
  <td><?= $row['id'] ?></td>
  <td><?= $row['name'] ?></td>
  <td><?= $row['sex'] ?></td>
  <td><?= $row['phone'] ?></td>
  <td><?= $row['email'] ?></td>
  <td><?= $row['birthday'] ?></td>
  <td>
    <a href="?edit=<?= $row['id'] ?>" class="btn btn-warning btn-sm">แก้ไข</a>
    <button class="btn btn-danger btn-sm"
      data-bs-toggle="modal"
      data-bs-target="#deleteModal"
      data-id="<?= $row['id'] ?>"
      data-name="<?= $row['name'] ?>"
      data-email="<?= $row['email'] ?>">
      ลบ
    </button>
  </td>
</tr>
<?php endwhile; ?>
</tbody>
</table>

<!-- ================= MODAL ยืนยันการลบ ================= -->
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="post">
      <div class="modal-content">

        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">⚠️ ยืนยันการลบ</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="delete_id" id="delete_id">
          <p><b>ชื่อ :</b> <span id="delete_name"></span></p>
          <p><b>Email :</b> <span id="delete_email"></span></p>

          <div class="alert alert-warning">
            ข้อมูลจะถูกย้ายไปถังขยะ<br>
            สามารถกู้คืนหรือ ลบถาวรได้
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" name="confirm_delete" class="btn btn-danger">🗑️ ยืนยันลบ</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
        </div>

      </div>
    </form>
  </div>
</div>

<script>
const deleteModal = document.getElementById('deleteModal');
deleteModal.addEventListener('show.bs.modal', function (event) {
  const button = event.relatedTarget;
  document.getElementById('delete_id').value = button.dataset.id;
  document.getElementById('delete_name').innerText = button.dataset.name;
  document.getElementById('delete_email').innerText = button.dataset.email;
});
</script>

</body>
</html>
