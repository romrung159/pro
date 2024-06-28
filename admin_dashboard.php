<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>ระบบครุภัณฑ์สำนักงาน QR CODE</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.12.0/dist/sweetalert2.all.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
<?php
session_start();
include 'config.php'; 

// ตรวจสอบว่าผู้ใช้ล็อกอินหรือไม่
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: index.php");
    exit();
}

// เนื้อหาของหน้า admin_dashboard.php
echo "ยินดีต้อนรับผู้ดูแลระบบ!";
echo "<br><a href='add_equipment.php'>เพิ่มครุภัณฑ์</a>";
echo "<br><a href='view_equipment.php'>ดูครุภัณฑ์</a>";
echo "<br><a href='logout.php' id='logoutLink'>ออกจากระบบ</a>";

?>
<script>
document.getElementById('logoutLink').addEventListener('click', function(event) {
    event.preventDefault();

    Swal.fire({
        icon: 'info',
        title: 'ออกจากระบบ',
        text: 'คุณต้องการที่จะออกจากระบบหรือไม่?',
        showCancelButton: true,
        confirmButtonText: 'ใช่',
        cancelButtonText: 'ไม่',
    }).then((result) => {
        if (result.isConfirmed) {
            // ทำการ redirect หลังจาก confirm ให้ลองออกจากระบบ
            window.location.href = 'index.php';
        }
    });
});
</script>
</body>
</html>
