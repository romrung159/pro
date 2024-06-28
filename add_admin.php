<?php
include 'config.php'; // เชื่อมต่อฐานข้อมูล

$username = "admin";
$password = "1234";
$hashed_password = password_hash($password, PASSWORD_DEFAULT); // เข้ารหัสรหัสผ่าน

$sql = "INSERT INTO admins (username, password) VALUES ('$username', '$hashed_password')";

if ($conn->query($sql) === TRUE) {
    echo "เพิ่มผู้ดูแลระบบเรียบร้อยแล้ว";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
