<?php
session_start();

// ยกเลิก session ทั้งหมด
$_SESSION = array();
session_destroy();

// Redirect ไปยังหน้า login
header("Location: index.php");
exit();
?>
