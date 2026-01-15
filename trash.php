<?php
include 'db_connect.php';

/* ===== กู้คืนข้อมูล ===== */
if (isset($_POST['restore'])) {
    $id = $_POST['id'];
    $conn->query("UPDATE users SET deleted_at = NULL WHERE id=$id");
    header("Location: trash.php");
    exit;
}

/* ===== ลบถาวร ===== */
if (isset($_POST['delete_permanent'])) {
    $id = $_POST['id'];
    $conn->query("DELETE FROM users WHERE id=$id");
    header("Location: trash.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>ถังขยะ</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="container mt-4">

<h3>🗑️ ถังขยะข้อมูลผู้ใช้</h3>

<a href="index.php" class="btn btn-primary mb-3">
⬅️ กลับหน้าหลัก
</a>

<table class="table table-bordered">
<thead class="table-dark">
<tr>
  <th>ID</th>
  <th>ชื่อ</th>
  <th>Email</th>
  <th>วันลบ</th>
  <th>จัดการ</th>
</tr>
</thead>

<tbody>
<?php
$result = $conn->query("SELECT * FROM users WHERE deleted_at IS NOT NULL");
if ($result && $result->num_rows > 0):
while ($row = $result->fetch_assoc()):
?>
<tr>
  <td><?= $row['id'] ?></td>
  <td><?= $row['name'] ?></td>
  <td><?= $row['email'] ?></td>
  <td><?= $row['deleted_at'] ?></td>
  <td>

    <!-- กู้คืน -->
    <form method="post" class="d-inline">
      <input type="hidden" name="id" value="<?= $row['id'] ?>">
      <button type="submit" name="restore" class="btn btn-success btn-sm">
        ♻️ กู้คืน
      </button>
    </form>

    <!-- ลบถาวร -->
    <button class="btn btn-danger btn-sm"
      data-bs-toggle="modal"
      data-bs-target="#deleteModal"
      data-id="<?= $row['id'] ?>"
      data-name="<?= $row['name'] ?>">
      ❌ ลบถาวร
    </button>

  </td>
</tr>
<?php endwhile; else: ?>
<tr>
  <td colspan="5" class="text-center text-muted">ไม่มีข้อมูลในถังขยะ</td>
</tr>
<?php endif; ?>
</tbody>
</table>

<!-- ===== Modal ยืนยันลบถาวร ===== -->
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog">
    <form method="post">
      <div class="modal-content">

        <div class="modal-header bg-danger text-white">
          <h5 class="modal-title">⚠️ ยืนยันการลบถาวร</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="id" id="delete_id">
          <p>คุณต้องการลบข้อมูลของ <b id="delete_name"></b> แบบถาวรหรือไม่?</p>
          <div class="alert alert-danger">
            ⚠️ การลบถาวรไม่สามารถกู้คืนได้
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" name="delete_permanent" class="btn btn-danger">
            ลบถาวร
          </button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
            ยกเลิก
          </button>
        </div>

      </div>
    </form>
  </div>
</div>

<script>
const deleteModal = document.getElementById('deleteModal');
deleteModal.addEventListener('show.bs.modal', function (event) {
  const button = event.relatedTarget;
  document.getElementById('delete_id').value = button.getAttribute('data-id');
  document.getElementById('delete_name').innerText = button.getAttribute('data-name');
});
</script>

</body>
</html>
